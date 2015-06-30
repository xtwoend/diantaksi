<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Diantaksi\Eloquent\Driver;
use App\Diantaksi\Eloquent\Checkin;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{     
    /**
     * [$checkins description]
     * @var [type]
     */
    protected $checkins;

    /**
     * [$drivers description]
     * @var [type]
     */
    protected $drivers;

    /**
    * [$user description]
    * @var [type]
    */
    protected $user;

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function __construct(Driver $drivers, Checkin $checkins)
    {
        $this->drivers = $drivers;
        $this->checkins = $checkins;
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function activity()
    {  
        $lastdate = \Carbon\Carbon::now()->subMonths(3);   
        

        $checkins = $this->checkins
                        ->with('driver')
                        ->select(\DB::raw("*, COUNT(*) as activity , 
                            MONTHNAME(operasi_time) as mountname,
                            MONTH(operasi_time) as mount")) 
                        ->where('pool_id', $this->user->pool_id)
                        ->where('operasi_status_id', 1)
                        ->where('operasi_time', '>=', $lastdate->format('Y-m-d'))
                        ->where(\DB::raw('YEAR(operasi_time)'), date('Y'))
                        ->groupBy('driver_id')
                        ->groupBy(\DB::raw('MONTH(operasi_time)'))
                        ->get();

        //dd($drivers);
        return view('drivers.activity', compact('checkins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
