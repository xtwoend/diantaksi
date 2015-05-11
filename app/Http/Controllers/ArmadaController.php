<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Diantaksi\Eloquent\Fleet;
use App\Diantaksi\Eloquent\Kso;
use Illuminate\Support\Facades\Auth;

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
     * .
     *
     * @return
     */
    public function __construct(Fleet $fleets, Kso $ksos)
    {
        $this->fleets = $fleets;
        $this->ksos = $ksos;
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
    public function index($id)
    {   
        $ksos = $this->ksos
                ->join('fleets', 'ksos.fleet_id','=', 'fleets.id')
                ->where('ksos.pool_id', Auth::user()->pool_id)
                ->where('ksos.actived', 1)
                ->orderBy('fleets.taxi_number')
                ->get(['ksos.*', 'fleets.taxi_number']);

        $kso = $this->ksos->find($id);
        $fleet = $kso->fleet;
        return view('armada.dashboard', compact('ksos', 'kso', 'fleet'));
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
                  ->leftJoin('checkin_financials', 'checkins.id', '=', 'checkin_financials.checkin_id')
                  ->where('checkins.kso_id', $id)
                  ->where('checkins.operasi_time', '<=', $last_date)
                  ->groupBy('checkins.kso_id')
                  ->first();
        
        $checkins = DB::table('checkins')
                  ->select(DB::raw('sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) AS ks'))
                  ->leftJoin('checkin_financials', 'checkins.id', '=', 'checkin_financials.checkin_id')
                  ->where('checkins.kso_id', $id)
                  ->whereBetween('checkins.operasi_time',[$last_date, date('Y-m-d')])
                  ->groupBy('operasi_time')
                  ->get();

        $data = [];
        $setks = $sumtotal->ks;        

        $i = 1;
        foreach ($checkins as $loadks) {
            $setks = $setks + $loadks->ks;
            $data[] = [$i, $setks];
            $i++;
        }

        return $data;
    }
}
