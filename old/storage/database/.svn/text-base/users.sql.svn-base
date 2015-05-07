-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.20-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-17 23:25:25
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table diantaksi.roles: ~6 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `slug`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'Administrator', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'kasir', 'Kasir', '2013-03-17 22:32:58', '2013-03-17 22:32:58'),
	(3, 'management', 'Management', '2013-03-17 22:33:11', '2013-03-17 22:33:11'),
	(4, 'gudang', 'Gudang', '2013-03-17 23:09:06', '2013-03-17 23:09:06'),
	(5, 'bengkel', 'Bengkel', '2013-03-17 23:10:06', '2013-03-17 23:10:06'),
	(6, 'operasi', 'Operasi', '2013-03-17 22:32:42', '2013-03-17 22:32:42');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- Dumping structure for table diantaksi.role_user
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table diantaksi.role_user: ~10 rows (approximately)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(5, 2, 2, '2013-03-17 22:33:54', '2013-03-17 22:33:54'),
	(7, 2, 6, '2013-03-17 22:54:05', '2013-03-17 22:54:05'),
	(10, 1, 2, '2013-03-17 23:12:19', '2013-03-17 23:12:19'),
	(11, 1, 3, '2013-03-17 23:12:19', '2013-03-17 23:12:19'),
	(12, 1, 4, '2013-03-17 23:12:19', '2013-03-17 23:12:19'),
	(13, 1, 5, '2013-03-17 23:12:19', '2013-03-17 23:12:19'),
	(14, 1, 6, '2013-03-17 23:12:19', '2013-03-17 23:12:19'),
	(15, 4, 6, '2013-03-17 23:13:43', '2013-03-17 23:13:43'),
	(17, 5, 2, '2013-03-17 23:15:48', '2013-03-17 23:15:48'),
	(18, 3, 3, '2013-03-17 23:16:48', '2013-03-17 23:16:48');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;


-- Dumping structure for table diantaksi.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table diantaksi.users: ~5 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `first_name`, `last_name`, `password`, `last_login`, `active`, `admin`, `pool_id`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@admin.com', 'Abdul', 'Anshari', '$2a$08$djBBTkVNaG9LWUdydEdYceKxtn6KDzjZa99Jq0myYVG1jOWg0huBS', '2013-03-17 23:20:56', 1, 1, 1, '2012-09-26 16:11:32', '2013-03-17 23:20:56'),
	(2, 'manado', 'manado@diantaksi.com', 'DT', 'Manado', '$2a$08$cWRUbXpEcG9lQlR5WUhVRuBfkHtcGPwJkhxvrSscsrBTPvOFJ3wam', '2013-03-17 23:12:36', 1, 0, 3, '2013-03-17 22:19:52', '2013-03-17 23:12:36'),
	(3, 'joko', 'joko@diantaksi.com', 'Joko', 'S', '$2a$08$VjAzTjRiQW9WZDQ1R1dxT.WO57x0rnSA/aciLhrH94RTjSANuYHjS', '2013-03-17 23:17:01', 1, 0, 3, '2013-03-17 23:06:05', '2013-03-17 23:17:01'),
	(4, 'ops_manado', 'ops_manado@diantaksi.com', 'Operasi', 'Manado', '$2a$08$ZXZwdjVaYmRCV1lZWEZIZeKwXQxHssTmttmh/UiKoS0spT6MYdo22', '2013-03-17 23:14:33', 1, 0, 3, '2013-03-17 23:13:43', '2013-03-17 23:14:33'),
	(5, 'kasir_manado', 'kasir_manado@diantaksi.com', 'Kasir', 'Manado', '$2a$08$VXlwUkZWUERrT1JldjJjb.2B3qwNrt1pDfdKV9kxsB7y4jk4XU/2y', '2013-03-17 23:15:55', 1, 0, 3, '2013-03-17 23:14:23', '2013-03-17 23:15:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
