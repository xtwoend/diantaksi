<?php

namespace App\Diantaksi\Reports;

use App\Diantaksi\Eloquent\Kso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use Illuminate\Support\Str;

/**
* 
*/
class ReportSparepart
{	
	/**
	 * [$ksos description]
	 */
	protected $ksos;

	/**
	 * [$user description]
	 * @var [type]
	 */
	protected $user;

	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->ksos = new Kso;
		$this->user = Auth::user();
	}

	/**
	 * [FunctionName description]
	 * @param string $value [description]
	 */
	public function reportJson(Request $request)
	{
		$date = $request->get('date', date('Y-m-01'));
		$month = date('m', strtotime($date));
		$year = date('Y', strtotime($date));
		
		$pool = Auth::user()->pool_id;

		$dbQuery = $this->queryData($month, $year, $pool);
		
		$no = 0;

		$data = [];
		$information = [];
		$total = 0;
		foreach ($dbQuery as $row) {
			$information = [
				'no' => $no++,
				'taxi_number'	=> $row->taxi_number,
				'inserted_date_set' => date('d/m/Y',strtotime($row->inserted_date_set)),
				'wo_number'	=> $row->wo_number,
				'part_number' => $row->part_number,
				'name_sparepart' => $row->name_sparepart,
				'qty'	=> $row->qty,
				'satuan' => $row->satuan,
				'price'	=> $row->price,
				'subtotal' => $row->subtotal
			];
			$total += $row->subtotal;
			$data['rows'][] = $information;
		}
		$data['userdata']['name_sparepart']  = 'TOTAL';
		$data['userdata']['subtotal'] = $total;

		return response($data, 200)
              ->header('Content-Type', 'application/json');	
	}

	public function reportDownload($request)
	{
		$date = $request->get('date', date('Y-m-01'));
		$month = date('m', strtotime($date));
		$year = date('Y', strtotime($date));
		
		$pool = Auth::user()->pool_id;

		

		$objPHPExcel = new PHPExcel();
      	$objPHPExcel->getProperties()->setCreator($this->user->fullname)
               ->setLastModifiedBy($this->user->fullname)
               ->setTitle("LAPORAN PEMAKAIAN SPAREPART ". $this->user->pool->pool_name . '-' . date('d-m-Y'))
               ->setSubject("LAPORAN PEMAKAIAN SPAREPART ". $this->user->pool->pool_name . '-' . date('d-m-Y'))
               ->setDescription("LAPORAN PEMAKAIAN SPAREPART ". $this->user->pool->pool_name )
               ->setKeywords("LAPORAN PEMAKAIAN SPAREPART"); 
      
  	    $styleArray = array(
    	        'font'  => array(
    	            'bold'  => true,
    	            'color' => array('rgb' => 'FF0000'),
    				'size'  => 16
    	 	));

  	    $sheet_active = 0;

  	    $objPHPExcel->createSheet(NULL, $sheet_active);
        $objPHPExcel->setActiveSheetIndex($sheet_active);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN PEMAKAIAN SPAREPART TANGGAL ' . $date  );
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);      
        
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'TANGGAL');
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'BODY');
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'BPB PART');
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'NOMOR PART');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'NAMA SPAREPART');
       
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'QTY');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'SATUAN');
        $objPHPExcel->getActiveSheet()->setCellValue('I5', 'HARGA SATUAN');

        $objPHPExcel->getActiveSheet()->setCellValue('J5', 'TOTAL');

        $no = 1;
        $starline = 7;
        $tempBody = '';

        $groupByArmada = $this->queryGroupArmada($month, $year, $pool);
        $grandTotal = 0;
        foreach ($groupByArmada as $rew) {

        	$dbQuery = $this->queryDataPerBody($month, $year, $pool, $rew->fleet_id);
        	
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $starline, $rew->taxi_number);
        	$xline = $starline;
        	foreach ($dbQuery as $row) {       		        	
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, date('d/m/Y',strtotime($row->inserted_date_set)));
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $starline, $row->wo_number);
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $starline, $row->part_number);
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $starline, $row->name_sparepart);
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $starline, $row->qty);
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $starline, $row->satuan);
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $starline, $row->price);
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $starline, $row->subtotal);	        	
	            $grandTotal += $row->subtotal;
	            $starline ++;
	        }

	        $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline),'SUB TOTAL');
        	$objPHPExcel->getActiveSheet()->setCellValue('J'.($starline), '=SUM(J'.$xline.':J'.$starline -1 .')');

        	$starline ++;
        	$no ++;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('F'.($starline + 1),'GRAND TOTAL');
        $objPHPExcel->getActiveSheet()->setCellValue('J'.($starline + 1), $grandTotal);

        $objPHPExcel->getActiveSheet()->getStyle('A5:J'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
        $objPHPExcel->getActiveSheet()->getStyle('A5:J6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A5:J'.($starline))->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($starline + 1).':J'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


  	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	    $objWriter->save(storage_path('excels/').'LPS'. $this->user->pool_id.$date.'.xls');
    	return response()->download(storage_path('excels/').'LPS'. $this->user->pool_id.$date.'.xls', 'LAPORAN-PEMAKAIN-SPAREPART-'.Str::slug($this->user->pool->pool_name, '-').'-BULAN-'. $date .'.xls' );
	}

	protected function queryData($month, $year, $pool)
	{
		$query = "select `wo`.`id` AS `id`,
				`wo`.`kso_id` AS `kso_id`,
				`wo`.`wo_number` AS `wo_number`,
				`wo`.`fleet_id` AS `fleet_id`,
				`wo`.`driver_id` AS `driver_id`,
				`wo`.`pool_id` AS `pool_id`,
				`wo`.`km` AS `km`,
				`wo`.`complaint` AS `complaint`,
				`wo`.`information_complaint` AS `information_complaint`,
				`wo`.`status` AS `status`,
				`wo`.`mechanic_id` AS `mechanic_id`,
				`wo`.`mechanic` AS `mechanic`,
				`wo`.`dp_sparepart` AS `dp_sparepart`,
				`wo`.`user_id` AS `user_id`,
				`wo`.`inserted_date_set` AS `inserted_date_set`,
				`wo`.`finished_date_set` AS `finished_date_set`,
				`wo`.`fg_part_approved` AS `fg_part_approved`,
				`wo`.`user_approved` AS `user_approved`,
				`item`.`sparepart_id` AS `sparepart_id`,
				`item`.`qty` AS `qty`,
				`item`.`price` AS `price`,
				`sp`.`part_number` AS `part_number`,
				`sp`.`name_sparepart` AS `name_sparepart`,
				`sp`.`satuan` AS `satuan`,
				`sp`.`isi_satuan` AS `isi_satuan`,
				`fleets`.`taxi_number` AS 'taxi_number',
				month(`wo`.`inserted_date_set`) AS `month`,
				year(`wo`.`inserted_date_set`) AS `year`,
				(`item`.`qty` * `item`.`price`) AS `subtotal` 
				from ((`wo_part_items` `item` join `work_orders` `wo` on((`item`.`wo_id` = `wo`.`id`))) 
					join `spareparts` `sp` on((`item`.`sparepart_id` = `sp`.`id`))) 
					join `fleets` on (`wo`.`fleet_id` = `fleets`.`id`)
					where ((`wo`.`status` = 3) and (`item`.`telah_dikeluarkan` = 1)) 
					and month(`wo`.`inserted_date_set`) = ?
					and year(`wo`.`inserted_date_set`) = ?
					and `wo`.`pool_id` = ? 
					order by `fleets`.`taxi_number`, `wo`.`inserted_date_set` asc";

		return DB::select($query, [$month, $year, $pool]);
	}

	protected function queryDataPerBody($month, $year, $pool, $fleet)
	{
		$query = "select `wo`.`id` AS `id`,
				`wo`.`kso_id` AS `kso_id`,
				`wo`.`wo_number` AS `wo_number`,
				`wo`.`fleet_id` AS `fleet_id`,
				`wo`.`driver_id` AS `driver_id`,
				`wo`.`pool_id` AS `pool_id`,
				`wo`.`km` AS `km`,
				`wo`.`complaint` AS `complaint`,
				`wo`.`information_complaint` AS `information_complaint`,
				`wo`.`status` AS `status`,
				`wo`.`mechanic_id` AS `mechanic_id`,
				`wo`.`mechanic` AS `mechanic`,
				`wo`.`dp_sparepart` AS `dp_sparepart`,
				`wo`.`user_id` AS `user_id`,
				`wo`.`inserted_date_set` AS `inserted_date_set`,
				`wo`.`finished_date_set` AS `finished_date_set`,
				`wo`.`fg_part_approved` AS `fg_part_approved`,
				`wo`.`user_approved` AS `user_approved`,
				`item`.`sparepart_id` AS `sparepart_id`,
				`item`.`qty` AS `qty`,
				`item`.`price` AS `price`,
				`sp`.`part_number` AS `part_number`,
				`sp`.`name_sparepart` AS `name_sparepart`,
				`sp`.`satuan` AS `satuan`,
				`sp`.`isi_satuan` AS `isi_satuan`,
				`fleets`.`taxi_number` AS 'taxi_number',
				month(`wo`.`inserted_date_set`) AS `month`,
				year(`wo`.`inserted_date_set`) AS `year`,
				(`item`.`qty` * `item`.`price`) AS `subtotal` 
				from ((`wo_part_items` `item` join `work_orders` `wo` on((`item`.`wo_id` = `wo`.`id`))) 
					join `spareparts` `sp` on((`item`.`sparepart_id` = `sp`.`id`))) 
					join `fleets` on (`wo`.`fleet_id` = `fleets`.`id`)
					where ((`wo`.`status` = 3) and (`item`.`telah_dikeluarkan` = 1)) 
					and month(`wo`.`inserted_date_set`) = ?
					and year(`wo`.`inserted_date_set`) = ?
					and `wo`.`pool_id` = ? 
					and `wo`.`fleet_id` = ?
					order by `fleets`.`taxi_number`, `wo`.`inserted_date_set` asc";

		return DB::select($query, [$month, $year, $pool, $fleet]);
	}

	public function queryGroupArmada($month, $year, $pool)
	{
		$query = "select `wo`.`id` AS `id`,				
				`wo`.`kso_id` AS `kso_id`,
				`wo`.`wo_number` AS `wo_number`,
				`wo`.`fleet_id` AS `fleet_id`,
				`wo`.`driver_id` AS `driver_id`,
				`wo`.`pool_id` AS `pool_id`,
				`wo`.`km` AS `km`,
				`wo`.`complaint` AS `complaint`,
				`wo`.`information_complaint` AS `information_complaint`,
				`wo`.`status` AS `status`,
				`wo`.`mechanic_id` AS `mechanic_id`,
				`wo`.`mechanic` AS `mechanic`,
				`wo`.`dp_sparepart` AS `dp_sparepart`,
				`wo`.`user_id` AS `user_id`,
				`wo`.`inserted_date_set` AS `inserted_date_set`,
				`wo`.`finished_date_set` AS `finished_date_set`,
				`wo`.`fg_part_approved` AS `fg_part_approved`,
				`wo`.`user_approved` AS `user_approved`,
				`item`.`sparepart_id` AS `sparepart_id`,
				`item`.`qty` AS `qty`,
				`item`.`price` AS `price`,
				`sp`.`part_number` AS `part_number`,
				`sp`.`name_sparepart` AS `name_sparepart`,
				`sp`.`satuan` AS `satuan`,
				`sp`.`isi_satuan` AS `isi_satuan`,
				`fleets`.`taxi_number` AS 'taxi_number',
				month(`wo`.`inserted_date_set`) AS `month`,
				year(`wo`.`inserted_date_set`) AS `year`,
				sum(`item`.`qty` * `item`.`price`) AS `subtotal` 
				from ((`wo_part_items` `item` join `work_orders` `wo` on((`item`.`wo_id` = `wo`.`id`))) 
					join `spareparts` `sp` on((`item`.`sparepart_id` = `sp`.`id`))) 
					join `fleets` on (`wo`.`fleet_id` = `fleets`.`id`)
					where ((`wo`.`status` = 3) and (`item`.`telah_dikeluarkan` = 1)) 
					and month(`wo`.`inserted_date_set`) = ?
					and year(`wo`.`inserted_date_set`) = ?
					and `wo`.`pool_id` = ? 
					GROUP BY `wo`.`fleet_id`
					order by `fleets`.`taxi_number`, `wo`.`inserted_date_set`";

		return DB::select($query, [$month, $year, $pool]);
	}
}