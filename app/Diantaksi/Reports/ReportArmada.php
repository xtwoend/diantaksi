<?php  namespace App\Diantaksi\Reports;

/**
 * Part of the package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    
 * @version    0.1
 * @author     Abdul Hafidz Anshari
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014 
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Diantaksi\Eloquent\Checkin;
use App\Diantaksi\Eloquent\FleetModel;
use App\Diantaksi\Eloquent\Kso;
use DB;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use Illuminate\Support\Str;

class ReportArmada
{
		/**
	   * [$user description]
	   * @var [type]
	   */
		protected $user;

	  /**
	   * [$fleetmodel description]
	   * @var [type]
	   */
	  protected $fleetmodel;

		/**
		 * [$checkins description]
		 * @var [mixed]
		 */
		protected $checkins;

	  /**
	   * [$label description]
	   * @var [type]
	   */
		public 	$label = [
	      		1 => 'setoran_wajib',
	      		2 => 'tabungan_sparepart',
	      		3 => 'denda',
	      		4 => 'potongan',
	      		5 => 'cicilan_sparepart',
	      		6 => 'cicilan_ks',
	      		7 => 'biaya_cuci',
	      		8 => 'iuran_laka',
	      		9 => 'cicilan_dp_kso',
	      		10 => 'cicilan_hutang_lama',
	      		11 => 'ks',
	      		12 => 'cicilan_lain',
	      		13 => 'hutang_dp_sparepart',
	      		20 => 'setoran_cash',
	      		21 => 'tabungan'
	      	];
	  /**
	  	* .
	    *
	    * @return
	    */
	  public function __construct()
	  {
	    	$this->checkins = new Checkin;
	    	$this->user = Auth::user();
	      $this->fleetmodel = new FleetModel;
	  }

  /**
     * json.
     *
     * @return
     */
    public function json(Request $request)
    {
    	  $date 		= $request->get('dateops', date('Y-m-d'));
      	$kso_id		= $request->get('kso_id', 0);
      	$page 		= $request->get('page');
      	$limit 		= $request->get('rows');
      	$sidx 		= $request->get('sidx', 'operasi_time');
      	$sord 		= $request->get('sord', 'asc');

      	$year = date('Y', strtotime($date));
      	$month = date('n', strtotime($date));
      	


      	$checkins = $this->checkins
      					->where('kso_id', $kso_id)
                ->whereRaw('YEAR(operasi_time) = ? AND MONTH(operasi_time) = ?',[$year , $month]);

      	$count = $checkins->count();
      	if( $count > 0 ) {
        	$total_pages = ceil($count / $limit);
      	} else {
        	$total_pages = 0;
      	} 
     
      	if ($page > $total_pages) $page = $total_pages;

      	$start = $limit * $page - $limit; 

      	if($start < 0) $start = 0;

      	$financials = $checkins
                      ->skip($start)->take($limit)
                      ->orderBy($sidx, $sord )
                      ->get();

      	$data['page'] = $page;
      	$data['total'] = $total_pages;
      	$data['records'] = $count;
      	$no = $start + 0;
      
      	$totalks = 0;
      	$selisi_ks = 0;
      	$setoranops = 0;
      	$total = 0;
      	$denda = 0;
      	$cicilan_ks = 0;
      	$cicilan_dp_kso =0;

      	foreach ($financials as $finan) {
      		$no++;
      		$driver = $finan->driver;
      		$status = $finan->status;
      		$financial = $finan->financial;
          $bapakasuh = $finan->fleet->bapakasuh()->wherePivot('status',1)->first();
          $namabapakasuh = ($bapakasuh)? $bapakasuh->first_name . ' ' .$bapakasuh->last_name : 'N/A';
        	$datainfromation = [
        		'no' => $no,
        		'nip' => ($driver)? $driver->nip: 'N/A',
				    'nama' => ($driver)? $driver->name: 'N/A',
				    'checkin_time' => $finan->checkin_time,
            'bapakasuh' => $namabapakasuh,
            'operasi_time' => $finan->operasi_time,
            'operasi_status_id' => ($status)? $status->kode: 'N/A',
        	];

        	$financialdata = [];
        	//set default 0
        	foreach ($this->label as $key => $value) {
        		$financialdata[$value] = 0;
        	}

        	if($financial)
        	{	
        		foreach ($financial as $mony) {
        			$financialdata[$this->label[$mony->financial_type_id]] = $mony->amount;
        		}
        	
	        	$financialdata['ks'] = $financialdata['setoran_cash'] - ( ( $financialdata['setoran_wajib'] + $financialdata['tabungan_sparepart'] + $financialdata['denda'] + $financialdata['cicilan_sparepart']  
	                                  + $financialdata['cicilan_ks'] + $financialdata['biaya_cuci'] + $financialdata['iuran_laka'] + $financialdata['cicilan_dp_kso'] + $financialdata['cicilan_hutang_lama'] + $financialdata['cicilan_lain'] 
	                                  + $financialdata['hutang_dp_sparepart'] ) - $financialdata['potongan'] );
	        	
	        	$financialdata['total'] = ( $financialdata['setoran_wajib'] + $financialdata['tabungan_sparepart'] + $financialdata['denda'] + $financialdata['cicilan_sparepart']  
	                                  + $financialdata['cicilan_ks'] + $financialdata['biaya_cuci'] + $financialdata['iuran_laka'] + $financialdata['cicilan_dp_kso'] + $financialdata['cicilan_hutang_lama'] + $financialdata['cicilan_lain'] 
	                                  + $financialdata['hutang_dp_sparepart'] );

        		$financialdata['setoranops'] = ($financialdata['setoran_cash'] - ($financialdata['biaya_cuci'] + $financialdata['iuran_laka']));
        	
        		$totalks += $financialdata['ks'];
		      	$selisi_ks += 0;
		      	$setoranops += $financialdata['setoranops'];
		      	$total += $financialdata['total'];
		      	$denda += $financialdata['denda'];
		      	$cicilan_ks += $financialdata['cicilan_ks'];
		      	$cicilan_dp_kso += $financialdata['cicilan_dp_kso'];
		      	
        	} 

        	$data['rows'][] = $datainfromation + $financialdata;        	
      	}
      	$data['userdata']['operasi_time']  = 'TOTAL';
        $data['userdata']['ks']           = $totalks;
        $data['userdata']['selisi_ks']    = $selisi_ks;
        $data['userdata']['setoranops']   = $setoranops;
        $data['userdata']['total']        = $total;
        $data['userdata']['denda']        = $denda;
        $data['userdata']['cicilan_ks']   = $cicilan_ks;
        $data['userdata']['cicilan_dp_kso'] = $cicilan_dp_kso;

      	return response($data, 200)
              ->header('Content-Type', 'application/json');	
    }
    /**
     * export to excel.
     *
     * @return
     */
    public function export(Request $request)
    {
        $date 		= $request->get('date', date('Y-m-d'));
        $kso_id 	= $request->get('id', 0);
        $year = date('Y', strtotime($date));
      	$month = date('n', strtotime($date));
      	
      	$kso = Kso::find($kso_id);

      	$objPHPExcel = new PHPExcel();
      	$objPHPExcel->getProperties()->setCreator($this->user->fullname)
               ->setLastModifiedBy($this->user->fullname)
               ->setTitle("Laporan Harian ". $this->user->pool->pool_name . '-' . date('d-m-Y'))
               ->setSubject("Laporan Harian ". $this->user->pool->pool_name . '-' . date('d-m-Y'))
               ->setDescription("Laporan harian operasi pool". $this->user->pool->pool_name )
               ->setKeywords("Laporan Harian"); 
      
  	    $styleArray = array(
    	        'font'  => array(
    	            'bold'  => true,
    	            'color' => array('rgb' => 'FF0000'),
    				'size'  => 16
    	 	));

        $checkins = $this->checkins
                ->whereRaw('YEAR(operasi_time) = ? AND MONTH(operasi_time) = ?',[$year , $month])
                ->where('kso_id', $kso_id);
        
        // TOTAL QUERY
        $total = DB::table('checkins')
                  ->select(DB::raw('sum(if((checkin_financials.financial_type_id = 1),checkin_financials.amount,0)) AS setoran_wajib,sum(if((checkin_financials.financial_type_id = 2),checkin_financials.amount,0)) AS tabungan_sparepart,sum(if((checkin_financials.financial_type_id = 3),checkin_financials.amount,0)) AS denda,sum(if((checkin_financials.financial_type_id = 4),checkin_financials.amount,0)) AS potongan,sum(if((checkin_financials.financial_type_id = 5),checkin_financials.amount,0)) AS cicilan_sparepart,sum(if((checkin_financials.financial_type_id = 6),checkin_financials.amount,0)) AS cicilan_ks,sum(if((checkin_financials.financial_type_id = 7),checkin_financials.amount,0)) AS biaya_cuci,sum(if((checkin_financials.financial_type_id = 8),checkin_financials.amount,0)) AS iuran_laka,sum(if((checkin_financials.financial_type_id = 9),checkin_financials.amount,0)) AS cicilan_dp_kso,sum(if((checkin_financials.financial_type_id = 10),checkin_financials.amount,0)) AS cicilan_hutang_lama,sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) AS ks,sum(if((checkin_financials.financial_type_id = 12),checkin_financials.amount,0)) AS cicilan_lain,sum(if((checkin_financials.financial_type_id = 13),checkin_financials.amount,0)) AS hutang_dp_sparepart,sum(if((checkin_financials.financial_type_id = 20),checkin_financials.amount,0)) AS setoran_cash,sum(if((checkin_financials.financial_type_id = 21),checkin_financials.amount,0)) AS tabungan,(sum(if((checkin_financials.financial_type_id = 11),checkin_financials.amount,0)) - sum(if((checkin_financials.financial_type_id = 6),checkin_financials.amount,0))) AS selisi_ks '))
                  ->addSelect(DB::raw('checkins.id, checkins.operasi_time , checkins.pool_id, checkins.shift_id'))
                  ->leftJoin('checkin_financials', 'checkins.id', '=', 'checkin_financials.checkin_id')
                  ->where('checkins.kso_id', $kso_id)
                  ->where('checkins.operasi_time', '<=' , $date)
                  ->groupBy('checkins.kso_id')
                  ->first();

        $sparepart = DB::table('work_orders')
                    ->select(DB::raw('work_orders.id AS id,work_orders.kso_id AS kso_id,work_orders.wo_number AS wo_number,work_orders.fleet_id AS fleet_id,work_orders.driver_id AS driver_id,work_orders.pool_id AS pool_id,work_orders.km AS km,work_orders.complaint AS complaint,work_orders.information_complaint AS information_complaint,work_orders.status AS status,work_orders.beban AS beban,work_orders.mechanic_id AS mechanic_id,work_orders.mechanic AS mechanic,work_orders.dp_sparepart AS dp_sparepart,work_orders.user_id AS user_id,work_orders.inserted_date_set AS inserted_date_set,work_orders.finished_date_set AS finished_date_set,work_orders.fg_part_approved AS fg_part_approved,work_orders.user_approved AS user_approved,sum((wo_part_items.qty * wo_part_items.price)) AS pemakaian_part'))
                    ->leftJoin('wo_part_items', 'work_orders.id', '=', 'wo_part_items.wo_id')
                    ->where('work_orders.status', 3)
                    ->where('wo_part_items.telah_dikeluarkan', 1)
                    ->where('work_orders.beban', 0)
                    ->where('work_orders.kso_id', $kso_id)
                    ->where('work_orders.finished_date_set', '<=' , $date)
                    ->groupBy('work_orders.kso_id')
                    ->first();
        
        $total_pemakaian_part = 0;
        if($sparepart)
        {
          $total_pemakaian_part = $sparepart->pemakaian_part;
        }
        // END TOTAL QUERY
        $saldo = 0;
        if($total)
        {
          $saldo =  ($total->cicilan_ks - $total->ks) + ($total->tabungan_sparepart + $total->cicilan_sparepart + $total->hutang_dp_sparepart) - $total_pemakaian_part;
        }
        $total_ks = ($total)?  $total->ks: 0;
        $cicilan_ks = ($total)? $total->cicilan_ks : 0;
        $cicilan_sparepart = ($total)? $total->cicilan_sparepart : 0;
        $tabungan_sparepart = ($total)? $total->tabungan_sparepart : 0;
        $hutang_dp_sparepart = ($total)? $total->hutang_dp_sparepart : 0;


        $saldoks = $cicilan_ks - $total_ks;
        $saldo_sparepart = $total_pemakaian_part - ($cicilan_sparepart + $hutang_dp_sparepart + $tabungan_sparepart);
        // END DEKRARASI SALDO

        $sheet_active = 0;
          if( $checkins->count() > 0 ) {

            $objPHPExcel->createSheet(NULL, $sheet_active);
            $objPHPExcel->setActiveSheetIndex($sheet_active);
            
            $objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN ARMADA '. $kso->fleet->taxi_number .' PENDAPATAN BULAN ' . $date  );
            $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->setCellValue('B3', 'NAMA');
            $objPHPExcel->getActiveSheet()->setCellValue('B4', 'BODY');
            $objPHPExcel->getActiveSheet()->setCellValue('H3', 'SALDO KS');
            $objPHPExcel->getActiveSheet()->setCellValue('H4', 'SALDO SPAREPART');
            $objPHPExcel->getActiveSheet()->setCellValue('K4', 'SALDO UNIT');

            // SALDO VALUE
            $objPHPExcel->getActiveSheet()->setCellValue('C3', (isset($kso->bravo))? $kso->bravo->name : 'Unknown Driver');
            $objPHPExcel->getActiveSheet()->setCellValue('C4', $kso->fleet->taxi_number);
            $objPHPExcel->getActiveSheet()->setCellValue('I3', $saldoks);
            $objPHPExcel->getActiveSheet()->setCellValue('I4', $saldo_sparepart);
            $objPHPExcel->getActiveSheet()->setCellValue('L4', $saldo);
            // END SALDO VALUE

            $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
            $objPHPExcel->getActiveSheet()->mergeCells('F5:G5');
            $objPHPExcel->getActiveSheet()->mergeCells('H5:H6');

            $objPHPExcel->getActiveSheet()->mergeCells('I5:I6');
            $objPHPExcel->getActiveSheet()->mergeCells('J5:J6');
            $objPHPExcel->getActiveSheet()->mergeCells('K5:K6');
            $objPHPExcel->getActiveSheet()->mergeCells('L5:O5');
            $objPHPExcel->getActiveSheet()->mergeCells('P5:R5');
            //$objPHPExcel->getActiveSheet()->mergeCells('R5:R6');
            $objPHPExcel->getActiveSheet()->mergeCells('S5:S6');
            $objPHPExcel->getActiveSheet()->mergeCells('T5:T6');
            $objPHPExcel->getActiveSheet()->mergeCells('U5:U6');
            $objPHPExcel->getActiveSheet()->mergeCells('V5:V6');
            $objPHPExcel->getActiveSheet()->mergeCells('W5:W6');
            $objPHPExcel->getActiveSheet()->mergeCells('X5:X6');

            
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO');
            $objPHPExcel->getActiveSheet()->setCellValue('B5', 'BAPAK ASUH');
            $objPHPExcel->getActiveSheet()->setCellValue('C5', 'PENGEMUDI');
            $objPHPExcel->getActiveSheet()->setCellValue('C6', 'NIP');
            $objPHPExcel->getActiveSheet()->setCellValue('D6', 'NAMA');
            $objPHPExcel->getActiveSheet()->setCellValue('E5', 'TANGGAL');
           
            $objPHPExcel->getActiveSheet()->setCellValue('F5', 'STATUS');
            $objPHPExcel->getActiveSheet()->setCellValue('F6', 'OPS');
            $objPHPExcel->getActiveSheet()->setCellValue('G6', 'BS');

            $objPHPExcel->getActiveSheet()->setCellValue('H5', 'SETORAN MURNI');
            $objPHPExcel->getActiveSheet()->setCellValue('I5', 'TAB SPAREPART');
            $objPHPExcel->getActiveSheet()->setCellValue('J5', 'DENDA JAM');
            $objPHPExcel->getActiveSheet()->setCellValue('K5', 'DP SPAREPART');

            $objPHPExcel->getActiveSheet()->setCellValue('L5', 'BAYAR  CICILAN');
            $objPHPExcel->getActiveSheet()->setCellValue('L6', 'KS');
            $objPHPExcel->getActiveSheet()->setCellValue('M6', 'S-PART');
            $objPHPExcel->getActiveSheet()->setCellValue('N6', 'DP-KSO');
            $objPHPExcel->getActiveSheet()->setCellValue('O6', 'HUT-LAMA');

            $objPHPExcel->getActiveSheet()->setCellValue('P5', 'BAYAR');
            $objPHPExcel->getActiveSheet()->setCellValue('P6', 'STIKER BANDARA & KEAMANAN');
            $objPHPExcel->getActiveSheet()->setCellValue('Q6', 'CUCI');
            $objPHPExcel->getActiveSheet()->setCellValue('R6', 'LAKA');

            $objPHPExcel->getActiveSheet()->setCellValue('S5', 'HARUS SETOR');
            $objPHPExcel->getActiveSheet()->setCellValue('T5', 'POTONGAN');
            $objPHPExcel->getActiveSheet()->setCellValue('U5', 'SETOR CASH');
            $objPHPExcel->getActiveSheet()->setCellValue('V5', 'KETEKORAN');
            $objPHPExcel->getActiveSheet()->setCellValue('W5', 'SETORAN OPS');
            $objPHPExcel->getActiveSheet()->setCellValue('X5', 'SHIFT');
        
            $no = 1;
            $starline = 8;

            foreach ($checkins->get() as $finan) {

              $financialdata = [];
                  //set default 0
              foreach ($this->label as $key => $value) {
                  $financialdata[$value] = 0;
              }

              $driver = $finan->driver;
              $fleet = $finan->fleet;
              $status = $finan->status;
              $financial = $finan->financial;
              $bapakasuh = $fleet->bapakasuh()->wherePivot('status',1)->first();
              $namabapakasuh = ($bapakasuh)? $bapakasuh->first_name . ' ' .$bapakasuh->last_name : 'TIDAK ADA BAPAK ASUH';
              
              $nip = ($driver)? $driver->nip : '0000';
              $name = ($driver)? $driver->name : 'Unknown Driver';

              if($financial)
              { 
                foreach ($financial as $mony) {
                  $financialdata[$this->label[$mony->financial_type_id]] = $mony->amount;
                }
              }

              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $starline, $no);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $starline, $namabapakasuh);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $starline, $nip);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $starline, $name);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $starline, $finan->operasi_time);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $starline, $status->kode);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $starline, '');
              
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $starline, $financialdata['setoran_wajib']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $starline, $financialdata['tabungan_sparepart']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $starline, $financialdata['denda']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $starline, $financialdata['hutang_dp_sparepart']);

              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $starline, $financialdata['cicilan_ks']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $starline, $financialdata['cicilan_sparepart']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $starline, $financialdata['cicilan_dp_kso']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, $financialdata['cicilan_hutang_lama']);

              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $starline, $financialdata['cicilan_lain']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $starline, $financialdata['biaya_cuci']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $starline, $financialdata['iuran_laka']);
              

              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $starline, '=SUM(H'.$starline.':R'.$starline.')');
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $starline, $financialdata['potongan']);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $starline, $financialdata['setoran_cash']);
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $starline, $finan->ks);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $starline,'=(U'.$starline.'-(S'.$starline.'-T'.$starline.'))');
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $starline,'=(U'.$starline.'-(Q'.$starline.'+R'.$starline.'))');
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $starline,  $finan->shift_id); //col X
              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $starline, $finan->shift_id);

              //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $starline, $finan->cicilan_lain);
              
              //hidden coloumn status operasi
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $starline,  $finan->operasi_status_id); //col Z
              

              $no ++;
              $starline ++;

            }

            $objPHPExcel->getActiveSheet()->mergeCells('A'.($starline + 1).':G'.($starline + 1).'');
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($starline + 1), 'TOTAL SETORAN ');

            $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 1), '=SUM(H8:H'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 1), '=SUM(I8:I'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($starline + 1), '=SUM(J8:J'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 1), '=SUM(K8:K'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 1), '=SUM(L8:L'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.($starline + 1), '=SUM(M8:M'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('N'.($starline + 1), '=SUM(N8:N'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('O'.($starline + 1), '=SUM(O8:O'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('P'.($starline + 1), '=SUM(P8:P'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.($starline + 1), '=SUM(Q8:Q'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('R'.($starline + 1), '=SUM(R8:R'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('S'.($starline + 1), '=SUM(S8:S'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('T'.($starline + 1), '=SUM(T8:T'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('U'.($starline + 1), '=SUM(U8:U'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('V'.($starline + 1), '=SUM(V8:V'.$starline.')');  
            $objPHPExcel->getActiveSheet()->setCellValue('W'.($starline + 1), '=SUM(W8:W'.$starline.')');

            $objPHPExcel->getActiveSheet()->getStyle('A5:X'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $objPHPExcel->getActiveSheet()->getStyle('A5:X6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('A5:X'.($starline + 1))->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($starline + 1).':X'.($starline + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            /* Rekap Pendapatan */
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 3), 'Total Setoran  :');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 5), 'Disetor ke Bank  :');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 6), 'Disetor ke KKBD  :');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 7), 'Disetor ke Peduli Laka  :');

            $objPHPExcel->getActiveSheet()->setCellValue('E'.($starline + 3), '=SUM(U8:U'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($starline + 5), '=SUM(W8:W'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($starline + 6), '=SUM(Q8:Q'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($starline + 7), '=SUM(R8:R'.$starline.')');
            
            
            /* Rekap Unit Operasi */
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 3), 'Unit Sirkulasi  :');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 5), 'Unit Operasi  :');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 6), 'Status  B P :');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 7), 'Status  B L :');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($starline + 8), 'Status  T D O (Lain-Lain):');


            $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 3), '=COUNT(Z8:Z'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 5), '=COUNTIF(Z8:Z'.$starline.', 1)');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 6), '=COUNTIF(Z8:Z'.$starline.', 3)');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 7), '=COUNTIF(Z8:Z'.$starline.', 7)');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($starline + 8), '=I'.($starline + 3).'-(I'. ($starline + 5).'+ I'.($starline + 6).'+ I'.($starline + 7).')');
            
            /* Rekap KETEKORAN */
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 3), 'Total Ketekoran :');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 5), 'KS Murni  :');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 6), 'KS BP:');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 7), 'KS BL :');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($starline + 8), 'KS TDO (Lain-Lain):');


            $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 3), '=V'.($starline + 1));
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 5), '=SUMIF(Z8:Z'.$starline.',1,V8:V'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 6), '=SUMIF(Z8:Z'.$starline.',3,V8:V'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 7), '=SUMIF(Z8:Z'.$starline.',7,V8:V'.$starline.')');
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($starline + 8), '=L'.($starline + 3).'-(L'. ($starline + 5).'+ L'.($starline + 6).'+ L'.($starline + 7).')');
                    
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($starline + 10), 'Tanggal Unduh');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($starline + 10), ':');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($starline + 10), date('Y-m-d H:i:s'));

            // $objPHPExcel->getSecurity()->setLockWindows(true);
            // $objPHPExcel->getSecurity()->setLockStructure(true);
            // $objPHPExcel->getSecurity()->setWorkbookPassword("FreeBlocking");
            // $objPHPExcel->getActiveSheet()->getProtection()->setPassword('FreeBlocking');
            // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); // This should be enabled in order to enable any of the following!
            // //$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
            // $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
            // //$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
            
            $objPHPExcel->getActiveSheet()->setTitle('Laporan '. $date );
            $sheet_active++;
         	}

	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	    $objWriter->save(storage_path('excels/').'LB'. $kso_id.$date.'.xls');
    	return response()->download(storage_path('excels/').'LB'. $kso_id.$date.'.xls', 'Laporan-armada-'.$kso->fleet->taxi_number .'-bulan-'. $date .'.xls' );
    }
}