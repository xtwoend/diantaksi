@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Laporan Data Operasi</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Laporan Data Operasi</a></li>
    </ul>
@endsection
  
  
@section('content')
	<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Saldo Armada Per Tanggal </a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         <br> 
              {{ Form::open('reportops/exphutangarmada', 'POST' ,array('class'=>'form-inline'))}}
                <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                      <input name="date" id="date" class="input-small" type="text" value="{{ date('Y-m-d') }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                {{-- Form::select('shift_id', $shifts, 1, array('id'=>'shift_id')); --}}
                  <button class="btn btn-info" id="viewsReport"><i class="icon-search"></i></button>
                  <button class="btn btn-info" type="submit" id="downloadReport"><i class="icon-download"></i> Download Report Excel</button>
              {{ Form::close() }}
          <br>
        </div>
	</div>

  <div id="widget-report-hutang">
    <table id="jqGrid01"></table>
    <div id="jqGridPager01"></div>
  </div>

 @endsection

@section('otherscript')
<script type="text/javascript">
	var dateOps, shift_id;
	$(function () {

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
        }); 

        //load default data
        dateOps = $('#date').val();
        shift_id = $('#shift_id').val();
        viewGrid(dateOps, shift_id);   
    });	

    $('#viewsReport').click(function(){
    	dateOps = $('#date').val();
      shift_id = $('#shift_id').val();

      var grid = $("#jqGrid01");
    	grid.clearGridData();
      grid.setGridParam({ postData: {dateops: dateOps, shift_id: shift_id} });
      grid.trigger('reloadGrid');
      //console.log('view report clicked!!!');
    	return false;
    });

  

  //jqgrid
    function viewGrid(dateOps, shift_id) {
                var gwdth = $('#widget-report-hutang').width();
                var grid = $("#jqGrid01");
                grid.jqGrid({
                    url: '{{ URL::base() }}/reportops/reporthutang',
                    datatype: "json",
                    height: 500,
                    width: gwdth,
                    mtype: 'POST',
                    postData:{dateops: dateOps, shift_id: shift_id},
                    rowNum: 40,
                    rowList: [40,80,100,120,140,160,200,300,400],
                    colNames:['NO','BODY','BRAVO','SHIFT','PEMAKAIAN','TABUNGAN ','BAYAR', 'SELISIH',  'KURANG STOR', 'BAYAR KS', 'SELISIH', 'SALDO SP', 'SALDO KS', 'SALDO AKHIR'],
                    colModel:[
                        
                        {name:'no',index:'no', width:20, sortable:false ,search:false, fixed: true, frozen:true },
                        {name:'taxi_number',index:'taxi_number', width:60 ,search:false, fixed: true, frozen:true },
                        {name:'bravo',index:'bravo', width:140 ,search:false, fixed: true, frozen:true },
                        {name:'shift_id',index:'shift_id', width:70 ,search:false, fixed: true , frozen:true},
                        
                        {name:'pemakaian_sp',index:'pemakaian_sp', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        {name:'tabungan_sp',index:'tabungan_sp', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        {name:'bayar_sp',index:'bayar_sp', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        {name:'saldo_sp',index:'saldo_sp', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},


                        {name:'ks',index:'ks', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        {name:'bayar_ks',index:'bayar_ks', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        {name:'selisi_ks',index:'selisi_ks', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        
                        {name:'saldo_sp',index:'saldo_sp', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        {name:'selisi_ks',index:'selisi_ks', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                        {name:'saldo_armada',index:'saldo_armada', width:100 ,search:false,fixed: true , align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
      
                    ],
                    pager: "#jqGridPager01",
                    viewrecords: true,
                    //sortable: true,
                    sortname: 'operasi_time',
                    caption: "Laporan Kas Operasi Harian",
                    sortorder: "asc",
                    jsonReader: {
                      repeatitems : false
                    },
                    shrinkToFit: false,
                    footerrow: true,
                    userDataOnFooter: true
                });
                grid.jqGrid('setGroupHeaders', {
                  useColSpanStyle: true, 
                  groupHeaders:[
                    {startColumnName: 'pemakaian_sp', numberOfColumns: 4, titleText: 'PEMAKAIAN SPAREPART ARMADA'},
                    {startColumnName: 'saldo_sp', numberOfColumns: 3, titleText: 'SETORAN ARMADA'},
                    {startColumnName: 'ks', numberOfColumns: 3, titleText: 'SALDO ARMADA'},
                  ]
                });
                grid.jqGrid('setFrozenColumns');
                $('.ui-pg-input').css('width','20px');
                $('.ui-pg-selbox').css('width','60px');
                $('.ui-pg-selbox').css('padding','0px 0px 0px 0px');   
      }

</script>

@endsection
