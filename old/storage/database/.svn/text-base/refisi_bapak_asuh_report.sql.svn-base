-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-09-30 10:00:50
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for view db2.bapak_asuh_financial_month
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `bapak_asuh_financial_month` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`jho_id` INT(11) NOT NULL,
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`rit` INT(11) NOT NULL,
	`incomekm` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`operasi_status_id` INT(11) NOT NULL DEFAULT '0',
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`finance_time` DATETIME NOT NULL,
	`fg_bs` INT(11) NULL DEFAULT NULL COMMENT '1: bs 0:tidak',
	`keterangan` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`taxi_number` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`checkin_id` INT(11) NULL DEFAULT NULL,
	`monthname` VARCHAR(9) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`month` INT(2) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
	`bapak_asuh` BIGINT(11) NULL DEFAULT NULL,
	`total_anakasuh` BIGINT(21) NULL DEFAULT NULL,
	`setoran_wajib` DECIMAL(37,2) NULL DEFAULT NULL,
	`tabungan_sparepart` DECIMAL(37,2) NULL DEFAULT NULL,
	`denda` DECIMAL(37,2) NULL DEFAULT NULL,
	`potongan` DECIMAL(37,2) NULL DEFAULT NULL,
	`cicilan_sparepart` DECIMAL(37,2) NULL DEFAULT NULL,
	`cicilan_ks` DECIMAL(37,2) NULL DEFAULT NULL,
	`biaya_cuci` DECIMAL(37,2) NULL DEFAULT NULL,
	`iuran_laka` DECIMAL(37,2) NULL DEFAULT NULL,
	`cicilan_dp_kso` DECIMAL(37,2) NULL DEFAULT NULL,
	`cicilan_hutang_lama` DECIMAL(37,2) NULL DEFAULT NULL,
	`ks` DECIMAL(37,2) NULL DEFAULT NULL,
	`cicilan_lain` DECIMAL(37,2) NULL DEFAULT NULL,
	`hutang_dp_sparepart` DECIMAL(37,2) NULL DEFAULT NULL,
	`setoran_cash` DECIMAL(37,2) NULL DEFAULT NULL,
	`tabungan` DECIMAL(37,2) NULL DEFAULT NULL,
	`selisi_ks` DECIMAL(38,2) NULL DEFAULT NULL
) ENGINE=MyISAM;


-- Dumping structure for view db2.bapak_asuh_financial_month
-- Removing temporary table and create final VIEW structure
DROP VIEW IF EXISTS `bapak_asuh_financial_month`;
CREATE VIEW `bapak_asuh_financial_month` AS select 
cin.*,
f.taxi_number,
f.pool_id as pool,
cf.checkin_id,
MONTHNAME(cin.operasi_time) as monthname,
month(cin.operasi_time) as month,
year(cin.operasi_time) as year,
( select user_id from anak_asuh asu where cin.fleet_id = asu.fleet_id and asu.status = 1 limit 0,1) as bapak_asuh ,
(select count(id) from anak_asuh asus where asus.user_id = bapak_asuh and asus.status = 1  ) as total_anakasuh,
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
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time),  bapak_asuh  , cin.pool_id , pool
order by cin.operasi_time desc  
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
