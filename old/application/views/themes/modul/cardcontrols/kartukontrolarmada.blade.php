@include('themes.partials.head')

<div class="container-fluid">
  
   <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Tanggal Operasi Armada</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          <form method="GET" action="" class="form-inline" >
                       

              <div class="input-append date" id="date-start" data-date="{{ Input::get('datestart',date('Y-m-d')) }}" data-date-format="yyyy-mm-dd">
                  <input name="datestart" id="date-start" class="input-small" type="text" value="{{ Input::get('datestart',date('Y-m-d')) }}">
                  <span class="add-on"><i class="icon-calendar"></i></span>
              </div>
              - 
              <div class="input-append date" id="date-end" data-date="{{ Input::get('dateend',date('Y-m-d')) }}" data-date-format="yyyy-mm-dd">
                  <input name="dateend" id="date-end" class="input-small" type="text" value="{{ Input::get('dateend',date('Y-m-d')) }}">
                  <span class="add-on"><i class="icon-calendar"></i></span>
              </div>

              <button name="con" value="tampil" type="submit" class="btn btn-info"><i class="icon-search"></i></button>
              <button name="con" value="download" type="submit" class="btn btn-info"><i class="icon-search"></i> Download</button>
          </form>
            <br> 
        </div>
    </div>
              <?php 
                  $cash = 0;
                  $ks = 0;
                  $denda = 0;
                  $cicilan_sparepart = 0;
                  $cicilan_ks = 0;
                  $cicilan_dp_kso = 0;
                  $hutang_dp_sparepart = 0;
                  $setoran_wajib = 0;
                  $tabungan_sparepart = 0;
                  $potongan = 0;
              ?>
    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup2" data-toggle="collapse">Laporan Kartu Kontrol Armada</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup2">
          <table class="table table-condensed table-striped table-bordered" style="font-size: 0.9em; "> 
              <thead>
                   <tr>
                      <td rowspan="2">No</td>
                      <td rowspan="2">Tanggal</td>
                      <td rowspan="2">NIP</td>
                      <td rowspan="2">Nama</td>
                      <td rowspan="2">Setoran Cash</td>
                      <td rowspan="2">Set. Murni</td>
                      <td rowspan="2">Tab. SP</td>
                      <td rowspan="2">Denda</td>
                      <td colspan="4">Pembayaran</td>
                      <td rowspan="2">Potongan</td>
                      <td rowspan="2">KS</td>
                      <td rowspan="2">Keterangan OPS</td>
                    </tr>
                    <tr>
                      <td>KS</td>
                      <td>SP</td>
                      <td>DP KSO</td>
                      <td>DP SP</td>
                    </tr>
              </thead>
              <tbody>
                <?php $no=1; ?>
                @foreach($reports as $report)
                <?php $driver = Driver::find($report->driver_id); ?>
                <tr>
                  <td>{{ $no; }}</td>
                  <td>{{ $report->operasi_time }}</td>
                  <td>{{ $driver->nip }}</td>
                  <td>{{ $driver->name }}</td>
                  <td class="text-right">{{ number_format($report->setoran_cash, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->setoran_wajib, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->tabungan_sparepart, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->denda, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_ks, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_sparepart, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->cicilan_dp_kso, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->hutang_dp_sparepart, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->potongan, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($report->ks, 0, ',', '.') }}</td>
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
                  $setoran_wajib = $setoran_wajib + $report->setoran_wajib;
                  $tabungan_sparepart = $tabungan_sparepart + $report->tabungan_sparepart;
                  $potongan = $potongan + $report->potongan;
                  $no++;
                ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>TOTAL :</td>
                  <td class="text-right">{{ number_format($cash, 0, ',', '.') }}</td> 
                  <td class="text-right">{{ number_format($setoran_wajib, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($tabungan_sparepart, 0, ',', '.') }}</td>                 
                  <td class="text-right">{{ number_format($denda, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($cicilan_ks, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($cicilan_sparepart, 0, ',', '.') }}</td>                  
                  <td class="text-right">{{ number_format($cicilan_dp_kso, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($hutang_dp_sparepart, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($potongan, 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($ks, 0, ',', '.') }}</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
        </div>
    </div>

@include('themes.partials.script')
<script type="text/javascript">
$(function () {
   
        $('#date-start').datepicker();
        $('#date-end').datepicker();

});

$('#viewCartControl').click(function(){
  
});

$('#downloadReport').click(function(){
        var dateSchedule = $('#date').val();
        var url = rootURL + '/expreportdaily/' + dateSchedule;
        window.open( url, "Export", "menubar=0,location=0,height=600,width=500" );
        return false;
});

</script>