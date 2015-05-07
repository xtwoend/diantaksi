-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-04-23 14:25:39
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for view diantaksi.financial_report_daily
DROP VIEW IF EXISTS `financial_report_daily`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_daily` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`rit` INT(10) NULL DEFAULT NULL,
	`incomekm` INT(10) NULL DEFAULT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`operasi_status_id` INT(11) NOT NULL DEFAULT '0',
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`nip` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`name` VARCHAR(200) NOT NULL COLLATE 'latin1_swedish_ci',
	`taxi_number` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`checkin_id` INT(11) NULL DEFAULT NULL,
	`kode` VARCHAR(2) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	`setoran_wajib` DECIMAL(15,2) NULL DEFAULT NULL,
	`tabungan_sparepart` DECIMAL(15,2) NULL DEFAULT NULL,
	`denda` DECIMAL(15,2) NULL DEFAULT NULL,
	`potongan` DECIMAL(15,2) NULL DEFAULT NULL,
	`cicilan_sparepart` DECIMAL(15,2) NULL DEFAULT NULL,
	`cicilan_ks` DECIMAL(15,2) NULL DEFAULT NULL,
	`biaya_cuci` DECIMAL(15,2) NULL DEFAULT NULL,
	`iuran_laka` DECIMAL(15,2) NULL DEFAULT NULL,
	`cicilan_dp_kso` DECIMAL(15,2) NULL DEFAULT NULL,
	`cicilan_hutang_lama` DECIMAL(15,2) NULL DEFAULT NULL,
	`ks` DECIMAL(15,2) NULL DEFAULT NULL,
	`cicilan_lain` DECIMAL(15,2) NULL DEFAULT NULL,
	`hutang_dp_sparepart` DECIMAL(15,2) NULL DEFAULT NULL,
	`setoran_cash` DECIMAL(15,2) NULL DEFAULT NULL
) ENGINE=MyISAM;


-- Dumping structure for view diantaksi.financial_report_daily
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
max(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join drivers d on (cin.driver_id = d.id) 
join fleets f on (cin.fleet_id = f.id)
join operasi_status o on (cin.operasi_status_id = o.id)
group by cin.id ;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
