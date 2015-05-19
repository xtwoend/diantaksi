<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Diantaksi\Reports\ReportRange;

class DashboardController extends Controller
{
    /**
     * .
     *
     * @return
     */
    public function __construct()
    {
      $this->rangereport = new ReportRange;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));

        return view('dashboard', compact('date'));
    }

    /**
     * get data perbandingan pendapatan dengan ks.
     *
     * @return
     */
    public function persentasePendapatan(Request $request)
    {
        $date = $request->get('date', date('Y-m-d')); 

        $pendapatan = $this->rangereport->persentasePendapatan($date, Auth::user()->pool_id);

        $harussetor = $pendapatan->setoran_wajib  + $pendapatan->tabungan_sparepart;
        $ks = $pendapatan->ks; 

        $persen = ($harussetor - $ks) * 100 / $harussetor;
        $persenks = 100 - $persen;

        $data = [
                    [
                        'label' => 'Pendapatan',
                        'data' => $persen
                    ],
                    [
                        'label' => 'Ketekoran',
                        'data' => $persenks
                    ]
                ];
        return $data;
    }

    /**
     * change pool.
     *
     * @return
     */
    public function change($pool_id = null)
    {
    	if(is_null($pool_id)) 
    		return redirect('auth/logout');

    	$user = Auth::user();
    	$user->pool_id = $pool_id;
    	$user->save();

    	return redirect('home');
    }
}
