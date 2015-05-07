@layout('themes.layouts.common')

@section('content')
  
  <div class="row-fluid">
    <div class="dialog">
        <div class="block">
            <p class="block-heading">Sign In</p>
            <div class="block-body">
                <div class="row-fluid">
                    <div class="span4">
                        {{ HTML::image('img/logo.gif','',array('id' => 'logo')) }}
                    </div>

                    <div class="span8">
                    {{ Form::open('admin/login', 'POST'); }}
                       <?php echo Form::token()?>
                        <label>Username</label>
                        <input type="text" class="span12" name="username">
                        <label>Password</label>
                        <input type="password" class="span12" name="password">
                        <input type="submit" class="btn btn-primary pull-right" value="Sign In" />
                        <div class="clearfix"></div>
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

