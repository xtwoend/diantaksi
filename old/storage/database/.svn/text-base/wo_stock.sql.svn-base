
-- Dumping structure for table db2.stocks
DROP TABLE IF EXISTS `stocks`;
CREATE TABLE IF NOT EXISTS `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) DEFAULT NULL,
  `sparepart_id` int(11) DEFAULT NULL,
  `min_qty` int(11) DEFAULT '0',
  `sale_price` int(11) DEFAULT '0',
  `discount` int(11) DEFAULT '0',
  `sale_on` int(11) DEFAULT '0',
  `qty` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pool_id_sparepart_id` (`pool_id`,`sparepart_id`)
) ENGINE=InnoDB; 

-- Dumping structure for table db2.tracking_inventories
DROP TABLE IF EXISTS `tracking_inventories`;
CREATE TABLE IF NOT EXISTS `tracking_inventories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) DEFAULT NULL,
  `sparepart_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;


-- Dumping structure for view db2.stock_sp
DROP VIEW IF EXISTS `stock_sp`;
-- Removing temporary table and create final VIEW structure
CREATE VIEW `stock_sp` AS SELECT s.id as stock_id,sp.name_sparepart, sp.part_number, sp.barcode, sp.base_price, sp.price, sp.moving, sp.sp_categories_id, sp.satuan, sp.isi_satuan,
p.pool_name, s.qty, s.min_qty, s.sale_price, s.sale_on, s.note, s.pool_id, s.sparepart_id , s.created_at, s.updated_at
FROM stocks s join spareparts sp ON (s.sparepart_id = sp.id) 
join pools p ON (s.pool_id = p.id) ;


-- Dumping structure for view db2.wo_financial_report_bykso
DROP VIEW IF EXISTS `wo_financial_report_bykso`;

CREATE VIEW `wo_financial_report_bykso` AS select 
wo.*,
sum((part.qty * part.price)) as pemakaian_part
from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id )
where wo.status = 3 and part.telah_dikeluarkan = 1
group by wo.kso_id ;


-- Dumping structure for view db2.wo_financial_report_daily
DROP VIEW IF EXISTS `wo_financial_report_daily`;

CREATE VIEW `wo_financial_report_daily` AS select 
wo.*,
sum((part.qty * part.price)) as pemakaian_part
from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id ) 
where wo.status = 3 and part.telah_dikeluarkan = 1
group by wo.id ;


-- Dumping structure for view db2.wo_financial_report_monthly_bykso
DROP VIEW IF EXISTS `wo_financial_report_monthly_bykso`;

CREATE VIEW `wo_financial_report_monthly_bykso` AS select 
wo.*,
monthname(wo.inserted_date_set) as monthname,
month(wo.inserted_date_set) as month,
year(wo.inserted_date_set) as year,
sum((part.qty * part.price)) as pemakaian_part
from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id ) 
where wo.status = 3 and part.telah_dikeluarkan = 1
group by month, wo.kso_id , wo.id ;


-- Dumping structure for view db2.wo_financial_report_monthly_fleet
DROP VIEW IF EXISTS `wo_financial_report_monthly_fleet`;
CREATE VIEW `wo_financial_report_monthly_fleet` AS select 
wo.*,
monthname(wo.inserted_date_set) as monthname,
month(wo.inserted_date_set) as month,
year(wo.inserted_date_set) as year,
sum((part.qty * part.price)) as pemakaian_part
from work_orders wo left join wo_part_items part on ( wo.id = part.wo_id ) 
where wo.status = 3 and part.telah_dikeluarkan = 1
group by month, wo.fleet_id , wo.id ;


-- Dumping structure for view db2.wo_listparts
DROP VIEW IF EXISTS `wo_listparts`;
CREATE VIEW `wo_listparts` AS SELECT wo.*,item.sparepart_id, item.qty, item.price , sp.part_number, sp.name_sparepart, sp.satuan, sp.isi_satuan ,
month(wo.inserted_date_set) as month, year(wo.inserted_date_set) as year,
(item.qty * item.price) as subtotal
from wo_part_items item 
join work_orders wo on( item.wo_id = wo.id )
join spareparts sp on (item.sparepart_id = sp.id)
where wo.status = 3 and item.telah_dikeluarkan = 1 ;