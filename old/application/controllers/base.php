<?php

class Base_Controller extends Controller {

	public $data = array();
	// Our first stuff
    public function __construct(){
        // Make sure that the 'auth' function is run before ANYTHING else happens
        // With the exception of our login page (to actually login) this will
        // prevent any un-authorised use of the admin areas
    	$this->filter('before', 'auth')->except(array('login'));

        // Default variable set for CRUD usage.
    	$this->data['create'] = false;

        // Get the user details from when they logged in / old sessions
    	$this->data['user'] = Auth::user();
        $user_roles = array();
        if(Auth::user()){
            foreach (Auth::user()->roles as $role) {
                array_push($user_roles, $role->id);
            }
        }
        $this->data['user_roles'] = $user_roles;

    }

    /**
     * Checks to see if the user is logged in. If they aren't we get redirected to the login page
     * @return header redirect
     */
	public function auth(){
    	if (Auth::guest()) return Redirect::to('admin/login');
    }
}