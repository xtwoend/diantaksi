<?php namespace App\Diantaksi\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Kso extends Model
{

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ksos';

    /**
     * .
     *
     * @return
     */
    public function fleet()
    {
    	return $this->belongsTo(__NAMESPACE__ . '\\Fleet', 'fleet_id');
    }

    /**
     * bravo.
     *
     * @return
     */
    public function bravo()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Driver', 'bravo_driver_id');
    }

    /**
     * .
     *
     * @return
     */
    public function charlie()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Driver', 'charlie_driver_id');
    }
}