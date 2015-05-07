<div class="modal hide fade" id="formkpps">
      <div class="modal-body">
        <p>
        	&nbsp;
        </p>
      </div>
      <div class="modal-footer">

        <a data-toggle="modal" href="#formkpps" class="btn">Batal</a>
        <button class="btn btn-danger" id="cetak">Cetak </button> 

      </div>
</div>
<script type="text/javascript">

$(function () {
   $('#formkpps').modal('show');
});

$('#cetak').click(function() {
	alert('Test ');      
	return false;
});
</script>