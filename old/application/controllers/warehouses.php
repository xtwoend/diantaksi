<?php

class Warehouses_Controller extends Base_Controller {

	public $restful = true;
  	public $views = 'warehouses';
  	public $report = 'warehouses.report';

  	public function get_index()
  	{
     	//$this->data['wos'] = Workorder::where_status(2)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get(); 
  		$this->data['wos'] = Workorder::where_status(1)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      $this->data['wosonworkings'] = Workorder::where_status(2)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      $this->data['wosonpanding'] = Workorder::where_status(4)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      $this->data['wosonfinish'] = Workorder::where_status(3)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->take(5)->get();
      
      return View::make('themes.modul.'.$this->views.'.index',$this->data);
  	}
  	public function get_partrequest($wo_id=false)
  	{
      
      if(!$wo_id) return false;
    
        $wo = Workorder::find($wo_id);
        $this->data['wo'] = $wo;
        $options = array();
        foreach (Statusperbaikan::all() as $k) {
          $options[$k->id] = $k->status;
        }
      $this->data['statusoptions'] = $options;
      $this->data['wo'] = Workorder::find($wo_id);
      $this->data['partitems'] = Wopart::where('wo_id', '=', $wo_id)->get();
      $this->data['wo_id_initem'] = $wo_id;
      $this->data['analisas'] = Woanalisa::where('wo_id','=',$wo_id)->get();

      return View::make('themes.modul.'.$this->views.'.partrequest',$this->data);
  	}

    public function get_laoditemrequest($wo_id=false)
    {
      if(!$wo_id) return false;
      $this->data['partitems'] = Wopart::where('wo_id', '=', $wo_id)->get();
      return View::make('themes.modul.'.$this->views.'.itempart',$this->data);
    }

  	public function get_part_item_remove($item_id = null, $wo_id = null)
    { 
      $s = Wopart::find($item_id);
      if($s->telah_dikeluarkan == 1){
        Trackinginventory::create(array(
                                          'pool_id' => Auth::user()->pool_id, 
                                          'sparepart_id' => $s->sparepart_id,
                                          'qty' => $s->qty,
                                          'user_id' => Auth::user()->id,
                                          'note' => 'Part di kembalikan melalui WO dengan id wo ' . $s->wo_id  . ' oleh '. Auth::user()->fullname
                                        ));
      }
      $s->delete();
    }

    public function get_approvedpart()
    {
    	
    	$this->data['wos'] = Workorder::where_status(2)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get(); 
  		return View::make('themes.modul.'.$this->views.'.partapprove',$this->data);
    }

    public function get_approvedpartdetail($wo_id=false)
    {
    	
    	if(!$wo_id) return false;
    
	      $wo = Workorder::find($wo_id);
	      $this->data['wo'] = $wo;
	      $options = array();
	      foreach (Statusperbaikan::all() as $k) {
	        $options[$k->id] = $k->status;
	      }
      $this->data['statusoptions'] = $options;
      $this->data['wo'] = Workorder::find($wo_id);
	    $this->data['partitems'] = Wopart::where('wo_id', '=', $wo_id)->get();
	    $this->data['wo_id_initem'] = $wo_id;
      $this->data['analisas'] = Woanalisa::where('wo_id','=',$wo_id)->get();

  		return View::make('themes.modul.'.$this->views.'.partapprovedetail',$this->data);
    }

    public function post_approvedpartdetail($wo_id=false)
    {
      $approved = Input::get('fg_part_approved');

      $wo = Workorder::find($wo_id);
      $wo->fg_part_approved = $approved;
      $wo->user_approved = Auth::user()->id;
      $wo->dp_sparepart = Input::get('dp_sparepart');
      $wo->save();
      Session::flash('status', 'Status Persetujuan berhasil di ubah');
      return Redirect::to('warehouses/approvedpartdetail/'.$wo_id);
    }

    public function get_fleetinfo($fleet_id=false)
    {
      //if(!$fleet_id) return false;
      $this->data['fleet_id'] = $fleet_id;
      return View::make('themes.modul.'.$this->views.'.fleetinfo',$this->data);
    }

    public function get_receiptpart()
    {
      return View::make('themes.modul.'.$this->views.'.receipt',$this->data);
    }

    public function get_cetakbkb($woid=false)
    {
      if(!$woid) return false;
      $this->data['wo'] = Workorder::find($woid);
      $this->data['partitems'] = Wopart::where('wo_id', '=', $woid)->get();
      return View::make('themes.modul.'.$this->report.'.bkb',$this->data);
    }

    public function get_wolist($status_id = false)
    {
      if(!$status_id) $status_id = 1; 

      $allowed = array('taxi_number', 'mechanic', 'complaint','information_complaint','inserted_date_set'); // add allowable columns to search on
      $sort = in_array(Input::get('sort'), $allowed) ? Input::get('sort') : 'taxi_number'; // if user type in the url a column that doesnt exist app will default to id
      $order = Input::get('order') === 'desc' ? 'desc' : 'asc'; // default desc
      $keyword = Input::get('q');
      $search = Input::get('search');

      $wo = Workorder::join('fleets as f','f.id','=','work_orders.fleet_id')
                              ->where('work_orders.pool_id','=',Auth::user()->pool_id)
                              ->where('work_orders.status','=',$status_id)
                              ->order_by($sort, $order);

      $q = null;
      
      if (Input::has('q')) {
        $wo = $wo->where($search,'like', '%'.$keyword.'%');
        $q = '&search='.$search.'&q='.$keyword;
      }

      $wo = $wo->paginate(20,array('work_orders.id','km','inserted_date_set','complaint','information_complaint','mechanic','work_orders.pool_id','taxi_number','police_number'));

      $this->data['querystr'] = '&order='.(Input::get('order') == 'asc' || null ? 'desc' : 'asc').$q;
      $this->data['wos'] = $wo;
      $this->data['searchby'] = $search;
      $this->data['q'] = $keyword;
      $this->data['status_id'] = $status_id;
      $this->data['pagination'] = $wo->appends(
        array(
            'search'    => Input::get('search'),
            'q'         => Input::get('q'),
            'sort'      => Input::get('sort'),
            'order'     => Input::get('order')
        ))->links();

      //$this->data['wos'] = Workorder::where_status($status_id)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      return View::make('themes.modul.'.$this->views.'.wolist',$this->data);
    }

    //report 

    public function get_pemakaianunit()
    { 
      return View::make('themes.modul.'.$this->report.'.pemakaianunit',$this->data);
    }

    public function post_pemakaianunit()
    {
      $date = Input::get('date');
      $kso_id = Input::get('ksoid');

      $wolist =   DB::table('wo_listparts')
                  ->where('month','=',date('n',strtotime($date)) )
                  ->where('year','=',date('Y',strtotime($date)) )
                  ->where('kso_id','=',$kso_id)
                  ->order_by('inserted_date_set', 'asc')
                  ->get();
      
      return json_encode( $wolist );
    }

    //export to excel pemakaian unit bulanan 
    public function post_exppemakaianunit()
    {
      $input = Input::all();
      
      $wolist =   DB::table('wo_listparts')
                  ->where('month','=',date('n',strtotime($input['date'])) )
                  ->where('year','=',date('Y',strtotime($input['date'])) )
                  ->where('kso_id','=',$input['kso_id'])
                  ->order_by('inserted_date_set', 'asc')
                  ->get();
      $kso = Kso::find($input['kso_id']);

      if($wolist && $kso){

        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(path('public').'template/rekapbonpengemuditemplate.xls');
        $no =1;
        $startline = 11;

        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'PERIODE '. Myfungsi::periode(strtotime($input['date'])));
        $objPHPExcel->getActiveSheet()->setCellValue('B6', Fleet::find($kso->fleet_id)->taxi_number);
        $objPHPExcel->getActiveSheet()->setCellValue('B7', Driver::find($kso->bravo_driver_id)->nip);
        $objPHPExcel->getActiveSheet()->setCellValue('B8', Driver::find($kso->bravo_driver_id)->name);

        foreach ($wolist as $bon) {
          $row = $startline + 2;
          $objPHPExcel->getActiveSheet()->insertNewRowBefore($row - 1,1);
          
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no++);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $bon->inserted_date_set);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $bon->wo_number);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $bon->part_number);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $bon->name_sparepart);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $bon->qty);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $bon->satuan);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $bon->price);
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, '=F'.$row.'*H'.$row);

        }
        
        $objPHPExcel->getActiveSheet()->removeRow($row - 1,1);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(path('public').'Laporan-hutang-armada.xls');
        return Response::download(path('public').'Laporan-hutang-armada.xls');
      }
    }

    //stok sparepart di pool
    public function get_stock()
    {
      $allowed = array('name_sparepart', 'part_number', 'sp_categories_id', 'qty', 'price', 'min_stock'); // add allowable columns to search on
      $sort = in_array(Input::get('sort'), $allowed) ? Input::get('sort') : 'name_sparepart'; // if user type in the url a column that doesnt exist app will default to id
      $order = Input::get('order') === 'desc' ? 'desc' : 'asc'; // default desc
      $keyword = Input::get('q');
      $search = Input::get('search');
      $spareparts = DB::table('stock_sp')
                              ->join('sp_categories as cat','cat.id','=','stock_sp.sp_categories_id')
                              ->where('stock_sp.pool_id','=',Auth::user()->pool_id)
                              ->order_by($sort, $order);

      $q = null;
      if (Input::has('q')) {
        $spareparts = $spareparts->where($search,'like', '%'.$keyword.'%');
        $q = '&search='.$search.'&q='.$keyword;
      }
      $spareparts = $spareparts->paginate(20);
      $this->data['querystr'] = '&order='.(Input::get('order') == 'asc' || null ? 'desc' : 'asc').$q;
      $this->data['stocks'] = $spareparts;
      $this->data['searchby'] = $search;
      $this->data['q'] = $keyword;
      $this->data['pagination'] = $spareparts->appends(
        array(
            'search'    => Input::get('search'),
            'q'         => Input::get('q'),
            'sort'      => Input::get('sort'),
            'order'     => Input::get('order')
        ))->links();
      return View::make('themes.modul.'.$this->views.'.stock',$this->data);
    }

    public function get_stockfrom()
    {     
      $this->data['create'] = true;
      return View::make('themes.modul.'.$this->views.'.formstock',$this->data);
    }

    public function get_editstockform($id=false)
    {
      if(!$id) return false;
      $stock = DB::table('stock_sp')->where('stock_id','=',$id)->first();
      $this->data['sp']     = $stock;
      $this->data['create'] = false;
      return View::make('themes.modul.'.$this->views.'.formstock',$this->data);
    }
    
    public function post_stocksave()
    {
      $sparepart = Sparepart::where('part_number','=',Input::get('part_number'))->first();
      $msg = 'Part Number tidak ada di database pusat';
      if($sparepart){
        if(Input::get('id') == ''){
          $stock = new Stock;
          $stock->pool_id = Auth::user()->pool_id;
          $stock->sparepart_id = $sparepart->id;
          $stock->min_qty = Input::get('min_qty');
          $stock->sale_price = Input::get('sale_price');
          $stock->discount = 0;
          $stock->sale_on = 0;
          $stock->qty = Input::get('qty');
          $stock->user_id = Auth::user()->id;
          $stock->note = Input::get('note');
          $stock->save();
          $msg = 'Stock berhasil di tambahkan di gudang pool';
        }else{

          $stock = Stock::find(Input::get('id'));
          $stock->pool_id = Auth::user()->pool_id;
          $stock->sparepart_id = $sparepart->id;
          $stock->min_qty = Input::get('min_qty');
          $stock->sale_price = Input::get('sale_price');
          $stock->discount = 0;
          $stock->sale_on = 0;
          //$stock->qty = $stock->qty + Input::get('new_qty');
          $stock->user_id = Auth::user()->id;
          $stock->note = Input::get('note');
          $stock->save();
          $msg = 'Stock berhasil di update';

          Trackinginventory::create(array(
                                      'pool_id' => Auth::user()->pool_id, 
                                      'sparepart_id' => $sparepart->id,
                                      'qty' => Input::get('new_qty'),
                                      'user_id' => Auth::user()->id,
                                      'note' => 'Part Ajustment oleh ' . Auth::user()->fullname 
                                    ));

        }
      }
      return Redirect::to('warehouses/stock')->with('status', $msg);
    }

    //verifikasi part keluar
    public function post_verifikasipartkeluar()
    {
      $id = Input::get('id');
      $itempart = Wopart::find($id);
      $stock = Stock::where('pool_id','=',Auth::user()->pool_id)->where('sparepart_id','=',$itempart->sparepart_id)->first();
      if($stock)
      { 
        if($stock->qty >= $itempart->qty){
          $x = Trackinginventory::create(array(
                                          'pool_id' => Auth::user()->pool_id, 
                                          'sparepart_id' => $itempart->sparepart_id,
                                          'qty' => ($itempart->qty * -1),
                                          'user_id' => Auth::user()->id,
                                          'note' => 'Part Keluar melalui WO dengan id wo ' . $itempart->wo_id 
                                        ));
          if($x){

            $itempart->telah_dikeluarkan = 1;
            $itempart->save();

            return 'Part berhasil di keluarkan';
          }
        }else{ return 'Part gagal di keluarkan mungkin karna stock tidak tercukupi!'; }
      }else{
        return 'Part gagal di keluarkan mungkin karna stock tidak tersedia!';
      }
    }


    //report
    public function get_bkb()
    {
        $start  = Input::get('start', date('Y-m-d'));
        $end    = Input::get('end',  date('Y-m-d')); 

        $lists = DB::table('wo_listparts')
                ->where('inserted_date_set','>=', $start)
                ->where('inserted_date_set','<=', $end)
                ->where('pool_id','=', Auth::user()->pool_id)
                ->get();
        $this->data['querystr'] = '';
        $this->data['lists'] = $lists;
        return View::make('themes.modul.'.$this->views.'.listpartout',$this->data);
    }

    //report to excel
    public function post_bkbexport()
    { 
      $data = Input::json();
      $lists = DB::table('wo_listparts')
                ->where('inserted_date_set','>=', $data->start)
                ->where('inserted_date_set','<=', $data->end)
                ->where('pool_id','=', Auth::user()->pool_id)
                ->get();

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

      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'NO');
      $objPHPExcel->getActiveSheet()->setCellValue('B1', 'TANGGAL');
      $objPHPExcel->getActiveSheet()->setCellValue('C1', 'NOMOR WO');
      $objPHPExcel->getActiveSheet()->setCellValue('D1', 'NOMOR SPAREPART');
      $objPHPExcel->getActiveSheet()->setCellValue('E1', 'NAMA');
      $objPHPExcel->getActiveSheet()->setCellValue('F1', 'BODY');
      $objPHPExcel->getActiveSheet()->setCellValue('G1', 'QTY');
      $objPHPExcel->getActiveSheet()->setCellValue('H1', 'SATUAN');
      
      $no = 1;
      $starline = 2;
      foreach ($lists as $ls) {
        $fleetname ='';
        if(Fleet::find($ls->fleet_id)) {
                      $fleetname = Fleet::find($ls->fleet_id)->taxi_number;
        }
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, date('d/m/Y',strtotime($ls->inserted_date_set)) );
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $starline, $ls->wo_number);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $starline, "'".$ls->part_number);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $starline, $ls->name_sparepart);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $starline, $fleetname);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $starline, $ls->qty);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $starline, $ls->satuan);

        $no ++;
        $starline ++;
      }

        $objPHPExcel->getActiveSheet()->getStyle('A1:H'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H'.($starline + 1))->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($starline + 1).':H'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


      $objPHPExcel->getActiveSheet()->setTitle('Laporan');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save(path('public').'Laporan-BKB'.date('Y-m-d').'.xls');
      return json_encode(array('url'=>'Laporan-BKB'.date('Y-m-d').'.xls'));
    }

    public function get_bkbdownload($path='')
    {
      return Response::download(path('public').$path, $path);
    }
    public function get_stockspart()
    { 
      $this->data['create'] = true;
      return View::make('themes.modul.'.$this->views.'.cardstock',$this->data);
    }

    public function post_stockspart()
    {
      $part_number = Input::get('part_number');
      
      $sparepart = Sparepart::where('part_number','=',$part_number)->first();
      $data = array('status'=>0, 'data'=>'null');

      if($sparepart){
        $stock = DB::table('stock_sp')
              ->where('pool_id','=',Auth::user()->pool_id)
              ->where('sparepart_id','=',$sparepart->id)
              ->first();

        $lists = DB::table('wo_listparts')
                ->where('pool_id','=', Auth::user()->pool_id)
                ->where('sparepart_id','=', $sparepart->id)
                ->order_by('inserted_date_set','desc')
                ->get();
        $xs = array();
        if($stock){
          $no = 1;
          foreach($lists as $ls)
          {
            $xs[] = array($no++, date('d/m/Y',strtotime($ls->inserted_date_set)) , $ls->wo_number, Fleet::find($ls->fleet_id)->taxi_number, $ls->qty, $ls->satuan );
          }        
          $data = array('status'=>1, 'data'=>$stock, 'aaData'=> $xs );
        }
      }

      return json_encode($data); 
    }


}
