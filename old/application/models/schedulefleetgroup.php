<?php
class Schedulefleetgroup extends Eloquent {
	public static $timestamps = false;
	public static $table = 'schedule_fleet_groups';

	public function fleet()
    {
          return $this->has_one('Fleet' , 'fleet_id');
    }

    public function schedulegroup()
     {
          return $this->belongs_to('Schedulegroup');
     }

}