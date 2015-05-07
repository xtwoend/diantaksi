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

-- Dumping structure for table db2.purchase_requests
DROP TABLE IF EXISTS `purchase_requests`;
CREATE TABLE IF NOT EXISTS `purchase_requests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `no_doc` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `tanggal_order` date DEFAULT NULL,
  `tanggal_terima` date DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `catatan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_doc` (`no_doc`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table db2.purchase_requests: ~14 rows (approximately)
/*!40000 ALTER TABLE `purchase_requests` DISABLE KEYS */;
INSERT INTO `purchase_requests` (`id`, `no_doc`, `status`, `tanggal_order`, `tanggal_terima`, `user_id`, `update_time`, `catatan`) VALUES
	(1, 'DT-00001/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '7', '2013-06-24 14:51:59', ''),
	(2, 'DT-00002/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '7', '2013-06-24 14:54:33', 'Test\n'),
	(3, 'DT-00003/SPP/06/2013', 0, '2013-06-24', '2013-06-27', '7', '2013-06-24 14:57:32', 'test'),
	(4, 'DT-00004/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:22:36', ''),
	(5, 'DT-00005/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:23:47', 'asd'),
	(6, 'DT-00006/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:24:37', 'asd'),
	(7, 'DT-00007/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:25:35', ''),
	(8, 'DT-00008/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:28:16', 'asd'),
	(9, 'DT-00009/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:29:30', 'as'),
	(10, 'DT-00010/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:30:13', 'C\n\n'),
	(11, 'DT-00011/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:32:51', ''),
	(12, 'DT-00012/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:34:48', 'Catatan'),
	(13, 'DT-00013/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:35:59', 'asd'),
	(14, 'DT-00014/SPP/06/2013', 0, '2013-06-24', '2013-06-24', '1', '2013-06-24 15:55:40', '');
/*!40000 ALTER TABLE `purchase_requests` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
