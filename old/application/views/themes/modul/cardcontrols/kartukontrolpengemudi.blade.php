@include('themes.partials.head')

<div class="container-fluid">
  
   <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Tanggal Operasi Armada</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          <form method="GET" action="">
          <div class="form-inline" >
              <?php /*
              <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                  <input name="date" id="date" class="input-small" type="text" value="{{ date('Y-m-d') }}">
                  <span class="add-on"><i class="icon-calendar"></i></span>
              </div> 
              */ ?>
              

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
          </div>
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
                  $cicilan_hut_lama = 0;

              ?>
    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Laporan Kartu Kontrol Pengemudi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <table class="table table-condensed table-striped table-bordered" style="font-size: 0.9em; "> 
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
                <tr>
                  <td>{{ $report->operasi_time }}</td>
                  <td>{{ Fleet::find($report->fleet_id)->taxi_number }}</td>
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
                  <td>TOTAL</td>
                  <td>:</td>
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
        </div>
    </div>

@include('themes.partials.script')
<script type="text/javascript">
$(function () {
    
        $('#date-start').datepicker({
              format: 'yyyy-mm-dd'
          });

        $('#date-end').datepicker({
              format: 'yyyy-mm-dd'
          });

});

$('#viewCartControl').click(function(){
  
});

</script>