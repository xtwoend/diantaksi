<?php

class Cardcontrols_Controller extends Base_Controller {

	public $restful = true;
  public $views = 'cardcontrols';
  public $report = 'cardcontrols.report';

	public function get_fleets()
	{	    
    return View::make('themes.modul.'.$this->views.'.fleets',$this->data);
	}

  public function get_drivers()
  {     
    
    return View::make('themes.modul.'.$this->views.'.drivers',$this->data);
  }

  public function get_driverviews($id=false)
  {
    $startdate = Input::get('datestart', false);
    $enddate = Input::get('dateend', false);
    
    
    if(!$id) return false;
    if(!$startdate) $startdate = date('Y-m-d', mktime(0,0,0,(int) strtotime('m',$startdate),1,(int) strtotime('Y',$enddate))); 
    if(!$enddate) $enddate = date('Y-m-d', (int)mktime(0,0,0,strtotime('m',$enddate), (int) strtotime('j',$enddate), (int)strtotime('Y',$enddate))); 
    
    $financial_driver = DB::table('financial_report_driver')->where('driver_id','=',$id)->first();
      $driver_ks = 0;
      $driver_cicilan_ks = 0;
      $cicilan_hutang_lama = 0;
    $driv = Driver::find($id);
    if($financial_driver){
      $driver_ks = $financial_driver->ks;
      $driver_cicilan_ks = $financial_driver->cicilan_ks;
      $cicilan_hutang_lama = $financial_driver->cicilan_hutang_lama;
    }

    $reports = DB::table('financial_report_daily')
              ->where('driver_id','=',$id)
              ->where('operasi_time','>=', $startdate)
              ->where('operasi_time','<=', $enddate)
              ->order_by('operasi_time','asc')
              ->get();

    $this->data['name'] = $driv->name. ' ('.$driv->nip.')';
    $this->data['kspengemudi'] = $driver_ks;
    $this->data['cicilanks'] = $driver_cicilan_ks;
    $this->data['cicilanhutang'] = $cicilan_hutang_lama;
    $this->data['reports'] = $reports;

    if($cont=='tampil'){
      return View::make('themes.modul.'.$this->views.'.kartukontrolpengemudi',$this->data);
    }else{
      return View::make('themes.modul.'.$this->report.'.printkartukontrol',$this->data);
    }
    
  }

  public function get_driverslist()
  {
    $pool_id = Auth::user()->pool_id;
    $drivers = Driver::where_pool_id($pool_id)->get(array('id','nip','name'));
    $driverdata = array_map(function($object) {
             return $object->to_array();
    }, $drivers);
        
    $data['drivers'] = $driverdata;
    return json_encode($data);
  }

  public function get_fleetslist()
  {
    $pool_id = Auth::user()->pool_id;
    
    //$fleets = Fleet::where_pool_id($pool_id)->get(array('id','taxi_number'));
    $fleets = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('ksos.actived', '=', 1)->where('fleets.pool_id', '=', Auth::user()->pool_id)->order_by('fleets.taxi_number','asc')->get(array('fleets.taxi_number', 'fleets.id', 'ksos.id as kso_id'));

    $fleetdata = array_map(function($object) {
             return $object->to_array();
    }, $fleets);
        
    $data['fleets'] = $fleetdata;
    return json_encode($data);
  }
  public function post_searchDriver()
  {
    $jsondata = Input::json();
    $pool_id = Auth::user()->pool_id;
    $drivers = Driver::where_pool_id($pool_id)->where('nip','LIKE','%'.$jsondata->nip.'%')->get(array('id','nip','name'));
    $driverdata = array_map(function($object) {
             return $object->to_array();
    }, $drivers);
        
    $data['drivers'] = $driverdata;
    return json_encode($data);
  }

  public function post_searchFleet()
  {
    $jsondata = Input::json();
    $pool_id = Auth::user()->pool_id;
    //$fleets = Fleet::where_pool_id($pool_id)->where('taxi_number','LIKE','%'.$jsondata->taxi_number.'%')->get(array('fleets.taxi_number', 'fleets.id', 'ksos.id as kso_id'));
    //$fleets = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('ksos.actived', '=', 1)->where('fleets.pool_id', '=', Auth::user()->pool_id)->where('taxi_number','LIKE','%'.$jsondata->taxi_number.'%')->order_by('fleets.taxi_number','asc')->get(array('fleets.taxi_number', 'fleets.id', 'ksos.id as kso_id'));
    $fleets = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')
              //->where('ksos.actived', '=', 1)
              ->where('fleets.pool_id', '=', Auth::user()->pool_id)
              ->where('taxi_number','LIKE','%'.$jsondata->taxi_number.'%')
              ->order_by('fleets.taxi_number','asc')
              ->get(array('fleets.taxi_number', 'fleets.id', 'ksos.id as kso_id','ksos.actived as actived'));

    /*
    $fleetdata = array_map(function($object) {
             return $object->to_array();
    }, $fleets);
    */
   
    $fleetdata = array();

    foreach ($fleets as $fleet) {
      $actived = ($fleet->actived == 1) ? 'Active' : 'Gugur';
      $fleetdata[] = array(
            'taxi_number' => $fleet->taxi_number  .'('. $actived .' )' ,
            'id'          => $fleet->id,
            'kso_id'      => $fleet->kso_id
        );
    }
        
    $data['fleets'] = $fleetdata;
    return json_encode($data);
  }


  public function get_findbyIdDriver($id=false)
  {
    if(!$id) return false;
    $driver = Driver::find($id);
    $financial_driver = DB::table('financial_report_driver')->where('driver_id','=',$driver->id)->first();
    
    //check hutang lama  
    $hutang_lama = Driverfinancial::where_driver_id($driver->id)->where_financial_type_id('18')->first();
    $tagihan_hutang_lama = 0;
    if($hutang_lama)
    {
      $tagihan_hutang_lama = $hutang_lama->amount;
    }

      $driver_ks = 0;
      $driver_cicilan_ks = 0;
      $cicilan_hutang_lama = 0;

    if($financial_driver){
      $driver_ks = $financial_driver->ks;
      $driver_cicilan_ks = $financial_driver->cicilan_ks;
      $cicilan_hutang_lama = $financial_driver->cicilan_hutang_lama;
    }

    $driverinfo = array(
                  'id'  => $driver->id,
                  'name'  => $driver->name,
                  'nip'   => $driver->nip,
                  'saldo_ks_driver' => number_format($driver_ks, 2,',','.'),
                  'pembayaran_ks_driver' => number_format($driver_cicilan_ks, 2,',','.'),
                  'hutang_lama' => number_format($tagihan_hutang_lama, 2,',','.'),
                  'cicilan_hutang_lama' => number_format($cicilan_hutang_lama, 2,',','.'),
                  'status' => ($driver->fg_blocked == 1) ? 'Blocked' : 'Ok',
      );
    
    $bapinfo = array();
    $baps = Bap::where_driver_id($driver->id)->order_by('date','desc');
    $countbap = $baps->count();

    if($baps->get() ){
      foreach ($baps->get() as $bap) {
        $bapinfo[] = array(
                        'id' => $bap->id,
                        'date' => $bap->date,
                        'bap_number' => $bap->bap_number,
                        'user'  => User::find($bap->user_id)->fullname,
                        );
      }      
    } 

   
    $returndata = array(
                  'driverinfo' => $driverinfo,
                  'bapinfo' => $bapinfo,
                  'countbap' => $countbap,
    );
    return json_encode($returndata);
  }

  public function get_findbyIdFleet($id=false)
  {
    if(!$id) return false;
    
    //$fleet = Fleet::find($id);
    //$kso = Kso::where_fleet_id($fleet->id)->where_actived(1)->first();
    $kso = Kso::find($id);
    $fleet = Fleet::find($kso->fleet_id);

    $financial_fleet = DB::table('financial_report_bykso')->where('kso_id','=',$kso->id)->first();
    $financial_fleet_part = DB::table('wo_financial_report_bykso')->where('kso_id','=',$kso->id)->first();

      $fleet_ks = 0;
      $fleet_cicilan_ks = 0;
      $fleet_tabungan_sparepart = 0;
      $fleet_cicilan_dp_kso = 0;
      $fleet_cicilan_sparepart = 0;
      $fleet_dp_sparepart = 0;

    if($financial_fleet){
      $fleet_ks = $financial_fleet->ks;
      $fleet_cicilan_ks = $financial_fleet->cicilan_ks;
      $fleet_tabungan_sparepart = $financial_fleet->tabungan_sparepart;
      $fleet_cicilan_dp_kso = $financial_fleet->cicilan_dp_kso;
      $fleet_cicilan_sparepart = $financial_fleet->cicilan_sparepart;
      $fleet_dp_sparepart = $financial_fleet->hutang_dp_sparepart; 
    }
    
    $total_pemakaian_part = 0;
    if($financial_fleet_part)
    {
      $total_pemakaian_part = $financial_fleet_part->pemakaian_part;
    }

    $fleetinfo = array(
                  'id' => $fleet->id, 
                  'police_number' => $fleet->police_number,
                  'bravo' => Driver::find($kso->bravo_driver_id)->name,
                  'taxi_number' => $fleet->taxi_number,
                  'total_ks' => number_format($fleet_ks, 0,',','.'),
                  'pembayaran_ks' => number_format($fleet_cicilan_ks, 0,',','.'),
                  'tab_sparepart' => number_format($fleet_tabungan_sparepart, 0,',','.'),
                  'dp_kso' => number_format($kso->dp, 0,',','.'),
                  'hutang_dp_kso' => number_format($kso->sisa_dp, 0,',','.'),
                  'pem_hutang_dp_kso' => number_format($fleet_cicilan_dp_kso, 0,',','.'),
                  'pem_sparepart' => number_format($total_pemakaian_part, 0,',','.'),
                  'saldo_unit' => number_format((($fleet_cicilan_ks ) - ($fleet_ks)) + (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part ), 0,',','.'),
                  'pembayaran_sparepart' => number_format(($fleet_cicilan_sparepart + $fleet_dp_sparepart), 0,',','.'),
                  'status'  => ($fleet->fg_blocked == 1 || $fleet->fg_bengkel == 1) ? 'Blocked' : 'Ready',
                  'saldo_dp' => ($kso->sisa_dp - $fleet_cicilan_dp_kso),
      );

    $returndata = array(

                  'fleetinfo' => $fleetinfo,
    );
    return json_encode($returndata);
  }

  public function get_kartukontrolpengemudi($id=false)
  { 
    $startdate = Input::get('datestart', false);
    $enddate = Input::get('dateend', false);
    $cont = Input::get('con', false);

    if(!$id) return false;
    if(!$startdate) $startdate = date('Y-m-d', mktime(0,0,0,(int) strtotime('m',$startdate),1,(int) strtotime('Y',$enddate))); 
    if(!$enddate) $enddate = date('Y-m-d', (int)mktime(0,0,0,strtotime('m',$enddate), (int) strtotime('j',$enddate), (int)strtotime('Y',$enddate))); 
    
    //$financial_driver = DB::table('financial_report_driver')->where('driver_id','=',$id)->first();
     
    $driv = Driver::find($id);
  
    $reports = DB::table('financial_report_daily')
              ->where('driver_id','=',$id)
              ->where('operasi_time','>=', $startdate)
              ->where('operasi_time','<=', $enddate)
              ->order_by('operasi_time','asc')
              ->get();

    $this->data['name'] = $driv->name. ' ('.$driv->nip.')';
    $this->data['reports'] = $reports;
    //return View::make('themes.modul.'.$this->views.'.kartukontrolpengemudi',$this->data);
    $this->data['startdate'] = $startdate;
    $this->data['enddate']  = $enddate;

    if($cont=='tampil'){
      return View::make('themes.modul.'.$this->views.'.kartukontrolpengemudi',$this->data);
    }else if($cont=='download'){
      return View::make('themes.modul.'.$this->report.'.printkartukontrolpengemudi',$this->data);
    }
    
    return View::make('themes.modul.'.$this->views.'.kartukontrolpengemudi',$this->data);
  }

  public function get_kartukontrolarmada($id=false)
  {
    $startdate = Input::get('datestart', false);
    $enddate = Input::get('dateend', false);
    $cont = Input::get('con', false);

    if(!$id) return false;
    if(!$startdate) $startdate = date('Y-m-d', mktime(0,0,0,(int) strtotime('m',$startdate),1,(int) strtotime('Y',$enddate))); 
    if(!$enddate) $enddate = date('Y-m-d', (int)mktime(0,0,0,strtotime('m',$enddate), (int) strtotime('j',$enddate), (int)strtotime('Y',$enddate))); 
    //$kso = Kso::where_fleet_id($id)->where_actived(1)->first();
    $kso = Kso::where_fleet_id($id)->where_actived(1)->first();
    $fleet = Fleet::find($id);
       
    //$financial_fleet = DB::table('financial_report_bykso')->where('kso_id','=',$kso->id)->first();
    //$financial_fleet_part = DB::table('wo_financial_report_bykso')->where('kso_id','=',$kso->id)->first();
    if($cont=='download'){
      $financialdetail = $this->infoSaldo($kso->id, $enddate);
    }else{
      $financialdetail =  false;
    }
      $fleet_ks = 0;
      $fleet_cicilan_ks = 0;
      $fleet_tabungan_sparepart = 0;
      $fleet_cicilan_dp_kso = 0;
      $fleet_cicilan_sparepart = 0;
      $fleet_dp_sparepart = 0;
      $total_pemakaian_part = 0;

    if($financialdetail){
      $fleet_ks = $financialdetail->ks;
      $fleet_cicilan_ks = $financialdetail->cicilan_ks;
      $fleet_tabungan_sparepart = $financialdetail->tabungan_sparepart;
      $fleet_cicilan_dp_kso = $financialdetail->cicilan_dp_kso;
      $fleet_cicilan_sparepart = $financialdetail->cicilan_sparepart;
      $fleet_dp_sparepart = $financialdetail->hutang_dp_sparepart; 
      $total_pemakaian_part = $financialdetail->pemakaian_part;
    }
    
    /*
    if($financial_fleet_part)
    {
      $total_pemakaian_part = $financial_fleet_part->pemakaian_part;
    }
    */

    $fleetinfo = array(
                  'id' => $fleet->id, 
                  'police_number' => $fleet->police_number,
                  'nip' => Driver::find($kso->bravo_driver_id)->nip,
                  'bravo' => Driver::find($kso->bravo_driver_id)->name,
                  'taxi_number' => $fleet->taxi_number,
                  'total_ks' => $fleet_ks,
                  'pembayaran_ks' => $fleet_cicilan_ks,
                  'tab_sparepart' => $fleet_tabungan_sparepart,
                  'dp_kso' => $kso->dp,
                  'hutang_dp_kso' => $kso->sisa_dp,
                  'pem_hutang_dp_kso' => $fleet_cicilan_dp_kso,
                  'pem_sparepart' => $total_pemakaian_part,
                  //'saldo_unit' => (($fleet_cicilan_ks ) - ($fleet_ks)) + (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part ), 0,',','.'),
                  'pembayaran_sparepart' => $fleet_cicilan_sparepart + $fleet_dp_sparepart,
                  'status'  => ($fleet->fg_blocked == 1 || $fleet->fg_bengkel == 1) ? 'Blocked' : 'Ready',
                  'saldo_dp' => ($kso->sisa_dp - $fleet_cicilan_dp_kso),
      );
   
    $reports = DB::table('financial_report_daily')
              ->where('kso_id','=',$kso->id)
              ->where('operasi_time','>=', $startdate)
              ->where('operasi_time','<=', $enddate)
              ->order_by('operasi_time','asc')
              ->get();

    $this->data['reports'] = $reports;
    $this->data['detailarmada'] = $fleetinfo;

    $this->data['startdate'] = $startdate;
    $this->data['enddate']  = $enddate;

    if($cont=='tampil'){
      return View::make('themes.modul.'.$this->views.'.kartukontrolarmada',$this->data);
    }else if($cont=='download'){
      return View::make('themes.modul.'.$this->report.'.printkartukontrol',$this->data);
    }
      return View::make('themes.modul.'.$this->views.'.kartukontrolarmada',$this->data);
  }

  public function get_sbap($id=false)
  {
    if(!$id) return false;
    $infobap = Bap::find($id);

    $fleet_id = $infobap->fleet_id;
    $driver_id = $infobap->driver_id;

    //informasi ks pengemudi
    $financial_driver = DB::table('financial_report_monthly_driver')->where('driver_id','=',$driver_id)->order_by('operasi_time','desc')->skip(1)->take(3)->get();
    $financial_fleet = DB::table('financial_report_monthly_fleet')->where('fleet_id','=',$fleet_id)->order_by('operasi_time','desc')->skip(1)->take(3)->get();
    
    //array dari bernagai informasi
    /* informasi dari bulan 1 dan 2 bulan ke belangang di mulai dari 1-3 
    $month1 = date('n-Y', strtotime($infobap->date));
    $month2 = date('n-Y',(strtotime('-1 month',strtotime($infobap->date))));
    $month3 = date('n-Y',(strtotime('-2 month',strtotime($infobap->date))));
    echo $month1.$month2.$month3;*/

    $this->data['financial_driver'] = $financial_driver;
    $this->data['financial_fleet'] = $financial_driver;
    $this->data['bap'] = $infobap;
    return View::make('themes.modul.'.$this->views.'.sbap',$this->data);
  }



  public function get_fleetskso()
  {     
    return View::make('themes.modul.'.$this->views.'.fleetsground',$this->data);
  }

  public function get_ksolist()
  {
    $pool_id = Auth::user()->pool_id;
    //$fleets = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('ksos.actived', '=', 1)->where('fleets.pool_id', '=', Auth::user()->pool_id)->order_by('fleets.taxi_number','asc')->get(array('fleets.taxi_number', 'fleets.id'));
    
    $fleets = Kso::join('fleets', 'fleets.id', '=', 'ksos.fleet_id')->where('fleets.pool_id', '=', Auth::user()->pool_id)->order_by('fleets.taxi_number','asc')->get(array('fleets.taxi_number', 'ksos.id', 'ksos.kso_number'));

    
    $fleetdata = array_map(function($object) {
             return $object->to_array();
    }, $fleets);
        
    $data['fleets'] = $fleetdata;
    return json_encode($data);
    
    //var_dump($fleets);
  }

  public function post_searchFleetkso()
  {
    $jsondata = Input::json();
    $pool_id = Auth::user()->pool_id;
    $fleets = Kso::join('fleets', 'fleets.id', '=', 'ksos.fleet_id')->where('fleets.taxi_number','LIKE','%'.$jsondata->taxi_number.'%')->where('fleets.pool_id', '=', $pool_id)->order_by('fleets.taxi_number','asc')->get(array('fleets.taxi_number', 'ksos.id', 'ksos.kso_number'));
    $fleetdata = array_map(function($object) {
             return $object->to_array();
    }, $fleets);
        
    $data['fleets'] = $fleetdata;
    return json_encode($data);
  }

  public function get_findbyIdFleetkso($id=false)
  {
    if(!$id) return false;
    
    
    $kso = Kso::find($id);
    $fleet = Fleet::find($kso->fleet_id);

    $financial_fleet = DB::table('financial_report_bykso')->where('kso_id','=',$kso->id)->first();
    $financial_fleet_part = DB::table('wo_financial_report_bykso')->where('kso_id','=',$kso->id)->first();

      $fleet_ks = 0;
      $fleet_cicilan_ks = 0;
      $fleet_tabungan_sparepart = 0;
      $fleet_cicilan_dp_kso = 0;
      $fleet_cicilan_sparepart = 0;
      $fleet_dp_sparepart = 0;

    if($financial_fleet){
      $fleet_ks = $financial_fleet->ks;
      $fleet_cicilan_ks = $financial_fleet->cicilan_ks;
      $fleet_tabungan_sparepart = $financial_fleet->tabungan_sparepart;
      $fleet_cicilan_dp_kso = $financial_fleet->cicilan_dp_kso;
      $fleet_cicilan_sparepart = $financial_fleet->cicilan_sparepart;
      $fleet_dp_sparepart = $financial_fleet->hutang_dp_sparepart; 
    }
    
    $total_pemakaian_part = 0;
    if($financial_fleet_part)
    {
      $total_pemakaian_part = $financial_fleet_part->pemakaian_part;
    }

    $fleetinfo = array(
                  'id' => $kso->id, 
                  'fleet_id' => $kso->fleet_id,
                  'police_number' => $fleet->police_number,
                  'bravo' => Driver::find($kso->bravo_driver_id)->name,
                  'taxi_number' => $fleet->taxi_number,
                  'total_ks' => number_format($fleet_ks, 0,',','.'),
                  'pembayaran_ks' => number_format($fleet_cicilan_ks, 0,',','.'),
                  'tab_sparepart' => number_format($fleet_tabungan_sparepart, 0,',','.'),
                  'dp_kso' => number_format($kso->dp, 0,',','.'),
                  'hutang_dp_kso' => number_format($kso->sisa_dp, 0,',','.'),
                  'pem_hutang_dp_kso' => number_format($fleet_cicilan_dp_kso, 0,',','.'),
                  'pem_sparepart' => number_format($total_pemakaian_part, 0,',','.'),
                  'saldo_unit' => number_format((($fleet_cicilan_ks ) - ($fleet_ks)) + (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part ), 0,',','.'),
                  'pembayaran_sparepart' => number_format(($fleet_cicilan_sparepart + $fleet_dp_sparepart), 0,',','.'),
                  'status'  => ($fleet->fg_blocked == 1 || $fleet->fg_bengkel == 1) ? 'Blocked' : 'Ready',
                  'saldo_dp' => ($kso->sisa_dp - $fleet_cicilan_dp_kso),
      );
   
    $returndata = array(

                  'fleetinfo' => $fleetinfo,
    );
    return json_encode($returndata);
  }

  public function get_kartukontrolarmadakso($id=false)
  {
    $startdate = Input::get('datestart', false);
    $enddate = Input::get('dateend', false);
    $cont = Input::get('con', false);

    if(!$id) return false;
    if(!$startdate) $startdate = date('Y-m-d', mktime(0,0,0,(int) strtotime('m',$startdate),1,(int) strtotime('Y',$enddate))); 
    if(!$enddate) $enddate = date('Y-m-d', (int)mktime(0,0,0,strtotime('m',$enddate), (int) strtotime('j',$enddate), (int)strtotime('Y',$enddate))); 
    //$kso = Kso::where_fleet_id($id)->where_actived(1)->first();
    $kso = Kso::find($id);
    $fleet = Fleet::find($kso->fleet_id);
       
    $financial_fleet = DB::table('financial_report_bykso')->where('kso_id','=',$kso->id)->first();
    $financial_fleet_part = DB::table('wo_financial_report_bykso')->where('kso_id','=',$kso->id)->first();

      $fleet_ks = 0;
      $fleet_cicilan_ks = 0;
      $fleet_tabungan_sparepart = 0;
      $fleet_cicilan_dp_kso = 0;
      $fleet_cicilan_sparepart = 0;
      $fleet_dp_sparepart = 0;

    if($financial_fleet){
      $fleet_ks = $financial_fleet->ks;
      $fleet_cicilan_ks = $financial_fleet->cicilan_ks;
      $fleet_tabungan_sparepart = $financial_fleet->tabungan_sparepart;
      $fleet_cicilan_dp_kso = $financial_fleet->cicilan_dp_kso;
      $fleet_cicilan_sparepart = $financial_fleet->cicilan_sparepart;
      $fleet_dp_sparepart = $financial_fleet->hutang_dp_sparepart; 
    }
    
    $total_pemakaian_part = 0;
    if($financial_fleet_part)
    {
      $total_pemakaian_part = $financial_fleet_part->pemakaian_part;
    }

    $fleetinfo = array(
                  'id' => $fleet->id, 
                  'police_number' => $fleet->police_number,
                  'nip' => Driver::find($kso->bravo_driver_id)->nip,
                  'bravo' => Driver::find($kso->bravo_driver_id)->name,
                  'taxi_number' => $fleet->taxi_number,
                  'total_ks' => number_format($fleet_ks, 0,',','.'),
                  'pembayaran_ks' => number_format($fleet_cicilan_ks, 0,',','.'),
                  'tab_sparepart' => number_format($fleet_tabungan_sparepart, 0,',','.'),
                  'dp_kso' => number_format($kso->dp, 0,',','.'),
                  'hutang_dp_kso' => number_format($kso->sisa_dp, 0,',','.'),
                  'pem_hutang_dp_kso' => number_format($fleet_cicilan_dp_kso, 0,',','.'),
                  'pem_sparepart' => number_format($total_pemakaian_part, 0,',','.'),
                  'saldo_unit' => number_format((($fleet_cicilan_ks ) - ($fleet_ks)) + (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part ), 0,',','.'),
                  'pembayaran_sparepart' => number_format(($fleet_cicilan_sparepart + $fleet_dp_sparepart), 0,',','.'),
                  'status'  => ($fleet->fg_blocked == 1 || $fleet->fg_bengkel == 1) ? 'Blocked' : 'Ready',
                  'saldo_dp' => ($kso->sisa_dp - $fleet_cicilan_dp_kso),
      );
   

    $reports = DB::table('financial_report_daily')
              ->where('kso_id','=',$kso->id)
              ->where('operasi_time','>=', $startdate)
              ->where('operasi_time','<=', $enddate)
              ->order_by('operasi_time','asc')
              ->get();

    $this->data['reports'] = $reports;
    $this->data['detailarmada'] = $fleetinfo;

    if($cont=='tampil'){
      return View::make('themes.modul.'.$this->views.'.kartukontrolarmada',$this->data);
    }else if($cont=='download'){
      return View::make('themes.modul.'.$this->report.'.printkartukontrol',$this->data);
    }
      return View::make('themes.modul.'.$this->views.'.kartukontrolarmada',$this->data);
  }

  /*******************************************/
    /**** REPORT HERE **************************/
    /*******************************************/
    public function get_reportdaily($date=false)
    { 
      Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Read report', true);

      if(!$date) $date = date('Y-m-d');
      $timestamp = strtotime($date);

      $shifts = Shift::all();

      $this->data['shifts'] = Koki::to_dropdown($shifts,'id','shift');

      $this->data['report_daily'] = DB::table('financial_report_daily')->where_pool_id(Auth::user()->pool_id)->get();
      //return json_encode($report_daily);
      return View::make('themes.modul.'.$this->report.'.dailyreport',$this->data);
    }

    public function get_reportdailyjson($date=false)
    { 
      if(!$date) $date = date('Y-m-d');
      $timestamp = strtotime($date);


      //$report_daily = DB::table('financial_report_daily')->where_pool_id(Auth::user()->pool_id)->get();
      $tanggalKSO =  Myfungsi::fulldate($timestamp);

      $returndata = array(
                      'tanggal' => $tanggalKSO,
                      'date'  => $date,
                    );
      return json_encode($returndata);
    }
    
    public function post_loaddatadaily()
    { 
      $date = Input::get('dateops', date('Y-m-d'));
      $shift_id = Input::get('shift_id');
      $page = Input::get('page');
      $limit = Input::get('rows');
      $sidx = Input::get('sidx', 'id');
      $sord = Input::get('sord');

      //$count = Driver::count();
      $count = DB::table('financial_report_daily')->where('shift_id','=',$shift_id)->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->count();
      
      
      if( $count > 0 ) {
        $total_pages = ceil($count / $limit);
      } else {
        $total_pages = 0;
      } 
     
      if ($page > $total_pages) $page = $total_pages;

      $start = $limit * $page - $limit; 

      if($start < 0) $start = 0;

      $financials =  DB::table('financial_report_daily')->where('shift_id','=',$shift_id)->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->order_by($sidx,$sord)->skip($start)->take($limit)->get();
      $responce['page'] = $page;
      $responce['total'] = $total_pages;
      $responce['records'] = $count;
      $no= $start + 0;
      foreach ($financials as $finan) {
        $no++;
        $responce['rows'][] = array(
                                'no' => $no ,
                                'taxi_number' => $finan->taxi_number ,
                                'nip' => $finan->nip ,
                                'name' => $finan->name ,
                                'checkin_time' => $finan->checkin_time ,
                                'finance_time' => $finan->finance_time ,
                                'shift_id' => Shift::find($finan->shift_id)->shift ,
                                'setoran_cash' => $finan->setoran_cash ,
                                'setoran_wajib' => $finan->setoran_wajib ,
                                'tabungan_sparepart' => $finan->tabungan_sparepart ,
                                'denda' => $finan->denda ,
                                'potongan' => $finan->potongan ,
                                'cicilan_sparepart' => $finan->cicilan_sparepart ,
                                'cicilan_ks' => $finan->cicilan_ks ,
                                'biaya_cuci' => $finan->biaya_cuci ,
                                'iuran_laka' => $finan->iuran_laka ,
                                'cicilan_dp_kso' => $finan->cicilan_dp_kso ,
                                'cicilan_hutang_lama' => $finan->cicilan_hutang_lama ,
                                //'ks' => $finan->ks ,
                                'ks' => $finan->setoran_cash - ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                  + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                  + $finan->hutang_dp_sparepart ) - $finan->potongan ),
                                'cicilan_lain' => $finan->cicilan_lain ,
                                'hutang_dp_sparepart' => $finan->hutang_dp_sparepart ,
                                'operasi_status_id' => $finan->kode ,
                                'total' => ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                  + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                  + $finan->hutang_dp_sparepart ) ),
                                'setoranops' => ( $finan->setoran_cash - ($finan->biaya_cuci + $finan->iuran_laka)),
                                'finance_check_user_id' => User::find($finan->finance_check_user_id)->fullname,
                                );
      }

      return json_encode($responce);
       /**/
    }

    public function get_sumreport($date=false, $shift_id)
    {
      if(!$date) $date = date('Y-m-d');
      $checkcount = DB::table('financial_report_summary')->where('shift_id','=',$shift_id)->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->count();
      $finan =  DB::table('financial_report_summary')->where('shift_id','=',$shift_id)->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->first();
      if($checkcount > 0){
      $returndata = array(
                                'setoran_cash' => $finan->setoran_cash ,
                                'setoran_wajib' => $finan->setoran_wajib ,
                                'tabungan_sparepart' => $finan->tabungan_sparepart ,
                                'denda' => $finan->denda ,
                                'potongan' => $finan->potongan ,
                                'cicilan_sparepart' => $finan->cicilan_sparepart ,
                                'cicilan_ks' => $finan->cicilan_ks ,
                                'biaya_cuci' => $finan->biaya_cuci ,
                                'iuran_laka' => $finan->iuran_laka ,
                                'cicilan_dp_kso' => $finan->cicilan_dp_kso ,
                                'cicilan_hutang_lama' => $finan->cicilan_hutang_lama ,
                                //'ks' => $finan->ks ,
                                'ks' => $finan->setoran_cash - ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                  + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                  + $finan->hutang_dp_sparepart ) - $finan->potongan ),
                                'cicilan_lain' => $finan->cicilan_lain ,
                                'hutang_dp_sparepart' => $finan->hutang_dp_sparepart ,
                                'total' => ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                  + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                  + $finan->hutang_dp_sparepart )),
                                'setoranops' => ( $finan->setoran_cash - ($finan->biaya_cuci + $finan->iuran_laka)),
                                );
        }
        else{

        $returndata = array(
                                'setoran_cash' => 0 ,
                                'setoran_wajib' => 0 ,
                                'tabungan_sparepart' => 0 ,
                                'denda' => 0 ,
                                'potongan' => 0 ,
                                'cicilan_sparepart' => 0 ,
                                'cicilan_ks' => 0 ,
                                'biaya_cuci' => 0 ,
                                'iuran_laka' => 0 ,
                                'cicilan_dp_kso' => 0 ,
                                'cicilan_hutang_lama' => 0 ,
                                'ks' => 0 ,
                                'cicilan_lain' => 0 ,
                                'hutang_dp_sparepart' => 0 ,
                                'total'=>0,
                                'setoranops' => 0,
          );
        }
        return json_encode($returndata);
    }

    public function infoSaldo($kso_id, $date)
    {        
      $saldo = DB::first('select 
                cin.id,
                cin.kso_id,
                cin.fleet_id,
                cin.operasi_time,
                a.pool_id,
                a.bravo_driver_id, 
                a.charlie_driver_id,
                /* f.taxi_number, */
                /* KS */
                sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
                sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
                /* SP */
                sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
                sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
                sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
                sp.pemakaian_part,
                /*  DP */
                sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
                /* saldo saldo */
                (sum(if( cf.financial_type_id = 11, cf.amount, 0)) - sum(if( cf.financial_type_id = 6, cf.amount, 0)) ) as saldoks,

                ((sum(if( cf.financial_type_id = 2, cf.amount, 0)) + sum(if( cf.financial_type_id = 5, cf.amount, 0)) + sum(if( cf.financial_type_id = 13, cf.amount, 0)))) - sp.pemakaian_part as saldosp

                from checkins cin 
                left join 
                (
                  select cfx.financial_type_id, cfx.amount, cfx.checkin_id from checkin_financials cfx
                ) as cf on ( cin.id = cf.checkin_id ) 
                join (
                  select kso.id, kso.pool_id, kso.bravo_driver_id, kso.charlie_driver_id from ksos kso where kso.actived = 1 
                ) as a ON a.id = cin.kso_id 
                left join (
                  select 
                    wo.id,wo.kso_id,wo.inserted_date_set,
                    sum((part.qty * part.price)) as pemakaian_part
                    from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id )
                    where wo.status = 3 and part.telah_dikeluarkan = 1 and wo.beban = 0 
                    and wo.inserted_date_set <= ?
                    group by wo.kso_id 
                ) as sp ON ( sp.kso_id = cin.kso_id)
                /* join (
                  select 
                    fleets.taxi_number, fleets.id from fleets
                ) as f ON (f.id = cin.fleet_id) */
                where cin.operasi_time <= ? and cin.kso_id = ?
                group by cin.kso_id', array($date, $date, $kso_id ));


      return $saldo;
    }

    public function infoSaldopengemudi($driver_id, $date)
    {        
      $saldo = DB::first('select 
                cin.id,
                cin.kso_id,
                cin.fleet_id,
                cin.driver_id,
                cin.operasi_time,
                f.taxi_number,
                /* KS */
                sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
                sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
                /* SP */
                sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
                sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
                sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
                /* sp.pemakaian_part, */
                /*  DP */
                sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
                /* saldo saldo */
                (sum(if( cf.financial_type_id = 11, cf.amount, 0)) - sum(if( cf.financial_type_id = 6, cf.amount, 0)) ) as saldoks,

                ((sum(if( cf.financial_type_id = 2, cf.amount, 0)) + sum(if( cf.financial_type_id = 5, cf.amount, 0)) + sum(if( cf.financial_type_id = 13, cf.amount, 0)))) - sp.pemakaian_part as saldosp

                from checkins cin 
                left join 
                (
                  select cfx.financial_type_id, cfx.amount, cfx.checkin_id from checkin_financials cfx
                ) as cf on ( cin.id = cf.checkin_id ) 
                
                join (
                  select 
                    fleets.taxi_number, fleets.id from fleets
                ) as f ON (f.id = cin.fleet_id) */
                where cin.operasi_time <= ? and cin.driver_id = ?
                group by cin.driver_id', array($date, $driver_id ));


      return $saldo;
    }
}