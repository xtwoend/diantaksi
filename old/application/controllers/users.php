<?php
class Users_Controller extends Base_Controller
{

    public $restful = true;
    public $views = 'users';

    public function get_index()
    {
    	$this->data[$this->views] = User::order_by('id','asc')->get();
        return View::make('themes.modul.'.$this->views.'.index',$this->data);
    }
    public function get_edit($object_id = false){
    	// Do our checks to make sure things are in place
    	if(!$object_id) return Redirect::to($this->views);
    	$object = User::find($object_id);
    	if(!$object) return Redirect::to($this->views);
    	$this->data['user'] = $object;
        $this->data['roles'] = Role::all();
        $opt = array();
        foreach (Pool::all() as $po) {
            $opt[$po->id] = $po->pool_name; 
        }
        $this->data['pools'] = $opt;
    	return View::make('themes.modul.'.$this->views.'.form',$this->data);
    }

    public function post_delete(){
        $rules = array(
            'id'  => 'required|exists:users',
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error','You tried to delete a user that doesn\'t exist.');
            return Redirect::to($this->views.'');
        }else{
            $user = User::find(Input::get('id'));
            $user->roles()->delete();
            $user->delete();
            Messages::add('success','User Removed');
            return Redirect::to($this->views);
        }
    }

    public function post_create(){
        $rules = array(
            'username'  => 'required|unique:users|max:255',
            'first_name'  => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email' => 'required|email',
            'password' => 'confirmed',
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error',$validation->errors->all());
            return Redirect::to($this->views.'/create')->with_input();
        }else{
            $usr = new User;
            $usr->username = Input::get('username');
            $usr->email = Input::get('email');
            $usr->first_name = Input::get('first_name');
            $usr->last_name = Input::get('last_name');
            $usr->active = 1;
            $usr->pool_id = Input::get('pool_id');
            $usr->admin = Input::get('admin') ? 1 : 0;
            if(Input::get('password')){
                $usr->password = Input::get('password');
            }
            $usr->save();
            $usr->roles()->delete();
            if(Input::get('roles')){
                foreach(Input::get('roles') as $rolekey=>$val){
                    $usr->roles()->attach($rolekey);
                }
            }
            Messages::add('success','New User Added');
            return Redirect::to($this->views);
        }
    }

    public function post_edit(){
        $rules = array(
            'id'  => 'required|exists:users',
            'username'  => 'required|max:255',
            'first_name'  => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email' => 'required|email',
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error',$validation->errors->all());
            return Redirect::to($this->views.'/edit')->with_input();
        }else{

            $usr = User::find(Input::get('id'));
            $usr->username = Input::get('username');
            $usr->email = Input::get('email');
            $usr->first_name = Input::get('first_name');
            $usr->last_name = Input::get('last_name');
            $usr->admin = Input::get('admin') ? 1 : 0;
            $usr->active = 1;
            $usr->pool_id = Input::get('pool_id');
            if(Input::get('password')){
                $usr->password = Input::get('password');
            }
            $usr->roles()->delete();
            if(Input::get('roles')){
                foreach(Input::get('roles') as $rolekey=>$val){
                    $usr->roles()->attach($rolekey);
                }
            }
            $usr->save();
            Messages::add('success','User updated');
            return Redirect::to($this->views.'');
        }
    }

    /**
     * Our user article create function
     *
     **/
    public function get_create(){
        $this->data['create'] = true;
        $this->data['roles'] = Role::all();
        $opt = array();
        foreach (Pool::all() as $po) {
            $opt[$po->id] = $po->pool_name; 
        }
        $this->data['pools'] = $opt;
        return View::make('themes.modul.'.$this->views.'.form',$this->data);
    }

    public function get_changepassword()
    {
        $this->data['user'] = Auth::user();
        return View::make('themes.modul.'.$this->views.'.changepassword',$this->data);
    }

    public function post_changepassword()
    {
        $usr = User::find(Auth::user()->id);
        if(Input::get('password')){
                $usr->password = Input::get('password');
        }
        $usr->save();
        Messages::add('success','Password Changed!');
        return Redirect::to('users/changepassword');
    }

    public function get_swichpool($pool_id = false)
    {
        if(!$pool_id) return Redirect::to('admin/dashboard');

        $user = User::find(Auth::user()->id);
        $user->pool_id = $pool_id;
        $user->save();
        return Redirect::to('admin/dashboard');
    }
}