<?php

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="daftarksoactive.xls"');
header('Cache-Control: max-age=0');

?>


<table>
	<tr>
		<th>No</th>
		<th>Body</th>
		<th>Tanggal KSO</th>
		<th>Tanggal Selesai KSO</th>
		<th>Nip</th>
		<th>Bravo</th>
		<th>Tanggal Lahir</th>		
		<th>Alamat</th>
		<th>Kelurahan</th>
		<th>Kecamatan</th>
		<th>Kota</th>
		<th>No Telp</th>
	</tr>

	<?php $no=1; ?>
	@foreach($ksos as $kso)
	<tr>
		<td>{{ $no++ }}</td>
		<td>{{ $kso->taxi_number }}</td>
		<td>{{ $kso->ops_start}}</td>
		<td>{{ $kso->ops_end}}</td>
		<td>{{ $kso->nip }}</td>	
		<td>{{ $kso->name }}</td>
		<td>{{ $kso->date_of_birth }}</td>
		<td>{{ $kso->address }}</td>
		<td>{{ $kso->kelurahan }}</td>
		<td>{{ $kso->kecamatan }}</td>
		<td>{{ $kso->kota }}</td>
		<td>{{ $kso->phone }}</td>
	</tr>
	@endforeach
</table>