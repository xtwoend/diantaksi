@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Manage Anak Asuh Untuk {{ $userinfo->fullname }} - {{  Pool::find($userinfo->pool_id)->pool_name }} </h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Manage Anak Asuh</li>
    </ul>
@endsection
  

@section('content')
     {{ HTML::link('anakasuh/addanakasuh/'.$userinfo->id ,'Add Anak Asuh',array('class'=>'btn btn-success')) }}
     <br><br>
     <table class="table table-striped table-bordered table-condensed">
        <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor Body</th>
                  <th>Bravo</th>
                  <th>Charlie</th>
                  <th>Actions</th>
                </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          @foreach($listanakasuh as $fleet)
          <?php $infokso = Kso::where('fleet_id','=', $fleet->fleet_id)->where('actived','=',1)->first();?>
          @if($infokso)
          <?php $bravo = Driver::find($infokso->bravo_driver_id); ?>
          <?php $charlie = Driver::find($infokso->charlie_driver_id); ?>
            <tr>
              <td>{{ $no }}</td>
              <td><span class="label label-success"> <?php $fl = Fleet::find($fleet->fleet_id); ?> 
                @if($fl)
                 {{ $fl->taxi_number }} 
                 @endif  </span></td>
              <td>( {{$bravo->nip}} ) {{$bravo->name}} </td>
              <td>@if($charlie)
                        ( {{$charlie->nip}} ) {{$charlie->name}} </td>
                      @else
                        Tidak Ada Charlie
                      @endif
            </td>
              <td>{{ HTML::link('anakasuh/remove/'.$fleet->id ,'Hapus',array('class'=>'btn btn-mini btn-success')) }}</td>
            </tr>
          @else
            <tr>
              <td>{{ $no }}</td>
              <td><span class="label label-success"><?php $fl = Fleet::find($fleet->fleet_id); ?> 
                @if($fl) 
                {{ $fl->taxi_number }} 
                @endif</span></td>
              <td>Gugur KSO</td>
              <td></td>
              <td>{{ HTML::link('anakasuh/remove/'.$fleet->id ,'Hapus',array('class'=>'btn btn-mini btn-success')) }}</td>
            </tr>
          @endif
          <?php $no++; ?>
          @endforeach 
        </tbody>
      </table>
      <!-- Button to trigger modal -->

 

    <div class="modal hide fade" id="delete_user">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Are You Sure?</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this user?</p>
      </div>
      <div class="modal-footer">
        <?php echo Form::open('users/delete', 'POST')?>
        <a data-toggle="modal" href="#delete_user" class="btn">Keep</a>
        <input type="hidden" name="id" id="postvalue" value="" />
        <input type="submit" class="btn btn-danger" value="Delete" />
        <?php echo Form::close()?>
      </div>
    </div>

@endsection

@section('otherscript')
  <script>
     
      // Populate the field with the right data for the modal when clicked
      $('.delete_toggler').each(function(index,elem) {
          $(elem).click(function(){
            $('#postvalue').attr('value',$(elem).attr('rel'));
            $('#delete_user').modal('show');
          });
      });
  </script>
@endsection