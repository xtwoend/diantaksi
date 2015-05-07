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
                                    <?php $ksos = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('ksos.actived','=', 1)->where('ksos.pool_id', '=', $pool->id )->order_by('fleets.taxi_number','asc')->get(array('ksos.id','fleets.taxi_number', 'fleets.id as fleet_id')); ?>
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
                               <?php $ksos = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('ksos.actived','=',2)->where('ksos.pool_id', '=', $pool->id )->group_by('fleets.id')->order_by('fleets.taxi_number','asc')->get(array('ksos.id','fleets.taxi_number', 'fleets.id as fleet_id')); ?>
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
                            <tr>
                                <td><span class="label label-important">KSO SELESAI</span></td>
                            </tr>
                            <tr>
                                <td>
                               <?php $ksos = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where('ksos.actived','=',3)->where('ksos.pool_id', '=', $pool->id )->group_by('fleets.id')->order_by('fleets.taxi_number','asc')->get(array('ksos.id','fleets.taxi_number', 'fleets.id as fleet_id')); ?>
                                @foreach($ksos as $kso)
                                    {{ HTML::link('ksos/ksofleet/'.$kso->fleet_id ,$kso->taxi_number,array('class'=>'btn btn-mini btn-success')) }}
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

@endsection
@section('otherscript')
<script type="text/javascript">


</script>
@endsection
