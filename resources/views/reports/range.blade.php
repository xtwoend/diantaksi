@extends('main')

@section('content')
<section id="content">
	<section class="vbox" id="bjax-el">
		<section class="scrollable wrapper">
			
			<section class="panel panel-default">
                <header class="panel-heading font-bold">                  
                  Tanggal Operasi
                </header>
                <div class="panel-body">
                  <form class="form-inline" role="form" action="{{ url('reports/range.xlsx') }}">
                    <div class="form-group">
                      <label class="sr-only" for="date">Tanggal Operasi</label>
                      <input class="input input-s datepicker-input form-control" size="16" type="text" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd" name="start" id="start">
                    </div> - 
                    <div class="form-group">
                      <label class="sr-only" for="date">Tanggal Operasi</label>
                      <input class="input input-s datepicker-input form-control" size="16" type="text" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd" name="end" id="end">
                    </div>
                    <div class="form-group padder">
                      	<label class="sr-only" for=""></label>
                      	<select id="shift_id" class="form-control" name="shift_id">
                      		<option value="1">Reguler</option>
                      		<option value="2">Kalong</option>
                      	</select>                  
                    </div>
                    <button type="button" class="btn btn-primary" id="viewsReport">Tampilkan</button>

                    <button type="submit" class="btn btn-success" data-toggle="modal">Download</button>
                  </form>            
                </div>
            </section>

            <section class="panel panel-default"  id="widget-report-daily">
                <header class="panel-heading">
                  Laporan Kas Harian
                </header>
                <table id="jqGrid01"><tr><td></td></tr></table> 
		    	<div id="pager"></div>
		    </section>

		</section>
	</section>
</section>
@endsection


@section('js')
<script type="text/javascript">

$(function(){
	var start = $('#start').val();
    var end = $('#end').val();
    var shift_id = $('#shift_id').val();
	loadGrid(start, end ,shift_id);
});

$('#viewsReport').on('click', function(e){
	var start = $('#start').val();
    var end = $('#end').val();
    var shift_id = $('#shift_id').val();
    var grid = $('#jqGrid01');

    grid.clearGridData();
    grid.setGridParam({ 
        postData: {start: start, end: end, shift_id: shift_id, _token: crsf_token} 
    });
    grid.trigger('reloadGrid');

	e.preventDefault();
});

function loadGrid(start, end, shift_id) {
	var gwdth = $('#widget-report-daily').width();
	var grid = $("#jqGrid01");

    grid.jqGrid({
        url: "/reports/range.json",
        datatype: "json",
        mtype: "POST",
        height: 500,
        width: gwdth - 12,
        postData:{start: start ,end: end, _token: crsf_token },
        colNames:['NO','TANGGAL', 'JENIS KENDARAAN', 'SETORAN MURNI','TAB S-PART','DENDA','DP S-PART','BAYAR KS','BAYAR S-PART','BAYAR DP-KSO','BAYAR HUT-LAMA','STKR BANDARA & KEAMANAN','CUCI','LAKA','HARUS DISETOR','POTONGAN','SETOR CASH','KETEKORAN', 'SETORAN OPS'],
        colModel:[
			{name:'no',index:'no', width:20, sortable:false ,search:false, fixed: true, frozen:true },
            {name:'operasi_time',index:'operasi_time', width:100 ,search:false, fixed: true , frozen:true},  
            {name:'fleet_model',index:'fleet_model', width:100 ,search:false, fixed: true , frozen:true},                 

            {name:'setoran_wajib',index:'setoran_wajib', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'tabungan_sparepart',index:'tabungan_sparepart', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'denda',index:'denda', width:100 ,search:false , align:"right",fixed: true ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'hutang_dp_sparepart',index:'hutang_dp_sparepart', width:100,fixed: true ,search:false , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        
            {name:'cicilan_ks',index:'cicilan_ks', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
			{name:'cicilan_sparepart',index:'cicilan_sparepart', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'cicilan_dp_kso',index:'cicilan_dp_kso', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'cicilan_hutang_lama',index:'cicilan_hutang_lama', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        
            {name:'cicilan_lain',index:'cicilan_lain', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'biaya_cuci',index:'biaya_cuci', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'iuran_laka',index:'iuran_laka', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        
            {name:'total',index:'total', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'potongan',index:'potongan', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'setoran_cash',index:'setoran_cash', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'ks',index:'ks', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'setoranops',index:'setoranops', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
        ],
        pager: "#pager",
        rowNum: 40,
		rowList: [40,80,120,200],
		sortable: false,
        sortname: "operasi_time",
        sortorder: "asc",
        viewrecords: true,
        gridview: true,
    	jsonReader: {
                      repeatitems : false
        },
        shrinkToFit: false,
        footerrow: true,
        userDataOnFooter: true
    });

    grid.jqGrid('setFrozenColumns');

    return false;
}
</script>

@endsection