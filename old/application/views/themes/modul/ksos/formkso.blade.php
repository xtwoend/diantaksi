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
            
              {{ Form::open('ksos/savekso','POST',array('class'=>'form-horizontal')) }}
              <div class="span6">

                   <div class="control-group">
                    <label class="control-label" for="pool">Pool</label>
                    <div class="controls">
                      {{ Form::select('pool_id', $pools,'',array('id'=>'pool_id')) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="body">Nomor Body</label>
                    <div class="controls">
                      <select id="fleet_id" name="fleet_id">

                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="name">Bravo</label>
                    <div class="controls">
                      <select id="bravo_driver_id" name="bravo_driver_id">

                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="inputtext">Charlie</label>
                    <div class="controls">
                      <select id="charlie_driver_id" name="charlie_driver_id">

                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="date">Tanggal Mulai Operasi</label>
                    <div class="controls">
                      <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="ops_start" id="ops_start" class="input-small" id="ops_start" type="text" value="{{ date('Y-m-d') }}">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>

                   <div class="control-group">
                    <label class="control-label" for="date">Tanggal Akhir Operasi</label>
                    <div class="controls">
                      <div class="input-append date" id="datepicker1" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="ops_end" id="ops_end" class="input-small" id="ops_end" type="text" value="{{ date('Y-m-d') }}">
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
                      <input type="text" id="ksoNumber" name="kso_number" placeholder="No Perjanjian">
                    </div>
                  </div>

                  
                  <div class="control-group">
                    <label class="control-label" for="dp">Uang Muka (DP)</label>
                    <div class="controls">
                      <input type="text" id="dp" name="dp" class="moneys" placeholder="dalam rupiah">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="sisa_dp">Sisa Uang Muka (DP)</label>
                    <div class="controls">
                      <input type="text" id="sisa_dp" name="sisa_dp" class="moneys" placeholder="dalam rupiah">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="setoran">Uang Setoran</label>
                    <div class="controls">
                      <input type="text" id="setoran" name="setoran" class="moneys" placeholder="dalam rupiah">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="tab_sparepart">Tabungan Spareprt</label>
                    <div class="controls">
                      <input type="text" id="tab_sparepart" name="tab_sparepart" class="moneys" placeholder="dalam rupiah">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="tab_sparepart">Jenis KSO</label>
                    <div class="controls">
                      {{ Form::select('kso_type_id', $kso_types,'') }}
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

generadeNumberKso();
  $(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });

        $('#datepicker1').datepicker({
              format: 'yyyy-mm-dd'
          });

        $('.moneys').money_field({width: 170});
  });
function generadeNumberKso(){
    console.log('findAll');
        $.ajax({
          type: 'GET',
          url: rootURL + '/lastNumber',
          dataType: "json", // data type of response
          success: function(data){
            $('#ksoNumber').val(data.number);
            //alert(data.number);
          }
        });
  }

var option = $('<option></option>').attr("value", "option value").text("Text");

$("#fleet_id").empty().append(option);
$("#bravo_driver_id").empty().append(option);
$("#charlie_driver_id").empty().append(option);

var optionFleet;
var optionDriver;

  
$("#pool_id").change(function () {
    var pool_id = this.value;
    getFleet(pool_id);
    getDriver(pool_id);
})
.change();

function getFleet(pool_id)
{
     $.ajax({
          type: 'GET',
          url: rootURL + '/getFleet/'+ pool_id,
          dataType: "json", // data type of response
          success: function(data){
            var $el = $("#fleet_id");
            $el.empty(); // remove old options
            $.each(data, function(key, value) {
              $el.append($("<option></option>")
                 .attr("value", value).text(key));
            });
            //alert(data.number);
          }
        });
}

function getDriver(pool_id)
{
     $.ajax({
          type: 'GET',
          url: rootURL + '/getDriver/'+ pool_id,
          dataType: "json", // data type of response
          success: function(data){
            var $el = $("#bravo_driver_id");
            var $es = $("#charlie_driver_id");
            $el.empty(); // remove old options
            $es.empty(); // remove old options
            $.each(data, function(key, value) {
              $el.append($("<option></option>")
                 .attr("value", value).text(key));
              $es.append($("<option></option>")
                 .attr("value", value).text(key));
            });
            //alert(data.number);
          }
        });
}

</script>
@endsection

