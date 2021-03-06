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
    <p>
      <input type="hidden" id="month" value="{{ $month }}">
      <input type="hidden" id="year" value="{{ $year }}">
      <input type="hidden" id="fleet_id" value="{{ $schm->fleet_id }}">
      <input type="hidden" id="schedule_date_id" value="{{ $schd->id }}">
      <label class="radio"><input type="radio" class="radioBtnClass" name="driver" value="{{$bravo->id}}" {{ ($schd->driver_id == $bravo->id ) ? 'checked' : '' }}>( {{ $bravo->nip }} ) {{ $bravo->name }} -- Bravo</label>
      @if($charlie)
      <label class="radio"><input type="radio" class="radioBtnClass" name="driver" value="{{$charlie->id}}" {{ ($schd->driver_id == $charlie->id ) ? 'checked' : '' }}>( {{ $charlie->nip }} ) {{ $charlie->name }} -- Charlie</label>
      @endif
      
    </p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="changeSave">Save changes</button>
  </div>
</div>

<script type="text/javascript">
var rootURL = '{{ URL::base().'/schedule' }}';

$(function () {
   $('#ChangeDriver').modal('show');
});

$('#changeSave').click(function() {
          ChangeSaved()
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
                var month = $('#month').val();
                var year = $('#year').val();
                var fleet_id = $('#fleet_id').val();
                $("#listschedule").load( rootURL + '/viewschedule/' + month + '/' + year + '/' + fleet_id ); 
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
</script>