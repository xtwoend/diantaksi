@extends('main')

@section('content')
<section id="content">
	<section class="vbox" id="bjax-el">
		<section class="scrollable wrapper">
			
			<section class="panel panel-default">
                <header class="panel-heading font-bold">                  
                  Tanggal
                </header
                <div class="panel-body">
                  <form class="form-inline" role="form" action="{{ url('reports/armada/pemakaian.xls') }}">
                    <div class="form-group">
                      <label class="sr-only" for="date">Tanggal</label>
                      <input class="input input-s datepicker-input form-control" size="16" type="text" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd" name="date" id="date">
                    </div>
                    <button type="button" class="btn btn-primary" id="viewsReport">Tampilkan</button>
                    <button type="submit" class="btn btn-success" data-toggle="modal">Download</button>
                  </form>            
                </div>
            </section>

            <section class="panel panel-default"  id="widget-report-daily">
                <header class="panel-heading">
                  Laporan Pemakaian Sparepart
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

$('#date').datepicker({
    viewMode: 1
});

$(function(){
	var date = $('#date').val();
	loadGrid(date);
});

$('#viewsReport').on('click', function(e){
	var date = $('#date').val();

    var grid = $('#jqGrid01');

    grid.clearGridData();
    grid.setGridParam({ 
        postData: {date: date, _token: crsf_token} 
    });
    grid.trigger('reloadGrid');

	e.preventDefault();
});

function loadGrid(start, end, shift_id) {
	var gwdth = $('#widget-report-daily').width();
	var grid = $("#jqGrid01");

    grid.jqGrid({
        url: "/reports/armada/pemakaian.json",
        datatype: "json",
        mtype: "POST",
        height: 500,
        width: gwdth - 12,
        postData:{start: start ,end: end, _token: crsf_token },
        colNames:['NO', 'BODY', 'TANGGAL', 'BPB PART', 'PART NUMBER', 'PART NAME', 'QTY', 'SATUAN', '@PRICE', 'TOTAL'],
        colModel:[
			{name:'no',index:'no', width:40, sortable:false ,search:false, fixed: true, frozen:true },
            {name:'taxi_number',index:'taxi_number', width:80 ,search:false, fixed: true , frozen:true},  
            {name:'inserted_date_set',index:'inserted_date_set', align:"center", width:100 ,search:false, fixed: true , frozen:true},
            {name:'wo_number',index:'wo_number', width:150 ,search:false, fixed: true , frozen:true},              
            {name:'part_number',index:'part_number', width:100 ,search:false, fixed: true , frozen:true}, 
            {name:'name_sparepart',index:'name_sparepart',width:200 ,search:false, fixed: true , frozen:true},
            {name:'qty',index:'qty', width:80 ,search:false, align:"right", fixed: true , frozen:true}, 
            {name:'satuan',index:'satuan', width:80 ,search:false, align:"center", fixed: true , frozen:true},           
            {name:'price',index:'price', width:80 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            {name:'subtotal',index:'subtotal', width:100 ,search:false ,fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
        ],
        pager: "#pager",
        rowNum: 500,
		rowList: [500],
		sortable: false,
        sortname: "taxi_number",
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