-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.20-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-22 08:33:22
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

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
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
