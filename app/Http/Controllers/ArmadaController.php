<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Diantaksi\Eloquent\Fleet;
use App\Diantaksi\Eloquent\Kso;
use Illuminate\Support\Facades\Auth;
use App\Diantaksi\Reports\ReportArmada;

class ArmadaController extends Controller
{   
    /**
     * [$fleets description]
     * @var [type]
     */
    protected $fleets;

    /**
     * [$ksos description]
     * @var [type]
     */
    protected $ksos;

    /**
     * [$reports description]
     * @var [type]
     */
    protected $reports;

    /**
     * .
     *
     * @return
     */
    public function __construct(Fleet $fleets, Kso $ksos)
    {
        $this->fleets = $fleets;
        $this->ksos = $ksos;
        $this->reports = new ReportArmada;
    }

    /**
     * laporan armada.
     *
     * @return
     */
    public function armada()
    {
        $ksos = $this->ksos
                ->join('fleets', 'ksos.fleet_id','=', 'fleets.id')
                ->where('ksos.pool_id', Auth::user()->pool_id)
                ->where('ksos.actived', 1)
                ->orderBy('fleets.taxi_number')
                ->get(['ksos.*', 'fleets.taxi_number']);

        return view('reports.armada', compact('ksos'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id, Request $request)
    {   
        $date = $request->get('date', date('Y-m-d'));

        $ksos = $this->ksos
                ->join('fleets', 'ksos.fleet_id','=', 'fleets.id')
                ->where('ksos.pool_id', Auth::user()->pool_id)
                ->where('ksos.actived', 1)
                ->orderBy('fleets.taxi_number')
                ->get(['ksos.*', 'fleets.taxi_number']);

        $total = DB::table('checkins')
                  ->select(DB::raw('sum(if((checkin_financials.financial_type_id = 1),checkin_financials.amount,0)) AS setoran_wajib,sum(if((checkin_financials.financial_type_id = 2),checkin_financials.amount,0)) AS tabungan_sparepart,sum(if((checkin_financials.financial_type_id = 3),checkin_financials.amount,0)) AS denda,sum(if((checkin_financials.financial_type_id = 4),checkin_financials.amount,0)) AS potongan,sum(if((checkin_financials.financial_type_id = 5),checkin_financials.amount,0)) AS cicilan_sparepart,sum(if((checkin_financials.financial_type_id = 6),checkin_financials.amount,0)) AS cicilan_ks,sum(if((checkin_financials.financial_type_id = 7),checkin_financials.amount,0)) AS biaya_cuci,sum(if((checkin_financials.financial_type_id = 8),checkin_financials.amount,0)) AS iuran_laka,sum(if((checkin_financials.financial_type_id = 9),checkin_financials.amount,0)) AS cicilan_dp_kso,sum(if((checkin_financials.financial_type_id = 10),checkin_financials.amount,0)) AS cicilan_hutang_lama,sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) AS ks,sum(if((checkin_financials.financial_type_id = 12),checkin_financials.amount,0)) AS cicilan_lain,sum(if((checkin_financials.financial_type_id = 13),checkin_financials.amount,0)) AS hutang_dp_sparepart,sum(if((checkin_financials.financial_type_id = 20),checkin_financials.amount,0)) AS setoran_cash,sum(if((checkin_financials.financial_type_id = 21),checkin_financials.amount,0)) AS tabungan,(sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) - sum(if((checkin_financials.financial_type_id = 6),checkin_financials.amount,0))) AS selisi_ks '))
                  ->addSelect(DB::raw('checkins.id, checkins.operasi_time , checkins.pool_id, checkins.shift_id'))
                  ->leftJoin('checkin_financials', 'checkins.id', '=', 'checkin_financials.checkin_id')
                  ->where('checkins.kso_id', $id)
                  ->where('checkins.operasi_time', '<=' , $date)
                  ->groupBy('checkins.kso_id')
                  ->first();

        $sparepart = DB::table('work_orders')
                    ->select(DB::raw('work_orders.id AS id,work_orders.kso_id AS kso_id,work_orders.wo_number AS wo_number,work_orders.fleet_id AS fleet_id,work_orders.driver_id AS driver_id,work_orders.pool_id AS pool_id,work_orders.km AS km,work_orders.complaint AS complaint,work_orders.information_complaint AS information_complaint,work_orders.status AS status,work_orders.beban AS beban,work_orders.mechanic_id AS mechanic_id,work_orders.mechanic AS mechanic,work_orders.dp_sparepart AS dp_sparepart,work_orders.user_id AS user_id,work_orders.inserted_date_set AS inserted_date_set,work_orders.finished_date_set AS finished_date_set,work_orders.fg_part_approved AS fg_part_approved,work_orders.user_approved AS user_approved,sum((wo_part_items.qty * wo_part_items.price)) AS pemakaian_part'))
                    ->leftJoin('wo_part_items', 'work_orders.id', '=', 'wo_part_items.wo_id')
                    ->where('work_orders.status', 3)
                    ->where('wo_part_items.telah_dikeluarkan', 1)
                    ->where('work_orders.beban', 0)
                    ->where('work_orders.kso_id', $id)
                    ->where('work_orders.finished_date_set', '<=' , $date)
                    ->groupBy('work_orders.kso_id')
                    ->first();
        
        $total_pemakaian_part = 0;
        if($sparepart)
        {
          $total_pemakaian_part = $sparepart->pemakaian_part;
        }

        $kso = $this->ksos->find($id);
        $fleet = $kso->fleet;
        return view('armada.dashboard', compact('ksos', 'kso', 'fleet', 'total', 'total_pemakaian_part', 'date'));
    }

    /**
     * hutang armada perhari.
     *
     * @return
     */
    public function hutang(Request $request)
    {
        $limit = $request->get('limit', 5);
        $id = $request->get('id');

        $last_date=date("Y-m-d",strtotime(' -'.$limit.' day'));
        
        $sumtotal = DB::table('checkins')
                  ->select(DB::raw('sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) AS ks'))
                  ->addSelect(DB::raw('checkins.id, checkins.operasi_time , checkins.pool_id, checkins.shift_id'))
                  ->leftJoin('checkin_financials', 'checkins.id', '=', 'checkin_financials.checkin_id')
                  ->where('checkins.kso_id', $id)
                  ->groupBy('checkins.kso_id')
                  ->first();
        
        $checkins = DB::table('checkins')
                  ->select(DB::raw('sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) AS ks'))
                  ->addSelect(DB::raw('checkins.id, checkins.operasi_time , checkins.pool_id, checkins.shift_id'))
                  ->leftJoin('checkin_financials', 'checkins.id', '=', 'checkin_financials.checkin_id')
                  ->where('checkins.kso_id', $id)
                  ->whereBetween('checkins.operasi_time',[$last_date, date('Y-m-d')])
                  ->groupBy('operasi_time')
                  ->orderBy('operasi_time', 'desc')
                  ->get();

        $data = [];
        $setks = $sumtotal->ks;        

        $i = 10;
        foreach ($checkins as $loadks) {
            $data[] = [$i, $setks];
            $setks = $setks - $loadks->ks;
            $i--;
        }

        return $data;
    }


    /**
     * report armada harian.
     *
     * @return
     */
    public function reportjson(Request $request)
    {
        return $this->reports->json($request);
    }

    /**
     * export to excel.
     *
     * @return
     */
    public function export(Request $request)
    {
        return $this->reports->export($request);
    }
}
