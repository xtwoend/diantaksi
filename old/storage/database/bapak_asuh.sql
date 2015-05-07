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

-- Dumping structure for view db2.bapak_asuh
DROP VIEW IF EXISTS `bapak_asuh`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `bapak_asuh` (
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
	`nip` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`name` VARCHAR(200) NOT NULL COLLATE 'latin1_swedish_ci',
	`taxi_number` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`fleet_model_id` INT(11) NOT NULL,
	`checkin_id` INT(11) NULL,
	`kode` VARCHAR(2) NULL COLLATE 'latin1_swedish_ci',
	`shift` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`setoran_wajib` DECIMAL(15,2) NULL,
	`tabungan_sparepart` DECIMAL(15,2) NULL,
	`denda` DECIMAL(15,2) NULL,
	`potongan` DECIMAL(15,2) NULL,
	`cicilan_sparepart` DECIMAL(15,2) NULL,
	`cicilan_ks` DECIMAL(15,2) NULL,
	`biaya_cuci` DECIMAL(15,2) NULL,
	`iuran_laka` DECIMAL(15,2) NULL,
	`cicilan_dp_kso` DECIMAL(15,2) NULL,
	`cicilan_hutang_lama` DECIMAL(15,2) NULL,
	`ks` DECIMAL(15,2) NULL,
	`cicilan_lain` DECIMAL(15,2) NULL,
	`hutang_dp_sparepart` DECIMAL(15,2) NULL,
	`setoran_cash` DECIMAL(15,2) NULL,
	`tabungan` DECIMAL(15,2) NULL,
	`bapak_asuh` BIGINT(11) NULL
) ENGINE=MyISAM;


-- Dumping structure for view db2.bapak_asuh
DROP VIEW IF EXISTS `bapak_asuh`;
-- Menghapus tabel sementara dan menciptakan struktur VIEW terakhir
DROP TABLE IF EXISTS `bapak_asuh`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `db2`.`bapak_asuh` AS select *, ( select user_id from anak_asuh asu where fr.fleet_id = asu.fleet_id and asu.status = 1) as bapak_asuh from financial_report_daily fr ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
