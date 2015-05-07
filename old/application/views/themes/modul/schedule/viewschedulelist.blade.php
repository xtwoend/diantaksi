<div class="block">
       	<div class="block-heading">
       		<span class="block-icon pull-right">
       			<button class="btn btn-info" id="exportpdf">Cetak Jadwal Harian <i class="icon-print icon-white"></i></button>
            </span>
            <a href="#widgetGroup" data-toggle="collapse">Jadwal Operasi Tanggal  {{ $tanggal }}</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup">
            <table class="table table-striped table-condensed">
				<thead>
					<tr>
						<th>No.</th>
						<th>No. Body</th>
						<th>No. NIP</th>
						<th>Nama Pengemudi</th>
						<th>Waktu Operasi</th>
						<th>Status Operasi</th>
					</tr>
				</thead>
				<tbody>
				<?php $i = 1; ?>
				@forelse($scheduleday as $sch)
					<tr>
						<td>{{ $i }}</td>
						<td>{{ $sch->taxi_number; }}</td>
						<td>{{ ($driver = Driver::find($sch->driver_id))? $driver->nip : ' ' }}</td>
						<td><a class="change_toggler" rel="{{$sch->id}}">{{ ($driver)? $driver->name: 'pengemudi terdelete'; }}</a></td>
						<td><?php $shift = Shift::find($sch->shift_id);  ?> @if($shift) {{ $shift->shift }} @endif</td>
						<td>{{ ($sch->fg_check == 1) ? 'Sudah Print SPJ' : 'Belum Print SPJ' ; }}</td>
					</tr>
				<?php $i++;  ?>
				@empty
					<tr>
						<td colspan="5"> is empty</td>
					</tr>
				@endforelse
				</tbody>
			</table>
        </div>
    </div>          

<!-- Button to trigger modal -->
<div id="editschedule"></div>

<script>
var rootURL = '{{ URL::base().'/schedule' }}';
	
	$('#exportpdf').click(function() {
		$.get(rootURL + '/ExportJhoHarianPdf/{{ $date }}');
          //window.open( rootURL + '/ExportJhoHarianPdf/{{ $date }}' , "Export JHO Harian", "menubar=0,location=0,height=600,width=500" );
          return false;
      });

      // Populate the field with the right data for the modal when clicked
      $('.change_toggler').each(function(index,elem) {
          $(elem).click(function(){
            //$('#postvalue').attr('value',$(elem).attr('rel'));
            //$('#change_driver').modal('show');
            $('#editschedule').load(rootURL + '/editschedule/' + $(elem).attr('rel'));

          });
      });

</script>

