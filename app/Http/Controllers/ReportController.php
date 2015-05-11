<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Diantaksi\Eloquent\Checkin;
use App\Diantaksi\Eloquent\FleetModel;

use App\Diantaksi\Reports\ReportDaily;
use App\Diantaksi\Reports\ReportRange;

use App\Diantaksi\Eloquent\Kso;

class ReportController extends Controller
{	 
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
    public function __construct(Kso $ksos)
    {
      $this->dailyreport = new ReportDaily;
      $this->rangereport = new ReportRange;
      $this->ksos = $ksos;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function daily()
    {
        return view('reports.daily');
    }

    /**
     * json.
     *
     * @return
     */
    public function dailyjson(Request $request)
    {
    	return $this->dailyreport->dailyjson($request);
    }

    /**
     * sum loader.
     *
     * @return
     */
    public function dailysum(Request $request)
    { 
      return $this->dailyreport->dailysum($request);
    }

    /**
     * export to excel.
     *
     * @return
     */
    public function dailyexport(Request $request)
    {
        return $this->dailyreport->dailyexport($request);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function range()
    {
        return view('reports.range');
    }

    /**
     * json.
     *
     * @return
     */
    public function rangejson(Request $request)
    {
      return $this->rangereport->json($request);
    }

    /**
     * sum loader.
     *
     * @return
     */
    public function rangesum(Request $request)
    { 
      return $this->rangereport->sum($request);
    }

    /**
     * export to excel.
     *
     * @return
     */
    public function rangexport(Request $request)
    {
        return $this->rangereport->export($request);
    }


}
