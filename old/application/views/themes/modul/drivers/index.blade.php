@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Daftar Pengemudi</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('drivers')}}">Driver CMS</a> <span class="divider">/</span></li>
        <li class="active">List</li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#ss" data-toggle="collapse">Pencarian Pengemudi</a>       
        </div>
        <div class="block-body collapse" id="ss">
          <br>
            <form class="form-inline" action="" method="GET">
                <input name="q" id="q" class="input-normal" type="text" placeholder="Ketikan NIP/NAMA Pengemudi" value="{{ Input::get('q') }}"><input type="submit" class="btn btn-info" value="Cari">
            </form>
            <br> 
        </div>
</div>
<a href="{{ URL::to('drivers/exporttoxls') }}" class="btn btn-info btn-sm">Download</a>
<div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
                {{ HTML::link('drivers/add','Add Driver',array('class'=>'btn btn-info','type'=>'button') ) }}
            </span>
            <a href="#widgetGroup1" data-toggle="collapse">Daftar Pengemudi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>No KTP</th>
                        <th>No SIM</th>
                        <th>No Telp / HP</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers->results as $driver)
                    <tr>
                        <td> {{ $driver->id }}</td>
                        <td> {{ $driver->nip }}</td>
                        <td> {{ $driver->name }}</td>
                        <td> {{ $driver->brith_place }}</td>
                        <td> {{ $driver->date_of_birth }}</td>
                        <td> {{ $driver->ktp }}</td>
                        <td> {{ $driver->sim }}</td>
                        <td> {{ $driver->phone }}</td>
                        <td> {{ Html::link('/drivers/edit/'.$driver->id ,'Edit') }} || {{ Html::link('/drivers/delete/'.$driver->id ,'Delete') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $drivers->links() }}
        </div>
    </div>
 

@endsection
@section('otherscript')
<script type="text/javascript">


</script>
@endsection
