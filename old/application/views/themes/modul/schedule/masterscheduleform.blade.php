@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Form Master Jadwal Armada</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('schedule')}}">Schedule</a> <span class="divider">/</span></li>
        <li class="active">Mater Jadwal Armada</li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Form Jadwal Master Armada</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            <form class="form-horizontal" action="{{ URL::current() }}" method="POST">
              <div class="span12">
                <input type="hidden" name="id" @if(!$create) value="{{$ms->id}}" @endif>
                  <div class="control-group">
                    <label class="control-label" for="name">Nama Master Jadwal</label>
                    <div class="controls">
                      <input type="text" id="name" name="name" placeholder="Ketikan Nama Master Jadwal" @if(!$create) value="{{$ms->name}}" @endif>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="name">Interval Bravo</label>
                    <div class="controls">
                      <input type="text" id="bravo_interval" name="bravo_interval" placeholder="interval bravo" @if(!$create) value="{{$ms->bravo_interval}}" @endif >
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Interval Charlie</label>
                    <div class="controls">
                      <input type="text" id="charlie_interval" name="charlie_interval" placeholder="interval charlie" @if(!$create) value="{{$ms->charlie_interval}}" @else @endif >
                    </div>
                  </div>

              </div>
              
             <input type="reset" class="btn" value="Reset"> <input type="submit" class="btn btn-primary" value="Simpan"> 
               </form>
          </div>  <!-- end pembagian kolom -->
        </div>
</div>
 

@endsection
@section('otherscript')
<script type="text/javascript">


</script>
@endsection
