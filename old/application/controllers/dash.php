<?php

class Dash_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{	
    $date = Input::get('date', false);	  
    $pool_id = Auth::user()->pool_id;

    if(!$date) $date = date('Y-m-d');
    $timestamp = strtotime($date);
   
    $this->data['month'] = Myfungsi::bulan(date('n',strtotime($date)));

    return View::make('themes.layouts.dashboard',$this->data);
	}

	// Login Staff
    public function get_login(){
    	return View::make('themes.layouts.login');
    }

    public function get_logout(){
      Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Logout', true);
          
    	Auth::logout();
		return Redirect::to('admin');
    }

    public function post_login(){
        $credentials = array('username' => Input::get('username'), 'password' => Input::get('password'));
    	  if (Auth::attempt( $credentials ))
		    { 
          Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Login', true);
          //set last login
          $user = Auth::user();
          $user->last_login = new \DateTime;
          $user->save();

		      return Redirect::to('admin/dashboard');
		    }else{
          return Redirect::to('admin/login');
        }
    }

    public function get_fleetsonnotprintspj()
    { 
      $date = Input::get('date', date('Y-m-d'));    
      $pool_id = Auth::user()->pool_id;
      $timestamp = strtotime($date);
      /*
      $fleets_on_not_printspj = Scheduledate::join('schedules','schedules.id','=','schedule_dates.schedule_id')
                  ->join('fleets', 'fleets.id', '=', 'schedules.fleet_id' )
                  //->join('ksos', 'ksos.fleet_id', '=', 'schedules.fleet_id' )
                  //->where_in('schedule_dates.schedule_id', $arrayschedule )
                  //->where('ksos.actived','=',1)
                  ->where('schedules.pool_id', '=', $pool_id )
                  ->where('schedule_dates.date', '=', date('j', $timestamp))
                  ->where('schedules.month','=',date('n', $timestamp ))
                  ->where('schedule_dates.fg_check','=',0)                  
                  ->order_by('fleets.taxi_number','asc')
                  ->get(array('schedule_dates.id as id','schedule_dates.driver_id','schedules.fleet_id','fleets.taxi_number'));
      */
      $arrayschedule = array();
      $schedule = Schedule::where('month', '=', date('n', $timestamp) )->where('year', '=', date('Y', $timestamp))->get(array('id','fleet_id'));
      foreach ($schedule as $sc) {
        $arrayschedule[] = $sc->id; 
      }
      $fleets_on_not_printspj = array();
      if(is_array($arrayschedule) && !empty($arrayschedule)){
        $fleets_on_not_printspj = Scheduledate::join('schedules','schedules.id','=','schedule_dates.schedule_id')
                                      ->join('fleets','fleets.id' ,'=' ,'schedules.fleet_id')
                                      ->where_in('schedule_dates.schedule_id', $arrayschedule )
                                      ->where('schedules.pool_id', '=', Auth::user()->pool_id )
                                      ->where('schedule_dates.date', '=', date('j', $timestamp))
                                      ->where('schedule_dates.fg_check','=',0) 
                                      ->order_by('fleets.taxi_number','asc')
                                      ->get(array('fleets.taxi_number','schedule_dates.id as id'));
      }
      $datas = array_map(function($object) {
             return $object->to_array();
        }, $fleets_on_not_printspj);

      return Response::json($datas);
    }

    public function get_fleetsoncheckout()
    { 
      $date = Input::get('date', date('Y-m-d'));
      $pool_id = Auth::user()->pool_id;
      $fleets_on_checkout = Checkout::join('fleets as f', 'f.id', '=', 'checkouts.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkouts.checkout_step_id','=',3)
                ->where('checkouts.operasi_status_id','=',1)
                ->where('checkouts.pool_id','=', $pool_id)
                ->order_by('f.taxi_number','asc')
                ->get(array('f.taxi_number','checkouts.id'));

      $datas = array_map(function($object) {
             return $object->to_array();
        }, $fleets_on_checkout);
      return Response::json($datas);
    }
    
    public function get_fleetsoncheckin()
    {
      $date = Input::get('date', date('Y-m-d'));
      $pool_id = Auth::user()->pool_id;
      $fleets_on_checkin = Checkout::join('fleets as f', 'f.id', '=', 'checkouts.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkouts.pool_id','=', $pool_id)
                ->where('checkouts.checkout_step_id', '=', 4)
                ->where('checkouts.operasi_status_id', '=', 1)
                ->order_by('f.taxi_number','asc')
                ->get(array('f.taxi_number','checkouts.id'));
      $datas = array_map(function($object) {
             return $object->to_array();
        }, $fleets_on_checkin);
      return Response::json($datas);
    }

    public function get_fleetsonnotopration()
    { 
      $date = Input::get('date', date('Y-m-d'));
      $pool_id = Auth::user()->pool_id;
      $fleets_on_not_opration = Checkin::join('fleets as f', 'f.id', '=', 'checkins.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkins.pool_id','=', $pool_id)
                ->where('checkins.operasi_status_id', '!=', 1)
                ->order_by('f.taxi_number','asc')
                ->get(array('f.taxi_number','checkins.id'));
      $datas = array_map(function($object) {
             return $object->to_array();
        }, $fleets_on_not_opration);
      return Response::json($datas);
    }

    public function get_fleetsonafterpay()
    { 
      $date = Input::get('date', date('Y-m-d'));
      $pool_id = Auth::user()->pool_id;
      $fleets_on_after_pay = Checkin::join('fleets as f', 'f.id', '=', 'checkins.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkins.pool_id','=', $pool_id)
                ->where('checkins.checkin_step_id', '=', 3)
                ->where('checkins.operasi_status_id', '=', 1)
                ->order_by('f.taxi_number','asc')
                ->get(array('f.taxi_number','checkins.id'));
      $datas = array_map(function($object) {
             return $object->to_array();
        }, $fleets_on_after_pay);
      return Response::json($datas);
    }

    public function get_fleetsonbeforepay()
    { 
      $date = Input::get('date', date('Y-m-d'));
      $pool_id = Auth::user()->pool_id;
      $fleets_on_before_pay = Checkin::join('fleets as f', 'f.id', '=', 'checkins.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkins.pool_id','=', $pool_id)
                ->where('checkins.checkin_step_id', '=', 11)
                ->where('checkins.operasi_status_id', '=', 1)
                ->order_by('f.taxi_number','asc')
                ->get(array('f.taxi_number','checkins.id'));
      $datas = array_map(function($object) {
             return $object->to_array();
        }, $fleets_on_before_pay);
      return Response::json($datas);
    }

    public function get_fleetsonbengkel()
    { 
      $fleets_on_bengkel = Fleet::where('fg_bengkel','=', 1)
                ->where('pool_id','=', Auth::user()->pool_id)
                ->order_by('taxi_number','asc')
                ->get(array('taxi_number','id'));
      $datas = array_map(function($object) {
             return $object->to_array();
        }, $fleets_on_bengkel);
      return Response::json($datas);
    }

    public function get_toptenksfleet()
    { 
      
      $date = Input::get('date', date('Y-m-d'));

      $ksos = Kso::where('pool_id','=', Auth::user()->pool_id)
                ->where('actived','=', 1)
                ->get();

      $ksosarray = array();
      foreach ( $ksos as $kso) {
          array_push($ksosarray, $kso->id);
      }
      if(empty($ksosarray))
      {
        $finanks = array();
      } else{ 
        $finanks =  DB::table('financial_report_monthly_bykso')
                    ->join('fleets', 'fleets.id', '=', 'financial_report_monthly_bykso.fleet_id')
                    ->join('drivers', 'drivers.id', '=', 'financial_report_monthly_bykso.driver_id')
                    //->join('ksos', 'ksos.id', '=', 'financial_report_monthly_bykso.kso_id')
                    ->where('month','=',date('n',strtotime($date)) )
                    ->where('year','=',date('Y',strtotime($date)) )
                    ->where('financial_report_monthly_bykso.pool_id','=',Auth::user()->pool_id)
                    //->where('ksos.actived', '=', 1)
                    ->where_in('financial_report_monthly_bykso.kso_id',$ksosarray)
                    ->order_by('financial_report_monthly_bykso.selisi_ks', 'asc')
                    ->take(10)
                    ->get(array('financial_report_monthly_bykso.selisi_ks','fleets.taxi_number','drivers.name','drivers.nip')); 
           
      }

      return Response::json($finanks);

    }

    public function get_toptenksdriver()
    { $date = Input::get('date', date('Y-m-d'));
      $ksos = Kso::where('pool_id','=', Auth::user()->pool_id)
                ->where('actived','=', 1)
                ->get();

      $fleets = array();
      foreach ( $ksos as $fleet) {
        array_push($fleets, $fleet->fleet_id);
      }

      if(empty($fleets))
      {
        $driverks = array();
      } else{ 
        $driverks =  DB::table('financial_report_monthly_driver')
                    ->join('fleets', 'fleets.id', '=', 'financial_report_monthly_driver.fleet_id')
                    ->join('drivers', 'drivers.id', '=', 'financial_report_monthly_driver.driver_id')
                    //->join('ksos', 'ksos.id', '=', 'financial_report_monthly_bykso.kso_id')
                    ->where('month','=',date('n',strtotime($date)) )
                    ->where('year','=',date('Y',strtotime($date)) )
                    ->where('financial_report_monthly_driver.pool_id','=',Auth::user()->pool_id)
                    //->where('ksos.actived', '=', 1)
                    ->where_in('financial_report_monthly_driver.fleet_id',$fleets)
                    ->order_by('financial_report_monthly_driver.selisi_ks', 'asc')
                    ->take(10)
                    ->get(array('financial_report_monthly_driver.selisi_ks','fleets.taxi_number','drivers.name','drivers.nip')); 
      }
    
      return Response::json($driverks);
    }

    public function get_downtime()
    { 
      $date = Input::get('date', date('Y-m-d'));

      $ksos = Kso::where('pool_id','=', Auth::user()->pool_id)
                ->where('actived','=', 1)
                ->get();

      $fleets = array();
      foreach ( $ksos as $fleet) {
        array_push($fleets, $fleet->fleet_id);
      }
      
      $datax = array();
      
      if(!empty($fleets))
      {   
          $userx = User::where('pool_id','=',Auth::user()->pool_id)->get();
          foreach ($userx as $u) {

            $anakasuh = Anakasuh::where_in('anak_asuh.fleet_id',$fleets)
                          ->where('anak_asuh.status', '=', 1 )
                          ->where('anak_asuh.user_id','=', $u->id)
                          ->get(array('anak_asuh.id','anak_asuh.fleet_id','anak_asuh.user_id'));
            
            $fleetsx = array();
            $jumlaharmada = 0;
            foreach ( $anakasuh as $f) {
              array_push($fleetsx, $f->fleet_id);
              $jumlaharmada = $jumlaharmada + 1;
            }
            
            
            $selisiks = 0;
            if(!empty($fleetsx)){
                $bapakasuh =  DB::table('financial_report_monthly_fleet')
                                ->where_in('fleet_id',$fleetsx)
                                ->where('month','=',date('n',strtotime($date)) )
                                ->where('year','=',date('Y',strtotime($date)) )
                                ->order_by('selisi_ks', 'asc')
                                ->take(10)->get();
                
                foreach ($bapakasuh as $x) {
                    $selisiks = $selisiks + $x->selisi_ks; 
                }
               //data array selisi ks
              $datax[] = array(
                          'bapak_asuh'  => $u->id,
                          'selisi_ks'   => $selisiks,
                          'nama'        => $u->first_name . ' ' .$u->last_name,
                          'total_anakasuh' => $jumlaharmada,
                          );  
              
            }
          }            
      }



      /*
      if(empty($fleets))
      {
        $bapakasuh = array();
      } else{ 

        $bapakasuh =  DB::table('bapak_asuh_financial_month')
                    ->join('users','users.id','=','bapak_asuh_financial_month.bapak_asuh')
                    ->where('month','=',date('n',strtotime($date)) )
                    ->where('year','=',date('Y',strtotime($date)) )
                    ->where_pool(Auth::user()->pool_id)
                    ->where('bapak_asuh_financial_month.pool_id','=',Auth::user()->pool_id)
                    ->order_by('selisi_ks', 'asc')
                    ->take(10)
                    ->get();
      }*/
      $retundata = $this->aasort($datax,'selisi_ks');
      return Response::json($retundata);
    }

    private function aasort (&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        $newindex = 0;
        foreach ($sorter as $ii => $va) {
            $ret[$newindex]=$array[$ii];
            $newindex++;
        }

        return $ret;
    }

    //aasort($your_array,"order");


    public function getCountAll()
    {
      $pool_id = Auth::user()->pool_id;

      return Kso::where('actived','=',1)->where('pool_id','=',$pool_id)->count();
    }

    public function getArmadaOps()
    { 
      $pool_id = Auth::user()->pool_id;
      return Checkout::where_operasi_time($date)
                ->where_in('checkout_step_id',array(3,4))
                ->where('operasi_status_id','=',1)
                ->where('pool_id','=', $pool_id)
                ->count();

    }

    
}