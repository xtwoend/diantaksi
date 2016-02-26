<?php

namespace App\Http\Controllers;

use App\Diantaksi\Eloquent\Kso;
use App\Diantaksi\Eloquent\Stock;
use App\Diantaksi\Reports\ReportSparepart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PSController extends Controller
{
    protected $ksos;
    protected $sparepart;
    protected $stocks;

    public function __construct(Kso $ksos, Stock $stocks)
    {
        $this->ksos = $ksos;
        $this->stocks = $stocks;
        $this->sparepart = new ReportSparepart;
    }

    public function index()
    {
        return view('gudang.penerimaan.index');
    }

    public function itemUpdate(Request $request)
    {
        return $request->all();
    }
}
