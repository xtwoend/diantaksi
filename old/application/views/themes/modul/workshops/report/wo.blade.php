<html>
<head>
<link rel="stylesheet" href="{{ URL::base() }}/themes/stylesheets/print.css" type="text/css"  />

<body class="body">
<div id="wrapper">

<table class="tabel">
  <tr>
    <td><table class="tabel">
      <tr>
        <td width="33%" >*</td>
        <td width="34%" rowspan="2" align="center">{{ HTML::image('img/diantaksi.png', 'logo diantaksi', array('id' => 'smile')) }}<h2>SURAT PERINTAH KERJA</h2></td>
        <td width="33%">**</td>
      </tr>
      <tr>
        <td>*MASUK</td>
        <td>** KELUAR</td>
      </tr>
    </table>
      <table class="tabel">
        <tr>
          <td valign="top" width="25%">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="35%"><b>KM</b></td>
              <td width="8%">:</td>
              <td width="57%">&nbsp KM</td>
            </tr>
            <tr>
              <td><b>JAM</b></td>
              <td>:</td>
              <td></td>
            </tr>
            <tr>
              <td><b>TANGGAL</b></td>
              <td>:</td>
              <td><strong>{{ myFungsi::fulldate(strtotime($wo->inserted_date_set)) }}</strong></td>
            </tr>
          </table>
          </td>
          <td valign="top" width="50%"><table class="tabel">
            <tr>
              <td width="25%"><b>NO</b></td>
              
              <td width="75%">: <strong>{{ $wo->wo_number }} </strong></td>
            </tr>
            <tr>
              <td><b>POOL</b></td>
              
              <td>: <strong>{{ Pool::find($wo->pool_id)->pool_name }}</strong></td>
            </tr>
            <tr>
              <td><b>NAMA</b></td>
              
              <td>: <strong>{{ Driver::find($wo->driver_id)->name }}</strong></td>
            </tr>
            <tr>
              <td><b>NIP</b></td>
              
              <td>: <strong>{{ Driver::find($wo->driver_id)->nip }}</strong></td>
            </tr>
            <tr>
              <td><b>BODY</b></td>
              
              <td>: <strong>{{ Fleet::find($wo->fleet_id)->taxi_number }}</strong></td>
            </tr>
          </table></td>
          <td valign="top" width="25%"><table class="tabel">
            <tr>
              <td width="35%"><b>KM</b></td>
              <td width="7%">:</td>
              <td width="58%">&nbsp;</td>
            </tr>
            <tr>
              <td><b>JAM</b></td>
              <td>:</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><b>TANGGAL</b></td>
              <td>:</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table class="tabel">
      <tr>
        <td width="58%"><b>* KELUHAN KERUSAKAN</b></td>
        <td width="34%"><b>* KETERANGAN</b></td>
      </tr>
       <tr>
        <td width="58%">{{ $wo->complaint }}</td>
        <td width="34%">{{ $wo->information_complaint }}</td>
      </tr>
 
    </table></td>
  </tr>
  <tr>
    <td><table class="tabel">
      <tr>
        <td rowspan="2"><b>** NO</b></td>
        <td rowspan="2"><b>** ANALISA KERUSAKAN</b></td>
        <td rowspan="2"><b>** PART YANG DIGANTI</b></td>
        <td colspan="3" align="center"><b>DIKERJAKAN</b></td>
        </tr>
      <tr>
        <td><b>MEKANIK</b></td>
        <td><b>MULAI</b></td>
        <td><b>SELESAI</b></td>
      </tr><tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>KET : * (DIISI OLEH BAGIAN OPERASI) - ** (DIISI OLEH BAGIAN BENGKEL)</td>
  </tr>
  <tr>
    <td><table class="tabel">
      <tr>
        <td colspan="4" align="center">JAKARTA, </td>
        </tr>
      <tr>
        <td rowspan="4"><table class="small">
          <tr>
            <td>Form Nomor</td>
            <td>: </td>
            <td>DT-F-OPS-04-005</td>
          </tr>
          <tr>
            <td>Tanggal Implementasi</td>
            <td>:</td>
            <td>04 Juli 2011</td>
          </tr>
          <tr>
            <td>Revisi Nomor</td>
            <td>:</td>
            <td>00</td>
          </tr>
        </table></td>
        <td>Dibuat Oleh,</td>
        <td>Mengetahui,</td>
        <td>Menyetujui</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p>(...............................)</p>
          <p>BAGIAN OPERASI</p></td>
        <td><p>(...............................)</p>
          <p>BAGIAN BENGKEL</p></td>
        <td><p>(...............................)</p>
          <p>Ka. Bag. Bengkel</p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<div>
</body>
</html>

