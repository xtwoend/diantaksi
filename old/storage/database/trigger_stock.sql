-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for trigger db2.update_stock
DROP TRIGGER IF EXISTS `update_stock`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `update_stock` BEFORE INSERT ON `tracking_inventories` FOR EACH ROW BEGIN
	UPDATE stocks s SET s.qty = s.qty + (NEW.qty) WHERE s.pool_id = NEW.pool_id AND s.sparepart_id = NEW.sparepart_id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;