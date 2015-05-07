<div class="modal hide fade" id="otorisasi_proses">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Catatan Otorisasi Open Block</h3>
      </div>
      {{ Form::open('proses/openpusat', 'POST', array('class'=>'form-horizontal')) }}
      <div class="modal-body">
               
        <div class="control-group">
          <label class="control-label" for="NIP">NIP</label>
          <div class="controls">:
                {{ $driver->nip }}
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="name">Nama Pengemudi</label>
          <div class="controls">:
             {{ $driver->name }}
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="name">Nomor BAP Pengemudi</label>
          <div class="controls">:
            {{ Form::text('bap_number', '' ) }}
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="barcode">Catatan Open Block</label>
          <div class="controls">:
            {{ Form::textarea('catatan', '' ) }}
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="pay">Besar Uang</label>
          <div class="controls">:
              {{ Form::text('pay', '' ,array('class'=>'money')) }}
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <a data-dismiss="modal" class="btn">Cancel</a>
        {{ Form::hidden('id',$driver->id) }}
        <input type="submit" class="btn btn-warning" value="Open Block" />
      </div>
       {{ Form::close() }}
</div>


<script type="text/javascript">

$(function () {
  $('.money').money_field({width: 120});
   $('#otorisasi_proses').modal('show');
});

</script>