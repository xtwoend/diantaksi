-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-05-14 11:32:50
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for view db2.financial_report_summary
DROP VIEW IF EXISTS `financial_report_summary`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_summary` (
	`id` INT(11) NOT NULL DEFAULT '0',
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
	`fg_bs` INT(11) NULL DEFAULT NULL COMMENT '1: bs 0:tidak',
	`nip` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`name` VARCHAR(200) NOT NULL COLLATE 'latin1_swedish_ci',
	`taxi_number` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`checkin_id` INT(11) NULL DEFAULT NULL,
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
	`setoran_cash` DECIMAL(37,2) NULL DEFAULT NULL
) ENGINE=MyISAM;


-- Dumping structure for view db2.financial_report_summary
DROP VIEW IF EXISTS `financial_report_summary`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_summary`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_summary` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join drivers d on (cin.driver_id = d.id) 
join fleets f on (cin.fleet_id = f.id)
group by cin.pool_id, cin.operasi_time ;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
