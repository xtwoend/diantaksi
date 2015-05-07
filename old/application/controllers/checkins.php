<?php

class Checkins_Controller extends Base_Controller {

	public $restful = true;
  	public $views = 'checkins';
  	public $report = 'checkins.report';

	public function get_index()
	{	
		$this->data['docs'] = Stddoc::all();
	    $this->data['neats'] = Stdneat::all();
	    $this->data['equips'] = Stdequip::all();
	    $this->data['categories'] = Stdfleetcategorie::all();
    	return View::make('themes.modul.'.$this->views.'.index',$this->data);
	}

	public function get_checkfisik()
	{
		$this->data['docs'] = Stddoc::all();
	    $this->data['neats'] = Stdneat::all();
	    $this->data['equips'] = Stdequip::all();
	    $this->data['categories'] = Stdfleetcategorie::all();
    	return View::make('themes.modul.'.$this->views.'.checkfisik',$this->data);
	}	
	public function get_allfleetCheckouts($date = false)
  	{
    	if(!$date) $date = date('Y-m-d');
    	$timestamp = strtotime($date);
      //list armada on checkouts
      	$fleets = Checkout::join('fleets as f', 'f.id', '=', 'checkouts.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkouts.pool_id','=',Auth::user()->pool_id)
                ->where('checkouts.checkout_step_id', '=', 4)
                ->where('checkouts.operasi_status_id', '=', 1)
                ->order_by('f.taxi_number','asc')
                ->get(array('f.taxi_number','checkouts.id'));
      	$fleetdata = array_map(function($object) {
             return $object->to_array();
      	}, $fleets);
        
	    $data['fleets'] = $fleetdata;
	    return json_encode($data);
  	}

  	public function get_allfleetCheckin($date = false)
  	{
    	if(!$date) $date = date('Y-m-d');
    	$timestamp = strtotime($date);
      //list armada on checkouts
      	$fleets = Checkin::join('fleets as f', 'f.id', '=', 'checkins.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkins.pool_id','=',Auth::user()->pool_id)
                ->order_by('f.taxi_number','asc')
                ->get(array('f.taxi_number','checkins.id'));
      	$fleetdata = array_map(function($object) {
             return $object->to_array();
      	}, $fleets);
        
	    $data['fleets'] = $fleetdata;
	    return json_encode($data);
  	}

  // find taxi on checkouts
  public function post_searchChekouts()
  {	
  	
    $jsondata = Input::json();

    $date = $jsondata->date;
    $timestamp = strtotime($date);

    //list armada on checkouts
      $fleets = Checkout::join('fleets as f', 'f.id', '=', 'checkouts.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkouts.pool_id','=',Auth::user()->pool_id)
                ->where('f.taxi_number','LIKE', '%'.$jsondata->taxi_number.'%')
                ->get(array('f.taxi_number','checkouts.id'));

      $fleetdata = array_map(function($object) {
             return $object->to_array();
      }, $fleets);
    
    $data['fleets'] = $fleetdata;
    return json_encode($data);   
  }
  public function post_searchChekins()
  {	
  	
    $jsondata = Input::json();

    $date = $jsondata->date;
    $timestamp = strtotime($date);

    //list armada on checkouts

                $fleets = Checkin::join('fleets as f', 'f.id', '=', 'checkins.fleet_id' )
                ->where_operasi_time($date)
                ->where('checkins.pool_id','=',Auth::user()->pool_id)
                ->order_by('f.taxi_number','asc')
                ->where('f.taxi_number','LIKE', '%'.$jsondata->taxi_number.'%')
                ->get(array('f.taxi_number','checkins.id'));

      $fleetdata = array_map(function($object) {
             return $object->to_array();
      }, $fleets);
    
    $data['fleets'] = $fleetdata;
    return json_encode($data);   
  }

  public function get_findbyidCheckouts($id=false)
  {
    if(!$id) return false;
    $checkout = Checkout::find($id);
    $fleetinfo = Fleet::find($checkout->fleet_id);
    $driverinfo = Driver::find($checkout->driver_id);
    
    $checkin = 	Checkin::where('fleet_id','=',$checkout->fleet_id)
    						->where('operasi_time','=', $checkout->operasi_time)
    						->first();
    if($checkin)
    {
	    
	    $checkin_documents = Checkindocument::where_checkin_id($checkin->id)->first();
	    //$cpy = Checkinphysic::where_checkin_id($checkin->id)->first();
	    
	    $sp_pyss = array();
	    /*
	    if($cpy){
	    	
	    	$sp_pys = explode(',', $cpy->sparepart_id );
	    	$ket_pys = explode(',', $cpy->ket );

	    	foreach ($sp_pys as $k => $v) {
		    	$sp_pyss[$v] = $ket_pys[$k];
		    }

	    }
		*/
	    $std_doc = explode(',', $checkin_documents->std_document_id );
	    $ket_doc = explode(',', $checkin_documents->ket );
	    $std_equip = explode(',', $checkin_documents->std_equip_id );
	    $std_neat = explode(',', $checkin_documents->std_neats_id );


	    
	    $std_docs = array();
	    $std_equips = array();
	    $std_neats = array();

	    

	    foreach ($std_doc as $k => $v) {
	      $std_docs[$v] = $ket_doc[$k]; 
	    }

	    foreach ($std_equip as $k => $v) {
	      $std_equips[$v] = $v; 
	    }

	    foreach ($std_neat as $k => $v) {
	      $std_neats[$v] = $v; 
	    }

	    
	    $returndata = array(
	                  'id'=> $checkout->id, 
	                  'nip'=> $driverinfo->nip, 
	                  'name' => $driverinfo->name,
	                  'taxi_number' => $fleetinfo->taxi_number,
	                  'police_number' => $fleetinfo->police_number,
	                  'pool_id' => $checkout->pool_id,
	                  'pool' => Pool::find($checkout->pool_id)->pool_name,
	                  'status' => Checkinstep::find($checkin->checkin_step_id)->checkin_step,
	                  'statusops' => Statusoperasi::find($checkin->operasi_status_id)->operasi_status,
	                  'statusopsval' => $checkout->operasi_status_id,

	                  'km_fleet' => $checkin->km_fleet,
	                  'rit' => $checkin->rit,
	                  'incomekm' => $checkin->incomekm,
	                  'checkin_time' => $checkin->checkin_time,

	                  'std_doc_id' => $std_docs,
	                  'std_equip_id'  => $std_equips,
	                  'std_neat_id'  => $std_neats,

	                  'psy_check'  => $sp_pyss,

	                  'checkin' => true,
	                  'checkinid' => $checkin->id,
	                  'operasi_status_id' => $checkin->operasi_status_id,
	                  'fg_bengkel' => $fleetinfo->fg_bengkel,
	                  );
	  }else{

	  	$returndata = array(
	  				  'id'=> $checkout->id, 
	                  'nip'=> $driverinfo->nip, 
	                  'name' => $driverinfo->name,
	                  'taxi_number' => $fleetinfo->taxi_number,
	                  'police_number' => $fleetinfo->police_number,
	                  'pool_id' => $checkout->pool_id,
	                  'pool' => Pool::find($checkout->pool_id)->pool_name,
	                  'status' => Checkinstep::find(1)->checkin_step,
	                  'statusops' => Statusoperasi::find($checkout->operasi_status_id)->operasi_status,
	                  'statusopsval' => $checkout->operasi_status_id,
	                  'checkin' => false,

	                  );
	  }

    return json_encode($returndata);
  }

  public function get_findbyidCheckins($id=false)
  {
    if(!$id) return false;
   
   
    $checkin = 	Checkin::find($id);

    $fleetinfo = Fleet::find($checkin->fleet_id);
    $driverinfo = Driver::find($checkin->driver_id);
    
    if($checkin)
    {
	    
	    $checkin_documents = Checkindocument::where_checkin_id($checkin->id)->first();
	    $cpy = Checkinphysic::where_checkin_id($checkin->id)->first();
	    
	    $sp_pyss = array();

	    if($cpy){
	    	
	    	$sp_pys = explode(',', $cpy->sparepart_id );
	    	$ket_pys = explode(',', $cpy->ket );

	    	foreach ($sp_pys as $k => $v) {
		    	$sp_pyss[$v] = $ket_pys[$k];
		    }

	    }

	    $std_doc = explode(',', $checkin_documents->std_document_id );
	    $ket_doc = explode(',', $checkin_documents->ket );
	    $std_equip = explode(',', $checkin_documents->std_equip_id );
	    $std_neat = explode(',', $checkin_documents->std_neats_id );


	    
	    $std_docs = array();
	    $std_equips = array();
	    $std_neats = array();

	    

	    foreach ($std_doc as $k => $v) {
	      $std_docs[$v] = $ket_doc[$k]; 
	    }

	    foreach ($std_equip as $k => $v) {
	      $std_equips[$v] = $v; 
	    }

	    foreach ($std_neat as $k => $v) {
	      $std_neats[$v] = $v; 
	    }

	    
	    $returndata = array(
	                  'id'=> $checkin->id, 
	                  'nip'=> $driverinfo->nip, 
	                  'name' => $driverinfo->name,
	                  'taxi_number' => $fleetinfo->taxi_number,
	                  'police_number' => $fleetinfo->police_number,
	                  'pool_id' => $checkin->pool_id,
	                  'pool' => Pool::find($checkin->pool_id)->pool_name,
	                  'status' => Checkinstep::find($checkin->checkin_step_id)->checkin_step,
	                  'km_fleet' => $checkin->km_fleet,
	                  'rit' => $checkin->rit,
	                  'incomekm' => $checkin->incomekm,
	                  'checkin_time' => $checkin->checkin_time,

	                  'std_doc_id' => $std_docs,
	                  'std_equip_id'  => $std_equips,
	                  'std_neat_id'  => $std_neats,

	                  'psy_check'  => $sp_pyss,

	                  'checkin' => true,
	                  'checkinid' => $checkin->id,
	                  'operasi_status_id' => $checkin->operasi_status_id,
	                  'fg_bengkel' => $fleetinfo->fg_bengkel,
	                  );
	  }else{

	  	$returndata = array(
	  								'id'=> $checkin->id, 
	                  'nip'=> $driverinfo->nip, 
	                  'name' => $driverinfo->name,
	                  'taxi_number' => $fleetinfo->taxi_number,
	                  'police_number' => $fleetinfo->police_number,
	                  'pool_id' => $checkin->pool_id,
	                  'pool' => Pool::find($checkin->pool_id)->pool_name,
	                  'status' => Checkinstep::find(1)->checkin_step,
	                  'checkin' => false,
	                  );
	  }

    return json_encode($returndata);
  }

  public function post_checkinstep1()
  {		
  		Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Checkin Step 1', true);
  		$jsondata = Input::json();
  		$checkout = Checkout::find($jsondata->id);
  		if(!$checkout) return false;
  		$checkout->checkout_step_id = 7;
  		$checkout->save();

  		$statusops = $checkout->operasi_status_id;
  		if((int)$jsondata->status_ops == 3)
  		{
  			$statusops = 3;
  		}

  		$cin = Checkin::create(array(
								'kso_id' => $checkout->kso_id,
								'fleet_id' => $checkout->fleet_id,
								'driver_id' => $checkout->driver_id,
								'checkin_time' => date('Y-m-d H:i:s',Myfungsi::sysdate()),
								'shift_id' => $checkout->shift_id,
								'km_fleet' => $jsondata->km_fleet,
								'rit' => $jsondata->rit,
								'incomekm' => $jsondata->incomekm,
								'operasi_time' => $checkout->operasi_time,
								'pool_id' => $checkout->pool_id,
								'operasi_status_id' => $statusops,
								'fg_late' => '',
								'checkin_step_id' => 2,
								'document_check_user_id' => Auth::user()->id,
								'physic_check_user_id' => '',
								'bengkel_check_user_id' => '',
								'finance_check_user_id' => '',
								));
	  	
	  	if($cin){
	  		
	  		$docs = new Checkindocument; 
	  		$docs->checkin_id = $cin->id;
	  		$docs->save();

	  		$fl = Fleet::find($checkout->fleet_id);
	  		$fl->last_km = $jsondata->km_fleet;
	  		$fl->save();

	  		$datax['checkin'] = array('checkoutid'=> $jsondata->id, 'message' => 'Next to step 2');
	  	}else{
	  		$datax['checkin'] = array('message' => 'Error Step 1');
	  	}
			
	  	return json_encode($datax);
  }

  public function post_saveCheck()
  {	
  	Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Save Checkin', true);
    $data = Input::json();

    $id = $data->id;
    $docs_ket = $data->std_docs;
    $neats = $data->std_neats;
    $equips = $data->std_equips;
    $sp_kets = $data->ket_sp;

    $checkin = Checkin::find($id);
    $checkin->km_fleet = $data->km_fleet;
    $checkin->rit = $data->rit;
    $checkin->incomekm = $data->incomekm;
    //$checkin->checkin_step_id = 2;
    $checkin->save();

    //update yang nyangkut
    $checkout = Checkout::where('fleet_id','=',$checkin->fleet_id)->where('operasi_time','=',$checkin->operasi_time)->first();
  	if($checkout){
  		$checkout->checkout_step_id = 7;
  		$checkout->save();
  	}

    $docs = array();
    foreach (Stddoc::all() as $doc) {
      array_push($docs, $doc->id);
    }

    $sps = array();
    foreach (Stdfleet::all() as $sp) {
      array_push($sps, $sp->id);
    }
   
    $cin = Checkindocument::where_checkin_id($id)->first();
  
    if($cin->operasi_time > date('Y-m-d',Myfungsi::sysdate()) )
    {
      $datax['message'] = 'invalide time';
    }else{
      $cin->std_neats_id = implode(",", $neats);
      $cin->std_document_id = implode(",", $docs);
      $cin->ket = implode(",", $docs_ket);
      $cin->std_equip_id = implode(",", $equips);
      $cin->save();

      $datax['message'] = 'Data Saved';
    } 

    return json_encode($datax);
  }

  public function post_saveCheckFisik()
  {	
  	Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Save Checkin', true);
    $data = Input::json();

    $id = $data->id;
    $docs_ket = $data->std_docs;
    $neats = $data->std_neats;
    $equips = $data->std_equips;
    $sp_kets = $data->ket_sp;

    $checkin = Checkin::find($id);
    //$checkin->operasi_status_id = $data->status_ops;
    $checkin->save();

    $docs = array();
    foreach (Stddoc::all() as $doc) {
      array_push($docs, $doc->id);
    }

    $sps = array();
    foreach (Stdfleet::all() as $sp) {
      array_push($sps, $sp->id);
    }
    
    $fg_bengkel = ($data->hasilcheckfisik == 2) ? 1 : 0;

    $cin = Checkindocument::where_checkin_id($id)->first();
    $cpy = Checkinphysic::where_checkin_id($id)->first();
    
    if(!$cpy){
    	$cpy = Checkinphysic::create(array('checkin_id' => $id));
    }

    if($cin->operasi_time > date('Y-m-d',Myfungsi::sysdate()) )
    {
      $datax['message'] = 'invalide time';
    }else{
      $cin->std_neats_id = implode(",", $neats);
      $cin->std_document_id = implode(",", $docs);
      $cin->ket = implode(",", $docs_ket);
      $cin->std_equip_id = implode(",", $equips);
      $cin->save();

      //save pysicly

      $cpy->sparepart_id = implode(",", $sps);
      $cpy->ket = implode(",", $sp_kets);
      $cpy->save();

      //update jika perlu berbaikan
      $fl = Fleet::find($checkin->fleet_id);
      $fl->fg_bengkel = $fg_bengkel;
      $fl->save();

      $datax['message'] = 'Data Saved';
    } 

    return json_encode($datax);
  }
}