@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Berkas BAP Harian</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Berkas BAP</a></li>
    </ul>
@endsection
  
  
@section('content')

    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Berkas BAP</a>       
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
            <a href="#widgetGroup2" data-toggle="collapse">Berkas BAP Harian</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup2">
          <br>

            <table class="table table-condensed table-striped" id="tabelBap">
            <thead>

              <tr>
                <th class="span1">No.</th>
                <th>No. BAP</th>
                <th>Body</th>
                <th>NIP</th>
                <th>Pengemudi</th>
                <th>Proses Oleh</th>
                <th>Diotorisasi Oleh</th>
                <th>Waktu Proses</th>
              </tr>
            
            </thead>
            <?php $no=1; ?>
              <tbody>
                @foreach($baps as $bap)
                <?php $fleet = Fleet::find($bap->fleet_id); ?>
                <?php $driver = Driver::find($bap->driver_id); ?>
                <tr>
                  <td>{{ $no }}</td>
                  <td><a href="#" data-identity="{{ $bap->id }}">{{ $bap->bap_number }}</a></td>
                  <td>@if($fleet) {{ $fleet->taxi_number }} @endif</td>
                  <td>@if($driver) {{ $driver->nip }} @endif</td>
                  <td>@if($driver) {{ $driver->name }} @endif</td>
                  <td>{{ User::find($bap->user_id)->fullname }}</td>
                  <td> 
                  <?php $otorisasi = User::find($bap->otorisasi2_id) ?>
                    @if($otorisasi)
                      {{ $otorisasi->fullname }}
                    @endif
                  </td>
                  <td>{{ $bap->last_update }}</td>
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
  $('#tabelBap a').live('click', function() {
        var url = '{{ URL::base()}}/cardcontrols/sbap/' + $(this).data('identity');
        window.open( url, "BERITA ACARA PROSES PENGEMUDI", "menubar=0,location=0,height=760,width=1000" );
        return false;
  });
      
</script>
  
@endsection