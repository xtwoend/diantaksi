<?php

class Fleets_Controller extends Base_Controller {

	public $restful = true;
  public $views = 'fleets';
  public $report = 'fleets.report';

  public function get_index()
  {
    $this->data['fleets'] = Fleet::join('fleet_brands as b', 'b.id', '=', 'fleets.fleet_brand_id' )
                            ->join('fleet_models as m', 'm.id', '=', 'fleets.fleet_model_id' )
                            ->where('fleets.pool_id','=',Auth::user()->pool_id)
                            ->order_by('taxi_number','asc')->paginate(20,array('fleets.id','fleets.taxi_number','fleets.police_number','fleets.engine_number','fleets.chassis_number','b.fleet_brand','m.fleet_model'));
    return View::make('themes.modul.'.$this->views.'.index',$this->data);
  } 

  public function post_index()
  { 
    
    $taxi_number = Input::get('taxi_number');
    $this->data['fleets'] = Fleet::join('fleet_brands as b', 'b.id', '=', 'fleets.fleet_brand_id' )
                            ->join('fleet_models as m', 'm.id', '=', 'fleets.fleet_model_id' )
                            ->where('fleets.taxi_number','LIKE','%'.$taxi_number.'%')
                            ->order_by('taxi_number','asc')->paginate(20,array('fleets.id','fleets.taxi_number','fleets.police_number','fleets.engine_number','fleets.chassis_number','b.fleet_brand','m.fleet_model'));
    return View::make('themes.modul.'.$this->views.'.index',$this->data);
  }

  public function get_add()
  {
    $brands = array();
    $models = array();
    $pools = array();
    foreach(Fleetbrand::all() as $brand)
    {
      $brands[$brand->id] = $brand->fleet_brand;
    }
    foreach(Fleetmodel::all() as $model)
    {
      $models[$model->id] = $model->fleet_model;
    }
    foreach(Pool::all() as $pool)
    {
      $pools[$pool->id] = $pool->pool_name;
    }
    $this->data['brands'] = $brands;
    $this->data['models'] = $models;
    $this->data['pools'] = $pools;
    $this->data['create'] = true;
    return View::make('themes.modul.'.$this->views.'.form',$this->data);
  }

  public function post_add()
  {
    $input = Input::all();
    try {
      Fleet::create($input);
      return Redirect::to('fleets');
    } catch (Exception $e) {
      return 'Error Insert';
    }

  }

  public function get_edit($id=false)
  {
    if(!$id) return Redirect::to('fleets');
    
    $brands = array();
    $models = array();
    $pools = array();
    foreach(Fleetbrand::all() as $brand)
    {
      $brands[$brand->id] = $brand->fleet_brand;
    }
    foreach(Fleetmodel::all() as $model)
    {
      $models[$model->id] = $model->fleet_model;
    }
    foreach(Pool::all() as $pool)
    {
      $pools[$pool->id] = $pool->pool_name;
    }
    $this->data['brands'] = $brands;
    $this->data['models'] = $models;
    $this->data['pools'] = $pools;
    $this->data['create'] = false;
    $this->data['fleet'] = Fleet::find($id);
    return View::make('themes.modul.'.$this->views.'.form',$this->data);
  }

  public function post_edit($id=false)
  {
    if(!$id) return Redirect::to('fleets');
    
    $input = Input::all();
    try {
      $fleet = fleet::find($id);
      $fleet->taxi_number = $input['taxi_number'];
      $fleet->police_number = $input['police_number'];
      $fleet->engine_number = $input['engine_number'];
      $fleet->chassis_number = $input['chassis_number'];
      $fleet->pool_id = $input['pool_id'];
      $fleet->fleet_brand_id = $input['fleet_brand_id'];
      $fleet->fleet_model_id = $input['fleet_model_id'];
      $fleet->fg_laka = Input::get('fg_laka',0);
      $fleet->fg_kso = Input::get('fg_kso',0);
      $fleet->fg_setor = Input::get('fg_setor',0);
      $fleet->fg_group = Input::get('fg_group',0);
      $fleet->fg_bandara = Input::get('fg_bandara',0);
      $fleet->save();
      return Redirect::to('fleets');
    } catch (Exception $e) {
    
    }
  }

   public function get_delete($id=false)
  {
    if(!$id) return Redirect::to('fleets');
    $fleet = Fleet::find($id);
    $fleet->delete();
    
    return Redirect::to('fleets');
  }

  public function get_bp()
  { 
    $pool_id = Auth::user()->pool_id;
    
    $this->data['fleetsbp'] = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('ksos.actived', '=', 1)->where('fleets.fg_bp','=',1)->where('fleets.pool_id', '=', $pool_id)->order_by('fleets.taxi_number','asc')->get(array('fleets.taxi_number', 'fleets.id'));

    return View::make('themes.modul.'.$this->views.'.bp',$this->data);
  }
}