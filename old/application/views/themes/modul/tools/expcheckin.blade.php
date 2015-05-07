@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Check-In List</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Check-In List</li>
    </ul>
@endsection

@section('content')
  <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Tampilkan Jadwal Operasi Berdasarkan Tanggal</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          <form class="form-inline" method="get">
            <div class="input-append date" id="datepicker" data-date="{{ $tanggal }}" data-date-format="yyyy-mm-dd">
                  <input name="tanggal" class="input-small" id="tanggal" type="text" value="{{ $tanggal }}">
                  <span class="add-on"><i class="icon-calendar"></i></span>
              </div>
              <button class="btn btn-info">Lihat Jadwal <i class="icon-calendar icon-white"></i></button>
            </form>
            <br> 
        </div>
    </div> 
    
    <div class="block">
      <div class="block">
        <div class="block-heading">
          <span class="block-icon pull-right">
            {{ HTML::link('tools/downloadformat/'.$tanggal, 'Download Format Inport Setoran', array('class' => 'btn btn-info')); }}
            </span>
            <a href="#widgetGroup" data-toggle="collapse">Daftar Checkin</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup">
            <table class="table table-striped table-condensed">
        <thead>
          <tr>
            <th>No.</th>
            <th>No. Body</th>
            <th>No. NIP</th>
            <th>Nama Pengemudi</th>
            <th>Status Operasi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          @foreach($checkins as $in)
          <tr>
            <td>{{ $no }}</td>
            <td>{{ $in->taxi_number }}</td>
            <td>{{ $in->nip }}</td>
            <td>{{ $in->name }}</td>
            <td>{{ Statusoperasi::find($in->operasi_status_id)->operasi_status }}</td>
          </tr>
          <?php $no++; ?>
          @endforeach
        </tbody>
      </table>
        </div>
    </div>  
    </div> 
@endsection


@section('otherscript') 	
   <script type="text/javascript">

var rootURL = '{{ URL::base().'/tools' }}';

$(function () {
  $('#datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});

$('#downloadformat').click(function() {
             alert('aaa');
        return false;
});

  

</script>
@endsection