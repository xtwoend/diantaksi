<div id="formBap" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>    
    <center><h2 id="myModalLabel"><strong><u>BERITA ACARA PROSES PENGEMUDI</u></strong></h2>
  NO  :  {{ $nosurat }} </center>
  </div>
  {{ Form::open('proses/simpanbap') }}
  <div class="modal-body">


    <input type="hidden" name="driver_id" value="{{ $checkout->driver_id }}">
    <input type="hidden" name="fleet_id" value="{{ $checkout->fleet_id }}">
    <input type="hidden" name="pool_id" value="{{ $checkout->pool_id }}">
    <input type="hidden" name="operasi_time" value="{{ $checkout->operasi_time }}" >

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%">Pada  Hari </td>
    <td width="21%">: <strong>{{ MyFungsi::hari(date('N', strtotime('now'))) }} </strong> </td>
    <td width="7%">&nbsp;</td>
    <td width="17%">&nbsp;</td>
    <td width="17%">&nbsp;</td>
    <td width="28%">&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>: <strong>{{ MyFungsi::fulldate(strtotime('now')) }} </strong></td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><br>Dilakukan proses terhadap  pengemudi tersebut dibawah ini :<br> &nbsp;</td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>: <strong>{{ $infodriver->name }}</strong></td>
    <td>NIP</td>
    <td>: <strong>{{ $infodriver->nip }}</strong></td>
    <td>Saldo Sparepart</td>
    <td>: <strong><input type="text" class="moneys"  name="sum_sparepart" value="{{ $saldo_sparepart }}" readonly></strong></td>
  </tr>
  <tr>
    <td>Status</td>
    <td>: <strong>{{ $status_pengemudi }} <input type="hidden" name="driver_status" value="{{ $status_pengemudi }}"></strong></td>
    <td>Body</td>
    <td>: <strong>{{ Fleet::find($checkout->fleet_id)->taxi_number }}</strong></td>
    <td>Saldo KS</td>
    <td>: <strong> <input type="text" name="sum_ks" class="moneys"  value="{{ $saldo_ks }}" readonly></strong></td>
  </tr>
  <tr>
    <td>Pool</td>
    <td>: <strong>{{ Pool::find($checkout->pool_id)->pool_name }}</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Saldo Akhir Unit</td>
    <td>: <strong> <input type="text" class="moneys"  name="sum_akhir_unit" value="{{ $saldo_unit }}" readonly> </strong></td>
  </tr>
</table>
<br>
<p> Adapun latar belakang  dilakukan proses terhadap yang bersangkutan adalah <em>(tandai kolom proses)</em>:</p>
<br>
<ol>
  @foreach($listpelanggaran as $pe)
  <li>  
    <input type="checkbox" name="pelanggaran[]" value="{{ $pe->id }}" @if( in_array($pe->id , $checklistpelanggaran)) checked @endif> 
    {{ $pe->std_bap }} 
    @if($pe->id == 14) <input type="text" name="ket_bap_other" class="span8"> @endif 
  </li>
  @endforeach
</ol>
<p>Uraian tambahan dari pengemudi ( bila ada ) :<br />
  <textarea name="keterangan" id="textarea" cols="45" rows="5" class="span12" required></textarea>
  <br />
  Setelah  dilakukan proses pembahasan masalah dan solusi untuk selanjutnya dapat  disimpulkan / diputuskan hal-hal berikut : 
  {{ Form::select('keputusan_id', $keputusans) }}
 
  <textarea name="solusi" id="textarea2" cols="45" rows="5" class="span12" required></textarea>
  <br />
  <table class="table"> 
            <tbody>
               @forelse ($listkewajibans as $ke)
              <tr>
                <td>Input Kewajiban Cicilan ( {{ Financialtype::find($ke->financial_type_id)->financial_type }} )<input type="hidden" id="total_amount" name="total_amount[]" value="{{ $ke->total_amount }}"> <input type="hidden" id="financial_type_id" name="financial_type_id[]" value="{{ $ke->financial_type_id }}"></td>
                <td>Jumlah yang sanggup di bayar <input class="moneys" type="text" id="amount" name="amount[]" value="{{ $ke->amount }}"> * gunakan angka tampa tanda pemisah titik ( exp. 10000 )</td></td>
              </tr>
               @empty
               <tr>
                <td>Input Kewajiban Cicilan <input type="hidden" id="total_amount" name="total_amount[]" value="0">  <input type="hidden" id="financial_type_id" name="financial_type_id[]" value="6"></td>
                <td>Jumlah yang sanggup di bayar <input class="moneys" type="text" id="amount" name="amount[]" value="">* gunakan angka tampa tanda pemisah titik ( exp. 10000 )</td></td>
              </tr>
              @endforelse
            </tbody>
          </table>
  Terdapat  / Tidak terdapat lampiran ( <input type="text" name="lampiran" class="span5" required> ) yang dibubuhi paraf dan tanda tangan yang cukup sebagai bagian  yang tidak dapat dipisahkan dari berita acara proses pengemudi dian taksi.(*)<br />
Demikian  Berita Acara ini dibuat dengan sebenar-benarnya agar dapat dipergunakan  sebagaimana mestinya dan ditanda tangani dalam keadaan sehat jasmani dan  rohani, serta tanpa ada paksaan dari pihak manapun.</p>
<p>Jakarta, </p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%"><div align="center">Dibuat Oleh ( Staff perusahaan ) </div></td>
    <td colspan="2"><div align="center">Mengetahui  / saksi </div></td>
    <td width="26%"><div align="center">Peserta KSO</div></td>
  </tr>
  <tr>
    <td height="94">&nbsp;</td>
    <td width="22%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama : {{ $user->fullname }}</td>
    <td>Nama : <input type="text" name="saksi1_name" class="span6"></td>
    <td>Nama : <input type="text" name="saksi2_name" class="span6"></td>
    <td>Nama : {{ $infodriver->name }}</td>
  </tr>
  <tr>
    <td>Nik : {{ $user->nik }}</td>
    <td>Nik : <input type="text" name="saksi1_nik" class="span6"></td>
    <td>Nik : <input type="text" name="saksi2_nik" class="span6"></td>
    <td>Nip : {{ $infodriver->nip }}</td>
  </tr>
  <tr>
    <td>Jabatan : </td>
    <td>Jabatan : <input type="text" name="saksi1_jabatan" class="span6"></td>
    <td>Jabatan : <input type="text" name="saksi2_jabatan" class="span6"></td>
    <td>Status : {{ $status_pengemudi }}</td>
  </tr>
</table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
    <input type="submit" class="btn btn-primary" value="Simpan BAP">
  </div>
  {{ Form::close() }}
</div>

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