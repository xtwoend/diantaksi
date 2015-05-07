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

-- Dumping structure for table db2.news
DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `expired` datetime DEFAULT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `message` text,
  `pool_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) NOT NULL DEFAULT '0',
  `msg_type` int(11) NOT NULL DEFAULT '1' COMMENT '1.BroadCast  2. Pool 3. User',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table db2.news: ~2 rows (approximately)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (`id`, `created_at`, `updated_at`, `expired`, `priority`, `message`, `pool_id`, `user_id`, `to_user_id`, `msg_type`) VALUES
	(1, '2013-09-03 15:20:06', NULL, '2013-09-03 15:27:59', 'label-info', 'e', NULL, 1, 0, 1),
	(2, '2013-09-03 15:27:43', '2013-09-03 15:27:44', '2013-09-04 15:27:59', 'label-important', 'Tolong Perhatikan Usernya', 1, 1, 1, 3),
	(3, '2013-09-04 11:07:26', '2013-09-04 11:07:26', '2013-09-04 12:00:00', 'label-info', 'It\'s easy to define your own custom Form class helpers called "macros". Here\'s how it works. First, simply register the macro with a given name and a Closure:', 0, 1, 0, 1),
	(7, '2013-09-04 12:01:31', '2013-09-04 12:01:31', '2013-09-04 13:00:15', 'label-warning', 'asdasdasdasd', 0, 1, 0, 1);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
