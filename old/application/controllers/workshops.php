<?php

class Workshops_Controller extends Base_Controller {

	  public $restful = true;
  	public $views = 'workshops';
  	public $report = 'workshops.report';

  	public function get_index()
  	{
      $this->data['wos'] = Workorder::where_status(1)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      $this->data['wosonworkings'] = Workorder::where_status(2)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
  		$this->data['wosonpanding'] = Workorder::where_status(4)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      $this->data['wosonfinish'] = Workorder::where_status(3)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->take(5)->get();
      
      return View::make('themes.modul.'.$this->views.'.index',$this->data);
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
    public function get_woonoperasi()
    { 
      $this->data['wosonworkings'] = Workorder::where_status(2)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      $this->data['wosonpanding'] = Workorder::where_status(4)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      $this->data['wosonfinish'] = Workorder::where_status(3)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->take(5)->get();
      $this->data['wos'] = Workorder::where_status(1)->where_pool_id(Auth::user()->pool_id)->order_by('inserted_date_set','desc')->get();
      return View::make('themes.modul.'.$this->views.'.dash',$this->data);
    }

  	public function get_wo()
  	{
  		return View::make('themes.modul.'.$this->views.'.workorder',$this->data);
  	}

    public function get_woanalisis($id=false)
    {
      if(!$id) return false;
      $wo = Workorder::find($id);
      $this->data['wo'] = $wo;
      $options = array();
      foreach (Statusperbaikan::all() as $k) {
        $options[$k->id] = $k->status;
      }
      $this->data['statusoptions'] = $options;
      return View::make('themes.modul.'.$this->views.'.woanalisis',$this->data);
    
    }

    public function get_editwo($id=false)
    {
      if(!$id) return false;
      $wo = Workorder::find($id);
      $this->data['wo'] = $wo;
      $options = array();
      foreach (Statusperbaikan::all() as $k) {
        $options[$k->id] = $k->status;
      }
      $this->data['statusoptions'] = $options;
      return View::make('themes.modul.'.$this->views.'.editwo',$this->data);
    
    }

    public function post_editwo($id=false)
    {
      $wo_id = Input::get('wo_id');

      //update status WO
      $upwo =  Workorder::find($wo_id);
      $upwo->status = Input::get('status');
      $upwo->complaint = Input::get('compalaint');
      $upwo->information_complaint = Input::get('information');
      $upwo->finished_date_set = date('Y-m-d H:i:s');
      $upwo->mechanic = Input::get('mechanic');
      $upwo->save();

      if(Input::get('status') == 3 || Input::get('status') == 4 || Input::get('status') == 5)
      { 
        $z = Fleet::find($upwo->fleet_id);
        $z->fg_bengkel = 0;
        $z->save();        
      }
      Session::flash('status', 'Work Order berhasil di simpan!');
      return Redirect::to('workshops/editwo/'. $wo_id);
    }

  	public function get_maintenance()
  	{
  		# code...
  	}

    public function get_allFleet()
    {
      $query = Input::get('query');
      $fleets = Fleet::join('pools','pools.id','=','fleets.pool_id')
                ->join('ksos','ksos.fleet_id','=','fleets.id')
                ->join('drivers','drivers.id', '=', 'ksos.bravo_driver_id' )
                ->where('ksos.actived','=', 1)
                ->where('ksos.pool_id','=',Auth::user()->pool_id)
                ->where('fleets.taxi_number','LIKE', '%'.$query.'%')
                ->get(array('ksos.id as kso_id','fleets.id','fleets.taxi_number','fleets.police_number','pools.pool_name','pools.id as pool_id' ,'drivers.name','drivers.nip','drivers.id as driver_id'));
      $fleetdatas = array_map(function($object) {
             return $object->to_array();
      }, $fleets);

      return json_encode($fleetdatas);
    }

    public function post_searchFleet()
    {
      $jsondata = Input::json();
      $fleets = Fleet::where_pool_id(Auth::user()->pool_id)->where('taxi_number','LIKE', '%'.$jsondata->taxi_number.'%')->get(array('id','taxi_number'));
      
      $fleetdatas = array_map(function($object) {
             return $object->to_array();
      }, $fleets);

      return json_encode($fleetdatas);
    }

    public function post_saveWo()
    {
      $inp = Input::json();
      try {
        $spk = Workorder::create(array(
            'kso_id' => $inp->kso_id,
            'wo_number' => $inp->wo_number,
            'fleet_id'  => $inp->fleet_id,
            'driver_id'  => $inp->driver_id,
            'pool_id'  => $inp->pool_id,
            'km'        => $inp->km,
            'complaint' => $inp->complaint,
            'information_complaint' => $inp->information_complaint,
            'status' => 1,
            'user_id' => Auth::user()->id,
            'inserted_date_set' => $inp->date,
            'beban' => $inp->beban,
        ));
        if($spk){
          $z = Fleet::find($inp->fleet_id);
          $z->fg_bengkel = 1;
          $z->save();
        }
        return json_encode(array('id'=>$spk->id));
      } catch (Exception $e) {
        return json_encode($e);
      }
    }

    public function get_woPreview($id=false)
    {
      if(!$id) return false;

      $this->data['wo'] = Workorder::find($id);
      return View::make('themes.modul.'.$this->views.'.wopreview',$this->data);
    }

    public function get_printWo($id=false)
    {
      if(!$id) return false;
      Asset::add('print', 'themes/stylesheets/print.css');
      $this->data['wo'] = Workorder::find($id);
      return View::make('themes.modul.'.$this->report.'.wo',$this->data);
    }
    //save analisa bengkel
    public function post_analisasave()
    {
      $wo_id = Input::get('wo_id');

      //update status WO
      $upwo =  Workorder::find($wo_id);
      $upwo->status = Input::get('status');
      $upwo->complaint = Input::get('compalaint');
      $upwo->information_complaint = Input::get('information');
      $upwo->finished_date_set = date('Y-m-d H:i:s');
      $upwo->mechanic = Input::get('mechanic');
      $upwo->save();

      if(Input::get('status') == 3 || Input::get('status') == 4 || Input::get('status') == 5)
      { 
        $z = Fleet::find($upwo->fleet_id);
        $z->fg_bengkel = 0;
        $z->save();        
      }
      Session::flash('status', 'Work Order berhasil di simpan!');
      return Redirect::to('workshops/woanalisis/'. $wo_id);
    }

    

    //partrequest

    public function get_partrequest($wo_id=false)
    {
      if(!$wo_id) return false;

      return View::make('themes.modul.'.$this->views.'.partrequest',$this->data);
    }

    //add sparepart 
    public function post_addpart()
    {
      $inp = Input::json();

      $sparepart = Sparepart::where_part_number($inp->part_number)->first();
      
      if($sparepart){
          $wopart = Wopart::where('wo_id','=',$inp->wo_id)->where('sparepart_id','=',$sparepart->id);
          
          if($inp->price == ''){
            $price = $sparepart->price;
            if($sparepart->moving == 2){
              $price = (($price * 15) / 100 ) + $price ;
            }elseif ($sparepart->moving == 3) {
              $price = (($price * 10) / 100 ) + $price ;
            }
          }else{
            $price = $inp->price;
          }
          
          

        if($wopart->count() > 0 ){
          
          $update = $wopart->first();
          $update->qty = $update->qty + $inp->qty;
          $update->save();

        }else{
          //add sparepart awal
          //$additem = Wopart::create(array('wo_id'=>$inp->wo_id, 'sparepart_id' => $sparepart->id , 'qty'=> $inp->qty , 'price' => $sparepart->price ));
          //add sparepart edited
          $additem = Wopart::create(array('wo_id'=>$inp->wo_id, 'sparepart_id' => $sparepart->id , 'qty'=> $inp->qty , 'price' => $price ));
          
        }
        return json_encode(array('status'=>'ok'));
      }else{
        return json_encode(array('status'=>'failed'));
      }
    }
    public function get_partitem($wo_id = false)
    { 
      if(!$wo_id) return false;
      //$this->data['partitems'] = Cartify::cart('part_item_'.$wo_id)->contents();
      $this->data['partitems'] = Wopart::where('wo_id', '=', $wo_id)->get();
      $this->data['wo_id_initem'] = $wo_id;
      return View::make('themes.modul.'.$this->views.'.partitem',$this->data);
    }

    //add Analis 
    public function post_addanalis()
    {
      $inp = Input::json();
      Woanalisa::create(array('wo_id'=>$inp->wo_id, 'analisa'=> $inp->analisa ));
      return json_encode(array('status'=>'ok'));
    }


    public function get_analisitem($wo_id = false)
    { 
      if(!$wo_id) return false;
      //$this->data['partitems'] = Cartify::cart('part_item_'.$wo_id)->contents();
      $this->data['analisitems'] = Woanalisa::where('wo_id', '=', $wo_id)->get();
      $this->data['wo_id_initem'] = $wo_id;
      return View::make('themes.modul.'.$this->views.'.analisitem',$this->data);
    }
    public function get_part_item_remove($item_id = null, $wo_id = null)
    { 
      $s = Wopart::find($item_id);
      $s->delete();
    }

    public function get_analisa_item_remove($item_id = null, $wo_id = null)
    { 
      $s = Woanalisa::find($item_id);
      $s->delete();
    }

    
    //get last nuber 
    public function get_lastNumber()
    { 
      $lastnumber = Workorder::max('id'); 
      $num    = myFungsi::numberComplate(($lastnumber + 1),5);
      $date   = str_replace('-', '/', date('Y-m-d'));
      $number = 'DT-' . $num . '/WO/' . $date;
      return json_encode(array('number'=>$number));
    }

    public function get_sparepart()
    {
      $query = Input::get('query');
      $fleets = Sparepart::where('part_number','LIKE', '%'.$query.'%')
                ->get(array('id','part_number','name_sparepart'));
      $fleetdatas = array_map(function($object) {
             return $object->to_array();
      }, $fleets);

      return json_encode($fleetdatas);
    }

    public function get_searchpart()
    {
      return View::make('themes.modul.'.$this->views.'.searchpart',$this->data);
    }


    //print

    public function get_cetakwo($woid=false)
    {
      if(!$woid) return false; 
      $this->data['wo'] = Workorder::find($woid);
      return View::make('themes.modul.'.$this->report.'.wo',$this->data);
    }

    
}