<?php
class Fleet extends Eloquent {
	public static $timestamps = false;
	public static $table = 'fleets';

	public function schedulefleetgroup()
    {
        return $this->belongs_to('Schedulefleetgroup');
    }

    public function pool()
    {	
    	return $this->belongs_to('Pool','pool_id');
    }
}