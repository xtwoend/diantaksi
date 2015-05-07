               BUKTI SETORAN ARMADA<br>
         PT DHARMA INDAH AGUNG METROPOLITAN<br>
===========================================<br>
NIP         : {{ $driverinfo->nip }}<br>
NAMA        : {{ $driverinfo->name }}<br>
NO. PINTU   : {{ $fleetinfo->taxi_number }}<br>	
TANGGAL     : {{ $dateops }} / {{ $pool->pool_name }}<br>
===========================================<br>
RINCIAN SETORAN HARI INI <br>
===========================================<br>
Setoran 	: {{ $setoran['setoran_wajib'] }}<br>
Tab S'Part	: {{ $setoran['tab_sp'] }}<br>
Denda		: {{ $setoran['denda'] }}<br>

Cicilan	<br>
============================================<br>
KS			: {{ $setoran['tag_ks'] }}<br>
Sapare Part	: {{ $setoran['tag_spart'] }}<br>
DP 			: {{ $setoran['tag_cicilan_dp'] }}<br>
DP S' Part	: {{ $setoran['tag_dp_spart'] }}<br>
Hutang Lama	: {{ $setoran['tag_hut_lama'] }}<br>
Lain - Lain	: {{ $setoran['tag_other'] }}<br>

Iuran Laka	: {{ $setoran['iuran_laka'] }}<br>
Biaya TC	: {{ $setoran['biaya_tc'] }}<br>
===========================================<br>
TOTAL 		: {{ $setoran['total'] }}<br>
===========================================<br>
SETORAN 	: {{ $setoran['cash'] }}<br>
===========================================<br>
POTONGAN	: {{ $setoran['pot'] }}<br>
===========================================<br>
KURANG SETOR: {{ $setoran['ks'] }}<br>

