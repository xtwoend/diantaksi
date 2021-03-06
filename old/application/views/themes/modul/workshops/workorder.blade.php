@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Pembuatan Surat Perintah Kerja ( SPK )</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('workshops')}}">workshops</a> <span class="divider">/</span></li>
        <li class="active">buat spk</a></li>
    </ul>
@endsection
  
  
@section('content')

<div class="block" id="formspk">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-info" id="btnSave" tabindex="8">Buat SPK <i class="icon-hdd"></i></button>
            </span>
            <a href="#widget-info" data-toggle="collapse">Form SPK</a>
        </div>
        <div class="block-body collapse in" id="widget-info">
          <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            <form class="form-horizontal">
              <div class="span6">
                
                  <div class="control-group">
                    <label class="control-label" for="body">Nomor Body</label>
                    <div class="controls">
                      <input type="hidden" id="ksoID"><input type="hidden" id="fleetID"><input type="text" id="body" placeholder="Ketikan No body di sini">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="name">Nama Bravo</label>
                    <div class="controls">
                      <input type="hidden" id="driver_id"> <input type="text" id="name" placeholder="bravo..." readonly>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="inputtext">NIP </label>
                    <div class="controls">
                      <input type="text" id="nip" placeholder="nip..." readonly>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Pool</label>
                    <div class="controls">
                      <input type="hidden" id="pool_id"><input type="text" id="pool" placeholder="pool..." readonly>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="kmMasuk">Di Bebankan pada</label>
                    <div class="controls">
                      <div class="btn-group" data-toggle="buttons-radio">
                        <button type="button" name="beban" id="bebanbody" value="0" class="btn btn-primary">Body</button>
                        <button type="button" name="beban" id="bebanperusahaan" value="1" class="btn btn-primary">Perusahaan</button>
                      </div>
                    </div>
                  </div>
              
              </div>
              <div class="span6">
                  <div class="control-group">
                    <label class="control-label" for="woNumber">Nomor SPK</label>
                    <div class="controls">
                      <input type="text" id="woNumber" placeholder="No SPK" readonly>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="date">Tanggal</label>
                    <div class="controls">
                      <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="date" id="date" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="jam">Jam</label>
                    <div class="controls">
                      <div class="input-append bootstrap-timepicker-component">
                          <input name="jam" type="text" id="jam" class="timepicker input-small" value="{{ date('H:i:s') }}">
                          <span class="add-on">
                              <i class="icon-time"></i>
                          </span>
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="kmMasuk">KM Masuk</label>
                    <div class="controls">
                      <input type="text" id="kmMasuk" placeholder="km masuk...">
                    </div>
                  </div>

              </div>
             
               </form>
          </div>  <!-- end pembagian kolom -->
            <div class="row-fluid">
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keluhan Kerusakan</a>
                        </div>
                        <div class="block-body">
                         <textarea rows="10" style="width:97%;" id="complaint"></textarea>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keterangan</a>
                        </div>
                        <div class="block-body">
                         <textarea rows="10" style="width:97%;" id="information_complaint"></textarea>
                        </div>
                    </div>
                </div>
            </div>
          <br>
        </div>
      </div>
</div>

<div id="woPreview"></div>

@endsection

@section('otherscript')
<script type="text/javascript">
  
  var rootURL = '{{ URL::base().'/workshops' }}';

  generadeNumberSpk();
  $(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });

        $('.timepicker').timepicker({
          showMeridian: false,
          showSeconds: true
        });
        
        $('#bebanbody').button('toggle');

        $('#body').typeahead({
                             
                source: 
                    function (query, process) {
                        $.getJSON( rootURL + "/allFleet", { query: query }, function(json) {    
                              objects = [];
                              map = {};
                              $.each(json, function(i, object){
                                map[object.taxi_number] = object;
                                objects.push(object.taxi_number);
                              });
                              process(objects);
                        });
                    },
                    updater: function(item){
                      $('#ksoID').val(map[item].kso_id);
                      $('#fleetID').val(map[item].id);
                      $('#driver_id').val(map[item].driver_id);
                      $('#pool_id').val(map[item].pool_id);
                      $('#pool').val(map[item].pool_name);
                      $('#name').val(map[item].name);
                      $('#nip').val(map[item].nip);
                      //alert('Your Selected ID' + map[item].id );
                      return item; 
                    }, 
                    highlighter: function (item) {
                      var desc = map[item].police_number;
                      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
                      var value = item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
                        return '<strong>' + match + '</strong>'
                      });
                      return value + '  ( ' + desc + ' )' ;
                    },
                   
                    minLength: 2
            });
  });
  
  $('#btnSave').click(function() {
      if($('#fleetID').val() == '')
      { alert('Nomor Body Tidak ditemukan'); }
      else { saveSPK(); }
      return false;
  });

  function generadeNumberSpk(){
    console.log('findAll');
        $.ajax({
          type: 'GET',
          url: rootURL + '/lastNumber',
          dataType: "json", // data type of response
          success: function(data){
            $('#woNumber').val(data.number);
            //alert(data.number);
          }
        });
  }

  function saveSPK()
  {     var beban = $('button[name="beban"].active').val();
        var dataJSON = JSON.stringify({
          "kso_id": $('#ksoID').val(),
          "fleet_id": $('#fleetID').val(),
          "driver_id": $('#driver_id').val(),
          "wo_number": $('#woNumber').val(),
          "km": $('#kmMasuk').val(),
          "pool_id": $('#pool_id').val(),
          "complaint": $('#complaint').val(),
          "information_complaint": $('#information_complaint').val(),
          "date": $('#date').val() + ' ' + $('#jam').val(),
          "beban": beban,
          });

        console.log('simapan spk number: ' + $('#woNumber').val());
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/saveWo',
          dataType: "json",
          data: dataJSON,
          success: function(data){
              $('#formspk').html('');
              $("#woPreview").load( rootURL + '/woPreview/' + data.id );
          },
          error: function(jqXHR, textStatus, errorThrown){
               alert(textStatus);
          } 
        });
  }
</script>
  
@endsection