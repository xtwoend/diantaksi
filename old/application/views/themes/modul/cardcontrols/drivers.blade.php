@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Kartu Kontrol Pengemudi</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Kartu Kontrol Pengemudi</li>
    </ul>
@endsection
  
 
@section('content')

<div class="row-fluid">
  <div class="span3">
    <div class="block">
        <span class="block-heading">
          <a>
            <div class="input-append">
              <input class="span9" id="searchKey" type="text">
              <button class="btn" id="btnSearch" type="button"><i class="icon-search"></i></button>
            </div> 
          </a>
        </span>
        <div class="block-body collapse in" id="widget-listArmada">
            <div class="leftArea">
              <ul id="driverLists" class="nav nav-list"></ul>
            </div>
        </div>
    </div>

  </div>
  <div class="span9">
    <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-primary" type="button" id="reportks">Detail Setoran</button>
            </span>
            <a href="#widget-info" data-toggle="collapse">Information </a>
        </div>
        <div class="block-body collapse in" id="widget-info">
          
          <div class="row-fluid">
          <div class="tabbable">
            <ul class="nav nav-tabs">
              <li><a href="#tab2" data-toggle="tab">BAP Archive <span class="label label-warning" id="countbap"></span></a></li>
              <li class="active"><a href="#tab4" data-toggle="tab">Pengemudi</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="tab2">
                  <input type="hidden" id="id" name="id">

                  <table class="table table-condensed table-striped" id="tabelBap">
                    <thead>
                      <tr>
                        <th>No. BAP</th>
                        <th>Tanggal</th>
                        <th>Di Proses Oleh</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <ul id="baplist" class="nav nav-list"></ul>   
                </div>
                {{-- end status bap --}}

                
                <div class="tab-pane  active" id="tab4">
                  
                    <table class="table table-condensed table-striped">
                      <tr>
                        <td>Nip</td>
                        <td><input type="hidden" id="driver_id"><input type="text" id="nip" name="nip" disabled></td>
                      </tr>
                      <tr>
                        <td>Nama</td>
                        <td><input type="text" id="name" name="name" disabled></td>
                      </tr>
                      <tr>
                        <td>Saldo KS</td>
                        <td>
                            <input type="text" id="saldo_ks_driver" name="saldo_ks_driver" class="money" disabled> 
                            
                        </td>
                      </tr>
                      <tr>
                        <td>Pembayaran KS</td>
                        <td><input type="text" id="pembayaran_ks_driver" name="pembayaran_ks_driver" class="money" disabled></td>
                      </tr>
                      <tr>
                        <td>Hutang Lama</td>
                        <td><input type="text" id="hutang_lama" name="hutang_lama" class="money" disabled></td>
                      </tr>
                      <tr>
                        <td>Pembayaran Hutang Lama</td>
                        <td><input type="text" id="cicilan_hutang_lama" name="cicilan_hutang_lama" class="money" disabled></td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td><input type="text" id="driver_status" name="driver_status" disabled></td>
                      </tr>
                   </table>
                </div>
                {{--end informasi pengemudi--}}
            </div>
          
        </div>
      </div>
    </div>
</div>
</div>

{{-- Modal Proses APP --}}
<div id="formBaps"></div>

<div id="reportks"></div>

@endsection

@section('otherscript')
<script type="text/javascript">
var rootURL = '{{ URL::base().'/cardcontrols' }}';
var currentInfo;
$(function () {
        $('.money').money_field({width: 120});
});

      findAll($('#date').val());

      $('#viewFleets').click(function(){
        findAll($('#date').val());
        return false;
      });

      $('#btnSearch').click(function() {
        search($('#searchKey').val());
        return false;
      });

      $('#driverLists a').live('click', function() {
        findById($(this).data('identity'));
      });
      
      $('#tabelBap a').live('click', function() {
        var url = rootURL + '/sbap/' + $(this).data('identity');
        window.open( url, "BERITA ACARA PROSES PENGEMUDI", "menubar=0,location=0,height=760,width=1000" );
        return false;
      });


      $('#reportks').click(function(){
        var driver_id = $('#driver_id').val();
        //$('#reportks').load(rootURL + '/kartukontrolpengemudi/' + driver_id );
        if(driver_id == ''){
          alert('pilih pengemudi dahulu');
        }else{
          var url = rootURL + '/kartukontrolpengemudi/' + driver_id;
          window.open( url, "Kartu Kontrol Pengemudi", "menubar=0,location=0,height=760,width=1000" );
        }
        return false;

      });


      function search(searchKey) {
        if (searchKey == '') 
          findAll($('#date').val());
        else
          findByName(searchKey);
      }

      function findAll(dateSchedule) {
        console.log('findAll');
        $.ajax({
          type: 'GET',
          url: rootURL + '/driverslist',
          dataType: "json", // data type of response
          success: renderList
        });
      }
      function findByName(searchKey) {

        var dataJSON = JSON.stringify({
          "nip": searchKey, 
          "date": $('#date').val(), 
          });

        console.log('findByName: ' + searchKey);
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/searchDriver',
          dataType: "json",
          data: dataJSON,
          success: renderList 
        });
      }

      function findById(id) {
        console.log('findById: ' + id);
        $.ajax({
          type: 'GET',
          url: rootURL + '/findbyIdDriver/' + id,
          dataType: "json",
          success: function(data){
            
            var driverinfo = data.driverinfo;
            console.log('findById success: ' + driverinfo.name);
            currentInfo = data;
            renderDetails(currentInfo);
          }
        });
      }

      function renderList(data) {
        // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
        var list = data == null ? [] : (data.drivers instanceof Array ? data.drivers : [data.drivers]);
        $('#driverLists li').remove();
        $.each(list, function(index, driver) {
          $('#driverLists').append('<li><a href="#" data-identity="' + driver.id + '">'+driver.nip+'( '+driver.name+' )'+'</a></li>');
        });
      }

      function renderDetails(data) {
        var driverinfo = data.driverinfo;
        var bapinfo = data.bapinfo;
        //fleet info

        //driver info
        $('#driver_id').val(driverinfo.id);
        $('#nip').val(driverinfo.nip);
        $('#name').val(driverinfo.name);
        $('#hutang_lama').val(driverinfo.hutang_lama);
        $('#saldo_ks_driver').val(driverinfo.saldo_ks_driver);
        $('#pembayaran_ks_driver').val(driverinfo.pembayaran_ks_driver);
        $('#cicilan_hutang_lama').val(driverinfo.cicilan_hutang_lama);
        $('#driver_status').val(driverinfo.status);

        //BAP list info
        // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
        var list = data == null ? [] : (data.bapinfo instanceof Array ? data.bapinfo : [data.bapinfo]);
        $("#tabelBap > tbody").html("");
        $.each(list, function(index, bap) {
           console.log('add row ' + index);
          $('#tabelBap > tbody:last').append('<tr><td><a href="#" data-identity="' + bap.id + '">'+bap.bap_number+'</a></td> <td>'+bap.date+'</td><td>'+bap.user+'</td></tr>');
        });

        $('#countbap').text(data.countbap);
        return false;
      }
</script>
  
@endsection