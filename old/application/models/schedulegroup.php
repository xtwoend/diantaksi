<?php
class Schedulegroup extends Eloquent {
	public static $timestamps = false;
	public static $table = 'schedule_groups';

	public function schedulefleetgroup()
    {
          return $this->has_many('Schedulefleetgroup', 'schedule_group_id');
    }

    
}