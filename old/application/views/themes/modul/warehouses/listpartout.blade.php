@layout('themes.layouts.common')

@section('header')
    <div class="header">
          <h1 class="page-title">Bukti Keluar Barang</h1>
    </div>    
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Laporan bukti keluar barang</a> 
    </ul>

@endsection
  
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Bulan</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         <br>
              <form class="form-inline" method="GET">
                <div class="input-append date" id="datepicker1" data-date="{{ Input::get('start', date('Y-m-d')) }}" data-date-format="yyyy-mm-dd">
                      <input name="start" id="startdateops" class="input-small" id="tanggal" type="text" value="{{ Input::get('start', date('Y-m-d')) }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div> - 
                <div class="input-append date" id="datepicker" data-date="{{ Input::get('end', date('Y-m-d')) }}" data-date-format="yyyy-mm-dd">
                      <input name="end" id="date" class="input-small" id="tanggal" type="text" value="{{ Input::get('end', date('Y-m-d')) }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                  <button class="btn btn-info" type="submit" id="viewsReport"><i class="icon-search"></i></button>
                  
              </form>
              <button class="btn btn-info" id="downloadReport"><i class="icon-download"></i> Download Report Excel</button>
          <br>
        </div>
</div>

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup2" data-toggle="collapse">LIST SPARE PART KELUAR</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup2">

          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th class="span1">No.</th>
                <th>Tanggal</th>
                <th>Nomor WO</th>
                <th>Nomor Sparepart</th>
                <th>Nama Sparepart</th>
                <th>Body</th>
                <th>Qty</th>
                <th style="text-align: center;">Satuan</th>
              </tr>
            </thead>
              <tbody>
                <?php $no=((Input::get('page',1) * 20) - 20) + 1; ?>
                @foreach($lists as $ls)
                <tr>
                  <td>{{ $no }}</td>
                  <td>{{ date('d/m/Y',strtotime($ls->inserted_date_set)) }}</td>
                  <td>{{ $ls->wo_number }}</td>
                  <td>{{ $ls->part_number }}</td>
                  <td>{{ $ls->name_sparepart }}</td>
                  <td> 
                    @if(Fleet::find($ls->fleet_id)) 
                      {{ Fleet::find($ls->fleet_id)->taxi_number  }}
                    @endif
                  </td>
                  <td>{{ $ls->qty }} </td>
                  <td>{{ $ls->satuan }}</td>

                </tr>
                <?php $no++; ?>
                @endforeach
              </tbody>
            </table>

        </div>
</div>

@endsection


@section('otherscript') 
<script type="text/javascript">
     
      $(function () {         
              $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                });
               $('#datepicker1').datepicker({
                    format: 'yyyy-mm-dd',
                });
      });

      $('#downloadReport').click(function(){         
        
          var dataJSON = JSON.stringify({
          "start": $('#startdateops').val(), 
          "end": $('#date').val(), 
          });

          $.ajax({
            type: "POST",
            contentType: "application/json",
            url: "{{ URL::to('warehouses/bkbexport') }}",
            dataType: "json",
            data: dataJSON,
            success: function(data){
              window.open( "{{ URL::to('warehouses/bkbdownload/') }}" + data.url , "Export", "menubar=0,location=0,height=600,width=500" );
            }
          });
          
      });
</script>
@endsection