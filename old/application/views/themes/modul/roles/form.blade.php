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


{{ Messages::get_html() }}

{{Form::open('roles/'.( $create ? 'create' : 'edit' ), 'POST', array('class'=>'form-horizontal'))}}
          @if(!$create) <input type="hidden" name="id" value="<?php echo $role->id?>" /> @endif
           
          <fieldset>
            <legend>Basic Information</legend>

            <div class="control-group">
              <?php echo Form::label('name', 'Role Name',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('name',  ( Input::old('name') || $create ? Input::old('name') : $role->name ),array('placeholder'=>'Enter Role Name...'))?>
              </div>
            </div>
          </fieldset>
          
           <div class="form-actions">
            <a class="btn" href="{{url('roles')}}">Go Back</a>
            <input type="submit" class="btn btn-primary" value="{{ ($create ? 'Create Role' : 'Save Role') }}" />
          </div>
          <?php
            if($users){
              echo '<fieldset><legend>Users Assigned To This Role</legend><div class="control-group">';
              echo Form::label('user_list','Role\'s Users', array('class'=>'control-label'));
              foreach($users as $user){
          ?>
              <div class="controls">
                <label class="checkbox">
                  <?php echo Form::checkbox('users['.$user->id.']', '1', ( Input::old('users['.$user->id.']') || $create ? Input::old('users['.$user->id.']') : Koki::has_role($user,$role->id) ) );?>
                  <?php echo $user->fullname?>
                </label>
              </div>
            </div>
          <?php
              }
              echo '</fieldset>';
            }
          ?>

{{Form::close()}}

@endsection
