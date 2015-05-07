<!DOCTYPE html>
<head>
<style type="text/css">
/*yang ini buat setting ukuran kertasnya assumsi A4 */
#KERTASKECIL {
	background-color:#FFFFFF;
	left:0px;
	right:0px;
	height:5.00in ; /*Ukuran Panjang Kertas */
	width: 3.80in; /*Ukuran Lebar Kertas */
	margin:1px solid #FFFFFF;
	border: 1px solid #000;
	font-size: 10pt;
	font-family: Arial, Helvetica, sans-serif;
	position: fixed;
}
#content {
	padding: 10px 10px 10px 10px;
}
h1 {
	font-size: 14pt;
}
/*sampe sini */
</style>
</head>
<body>
<div id="KERTASKECIL">
	<div id="content">
		<table cellspacing="0" cellpadding="0">
			  <col width="80" />
			  <col width="135" />
			  <col width="90" />
			  <col width="150" />
			  <tr>
			    <td colspan="4" align="center"><h1>SURAT PERINTAH JALAN<h1></td>
			  </tr>
			  <tr>
			    <td colspan="4" align="center">PT. DHARMA INDAH AGUNG METROPOLITAN</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td>NIP</td>
			    <td>: {{ $driverinfo->nip }}</td>
			    <td>NO PINTU</td>
			    <td>: {{ $fleetinfo->taxi_number }}</td>
			  </tr>
			  <tr>
			    <td>NAMA</td>
			    <td>: {{ $driverinfo->name }}</td>
			    <td>POOL</td>
			    <td>: {{ $pool->pool_name }}</td>
			  </tr>
			  <tr>
			    <td>TANGGAL</td>
			    <td>: {{ $dateops }}</td>
			    <td>Tgl Print</td>
			    <td>: {{ $printed }}</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td colspan="4">Nama dan kendaraan yang tercantum diatas di IZINKAN
mengoprasikan kendaraan DIAN TAKSI sesuai dengan
tanggal yang tercantum diatas<br>
				</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td colspan="4">Setelah beroperasi SPJ di kembalikan kebagian Operasi</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td colspan="4" align="center">TANDA TANGAN</td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center">Bag. Operasi</td>
			    <td colspan="2" align="center">Security</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td colspan="4">Syarat Armada Keluar : (di isi oleh Security)</td>
			  </tr>

			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td colspan="2">[ ] Seragam </td>
			    <td colspan="2" >[ ] Sepatu </td>
			  </tr>
			  <tr>
			    <td colspan="2" >[ ] KPP </td>
			    <td colspan="2">[ ] Kunci Roda </td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td></td>
			    <td></td>
			    <td></td>
			  </tr>
			</table>
	</div>
</div>
</body>
</html>