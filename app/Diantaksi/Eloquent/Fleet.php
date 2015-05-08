<?php namespace App\Diantaksi\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fleets';



    /**
     * Anak Asuh .
     *
     * @return
     */
    public function bapakasuh()
    {
    	return $this->belongsToMany(__NAMESPACE__ . '\\User', 'anak_asuh', 'fleet_id', 'user_id')->withPivot('status', 'start_date', 'end_date');
    }

}