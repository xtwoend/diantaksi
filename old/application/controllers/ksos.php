<?php

class Ksos_Controller extends Base_Controller {

	public $restful = true;
  public $views = 'ksos';
  public $report = 'ksos.report';

	public function get_index()
	{	
    
    return View::make('themes.modul.'.$this->views.'.index',$this->data);
	}

  public function get_formkso()
  { 

    $optionspool = array();
    foreach (Pool::all() as $pool) {
      $optionspool[$pool->id] = $pool->pool_name;
    }
    $opttipe = array();
    foreach (Ksotype::all() as $tipe) {
      $opttipe[$tipe->id] = $tipe->type; 
    }
    $this->data['pools'] = $optionspool;
    $this->data['kso_types'] = $opttipe;
    return View::make('themes.modul.'.$this->views.'.formkso',$this->data);
  }

  public function post_savekso()
  { 
    Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Create KSO', true);
        
    $data = Input::all();
    $extradata = array('user_id'=> Auth::user()->id, 'last_update' => date('Y-m-d H:i:s'), 'actived' => 1);
    $savedata = $data + $extradata;
    $x = Kso::create($savedata);
    if($x){
      $c = Fleet::find($data['fleet_id']);
      $c->fg_kso = 1;
      $c->save();

      return Redirect::to('ksos');
    }
  }
  public function post_saveeditkso()
  {
    Log::write('info', Request::ip() . ' User : '. Auth::user()->fullname . ' Event: Edit KSO', true);
    $data = Input::all();
    $extradata = array('user_id'=> Auth::user()->id, 'last_update' => date('Y-m-d H:i:s'));
    $savedata = $data + $extradata;

    $datasave = Kso::find($data['id']);
    $datasave->kso_number = $data['kso_number'];
    $datasave->fleet_id = $data['fleet_id'];
    $datasave->bravo_driver_id = $data['bravo_driver_id'];
    $datasave->charlie_driver_id = $data['charlie_driver_id'];
    $datasave->pool_id = $data['pool_id'];
    $datasave->dp = $data['dp'];
    $datasave->sisa_dp = $data['sisa_dp'];
    $datasave->setoran = $data['setoran'];
    $datasave->tab_sparepart = $data['tab_sparepart'];
    $datasave->kso_type_id = $data['kso_type_id'];
    $datasave->ops_start = $data['ops_start'];
    $datasave->ops_end = $data['ops_end'];
    $datasave->actived = $data['actived'];
    $datasave->save();    

    if($datasave){
      if($data['actived'] == 2){
        $c = Fleet::find($data['fleet_id']);
        $c->fg_kso = 0;
        $c->save();

        $s = Anakasuh::where('fleet_id','=',$data['fleet_id'])->where('status','=',1)->first();
        
        if($s){
          $s->status = 0;
          $s->end_date = date('Y-m-d',Myfungsi::sysdate());
          $s->save();
        }

      }else if($data['actived'] == 1){
        $c = Fleet::find($data['fleet_id']);
        $c->fg_kso = 1;
        $c->save();
      }
      return Redirect::to('ksos');
    }

    var_dump($data);
  }
  public function get_ksofleet($fleet_id=false)
  {
    if(!$fleet_id) return false;
    $this->data['fleet'] = Fleet::find($fleet_id);
    $this->data['fleetkso'] = Kso::where_fleet_id($fleet_id)->get();
    return View::make('themes.modul.'.$this->views.'.fleetkso',$this->data);
  }

  //get last nuber 
    public function get_lastNumber()
    { 
      $lastnumber = Kso::max('id'); 
      $num    = myFungsi::numberComplate(($lastnumber + 1),5);
      $date   = str_replace('-', '/', date('Y-m-d'));
      $number = 'DT-' . $num . '/KSO/' . $date;
      return json_encode(array('number'=>$number));
    }


    public function get_getFleet($pool_id=false)
    {
      if(!$pool_id) return false;

      $optionFleet = array();
      $optionFleet['----'] = 'null';
      $fleets = Fleet::where_pool_id($pool_id)->where_fg_kso(0)->order_by('taxi_number','asc')->get(array('id','taxi_number'));
      if($fleets){
        foreach ($fleets as $fo) {
          $optionFleet[$fo->taxi_number] = $fo->id;
        }
      }
      return json_encode($optionFleet);
    }

    public function get_getDriver($pool_id=false)
    {
      if(!$pool_id) return false;

      $optionDriver = array();
      $optionDriver['----'] = 'null';
      $drivers = Driver::where_pool_id($pool_id)->order_by('nip', 'asc')->get(array('id','nip','name'));
      if($drivers){
        foreach ($drivers as $do) {
          $optionDriver[$do->nip.' - '.$do->name] = $do->id;
        }
      }
      return json_encode($optionDriver);
    }

    public function get_editkso($id=false)
    {
      if(!$id) Redirect::to('ksos');
      $kso = Kso::find($id);

      $optionspool = array();
      foreach (Pool::all() as $pool) {
        $optionspool[$pool->id] = $pool->pool_name;
      }
      $opttipe = array();
      foreach (Ksotype::all() as $tipe) {
        $opttipe[$tipe->id] = $tipe->type; 
      }

      $optionFleet = array();
      $optionFleet['null'] = '----';
      //$fleets = Fleet::where_pool_id($kso->pool_id)->order_by('taxi_number','asc')->get(array('id','taxi_number'));
      $fleets = Fleet::order_by('taxi_number','asc')->get(array('id','taxi_number'));
      if($fleets){
        foreach ($fleets as $fo) {
          $optionFleet[$fo->id] = $fo->taxi_number;
        }
      }

      $optionDriver = array();
      $optionDriver['null'] = '----';
      //$drivers = Driver::where_pool_id($kso->pool_id)->order_by('nip', 'asc')->get(array('id','nip','name'));
      $drivers = Driver::order_by('nip', 'asc')->get(array('id','nip','name'));
      if($drivers){
        foreach ($drivers as $do) {
          $optionDriver[$do->id] = $do->nip.' - '.$do->name;
        }
      }

      $this->data['statuskso'] = array('1'=> 'Active', '2'=> 'Gugur KSO', '3'=> 'Selesai KSO');


      $this->data['pools'] = $optionspool;
      $this->data['kso_types'] = $opttipe;
      $this->data['datakso'] = $kso;
      $this->data['fleets'] = $optionFleet;
      $this->data['drivers'] = $optionDriver;
      return View::make('themes.modul.'.$this->views.'.formeditkso',$this->data);

    }

    /*
    public function get_editksolist($id=false)
    {
      if(!$id) Redirect::to('ksos');
      $kso = Kso::find($id);

      $optionspool = array();
      foreach (Pool::all() as $pool) {
        $optionspool[$pool->id] = $pool->pool_name;
      }
      $opttipe = array();
      foreach (Ksotype::all() as $tipe) {
        $opttipe[$tipe->id] = $tipe->type; 
      }

      $optionFleet = array();
      $optionFleet['null'] = '----';
      //$fleets = Fleet::where_pool_id($kso->pool_id)->order_by('taxi_number','asc')->get(array('id','taxi_number'));
      $fleets = Fleet::order_by('taxi_number','asc')->get(array('id','taxi_number'));
      if($fleets){
        foreach ($fleets as $fo) {
          $optionFleet[$fo->id] = $fo->taxi_number;
        }
      }

      $optionDriver = array();
      $optionDriver['null'] = '----';
      //$drivers = Driver::where_pool_id($kso->pool_id)->order_by('nip', 'asc')->get(array('id','nip','name'));
      $drivers = Driver::order_by('nip', 'asc')->get(array('id','nip','name'));
      if($drivers){
        foreach ($drivers as $do) {
          $optionDriver[$do->id] = $do->nip.' - '.$do->name;
        }
      }

      $this->data['statuskso'] = array('1'=> 'Active', '2'=> 'Gugur KSO', '3'=> 'Selesai KSO');


      $this->data['pools'] = $optionspool;
      $this->data['kso_types'] = $opttipe;
      $this->data['datakso'] = $kso;
      $this->data['fleets'] = $optionFleet;
      $this->data['drivers'] = $optionDriver;
      return View::make('themes.modul.'.$this->views.'.formeditksolist',$this->data);
    }
    */

    public function post_delkso()
    {
      $id = Input::get('id');
      if(!$id) return false;
      $kso = Kso::find($id);
      $kso->delete();

      return Redirect::to('ksos');
    }

    public function get_listkso()
    {
      
      $allowed = array('kso_number', 'fleet_id', 'ops_start', 'ops_end', 'kso_type_id'); // add allowable columns to search on
      $sort = in_array(Input::get('sort'), $allowed) ? Input::get('sort') : 'fleet_id'; // if user type in the url a column that doesnt exist app will default to id
      $order = Input::get('order') === 'desc' ? 'desc' : 'asc'; // default desc
      $keyword = Input::get('q');
      $search = Input::get('search');

      $ksos = Kso::join('fleets as f','f.id','=','ksos.fleet_id')
                              ->where('ksos.pool_id','=',Auth::user()->pool_id)
                              ->where('ksos.actived','=',1)
                              ->order_by($sort, $order);

      $q = null;
      
      if (Input::has('q')) {
        $ksos = $ksos->where($search,'like', '%'.$keyword.'%');
        $q = '&search='.$search.'&q='.$keyword;
      }

      $ksos = $ksos->paginate(20,array('ksos.id','kso_number','fleet_id','ops_start','ops_end','kso_type_id','actived','dp','ksos.pool_id','taxi_number','police_number'));

      $this->data['querystr'] = '&order='.(Input::get('order') == 'asc' || null ? 'desc' : 'asc').$q;
      $this->data['ksos'] = $ksos;
      $this->data['searchby'] = $search;
      $this->data['q'] = $keyword;
      $this->data['pagination'] = $ksos->appends(
        array(
            'search'    => Input::get('search'),
            'q'         => Input::get('q'),
            'sort'      => Input::get('sort'),
            'order'     => Input::get('order')
        ))->links();

      return View::make('themes.modul.'.$this->views.'.listkso',$this->data);

    }

    /**
     * @doc
     * 
     */
    public function get_downloadksoactive()
    {
        $pool_id = Auth::user()->pool_id;

        $this->data['ksos'] = Kso::join('fleets as f','f.id','=','ksos.fleet_id')
                              ->join('drivers as d', 'd.id','=', 'ksos.bravo_driver_id')
                              ->where('ksos.pool_id','=',Auth::user()->pool_id)
                              ->where('ksos.actived','=',1)
                              ->order_by('f.taxi_number','asc')
                              ->get();

        return View::make('themes.modul.'.$this->report.'.listksoactive', $this->data);
    }
}