-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.20-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-22 08:29:36
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
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
