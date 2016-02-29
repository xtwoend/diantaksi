<?php

namespace App\Http\Controllers;

use App\Diantaksi\Eloquent\Kso;
use App\Diantaksi\Eloquent\Stock;
use App\Diantaksi\Eloquent\Supplier;
use App\Diantaksi\Reports\ReportSparepart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PSController extends Controller
{
    protected $ksos;
    protected $sparepart;
    protected $stocks;
    protected $suppliers;

    public function __construct(Kso $ksos, Stock $stocks, Supplier $suppliers)
    {
        $this->ksos = $ksos;
        $this->stocks = $stocks;
        $this->sparepart = new ReportSparepart;
        $this->suppliers = $suppliers;
    }

    public function index()
    {
        return view('gudang.penerimaan.index');
    }

    public function itemUpdate(Request $request)
    {
        return $request->all();
    }

    public function getSuplier(Request $request)
    {
        $suppliers = $this->suppliers->where('name', 'LIKE', '%' . $request->get('query') . '%')->get();
        $data = [];
        $data['query'] = $request->get('query');
        foreach ($suppliers as $row) {
            $data['suggestions'] = [
                'value' => $row->name,
                'data' => $row->id,
            ];
        }
        return response()->json($data, 200);
    }
}
