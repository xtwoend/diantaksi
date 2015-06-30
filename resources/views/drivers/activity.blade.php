@extends('main')

@section('content')
<section id="content">
	<section class="vbox" id="bjax-el">
		<section class="scrollable wrapper">
			<div class="table-responsive">
	            <table class="table table-striped b-t b-light">
					<thead>
						<tr>
							<th>NIP</th>
							<th>NAMA</th>
							<th>BULAN</th>
							<th>JUMLAH AKTIFITAS</th>
						</tr>
					</thead>
					<tbody>
						@foreach($checkins as $checkin)
						<tr>
							<td>{{ ($checkin->driver) ? $checkin->driver->nip : 'N/A' }}</td>
							<td>{{ ($checkin->driver) ? $checkin->driver->name : 'N/A' }}</td>
							<td>{{ $checkin->mountname }}</td>
							<td>{{ $checkin->activity }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</section>
</section>
@endsection

@section('js')

@endsection
