-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.20-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-22 08:24:46
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table diantaksi.baps
DROP TABLE IF EXISTS `baps`;
CREATE TABLE IF NOT EXISTS `baps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `bap_number` varchar(100) NOT NULL,
  `besar_ks` decimal(15,2) NOT NULL,
  `bayar_ks` decimal(15,2) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `driver_status` varchar(11) NOT NULL,
  `keputusan_id` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `sum_sparepart` decimal(15,2) NOT NULL,
  `sum_ks` decimal(15,2) NOT NULL,
  `sum_akhir_unit` decimal(15,2) NOT NULL,
  `lampiran` varchar(200) NOT NULL,
  `std_bap_id` varchar(100) NOT NULL,
  `ket_bap_other` varchar(200) NOT NULL,
  `keterangan` text NOT NULL,
  `solusi` text NOT NULL,
  `saksi_id` varchar(100) NOT NULL,
  `saksi1_name` varchar(100) NOT NULL,
  `saksi1_nik` varchar(100) NOT NULL,
  `saksi1_jabatan` varchar(100) NOT NULL,
  `saksi2_name` varchar(100) NOT NULL,
  `saksi2_nik` varchar(100) NOT NULL,
  `saksi2_jabatan` varchar(100) NOT NULL,
  `verifikasi_1` int(11) NOT NULL DEFAULT '0',
  `verifikasi_2` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bap_number` (`bap_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.blockeds
DROP TABLE IF EXISTS `blockeds`;
CREATE TABLE IF NOT EXISTS `blockeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) DEFAULT NULL,
  `std_bap_id` int(11) DEFAULT NULL,
  `fleet_id` int(11) DEFAULT NULL,
  `blocked_status_id` int(11) NOT NULL DEFAULT '0',
  `checkin_id` int(11) NOT NULL DEFAULT '0',
  `proses` int(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_proses` datetime NOT NULL,
  `date` datetime DEFAULT NULL,
  `note` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.blocked_status
DROP TABLE IF EXISTS `blocked_status`;
CREATE TABLE IF NOT EXISTS `blocked_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.checkins
DROP TABLE IF EXISTS `checkins`;
CREATE TABLE IF NOT EXISTS `checkins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kso_id` int(11) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `checkin_time` datetime NOT NULL,
  `shift_id` int(11) NOT NULL,
  `km_fleet` int(11) NOT NULL,
  `operasi_time` date NOT NULL,
  `pool_id` int(11) NOT NULL,
  `operasi_status_id` int(11) NOT NULL DEFAULT '0',
  `fg_late` int(11) NOT NULL,
  `checkin_step_id` int(11) NOT NULL,
  `document_check_user_id` int(11) NOT NULL,
  `physic_check_user_id` int(11) NOT NULL,
  `bengkel_check_user_id` int(11) NOT NULL,
  `finance_check_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unix_ops` (`fleet_id`,`operasi_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.checkin_bengkels
DROP TABLE IF EXISTS `checkin_bengkels`;
CREATE TABLE IF NOT EXISTS `checkin_bengkels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(11) NOT NULL,
  `sparepart_id` varchar(11) NOT NULL,
  `jumlah` varchar(11) NOT NULL,
  `analisa` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.checkin_documents
DROP TABLE IF EXISTS `checkin_documents`;
CREATE TABLE IF NOT EXISTS `checkin_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(11) NOT NULL,
  `std_document_id` varchar(100) NOT NULL,
  `std_neats_id` varchar(100) NOT NULL,
  `std_equip_id` varchar(100) NOT NULL,
  `ket` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.checkin_financials
DROP TABLE IF EXISTS `checkin_financials`;
CREATE TABLE IF NOT EXISTS `checkin_financials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(11) NOT NULL,
  `financial_type_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checkin_id` (`checkin_id`,`financial_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.checkin_physics
DROP TABLE IF EXISTS `checkin_physics`;
CREATE TABLE IF NOT EXISTS `checkin_physics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(11) NOT NULL,
  `sparepart_id` varchar(1000) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.checkin_steps
DROP TABLE IF EXISTS `checkin_steps`;
CREATE TABLE IF NOT EXISTS `checkin_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_step` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.checkouts
DROP TABLE IF EXISTS `checkouts`;
CREATE TABLE IF NOT EXISTS `checkouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kso_id` int(11) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `operasi_time` date NOT NULL,
  `checkout_time` datetime NOT NULL,
  `checkout_step_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `std_neat_id` varchar(100) NOT NULL COMMENT 'kerapihan supir',
  `std_doc_id` varchar(100) NOT NULL COMMENT 'kelengkapan dokumen',
  `std_doc_ket` varchar(200) DEFAULT NULL,
  `std_equip_id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `security_check_user_id` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `std_physic_id` int(11) NOT NULL,
  `fg_late` int(11) NOT NULL,
  `printspj_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fleet_operation` (`fleet_id`,`operasi_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.checkout_steps
DROP TABLE IF EXISTS `checkout_steps`;
CREATE TABLE IF NOT EXISTS `checkout_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkout_step` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.cities
DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.customers
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city_id` int(11) NOT NULL,
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.customer_address
DROP TABLE IF EXISTS `customer_address`;
CREATE TABLE IF NOT EXISTS `customer_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `category` varchar(10) DEFAULT NULL,
  `address` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.drivers
DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `ktp` varchar(100) NOT NULL,
  `sim` varchar(100) NOT NULL,
  `brith_place` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(250) NOT NULL,
  `city_id` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `join_date` date NOT NULL,
  `driver_status` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `fg_blocked` int(11) NOT NULL,
  `fg_super_blocked` int(11) NOT NULL DEFAULT '0',
  `fg_laka` int(11) NOT NULL DEFAULT '0',
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nip` (`nip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.driver_financials
DROP TABLE IF EXISTS `driver_financials`;
CREATE TABLE IF NOT EXISTS `driver_financials` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `driver_id` int(10) DEFAULT NULL,
  `financial_type_id` int(10) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.driver_status
DROP TABLE IF EXISTS `driver_status`;
CREATE TABLE IF NOT EXISTS `driver_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.driver_types
DROP TABLE IF EXISTS `driver_types`;
CREATE TABLE IF NOT EXISTS `driver_types` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for view diantaksi.financial_report_bykso
DROP VIEW IF EXISTS `financial_report_bykso`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_bykso` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
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


-- Dumping structure for view diantaksi.financial_report_driver
DROP VIEW IF EXISTS `financial_report_driver`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_driver` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`operasi_status_id` INT(11) NOT NULL DEFAULT '0',
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
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


-- Dumping structure for view diantaksi.financial_report_fleet
DROP VIEW IF EXISTS `financial_report_fleet`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_fleet` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`operasi_status_id` INT(11) NOT NULL DEFAULT '0',
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
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


-- Dumping structure for view diantaksi.financial_report_monthly_bykso
DROP VIEW IF EXISTS `financial_report_monthly_bykso`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_monthly_bykso` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`checkin_id` INT(11) NULL DEFAULT NULL,
	`monthname` VARCHAR(9) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`month` INT(2) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
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


-- Dumping structure for view diantaksi.financial_report_monthly_driver
DROP VIEW IF EXISTS `financial_report_monthly_driver`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_monthly_driver` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`checkin_id` INT(11) NULL DEFAULT NULL,
	`monthname` VARCHAR(9) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`month` INT(2) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
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


-- Dumping structure for view diantaksi.financial_report_monthly_fleet
DROP VIEW IF EXISTS `financial_report_monthly_fleet`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_monthly_fleet` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`checkin_id` INT(11) NULL DEFAULT NULL,
	`monthname` VARCHAR(9) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`month` INT(2) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
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


-- Dumping structure for view diantaksi.financial_report_years_bykso
DROP VIEW IF EXISTS `financial_report_years_bykso`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_years_bykso` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`checkin_id` INT(11) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
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


-- Dumping structure for view diantaksi.financial_report_years_driver
DROP VIEW IF EXISTS `financial_report_years_driver`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_years_driver` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`checkin_id` INT(11) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
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


-- Dumping structure for view diantaksi.financial_report_years_fleet
DROP VIEW IF EXISTS `financial_report_years_fleet`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `financial_report_years_fleet` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(11) NOT NULL,
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`checkin_time` DATETIME NOT NULL,
	`shift_id` INT(11) NOT NULL,
	`km_fleet` INT(11) NOT NULL,
	`operasi_time` DATE NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`fg_late` INT(11) NOT NULL,
	`checkin_step_id` INT(11) NOT NULL,
	`document_check_user_id` INT(11) NOT NULL,
	`physic_check_user_id` INT(11) NOT NULL,
	`bengkel_check_user_id` INT(11) NOT NULL,
	`finance_check_user_id` INT(11) NOT NULL,
	`checkin_id` INT(11) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
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


-- Dumping structure for table diantaksi.financial_types
DROP TABLE IF EXISTS `financial_types`;
CREATE TABLE IF NOT EXISTS `financial_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `financial_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleets
DROP TABLE IF EXISTS `fleets`;
CREATE TABLE IF NOT EXISTS `fleets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) NOT NULL,
  `taxi_number` varchar(100) NOT NULL,
  `fleet_brand_id` int(11) NOT NULL,
  `fleet_model_id` int(11) NOT NULL,
  `engine_number` varchar(100) NOT NULL,
  `chassis_number` varchar(100) NOT NULL,
  `fleet_year_id` int(11) NOT NULL,
  `fleet_color_id` int(11) NOT NULL,
  `police_number` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `fg_status` int(11) NOT NULL COMMENT '1:Armada Didalam Pool, 2:Armada Diluar Pool',
  `fg_check` int(11) NOT NULL COMMENT '1 : Dalam Proses Checkout 2: Dalam Proses Check In',
  `fg_blocked` int(11) NOT NULL DEFAULT '0' COMMENT '0 : normal 1: Dalam Proses Blocking',
  `fg_bengkel` int(11) NOT NULL COMMENT '0: Armada Diluar Bengkel 1:Armada Di Bengkel',
  `fg_group` int(11) NOT NULL COMMENT '0: Armada Diluar Bengkel 1:Armada Di Bengkel',
  `fg_kso` int(10) NOT NULL DEFAULT '0',
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  `last_km` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_brands
DROP TABLE IF EXISTS `fleet_brands`;
CREATE TABLE IF NOT EXISTS `fleet_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_brand` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_checks
DROP TABLE IF EXISTS `fleet_checks`;
CREATE TABLE IF NOT EXISTS `fleet_checks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `security_check_id` int(11) NOT NULL,
  `fisik_check_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_colors
DROP TABLE IF EXISTS `fleet_colors`;
CREATE TABLE IF NOT EXISTS `fleet_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_color` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_drivers
DROP TABLE IF EXISTS `fleet_drivers`;
CREATE TABLE IF NOT EXISTS `fleet_drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `fg_type` int(11) NOT NULL COMMENT '1: charlie, 2:bravo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_financials
DROP TABLE IF EXISTS `fleet_financials`;
CREATE TABLE IF NOT EXISTS `fleet_financials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(10) DEFAULT NULL,
  `financial_type_id` int(10) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_licenses
DROP TABLE IF EXISTS `fleet_licenses`;
CREATE TABLE IF NOT EXISTS `fleet_licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `fleet_license_type_id` int(11) NOT NULL,
  `license_number` varchar(100) NOT NULL,
  `validtrough` date NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_license_types
DROP TABLE IF EXISTS `fleet_license_types`;
CREATE TABLE IF NOT EXISTS `fleet_license_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_license_type` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_location_updates
DROP TABLE IF EXISTS `fleet_location_updates`;
CREATE TABLE IF NOT EXISTS `fleet_location_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `location` varchar(200) NOT NULL,
  `time_lookup` datetime NOT NULL,
  `time_inserted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_models
DROP TABLE IF EXISTS `fleet_models`;
CREATE TABLE IF NOT EXISTS `fleet_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_brand_id` int(11) NOT NULL,
  `fleet_model` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_repairs
DROP TABLE IF EXISTS `fleet_repairs`;
CREATE TABLE IF NOT EXISTS `fleet_repairs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_check_id` int(11) NOT NULL,
  `request_sparepart_id` int(11) NOT NULL,
  `fg_done` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.fleet_years
DROP TABLE IF EXISTS `fleet_years`;
CREATE TABLE IF NOT EXISTS `fleet_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.inventory
DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) DEFAULT NULL,
  `sparepart_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pool_id` (`pool_id`,`sparepart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.keputusan_baps
DROP TABLE IF EXISTS `keputusan_baps`;
CREATE TABLE IF NOT EXISTS `keputusan_baps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keputusan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.kewajibans
DROP TABLE IF EXISTS `kewajibans`;
CREATE TABLE IF NOT EXISTS `kewajibans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `financial_type_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.ksos
DROP TABLE IF EXISTS `ksos`;
CREATE TABLE IF NOT EXISTS `ksos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kso_number` varchar(100) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `bravo_driver_id` int(100) NOT NULL,
  `charlie_driver_id` int(100) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `dp` decimal(15,2) NOT NULL,
  `sisa_dp` decimal(15,2) NOT NULL,
  `sisa_kewajiban` decimal(15,2) NOT NULL,
  `setoran` decimal(15,2) NOT NULL,
  `tab_sparepart` decimal(15,2) NOT NULL,
  `ops_start` date NOT NULL,
  `ops_end` date NOT NULL,
  `attachment` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL,
  `actived` int(10) DEFAULT NULL,
  `kso_type_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.kso_types
DROP TABLE IF EXISTS `kso_types`;
CREATE TABLE IF NOT EXISTS `kso_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.months
DROP TABLE IF EXISTS `months`;
CREATE TABLE IF NOT EXISTS `months` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.open_blocking
DROP TABLE IF EXISTS `open_blocking`;
CREATE TABLE IF NOT EXISTS `open_blocking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bap_id` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `otorisasi1_id` int(11) DEFAULT NULL,
  `otorisasi2_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bap_id` (`bap_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.operasi_status
DROP TABLE IF EXISTS `operasi_status`;
CREATE TABLE IF NOT EXISTS `operasi_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(2) DEFAULT NULL,
  `operasi_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `from_address` varchar(250) NOT NULL,
  `to_address` varchar(250) NOT NULL,
  `shuttle_time` datetime NOT NULL,
  `fleet_id` int(11) DEFAULT NULL,
  `order_status_id` int(11) DEFAULT NULL,
  `cancellation_message` text,
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.order_spareparts
DROP TABLE IF EXISTS `order_spareparts`;
CREATE TABLE IF NOT EXISTS `order_spareparts` (
  `id` int(11) NOT NULL,
  `fg_order_type` int(11) NOT NULL COMMENT '1 : Check Out, 2:Check In, 3: Lain-lain',
  `related_id` int(11) NOT NULL,
  `sparepart_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL COMMENT 'satuan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.order_status
DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.other_payments
DROP TABLE IF EXISTS `other_payments`;
CREATE TABLE IF NOT EXISTS `other_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) DEFAULT NULL,
  `financial_type_id` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.payment_cuts
DROP TABLE IF EXISTS `payment_cuts`;
CREATE TABLE IF NOT EXISTS `payment_cuts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pool_id` int(10) DEFAULT NULL,
  `financial_type_id` int(10) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.pools
DROP TABLE IF EXISTS `pools`;
CREATE TABLE IF NOT EXISTS `pools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_name` varchar(200) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city_id` int(11) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `code_pool` varchar(8) NOT NULL,
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.request_spareparts
DROP TABLE IF EXISTS `request_spareparts`;
CREATE TABLE IF NOT EXISTS `request_spareparts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `sparepart_id` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `fg_check` int(11) NOT NULL COMMENT '0:Belum Cek, 1:Cek',
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.role_user
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.schedules
DROP TABLE IF EXISTS `schedules`;
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `schedule_master_id` int(11) NOT NULL,
  `month` int(100) NOT NULL,
  `year` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.schedule_dates
DROP TABLE IF EXISTS `schedule_dates`;
CREATE TABLE IF NOT EXISTS `schedule_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `fg_check` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.schedule_fleet_groups
DROP TABLE IF EXISTS `schedule_fleet_groups`;
CREATE TABLE IF NOT EXISTS `schedule_fleet_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) DEFAULT NULL,
  `schedule_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.schedule_groups
DROP TABLE IF EXISTS `schedule_groups`;
CREATE TABLE IF NOT EXISTS `schedule_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group` int(10) DEFAULT NULL,
  `schedule_master_id` int(10) DEFAULT NULL,
  `pool_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.schedule_masters
DROP TABLE IF EXISTS `schedule_masters`;
CREATE TABLE IF NOT EXISTS `schedule_masters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  `bravo_interval` int(10) DEFAULT NULL,
  `charlie_interval` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.schedule_master_dates
DROP TABLE IF EXISTS `schedule_master_dates`;
CREATE TABLE IF NOT EXISTS `schedule_master_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_master_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `fg_bravo_charlie` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.shifts
DROP TABLE IF EXISTS `shifts`;
CREATE TABLE IF NOT EXISTS `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shift` varchar(100) NOT NULL,
  `jam_checkin` time NOT NULL,
  `ci_adjust` int(11) NOT NULL COMMENT 'in minutes',
  `jam_checkout` time NOT NULL,
  `co_adjust` int(11) NOT NULL COMMENT 'in minutes',
  `inserted_date_set` datetime NOT NULL,
  `spj_print_start` time DEFAULT NULL,
  `spj_print_end` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.spareparts
DROP TABLE IF EXISTS `spareparts`;
CREATE TABLE IF NOT EXISTS `spareparts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_sparepart` varchar(100) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `part_number` varchar(50) NOT NULL,
  `sp_categories_id` int(11) NOT NULL,
  `base_price` decimal(15,2) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `min_qty` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_part` (`part_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.sp_categories
DROP TABLE IF EXISTS `sp_categories`;
CREATE TABLE IF NOT EXISTS `sp_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.status_perbaikan
DROP TABLE IF EXISTS `status_perbaikan`;
CREATE TABLE IF NOT EXISTS `status_perbaikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.std_baps
DROP TABLE IF EXISTS `std_baps`;
CREATE TABLE IF NOT EXISTS `std_baps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_bap` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.std_docs
DROP TABLE IF EXISTS `std_docs`;
CREATE TABLE IF NOT EXISTS `std_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_doc` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.std_equips
DROP TABLE IF EXISTS `std_equips`;
CREATE TABLE IF NOT EXISTS `std_equips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_equip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.std_fleets
DROP TABLE IF EXISTS `std_fleets`;
CREATE TABLE IF NOT EXISTS `std_fleets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_sparepart` varchar(100) NOT NULL,
  `sp_categories_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.std_fleet_categories
DROP TABLE IF EXISTS `std_fleet_categories`;
CREATE TABLE IF NOT EXISTS `std_fleet_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.std_neats
DROP TABLE IF EXISTS `std_neats`;
CREATE TABLE IF NOT EXISTS `std_neats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_neat` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `nik` varchar(7) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `last_login` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.work_orders
DROP TABLE IF EXISTS `work_orders`;
CREATE TABLE IF NOT EXISTS `work_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kso_id` int(10) DEFAULT NULL,
  `wo_number` varchar(50) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `km` int(11) NOT NULL,
  `complaint` text NOT NULL,
  `information_complaint` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: belum di perbaiki  2: sedang di perbaiki 3: selesai di perbaiki 4: menunggu',
  `mechanic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  `finished_date_set` datetime DEFAULT NULL,
  `fg_part_approved` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.wo_analisa_item
DROP TABLE IF EXISTS `wo_analisa_item`;
CREATE TABLE IF NOT EXISTS `wo_analisa_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `wo_id` int(10) DEFAULT NULL,
  `analisa` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for view diantaksi.wo_financial_report_bykso
DROP VIEW IF EXISTS `wo_financial_report_bykso`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `wo_financial_report_bykso` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(10) NULL DEFAULT NULL,
	`wo_number` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`km` INT(11) NOT NULL,
	`complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`information_complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`status` INT(11) NOT NULL DEFAULT '1' COMMENT '1: belum di perbaiki  2: sedang di perbaiki 3: selesai di perbaiki 4: menunggu',
	`mechanic_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`inserted_date_set` DATETIME NOT NULL,
	`pemakaian_part` DECIMAL(42,2) NULL DEFAULT NULL
) ENGINE=MyISAM;


-- Dumping structure for view diantaksi.wo_financial_report_daily
DROP VIEW IF EXISTS `wo_financial_report_daily`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `wo_financial_report_daily` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(10) NULL DEFAULT NULL,
	`wo_number` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`km` INT(11) NOT NULL,
	`complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`information_complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`status` INT(11) NOT NULL DEFAULT '1' COMMENT '1: belum di perbaiki  2: sedang di perbaiki 3: selesai di perbaiki 4: menunggu',
	`mechanic_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`inserted_date_set` DATETIME NOT NULL,
	`pemakaian_part` DECIMAL(42,2) NULL DEFAULT NULL
) ENGINE=MyISAM;


-- Dumping structure for view diantaksi.wo_financial_report_monthly_bykso
DROP VIEW IF EXISTS `wo_financial_report_monthly_bykso`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `wo_financial_report_monthly_bykso` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(10) NULL DEFAULT NULL,
	`wo_number` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`km` INT(11) NOT NULL,
	`complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`information_complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`status` INT(11) NOT NULL DEFAULT '1' COMMENT '1: belum di perbaiki  2: sedang di perbaiki 3: selesai di perbaiki 4: menunggu',
	`mechanic_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`inserted_date_set` DATETIME NOT NULL,
	`monthname` VARCHAR(9) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`month` INT(2) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
	`pemakaian_part` DECIMAL(42,2) NULL DEFAULT NULL
) ENGINE=MyISAM;


-- Dumping structure for view diantaksi.wo_financial_report_monthly_fleet
DROP VIEW IF EXISTS `wo_financial_report_monthly_fleet`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `wo_financial_report_monthly_fleet` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(10) NULL DEFAULT NULL,
	`wo_number` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`km` INT(11) NOT NULL,
	`complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`information_complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`status` INT(11) NOT NULL DEFAULT '1' COMMENT '1: belum di perbaiki  2: sedang di perbaiki 3: selesai di perbaiki 4: menunggu',
	`mechanic_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`inserted_date_set` DATETIME NOT NULL,
	`monthname` VARCHAR(9) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`month` INT(2) NULL DEFAULT NULL,
	`year` INT(4) NULL DEFAULT NULL,
	`pemakaian_part` DECIMAL(42,2) NULL DEFAULT NULL
) ENGINE=MyISAM;


-- Dumping structure for table diantaksi.wo_part_items
DROP TABLE IF EXISTS `wo_part_items`;
CREATE TABLE IF NOT EXISTS `wo_part_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wo_id` int(11) DEFAULT NULL,
  `sparepart_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table diantaksi.years
DROP TABLE IF EXISTS `years`;
CREATE TABLE IF NOT EXISTS `years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for view diantaksi.financial_report_bykso
DROP VIEW IF EXISTS `financial_report_bykso`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_bykso`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_bykso` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by cin.kso_id ;


-- Dumping structure for view diantaksi.financial_report_daily
DROP VIEW IF EXISTS `financial_report_daily`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_daily`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_daily` AS select 
cin.*,
d.nip,
d.name,
f.taxi_number,
cf.checkin_id,
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
group by cin.id ;


-- Dumping structure for view diantaksi.financial_report_driver
DROP VIEW IF EXISTS `financial_report_driver`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_driver`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_driver` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by cin.driver_id ;


-- Dumping structure for view diantaksi.financial_report_fleet
DROP VIEW IF EXISTS `financial_report_fleet`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_fleet`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_fleet` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by cin.fleet_id ;


-- Dumping structure for view diantaksi.financial_report_monthly_bykso
DROP VIEW IF EXISTS `financial_report_monthly_bykso`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_monthly_bykso`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_monthly_bykso` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.kso_id ;


-- Dumping structure for view diantaksi.financial_report_monthly_driver
DROP VIEW IF EXISTS `financial_report_monthly_driver`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_monthly_driver`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_monthly_driver` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.driver_id ;


-- Dumping structure for view diantaksi.financial_report_monthly_fleet
DROP VIEW IF EXISTS `financial_report_monthly_fleet`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_monthly_fleet`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_monthly_fleet` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time), cin.fleet_id ;


-- Dumping structure for view diantaksi.financial_report_years_bykso
DROP VIEW IF EXISTS `financial_report_years_bykso`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_years_bykso`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_years_bykso` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), cin.kso_id ;


-- Dumping structure for view diantaksi.financial_report_years_driver
DROP VIEW IF EXISTS `financial_report_years_driver`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_years_driver`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_years_driver` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), cin.driver_id ;


-- Dumping structure for view diantaksi.financial_report_years_fleet
DROP VIEW IF EXISTS `financial_report_years_fleet`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `financial_report_years_fleet`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `financial_report_years_fleet` AS select 
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
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by YEAR(cin.operasi_time), cin.fleet_id ;


-- Dumping structure for view diantaksi.wo_financial_report_bykso
DROP VIEW IF EXISTS `wo_financial_report_bykso`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `wo_financial_report_bykso`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `wo_financial_report_bykso` AS select 
wo.*,
sum((part.qty * part.price)) as pemakaian_part
from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id )
where wo.status = 3 
group by wo.kso_id ;


-- Dumping structure for view diantaksi.wo_financial_report_daily
DROP VIEW IF EXISTS `wo_financial_report_daily`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `wo_financial_report_daily`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `wo_financial_report_daily` AS select 
wo.*,
sum((part.qty * part.price)) as pemakaian_part
from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id ) 
where wo.status = 3
group by wo.id ;


-- Dumping structure for view diantaksi.wo_financial_report_monthly_bykso
DROP VIEW IF EXISTS `wo_financial_report_monthly_bykso`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `wo_financial_report_monthly_bykso`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `wo_financial_report_monthly_bykso` AS select 
wo.*,
monthname(wo.inserted_date_set) as monthname,
month(wo.inserted_date_set) as month,
year(wo.inserted_date_set) as year,
sum((part.qty * part.price)) as pemakaian_part
from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id ) 
where wo.status = 3
group by month, wo.kso_id , wo.id ;


-- Dumping structure for view diantaksi.wo_financial_report_monthly_fleet
DROP VIEW IF EXISTS `wo_financial_report_monthly_fleet`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `wo_financial_report_monthly_fleet`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` VIEW `wo_financial_report_monthly_fleet` AS select 
wo.*,
monthname(wo.inserted_date_set) as monthname,
month(wo.inserted_date_set) as month,
year(wo.inserted_date_set) as year,
sum((part.qty * part.price)) as pemakaian_part
from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id ) 
where wo.status = 3
group by month, wo.fleet_id , wo.id ;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
