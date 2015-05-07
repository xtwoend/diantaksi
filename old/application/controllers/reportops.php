<?php

class Reportops_Controller extends Base_Controller {

	public $restful = true;
  	public $views = 'report';

	public function get_index()
	{	
		  $shifts = Shift::all();
      $shiftoption = Koki::to_dropdown($shifts,'id','shift');
      $this->data['shifts'] = $shiftoption + array('all'=>'Gabungan');
   
    	return View::make('themes.modul.'.$this->views.'.reportarmada',$this->data);
	}

	public function post_reporthutang()
	{	
		$msg 		= null;
    $pool_id = Auth::user()->pool_id;

		$date 		= Input::get('dateops', date('Y-m-d'));
	    $shift_id 	= Input::get('shift_id');
	    $page 		= Input::get('page');
	    $limit 		= Input::get('rows');
	    $sidx 		= Input::get('sidx', 'operasi_time');
	    $sord 		= Input::get('sord', 'asc');

	    if($shift_id == 'all'){
	    	$count = Checkin::join('ksos','ksos.id','=', 'kso_id')->where('checkins.operasi_time','<=', $date)->where('ksos.pool_id','=',Auth::user()->pool_id)->where('ksos.actived','=',1)->group_by('kso_id')->count();	
      	}else{
        	$count = Checkin::join('ksos','ksos.id','=', 'kso_id')->where('checkins.operasi_time','<=', $date)->where('checkins.shift_id','=',$shift_id)->where('ksos.pool_id','=',Auth::user()->pool_id)->where('ksos.actived','=',1)->group_by('kso_id')->count();	
		}

		if( $count > 0 ) {
	        $total_pages = ceil($count / $limit);
	   	} else {
	        $total_pages = 0;
	    } 
	     
	    if ($page > $total_pages) $page = $total_pages;

	    $start = $limit * $page - $limit; 

	    if($start < 0) $start = 0;

	  
      $saldohutangbymonth = $this->sqlData($date, $pool_id, $shift_id, $start, $limit);
      
      $responce['page'] = $page;
      $responce['total'] = $total_pages;
      $responce['records'] = $count;
      if($saldohutangbymonth){
        
        $no= $start + 1; $ksavr = 0; $selisiavr = 0; $setoranopsavr = 0; $totalavr = 0; $cicilanksavr=0; $dendaavr=0; $cicilan_dp_ksoavr=0;
     
        foreach ($saldohutangbymonth as $finan) {
        	$saldosp = ($finan->tabungan_sparepart + $finan->hutang_dp_sparepart + $finan->cicilan_sparepart) - $finan->pemakaian_part;
          $responce['rows'][] = array(
                                  'no' 				=> $no++ ,
                                  'taxi_number' 	=> ($c = Fleet::find($finan->fleet_id))? $c->taxi_number: 'Body Error',
                                  'bravo' 			=> ($b = Driver::find($finan->bravo_driver_id))? $b->name: 'Bravo Error',
                                  'shift_id' 		=> Shift::find($finan->shift_id)->shift,
                                  'pemakaian_sp' 	=> $finan->pemakaian_part,
                                  'tabungan_sp' 	=> $finan->tabungan_sparepart,
                                  'bayar_sp'		=> $finan->hutang_dp_sparepart + $finan->cicilan_sparepart,
                                  'saldo_sp'		=> $saldosp,
                                  'ks' 				=> $finan->ks,
                                  'bayar_ks' 		=> $finan->cicilan_ks,
                                  'selisi_ks' 		=> $finan->selisi_ks,
                                  'saldo_armada' 	=> $saldosp + $finan->selisi_ks, 
                                  );
        }
      }

      return json_encode($responce);
	}


	//export to excel
	public function post_exphutangarmada()
	{
		$input = Input::all();
    $shift = 'all';
		$saldohutangbymonth = $this->allQuery($input['date'], Auth::user()->pool_id, $shift, 0, 1000);
		if($saldohutangbymonth){

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
        $sheet_active = 0;

        $objPHPExcel->createSheet(NULL, $sheet_active);
        $objPHPExcel->setActiveSheetIndex($sheet_active);

        //title 
        $objPHPExcel->getActiveSheet()->mergeCells('A2:J2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN HUTANG ARMADA PER TANGGAL ' . Myfungsi::fulldate(strtotime($input['date']))  );
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);

          // Coloum header
          $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
          $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
          $objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
          $objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
          $objPHPExcel->getActiveSheet()->mergeCells('F5:I5');
          $objPHPExcel->getActiveSheet()->mergeCells('J5:L5');
          $objPHPExcel->getActiveSheet()->mergeCells('M5:O5');
         
          $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO');
          $objPHPExcel->getActiveSheet()->setCellValue('B5', 'BAPAK ASUH');
          $objPHPExcel->getActiveSheet()->setCellValue('C5', 'PENGEMUDI');
          $objPHPExcel->getActiveSheet()->setCellValue('C6', 'NIP');
          $objPHPExcel->getActiveSheet()->setCellValue('D6', 'NAMA');
          $objPHPExcel->getActiveSheet()->setCellValue('E5', 'BODY');

         
          $objPHPExcel->getActiveSheet()->setCellValue('F5', 'PEMAKAIAN SPAREPART ARMADA');
          $objPHPExcel->getActiveSheet()->setCellValue('F6', 'PEMAKAIAN');
          $objPHPExcel->getActiveSheet()->setCellValue('G6', 'TABUNGAN');
          $objPHPExcel->getActiveSheet()->setCellValue('H6', 'BAYAR');
          $objPHPExcel->getActiveSheet()->setCellValue('I6', 'SELISIH');

          $objPHPExcel->getActiveSheet()->setCellValue('J5', 'SETORAN ARMADA');
          $objPHPExcel->getActiveSheet()->setCellValue('J6', 'KS');
          $objPHPExcel->getActiveSheet()->setCellValue('K6', 'BAYAR KS');
          $objPHPExcel->getActiveSheet()->setCellValue('L6', 'SELISIH');

          $objPHPExcel->getActiveSheet()->setCellValue('M5', 'SALDO ARMADA');
          $objPHPExcel->getActiveSheet()->setCellValue('M6', 'SALDO SPAREPART');
          $objPHPExcel->getActiveSheet()->setCellValue('N6', 'SALDO KS');
          $objPHPExcel->getActiveSheet()->setCellValue('O6', 'SALDO AKHIR');

          $objPHPExcel->getActiveSheet()->setCellValue('P5', 'SHIFT');
          
          $no = 1;
          $starline = 8;
          foreach ($saldohutangbymonth as $saldo) {
          	
          	$bpkasuh = Anakasuh::where('status','=',1)->where('fleet_id','=',$saldo->fleet_id)->first();
          	$bravo = Driver::find($saldo->bravo_driver_id);
          	$saldosp = ($saldo->tabungan_sparepart + $saldo->hutang_dp_sparepart + $saldo->cicilan_sparepart) - $saldo->pemakaian_part;

          	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, ($bpkasuh)? User::find($bpkasuh->user_id)->fullname : 'TIDAK ADA BAPAK ASUH' );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $starline, ($bravo)? $bravo->nip: 'NONE');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $starline, ($bravo)? $bravo->name: 'NONE');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $starline, $saldo->taxi_number );
            //pemakaikan sp
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $starline, $saldo->pemakaian_part);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $starline, $saldo->tabungan_sparepart);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $starline, $saldo->hutang_dp_sparepart + $saldo->cicilan_sparepart);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $starline, $saldosp);
            //setoran armada
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $starline, $saldo->ks);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $starline, $saldo->cicilan_ks);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $starline, $saldo->selisi_ks);

            //saldo armada
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $starline, $saldosp);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $starline, $saldo->selisi_ks);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, ($saldosp + $saldo->selisi_ks) );
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $starline, $saldo->shift_id );


            $no++;
            $starline++;
          }

          $objPHPExcel->getActiveSheet()->getStyle('A5:O'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
          $objPHPExcel->getActiveSheet()->getStyle('A5:O6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $objPHPExcel->getActiveSheet()->getStyle('A5:O'.($starline + 1))->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $objPHPExcel->getActiveSheet()->getStyle('A'.($starline + 1).':O'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

          //end

          //SET TANGGAL UNDUH DAN PASSWORD
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
          //END

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      	$objWriter->save(path('public').'Laporan-hutang-armada.xls');
      	return Response::download(path('public').'Laporan-hutang-armada.xls');

      	}//end if
 		//var_dump($saldohutangbymonth); 
	}
	
	public function sqlQuery($shift_id=1, $date = null , $start=0, $limit=1000)
	{	
		if($date === null) $date = date('Y-m-d');
		if($shift_id == 'all'){
          $saldohutangbymonth = DB::query("select 
								cin.kso_id,
								cin.fleet_id,
								cin.id,
								cin.shift_id,
								f.taxi_number,
								cf.checkin_id,
								k.bravo_driver_id,
								sp.pemakaian_part,						
								sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
								sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
								sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
								sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
								sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
								(sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
								from checkins cin 
								left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
								join fleets f on (cin.fleet_id = f.id)
								join ksos k on (cin.kso_id = k.id)
								left join (
                  select 
                    wo.id,wo.kso_id,wo.inserted_date_set,
                    sum((part.qty * part.price)) as pemakaian_part
                    from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id )
                    where wo.status = 3 and part.telah_dikeluarkan = 1 and wo.beban = 0
                    and DATE_FORMAT(wo.inserted_date_set,'%Y-%m-%d') <= ? 
                    group by wo.kso_id 
                ) as sp ON ( sp.kso_id = cin.kso_id)
                where cin.operasi_time <= ?
								and cin.pool_id = ?
								and k.actived = 1
								group by cin.kso_id
								order by f.taxi_number asc
								limit ? , ?								
								", array($date, $date, Auth::user()->pool_id, $start, $limit));
       	}else{
            $saldohutangbymonth = DB::query("select 
								cin.kso_id,
								cin.fleet_id,
								cin.id,
								cin.shift_id,
								f.taxi_number,
								cf.checkin_id,
								k.bravo_driver_id,
								sp.pemakaian_part,
								sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
								sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
								sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
								sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
								sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
								(sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
								from checkins cin 
								left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
								join fleets f on (cin.fleet_id = f.id)
								join ksos k on (cin.kso_id = k.id)
								left join (
                  select 
                    wo.id,wo.kso_id,wo.inserted_date_set,
                    sum((part.qty * part.price)) as pemakaian_part
                    from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id )
                    where wo.status = 3 and part.telah_dikeluarkan = 1 and wo.beban = 0
                    and DATE_FORMAT(wo.inserted_date_set,'%Y-%m-%d') <= ? 
                    group by wo.kso_id 
                ) as sp ON ( sp.kso_id = cin.kso_id)

								where cin.operasi_time <= ?
								and cin.pool_id = ?
								and cin.shift_id = ?
								and k.actived = 1
								group by cin.kso_id
								order by f.taxi_number asc
								limit ? , ?
								", array($date, $date, Auth::user()->pool_id, $shift_id , $start, $limit));
       	}   

       	return $saldohutangbymonth;
	}

  //report setoran armada bulanan

  public function get_rekapsetoran()
  {
      $shifts   = Shift::all();
      $pool_id  = Auth::user()->pool_id;
      $shiftoption = Koki::to_dropdown($shifts,'id','shift');
      $this->data['shifts'] = $shiftoption + array('all'=>'Gabungan');
      $this->data['fleets'] = Kso::join('fleets','fleets.id','=','ksos.fleet_id')->where('ksos.pool_id','=',$pool_id)->where('ksos.actived','=',1)->get(array('ksos.id','ksos.fleet_id', 'fleets.taxi_number'));

      return View::make('themes.modul.'.$this->views.'.rekapsetoranarmada',$this->data);
  }

  public function post_expreportsetoran()
  {
      //var_dump(Input::all());
      $mic_time = microtime();
      $mic_time = explode(" ",$mic_time);
      $mic_time = $mic_time[1] + $mic_time[0];
      $start_time = $mic_time;

      $date = Input::get('date');
      $shift = Input::get('shift_id');
      $all = Input::get('allbody', false);
      $fleets = Input::get('bodylist', array());

      $subdate = explode('/', $date);

      $month  = $subdate[0];
      $year   = $subdate[1];

      $newdate   = date("Y-m-t", strtotime($year .'-'.$month.'-01'));
      $pool_id = Auth::user()->pool_id;

      if($all){
        $fleets = array();
        $fleetsobj = Kso::where('pool_id','=',$pool_id)->where('actived','=',1)->get(array('id','fleet_id'));
        foreach ($fleetsobj as $sc) {
          $fleets[] = $sc->id; 
        }
      } 
      /*
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
      */
      $sheet_active = 0;
      $no = 1;
      $starline = 8;
      foreach ($fleets as $key => $kso_id) {
        /*
        $objPHPExcel->createSheet(NULL, $sheet_active);
        $objPHPExcel->setActiveSheetIndex($sheet_active);
        */
        $reports = DB::table('financial_report_daily')
              ->where('kso_id','=',$kso_id)
              ->where('operasi_time','>=', date("Y-m-01", strtotime($year .'-'.$month.'-01')) )
              ->where('operasi_time','<=', date("Y-m-t", strtotime($year .'-'.$month.'-01')) )
              ->order_by('operasi_time','asc')
              ->get();
        
        $data = $this->infoSaldo($kso_id, $newdate);
        /*
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline,  $data->saldoks );
        
        $objPHPExcel->getActiveSheet()->setTitle($data->taxi_number);
        $sheet_active++;
        */
      }
      /*
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save(path('public').'x.xls');
      */
      $mic_time = microtime();
      $mic_time = explode(" ",$mic_time);
      $mic_time = $mic_time[1] + $mic_time[0];
      $endtime = $mic_time;
      $total_execution_time = ($endtime - $start_time);
      return "Total Executaion Time ".$total_execution_time." seconds";

      //return Response::download(path('public').'x.xls', 'x.xls');
  }

  public function detailSetoran($kso_id, $startdate, $enddate)
  {
    
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
                f.taxi_number,
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
                join (
                  select 
                    fleets.taxi_number, fleets.id from fleets
                ) as f ON (f.id = cin.fleet_id) 
                where cin.operasi_time <= ? and cin.kso_id = ?
                group by cin.kso_id', array($date, $date, $kso_id ));


      return $saldo;
  }

  public function sqlData($date, $pool_id, $shift=1, $start=0, $limit=1000)
  {
    if($date === null) $date = date('Y-m-d');

    switch ($shift) {
      case 'all':
        return $this->allQuery($date, $pool_id, $shift, $start=0, $limit=1000);
        break;
      
      default:
        return $this->allQuery($date, $pool_id, $shift, $start=0, $limit=1000);
        break;
    }
    
  }

  public function sqlQueryCorections($date, $pool_id, $shift, $start, $limit)
  {
    
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
                      sum(if((cf.financial_type_id = 13),cf.amount,0)) AS hutang_dp_sparepart,
                      (sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
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
                      group by cin.kso_id
                      limit ? , ?",
            array(
              $pool_id, 
              $date,
              $date,
              $shift,
              $pool_id,
              $start,
              $limit
            ));
    
    return $sql;

  }

  public function allQuery($date, $pool_id, $shift, $start=0, $limit=1000)
  {
    
        $sql = DB::query("select 
                      cin.id AS id,
                      cin.kso_id AS kso_id,
                      cin.fleet_id AS fleet_id,
                      cin.shift_id AS shift_id,
                      cin.operasi_time AS operasi_time,
                      cin.operasi_status_id AS operasi_status_id,
                      cf.checkin_id AS checkin_id,
                      f.taxi_number,
                      k.bravo_driver_id,
                      sp.pemakaian_part,
                      sum(if((cf.financial_type_id = 2),cf.amount,0)) AS tabungan_sparepart,
                      sum(if((cf.financial_type_id = 5),cf.amount,0)) AS cicilan_sparepart,
                      sum(if((cf.financial_type_id = 6),cf.amount,0)) AS cicilan_ks,
                      sum(if((cf.financial_type_id = 9),cf.amount,0)) AS cicilan_dp_kso,
                      sum(if((cf.financial_type_id = 10),cf.amount,0)) AS cicilan_hutang_lama,
                      sum(if((cf.financial_type_id = 11),cf.amount,0)) AS ks,
                      sum(if((cf.financial_type_id = 13),cf.amount,0)) AS hutang_dp_sparepart,
                      (sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
                      from checkins cin 
                      left join checkin_financials cf on((cin.id = cf.checkin_id))
                      join fleets f on (cin.fleet_id = f.id)
                      join ksos k on (cin.kso_id = k.id)
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
                      and cin.kso_id in (select k.id  from ksos k where k.pool_id = ? and k.actived = 1)
                      group by cin.kso_id
                      order by taxi_number asc
                      limit ? , ?",
            array(
              $pool_id, 
              $date,
              $date,
              $pool_id,
              $start,
              $limit
            ));
    
    return $sql;

  }
}