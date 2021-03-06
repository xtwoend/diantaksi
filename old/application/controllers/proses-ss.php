<?php

class Proses_Controller extends Base_Controller {

	public $restful = true;
  public $views = 'proses';

	public function get_index()
	{		
    return View::make('themes.modul.'.$this->views.'.pengemudiblock',$this->data);
	}
  
  public function get_blockingfleet($date=false)
  {
    if(!$date) $date = date('Y-m-d');
    $timestamp = strtotime($date);
      //list armada on checkouts
      $fleets = Checkout::join('fleets as f', 'f.id', '=', 'checkouts.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkouts.pool_id','=',Auth::user()->pool_id)
                ->where('checkout_step_id','=', 5)
                ->get(array('f.taxi_number','checkouts.id'));
      $fleetdata = array_map(function($object) {
             return $object->to_array();
      }, $fleets);
        
      $data['fleets'] = $fleetdata;
      return json_encode($data);
  }
  public function get_blockingdriver($date = false)
  {
    if(!$date) $date = date('Y-m-d');
    $timestamp = strtotime($date);

    //list pengemudi di block
     $drivers = Checkout::join('drivers as d', 'd.id', '=', 'checkouts.driver_id' )
                ->where_operasi_time($date)
                ->where('checkouts.pool_id','=',Auth::user()->pool_id)
                //->where('checkout_step_id','=', 5)
                ->where('d.fg_blocked', '=', 1)
                ->get(array('d.name','d.nip','checkouts.id'));
    /*
    $drivers = Driver::where('pool_id', '=', Auth::user()->pool_id)
                      ->where('fg_blocked', '=', 1)
                      ->get(array('nip','name','id'));
    */
     $driverdata = array_map(function($object) {
             return $object->to_array();
      }, $drivers);
        
      $data['drivers'] = $driverdata;
      return json_encode($data);
  }
  /*
  public function post_searchFleet()
  {
    $jsondata = Input::json();

    $date = $jsondata->date;
    $timestamp = strtotime($date);

    //list armada on checkouts
      $fleets = Checkout::join('fleets as f', 'f.id', '=', 'checkouts.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkouts.pool_id','=',Auth::user()->pool_id)
                ->where('checkout_step_id','=', 5)
                ->where('f.taxi_number','LIKE', '%'.$jsondata->taxi_number.'%')
                ->get(array('f.taxi_number','checkouts.id'));

      $fleetdata = array_map(function($object) {
             return $object->to_array();
      }, $fleets);
    
    $data['fleets'] = $fleetdata;
    return json_encode($data);
  }
  */
  public function post_searchDriver()
  {
    $jsondata = Input::json();

    $date = $jsondata->date;
    $timestamp = strtotime($date);

    $drivers = Checkout::join('drivers as d', 'd.id', '=', 'checkouts.driver_id' )
                ->where_operasi_time($date)
                ->where('checkouts.pool_id','=',Auth::user()->pool_id)
                //->where('checkout_step_id','=', 5)
                ->where('d.fg_blocked', '=', 1)
                ->where('d.nip','LIKE', '%'.$jsondata->taxi_number.'%')
                ->get(array('d.name','d.nip','checkouts.id'));

      $driverdata = array_map(function($object) {
             return $object->to_array();
      }, $drivers);
    
    $data['drivers'] = $driverdata;
    return json_encode($data);
  }

  public function get_findbyidFleetBlocking($id=false)
  {
    if(!$id) return false;
    
    $checkout = Checkout::find($id);
    $fleet = Fleet::find($checkout->fleet_id);
    $driver = Driver::find($checkout->driver_id);
    $kso = Kso::find($checkout->kso_id);
       
    $financial_driver = DB::table('financial_report_driver')->where('driver_id','=',$checkout->driver_id)->first();
    $financial_fleet = DB::table('financial_report_bykso')->where('kso_id','=',$checkout->kso_id)->first();
    $financial_fleet_part = DB::table('wo_financial_report_bykso')->where('kso_id','=',$checkout->kso_id)->first();

      $fleet_ks = 0;
      $fleet_cicilan_ks = 0;
      $fleet_tabungan_sparepart = 0;
      $fleet_cicilan_db_kso = 0;
      $fleet_cicilan_sparepart = 0;
      $fleet_dp_sparepart = 0;

    if($financial_fleet){
      $fleet_ks = $financial_fleet->ks;
      $fleet_cicilan_ks = $financial_fleet->cicilan_ks;
      $fleet_tabungan_sparepart = $financial_fleet->tabungan_sparepart;
      $fleet_cicilan_db_kso = $financial_fleet->cicilan_dp_kso;
      $fleet_cicilan_sparepart = $financial_fleet->cicilan_sparepart;
      $fleet_dp_sparepart = $financial_fleet->hutang_dp_sparepart; 
    }
    
    $total_pemakaian_part = 0;
    if($financial_fleet_part)
    {
      $total_pemakaian_part = $financial_fleet_part->pemakaian_part;
    }

    //check hutang lama  
    $hutang_lama = Driverfinancial::where_driver_id($checkout->driver_id)->where_financial_type_id('18')->first();
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

    $fleetinfo = array(
                  'police_number' => $fleet->police_number,
                  'bravo' => Driver::find($kso->bravo_driver_id)->name,
                  'taxi_number' => $fleet->taxi_number,
                  'total_ks' => $fleet_ks,
                  'pembayaran_ks' => $fleet_cicilan_ks,
                  'tab_sparepart' => $fleet_tabungan_sparepart,
                  'hutang_dp_kso' => $kso->sisa_dp,
                  'pem_hutang_dp_kso' => $fleet_cicilan_db_kso,
                  'pem_sparepart' => $total_pemakaian_part,
                  'saldo_unit' => number_format((($fleet_cicilan_ks+$fleet_cicilan_db_kso) - ($fleet_ks+$kso->sisa_dp)) + (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part ), 2,',','.'),
                  'pembayaran_sparepart' => $fleet_cicilan_sparepart + $fleet_dp_sparepart,
                  'status'  => ($fleet->fg_blocked == 1 || $fleet->fg_bengkel == 1) ? 'Blocked' : 'Ready',
      );
    $driverinfo = array(
                  'id'  => $driver->id,
                  'name'  => $driver->name,
                  'nip'   => $driver->nip,
                  'saldo_ks_driver' => $driver_ks,
                  'pembayaran_ks_driver' => $driver_cicilan_ks,
                  'hutang_lama' => $tagihan_hutang_lama,
                  'cicilan_hutang_lama' => $cicilan_hutang_lama,
                  'status' => ($driver->fg_blocked == 1) ? 'Blocked' : 'Ok',
      );
    $bapinfo = array();
    $baps = Bap::where_driver_id($checkout->driver_id)->order_by('date','desc');
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

    $time = Myfungsi::sysdate();
    //date ajustment
    //strtotime($checkout->operasi_time);
    $t = strtotime($checkout->operasi_time ." 7 hours 0 seconds");
    $time_proses = false;
    if($time >= $t)
    {
       $time_proses = true;
    }

    $returndata = array(
                  'checkout_id' => $id,
                  'fleetinfo' => $fleetinfo,
                  'driverinfo' => $driverinfo,
                  'bapinfo' => $bapinfo,
                  'countbap' => $countbap,
                  'time_proses' => $time_proses,     
    );
    return json_encode($returndata);
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

  public function get_kartukontrolpengemudi($id=false)
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
    return View::make('themes.modul.'.$this->views.'.kartukontrolpengemudi',$this->data);
  }

  public function get_formbap($id=false)
  {
    Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Open Form BAP', true);
        
    if(!$id) return false;
    $checkout = Checkout::find($id);
    
    //membuat tidak tapil form jika belum waktunya
    $time = Myfungsi::sysdate();
    //date ajustment
    $t = strtotime($checkout->operasi_time ." 7 hours 0 seconds");
    if($time <= $t)
    {
       return false;
    }


    $financial_fleet = DB::table('financial_report_bykso')->where('kso_id','=',$checkout->kso_id)->first();
    $financial_fleet_part = DB::table('wo_financial_report_bykso')->where('kso_id','=',$checkout->kso_id)->first();
    
    $kso = Kso::find($checkout->kso_id);
    $driver_status = 'Bravo';
    if($kso->bravo_driver_id !== $checkout->driver_id) { $driver_status = 'Charlie'; }

      $fleet_ks = 0;
      $fleet_cicilan_ks = 0;
      $fleet_tabungan_sparepart = 0;
      $fleet_cicilan_db_kso = 0;
      $fleet_cicilan_sparepart = 0;
      $fleet_dp_sparepart = 0;

    if($financial_fleet){
      $fleet_ks = $financial_fleet->ks;
      $fleet_cicilan_ks = $financial_fleet->cicilan_ks;
      $fleet_tabungan_sparepart = $financial_fleet->tabungan_sparepart;
      $fleet_cicilan_db_kso = $financial_fleet->cicilan_dp_kso;
      $fleet_cicilan_sparepart = $financial_fleet->cicilan_sparepart;
      $fleet_dp_sparepart = $financial_fleet->hutang_dp_sparepart; 
    }
    
    $total_pemakaian_part = 0;
    if($financial_fleet_part)
    {
      $total_pemakaian_part = $financial_fleet_part->pemakaian_part;
    }

    $maxno = Bap::max('id');
    //MyFungsi::numberComplate($maxno,5)
    $nosurat = 'DT-xxxxxx/BAP/'.Fleet::find($checkout->fleet_id)->taxi_number.'/'.date('m').'/'. date('Y');

    $this->data['saldo_sparepart'] = (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part );
    $this->data['saldo_ks'] = ($fleet_ks - $fleet_cicilan_ks);
    $this->data['saldo_unit'] = ($fleet_ks - $fleet_cicilan_ks) + (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part );
    $this->data['nosurat'] = $nosurat;
    $this->data['checkout'] = $checkout;
    $this->data['listpelanggaran'] = Stdbap::all();
    $this->data['options'] = array('6'=>'Cicilan KS');
    $this->data['infodriver'] = Driver::find($checkout->driver_id);
    $this->data['listkewajibans'] = Kewajiban::join('financial_types as ft','ft.id', '=','kewajibans.financial_type_id')->where_fleet_id($checkout->fleet_id)->where_driver_id($checkout->driver_id)->get(); 
    $this->data['status_pengemudi'] = $driver_status;
    $kep = Keputusanbap::all();

    $pelanggaran = Blocked::where_driver_id($checkout->driver_id)->where_fleet_id($checkout->fleet_id)->where_proses(0)->get();
    $pel_id = array();
    foreach ($pelanggaran as $pel) {
      array_push($pel_id, $pel->std_bap_id);
    }

    $optionskeputusan = array();
    foreach ($kep as $v) {
      $optionskeputusan[$v->id] = $v->keputusan;
    }
    
    $this->data['keputusans'] = $optionskeputusan;
    $this->data['checklistpelanggaran'] = $pel_id;

    //return View::make('themes.modul.'.$this->views.'.formbap',$this->data);
    return View::make('themes.modul.'.$this->views.'.suratbap',$this->data);
  
  }

  public function post_simpanbap()
  { 
    Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Simpan Proses BAP', true);
    
      $lastnumber = Bap::max('id'); 
      $num    = myFungsi::numberComplate(($lastnumber + 1),5); 

    $total_amount = Input::get('total_amount');
    $amount = Input::get('amount');

    foreach (Input::get('financial_type_id') as $key => $val) {
      if($val == 6){
        $besar_ks = $total_amount[$key];
        $bayar_ks = $amount[$key];
      }

      $ke = Kewajiban::where_fleet_id(Input::get('fleet_id'))
                  ->where_driver_id(Input::get('driver_id'))
                  ->where_financial_type_id($val)
                  ->first();
           if($ke)
           {
              $ke->amount = $amount[$key];
              $ke->total_amount = $total_amount[$key];
              $ke->save();
           }else{
              Kewajiban::create(array(
                  'fleet_id' => Input::get('fleet_id'),
                  'driver_id' => Input::get('driver_id'),
                  'financial_type_id' =>  $val,
                  'amount' => $amount[$key],
                  'total_amount' => $total_amount[$key],
                ));
           }
    }
 
    $fleet_id = Input::get('fleet_id');
    $bap_number = 'DT-'.$num.'/BAP/'.Fleet::find($fleet_id)->taxi_number.'/'.date('m').'/'. date('Y');
    $driver_id = Input::get('driver_id');
    $driver_status = Input::get('driver_status');
    $keputusan_id = Input::get('keputusan_id');
    $pool_id = Input::get('pool_id');
    $sum_sparepart = Input::get('sum_sparepart');
    $sum_ks = Input::get('sum_ks');
    $sum_akhir_unit = Input::get('sum_akhir_unit');
    $lampiran = Input::get('lampiran');
    $std_bap_id = implode(',', Input::get('pelanggaran'));
    $ket_bap_other = Input::get('ket_bap_other');
    $keterangan = Input::get('keterangan');
    $solusi = Input::get('solusi');
    $saksi1_name = Input::get('saksi1_name');
    $saksi1_nik = Input::get('saksi1_nik');
    $saksi1_jabatan = Input::get('saksi1_jabatan');
    $saksi2_name = Input::get('saksi2_name');
    $saksi2_nik = Input::get('saksi2_nik');
    $saksi2_jabatan = Input::get('saksi2_jabatan');



    $bap = Bap::create(array(
            'date' => date('Y-m-d'),
            'bap_number' => $bap_number,
            'fleet_id' => $fleet_id,
            'driver_id' => $driver_id,
            'driver_status' => $driver_status,
            'keputusan_id' => $keputusan_id,
            'pool_id' => $pool_id,
            'sum_sparepart' => $sum_sparepart,
            'sum_ks' => $sum_ks,
            'sum_akhir_unit' => $sum_akhir_unit,
            'lampiran' => $lampiran,
            'std_bap_id' => $std_bap_id,
            'ket_bap_other' => $ket_bap_other,
            'keterangan' => $keterangan,
            'solusi' => $solusi,
            'saksi1_name' => $saksi1_name,
            'saksi1_nik' => $saksi1_nik,
            'saksi1_jabatan' => $saksi1_jabatan,
            'saksi2_name' => $saksi2_name,
            'saksi2_nik' => $saksi2_nik,
            'saksi2_jabatan' => $saksi2_jabatan,
            'user_id' => Auth::user()->id,
            'last_update' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
            'besar_ks' => $besar_ks,
            'bayar_ks' => $bayar_ks,
            
    ));
    
    return Redirect::to('proses'); 
  }


  public function get_openblock()
  {
    $this->data['show'] = false;
    return View::make('themes.modul.'.$this->views.'.openblock',$this->data);
  }

  public function post_openblock()
  {
    $bap_number = Input::get('bap_number');

    $this->data['bap_number'] = $bap_number;
    $this->data['bap'] = Bap::where_bap_number($bap_number)->first();
    $this->data['show'] = true;
    return View::make('themes.modul.'.$this->views.'.openblock',$this->data);
  }

  public function post_otorisasi()
  {
    $input = Input::json();
    $username = $input->username;
    $password = $input->password;
    $bap_id   = $input->bap_id;

    $ver2 = User::where('username','=',$username)->first();
    if($ver2){
      if (Hash::check($password , $ver2->password))
      {
        if($ver2->id !== Auth::user()->id)
        {
            //melihat driver_id dan fleet_id pada bap 
            $bap = Bap::find($bap_id);
            //create log open block

            try {
              $open = Openblocking::create(array(
                'bap_id' => $bap_id,
                'tanggal' => date('Y-m-d H:i:s'),
                'otorisasi1_id' => Auth::user()->id,
                'otorisasi2_id' => $ver2->id,
              ));
              if($open){
                $driver = Driver::find($bap->driver_id);
                $driver->fg_blocked = 0;
                $driver->save();   

                $setor = Fleet::find($bap->fleet_id);
                $setor->fg_setor = 0;
                $setor->save();             

                return json_encode(array('status'=> true ,'msg'=>'Otorisasi open block berhasil!'));
              }
            } catch (Exception $e) {
              return json_encode(array('status'=> true ,'msg'=>'Otorisasi sudah dilakukan!'));
            }
            
            
        }else{
            return json_encode(array('status'=> false ,'msg'=>'Otorisasi harus orang yang berbeda!'));
        }
      }
    }
    
    return json_encode(array('status'=> false ,'msg'=>'Otorisasi kedua gagal!'));
  }
}