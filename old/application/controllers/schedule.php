<?php
class Schedule_Controller extends Base_Controller
{

    public $restful = true;
    public $views = 'schedule';
    public $report = 'schedule.report';

    public function get_index()
    {
      //var_dump($this->data['scheduleday']);
      return View::make('themes.modul.'.$this->views.'.index',$this->data);
    }
   	
    public function get_scheduleview($date = false)
    { 
      if(!$date)  $date = date('Y-m-d');

      $timestamp = strtotime($date);

      $arrayschedule = array();
      $schedule = Schedule::where('month', '=', date('n', $timestamp) )->where('year', '=', date('Y', $timestamp))->get(array('id','fleet_id'));
      foreach ($schedule as $sc) {
        $arrayschedule[] = $sc->id; 
      }
      $this->data['scheduleday'] = array();
      if(is_array($arrayschedule) && !empty($arrayschedule)){
        $this->data['scheduleday'] = Scheduledate::join('schedules','schedules.id','=','schedule_dates.schedule_id')
                                      ->join('fleets','fleets.id' ,'=' ,'schedules.fleet_id')
                                      ->where_in('schedule_dates.schedule_id', $arrayschedule )
                                      ->where('schedules.pool_id', '=', Auth::user()->pool_id )
                                      ->where('schedule_dates.date', '=', date('j', $timestamp))
                                      ->order_by('fleets.taxi_number','asc')
                                      ->get(array('fleets.taxi_number','schedule_dates.id as id','schedule_dates.driver_id','schedules.fleet_id','schedule_dates.fg_check','schedule_dates.shift_id'));
      }

      $this->data['tanggal'] = Myfungsi::fulldate($timestamp);
      $this->data['date'] = $date;
      return View::make('themes.modul.'.$this->views.'.viewschedulelist',$this->data);
    }

   	public function get_groups()
   	{
      $this->data['schedulemasters'] = Schedulemaster::all();
      return View::make('themes.modul.'.$this->views.'.group',$this->data);
   	}

    public function get_addtogroup()
    {
      $master_schedule_id = (int) Input::get('mstr_schedule', false);
      if(!$master_schedule_id) return Redirect::to('schedule/groups');

      $this->data['newgroup'] = Schedulegroup::where('pool_id','=', Auth::user()->pool_id )->where('schedule_master_id','=',$master_schedule_id )->max('group') +1;
      return View::make('themes.modul.'.$this->views.'.addfleet',$this->data);
    }

    public function post_addgroup()
    {
      $fleets = Input::get('fleets');
      $newgroup = Input::get('group');
      $schedule_master_id = Input::get('schedule_master_id');
      
      $group = new Schedulegroup;
      $group->group = $newgroup;
      $group->schedule_master_id = $schedule_master_id;
      $group->pool_id = Auth::user()->pool_id;
      $group->save();
      $group_id = $group->id;


      foreach ($fleets as $fleet) {
        Schedulefleetgroup::create(array('fleet_id'=>$fleet , 'schedule_group_id' => $group_id ));
        $set = Fleet::find($fleet);
        $set->fg_group = 1;
        $set->save();
      }
      
      return Redirect::to('schedule/groups');
      
    }
    public function get_addformgroup()
    { 
      $options = array();
      foreach(Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('fleets.fg_group','=', 0)->where('ksos.actived', '=', 1)->where('fleets.pool_id', '=', Auth::user()->pool_id)->order_by('fleets.taxi_number','asc')->get(array('fleets.taxi_number', 'fleets.id')) as $fleet)
      {
        $options[$fleet->id] = $fleet->taxi_number;
      }
      $this->data['fleets'] = $options;
      
      //var_dump($options);
      return View::make('themes.modul.'.$this->views.'.addformgroup',$this->data);
    }

    public function get_ajaxfleetlist()
    {
      $options = array();
      foreach(Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('fleets.fg_group','=', 0)->where('ksos.actived', '=', 1)->where('fleets.pool_id', '=', Auth::user()->pool_id)->order_by('fleets.taxi_number','asc')->get(array('fleets.taxi_number', 'fleets.id')) as $fleet)
      {
        $options[$fleet->id] = $fleet->taxi_number;
      }
      $this->data['fleets'] = $options;
      return View::make('themes.modul.'.$this->views.'.fleetlist',$this->data);
    }

    public function get_create()
    {
      $id = (int) Input::get('id', false);
      if(!$id) return Redirect::to('schedule/groups');
      $this->data['fleets'] = Schedulefleetgroup::where('schedule_group_id','=',$id)->get();
      $this->data['group'] = Schedulegroup::find($id);
  
      return View::make('themes.modul.'.$this->views.'.createschedule',$this->data);
    }

    public function get_detail($id = false, $id_group = false)
    { 
      if(!$id || !$id_group) return false;
      
      $group = Schedulegroup::find($id_group);
      $interval = Schedulemaster::find($group->schedule_master_id);

      $dayofmonth = array();
      $optionsmonth = array();
      $optionsyears = array();

      for($i=1; $i <= ( $interval->bravo_interval + 1 ); $i++)
      {
          $dayofmonth[$i] = $i;
      }

      for ($month=1; $month <= 12 ; $month++) { 
          $optionsmonth[$month] = Myfungsi::bulan($month);
      }

      for ($year=date('Y'); $year < ( date('Y') + 3 ); $year++) { 
          $optionsyears[$year] = $year;
      }

      $this->data['fleets'] = Schedulefleetgroup::where('schedule_group_id','=',$id_group)->get();
      $this->data['group'] = Schedulegroup::find($id_group);
      $this->data['dayofmonth'] = $dayofmonth;
      $this->data['months'] = $optionsmonth;
      $this->data['years'] = $optionsyears;
      
      $this->data['shifts'] = Koki::to_dropdown(Shift::all(),'id','shift');

      $this->data['fleetinfo'] = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('ksos.fleet_id','=', $id)->where('ksos.actived', '=', 1)->where('fleets.pool_id', '=', Auth::user()->pool_id)->first(); //->get(array('fleets.*','ksos.bravo_driver_id', 'ksos.charlie_driver_id'));
      
      return View::make('themes.modul.'.$this->views.'.setholiday',$this->data);
    }

    public function post_generate()
    {
      $data = Input::json();
      //edit schedule generate all on one click
      $found = Schedule::where('fleet_id','=', $data->fleet_id)->where('month', '=', $data->month)->where('year','=',$data->year)->count();
      if(! ( $found > 0 ) )
      {
        $schedule = new Schedule;
        $schedule->pool_id = Auth::user()->pool_id;
        $schedule->fleet_id = $data->fleet_id;
        $schedule->schedule_master_id =  $data->schedule_master_id;
        $schedule->month = $data->month;
        $schedule->year = $data->year;
        $schedule->user_id = Auth::user()->id;
        $schedule->inserted_date_set = date('Y-m-d H:i:s');
        $schedule->save();

        $schedule_id =  $schedule->id;

        $interval = Schedulemaster::find($data->schedule_master_id);
        
        $h = 1;
        $z = 0; 
        $g = 1;

        for($i=1; $i <= date('t',mktime(1, 2, 3, $data->month, 1, $data->year)); $i++)
        {   
            //new generate
            
            if( $data->day == $i ){
              $z = 1 + $data->sisaopscharlie;
            }

            if($z <= $interval->charlie_interval && $z !== 0){
              $driver_id = $data->charlie_id;
              $z++;
            }
            else if( $i > $data->day)
            {
                if($h <= $interval->bravo_interval)
                {
                  $driver_id = $data->bravo_id;
                  $h++;
                }else if($g <= $interval->charlie_interval){
                  $driver_id = $data->charlie_id;
                  $g++;
                }else{
                  $h=2;
                  $g=1;
                  $driver_id = $data->bravo_id;
                }   
            }else{
                $driver_id = $data->bravo_id;
            }

            // penentuan shift operasi (kalong, reguler, non shift) belum di definisikan
            
            $schdate = new Scheduledate;
            $schdate->schedule_id = $schedule_id;
            $schdate->date = $i;
            $schdate->driver_id = $driver_id;
            $schdate->shift_id = $data->shift;
            $schdate->fg_check = 0;
            $schdate->inserted_date_set = date('Y-m-d H:i:s');
            $schdate->save();
            
            
        }

        return $schedule_id;
      }
      $error['error'] = array('text'=>'jadwal sudah pernah di buat'); 
      return Response::error('500', $error);  
      //return '{"error":{"text":"jadwal sudah pernah di buat"}}'; 
    }

    public function get_viewschedule($month = false, $year = false, $fleet_id = false)
    {
      if(!$month || !$year || !$fleet_id) return false;
      $this->data['schedule'] =  Schedule::where('fleet_id', '=', $fleet_id )->where('month', '=', $month )->where('year', '=', $year)->first();
      if(!$this->data['schedule']) return false;
      return View::make('themes.modul.'.$this->views.'.viewschedule',$this->data);
    }

    public function get_editschedule($schedule_id = false)
    {
      if(!$schedule_id) return false;
      $schd = Scheduledate::find($schedule_id);
      $schm = Schedule::find($schd->schedule_id);
      $stmp = mktime(0,0,0,$schm->month, $schd->date , $schm->year );

      $this->data['date'] =  Myfungsi::fulldate($stmp);
      $this->data['schd'] = $schd;
      $this->data['schm'] = $schm;
      $this->data['tanggal'] = date('Y-m-d', $stmp);
      $this->data['bckso'] = Kso::where('fleet_id','=', $schm->fleet_id)->where('actived','=',1)->first();

      return View::make('themes.modul.'.$this->views.'.editschedule',$this->data);
    }

    public function get_editscheduleonmaster($scheduledate_id = false)
    {
      if(!$scheduledate_id) return false;
      $schd = Scheduledate::find($scheduledate_id);
      $schm = Schedule::find($schd->schedule_id);
      $stmp = mktime(0,0,0,$schm->month, $schd->date , $schm->year );

      $this->data['date'] =  Myfungsi::fulldate($stmp);
      $this->data['schd'] = $schd;
      $this->data['schm'] = $schm;
      $this->data['month'] = date('n', $stmp);
      $this->data['year'] = date('Y', $stmp);
      $this->data['bckso'] = Kso::where('fleet_id','=', $schm->fleet_id)->where('actived','=',1)->first();

      return View::make('themes.modul.'.$this->views.'.editscheduleonmaster',$this->data);
    }

    public function post_changeSave()
    {
      $data = Input::json();
      try{
        $edit = Scheduledate::find($data->schedule_date_id);
        $edit->driver_id = $data->driver;
        $edit->save();
        return $edit->id;
      }catch(PDOException $e) {
        return '{"error":{"text":'. $e->getMessage() .'}}'; 
      }
    }


    public function post_lelangSave()
    {
      $data = Input::json();
      try{

        $edit = Scheduledate::find($data->schedule_date_id);
        $edit->driver_id = $data->driver;
        $edit->save();

        //count lelang here belum di definisikan
        
        return $edit->id;
      }catch(PDOException $e) {
        return '{"error":{"text":'. $e->getMessage() .'}}'; 
      }
    }
    //view lelang mode
    public function get_getDriver()
    {
      $q = Input::get('query');
      $driver = Driver::where('driver_status','=',1)->where('pool_id', '=', Auth::user()->pool_id)->where('nip', 'like', '%'.$q.'%' )->or_where('name','like', '%'.$q.'%')->get();
      $data = array();
      foreach ($driver as $k) {
        $data[] = array('id' => $k->id, 'nip' => $k->nip, 'name' => $k->name ); 
      }
      return json_encode($data);
    } 

    public function get_report()
    {
      return View::make('themes.modul.'.$this->views.'.report',$this->data);
    }

    public function get_reportview($date = false)
    {
      if(!$date)  $date = date('Y-m-d');
      $timestamp = strtotime($date);
      $this->data['countmonth'] = date('t', $timestamp);
      $this->data['timestamp'] = $timestamp;
      
      return View::make('themes.modul.'.$this->views.'.reportdisply',$this->data);
    }


    //print to pdf 
    public function get_ExportJhoHarianPdf($date = false)
    { 

      if(!$date)  $date = date('Y-m-d');

      $timestamp = strtotime($date);

      $arrayschedule = array();
      $schedule = Schedule::where('month', '=', date('n', $timestamp) )->where('year', '=', date('Y', $timestamp))->get(array('id','fleet_id'));
      foreach ($schedule as $sc) {
        $arrayschedule[] = $sc->id; 
      }
      $this->data['scheduleday'] = array();
      if(is_array($arrayschedule) && !empty($arrayschedule)){
        $this->data['scheduleday'] = Scheduledate::join('schedules','schedules.id','=','schedule_dates.schedule_id')
                                      ->where_in('schedule_dates.schedule_id', $arrayschedule )
                                      ->where('schedules.pool_id', '=', Auth::user()->pool_id )
                                      ->where('schedule_dates.date', '=', date('j', $timestamp))
                                      ->get(array('schedule_dates.id as id','schedule_dates.driver_id','schedules.fleet_id','schedule_dates.fg_check'));
      }

      $this->data['tanggal'] = Myfungsi::fulldate($timestamp);
      /*
      ob_start();
        echo View::make('themes.modul.'.$this->report.'.scheduleharian',$this->data);
      $content = ob_get_clean();
      
      try
      {
          $html2pdf = new HTML2PDF('P', 'A4', 'en');
          $html2pdf->pdf->SetDisplayMode('fullpage');
          //$html2pdf->pdf->SetProtection(array('print'), 'spipu');
          $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
          return Response::make($html2pdf->Output(), 200, array('Content-type' => 'application/pdf'));
      }
      catch(HTML2PDF_exception $e) {
          echo $e;
          exit;
      }
      */
      return View::make('themes.modul.'.$this->report.'.scheduleharian',$this->data);
    }

    public function post_delgroup()
    { 
      $id = Input::get('id');
      if(!$id) return false;
      $group = Schedulefleetgroup::where('schedule_group_id','=',$id)->get();
      if($group)
      {
        foreach ($group as $x) {
          $fleet = Fleet::find($x->fleet_id);
          $fleet->fg_group = 0;
          $fleet->save();
        }
        DB::table('schedule_groups')->where('id', '=', $id)->delete();
        DB::table('schedule_fleet_groups')->where('schedule_group_id', '=', $id)->delete();
      }
      

      return Redirect::to('schedule/groups');
    }


    public function post_schedulereset()
    {
      $data = Input::json();
      $schedule =  Schedule::where('fleet_id', '=', $data->fleet_id )->where('month', '=', $data->month )->where('year', '=', $data->year)->first();
      if($schedule->delete())
      {
        return json_encode(array('Jadwal Berhasil di Hapus'));
      }else{
        return json_encode(array('Jadwal Gagal di Hapus'));
      }
    }


    //master schedulu operasi

    public function get_mastersch()
    { 
      $pool_id = Auth::user()->pool_id;
      $this->data['masterschedules'] = Schedulemaster::order_by('name','asc')->paginate(20);

      return View::make('themes.modul.'.$this->views.'.masterschedule',$this->data);
    }

    public function get_masterschadd()
    {
      $this->data['create'] = true;
      return View::make('themes.modul.'.$this->views.'.masterscheduleform',$this->data);
    }

    public function post_masterschadd()
    {
      $input = Input::all();
      try {
        Schedulemaster::create($input);
        return Redirect::to('schedule/mastersch');
      } catch (Exception $e) {
        return 'Error Insert';
      }
    }

    public function get_masterschedit($id=false)
    {
      if(!$id) return Redirect::to('schedule/mastersch');

      $this->data['ms'] = Schedulemaster::find($id);
      $this->data['create'] = false;

      return View::make('themes.modul.'.$this->views.'.masterscheduleform',$this->data);
    }

    public function post_masterschedit($id=false)
    { 
      if(!$id) return Redirect::to('schedule/mastersch');

      try {
        $edit = Schedulemaster::find($id);
        $edit->name = Input::get('name');
        $edit->bravo_interval = Input::get('bravo_interval');
        $edit->charlie_interval = Input::get('charlie_interval');
        $edit->save();
        return Redirect::to('schedule/mastersch');
      } catch (Exception $e) {
        return 'Error Insert';
      }
    }
}