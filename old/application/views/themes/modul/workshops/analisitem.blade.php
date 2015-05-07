                          <table class="table table-condensed table-hover">
                            <thead>
                              <tr> 
                                  <th class="span1">No. </th>
                                  <th class="span3">Analisa Benkel</th>
                                  <th class="span1"></th>
                              </tr>
                            </thead>
                            <tbody>
                              
                            @if($analisitems)
                              <?php $no =1; ?>
                              @foreach($analisitems as $item)
                              <tr id="analisrow_{{ $item->id }}">
                                  <td>{{ $no }}</td>
                                  <td>{{ $item->analisa }}</td>
                                  <td><a rel="{{ $item->id }}" class="delete_analis btn btn-mini btn-danger"><i class="icon icon-white icon-remove"></i></a></td>
                              </tr>
                              <?php $no++ ?>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="5">data item is empty.</td>
                              </tr>
                            @endif
                            </tbody>
                          </table>
<script type="text/javascript">
var wo_id_inpart = '{{ $wo_id_initem }}';
 $('.delete_analis').each(function(index,elem) {
          $(elem).click(function(){
            var id = $(elem).attr('rel');
            
            var r=confirm("Anda yakin akan menghapus item ini?")
            if (r==true)
              {
                $.get( rootURL + '/analisa_item_remove/' + id + '/' + wo_id_inpart);
                $("#analisrow_" + id).remove();
              }
            
          });
      });
</script>