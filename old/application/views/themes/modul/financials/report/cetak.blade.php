<!DOCTYPE html>
<head>
<style type="text/css">
/*yang ini buat setting ukuran kertasnya assumsi KECIL */
#KERTASKECIL {
	background-color:#FFFFFF;
	left:0px;
	right:0px;
	height:5.30in ; /*Ukuran Panjang Kertas */
	width: 3.80in; /*Ukuran Lebar Kertas */
	margin:1px solid #FFFFFF;
	border: 1px solid #000;
	font-size: .8em;
	font-family:Tahoma, Geneva, sans-serif;
	position: fixed;
}
#content {
	padding: 10px 10px 10px 10px;
}
h1 {
	font-size: 1.4em;
}
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
			    <td colspan="4" align="center">BUKTI SETORAN PENGEMUDI</td>
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
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			</table>
======================================<br>
RINCIAN SETORAN HARI INI <br>
======================================<br>
Setoran 	: {{ $setoran['setoran_wajib'] }}<br>
Tab S'Part	: {{ $setoran['tab_sp'] }}<br>
Denda		: {{ $setoran['denda'] }}<br>

Cicilan	<br>
======================================<br>
KS			: {{ $setoran['tag_ks'] }}<br>
Sapare Part	: {{ $setoran['tag_spart'] }}<br>
DP 			: {{ $setoran['tag_cicilan_dp'] }}<br>
DP S' Part	: {{ $setoran['tag_dp_spart'] }}<br>
Hutang Lama	: {{ $setoran['tag_hut_lama'] }}<br>
Lain - Lain	: {{ $setoran['tag_other'] }}<br>

Iuran Laka	: {{ $setoran['iuran_laka'] }}<br>
Biaya TC	: {{ $setoran['biaya_tc'] }}<br>
=======================================<br>
TOTAL 		: {{ $setoran['total'] }}<br>
=======================================<br>
SETORAN 	: {{ $setoran['cash'] }}<br>
=======================================<br>
POTONGAN	: {{ $setoran['pot'] }}<br>
=======================================<br>
KURANG SETOR: {{ $setoran['ks'] }}<br>

	</div>
</div>
</body>
</html>