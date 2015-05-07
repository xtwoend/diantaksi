                          <table class="table table-condensed table-hover">
                            <thead>
                              <tr> 
                                  <th class="span1">No. </th>
                                  <th class="span3">Nomor Part </th>
                                  <th class="span3">Nama </th>
                                  <th class="span1">Qty </th>
                                  <th class="span1"></th>
                              </tr>
                            </thead>
                            <tbody>
                              
                            @if($partitems)
                              <?php $no =1; ?>
                              @foreach($partitems as $item)
                              <?php $partdetail = Sparepart::find($item->sparepart_id); ?>
                              <tr id="partrow_{{ $item->id }}">
                                  <td>{{ $no }}</td>
                                  <td>{{ $partdetail->part_number }}</td>
                                  <td>{{ $partdetail->name_sparepart }}</td>
                                  <td>{{ $item->qty }}</td>
                                  <td><a rel="{{ $item->id }}" class="delete_part btn btn-mini btn-danger"><i class="icon icon-white icon-remove"></i></a></td>
                              </tr>
                              <?php $no++ ?>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="5">Part item is empty.</td>
                              </tr>
                            @endif
                            </tbody>
                          </table>
<script type="text/javascript">
var wo_id_inpart = '{{ $wo_id_initem }}';
 $('.delete_part').each(function(index,elem) {
          $(elem).click(function(){
            var id = $(elem).attr('rel');
            
            var r=confirm("Anda yakin akan menghapus item ini?")
            if (r==true)
              {
                $.get( rootURL + '/part_item_remove/' + id + '/' + wo_id_inpart);
                $("#partrow_" + id).remove();
              }
            
          });
      });
</script>