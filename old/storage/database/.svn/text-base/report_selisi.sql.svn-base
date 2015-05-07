
-- Dumping structure for view db2.financial_report_graf_ks_detail
DROP VIEW IF EXISTS `financial_report_graf_ks_detail`;

CREATE VIEW `financial_report_graf_ks_detail` AS select 
cin.*,
d.nip,
d.name,
f.taxi_number,
f.fleet_model_id,
cf.checkin_id,
month(cin.operasi_time) as month,
year(cin.operasi_time) as year,
sum(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
sum(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
sum(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
sum(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
sum(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
sum(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
sum(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan,
(sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join drivers d on (cin.driver_id = d.id) 
join fleets f on (cin.fleet_id = f.id)
group by cin.operasi_status_id, cin.pool_id, cin.operasi_time ;


-- Dumping structure for view db2.financial_report_monthly_bykso
DROP VIEW IF EXISTS `financial_report_monthly_bykso`;

CREATE VIEW `financial_report_monthly_bykso` AS select 
cin.*,
f.taxi_number,
cf.checkin_id,
MONTHNAME(cin.operasi_time) as monthname,
month(cin.operasi_time) as month,
year(cin.operasi_time) as year,
sum(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
sum(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
sum(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
sum(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
sum(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
sum(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
sum(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan,
(sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join fleets f on (cin.fleet_id = f.id)
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.kso_id ;


-- Dumping structure for view db2.financial_report_monthly_driver
DROP VIEW IF EXISTS `financial_report_monthly_driver`;

CREATE VIEW `financial_report_monthly_driver` AS select 
cin.*,
cf.checkin_id,
MONTHNAME(cin.operasi_time) as monthname,
month(cin.operasi_time) as month,
year(cin.operasi_time) as year,

sum(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
sum(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
sum(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
sum(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
sum(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
sum(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
sum(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan,
(sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.driver_id ;


-- Dumping structure for view db2.financial_report_monthly_fleet
DROP VIEW IF EXISTS `financial_report_monthly_fleet`;

CREATE VIEW `financial_report_monthly_fleet` AS select 
cin.*,
f.taxi_number,
cf.checkin_id,
MONTHNAME(cin.operasi_time) as monthname,
month(cin.operasi_time) as month,
year(cin.operasi_time) as year,
sum(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
sum(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
sum(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
sum(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
sum(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
sum(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
sum(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan,
(sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join fleets f on (cin.fleet_id = f.id)
group by cin.kso_id, YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.fleet_id ;