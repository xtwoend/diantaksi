@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Laporan Rekap Setoran Armada Bulanan</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Laporan Rekap Setoran Armada Bulanan</a></li>
    </ul>
@endsection
  
  
@section('content')
	<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Rekap Setoran Armada Bulanan </a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br> 
              {{ Form::open('reportops/expreportsetoran', 'POST' ,array('class'=>'form-horizontal'))}}
              <div class="row-fluid">
                <div class="span6">

                  <div class="control-group">
                    <label class="control-label" for="inputEmail">Periode</label>
                    <div class="controls">
                      <div class="input-append date" id="dpMonths" data-date="{{ date('m/Y') }}" data-date-format="mm/yyyy" data-date-viewmode="months" data-date-minviewmode="months">
                        <input class="span10" name="date" type="text" value="{{ date('m/Y') }}">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="inputEmail">Shift</label>
                    <div class="controls">
                        {{ Form::select('shift_id', $shifts, 1, array('id'=>'shift_id')); }}
                    </div>
                  </div>
          
                  <div class="control-group">
                    <label class="control-label" for="inputEmail"></label>
                    <div class="controls">
                        <label class="checkbox">
                          <input type="checkbox" name="allbody" value="1">
                          Semua Body
                        </label>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="inputEmail"></label>
                    <div class="controls">
                      <button class="btn btn-info" type="submit" id="downloadReport"><i class="icon-download"></i> Download Report Excel</button>
                    </div>
                  </div>
                </div>
              
                <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="x">Pilih Body Untuk di Print</label>
                    <div class="controls">
                      <select multiple="multiple" name="bodylist[]" class="span12" style='height: 300px;'>
                      @foreach($fleets as $fleet)
                        <option value="{{ $fleet->id }}">{{ $fleet->taxi_number }}</option>
                      @endforeach
                      </select>
                      * Tekan Shift Untuk Memilih Lebih Dari Satu
                    </div>
                </div>
                </div>
              </div>
              {{ Form::close() }}
        </div>
	</div>

  <div>
      
  </div>

 @endsection

@section('otherscript')
<script type="text/javascript">
	$(function () {
        $('#dpMonths').datepicker({
            format: 'mm/yyyy',
        }); 
  });	
</script>

@endsection
