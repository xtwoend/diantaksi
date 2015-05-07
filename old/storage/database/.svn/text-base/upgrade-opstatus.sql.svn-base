-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.20-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-13 13:56:11
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table diantaksi.operasi_status
DROP TABLE IF EXISTS `operasi_status`;
CREATE TABLE IF NOT EXISTS `operasi_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(2) DEFAULT NULL,
  `operasi_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table diantaksi.operasi_status: ~7 rows (approximately)
/*!40000 ALTER TABLE `operasi_status` DISABLE KEYS */;
INSERT INTO `operasi_status` (`id`, `kode`, `operasi_status`) VALUES
	(1, 'OK', 'Beroperasi'),
	(2, 'TP', 'Tanpa Pengemudi'),
	(3, 'BP', 'Belum Pulang'),
	(4, 'TL', 'Tidak Layak Jalan'),
	(5, 'BS', 'Bebas Setor'),
	(6, 'LL', 'Lain - Lain'),
	(7, 'BL', 'Blocking');
/*!40000 ALTER TABLE `operasi_status` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
