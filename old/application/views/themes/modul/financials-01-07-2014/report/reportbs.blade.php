@layout('themes.layouts.common')

@section('header')
    <div class="header">
          <h1 class="page-title">Laporan Harian Operasi</h1>
    </div>    
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Laporan harian operasi</a> 
    </ul>

@endsection
  
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Tanggal Operasi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         <br>
              <div class="form-inline">
                <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                      <input name="date" id="date" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                  <button class="btn btn-info" id="viewsReport"><i class="icon-search"></i></button>
                  <button class="btn btn-info" id="downloadReport"><i class="icon-download"></i> Download Report Excel</button>
              </div>
          <br>
        </div>
</div>

<div id="widget-report-daily">
  <table id="jqGrid01"></table>
  <div id="jqGridPager01"></div>
</div>



@endsection

@section('otherscript')
<script type="text/javascript">
      var rootURL = '{{ URL::base().'/financials' }}';

    

      $(function () {
            var dateSchedule = $('#date').val();
             $('#datepicker').datepicker({
              format: 'yyyy-mm-dd',
              viewMode: "months", 
              minViewMode: "months"
          });
              viewGrid(dateSchedule);
      });

     
      $('#viewsReport').click(function(){
        var dateSchedule = $('#date').val();

        
        var grid = $('#jqGrid01');
        grid.clearGridData();
        grid.setGridParam({ postData: {dateops: dateSchedule} });
        grid.trigger('reloadGrid');
        
        return false;
      });

      $('#downloadReport').click(function(){
        var dateSchedule = $('#date').val();
        window.open( "{{ URL::to('financials/downloadreportbs/') }}" + dateSchedule , "Export", "menubar=0,location=0,height=600,width=500" );
        return false;
      });
     

      function viewGrid(dateSchedule) {
                var gwdth = $('#widget-report-daily').width();
                var grid = $("#jqGrid01");
               grid.jqGrid({
                    url: rootURL + '/loaddatabs',
                    datatype: "json",
                    height: 500,
                    width: gwdth,
                    mtype: 'POST',
                    postData:{dateops: dateSchedule},
                    rowNum: 20,
                    rowList: [20,40,60,100,200],
                    colNames:['NO','BODY', 'BS' ,'SETORAN MURNI','TAB S-PART','DENDA','DP S-PART','BAYAR KS','BAYAR S-PART','BAYAR DP-KSO','BAYAR HUT-LAMA','STIKER BANDARA','CUCI','LAKA','HARUS DISETOR','POTONGAN','SETOR CASH','KETEKORAN', 'SETORAN OPS','SELISI KS'],
                    colModel:[
                        
                        {name:'no',index:'no', width:20, sortable:false ,search:false, fixed: true, frozen:true },
                        /*
                        {name:'nip',index:'nip', width:60 ,search:false, fixed: true , frozen:true},
                        {name:'name',index:'name', width:120 ,search:false, fixed: true , frozen:true},
                        */
                        {name:'taxi_number',index:'taxi_number', width:60 ,search:true, fixed: true , frozen:true},
                        {name:'bs',index:'bs', width:60 ,search:true, sortable: false, fixed: true , frozen:true},

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
                        {name:'selisi_ks',index:'selisi_ks', width:100 ,search:false , fixed: true, align:"right" ,formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
                    ],
                    pager: "#jqGridPager01",
                    viewrecords: true,
                    caption: "Laporan operasi harian",
                    sortname: 'taxi_number',
                    //sortable: true,
                    hidegrid:false,
                    jsonReader : { repeatitems: false },
                });
                grid.jqGrid('setFrozenColumns');  
                $('.ui-pg-input').css('width','20px');
                $('.ui-pg-selbox').css('width','60px');
                $('.ui-pg-selbox').css('padding','0px 0px 0px 0px'); 
      }

</script>
@endsection