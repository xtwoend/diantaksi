<?php

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="setoran.xls"');
header('Cache-Control: max-age=0');

?>
<?php 
                  $cash = 0;
                  $ks = 0;
                  $denda = 0;
                  $cicilan_sparepart = 0;
                  $cicilan_ks = 0;
                  $cicilan_dp_kso = 0;
                  $hutang_dp_sparepart = 0;

                  $saldoks =  $detailarmada['pembayaran_ks'] - $detailarmada['total_ks']; 
                  $saldosp = ($detailarmada['tab_sparepart'] + $detailarmada['pembayaran_sparepart']) - $detailarmada['pem_sparepart'] ;
                  $saldo = $saldoks + $saldosp;
              ?>
<table>
  <tr>
    <td colspan="11">Kartu Kontrol Armada Periode {{ Myfungsi::fulldate(strtotime($startdate)) }} - {{ Myfungsi::fulldate(strtotime($enddate)) }}  </td>    
  </tr>
  <tr>
    <td colspan="11"></td>    
  </tr>
</table>

<table>
	<tr>
		<td>Body</td>
		<td>{{ $detailarmada['taxi_number'] }} </td>
		<td>Saldo KS</td>
		<td>{{ ceil(floatval($saldoks))  }}</td>
		
		<td>Hutang DP</td>
		<td>{{ ceil(floatval($detailarmada['hutang_dp_kso'])) }}</td>
		
	</tr>
	<tr>
		<td>NIP Bravo</td>
		<td>{{ $detailarmada['nip'] }}</td>
		<td>Saldo Sparepart</td>
		<td>{{ ceil(floatval($saldosp)) }}</td>
		
    <td>Bayaran DP</td>
		<td>{{ ceil(floatval($detailarmada['pem_hutang_dp_kso'])) }}</td>
		
	</tr>
	<tr>
		<td>Nama Bravo </td>
		<td>{{ $detailarmada['bravo'] }}</td>
		<td>Saldo Unit</td>
		<td>{{ ceil(floatval($saldo)) }}</td>
		
    <td>Saldo DP</td>
    <td>{{ ceil(floatval($detailarmada['pem_hutang_dp_kso'] - $detailarmada['hutang_dp_kso'])) }}</td>
    
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>

<table>
  <tr>
    <td colspan="11"><hr></td>    
  </tr>
</table>

<table class="table table-condensed table-striped table-bordered" style="font-size: 0.9em; " border="1"> 
              <thead>
                   <tr>
                      <td rowspan="2">Tanggal</td>
                      <td rowspan="2">NIP</td>
                      <td rowspan="2">Nama</td>
                      <td rowspan="2">Setoran Cash</td>
                      <td rowspan="2">Denda</td>
                      <td colspan="4">Pembayaran</td>
                      <td rowspan="2">KS</td>
                      <td rowspan="2">Ket. OPS</td>
                    </tr>
                    <tr>
                      <td>KS</td>
                      <td>SP</td>
                      <td>DP KSO</td>
                      <td>DP SP</td>
                    </tr>
              </thead>
              <tbody>
                @foreach($reports as $report)
                <?php $driver = Driver::find($report->driver_id); ?>
                <tr>
                  <td>{{ $report->operasi_time }}</td>
                  <td>'{{ $driver->nip }}</td>
                  <td>{{ $driver->name }}</td>
                  <td class="text-right">{{ number_format($report->setoran_cash, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->denda, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_ks, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_sparepart, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_dp_kso, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->hutang_dp_sparepart, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->ks, 2, ',', '.') }}</td>
                  <td class="text-right">{{ Statusoperasi::find($report->operasi_status_id)->kode }}</td>
                </tr>
                <?php 
                  $cash = $cash + $report->setoran_cash;
                  $ks = $ks + $report->ks;
                  $denda = $denda + $report->denda;
                  $cicilan_sparepart = $cicilan_sparepart + $report->cicilan_sparepart;
                  $cicilan_ks = $cicilan_ks + $report->cicilan_ks;
                  $cicilan_dp_kso = $cicilan_dp_kso + $report->cicilan_dp_kso;
                  $hutang_dp_sparepart = $hutang_dp_sparepart + $report->hutang_dp_sparepart;
                ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td>TOTAL :</td>
                  <td class="text-right">{{ number_format($cash, 2, ',', '.') }}</td>                  
                  <td class="text-right">{{ number_format($denda, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($cicilan_ks, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($cicilan_sparepart, 2, ',', '.') }}</td>                  
                  <td class="text-right">{{ number_format($cicilan_dp_kso, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($hutang_dp_sparepart, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($ks, 2, ',', '.') }}</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>