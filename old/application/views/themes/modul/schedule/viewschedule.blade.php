<table class="table table-bordered table-striped table-condensed"><thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Nama</th>
                   </tr>
               </thead>
@foreach(Scheduledate::where('schedule_id', '=', $schedule->id)->get() as $scheduledate )
	 <tr>
                   
                    <td>{{ $scheduledate->date }} - {{ Myfungsi::bulan($schedule->month) }} - {{ $schedule->year }}</td>
                    <td>{{ Shift::find($scheduledate->shift_id)->shift }}</td>
                    <td>
                      <a class="change_toggler" rel="{{$scheduledate->id}}">{{  Driver::find( $scheduledate->driver_id )->name }}</a>
                    </td>
                  </tr>

@endforeach

</table>

<!-- Button to trigger modal -->
<div id="editschedule"></div>


<script>
var rootURL = '{{ URL::base().'/schedule' }}';

      // Populate the field with the right data for the modal when clicked
      $('.change_toggler').each(function(index,elem) {
          $(elem).click(function(){
            //$('#postvalue').attr('value',$(elem).attr('rel'));
            //$('#change_driver').modal('show');
            $('#editschedule').load(rootURL + '/editscheduleonmaster/' + $(elem).attr('rel'));

          });
      });

</script>

