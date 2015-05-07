<?php
class Financials_Controller extends Base_Controller
{

    public $restful = true;
    public $views = 'financials';
    public $report = 'financials.report';

    public function get_index()
    {
        return View::make('themes.modul.'.$this->views.'.form',$this->data);
    }
    
    public function get_allfleets($date=false)
    {   
        if(!$date) $date = date('Y-m-d');

        $fleets = Checkin::join('fleets','fleets.id', '=', 'checkins.fleet_id')
                ->where('checkins.pool_id', '=', Auth::user()->pool_id)
                ->where('checkins.operasi_time','=',$date)
                ->where_in('checkins.checkin_step_id',array(12,2))
                ->order_by('fleets.taxi_number','asc')
                ->get(array('fleets.taxi_number','checkins.id'));

        $fleetdatas = array_map(function($object) {
             return $object->to_array();
        }, $fleets);
        
        $data['fleet'] = $fleetdatas;
        return json_encode($data);
    }

    public function post_search()
    {   
        $jsondata = Input::json();

        $fleets = Checkin::join('fleets','fleets.id', '=', 'checkins.fleet_id')
                ->where('fleets.taxi_number', 'LIKE', '%'.$jsondata->taxi_number.'%')
                ->where('checkins.pool_id', '=', Auth::user()->pool_id)
                ->where('checkins.operasi_time','=',$jsondata->date)
                ->get(array('fleets.taxi_number','checkins.id'));

        $fleetdatas = array_map(function($object) {
             return $object->to_array();
        }, $fleets);
        
        $data['fleet'] = $fleetdatas;
        return json_encode($data);
    }
   	
    public function post_findbyid()
    {   
        $jsondata = Input::json();
        
        $checkin =  Checkin::find($jsondata->id);
        $driverinfo = Driver::find($checkin->driver_id);
        $fleetinfo = Fleet::find($checkin->fleet_id);
        $kso = Kso::find($checkin->kso_id);

        //potongan hari libur
        $pot = 0;
        if($jsondata->dayof  === 'minggu')
        {   
            $pot = Paymentcut::where('pool_id','=', Auth::user()->pool_id)->where('financial_type_id','=', 16)->first()->amount; 
        }
        else if ($jsondata->dayof  === 'nasional') 
        {
            $pot = Paymentcut::where('pool_id','=', Auth::user()->pool_id)->where('financial_type_id','=', 17)->first()->amount;
        }

        
        //potongan bs
        $enddatemonth = date('Y-m-t', strtotime($checkin->operasi_time));
        $datechecked = date('Y-m-d', strtotime($enddatemonth. ' -2 days'));
        if($checkin->operasi_time > $datechecked)
        { 
          $financial = DB::table('financial_report_monthly_bykso')->where('kso_id','=',$checkin->kso_id)->where_month(date('m', strtotime($checkin->operasi_time)))->where_year(date('Y', strtotime($checkin->operasi_time)))->first();
          $bayar_ks = $financial->cicilan_ks; //bayar ks dalam bulan ini
          $ks = $financial->ks; //ks yang timbul bulan ini 
          if($bayar_ks >= $ks){
            $pot = $kso->setoran;
          }
        }
        if($kso->kso_type_id == 2)
        {
          $pot = 0;
        }
        //end potongan BS

        
        //tagihan ks
        $tagihan_ks = Kewajiban::where('fleet_id','=',$checkin->fleet_id)
                      ->where('driver_id','=',$checkin->driver_id)
                      ->where('financial_type_id','=',6)
                      ->first();

        $tag_ks = 0;
             
        
        if($tagihan_ks)
        { 
          $tag_ks = $tagihan_ks->amount;

          $financialfleet = DB::table('financial_report_bykso')->where('kso_id','=',$checkin->kso_id)->first();
          if($financialfleet->cicilan_ks >= $financialfleet->ks){
              $tagihan_ks->amount = 0;
              $tagihan_ks->save();
          }
        }
        //end tagihan ks

        //iuran lain-lain
        $iuran_laka = 0;
        $biaya_tc = 0;
        if($fleetinfo->fg_laka == 1 && $checkin->operasi_status_id == 1) $iuran_laka = Otherpayment::where('pool_id','=', Auth::user()->pool_id)->where('financial_type_id','=', 8)->first()->amount;
        if($checkin->operasi_status_id == 1) $biaya_tc = Otherpayment::where('pool_id','=', Auth::user()->pool_id)->where('financial_type_id','=', 7)->first()->amount;
        
        //denda keterlambatan
        $denda = 0;
        $jamopsplusday = date('Y-m-d', strtotime($checkin->operasi_time. ' +1 days'));
        $shift = Shift::find($checkin->shift_id);  
        $batas_terlambat = date('Y-m-d H:i:s',Myfungsi::sysdate( date('Y-m-d H:i:s', strtotime($jamopsplusday. ' ' .$shift->jam_checkin. ' +' .$shift->ci_adjust.' minutes')) )); 
        
        if($checkin->checkin_time > $batas_terlambat)
        {   
            $hours = ( strtotime($checkin->checkin_time) - strtotime($batas_terlambat) ) / 60 / 60;
            $denda = ceil($hours) * 10000;
        }

        //end denda
        //tag_cicilan_dp 
        $tag_cicilan_dp = 0;;
        $tagihan_dp = Kewajiban::where('fleet_id','=',$checkin->fleet_id)
                      ->where('driver_id','=',$checkin->driver_id)
                      ->where('financial_type_id','=',9)
                      ->first();
        if($tagihan_dp)
        {
          $tag_cicilan_dp = $tagihan_dp->amount;
        }
        //end tagihan cicilan dp kso

        //tagihan dp sparepart
        $tag_dp_spart = 0;
        $dp_spart = Kewajiban::where('fleet_id','=',$checkin->fleet_id)
                      ->where('driver_id','=',$checkin->driver_id)
                      ->where('financial_type_id','=', 13)
                      ->first();
        if($dp_spart)
        {
          $tag_dp_spart = $dp_spart->amount;
        }

        //tagihan hutang sparepart
        $tag_spart = 0;
        $tagihan_spart = Kewajiban::where('fleet_id','=',$checkin->fleet_id)
                      ->where('driver_id','=',$checkin->driver_id)
                      ->where('financial_type_id','=', 5)
                      ->first();
        if($tagihan_spart)
        {
          $tag_spart = $tagihan_spart->amount;
        }

        //tagihan hutang lama
        $tag_hut_lama = 0;
        $hutang_lama_pengemudi = Driverfinancial::where('driver_id','=',$checkin->driver_id)->where('financial_type_id','=',10)->first();
        if($hutang_lama_pengemudi)
        {
          $tag_hut_lama = $hutang_lama_pengemudi->amount;
        }
        //end tagihan hutang lama

        //tagihan other
        $tag_other = 0;

        //km tempuh operasi
        $last_operasi = date('Y-m-d', strtotime($checkin->operasi_time. ' -1 days'));
        $last_checkin = Checkin::where_fleet_id($checkin->fleet_id)->where_operasi_time($last_operasi)->first();
        $km_tempuh =  $checkin->km_fleet ;
        if($last_checkin ){
          $km_tempuh = $checkin->km_fleet - $last_checkin->km_fleet;
        }
        

        $returndata = array(
                      'id'=>$checkin->id, 
                      'nip'=> $driverinfo->nip, 
                      'name' => $driverinfo->name,
                      'taxi_number' => $fleetinfo->taxi_number,
                      'police_number' => $fleetinfo->police_number,
                      'pool_id' => $fleetinfo->pool_id,
                      'pool' => Pool::find($fleetinfo->pool_id)->pool_name,

                        //Tagihan Setoran Perorangan
                      'setoran_wajib' => $kso->setoran,
                      'tab_sp' => $kso->tab_sparepart,
                      'pot' => $pot,
                      'denda' => $denda,
                      'iuran_laka' => $iuran_laka,
                      'biaya_tc' => $biaya_tc,

                      //tagihan hutang
                      'tag_spart' => $tag_spart,
                      'tag_ks' => $tag_ks,
                      'tag_cicilan_dp' => $tag_cicilan_dp,
                      'tag_dp_spart' => $tag_dp_spart,
                      'tag_hut_lama' => $tag_hut_lama,
                      'tag_other' => $tag_other,

                      //in-out time
                      'in_time' => $checkin->checkin_time,
                      'km_tempuh' => $km_tempuh,

                      'total' => ( ($kso->setoran + $kso->tab_sparepart + $denda + $iuran_laka + $biaya_tc + $tag_spart + $tag_ks + $tag_cicilan_dp + $tag_dp_spart + $tag_hut_lama + $tag_other ) - $pot  ),
                      );

        return json_encode($returndata);
        
    }

    /*
      id  financial_type
      1 Setoran Wajib
      2 Tabungan Sparepart
      3 Denda
      4 Potongan
      5 Cicilan Sparepart
      6 Cicilan KS
      7 Biaya Cuci
      8 Iuran Laka
      9 Cicilan DP KSO
      10  Cicilan Hutang Lama
      11  Kurang Setor
      12  Cicilan Lain-Lain
      13  Hutang DP Sparepart
      14  Pemakaian Sparepart
      15  DP Sparepart
      16  Potongan Hari Libur
      17  Potongan Hari Libur Nasional
      18  Hutang Lama pengemudi
      19  Total Hutang KS Pengemudi
      20  Setoran Cash Pengemudi
      21  Tabungan Pengemudi
    */

    // save setoran
    public function post_savePayment()
    {   
        Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Save Setoran', true);
        $jsondata = Input::json();

        //lihat KS 
        $tabungan_pengemudi = 0;
        $ks_pengemudi = 0;
        if((int)$jsondata->ks > 0)
        {
          $tabungan_pengemudi = (int)$jsondata->ks;
        }else{
          $ks_pengemudi = abs((int)$jsondata->ks);
        }
       

        $setoran = array();
        $setoran['1'] = (int)$jsondata->setoran_wajib;
        $setoran['2'] = (int)$jsondata->tab_sp;
        $setoran['3'] = (int)$jsondata->denda;
        $setoran['4'] = (int)$jsondata->pot;
        $setoran['5'] = (int)$jsondata->tag_spart;
        $setoran['6'] = (int)$jsondata->tag_ks;
        $setoran['7'] = (int)$jsondata->biaya_tc;
        $setoran['8'] = (int)$jsondata->iuran_laka;
        $setoran['9'] = (int)$jsondata->tag_cicilan_dp;
        $setoran['10'] = (int)$jsondata->tag_hut_lama;
        $setoran['11'] = (int)$ks_pengemudi;
        $setoran['12'] = (int)$jsondata->tag_other;
        $setoran['13'] = (int)$jsondata->tag_dp_spart;
        $setoran['20'] = (int)$jsondata->setoran_cash;
        $setoran['21'] = (int)$tabungan_pengemudi;

      try {
            foreach ($setoran as $key => $value) {
              $payment = Checkinfinancial::create(array(
                        'checkin_id'=>$jsondata->checkin_id, 
                        'financial_type_id'=> $key, 
                        'amount'=> $value));          
            }
            $checkin = Checkin::find($jsondata->checkin_id);
            
            /*
            /* membuat super block berdasarkan parameter ini
            /* 1. KS Pengemudi Melebihi atau sama dengan 500.000,- dalam bulan berjalan
            /* 2. Belum di devinisikan ( besar akumulasi batas KS ) 
            */

            $finandriver = DB::table('financial_report_monthly_driver_status')
                          ->where('month','=',date('n',strtotime($checkin->operasi_time)) )
                          ->where('year','=',date('Y',strtotime($checkin->operasi_time)) )
                          ->where('driver_id','=', $checkin->driver_id)
                          ->where('operasi_status_id','=',1)
                          ->order_by('id','desc')
                          ->first();

            if($setoran['11'] > 0)
            {
              Blocked::create(array(
                                  'driver_id'=> $checkin->driver_id, 
                                  'fleet_id' => $checkin->fleet_id , 
                                  'std_bap_id' => 4,
                                  'checkin_id' => $checkin->id,  
                                  'date'=> date('Y-m-d H:i:s',Myfungsi::sysdate()) ));

              $block = Driver::find($checkin->driver_id);
              $block->fg_blocked = 1;
              
              /*super block melebihi ks 500000*/
              if($finandriver){
                if($finandriver->selisi_ks < -500000)  
                {
                  //$block->fg_super_blocked = 1;
                }
              }
              
              $block->save();
            }

            //update status checkin
            //informasi siapa yang menerima setoran dan waktu setoran
            $checkin->checkin_step_id = 3;
            $checkin->finance_check_user_id = Auth::user()->id;
            $checkin->finance_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
            $checkin->save();
            

            $pothutanglama = Driverfinancial::where_driver_id($checkin->driver_id)->where_financial_type_id(18)->first();
            if($pothutanglama){
              $pothutanglama->amount = $pothutanglama->amount -  $jsondata->tag_hut_lama; 
            }

            $tabunganpengemudi = Driverfinancial::where_driver_id($checkin->driver_id)->where_financial_type_id(21)->first();
            if($tabunganpengemudi){
              $tabunganpengemudi->amount = $tabunganpengemudi->amount + $tabungan_pengemudi; 
            }else{
              Driverfinancial::create(array(
                              'driver_id'=> $checkin->driver_id,
                              'financial_type_id' => 21,
                              'amount' => $tabungan_pengemudi,
                              ));
            }

            $ks = Kewajiban::where_fleet_id($checkin->fleet_id)
                            ->where_driver_id($checkin->driver_id)
                            ->where_financial_type_id(6)->first();
            if($ks){
              $ks->total_amount = ($ks->total_amount + $setoran['11'])  - $setoran['6'];
            }else{
              Kewajiban::create(array(
                    'fleet_id' => $checkin->fleet_id,
                    'driver_id' => $checkin->driver_id,
                    'financial_type_id' => 6,
                    'amount' => 0,
                    'total_amount' => $setoran['11'],
                ));
            }

            $setor = Fleet::find($checkin->fleet_id);
            $setor->fg_setor = 0;
            $setor->save();
            /*
            if((int)$jsondata->denda > 10000)
            {
              Blocked::create(array(
                                  'driver_id'=>$checkin->driver_id, 
                                  'fleet_id' => $checkin->fleet_id , 
                                  'blocked_status_id' => 6,
                                  'checkin_id' => $checkin->id,  
                                  'date'=> date('Y-m-d H:i:s') ));

              $block = Driver::find($checkin->driver_id);
              $block->fg_blocked = 1;
              $block->save();
            }
            */

         return json_encode(array('id'=> $jsondata->checkin_id ,'msg'=>'Setoran berhasil di simpan'));
      }
      catch( Exception $e ) {
         return json_encode(array('id'=> $jsondata->checkin_id, 'msg'=>'Setoran Sudah pernah di input'));
      }        
    }

    public function get_cetak($id=false)
    {   
      if(!$id) return false;
      
        $checkin =  Checkin::find($id);
        $payment = Checkinfinancial::where_checkin_id($checkin->id)->get();
        $datapayment = array();
        
        for($f=1; $f<22; $f++){
          $datapayment[$f] = 0;
        }
        
        foreach ($payment as $pay) {
              $datapayment[$pay->financial_type_id] = $pay->amount;
        }
        $driverinfo = Driver::find($checkin->driver_id);
        $fleetinfo = Fleet::find($checkin->fleet_id);
        $kso = Kso::find($checkin->kso_id);
        

         //km tempuh operasi
        $last_operasi = date('Y-m-d', strtotime($checkin->operasi_time. ' -1 days'));
        $last_checkin = Checkin::where_fleet_id($checkin->fleet_id)->where_operasi_time($last_operasi)->first();
        $km_tempuh =  $checkin->km_fleet ;
        if($last_checkin ){
          $km_tempuh = $checkin->km_fleet - $last_checkin->km_fleet;
        }
        
        $returndata = array(
                      'id'=>$checkin->id, 
                      'nip'=> $driverinfo->nip, 
                      'name' => $driverinfo->name,
                      'taxi_number' => $fleetinfo->taxi_number,
                      'police_number' => $fleetinfo->police_number,
                      'pool_id' => $fleetinfo->pool_id,
                      'pool' => $fleetinfo->pool_id,

                        //Tagihan Setoran Perorangan
                      'setoran_wajib' => $datapayment[1],
                      'tab_sp' => $datapayment[2],
                      'pot' => $datapayment[4],
                      'denda' => $datapayment[3],
                      'iuran_laka' => $datapayment[8],
                      'biaya_tc' => $datapayment[7],

                      //tagihan hutang
                      'tag_spart' => $datapayment[5],
                      'tag_ks' => $datapayment[6],
                      'tag_cicilan_dp' => $datapayment[9],
                      'tag_dp_spart' => $datapayment[13],
                      'tag_hut_lama' => $datapayment[10],
                      'tag_other' => $datapayment[12],
                      //not avliable
                      'ks' => $datapayment[11],
                      'cash' =>  $datapayment[20],
                      'tabunganpengemudi' =>  $datapayment[21],

                      //in-out time
                      'in_time' => $checkin->checkin_time,
                      'km_tempuh' => $km_tempuh,

                      'total' => ( ($datapayment[1] + $datapayment[2] + $datapayment[3] + $datapayment[8] + $datapayment[7] + 
                                    $datapayment[5] + $datapayment[6] + $datapayment[9] + $datapayment[13] + $datapayment[10] + $datapayment[12] ) - $datapayment[4]  ),
                      );
            
      $a = strtotime($checkin->operasi_time);

      $this->data['driverinfo'] = $driverinfo;
      $this->data['fleetinfo'] = $fleetinfo;
      $this->data['pool'] = Pool::find($checkin->pool_id);
      $this->data['dateops'] = date('d/m/Y', $a);
      $this->data['setoran'] = $returndata;
      return View::make('themes.modul.'.$this->report.'.cetak',$this->data);

    }

    /*******************************************/
    /**** Menu Khusus Edit Setoran *************/
    /*******************************************/

    public function get_editpay()
    {
        return View::make('themes.modul.'.$this->views.'.formedit',$this->data);
    }
    public function get_allafterpay($date=false)
    {   
        if(!$date) $date = date('Y-m-d');
        $date =  date('Y-m-d',Myfungsi::sysdate($date));
        $fleets = Checkin::join('fleets','fleets.id', '=', 'checkins.fleet_id')
                ->where('checkins.pool_id', '=', Auth::user()->pool_id)
                ->where('checkins.operasi_time','=',$date)
                ->where('checkins.checkin_step_id','=',3)
                ->order_by('fleets.taxi_number','asc')
                ->get(array('fleets.taxi_number','checkins.id'));

        $fleetdatas = array_map(function($object) {
             return $object->to_array();
        }, $fleets);
        
        $data['fleet'] = $fleetdatas;
        return json_encode($data);
    }

    public function post_searchafterpay()
    {   
        $jsondata = Input::json();

        $fleets = Checkin::join('fleets','fleets.id', '=', 'checkins.fleet_id')
                ->where('fleets.taxi_number', 'LIKE', '%'.$jsondata->taxi_number.'%')
                //->where('checkins.pool_id', '=', Auth::user()->pool_id)
                ->where('checkins.operasi_time','=',$jsondata->date)
                ->get(array('fleets.taxi_number','checkins.id'));

        $fleetdatas = array_map(function($object) {
             return $object->to_array();
        }, $fleets);
        
        $data['fleet'] = $fleetdatas;
        return json_encode($data);
    }

    public function post_findbyidafterpay()
    {   
        $jsondata = Input::json();
        
        $checkin =  Checkin::find($jsondata->id);
        $driverinfo = Driver::find($checkin->driver_id);
        $fleetinfo = Fleet::find($checkin->fleet_id);
        $kso = Kso::find($checkin->kso_id);

        $payment = Checkinfinancial::where_checkin_id($checkin->id)->get();

        $datapayment = array();
        foreach ($payment as $pay) {
              $datapayment[$pay->financial_type_id] = $pay->amount;
        }

         //km tempuh operasi
        $last_operasi = date('Y-m-d', strtotime($checkin->operasi_time. ' -1 days'));
        $last_checkin = Checkin::where_fleet_id($checkin->fleet_id)->where_operasi_time($last_operasi)->first();
        $km_tempuh =  $checkin->km_fleet ;
        if($last_checkin ){
          $km_tempuh = $checkin->km_fleet - $last_checkin->km_fleet;
        }

        $returndata = array(
                      'id'=>$checkin->id, 
                      'nip'=> $driverinfo->nip, 
                      'name' => $driverinfo->name,
                      'taxi_number' => $fleetinfo->taxi_number,
                      'police_number' => $fleetinfo->police_number,
                      'pool_id' => $fleetinfo->pool_id,
                      'pool' => Pool::find($fleetinfo->pool_id)->pool_name,
                      'operasi_status_id' => $checkin->operasi_status_id,
                      'shift_id' => $checkin->shift_id,

                        //Tagihan Setoran Perorangan
                      'setoran_wajib' => $datapayment[1],
                      'tab_sp' => $datapayment[2],
                      'pot' => $datapayment[4],
                      'denda' => $datapayment[3],
                      'iuran_laka' => $datapayment[8],
                      'biaya_tc' => $datapayment[7],

                      //tagihan hutang
                      'tag_spart' => $datapayment[5],
                      'tag_ks' => $datapayment[6],
                      'tag_cicilan_dp' => $datapayment[9],
                      'tag_dp_spart' => $datapayment[13],
                      'tag_hut_lama' => $datapayment[10],
                      'tag_other' => $datapayment[12],
                      //not avliable
                      //'ks' => $datapayment[11],
                      'ks' =>  $datapayment[20] - ( ($datapayment[1] + $datapayment[2] + $datapayment[3] + $datapayment[8] + $datapayment[7] + 
                                    $datapayment[5] + $datapayment[6] + $datapayment[9] + $datapayment[13] + $datapayment[10] + $datapayment[12] ) - $datapayment[4]  ),
                      'cash' =>  $datapayment[20],


                      //in-out time
                      'in_time' => $checkin->checkin_time,
                      'km_tempuh' => $km_tempuh,

                      'total' => ( ($datapayment[1] + $datapayment[2] + $datapayment[3] + $datapayment[8] + $datapayment[7] + 
                                    $datapayment[5] + $datapayment[6] + $datapayment[9] + $datapayment[13] + $datapayment[10] + $datapayment[12] ) - $datapayment[4]  ),
                      );

        return json_encode($returndata);
    }

    public function post_afterpaysave()
    { 
        Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Save Edit Setoran', true);
        $jsondata = Input::json();

        //lihat KS 
        $tabungan_pengemudi = 0;
        $ks_pengemudi = 0;
        if((int)$jsondata->ks > 0)
        {
          $tabungan_pengemudi = (int)$jsondata->ks;
        }else{
          $ks_pengemudi = abs((int)$jsondata->ks);
        }
       

        $setoran = array();
        $setoran['1'] = (int)$jsondata->setoran_wajib;
        $setoran['2'] = (int)$jsondata->tab_sp;
        $setoran['3'] = (int)$jsondata->denda;
        $setoran['4'] = (int)$jsondata->pot;
        $setoran['5'] = (int)$jsondata->tag_spart;
        $setoran['6'] = (int)$jsondata->tag_ks;
        $setoran['7'] = (int)$jsondata->biaya_tc;
        $setoran['8'] = (int)$jsondata->iuran_laka;
        $setoran['9'] = (int)$jsondata->tag_cicilan_dp;
        $setoran['10'] = (int)$jsondata->tag_hut_lama;
        $setoran['11'] = (int)$ks_pengemudi;
        $setoran['12'] = (int)$jsondata->tag_other;
        $setoran['13'] = (int)$jsondata->tag_dp_spart;
        $setoran['20'] = (int)$jsondata->setoran_cash;
        $setoran['21'] = (int)$tabungan_pengemudi;

        //Edit Status Operasi

        //End Status Operasi
      try {
            foreach ($setoran as $key => $value) {
              /*
              $payment = Checkinfinancial::create(array(
                        'checkin_id'=>$jsondata->checkin_id, 
                        'financial_type_id'=> $key, 
                        'amount'=> $value));
                        */
              $payment = Checkinfinancial::where_checkin_id($jsondata->checkin_id)->where_financial_type_id($key)->first();
              if($payment){
                $payment->amount =  $value;
                $payment->save();  
              }else{
                
                $payment = Checkinfinancial::create(array(
                        'checkin_id'=> $jsondata->checkin_id, 
                        'financial_type_id'=> $key, 
                        'amount'=> $value));
              }
                       
            }
            
            $checkin = Checkin::find($jsondata->checkin_id);
            $checkin->checkin_step_id = 3;
            $checkin->operasi_status_id = $jsondata->operasi_status_id;
            $checkin->shift_id = $jsondata->shift_id;
            $checkin->save();

            /*
            if($setoran['11'] > 0)
            {
              Blocked::create(array(
                                  'driver_id'=> $checkin->driver_id, 
                                  'fleet_id' => $checkin->fleet_id , 
                                  'blocked_status_id' => 1,
                                  'checkin_id' => $checkin->id,  
                                  'date'=> date('Y-m-d H:i:s') ));

              $block = Driver::find($checkin->driver_id);
              $block->fg_blocked = 1;
              $block->save();
            }*/
            //update status checkin
            
            
            /*
            $pothutanglama = Driverfinancial::where_driver_id($checkin->driver_id)->where_financial_type_id(18)->first();
            if($pothutanglama){
              $pothutanglama->amount = $pothutanglama->amount -  $jsondata->tag_hut_lama; 
            }

            $tabunganpengemudi = Driverfinancial::where_driver_id($checkin->driver_id)->where_financial_type_id(21)->first();
            if($tabunganpengemudi){
              $tabunganpengemudi->amount = $tabunganpengemudi->amount + $tabungan_pengemudi; 
            }else{
              Driverfinancial::create(array(
                              'driver_id'=> $checkin->driver_id,
                              'financial_type_id' => 21,
                              'amount' => $tabungan_pengemudi,
                              ));
            }

            $ks = Kewajiban::where_fleet_id($checkin->fleet_id)
                            ->where_driver_id($checkin->driver_id)
                            ->where_financial_type_id(6)->first();
            if($ks){
              $ks->total_amount = ($ks->total_amount + $setoran['11'])  - $setoran['6'];
            }else{
              Kewajiban::create(array(
                    'fleet_id' => $checkin->fleet_id,
                    'driver_id' => $checkin->driver_id,
                    'financial_type_id' => 6,
                    'amount' => 0,
                    'total_amount' => $setoran['11'],
                ));
            }

            
            
            if((int)$jsondata->denda > 10000)
            {
              Blocked::create(array(
                                  'driver_id'=>$checkin->driver_id, 
                                  'fleet_id' => $checkin->fleet_id , 
                                  'blocked_status_id' => 6,
                                  'checkin_id' => $checkin->id,  
                                  'date'=> date('Y-m-d H:i:s') ));

              $block = Driver::find($checkin->driver_id);
              $block->fg_blocked = 1;
              $block->save();
            }
            */
         return json_encode(array('msg'=>'Setoran berhasil di ubah'));
      }
      catch( Exception $e ) {
         return json_encode(array('msg'=>'Edit Setoran Gagal'));
      }
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

    public function get_expreportdaily($date=false, $shift_id = false)
    {
      if(!$date) $date = date('Y-m-d');
      if(!$shift_id) $$shift_id = 1;
      
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()->setCreator(Auth::user()->fullname)
               ->setLastModifiedBy(Auth::user()->fullname)
               ->setTitle("Laporan Harian ".Pool::find(Auth::user()->pool_id)->pool_name)
               ->setSubject("Laporan Harian ".Pool::find(Auth::user()->pool_id)->pool_name)
               ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
               ->setKeywords("Laporan Harian")
               ->setCategory("");
      $objPHPExcel->setActiveSheetIndex(0);
      
      $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
      $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
      $objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
      $objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
      $objPHPExcel->getActiveSheet()->mergeCells('F5:G5');
      $objPHPExcel->getActiveSheet()->mergeCells('H5:H6');

      $objPHPExcel->getActiveSheet()->mergeCells('I5:I6');
      $objPHPExcel->getActiveSheet()->mergeCells('J5:J6');
      $objPHPExcel->getActiveSheet()->mergeCells('K5:K6');
      $objPHPExcel->getActiveSheet()->mergeCells('L5:O5');
      $objPHPExcel->getActiveSheet()->mergeCells('P5:R5');
      //$objPHPExcel->getActiveSheet()->mergeCells('R5:R6');
      $objPHPExcel->getActiveSheet()->mergeCells('S5:S6');
      $objPHPExcel->getActiveSheet()->mergeCells('T5:T6');
      $objPHPExcel->getActiveSheet()->mergeCells('U5:U6');
      $objPHPExcel->getActiveSheet()->mergeCells('V5:V6');
      $objPHPExcel->getActiveSheet()->mergeCells('W5:W6');
      $objPHPExcel->getActiveSheet()->mergeCells('X5:X6');

      
      $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO');
      $objPHPExcel->getActiveSheet()->setCellValue('B5', 'BAPAK ASUH');
      $objPHPExcel->getActiveSheet()->setCellValue('C5', 'PENGEMUDI');
      $objPHPExcel->getActiveSheet()->setCellValue('C6', 'NIP');
      $objPHPExcel->getActiveSheet()->setCellValue('D6', 'NAMA');
      $objPHPExcel->getActiveSheet()->setCellValue('E5', 'BODY');
     
      $objPHPExcel->getActiveSheet()->setCellValue('F5', 'STATUS');
      $objPHPExcel->getActiveSheet()->setCellValue('F6', 'OPS');
      $objPHPExcel->getActiveSheet()->setCellValue('G6', 'BS');

      $objPHPExcel->getActiveSheet()->setCellValue('H5', 'SETORAN MURNI');
      $objPHPExcel->getActiveSheet()->setCellValue('I5', 'TAB SPAREPART');
      $objPHPExcel->getActiveSheet()->setCellValue('J5', 'DENDA JAM');
      $objPHPExcel->getActiveSheet()->setCellValue('K5', 'DP SPAREPART');

      $objPHPExcel->getActiveSheet()->setCellValue('L5', 'BAYAR  CICILAN');
      $objPHPExcel->getActiveSheet()->setCellValue('L6', 'KS');
      $objPHPExcel->getActiveSheet()->setCellValue('M6', 'S-PART');
      $objPHPExcel->getActiveSheet()->setCellValue('N6', 'DP-KSO');
      $objPHPExcel->getActiveSheet()->setCellValue('O6', 'HUT-LAMA');

      $objPHPExcel->getActiveSheet()->setCellValue('P5', 'BAYAR');
      $objPHPExcel->getActiveSheet()->setCellValue('P6', 'STIKER BANDARA');
      $objPHPExcel->getActiveSheet()->setCellValue('Q6', 'CUCI');
      $objPHPExcel->getActiveSheet()->setCellValue('R6', 'LAKA');

      $objPHPExcel->getActiveSheet()->setCellValue('S5', 'HARUS SETOR');
      $objPHPExcel->getActiveSheet()->setCellValue('T5', 'POTONGAN');
      $objPHPExcel->getActiveSheet()->setCellValue('U5', 'SETOR CASH');
      $objPHPExcel->getActiveSheet()->setCellValue('V5', 'KETEKORAN');
      $objPHPExcel->getActiveSheet()->setCellValue('W5', 'SETORAN OPS');
      $objPHPExcel->getActiveSheet()->setCellValue('X5', 'SHIFT');


      $financials =  DB::table('financial_report_daily')
                        ->where('operasi_time','=',$date)
                        ->where('shift_id','=',$shift_id)
                        ->where_pool_id(Auth::user()->pool_id)
                        ->order_by('shift_id','asc')
                        //->order_by('shift_id','asc')
                        ->order_by('taxi_number','asc')->get();

      $no = 1;
      $starline = 8;
      foreach ($financials as $finan) {
        $bs = ($finan->potongan >= $finan->setoran_wajib)? 'YA' : 'TIDAK'; 
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, '');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $starline, $finan->nip);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $starline, $finan->name);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $starline, $finan->taxi_number);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $starline, $finan->kode);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $starline, $bs);
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $starline, $finan->setoran_wajib);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $starline, $finan->tabungan_sparepart);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $starline, $finan->denda);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $starline, $finan->hutang_dp_sparepart);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $starline, $finan->cicilan_ks);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $starline, $finan->cicilan_sparepart);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $starline, $finan->cicilan_dp_kso);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, $finan->cicilan_hutang_lama);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $starline, $finan->cicilan_lain);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $starline, $finan->biaya_cuci);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $starline, $finan->iuran_laka);
        

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $starline, '=SUM(H'.$starline.':R'.$starline.')');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $starline, $finan->potongan);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $starline, $finan->setoran_cash);
        //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $starline, $finan->ks);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $starline,'=(U'.$starline.'-(S'.$starline.'-T'.$starline.'))');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $starline,'=(U'.$starline.'-(Q'.$starline.'+R'.$starline.'))');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $starline,  $finan->shift);
        //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $starline, $finan->shift_id);

        //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, $finan->cicilan_lain);
        
        $no ++;
        $starline ++;
      }

      $objPHPExcel->getActiveSheet()->mergeCells('A'.($starline + 1).':G'.($starline + 1).'');
      $objPHPExcel->getActiveSheet()->setCellValue('A'.($starline + 1), 'TOTAL SETORAN ');

      $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 1), '=SUM(H8:H'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 1), '=SUM(I8:I'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('J'.($starline + 1), '=SUM(J8:J'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 1), '=SUM(K8:K'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 1), '=SUM(L8:L'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('M'.($starline + 1), '=SUM(M8:M'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('N'.($starline + 1), '=SUM(N8:N'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('O'.($starline + 1), '=SUM(O8:O'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('P'.($starline + 1), '=SUM(P8:P'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('Q'.($starline + 1), '=SUM(Q8:Q'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('R'.($starline + 1), '=SUM(R8:R'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('S'.($starline + 1), '=SUM(S8:S'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('T'.($starline + 1), '=SUM(T8:T'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('U'.($starline + 1), '=SUM(U8:U'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('V'.($starline + 1), '=SUM(V8:V'.$starline.')');  
      $objPHPExcel->getActiveSheet()->setCellValue('W'.($starline + 1), '=SUM(W8:W'.$starline.')');

      $objPHPExcel->getActiveSheet()->getStyle('A5:X'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
      $objPHPExcel->getActiveSheet()->getStyle('A5:X6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle('A5:X'.($starline + 1))->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle('A'.($starline + 1).':X'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

      /* Rekap Pendapatan */
      $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 3), 'Total Setoran  :');
      $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 5), 'Disetor ke Bank  :');
      $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 6), 'Disetor ke KKBD  :');
      $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 7), 'Disetor ke Peduli Laka  :');

      $objPHPExcel->getActiveSheet()->setCellValue('E'.($starline + 3), '=SUM(U8:U'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('E'.($starline + 5), '=SUM(W8:W'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('E'.($starline + 6), '=SUM(Q8:Q'.$starline.')');
      $objPHPExcel->getActiveSheet()->setCellValue('E'.($starline + 7), '=SUM(R8:R'.$starline.')');
      
      $objPHPExcel->getActiveSheet()->setTitle('Laporan Harian Tgl '. $date);
           
      /*
      $objPHPExcel->getSecurity()->setLockWindows(true);
      $objPHPExcel->getSecurity()->setLockStructure(true);
      $objPHPExcel->getSecurity()->setWorkbookPassword("FreeBlocking");
      $objPHPExcel->getActiveSheet()->getProtection()->setPassword('FreeBlocking');
      $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); // This should be enabled in order to enable any of the following!
      $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
      $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
      $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
      */
      $objPHPExcel->setActiveSheetIndex(0);
      
      
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      //echo path('public');
      $objWriter->save(path('public').'Laporan-Harian-'.Pool::find(Auth::user()->pool_id)->pool_name.'-Tanggal-'.$date.'.xlsx');
      return Response::download(path('public').'Laporan-Harian-'.Pool::find(Auth::user()->pool_id)->pool_name.'-Tanggal-'.$date.'.xlsx', 'Laporan-Harian-'.Pool::find(Auth::user()->pool_id)->pool_name.'-Tanggal-'.$date.'.xlsx');
  
    }


    //BS

    public function get_reportbs()
    {
      Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Read report BS', true);
      return View::make('themes.modul.'.$this->report.'.reportbs',$this->data);
    }

    public function post_loaddatabs()
    { 
      $date = Input::get('dateops', date('Y-m-d'));
      $page = Input::get('page');
      $limit = Input::get('rows');
      $sidx = Input::get('sidx', 'id');
      $sord = Input::get('sord');

      //$ksoaktif = Kso::where('actived','=',1)->where('pool_id','=',Auth::user()->pool_id)->get();

      $date = strtotime($date);
      //$count = Driver::count();
      $count = DB::table('financial_report_monthly_bykso')->where('month','=',date('n',$date))->where('year','=',date('Y',$date))->where_pool_id(Auth::user()->pool_id)->count();
      
      
      if( $count > 0 ) {
        $total_pages = ceil($count / $limit);
      } else {
        $total_pages = 0;
      } 
     
      if ($page > $total_pages) $page = $total_pages;

      $start = $limit * $page - $limit; 

      if($start < 0) $start = 0;

      $financials =  DB::table('financial_report_monthly_bykso')->where('month','=',date('n',$date))->where('year','=',date('Y',$date))->where_pool_id(Auth::user()->pool_id)->order_by($sidx,$sord)->skip($start)->take($limit)->get();
      $responce['page'] = $page;
      $responce['total'] = $total_pages;
      $responce['records'] = $count;
      $no= $start + 0;
      foreach ($financials as $finan) {
        $no++;

        $ks = abs($finan->setoran_cash - ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                  + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                  + $finan->hutang_dp_sparepart ) - $finan->potongan ));
        
        $bs = 'Tidak'; 
        if($ks <= $finan->cicilan_ks){
          $bs = 'Ya'; 
        }
        
        $responce['rows'][] = array(
                                'no' => $no ,
                                'taxi_number' => $finan->taxi_number ,
                                //'nip' => $finan->nip ,
                                //'name' => $finan->name ,
                                //'checkin_time' => $finan->checkin_time ,
                                'bs' =>  $bs,

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
                                'ks' => $ks,
                                'cicilan_lain' => $finan->cicilan_lain ,
                                'hutang_dp_sparepart' => $finan->hutang_dp_sparepart ,
                                //'status_operasi' => $finan->kode ,
                                'total' => ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                  + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                  + $finan->hutang_dp_sparepart ) ),
                                
                                'setoranops' => ( $finan->setoran_cash - ($finan->biaya_cuci + $finan->iuran_laka)),
                                'selisi_ks' => ($finan->selisi_ks),
                                );
      }

      return json_encode($responce);
       /**/
    }

}