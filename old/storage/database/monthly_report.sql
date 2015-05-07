-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 5.5.24-log - MySQL Community Server (GPL)
-- OS Server:                    Win32
-- HeidiSQL Versi:               8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for view db2.financial_report_monthly_fleet
DROP VIEW IF EXISTS `financial_report_monthly_fleet`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_monthly_fleet` (
	`id` INT(11) NOT NULL,
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
	`operasi_status_id` INT(11) NOT NULL,
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`finance_time` DATETIME NOT NULL,
	`fg_bs` INT(11) NULL COMMENT '1: bs 0:tidak',
	`keterangan` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`taxi_number` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`checkin_id` INT(11) NULL,
	`monthname` VARCHAR(9) NULL COLLATE 'utf8_general_ci',
	`month` INT(2) NULL,
	`year` INT(4) NULL,
	`setoran_wajib` DECIMAL(37,2) NULL,
	`tabungan_sparepart` DECIMAL(37,2) NULL,
	`denda` DECIMAL(37,2) NULL,
	`potongan` DECIMAL(37,2) NULL,
	`cicilan_sparepart` DECIMAL(37,2) NULL,
	`cicilan_ks` DECIMAL(37,2) NULL,
	`biaya_cuci` DECIMAL(37,2) NULL,
	`iuran_laka` DECIMAL(37,2) NULL,
	`cicilan_dp_kso` DECIMAL(37,2) NULL,
	`cicilan_hutang_lama` DECIMAL(37,2) NULL,
	`ks` DECIMAL(37,2) NULL,
	`cicilan_lain` DECIMAL(37,2) NULL,
	`hutang_dp_sparepart` DECIMAL(37,2) NULL,
	`setoran_cash` DECIMAL(37,2) NULL,
	`tabungan` DECIMAL(37,2) NULL
) ENGINE=MyISAM;


-- Dumping structure for view db2.financial_report_monthly_fleet
DROP VIEW IF EXISTS `financial_report_monthly_fleet`;
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `financial_report_monthly_fleet`;
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
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join fleets f on (cin.fleet_id = f.id)
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.fleet_id ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
