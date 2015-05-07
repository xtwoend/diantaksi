@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Create Schedule</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('schedule')}}">Schedule</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('schedule/groups')}}">Groups</a> <span class="divider">/</span></li>
        <li class="active">Create Schedule</li>
    </ul>
@endsection
 
@section('content')
	
	<div class="block">
       <div class="block-heading">
            
            <a href="#widgetGroup" data-toggle="collapse">Daftar armada di Groups #{{$group->group}} </a>
        </div>
        <div class="block-body collapse in" id="widgetGroup">
            <table class="table table-condensed table-bordered table-striped table-small">
           		<tr>
	                <td class="span8">
	                	@foreach($fleets as $fleet)
	                		{{ HTML::link('schedule/detail/'.$fleet->fleet_id .'/'.URI::segment(4) , Fleet::find($fleet->fleet_id)->taxi_number , array('class' => 'btn btn-mini btn-info')) }}
	                	@endforeach
	                </td>
	            </tr>
            </table>
        </div>
    </div>

    <div class="block">
       <div class="block-heading">
            
            <a href="#widgetGroup1" data-toggle="collapse">Infomasi Armada {{ $fleetinfo->taxi_number }} </a>
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            <table class="table table-condensed table-bordered table-striped table-small">
           		<tr>
	                <td>Nomor Polisi </td>
	                <td>Pool </td>
	                <td>Saldo Unit</td>
	            </tr>
	            <tr>
	                <td>{{ $fleetinfo->police_number }}</td>
	                <td>{{ Pool::find($fleetinfo->pool_id)->pool_name }}</td>
	                <td></td>
	            </tr>
            </table>
        </div>
    </div>
    {{-- Block untuk infomasi pengemudi --}}
    <div class="block">
       <div class="block-heading">
            
            <a href="#widgetGroup2" data-toggle="collapse">Infomasi Pengemudi {{ $fleetinfo->taxi_number }} </a>
        </div>
        <div class="block-body collapse in" id="widgetGroup2">
            <table class="table table-condensed table-bordered table-striped table-small">
           		<?php $bravo = Driver::find($fleetinfo->bravo_driver_id); ?>
              <tr>
	                <td>Bravo</td>
	                <td>
                    @if($bravo)
                    ( {{$bravo->nip}} ) {{$bravo->name}} <input type="hidden" id="bravo_id" value="{{$bravo->id}}">
                    @else
                      Tidak Ada Bravo
                    @endif
                  </td>
	                <td>

                  {{ Form::select('day', $dayofmonth,'' , array('required','id'=>'day')) }} Tanggal Awal Libur

                  </td>
	            </tr>
              <?php $charlie = Driver::find($fleetinfo->charlie_driver_id); ?>
              <tr>
	                <td>Charlie</td>
	                <td>
                      @if($charlie)
                        ( {{$charlie->nip}} ) {{$charlie->name}} <input type="hidden" id="charlie_id" value="{{$charlie->id}}"></td>
	                    @else
                        Tidak Ada Charlie
                      @endif
                  <td>
                    <input name="sisaopscharlie" id="sisaopscharlie" type="text" value="0" >Sisa Operasi Charlie Bulan Lalu
                  </td>
	            </tr>
              <tr>
                  <td>Waktu Operasi</td>
                  <td>{{ Form::select('shift', $shifts,'',array('id'=>'shift')) }}</td>
                  <td></td>
              </tr>
              <tr>
                  <td></td>
                  <td><input type="hidden" id="fleet_id" value="{{$fleetinfo->fleet_id}}"> <input type="hidden" id="schedule_master_id" value="{{ $group->schedule_master_id }}">
                   
                   {{ Form::select('month', $months,  date('n', time()) , array('required','id'=>'month')) }} 
                   {{ Form::select('year', $years, date('Y',time()) , array('required','id'=>'year')) }}   
                  </td>
                  <td> <button class="btn btn-info" id="btnGenerate" >Buat Jadwal <i class="icon-calendar icon-white"></i></button>
                        <button class="btn btn-info" id="scheduleReset">Reset Jadwal <i class="icon-calendar icon-white"></i></button>
                  </td>
              </tr>
            </table>

            
        </div>
    </div>

  {{-- Block untuk schedule fleet --}}
    <div class="block">
       <div class="block-heading">
            
            <a href="#widgetGroup3" data-toggle="collapse">jadwal Pengemudi {{ $fleetinfo->taxi_number }} </a>
        </div>
        <div class="block-body collapse in" id="widgetGroup3">
            <br>
            {{ Form::select('monthschedule', $months, date('n', time()) , array('required','id'=>'monthschedule')) }} 
            {{ Form::select('yearschedule', $years, date('Y',time()) , array('required','id'=>'yearschedule')) }} 
            <button class="btn btn-info" id="viewschedule">Lihat Jadwal <i class="icon-calendar icon-white"></i></button>

            <div id="listschedule"></div>
        </div>
    </div>
@endsection

@section('otherscript')
 	<script type="text/javascript">
    var rootURL = '{{ URL::base().'/schedule' }}';
 		$('#btnGenerate').click(function() {
          generate();
          return false;
      });
    $('#viewschedule').click(function() {
          viewschedule();
          return false;
      });

    $('#scheduleReset').click(function() {
          var month = $('#monthschedule').val();
          var r=confirm("Apakah Anda Yakin Mengapus Jadwal Armada {{ $fleetinfo->taxi_number }} untuk bulan " + month + " ?")
          if (r==true)
            {
              scheduleReset(); 
            }
          return false;
      });

    function viewschedule()
    {  
      var month = $('#monthschedule').val();
      var year = $('#yearschedule').val();
      var fleet_id = $('#fleet_id').val();
      console.log('viewschedule');

      $("#listschedule").load( rootURL + '/viewschedule/' + month + '/' + year + '/' + fleet_id);   
    }

    function  scheduleReset() {
      console.log('generateSchedule');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/schedulereset',
            dataType: "json",
            data: formToJSON(),
            success: function(data, textStatus, jqXHR){
                  alert(data);                
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('Schedule Reset error: Jadwal gagal direset!');
            }
        });
    }
    function generate()
    {
        console.log('generateSchedule');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/generate',
            dataType: "json",
            data: formToJSON(),
            success: function(data, textStatus, jqXHR){
                  alert('Schedule generate successfully');                
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('Schedule generate error: Jadwal sudah pernah di buat!');
            }
        });
    }

    function formToJSON(){
      return JSON.stringify({
          "fleet_id": $('#fleet_id').val(), 
          "day": $('#day').val(),
          "sisaopscharlie": $('#sisaopscharlie').val(),
          "schedule_master_id": $('#schedule_master_id').val(),
          "bravo_id": $('#bravo_id').val(),
          "charlie_id": $('#charlie_id').val(),
          "month": $('#month').val(), 
          "year": $('#year').val(),
          "shift": $('#shift').val(),  
        });
    }

     function scheduleToJSON(){
      return JSON.stringify({
          "fleet_id": $('#fleet_id').val(), 
          "monthschedule": $('#monthschedule').val(),
          "yearschedule": $('#yearschedule').val(),
        });
    }
 	</script>
@endsection