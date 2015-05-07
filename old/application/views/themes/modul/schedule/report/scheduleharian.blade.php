<?php

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="setoran.xls"');
header('Cache-Control: max-age=0');

?>
<page backcolor="#FEFEFE" footer="date;heure;page" style="font-size: 12pt">

    <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 1px #000000; font-size: 11pt; ">
                    <tr>
                        <th style="width: 100%; text-align: center; border: solid 1px #000000;" >
                           Jadwal Harian Operasi
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 100%; text-align: center; border: solid 1px #000000;">
                            PT Dharama Indah Agung Metropolitan
                        </th>
                    </tr>
    </table>
    <br>
    <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 1px #000000; font-size: 11pt; ">
                    <tr>
                        <th style="width: 5%; border: solid 1px #000000;">No. </th>
                        <th style="width: 15%; border: solid 1px #000000;">No. Body</th>
                        <th style="width: 20%; border: solid 1px #000000;">Nip </th>
                        <th style="width: 30%; border: solid 1px #000000;">Nama</th>
                        <th style="width: 30%; border: solid 1px #000000;">Status Operasi</th>
                    </tr>
				<?php $i = 1; ?>
				@forelse($scheduleday as $sch)
                    <tr>
                        <td style="width: 5%; border: solid 1px #000000;">{{ $i }}</td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: left;">{{ Fleet::find($sch->fleet_id)->taxi_number; }}</td>
                        <td style="width: 20%; border: solid 1px #000000;">{{ Driver::find($sch->driver_id)->nip; }}</td>
                        <td style="width: 30%; border: solid 1px #000000;">{{ Driver::find($sch->driver_id)->name; }}</td>
                        <td style="width: 30%; border: solid 1px #000000;">{{ ($sch->fg_check == 1) ? 'Sudah Print SPJ' : 'Belum Print SPJ' ; }}</td>
                    </tr>

				<?php $i++;  ?>
				@empty
                    <tr>
                        <td style="width: 5%; border: solid 1px #000000;">&nbsp;</td>
                        <td style="width: 15%; border: solid 1px #000000;">&nbsp;</td>
                        <td style="width: 20%; border: solid 1px #000000;">&nbsp;</td>
                        <td style="width: 30%; border: solid 1px #000000;">&nbsp;</td>
                        <td style="width: 30%; border: solid 1px #000000;">&nbsp;</td>
                    </tr>
				@endforelse
    </table>
</page>