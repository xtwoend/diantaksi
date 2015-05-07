@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Schedule</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Schedule</li>
    </ul>
@endsection
  
  
@section('content')
     <div class="block">
       	<div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Create JHO ALL</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
        	<br>
            <form class="form-inline" method="POST">
	        	  <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
	              	<input name="tanggal" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
	              	<span class="add-on"><i class="icon-calendar"></i></span>
	          	</div>
	          	<button class="btn btn-info" id="viewschedule">Create Jadwal <i class="icon-calendar icon-white"></i></button>
           	</form>
           	<br> 
        </div>
    </div>      
    
 
 
@endsection

@section('otherscript')
<script type="text/javascript">

var rootURL = '{{ URL::base().'/schedule' }}';

$('#viewschedule').click(function() {
          scheduleview();
          return false;
      });

$(function () {
	$('#datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});
	

</script>
@endsection