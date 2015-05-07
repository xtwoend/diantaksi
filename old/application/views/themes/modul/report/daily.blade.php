@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Grafik Pendapatan Operasi Dalam 1 Bulan</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Statistik Harian</a></li>
    </ul>
@endsection
  
  
@section('content')

    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Statistik Harian</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          <div class="form-inline">
              <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                  <input name="date" id="date" class="input-small" type="text" value="{{ date('Y-m-d') }}">
                  <span class="add-on"><i class="icon-calendar"></i></span>
              </div> 
              <button class="btn btn-info" id="view"><i class="icon-search"></i></button>
          </div>
            <br> 
        </div>
    </div>

    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Statistik View</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
            <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
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
              viewMode: "months", 
              minViewMode: "months"
          });
});

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
      
</script>
  
@endsection