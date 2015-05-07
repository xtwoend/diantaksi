@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Setoran Armada</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('ksos')}}">Management KSO</a> <span class="divider">/</span></li>
        <li class="active">KSO</li>
    </ul>
@endsection
  
@section('content')

 <div class="block">
        <div class="block-heading">
        	<span class="block-icon pull-right">
        		{{ HTML::link('ksos/formkso','New KSO',array('class'=>'btn btn-info','type'=>'button') ) }}
            </span>
            <a href="#widgetGroup1" data-toggle="collapse">Daftar Armada Perserta KSO</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          	
        	<table class="table">
        		@foreach(Pool::all() as $pool)
        		<tr>
        			<td> {{$pool->pool_name}} </td>
        		</tr>
        		<tr>
        			<td> 
        				<table class="table">
                            <tr>
                                <td><span class="label label-success">KSO AKTIF</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php $ksos = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where_in('ksos.actived', array(1))->where('fleets.pool_id', '=', $pool->id )->order_by('fleets.taxi_number','asc')->get(array('ksos.id','fleets.taxi_number', 'fleets.id as fleet_id')); ?>
                                    @foreach($ksos as $kso)
                                        {{ HTML::link('ksos/ksofleet/'.$kso->fleet_id ,$kso->taxi_number,array('class'=>'btn btn-mini btn-success')) }}
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <td><span class="label label-important">KSO GUGUR</span></td>
                            </tr>
                            <tr>
                                <td>
                               <?php $ksos = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where_in('ksos.actived', array(2))->where('fleets.pool_id', '=', $pool->id )->group_by('fleets.id')->order_by('fleets.taxi_number','asc')->get(array('ksos.id','fleets.taxi_number', 'fleets.id as fleet_id')); ?>
                                @foreach($ksos as $kso)
                                    <?php //membuat yang aktif tidak ada tapi yang gugur ada
                                      $active = Kso::where('fleet_id','=',$kso->fleet_id)->where('actived','=',1)->get();
                                    ?>
                                    @if(!$active)
                                        {{ HTML::link('ksos/ksofleet/'.$kso->fleet_id ,$kso->taxi_number,array('class'=>'btn btn-mini btn-success')) }}
                                    @endif
                                @endforeach
                                </td>
                            </tr>
                        </table>
        			</td>
        		</tr>
        		@endforeach
        	</table>

        </div>
    </div>

     <div class="block">
        <div class="block-heading">
            <a href="#listss" data-toggle="collapse">Daftar Perjanjian KSO Armda {{ '' }}</a>       
        </div>
        <div class="block-body collapse in" id="listss">
            
            <table class="table">
                <tr>
                    <td>No. </td>
                    <td>No KSO </td>
                    <td>Pengemudi</td>
                    <td>Tanggal KSO </td>
                    <td>Mulai Beroperasi </td>
                    <td>Selesai Beroperasi </td>
                    <td>Status</td>
                    <td>Options</td>
                </tr>
                <?php $no=0;?>
                @foreach($fleetkso as $fkso)
                <?php $no++; ?>
                <?php 
                    $bravo = Driver::find($fkso->bravo_driver_id);
                    $charlie = Driver::find($fkso->charlie_driver_id);
                ?>
                <tr>
                    <td>{{$no}}</td>
                    <td>{{ $fkso->kso_number }}</td>
                    <td>
                        @if($bravo)
                            {{ '('. $bravo->nip .') '. $bravo->name }} 
                        @endif
                        
                        @if($charlie) 
                            {{ '('. $charlie->nip .') '. $charlie->name }} 
                        @endif
                    </td>
                    <td>{{ $fkso->last_update }}</td>
                    <td>{{ Myfungsi::fulldate(strtotime($fkso->ops_start)) }}</td>
                    <td>{{ Myfungsi::fulldate(strtotime($fkso->ops_end)) }}</td>
                    <td>{{ ($fkso->actived == 1)? 'Active' : 'Gugur' }}</td>
                    <td>{{ HTML::link('ksos/editkso/'.$fkso->id, 'Edit', array('class' => 'btn btn-mini btn-primary')) }} 

                       <a class="delete_toggler btn btn-mini btn-danger" rel="{{ $fkso->id }}"> Delete </a>
                    </td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>
    <div class="modal hide fade" id="delete_kso">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Are You Sure?</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this kso?</p>
      </div>
      <div class="modal-footer">
        {{ Form::open('ksos/delkso', 'POST') }}
        <a data-toggle="modal" href="#delete_kso" class="btn">Keep</a>
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
                $('#delete_kso').modal('show');
            });
        });
 

</script>
@endsection
