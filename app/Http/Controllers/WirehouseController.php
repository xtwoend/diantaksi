<?php 

namespace App\Http\Controllers;

use App\Diantaksi\Reports\ReportSparepart;
use App\Http\Controllers\Controller;
use App\Diantaksi\Eloquent\Kso;
use Illuminate\Http\Request;

class WirehouseController extends Controller
{
	protected $ksos;
	protected $sparepart;

	public function __construct(Kso $ksos)
	{
		$this->ksos = $ksos;
		$this->sparepart = new ReportSparepart;
	}

	public function viewPemakaian()
	{
		return view('reports.pemakaian');
	}

	public function reportPemakaian(Request $request)
	{
		return $this->sparepart->reportJson($request);
	}

	public function reportPemakaianDownload(Request $request)
	{
		return $this->sparepart->reportDownload($request);
	}
}