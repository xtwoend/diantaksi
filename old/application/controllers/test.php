<?php

class Test_Controller extends Controller {

	public $restful = true;

	public function get_index()
	{	
		return View::make('test',$this->data);
	}
	public function post_index()
	{
		var_dump($_POST);
	}


	public function get_clonejho()
	{
		$checkouts = Checkin::all();

		foreach ($checkouts as $a) {
			$chk = Checkin::where('fleet_id','=',$a->fleet_id)->where('operasi_time','=',$a->operasi_time)->first();
			$chk->jho_id = $a->jho_id;
		}
	}

	public function get_aja()
	{		
			 $offset = 3; $limit = 2;
		 	$saldohutangbymonth = DB::query('select 
								cin.*,
								f.taxi_number,
								cf.checkin_id,
								sum(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
								sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
								sum(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
								sum(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
								sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
								sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
								sum(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
								sum(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
								sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
								sum(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
								sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
								sum(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
								sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
								sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
								sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan,
								(sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
								from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
								join fleets f on (cin.fleet_id = f.id)
								where cin.operasi_time < ? 
								and cin.pool_id = ?
								and cin.shift_id = ?
								group by cin.kso_id
								limit ? , ?
								', array('2013-12-31', 2, 1, $offset, $limit));
	    var_dump($saldohutangbymonth);

	}
}