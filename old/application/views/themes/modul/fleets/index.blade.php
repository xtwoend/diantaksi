@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Daftar Armada</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('fleets')}}">Fleets CMS</a> <span class="divider">/</span></li>
        <li class="active">List Fleets</li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#ss" data-toggle="collapse">Pencarian Armada</a>       
        </div>
        <div class="block-body collapse" id="ss">
          <br>
            <form class="form-inline" action="{{ URL::current() }}" method="POST">
                <input name="taxi_number" id="taxi_number" class="input-normal" type="text" placeholder="Ketikan Nomor Body"><input type="submit" class="btn btn-info" value="Cari">
            </form>
            <br> 
        </div>
  </div>

<div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
                {{ HTML::link('fleets/add','Add fleet',array('class'=>'btn btn-info','type'=>'button') ) }}
            </span>
            <a href="#widgetGroup1" data-toggle="collapse">Daftar Pengemudi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th>Nomor Body</th>
                        <th>Nomor Polisi</th>
                        <th>Nomor Mesin</th>
                        <th>Nomor Rangka</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fleets->results as $fleet)
                    <tr>
                        <td> {{ $fleet->id }}</td>
                        <td> {{ $fleet->taxi_number }}</td>
                        <td> {{ $fleet->police_number }}</td>
                        <td> {{ $fleet->engine_number }}</td>
                        <td> {{ $fleet->chassis_number }}</td>
                        <td> {{ $fleet->fleet_brand }}</td>
                        <td> {{ $fleet->fleet_model }}</td>
                        <td> {{ Html::link('/fleets/edit/'.$fleet->id ,'Edit') }} || {{ Html::link('/fleets/delete/'.$fleet->id ,'Delete') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $fleets->links() }}
        </div>
    </div>
 

@endsection
@section('otherscript')
<script type="text/javascript">


</script>
@endsection
