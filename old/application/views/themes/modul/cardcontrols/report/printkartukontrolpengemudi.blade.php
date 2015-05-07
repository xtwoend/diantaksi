<?php

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="setoranpengemudi.xls"');
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
?>
<table>
  <tr>
    <td colspan="10">Kartu Kontrol Armada Periode {{ Myfungsi::fulldate(strtotime($startdate)) }} - {{ Myfungsi::fulldate(strtotime($enddate)) }}  </td>    
  </tr>
  <tr>
    <td colspan="10"></td>    
  </tr>
</table>

<table>
  <tr>
    <td colspan="10"><hr></td>    
  </tr>
</table>

<table class="table table-condensed table-striped table-bordered" style="font-size: 0.9em; " border="1"> 
              <thead>
                   <tr>
                      <td rowspan="2">Tanggal</td>
                      <td rowspan="2">Body</td>
                      <td rowspan="2">Setoran Cash</td>
                      <td rowspan="2">Denda</td>
                      <td colspan="5">Pembayaran</td>
                      <td rowspan="2">KS</td>
                      <td rowspan="2">Keterangan OPS</td>
                    </tr>
                    <tr>
                      <td>KS</td>
                      <td>SP</td>
                      <td>DP KSO</td>
                      <td>DP SP</td>
                      <td>HUT LAMA</td>
                    </tr>
              </thead>
              <tbody>
                @foreach($reports as $report)
                <?php $fleet = Fleet::find($report->fleet_id); ?>
                <tr>
                  <td>{{ $report->operasi_time }}</td>
                  <td>{{ $fleet->taxi_number }}</td>
                  <td class="text-right">{{ number_format($report->setoran_cash, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->denda, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_ks, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_sparepart, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_dp_kso, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->hutang_dp_sparepart, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_hutang_lama, 2, ',', '.') }}</td>
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
                  <td>TOTAL :</td>
                  <td class="text-right">{{ number_format($cash, 2, ',', '.') }}</td>                  
                  <td class="text-right">{{ number_format($denda, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($cicilan_ks, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($cicilan_sparepart, 2, ',', '.') }}</td>                  
                  <td class="text-right">{{ number_format($cicilan_dp_kso, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($hutang_dp_sparepart, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($ks, 2, ',', '.') }}</td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>