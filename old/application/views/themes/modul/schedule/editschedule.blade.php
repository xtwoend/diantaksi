<?php
  $bravo = Driver::find($bckso->bravo_driver_id);
  $charlie = Driver::find($bckso->charlie_driver_id);
?>

<div id="ChangeDriver" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Ubah Jadwal Armada {{ Fleet::find($schm->fleet_id)->taxi_number }} Untuk Tanggal {{ $date }} </h3>
  </div>
  <div class="modal-body">
<p> Pilih Pengemudi yang di inginkan atau pilih lelang untuk melelang armada :</p>
  <div class="tabbable">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab1" data-toggle="tab">Change</a></li>
      <li><a href="#tab2" data-toggle="tab">Lelang</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab1">
        <p>
          <input type="hidden" id="tanggal" value="{{ $tanggal }}">
          <input type="hidden" id="schedule_date_id" value="{{ $schd->id }}">
          <label class="radio"><input type="radio" class="radioBtnClass" name="driver" value="{{$bravo->id}}" {{ ($schd->driver_id == $bravo->id ) ? 'checked' : '' }}>( {{ $bravo->nip }} ) {{ $bravo->name }} -- Bravo</label>
          @if($charlie)
          <label class="radio"><input type="radio" class="radioBtnClass" name="driver" value="{{$charlie->id}}" {{ ($schd->driver_id == $charlie->id ) ? 'checked' : '' }}>( {{ $charlie->nip }} ) {{ $charlie->name }} -- Charlie</label>
          @endif
        </p>
        <button class="btn btn-primary pull-right" id="changeSave">Save changes</button>
      </div>
      <div class="tab-pane" id="tab2">
        <p>
          NIP : <input type="text" id="driverlelang" name="driverlelang" autocomplete="off" required >
          <div id="driverinfo"></div>
          <input type="hidden" id="driver_i"> 
          <button class="btn btn-primary pull-right" id="lelangsave">Lelang Save</button>
        </p>
      </div>
    </div>
  </div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<div id="lelang"></div>

<script type="text/javascript">
var rootURL = '{{ URL::base().'/schedule' }}';

$('#driverlelang').typeahead({
    source: 
                    function (query, process) {
                        $.getJSON( rootURL + '/getDriver' , { query: query }, function(json) {    
                              objects = [];
                              map = {};
                              $.each(json, function(i, object){
                                map[object.nip] = object;
                                objects.push(object.nip);
                              });
                              process(objects);
                        });
                    },
    updater: function(item){
                      $('#driver_i').val(map[item].id);
                      $( "#driverinfo" ).html(" [ " + map[item].nip + " , "+ map[item].name +" ] ");
                      return item; 
                    },
    highlighter: function (item) {
                      var name = map[item].name;
                      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
                      var value = item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
                        return '<strong>' + match + '</strong>'
                      });
                      return value + '  ( ' + name + ' )' ;
                    },
    minLength: 2
});

$(function () {
   $('#ChangeDriver').modal('show');
   $('#myTab a:last').tab('show');
});

$('#changeSave').click(function() {
          ChangeSaved()
          return false;
});
$('#lelangsave').click(function(e) {
          if($('#driver_i').val() === '') 
          { 
            alert('pilih pengemudi terlebih dahulu');
            return false;
          }else{
            lelangSaved();    
          }
          return false;
});
function ChangeSaved() {
  
  console.log('ChangeSaved');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/changeSave',
            dataType: "json",
            data: changedataToJSON(),
            success: function(data, textStatus, jqXHR){
                $('#ChangeDriver').modal('hide');
                alert('penggantian berhasil');
                var dateview = $('#tanggal').val();
                $("#listschedule").load( rootURL + '/scheduleview/' + dateview ); 
            },
            error: function(jqXHR, textStatus, errorThrown){
               
            }
        });

  $('#ChangeDriver').modal('hide');
}

function lelangSaved () {
    console.log('ChangeSaved');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/lelangSave',
            dataType: "json",
            data: lelangdataToJSON(),
            success: function(data, textStatus, jqXHR){
                $('#ChangeDriver').modal('hide');
                alert('penggantian berhasil');
                var dateview = $('#tanggal').val();
                $("#listschedule").load( rootURL + '/scheduleview/' + dateview ); 
            },
            error: function(jqXHR, textStatus, errorThrown){
               
            }
        });

  $('#ChangeDriver').modal('hide');
}
function changedataToJSON()
{
   return JSON.stringify({
          "schedule_date_id": $('#schedule_date_id').val(), 
          "driver": $('input:radio[name=driver]:checked').val(),
          });
}

function lelangdataToJSON()
{
   return JSON.stringify({
          "schedule_date_id": $('#schedule_date_id').val(), 
          "driver": $('#driver_i').val(),
          });
}
</script>