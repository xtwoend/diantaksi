@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Roles</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Roles</li>
    </ul>
@endsection
    

@section('content')

  <p>Use the table below to edit the roles available to users.</p>
          <?php echo Messages::get_html()?>
          <?php
            if($roles){
              echo '<table class="table table-striped table-bordered table-condensed">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Key</th>
                  <th>Name</th>
                  <th>User Count</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </thead><tbody>
              ';
              foreach($roles as $role){
                echo '<tr>
                  <td>'.$role->id.'</td>
                  <td>'.$role->slug.'</td>
                  <td>'.$role->name.'</td>
                  <td>'.$role->users()->count().'</td>
                  <td>'.$role->created_at.'</td>
                  <td><a class="btn btn-primary" href="'.action('roles@edit', array($role->id)).'">Edit</a> <a class="delete_toggler btn btn-danger" rel="'.$role->id.'">Delete</a></td>
                </tr>';
              }
              echo '</tbody></table>';
            }else{
              echo '<div class="well"><p>There are no roles in the system yet. Feel free to add one below.</p></div>';
            }
          ?>
          <a href="<?php echo action('roles@create')?>" class="btn btn-primary right">New Role</a>


	<div class="modal hide fade" id="delete_role">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Are You Sure?</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this role?</p>
      </div>
      <div class="modal-footer">
        {{ Form::open('roles/delete', 'POST') }}
        <a data-toggle="modal" href="#delete_role" class="btn">Keep</a>
        <input type="hidden" name="id" id="postvalue" value="" />
        <input type="submit" class="btn btn-danger" value="Delete" />
        {{ Form::close() }}
      </div>
    </div>
@endsection

@section('otherscript') 	
   	<script>
      // Populate the field with the right data for the modal when clicked
      $('.delete_toggler').each(function(index,elem) {
          $(elem).click(function(){
            $('#postvalue').attr('value',$(elem).attr('rel'));
            $('#delete_role').modal('show');
          });
      });
    </script>
@endsection