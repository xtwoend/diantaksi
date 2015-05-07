@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Master Jadwal Armada</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('schedule')}}">Schedule</a> <span class="divider">/</span></li>
        <li class="active">Mater Jadwal Armada</li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
                {{ HTML::link('schedule/masterschadd','Add Master Schedule',array('class'=>'btn btn-info','type'=>'button') ) }}
            </span>
            <a href="#widgetGroup1" data-toggle="collapse">Master Jadwal Armada</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Mater</th>
                        <th>Interval Bravo</th>
                        <th>Interval Charlie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($masterschedules->results as $ms)
                    <tr>
                        <td> {{ $ms->id }}</td>
                        <td> {{ $ms->name }}</td>
                        <td> {{ $ms->bravo_interval }}</td>
                        <td> {{ $ms->charlie_interval }}</td>
                        <td> {{ Html::link('schedule/masterschedit/'.$ms->id ,'Edit') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $masterschedules->links() }}
        </div>
    </div>
 

@endsection
@section('otherscript')
<script type="text/javascript">


</script>
@endsection
