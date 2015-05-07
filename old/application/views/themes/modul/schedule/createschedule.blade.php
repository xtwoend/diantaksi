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
                    <?php $id = (int) Input::get('id', false); ?>
	                	@foreach($fleets as $fleet)
	                		{{ HTML::link('schedule/detail/'.$fleet->fleet_id.'/'.$id , Fleet::find($fleet->fleet_id)->taxi_number , array('id'=>'loaddata','class' => 'btn btn-mini btn-info')) }}
	                	@endforeach
	                </td>
	            </tr>
            </table>
        </div>
    </div>


@endsection

@section('otherscript')
 	
@endsection