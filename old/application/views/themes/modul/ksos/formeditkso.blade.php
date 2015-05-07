@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Setoran Armada</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('ksos')}}">Management KSO</a> <span class="divider">/</span></li>
        <li class="active">KSO</li>
    </ul>
@endsection
  
@section('content')

 <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Form Perjanjian Kerjasama Operasi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            
              {{ Form::open('ksos/saveeditkso','POST',array('class'=>'form-horizontal')) }}
              
              <div class="span6">

                   <div class="control-group">
                    <label class="control-label" for="pool">Pool</label>
                    <div class="controls"><input name="id" type="hidden" value="{{ $datakso->id }}">
                      {{ Form::select('pool_id', $pools, $datakso->pool_id ,array('id'=>'pool_id')) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="body">Nomor Body</label>
                    <div class="controls">
                      {{ Form::select('fleet_id', $fleets, $datakso->fleet_id, array('id'=>'fleet_id' )) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="name">Bravo</label>
                    <div class="controls">
                      {{ Form::select('bravo_driver_id', $drivers, $datakso->bravo_driver_id,  array('id'=>'bravo_driver_id' )) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="inputtext">Charlie</label>
                    <div class="controls">
                      {{ Form::select('charlie_driver_id', $drivers, $datakso->charlie_driver_id ,  array('id'=>'charlie_driver_id' )) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="date">Tanggal Mulai Operasi</label>
                    <div class="controls">
                      <div class="input-append date" id="datepicker" data-date="{{ $datakso->ops_start }}" data-date-format="yyyy-mm-dd">
                        <input name="ops_start" id="ops_start" class="input-small" id="ops_start" type="text" value="{{ $datakso->ops_start }}">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>

                   <div class="control-group">
                    <label class="control-label" for="date">Tanggal Akhir Operasi</label>
                    <div class="controls">
                      <div class="input-append date" id="datepicker1" data-date="{{ $datakso->ops_end }}" data-date-format="yyyy-mm-dd">
                        <input name="ops_end" id="ops_end" class="input-small" id="ops_end" type="text" value="{{ $datakso->ops_end }}">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                 
                  <div class="control-group">
                    <label class="control-label" for="ksoNumber"></label>
                    <div class="controls">
                      <input type="submit" value="Simpan" class="btn">
                      <input type="reset" value="Reset" class="btn">
                    </div>
                  </div>

              </div>
              <div class="span6">
                  <div class="control-group">
                    <label class="control-label" for="ksoNumber">Nomor Perjanjian</label>
                    <div class="controls">
                      <input type="text" id="ksoNumber" name="kso_number" placeholder="No Perjanjian" value="{{ $datakso->kso_number }}">
                    </div>
                  </div>

                  
                  <div class="control-group">
                    <label class="control-label" for="dp">Uang Muka (DP)</label>
                    <div class="controls">
                      <input type="text" id="dp" name="dp" class="moneys" placeholder="dalam rupiah" value="{{ $datakso->dp }}">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="sisa_dp">Sisa Uang Muka (DP)</label>
                    <div class="controls">
                      <input type="text" id="sisa_dp" name="sisa_dp" class="moneys" placeholder="dalam rupiah" value="{{ $datakso->sisa_dp }}">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="setoran">Uang Setoran</label>
                    <div class="controls">
                      <input type="text" id="setoran" name="setoran" class="moneys" placeholder="dalam rupiah" value="{{ $datakso->setoran }}">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="tab_sparepart">Tabungan Spareprt</label>
                    <div class="controls">
                      <input type="text" id="tab_sparepart" name="tab_sparepart" class="moneys" placeholder="dalam rupiah" value="{{ $datakso->tab_sparepart }}">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="jeniskso">Jenis KSO</label>
                    <div class="controls">
                      {{ Form::select('kso_type_id', $kso_types,$datakso->kso_type_id) }}
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="jeniskso">Status KSO</label>
                    <div class="controls">
                      {{ Form::select('actived', $statuskso, $datakso->actived) }}
                    </div> 
                  </div>

              </div>
             
              {{ Form::close() }}
          </div>

        </div>
    </div>

@endsection
@section('otherscript')
<script type="text/javascript">

var rootURL = '{{ URL::base().'/ksos' }}';
  $(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });

        $('#datepicker1').datepicker({
              format: 'yyyy-mm-dd'
          });

        $('.moneys').money_field({width: 170});
  });


</script>
@endsection

