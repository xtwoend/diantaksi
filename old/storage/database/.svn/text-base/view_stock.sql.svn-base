-- Dumping structure for view db2.stock_sp
DROP VIEW IF EXISTS `stock_sp`;

CREATE VIEW `stock_sp` AS SELECT s.id as stock_id,sp.name_sparepart, sp.part_number, sp.barcode, sp.base_price, sp.price, sp.moving, sp.sp_categories_id, sp.satuan, sp.isi_satuan,
p.pool_name, s.qty, s.min_qty, s.sale_price, s.sale_on, s.note, s.pool_id, s.sparepart_id , s.created_at, s.updated_at, s.user_id
FROM stocks s join spareparts sp ON (s.sparepart_id = sp.id) 
join pools p ON (s.pool_id = p.id) ;