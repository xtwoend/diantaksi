<?php namespace App\Diantaksi\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'checkin_time';


	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'checkins';


    /**
     * checkins financial .
     *
     * @return
     */
    public function financial()
    {
    	return $this->hasMany(__NAMESPACE__ .'\\CheckinFinancial', 'checkin_id');
    }

    /**
     * Fleet .
     *
     * @return
     */
    public function fleet()
    {
    	return $this->belongsTo(__NAMESPACE__ .'\\Fleet', 'fleet_id')->orderBy('taxi_number', 'asc');
    }

    /**
     * Driver Relations.
     *
     * @return
     */
    public function driver()
    {
    	return $this->belongsTo(__NAMESPACE__ .'\\Driver', 'driver_id');
    }

    /**
     * document checklist.
     *
     * @return
     */
    public function document()
    {
        return $this->hasOne(__NAMESPACE__ . '\\CheckinDocument', 'checkin_id');
    }

    /**
     * document checklist.
     *
     * @return
     */
    public function physic()
    {
        return $this->hasOne(__NAMESPACE__ . '\\CheckinPhysic', 'checkin_id');
    }

    /**
     * .
     *
     * @return
     */
    public function step()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\CheckinStep', 'checkin_step_id');
    }

    /**
     * .
     *
     * @return
     */
    public function status()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\OperasiStatus', 'operasi_status_id');
    }
}