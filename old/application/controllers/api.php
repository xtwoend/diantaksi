<?php

class Api_Controller extends Controller {

	public $restful = true;

	public function get_index()
	{	
		echo Request::ip();
		
	}

	public function get_login()
	{	
		$callback = Input::get('callback');

		$credentials = array('username' => Input::get('username'), 'password' => Input::get('password'));
    	  if (Auth::attempt( $credentials ))
		    { 
	          	//set last login
	          	$user = Auth::user();
	          	$user->last_login = new \DateTime;
	          	$user->save();
         	
	          	$returndata = array('login' => true , 'data'=> Auth::user()->to_array() );
		   }else{
          		$returndata = array('login' => false, 'data'=> 'error' );
        }
		return Response::jsonp($callback, $returndata );
	}

	public function get_schedule()
	{	
		$callback = Input::get('callback');
		$date = Input::get('date', date('Y-m-d'));
		$pool = Input::get('pool');

	    $timestamp = strtotime($date);
	    //list armada on schedule
	      $arrayschedule = array();
	      $schedule = Schedule::where('month', '=', date('n', $timestamp) )
	                  ->where('year', '=', date('Y', $timestamp))
	                  ->get(array('id','fleet_id'));

	      foreach ($schedule as $sc) {
	        $arrayschedule[] = $sc->id; 
	      }

	      $fleets = array();
	      if(is_array($arrayschedule) && !empty($arrayschedule)){
	        $fleets = Scheduledate::join('schedules','schedules.id','=','schedule_dates.schedule_id')
	                  ->join('fleets', 'fleets.id', '=', 'schedules.fleet_id' )
	                  ->join('ksos', 'ksos.fleet_id', '=', 'schedules.fleet_id' )
	                  ->where_in('schedule_dates.schedule_id', $arrayschedule )
	                  ->where('schedules.pool_id', '=', $pool )
	                  ->where('schedule_dates.date', '=', date('j', $timestamp))
	                  ->where('schedules.month','=',date('n', $timestamp ))
	                  //->where('schedule_dates.fg_check','=',0)
	                  ->where('ksos.actived','=',1)
	                  ->order_by('fleets.taxi_number','asc')
	                  ->get(array('schedule_dates.id as id','schedule_dates.driver_id','schedules.fleet_id','fleets.taxi_number','schedule_dates.fg_check as out'));
	                  //->get(array('fleets.taxi_number','schedule_dates.id as id', 'schedule_dates.fg_check as out'));
	      }

	      $fleetdatas = array_map(function($object) {
	             return $object->to_array();
	      }, $fleets);
	        
		return Response::jsonp($callback, $fleetdatas );
	}

	public function get_checkout()
	{
		$callback = Input::get('callback');
		$id = Input::get('schedule_id');
		$fleets = Scheduledate::join('schedules','schedules.id','=','schedule_dates.schedule_id')
								->join('fleets', 'fleets.id', '=', 'schedules.fleet_id' )
								->join('drivers', 'drivers.id', '=', 'schedule_dates.driver_id')
								->where('schedule_dates.id','=',$id)
								->first();

		$fleetdatas = $fleets->to_array();					

		return Response::jsonp($callback, $fleetdatas );					
	}

	public function get_stddocs()
	{
		$callback = Input::get('callback');
		$datas = Stddoc::all();

		$data = array_map(function($object) {
	             return $object->to_array();
	    }, $datas);

	    return Response::jsonp($callback, $data);	    
	}
	public function get_stdneats()
	{
		$callback = Input::get('callback');
		$datas = Stdneat::all();

		$data = array_map(function($object) {
	             return $object->to_array();
	    }, $datas);
	    
	    return Response::jsonp($callback, $data);
	}
	public function get_stdequips()
	{
		$callback = Input::get('callback');
		$datas = Stdequip::all();

		$data = array_map(function($object) {
	             return $object->to_array();
	    }, $datas);
	    
	    return Response::jsonp($callback, $data);
	}

	public function get_test()
	{
		$callback = Input::get('callback');
		$datas = Stdequip::all();

		$data = array_map(function($object) {
	             return $object->to_array();
	    }, $datas);
	    
	    return Response::jsonp($callback, $data);
	}

	public function get_setoranharian()
	{	
		$select = array('nip','name','taxi_number','checkin_time','kode','setoran_wajib','tabungan_sparepart','denda'); 
		$callback = Input::get('callback','JSON_CALLBACK');
		$date = Input::get('date', date('Y-m-d'));
		$shift_id = Input::get('shift_id', 1);
		$pool_id = Input::get('pool_id', 1 );
		$data = DB::table('financial_report_daily')
				->where('shift_id','=',$shift_id)
				->where('operasi_time','=',$date)
				->where_pool_id($pool_id)
				->get($select);
		
		return Response::jsonp($callback, $data);
	}


	public function post_query()
	{	
		$date = Input::get('date');
		$pool_id = Input::get('pool_id');
		$shift = Input::get('shift');
		
		$sql = DB::query("select 
                      cin.id AS id,
                      cin.kso_id AS kso_id,
                      cin.fleet_id AS fleet_id,
                      cin.shift_id AS shift_id,
                      cin.operasi_time AS operasi_time,
                      cin.operasi_status_id AS operasi_status_id,
                      cf.checkin_id AS checkin_id,
                      sp.pemakaian_part,
                      sum(if((cf.financial_type_id = 2),cf.amount,0)) AS tabungan_sparepart,
                      sum(if((cf.financial_type_id = 5),cf.amount,0)) AS cicilan_sparepart,
                      sum(if((cf.financial_type_id = 6),cf.amount,0)) AS cicilan_ks,
                      sum(if((cf.financial_type_id = 9),cf.amount,0)) AS cicilan_dp_kso,
                      sum(if((cf.financial_type_id = 10),cf.amount,0)) AS cicilan_hutang_lama,
                      sum(if((cf.financial_type_id = 11),cf.amount,0)) AS ks,
                      sum(if((cf.financial_type_id = 13),cf.amount,0)) AS hutang_dp_sparepart
                      from checkins cin 
                      left join checkin_financials cf on((cin.id = cf.checkin_id))
                      left join (
                                        select 
                                          wo.id,wo.kso_id,wo.inserted_date_set,
                                          sum((part.qty * part.price)) as pemakaian_part
                                          from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id )
                                          where wo.status = 3 and part.telah_dikeluarkan = 1 and wo.beban = 0
                                          and wo.kso_id in (select k.id  from ksos k where k.pool_id = ? and k.actived = 1)
                                          and DATE_FORMAT(wo.inserted_date_set,'%Y-%m-%d') <= ? 
                                          group by wo.kso_id 
                                      ) as sp ON ( sp.kso_id = cin.kso_id)
                      where operasi_time <= ?
                      and cin.shift_id = ?
                      and cin.kso_id in (select k.id  from ksos k where k.pool_id = ? and k.actived = 1)
                      group by cin.kso_id",
            array(
              $pool_id, 
              $date,
              $date,
              $shift,
              $pool_id
            ));
    
    	return json_encode($sql);
	}
}