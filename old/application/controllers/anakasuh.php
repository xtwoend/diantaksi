<?php

class Anakasuh_Controller extends Base_Controller {

	public $restful = true;
	public $views = 'anakasuh';
	public $report = 'anakasuh.report';

	public function get_index()
	{	
    
    	return View::make('themes.modul.'.$this->views.'.index',$this->data);
	}
  
	public function get_manage()
	{
		$pool_id = Auth::user()->pool_id;

		$this->data['userperpool'] = User::all();
		return View::make('themes.modul.'.$this->views.'.list',$this->data);
    
	}

	public function get_daftar($id=false)
	{
		if(!$id) return Redirect::to('anakasuh/manage');
			
			$this->data['userinfo'] = User::find($id);

      /*
		  $this->data['listanakasuh'] = Anakasuh::join('fleets', 'fleets.id', '=', 'anak_asuh.fleet_id')
                    								->where('anak_asuh.user_id','=',$id)
                    								->where('anak_asuh.status', '=', 1 )
                    								->get(array('anak_asuh.id','fleets.taxi_number', 'anak_asuh.fleet_id'));
      */
      $this->data['listanakasuh'] = Anakasuh::where('anak_asuh.user_id','=',$id)
                                    ->where('anak_asuh.status', '=', 1 )
                                    ->get(array('anak_asuh.id','anak_asuh.fleet_id'));
		return View::make('themes.modul.'.$this->views.'.manageanakasuh',$this->data);
	}
	public function get_addanakasuh($id=false)
	{
		if(!$id) return Redirect::to('anakasuh/manage');
		
		$pool_id = Auth::user($id)->pool_id;
		$fleets = Fleet::where_pool_id($pool_id)->order_by('taxi_number', 'asc')->get();

		$fleetsdata = array();
        foreach ($fleets as $fleet) {
              $fleetsdata[$fleet->id] = $fleet->taxi_number;
        }
        $this->data['fleets'] = $fleetsdata;
		$this->data['create'] = true;
		return View::make('themes.modul.'.$this->views.'.form',$this->data);
	}

	public function post_addanakasuh($id=false)
	{
		if(!$id) return Redirect::to('anakasuh/manage');
		
		$add = Anakasuh::create(array(
						'user_id' => $id,
						'fleet_id' => Input::get('fleet_id'),
						'start_date' => Input::get('start_date'),
						'status' => 1
			));
		if($add){
			return Redirect::to('anakasuh/daftar/'.$id);
		}
		
	}
	public function get_remove($id=false)
	{
		if(!$id) return Redirect::to('anakasuh/manage');

		$anakasuh = Anakasuh::find($id);
		$anakasuh->status = 0;
		$anakasuh->end_date = date('Y-m-d');
		$anakasuh->save();

		return Redirect::to('anakasuh/manage');
	}

	public function get_report()
	{
	  //report anak asuh per bapak asuh   
    $this->data['bapak_asuh'] = User::lists('first_name','id');
    return View::make('themes.modul.'.$this->report.'.report',$this->data);
	}

  public function post_report()
  {
      $tanggal = Input::get('date', date('Y-m-d'));

      foreach (User::where('pool_id','=',Auth::user()->pool_id)->get() as $u) {

        //foreach (Fleetmodel::where('actived','=',1)->get() as $model) {
            
            
            
            $ksos = Kso::join('anak_asuh','anak_asuh.fleet_id','=','ksos.fleet_id' )
                      ->join('fleets','fleets.id','=', 'ksos.fleet_id')
                      ->where('ksos.pool_id','=', Auth::user()->pool_id)
                      ->where('ksos.actived','=', 1)
                      ->where('anak_asuh.status','=', 1)
                      ->where('anak_asuh.user_id', '=', $u->id)
                     //->where('fleets.fleet_model_id', '=', $model->id)
                      ->get(array('ksos.id','ksos.fleet_id','ksos.bravo_driver_id','ksos.charlie_driver_id','anak_asuh.user_id','fleets.fleet_model_id'));
            

            if(!empty($ksos)){
                echo 'Bapak Asuh : '. $u->fullname;
               // echo '<br>Model : ' . $model->fleet_model; 
                echo '<table border=1>';
                echo '<tr>';
                echo '<td>No</td>';
                echo '<td>Body</td>';
                echo '<td>Pengemudi</td>';
                echo '<td>NIP</td>';
                echo '<td>Jadwal</td>';
                for($p=2; $p>=0; $p--){
                  echo '<td>KS bulan '.date("M, Y", strtotime($tanggal." -".$p." month")).'</td>';
                }
                echo '</tr>';
                $no = 1;
                foreach ($ksos as $x) {
                  
                  echo '<tr>';
                  echo '<td>'. $no++ .'</td>';
                  echo '<td>'.Fleet::find($x->fleet_id)->taxi_number.'</td>';
                  echo '<td>'.Driver::find($x->bravo_driver_id)->name.'</td>';
                  echo '<td>'.Driver::find($x->bravo_driver_id)->nip.'</td>';
                  echo '<td></td>';
                  //query 3 ks bulan terakhir
                  for($k=2; $k>=0; $k--){
                    $manualquery = DB::query('select 
                                            cin.*,
                                            cf.checkin_id,
                                            MONTHNAME(cin.operasi_time) as monthname,
                                            month(cin.operasi_time) as month,
                                            year(cin.operasi_time) as year,
                                            sum(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
                                            sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
                                            sum(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
                                            sum(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
                                            sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
                                            sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
                                            sum(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
                                            sum(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
                                            sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
                                            sum(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
                                            sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
                                            sum(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
                                            sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
                                            sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
                                            sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan,
                                            (sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
                                            from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
                                            where month(cin.operasi_time) = ? and
                                            year(cin.operasi_time) = ? and
                                            cin.driver_id = ?
                                            group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.operasi_status_id, cin.driver_id',
                                            array(
                                              date("n", strtotime($tanggal." -".$k." month")), 
                                              date("Y", strtotime($tanggal." -".$k." month")),
                                              $x->bravo_driver_id
                                              ));
                    //var_dump($manualquery);
                    /*
                    $selisih_ks = DB::table('financial_report_monthly_driver_status')
                                ->where('driver_id','=',$x->bravo_driver_id)
                                ->where('month','=', date("n", strtotime($tanggal." -".$k." month")) )
                                ->where('year', '=', date("Y", strtotime($tanggal." -".$k." month")) )
                                ->sum(array('selisi_ks'));
                    
                    echo '<td>'.$selisih_ks.'</td>';
                    */
                  }                  
                  
                  echo '</tr>';
                  
                  echo '<tr>';
                  echo '<td></td>';
                  echo '<td></td>';
                  echo '<td>';
                    $xc = Driver::find($x->charlie_driver_id);
                    if($xc) 
                      { echo $xc->name; } 
                    else 
                      { echo '-'; }
                  echo '</td>';
                  echo '<td>';
                    if($xc) 
                      { echo $xc->nip; } 
                    else 
                      { echo '-'; }
                  echo  '</td>';

                  echo '<td></td>';
                  //query 3 ks bulan terakhir
                  for($z=2; $z>=0; $z--){
                    
                    $selisih_ks = DB::table('financial_report_monthly_driver_status_temp')
                                ->where('driver_id','=',$x->charlie_driver_id)
                                ->where('month','=', date("n", strtotime($tanggal." -".$z." month")) )
                                ->where('year', '=', date("Y", strtotime($tanggal." -".$z." month")) )
                                ->sum(array('selisi_ks'));
                    
                    echo '<td>'.$selisih_ks.'</td>';
                    
                  }             
                  echo '</tr>';
                }
                echo '</table>';
          //  }
        } 
      }

      
      
  }

	//report untuk bapak asuh

	public function get_financialreport($user_id = false)
    { 
      Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Read report', true);

      if(!$user_id) $user_id = Auth::user()->id;
      $this->data['user_id'] = $user_id;
      return View::make('themes.modul.'.$this->report.'.dailyreport',$this->data);
    }

    public function get_reportdailyjson($date=false)
    { 
      if(!$date) $date = date('Y-m-d');
      $timestamp = strtotime($date);


      $report_daily = DB::table('financial_report_daily')->where_pool_id(Auth::user()->pool_id)->get();
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
      $page = Input::get('page');
      $limit = Input::get('rows');
      $sidx = Input::get('sidx', 'id');
      $sord = Input::get('sord');
        //selection fleet_id by bapak asuh
      $user_id = Input::get('user_id');
      $anakasuh = Anakasuh::where('user_id','=',$user_id)->where('status','=',1)->get();
      $fleets = array();
            foreach ( $anakasuh as $fleet) {
                array_push($fleets, $fleet->fleet_id);
            }
      if(!$anakasuh) return false;
      //$count = Driver::count();
      $count = DB::table('financial_report_daily')->where_in('fleet_id',$fleets)->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->count();
      
      if( $count > 0 ) {
        $total_pages = ceil($count / $limit);
      } else {
        $total_pages = 0;
      } 
     
      if ($page > $total_pages) $page = $total_pages;

      $start = $limit * $page - $limit; 

      if($start < 0) $start = 0;

      $financials =  DB::table('financial_report_daily')->where_in('fleet_id',$fleets)->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->order_by($sidx,$sord)->skip($start)->take($limit)->get();
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
                                'status_operasi' => $finan->kode ,
                                'total' => ( ( $finan->setoran_wajib + $finan->tabungan_sparepart + $finan->denda + $finan->cicilan_sparepart  
                                  + $finan->cicilan_ks + $finan->biaya_cuci + $finan->iuran_laka + $finan->cicilan_dp_kso + $finan->cicilan_hutang_lama + $finan->cicilan_lain 
                                  + $finan->hutang_dp_sparepart ) ),
                                );
      }

      return json_encode($responce);
       /**/
    }

    public function get_sumreport($date=false, $user_id=false)
    {
        if(!$date) $date = date('Y-m-d');
        if(!$user_id) $user_id = Auth::user()->id;

        $anakasuh = Anakasuh::where('user_id','=',$user_id)->where('status','=',1)->get();
          $fleets = array();
                foreach ($anakasuh as $fleet) {
                    array_push($fleets, $fleet->fleet_id);
          }
        if(!$anakasuh) return false;
      
        $financials =  DB::table('financial_report_daily')->where_in('fleet_id',$fleets)->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->get();
        
        $setoran_cash = 0;
        $setoran_wajib = 0;
        $tabungan_sparepart = 0;
        $denda = 0;
        $potongan = 0;
        $cicilan_sparepart = 0;
        $cicilan_ks = 0;
        $biaya_cuci = 0;
        $iuran_laka = 0;
        $cicilan_dp_kso = 0;
        $cicilan_hutang_lama = 0;
        $cicilan_lain = 0;
        $hutang_dp_sparepart = 0;


        foreach ($financials as $fin) {
        	$setoran_cash = $setoran_cash + $fin->setoran_cash;
  		    $setoran_wajib = $setoran_wajib + $fin->setoran_wajib;
  		    $tabungan_sparepart = $tabungan_sparepart + $fin->tabungan_sparepart;
  		    $denda =  $denda + $fin->denda; 
  		    $potongan = $potongan + $fin->potongan;
  		    $cicilan_sparepart = $cicilan_sparepart + $fin->cicilan_sparepart;
  		    $cicilan_ks = $cicilan_ks + $fin->cicilan_ks;
  		    $biaya_cuci = $biaya_cuci + $fin->biaya_cuci;
  		    $iuran_laka = $iuran_laka + $fin->iuran_laka;
  		    $cicilan_dp_kso = $cicilan_dp_kso + $fin->cicilan_dp_kso;
  		    $cicilan_hutang_lama = $cicilan_hutang_lama + $fin->cicilan_hutang_lama;
  		    $cicilan_lain = $cicilan_lain  + $fin->cicilan_lain; 
  		    $hutang_dp_sparepart = $hutang_dp_sparepart + $fin->hutang_dp_sparepart;
        }

        $returndata = array(
                                  'setoran_cash' => $setoran_cash ,
                                  'setoran_wajib' => $setoran_wajib ,
                                  'tabungan_sparepart' => $tabungan_sparepart ,
                                  'denda' => $denda ,
                                  'potongan' => $potongan ,
                                  'cicilan_sparepart' => $cicilan_sparepart ,
                                  'cicilan_ks' => $cicilan_ks ,
                                  'biaya_cuci' => $biaya_cuci ,
                                  'iuran_laka' => $iuran_laka ,
                                  'cicilan_dp_kso' => $cicilan_dp_kso ,
                                  'cicilan_hutang_lama' => $cicilan_hutang_lama ,
                                  //'ks' => $finan->ks ,
                                  'ks' => $setoran_cash - ( ( $setoran_wajib + $tabungan_sparepart + $denda + $cicilan_sparepart  
                                    + $cicilan_ks + $biaya_cuci + $iuran_laka + $cicilan_dp_kso + $cicilan_hutang_lama + $cicilan_lain 
                                    + $hutang_dp_sparepart ) - $potongan ),
                                  'cicilan_lain' => $cicilan_lain ,
                                  'hutang_dp_sparepart' => $hutang_dp_sparepart ,
                                  'total' => ( ( $setoran_wajib + $tabungan_sparepart + $denda + $cicilan_sparepart  
                                    + $cicilan_ks + $biaya_cuci + $iuran_laka + $cicilan_dp_kso + $cicilan_hutang_lama + $cicilan_lain 
                                    + $hutang_dp_sparepart )),
                                  );

        return json_encode($returndata);
    }
    public function get_expreportdaily($date=false, $user_id = false)
    {
      if(!$date) $date = date('Y-m-d');
      if(!$user_id) $user_id = Auth::user()->id;
      $anakasu = Anakasuh::where('user_id','=',$user_id)->where('status','=',1)->get();
      if(!$anakasu) return false;
      $fleets = array();
            foreach ( $anakasu as $fleet) {
                array_push($fleets, $fleet->fleet_id);
            }
      $financials =  DB::table('financial_report_daily')->where_in('fleet_id',$fleets)->where('operasi_time','=',$date)->where_pool_id(Auth::user()->pool_id)->order_by('taxi_number','asc')->get();
      
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
      $objPHPExcel->getActiveSheet()->setCellValue('W5', 'KETERANGAN');
      
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
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $starline, '');
        

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

      $objPHPExcel->getActiveSheet()->getStyle('A5:W'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
      $objPHPExcel->getActiveSheet()->getStyle('A5:W6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle('A5:W'.($starline + 1))->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle('A'.($starline + 1).':W'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

      /*
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, 'Some value');
      
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Hello');
      $objPHPExcel->getActiveSheet()->setCellValue('B2', 'world!');
      $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Hello');
      $objPHPExcel->getActiveSheet()->setCellValue('D2', 'world!');
      */
      $objPHPExcel->getActiveSheet()->setTitle('Laporan Harian Tgl '. $date);
      
     
      $objPHPExcel->getSecurity()->setLockWindows(true);
      $objPHPExcel->getSecurity()->setLockStructure(true);
      $objPHPExcel->getSecurity()->setWorkbookPassword("FreeBlocking");
      $objPHPExcel->getActiveSheet()->getProtection()->setPassword('FreeBlocking');
      $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); // This should be enabled in order to enable any of the following!
      $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
      $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
      $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
      $objPHPExcel->setActiveSheetIndex(0);
      
      
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      //echo path('public');
      $objWriter->save(path('public').'Laporan-Harian-Tanggal-'.$date.'.xlsx');
      return Response::download(path('public').'Laporan-Harian-Tanggal-'.$date.'.xlsx', 'Laporan-Harian-Tanggal-'.$date.'.xlsx');
  
    }

   	public function get_financialreportcard()
   	{
   		return View::make('themes.modul.'.$this->views.'.fleets',$this->data);
   	}
   	public function get_fleetslist()
	  {
	    $pool_id = Auth::user()->pool_id;
	    $user_id = Auth::user()->id;
      	$fleets = array();
            foreach (Anakasuh::where('user_id','=',$user_id)->where('status','=',1)->get() as $fleet) {
                array_push($fleets, $fleet->fleet_id);
            }

	    $fleets = Fleet::where_pool_id($pool_id)->where_in('id',$fleets)->get(array('id','taxi_number'));
	    $fleetdata = array_map(function($object) {
	             return $object->to_array();
	    }, $fleets);
	        
	    $data['fleets'] = $fleetdata;
	    return json_encode($data);
	  }
	public function post_searchFleet()
  	{
	    $jsondata = Input::json();
	    $pool_id = Auth::user()->pool_id;
	    $user_id = Auth::user()->id;
	      	$fleets = array();
	            foreach (Anakasuh::where('user_id','=',$user_id)->where('status','=',1)->get() as $fleet) {
	                array_push($fleets, $fleet->fleet_id);
	            }

	    $fleets = Fleet::where_pool_id($pool_id)->where_in('id',$fleets)->where('taxi_number','LIKE','%'.$jsondata->taxi_number.'%')->get(array('id','taxi_number'));
	    $fleetdata = array_map(function($object) {
	             return $object->to_array();
	    }, $fleets);
	        
	    $data['fleets'] = $fleetdata;
	    return json_encode($data);
  	}

	public function get_findbyIdFleet($id=false)
	{
	    if(!$id) return false;
	    
	    $fleet = Fleet::find($id);
	    $kso = Kso::where_fleet_id($fleet->id)->first();
	       
	    $financial_fleet = DB::table('financial_report_bykso')->where('kso_id','=',$kso->id)->first();
	    $financial_fleet_part = DB::table('wo_financial_report_bykso')->where('kso_id','=',$kso->id)->first();

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

	    $fleetinfo = array(
	                  'id' => $fleet->id, 
	                  'police_number' => $fleet->police_number,
	                  'bravo' => Driver::find($kso->bravo_driver_id)->name,
	                  'taxi_number' => $fleet->taxi_number,
	                  'total_ks' => number_format($fleet_ks, 2,',','.'),
	                  'pembayaran_ks' => number_format($fleet_cicilan_ks, 2,',','.'),
	                  'tab_sparepart' => number_format($fleet_tabungan_sparepart, 2,',','.'),
	                  'dp_kso' => number_format($kso->dp, 2,',','.'),
	                  'hutang_dp_kso' => number_format($kso->sisa_dp, 2,',','.'),
	                  'pem_hutang_dp_kso' => number_format($fleet_cicilan_db_kso, 2,',','.'),
	                  'pem_sparepart' => number_format($total_pemakaian_part, 2,',','.'),
	                  'saldo_unit' => number_format((($fleet_cicilan_ks+$fleet_cicilan_db_kso + $kso->dp ) - ($fleet_ks + $kso->sisa_dp)) + (($fleet_tabungan_sparepart + $fleet_cicilan_sparepart + $fleet_dp_sparepart) - $total_pemakaian_part ), 2,',','.'),
	                  'pembayaran_sparepart' => $fleet_cicilan_sparepart + $fleet_dp_sparepart,
	                  'status'  => ($fleet->fg_blocked == 1 || $fleet->fg_bengkel == 1) ? 'Blocked' : 'Ready',
	      );
	   
	    $returndata = array(

	                  'fleetinfo' => $fleetinfo,
	    );
	    return json_encode($returndata);
	}



}	
