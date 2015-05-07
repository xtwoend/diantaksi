-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-09-30 16:19:00
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for view db2.wo_listparts
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `wo_listparts` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`kso_id` INT(10) NULL DEFAULT NULL,
	`wo_number` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`fleet_id` INT(11) NOT NULL,
	`driver_id` INT(11) NOT NULL,
	`pool_id` INT(11) NOT NULL,
	`km` INT(11) NOT NULL,
	`complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`information_complaint` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`status` INT(11) NOT NULL DEFAULT '1' COMMENT '1: belum di perbaiki  2: sedang di perbaiki 3: selesai di perbaiki 4: menunggu 5:Batal',
	`mechanic_id` INT(11) NOT NULL,
	`mechanic` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`dp_sparepart` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`inserted_date_set` DATETIME NOT NULL,
	`finished_date_set` DATETIME NULL DEFAULT NULL,
	`fg_part_approved` INT(10) NOT NULL DEFAULT '0',
	`user_approved` INT(10) NULL DEFAULT NULL,
	`sparepart_id` INT(11) NULL DEFAULT NULL,
	`qty` INT(11) NULL DEFAULT NULL,
	`price` DECIMAL(10,2) NULL DEFAULT NULL,
	`part_number` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`name_sparepart` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`satuan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`isi_satuan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`month(wo.inserted_date_set)` INT(2) NULL DEFAULT NULL,
	`year(wo.inserted_date_set)` INT(4) NULL DEFAULT NULL
) ENGINE=MyISAM;


-- Dumping structure for view db2.wo_listparts
-- Removing temporary table and create final VIEW structure
DROP VIEW IF EXISTS `wo_listparts`;
CREATE VIEW `wo_listparts` AS 
SELECT wo.*,item.sparepart_id, item.qty, item.price , sp.part_number, sp.name_sparepart, sp.satuan, sp.isi_satuan ,
month(wo.inserted_date_set) as month, year(wo.inserted_date_set) as year,
(item.qty * item.price) as subtotal
from wo_part_items item 
join work_orders wo on( item.wo_id = wo.id )
join spareparts sp on (item.sparepart_id = sp.id)
where wo.status = 3 
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
