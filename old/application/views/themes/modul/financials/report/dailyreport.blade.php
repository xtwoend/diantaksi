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
                {{ Form::select('shift_id', $shifts, 1, array('id'=>'shift_id')); }}
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

      var setoran_cash = 0;
      var setoran_wajib = 0;
      var tabungan_sparepart = 0;
      var denda = 0;
      var potongan = 0;
      var cicilan_sparepart = 0;
      var cicilan_ks = 0;
      var biaya_cuci = 0;
      var iuran_laka = 0;
      var cicilan_dp_kso = 0;
      var cicilan_hutang_lama = 0;
      var ks = 0;
      var cicilan_lain = 0;
      var hutang_dp_sparepart = 0;
      var total = 0;
      var setoranops = 0;

      $(function () {
            var dateSchedule = $('#date').val();
            var shift_id = $('#shift_id').val();
              $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                });
              viewGrid(dateSchedule,shift_id);
              getsum(dateSchedule,shift_id);
      });

     
      $('#viewsReport').click(function(){
        var dateSchedule = $('#date').val();
        var shift_id = $('#shift_id').val();
        var grid = $('#jqGrid01');
        grid.clearGridData();
        grid.setGridParam({ postData: {dateops: dateSchedule , shift_id: shift_id} });
        grid.trigger('reloadGrid');
        getsum(dateSchedule,shift_id);
        return false;
      });

      $('#downloadReport').click(function(){
        var dateSchedule = $('#date').val();
        var shift_id = $('#shift_id').val();
        var url = rootURL + '/expreportdaily/' + dateSchedule + '/' + shift_id; 
        window.open( url, "Export", "menubar=0,location=0,height=600,width=500" );
        return false;
      });
     
      function getsum(dateSchedule,shift_id)
      {
        $.ajax({
          type: 'GET',
          url: rootURL + '/sumreport/' + dateSchedule + '/' + shift_id,
          dataType: "json", // data type of response
          success: function(data){
            setoran_cash = data.setoran_cash;
            setoran_wajib = data.setoran_wajib;
            tabungan_sparepart = data.tabungan_sparepart;
            denda = data.denda; 
            potongan = data.potongan;
            cicilan_sparepart = data.cicilan_sparepart;
            cicilan_ks = data.cicilan_ks; 
            biaya_cuci = data.biaya_cuci;
            iuran_laka = data.iuran_laka;
            cicilan_dp_kso = data.cicilan_dp_kso;
            cicilan_hutang_lama = data.cicilan_hutang_lama;
            ks = data.ks;
            cicilan_lain = data.cicilan_lain;
            hutang_dp_sparepart = data.hutang_dp_sparepart;
            total = data.total;
            setoranops = data.setoranops;
          },
        });
      }

      function viewGrid(dateSchedule,shift_id) {
                var gwdth = $('#widget-report-daily').width();
                var grid = $("#jqGrid01");
               grid.jqGrid({
                    url: rootURL + '/loaddatadaily',
                    datatype: "json",
                    height: 500,
                    width: gwdth,
                    mtype: 'POST',
                    postData:{dateops: dateSchedule, shift_id: shift_id},
                    rowNum: 20,
                    rowList: [20,40,60,100,200],
                    colNames:['NO','NIP', 'NAMA','BODY', 'STATUS OPS','WAKTU MASUK', 'SHIFT','SETORAN MURNI','TAB S-PART','DENDA','DP S-PART','BAYAR KS','BAYAR S-PART','BAYAR DP-KSO','BAYAR HUT-LAMA','STKR BANDARA & KEAMANAN','CUCI','LAKA','HARUS DISETOR','POTONGAN','SETOR CASH','KETEKORAN', 'SETORAN OPS'],
                    colModel:[
                        
                        {name:'no',index:'no', width:20, sortable:false ,search:false, fixed: true, frozen:true },
                        {name:'nip',index:'nip', width:60 ,search:true, fixed: true , frozen:true},
                        {name:'name',index:'name', width:120 ,search:false, fixed: true , frozen:true},
                        {name:'taxi_number',index:'taxi_number', width:60 ,search:true, fixed: true , frozen:true},
                        {name:'operasi_status_id',index:'operasi_status_id', width:50 ,search:false , align:"center",fixed: true , frozen:true},

                        {name:'checkin_time',index:'checkin_time', width:125 ,search:false, fixed: true , frozen:true},
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
                    caption: "Laporan operasi harian",
                    //sortable: true,
                    sortname: 'taxi_number',
                    hidegrid: false,
                    jsonReader : { repeatitems: false },
                    footerrow: true,
                    loadComplete: function () {
                        grid.jqGrid('footerData','set', {
                            name: 'Total:', 
                            setoran_cash: setoran_cash, 
                            setoran_wajib: setoran_wajib,
                            tabungan_sparepart: tabungan_sparepart,
                            denda: denda,
                            potongan: potongan,
                            cicilan_sparepart: cicilan_sparepart,
                            cicilan_ks: cicilan_ks,
                            biaya_cuci: biaya_cuci,
                            iuran_laka: iuran_laka,
                            cicilan_dp_kso: cicilan_dp_kso,
                            cicilan_hutang_lama: cicilan_hutang_lama,
                            ks: ks,
                            cicilan_lain: cicilan_lain,
                            hutang_dp_sparepart: hutang_dp_sparepart,
                            total: total,
                            setoranops: setoranops,
                          });
                    }
                });
                grid.jqGrid('setFrozenColumns');
                $('.ui-pg-input').css('width','20px');
                $('.ui-pg-selbox').css('width','60px');
                $('.ui-pg-selbox').css('padding','0px 0px 0px 0px'); 
      }

</script>
@endsection