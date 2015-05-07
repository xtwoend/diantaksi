<?php
class Pool extends Eloquent {
	public static $timestamps = false;

	public function users()
     {
          return $this->has_many('User');
     }
}