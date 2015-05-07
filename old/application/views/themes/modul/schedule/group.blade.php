@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Fleet Schedule Groups</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('schedule')}}">Schedule</a> <span class="divider">/</span></li>
        <li class="active">Groups</li>
    </ul>
@endsection
  

@section('content')
     
<div class="row-fluid">
	@foreach($schedulemasters as $master)
    <div class="block">
       <div class="block-heading">
            <span class="block-icon pull-right span1">
               <center><a href="{{URL::to('schedule/addtogroup')}}?mstr_schedule={{$master->id}}"> New </a></center>
            </span>

            <a href="#widget{{$master->id}}" data-toggle="collapse">Groups {{$master->name}} </a>
        </div>
        <div class="block-body collapse in" id="widget{{$master->id}}">
            <table class="table table-condensed table-bordered table-striped table-small">
           		{{-- loop group in pool --}}
           		@forelse( Schedulegroup::where('schedule_master_id','=',$master->id)->where('pool_id','=',Auth::user()->pool_id)->get() as $group )	
           		<tr>
	                <td class="span2"><span class="label">Group #{{ $group->group }} </span> <a class="delete_toggler btn btn-mini btn-danger" rel="{{ $group->id }}"> Delete </a></td>
	                <td class="span8">
	                	{{-- loop fleet in group --}}
	                	@foreach(Schedulefleetgroup::where('schedule_group_id','=', $group->id )->get() as $fleet)
                    <?php $fleetz = Fleet::find($fleet->fleet_id); ?>	
                      @if($fleetz)
  	                		<span class="label label-info">{{ $fleetz->taxi_number }}</span> 
                        <?php 
                          $x = Schedule::where('fleet_id','=',$fleet->fleet_id)
                                    //->where('month','=',date('n',time()))
                                    ->where('year','=',date('Y',time()))
                                    ->order_by('month','desc')->first();
                          if($x) {
                            echo 'Last Generate: ';
                            echo '<span class="label label-info">';
                            echo MyFungsi::bulan($x->month);
                            echo '</span>'; 
                          }
                        ?>
                      @endif
	                	@endforeach
	                </td>
	                <td class="span2"><a class="label label-info" href="{{URL::to('schedule/create')}}?id={{$group->id}}"> Create Jadwal </a></td>
            	</tr>
            	@empty

            	<tr> <td> Tidak ada armada di master kepang ini </td> </tr>

            	@endforelse

            </table>
        </div>
    </div>
    @endforeach
</div>

 <div class="modal hide fade" id="delete_group">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Are You Sure?</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this group?</p>
      </div>
      <div class="modal-footer">
        {{ Form::open('schedule/delgroup', 'POST') }}
        <a data-toggle="modal" href="#delete_group" class="btn">Keep</a>
        <input type="hidden" name="id" id="postvalue" value="" />
        <input type="submit" class="btn btn-danger" value="Delete" />
        {{ Form::close() }}
      </div>
    </div>

@endsection

@section('otherscript')
  <script type="text/javascript">
       

        // Populate the field with the right data for the modal when clicked
        $('.delete_toggler').each(function(index,elem) {
            $(elem).click(function(){
                $('#postvalue').attr('value',$(elem).attr('rel'));
                $('#delete_group').modal('show');
            });
        });
 

</script>
@endsection