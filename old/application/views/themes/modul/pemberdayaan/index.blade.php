@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Pemberdayaan Pengemudi</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('pemberdayaan')}}">Pemberdayaan Pengemudi</a> <span class="divider">/</span></li>
    </ul>
@endsection
  
@section('content')



@endsection
@section('otherscript')
<script type="text/javascript">


</script>
@endsection
