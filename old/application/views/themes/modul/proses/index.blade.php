@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Proses Pengmudi Bermasalah</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">proses dashboard</a></li>
    </ul>
@endsection

  
@section('content')

    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Tanggal Operasi Armada</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          <div class="form-inline">
              <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                  <input name="date" id="date" class="input-small" type="text" value="{{ date('Y-m-d') }}">
                  <span class="add-on"><i class="icon-calendar"></i></span>
              </div> 
              <button class="btn btn-info" id="viewFleets"><i class="icon-search"></i></button>
          </div>
            <br> 
        </div>
    </div>

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
              <ul id="armadaOnBlocking" class="nav nav-list"></ul>
            </div>
        </div>
    </div>

  </div>
  <div class="span9">
    <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-info" id="buatBAP" type="button">Buat BAP <i class="icon-pencil icon-white"></i></button>
            </span>
            <a href="#widget-info" data-toggle="collapse">Information </a>
        </div>
        <div class="block-body collapse in" id="widget-info">
          
          <div class="row-fluid">
          <div class="tabbable">
            <ul class="nav nav-tabs">
              <li><a href="#tab2" data-toggle="tab">BAP Archive <span class="label label-warning" id="countbap"></span></a></li>
              <li><a href="#tab3" data-toggle="tab">Armada</a></li>
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

                <div class="tab-pane" id="tab3">
                  <table class="table table-condensed table-striped">
                  <tr>
                    <td>Nomor Body</td>
                    <td><input type="text" id="taxi_number" name="taxi_number" disabled></td>
                  </tr>
                  <tr>
                    <td>Bravo</td>
                    <td><input type="text" id="bravo" name="bravo" disabled></td>
                  </tr>
                  <tr>
                    <td>Nomor Polisi</td>
                    <td><input type="text" id="police_number" name="police_number" disabled></td>
                  </tr>
                  <tr>
                    <td>Total KS</td>
                    <td><input type="text" id="total_ks" name="total_ks" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Pembayaran KS</td>
                    <td><input type="text" id="pembayaran_ks" name="pembayaran_ks" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Tabungan Sparepart</td>
                    <td><input type="text" id="tab_sparepart" name="tab_sparepart" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Pemakaian Sparepart</td>
                    <td><input type="text" id="pem_sparepart" name="pem_sparepart" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Pembayaran Sparepart</td>
                    <td><input type="text" id="pembayaran_sparepart" name="pembayaran_sparepart" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Hutang DP KSO</td>
                    <td><input type="text" id="hutang_dp_kso" name="hutang_dp_kso" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Pembayaran DP KSO</td>
                    <td><input type="text" id="pem_hutang_dp_kso" name="pem_hutang_dp_kso" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Saldo Unit</td>
                    <td><input type="text" id="saldo_unit" name="saldo_unit" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td><input type="text" id="fleet_status" name="fleet_status" disabled></td>
                  </tr>
               </table>
                </div>
                {{--end informasi armada--}}
                <div class="tab-pane  active" id="tab4">
                  <button class="btn btn-mini" type="button" id="reportks">Kartu Kontrol</button>
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
var rootURL = '{{ URL::base().'/proses' }}';
var currentInfo;
$(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });
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

      $('#armadaOnBlocking a').live('click', function() {
        findById($(this).data('identity'));
      });
      
      $('#tabelBap a').live('click', function() {
        var url = rootURL + '/sbap/' + $(this).data('identity');
        window.open( url, "BERITA ACARA PROSES PENGEMUDI", "menubar=0,location=0,height=760,width=1000" );
        return false;
      });

      $('#buatBAP').click(function(){
        var id = $('#id').val();
        $('#formBaps').load(rootURL + '/formbap/' + id );
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
          url: rootURL + '/blockingfleet/' + dateSchedule,
          dataType: "json", // data type of response
          success: renderList
        });
      }
      function findByName(searchKey) {

        var dataJSON = JSON.stringify({
          "taxi_number": searchKey, 
          "date": $('#date').val(), 
          });

        console.log('findByName: ' + searchKey);
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/searchFleet',
          dataType: "json",
          data: dataJSON,
          success: renderList 
        });
      }

      function findById(id) {
        console.log('findById: ' + id);
        $.ajax({
          type: 'GET',
          url: rootURL + '/findbyidFleetBlocking/' + id,
          dataType: "json",
          success: function(data){
            $('#btnSimpan').show();
            var fleetinfo = data.fleetinfo;
            var driverinfo = data.driverinfo;
            console.log('findById success: ' + fleetinfo.taxi_number);
            currentInfo = data;
            renderDetails(currentInfo);
          }
        });
      }

      function renderList(data) {
        // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
        var list = data == null ? [] : (data.fleets instanceof Array ? data.fleets : [data.fleets]);
        $('#armadaOnBlocking li').remove();
        $.each(list, function(index, fleet) {
          $('#armadaOnBlocking').append('<li><a href="#" data-identity="' + fleet.id + '">'+fleet.taxi_number+'</a></li>');
        });
      }

      function renderDetails(data) {
        var driverinfo = data.driverinfo;
        var fleetinfo = data.fleetinfo;
        var bapinfo = data.bapinfo;
        //fleet info
        $('#id').val(data.checkout_id);

        $('#taxi_number').val(fleetinfo.taxi_number);
        $('#bravo').val(fleetinfo.bravo);
        $('#police_number').val(fleetinfo.police_number);
        $('#total_ks').val(fleetinfo.total_ks);
        $('#pembayaran_ks').val(fleetinfo.pembayaran_ks);
        $('#tab_sparepart').val(fleetinfo.tab_sparepart);
        $('#pem_sparepart').val(fleetinfo.pem_sparepart);
        $('#fleet_status').val(fleetinfo.status);
        $('#saldo_unit').val(fleetinfo.saldo_unit);
        $('#pembayaran_sparepart').val(fleetinfo.pembayaran_sparepart);
        $('#hutang_dp_kso').val(fleetinfo.hutang_dp_kso);
        $('#pem_hutang_dp_kso').val(fleetinfo.pem_hutang_dp_kso);


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