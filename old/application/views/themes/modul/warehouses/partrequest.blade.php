@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Permintaan Barang</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('werehouses')}}">Warehouse</a> <span class="divider">/</span></li>
        <li class="active">permintaan barang</a></li>
    </ul>
@endsection
  
  
@section('content')

@if(Session::has('status'))
<div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('status'); }}
</div>
@endif

<div class="block">
        <div class="block-heading">
            @if($wo->fg_part_approved == 1)
            <span class="block-icon pull-right">
              <input type="button" id="cetakbkb" class="btn btn-info" value="Cetak BKB">
            </span>
            @endif
            <a href="#widget-preview" data-toggle="collapse">SPK Nomor : <strong>{{ $wo->wo_number }} </strong></a>
        </div>
        <div class="block-body collapse in" id="widget-preview">
          <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            <form class="form-horizontal">
              <div class="span6">
                
                  <div class="control-group">
                    <label class="control-label" for="body">Nomor Body</label>
                    <div class="controls"> <input type="hidden" id="wo_id" value="{{ $wo->id }}">
                      : <strong>{{ Fleet::find($wo->fleet_id)->taxi_number }}</strong> <button type="button" id="fleetinfo" class="btn btn-mini btn-info">Informasi Saldo</button>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="name">Nama Bravo</label>
                    <div class="controls">
                      : <strong>{{ Driver::find($wo->driver_id)->name }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="inputtext">NIP </label>
                    <div class="controls">
                      : <strong>{{ Driver::find($wo->driver_id)->nip }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Pool</label>
                    <div class="controls">
                      : <strong>{{ Pool::find($wo->pool_id)->pool_name }}</strong>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="pool">Status Persetujuan</label>
                    <div class="controls">
                      : <strong>{{ ($wo->fg_part_approved == 1) ? 'Telah disetujui' : 'Menunggu Persetujuan' }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">DP Sparepart</label>
                    <div class="controls">
                      : {{ Form::text('dp_sparepart', $wo->dp_sparepart, array( 'class' => 'span11  money')); }}
                    </div>
                  </div>
              </div>
              <div class="span6">
                  <div class="control-group">
                    <label class="control-label" for="woNumber">Nomor SPK</label>
                    <div class="controls">
                      : <strong>{{ $wo->wo_number }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="date">Tanggal</label>
                    <div class="controls">
                      : <strong> {{ myFungsi::fulldate(strtotime($wo->inserted_date_set)) }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="jam">Jam</label>
                    <div class="controls">
                        : <strong>{{ date('H:i:s', strtotime($wo->inserted_date_set)) }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="kmMasuk">KM Masuk</label>
                    <div class="controls">
                        : <strong>{{ $wo->km }}</strong>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="kmMasuk">Status Perbaikan</label>
                    <div class="controls">
                        : <strong>{{ Statusperbaikan::find($wo->status)->status }}</strong>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="woNumber">Oleh Mekanik</label>
                    <div class="controls">
                      : <strong>{{  $wo->mechanic }}</strong>
                    </div>
                  </div>

              </div>
             
               </form>
          </div>  <!-- end pembagian kolom -->
          <div class="row-fluid">
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keluhan Kerusakan</a>
                        </div>
                        <div class="block-body">
                          {{ $wo->complaint }}
                        </div>
                    </div>
                    <div class="block">
                        <div class="block-heading">
                            <a>Keterangan</a>
                        </div>
                        <div class="block-body">
                          {{ $wo->information_complaint }}
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Analisa Kerusakan</a>
                        </div>
                        <div class="block-body">

                          <table class="table table-condensed table-hover">
                            <tbody>
                            
                            @if($analisas)
                              <?php $no =1; ?>
                              @foreach($analisas as $analisa)
                              <tr id="row_{{ $analisa->id }}">
                                  <td>{{ $no }}</td>
                                  <td>{{ $analisa->analisa }}</td>
                              </tr>
                              <?php $no++ ?>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="2">Analisa is empty</td>
                              </tr>
                            @endif
                            </tbody>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
          <br>
      </div>
    </div>
<div id="partitem"> Part tidak berhasil di load</div>
	

@endsection

@section('otherscript')
<script type="text/javascript">
var rootURL = '{{ URL::base().'/warehouses' }}';
var wo_id_inpart = '{{ $wo_id_initem }}';

$(function () {
  $('.money').money_field({width: 120});
  partitem(wo_id_inpart);
});
$('#fleetinfo').click(function() {
  var url = rootURL + '/fleetinfo/'+ {{ $wo->fleet_id }};
  window.open( url, "Detail Info Fleet", "width=500,toolbar=1,resizable=1,scrollbars=yes,height=430,top=100,left=100" );
  return false;
});

$('#cetakbkb').click(function() {
  var url = rootURL + '/cetakbkb/'+ {{ $wo->id }};
  window.open( url, "Detail Info Fleet", "width=600,toolbar=1,resizable=1,scrollbars=yes,height=430,top=100,left=100" );
  return false;
});

//load part item
function partitem(wo_id){
  $( "#partitem" ).load( rootURL + "/laoditemrequest/" + wo_id );
}

</script>
@endsection
