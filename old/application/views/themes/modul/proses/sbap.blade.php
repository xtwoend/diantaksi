<html>
<head>
<style type="text/css">
*{
  font-family: Arial;
  margin:0px;
  padding:0px;
  font-size: 10pt;
}
@page {
 margin: 1cm 2cm 1cm 2cm;
}

#logo{
  height: 60px;
}

#header {
  border-bottom: 3px double #000;
}

ol {
  padding-left: 30px;
}

p {
  padding-bottom: 10px;
  padding-top: 10px;
}

.finance{
  font-size: 10pt;
  border-collapse:collapse;
}
.finance th{
  padding-top:1mm;
  padding-bottom:1mm;
}
.finance th{
  background: #F0F0F0;
  border-top: 0.3mm solid #000;
  border-bottom: 0.3mm solid #000;

  padding-left:0.2cm;
}
.finance tr td{
  padding-top:0.5mm;
  padding-bottom:0.5mm;
  padding-left:2mm;
  border-bottom:0.3mm solid #000;
  padding-right: 5mm;
}
h3 {
  font-size: 13pt;
}

</style>

</head>
<body>

<div id="content">

<?php
          $driver = Driver::find($bap->driver_id);
          $fleet = Fleet::find($bap->fleet_id);
?>
<table width="100%"  cellpadding="0" cellspacing="0" id="header">
  <tr>
    <td rowspan="3">{{ HTML::image('img/diantaksi.png','',array('id' => 'logo')) }}</td>
    <td>PT DHARMA INDAH AGUNG METROPOLITAN</td>
  </tr>
  <tr>
    <td><strong><u><h3>BERITA ACARA PROSES PENGEMUDI</h3></u></strong></td>
  </tr>
  <tr>
    <td> NO  :  {{ $bap->bap_number }} </td>
  </tr>
</table>

<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%">Pada  Hari </td>
    <td>: <strong>{{ MyFungsi::hari(date('N',strtotime($bap->date))) }} </strong> </td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>: <strong>{{ MyFungsi::fulldate(strtotime($bap->date)) }} </strong></td>
  </tr>
</table>

<p>Dilakukan proses terhadap  pengemudi tersebut dibawah ini :</p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%">Nama</td>
    <td width="40%">: <strong>{{ $driver->name }}</strong></td>
    <td >NIP</td>
    <td>: <strong>{{ $driver->nip }}</strong></td>
  </tr>
  <tr>
    <td width="20%">Status</td>
    <td>: <strong>{{ $bap->driver_status }}</strong></td>
    <td>Body</td>
    <td>: <strong>{{ $fleet->taxi_number }}</strong></td>
  </tr>
  <tr>
    <td>Pool</td>
    <td>: <strong>{{ Pool::find($bap->pool_id)->pool_name }}</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="finance">
  <tr>
    <th width="40%" style="  text-align: left;">Informasi</th>
    <th width="20%" style="  text-align: left;">Bulan Berjalan</th>
    @foreach($financial_driver as $month)
      <th width="20%" style="  text-align: center;">{{ $month->monthname }} {{ $month->year }}</th>
    @endforeach
  </tr>
  <tr>
      <td>Saldo Saldo Sparepart</td>
      <td>{{ number_format($bap->sum_sparepart, 0, ',', '.') }} </td>
      @foreach($financial_fleet as $ks)
        <td align="right"></td>
      @endforeach
  </tr>
  <tr>
      <td>Saldo KS</td>
      <td>{{ number_format($bap->sum_ks, 0, ',', '.') }}</td>
      @foreach($financial_fleet as $ks)
        <td align="right"></td>
      @endforeach
  </tr>
  <!-- Error Input Nilai Akhir Saldo -->
  <tr>
      <td >Saldo Akhir Unit</td>
      <td >{{ number_format($bap->sum_akhir_unit, 0, ',', '.') }}</td>
      @foreach($financial_fleet as $ks)
        <td align="right"></td>
      @endforeach
  </tr>

  <tr>
      <td >KS Unit</td>
      <td ></td>
      @foreach($financial_fleet as $ks)
        <td align="right">{{ number_format($ks->ks, 0, ',', '.') }}</td>
      @endforeach
  </tr>
   <tr>
      <td >Pembayaran KS Unit</td>
       <td ></td>
      @foreach($financial_fleet as $pay)
        <td align="right">{{ number_format($pay->cicilan_ks, 0, ',', '.') }}</td>
      @endforeach
  </tr>
  <tr>
    <td>Besar KS /Pengemudi</td>
    <td ></td>
    @foreach($financial_driver as $ks_d)
        <td align="right">{{ number_format($ks_d->ks, 0, ',', '.') }}</td>
    @endforeach
  </tr>
  <tr>
    <td>Pembayaran KS /Pengemudi</td>
    <td ></td>
    @foreach($financial_driver as $pay_d)
        <td align="right">{{ number_format($pay_d->cicilan_ks, 0, ',', '.') }}</td>
    @endforeach
  </tr>
</table>
<p> Adapun latar belakang  dilakukan proses terhadap yang bersangkutan adalah <em>(tandai kolom proses)</em>:</p>

<ol>
        @if($bap->std_bap_id !== '' )
          <?php $bap_id = explode(',', $bap->std_bap_id ); ?>
          @foreach($bap_id as $baps => $val) 
            <li>{{ Stdbap::find($val)->std_bap }}</li>
          @endforeach
        @endif
</ol>

<p>Uraian tambahan dari pengemudi ( bila ada ) : </p>
  {{ $bap->keterangan }}

<p>Setelah  dilakukan proses pembahasan masalah dan solusi untuk selanjutnya dapat  disimpulkan / diputuskan untuk : 
  <strong>{{ Keputusanbap::find($bap->keputusan_id)->keputusan }}</strong> </p>
<p> Dengan alasan: </p>
<p> {{ $bap->solusi }} </p>
  
<p>Terdapat  / Tidak terdapat lampiran ( {{ $bap->lampiran }} ) yang dibubuhi paraf dan tanda tangan yang cukup sebagai bagian  yang tidak dapat dipisahkan dari berita acara proses pengemudi dian taksi.(*)</p>
<p>Demikian  Berita Acara ini dibuat dengan sebenar-benarnya agar dapat dipergunakan  sebagaimana mestinya dan ditanda tangani dalam keadaan sehat jasmani dan  rohani, serta tanpa ada paksaan dari pihak manapun.</p>
<p>Jakarta, {{ MyFungsi::fulldate(strtotime($bap->date)) }}</p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%"><div align="center">Dibuat Oleh <br>( Staff perusahaan ) </div></td>
    <td colspan="2"><div align="center">Mengetahui  / saksi </div></td>
    <td width="26%"><div align="center">Peserta KSO</div></td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
    <td width="22%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama : {{ User::find($bap->user_id)->fullname }}</td>
    <td>Nama : {{ $bap->saksi1_name }}</td>
    <td>Nama : {{ $bap->saksi2_name }}</td>
    <td>Nama : {{ $driver->name }}</td>
  </tr>
  <tr>
    <td>Nik : </td>
    <td>Nik : {{ $bap->saksi1_nik }}</td>
    <td>Nik : {{ $bap->saksi2_nik }}</td>
    <td>Nip : {{ $driver->nip }}</td>
  </tr>
  <tr>
    <td>Jabatan : </td>
    <td>Jabatan : </td>
    <td>Jabatan : </td>
    <td>Status : {{ $bap->driver_status }}</td>
  </tr>
</table>

  </div>
</div>

</body>
</html>