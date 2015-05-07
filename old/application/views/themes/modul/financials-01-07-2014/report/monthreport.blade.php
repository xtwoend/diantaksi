@layout('themes.layouts.common')

@section('header')
    <div class="header">
          <h1 class="page-title">Laporan Kas Harian Operasi</h1>
    </div>    
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Laporan kas harian operasi</a> 
    </ul>

@endsection
  
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Bulan</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         <br> 
              <form class="form-inline" method="POST" action="{{ URL::to('financials/expkasharian') }}">
                <div class="input-append date" id="datepicker1" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                      <input name="startdateops" id="startdateops" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div> - 
                <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                      <input name="date" id="date" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                  {{ Form::select('shift_id', $shifts, 1, array('id'=>'shift_id')); }}
                  <input type="hidden" name="statusopsdef" id="statusopsdef" value="split">
                  <button class="btn btn-info" id="viewsReport"><i class="icon-search"></i></button>
                  <div class="btn-group" data-toggle="buttons-radio">                         
                          <button type="button" class="btn btn-warning" name="statusops" id="xl" value="split">All Model</button>
                          <button type="button" class="btn btn-warning" name="statusops" id="x" value="all">Split Model</button>
                  </div> 
                  <button class="btn btn-info" type="submit" id="downloadReport"><i class="icon-download"></i> Download Report Excel</button>
              </form>
          <br>
        </div>
</div>

<div id="widget-report-monthly">
  <table id="jqGrid01"></table>
  <div id="jqGridPager01"></div>
</div>



@endsection

@section('otherscript')
<script type="text/javascript">
      var rootURL = '{{ URL::base().'/financials' }}';
      $(function () {
            var dateSchedule = $('#date').val();
            var startdateops = $('#startdateops').val();
            var shift_id = $('#shift_id').val();
              $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                });
               $('#datepicker1').datepicker({
                    format: 'yyyy-mm-dd',
                });
              viewGrid(dateSchedule, startdateops, shift_id);
              $('#x').button('toggle');

            $('button[name="statusops"]').click(function(){
              var value =$('button[name="statusops"].active').val(); 
              $('#statusopsdef').val(value);
            });

      });

      

      $('#viewsReport').click(function(){
        var dateSchedule = $('#date').val();
        var startdateops = $('#startdateops').val();
        var shift_id = $('#shift_id').val();
        var grid = $('#jqGrid01');
        grid.clearGridData();
        grid.setGridParam({ postData: {dateops: dateSchedule , startdateops: startdateops, shift_id: shift_id} });
        grid.trigger('reloadGrid');
        
        return false;
      });

    
      function viewGrid(dateSchedule, startdateops, shift_id) {
                var gwdth = $('#widget-report-monthly').width();
                var grid = $("#jqGrid01");
                grid.jqGrid({
                    url: rootURL + '/loaddatamonthly',
                    datatype: "json",
                    height: 500,
                    width: gwdth,
                    mtype: 'POST',
                    postData:{dateops: dateSchedule, startdateops: startdateops, shift_id: shift_id},
                    rowNum: 40,
                    rowList: [40],
                    colNames:['NO','TANGGAL OPERASI','SHIFT','SETORAN MURNI','TAB S-PART','DENDA','DP S-PART','BAYAR KS','BAYAR S-PART','BAYAR DP-KSO','BAYAR HUT-LAMA','STIKER BANDARA','CUCI','LAKA','HARUS DISETOR','POTONGAN','SETOR CASH','KETEKORAN', 'SETORAN OPS'],
                    colModel:[
                        
                        {name:'no',index:'no', width:20, sortable:false ,search:false, fixed: true, frozen:true },
                        {name:'operasi_time',index:'operasi_time', width:120 ,search:false, fixed: true, frozen:true },
                        
                        {name:'shift_id',index:'shift_id', width:70 ,search:false, fixed: true , frozen:true},
                        
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
                grid.jqGrid('setFrozenColumns');
                $('.ui-pg-input').css('width','20px');
                $('.ui-pg-selbox').css('width','60px');
                $('.ui-pg-selbox').css('padding','0px 0px 0px 0px'); 
      }

</script>
@endsection