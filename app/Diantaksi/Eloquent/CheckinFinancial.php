<?php namespace App\Diantaksi\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CheckinFinancial extends Model
{

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'checkin_financials';

    /**
     * Relation To Checkin.
     *
     * @return
     */
    public function checkin()
    {
    	return $this->belongsTo(__NAMESPACE__ . '\\Checkin');
    }

    /**
     * .
     *
     * @return
     */
    public function label()
    {
    	return $this->belongsTo(__NAMESPACE__ . '\\FinancialType', 'financial_type_id');
    }
}