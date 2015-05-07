<div id="formBap" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Form Proses BAP</h3>
  </div>
  <div class="modal-body">
    {{ Form::open('proses/simpanbap') }}
    <input type="hidden" name="driver_id" value="{{ $checkout->driver_id }}">
    <input type="hidden" name="fleet_id" value="{{ $checkout->fleet_id }}">
    <input type="hidden" name="pool_id" value="{{ $checkout->pool_id }}">
    <div class="row-fluid">
      <div class="span6">
        Dilakukan proses terhadap pengemudi tersebut dibawah ini :
        <table class="table table-condensed"> 
          <tbody>
              <tr>
                <td>Nama</td>
                <td>: {{ $infodriver->name }}</td>
                <td>NIP</td>
                <td>: {{ $infodriver->nip }}</td>
              </tr>
              <tr>
                <td>Pool</td>
                <td>: {{ Pool::find($checkout->pool_id)->pool_name }} </td>
                <td>Body</td>
                <td>: {{ Fleet::find($checkout->fleet_id)->taxi_number }} </td>
              </tr>
          </tbody>
        </table>
        <?php /*
        Daftar Pelanggaran Operasi <br>
          
           <table class="table"> 
            
            <tbody>
               @foreach($pelanggaran as $pe)
               
              <tr>
                <td><input type="hidden" name="blocked_id[]" value="{{ $pe->id }}">{{ Blockedstatus::find($pe->blocked_status_id)->status }} Tanggal Operasi {{ Myfungsi::fulldate(strtotime(Checkin::find($pe->checkin_id)->operasi_time)) }}</td>
                @if($pe->blocked_status_id == 1)
                  <?php $ks = Checkinfinancial::where_checkin_id($pe->checkin_id)->where_financial_type_id(11)->first(); ?>
                  <td>Rp. {{ number_format($ks->amount,2,',','.') }} </td>
                @endif
              </tr>
               @endforeach
            </tbody>
          </table>
         */ ?>
      </div>
      <div class="span6">
          Kewajiban Pengemudi Terhadap Armada <br>
           <table class="table"> 
            <thead>
              <tr>
                <th>Tipe Kewajiban</th>
                <th>Total Kewajiban</th>
                <th>Cicilan / Operasi</th>
              </tr>
            </thead>
            <tbody>
               @forelse ($listkewajibans as $ke)
              <tr>
                <td><input type="hidden" id="financial_type_id" name="financial_type_id" value="{{ $ke->financial_type_id }}">{{ $ke->financial_type }}</td>
                <td><input class="moneys" type="text" id="total_amount" name="total_amount" value="{{ $ke->total_amount }}"></td>
                <td><input class="moneys" type="text" id="amount" name="amount" value="{{ $ke->amount }}"></td></td>
              </tr>
               @empty
               <tr>
                <td>{{ Form::select('financial_type_id', $options, '6', array('class'=>'span12')); }}</td>
                <td><input class="moneys" type="text" id="total_amount" name="total_amount" value=""></td>
                <td><input class="moneys" type="text" id="amount" name="amount" value=""></td></td>
              </tr>
              @endforelse
            </tbody>
          </table>        
      </div>
    </div>
  <div class="row-fluid">
    <div class="span6">
      Keterangan/Uraian dari Pengemudi: <br>
      <textarea name="keterangan" class="span12" rows="6"></textarea><br>
      Lampiran : <input type="text" name="lampiran" class="span10" required><br>

      Di Buat dan di setujui untuk di lakukan : 
      <label class="radio">
        <input type="radio" name="openblock" value="close" checked>
        Blocking Pengemudi
      </label>
      <label class="radio">
        <input type="radio" name="openblock" value="open">
        Open Blocking Pengemudi
      </label>
      
    </div>

     <div class="span6">
      Solusi pemeroses: <br>
      
      <textarea name="solusi" class="span12" rows="6"></textarea>
      <br>
      <div class="row-fluid">
        <div class="span6">
          Saksi 1  <br>
          <strong>{{ $user->fullname }}</strong>
        </div>
        <div class="span6">
          Saksi 2 <br>
        <input name="username" type="text" placeholder="username"><br>  
        <input name="password" type="password" placeholder="password">
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
    <input type="submit" class="btn btn-primary" value="Simpan BAP">
  </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
var rootURL = '{{ URL::base().'/proses' }}';

$(function () {
   $('#formBap').modal('show').css({
       'width': function () { 
           return ($(document).width() * .9) + 'px';  
       },
       'margin-left': function () { 
           return -($(this).width() / 2); 
       }
    });
   $('.moneys').money_field({width: 120});
});

</script>