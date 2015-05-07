@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Dashboard</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('warehousecenter')}}">Warehouse Center</a> <span class="divider">/</span></li>
        <li class="active">Pemakain Sparepart Unit</a></li>
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
              <ul id="unitlist" class="nav nav-list"></ul>
            </div>
        </div>
    </div>

  </div>
  <div class="span9">
    <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-primary" type="button" id="detailSetoran">Detail Setoran</button>
            </span>
            <a href="#widget-info" data-toggle="collapse">Information </a>
        </div>
        <div class="block-body collapse in" id="widget-info">
          
          <div class="row-fluid">
          <div class="tabbable">
            <ul class="nav nav-tabs">
              <li><a href="#tab1" data-toggle="tab">Pemakaian Sparepart Unit</a></li>
              <li class="active"><a href="#tab3" data-toggle="tab">Setoran Armada</a></li>
              <li><a href="#tab4" data-toggle="tab">DP Armada</a></li>
            </ul>
            <div class="tab-content">
                
                {{-- end status bap --}}
                <div class="tab-pane active" id="tab3">
                  <table class="table table-condensed table-striped">
                  <tr>
                    <td>Nomor Body</td>
                    <td><input type="hidden" id="kso_id" name="kso_id"><input type="text" id="taxi_number" name="taxi_number" disabled></td>
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
                    <td>Saldo Unit</td>
                    <td><input type="text" id="saldo_unit" name="saldo_unit" class="money" disabled></td>
                  </tr>
               </table>
                </div>
                
                <div class="tab-pane" id="tab4">
                  <table class="table table-condensed table-striped">
                    <tr>
                      <td>DP KSO</td>
                      <td><input type="text" id="dp_kso" name="dp_kso" class="money" disabled></td>
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
                      <td>Saldo DP KSO</td>
                      <td><input type="text" id="saldo_dp" name="saldo_dp" class="money" disabled></td>
                    </tr>
                   
                 </table>
                </div>              
                {{--end informasi pengemudi--}}
                <div class="tab-pane" id="tab1">
                  <!-- Date mounth -->
                  {{ Form::open('warehouses/exppemakaianunit','POST', array( 'class'=>'form-inline' ))}}
                    <input type="hidden" id="fleet_idx" name="fleet_id">
                    <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="date" id="date" class="input-small" type="text" value="{{ date('Y-m-d') }}">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                    </div> 
                    <button class="btn btn-info" id="view"><i class="icon-search"></i></button>
                    <strong><span id="infobody"></span></strong>
                    <button  type="submit" class="btn btn-info pull-right" id="cetak"><i class="icon-print"></i> Cetak</button>
                  {{ Form::close() }}

                   <div class="block"> 
                    <table class="table table-condensed table-striped" id="listpart">
                      <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>NO SPK</th>
                        <th>NO Part</th>
                        <th>Spare Part</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Harga</th>
                      </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>  
                      </tbody>
                      <tfoot>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>Rp.</td>
                          <td><strong><span id="total"></span></strong></td>
                        </tr>
                      </tfoot>
                    </table>
                   </div>
                </div>
            </div>
          
        </div>
      </div>
    </div>
</div>
</div>

@endsection

@section('otherscript')
<script>
$(function(){
  
  //make global var
  var fleetId;

  $('#unitlist a').live('click', function() {
    //console.log($(this).data('identity'));
    getUnitinfo($(this).data('identity'));
  }); 

  $('#view').live('click', function(){
    getPemakaianSparepart($('#date').val(), fleetId);
    return false;
  });

  $('#detailSetoran').live('click', function(){
    window.open( '{{ URL::base() }}' + '/cardcontrols/kartukontrolarmadakso/' + ksoid, "Kartu Kontrol Armada", "menubar=0,location=0,height=700,width=1100" );
    return false;
  });

  $('#btnSearch').live('click', function(){
    search($('#searchKey').val());
    return false;
  });


  search = function(searchKey) {

        if (searchKey == '') 
          findAll($('#date').val());
        else
          findByName(searchKey);
  }

  findAll = function(dateSchedule) {
        console.log('findAll');
        $.ajax({
          type: 'GET',
          url: '{{ URL::base().'/cardcontrols' }}' + '/fleetslist',
          dataType: "json", // data type of response
          success: renderUnitList
        });
  }
  
  findByName = function(searchKey) {

        var dataJSON = JSON.stringify({
          "taxi_number": searchKey,
          });

        console.log('findByName: ' + searchKey);
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: '{{ URL::base().'/cardcontrols' }}' + '/searchFleet',
          dataType: "json",
          data: dataJSON,
          success: renderUnitList 
        });
  }


  init = function(){

    Globalize.culture( "id-ID" );
    getUnit();
    
    $('#datepicker').datepicker({
              format: 'yyyy-mm-dd',
              viewMode: "months", 
              minViewMode: "months"
    });
  }  

  getUnitinfo = function(ksoid){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/cardcontrols/findbyIdFleetkso/'+ ksoid,
        dataType: 'json',
        success: function(response){
          console.log(response);
          renderDetails(response);
        }
    });
  }
  getUnit = function(){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/cardcontrols/fleetslist',
        dataType: "json", // data type of response
        success: function(response){
          renderUnitList(response);
        }
    });
  }

  getPemakaianSparepart = function(date, fleetId){
    $.ajax({
        type: 'POST',
        url: '{{ URL::base() }}'+'/warehousescenter/pemakaianunit',
        data: { date: date, fleet_id: fleetId},
        dataType: 'json',
        success: function(response){
          console.log(response);
          renderPartlist(response);
        }
    });
  }

  renderUnitList = function(data){
    var list = data == null ? [] : (data.fleets instanceof Array ? data.fleets : [data.fleets]);
    $('#unitlist li').remove();
    $.each(list, function(index, fleet) {
      $('#unitlist').append('<li><a href="#" data-identity="' + fleet.kso_id + '">'+fleet.taxi_number+'</a></li>');
    });
  }

  renderDetails = function(data) {
        var fleetinfo = data.fleetinfo;
        fleetId = fleetinfo.fleet_id;
        //fleet info
        $('#fleet_idx').val(fleetinfo.fleet_id);
        $('#kso_id').val(fleetinfo.id);
        $('#taxi_number').val(fleetinfo.taxi_number);
        $('#bravo').val(fleetinfo.bravo);
        $('#police_number').val(fleetinfo.police_number);
        $('#total_ks').val(fleetinfo.total_ks);
        $('#pembayaran_ks').val(fleetinfo.pembayaran_ks);
        $('#tab_sparepart').val(fleetinfo.tab_sparepart);
        $('#pem_sparepart').val(fleetinfo.pem_sparepart);
        $('#saldo_unit').val(fleetinfo.saldo_unit);
        $('#pembayaran_sparepart').val(fleetinfo.pembayaran_sparepart);
        $('#dp_kso').val(fleetinfo.dp_kso);
        $('#hutang_dp_kso').val(fleetinfo.hutang_dp_kso);
        $('#pem_hutang_dp_kso').val(fleetinfo.pem_hutang_dp_kso);
        $('#saldo_dp').val(fleetinfo.saldo_dp);
        $('#infobody').text(fleetinfo.taxi_number + ' ' + fleetinfo.bravo);
        return false;
  } 

  renderPartlist = function(data){
        var total = 0;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $("#listpart > tbody").html("");
        $.each(list, function(index, part) {
           console.log('add row ' + index);
           total = total + parseInt(part.subtotal);
          $('#listpart > tbody:last').append('<tr><td>'+part.inserted_date_set+'</td><td>'+ part.wo_number+'</td><td>'+ part.part_number+'</td><td>'+ part.name_sparepart+'</td><td>'+ part.qty+'</td><td>'+ Globalize.format(parseInt(part.price),"n0")+'</td><td>'+ Globalize.format(parseInt(part.subtotal),"n0")+'</td></tr>');
        });
        $('#total').text(Globalize.format(total,"n0"));
  }

  init();
});

</script>
@endsection
