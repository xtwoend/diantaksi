@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Manage Bapak Asuh {{  Pool::find($user->pool_id)->pool_name }} </h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Manage Bapak Asuh</li>
    </ul>
@endsection
  

@section('content')
     
     <table class="table table-striped table-bordered table-condensed">
        <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Jabatan</th>
                  <th>Anak Asuh</th>
                  <th>Actions</th>
                </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
@foreach($userperpool as $man)
          <tr>
            <td>{{ $no }}</td>
            <td>{{ $man->fullname }}</td>
            <td> - </td>
            <td>
                <?php 
                        $anakasuh = Anakasuh::join('fleets', 'fleets.id', '=', 'anak_asuh.fleet_id')
                                  ->where('anak_asuh.user_id','=',$man->id)
                                  ->where('anak_asuh.status', '=', 1 )
                                  ->get(array('anak_asuh.id','fleets.taxi_number', 'anak_asuh.fleet_id')); 
                ?>
                                    @foreach($anakasuh as $fleet)
                                        {{ HTML::link('cardcontrols/kartukontrolarmada/'.$fleet->fleet_id ,$fleet->taxi_number,array('class'=>'btn btn-mini btn-success','target'=>'_blank')) }}
                                    @endforeach
            
            </td>
            <td>{{ HTML::link('anakasuh/daftar/'.$man->id ,'Manage Anak Asuh',array('class'=>'btn btn-mini btn-success')) }}</td>
          </tr>
          <?php $no++; ?>
@endforeach 
        </tbody>
      </table>
      <!-- Button to trigger modal -->

@endsection

@section('otherscript')

@endsection