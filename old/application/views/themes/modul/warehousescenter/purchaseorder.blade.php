@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Daftar Permintaan Pembelian Barang</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">PP List</li>
    </ul>
@endsection

@section('content')
	
	<div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
                {{ HTML::link('warehousescenter/pp','Buat PP') }}
            </span>
            <a>Daftar Permintaan Pembelian Barang</a>
        </div>
        <div class="block-body">
        	<table class="table table-condensed">
 				<thead>
 					<tr>
 						<th>Nomor PP</th>
 						<th>Tanggal Permintaan</th>
                        <th>Tanggal Jatuh Tempo</th>
 						<th>Catatan</th>
 						<th>Status</th>
                        <th></th>
 					</tr>
 				</thead>
 				<tbody>
 					@foreach($pplists->results as $pp)
 					<tr>
 						<td>{{ $pp->no_doc }}</td>
 						<td>{{ $pp->tanggal_order }}</td>
                        <td>{{ $pp->tanggal_terima }}</td>
 						<td>{{ $pp->catatan }}</td>
 						<td>{{ $pp->status }}</td>
                        <td><a class="btn btn-success btn-mini" href="{{ URL::to('warehousescenter/editpp/'.$pp->id) }}"><i class="icon-edit icon-white"></i></a>  </td>
 					</tr>
 					@endforeach
 				</tbody>
			</table>
			{{ $pplists->links() }}
        </div>
    </div>
   	  

@endsection