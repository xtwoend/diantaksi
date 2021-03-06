<div class="row-fluid">
    <div class="block span12">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse">Permintaan Sparepart dari WO</a>
        <div id="tablewidget" class="block-body collapse in">

                          <table class="table table-condensed table-hover">
                            <thead>
                              <tr> 
                                  <th class="span1">No. </th>
                                  <th class="span2">Nomor Part </th>
                                  <th class="span3">Nama </th>
                                  <th class="span1">Qty </th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">Harga Satuan </th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">Sub Total </th>
                                  <th class="span3"></th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no =1; $tot = 0;?>
                            @if($partitems)
                              @foreach($partitems as $item)
                              <?php $partdetail = Sparepart::find($item->sparepart_id); ?>
                              <tr id="row_{{ $item->id }}">
                                  <td>{{ $no }}</td>
                                  <td>{{ $partdetail->part_number }}</td>
                                  <td>{{ $partdetail->name_sparepart }}</td>
                                  <td>{{ $item->qty }}</td>
                                  <td style="text-align: right; padding-right:50px;">{{ number_format($item->price, 2, ',', '.') }}</td>
                                  <td style="text-align: right; padding-right:50px;">{{ number_format(($item->price * $item->qty), 2, ',', '.') }}</td>
                                  <td>
                                    @if($item->telah_dikeluarkan == 0)
                                      	<a rel="{{ $item->id }}" class="verifikasi_toggler btn btn-mini btn-info"><i class="icon icon-white icon-ok"></i> Keluarkan Sparepart </a> 
                                    @else
                                    	<button class="btn btn-mini btn-info"><i class="icon icon-white icon-ok"></i> Sudah Keluar</button> 	
                                    @endif
                                    	<a rel="{{ $item->id }}" class="delete_toggler btn btn-mini btn-danger"><i class="icon icon-white icon-remove"></i></a>
                                  </td>
                              </tr>
                              <?php $no++;  $tot = $tot + ($item->price * $item->qty); ?>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="7">Part item is empty.</td>
                              </tr>
                            @endif
                            </tbody>
                            <tfoot style="border-top: double 2px;">
                              <tr> 
                                  <th class="span1"></th>
                                  <th class="span2"></th>
                                  <th class="span3"></th>
                                  <th class="span1"></th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">Grand Total :</th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">{{ number_format($tot, 2, ',', '.') }}</th>
                                  <th class="span1"></th>
                              </tr>
                            </tfoot>
                          </table>
        </div>
    </div>
    
</div>	

<script type="text/javascript">

$('.verifikasi_toggler').each(function(index,elem) {
          $(elem).click(function(){
            var id = $(elem).attr('rel');

            var r=confirm("Part ini akan di keluarkan?" + id)
            if (r==true)
            {
              $.post( rootURL + "/verifikasipartkeluar", { id: id })
                .done(function( data ) {
                  partitem(wo_id_inpart);
                  alert( data );
                });
            }
            
          });
      });

$('.delete_toggler').each(function(index,elem) {
          $(elem).click(function(){
            var id = $(elem).attr('rel');
            
            var r=confirm("Anda yakin akan menghapus item ini?")
            if (r==true)
              {
                $.get( rootURL + '/part_item_remove/' + id + '/' + wo_id_inpart);
                $("#row_" + id).remove();
              }
            
          });
      });

</script>