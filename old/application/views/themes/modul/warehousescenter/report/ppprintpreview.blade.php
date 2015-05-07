@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Cetak Permintaan Pembelian Sparepart</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">cetak permintaan sparepart</li>
    </ul>
@endsection
@section('content')
	<p>&nbsp;</p>
	<div class="pull-right"><button class="btn" id="print"><i class="icon-print"></i> Print </button></div>

<div class="printhere">
	<div class="row-fluid underlinedb">
		<div class="span8">
			<div class="row-fluid">
				<div class="span3">Pemohon </div>
				<div class="span5">: {{ User::find($pp->user_id)->fullname }} </div>						
			</div><!-- /.row -->
			<div class="row-fluid">
				<div class="span3">Pool </div>
				<div class="span5">:  {{ Pool::find($pp->pool_id)->pool_name }} </div>						
			</div><!-- /.row -->
			<div class="row-fluid">
				<div class="span3">Kepada </div>
				<div class="span5">: {{ Supplier::find($pp->supplier_id)->company_name }}</div>						
			</div><!-- /.row -->

			<div class="row-fluid">
				<div class="span3">Nomor PP</div>
				<div class="span5">: {{ $pp->no_doc }}</div>						
			</div><!-- /.row -->
			<div class="row-fluid">
				<div class="span3">Tanggal Pemesanan</div>
				<div class="span5">: {{ myFungsi::fulldate(strtotime($pp->tanggal_order)) }}</div>						
			</div><!-- /.row -->
		</div>
		<div class="span4">
			Catatan: {{ $pp->catatan }}
		</div>
	</div>
		
		<div class="block" id="formspk">
	        <div class="block-body collapse in">
				<table class="table table-condensed table-striped">
	         	<thead>
	         		<tr>
	         			<th class="span1">No.</th>
	         			<th>Nomor Part</th>
	         			<th>Nama Part</th>
	                	<th style="text-align: center;">Qty</th>
	                	<th>Satuan</th>
	         			<th>Keterangan</th>
	         			
	         		</tr>
	         	</thead>
		        <tbody>
		        <?php $no =1; ?>
		        @foreach($ppitems as $item)
		        	<tr>
		        		<td>{{ $no }}</td>
		        		<td>{{ $item->part_number }}</td>
		        		<td>{{ $item->name_sparepart }}</td>
		        		<td style="text-align: center;">{{ $item->qty }}</td>
		        		<td>{{ $item->satuan }}</td>
		        		<td>{{ $item->ket }}</td>
		        		
		        	</tr>
		        <?php $no++ ?>
		        @endforeach
		        </tbody>
				</table>
			</div>
		</div>
</div>
@endsection

@section('otherscript')
<script type="text/javascript">
	$('#print').click(function(){
		$(".printhere").printElement({printMode:'popup'});
	});
</script>
@endsection