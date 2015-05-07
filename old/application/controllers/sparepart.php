<?php

class Sparepart_Controller extends Base_Controller {

    public $restful = true;
  	public $views = 'sparepart';
  	public $report = 'sparepart.report';

  	public function get_index()
  	{
      
      $allowed = array('name_sparepart', 'part_number', 'sp_categories_id', 'base_price', 'price'); // add allowable columns to search on
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

      $spareparts = $spareparts->paginate(20,array('spareparts.id','name_sparepart','part_number','sp_categories_id','moving','base_price','price','satuan','isi_satuan','sp_category','sp_group'));

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

  		return View::make('themes.modul.'.$this->views.'.index',$this->data);
  	}
    public function get_catalog()
    {
      
      $allowed = array('name_sparepart', 'part_number', 'sp_categories_id', 'base_price', 'price'); // add allowable columns to search on
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

      $spareparts = $spareparts->paginate(20,array('spareparts.id','name_sparepart','part_number','sp_categories_id','moving','base_price','price','satuan','isi_satuan','sp_category','sp_group'));

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

      return View::make('themes.modul.'.$this->views.'.catalog',$this->data);
    }

    public function post_save()
    {
      if(Input::get('id') == '')
      { 
        $sp = Sparepart::create(array(
                          //'id' => Input::get('id'),
                          'name_sparepart' => Input::get('name_sparepart'),
                          'barcode' => Input::get('barcode'),
                          'part_number' =>Input::get('part_number'),
                          'sp_categories_id' => Input::get('sp_categories_id'),
                          'sp_group_id' => Input::get('sp_group_id'),
                          'base_price' => Input::get('base_price'),
                          'price' => Input::get('price'),
                          'min_qty'=> Input::get('min_qty'),
                          'satuan' => Input::get('satuan'),
                          'isi_satuan' => Input::get('isi_satuan'),
                          'user_id' => Auth::user()->id,
                          'last_update' => date('Y-m-d H:i:s'),
                          'moving' => Input::get('moving'),
                          'lokasi' => Input::get('lokasi'),
          ));

      }else{

        $sp = Sparepart::find(Input::get('id'));
        $sp->name_sparepart = Input::get('name_sparepart');
        $sp->barcode = Input::get('barcode');
        $sp->part_number = Input::get('part_number');
        $sp->sp_categories_id = Input::get('sp_categories_id');
        $sp->sp_group_id = Input::get('sp_group_id');
        $sp->base_price = Input::get('base_price');
        $sp->price = Input::get('price');
        $sp->min_qty = Input::get('min_qty');
        $sp->satuan = Input::get('satuan');
        $sp->isi_satuan = Input::get('isi_satuan');
        $sp->user_id = Input::get('user_id');
        $sp->last_update = Input::get('last_update');
        $sp->moving = Input::get('moving');
        $sp->lokasi = Input::get('lokasi');
        $sp->save();
      }    

      return Redirect::to('sparepart');
    }

    public function get_detilsparepart($id=false)
    {
      if(!$id) return false;
      $options = array();
      foreach ( Spcategorie::order_by('sp_category','asc')->get() as $cat) {
        $options[$cat->id] = $cat->sp_category;
      }
      $groupoptions = array();
      foreach ( Spgroup::order_by('sp_group','asc')->get() as $gr) {
        $groupoptions[$gr->id] = $gr->sp_group;
      }
      $this->data['categoriesoption'] = $options;
      $this->data['groupsoption'] = $groupoptions;
      $this->data['sp'] = Sparepart::find($id);
      return View::make('themes.modul.'.$this->views.'.formsparepart',$this->data);
    }

    public function get_newsparepart()
    {
      $options = array();
      foreach ( Spcategorie::order_by('sp_category','asc')->get() as $cat) {
        $options[$cat->id] = $cat->sp_category;
      }
      $groupoptions = array();
      foreach ( Spgroup::order_by('sp_group','asc')->get() as $gr) {
        $groupoptions[$gr->id] = $gr->sp_group;
      }
      $this->data['categoriesoption'] = $options;
      $this->data['groupsoption'] = $groupoptions;
      $this->data['create'] = true;
      return View::make('themes.modul.'.$this->views.'.formsparepart',$this->data);
    }

    public function get_category()
    {
      $this->data['categories'] = Spcategorie::order_by('sp_category','asc')->paginate(10);
      return View::make('themes.modul.'.$this->views.'.category',$this->data);
    }

    public function post_category()
    {
      if(Input::get('id') == '')
      {
        try {
          Spcategorie::create(array(
                      'sp_category' => Input::get('sp_category')
                    ));
          return Redirect::to('sparepart/category');
        } catch (Exception $e) {
           
        }        
      }else{
        try {
          $sp = Spcategorie::find(Input::get('id'));
          $sp->sp_category = Input::get('sp_category');
          $sp->save();

          return Redirect::to('sparepart/category');
        } catch (Exception $e) {
           
        }   
      }
      $this->data['categories'] = Spcategorie::order_by('sp_category','asc')->paginate(10);
      return View::make('themes.modul.'.$this->views.'.category',$this->data);
    }

    public function post_delcategory()
    {
      try {
        $sp = Spcategorie::find(Input::get('id'));
        $sp->delete();
        return Redirect::to('sparepart/category');
      } catch (Exception $e) {
        return $e;
      }
    }

    public function post_delsparepart()
    {
        $sparepart = array(
            'id'  => 'required|exists:spareparts',
        );
        $validation = Validator::make(Input::all(), $sparepart);
        if ($validation->fails())
        {
            Messages::add('error','You tried to delete a sparepart that doesn\'t exist.');
            return Redirect::to($this->views.'');
        }else{
            $sp = Sparepart::find(Input::get('id'));
            $sp->delete();
            Messages::add('success','Sparepart Removed');
            return Redirect::to($this->views.'');
        }
    }

    public function get_groups()
    {
       $this->data['groups'] = Spgroup::order_by('sp_group','asc')->paginate(10);
      return View::make('themes.modul.'.$this->views.'.groups',$this->data);
    }
    
    public function post_groups()
    {
      if(Input::get('id') == '')
      {
        try {
          Spgroup::create(array(
                      'sp_group' => Input::get('sp_group')
                    ));
          return Redirect::to('sparepart/groups');
        } catch (Exception $e) {
           return $e;
        }        
      }else{
        try {
          $sp = Spgroup::find(Input::get('id'));
          $sp->sp_group = Input::get('sp_group');
          $sp->save();

          return Redirect::to('sparepart/groups');
        } catch (Exception $e) {
           return $e;
        }   
      }
      $this->data['groups'] = Spgroup::order_by('sp_group','asc')->paginate(10);
      return View::make('themes.modul.'.$this->views.'.groups',$this->data);
    }

    public function post_delgroup()
    {
      try {
        $sp = Spgroup::find(Input::get('id'));
        $sp->delete();
        return Redirect::to('sparepart/groups');
      } catch (Exception $e) {
        return $e;
      }
    }

    public function get_search()
    {
      return View::make('themes.modul.'.$this->views.'.searchpart',$this->data);
    }
    
    public function get_jsonsparepart()
    {   
        $data = array();

        foreach(Sparepart::all() as $part)
        {
          $data[] = array('<a href="#" data-identity="'.$part->part_number.'">'.$part->part_number.'</a>',$part->name_sparepart,$part->min_qty);
        }

        $returndata = array('aaData'=> $data );


        return json_encode($returndata);
    }

    public function get_autopart()
    {
      $query = Input::get('query');
      $sp = Sparepart::where('part_number','LIKE', '%'.$query.'%')->get();
      $spareparts = array_map(function($object) {
             return $object->to_array();
      }, $sp);

      return json_encode($spareparts);
    }
}