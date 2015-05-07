@extends('layout')

@section('body')

	<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
	    <div class="container aside-xl">
	      <a class="navbar-brand block" href="index.html"><span class="h1 font-bold">Musik</span></a>
	      <section class="m-b-lg">
	        <header class="wrapper text-center">
	          <strong>Sign in to get in touch</strong>
	        </header>
	        
	        @if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>Whoops!</strong> There were some problems with your input.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

	        <form action="{{  url('auth/login') }}" method="POST">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	          	<div class="form-group">
	            	<input type="text" name="username" placeholder="Username" class="form-control rounded input-lg text-center no-border">
	          	</div>
	          	<div class="form-group">
	            	<input type="password" name="password" placeholder="Password" class="form-control rounded input-lg text-center no-border">
	          	</div>
	          	<button type="submit" class="btn btn-lg btn-warning lt b-white b-2x btn-block btn-rounded"><i class="icon-arrow-right pull-right"></i><span class="m-r-n-lg">Sign in</span></button>
	          	<div class="text-center m-t m-b"><a href="#"><small>Forgot password?</small></a></div>
	          	<div class="line line-dashed"></div>
	        </form>
	      </section>
	    </div>
	</section>
	  <!-- footer -->
	<footer id="footer">
	    <div class="text-center padder">
	      <p>
	        <small>Dian Taksi <br>&copy; 2015</small>
	      </p>
	    </div>
	</footer>

@endsection