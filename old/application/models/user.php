<?php
class User extends Eloquent {
	public static $timestamps = true;
	public static $table = 'users';
	
	//roles relasi
	public function roles()
	{
		return $this->has_many_and_belongs_to('Role');
	}
	
	// pool relasi
	public function pools()
	{
		 return $this->belongs_to('Pool','pool_id');
	}
	
	//atrribut get
	public function set_password($password)
	{
		$this->set_attribute('password', Hash::make($password));
	}
	
	public function get_fullname(){
		return $this->get_attribute('first_name').' '.$this->get_attribute('last_name');
	}

	public function get_is_admin(){
		return ( $this->get_attribute('admin') === 1 ) ? true : false ;
	}

	public function get_pool_id()
	{
		return $this->get_attribute('pool_id');
	}

	
}