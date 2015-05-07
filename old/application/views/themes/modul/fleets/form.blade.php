@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Daftar Armada</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('fleets')}}">Fleets CMS</a> <span class="divider">/</span></li>
        <li class="active">Add Fleets</li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Form Armada</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            <form class="form-horizontal" action="{{ URL::current() }}" method="POST">
              <div class="span12">
                
                  <div class="control-group">
                    <label class="control-label" for="name">Nomor Body</label>
                    <div class="controls">
                      <input type="text" id="taxi_number" name="taxi_number" placeholder="Ketikan Nomor Body" @if(!$create) value="{{$fleet->taxi_number}}" @endif>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="police_number">Nomor Polisi</label>
                    <div class="controls">
                      <input type="text" id="police_number" name="police_number" placeholder="police number" @if(!$create) value="{{$fleet->police_number}}" @endif >
                    </div>
                  </div>
<!--
                  <div class="control-group">
                    <label class="control-label" for="inputtext">TTL</label>
                    <div class="controls">
                      <input type="text" id="brith_place" name="brith_place" placeholder="Tempat Lahir" @if(!$create) value="{{$fleet->brith_place}}" @endif >
                      <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="date_of_birth" class="input-small" id="date_of_birth" type="text" @if(!$create) value="{{$fleet->date_of_birth}}" @endif>
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>
-->
                  <div class="control-group">
                    <label class="control-label" for="pool">Nomor Mesin</label>
                    <div class="controls">
                      <input type="text" id="engine_number" name="engine_number" placeholder="engine number" @if(!$create) value="{{$fleet->engine_number}}" @else @endif >
                    </div>
                  </div>

                   <div class="control-group">
                    <label class="control-label" for="pool">Nomor Rangka</label>
                    <div class="controls">
                      <input type="text" id="chassis_number" name="chassis_number" placeholder="chassis number" @if(!$create) value="{{$fleet->chassis_number}}" @endif >
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Pool</label>
                    <div class="controls">
                        {{ Form::select('pool_id', $pools , ($create) ? '': $fleet->pool_id ) }}
                    </div>
                  </div>

                 

                  <div class="control-group">
                    <label class="control-label" for="pool">Merek</label>
                    <div class="controls">
                        {{ Form::select('fleet_brand_id', $brands, ($create) ? '': $fleet->fleet_brand_id  ) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Model</label>
                    <div class="controls">
                        {{ Form::select('fleet_model_id', $models, ($create) ? '': $fleet->fleet_model_id  ) }}
                    </div>
                  </div>

                   <div class="control-group">
                    <label class="control-label" for="pool">Keanggotaan Laka </label>
                      <label class="checkbox inline span4">
                          {{ Form::checkbox('fg_laka', '1', ($create) ? '' : ($fleet->fg_laka == 1) ? true : false ) }}
                          
                      </label>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Stiker Bandara</label>
                      <label class="checkbox inline span4">
                          {{ Form::checkbox('fg_bandara', '1', ($create) ? '' : ($fleet->fg_bandara == 1) ? true : false ) }}
                          
                      </label>
                  </div>

                   <div class="control-group">
                    <label class="control-label" for="pool">Telah Di KSO kan</label>
                      <label class="checkbox inline span4">
                          {{ Form::checkbox('fg_kso', '1', ($create) ? '' : ($fleet->fg_kso == 1) ? true : false ) }}
                          
                      </label>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Telah Setoran</label>
                      <label class="checkbox inline span4">
                          {{ Form::checkbox('fg_setor', '1', ($create) ? '' : ($fleet->fg_setor == 1) ? true : false ) }}
                          
                      </label>* Note ini diedit jika terjadi kesalahan pada operasi jika armada masih di nyatakan belum setoran padahal sudah
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">On Group</label>
                      <label class="checkbox inline span4">
                          {{ Form::checkbox('fg_group', '1', ($create) ? '' : ($fleet->fg_group == 1) ? true : false ) }}
                          
                      </label>* Note ini diedit jika terjadi edit di doo
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
$(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });
  });

</script>
@endsection
