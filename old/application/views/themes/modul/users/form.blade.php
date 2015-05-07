@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Users</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Users</li>
    </ul>
@endsection
  

@section('content')
       
          
          <?php echo Messages::get_html()?>
          <?php echo Form::open_for_files('users/'.( $create ? 'create' : 'edit' ), 'POST', array('class'=>'form-horizontal'));?>
          <?php if(!$create): ?> <input type="hidden" name="id" value="<?php echo $user->id?>" /> <?php endif; ?>
           
          <fieldset>
            <legend>Basic Information</legend>

            <div class="control-group">
              <?php echo Form::label('username', 'Username',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('username',  ( Input::old('username') || $create ? Input::old('username') : $user->username ),array('placeholder'=>'Enter Username...'))?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('email', 'Email Address',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('email',  ( Input::old('email') || $create ? Input::old('email') : $user->email ),array('placeholder'=>'Enter Email Address...'))?>
              </div>
            </div>


            <div class="control-group">
              <?php echo Form::label('first_name', 'First Name',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('first_name',  ( Input::old('first_name') || $create ? Input::old('first_name') : $user->first_name ),array('placeholder'=>'Enter First Name...'))?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('last_name', 'Last Name',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('last_name',  ( Input::old('last_name') || $create ? Input::old('last_name') : $user->last_name ),array('placeholder'=>'Enter Last Name...'))?>
              </div>
            </div>

          <div class="control-group">
              <?php echo Form::label('pool_id', 'Pool',array('class'=>'control-label'))?>
              <div class="controls">
                {{ Form::select('pool_id', $pools, ( Input::old('pool_id') || $create ? Input::old('pool_id') : $user->pool_id ) ) }}
                <?php //echo Form::text('pool_id',  ( Input::old('pool_id') || $create ? Input::old('pool_id') : $user->pool_id ),array('placeholder'=>'Enter Last Name...'))?>
              </div>
          </div>

          </fieldset>
          <fieldset>
            <legend>Authentication</legend>
            <div class="control-group">
              <?php echo Form::label('password', 'Password',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::password('password', array('placeholder'=>'Enter New Password...'))?>
              </div>
            </div>
            <div class="control-group">
              <?php echo Form::label('password_confirmation', 'Password Confirmation', array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::password('password_confirmation', array('placeholder'=>'Confirm New Password...'))?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('admin', 'Administrator', array('class'=>'control-label'))?>
              <div class="controls">
                <label class="checkbox">
                  <?php echo Form::checkbox('admin', '1', ( Input::old('admin') || $create ? Input::old('admin') : ($user->admin ? true : false)  ));?>
                </label>
              </div>
            </div>

          </fieldset>

          <?php
            if($roles){
              echo '<fieldset><legend>Roles</legend><div class="control-group">';
              echo Form::label('user_list', ( $create ? 'User\'s Roles' : $user->first_name.'\'s Roles' ), array('class'=>'control-label'));
              foreach($roles as $role){
          ?>
              <div class="controls">
                <label class="checkbox">
                  <?php echo Form::checkbox('roles['.$role->id.']', '1', ( Input::old('roles['.$role->id.']') || $create ? Input::old('roles['.$role->id.']') : Koki::has_role($user,$role->id) ));?>
                  <?php echo $role->name?>
                </label>
              </div>
          <?php
              }
              echo '</div></fieldset>';
            }
          ?>
          <div class="form-actions">
            <a class="btn" href="<?php echo url('users')?>">Go Back</a>
            <input type="submit" class="btn btn-primary" value="<?php echo ($create ? 'Create User' : 'Save User')?>" />
          </div>
          <?php echo Form::close() ?>
          
@endsection

   
  