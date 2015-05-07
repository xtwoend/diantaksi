@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Analisa Bengkel</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('workshops')}}">workshops</a> <span class="divider">/</span></li>
        <li class="active">analisa kerusakan</a></li>
    </ul>
@endsection
  
  
@section('content')

@if(Session::has('status'))
<div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('status'); }}
</div>
@endif
{{ Form::open(URL::current(), 'POST', array('class'=>'form-horizontal')) }}
<div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <input type="submit" class="btn btn-info" value="Simpan">
              <button class="btn btn-info" id="printWo" tabindex="8">Cetak <i class="icon-print icon-white"></i></button>
            </span>
            <a href="#widget-preview" data-toggle="collapse">SPK Nomor : <strong>{{ $wo->wo_number }} </strong></a>
        </div>
        <div class="block-body collapse in" id="widget-preview">
        	<br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
              <div class="span6">

                   <div class="control-group">
                    <label class="control-label" for="body">Nomor Body</label>
                    <div class="controls"> <input type="hidden" id="wo_id" name="wo_id" value="{{ $wo->id }}">
                      <input type="hidden" id="part_id">
                      : <strong>{{ Fleet::find($wo->fleet_id)->taxi_number }}</strong>
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

                

              </div>
              <div class="span6">
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
                    <label class="control-label" for="woNumber">Status Perbaikan</label>
                    <div class="controls">
                      : {{ Form::select('status', $statusoptions , $wo->status) }}
                    </div>
                  </div>

                 
              </div>
          </div>  <!-- end pembagian kolom -->
            <div class="row-fluid">
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keluhan Kerusakan</a>
                        </div>
                        <div class="block-body">
                         	<textarea rows="10" style="width:97%;" id="complaint" name="compalaint">{{ $wo->complaint }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keterangan</a>
                        </div>
                        <div class="block-body">
                         	<textarea rows="10" style="width:97%;" id="information_complaint" name="information">{{ $wo->information_complaint }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
</div>
{{ Form::close() }}
@endsection

@section('otherscript')
<script type="text/javascript">
  var rootURL = '{{ URL::base().'/workshops' }}';
  var wo_id = $('#wo_id').val();
 $('#printWo').click(function(){
   
    //alert('clicked');
    cetak(wo_id);
    return false;
  });

 //print standar web
      function cetak(id)
      {   
          var url = rootURL + '/cetakwo/' + id;
          var thePopup = window.open( url, "cetak", "menubar=0,location=0,height=400,width=500" );
          thePopup.print();        
      }


</script>
@endsection