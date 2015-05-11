<?php namespace App\Diantaksi\Eloquent;

/**
 * Part of the package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    
 * @version    0.1
 * @author     Abdul Hafidz Anshari
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014 
 */
 
trait RoleTrait {
	
	/**
	 * Relation to "Role".
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|null
	 */
	public function roles()
	{
		return $this->belongsToMany( __NAMESPACE__ . '\\Role' )->withTimestamps();
	}

	/**
	 * Get all roles from current user.
	 *
	 * @return array|null
	 */
	public function getRoles()
	{	
		return ! is_null($this->roles) ? $this->roles->lists('slug')->toArray() : null;
	}

	/**
	 * Get user role from the current user.
	 *
	 * @return \Role
	 */
	public function getRole()
	{
		return $this->roles->first();
	}
    
    /**
     * Get role id
     *
     * @return mixed
     */
	public function getRoleId()
	{	
		return $this->getRole() ? $this->getRole()->id : null;
	}

	/**
	 * Check whether the user has a given role.
	 *
	 * @param  string  $role  
	 * @return boolean
	 */
	public function can($role)
	{	
		return in_array($role, $this->getRoles());
	}

	/**
	 * Has role scope.
	 * 
	 * @param  Builder $query 
	 * @param  string  $type  
	 * @return Builder        
	 */
	public function scopeHasRole($query, $type)
	{
		return $query->whereHas('roles', function($query) use ($type)
		{
			$query->where('slug', $type);
		});
	}

	/**
	 * Add role to this user.
	 * 
	 * @param int $id 
	 */
	public function addRole($id)
	{
		$this->roles()->attach($id);
	}

	/**
	 * Update roles.
	 * 
	 * @param  int $id 
	 * @return void     
	 */
	public function updateRole($id)
	{
		$this->roles()->detach($this->getRoleId());

		$this->addRole($id);
	}
	
	/**
	 * Handle dynamic method.
	 *
	 * @param  string  $method  
	 * @param  array   $parameters  
	 * @return boolean
	 */
	public function __call($method, $parameters = array())
	{
		if(starts_with($method, 'can') and $method != 'can')
		{
			return $this->can(snake_case(substr($method, 3)));
		}
		elseif (in_array($method, ['increment', 'decrement']))
		{
			return call_user_func_array([$this, $method], $parameters);
		}
		else
		{
			$query = $this->newQuery();

			return call_user_func_array([$query, $method], $parameters);
		}
	}
	
}
