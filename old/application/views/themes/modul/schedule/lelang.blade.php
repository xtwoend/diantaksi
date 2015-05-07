<div id="LelangMode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Ubah Jadwal Armada XXX Untuk Tanggal XXX </h3>
  </div>
  <div class="modal-body">
   
    <p>
      
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
   $('#LelangMode').modal('show');
});

</script>