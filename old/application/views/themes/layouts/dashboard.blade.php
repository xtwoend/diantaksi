@layout('themes.layouts.common')

@section('header')
	<div class="header">
          <!--
            <div class="stats">
	            <p class="stat"><span class="number">53</span>Order</p>
	            <p class="stat"><span class="number">27</span>Fleet</p>
	            <p class="stat"><span class="number">15</span>waiting</p>
   			    </div>
          -->
   			<h1 class="page-title">Dashboard</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Dashboard</li>
    </ul>
@endsection
  

@section('content')
<div class="row-fluid">
  <div class="span6">
    <div class="block">
            <div class="block-heading">
                <a href="#widgetGroup1" data-toggle="collapse">DOWN TEN KS ARMADA DALAM BULAN {{ strtoupper($month); }}</a>       
            </div>
            <div class="block-body collapse in" id="widgetGroup1">
              
              <table class="table table-condensed" id="listksfleets">
              <thead>
                <tr>
                  <th>No Urut</th>
                  <th>Body</th>
                  <th>Bravo</th>
                  <th>Total KS</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>

            </div>
    </div>
</div>
    
  <div class="span6">
    <div class="block">
            <div class="block-heading">
                <a href="#widgetGroup2" data-toggle="collapse">DOWN TEN KS PENGEMUDI DALAM BULAN {{ strtoupper($month); }}</a>       
            </div>
            <div class="block-body collapse in" id="widgetGroup2">
              
              <table class="table table-condensed" id="listksdrivers">
              <thead>
                <tr>
                  <th>No Urut</th>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Total KS</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>

            </div>
    </div>

  </div>

</div>

<div class="row-fluid">
  <div class="span6">
    <div class="block">
            <div class="block-heading">
                <a href="#widgetGroup3" data-toggle="collapse">DOWNTIME KS BAPAK ASUH DALAM BULAN {{ strtoupper($month); }}</a>       
            </div>
            <div class="block-body collapse in" id="widgetGroup3">
              
              <table class="table table-condensed" id="downtime">
              <thead>
                <tr>
                  <th>No Urut</th>
                  <th>Bapak Asuh</th>
                  <th>Jumlah Armada</th>
                  <th>Total KS</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>

            </div>
    </div>
</div>

</div>

<div class="row-fluid">
  
  <div class="span4">
    <div class="block">
            <div class="block-heading">
                <a href="#widgetGroup5" data-toggle="collapse">Tanggal Operasi Armada</a>       
            </div>
            <div class="block-body collapse in" id="widgetGroup5">
              <br>
              <form method="GET" action="" class="form-inline" >
                    
                  <div class="input-append date" id="datepicker" data-date="{{ Input::get('date',date('Y-m-d')) }}" data-date-format="yyyy-mm-dd">
                      <input name="date" id="dateops" class="input-small" type="text" value="{{ Input::get('date',date('Y-m-d')) }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                  </div>

                  <button type="submit" class="btn btn-info"><i class="icon-search"></i></button>
              </form>
                <br> 
            </div>
        </div>
  </div>

  <div class="span8">
    <div class="block">
            <div class="block-heading">
                <a href="#infounit" data-toggle="collapse">Informasi Unit</a>       
            </div>
            <div class="block-body collapse in" id="infounit">
              <table class="table">
              <thead>
                <tr>
                  <th>Total Unit</th>
                  <th>Unit Operasi</th>
                  <th>Unit Belum Beroperasi</th>
                  <th>BL</th>
                  <th>BP</th>
                  <th>TP</th>
                  <th>TL</th>
                  <th>LL</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>-</td>
                  <td>-</td>
                  <td></td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
                
              </tbody>
            </table>
            </div>
        </div>
  </div>
</div>

<div class="row-fluid">
  
  <div class="span6">

    <div class="block">
        <div class="block-heading">
          <span class="block-icon pull-right">
            </span>
            <a href="#datanotprint1" data-toggle="collapse">Daftar Armada Yang Belum Keluar Pool / Akan Beroperasi </a>       
        </div>
        <div class="block-body collapse in" id="datanotprint1">
          <br>
          <div id="listfleetsoncheckout"></div>
          <br>
        </div>
    </div>

  </div>

  <div class="span6">
    
    <div class="block">
        <div class="block-heading">
          <span class="block-icon pull-right">
            </span>
            <a href="#datanotprint2" data-toggle="collapse">Daftar Armada Yang Belum Print SPJ</a>       
        </div>
        <div class="block-body collapse in" id="datanotprint2">
         <br>
        <div id="listfleetsonnotprintspj"></div>
        <br>
        </div>
    </div>

  </div>

</div>  
<div class="row-fluid">
  <div class="span6">

    <div class="block">
        <div class="block-heading">
          <span class="block-icon pull-right">
            </span>
            <a href="#datanotprint3" data-toggle="collapse">Daftar Armada Yang Belum Masuk Pool / Sedang Operasi Beroperasi</a>       
        </div>
        <div class="block-body collapse in" id="datanotprint3">
          <br>
          <div id="listfleetsoncheckin"></div>
          <br>
        </div>
    </div>

  </div>
  <div class="span6">

    <div class="block">
        <div class="block-heading">
          <span class="block-icon pull-right">
            </span>
            <a href="#datanotprint4" data-toggle="collapse">Daftar Armada Yang Tidak Beroperasi</a>       
        </div>
        <div class="block-body collapse in" id="datanotprint4">
          <br>
          <div id="listfleetsonnotopration"></div>
          <br>
        </div>
    </div>

  </div>
</div>


<div class="row-fluid">
  <div class="span6">

    <div class="block">
        <div class="block-heading">
          <span class="block-icon pull-right">
            </span>
            <a href="#datanotprint" data-toggle="collapse">Daftar Armada Yang Belum & Sudah Setoran</a>       
        </div>
        <div class="block-body collapse in" id="datanotprint">
          Belum Setoran
          <hr>
          <div id="listfleetsonbeforepay"></div>
          <br>
          Sudah Setoran
          <hr> 
          <div id="listfleetsonafterpay"></div>
          <br>
        <br>
        </div>
    </div>

  </div>
  <div class="span6">

    <div class="block">
        <div class="block-heading">
          <span class="block-icon pull-right">
            </span>
            <a href="#datanotprint" data-toggle="collapse">Daftar Armada dalam perbaikan</a>       
        </div>
        <div class="block-body collapse in" id="datanotprint">
         <br>
          <div id="listfleetsonbengkel"></div>
          <br>
        </div>
    </div>

  </div>
</div>

@endsection
@section('otherscript')
<script type="text/javascript">
$(function(){

  //global var
  var date = $('#dateops').val();

  init = function(){

    Globalize.culture( "id-ID" );
    
    $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
    });

    getToptenksfleet(date);
    getToptenksdriver(date);
    getDowntime(date);
    getfleetsonnotprintspj(date);
    getfleetsoncheckout(date);
    getfleetsonnotopration(date);
    getfleetsoncheckin(date);
    getfleetsonbeforepay(date);
    getfleetsonafterpay(date);
    getfleetsonbengkel(date);
  }  

  getToptenksfleet = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/toptenksfleet?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          toptenfleetRender(response)
        }
    });
  }

  toptenfleetRender = function(data){
        var noa = 0;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $("#listksfleets > tbody").html("");
        $.each(list, function(index, fleet) {
           console.log('add row ' + index);
           noa = noa + 1;
          $('#listksfleets > tbody:last').append('<tr><td>'+ noa +'</td><td>'+ fleet.taxi_number +'</td><td>'+ '' +'</td><td>'+ Globalize.format(parseInt(fleet.selisi_ks),"n0")+'</td></tr>');
        });
  }

  getToptenksdriver = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/toptenksdriver?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          toptenksdriverRender(response)
        }
    });
  }

  toptenksdriverRender = function(data){
        var noz = 0;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $("#listksdrivers > tbody").html("");
        $.each(list, function(index, driver) {
           console.log('add row ' + index);
           noz = noz + 1;
          $('#listksdrivers > tbody:last').append('<tr><td>'+ noz +'</td><td>'+ driver.taxi_number +'</td><td>'+ driver.name +'</td><td>'+ Globalize.format(parseInt(driver.selisi_ks),"n0")+'</td></tr>');
        });
  }

  getDowntime = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/downtime?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          downtimeRender(response)
        }
    });
  }

  downtimeRender = function(data){
        var nox = 0;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $("#downtime > tbody").html("");
        $.each(list, function(index, bpk) {
           console.log('add row ' + index);
           nox = nox + 1;
          $('#downtime > tbody:last').append('<tr><td>'+ nox +'</td><td><a href="' + base_url + '/anakasuh/financialreport/'+ bpk.bapak_asuh +'"><span class="label label-warning">'+ bpk.nama +'</span></a></td><td>'+ bpk.total_anakasuh +'</td><td>'+ Globalize.format(parseInt(bpk.selisi_ks),"n0")+'</td></tr>');
        });
  }


  //list fleet on schedule
  getfleetsonnotprintspj = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/fleetsonnotprintspj?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          fleetsonnotprintspjRender(response)
        }
    });
  }

  fleetsonnotprintspjRender = function(data){
        var no = 1;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $.each(list, function(index, fleet) {
           no = no + index;
          $('#listfleetsonnotprintspj').append('<span class="label label-success">'+ fleet.taxi_number + '</span> ');
        });
  }

  // yang checkout
  getfleetsoncheckout = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/fleetsoncheckout?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          fleetsoncheckoutRender(response)
        }
    });
  }

  fleetsoncheckoutRender = function(data){
        var no = 1;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $.each(list, function(index, fleet) {
           no = no + index;
          $('#listfleetsoncheckout').append('<span class="label label-success">'+ fleet.taxi_number + '</span> ');
        });
  }

  //fleet tidak operasi
  getfleetsonnotopration = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/fleetsonnotopration?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          fleetsonnotoprationRender(response)
        }
    });
  }

  fleetsonnotoprationRender = function(data){
        var no = 1;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $.each(list, function(index, fleet) {
           no = no + index;
          $('#listfleetsonnotopration').append('<span class="label label-success">'+ fleet.taxi_number + '</span> ');
        });
  }
  //armada sedang beroperasi
  getfleetsoncheckin = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/fleetsoncheckin?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          fleetsoncheckinRender(response)
        }
    });
  }

  fleetsoncheckinRender = function(data){
        var no = 1;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $.each(list, function(index, fleet) {
           no = no + index;
          $('#listfleetsoncheckin').append('<span class="label label-success">'+ fleet.taxi_number + '</span> ');
        });
  }

  //armada masuk belum setor
  getfleetsonbeforepay = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/fleetsonbeforepay?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          fleetsonbeforepayRender(response)
        }
    });
  }

  fleetsonbeforepayRender = function(data){
        var no = 1;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $.each(list, function(index, fleet) {
           no = no + index;
          $('#listfleetsonbeforepay').append('<span class="label label-success">'+ fleet.taxi_number + '</span> ');
        });
  }
  //armada masuk sudah setor
  getfleetsonafterpay = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/fleetsonafterpay?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          fleetsonafterpayRender(response)
        }
    });
  }

  fleetsonafterpayRender = function(data){
        var no = 1;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $.each(list, function(index, fleet) {
           no = no + index;
          $('#listfleetsonafterpay').append('<span class="label label-success">'+ fleet.taxi_number + '</span> ');
        });
  }

  //armada di benkel
  getfleetsonbengkel = function(date){
    $.ajax({
        type: 'GET',
        url: '{{ URL::base() }}'+'/dash/fleetsonbengkel?date='+ date,
        dataType: "json", // data type of response
        success: function(response){
          fleetsonbengkelRender(response)
        }
    });
  }

  fleetsonbengkelRender = function(data){
        var no = 1;
        var list = data == null ? [] : (data instanceof Array ? data : [data]);
        $.each(list, function(index, fleet) {
           no = no + index;
          $('#listfleetsonbengkel').append('<span class="label label-success">'+ fleet.taxi_number + '</span> ');
        });
  }
  
  init();
});
  </script>
@endsection