<?php

class Reports_Controller extends Base_Controller {

	public $restful = true;
  	public $views = 'report';

	public function get_index()
	{		
    	return false;
	}

	public function get_daily()
	{
		return View::make('themes.modul.'.$this->views.'.daily',$this->data);
	}

	public function get_datadaily($date=false)
	{
		if(!$date) $date = date('Y-m-d');
		
		$month = date('n', strtotime($date));
		$year = date('Y', strtotime($date));

		$series = array();
		$categories = array();
				

		foreach (Pool::all() as $pool) { 

			$datafianan = array();
			for($j=1; $j<=date('t',strtotime($date)); $j++)
			{
				$categories[] = $j;
				$datafianan[] = 0;
			}

			$reportdaily = DB::table('financial_report_summary_graf')
						->where_month($month)
						->where_year($year)
						->order_by('operasi_time','asc')
						->where_pool_id($pool->id)
						->where('setoran_cash', '<' , 50000000)
						->get();	
			$arraydata = array();
			foreach ($reportdaily as $finan) {
				$potition = ( date('j',strtotime($finan->operasi_time)) - 1);
				$arraydata[$potition] = (int)($finan->setoran_cash - ($finan->biaya_cuci + $finan->iuran_laka));				
			}
			
			$datas = array_replace($datafianan, $arraydata);

			$series[] = array( 'name' 	=> $pool->pool_name,
								'data' 	=> $datas
							);
		}

		$returndata = array(
			'categories' => $categories,
			'series' => $series
			);
		

		return json_encode($returndata);
	}

	public function get_downdaily()
	{
		return View::make('themes.modul.'.$this->views.'.downdaily',$this->data);
	}

	public function get_datadowndaily($date=false)
	{
		if(!$date) $date = date('Y-m-d');
		
		$month = date('n', strtotime($date));
		$year = date('Y', strtotime($date));

		$series = array();
		$categories = array();
				

		foreach (Pool::all() as $pool) { 

			$datafianan = array();
			for($j=1; $j<=date('t',strtotime($date)); $j++)
			{
				$categories[] = $j;
				$datafianan[] = 0;
			}

			$reportdaily = DB::table('financial_report_summary_graf')
						->where_month($month)
						->where_year($year)
						->order_by('operasi_time','asc')
						->where_pool_id($pool->id)
						->where('setoran_cash', '<' , 50000000)
						->get();	
			$arraydata = array();
			foreach ($reportdaily as $finan) {
				$potition = ( date('j',strtotime($finan->operasi_time)) - 1);
				$arraydata[$potition] = (int) $finan->ks ;				
			}

			$datas = array_replace($datafianan, $arraydata);

			$series[] = array( 'name' 	=> $pool->pool_name,
								'data' 	=> $datas
							);
		}

		$returndata = array(
			'categories' => $categories,
			'series' => $series
			);
		

		return json_encode($returndata);
	}

	public function get_ksmurni()
	{
		return View::make('themes.modul.'.$this->views.'.ksmurni',$this->data);
	}

	public function get_dataksmurni($date=false)
	{
		if(!$date) $date = date('Y-m-d');
		
		$month = date('n', strtotime($date));
		$year = date('Y', strtotime($date));

		$series = array();
		$categories = array();
				

		foreach (Pool::all() as $pool) { 

			$datafianan = array();
			for($j=1; $j<=date('t',strtotime($date)); $j++)
			{
				$categories[] = $j;
				$datafianan[] = 0;
			}

			$reportdaily = DB::table('financial_report_graf_ks_detail')
						->where_month($month)
						->where_year($year)
						->order_by('operasi_time','asc')
						->where_pool_id($pool->id)
						->where_in('operasi_status_id',array(1,3))
						->where('setoran_cash', '<' , 50000000)
						->group_by('operasi_time')
						->get(array('operasi_time',DB::raw('sum(ks) as subks') ));

			$arraydata = array();
			foreach ($reportdaily as $finan) {
				$potition = ( date('j',strtotime($finan->operasi_time)) - 1);
				$arraydata[$potition] = (int) $finan->subks ;				
			}

			$datas = array_replace($datafianan, $arraydata);

			$series[] = array( 'name' 	=> $pool->pool_name,
								'data' 	=> $datas
							);
		}

		$returndata = array(
			'categories' => $categories,
			'series' => $series
			);
		

		return json_encode($returndata);
	}
	//report checkin&checkout scurity

	public function get_checkinout()
	{
		$date = Input::get('date',date('Y-m-d'));
	
		
		$checkout = Checkout::left_join('checkins as cin', function($join)
							    {
							        $join->on('checkouts.kso_id', '=', 'cin.kso_id');
							        $join->on('checkouts.operasi_time', '=', 'cin.operasi_time');
							    })//'checkouts.kso_id', '=', 'cin.kso_id' )
         					//>raw_where('checkouts.operasi_time = cin.operasi_time')
							->where('checkouts.operasi_time','=', $date)
							->where('checkouts.pool_id','=',Auth::user()->pool_id)
							->order_by('checkouts.checkout_time','asc')
							->get(array('cin.id as checkin_id',
										'checkouts.id as checkout_id',
										'checkouts.fleet_id',
										'checkouts.driver_id',
										'checkouts.printspj_time',
										'checkouts.checkout_time',
										'checkouts.shift_id',
										'checkouts.operasi_status_id',
										'cin.checkin_time',
										'cin.km_fleet',
										'cin.operasi_time'
										));
		//var_dump($checkout);
		
		$this->data['date'] = $date;
		$this->data['checkout'] = $checkout;
		return View::make('themes.modul.'.$this->views.'.checkinout',$this->data);
	}
	public function get_checkinoutreport()
	{
		$date = Input::get('date',date('Y-m-d'));
		$checkout = Checkout::left_join('checkins as cin', function($join)
							    {
							        $join->on('checkouts.kso_id', '=', 'cin.kso_id');
							        $join->on('checkouts.operasi_time', '=', 'cin.operasi_time');
							    })//'checkouts.kso_id', '=', 'cin.kso_id' )
         					//>raw_where('checkouts.operasi_time = cin.operasi_time')
							->where('checkouts.operasi_time','=', $date)
							->where('checkouts.pool_id','=',Auth::user()->pool_id)
							->order_by('checkouts.printspj_time','asc')
							->get(array('cin.id as checkin_id',
										'checkouts.id as checkout_id',
										'checkouts.fleet_id',
										'checkouts.driver_id',
										'checkouts.printspj_time',
										'checkouts.checkout_time',
										'checkouts.shift_id',
										'checkouts.operasi_status_id',
										'cin.checkin_time',
										'checkouts.print_out_time',
										'checkouts.otorisasi_user_id',
										'checkouts.keterangan',
										));

		$this->data['date'] = $date;
		$this->data['checkout'] = $checkout;
		return View::make('themes.modul.'.$this->views.'.checkinoutreport',$this->data);
	}

	public function get_baparchive()
	{
		$date = Input::get('date',date('Y-m-d'));

		$baps = Bap::left_join('open_blocking as ob','ob.bap_id','=','baps.id')
							->where('baps.date','=', $date)
							->where('baps.pool_id','=',Auth::user()->pool_id)
							->get(array('baps.bap_number',
										'baps.id as id',
										'baps.fleet_id',
										'baps.driver_id',
										'baps.user_id',
										'baps.pool_id',
										'baps.date',
										'baps.last_update',
										'ob.bap_id',
										'ob.otorisasi2_id'
										));

		$this->data['date'] = $date;
		$this->data['baps'] = $baps;
		return View::make('themes.modul.'.$this->views.'.baparchive',$this->data);
	}
}