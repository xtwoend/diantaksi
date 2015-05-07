@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Report Check In & Out Harian</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Check In & Out</a></li>
    </ul>
@endsection
  
  
@section('content')

    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Check In & Out</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          <form method="get" class="form-inline">
              <div class="input-append date" id="datepicker" data-date="{{ $date }}" data-date-format="yyyy-mm-dd">
                  <input name="date" id="date" class="input-small" type="text" value="{{ $date }}">
                  <span class="add-on"><i class="icon-calendar"></i></span>
              </div> 
              <button class="btn btn-info" id="view"><i class="icon-search"></i></button>
          </form>
            <br> 
        </div>
    </div>

    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup2" data-toggle="collapse">Report Check In & Out Harian</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup2">
          <br>

            <table class="table table-condensed table-striped">
            <thead>

              <tr>
                <th class="span1">No.</th>
                <th>Body</th>
                <th>NIP</th>
                <th>Pengemudi</th>
                <th>Waktu Cetak SPJ</th>
                <th>Waktu Keluar Pool</th>
                <th>KM Keluar</th>
                <th>Waktu Masuk Pool</th>
                <th>KM Masuk</th>
                <th>Shift</th>
                <th>Status OPS</th>
                <th>Action</th>
              </tr>
            
            </thead>
            <?php $no=1; ?>
              <tbody>
                @foreach($checkout as $out)
                <?php $fleet = Fleet::find($out->fleet_id); ?>
                <?php $driver = Driver::find($out->driver_id); ?>
                <tr>
                  <td>{{ $no }}</td>
                  <td>@if($fleet) {{ $fleet->taxi_number }} @endif</td>
                  <td>@if($driver) {{ $driver->nip }} @endif</td>
                  <td>@if($driver) {{ $driver->name }} @endif</td>
                  <td>{{ $out->printspj_time }}</td>
                  <td>{{ $out->checkout_time }}</td>
                  <td>
                    <?php
                      $last_operasi = date('Y-m-d', strtotime($out->operasi_time. ' -1 days'));
                      $last_checkin = Checkin::where_fleet_id($out->fleet_id)->where_operasi_time($last_operasi)->first();
                      
                      if($last_checkin ){
                        echo $last_checkin->km_fleet;
                      }
                    ?>
                  </td>
                  <td>{{ $out->checkin_time }}</td>
                  <td>{{ $out->km_fleet }}</td>
                  <td>{{ Shift::find($out->shift_id)->shift }}</td>
                  <td>{{ Statusoperasi::find($out->operasi_status_id)->kode }}</td>
                  <td>Lihat Data Cheklist</td>
                </tr>
                <?php $no++; ?>
                @endforeach
              </tbody>
            
            </table>
            
          <br> 
        </div>
    </div>


@endsection

@section('otherscript')
<script type="text/javascript">

var rootURL = '{{ URL::base().'/reports' }}';

$(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd',
              //viewMode: "months", 
              //minViewMode: "months"
          });
});
  /*
      findAll($('#date').val());
      
      $('#view').click(function(){
        findAll($('#date').val());
        return false;
      });

      
      function findAll(date) {
        console.log('findAll');
        $.ajax({
          type: 'GET',
          url: rootURL + '/datadaily/' + date,
          dataType: "json", // data type of response
          success: function (data) {
              $('#container').highcharts({
                  chart: {
                      type: 'line',
                      marginRight: 130,
                      marginBottom: 25
                  },
                  title: {
                      text: 'Setoran Operasi Dalam 1 Bulan',
                      x: -20 //center
                  },
                  xAxis: {
                      categories: data.categories
                  },
                  yAxis: {
                      title: {
                          text: 'Total Setoran Operasi (1.000.000)'
                      },
                      plotLines: [{
                          value: 0,
                          width: 1,
                          color: '#808080'
                      }]
                  },
                  tooltip: {
                      valueSuffix: ' (Rp)'
                  },
                  legend: {
                      layout: 'vertical',
                      align: 'right',
                      verticalAlign: 'top',
                      x: -10,
                      y: 100,
                      borderWidth: 0
                  },
                  series: data.series
              });
          }
        });
      }
      */
      
</script>
  
@endsection