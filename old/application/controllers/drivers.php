<?php

class Drivers_Controller extends Base_Controller {

	public $restful = true;

  public $views = 'drivers';
  public $report = 'drivers.report';

  public function get_index()
  { 
    $driver = Driver::order_by('nip','asc');
    $q = Input::get('q',false);
    if($q) {
      $driver = $driver->where('nip','LIKE','%'.$q.'%')->or_where('name','LIKE','%'.$q.'%');
    }else{
      $driver = $driver->where('pool_id','=',Auth::user()->pool_id);
    }                       
    $this->data['drivers'] = $driver->paginate(20);
    return View::make('themes.modul.'.$this->views.'.index',$this->data);
  }
	/*
  public function post_index()
  {  
    $nip = Input::get('nip');
    $this->data['drivers'] = Driver::where('nip','LIKE','%'.$nip.'%')
                              ->order_by('nip','asc')->paginate(20);

    return View::make('themes.modul.'.$this->views.'.index',$this->data);
  }
  */

  public function get_pengemudiactive()
  {
    $driver = Driver::order_by('nip','asc');
    $q = Input::get('q',false);
    if($q) {
      $driver = $driver->where('pool_id','=',Auth::user()->pool_id)->where('driver_status','=',1)->where('nip','LIKE','%'.$q.'%')->or_where('name','LIKE','%'.$q.'%');
    }else{
      $driver = $driver->where('pool_id','=',Auth::user()->pool_id)->where('driver_status','=',1);
    }                       
    $this->data['drivers'] = $driver->paginate(20);

    
    return View::make('themes.modul.'.$this->views.'.driveractive',$this->data);
  }

  public function get_add()
  {
    $cities = array();
    $pools = array();
    foreach(City::all() as $city)
    {
      $cities[$city->id] = $city->city;
    }
    foreach(Pool::all() as $pool)
    {
      $pools[$pool->id] = $pool->pool_name;
    }
    $this->data['cities'] = $cities;
    $this->data['pools'] = $pools;
    $this->data['create'] = true;
    $this->data['driver_id'] = '';
    return View::make('themes.modul.'.$this->views.'.form',$this->data);
  }

  public function post_add()
  { 
    $files = Input::file('photo');
    $input = Input::all();
    try {
      unset($input['photo']);

      if (is_array($files) && isset($files['error']) && $files['error'] == 0) {
        $success = Resizer::open( $files )
          ->resize( 200 , 200 , 'auto' )
          ->save( path('public') . 'photo/'.str_replace(' ', '-', $input['nip']).'.jpg' , 90 );
      }
      
      //$input = $input + array('photo'=>str_replace(' ', '-', $input['nip']).'.jpg');
      //Driver::create($input);
      $driver = new Driver;
      $driver->name = $input['name'];
      $driver->nip = $input['nip'];
      $driver->ktp = $input['ktp'];
      $driver->sim = $input['sim'];
      $driver->phone = $input['phone'];
      $driver->brith_place = $input['brith_place'];
      $driver->date_of_birth = $input['date_of_birth'];
      $driver->address = $input['address'];
      $driver->kelurahan = $input['kelurahan'];
      $driver->kecamatan = $input['kecamatan'];
      $driver->kota = $input['kota'];
      $driver->fg_blocked = Input::get('fg_blocked',0);
      $driver->driver_status = Input::get('driver_status', 2);
      $driver->kpp_validthrough = $input['kpp_validthrough'];
      $driver->city_id = $input['city_id'];
      $driver->pool_id = $input['pool_id'];
      $driver->pool_id = $input['pool_id'];
      if($files) $driver->photo = str_replace(' ', '-', $input['nip']).'.jpg';
      $driver->save();
      return Redirect::to('drivers');
    } catch (Exception $e) {
      return 'Error Insert';
    }

  }

  public function get_edit($id=false)
  {
    if(!$id) return Redirect::to('drivers');
    
    $cities = array();
    $pools = array();
    foreach(City::all() as $city)
    {
      $cities[$city->id] = $city->city;
    }
    foreach(Pool::all() as $pool)
    {
      $pools[$pool->id] = $pool->pool_name;
    }
    $this->data['cities'] = $cities;
    $this->data['pools'] = $pools;
    $this->data['driver'] = Driver::find($id);
    $this->data['create'] = false;
    $this->data['driver_id'] = $id;
    return View::make('themes.modul.'.$this->views.'.form',$this->data);
  }

  public function post_edit($id=false)
  {
    if(!$id) return Redirect::to('drivers');
    
    $input = Input::all();
    $files = Input::file('photo',false);

    //if($files) Input::upload('photo', path('public') . 'photo/', $files['name']);
   
    // Save a thumbnail
    if (is_array($files) && isset($files['error']) && $files['error'] == 0) {
        $success = Resizer::open( $files )
          ->resize( 200 , 200 , 'auto' )
          ->save( path('public') . 'photo/'.str_replace(' ', '-', $input['nip']).'.jpg' , 90 );
      }
    try {
      $driver = Driver::find($id);
      $driver->name = $input['name'];
      $driver->nip = $input['nip'];
      $driver->ktp = $input['ktp'];
      $driver->sim = $input['sim'];
      $driver->phone = $input['phone'];
      $driver->brith_place = $input['brith_place'];
      $driver->date_of_birth = $input['date_of_birth'];
      $driver->address = $input['address'];
      $driver->kelurahan = $input['kelurahan'];
      $driver->kecamatan = $input['kecamatan'];
      $driver->kota = $input['kota'];
      $driver->fg_blocked = Input::get('fg_blocked',0);
      $driver->driver_status = Input::get('driver_status', 2);
      $driver->kpp_validthrough = $input['kpp_validthrough'];
      $driver->city_id = $input['city_id'];
      $driver->pool_id = $input['pool_id'];
      $driver->pool_id = $input['pool_id'];
      if($files) $driver->photo = str_replace(' ', '-', $input['nip']).'.jpg';
      $driver->save();
      return Redirect::to('drivers/edit/'.$id);
    } catch (Exception $e) {
    
    }

  }

  public function get_delete($id=false)
  {
    if(!$id) return Redirect::to('drivers');
    $driver = Driver::find($id);
    $driver->delete();
    
    return Redirect::to('drivers');
  }

  public function get_printkpp($id=false)
  {
    if(!$id) return false;
    $this->data['driver_id'] = $id;
    return View::make('themes.modul.'.$this->views.'.printkpp',$this->data);
  }


  /**
   * export to excel.
   *
   * @return
   */
  public function get_exporttoxls()
  {
    $drivers = Driver::order_by('nip','asc')->where('pool_id','=',Auth::user()->pool_id)->get();
    return View::make('themes.modul.'.$this->views.'.export', compact('drivers'));
  }
}