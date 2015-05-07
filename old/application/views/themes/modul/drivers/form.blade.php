@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Daftar Pengemudi</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('drivers')}}">Driver CMS</a> <span class="divider">/</span></li>
        <li class="active">Add Pengemudi</li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Form Pengemudi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
             <div class="span8">
                <form class="form-horizontal" action="{{ URL::current() }}" method="POST" enctype="multipart/form-data">
                  <div class="control-group">
                    <label class="control-label" for="name">Nip</label>
                    <div class="controls">
                      <input type="text" id="nip" name="nip" placeholder="Ketikan No NIp" @if(!$create) value="{{$driver->nip}}" @endif>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="name">Nama Lengkap</label>
                    <div class="controls">
                      <input type="text" id="name" name="name" placeholder="Nama" @if(!$create) value="{{$driver->name}}" @endif >
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="inputtext">TTL</label>
                    <div class="controls">
                      <input type="text" id="brith_place" name="brith_place" placeholder="Tempat Lahir" @if(!$create) value="{{$driver->brith_place}}" @endif >
                      <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="date_of_birth" class="input-small" id="date_of_birth" type="text" @if(!$create) value="{{$driver->date_of_birth}}" @endif>
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="pool">Tanggal Berlaku KPP</label>
                    <div class="controls">
                      <div class="input-append date" id="kpp_validthrough" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="kpp_validthrough" class="input-small" id="kpp_validthrough" type="text" @if(!$create) value="{{$driver->kpp_validthrough}}" @endif>
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">No KTP</label>
                    <div class="controls">
                      <input type="text" id="ktp" name="ktp" placeholder="ktp..." @if(!$create) value="{{$driver->ktp}}" @else @endif >
                    </div>
                  </div>

                   <div class="control-group">
                    <label class="control-label" for="pool">No SIM</label>
                    <div class="controls">
                      <input type="text" id="sim" name="sim" placeholder="sim..." @if(!$create) value="{{$driver->sim}}" @endif >
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="phone">No Telp / HP</label>
                    <div class="controls">
                      <input type="text" id="phone" name="phone" placeholder="phone..." @if(!$create) value="{{$driver->phone}}" @endif >
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Pool</label>
                    <div class="controls">
                        {{ Form::select('pool_id', $pools , ($create) ? '': $driver->pool_id ) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Alamat</label>
                    <div class="controls">
                        <textarea rows="5" id="address" name="address" > @if(!$create) {{$driver->address}} @endif </textarea>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="phone">Kelurahan</label>
                    <div class="controls">
                      <input type="text" id="kelurahan" name="kelurahan" placeholder="kelurahan..." @if(!$create) value="{{$driver->kelurahan}}" @endif >
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="kecamatan">Kecamatan</label>
                    <div class="controls">
                      <input type="text" id="kecamatan" name="kecamatan" placeholder="kecamatan..." @if(!$create) value="{{$driver->kecamatan}}" @endif >
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="kota">Kota</label>
                    <div class="controls">
                      <input type="text" id="kota" name="kota" placeholder="kota..." @if(!$create) value="{{$driver->kota}}" @endif >
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Area Operasi</label>
                    <div class="controls">
                        {{ Form::select('city_id', $cities, ($create) ? '': $driver->city_id  ) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Block Pengemudi</label>
                      <label class="checkbox inline span4">
                          {{ Form::checkbox('fg_blocked', '1', ($create) ? '' : ($driver->fg_blocked == 1) ? true : false ) }}
                          
                      </label>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Pengemudi Aktif</label>
                      <label class="checkbox inline span4">
                          {{ Form::checkbox('driver_status', '1', ($create) ? '' : ($driver->driver_status == 1) ? true : false ) }}
                          
                      </label>
                  </div>
                  
              </div>
              <div class="span4">
                  <div class="block">
                      <div class="block-heading">
                          <a>Foto Pengemudi</a>       
                      </div>
                      <div class="block-body collapse in">
                        @if(!$create) 
                          @if( $driver->photo !== null ) 
                            {{ HTML::image('photo/'. $driver->photo) }}
                          @endif
                        @endif
                      </div>
                  </div>
                  <!--
                  <video autoplay></video>
                  <img src="">
                  <canvas style="display:none;"></canvas>
                  -->
                  <div class="control-group">
                    <label class="control-label" for="kecamatan">Upload Foto</label>
                    <div class="controls">
                        {{ Form::file('photo') }}
                    </div>
                  </div>
                  <input type="reset" class="btn" value="Reset"> <input type="submit" class="btn btn-primary" value="Simpan"> 
                  </form>
                  <br>
                  <br>
                  <br>
                  <button class="btn btn-warning" id="CetakKpp">Cetak KPP</button>
              </div>

            </div>  <!-- end pembagian kolom -->
           
        </div>
</div>
<div id="formkpp"></div>

@endsection
@section('otherscript')
<script type="text/javascript">
var rootURL = '{{ URL::base().'/drivers' }}';
var driver_id = '{{ $driver_id }}';
$(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });
        $('#kpp_validthrough').datepicker({
              format: 'yyyy-mm-dd'
          });
           
  });

$('#CetakKpp').click(function() {
    $('#formkpp').load(rootURL + '/printkpp/' + driver_id );
    return false;
  });
/*
var video = document.querySelector('video');
var canvas = document.querySelector('canvas');
    var ctx = canvas.getContext('2d');
    var localMediaStream = null;

    var onCameraFail = function (e) {
        console.log('Camera did not work.', e);
    };

    function snapshot() {
        if (localMediaStream) {
            ctx.drawImage(video, 0, 0);
        }
    }

    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
    window.URL = window.URL || window.webkitURL;
    navigator.getUserMedia({video:true}, function (stream) {
        video.src = window.URL.createObjectURL(stream);
        localMediaStream = stream;
    }, onCameraFail);
*/
</script>
@endsection
