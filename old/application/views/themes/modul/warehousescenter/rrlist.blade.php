@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Daftar Penerimaan Barang</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">RR List</li>
    </ul>
@endsection

@section('content')
	
	<div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
                {{ HTML::link('warehousescenter/ps','Buat Penerimaan Sparepart') }}
            </span>
            <a>Daftar Penerimaan Barang</a>
        </div>
        <div class="block-body">
        	<table class="table table-condensed">
 				<thead>
 					<tr>
 						<th>Nomor RR</th>
 						<th>Tanggal Penerimaan</th>
                        <th>Dari</th>
 						<th>Catatan</th>
 						<th>Status</th>
                        <th></th>
 					</tr>
 				</thead>
 				<tbody>
 					@foreach($rrlists->results as $rr)
 					<tr>
 						<td>{{ $rr->no_doc }}</td>
 						<td>{{ $rr->tanggal_terima }}</td>
                        <td>{{ $rr->supplier_id }}</td>
 						<td>{{ $rr->catatan }}</td>
 						<td>{{ $rr->status }}</td>
                        <td><a class="btn btn-success btn-mini" href="{{ URL::to('warehousescenter/editpp/'.$rr->id) }}"><i class="icon-edit icon-white"></i></a>  </td>
 					</tr>
 					@endforeach
 				</tbody>
			</table>
			{{ $rrlists->links() }}
        </div>
    </div>
   	  

@endsection