-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table dian.ca_add_ons
CREATE TABLE IF NOT EXISTS `ca_add_ons` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `order` int(5) DEFAULT NULL,
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table dian.ca_add_ons: 0 rows
/*!40000 ALTER TABLE `ca_add_ons` DISABLE KEYS */;
/*!40000 ALTER TABLE `ca_add_ons` ENABLE KEYS */;


-- Dumping structure for table dian.ca_album
CREATE TABLE IF NOT EXISTS `ca_album` (
  `id` varchar(10) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `order` int(10) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_album: 1 rows
/*!40000 ALTER TABLE `ca_album` DISABLE KEYS */;
INSERT INTO `ca_album` (`id`, `name`, `description`, `order`, `publish`) VALUES
	('1343522666', 'Uncategory', '-', 1, '1');
/*!40000 ALTER TABLE `ca_album` ENABLE KEYS */;


-- Dumping structure for table dian.ca_categories
CREATE TABLE IF NOT EXISTS `ca_categories` (
  `id` varchar(10) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `meta_keyword` varchar(225) DEFAULT NULL,
  `meta_description` varchar(225) DEFAULT NULL,
  `permalink` varchar(100) DEFAULT NULL,
  `order` int(10) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_categories: 4 rows
/*!40000 ALTER TABLE `ca_categories` DISABLE KEYS */;
INSERT INTO `ca_categories` (`id`, `name`, `meta_keyword`, `meta_description`, `permalink`, `order`, `publish`) VALUES
	('8948759595', 'uncategory', 'uncategory', 'all about uncategory', 'uncategory', 2, '1'),
	('1348292247', 'blog', 'blog', 'blog', 'blog', 0, '1'),
	('1386128840', 'news', 'news, diantaksi, dian, taksi, transportasi', 'dian transportasi darat', 'news', 0, '1'),
	('1386129630', 'Events', 'events, diantaksi, dian, taksi, jakarta', 'kegiatan dian taksi', 'events', 0, '1');
/*!40000 ALTER TABLE `ca_categories` ENABLE KEYS */;


-- Dumping structure for table dian.ca_comments
CREATE TABLE IF NOT EXISTS `ca_comments` (
  `id` varchar(10) NOT NULL,
  `date` datetime DEFAULT NULL,
  `id_posts` varchar(10) DEFAULT NULL,
  `member_id` varchar(10) DEFAULT NULL,
  `content` text,
  `com_url` varchar(225) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `order` int(10) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_comments: 0 rows
/*!40000 ALTER TABLE `ca_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `ca_comments` ENABLE KEYS */;


-- Dumping structure for table dian.ca_gallery
CREATE TABLE IF NOT EXISTS `ca_gallery` (
  `id` varchar(10) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `img` varchar(225) DEFAULT 'codeanalytic_media_ca_thumb_small.jpg',
  `date` datetime DEFAULT NULL,
  `album_id` int(10) DEFAULT NULL,
  `description` varchar(225) DEFAULT NULL,
  `order` int(10) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_gallery: 0 rows
/*!40000 ALTER TABLE `ca_gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `ca_gallery` ENABLE KEYS */;


-- Dumping structure for table dian.ca_htmlarea
CREATE TABLE IF NOT EXISTS `ca_htmlarea` (
  `id` varchar(15) NOT NULL,
  `pos` smallint(1) NOT NULL,
  `title` varchar(100) NOT NULL,
  `html` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table dian.ca_htmlarea: 0 rows
/*!40000 ALTER TABLE `ca_htmlarea` DISABLE KEYS */;
/*!40000 ALTER TABLE `ca_htmlarea` ENABLE KEYS */;


-- Dumping structure for table dian.ca_ippoll
CREATE TABLE IF NOT EXISTS `ca_ippoll` (
  `ip` varchar(15) DEFAULT NULL,
  `pid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_ippoll: 2 rows
/*!40000 ALTER TABLE `ca_ippoll` DISABLE KEYS */;
INSERT INTO `ca_ippoll` (`ip`, `pid`) VALUES
	('192.168.0.6', 1),
	('192.168.0.4', 1);
/*!40000 ALTER TABLE `ca_ippoll` ENABLE KEYS */;


-- Dumping structure for table dian.ca_link
CREATE TABLE IF NOT EXISTS `ca_link` (
  `id` varchar(10) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `target` varchar(15) DEFAULT NULL,
  `attr_id` varchar(15) DEFAULT NULL,
  `attr_class` varchar(225) DEFAULT NULL,
  `order` int(10) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_link: 4 rows
/*!40000 ALTER TABLE `ca_link` DISABLE KEYS */;
INSERT INTO `ca_link` (`id`, `title`, `url`, `target`, `attr_id`, `attr_class`, `order`, `publish`) VALUES
	('1342404124', 'CodeAnalytic', 'http://www.codeanalytic.com', '_blank', '-', '-', 1, '1'),
	('1347987614', 'Twitter@CodeAnalytic', 'https://twitter.com/CodeAnalytic', '_blank', '-', '-', 2, '1'),
	('1347987662', 'Facebook@CodeAnlaytic', 'https://facebook.com/CodeAnalytic', '_blank', '-', '-', 3, '1'),
	('1347987694', 'Support', 'http://forum.codeanalytic.com', '_blank', '-', '-', 0, '1');
/*!40000 ALTER TABLE `ca_link` ENABLE KEYS */;


-- Dumping structure for table dian.ca_members
CREATE TABLE IF NOT EXISTS `ca_members` (
  `id` varchar(10) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `photo` varchar(100) DEFAULT 'default_ca_thumb_small.jpg',
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` enum('0','1') DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `born` date DEFAULT NULL,
  `about` varchar(225) DEFAULT NULL,
  `login_from` varchar(25) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_activated` enum('0','1') DEFAULT '0',
  `order` int(10) DEFAULT NULL,
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_members: 1 rows
/*!40000 ALTER TABLE `ca_members` DISABLE KEYS */;
INSERT INTO `ca_members` (`id`, `username`, `password`, `email`, `photo`, `first_name`, `last_name`, `gender`, `address`, `phone`, `born`, `about`, `login_from`, `last_login`, `is_activated`, `order`, `publish`) VALUES
	('uF3gO1shm4', 'noname', 'af74363590cf3797d6c6383aaa2750d4', 'noname@codeanalytic.com', '1346824383_ca_thumb_middle.png', '', '', '', '', '', '0000-00-00', '', '', '2012-09-05 05:41:26', '0', 0, '1');
/*!40000 ALTER TABLE `ca_members` ENABLE KEYS */;


-- Dumping structure for table dian.ca_members_statistic
CREATE TABLE IF NOT EXISTS `ca_members_statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(15) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table dian.ca_members_statistic: 0 rows
/*!40000 ALTER TABLE `ca_members_statistic` DISABLE KEYS */;
/*!40000 ALTER TABLE `ca_members_statistic` ENABLE KEYS */;


-- Dumping structure for table dian.ca_menu
CREATE TABLE IF NOT EXISTS `ca_menu` (
  `id` varchar(10) NOT NULL,
  `id_parent` varchar(10) DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `target` varchar(15) DEFAULT NULL,
  `attr_id` varchar(30) DEFAULT NULL,
  `attr_class` varchar(100) DEFAULT NULL,
  `order` int(10) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_menu: 16 rows
/*!40000 ALTER TABLE `ca_menu` DISABLE KEYS */;
INSERT INTO `ca_menu` (`id`, `id_parent`, `name`, `url`, `target`, `attr_id`, `attr_class`, `order`, `publish`) VALUES
	('1341930566', '0', 'home', '#home', '_self', 'home', 'external', 1, '1'),
	('1348119324', '0', 'News & Update', '#news-and-update', '_self', '-', '-', 11, '1'),
	('1385886807', '0', 'About Us', '#about', '_self', '', '', 2, '1'),
	('1385886987', '1385886807', 'Vision and Mission', 'vision-mission', '_self', '', '', 4, '1'),
	('1385887053', '1385886807', 'Board of Directors', 'board-of-directors', '_self', '', '', 5, '1'),
	('1385887082', '0', 'Career', '#career', '_self', '', '', 9, '1'),
	('1386130179', '1385886807', 'Company Profile', 'company-profile', '_self', '', 'external', 0, '1'),
	('1385887142', '0', 'Passenger Transportation', '#passenger-transportation', '_self', '', '', 6, '1'),
	('1385887163', '1385887082', 'Join Us', 'join-us', '_self', '', '', 11, '1'),
	('1385887211', '1385887142', 'Dian Taxi', 'dian-taksi', '_self', '', 'external', 7, '1'),
	('1385887241', '1385887142', 'Dian Bus', 'dian-bus', '_self', '', '', 8, '1'),
	('1385887288', '0', 'Contact Us', '#contact', '_self', '', '', 10, '1'),
	('1385887320', '0', 'Used Car Center', 'used-car-center', '_self', '', 'external', 10, '1'),
	('1386050441', '1385886807', 'Location', '#location', '_self', '', 'external', 0, '1'),
	('1386047954', '1348119324', 'Kabar Berita', 'news', '_self', '', 'external', 0, '1'),
	('1386047920', '1348119324', 'Events', 'events', '_self', '', 'external', 0, '1');
/*!40000 ALTER TABLE `ca_menu` ENABLE KEYS */;


-- Dumping structure for table dian.ca_module
CREATE TABLE IF NOT EXISTS `ca_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('1','0') DEFAULT '0',
  `id_parent` int(11) DEFAULT '0',
  `path_name` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `url` varbinary(50) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2147483648 DEFAULT CHARSET=latin1;

-- Dumping data for table dian.ca_module: 12 rows
/*!40000 ALTER TABLE `ca_module` DISABLE KEYS */;
INSERT INTO `ca_module` (`id`, `type`, `id_parent`, `path_name`, `name`, `url`, `order`, `publish`) VALUES
	(1111111101, '1', 0, 'gallery/', 'gallery', _binary 0x67616C6C6572792F64617461, 2, '1'),
	(1111111102, '1', 0, 'pages/', 'pages', _binary 0x70616765732F696E646578, 7, '1'),
	(1111111103, '1', 0, 'media/', 'media', _binary 0x6D656469612F696E646578, 5, '1'),
	(1111111104, '1', 1111111101, 'album/', 'album', _binary 0x616C62756D2F696E646578, 3, '1'),
	(1111111105, '1', 0, 'posts/', 'posts', _binary 0x706F7374732F696E646578, 9, '1'),
	(1111111106, '1', 0, 'menu/', 'menu', _binary 0x6D656E752F696E646578, 6, '1'),
	(1111111107, '1', 0, 'link/', 'link', _binary 0x6C696E6B2F696E646578, 4, '1'),
	(1111111108, '1', 0, 'polling/', 'polling', _binary 0x706F6C6C696E672F696E646578, 8, '1'),
	(1111111109, '1', 1111111105, 'categories/', 'categories', _binary 0x63617465676F726965732F696E646578, 0, '1'),
	(1111111110, '1', 0, 'add-ons/', 'add-ons', _binary 0x6164645F6F6E732F696E646578, 3, '1'),
	(1111111111, '0', 1111111110, 'security/', 'security', _binary 0x73656375726974792F696E646578, 0, '1'),
	(1111111113, '0', 1111111110, 'word_censor/', 'word censor', _binary 0x776F72645F63656E736F722F696E646578, 2, '1');
/*!40000 ALTER TABLE `ca_module` ENABLE KEYS */;


-- Dumping structure for table dian.ca_pages
CREATE TABLE IF NOT EXISTS `ca_pages` (
  `id` varchar(10) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `is_like` enum('0','1') DEFAULT '0',
  `is_share` enum('0','1') DEFAULT '0',
  `meta_keyword` varchar(225) DEFAULT NULL,
  `meta_description` varchar(225) DEFAULT NULL,
  `content` text,
  `view` int(10) DEFAULT NULL,
  `link` varchar(225) DEFAULT NULL,
  `permalink` varchar(100) DEFAULT NULL,
  `show_as_menu` enum('0','1') DEFAULT '0',
  `order` int(10) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_pages: 4 rows
/*!40000 ALTER TABLE `ca_pages` DISABLE KEYS */;
INSERT INTO `ca_pages` (`id`, `user_id`, `title`, `subtitle`, `date`, `is_like`, `is_share`, `meta_keyword`, `meta_description`, `content`, `view`, `link`, `permalink`, `show_as_menu`, `order`, `publish`) VALUES
	('1348132162', '1385885750', 'The Reason Why You Use CodeAnalytic', 'Teser', '2012-09-20 04:51:06', '1', '1', 'about hadinug, founder codeanlaytic, inventor of codeanalytic', 'about hadinug, founder codeanlaytic, inventor of codeanalytic', '<p>"One Touch In All Sollution" yes it was, when you start installed codeanlaytic you\'ll get website best view on web browser and mobile browser. It\'s automaticly when you use codeanalytic for website engine.</p>\n<p>&nbsp;</p>\n<p>There are many reason why you should choose codeanalaytic for your website. I try to quote from codeanalytic official website, "<a href="http://codeanalytic.com/" target="_blank">CodeAnalytic</a>&nbsp;is one of more Content Management System, started in 2012 with lines code&nbsp;to enhance the typography of everyday writing.&nbsp;Everything you see here, from the documentation to the code itself, was created by and for the community. CodeAnalytic is an Open Source project. It also means you are free to use it for anything paying anyone a license fee and a number of other important freedoms".</p>\n<p><br />I put little information from CodeAnalytic and get the experience&nbsp;when develop this cms, CodeAnlaytic using height&nbsp;programing&nbsp;technique. CodeAnalytic is create base OOP php 4+ that optimized with ajax jQuery in backEnd proccess. CodeAnaltic is OpenSource CMS that allow you to edit the script.&nbsp;Maybe this list can be&nbsp;represent codeanalytic fiture that must you know . Codeanalytic using ..</p>\n<p>&nbsp;</p>\n<p>1. Height programing technique PHP OOP 4+</p>\n<p>2. CodeIgniter Base Modification</p>\n<p>3. jQuery and Mobile jQuery</p>\n<p>4. Using MYSQL</p>\n<p>5. Multi Language</p>\n<p>6. FusionChart</p>\n<p>7. HMVC structure</p>\n<p>8. UserFriendly URL and using permalink</p>\n<p>9. Ajax BackEnd Proccess</p>\n<p>10. Widget Click and Drag on the Fly</p>\n<p>11. Virtual Keybord</p>\n<p>12. Ajax Upload on The Fly</p>\n<p>13. Easy drag and drop short data list</p>\n<p>14. Live Coding on CMS</p>\n<p>15. TinyMCE editor modification</p>\n<p>16. and many things else..</p>\n<p>&nbsp;</p>\n<p>Many things else that I can write in here. Because codeanalytic more than CMS ever there in the world.&nbsp;</p>', 18, 'pages/detail/1348132162/2012/09/20/04/51/06', 'the-reason-why-you-use-codeanalytic', '1', 0, '1'),
	('1385887590', '1385885750', 'Tentang Dian Taksi', 'Riwayat ', '2013-12-01 08:45:30', '1', '1', 'taksi, dian, transportasi, taxi', '-', '<p style="text-align: justify;">PT. Dharma Indah Agung Metropolitan (Perusahaan) didirikan tanggal 5 Juni 1986 berdasarkan akta No.15 dihadapkan notaris Haji Zawir Simon, Sarjana Hukum.</p>\n<p style="text-align: justify;">Anggaran dasar perusahaan ini telah disetujui oleh Menteri Kehakiman Republik Indonesia pada tanggal 16 Pebruari 1987 No.C2-1329.HT.01.01.Th.87 tanggal 16 Pebruari 1987.&nbsp;</p>\n<p style="text-align: justify;">Anggaran dasar perusahaan telah mengalami beberapa kali perubahan, yaitu :</p>\n<ol>\n<li style="text-align: justify;">Tanggal 24 Desember 1986 sesuai dengan akta No.108 dihadapan notaris Haji Zawir Simon, Sarjana Hukum, mengenai perubahan pemegang saham dan pengurus.</li>\n<li style="text-align: justify;">Tanggal 15 Agustus 1995 sesuai akta No.104 yang dibuat dihadapan notaris Frans Elsius Muliawan, Sarjana Hukum, mengenai peningkatan modal dasar perseroan menjadi 100.000 lembar saham dengan nilai nominal Rp.100.000,00 sehingga modal dasar perseroan menjadi Rp.10.000.000.000,00 (sepuluh milyar rupiah). Perubahan ini disahkan dengan Keputusan Menteri Kehakiman Republik Indonesia No.C2-10.957.HT.01.04.TH.95 tanggal 1 September 1995.&nbsp;</li>\n<li style="text-align: justify;">Tangggal 1 Mei 1997 sesuai berita acara rapat No.2 yang dibuat dihadapan notaris Nyonya Wasiati Basoeki, Sarjana Hukum, mengenai perubahan kepemilikan saham.</li>\n<li style="text-align: justify;">Tanggal 16 Desember 1999 berdasarkan hasil Rapat Umum Luar Biasa Pemegang Saham, telah disetujui penambahan modal disetor yang semula Rp.3.825.000.000,-menjadi Rp.4.525.000.000,-</li>\n<li style="text-align: justify;">Tanggal 7 Nopember 2000 sesuai akta No.2 yang dibuat dihadapan notaris Lenny Budiman, Sarjana Hukum, mengenai penigkatan modal dasar perusahaan menjadi sebesar Rp.20.000.000.000,-(dua puluh milyar rupiah). Dari modal tersebut telah ditempatkan sebesar Rp.7.525.000.000,00. Akta perubahan tersebut telah mendapat pengesahan dari Menteri Kehakiman Dan Hak Asasi Manusia Republik Indonesia tanggal 4 Mei 2001 No.C-6922 HT.01.04.TH.2001.</li>\n<li style="text-align: justify;">Tanggal 22 Juni 2006 sesuai berita acara rapat No.6 yang dibuat di hadapan notaris Inne Kusumawati, Sarjana Hukum mengenai perubahan pengurus. Akta tersebut telah didaftarkan dalam Database Sisminbakum Direktorat Jenderal Administrasi Hukum Umum Departemen Hukum dan Hak Asasi Manusia Republik Indonesia pada tanggal 27 Juli 2006.</li>\n</ol>\n<p style="text-align: justify;">&nbsp;</p>\n<p style="text-align: justify;"><strong><span style="text-decoration: underline;">MODAL SAHAM</span></strong></p>\n<p style="text-align: justify;">&nbsp;</p>\n<p style="text-align: justify;">Susunan pemegang saham per 31 Desember 2006 adalah sebagai berikut :</p>\n<p style="text-align: justify;">&nbsp;</p>\n<p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp; Pemegang Saham &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Lembar Saham &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Jumlah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; %</p>\n<table cellspacing="0" cellpadding="0" align="left">\n<tbody>\n<tr>\n<td width="24" height="15">&nbsp;</td>\n<td width="189">&nbsp;PT. Dian Maupus &nbsp;</td>\n<td width="10">&nbsp;</td>\n<td style="text-align: right;" width="127">&nbsp;73.369 lembar</td>\n<td width="23">&nbsp;</td>\n<td width="127">&nbsp;Rp.7.336.900.000</td>\n<td width="35">&nbsp;</td>\n<td width="89">&nbsp;&nbsp; &nbsp;97,5%</td>\n</tr>\n<tr>\n<td height="2">&nbsp;</td>\n<td align="left" valign="top">&nbsp;Drs. I Wayan Pasek</td>\n<td>&nbsp;</td>\n<td style="text-align: right;" align="left" valign="top">&nbsp;1.881 lembar</td>\n<td>&nbsp;</td>\n<td align="left" valign="top">&nbsp;Rp.&nbsp;&nbsp; 188.100.000</td>\n<td>&nbsp;</td>\n<td align="left" valign="top">&nbsp;&nbsp; &nbsp; 2,5%</td>\n</tr>\n</tbody>\n</table>\n<p style="text-align: justify;">&nbsp; &nbsp; &nbsp;</p>\n<p style="text-align: justify;">&nbsp; &nbsp; &nbsp; Jumlah &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;75.250 lembar &nbsp; &nbsp; &nbsp; Rp.7.525.000.000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;100 &nbsp;%</p>\n<p style="text-align: justify;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\n<p style="text-align: justify;"><strong><span style="text-decoration: underline;">SUSUNAN PENGURUS</span></strong></p>\n<p style="text-align: justify;">&nbsp;Sesuai akte perubahan terakhir susunan pengurus perseroan adalah:</p>\n<p style="text-align: justify;">&nbsp;- Direktur &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I Made Sutarjana</p>\n<p style="text-align: justify;">- Presiden Komisaris &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I Ketut Siandana</p>\n<p style="text-align: justify;">- Komisaris &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I Gusti Rai Yudhakarma Soekidjo, Ph.D.</p>\n<p style="text-align: justify;">&nbsp;</p>\n<p style="text-align: justify;"><strong><span style="text-decoration: underline;">BIDANG USAHA PERUSAHAAN</span></strong></p>\n<p style="text-align: justify;">Bidang usaha perusahaan adalah jasa pelayanan taxi meter, dengan ijin usaha perdagangan dari departemen Perindustrian dan perdagangan (SIUP) No. 2314/3132-P/09-08/PB/VI/89, tertanggal 7 Juni 1989, Sedangkan Ijin Prinsip atas&nbsp; usaha angkutan dengan kendaraan bermotor umum di peroleh dari Pemerintahan Daerah DKI Jakarta, yang mana terakhir diperpanjang dengan Surat Keputusan Gubernur Kepala Daerah Khusus Ibukota DKI Jakarta No.07/IU/TX/MPU/DISHUB/I/2007 tanggal 15 Januari 2007 dan berlaku sampai tanggal 06 Pebruari 2012, dengan jumlah maksimal pengoperasikan&nbsp; sebesar<strong> 800 unit</strong>&nbsp;</p>\n<p style="text-align: justify;">Pengoperasian taksi di Manado mendapat izin dari Gubernur Kepala Daerah Tingkat 1 Sulawesi Utara yang berawal dari surat rekomendasi no. 551.1/08/2976, tertanggal 31 Agustus 1989 dan&nbsp; telah di perpanjang beberapa kali serta akan berakhir pada 5 Oktober 2008. Persetujuan ini di ikuti dengan rekomendasi dari Dinas Perhubungan dengan jumlah&nbsp; maksimal sebesar <strong>290 unit</strong> mobil taksi</p>\n<p style="text-align: justify;">Tahun 2004, Perusahaan membuka cabang di Gorontalo, dengan izin Gubernur Kepala Daerah Tingkat 1 Gorontalo No.551-2/PPTP/II/2004 tanggal 19 Pebruari 2004. dengan persetujuan pengoperasian sebesar <strong>30 unit</strong> mobil taksi</p>\n<p style="text-align: justify;">&nbsp; &nbsp; &nbsp;</p>\n<p style="text-align: justify;"><span style="text-decoration: underline;"><strong>SISTEM OPERASIONAL</strong>&nbsp;</span></p>\n<p style="text-align: justify;">Sejak bulan November 2007 PT Dharma Indah Agung Metropolitan ( DIAN TAKSI ) unit operasi Jakarta merubah sistem operasional Setoran Biasa menjadi Setoran Kemitraan, dimana di dalam sistim operational Kemitraan tsb diatas adalah : Pengemudi di wajibkan menyetor setiap harinya pada jumlah tertentu ( Soluna Rp. 100,000,- dan Limo Rp. 130,000,- ), dan jangka waktu tertentu ( Soluna 2 Th dan Limo 3.5 Th )</p>\n<p style="text-align: justify;">Saat ini Dian Taxi sebagai salah satu Operator Taxi di Jakarta telah menemukan system operasional yang paling sesuai, Yaitu Sistem Kemitraan, dimana para pengemudi sebagai Mitra Kerja berkesempatan memiliki Taksi yang dioperasikannya sesuai dengan ketentuan yang telah disepakati bersama. Melalui system ini terbinalah kerjasama yang kuat dan saling menguntungkan antara Perusahaan dan Pengemudi sebagai mitra utama. Dengan system Kemitraan, Dian Taxi tidak hanya mampu bertahan, tetapi di harapkan juga akan bisa bertumbuh dengan baik sesuai dengan Proyeksi Cash Flow yang telah kami persiapkan dengan baik, ditengah kerasnya terjangan badai krisis ekonomi akibat kenaikan BBM yang menghantam industri taxi di tanah air.</p>\n<p style="text-align: justify;">Dian Taxi juga telah menumbuhkan reputasi yang solid Karena di kelola dengan system manajemen yang professional untuk meningkatkan kwalitas pelayanan.&nbsp;&nbsp; Dian Taxi juga menyadari pentingnya keseimbangan antara pelayanan terhadap mitra pengmudi dan pelayanan terhadap pelanggan pengguna jasa. Bagi Dian Taxi, pengemudi merupakan mitra yang esensial, oleh karena itu system pengoperasian taxi yang dilakukan Dian Taxi berbeda dengan beberapa perusahaan taxi lain. Merengkuh pengemudi sebagai mitra untuk menjadi bagian dari perusahaan dan dapat memiliki mobil yang dikemudikannya merupakan langkah yang diambil Dian Taxi. Dalam usahanya Dian Taxi juga berusaha untuk meleburkan filosofi membangun bisnis transportasi modern ke dalam budaya perusahaan untuk menciptakan sebuah servis transportasi yang mampu memberikan pelayanan lebih dari yang diharapkan konsumen (&nbsp; exceed their expectation ).</p>\n<p style="text-align: justify;">Memasuki tahun 2008, dengan kerjasama team yang solid, kontribusi, serta komitmen dari seluruh karyawan dan mitra kami, kami sangat optimis Dian Taxi akan terus bertumbuh dan semakin kuat eksistensinya sebagai salah satu operator Taxi di Jakarta. &nbsp;&nbsp;</p>\n<p style="text-align: justify;">&nbsp;</p>', 473, 'pages/detail/1385887590/2013/12/01/08/45/30', 'company-profile', '0', 0, '1'),
	('1386059474', '1385885750', 'Dian Taksi', 'Melayani dengan segenap hati dan memberi pelayanan terbaik', '2013-12-03 08:30:06', '1', '1', 'dian, taksi, jakarta, manado,', '-', '<p>Test</p>', 82, 'pages/detail/1386059474/2013/12/03/08/30/06', 'dian-taksi', '1', 0, '1'),
	('1386060329', '1385885750', 'Used Car Center', 'Mencari kendaraan yang murah dan nyaman di sini tempatnya', '2013-12-03 08:44:11', '0', '0', 'jual, mobil, beli', '-', '<p><img src="assets/media/upload/image/gUy0HjexTcH85WGbHSDVBbEhv_1386060446_codeanalytic_media_gCHCoHS4tkfQ4DQKsSe880WXJ_ca_thumb_big.jpg" alt="" width="490" height="350" /></p>\n<p>&nbsp;</p>\n<p>asdasdasd</p>', 67, 'pages/detail/1386060329/2013/12/03/08/44/11', 'used-car-center', '0', 0, '1');
/*!40000 ALTER TABLE `ca_pages` ENABLE KEYS */;


-- Dumping structure for table dian.ca_poll
CREATE TABLE IF NOT EXISTS `ca_poll` (
  `pid` varchar(10) NOT NULL,
  `question` varchar(225) DEFAULT NULL,
  `noofanswers` int(2) DEFAULT NULL,
  `answer1` varchar(225) DEFAULT NULL,
  `answer2` varchar(225) DEFAULT NULL,
  `answer3` varchar(225) DEFAULT NULL,
  `answer4` varchar(225) DEFAULT NULL,
  `answer5` varchar(225) DEFAULT NULL,
  `answer6` varchar(225) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_poll: 1 rows
/*!40000 ALTER TABLE `ca_poll` DISABLE KEYS */;
INSERT INTO `ca_poll` (`pid`, `question`, `noofanswers`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`, `order`, `publish`) VALUES
	('1', 'How about performance codeanalytic, in your website', 3, 'good', 'very good', 'bad', '', '', '', 0, '1');
/*!40000 ALTER TABLE `ca_poll` ENABLE KEYS */;


-- Dumping structure for table dian.ca_pollresult
CREATE TABLE IF NOT EXISTS `ca_pollresult` (
  `pid` varchar(10) NOT NULL,
  `answer1` int(10) DEFAULT NULL,
  `answer2` int(10) DEFAULT NULL,
  `answer3` int(10) DEFAULT NULL,
  `answer4` int(10) DEFAULT NULL,
  `answer5` int(10) DEFAULT NULL,
  `answer6` int(10) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_pollresult: 1 rows
/*!40000 ALTER TABLE `ca_pollresult` DISABLE KEYS */;
INSERT INTO `ca_pollresult` (`pid`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`) VALUES
	('1', 3, 1, 1, 1, 1, 1);
/*!40000 ALTER TABLE `ca_pollresult` ENABLE KEYS */;


-- Dumping structure for table dian.ca_posts
CREATE TABLE IF NOT EXISTS `ca_posts` (
  `id` varchar(10) NOT NULL,
  `cat_id` varchar(250) DEFAULT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `img` varchar(225) DEFAULT 'codeanalytic_media_ca_thumb_small.jpg',
  `is_show_thumb` enum('0','1') NOT NULL,
  `is_like` enum('0','1') DEFAULT '0',
  `is_share` enum('0','1') DEFAULT '0',
  `meta_keyword` varchar(225) DEFAULT NULL,
  `meta_description` varchar(225) DEFAULT NULL,
  `content` text,
  `view` int(10) DEFAULT NULL,
  `link` varchar(225) NOT NULL,
  `permalink` varchar(225) NOT NULL,
  `order` int(10) DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_posts: 3 rows
/*!40000 ALTER TABLE `ca_posts` DISABLE KEYS */;
INSERT INTO `ca_posts` (`id`, `cat_id`, `user_id`, `title`, `date`, `img`, `is_show_thumb`, `is_like`, `is_share`, `meta_keyword`, `meta_description`, `content`, `view`, `link`, `permalink`, `order`, `publish`) VALUES
	('1386128356', '1386128840', '1385885750', 'Xc', '2013-12-04 03:38:58', 'codeanalytic_media_ca_thumb_small.jpg', '1', '0', '0', 'A', 'A', '<p>ASDADSFASDF</p>', 7, 'posts/detail/1386128356/2013/12/04/03/38/58', 'xc', 0, '1'),
	('1386129676', '1386129630', '1385885750', 'This Events', '2013-12-04 04:00:37', 'CoKlMcrA1nvMYohigC28Au092_1386128591_codeanalytic_media_aV4gWk8x6kk9FJXmlyWaImSeD_ca_thumb_small.jpg', '1', '0', '0', 'event', 'e', '<p>More Event here</p>', NULL, 'posts/detail/1386129676/2013/12/04/04/00/37', 'this-events', 0, '1'),
	('1386126571', '1386128840', '1385885750', 'test', '2013-12-04 03:09:31', 'CoKlMcrA1nvMYohigC28Au092_1386128591_codeanalytic_media_aV4gWk8x6kk9FJXmlyWaImSeD_ca_thumb_small.jpg', '1', '0', '0', '0', '0', '<p>asdfasdf</p>', 7, 'posts/detail/1386126571/2013/12/04/03/09/31', 'test', 0, '1');
/*!40000 ALTER TABLE `ca_posts` ENABLE KEYS */;


-- Dumping structure for table dian.ca_privileges
CREATE TABLE IF NOT EXISTS `ca_privileges` (
  `priv_id` int(2) NOT NULL AUTO_INCREMENT,
  `priv_name` varchar(15) DEFAULT NULL,
  `insert` enum('0','1') DEFAULT '0',
  `update` enum('0','1') DEFAULT '0',
  `delete` enum('0','1') DEFAULT '0',
  `publish` enum('0','1') DEFAULT '0',
  `description` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`priv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_privileges: 4 rows
/*!40000 ALTER TABLE `ca_privileges` DISABLE KEYS */;
INSERT INTO `ca_privileges` (`priv_id`, `priv_name`, `insert`, `update`, `delete`, `publish`, `description`) VALUES
	(1, 'administrator', '1', '1', '1', '1', 'all privilages'),
	(2, 'admin', '1', '1', '0', '1', 'admin website'),
	(3, 'editor', '0', '1', '0', '0', 'editor pages'),
	(4, 'publisher', '0', '0', '0', '1', 'publisher page');
/*!40000 ALTER TABLE `ca_privileges` ENABLE KEYS */;


-- Dumping structure for table dian.ca_subscribe
CREATE TABLE IF NOT EXISTS `ca_subscribe` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_subscribe: 1 rows
/*!40000 ALTER TABLE `ca_subscribe` DISABLE KEYS */;
INSERT INTO `ca_subscribe` (`id`, `email`) VALUES
	(1, 'info@codeanalytic.com');
/*!40000 ALTER TABLE `ca_subscribe` ENABLE KEYS */;


-- Dumping structure for table dian.ca_template
CREATE TABLE IF NOT EXISTS `ca_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `thumb` varchar(225) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `maker` varchar(100) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `publish` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_template: 1 rows
/*!40000 ALTER TABLE `ca_template` DISABLE KEYS */;
INSERT INTO `ca_template` (`id`, `name`, `thumb`, `date`, `maker`, `description`, `order`, `publish`) VALUES
	(1, 'template', 'preview.jpg', '2012-08-14 00:00:00', 'Aris Sudaryanto\r\n', '\r\nTheme for CodeAnalytic cms is stylish, customizable, simple,\r\nand readable. Make it yours with a custom menu, header image, and background.\r\n You can see much supports widget areas (in the sidebar, footer) and featured images It include inside', 2, '1');
/*!40000 ALTER TABLE `ca_template` ENABLE KEYS */;


-- Dumping structure for table dian.ca_third_party
CREATE TABLE IF NOT EXISTS `ca_third_party` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `order` int(5) DEFAULT NULL,
  `publish` enum('0','1') CHARACTER SET latin1 DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_third_party: 3 rows
/*!40000 ALTER TABLE `ca_third_party` DISABLE KEYS */;
INSERT INTO `ca_third_party` (`id`, `title`, `date`, `order`, `publish`) VALUES
	(1, 'prettyPhoto', '2012-07-25 17:17:43', 2, '1'),
	(2, 'calendar', '2012-07-25 17:17:43', 3, '1'),
	(3, 'jquery.dropron', '2012-08-12 05:36:09', 0, '1');
/*!40000 ALTER TABLE `ca_third_party` ENABLE KEYS */;


-- Dumping structure for table dian.ca_users
CREATE TABLE IF NOT EXISTS `ca_users` (
  `user_id` varchar(10) NOT NULL,
  `priv_id` int(3) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `photo` varchar(100) DEFAULT 'default_ca_thumb_middle.jpg',
  `last_login` datetime DEFAULT NULL,
  `order` int(10) DEFAULT '0',
  `active` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_users: 1 rows
/*!40000 ALTER TABLE `ca_users` DISABLE KEYS */;
INSERT INTO `ca_users` (`user_id`, `priv_id`, `username`, `password`, `first_name`, `last_name`, `email`, `photo`, `last_login`, `order`, `active`) VALUES
	('1385885750', 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, 'default_ca_thumb_middle.jpg', '2013-12-01 08:27:02', 0, '0');
/*!40000 ALTER TABLE `ca_users` ENABLE KEYS */;


-- Dumping structure for table dian.ca_users_statistic
CREATE TABLE IF NOT EXISTS `ca_users_statistic` (
  `user_id` varchar(15) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table dian.ca_users_statistic: 1 rows
/*!40000 ALTER TABLE `ca_users_statistic` DISABLE KEYS */;
INSERT INTO `ca_users_statistic` (`user_id`, `date`) VALUES
	('1385885750', '2013-12-01 08:27:02');
/*!40000 ALTER TABLE `ca_users_statistic` ENABLE KEYS */;


-- Dumping structure for table dian.ca_widget
CREATE TABLE IF NOT EXISTS `ca_widget` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `type` enum('0','1') DEFAULT '0',
  `position` enum('1','2','3','4','5','6','7') DEFAULT NULL,
  `id_htmlarea` varchar(15) NOT NULL DEFAULT '0',
  `id_template` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table dian.ca_widget: 2 rows
/*!40000 ALTER TABLE `ca_widget` DISABLE KEYS */;
INSERT INTO `ca_widget` (`id`, `name`, `order`, `type`, `position`, `id_htmlarea`, `id_template`) VALUES
	(1, 'archives_wi', 2, '0', '2', '0', '1'),
	(2, 'list_categories_wi', 1, '0', '2', '0', '1');
/*!40000 ALTER TABLE `ca_widget` ENABLE KEYS */;


-- Dumping structure for table dian.ca_word_censor
CREATE TABLE IF NOT EXISTS `ca_word_censor` (
  `id` varchar(11) NOT NULL,
  `word` varchar(225) DEFAULT NULL,
  `replace` varchar(225) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `publish` enum('1','0') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table dian.ca_word_censor: 1 rows
/*!40000 ALTER TABLE `ca_word_censor` DISABLE KEYS */;
INSERT INTO `ca_word_censor` (`id`, `word`, `replace`, `order`, `publish`) VALUES
	('1347521846', 'fuck', 'f***', 0, '1');
/*!40000 ALTER TABLE `ca_word_censor` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
