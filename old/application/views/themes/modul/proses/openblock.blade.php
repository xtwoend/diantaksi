@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Proses Pengmudi Bermasalah</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Open Block Pengemudi</a></li>
    </ul>
@endsection

@section('content')

 	<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Masukan Nomor BAP untuk membuka blocking</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          {{ Form::open('proses/openblock') }}
          <div class="form-inline">
              <input type="text" name="bap_number" @if($show) value="{{ $bap_number }}" @endif >
              <button class="btn btn-info" type="submit"><i class="icon-search"></i></button>
          </div>
          {{ Form::close() }}
            <br> 
        </div>
    </div>
@if($show)
	
	<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup2" data-toggle="collapse">Proses Open Block Pengemudi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup2">
        	<br>
          	@if($bap)
          		@if($bap->keputusan_id == 7)
          			
          			<input type="hidden" id="bap_id" name="bap_id" value="{{ $bap->id }}">
          			<blockquote>
					  	<small>Silahkan Otorisasi pembukaan block </small>
					</blockquote>
          			<div class="row-fluid">
				        <div class="span6">
				          Otorisasi 1 <br>
				          <strong>{{ $user->fullname }}</strong>
				        </div>
				        <div class="span6">
				          Otorisasi 2 <br>
				        <input name="username" type="text" id="username" placeholder="username"><br>  
				        <input name="password" type="password" id="password" placeholder="password">
				        </div>
				     </div>

				    <button type="button" id="btnSave" class="btn btn-success">Open Blocking</button>
				    <br>
				    
          		@else
          			<blockquote>
					  	<small>Maaf dari hasil keputusan bap pengemudi tidak di izinkan beroperasi untuk sementara</small>
					</blockquote>
          		@endif
          	@else
          			<blockquote>
					  	<small>Nomor BAP Tidak di temukan ! </small>
					</blockquote>
          	@endif

          	<br>
        </div>
    </div>

@endif

@endsection

@section('otherscript')
<script type="text/javascript">
  //penggunaan post javasript
   var rootURL = '{{ URL::base().'/proses' }}';

   $('#btnSave').click(function(){
      openblock();
      return false;
   });

   function openblock()
   {
      var dataJSON = JSON.stringify({
          "username": $('#username').val(), 
          "password": $('#password').val(), 
          "bap_id": $('#bap_id').val(), 
          });

        console.log('Open Block Proses');
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/otorisasi',
          dataType: "json",
          data: dataJSON,
          success: function(data){
            if(data.status){
              alert(data.msg);
            }else{
              alert(data.msg);
            }
          }
        });
   }
</script>
@endsection