<?php

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="daftarpengemudi.xls"');
header('Cache-Control: max-age=0');

?>
<table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>No KTP</th>
                        <th>No SIM</th>
                        <th>No Telp / HP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td> {{ $driver->id }}</td>
                        <td> {{ $driver->nip }}</td>
                        <td> {{ $driver->name }}</td>
                        <td> {{ $driver->brith_place }}</td>
                        <td> {{ $driver->date_of_birth }}</td>
                        <td> {{ $driver->ktp }}</td>
                        <td> {{ $driver->sim }}</td>
                        <td> {{ $driver->phone }}</td>
                       </td>
                    </tr>
                    @endforeach
                </tbody>
</table>