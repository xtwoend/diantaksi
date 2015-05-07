<?php

class Checkouts_Controller extends Base_Controller {

	public $restful = true;
  public $views = 'checkouts';
  public $report = 'checkouts.report';

	public function get_index()
	{	
    
    $this->data['docs'] = Stddoc::all();
    $this->data['neats'] = Stdneat::all();
    $this->data['equips'] = Stdequip::all();
    return View::make('themes.modul.'.$this->views.'.index',$this->data);
	}

  public function get_spj()
  { 
    $shifts = Shift::all();
    $this->data['shifts'] = Koki::to_dropdown($shifts,'id','shift');
    return View::make('themes.modul.'.$this->views.'.checkouts',$this->data);
  }

  public function get_qzspj()
  {
    $shifts = Shift::all();
    $this->data['shifts'] = Koki::to_dropdown($shifts,'id','shift');
    return View::make('themes.modul.'.$this->views.'.qzcheckouts',$this->data);
  }  
   
  public function get_allfleetsOnSchedule($date = false, $shift_id = false)
  {
    if(!$date) $date = date('Y-m-d');
    if(!$shift_id) $shift_id = 1; 
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
                  ->where('schedules.pool_id', '=', Auth::user()->pool_id )
                  ->where('schedule_dates.date', '=', date('j', $timestamp))
                  ->where('schedules.month','=',date('n', $timestamp ))
                  ->where('schedule_dates.fg_check','=',0)
                  ->where('schedule_dates.shift_id','=',$shift_id)
                  ->where('ksos.actived','=',1)
                  ->order_by('fleets.taxi_number','asc')
                  ->get(array('schedule_dates.id as id','schedule_dates.driver_id','schedules.fleet_id','fleets.taxi_number'));
      }

      $fleetdatas = array_map(function($object) {
             return $object->to_array();
      }, $fleets);
        
      $data['fleet'] = $fleetdatas;
      return json_encode($data);
  }
 
  public function post_search()
  {
    $jsondata = Input::json();

    $date = $jsondata->date;
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
                  ->where('schedules.pool_id', '=', Auth::user()->pool_id )
                  ->where('schedule_dates.date', '=', date('j', $timestamp))
                  ->where('schedules.month','=',date('n', $timestamp ))
                  ->where('ksos.actived','=',1)
                  ->where('taxi_number','LIKE', '%'.$jsondata->taxi_number.'%')
                  ->get(array('schedule_dates.id as id','schedule_dates.driver_id','schedules.fleet_id','fleets.taxi_number'));
      }

      $fleetdatas = array_map(function($object) {
             return $object->to_array();
      }, $fleets);
        
      $data['fleet'] = $fleetdatas;
      return json_encode($data); 
  }

  public function get_findbyid($id=false)
  {
    if(!$id) return false;
    $scheduledate = Scheduledate::find($id);
    $schedule = Schedule::find($scheduledate->schedule_id);
    
    $driverinfo = Driver::find($scheduledate->driver_id);
    $fleetinfo = Fleet::find($schedule->fleet_id);
    $status = 'OK';
    $blocked = false;


    //if($driverinfo->fg_blocked === 1 OR $fleetinfo->fg_blocked === 1 OR $fleetinfo->fg_bengkel === 1) $status = 'Blocked'; 
    if($driverinfo->fg_blocked == 1)
    {
      $status = 'Pengemudi di block oleh sistem';
      $blocked = true;
    }
    else if($driverinfo->fg_super_blocked == 1){
      $status = 'Pengemudi terkena super block oleh sistem';
      $blocked = true; 
      
    } else if($fleetinfo->fg_blocked == 1){
      $status = 'Armada di block';
      $blocked = true; 
    }
    else if($fleetinfo->fg_bengkel == 1){
      $status = 'Armada di Bengkel';
      $blocked = true; 
    }

    
    if($fleetinfo->fg_setor == 1){
      $status = 'Armada Belum Setoran';
      $blocked = true;
    }
    

    $shift = Shift::find($scheduledate->shift_id);
    
    
    $time = Myfungsi::sysdate();
    //date ajustment
    $start_time = strtotime($shift->spj_print_start);
    $end_time = strtotime($shift->spj_print_end);
   
    $print = false;
    if(($time >= $start_time) && ($time <= $end_time))
    {
       $print = true;
    }
   
    $returndata = array(
                  'id'=>$scheduledate->id, 
                  'nip'=> $driverinfo->nip,
                  'driver_id' =>  $driverinfo->id,
                  'name' => $driverinfo->name,
                  'taxi_number' => $fleetinfo->taxi_number,
                  'police_number' => $fleetinfo->police_number,
                  'pool_id' => $fleetinfo->pool_id,
                  'pool' => Pool::find($fleetinfo->pool_id)->pool_name,
                  'status' => $status,
                  'print' => $print,
                  'blocked' => $blocked,
                  );

    return json_encode($returndata);
  }

  public function get_printspj($id=false)
  { 
    if(!$id) return false;
    $checkout = Checkout::find($id);

    $this->data['dateops'] = date('d/m/Y', strtotime($checkout->operasi_time));
    $this->data['printed'] = date('d/m/Y H:i:s');
    $driverinfo = Driver::find($checkout->driver_id);
    $fleetinfo = Fleet::find($checkout->fleet_id);
    
    $this->data['driverinfo'] = $driverinfo;
    $this->data['fleetinfo'] = $fleetinfo;
    $this->data['pool'] = Pool::find($checkout->pool_id);
    
    if($checkout->operasi_status_id == 1) {
      return View::make('themes.modul.'.$this->report.'.spj',$this->data);
    }else{
      return View::make('themes.modul.'.$this->report.'.spjblocked',$this->data);
    }

  }

  public function post_printspj()
  { 
    $data = Input::json();
    
    Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Print SPJ', true);

    $scheduledate = Scheduledate::find($data->id);
    $schedule = Schedule::find($scheduledate->schedule_id);
    
    $scheduledate->fg_check = 1;
    $scheduledate->save();

    $driverinfo = Driver::find($scheduledate->driver_id);
    $fleetinfo = Fleet::find($schedule->fleet_id);
    $ksoinfo = Kso::where_fleet_id($schedule->fleet_id)->where_actived(1)->first();
    
    $this->data['driverinfo'] = $driverinfo;
    $this->data['fleetinfo'] = $fleetinfo;
    $this->data['pool'] = Pool::find($schedule->pool_id);
    
    $codeops = $data->statusops;
    $keterangan = $data->keterangan;

  
    if((int)$codeops == 1 ){
     
      if($driverinfo->fg_blocked == 1)
      {
        $status = 5;
        $codeops = 7;
      } 
      else if($driverinfo->fg_super_blocked == 1){
        $status = 5;
        $codeops = 7;
      }else if($fleetinfo->fg_blocked == 1){
        $status = 5;
        $codeops = 7;
      }
      else if($fleetinfo->fg_bengkel == 1){
        $status = 6;
        $codeops = 4;
      }else if($fleetinfo->fg_super_blocked == 1){
        $status = 5;
        $codeops = 7;
      }else{
        $status = 3;
        $codeops = $codeops;
      }
     
    }else{
      $status = 3;
    }
    
    $dateopertion = mktime(0, 0, 0, $schedule->month, $scheduledate->date, $schedule->year);
    $checkouts = Checkout::where_fleet_id($schedule->fleet_id)
                  ->where_operasi_time(date('Y-m-d', $dateopertion))
                  ->first();

    if(!$checkouts)
    {
      //insert into to checkouts step
      $checkouts = new Checkout;
      $checkouts->kso_id = $ksoinfo->id;
      $checkouts->operasi_time = date('Y-m-d', $dateopertion);
      $checkouts->fleet_id = $fleetinfo->id;        
      $checkouts->driver_id = $driverinfo->id;    
      $checkouts->checkout_step_id = $status;
      $checkouts->shift_id = $scheduledate->shift_id;
      $checkouts->user_id = Auth::user()->id;
      $checkouts->pool_id = Auth::user()->pool_id;
      $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
      $checkouts->operasi_status_id = $codeops;
      $checkouts->keterangan = $keterangan;
      $checkouts->save();

      if((int)$codeops == 1 ){
        $scheduledate->fg_check = 1;
        $scheduledate->save();
      }

      if((int) $codeops !== 1){
                    
              $cin = Checkin::create(array(
                'kso_id' => $ksoinfo->id,
                'fleet_id' => $fleetinfo->id,
                'driver_id' => $driverinfo->id,
                'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
                'shift_id' => $scheduledate->shift_id,
                'km_fleet' => 0,
                'rit' => 0,
                'incomekm' => 0,
                'operasi_time' => date('Y-m-d', $dateopertion),
                'pool_id' => Auth::user()->pool_id,
                'operasi_status_id' => $codeops,
                'fg_late' => '',
                'checkin_step_id' => 12,
                'document_check_user_id' => Auth::user()->id,
                'physic_check_user_id' => '',
                'bengkel_check_user_id' => '',
                'finance_check_user_id' => '',
                'keterangan' => $keterangan,
                ));
              if($cin){
                $docs = new Checkindocument; 
                $docs->checkin_id = $cin->id;
                $docs->save();
              }
      }
    }else{
      //reprint after open blocking
      if((int) $codeops !== 1){
                  $checkinstatus = Checkin::where_fleet_id($schedule->fleet_id)
                      ->where_operasi_time(date('Y-m-d', $dateopertion))
                      ->first();
                  if(!$checkinstatus){
                    
                    $cin = Checkin::create(array(
                      'kso_id' => $ksoinfo->id,
                      'fleet_id' => $fleetinfo->id,
                      'driver_id' => $driverinfo->id,
                      'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
                      'shift_id' => $scheduledate->shift_id,
                      'km_fleet' => 0,
                      'rit' => 0,
                      'incomekm' => 0,
                      'operasi_time' => date('Y-m-d', $dateopertion),
                      'pool_id' => Auth::user()->pool_id,
                      'operasi_status_id' => $codeops,
                      'fg_late' => '',
                      'checkin_step_id' => 12,
                      'document_check_user_id' => Auth::user()->id,
                      'physic_check_user_id' => '',
                      'bengkel_check_user_id' => '',
                      'finance_check_user_id' => '',
                      'keterangan' => $keterangan,
                      ));
                    
                      if($cin){
                        $docs = new Checkindocument; 
                        $docs->checkin_id = $cin->id;
                        $docs->save();
                      }

                      $setor = Fleet::find($fleetinfo->id);
                      $setor->fg_setor = 1;
                      $setor->save();
                  }
          }

      if((int) $codeops == 1){
        $checkinremove = Checkin::where_fleet_id($schedule->fleet_id)
                    ->where_operasi_time(date('Y-m-d', $dateopertion))
                    ->where_in('operasi_status_id',array(2,3,4,5,6,7)) //->where_operasi_status_id(7)
                    ->first();
        if($checkinremove){
          $checkinremove->delete();

          //make can print before setoran becouse update set on checkout step
              $setor = Fleet::find($schedule->fleet_id);
              $setor->fg_setor = 0;
              $setor->save();
        }
      }

      if((int)$codeops == 1 ){
        $scheduledate->fg_check = 1;
        $scheduledate->save();
      }

      $checkouts->kso_id = $ksoinfo->id;
      $checkouts->operasi_time = date('Y-m-d', $dateopertion);
      $checkouts->fleet_id = $fleetinfo->id;        
      $checkouts->driver_id = $driverinfo->id;    
      $checkouts->checkout_step_id = $status;
      $checkouts->shift_id = $scheduledate->shift_id;
      $checkouts->user_id = Auth::user()->id;
      $checkouts->pool_id = Auth::user()->pool_id;
      $checkouts->operasi_status_id = $codeops;
      $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
      $checkouts->keterangan = $keterangan;
      $checkouts->save();
    }

    return json_encode(array('checkin_id'=> $checkouts->id));
  }

   public function post_qzprintspj()
  { 
    $data = Input::json();
    
    Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Print SPJ', true);

    $scheduledate = Scheduledate::find($data->id);
    $schedule = Schedule::find($scheduledate->schedule_id);
    
    $scheduledate->fg_check = 1;
    $scheduledate->save();

    $driverinfo = Driver::find($scheduledate->driver_id);
    $fleetinfo = Fleet::find($schedule->fleet_id);
    $ksoinfo = Kso::where_fleet_id($schedule->fleet_id)->where_actived(1)->first();
    
    $this->data['driverinfo'] = $driverinfo;
    $this->data['fleetinfo'] = $fleetinfo;
    $this->data['pool'] = Pool::find($schedule->pool_id);
    
    $codeops = $data->statusops;
    $keterangan = $data->keterangan;

  
    if((int)$codeops == 1 ){
     
      if($driverinfo->fg_blocked == 1)
      {
        $status = 5;
        $codeops = 7;
      } 
      else if($driverinfo->fg_super_blocked == 1){
        $status = 5;
        $codeops = 7;
      }else if($fleetinfo->fg_blocked == 1){
        $status = 5;
        $codeops = 7;
      }
      else if($fleetinfo->fg_bengkel == 1){
        $status = 6;
        $codeops = 4;
      }else if($fleetinfo->fg_super_blocked == 1){
        $status = 5;
        $codeops = 7;
      }else{
        $status = 3;
        $codeops = $codeops;
      }
     
    }else{
      $status = 3;
    }
    
    $dateopertion = mktime(0, 0, 0, $schedule->month, $scheduledate->date, $schedule->year);
    $checkouts = Checkout::where_fleet_id($schedule->fleet_id)
                  ->where_operasi_time(date('Y-m-d', $dateopertion))
                  ->first();

    if(!$checkouts)
    {
      //insert into to checkouts step
      $checkouts = new Checkout;
      $checkouts->kso_id = $ksoinfo->id;
      $checkouts->operasi_time = date('Y-m-d', $dateopertion);
      $checkouts->fleet_id = $fleetinfo->id;        
      $checkouts->driver_id = $driverinfo->id;    
      $checkouts->checkout_step_id = $status;
      $checkouts->shift_id = $scheduledate->shift_id;
      $checkouts->user_id = Auth::user()->id;
      $checkouts->pool_id = Auth::user()->pool_id;
      $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
      $checkouts->operasi_status_id = $codeops;
      $checkouts->keterangan = $keterangan;
      $checkouts->save();

      if((int)$codeops == 1 ){
        $scheduledate->fg_check = 1;
        $scheduledate->save();
      }

      if((int) $codeops !== 1){
                    
              $cin = Checkin::create(array(
                'kso_id' => $ksoinfo->id,
                'fleet_id' => $fleetinfo->id,
                'driver_id' => $driverinfo->id,
                'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
                'shift_id' => $scheduledate->shift_id,
                'km_fleet' => 0,
                'rit' => 0,
                'incomekm' => 0,
                'operasi_time' => date('Y-m-d', $dateopertion),
                'pool_id' => Auth::user()->pool_id,
                'operasi_status_id' => $codeops,
                'fg_late' => '',
                'checkin_step_id' => 12,
                'document_check_user_id' => Auth::user()->id,
                'physic_check_user_id' => '',
                'bengkel_check_user_id' => '',
                'finance_check_user_id' => '',
                'keterangan' => $keterangan,
                ));
              if($cin){
                $docs = new Checkindocument; 
                $docs->checkin_id = $cin->id;
                $docs->save();
              }
      }
    }else{
      //reprint after open blocking
      if((int) $codeops !== 1){
                  $checkinstatus = Checkin::where_fleet_id($schedule->fleet_id)
                      ->where_operasi_time(date('Y-m-d', $dateopertion))
                      ->first();
                  if(!$checkinstatus){
                    
                    $cin = Checkin::create(array(
                      'kso_id' => $ksoinfo->id,
                      'fleet_id' => $fleetinfo->id,
                      'driver_id' => $driverinfo->id,
                      'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
                      'shift_id' => $scheduledate->shift_id,
                      'km_fleet' => 0,
                      'rit' => 0,
                      'incomekm' => 0,
                      'operasi_time' => date('Y-m-d', $dateopertion),
                      'pool_id' => Auth::user()->pool_id,
                      'operasi_status_id' => $codeops,
                      'fg_late' => '',
                      'checkin_step_id' => 12,
                      'document_check_user_id' => Auth::user()->id,
                      'physic_check_user_id' => '',
                      'bengkel_check_user_id' => '',
                      'finance_check_user_id' => '',
                      'keterangan' => $keterangan,
                      ));
                    
                      if($cin){
                        $docs = new Checkindocument; 
                        $docs->checkin_id = $cin->id;
                        $docs->save();
                      }

                      $setor = Fleet::find($fleetinfo->id);
                      $setor->fg_setor = 1;
                      $setor->save();
                  }
          }

      if((int) $codeops == 1){
        $checkinremove = Checkin::where_fleet_id($schedule->fleet_id)
                    ->where_operasi_time(date('Y-m-d', $dateopertion))
                    ->where_in('operasi_status_id',array(2,3,4,5,6,7)) //->where_operasi_status_id(7)
                    ->first();
        if($checkinremove){
          $checkinremove->delete();

          //make can print before setoran becouse update set on checkout step
              $setor = Fleet::find($schedule->fleet_id);
              $setor->fg_setor = 0;
              $setor->save();
        }
      }

      if((int)$codeops == 1 ){
        $scheduledate->fg_check = 1;
        $scheduledate->save();
      }

      $checkouts->kso_id = $ksoinfo->id;
      $checkouts->operasi_time = date('Y-m-d', $dateopertion);
      $checkouts->fleet_id = $fleetinfo->id;        
      $checkouts->driver_id = $driverinfo->id;    
      $checkouts->checkout_step_id = $status;
      $checkouts->shift_id = $scheduledate->shift_id;
      $checkouts->user_id = Auth::user()->id;
      $checkouts->pool_id = Auth::user()->pool_id;
      $checkouts->operasi_status_id = $codeops;
      $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
      $checkouts->keterangan = $keterangan;
      $checkouts->save();
    }

    //return json_encode(array('checkin_id'=> $checkouts->id));
    $content = ("");
    
    if($checkouts->operasi_status_id == 1) {
      $kopsurat = 'SURAT PERINTAH JALAN';
      $content .= ("Nama dan kendaraan yang tercantum diatas");
      $content .= ("DI IZINKAN untuk mengoprasikan kendaraan"); 
      $content .= ("PT.DIAN TAKSI sesuai dengan tanggal yang");
      $content .= ("tercantum diatas\r\n");
      $content .=("--------------------------------------- \r\n");
      $content .=("\x1B\x61\x01"); // 1 SET CENTER PAGE
      $content .=("Tanda Tangan \r\n");
      $content .=("\x1B\x61\x00"); // 1 SET LEFT PAGE 
      $content .=("--------------------------------------- \r\n");
      $content .=("  Bag. Operasi               Security \r\n");
      $content .=("\r\n \r\n \r\n");

    }else{
      $kopsurat = 'SURAT PENGANTAR PROSES BAP';
      $content .= ("Nama dan kendaraan yang tercantum diatas");
      $content .= ("TIDAK DI IZINKAN mengoprasikan kendaraan"); 
      $content .= ("PT.DIAN TAKSI sesuai dengan tanggal yang");
      $content .= ("tercantum diatas\r\n");
    }

    $headerPrint =("");
      for($j = 1; $j<2; $j++) {
        $headerPrint .=("\x1B\x40");
        $headerPrint .=("\x1B\x61\x01"); // 1 SET CENTER PAGE
        $headerPrint .=("\x1B\x21\x17");
        $headerPrint .=($kopsurat." \r\n"); 
        $headerPrint .=("\x1B\x21\x00");
        $headerPrint .=("\x1B\x40"); // 1 RESET
        $headerPrint .=("\x1B\x61\x01"); // 1 SET CENTER PAGE
        $headerPrint .=("PT. DHARMA INDAH AGUNG METROPOLITAN \r\n");
        $headerPrint .=("POOL ". Pool::find($checkouts->pool_id)->pool_name  ." \r\n");
        $headerPrint .=("======================================= \r\n"); 
        $headerPrint .=("\x1B\x61\x00"); // 1 SET LEFT PAGE 
        //content printer

        $headerPrint .=("Nama        : ". substr($driverinfo->name, 0, 25) ." \r\n");
        $headerPrint .=("Nip         : ". $driverinfo->nip ." \r\n");
        $headerPrint .=("Body        : ". $fleetinfo->taxi_number. " \r\n");
        $headerPrint .=("Tgl Operasi : ". date('d/m/Y', strtotime($checkouts->operasi_time) ). " \r\n");
        $headerPrint .=("--------------------------------------- \r\n");
        $headerPrint .= $content;
        $headerPrint .=("======================================= \r\n");
        $headerPrint .=("Tanggal Cetak ".date('d/m/Y H:i:s', MyFungsi::sysdate(date('Y-m-d H:i:s')))." \r\n");
        $headerPrint .=("Lembar ke - ".$j." \r\n");
        $headerPrint .=("\x0C"); // 5 FF
        $headerPrint .=("\x1D\x56\x41"); // 4 motong kertas
        $headerPrint .=("\x1B\x40"); // 5 END
      }

      //create temp file
      $file = 'dataprintspj'.$checkouts->pool_id.'.txt';

      $myFile = path('public'). '/qzprint/templatedata/'. $file ;
      $fh = fopen($myFile, 'w') or die("can't open file");
      $resetPrint = "";
      fwrite($fh, $resetPrint);
      $dataPrint = $headerPrint;
      fwrite($fh, $dataPrint);
      fclose($fh);
      
      return json_encode(array('status'=>1, 'urlfile'=> $file));

  }

  public function get_allfleetCheckouts($date = false)
  {
    if(!$date) $date = date('Y-m-d');
      $timestamp = strtotime($date);
      //list armada on checkouts
      $fleets = Checkout::join('fleets as f', 'f.id', '=', 'checkouts.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkouts.checkout_step_id','=',3)
                ->where('checkouts.operasi_status_id','=',1)
                ->where('checkouts.pool_id','=',Auth::user()->pool_id)
                ->order_by('f.taxi_number','asc')
                ->get(array('f.taxi_number','checkouts.id'));
      $fleetdata = array_map(function($object) {
             return $object->to_array();
      }, $fleets);
        
      $data['fleets'] = $fleetdata;
      return json_encode($data);
  }


  public function get_findbyidCheckouts($id=false)
  {
    if(!$id) return false;
    $checkout = Checkout::find($id);
    $fleetinfo = Fleet::find($checkout->fleet_id);
    $driverinfo = Driver::find($checkout->driver_id);
      
    $std_doc = explode(',', $checkout->std_doc_id );
    $ket_doc = explode(',', $checkout->std_doc_ket );
    $std_equip = explode(',', $checkout->std_equip_id );
    $std_neat = explode(',', $checkout->std_neat_id );
    
    $std_docs = array();
    $std_equips = array();
    $std_neats = array();

    foreach ($std_doc as $k => $v) {
      $std_docs[$v] = $ket_doc[$k]; 
    }

    foreach ($std_equip as $k => $v) {
      $std_equips[$v] = $v; 
    }

    foreach ($std_neat as $k => $v) {
      $std_neats[$v] = $v; 
    }
    
    
    $returndata = array(
                  'id'=> $checkout->id, 
                  'nip'=> $driverinfo->nip, 
                  'name' => $driverinfo->name,
                  'taxi_number' => $fleetinfo->taxi_number,
                  'police_number' => $fleetinfo->police_number,
                  'pool_id' => $checkout->pool_id,
                  'pool' => Pool::find($checkout->pool_id)->pool_name,
                  'status' => Checkoutstep::find($checkout->checkout_step_id)->checkout_step,
                  'std_doc_id' => $std_docs,
                  'std_equip_id'  => $std_equips,
                  'std_neat_id'  => $std_neats,
                  'checkout_time' => $checkout->checkout_time,
                  );

    return json_encode($returndata);
  }

  // find taxi on checkouts
  public function post_searchChekouts()
  {
    $jsondata = Input::json();

    $date = $jsondata->date;
    $timestamp = strtotime($date);

    //list armada on checkouts
      $fleets = Checkout::join('fleets as f', 'f.id', '=', 'checkouts.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkouts.pool_id','=',Auth::user()->pool_id)
                ->where('f.taxi_number','LIKE', '%'.$jsondata->taxi_number.'%')
                ->get(array('f.taxi_number','checkouts.id'));

      $fleetdata = array_map(function($object) {
             return $object->to_array();
      }, $fleets);
    
    $data['fleets'] = $fleetdata;
    return json_encode($data);   
  }

  public function post_saveCheck()
  { 
    Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Save Checkout Checklist', true);
    $data = Input::json();

    $id = $data->id;
    $docs_ket = $data->std_docs;
    $neats = $data->std_neats;
    $equips = $data->std_equips;
    //$timeout = $data->checkout_time;

    $docs = array();
    foreach (Stddoc::all() as $doc) {
      array_push($docs, $doc->id);
    }

    $c = Checkout::find($id);

    $setor = Fleet::find($c->fleet_id);
    $setor->fg_setor = 1;
    $setor->save();
    /*
    if($c->operasi_time < date('Y-m-d',Myfungsi::sysdate()) )
    {
      $datax['message'] = array('id'=> $id, 'message'=>'Invalide Date');
    }else{
      */
      if($c->checkout_step_id == 3){
        $c->checkout_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
      }

      $c->std_neat_id = implode(",", $neats);
      $c->std_doc_id = implode(",", $docs);
      $c->std_doc_ket = implode(",", $docs_ket);
      $c->std_equip_id = implode(",", $equips);
      $c->checkout_step_id = 4;
      $c->save();
      $datax['message'] = array('id'=> $id, 'message'=>'Data Saved');
    //} 

    return json_encode($datax);
  }

  public function post_otorisasicetak()
  {
    $data = Input::json();
    $username = $data->username;
    $password = $data->password;

    $ver2 = User::where('username','=',$username)->first();
    if($ver2){
      if (Hash::check($password , $ver2->password))
      {
        Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Print SPJ otoritas', true);

        $scheduledate = Scheduledate::find($data->id);
        $schedule = Schedule::find($scheduledate->schedule_id);
        $scheduledate->fg_check = 1;
        $scheduledate->save(); 

        $driverinfo = Driver::find($scheduledate->driver_id);
        $fleetinfo = Fleet::find($schedule->fleet_id);
        $ksoinfo = Kso::where_fleet_id($schedule->fleet_id)->where_actived(1)->first();
        
        $this->data['driverinfo'] = $driverinfo;
        $this->data['fleetinfo'] = $fleetinfo;
        $this->data['pool'] = Pool::find($schedule->pool_id);
        
        $codeops = $data->statusops;
        $keterangan = $data->keterangan;

        if((int)$codeops == 1 ){
     
          if($driverinfo->fg_blocked == 1)
          {
            $status = 5;
            $codeops = 7;
          } else if($driverinfo->fg_super_blocked == 1){
            $status = 5;
            $codeops = 7;
           
          } else if($fleetinfo->fg_blocked == 1){
            $status = 5;
            $codeops = 7;
          }
          else if($fleetinfo->fg_bengkel == 1){
            $status = 6;
            $codeops = 4;
          }else if($fleetinfo->fg_super_blocked == 1){
            $status = 5;
            $codeops = 7;
          }else{
            $status = 3;
            $codeops = $codeops;
          }
         
        }else{
          $status = 3;
        }
        
        $dateopertion = mktime(0, 0, 0, $schedule->month, $scheduledate->date, $schedule->year);
        $checkouts = Checkout::where_fleet_id($schedule->fleet_id)
                      ->where_operasi_time(date('Y-m-d', $dateopertion))
                      ->first();

        if(!$checkouts)
        {
          //insert into to checkouts step
          $checkouts = new Checkout;
          $checkouts->kso_id = $ksoinfo->id;
          $checkouts->operasi_time = date('Y-m-d', $dateopertion);
          $checkouts->fleet_id = $fleetinfo->id;        
          $checkouts->driver_id = $driverinfo->id;    
          $checkouts->checkout_step_id = $status;
          $checkouts->shift_id = $scheduledate->shift_id;
          $checkouts->user_id = Auth::user()->id;
          $checkouts->pool_id = Auth::user()->pool_id;
          $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
          $checkouts->operasi_status_id = $codeops;
          $checkouts->keterangan = $keterangan;
          $checkouts->print_out_time = 1;
          $checkouts->otorisasi_user_id = $ver2->id;
          $checkouts->save();

          if((int)$codeops == 1 ){
            $scheduledate->fg_check = 1;
            $scheduledate->save();
          }

          if((int) $codeops !== 1){
                        
                  $cin = Checkin::create(array(
                    'kso_id' => $ksoinfo->id,
                    'fleet_id' => $fleetinfo->id,
                    'driver_id' => $driverinfo->id,
                    'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
                    'shift_id' => $scheduledate->shift_id,
                    'km_fleet' => 0,
                    'rit' => 0,
                    'incomekm' => 0,
                    'operasi_time' => date('Y-m-d', $dateopertion),
                    'pool_id' => Auth::user()->pool_id,
                    'operasi_status_id' => $codeops,
                    'fg_late' => '',
                    'checkin_step_id' => 12,
                    'document_check_user_id' => Auth::user()->id,
                    'physic_check_user_id' => '',
                    'bengkel_check_user_id' => '',
                    'finance_check_user_id' => '',
                    'keterangan' => $keterangan,
                    ));

                  if($cin){
                    $docs = new Checkindocument; 
                    $docs->checkin_id = $cin->id;
                    $docs->save();
                  }

                  //make can't print before setoran
                  $setor = Fleet::find($fleetinfo->id);
                  $setor->fg_setor = 1;
                  $setor->save();
          }
        }else{
          
          if((int) $codeops !== 1){
                  $checkinstatus = Checkin::where_fleet_id($schedule->fleet_id)
                      ->where_operasi_time(date('Y-m-d', $dateopertion))
                      ->first();
                  if(!$checkinstatus){
                    
                    $cin = Checkin::create(array(
                      'kso_id' => $ksoinfo->id,
                      'fleet_id' => $fleetinfo->id,
                      'driver_id' => $driverinfo->id,
                      'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
                      'shift_id' => $scheduledate->shift_id,
                      'km_fleet' => 0,
                      'rit' => 0,
                      'incomekm' => 0,
                      'operasi_time' => date('Y-m-d', $dateopertion),
                      'pool_id' => Auth::user()->pool_id,
                      'operasi_status_id' => $codeops,
                      'fg_late' => '',
                      'checkin_step_id' => 12,
                      'document_check_user_id' => Auth::user()->id,
                      'physic_check_user_id' => '',
                      'bengkel_check_user_id' => '',
                      'finance_check_user_id' => '',
                      'keterangan' => $keterangan,
                      ));
                    
                      if($cin){
                        $docs = new Checkindocument; 
                        $docs->checkin_id = $cin->id;
                        $docs->save();
                      }
                    
                  }
          }

          //reprint after open blocking
          if((int) $codeops == 1){
            $checkinremove = Checkin::where_fleet_id($schedule->fleet_id)
                        ->where_operasi_time(date('Y-m-d', $dateopertion))
                        ->where_in('operasi_status_id',array(2,3,4,5,6,7)) //->where_operasi_status_id(7)
                        ->first();
            if($checkinremove){
              $checkinremove->delete();
              //make can print before setoran becouse update set on checkout step
              $setor = Fleet::find($schedule->fleet_id);
              $setor->fg_setor = 0;
              $setor->save();
            }
          }

          if((int)$codeops == 1 ){
            $scheduledate->fg_check = 1;
            $scheduledate->save();
          }


          $checkouts->kso_id = $ksoinfo->id;
          $checkouts->operasi_time = date('Y-m-d', $dateopertion);
          $checkouts->fleet_id = $fleetinfo->id;        
          $checkouts->driver_id = $driverinfo->id;    
          $checkouts->checkout_step_id = $status;
          $checkouts->shift_id = $scheduledate->shift_id;
          $checkouts->user_id = Auth::user()->id;
          $checkouts->pool_id = Auth::user()->pool_id;
          $checkouts->operasi_status_id = $codeops;
          $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
          $checkouts->keterangan = $keterangan;
          $checkouts->print_out_time = 1;
          $checkouts->otorisasi_user_id = $ver2->id;
          $checkouts->save();
        }

        return json_encode(array('checkin_id'=> $checkouts->id));
      }
    }

  }


  public function post_qzotorisasicetak()
  {
    $data = Input::json();
    $username = $data->username;
    $password = $data->password;

    $ver2 = User::where('username','=',$username)->first();
    if($ver2){
      if (Hash::check($password , $ver2->password))
      {
        Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Print SPJ otoritas', true);

        $scheduledate = Scheduledate::find($data->id);
        $schedule = Schedule::find($scheduledate->schedule_id);
        $scheduledate->fg_check = 1;
        $scheduledate->save(); 

        $driverinfo = Driver::find($scheduledate->driver_id);
        $fleetinfo = Fleet::find($schedule->fleet_id);
        $ksoinfo = Kso::where_fleet_id($schedule->fleet_id)->where_actived(1)->first();
        
        $this->data['driverinfo'] = $driverinfo;
        $this->data['fleetinfo'] = $fleetinfo;
        $this->data['pool'] = Pool::find($schedule->pool_id);
        
        $codeops = $data->statusops;
        $keterangan = $data->keterangan;

        if((int)$codeops == 1 ){
     
          if($driverinfo->fg_blocked == 1)
          {
            $status = 5;
            $codeops = 7;
          } else if($driverinfo->fg_super_blocked == 1){
            $status = 5;
            $codeops = 7;
           
          } else if($fleetinfo->fg_blocked == 1){
            $status = 5;
            $codeops = 7;
          }
          else if($fleetinfo->fg_bengkel == 1){
            $status = 6;
            $codeops = 4;
          }else if($fleetinfo->fg_super_blocked == 1){
            $status = 5;
            $codeops = 7;
          }else{
            $status = 3;
            $codeops = $codeops;
          }
         
        }else{
          $status = 3;
        }
        
        $dateopertion = mktime(0, 0, 0, $schedule->month, $scheduledate->date, $schedule->year);
        $checkouts = Checkout::where_fleet_id($schedule->fleet_id)
                      ->where_operasi_time(date('Y-m-d', $dateopertion))
                      ->first();

        if(!$checkouts)
        {
          //insert into to checkouts step
          $checkouts = new Checkout;
          $checkouts->kso_id = $ksoinfo->id;
          $checkouts->operasi_time = date('Y-m-d', $dateopertion);
          $checkouts->fleet_id = $fleetinfo->id;        
          $checkouts->driver_id = $driverinfo->id;    
          $checkouts->checkout_step_id = $status;
          $checkouts->shift_id = $scheduledate->shift_id;
          $checkouts->user_id = Auth::user()->id;
          $checkouts->pool_id = Auth::user()->pool_id;
          $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
          $checkouts->operasi_status_id = $codeops;
          $checkouts->keterangan = $keterangan;
          $checkouts->print_out_time = 1;
          $checkouts->otorisasi_user_id = $ver2->id;
          $checkouts->save();

          if((int)$codeops == 1 ){
            $scheduledate->fg_check = 1;
            $scheduledate->save();
          }

          if((int) $codeops !== 1){
                        
                  $cin = Checkin::create(array(
                    'kso_id' => $ksoinfo->id,
                    'fleet_id' => $fleetinfo->id,
                    'driver_id' => $driverinfo->id,
                    'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
                    'shift_id' => $scheduledate->shift_id,
                    'km_fleet' => 0,
                    'rit' => 0,
                    'incomekm' => 0,
                    'operasi_time' => date('Y-m-d', $dateopertion),
                    'pool_id' => Auth::user()->pool_id,
                    'operasi_status_id' => $codeops,
                    'fg_late' => '',
                    'checkin_step_id' => 12,
                    'document_check_user_id' => Auth::user()->id,
                    'physic_check_user_id' => '',
                    'bengkel_check_user_id' => '',
                    'finance_check_user_id' => '',
                    'keterangan' => $keterangan,
                    ));

                  if($cin){
                    $docs = new Checkindocument; 
                    $docs->checkin_id = $cin->id;
                    $docs->save();
                  }

                  //make can't print before setoran
                  $setor = Fleet::find($fleetinfo->id);
                  $setor->fg_setor = 1;
                  $setor->save();
          }
        }else{
          
          if((int) $codeops !== 1){
                  $checkinstatus = Checkin::where_fleet_id($schedule->fleet_id)
                      ->where_operasi_time(date('Y-m-d', $dateopertion))
                      ->first();
                  if(!$checkinstatus){
                    
                    $cin = Checkin::create(array(
                      'kso_id' => $ksoinfo->id,
                      'fleet_id' => $fleetinfo->id,
                      'driver_id' => $driverinfo->id,
                      'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
                      'shift_id' => $scheduledate->shift_id,
                      'km_fleet' => 0,
                      'rit' => 0,
                      'incomekm' => 0,
                      'operasi_time' => date('Y-m-d', $dateopertion),
                      'pool_id' => Auth::user()->pool_id,
                      'operasi_status_id' => $codeops,
                      'fg_late' => '',
                      'checkin_step_id' => 12,
                      'document_check_user_id' => Auth::user()->id,
                      'physic_check_user_id' => '',
                      'bengkel_check_user_id' => '',
                      'finance_check_user_id' => '',
                      'keterangan' => $keterangan,
                      ));
                    
                      if($cin){
                        $docs = new Checkindocument; 
                        $docs->checkin_id = $cin->id;
                        $docs->save();
                      }
                    
                  }
          }

          //reprint after open blocking
          if((int) $codeops == 1){
            $checkinremove = Checkin::where_fleet_id($schedule->fleet_id)
                        ->where_operasi_time(date('Y-m-d', $dateopertion))
                        ->where_in('operasi_status_id',array(2,3,4,5,6,7)) //->where_operasi_status_id(7)
                        ->first();
            if($checkinremove){
              $checkinremove->delete();
              //make can print before setoran becouse update set on checkout step
              $setor = Fleet::find($schedule->fleet_id);
              $setor->fg_setor = 0;
              $setor->save();
            }
          }

          if((int)$codeops == 1 ){
            $scheduledate->fg_check = 1;
            $scheduledate->save();
          }


          $checkouts->kso_id = $ksoinfo->id;
          $checkouts->operasi_time = date('Y-m-d', $dateopertion);
          $checkouts->fleet_id = $fleetinfo->id;        
          $checkouts->driver_id = $driverinfo->id;    
          $checkouts->checkout_step_id = $status;
          $checkouts->shift_id = $scheduledate->shift_id;
          $checkouts->user_id = Auth::user()->id;
          $checkouts->pool_id = Auth::user()->pool_id;
          $checkouts->operasi_status_id = $codeops;
          $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
          $checkouts->keterangan = $keterangan;
          $checkouts->print_out_time = 1;
          $checkouts->otorisasi_user_id = $ver2->id;
          $checkouts->save();
        }

        $content = ("");
    
    if($checkouts->operasi_status_id == 1) {
      $kopsurat = 'SURAT PERINTAH JALAN';
      $content .= ("Nama dan kendaraan yang tercantum diatas");
      $content .= ("DI IZINKAN untuk mengoprasikan kendaraan"); 
      $content .= ("PT.DIAN TAKSI sesuai dengan tanggal yang");
      $content .= ("tercantum diatas\r\n");
      $content .=("--------------------------------------- \r\n");
      $content .=("\x1B\x61\x01"); // 1 SET CENTER PAGE
      $content .=("Tanda Tangan \r\n");
      $content .=("\x1B\x61\x00"); // 1 SET LEFT PAGE 
      $content .=("--------------------------------------- \r\n");
      $content .=("  Bag. Operasi               Security \r\n");
      $content .=("\r\n \r\n \r\n");

    }else{
      $kopsurat = 'SURAT PENGANTAR PROSES BAP';
      $content .= ("Nama dan kendaraan yang tercantum diatas");
      $content .= ("TIDAK DI IZINKAN mengoprasikan kendaraan"); 
      $content .= ("PT.DIAN TAKSI sesuai dengan tanggal yang");
      $content .= ("tercantum diatas\r\n");
    }

      $headerPrint =("");
      for($j = 1; $j<2; $j++) {
        $headerPrint .=("\x1B\x40");
        $headerPrint .=("\x1B\x61\x01"); // 1 SET CENTER PAGE
        $headerPrint .=("\x1B\x21\x17");
        $headerPrint .=($kopsurat." \r\n"); 
        $headerPrint .=("\x1B\x21\x00");
        $headerPrint .=("\x1B\x40"); // 1 RESET
        $headerPrint .=("\x1B\x61\x01"); // 1 SET CENTER PAGE
        $headerPrint .=("PT. DHARMA INDAH AGUNG METROPOLITAN \r\n");
        $headerPrint .=("POOL ". Pool::find($checkouts->pool_id)->pool_name  ." \r\n");
        $headerPrint .=("======================================= \r\n"); 
        $headerPrint .=("\x1B\x61\x00"); // 1 SET LEFT PAGE 
        //content printer

        $headerPrint .=("Nama        : ". substr($driverinfo->name, 0, 25) ." \r\n");
        $headerPrint .=("Nip         : ". $driverinfo->nip ." \r\n");
        $headerPrint .=("Body        : ". $fleetinfo->taxi_number. " \r\n");
        $headerPrint .=("Tgl Operasi : ". date('d/m/Y', strtotime($checkouts->operasi_time) ). " \r\n");
        $headerPrint .=("--------------------------------------- \r\n");
        $headerPrint .= $content;
        $headerPrint .=("======================================= \r\n");
        $headerPrint .=("Tanggal Cetak ".date('d/m/Y H:i:s', MyFungsi::sysdate(date('Y-m-d H:i:s')))." \r\n");
        $headerPrint .=("Lembar ke - ".$j." \r\n");
        $headerPrint .=("\x0C"); // 5 FF
        $headerPrint .=("\x1D\x56\x41"); // 4 motong kertas
        $headerPrint .=("\x1B\x40"); // 5 END
      }


      //create temp file
      $file = 'dataprintspj'.$checkouts->pool_id.'.txt';

      $myFile = path('public'). '/qzprint/templatedata/'. $file ;
      $fh = fopen($myFile, 'w') or die("can't open file");
      $resetPrint = "";
      fwrite($fh, $resetPrint);
      $dataPrint = $headerPrint;
      fwrite($fh, $dataPrint);
      fclose($fh);
      
      return json_encode(array('status'=>1, 'urlfile'=> $file));
      }
    }

  }
}