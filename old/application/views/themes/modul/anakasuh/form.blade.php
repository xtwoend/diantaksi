@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Daftar Pengemudi</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('anakasuh/manage')}}">Manage Bapak Asuh</a> <span class="divider">/</span></li>
        <li class="active">Add Anak Asuh</li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Form Add Anak Asuh</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            <form class="form-horizontal" action="{{ URL::current() }}" method="POST">
              <div class="span12">
                
                  <div class="control-group">
                    <label class="control-label" for="name">Nomor Body</label>
                    <div class="controls">
                       {{ Form::select('fleet_id', $fleets , ($create) ? '': $anakasuh->fleet_id ) }}
                    </div>
                  </div>

                  

                  <div class="control-group">
                    <label class="control-label" for="inputtext">Tanggal</label>
                    <div class="controls">
                     <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="start_date" class="input-small" id="start_date" type="text" @if(!$create) value="{{$anakasuh->start_date}}" @endif>
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>

                  

              </div>
              
             <input type="reset" class="btn" value="Reset"> <input type="submit" class="btn btn-primary" value="Simpan"> 
               </form>
          </div>  <!-- end pembagian kolom -->
        </div>
</div>

 

@endsection
@section('otherscript')
<script type="text/javascript">
$(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });
  });

</script>
@endsection
