<?php

class Warehousescenter_Controller extends Base_Controller {

    public $restful = true;
  	public $views = 'warehousescenter';
  	public $report = 'warehousescenter.report';

  	public function get_index()
  	{
  		return View::make('themes.modul.'.$this->views.'.index',$this->data);
  	}

  	public function get_partrequest()
  	{
  		return View::make('themes.modul.'.$this->views.'.partrequest',$this->data);
  	}


    //permintaan ke puchess
    public function get_pplist()
    {
      $this->data['pplists'] = Requestsparepart::where('pool_id','=',Auth::user()->pool_id)->order_by('tanggal_order','desc')->paginate(20);
      return View::make('themes.modul.'.$this->views.'.purchaseorder',$this->data);
    }

    //permintaan ke puchess
    public function get_rrlist()
    {
      $this->data['rrlists'] = Receiptsparepart::where('pool_id','=',Auth::user()->pool_id)->order_by('tanggal_terima','desc')->paginate(20);
      return View::make('themes.modul.'.$this->views.'.rrlist',$this->data);
    }

    //permintaan ke puchess
    public function get_pp()
    {
      $this->data['suppliers'] =  Koki::to_dropdown(Supplier::all(),'id','company_name');
      return View::make('themes.modul.'.$this->views.'.newpurchaseorder',$this->data);
    }

    public function get_infopp()
    {
      $nomorpp = Input::get('nomorpp');
      $datas = Requestsparepart::where('no_doc','=',$nomorpp)->take(1)->first();
      if($datas){
        return json_encode(array('status' => true, 'data' => $datas->to_array()));
      }

      return json_encode(array('status'=>false));
    }

    public function get_partlist()
    {
      $ppid = Input::get('ppid');

      $datas = Requestsparepartitem::join('spareparts','spareparts.id','=','request_sparepart_items.sparepart_id')
                ->where('request_sparepart_id','=',$ppid)
                ->get(array('request_sparepart_items.id','request_sparepart_items.qty','request_sparepart_items.ket','spareparts.name_sparepart','spareparts.part_number', 'request_sparepart_items.sparepart_id'));
      return eloquent_to_json($datas);
    }
    //create pp
    public function post_createpp()
    {
      $input = Input::json();
     

      $pp = new Requestsparepart;
      $pp->no_doc = $input->pp_number;
      $pp->tanggal_order = $input->tanggal_order;
      $pp->tanggal_terima = $input->tanggal_terima;
      $pp->supplier_id = $input->supplier_id;
      $pp->pool_id = Auth::user()->pool_id;
      $pp->status = $input->status;
      $pp->catatan = $input->catatan;
      $pp->user_id = Auth::user()->id;
      //$pp->update_time = date('Y-m-d H:i:s');
      $pp->save();
      if($pp){
        return json_encode(array('msg'=> true , 'id'=> $pp->id));
      }
      
    }

    //edit permintaan ke puchess
    public function get_editpp($id=false)
    {
      if(!$id) return Redirect::to('warehousescenter/pplist');

      $this->data['pp'] = Requestsparepart::find($id);
      $this->data['suppliers'] =  Koki::to_dropdown(Supplier::all(),'id','company_name');
      $this->data['create'] = false;
      return View::make('themes.modul.'.$this->views.'.editpurchaseorder',$this->data);
    }
    public function post_editpp()
    { 
      $input = Input::json();
    
      $pp = Requestsparepart::find($input->id);
      $pp->no_doc = $input->pp_number;
      $pp->tanggal_order = $input->tanggal_order;
      $pp->tanggal_terima = $input->tanggal_terima;
      $pp->supplier_id = $input->supplier_id;
      $pp->pool_id = Auth::user()->pool_id;
      $pp->status = $input->status;
      $pp->catatan = $input->catatan;
      $pp->user_id = Auth::user()->id;
      //$pp->update_time = date('Y-m-d H:i:s');
      $pp->save();
      if($pp){
        return json_encode(array('msg'=> 'Data tersimpan!'));
      }
    }


    //edit penerimaan barang
    public function get_editrr($id=false)
    {
      if(!$id) return Redirect::to('warehousescenter/rrlist');

      $this->data['pp'] = Requestsparepart::find($id);
      $this->data['suppliers'] =  Koki::to_dropdown(Supplier::all(),'id','company_name');
      $this->data['create'] = false;
      return View::make('themes.modul.'.$this->views.'.editps',$this->data);
    }
    public function post_editrr()
    { 
      $input = Input::json();
    
      $pp = Requestsparepart::find($input->id);
      $pp->no_doc = $input->pp_number;
      $pp->tanggal_order = $input->tanggal_order;
      $pp->tanggal_terima = $input->tanggal_terima;
      $pp->supplier_id = $input->supplier_id;
      $pp->pool_id = Auth::user()->pool_id;
      $pp->status = $input->status;
      $pp->catatan = $input->catatan;
      $pp->user_id = Auth::user()->id;
      //$pp->update_time = date('Y-m-d H:i:s');
      $pp->save();
      if($pp){
        return json_encode(array('msg'=> 'Data tersimpan!'));
      }
    }


    public function get_pppreview($id=false)
    {
      if(!$id) return false;

      $this->data['pp'] = Requestsparepart::find($id);
      $this->data['ppitems'] = Requestsparepartitem::join('spareparts as sp', 'sp.id', '=', 'request_sparepart_items.sparepart_id')->where('request_sparepart_id','=',$id)->get();
      return View::make('themes.modul.'.$this->report.'.ppprintpreview',$this->data);
    }

     public function get_rrpreview($id=false)
    {
      if(!$id) return false;

      $this->data['pp'] = Receiptsparepart::find($id);
      $this->data['ppitems'] = Receiptsparepartitem::join('spareparts as sp', 'sp.id', '=', 'receipt_sparepart_items.sparepart_id')->where('receipt_sparepart_id','=',$id)
                              ->get(array('sp.part_number','sp.name_sparepart','receipt_sparepart_items.id','receipt_sparepart_items.qty','receipt_sparepart_items.price','receipt_sparepart_items.ket'));
      return View::make('themes.modul.'.$this->report.'.rrprintpreview',$this->data);
    }

    
    //penerimaan sp dari pembelian
    public function get_ps()
    {	
    	
    	$this->data['create'] = true;
    	$this->data['suppliers'] = Koki::to_dropdown(Supplier::all(),'id','company_name');
    	//var_dump($this->data['suppliers'] );
    	return View::make('themes.modul.'.$this->views.'.penerimaansp-jquery',$this->data);
  
    }

    public function post_ps()
    {
      $input = Input::json();
     

      $rr = new Receiptsparepart;
      $rr->no_doc = $input->rr_number;
      $rr->tanggal_terima = $input->tanggal_terima;
      $rr->supplier_id = $input->supplier_id;
      $rr->pool_id = Auth::user()->pool_id;
      //$rr->status = $input->status;
      $rr->catatan = $input->catatan;
      $rr->user_id = Auth::user()->id;
      //$pp->update_time = date('Y-m-d H:i:s');
      $rr->save();
      if($rr){
        return json_encode(array('status'=> true , 'id'=> $rr->id));
      }
      //return json_encode($input);
    }

    public function get_sparepart()
    {
      $query = Input::get('query');
      $sparepart = Sparepart::where('part_number','LIKE', '%'.$query.'%')->take(5)
                    ->get(array('id','part_number','name_sparepart'));

      $sparepartdatas = array_map(function($object) {
             return $object->to_array();
      }, $sparepart);

      return json_encode($sparepartdatas);
    }


    //add sparepart 
    public function post_addpart()
    {
      $inp = Input::json();

      $sparepart = Sparepart::where_part_number($inp->part_number)->first();
      if($sparepart){
          $wopart = Requestsparepartitem::where('request_sparepart_id','=',$inp->pp_id)->where('sparepart_id','=',$sparepart->id);
        if($wopart->count() > 0 ){
          
          $update = $wopart->first();
          $update->qty = $update->qty + $inp->qty;
          $update->ket = $inp->ket;
          $update->save();

        }else{
          $additem = Requestsparepartitem::create(array('request_sparepart_id'=>$inp->pp_id, 'sparepart_id' => $sparepart->id , 'qty'=> $inp->qty , 'price' => $sparepart->price, 'ket' => $inp->ket ));
        }
        return json_encode(array('status'=>'ok'));
      }else{
        return json_encode(array('status'=>'failed'));
      }
    }

    //add sparepart 
    public function post_addpartps()
    {
      $inp = Input::json();

      $sparepart = Sparepart::where_part_number($inp->part_number)->first();
      if($sparepart){
          $wopart = Receiptsparepartitem::where('receipt_sparepart_id','=',$inp->rr_id)->where('sparepart_id','=',$sparepart->id);
        if($wopart->count() > 0 ){
          
          $update = $wopart->first();
          $update->qty = $update->qty + $inp->qty;
          $update->ket = $inp->ket;
          $update->save();

        }else{
          $additem = Receiptsparepartitem::create(array('receipt_sparepart_id'=>$inp->rr_id, 'sparepart_id' => $sparepart->id , 'qty'=> $inp->qty , 'price' => $sparepart->price, 'ket' => $inp->ket ));
        }
        return json_encode(array('status'=>'ok'));
      }else{
        return json_encode(array('status'=>'failed'));
      }
    }

    public function get_partitem($pp_id = false)
    { 
      if(!$pp_id) return false;
      
      $this->data['partitems'] = Requestsparepartitem::where('request_sparepart_id', '=', $pp_id)->get();
      $this->data['pp_id_initem'] = $pp_id;
      return View::make('themes.modul.'.$this->views.'.partitem',$this->data);
    }

    public function get_partitemps($rr_id = false)
    { 
      if(!$rr_id) return false;
      
      $this->data['partitems'] = Receiptsparepartitem::where('receipt_sparepart_id', '=', $rr_id)->get();
      $this->data['rr_id_inpart'] = $rr_id;
      return View::make('themes.modul.'.$this->views.'.partitemps',$this->data);
    }

    //get last nuber 
    public function get_lastNumber()
    { 
      $lastnumber = Requestsparepart::max('id'); 
      $num    = myFungsi::numberComplate(($lastnumber + 1),5);
      //$date   = str_replace('-', '/', date('Y-m-d'));
      $date = explode('-', date('Y-m-d'));
      $number = 'DT-' . $num . '/SPP/' . $date[1].'/'.$date[0];
      return json_encode(array('number'=>$number));
    }

    public function get_NumberRR()
    { 
      $lastnumber = Receiptsparepart::max('id'); 
      $num    = myFungsi::numberComplate(($lastnumber + 1),5);
      //$date   = str_replace('-', '/', date('Y-m-d'));
      $date = explode('-', date('Y-m-d'));
      $number = 'DT-' . $num . '/SRR/' . $date[1].'/'.$date[0];
      return json_encode(array('number'=>$number));
    }


    public function get_part_item_remove($item_id = null, $pp_id = null)
    { 
      $s = Requestsparepartitem::find($item_id);
      $s->delete();
    }

    public function get_part_itemps_remove($item_id = null, $pp_id = null)
    { 
      $s = Receiptsparepartitem::find($item_id);
      $s->delete();
    }

    public function get_searchpart()
    {
      return View::make('themes.modul.'.$this->views.'.searchpart',$this->data);
    }
    

    public function get_stock()
    {
      $allowed = array('name_sparepart', 'part_number', 'sp_categories_id', 'base_price', 'price', 'qty', 'min_qty'); // add allowable columns to search on
      $sort = in_array(Input::get('sort'), $allowed) ? Input::get('sort') : 'name_sparepart'; // if user type in the url a column that doesnt exist app will default to id
      $order = Input::get('order') === 'desc' ? 'desc' : 'asc'; // default desc
      $keyword = Input::get('q');
      $search = Input::get('search');
      $spareparts = Sparepart::join('sp_categories as cat','cat.id','=','spareparts.sp_categories_id')
                              ->join('sp_groups as g','g.id','=','spareparts.sp_group_id')
                              ->order_by($sort, $order);

      $q = null;
      
      if (Input::has('q')) {
        $spareparts = $spareparts->where($search,'like', '%'.$keyword.'%');
        $q = '&search='.$search.'&q='.$keyword;
      }

      $spareparts = $spareparts->paginate(20,array('spareparts.id','name_sparepart','part_number','sp_categories_id','moving','base_price','price','satuan','isi_satuan','sp_category','sp_group','qty','min_qty'));

      $this->data['querystr'] = '&order='.(Input::get('order') == 'asc' || null ? 'desc' : 'asc').$q;
      $this->data['spareparts'] = $spareparts;
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


    /** 
     * report pemakaian unit
     */

    //report 

    public function get_pemakaianunit()
    { 
      return View::make('themes.modul.'.$this->report.'.pemakaianunit',$this->data);
    }

    public function post_pemakaianunit()
    {
      $date = Input::get('date');
      $fleet_id = Input::get('fleet_id');

      $wolist =   DB::table('wo_listparts')
                  ->where('month','=',date('n',strtotime($date)) )
                  ->where('year','=',date('Y',strtotime($date)) )
                  ->where('fleet_id','=',$fleet_id)
                  ->order_by('inserted_date_set', 'asc')
                  ->get();
      
      return json_encode( $wolist );
    }


  }