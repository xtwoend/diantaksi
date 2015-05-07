<!DOCTYPE html>
<head>
<style type="text/css">
/*yang ini buat setting ukuran kertasnya assumsi KECIL */
#KERTASSEDANG {
	background-color:#FFFFFF;
	left:0px;
	right:0px;
	height:3.80in ; /*Ukuran Panjang Kertas */
	width: 5.30in; /*Ukuran Lebar Kertas */
	margin:1px solid #FFFFFF;
	border: 1px solid #000;
	font-size: .8em;
	font-family:Tahoma, Geneva, sans-serif;
	position: fixed;
}
#content {
	padding: 10px 10px 10px 10px;
}
h1 {
	font-size: 1.4em;
}
</style>
</head>
<body>
<?php 
	$driver = Driver::find($wo->driver_id);
	$fleet = Fleet::find($wo->fleet_id);
?>
<div id="KERTASSEDANG">
	<div id="content">
<table cellspacing="0" cellpadding="0" width="100%">
			  <tr>
			    <td colspan="4" align="center">BUKTI KELUAR BARANG</td>
			  </tr>
			  <tr>
			    <td colspan="4" align="center">PT. DHARMA INDAH AGUNG METROPOLITAN</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td colspan="2">No WO</td>
			    <td colspan="2">: {{ $wo->wo_number }}</td>
			  </tr>
			  <tr>
			    <td>NIP</td>
			    <td>: 
			    	@if($driver) 
			    		{{ $driver->nip }}
			    	@endif
			    </td>
			    <td>NO PINTU</td>
			    <td>: 
			    	@if($fleet) 
			    		{{ $fleet->taxi_number }}
			    	@endif
			    </td>
			  </tr>
			  <tr>
			    <td>NAMA</td>
			    <td>:
			    	@if($driver) 
			    		{{ $driver->name }}
			    	@endif
			    </td>
			    <td>POOL</td>
			    <td>: </td>
			  </tr>
			  <tr>
			    <td>TANGGAL</td>
			    <td>: {{ $wo->inserted_date_set }}</td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			</table>

	<table class="table table-condensed table-hover">
                            <thead>
                              <tr> 
                                  <th class="span1">No. </th>
                                  <th class="span2">Nomor Part </th>
                                  <th class="span3">Nama </th>
                                  <th class="span1">Qty </th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">Harga Satuan </th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">Sub Total </th>
                                  <th class="span1"></th>
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
                                  <td><a rel="{{ $item->id }}" class="delete_toggler btn btn-mini btn-danger"><i class="icon icon-white icon-remove"></i></a></td>
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
</body>
</html>