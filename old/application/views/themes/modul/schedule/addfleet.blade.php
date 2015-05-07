@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Add group</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('schedule')}}">Schedule</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('schedule/groups')}}">Groups</a> <span class="divider">/</span></li>
        <li class="active">Add group</li>
    </ul>
@endsection
 
@section('content')

    <div class="input-append">
	  <input class="span5" readonly id="appendedInputButton" type="text" value="Group #{{ $newgroup }}">
	  <button class="btn" type="button" id="create">Create</button>
	</div>   

	{{ Form::open('schedule/addgroup') }}
	<input type = "hidden" name="group" value="{{ $newgroup }}"> 
	<input type = "hidden" name="schedule_master_id" value="{{ Input::get('mstr_schedule', False); }}"> 

	<div id="formadd"></div>
	
	{{ Form::close() }}

@endsection

@section('otherscript')
 	<script type="text/javascript">
 		$('#create').click(function(){
 			$( "#formadd" ).load( base_url + "/schedule/addformgroup");
 		});
 		var idrow = 1;
		var ss = 1; 

		function addlatar(){
			
		    var x = document.getElementById('tablefleets').insertRow(idrow); 
		    var td1 = x.insertCell(0); 
		    var td2 = x.insertCell(1); 
		    
		    td1.innerHTML=""; 
		    td2.innerHTML="<div id='plus"+ ss +"'></div>";
		    $("#plus"+ ss ).load( base_url + "/schedule/ajaxfleetlist");
		    idrow++;
		    ss++;
		} 

		function minlatar(){ 
		    if(idrow>1){ 
		        var x=document.getElementById('tablefleets').deleteRow(idrow-1); 
		        idrow--; 
		    } 
		}
 	</script>
@endsection