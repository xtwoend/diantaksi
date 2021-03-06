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
    
    public function get_qzfinancial()
    {
      return View::make('themes.modul.'.$this->views.'.form-qzprint',$this->data);
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
          $financial = DB::table('financial_report_monthly_bykso')
                        ->where('kso_id','=',$checkin->kso_id)
                        ->where_month(date('m', strtotime($checkin->operasi_time)))
                        ->where_year(date('Y', strtotime($checkin->operasi_time)))
                        ->first();
          
          /*
          $sd = date('Y-m-01', strtotime($checkin->operasi_time));
          $ed = date('Y-m-d', strtotime($checkin->operasi_time));

          $financial = DB::table('checkins')
                  ->select(DB::raw('sum(if((checkin_financials.financial_type_id = 1),checkin_financials.amount,0)) AS setoran_wajib,sum(if((checkin_financials.financial_type_id = 2),checkin_financials.amount,0)) AS tabungan_sparepart,sum(if((checkin_financials.financial_type_id = 3),checkin_financials.amount,0)) AS denda,sum(if((checkin_financials.financial_type_id = 4),checkin_financials.amount,0)) AS potongan,sum(if((checkin_financials.financial_type_id = 5),checkin_financials.amount,0)) AS cicilan_sparepart,sum(if((checkin_financials.financial_type_id = 6),checkin_financials.amount,0)) AS cicilan_ks,sum(if((checkin_financials.financial_type_id = 7),checkin_financials.amount,0)) AS biaya_cuci,sum(if((checkin_financials.financial_type_id = 8),checkin_financials.amount,0)) AS iuran_laka,sum(if((checkin_financials.financial_type_id = 9),checkin_financials.amount,0)) AS cicilan_dp_kso,sum(if((checkin_financials.financial_type_id = 10),checkin_financials.amount,0)) AS cicilan_hutang_lama,sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) AS ks,sum(if((checkin_financials.financial_type_id = 12),checkin_financials.amount,0)) AS cicilan_lain,sum(if((checkin_financials.financial_type_id = 13),checkin_financials.amount,0)) AS hutang_dp_sparepart,sum(if((checkin_financials.financial_type_id = 20),checkin_financials.amount,0)) AS setoran_cash,sum(if((checkin_financials.financial_type_id = 21),checkin_financials.amount,0)) AS tabungan,(sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) - sum(if((checkin_financials.financial_type_id = 6),checkin_financials.amount,0))) AS selisi_ks '))
                  ->add_select(DB::raw('checkins.id, checkins.operasi_time , checkins.pool_id, checkins.shift_id'))
                  ->left_join('checkin_financials', 'checkins.id', '=', 'checkin_financials.checkin_id')
                  ->where_between('checkins.operasi_time',$sd , $ed)
                  ->where('checkins.kso_id', '=' ,$checkin->kso_id)
                  ->group_by('checkins.kso_id', 'checkins.operasi_time');
          */
         
          $bayar_ks = $financial->cicilan_ks; //bayar ks dalam bulan ini
          $ks = $financial->ks; //ks yang timbul bulan ini 
          $selisih_ks = $financial->selisi_ks;

          if($bayar_ks >= $ks){
                      
            /* set bs berdasarkan tanggal kso */
            $startkso = Kso::find($checkin->kso_id);
            if( $startkso->ops_start >= date('Y-m-10', strtotime($checkin->operasi_time)) && $startkso->ops_start <= date('Y-m-15', strtotime($checkin->operasi_time))){
              $xd = date('Y-m-d', strtotime($enddatemonth. ' -1 days'));
              if($checkin->operasi_time > $xd)
              {
                  $pot = $kso->setoran;
              }
            }else if($startkso->ops_start <= date('Y-m-10', strtotime($checkin->operasi_time))){
                  $pot = $kso->setoran;
            }
          }
          /*
          else if ($checkin->pool_id == 2 && $selisih_ks >= (-200000) ) { // khusus mndo bulan ini
                $pot = $kso->setoran;
          }
          */
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
             
        /*
        if($tagihan_ks)
        { 
          $tag_ks = $tagihan_ks->amount;

          $financialfleet = DB::table('financial_report_bykso')->where('kso_id','=',$checkin->kso_id)->first();
          if($financialfleet->cicilan_ks >= $financialfleet->ks){
              $tagihan_ks->amount = 0;
              $tagihan_ks->save();
          }
        }
        */
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
        if($fleetinfo->fg_bandara == 1) $tag_other = 11000;       

        //km tempuh operasi
        $last_operasi = date('Y-m-d', strtotime($checkin->operasi_time. ' -1 days'));
        $last_checkin = Checkin::where_fleet_id($checkin->fleet_id)->where_operasi_time($last_operasi)->first();
        $km_tempuh =  $checkin->km_fleet ;
        if($last_checkin ){
          $km_tempuh = $checkin->km_fleet - $last_checkin->km_fleet;
        }
        
        //set $tagihanopenblock 
        $tagihanopenblock = 0;
        $bap = Bap::where('operasi_time','=',$checkin->operasi_time)->where('driver_id','=',$checkin->driver_id)->first();
        if($bap){
          $open = Openblocking::where('bap_id','=',$bap->id)->first();
          if($open){
            $tagihanopenblock = $open->pay;
          }
        }

        //end tagihan open block

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
                      'tagihanopenblock' => $tagihanopenblock,

                      //in-out time
                      'in_time' => $checkin->checkin_time,
                      'km_tempuh' => $km_tempuh,

                      'total' => ( ($kso->setoran + $kso->tab_sparepart + $denda + $iuran_laka + $biaya_tc + $tag_spart + $tag_ks + $tag_cicilan_dp + $tag_dp_spart + $tag_hut_lama + $tag_other + $tagihanopenblock ) - $pot  ),
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

        $setoran = array();
        $setoran['1'] = (int)$jsondata->setoran_wajib;
        $setoran['2'] = (int)$jsondata->tab_sp;
        $setoran['3'] = (int)$jsondata->denda;
        $setoran['4'] = (int)$jsondata->pot; //potongan
        $setoran['5'] = (int)$jsondata->tag_spart;
        $setoran['6'] = (int)$jsondata->tag_ks + (int)$jsondata->tagihanopenblock;
        $setoran['7'] = (int)$jsondata->biaya_tc;
        $setoran['8'] = (int)$jsondata->iuran_laka;
        $setoran['9'] = (int)$jsondata->tag_cicilan_dp;
        $setoran['10'] = (int)$jsondata->tag_hut_lama;
        //$setoran['11'] = (int)$ks_pengemudi;
        $setoran['12'] = (int)$jsondata->tag_other;
        $setoran['13'] = (int)$jsondata->tag_dp_spart;
        $setoran['20'] = (int)$jsondata->setoran_cash; //potongan
        //$setoran['21'] = (int)$tabungan_pengemudi;

        $totaltagihan = $setoran['1'] + $setoran['2'] + $setoran['3'] + $setoran['5'] + $setoran['6'] + $setoran['7'] + $setoran['8'] + $setoran['9'] + $setoran['10'] + $setoran['12'] + $setoran['13'] ;
        $potongan = $setoran['4'] + $setoran['20'];

        $ks = $potongan - $totaltagihan ;

        //lihat KS 
        $tabungan_pengemudi = 0;
        $ks_pengemudi = 0;
        if( $ks > 0 )
        {
          $tabungan_pengemudi = (int)$ks;
        }else{
          $ks_pengemudi = abs((int)$ks);
        }

        $setoran['11'] = (int)$ks_pengemudi;
        $setoran['21'] = (int)$tabungan_pengemudi;

        try {
            foreach ($setoran as $key => $value) {
              	$payment = Checkinfinancial::create(array(
                        	'checkin_id'=>$jsondata->checkin_id, 
                        	'financial_type_id'=> $key, 
                        	'amount'=> $value));          
            }
            $checkin = Checkin::find($jsondata->checkin_id);
            
            //max to block
            if($setoran['11'] > 25000 && (Auth::user()->pool_id != 2))
            {
              Blocked::create(array(
                                  'driver_id'=> $checkin->driver_id, 
                                  'fleet_id' => $checkin->fleet_id , 
                                  'std_bap_id' => 4,
                                  'checkin_id' => $checkin->id,  
                                  'date'=> date('Y-m-d H:i:s', Myfungsi::sysdate()) ));

              $block = Driver::find($checkin->driver_id);
              
              //block super untuk semua ks
              //$block->fg_super_blocked = 1;
              
              $block->fg_blocked = 1;
              
              /*
	            /* membuat super block berdasarkan parameter ini
	            /* 1. KS Pengemudi Melebihi atau sama dengan 500.000,- dalam bulan berjalan
	            /* 2. Belum di devinisikan ( besar akumulasi batas KS ) 
	            */
              /*
	            $finandriver = DB::table('financial_report_monthly_driver_status')
	                          	->where('month','=',date('n',strtotime($checkin->operasi_time)) )
	                          	->where('year','=',date('Y',strtotime($checkin->operasi_time)) )
	                          	->where('driver_id','=', $checkin->driver_id)
	                          	->where_in('operasi_status_id',array(1,3))
	                          	->order_by('id','desc')
	                          	->sum('selisi_ks');



              //super block melebihi ks 500000
              if($finandriver){
                if($finandriver < -500000)  
                {
                  $block->fg_super_blocked = 1;
                }
              }
              
              */
              $block->save();
            }elseif ($setoran['11'] > 0 && (Auth::user()->pool_id == 2)) {
              //create block manado
              Blocked::create(array(
                                  'driver_id'=> $checkin->driver_id, 
                                  'fleet_id' => $checkin->fleet_id , 
                                  'std_bap_id' => 4,
                                  'checkin_id' => $checkin->id,  
                                  'date'=> date('Y-m-d H:i:s', Myfungsi::sysdate()) ));

              $block = Driver::find($checkin->driver_id);
              $block->fg_blocked = 1;
              $block->save();
            }
            
            //update status checkin
            //informasi siapa yang menerima setoran dan waktu setoran
            $checkin->checkin_step_id = 3;
            $checkin->finance_check_user_id = Auth::user()->id;
            $checkin->finance_time = date('Y-m-d H:i:s', Myfungsi::sysdate());
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

    public function get_cetak2($id=false)
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
        /*
        $last_operasi = date('Y-m-d', strtotime($checkin->operasi_time. ' -1 days'));
        $last_checkin = Checkin::where_fleet_id($checkin->fleet_id)->where_operasi_time($last_operasi)->first();
        $km_tempuh =  $checkin->km_fleet ;
        if($last_checkin ){
          $km_tempuh = $checkin->km_fleet - $last_checkin->km_fleet;
        }
        */
           
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

        $datasaldo = array(
                      'Saldo KS'  => ($fleet_cicilan_ks - $fleet_ks),
                      'Saldo Sparepart' =>  (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part ),
                      '------------' => '--------------------------',
                      'Saldo Unit'  => (($fleet_cicilan_ks ) - ($fleet_ks)) + (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part ) ,
                    );

        $datatagihan = array(
                     
                      //Tagihan Setoran Perorangan
                      'Setoran Wajib' => $datapayment[1],
                      'Tabungan Sparepart' => $datapayment[2],
                      'Denda Keterlambatan' => $datapayment[3],
                     
                      //tagihan hutang
                     
                      'Bayar KS' => $datapayment[6],
                      'Bayar DP KSO' => $datapayment[9],
                      'Bayar DP SP' => $datapayment[13],
                      'Cicilan Hut. SP' => $datapayment[5],
                      'Cicilan Hut. Lama *' => $datapayment[10],
                      'Stkr. Bandara & Keamanan' => $datapayment[12],                      
                      
                      'Bayar TC' => $datapayment[7],
                      'Iuran LAKA' => $datapayment[8],
                      );
        $datapembayaran = array(
                'TOTAL' => ( ($datapayment[1] + $datapayment[2] + $datapayment[3] + $datapayment[8] + $datapayment[7] + 
                                 $datapayment[5] + $datapayment[6] + $datapayment[9] + $datapayment[13] + $datapayment[10] + $datapayment[12] ) ),
                'POTONGAN'  => $datapayment[4],
                '------------' => '--------------------------',
                'DI BAYAR'  => $datapayment[20],
                '-----------' => '---------------------------',
                'KS PENGEMUDI' => $datapayment[11],
          );
      $a = strtotime($checkin->operasi_time);
      $headerPrint =("");
      for($j = 1; $j<2; $j++) {
        
        $headerPrint .=("\x1B\x40");
        $headerPrint .=("\x1B\x61\x01"); // 1 SET CENTER PAGE
        $headerPrint .=("\x1B\x21\x17");
        $headerPrint .=("TANDA TERIMA SETORAN \r\n"); 
        $headerPrint .=("\x1B\x21\x00");
        $headerPrint .=("\x1B\x40"); // 1 RESET
        $headerPrint .=("\x1B\x61\x01"); // 1 SET CENTER PAGE
        $headerPrint .=("PT. DHARMA INDAH AGUNG METROPOLITAN \r\n");
        $headerPrint .=("POOL ". Pool::find($checkin->pool_id)->pool_name  ." \r\n");
        $headerPrint .=("======================================= \r\n"); 
        $headerPrint .=("\x1B\x61\x00"); // 1 SET LEFT PAGE 
        //content printer
        $headerPrint .=("Nama        : ". substr($driverinfo->name, 0, 25) ." \r\n");
        $headerPrint .=("Nip         : ". $driverinfo->nip ." \r\n");
        $headerPrint .=("Body        : ". $fleetinfo->taxi_number. " \r\n");
        $headerPrint .=("Tgl Operasi : ". date('d/m/Y', $a). " \r\n");
        $headerPrint .=("--------------------------------------- \r\n");
        $headerPrint .=("INFORMASI SALDO PER TGL ".date('d/m/Y')."\r\n");
        $headerPrint .=("--------------------------------------- \r\n");
        $headerPrint .=("".$this->textFormat($datasaldo, 39)."");
        $headerPrint .=("--------------------------------------- \r\n");     
        $headerPrint .=("TAGIHAN HARI INI \r\n");
        $headerPrint .=("--------------------------------------- \r\n");
        $headerPrint .=("".$this->textFormat($datatagihan, 39)."");
        $headerPrint .=("--------------------------------------- \r\n");
        $headerPrint .=("".$this->textFormat($datapembayaran, 39)."");     
        $headerPrint .=("======================================= \r\n");
        $headerPrint .=("Tanggal Cetak ".date('d/m/Y H:i:s', MyFungsi::sysdate(date('Y-m-d H:i:s')))." \r\n");
        $headerPrint .=("Lembar ke - ".$j." \r\n");
        $headerPrint .=("\x0C"); // 5 FF
        $headerPrint .=("\x1D\x56\x41"); // 4 motong kertas
        $headerPrint .=("\x1B\x40"); // 5 END

      }

      //create temp file
      $file = 'dataprintnota'.$checkin->pool_id.'.txt';

      $myFile = path('public'). '/qzprint/templatedata/'. $file ;
      $fh = fopen($myFile, 'w') or die("can't open file");
      $resetPrint = "";
      fwrite($fh, $resetPrint);
      $dataPrint = $headerPrint;
      fwrite($fh, $dataPrint);
      fclose($fh);
      
      return json_encode(array('status'=>1, 'urlfile'=> $file));
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
        
        /*
        $fleets = Checkin::where('pool_id', '=', Auth::user()->pool_id)
                ->where('operasi_time','=',$date)
                ->where('checkin_step_id','=',3)
                ->get(array('fleet_id','id'));
        $data = array();
        foreach ($fleets as $f) {
          $data['fleet'][] = array('id' => $f->id, 'taxi_number' => ($fle = Fleet::find($f->fleet_id))? $fle->taxi_number : 'error fleet' ); 
        }
        return json_encode($data);
        */
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
        
        $driverinfo = ($driverinfo) ? $driverinfo: Driver::find(8889); 

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
                      'ks' => $datapayment[11],
                      //'ks' =>  $datapayment[20] - ( ($datapayment[1] + $datapayment[2] + $datapayment[3] + $datapayment[8] + $datapayment[7] + 
                      //              $datapayment[5] + $datapayment[6] + $datapayment[9] + $datapayment[13] + $datapayment[10] + $datapayment[12] ) - $datapayment[4]  ),
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

        $setoran = array();
        $setoran['1'] = (int)$jsondata->setoran_wajib;
        $setoran['2'] = (int)$jsondata->tab_sp;
        $setoran['3'] = (int)$jsondata->denda;
        $setoran['4'] = (int)$jsondata->pot; //potongan
        $setoran['5'] = (int)$jsondata->tag_spart;
        $setoran['6'] = (int)$jsondata->tag_ks;
        $setoran['7'] = (int)$jsondata->biaya_tc;
        $setoran['8'] = (int)$jsondata->iuran_laka;
        $setoran['9'] = (int)$jsondata->tag_cicilan_dp;
        $setoran['10'] = (int)$jsondata->tag_hut_lama;
        //$setoran['11'] = (int)$ks_pengemudi;
        $setoran['12'] = (int)$jsondata->tag_other;
        $setoran['13'] = (int)$jsondata->tag_dp_spart;
        $setoran['20'] = (int)$jsondata->setoran_cash; //potongan
        //$setoran['21'] = (int)$tabungan_pengemudi;

        $totaltagihan = $setoran['1'] + $setoran['2'] + $setoran['3'] + $setoran['5'] + $setoran['6'] + $setoran['7'] + $setoran['8'] + $setoran['9'] + $setoran['10'] + $setoran['12'] + $setoran['13'] ;
        $potongan = $setoran['4'] + $setoran['20'];

        $ks = $potongan - $totaltagihan ;

        //lihat KS 
        $tabungan_pengemudi = 0;
        $ks_pengemudi = 0;
        if($ks > 0 )
        {
          $tabungan_pengemudi = (int)$ks;
        }else{
          $ks_pengemudi = abs((int)$ks);
        }

        $setoran['11'] = (int)$ks_pengemudi;
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
         return json_encode(array('msg'=>'Setoran berhasil di ubah '. $ks));
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
               ->setTitle("Laporan Harian ".Pool::find(Auth::user()->pool_id)->pool_name. '-'.date('Y-m-d'))
               ->setSubject("Laporan Harian ".Pool::find(Auth::user()->pool_id)->pool_name. '-'.date('Y-m-d'))
               ->setDescription("Laporan harian operasi pool")
               ->setKeywords("Laporan Harian")
               ->setCategory("");
      
      $styleArray = array(
          'font'  => array(
              'bold'  => true,
              'color' => array('rgb' => 'FF0000'),
              'size'  => 16,
              //'name'  => 'Verdana'
      ));

      $jenis_kendaraan = Fleetmodel::where('actived','=',1)->get();
      $sheet_active = 0;
      foreach ($jenis_kendaraan as $model) {

          $objPHPExcel->createSheet(NULL, $sheet_active);
          $objPHPExcel->setActiveSheetIndex($sheet_active);
          
          $objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

          $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN PENDAPATAN HARIAN TANGGAL ' . Myfungsi::fulldate(strtotime($date))  );
          $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);

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
          $objPHPExcel->getActiveSheet()->setCellValue('P6', 'STIKER BANDARA & KEAMANAN');
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
                            ->where('fleet_model_id','=',$model->id)
                            ->where_pool_id(Auth::user()->pool_id)
                            ->order_by('shift_id','asc')
                            //->order_by('shift_id','asc')
                            ->order_by('taxi_number','asc')->get();

          $no = 1;
          $starline = 8;
          foreach ($financials as $finan) {

            $bpkasuh = Anakasuh::where('status','=',1)->where('fleet_id','=',$finan->fleet_id)->first();

            $bs = ($finan->potongan >= $finan->setoran_wajib)? 'YA' : 'TIDAK'; 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, ($bpkasuh)? User::find($bpkasuh->user_id)->fullname : 'TIDAK ADA BAPAK ASUH' );
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $starline,  $finan->shift); //col X
            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $starline, $finan->shift_id);

            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, $finan->cicilan_lain);
            
            //hidden coloumn status operasi
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $starline,  $finan->operasi_status_id); //col Z
            

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
          
          
          /* Rekap Unit Operasi */
          $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 3), 'Unit Sirkulasi  :');
          $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 5), 'Unit Operasi  :');
          $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 6), 'Status  B P :');
          $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 7), 'Status  B L :');
          $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 8), 'Status  T D O (Lain-Lain):');


          $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 3), '=COUNT(Z8:Z'.$starline.')');
          $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 5), '=COUNTIF(Z8:Z'.$starline.', 1)');
          $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 6), '=COUNTIF(Z8:Z'.$starline.', 3)');
          $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 7), '=COUNTIF(Z8:Z'.$starline.', 7)');
          $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 8), '=I'.($starline + 3).'-(I'. ($starline + 5).'+ I'.($starline + 6).'+ I'.($starline + 7).')');
          
          /* Rekap KETEKORAN */
          $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 3), 'Total Ketekoran :');
          $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 5), 'KS Murni  :');
          $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 6), 'KS BP:');
          $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 7), 'KS BL :');
          $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 8), 'KS TDO (Lain-Lain):');


          $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 3), '=V'.($starline + 1));
          $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 5), '=SUMIF(Z8:Z'.$starline.',1,V8:V'.$starline.')');
          $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 6), '=SUMIF(Z8:Z'.$starline.',3,V8:V'.$starline.')');
          $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 7), '=SUMIF(Z8:Z'.$starline.',7,V8:V'.$starline.')');
          $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 8), '=L'.($starline + 3).'-(L'. ($starline + 5).'+ L'.($starline + 6).'+ L'.($starline + 7).')');
                  
          $objPHPExcel->getActiveSheet()->setCellValue('B'.($starline + 10), 'Tanggal Unduh');
          $objPHPExcel->getActiveSheet()->setCellValue('C'.($starline + 10), ':');
          $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 10), date('Y-m-d H:i:s'));

          $objPHPExcel->getSecurity()->setLockWindows(true);
          $objPHPExcel->getSecurity()->setLockStructure(true);
          $objPHPExcel->getSecurity()->setWorkbookPassword("FreeBlocking");
          $objPHPExcel->getActiveSheet()->getProtection()->setPassword('FreeBlocking');
          $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); // This should be enabled in order to enable any of the following!
          //$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
          $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
          //$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
         

          $objPHPExcel->getActiveSheet()->setTitle('Laporan '.$model->fleet_model.' - '. $date );
          $sheet_active++;
      }
      
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      //echo path('public');
      $objWriter->save(path('public').'Laporan-Harian-'.Pool::find(Auth::user()->pool_id)->pool_name.'-Tanggal-'.$date.'.xls');
      return Response::download(path('public').'Laporan-Harian-'.Pool::find(Auth::user()->pool_id)->pool_name.'-Tanggal-'.$date.'.xls', 'Laporan-Harian-'.Pool::find(Auth::user()->pool_id)->pool_name.'-Tanggal-'.$date.'.xls');
  
    }

    // report kas harian
    public function get_reportmonthly($date=false)
    { 
      Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Read report Kas', true);
      if(!$date) $date = date('Y-m-d');
      $timestamp = strtotime($date);
      $shifts = Shift::all();
      $shiftoption = Koki::to_dropdown($shifts,'id','shift');
      $this->data['shifts'] = $shiftoption + array('all'=>'Gabungan');
      return View::make('themes.modul.'.$this->report.'.monthreport',$this->data);
    }
    
    public function post_loaddatamonthly()
    { 
      $date = Input::get('dateops', date('Y-m-d'));
      $startdate = Input::get('startdateops', date('Y-m-01'));
      $pembagi = Input::get('pembagi', date('t'));
      $shift_id = Input::get('shift_id');
      $page = Input::get('page');
      $limit = Input::get('rows');
      $sidx = Input::get('sidx', 'operasi_time');
      $sord = Input::get('sord', 'asc');
       
      //$count = Driver::count();
      if($shift_id == 'all'){
        
         $count = DB::table('financial_report_summary_graf')
              //->where('year','=',date('Y',strtotime($date)))
              //->where('month','=',date('m',strtotime($date)))
              ->where('operasi_time','>=', $startdate)
              ->where('operasi_time','<=', $date)
              ->where_pool_id(Auth::user()->pool_id)
              ->count();
      }else{
        $count = DB::table('financial_report_summary')
              ->where('shift_id','=',$shift_id)
              //->where('year','=',date('Y',strtotime($date)))
              //->where('month','=',date('m',strtotime($date)))
              ->where('operasi_time','>=', $startdate)
              ->where('operasi_time','<=', $date)
              ->where_pool_id(Auth::user()->pool_id)
              ->count();
      }
     
      if( $count > 0 ) {
        $total_pages = ceil($count / $limit);
      } else {
        $total_pages = 0;
      } 
     
      if ($page > $total_pages) $page = $total_pages;

      $start = $limit * $page - $limit; 

      if($start < 0) $start = 0;

       if($shift_id == 'all'){
          $financials =  DB::table('financial_report_summary_graf')
              //->where('year','=',date('Y',strtotime($date)))
              //->where('month','=',date('m',strtotime($date)))
              ->where('operasi_time','>=', $startdate)
              ->where('operasi_time','<=', $date)
              ->where_pool_id(Auth::user()->pool_id)
              ->order_by($sidx,$sord)
              ->skip($start)
              ->take($limit)
              ->get();
       }else{
          $financials =  DB::table('financial_report_summary')
              ->where('shift_id','=',$shift_id)
              //->where('year','=',date('Y',strtotime($date)))
              //->where('month','=',date('m',strtotime($date)))
              ->where('operasi_time','>=', $startdate)
              ->where('operasi_time','<=', $date)
              ->where_pool_id(Auth::user()->pool_id)
              ->order_by($sidx,$sord)
              ->skip($start)
              ->take($limit)
              ->get();
       }      

      $responce['page'] = $page;
      $responce['total'] = $total_pages;
      $responce['records'] = $count;
      if($financials){
        $no= $start + 0; $ksavr = 0; $selisiavr = 0; $setoranopsavr = 0; $totalavr = 0; $cicilanksavr=0; $dendaavr=0; $cicilan_dp_ksoavr=0;
     
        foreach ($financials as $finan) {
          $no++;
          $responce['rows'][] = array(
                                  'no' => $no ,
                                  'operasi_time' => $finan->operasi_time ,
                                  //'taxi_number' => $finan->taxi_number ,
                                  //'nip' => $finan->nip ,
                                  //'name' => $finan->name ,
                                  //'checkin_time' => $finan->checkin_time ,
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
                                  //'operasi_status_id' => $finan->kode ,
                                  'total' => ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                    + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                    + $finan->hutang_dp_sparepart ) ),
                                  'setoranops' => ( $finan->setoran_cash - ($finan->biaya_cuci + $finan->iuran_laka)),
                                  );
          $dendaavr += $finan->denda;
          $cicilan_dp_ksoavr +=  $finan->cicilan_dp_kso;
          $cicilanksavr += $finan->cicilan_ks;
          $ksavr += $finan->setoran_cash - ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                    + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                    + $finan->hutang_dp_sparepart ) - $finan->potongan );
          $selisiavr += ($finan->selisi_ks);
          $setoranopsavr += ( $finan->setoran_cash - ($finan->biaya_cuci + $finan->iuran_laka));
          $totalavr += ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                    + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                    + $finan->hutang_dp_sparepart ) );
        }
      

        $responce['userdata']['ks']           = ($ksavr / ($count - 2));
        $responce['userdata']['selisi_ks']    = ($selisiavr / ($count - 2)) ;
        $responce['userdata']['setoranops']   = ($setoranopsavr / ($count - 2));
        $responce['userdata']['total']        = ($totalavr / ($count - 2) );
        $responce['userdata']['denda']        = ($dendaavr / ($count - 2));
        $responce['userdata']['cicilan_ks']   = ($cicilanksavr / ($count - 2));
        $responce['userdata']['cicilan_dp_kso'] = ($cicilan_dp_ksoavr / ($count - 2));
      }
      $responce['userdata']['operasi_time']  = 'Rata-rata:';

      return json_encode($responce);
       /**/
    }
    //export ke excell
    
    public function post_expkasharian()
    {
      $shift_id = Input::get('shift_id','all');
      $startdate = Input::get('startdateops', date('Y-m-01'));
      $date = Input::get('date',date('Y-m-d'));

      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()->setCreator(Auth::user()->fullname)
               ->setLastModifiedBy(Auth::user()->fullname)
               ->setTitle("Laporan Harian ".Pool::find(Auth::user()->pool_id)->pool_name. '-'.date('Y-m-d'))
               ->setSubject("Laporan Harian ".Pool::find(Auth::user()->pool_id)->pool_name. '-'.date('Y-m-d'))
               ->setDescription("Laporan harian operasi pool")
               ->setKeywords("Laporan Harian")
               ->setCategory("");

      $styleArray = array(
          'font'  => array(
              'bold'  => true,
              'color' => array('rgb' => 'FF0000'),
              'size'  => 16,
              //'name'  => 'Verdana'
      ));

      $jenis_kendaraan = Fleetmodel::where('actived','=',1)->get();
      $sheet_active = 0;

      if(Input::get('statusopsdef') == 'all'){
          
            //query export
            if($shift_id == 'all'){
              $financials =  DB::table('financial_report_summary_graf')
                  //->where('year','=',date('Y',strtotime($date)))
                  //->where('month','=',date('m',strtotime($date)))
                  ->where('operasi_time','>=', $startdate)
                  ->where('operasi_time','<=', $date)
                  //->where('fleet_model_id','=',$model->id)
                  ->where_pool_id(Auth::user()->pool_id)
                  ->order_by('operasi_time','asc')
                  ->get();

            }else{
                $financials =  DB::table('financial_report_summary')
                    ->where('shift_id','=',$shift_id)
                    //->where('year','=',date('Y',strtotime($date)))
                    //->where('month','=',date('m',strtotime($date)))
                    ->where('operasi_time','>=', $startdate)
                    ->where('operasi_time','<=', $date)
                    //->where('fleet_model_id','=',$model->id)
                    ->where_pool_id(Auth::user()->pool_id)
                    ->order_by('operasi_time','asc')
                    ->get();
             } 

            $objPHPExcel->createSheet(NULL, 0);
            $objPHPExcel->setActiveSheetIndex(0);
            
            $objPHPExcel->getActiveSheet()->mergeCells('A2:X2');

            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN PENDAPATAN PERIODE TANGGAL ' . Myfungsi::fulldate(strtotime($startdate)) .' - ' . Myfungsi::fulldate(strtotime($date)) .' Gabungan Armada');
            $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setVisible(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false);

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

            $objPHPExcel->getActiveSheet()->setCellValue('E5', 'TANGGAL OPERASI');
           
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
            $objPHPExcel->getActiveSheet()->setCellValue('P6', 'STIKER BANDARA & KEAMANAN');
            $objPHPExcel->getActiveSheet()->setCellValue('Q6', 'CUCI');
            $objPHPExcel->getActiveSheet()->setCellValue('R6', 'LAKA');

            $objPHPExcel->getActiveSheet()->setCellValue('S5', 'HARUS SETOR');
            $objPHPExcel->getActiveSheet()->setCellValue('T5', 'POTONGAN');
            $objPHPExcel->getActiveSheet()->setCellValue('U5', 'SETOR CASH');
            $objPHPExcel->getActiveSheet()->setCellValue('V5', 'KETEKORAN');
            $objPHPExcel->getActiveSheet()->setCellValue('W5', 'SETORAN OPS');
            $objPHPExcel->getActiveSheet()->setCellValue('X5', 'SHIFT');
       
        
            $no = 1;
            $starline = 8;
            foreach ($financials as $finan) {
              
              $ks = abs($finan->setoran_cash - ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                    + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                    + $finan->hutang_dp_sparepart ) - $finan->potongan ));

              $bs = 'Tidak'; 
              if($ks <= $finan->cicilan_ks){
                $bs = 'Ya'; 
              }

              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, '');
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $starline, $finan->nip);
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $starline, $finan->name);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $starline, $finan->operasi_time);
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $starline, $finan->kode);
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
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $starline,  $finan->shift); //col X
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $starline, $finan->shift_id);

              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, $finan->cicilan_lain);
              
              //hidden coloumn status operasi
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $starline,  $finan->operasi_status_id); //col Z
              

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


          $objPHPExcel->getActiveSheet()->setTitle('Laporan KAS '.date('d',strtotime($startdate)) . ' - '.  $date );

      }else{

        foreach ($jenis_kendaraan as $model) {

            //query export
            if($shift_id == 'all'){
              $financials =  DB::table('financial_report_sum_all')
                  //->where('year','=',date('Y',strtotime($date)))
                  //->where('month','=',date('m',strtotime($date)))
                  ->where('operasi_time','>=', $startdate)
                  ->where('operasi_time','<=', $date)
                  ->where('fleet_model_id','=',$model->id)
                  ->where_pool_id(Auth::user()->pool_id)
                  ->order_by('operasi_time','asc')
                  ->get();

            }else{
                $financials =  DB::table('financial_report_sum')
                    ->where('shift_id','=',$shift_id)
                    //->where('year','=',date('Y',strtotime($date)))
                    //->where('month','=',date('m',strtotime($date)))
                    ->where('operasi_time','>=', $startdate)
                    ->where('operasi_time','<=', $date)
                    ->where('fleet_model_id','=',$model->id)
                    ->where_pool_id(Auth::user()->pool_id)
                    ->order_by('operasi_time','asc')
                    ->get();
             } 

            $objPHPExcel->createSheet(NULL, $sheet_active);
            $objPHPExcel->setActiveSheetIndex($sheet_active);
            
            $objPHPExcel->getActiveSheet()->mergeCells('A2:X2');

            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN PENDAPATAN PERIODE TANGGAL ' . Myfungsi::fulldate(strtotime($startdate)) .' - ' . Myfungsi::fulldate(strtotime($date)) .' '.$model->fleet_model );
            $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setVisible(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false);

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

            $objPHPExcel->getActiveSheet()->setCellValue('E5', 'TANGGAL OPERASI');
           
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
            $objPHPExcel->getActiveSheet()->setCellValue('P6', 'STIKER BANDARA & KEAMANAN');
            $objPHPExcel->getActiveSheet()->setCellValue('Q6', 'CUCI');
            $objPHPExcel->getActiveSheet()->setCellValue('R6', 'LAKA');

            $objPHPExcel->getActiveSheet()->setCellValue('S5', 'HARUS SETOR');
            $objPHPExcel->getActiveSheet()->setCellValue('T5', 'POTONGAN');
            $objPHPExcel->getActiveSheet()->setCellValue('U5', 'SETOR CASH');
            $objPHPExcel->getActiveSheet()->setCellValue('V5', 'KETEKORAN');
            $objPHPExcel->getActiveSheet()->setCellValue('W5', 'SETORAN OPS');
            $objPHPExcel->getActiveSheet()->setCellValue('X5', 'SHIFT');
       
        
            $no = 1;
            $starline = 8;
            foreach ($financials as $finan) {
              
              $ks = abs($finan->setoran_cash - ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                    + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                    + $finan->hutang_dp_sparepart ) - $finan->potongan ));

              $bs = 'Tidak'; 
              if($ks <= $finan->cicilan_ks){
                $bs = 'Ya'; 
              }

              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, '');
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $starline, $finan->nip);
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $starline, $finan->name);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $starline, $finan->operasi_time);
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $starline, $finan->kode);
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
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $starline,  $finan->shift); //col X
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $starline, $finan->shift_id);

              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, $finan->cicilan_lain);
              
              //hidden coloumn status operasi
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $starline,  $finan->operasi_status_id); //col Z
              

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


          $objPHPExcel->getActiveSheet()->setTitle('Laporan KAS '.date('d',strtotime($startdate)) . ' - '.  $date );
          $sheet_active++;
        }
      } //end if gabungan
      
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save(path('public').'Laporan-KAS-'.Pool::find(Auth::user()->pool_id)->pool_name.'.xls');
      return Response::download(path('public').'Laporan-KAS-'.Pool::find(Auth::user()->pool_id)->pool_name.'.xls', 'Laporan-KAS-'.Pool::find(Auth::user()->pool_id)->pool_name.'.xls');

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

      $ksoaktif = Kso::where('actived','=',1)->where('pool_id','=',Auth::user()->pool_id)->get();
      $datakso =array();
      foreach ($ksoaktif as $kso) {
        $datakso[] = $kso->id; 
      }

      $date = strtotime($date);
      //$count = Driver::count();
      $count = DB::table('financial_report_monthly_bykso')
              ->where('month','=',date('n',$date))
              ->where('year','=',date('Y',$date))
              ->where_pool_id(Auth::user()->pool_id)
              ->where_in('kso_id', $datakso)
              ->count();
      
      
      if( $count > 0 ) {
        $total_pages = ceil($count / $limit);
      } else {
        $total_pages = 0;
      } 
     
      if ($page > $total_pages) $page = $total_pages;

      $start = $limit * $page - $limit; 

      if($start < 0) $start = 0;

      $financials =  DB::table('financial_report_monthly_bykso')
                      ->where('month','=',date('n',$date))
                      ->where('year','=',date('Y',$date))
                      ->where_in('kso_id', $datakso)
                      ->where_pool_id(Auth::user()->pool_id)
                      ->order_by($sidx,$sord)
                      ->skip($start)
                      ->take($limit)
                      ->get();
      
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

    public function get_downloadreportbs($date=false)
    {
      if(!$date) $date = date('Y-m-d');
      $ksos = Kso::where('pool_id','=', Auth::user()->pool_id)->where('actived','=',1)->get(); 
      $ksoaktif = array();
      foreach ($ksos as $xkso) {
        $ksoaktif[] = $xkso->id;
      }

      $financials =  DB::table('financial_report_monthly_bykso')
                      ->where('month','=', date('n', strtotime($date)))
                      ->where('year','=', date('Y', strtotime($date)))
                      ->where_pool_id(Auth::user()->pool_id)
                      ->where_in('kso_id', $ksoaktif)
                      ->order_by('taxi_number','asc')->get();
      
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()->setCreator(Auth::user()->fullname)
               ->setLastModifiedBy(Auth::user()->fullname)
               ->setTitle("Laporan Harian ".Pool::find(Auth::user()->pool_id)->pool_name. '-'.date('Y-m-d'))
               ->setSubject("Laporan Harian ".Pool::find(Auth::user()->pool_id)->pool_name. '-'.date('Y-m-d'))
               ->setDescription("Laporan harian operasi pool")
               ->setKeywords("Laporan Harian")
               ->setCategory("");

          $objPHPExcel->createSheet(NULL, 0);
          $objPHPExcel->setActiveSheetIndex(0);
          
          //$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);
          //$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false);

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
          $objPHPExcel->getActiveSheet()->setCellValue('P6', 'STIKER BANDARA & KEAMANAN');
          $objPHPExcel->getActiveSheet()->setCellValue('Q6', 'CUCI');
          $objPHPExcel->getActiveSheet()->setCellValue('R6', 'LAKA');

          $objPHPExcel->getActiveSheet()->setCellValue('S5', 'HARUS SETOR');
          $objPHPExcel->getActiveSheet()->setCellValue('T5', 'POTONGAN');
          $objPHPExcel->getActiveSheet()->setCellValue('U5', 'SETOR CASH');
          $objPHPExcel->getActiveSheet()->setCellValue('V5', 'KETEKORAN');
          $objPHPExcel->getActiveSheet()->setCellValue('W5', 'SETORAN OPS');
          $objPHPExcel->getActiveSheet()->setCellValue('X5', 'SELISIH');
     
      
          $no = 1;
          $starline = 8;
          foreach ($financials as $finan) {
            
            $ks = abs($finan->setoran_cash - ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                  + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                  + $finan->hutang_dp_sparepart ) - $finan->potongan ));

            $bs = 'Tidak'; 
            if($ks <= $finan->cicilan_ks){
              $bs = 'Ya'; 
            }

            $bpkasuh = Anakasuh::where('status','=',1)->where('fleet_id','=',$finan->fleet_id)->first();

            $bravo = Kso::find($finan->kso_id);
            
            $nip = 'NN';
            $bravonama = 'NN';
            
            if($bravo){

              $oxx = Driver::find($bravo->bravo_driver_id);
              if($oxx){
                $nip = $oxx->nip;
                $bravonama = $oxx->name;
              } 
            }

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, ($bpkasuh)? User::find($bpkasuh->user_id)->fullname : 'TIDAK ADA BAPAK ASUH');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $starline, $nip );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $starline, $bravonama );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $starline, $finan->taxi_number);
            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $starline, $finan->kode);
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
            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $starline,  $finan->shift); //col X
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $starline, '=V'.$starline.'+ L'.$starline);

            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, $finan->cicilan_lain);
            
            //hidden coloumn status operasi
            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $starline,  $finan->operasi_status_id); //col Z
            

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


      $objPHPExcel->getActiveSheet()->setTitle('Laporan BS '. $date );

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save(path('public').'Laporan-BS-'.Pool::find(Auth::user()->pool_id)->pool_name.'.xls');
      return Response::download(path('public').'Laporan-BS-'.Pool::find(Auth::user()->pool_id)->pool_name.'.xls', 'Laporan-BS-'.Pool::find(Auth::user()->pool_id)->pool_name.'.xls');

    }


    function left($str, $length) {
      return substr($str, 0, $length);
    }

    function right($str, $length) {
        return substr($str, -$length);
    }

    function textFormat($arrayData, $maxchar)
    {
      $maxchar = 40;
      $text = '';
      foreach($arrayData as $key => $val){
        if (is_numeric($val)) {
          $newval = number_format( $val, 0, '', '.');
          $koma = ",-";
        } else {
          $newval = $val;
          $koma = "-";
        }
        

        $space = $maxchar - (strlen($key) + strlen($newval) + 2);

        $text .= $this->left($key, strlen($key));
        $text .= str_repeat(" ", $space);
        $text .= $this->right($newval, strlen($newval)); 
        $text .= $koma;
        $text .= ("\r\n");
      }
      return $text;
    }


    //hapus operasi
    public function post_deleteops()
    { 
      Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Mengapus histori setoran', true);
      $data = Input::json();
      $checkin = Checkin::find($data->checkin_id);
      Checkout::where('operasi_time','=',$checkin->operasi_time)->where('fleet_id','=',$checkin->fleet_id)->first()->delete();
      $checkin->delete();

      return json_encode(array('status'=>1));
    }
}