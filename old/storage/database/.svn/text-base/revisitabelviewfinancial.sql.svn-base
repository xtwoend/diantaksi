
-- Dumping structure for view db2.financial_report_bykso
DROP VIEW IF EXISTS `financial_report_bykso`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_bykso`;
CREATE VIEW `financial_report_bykso` AS select 
cin.*,
cf.checkin_id,
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by cin.kso_id ;


-- Dumping structure for view db2.financial_report_daily
DROP VIEW IF EXISTS `financial_report_daily`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_daily`;
CREATE VIEW `financial_report_daily` AS select 
cin.*,
d.nip,
d.name,
f.taxi_number,
cf.checkin_id,
o.kode,
max(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
max(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
max(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
max(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
max(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
max(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
max(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
max(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
max(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
max(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
max(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
max(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
max(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
max(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
max(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join drivers d on (cin.driver_id = d.id) 
join fleets f on (cin.fleet_id = f.id)
join operasi_status o on (cin.operasi_status_id = o.id)
group by cin.id ;


-- Dumping structure for view db2.financial_report_driver
DROP VIEW IF EXISTS `financial_report_driver`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_driver`;
CREATE VIEW `financial_report_driver` AS select 
cin.*,
cf.checkin_id,
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by cin.driver_id ;


-- Dumping structure for view db2.financial_report_fleet
DROP VIEW IF EXISTS `financial_report_fleet`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_fleet`;
CREATE VIEW `financial_report_fleet` AS select 
cin.*,
cf.checkin_id,
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by cin.fleet_id ;


-- Dumping structure for view db2.financial_report_monthly_bykso
DROP VIEW IF EXISTS `financial_report_monthly_bykso`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_monthly_bykso`;
CREATE VIEW `financial_report_monthly_bykso` AS select 
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.kso_id ;


-- Dumping structure for view db2.financial_report_monthly_driver
DROP VIEW IF EXISTS `financial_report_monthly_driver`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_monthly_driver`;
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.driver_id ;


-- Dumping structure for view db2.financial_report_monthly_fleet
DROP VIEW IF EXISTS `financial_report_monthly_fleet`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_monthly_fleet`;
CREATE VIEW `financial_report_monthly_fleet` AS select 
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.fleet_id ;


-- Dumping structure for view db2.financial_report_summary
DROP VIEW IF EXISTS `financial_report_summary`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_summary`;
CREATE VIEW `financial_report_summary` AS select 
cin.*,
d.nip,
d.name,
f.taxi_number,
cf.checkin_id,
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join drivers d on (cin.driver_id = d.id) 
join fleets f on (cin.fleet_id = f.id)
group by cin.pool_id, cin.operasi_time ;


-- Dumping structure for view db2.financial_report_years_bykso
DROP VIEW IF EXISTS `financial_report_years_bykso`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_years_bykso`;
CREATE VIEW `financial_report_years_bykso` AS select 
cin.*,
cf.checkin_id,
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), cin.kso_id ;


-- Dumping structure for view db2.financial_report_years_driver
DROP VIEW IF EXISTS `financial_report_years_driver`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_years_driver`;
CREATE VIEW `financial_report_years_driver` AS select 
cin.*,
cf.checkin_id,
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), cin.driver_id ;


-- Dumping structure for view db2.financial_report_years_fleet
DROP VIEW IF EXISTS `financial_report_years_fleet`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_years_fleet`;
CREATE VIEW `financial_report_years_fleet` AS select 
cin.*,
cf.checkin_id,
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), cin.fleet_id ;

