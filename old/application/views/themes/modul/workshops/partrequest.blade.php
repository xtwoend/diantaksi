@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Permintaan Sparepart</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('workshops')}}">workshops</a> <span class="divider">/</span></li>
        <li class="active">permintaan sparepart</a></li>
    </ul>
@endsection
  
  
@section('content')
	
	

@endsection

@section('otherscript')

@endsection
