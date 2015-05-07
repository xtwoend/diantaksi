@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Kewajiban Cicilan Armada</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('settingcicilan')}}">Setting Kewajiban Cicilan</a> <span class="divider">/</span></li>
        <li class="active">List Armada</li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
                
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
                        <?php $ksos = Fleet::join('ksos', 'fleets.id', '=', 'ksos.fleet_id')->where_in('ksos.actived', array(1,2))->where('fleets.pool_id', '=', $pool->id )->get(array('ksos.id','fleets.taxi_number', 'fleets.id as fleet_id')); ?>
                        @foreach($ksos as $kso)
                            {{ HTML::link('ksos/ksofleet/'.$kso->fleet_id ,$kso->taxi_number,array('class'=>'btn btn-mini btn-success')) }}
                        @endforeach
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
