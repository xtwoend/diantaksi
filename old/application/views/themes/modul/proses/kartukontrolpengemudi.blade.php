@include('themes.partials.head')

<div class="container-fluid">
  <div class="block">
        <div class="block-heading">
            <a href="#infopengemudi" data-toggle="collapse">Informasi Pengemudi</a>       
        </div>
        <div class="block-body collapse in" id="infopengemudi">
          <table class="table table-condensed table-striped" style="font-size: 0.9em; ">
                      <tr>
                        <td>Nama</td>
                        <td>{{ $name }}</td>
                      </tr>
                      <tr>
                        <td>Saldo KS</td>
                        <td>
                            Rp. {{ number_format($kspengemudi, 2, '.', ''); }}                            
                        </td>
                      </tr>
                      <tr>
                        <td>Pembayaran KS</td>
                        <td>Rp. {{ number_format($cicilanks, 2, '.', ''); }} </td>
                      </tr>
                      <tr>
                        <td>Hutang Lama</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Pembayaran Hutang Lama</td>
                        <td>Rp. {{ number_format($cicilanhutang, 2, '.', ''); }}</td>
                      </tr>
      
                   </table>
        </div>
    </div>
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

              <button type="submit" class="btn btn-info" id="viewCartControl"><i class="icon-search"></i></button>
          </div>
          </form>
            <br> 
        </div>
    </div>
    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Laporan Kartu Kontrol Pengemudi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <table class="table table-condensed table-striped table-bordered" style="font-size: 0.9em; "> 
              <thead>
                <tr>
                  <td>Tanggal</td>
                  <td>Body</td>
                  <td>Setoran Cash</td>
                  <td>KS</td>
                  <td>Denda</td>
                  <td>Cicilan SP</td>
                  <td>Cicilan KS</td>
                  <td>Cicilan DP KSO</td>
                  <td>Cicilan DP SP</td>
                  <td>C. Hut Lama</td>
                  <td>Keterangan OPS</td>
                </tr>
              </thead>
              <tbody>
                @foreach($reports as $report)
                <tr>
                  <td>{{ $report->operasi_time }}</td>
                  <td>{{ Fleet::find($report->fleet_id)->taxi_number }}</td>
                  <td>{{ $report->setoran_cash }}</td>
                  <td>{{ $report->ks }}</td>
                  <td>{{ $report->denda }}</td>
                  <td>{{ $report->cicilan_sparepart }}</td>
                  <td>{{ $report->cicilan_ks }}</td>
                  <td>{{ $report->cicilan_dp_kso }}</td>
                  <td>{{ $report->hutang_dp_sparepart }}</td>
                  <td>{{ $report->cicilan_hutang_lama }}</td>
                  <td>{{ Statusoperasi::find($report->operasi_status_id)->kode }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>

@include('themes.partials.script')
<script type="text/javascript">
$(function () {
  /*
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });
*/
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
         
        var checkin = $('#date-start').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? '' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#date-end')[0].focus();
        }).data('datepicker');
        var checkout = $('#date-end').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');

});

$('#viewCartControl').click(function(){
  
});

</script>