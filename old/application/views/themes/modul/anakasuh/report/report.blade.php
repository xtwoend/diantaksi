@layout('themes.layouts.common')

@section('header')
    <div class="header">
          <h1 class="page-title">DATA KINERJA ANAK ASUH</h1>
    </div>    
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Data kinerja anak asuh</a> 
    </ul>

@endsection
  
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Tanggal Periode</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         <br>
              <form method="POST" class="form-inline">
                {{ Form::select('bapak_asuh', $bapak_asuh , null, array('class'=>'form-controll')) }}
                <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                      <input name="date" id="date" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                  <button type="submit" class="btn btn-info" id="downloadReport"><i class="icon-download"></i> Download</button>
              </form>
          <br>
        </div>
</div>

@endsection

@section('otherscript')
<script type="text/javascript">
    $(function(){
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd',
              viewMode: "months", 
              minViewMode: "months"
        });
    });
</script>
@endsection