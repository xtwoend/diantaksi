<?php

class Reportsnew_Controller extends Base_Controller {

	public $restful = true;
  	public $views = 'report';

	public function get_index()
	{		
    	return false;
	}

	public function get_monthly()
	{
		return View::make('themes.modul.'.$this->views.'.monthly',$this->data);
	}

	public function get_datamonthly($date=false)
	{
		if(!$date) $date = date('Y-m-d');
		
		$year = date('Y', strtotime($date));

		$series = array();
		$categories = array();
				

		foreach (Pool::all() as $pool) { 

			$datafianan = array();
			for($j=1; $j<=12; $j++)
			{
				$categories[] = $j;
				$datafianan[] = 0;
			}

			$reportmonthly = DB::table('financial_report_summary_month_graf')
						->where_year($year)
						->order_by('operasi_time','asc')
						->where_pool_id($pool->id)
						->where('setoran_cash', '<' , 993000000)
						->get();	
			$arraydata = array();
			$bulan=0;
			foreach ($reportmonthly as $finan) {
				$potition = $finan->month;
				$arraydata[$potition] = (int)($finan->setoran_cash - ($finan->biaya_cuci + $finan->iuran_laka));				
			}
			
			$datas = array_replace($datafianan, $arraydata);

			$series[] = array( 	'name' 	=> $pool->pool_name,
							 	'data' 	=> $datas
								);
		}

		$returndata = array(
			'categories' => $categories,
			'series' => $series
			);
		

		return json_encode($returndata);
	}

	
}