<?php

class Tools_Controller extends Base_Controller {

	public $restful = true;
	public $views = 'tools';
  	public $report = 'tools.report';
	
	public function get_index()
	{	
		
	}

	public function get_exportcheckin()
	{	
		$date = Input::get('tanggal', date('Y-m-d'));

		$checkins = Checkin::join('fleets as f', 'f.id', '=', 'checkins.fleet_id' )
					->join('drivers as d', 'd.id', '=', 'checkins.driver_id')
	                ->where_operasi_time($date)
	                ->where('checkins.pool_id','=',Auth::user()->pool_id)
	                ->order_by('f.taxi_number','asc')
	                ->get(array('f.taxi_number','d.nip','d.name','checkins.*'));
	    $this->data['tanggal'] = $date;
	    $this->data['checkins'] = $checkins;
  		return View::make('themes.modul.'.$this->views.'.expcheckin',$this->data);
	}

	public function get_downloadformat($date=false)
	{
		if(!$date) $date = date('Y-m-d');

		$financials =  DB::table('financial_report_daily')->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->order_by('taxi_number','asc')->get();
      
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
      $objPHPExcel->getActiveSheet()->mergeCells('S5:S6');
      $objPHPExcel->getActiveSheet()->mergeCells('T5:T6');
      $objPHPExcel->getActiveSheet()->mergeCells('U5:U6');
      $objPHPExcel->getActiveSheet()->mergeCells('V5:V6');
      $objPHPExcel->getActiveSheet()->mergeCells('W5:W6');

      
      $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO');
      $objPHPExcel->getActiveSheet()->setCellValue('B5', 'ID CHECKIN');
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
      $objPHPExcel->getActiveSheet()->setCellValue('W5', 'KETERANGAN');
      
      $no = 1;
      $starline = 8;
      foreach ($financials as $finan) {
        $bs = ($finan->potongan >= $finan->setoran_wajib)? 'YA' : 'TIDAK'; 
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, $finan->id);
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
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $starline,'=(U'.$starline.'-(S'.$starline.'-T'.$starline.'))');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $starline, '');
        

        $no ++;
        $starline ++;
      }
      
      $objPHPExcel->getActiveSheet()->getStyle('A5:W'.($starline))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
      $objPHPExcel->getActiveSheet()->getStyle('A5:W6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle('A5:W'.($starline))->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle('A'.($starline).':W'.($starline))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
     
      $objPHPExcel->getActiveSheet()->setTitle('Laporan Harian Tgl '. $date);
     
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      //echo path('public');
      $objWriter->save(path('public').'format_uload.xlsx');
      return Response::download(path('public').'format_uload.xlsx');
  

	}
	public function get_uploadsetoran()
	{
		return View::make('themes.modul.'.$this->views.'.uploadsetoran',$this->data);
	}

	public function post_uploadsetoran()
	{
		Input::upload('datasetoran', path('public'), 'upload.xlsx');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel = PHPExcel_IOFactory::load(path('public').'upload.xlsx');

		$arrayst = array(	1 	=> 7, 
			    					2 	=> 8,
			    					3 	=> 9,
			    					4	=> 19,
			    					5	=> 12,
			    					6 	=> 11,
			    					7	=> 16,
			    					8 	=> 17,
			    					9 	=> 13,
			    					10	=> 14,
			    					11	=> 21,
			    					12	=> 15,
			    					13	=> 10,
			    					20 	=> 20,
			    					//21 	=> 
			    				);
		$startline = 8;
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		    $worksheetTitle     = $worksheet->getTitle();
		    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
		    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		    $nrColumns = ord($highestColumn) - 64;
		    echo "<br>The worksheet ".$worksheetTitle." has ";
		    echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
		    echo ' and ' . $highestRow . ' row.';
		    echo '<br>Data: <table border="1"><tr>';
		    for ($row = $startline; $row <= $highestRow; ++ $row) {
		    	
		    	$cell = $worksheet->getCellByColumnAndRow(1, $row);
		        $val = $cell->getValue();
		        $checkin = Checkin::find($val);		            
			    
		    	if($checkin){

		    			foreach ($arrayst as $financial_type_id => $cellinexcell) {
		    				$cell = $worksheet->getCellByColumnAndRow($cellinexcell, $row);
				            $val = $cell->getValue();
			    			$payment = Checkinfinancial::where_checkin_id($checkin->id)->where_financial_type_id($financial_type_id)->first();
				              if($payment){
				                $payment->amount =  $val;
				                $payment->save();  
				              }else{
				                $payment = Checkinfinancial::create(array(
				                        'checkin_id'=> $checkin->id, 
				                        'financial_type_id'=> $financial_type_id, 
				                        'amount'=> $val));
				              }
		    			}

		    			

			        echo '<tr>';
			        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			            echo '<td>' . $val . ' '. $col . '</td>';
			        }
			        echo '</tr>';
			    }
		    }
		    echo '</table>';
		}
	}

	//reset checkin 
	public function get_resetcheckin()
	{
		
	}

	public function get_toolspj()
	{
		
		return View::make('themes.modul.'.$this->views.'.spj',$this->data);
	}

	//cetak_spj_all
	public function post_toolspj()
	{
		$date = Input::get('tanggal',date('Y-m-d'));

		ini_set('max_execution_time', 120);

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
	                  //->where('schedule_dates.fg_check','=',0)
	                  ->where('schedule_dates.shift_id','=',1)
	                  ->where('ksos.actived','=',1)
	                  ->order_by('fleets.taxi_number','asc')
	                  ->get(array('schedule_dates.id as id','schedule_dates.driver_id','schedules.fleet_id','fleets.taxi_number'));
	      }

	      if($fleets)
	      {
	      	foreach ($fleets as $f) {
	      		
	      		$scheduledate = Scheduledate::find($f->id);
			    $scheduledate->fg_check = 1;
			    $scheduledate->save();

			    $schedule = Schedule::find($scheduledate->schedule_id);
			    
				//$driverinfo = Driver::find($scheduledate->driver_id);
			    //$fleetinfo = Fleet::find($schedule->fleet_id);
			    $ksoinfo = Kso::where_fleet_id($schedule->fleet_id)->where_actived(1)->first();

			    $dateopertion = mktime(0, 0, 0, $schedule->month, $scheduledate->date, $schedule->year);
    			
    			$checkouts = Checkout::where_fleet_id($schedule->fleet_id)
                  ->where_operasi_time(date('Y-m-d', $dateopertion))
                  ->first();
               	//delete checkouts
                
                if($checkouts){
                	$checkouts->delete();
                }


                $codeops = 1;
                $status = 7;
                $keterangan = 'Print SPJ melalui Tools';

               	if(!$checkouts)
			    {
			      //insert into to checkouts step
			      $checkouts = new Checkout;
			      $checkouts->kso_id = $ksoinfo->id;
			      $checkouts->operasi_time = date('Y-m-d', $dateopertion);
			      $checkouts->fleet_id = $schedule->fleet_id;        
			      $checkouts->driver_id = $scheduledate->driver_id;    
			      $checkouts->checkout_step_id = $status;
			      $checkouts->shift_id = $scheduledate->shift_id;
			      $checkouts->user_id = Auth::user()->id;
			      $checkouts->pool_id = Auth::user()->pool_id;
			      $checkouts->printspj_time = date('Y-m-d H:i:s',Myfungsi::sysdate());
			      $checkouts->operasi_status_id = $codeops;
			      $checkouts->keterangan = $keterangan;
			      $checkouts->save();

			      $cinada = Checkin::where('operasi_time','=',date('Y-m-d', $dateopertion))
			      					->where('fleet_id','=',$schedule->fleet_id)->first();
			      if($cinada){
			      	$cinada->delete();
			  		}

			      	if(!$cinada){              
			              $cin = Checkin::create(array(
			                'kso_id' => $ksoinfo->id,
			                'fleet_id' => $schedule->fleet_id,
			                'driver_id' => $scheduledate->driver_id,
			                'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
			                'shift_id' => $scheduledate->shift_id,
			                'km_fleet' => 0,
			                'rit' => 0,
			                'incomekm' => 0,
			                'operasi_time' => date('Y-m-d', $dateopertion),
			                'pool_id' => Auth::user()->pool_id,
			                'operasi_status_id' => $codeops,
			                'fg_late' => '',
			                'checkin_step_id' => 2,
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

			                //return Redirect::to('schedule');
			              }

			                 //
			     	}
			    }
	      	}
	      	return Redirect::to('schedule');
	      }


	}


	public function get_printest()
	{
		
		return View::make('themes.modul.'.$this->views.'.printest',$this->data);
	}
}