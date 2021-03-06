-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Inang: localhost
-- Waktu pembuatan: 27 Feb 2013 pada 06.26
-- Versi Server: 5.5.20-log
-- Versi PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `diantaksi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `baps`
--

CREATE TABLE IF NOT EXISTS `baps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `bap_number` varchar(100) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `driver_status_id` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `sum_sparepart` decimal(15,2) NOT NULL,
  `sum_ks` decimal(15,2) NOT NULL,
  `sum_akhir_unit` decimal(15,2) NOT NULL,
  `std_bap_id` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `solusi` text NOT NULL,
  `saksi_id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `baps`
--

INSERT INTO `baps` (`id`, `date`, `bap_number`, `fleet_id`, `driver_id`, `driver_status_id`, `pool_id`, `sum_sparepart`, `sum_ks`, `sum_akhir_unit`, `std_bap_id`, `keterangan`, `solusi`, `saksi_id`, `user_id`, `last_update`) VALUES
(1, '2013-02-27', 'DT-00001/BAP/2013/02/27', 4, 9, 0, 1, '0.00', '0.00', '0.00', '', 'a', 'a', '', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `blockeds`
--

CREATE TABLE IF NOT EXISTS `blockeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) DEFAULT NULL,
  `fleet_id` int(11) DEFAULT NULL,
  `blocked_status_id` int(11) NOT NULL DEFAULT '0',
  `checkin_id` int(11) NOT NULL DEFAULT '0',
  `proses` int(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_proses` datetime NOT NULL,
  `date` datetime DEFAULT NULL,
  `note` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `blockeds`
--

INSERT INTO `blockeds` (`id`, `driver_id`, `fleet_id`, `blocked_status_id`, `checkin_id`, `proses`, `user_id`, `date_proses`, `date`, `note`) VALUES
(1, 9, 4, 1, 3, 1, 1, '2013-02-27 14:46:43', '2013-02-26 14:12:07', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `blocked_status`
--

CREATE TABLE IF NOT EXISTS `blocked_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `blocked_status`
--

INSERT INTO `blocked_status` (`id`, `status`) VALUES
(1, 'Financial Blocked ( KS )'),
(2, 'Check Scurity Blocked'),
(3, 'Check Physic Blocked'),
(4, 'Complain Costumers'),
(5, 'Other Blocked'),
(6, 'TIDAK DISIPLIN/MELEBIHI WAKTU JAM PULANG OPERASI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkins`
--

CREATE TABLE IF NOT EXISTS `checkins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kso_id` int(11) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `checkin_time` datetime NOT NULL,
  `shift_id` int(11) NOT NULL,
  `km_fleet` int(11) NOT NULL,
  `operasi_time` date NOT NULL,
  `pool_id` int(11) NOT NULL,
  `operasi_status_id` int(11) NOT NULL DEFAULT '0',
  `fg_late` int(11) NOT NULL,
  `checkin_step_id` int(11) NOT NULL,
  `document_check_user_id` int(11) NOT NULL,
  `physic_check_user_id` int(11) NOT NULL,
  `bengkel_check_user_id` int(11) NOT NULL,
  `finance_check_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unix_ops` (`fleet_id`,`operasi_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `checkins`
--

INSERT INTO `checkins` (`id`, `kso_id`, `fleet_id`, `driver_id`, `checkin_time`, `shift_id`, `km_fleet`, `operasi_time`, `pool_id`, `operasi_status_id`, `fg_late`, `checkin_step_id`, `document_check_user_id`, `physic_check_user_id`, `bengkel_check_user_id`, `finance_check_user_id`) VALUES
(1, 1, 1, 2, '2013-02-26 14:06:28', 1, 400, '2013-02-26', 1, 1, 0, 2, 1, 0, 0, 0),
(2, 2, 2, 6, '2013-02-26 14:07:59', 1, 500, '2013-02-26', 1, 1, 0, 2, 1, 0, 0, 0),
(3, 4, 4, 9, '2013-02-26 14:08:28', 1, 300, '2013-02-26', 1, 1, 0, 2, 1, 0, 0, 0),
(4, 2, 2, 4, '2013-02-27 14:55:27', 1, 5000, '2013-02-27', 1, 4, 0, 2, 1, 0, 0, 0),
(5, 4, 4, 9, '2013-02-27 14:56:35', 1, 700, '2013-02-27', 1, 1, 0, 2, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkin_bengkels`
--

CREATE TABLE IF NOT EXISTS `checkin_bengkels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(11) NOT NULL,
  `sparepart_id` varchar(11) NOT NULL,
  `jumlah` varchar(11) NOT NULL,
  `analisa` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkin_documents`
--

CREATE TABLE IF NOT EXISTS `checkin_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(11) NOT NULL,
  `std_document_id` varchar(100) NOT NULL,
  `std_neats_id` varchar(100) NOT NULL,
  `std_equip_id` varchar(100) NOT NULL,
  `ket` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `checkin_documents`
--

INSERT INTO `checkin_documents` (`id`, `checkin_id`, `std_document_id`, `std_neats_id`, `std_equip_id`, `ket`) VALUES
(1, 1, '1,2,3,4,5,6,7', '1,2,3,4', '1,2,3,4', 'Ada,Ada,Belum Ada,Ada,Ada,Ada,Ada'),
(2, 2, '1,2,3,4,5,6,7', '1,2,3,4', '1,2,3,4', 'Ada,Ada,Ada,Ada,Ada,Ada,Ada'),
(3, 3, '1,2,3,4,5,6,7', '', '', ',,,,,,'),
(4, 4, '', '', '', ''),
(5, 5, '1,2,3,4,5,6,7', '1,2,3,4', '1,2,3,4', 'Ada,Ada,Ada,Ada,Ada,Ada,Ada');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkin_financials`
--

CREATE TABLE IF NOT EXISTS `checkin_financials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(11) NOT NULL,
  `financial_type_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checkin_id` (`checkin_id`,`financial_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data untuk tabel `checkin_financials`
--

INSERT INTO `checkin_financials` (`id`, `checkin_id`, `financial_type_id`, `amount`) VALUES
(1, 1, 1, '210000.00'),
(2, 1, 2, '35000.00'),
(3, 1, 3, '0.00'),
(4, 1, 4, '0.00'),
(5, 1, 5, '0.00'),
(6, 1, 6, '0.00'),
(7, 1, 7, '3000.00'),
(8, 1, 8, '3000.00'),
(9, 1, 9, '0.00'),
(10, 1, 10, '0.00'),
(11, 1, 11, '0.00'),
(12, 1, 12, '0.00'),
(13, 1, 13, '0.00'),
(14, 1, 20, '251000.00'),
(15, 2, 1, '210000.00'),
(16, 2, 2, '35000.00'),
(17, 2, 3, '0.00'),
(18, 2, 4, '0.00'),
(19, 2, 5, '0.00'),
(20, 2, 6, '0.00'),
(21, 2, 7, '3000.00'),
(22, 2, 8, '3000.00'),
(23, 2, 9, '0.00'),
(24, 2, 10, '0.00'),
(25, 2, 11, '0.00'),
(26, 2, 12, '0.00'),
(27, 2, 13, '0.00'),
(28, 2, 20, '251000.00'),
(44, 3, 1, '210000.00'),
(45, 3, 2, '35000.00'),
(46, 3, 3, '0.00'),
(47, 3, 4, '0.00'),
(48, 3, 5, '0.00'),
(49, 3, 6, '0.00'),
(50, 3, 7, '3000.00'),
(51, 3, 8, '0.00'),
(52, 3, 9, '0.00'),
(53, 3, 10, '0.00'),
(54, 3, 11, '48000.00'),
(55, 3, 12, '0.00'),
(56, 3, 13, '0.00'),
(57, 3, 20, '200000.00'),
(58, 5, 1, '210000.00'),
(59, 5, 2, '35000.00'),
(60, 5, 3, '0.00'),
(61, 5, 4, '0.00'),
(62, 5, 5, '0.00'),
(63, 5, 6, '5000.00'),
(64, 5, 7, '3000.00'),
(65, 5, 8, '0.00'),
(66, 5, 9, '0.00'),
(67, 5, 10, '0.00'),
(68, 5, 11, '0.00'),
(69, 5, 12, '0.00'),
(70, 5, 13, '0.00'),
(71, 5, 20, '253000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkin_physics`
--

CREATE TABLE IF NOT EXISTS `checkin_physics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(11) NOT NULL,
  `sparepart_id` varchar(1000) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `checkin_physics`
--

INSERT INTO `checkin_physics` (`id`, `checkin_id`, `sparepart_id`, `ket`) VALUES
(1, 1, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195', ',,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,'),
(2, 2, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195', ',,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,'),
(3, 3, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195', ',,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,'),
(4, 5, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195', ',,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkin_steps`
--

CREATE TABLE IF NOT EXISTS `checkin_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkin_step` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data untuk tabel `checkin_steps`
--

INSERT INTO `checkin_steps` (`id`, `checkin_step`) VALUES
(1, 'Belum Lapor Masuk'),
(2, 'Cek Dokumen'),
(3, 'Setoran Finansial'),
(4, 'Belum Setoran & Masuk Bengkel'),
(5, 'Selesai Finansial & Masuk Bengkel'),
(6, 'Sudah Cetak SPK'),
(7, 'Sudah Diagnosa & Request Sparepart'),
(8, 'Sudah Kalkulasi Harga'),
(9, 'Sudah Cek Kredit'),
(10, 'Sudah Cek Barang'),
(11, 'Selesai Checkin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkouts`
--

CREATE TABLE IF NOT EXISTS `checkouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kso_id` int(11) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `operasi_time` date NOT NULL,
  `checkout_time` datetime NOT NULL,
  `checkout_step_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `std_neat_id` varchar(100) NOT NULL COMMENT 'kerapihan supir',
  `std_doc_id` varchar(100) NOT NULL COMMENT 'kelengkapan dokumen',
  `std_doc_ket` varchar(200) DEFAULT NULL,
  `std_equip_id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `security_check_user_id` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `std_physic_id` int(11) NOT NULL,
  `fg_late` int(11) NOT NULL,
  `printspj_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fleet_operation` (`fleet_id`,`operasi_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `checkouts`
--

INSERT INTO `checkouts` (`id`, `kso_id`, `fleet_id`, `driver_id`, `operasi_time`, `checkout_time`, `checkout_step_id`, `shift_id`, `std_neat_id`, `std_doc_id`, `std_doc_ket`, `std_equip_id`, `user_id`, `security_check_user_id`, `pool_id`, `std_physic_id`, `fg_late`, `printspj_time`) VALUES
(1, 1, 1, 2, '2013-02-26', '0000-00-00 00:00:00', 3, 1, '1,2,3,4', '1,2,3,4,5,6,7', 'Ada,Ada,Ada,Ada,Ada,Ada,Ada', '1,2,3,4', 1, 0, 1, 0, 0, '2013-02-26 23:49:19'),
(2, 2, 2, 6, '2013-02-26', '0000-00-00 00:00:00', 4, 1, '1,2,3,4', '1,2,3,4,5,6,7', 'Ada,Ada,Belum Ada,Ada,Ada,Ada,Ada', '1,2,3,4', 1, 0, 1, 0, 0, '2013-02-26 14:02:59'),
(3, 4, 4, 9, '2013-02-26', '0000-00-00 00:00:00', 4, 1, '1,2,3,4', '1,2,3,4,5,6,7', 'Ada,Ada,Ada,Ada,Ada,Ada,Ada', '1,2,3,4', 1, 0, 1, 0, 0, '2013-02-26 14:03:07'),
(4, 2, 2, 4, '2013-02-27', '0000-00-00 00:00:00', 5, 1, '', '', NULL, '', 1, 0, 1, 0, 0, '2013-02-27 14:41:36'),
(5, 4, 4, 9, '2013-02-27', '0000-00-00 00:00:00', 4, 1, '1,2,3,4', '1,2,3,4,5,6,7', 'Ada,Ada,Ada,Ada,Ada,Ada,Ada', '1,2,3,4', 1, 0, 1, 0, 0, '2013-02-27 14:48:25'),
(6, 1, 1, 2, '2013-02-27', '0000-00-00 00:00:00', 4, 1, '', '1,2,3,4,5,6,7', 'Ada,Ada,Ada,Ada,Ada,hilang,Ada', '1,2,3,4', 1, 0, 1, 0, 0, '2013-02-27 14:42:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkout_steps`
--

CREATE TABLE IF NOT EXISTS `checkout_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkout_step` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `checkout_steps`
--

INSERT INTO `checkout_steps` (`id`, `checkout_step`) VALUES
(1, 'Belum Lapor Keluar'),
(2, 'Sudah Cek Fisik'),
(3, 'Sudah Cetak SPJ'),
(4, 'Sudah Cek Dokumen'),
(5, 'Tidak Beroperasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `cities`
--

INSERT INTO `cities` (`id`, `city`) VALUES
(1, 'Jakarta'),
(2, 'Manado');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city_id` int(11) NOT NULL,
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `city_id`, `time_inserted`, `time_modified`) VALUES
(1, 'Sinta', '08578244723', 'Jl Kembangan Raya no 71', 1, '2012-08-02 12:18:10', '2012-08-08 05:33:53'),
(2, 'Nina', '08124124312', 'jl Raya buncit', 1, '2012-08-08 12:58:10', '2012-08-08 05:35:39'),
(3, 'Tono', '0857123123', 'Pesona Cilebut 2 Blok HB3 No 8', 1, '2012-08-04 12:58:10', '2012-08-08 07:17:41'),
(4, 'Nuniek', '08171817363', 'Pesona Cilebut 2 Blok HB3 No 8', 1, '2012-08-01 12:58:10', '2012-08-08 07:17:33'),
(5, 'Nani', '0856713615', 'Jl Prapanca Raya Persil No 92', 1, '2012-08-08 12:58:10', '2012-08-08 05:58:10'),
(6, 'Rambo', '08784616151', 'Jl Kemang Raya 75', 1, '2012-08-08 14:15:35', '2012-08-08 07:15:35'),
(7, 'Fakhri', '085718997609', 'Bojong Gede Bogor', 1, '2012-09-17 10:55:23', '2012-09-17 03:55:23'),
(8, 'Delsi', '08575675656', 'rawa bokor', 1, '2012-11-04 01:22:29', '0000-00-00 00:00:00'),
(10, 'Abdul Hafidz Anshari', '622158901717', 'Jl. Mawar No 60 Rt 03/07 Kosambi Tangerang', 1, '2013-01-10 00:00:00', '2012-11-10 06:50:15'),
(11, 'Mauludin', '08123456789', 'Jl. Sidorhajo no 70 Rt.04/09\r\nJogja Indonesia', 1, '2013-02-11 00:00:00', '2012-11-10 06:59:18'),
(12, 'Mamat Metal', '08123456789', 'asd', 1, '2013-02-28 00:00:00', '2012-11-10 06:52:03'),
(16, 'Puji Lestariningsih', '081317120333', 'Jl. Mawar No.60 Rt.03/07 Salembarang jaya Kosambi Tangerang', 1, '2012-12-12 09:23:01', '2012-12-12 09:23:01'),
(15, 'Abdul Hafidz Anshari', '081317120222', 'asd', 1, '2012-12-04 23:57:51', '2012-12-04 23:57:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer_address`
--

CREATE TABLE IF NOT EXISTS `customer_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `category` varchar(10) DEFAULT NULL,
  `address` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `drivers`
--

CREATE TABLE IF NOT EXISTS `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `ktp` varchar(100) NOT NULL,
  `sim` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city_id` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `join_date` date NOT NULL,
  `driver_status` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `fg_blocked` int(11) NOT NULL,
  `fg_laka` int(11) NOT NULL DEFAULT '0',
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nip` (`nip`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=559 ;

--
-- Dumping data untuk tabel `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `nip`, `ktp`, `sim`, `address`, `city_id`, `phone`, `join_date`, `driver_status`, `photo`, `pool_id`, `fg_blocked`, `fg_laka`, `time_inserted`, `time_modified`) VALUES
(2, 'AGUS MULYANA', 'DA-0001B1', '', '', 'SEKTOR 2', 1, '', '2012-12-18', 1, '', 1, 0, 1, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(3, 'MARTINUS M N', 'DA-00017', '3328152810730009', '731012192638', 'Jl.nusa jaya Rt.004/02 no.20 kel. pondok jaya', 1, '081317120222', '2012-12-18', 1, '', 1, 0, 1, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(4, 'ABDUL GHOFUR', 'DA-0002 B1', '09.5204.120580.5569', '8005.1205.4032', 'JL KALI ANYER II RT013RW001 KEL.X ANYER TAMBORA', 1, '', '2012-12-18', 1, '', 1, 0, 1, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(5, 'JEKSON SITEPU', 'DA-0003 B2', '31.7308.070870.0008', '7808.1205.14206', 'JL. KARYA SARI RT.004/003 KEL. SRENSENG JAKBAR', 1, '''081310006448', '2012-12-18', 1, '', 1, 0, 1, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(6, 'AZWAR TANJUNG', 'DA-0004', '-', '-', '', 1, '-', '2012-12-18', 1, '', 1, 0, 1, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(7, 'MOH. RONI', 'DA-0005 B1', '09.5208.270264.0210', '6402.1205.3274', 'JL. MERUYA ILIR RT018/004 KEL.MERUYA UTARA KEMBANG', 1, '021 92443405', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(8, 'ABDUL ROHIM SIREGAR', 'DA-0006 B1', '32031417026203378', '620212050623', 'KP CIPICUNG RT 11/04 KEL MEKAR SARI KEC CILEUNGSI', 1, '087870421554', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(9, 'SAIDUN', 'DA-0006 B2', '31.7410.120363.0005', '6303.1205.6965', 'KAMP BARU VII RT.009/002 NO.28 KEL _x000D_\nULUJAMI KEC', 1, '''081280068763', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(10, 'JOHAN COSMAS G', 'DA-0007', '36.7111.240179.0006', '7801.1205.2923', 'JL KEPNDANG BLOK A16/18 Rt.009/07 KEL KUNCIRAN TGR', 1, '96151004', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(11, 'TARMUJI', 'DA-0007 B1', '9.52011105567073E+01', '6705120558224', 'JL JOGLO BARU RT04/06 KEL JOGLO KEMBANGAN', 1, ' 081808668060', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(12, 'AKHMAD BADARUDIN', 'DA-0008', '-', '-', '', 1, '081806242450', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(13, 'ALFIA', 'DA-0009', '-', '-', 'JL LAMPIRI GG MAKMUR RT.01/02 NO.01 KEL PONDOK', 1, '97549894', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(14, 'DA-0086', 'DA-0010', '-', '-', '', 1, '081584018776', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(15, 'SUKARJO', 'DA-0011', '-', '-', '', 1, '-', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(16, 'NURHOLIS B.M', 'DA-0012 C2', '09.5204.290558.0180', '5805.1205.2574', 'JL.DURI BARU RT008RW005 KEL.JEMBATAN BESI .JB', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(17, 'RIFAI', 'DA-0012 C3', '3.1730821107E+015', '701012055853', 'JL.KEMBANGAN RY GG.PANDAN 3, RT.02_x000D_\n/08 SRENGSENG', 1, '081908735233', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(18, 'CANDRA', 'DA-0013 C3', '', '740112052315', 'JL KP PONCOL RT 08/01 NO 110 KEL PEDURENAN TGR', 1, '''081219171505', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(19, 'PARLIUSAN', 'DA-0014 C3', '09.5310.290462.7002', '6204.1205.1418', 'H.JIMIN RT.009/002 PET UTARA PESANGGRAHAN JAK-SEL', 1, '081381951932', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(20, 'HERIZAL', 'DA-0014 C4', '0950070709710503', '7106120517721', 'KP BARU RT001/007 SUKABUUMI  JAKBAR', 1, '''081275751746', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(21, 'WANDI MAYLANA', 'DA-0014 C5', '36.0420.300572.0001', '7205.1205.4888', 'KAPUK RAYA TANIWAN RT.008/006 NO.26 KAPUK CENGKARE', 1, '''081910675858', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(22, 'IN. SOEGITO', 'DA-0016', '-', '-', '', 1, '08816806084', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(23, 'SUKARDI', 'DA-0016 C1', '32.7606.110568.0001', '6102.1205.1010', 'JL.H.ASMAWI RT 03/05 BEJI DEPOK', 1, '081808756350', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(24, 'SUPARNO', 'DA-0016 C2', '3315121303700003', '700314350372', 'JL. MALUKU III / 263 RT 07/07 AREN JAYA_x000D_\nBEKASI', 1, '081226329960', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(25, 'SUBEKTI HP.', 'DA-0016 C3', '09.5408.140763.0317', '6307.1205.5667', 'JL.PINANG RANTI RT 001/004 PINANG RANTI KEC MAKASA', 1, '96933886', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(26, 'WAWAN JOJO', 'DA-0017', '09.5203.190880.5567', '8008.1205.6426', 'JL.ABDULLAH III DLM RT.006/006 KRUKUT TAMAN SARI', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(27, 'MARTINUS M.NGADIWIJOYO', 'DA-0017 C1', '09.5204.281073.0380', '7310.1205.4209', 'JL.NUSA JAYA RT 04/02 NO 20 PONDOK RANJI PNDK AREN', 1, '083894242711', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(28, 'TOPAN HADIWIJAYA', 'DA-0017 C2', '09.5006.291269.0505', '691212057440', 'JL ANDONG 1 RT09/06 NO26 KOTA BAMBU PALMERAH', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(29, 'ICHWANI', 'DA-0017 C3', '0952052604670394', '570412055183', 'JL GUJI BARU RT 04/02 NO 122 KEL DURI KEPA', 1, '021 - 92077336', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(30, 'FAISAL', 'DA-0017 C4', '09.5208.070159.0274', '5901.1205.5148', 'JL. JALUR 20 RT.002/010 NO.49 KEL_x000D_\nMERUYA UTARA', 1, '''081386658095', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(31, 'DJABROS', 'DA-0017 C5', '0952051202495505', '490212055465', 'Jl.sa''aba raya Rt.016/02 Kel. Joglo Kec. Kembngan', 1, '083870268336', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(32, 'RAHMAT KURNIAWAN', 'DA-0018', '-', '-', '', 1, '-', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(33, 'ACHMAD SURAWAN', 'DA-0018 C1', '09.6310.200768.7004', '580712059328', 'Gg.bakti Rt.06/01 bintaro pesanggrahan_x000D_\njak-sel', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(34, 'SUGIYONO', 'DA-0018 C2', '0950020703742006', '740312056216', 'JL. LAUTZE DALAM RT16/07 KEL KARTINI _x000D_\nJAK-PUS', 1, '021-97283105', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(35, 'HADI SUTISNA', 'DA-0019', '-', '-', '', 1, '02195127440', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(36, 'AGUNG SUNARTO', 'DA-0019 C1', '321215020887003', '870812054845', 'JL MANGGA RAYA RT 04/03 NO 10 KEL DURI KEPA JAKBAR', 1, '''085719110133', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(37, 'ARIEF SETIO  BUDI UTOMO', 'DA-0019 C2', '09.5201.061080.0320', '8010.1205.9845', 'KP.UTAN BAHAGIA RT 007/07 KEL.CENGKARENG', 1, '''021-98718398', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(38, 'WAWAN KURNIAWAN', 'DA-0020', '-', '-', '', 1, '02185312600', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(39, 'ARIE SETIAWAN DJODI', 'DA-0020 C1', '952081402650479', '6502120510961', 'Jl.Kartika Rt 003/004 No.88 Meruya utra_x000D_\nJakBar', 1, '081386368907', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(40, 'SAINAN', 'DA-0020 C2', '3603031009520002', '520912054499', 'KP PETE RT 01/13 KEL  PETE TANGERANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(41, 'SOLIHIN', 'DA-0020 C3', '317304.020574.0016', '7405.1205.17745', 'JL.DURI BANGKIT RT.004/010 JEMBATAN BESI', 1, '''085876382824', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(42, 'RICHWANTONO', 'DA-0021', '36032.4260271', '7102.1205.6061', 'KP.LIO RT.002/03 PARIGI PD AREN TANGGERANG', 1, '081219937267', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(43, 'ROBERT SAMOSIR', 'DA-0022', '32.750120096.70015', '6702.1205.2101', 'KP. RAWA AREN RT.005/002 AREN JAYA BEKASI', 1, '081318542035', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(44, 'MU''ALIM', 'DA-0023', '09.5204.010364.0642', '6403.1205.52435', 'JL.KALI ANYAR RT014/001 KALI AYAR JAKBAR NO 29', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(45, 'DENO NOPIANDI', 'DA-0024', '10.5505.101176.1029', '7611.1205.11946', 'JL.WADAS III NO.11 RT008/004 JATI CEMPAKA PDK.GEDE', 1, '081385633150', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(46, 'DADI SUKARDI', 'DA-0025', '3.6031405066E+016', '', 'KOSAMBI TIMUR RT008/003 KOSAMBI TIMUR TANGERANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(47, 'SETIADI', 'DA-0026', '953040906550020', '550912054267', 'JL MENTENG JAYART 010/009KEL MENTENG JAK PUS', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(48, 'ASEP KABUL WIBAWA SH', 'DA-0027', '954010101660693', '6602120555878', 'JL BALAI RAKYAT NO;13 RT 001/010 UTAN KAYU UTARA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(49, 'SUWONO', 'DA-0027 B1', '0952021708650384', '6508120512047', 'JL KARTIKA RT 02/04 NO 88 MERUYA UTARA', 1, '081315426616', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(50, 'WARTANA', 'DA-0027 B2', '09.5208.100165.5522', '6510.1205.2908', 'JL. BAMBU II RT.008/06 NO.58B KEL_x000D_\nSRENGSENG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(51, 'M. ZEN', 'DA-0028', '09.5404.250252.0136', '5202.1205.0463', 'KPNG PULO RT.012/003 KEL.KAMPUNG MELAYU,JAK-TIM', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(52, 'UU.  ANWAR B AYO', 'DA-0029', '09.5102.261072.0447', '7210.1205.14136', 'JL.GUSTI GG.KANTONG RT 08/15 PEJAGALAN', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(53, 'DARYANTO', 'DA-0030', '09.5305.290966.0348', '6609.1205.1915', 'JL.KERTA JAYA 1 RT 016/1 NO.22 KEL PENJARINGAN', 1, '021 -33583121', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(54, 'BUDI SETIONO', 'DA-0031 C1', '3219082010.34209', '6809.1205.4020', 'PERUM GRIYA ISLAM BLOK BJ/11 RT19/06 KRESEK TGR', 1, '021-92446985', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(55, 'SUNARYO', 'DA-0032', '952061709745517', '7409120599799', 'KEDOYA SASAK RT 011/05 NO;12 KEDOYA SELATAN KB', 1, '081316903816', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(56, 'MUKHLISIN', 'DA-0032 C1', '36.710226.1074.0003', '7410.1205.14469', 'KP. CIKONENG GIRANG RT.02/04 MANIS_x000D_\nJAYA TGRG', 1, '''082123020607', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(57, 'YUSUP', 'DA-0032 C2', '31.7308.140365.0007', '6503.1205.10307', 'JL. RY JOGLO GG. MASJID RT.001/09 NO._x000D_\n25 KEL. JOG', 1, '''087771261272', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(58, 'SUMARNO', 'DA-0033 C1', '', '', 'JL X ANYAR IX RT 014/01 NO;05 X ANYAR TAMBORA JKB', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(59, 'TAUFIK HIDAYAT', 'DA-0034', '0954091002760324', '7602120512395', 'LUBANG BUAYA RT04/07 LUBANG BUAYA CIPAYUNG JAKTIM', 1, '021-98987976', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(60, 'DESRIZAL EFENDI', 'DA-0035 C1', '09.5304.201281.0257', '781212055291', 'JL MESJID AL MAKMUR RT 017/007 PEJATEN TMR JAK SEL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(61, 'ROMADI', 'DA-0036', '954031302610348', '610212050602', 'JL KP BARU RT 010/021 JATINEGARA JAK TIM CAKUNG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(62, 'M. HUSNI THAMRIN', 'DA-0036 C1', '09.5401.120854.0521', '5408.1205.5738', 'JL.MATRAMAN SALEMBA VI RT014/001 KBN MANGGIS', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(63, 'TJETJEP', 'DA-0037', '09.5401.011260.0504', '6012.1205.4400', 'GG.SIRSAK RT.001/010 UTAN KAYU UTARA JAKTIM', 1, '085717250540', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(64, 'MAT SOLEH', 'DA-0037 C1', '31.7301.230677.0012', '7706.12051.6284', 'KP KELINGKIT RT.008/011 KEL RAWA BUAYA', 1, '''085283652919', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(65, 'ZAENAL ABIDIN', 'DA-0038 C1', '0950061705610436', '610512053409', 'Jl. Mantraman 1 no 24 rt 014/001 kebom manggis', 1, '''081384999544', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(66, 'SUDIYANTO', 'DA-0039', '09.5204.121260.0484', '5912.1206.6485', 'PESING GADOG RT.004/004_x000D_\nKEDOYA UTARA JAK-BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(67, 'ERLAN', 'DA-0039 C1', '09.5102.170277.0431', '7702.1205.2605', 'KAMPUNG GUSTI NO.33 RT 008/015 PENJARINGAN JAKUT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(68, 'H. SUHERMAN', 'DA-0039 C2', '3601062907570001', '570713210022', 'KP GUSTI Gg KENTUNG RT 08/015 NO 18 PENJRINGAN JAK', 1, '081574990787', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(69, 'NASIRUDIN', 'DA-0039 C4', '36.012602.0864.0001', '710813210017', 'JL. PERMATA GG. KANTONG KP GUSTI_x000D_\nRT.05/015 NO.36', 1, '''081398163384', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(70, 'MICHTAHUDIN', 'DA-0040', '', '690712054177', 'JL KARTA JAYA 1 RT 015/14PENJARINGAN JAK -UT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(71, 'EPUL RENDI WELLA', 'DA-0040 C1', '09.5208.270178.0402', '7801.1205.56409', 'JL. JOGLO BARU RT.03/06 KEL.JOGLO_x000D_\nKEC.KEMBANGAN', 1, '''082167481769', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(72, 'SUMARDI', 'DA-0041', '09.520501026.0595', '650212051422', 'KEPA DURI RAYA RT 07/03 NO;14 KEL DURI KEPA', 1, '081385722739', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(73, 'BAYU AWAN SUGIARTO', 'DA-0042', '10.5505.211179.1001', '7911.1220.1187', 'CEMPAKA BARU RT06/06KEL JATI WARINGIN BKS', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(74, 'PAINO', 'DA-0043', '09.5204.161082.0284', '8210.1205.5295', 'JL.KRENDANG SEL.RT02/06 KEL KRENDANG JAK-BAR', 1, '087882423108', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(75, 'SURIPNO', 'DA-0044', '36.7109030.4820006', '8204.1205.14018', 'KP.CIBODAS RT 003/004 CIBODAS TANGGERANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(76, 'SUHALI', 'DA-0044 B1', '6211.1205.4260', '31.7302.101156.0001', 'JL PENYELESSAIAN TOMANG II RT 003/001 KEL MERUYA', 1, '''082110219173', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(77, 'ROBBY DENI EMOR', 'DA-0044 B2', '36.7406.080470.0001', '7004.1222.1003', 'JL ARIA PURA R.009/010 NO.18 KEL KEDAUNG KEC PMLAN', 1, '''085287675040', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(78, 'ROESMAN', 'DA-0045', '10.1210.051155.1001', '5511.12050.46', 'KP.PASIR RANDU RT.12/06 SUKASARI SERANG CIKARANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(79, 'DARPI R.R.N', 'DA-0045 B1', '09.5205.030555.0238', '5505.1205.2819', 'KP.BARU RT 001/010 NO:46 KEL.KEMBANGAN UTR JAKBAR', 1, '081330366250', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(80, 'MUHAMAD', 'DA-0046', '', '', 'JL DAMAI 2 RT 08/05 NO;32A KEL PEJATEN TIMUR PASAR', 1, '081384375138', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(81, 'YAPUDIN', 'DA-0047', '09.5201.111065.5505', '6411.1205.3247', 'TANAH KOJA RT.003/003 KEL DURI KOSAMBI JAKBAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(82, 'MANSUR', 'DA-0047 B1', '0952080709710449', '710912057211', 'JL PENYELESAIAN TOMANG III BLOCK 41/30 RT 02/10', 1, '''081282644776', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(83, 'GUSNARTO', 'DA-0048 B1', '09.5306.100469.0761', '6904.1205.3467', 'JL.PINANG NO 74 RT007/002 KEL.PONDOK LABU CILANDAK', 1, '085289602163', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(84, 'VETRA', 'DA-0048 B2', '31.74080.10966.0002', '6609120515028', 'JL MASJID AL MAKMUR RT014/07 PEJATEN TIMUR', 1, '''0813 82540200', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(85, 'MUNAWIR', 'DA-0048 B3', '31.7308.200263.0006', '6302.1205.5459', 'JL.MASJID AT-TAQWA RT 001/002 KEMBANGAN UTARA', 1, '''087809532265', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(86, 'UDIN', 'DA-0048 B5', '31.7304.120371.0003', '7103.1205.45117', 'Jl. mangga besar Dua selatan Kec. sawah besar JP', 1, '.0219226858631', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(87, 'EDING .SUSWANTORO', 'DA-0049', '327504100600706', '750212058076', 'KP GUSTI RT 002/015KEL PEJAGALAN PENJARINGAN JAKUT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(88, 'NARAH', 'DA-0050', '09.5402020.9680334', '6809.1205.10642', 'KAMPUNG BARU RT006/07 KAYU PUTIH JAK TIM', 1, '181219980262', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(89, 'WASLIM', 'DA-0051', '952050512570737', '571212051206', 'KP GUJI RT 003/02 DURI KEPA KEBON JERUK JAK BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(90, 'AHMAT SUKANDEG', 'DA-0051 C1', '09.5008.080277.2009', '7702120511930', 'GUJI BARU BARAT RT.004/002 DURI KEPA KEBON JERUK', 1, '''081388517201', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(91, 'RUMANI', 'DA-0051 C2', '09.5204.100756.0186', '560712053444', 'JL PERSIMA 2 RT003/01 KEL KALI ANYAR TAMBORA', 1, '085214778152', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(92, 'RAZI', 'DA-0051 C3', '0952042612610507', '611212051486', 'JL ANGKE INDAH RT 003/02 TAMBORA_x000D_\nJAK-BAR', 1, '''081284975665', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(93, 'ALI RACHMAT', 'DA-0051 C4', '0952081110730453', '731012054235', 'JL JOGLO BARU RT 05/ 006 BLOK D1 / 46 JOGLO JAKBAR', 1, '''021-95134383', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(94, 'BENI ROSMANA', 'DA-0052', '', '', 'DS SATRIA JAYA RT 01/03 NO;300A TAMBUN UTARA BKS', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(95, 'RACHMAT SOLEH', 'DA-0053', '', '', 'JL PEKAPURAN 2 RT 05/06 KEL TANAH SEREAL TAMBORA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(96, 'EDI SUBAGYO', 'DA-0053 C1', '0952030905770612', '790512056882', 'JL. KEAGUNGAN RT.012/003 KEAGUNGAN_x000D_\nRT012/003 TMN', 1, '''085814214033', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(97, 'TOLKHA', 'DA-0053 C2', '317304.050782.0010', '8207.1205.12145', 'JL.TAMBORA MEJID RT.003/003 TAMBORA JAK-BAR', 1, '085640072370', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(98, 'TARJONO', 'DA-0054', '', '', 'JL KAV PEMUDA BAWAH RT 04/06 NO;38 PANUNGGANGAN', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(99, 'EDDY KHUNAEDI', 'DA-0054 C1', '0950062203742012', '740312057227', 'JL. AT TAQWA 3 KAMP PONCOL _x000D_\nPEDURENAN RT 002/001', 1, '''081908141023', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(100, 'FAKHRUDIN', 'DA-0054 C2', '3,17304110784001E+01', '8407.1205.5247', 'JL. TAMBORA3 GG 3/63 RT.006/07_x000D_\nTAMBORA JAKBAR', 1, '''085697605707', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(101, 'HENDI S', 'DA-0054 C3', '3173032908800011', '8008120514801', 'JL.KESEDERHANAAN RT07/05 KEANGUNGAN JAKBAR', 1, '''081395103502', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(102, 'SUARDI SITORUS', 'DA-0054 C4', '09.5201.100674.5851', '7406-1205.15851', 'Jl. Raya Rt. 001/014 No.11 Kel Cngkareng_x000D_\nJakbar', 1, '''085814025502', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(103, 'NHANUNG JANURI', 'DA-0054 C5', '3.32908100273001E+01', '', 'JL PONDOK II GG LURAH RT006/02 NO 13 TANGERANG', 1, '081911473179', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(104, 'ROHIMAN', 'DA-0055', '', '', 'JL CINANGNENG RT 003/013 NO 9 KEL CIAMPEA BOGOR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(105, 'KATMO', 'DA-0055 C', '3174051006580012', '580612051605', 'JL.CIPEDAK III Rt.006/03 CIPEDAK KEC. JAGAKARSA _x000D_\n', 1, '08176478842', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(106, 'TARWIN', 'DA-0055 C2', '0952082412660386', '661212050960', 'GG H BANGENG RT013/03 KEMBANGAN JAKARTA BARAT', 1, '''085782128543', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(107, 'S.AHMAD B.SALIM', 'DA-0056', '09.5308.030543.0051', '', 'PENGADEGAN TIMUR 1/2 RT 001/02 PENGADEGAN PANCORAN', 1, '02198332318', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(108, 'YANA SURYANA', 'DA-0056 C1', '09.5303.150576.7045', '7605.1205.9680', 'JLN. BANGKA IX RT08RW010 KEL.PELA MAMPANG  JAK-SEL', 1, '021834355138', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(109, 'ASBANI', 'DA-0056 C2', '09.5304.170359.0126', '5903.1205.2670', 'JL.ANGSANA DLM 1/KEL.PEJATEN TIMUR PSR MINGGU', 1, '085691363362', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(110, 'MUHAMAD TIWO', 'DA-0056 C3', '09.5308.250567.0499', '6705.1205.3862', 'DUREN TIGA RT.010/007 DURENTIGA_x000D_\nJAKARTA SELATAN', 1, '''081389771123', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(111, 'UMAR IRANA', 'DA-0056 C4', '31.7408.311081.1002', '8110.1205.15372', 'JL. BANGKA X RT.02/03 KELURAHAN_x000D_\nTEGAL PARANG', 1, '''088210155055', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(112, 'SYAMSUL BAHRI', 'DA-0056 C5', '317504.050276.0006', '7602.1205.2960', 'JL.CILIWUNG 1 NO.10RT 009/006 CILILITAN JAKTIM', 1, '''085283089361', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(113, 'BAMBANG BIN S', 'DA-0056 C6', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(114, 'DANURI', 'DA-0057', '09.5001.121260.0436', '6012.1205.7228', 'JL.KP. UTAN BAHAGIA RT007/006 CENGKARENG TIMUR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(115, 'ABDUL RAHMAN BA', 'DA-0057 C1', '09.5405.220458.0232', '', 'JL.KALI BATA RT.02/07 NO 13 KEL.CILILITAN', 1, '93564715', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(116, 'MOCH IDRIS', 'DA-0057 C2', '09.5006.221267.0353', '6712120554320', 'Jln.Menteng Sukabumi 008/03 no 19 menteng jakpus', 1, '''021 99488675', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(117, 'TAUFIK NUROHMAN', 'DA-0058', '950010602792027', '790212055419', 'JL CIBUNAR RT03/04DURI PULO GAMBIR KJAK PUS', 1, '081280073724', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(118, 'H. MUHIBUDIN', 'DA-0058 C1', '3174091707590006', '590712056760', 'JL.RAYA LENTENG AGUNG GG.GURU RT.006/002 NO.52', 1, '''021-93025613', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(119, 'AHMAD ZAENUDIN', 'DA-0058 C2', '09.5204.06560.0173', '600812054221', 'JL RAYA PENINGGILAN GG H LANCONG RT 001/01 NO 33', 1, '''081904699919', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(120, 'A SUKARNA', 'DA-0058 C3', '3.17106010559001E+01', '590512052487', 'JL MENTENG JAYA RT 014/009 MENTENG JAK-PUS', 1, '085695592135', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(121, 'SUHARJA', 'DA-0058 C4', '32.0329.041170.03929', '7011.1220.0245', 'KP TEGAL  RT.005/002 KEL CILAKU KEC TENJO', 1, '''081317164298', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(122, 'MAFTUHIN', 'DA-0059', '09.5003.131265.0420', '651212059341', 'JL KRAMAT IV UJUNG RT 013/06 KEL KWITANG SENEN', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(123, 'ABDUL YUSUF', 'DA-0059 C1', '09.5205.041066.0468', '6810.1205.7073', 'KEPA DURI RT 007/004 DURI KEPA JAKBAR', 1, '081281276558', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(124, 'WIDODO', 'DA-0060', '', '5502.1205.0930', 'KAMPUNG SUKAMULYA RT 03/01 DESA LEUWI MEKAR KAB', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(125, 'SEHUDIN', 'DA-0060 C1', '317302.180975.0004', '7509.1205.12028', 'JL.INDRA LOKA I NO.103 RT 008/010 JELAMBAR', 1, '''087717766034', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(126, 'ENDONG', 'DA-0060 C2', '3.602189090668E+016', '680612058316', 'JL RAYA JEMBATAN 3 RT 001/011 PEJAGALAN PENJARINGA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(127, 'MOCH SUGIYONO', 'DA-0061', '3177732007/15617', '670512210688', 'JL SALAK 1 RT 06/09NO;76 KEL ABADI JAYA SUKMAJAYA', 1, '081311256822', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(128, 'AHMAD BIN MASIM', 'DA-0062', '', '', 'JL KEDAUNG KALI ANGKE RT 04/08 NO ;27FKALI ANGKE', 1, '081383607328', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(129, 'INU SUTARYA', 'DA-0063', '3.67106070863E+015', '63081057616', 'JL SWADAYA 5 RT 003/05 NO;23 PARUNG SEREB CILEDUG', 1, '''081316742292', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(130, 'JUMADI', 'DA-0064', '', '', 'JL AL FALAH 1 RT 013/01 NO;37 KEL JATI PADANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(131, 'TOBRI B SARKAWIH', 'DA-0065', '95208121650332', '651112054075', 'KP BARU SIMPANG TIGA RT 05/05 PADEMANGAN X DERES', 1, '08811373536', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(132, 'ABDUL AZIS', 'DA-0066', '09.5204.080765.0456', '6507.1205.7990', 'JL.KALI ANYAR RT 013/001 TAMBORA JAK-BAR', 1, '081381758515', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(133, 'HARURI', 'DA-0066 B1', '3674032103520003', '590412051256', 'KP PABUARAN Gg MUSOLAH RT 06/08 PDK KARYA TGRNG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(134, 'ZAINIK', 'DA-0067', '950070410572008', '571012056626', 'JL PETAMBURAN II RT 011/03 TN ABANG JAK PUS', 1, '081386087730', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(135, 'RAMLI', 'DA-0068', '', '', 'JL.INPEKSI 74 RT07/04 KEL.KEMANGGISAN KEC.PALMERAH', 1, '088210605969', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(136, 'AHMAD ROHANI', 'DA-0069', '952031310640246', '641012059613', 'JL H ALI RT 02/07 NO;38 KEL TEGAL PARANG MAMPANG', 1, '''0817713582', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(137, 'SUBUR JAYA', 'DA-0070', '', '', 'JL.UTAN JATI RT 005/011 NO 27 PEGADUNGAN KALI DERE', 1, '081385920554', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(138, 'RISWONO', 'DA-0071', '31.7304.130573.0007', '7305.1205.4410', 'JL. DURI UTARA GG. LIMA RT.07/06 NO06_x000D_\nTAMBORA J-B', 1, '''085811422600', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(139, 'BASRAH', 'DA-0072', '952070202575502', '570212054136', 'KP BARU SIMPANG TIGA RT 05/08PADEMANGAN KALI DERES', 1, '''55950282', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(140, 'ROHMANI', 'DA-0073', '09.5303.311259.0450', '5912.1205.4270', 'JL.PONCOL JAYA GG.11-2 RT 003/04 NO 12 KUNINGAN', 1, '087878831129', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(141, 'AMAR', 'DA-0073 C1', '3671092709600001', '600912056479', 'PERUM II KARAWACI JL RUSA VI 22 RT 04/09 TGR', 1, '93291686', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(142, 'IMAM SAPI''I', 'DA-0073 C2', '09.5404.150772.8509', '7207.12057433', 'JL. TANAH MERDEKA RT. 003 /003 CIP_x000D_\nCEMPEDAK JAK		', 1, '''081887062417', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(143, 'YANI', 'DA-0073 C3', '09.5204.010175.1057', '7501.1205.11110', 'JL. PEKAPURAN RAYA RT.01/06 TANAH SEREAL-TAMBORA', 1, '''087880265777', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(144, 'JOKO RAHARJO', 'DA-0073 C4', '331022220583', '83054430881', 'MENTENG TENGGULUN MENTENG RT004/010 JAKPUS', 1, '''021-96983970', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(145, 'CECEP SUPRIYATNA', 'DA-0073 C5', '31.71061109700001', '7008120575359', 'JL. RY MENTENG JAYA RT.005/001 KEL. MENTENG JAK PU', 1, '''021 96652065', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(146, 'WASIMAN', 'DA-0074', '', '', 'KP STANGKLE RT 03/06 NO;21 KEL KEMIRI KEC BEJI DPK', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(147, 'CHARLES BATUA', 'DA-0074 C1', '09.5305.220455.0152', '55.0412.0556.35', 'MAMPANG PRAPATAN II Gg BB Rt.008/02 NO.12', 1, '''021-93919215', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(148, 'TARADI', 'DA-0075', '36.7101.200980.0011', '8009.12057.143', 'KP.BARU SIMPANG TIGA RT005/08 KEL.PEGADUNGAN', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(149, 'SUBODO', 'DA-0076', '', '', 'JL DURI BARU RT 008/05 NO;15 JELAMBAR BARAT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(150, 'SUPRIYANTO', 'DA-0076 C1', '', '', 'JL TIPAR RT 009/009 KEL CAKUNG BARAT JAKTIM', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(151, 'AWANG THOIB', 'DA-0076 C2', '0952042408690406', '690812053383', 'JL KALI ANYAR III RT 008/01 NO:17 KALI ANYAR JAKBA', 1, '''081281694054', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(152, 'ROHMAN BIN HS', 'DA-0076 C3', '09.5201.010962.0198', '6209.1205.3284', 'JL. BOJONG RY. RT 02/04 NO.36 KEL_x000D_\nRAWABUAYAJAKBAR', 1, '021 90389678', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(153, 'RUSNATA', 'DA-0076 C4', '3276111111760001', '7605120558403', 'JL UTAN JATI Gg masjid rt09/011 pgadungan x dres', 1, '''081807566763', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(154, 'MOCH YUNUS', 'DA-0076 C5', '31.7408.020464.0005', '6404.1205.1132', 'JL. PANCORAN BARAT IIRT.0014/06 NO34_x000D_\nKEL PANCORAN', 1, '''021 50610252', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(155, 'BAHRI', 'DA-0077 C2', '3173071601580002', '580112051679', 'GG.RS PELNI RT.011/001 PALMERAH JAK-BAR', 1, '021-95394216', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(156, 'RAMDANI', 'DA-0078', '09.5206.030358.0599', '5803.1205.6005', 'JL. MANGGA I KP PAKEMBANGAN BARAT RT004/05', 1, '''087886925128', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(157, 'GERSON SINAGA', 'DA-0078 C1', '', '', 'JL NURBAYA RT 017/02 NO 17 KEL PINANG RANTI MAKASA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(158, 'MUH RUSTIYO', 'DA-0079', '', '', 'JL MAMPANG PEREMPATAN XI RT 001/04 TEGAL PARANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(159, 'KADAR', 'DA-0079 C1', '09.5207.121260.1047', '6012.1205.1300', 'JL.R.MOCH KAHFI  II RT.006/003 KEL.CIPEDAK', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(160, 'DJUNED', 'DA-0079 C2', '', '', 'KP.SALO RT 10/04 KEMBANGAN UTARA JAK-BAR', 1, '081318233986', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(161, 'SUDIRNO', 'DA-0080', '', '', 'JL HUTAN BAHAGIA RT 07/07 NO;09 CENGKARENG JAK BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(162, 'SAKUR  MATSANIP', 'DA-0081', '952041403650222', '650312054335', 'JL KALI ANYAR 11 RT 013/01 TAMBORA JAK BAR', 1, '087883394889', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(163, 'AGUS RIZAL.M', 'DA-0082', '', '', 'JL JOE KEBAGUSAN RT 007/004 NO 14 KEBAGUSAN PSR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(164, 'PEPEN SOPENDI', 'DA-0083', '09.5208.220552.0203', '5202.1205.2337', 'JL RAYA JOGLO RT13/02 JOGLO KEMBANGAN JAK-BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(165, 'MADROJI', 'DA-0083 B', '3603202001790001', '7901120559648', 'KP BLOK TUGU RT 001/003 NO.14 KEL SERDANG WETAN TG', 1, '''021-97925255', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(166, 'MADROJI', 'DA-0083 B1', '3603202001790001', '7901120559648', 'KP BLOK TUGU RT 001/003 NO 14 KEL SERDANG WETAN', 1, '''97925255', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(167, 'WAKIM', 'DA-0084', '', '', 'KP BANJIR KANAL RT 011/01 GROGOL PETAMBURAN', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(168, 'MANSUR SAYUTI', 'DA-0084 B1', '317405.171163.0009', '6311.1205.10735', 'Gg.SAIRI RT 003/008 KEB LAM UTR KEB LAM JAKSEL', 1, '081808119151', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(169, 'SUTARJO', 'DA-0084 B2', '36.7112.101066.0006', '6610.1205.0973', 'JL.KARYAWAN I / 78 RT 003/005 KARANGTENGAH', 1, '''021 31708799', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(170, 'SADIMIN', 'DA-0085', '09.5204.311265.1251', '6512120514172', 'JL.X ANYAR 013/01 KEL.X ANYAR TAMBORA JAKBAR', 1, '''081325388732', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(171, 'MUKSIN', 'DA-0086', '09.5208.150762.0758', '620712059234', 'KP SALO RT 007/04 NO;46 KEMBANGAN UTARA JAK BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(172, 'HOLIK P MINA', 'DA-0087', '3.50909050859E+015', '590815320791', 'JL CIRACAS RT 002/03 NO:12KEL KP TAMBAK JAKTIM', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(173, 'SUHERMAN', 'DA-0088 B1', '360335.230773.0001', '7307.1205.54404', 'PNDK.PAKULONAN RT002/005 PAKU ALAM SERPONG UTARA', 1, '085211022065', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(174, 'TOPALI', 'DA-0088 B2', '09.5208.140882.0225', '8208.1205.7977', 'JL. H.MANDOR SALIM RT005/02 SRENGSENG JAKBAR', 1, '''081218950611', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(175, 'ABDULLOH', 'DA-0088 B3', '09.5201.140669.5518', '6906.1205.98095', 'JL. KH. ASYIM GG. H. DALI RT.005/001_x000D_\nNO.24 KEMB', 1, '''021 98736945', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(176, 'KARSIM', 'DA-0088 B4', '09.5107.040782.0224', '8207.1428.0218', 'JL MANGGA 2 KP MUKA RT.009.004 NO.15B KEL ANCOL', 1, '''087782275970', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(177, 'TOPALI', 'DA-0088 C2', '09.5208.140882.0225', '8208.1205.7977', 'JL.H.MANDOR SALIM RT.005/002 SRENGSENG JAKBAR', 1, '081218950611', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(178, 'ASRIL', 'DA-0089', '377105.120769.0003', '6907.1205.10283', 'JL.PULO INDAH RT002/04KEL.PETIR KEC.CIPONDOH TGR', 1, '02198726409', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(179, 'M HUSNI', 'DA-0090', '', '', 'JL DPR RI  01 GG GOTONG ROYONG RT 003/02 NO;39', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(180, 'EKO SARONTO', 'DA-0091', '', '', 'JL JEMBATAN BESI V111 RT 07/05 NO;37 TAMBORA JKB', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(181, 'NUR SALIM', 'DA-0091 C1', '3173042111560006', '561112052140', 'JL. KALI ANYAR III RT 008/001 KEL X ANYAR JAKBAR', 1, '''''081225394230', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(182, 'BAMBANG INDRA NOVIARDI ST', 'DA-0092', '09.5205.021173.0263', '7311.1205.60151', 'JL. PALAPA KAV 830RT9/7 DURI KEPA_x000D_\nJAKARTA BARAT', 1, ';021 98079736', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(183, 'YANTO', 'DA-0092 C1', '31.7106.050675.0005', '7506.1205.7371', 'JL.UNGGARAN UJUNG RT 03/05 NO 16 KEL. PSR MANGGIS', 1, '''021 92274026', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(184, 'SATRIA', 'DA-0093', '', '', 'KP PARUNG SARI RT 003/10 KEL SIPAR KEC JASINGA BGR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(185, 'UDIN SYAMSUDIN', 'DA-0093 C1', '320301.071265.06869', '', 'KP.PARUNG SAPI RT.01/10  DS.SIPAK JASINGA BGR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(186, 'SHOKIB', 'DA-0093 C2', '09.5204.140168.5508', '680112053671', 'JL.KALI ANYAR I RT.005/009 KEL. KALI ANYAR TAMBORA', 1, '''081210599655', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(187, 'WARTOMO', 'DA-0093 C3', '09.5206.200664.0536', '640812055400', 'JL KOTA BAMBU SELATAN V1 RT 06/05 NO ;48 PALMERAH', 1, '08128325808', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(188, 'MUCHLIS GUNAWAN', 'DA-0093 C4', '_x000D_\n32,0310140878052', '780813252963', 'JL. RY CIAWI RT.012/03 KP. KEMBANGAN_x000D_\nBANJAR SARI', 1, '0251 255105', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(189, 'TAMIL', 'DA-0093 C5', '3303142011790009', '791114240462', 'BEJI RT.015/007 DS.BEJI KEC. BOJONG SARI PURBALING', 1, '''085888799892', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(190, 'KARSUM', 'DA-0094', '32.75.05.2001.04118', '7705.1205.9448', 'PORIS GAGA BLOK.SUKADAMAI RT03/04 KEL.PORIS GAGA', 1, '081317471944', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(191, 'ABD ROSJID', 'DA-0094 C1', '09.5007.030454.0420', '5464.1205.4519', 'JL RAYA RINGROAD RT.005/003 KEL RAWA BUAYA', 1, '''087882424351', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(192, 'AHMAD TIONO', 'DA-0095', '09.5204.150567.0758', '670512057304', 'DURI BARU RT07/05 NO 45 KEL JEMBTAN BESI JAK-BAR', 1, '''085214000561', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(193, 'AGUS WINARYO', 'DA-0095 C1', '952040708880262', '880812052612', 'JL KALI ANYAR 11 RT 013/01 TAMBORA JAK-BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(194, 'ARIS SETIAWAN', 'DA-0095 C2', '', '', 'RAWA BUAYA RT 012/02 KEL RAWA BUAYA CENGKARENG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(195, 'DEDI', 'DA-0095 C3', '0953091008737052', '7308120515718', 'KP BALI BATA RT09/08 KEL SRENSENG SWH JAKSEL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(196, 'PASMI B.SADIR', 'DA-0096', '360307.110864.0001', '6408.12220.153', 'KP.BABAKAN RT 09/03 KEL.PASIR KEC.KRONJO TGR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(197, 'SIDIK SURYONO', 'DA-0096 C1', '09.5006.500375.0357', '750312053037', 'JL MENTENG TENGGULUN RT 006/010 MENTENG JAK PUS', 1, '021 98783096', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(198, 'EFENDI B1', 'DA-0097', '3301152308690002', '690814230816', 'DESA MADURA RT.003/004 KRNG ANYAR WANAREJA CILACAP', 1, '''087880937366', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(199, 'YUSRI', 'DA-0097 C1', '36.60422.12574.0002', '7405.1320.0576', 'KP. MUNTUR RT/07/03 BAROS SERANG_x000D_\nPANYIRAPAN BAROS', 1, '''021 948628933', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(200, 'A. SUKARYO', 'DA-0097 C2', '09.5205.290956.0429', '5609.1205.5798', 'PESING GOT KEDOYA RT 001/007 KEDOYA UTR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(201, 'MULYA DARMA', 'DA-0098', '950011810610008', '611012058708', 'PEMBANGUNAN IV NO'' 123 RT 012/01 PETOJO UTARA', 1, '63855482', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(202, 'SUDJUD PURDIANTO', 'DA-0098 C1', '3219032005.50073', '', 'JL.MAWAR 2 NO 27 KOMP RSAD.HARKIT RT 01/02 TGR', 1, '02199412919', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(203, 'DENDY KOSWARA', 'DA-0098 C2', '09.5208.101075.5562', '7510.1205.55374', 'JL.FLAMBOYAN RT.04/02 NO.11A KEL.SRENGSENG KEMBANG', 1, '081808154600', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(204, 'MUHADI', 'DA-0098 C3', '09.5209050967.0495', '6708120559102', 'KP BARU RT 004/010 NO 23 KEL KEMBANGAN UTARA', 1, '021 96889116', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(205, 'PAULUS J.M', 'DA-0098 C5', '09.5201.060763.0789', '630712211190', 'AL KTP : KAPUK PROYEK 03/07 KAPUK CENGKARENG JAKBA', 1, '''93559045', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(206, 'TIYARSO', 'DA-0098 C6', '3172021212590022', '591212052144', 'Jl.Mangga Dua Raya Gg.Da''o Rt008/03 No.42', 1, '''0819877661', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(207, 'SUTARYO', 'DA-0098 C7', '3.32710110459004E+01', '5904120555650', 'JL BUDI MULYA RT 008/012 PADEMANGAN BARAT JAKUT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(208, 'SUKAMTO', 'DA-0098-C3', '3.60335240552E+015', '520512055486 BI/U', 'Kp.Buaran Gg.Mesjid Al-Barokah Rt.07/02  Lengkong', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(209, 'AGUS AMIR', 'DA-0099', '09.5206.040863.0016', '630812051049', 'JL. KOTA BAMBU UTARA RT.002/001_x000D_\nKOTA BAMBU UTARA', 1, '''021 99387066', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(210, 'ALI SODIKIN', 'DA-0100', '09.5208.031080.5585', '8010.1205.10108', 'JL.H.MANDOR SALIM RT05/02 KEL.SERENGSENG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(211, 'EDI KURNIWAN', 'DA-0100 C1', '', '6906.1326.0571', 'JL.SAWO RT.04/09 NO 50 JATI PULO PALMERAH JAKBAR', 1, '087820970376', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(212, 'LILI', 'DA-0100 C2', '0952062412870299', '6712120510355', 'JL PONDOK BANDUNG RT 011/02 NO 129 KOTA BAMBU PALM', 1, '''021-90451191', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(213, 'GATOT', 'DA-0101', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(214, 'MASRIZAL.MT', 'DA-0102', '317305.050466.0014', '6604.1205.7292', 'JL.H.RAUSIN RT005/008 KEL.KLP.DUA KEC.KBN JRK', 1, '081382800469', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(215, 'LOSMEN LUBIS', 'DA-0103', '3.21905200715916E+01', '630212057572', 'KP BUARAN TR 03/  NO:33BUARAN SERPONG TANGERANNG', 1, '99198046', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(216, 'CEPPY PRANATA', 'DA-0104', '3603282901810001', '810112220582', 'PERUM DASANA INDAH RI. 6/28 RT.009/_x000D_\n015 BJ NANGKA', 1, '021-99442452', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(217, 'RUSLI ASMUNI', 'DA-0105', '09.5304.081178.0308', '7811.1205.10184', 'GG.SOSIAL /12 RT009/001 KEC.PSR MINGGU JAKSEL', 1, '02196125202', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(218, 'KURDI', 'DA-0105 B1', '33.2909.210182.0005', '8201.1431.10859', 'JL MANGGA DUA RY GG BURUNG RT 03/05 PINANGSIA SARI', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(219, 'SOKHIBI', 'DA-0106', '09.5007.281270.0461', '701212057443', 'JL.MENJANGAN V RT.01/01 PD RANJI_x000D_\nCIPUTAT TMR-TNG', 1, '''087881701303', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(220, 'RUSLI', 'DA-0107 B1', '09.5202.010972.0256', '720912055392', 'GG DUKUH 1NO 13 RT 02/07TJ DUREN UTARA', 1, '02194676711', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(221, 'BENNY WIEDIHARTO', 'DA-0108', '', '', 'JLDEPSOS IV RT005/02 NO4 KEC.BINTARO JAKSEL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(222, 'SOFIYAN', 'DA-0109', '09.5208.030483.0217', '830412058344', 'JL.H.SALEHBNO.33 RT.006/0011 PAL_x000D_\nMERAH JAK-BAR_x000D_\n', 1, '021-96912325', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(223, 'P. KARYO. SALAH', 'DA-0109 B I', '09.5208.200973.0324', '730912056247', 'JL RADEN SALEH GG SWADAYA RT003/04 NO 32 KARANG TE', 1, '087876680657', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(224, 'PRIYO KARYONO PUTRO', 'DA-0109B1', '0952012809730324', '730912056247', 'Jl.raden saleh Gg.swadaya RT.003/004 no 32', 1, '087876680657', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(225, 'YAKUB GINTING', 'DA-0110', '09.5309.010868.0606', '680812054409', 'JL.KELAPA TIGA RT.001/06 LENTENG AGUNG-JAKSEL', 1, '''08174997885', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(226, 'RUSDI', 'DA-0111', '09.5205.071274.0293', '7412.1205.3718', 'KAMPUNG KECIL RT005/01 SUKABUMI SLT KBN JRK', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(227, 'INDRA', 'DA-0112', '09.5205.200482.5529', '8204.1205.7883', 'JL.F KP.PERJUANGAN RT010/010 KBN JERUK JAKBAR', 1, '081382653381', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(228, 'ENDANG SUHERMAN', 'DA-0112 C1', '3171021505690004', '690612054266', 'JL.D GG I/15 KRG ANYAR RT06/01 KRG ANYAR JAKPUS', 1, '''081288075879', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(229, 'RONNI MARIHOT PASARIBU', 'DA-0113', '09.5305.031169.0248', '6911.1205.1995', 'JL PENINGGARAN NO 83 RT 012/009 KEB LAM UTR JAKSEL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(230, 'MUMU MULYADI', 'DA-0114', '3603281212530003', '531212058055', 'PERUM DASANA INDAH RI.6/28 RT.009/_x000D_\n012 BJ NANGKA', 1, '''021-93433197', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(231, 'DEDI TRIHARTANTO', 'DA-0115', '', '', 'JL.LEBAK PASAR RT.09/08 KEL.PEJATEN TIMUR JAK-SEL', 1, '081283916867', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(232, 'M. IQBAL YUSDA', 'DA-0115 C2', '32.7601.130474.0001', '7404.1344.0253', 'BATU JAYA PANCORAN MAS KOTA_x000D_\nDEPOK', 1, '''021 93179876', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(233, 'SUPRIATNA', 'DA-0115 C3', '09.5304.090178.0126', '7801.1205.10507', 'JL. RAYA PASAR MINGGU GG. GAYA RT.07/01 NO.2', 1, '''082122842223', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(234, 'SURYANA', 'DA-0115 C4', '31.7510.220572.0007', '7205.1205.7849.', 'JL KEBAGUSAN BESAR 3 RT 02/05 NO 40 KEC PSR MINGGU', 1, '''082124210500', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(235, 'RICHART ERIANTO', 'DA-0115 C5', '13.7112.060676.0002', '', 'JL.KEBAGUSAN KECIL GG. WATU RT 002/08 NO.117', 1, '''021-83838170', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(236, 'ABDUL MUKTI', 'DA-0116', '3219152001.0288771', '551212055247', 'JL.PUSKESMAS PD AREN RT.003/011 NO. 105.PD AREN-TG', 1, '''081317087376', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(237, 'TOFIKIN', 'DA-0116 C1', '09.5202.181168', '6811.1205.8488', 'JL.MENJANGAN IV RT01/04 KEL.PDK RANJI KEC.CPT TMR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(238, 'PARIHIN', 'DA-0116 C2', '09.5204.030887.0309', '8708.1205.6838', 'PEKAPURAN RAYA GG KANCIL RT.03/02 KEL TAMBORA JAKB', 1, '''081219374330', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(239, 'HERMAN AS', 'DA-0117', '3.67109051068001E+01', '681012054277', 'JL PENGASINAN GG KAMBOJA RT03.01 NO 05 SAWANGAN', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(240, 'SUPARMAN', 'DA-0118', '3671060102580002', '5802.1205.9807', 'WISMA TAJUR BLOK B2/ RT 005/01_x000D_\nTAJUR CILEDUK TGR', 1, '181398038112', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(241, 'BAHRUROJI', 'DA-0118 C1', '31.7304.081176.0014', '7611.1205.85277', 'JL.SUTENG TAMBORA I RT.03/04 KEL TAMBORA JAKBAR', 1, '''081287886634', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(242, 'MIRZAN HASYIM', 'DA-0119', '32.0439.111254.0001', '541212057979', 'KP.GUSTI GG.NAGA RT.02/06 NO.28 KP. GUSTI T.GONG_x000D_\n', 1, '''081276387999', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00');
INSERT INTO `drivers` (`id`, `name`, `nip`, `ktp`, `sim`, `address`, `city_id`, `phone`, `join_date`, `driver_status`, `photo`, `pool_id`, `fg_blocked`, `fg_laka`, `time_inserted`, `time_modified`) VALUES
(243, 'ALFAYAT HS', 'DA-0119 C1', '0952010607670670', '6707120510367', 'JL KAMAL RAYA JAYA 8 RT 06/14 CENGKRENG JAKBAR', 1, '021-94567605', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(244, 'AHMAD SAITA', 'DA-0119 C2', '32.7510.230165.0003', '8501.1205.8837', 'KRANGGAN KULON RT 002/008 JATI RADEN BKS', 1, '''02195460847', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(245, 'MULUD', 'DA-0119 C4', '0951021510700397', '70101205649', 'JL RAYA TELUK GONG GG TPI 2 RT06/014 NO 39 PENJAGA', 1, '''087774681729', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(246, 'M. FAUZI,HM', 'DA-0121', '36111.280963.0001', '6309.12220.212', 'JL.TAMBOTA 111 K.39 A/10 RT 04/02 KEL.KUNCIRAN', 1, '93407294', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(247, 'WILIAM EFENDI', 'DA-0122', '32190.32004.4011297', '800612192283', 'JL TERNATE 3 NO;32 RT 02/023 BENCONGAN CURUG KLP', 1, '02192786399', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(248, 'WARSONO', 'DA-0122 B1', '09.5001.040473.2015', '7304120515234', 'KP DURI BARAT RT 013/012 DURI PULO GAMBIR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(249, 'MOCH SOLEHUDIN', 'DA-0123 B1', '31.7201.050261.0009', '6102.1205.2593', 'JL. TOMANG I JALUR 20 RT 002/01 NO.24_x000D_\nKEL MERUYA', 1, '08139298381', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(250, 'ANDI BRACHMANA', 'DA-0124', '3603.2504037.30004', '730312052367', 'PAMULANG INDAH D-2/11 JL TERATAI RT 01/11 PAMULANG', 1, '081282300428', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(251, 'MUHAMMAD SOLIHIN', 'DA-0125', '09.5406.180276.0370', '760212051883', 'JL PEDATI UTAMA 1 NO;1 RT 05/06 CIJANTUNG JAK TIM', 1, '021''95987898', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(252, 'PAIMAN', 'DA-0125 B1', '1111020902730001', '730214320165', 'JL. SRENNGSENG RT 05/08 NO 15 F KEMBNGAN JAKBAR', 1, '''085716580673', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(253, 'YANDRI NOPITA', 'DA-0125 B2', '31.7507.190875.0016', '5881.12058.4841', 'PENGADEGAN TIMUR IV RT 009/001 PENGADENGAN PANCORA', 1, '''085210030294', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(254, 'SUGIONO', 'DA-0126', '3276051901780008', '7801120554954', 'KP BOJONG RT02/20 BAKTI JAYA DEPOK', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(255, 'MOHMMAD MEDI', 'DA-0126 B1', '3171081005690003', '680512055679', 'JL. BALA DEWA JATI Gg m. ali RT 08/04 TNH TNGGI', 1, '''081390329660', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(256, 'KARYOTO', 'DA-0127', '09.6303.021169.1016', '691112054054', 'JL BANGKA XI RT 06/010 KEL PELA MAM[PANG JAKSEL', 1, '02194283679', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(257, 'SOLEH', 'DA-0128', '09.5405.050673.8563', '730612052004', 'KP TENGAH JL MUNDU RT 03/04 NO;17B KEL TENGAH', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(258, 'SYAHRUL', 'DA-0129', '3671130.80150.0001', '5001.1205.0972', 'JL.H.NAJIH RT 009/001 KEL.PTKNG UTR JAKSEL', 1, '081386429957', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(259, 'MUCHLIS', 'DA-0130', '09.5207.030354.0403', '5403.1205.2607', 'KP BULAK  TEKO RT 004/011 NO;08 KALI DERES JAK BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(260, 'SIROJUDIN', 'DA-0131', '367107.020769.0001', '6907.1205.11088', 'JL.TANJUNG 3 NO:55 RT 002/011 KEL.NUSA JAYA', 1, '97788236', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(261, 'JERRI ADITYA', 'DA-0132', '3219032004.40119', '8102.1219.1249', 'BINONG PERMAI H-5/20 RT 06/04 BINONG  KEC.CURUG', 1, '087888893692', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(262, 'SUTRISNO', 'DA-0132 C1', '32.7504.301051.0001', '5110.1220.0441', 'JL. KENCANA II NO.A-63 RT.002/04_x000D_\nJAKA SETIA BKS', 1, '''081318744739', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(263, 'MARSUDI', 'DA-0132 C2', '09.5102.100261.4010', '6102.1205.1754', 'JL.KAPUK MUARA KP.PSR GOYANG RT 01/04 NO.45 KEL KA', 1, '''081282109162', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(264, 'TARIM', 'DA-0132C1', '', '6710.1205.14089', 'JL. KP PANDAN KP. MUKA BLOK E RT. 09_x000D_\nRW.04 NO.22', 1, '''021 411313933', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(265, 'FATKHUDIN', 'DA-0133', '3328061202046011194', '600414300283', 'DS KAMBANGAN RT 16/02 LEBAK SIU TEGAL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(266, 'R. YOGA PRASETYO', 'DA-0133 C1', '09.5003.071268.0205', '6812120514272', 'TAMAN ADIYASA BLOK F-20/07 RT 008_x000D_\n07 CIKASUNGKA_x000D_\n', 1, '''''021 4256683', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(267, 'SYAHRIZAL', 'DA-0133 C2', '09.5007.211083.2010', '', 'JL. TANAH RENDAH RT.011/005 KP. BALI_x000D_\nTANAH ABANG', 1, '''021 51157787', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(268, 'NURYADI', 'DA-0133 C3', '320208511630001', '731112053599', 'JL. H MENCONG Gg GEDAD 3 RT 03 / 01 NO 48 PNGGLN', 1, '''021 7334280', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(269, 'SAUDIN SAGALA', 'DA-0134', '3603251608570001', '570812057107', 'RENI JAYA BLOCK AG 2/3 RT 04/021_x000D_\nPAMULANG BARAT', 1, '021 - 93097823', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(270, 'M. JOHAN ALI', 'DA-0135', '31.7305.251064.0003', '6410.1205.3733', 'JL. LAP BOLA RT.03/010NO.01 KB JERUK_x000D_\nJAK BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(271, 'HERU LESMANA', 'DA-0135 C1', '3.17101281276E+015', '761212057312', 'JL DELIMA RT 04/08 NO 20 KEL PD KELAPA JAKTIM', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(272, 'SAMIAJI', 'DA-0136', '327565280850091', '500612052584', 'KP. BOJONG RT 009/020 KEL. BAKTI JAYA DEPOK', 1, '081398420680', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(273, 'RIFA''I', 'DA-0137', '09.5202.220774.0536', '7407.1205.15745', 'JL.MENJANGAN 4 KEL.PONDOK RANJI KEC.CPT TMR', 1, '081385678409', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(274, 'ANDI ASHARI', 'DA-0138', '09.5201.240275.0352', '750212055112', 'KP KRMAT RT 014/05 KEL CILILITAN_x000D_\nKRMAT JATI', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(275, 'CHACAN.P', 'DA-0138 C1', '32.77.731011', '7208.1205.12481', 'KP.PARUNG SERAB RT 03/05 TIRTA JAYA KEC SUKMA JAYA', 1, '081389983599', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(276, 'NOFRIWANDI', 'DA-0139', '09.5205.170373.0582', '730312057503', 'JL.F.KP.PERJUANGAN RT.010/10 KEBON JERUK-JAKBAR', 1, '''081380711924', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(277, 'RUSLIYADI', 'DA-0140', '09.5207.041153.0136', '531112054156', 'JL.PETA UTR RT.001/007 PEGADUNGAN KALIDERES JAKBAR', 1, '''021-94356863', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(278, 'SUWANDI', 'DA-0141', '3275061512590011', '5912120510570', 'KTP:UJUNG MENTENG RT.003/008 MEDAN SATRIA, BEKASI', 1, '''081317265878', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(279, 'FADLI', 'DA-0142', '09.5303.150483.0022', '830412059571', 'JL. JATI PANJANG BARU RT 06/06 NO 48 _x000D_\nPSR MINGGU', 1, '''08170847210', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(280, 'MUCHLISIN', 'DA-0143 B1', '3276021503720004', '7203120581498', 'KP SETU RT 03/08 KEL CILANGKAP DEPOK', 1, '''085287262353', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(281, 'WAHYONO', 'DA-0145', '09.5307.050867.0279', '670812054908', 'Jl. SAWO ATAS RT.002/007 GANDARIA UTR KEB-BARU', 1, '''08161472715', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(282, 'AHMAD ZAINI', 'DA-0146', '09.5201.101076.5532', '7610120511312', 'KTP:JL.BOJONG INDAH RT.005/006 PNDK KELAPA JAKTIM', 1, '''02183421668', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(283, 'BIMO ARIO TEJO', 'DA-0147', '32192220021772935', '7310120515722', 'PAMULANG PERMAI BX - 09/5 RT 02/12 PAMULANG BARAT', 1, '''''088210808705', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(284, 'HERMAN SUSILO', 'DA-0148', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(285, 'JOHANES LASIMIN', 'DA-0149', '3603240103550002', '550312052032', 'Jl. PLN PONDOK AREN RT 02/01 TANGERANG', 1, '021-7374054', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(286, 'SUIDIN', 'DA-0149 B1', '09.5104.020567.0448', '6705.1205.8126', 'JL. F GG H3 NO.34 RT.007/002 RAWA BADAK UTR KOJA', 1, '68722640', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(287, 'JOHANES LASIMIN', 'DA-0150', '', '550312052032', '', 1, '''021-7374054', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(288, 'HIDAYAT', 'DA-0150 B1', '09.5206.040470.0214', '7004.1205.6814', 'JL.WARGA INDAH NO 37 RT.2/3 LARANGAN SELATAN', 1, '081399343441', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(289, 'SA''AMAN', 'DA-0151', '09.5310.260262.0114', '620212053456', 'PERTUKANGAN UTARA RT007/010 PESANGGRAHAN JAK-SEL', 1, '021-93658109', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(290, 'FULMAN ADI S.', 'DA-0151 C1', '', '', 'JL. PEKAPURAN RAYA RT. 01/06 TANAH SEREAL-TAMBORA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(291, 'RAMLI YAHYA', 'DA-0151 C2', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(292, 'NURFIRMAN', 'DA-0152', '', '', 'JL JATI PADANG RT 06/06 NO''78 KEL JATI PADANG PSR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(293, 'INDRA POLO', 'DA-0152 C1', '3276020109679001', '670912051621', 'JL. H SALIM RT 003/010 NO 36 KEL TUGU KEC CIMANGIS', 1, '''081319246596', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(294, 'ARIMAN', 'DA-0153', '3173050.10564.0010', '6405.1205.56948', 'JL.MASJID AT-TAQWA RT 06/08 KEL.KEMBANGAN', 1, '085811319353', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(295, 'ASAN', 'DA-0153 C1', '09.5205.151060.0480', '60101205.5387', 'JL. MESJID ATAQWART KEMBANGAN BARU JAKBAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(296, 'NARSITO', 'DA-0154', '09.5208.160580.0283', '8005.1205.22851', 'JL.BAMBU II RT.008/006 KEL.SRENGSENG JAK BAR', 1, '087881696927', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(297, 'EDY RACHMAT', 'DA-0154 C1', '09.5006.130465.0107', '6504.1205.9504', 'JL MENTENG SUKABUMI Gg VII Rt.04/03 NO.37 MENTENG', 1, '021-95965346', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(298, 'BUDI ARYANTO', 'DA-0154 C2', '3.17106050557E+015', '570512056818', 'JL MENTENG TENGGULUN RT 09/01 NO 08 MENTENG JKP', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(299, 'CASTONO', 'DA-0154 C3', '31.7302.281182.0013', '8211.1205.7385', 'Jl. Pemutaran Raya Rt011/10 No.52 _x000D_\n_x000D_\n', 1, '''081932107022', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(300, 'SUMANTA', 'DA-0155', '', '', 'JL.TUBAGUS ANGKE GG.KANTONG RT.07/015 PEJAGALAN.', 1, '''087889559512', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(301, 'SLAMET TARYOTO', 'DA-0155 C1', '33.2710.121268.0041', '68.121428.0676', 'KP BANDAN BLOCK B-1 RT.009/004 KEL _x000D_\nANCOL KEC', 1, '''087883448175', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(302, 'CARSIM', 'DA-0156', '317305.150165.0010', '6402.1205.1338', 'JL. ASIA BARU RT.004/004 DURI KEPA JAKBAR', 1, '081909861257', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(303, 'SUTARDI', 'DA-0156 C1', '3.522020407910001', '', 'KP BALI RT 009/005 DURI KEPA JAKBAR', 1, '''081326616166', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(304, 'ASRUDIN', 'DA-0157', '0952052503590324', '590312053560', 'KP GUJI RT 001/002 KEL DURI KEPA KBN_x000D_\nJERUK JAKBAR', 1, '''081288124397', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(305, 'MARYONO', 'DA-0157 C1', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(306, 'MOHAMMAD SOLEH', 'DA-0158', '3604101805770084', '7805120515323', 'BINONG PERMAI D 5/30 RT 10/01 KEL BINONG TGR_x000D_\n', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(307, 'SUARDI', 'DA-0158 C1', '09.5205.080558.0264', '5805.1205.8151', 'JL.SUKABUMI UTARA KBN JERUK JAK-BAR', 1, '081218505666', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(308, 'SYAFRIZAL', 'DA-0158 C2', '367112.090460.0001', '6004.1205.3827', 'JL.H.MENCONG RT 01/08 NO.47 SUDIMARA TIMUR', 1, '087884708999', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(309, 'CEPAT SINULINGGA', 'DA-0158 C3', '31.7405.150557.0005', '5705.1205.34392', 'JL BENDI BESAR RT11/10 NO 49 KEB LAMA JAKSEL', 1, '''081383615451', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(310, 'SAWAB', 'DA-0159', '3402101204760003', '760414490858', 'Jl. KETAPANG II RT.02/04 PAMULANG TANGERANG', 1, '''08179862145', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(311, 'TOHARI', 'DA-0159 C1', '09.5104.170678.4006', '7806.1205.68339', 'JL.F Gg.1Gg K1 RT 004/02 KEL RW BADAK KOJA', 1, '97325925', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(312, 'SUNAN JAYA', 'DA-0159 C2', '09.5104.130960.0229', '6009.1205.7503', 'JL.MELATI TUGU V RT .010/03 NO 22 KEL.TUGU UTR KOJ', 1, '96840514', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(313, 'ABDULLAH', 'DA-0159 C3', '3172031603660005', '660312053543', 'KP.BETING JY RT.001/08 NO.2 KEL TUGU UTARA', 1, '085267132956', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(314, 'ARDI', 'DA-0160', '3.67111052126E+015', '6612120556453', 'JL MATAHARI  K SUDIMARA PINANG RT 03/05 NO 85', 1, '02198937295', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(315, 'EDDY KARYA', 'DA-0160 C1', '09,5107,070857,4001', '58081205,5334', 'CIPONDOH MAKMUR', 1, '021 50628244', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(316, 'SAMSUARDI', 'DA-0160 C2', '31.7407.231175.0004', '7511.1205.3203.', 'JL.KESEHATAN V Gg DEMPLON Rt.009/011 KEL BINTARO', 1, '''085881559731', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(317, 'DENI CAHYO NUGROHO', 'DA-0160 C3', '0953091504807057', '800412053633', 'Musholla Rt.008/01 No.17 LA jagakarsa Jaksel', 1, '''081585720694', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(318, 'CUCU ASTRONI', 'DA-0160 C4', '09.5308.031069.0148', '6910.1205.5444', 'JL PENYELESAIAN TOMANG I KAV DKI BLOCK 123', 1, '''081807130020', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(319, 'AGUS SUHERMAN', 'DA-0160 C5', '09.5006.070875.0468', '750812051608', 'JL RAYA SULTAN AGUNG MENTENG PASAR RUMPUT', 1, '''087877257325', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(320, 'SAMSUARDI', 'DA0160C3', '3174072311750004', '751112053203', 'J.L. KESEHATAN V Gg.DEMPLON RT09/11 BINTARO', 1, '085881559731', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(321, 'SUPRAPTO', 'DA-0161', '3603280506560002', '560612054070', 'PESONA KARAWACI BLOK B4/9 RT001/030 BOJONG NANGKA', 1, '''081398601055', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(322, 'DHEVID RUSDI HARAHAP', 'DA-0161 B1', '36.7112.140589.0002', '8905.1126.0049', 'JL. CIREMAI IV/17 RT 07/06 KARTENGAH_x000D_\nTANGERANG', 1, '021 93856332', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(323, 'MASRUKIH', 'DA-0163', '09.5206.031067.5505', '671012050283', 'JL. SEMANGKA II/17 RT.012/ 009 JATI_x000D_\nPULO PLRH J B', 1, '''085710442177', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(324, 'ROCHIM', 'DA-0163 B1', '09.5206.040370.5515', '7003.1205.10015', 'PERUM SURYA JAYA INDAH BLOK H2_x000D_\nNO.27 CISOKA TGRG', 1, '''021 68582027', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(325, 'MAKMUR', 'DA-0163 B2', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(326, 'MORIS WIJAYA', 'DA-0163 B3', '09.5004.260554.0230', '6001.1205.3030', 'JL.BUNGUR BESAR Gg.IX / 154 RT 014/01 BUNGUR JAKP', 1, '''0813700119595', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(327, 'M. SOLIKIN', 'DA-0164', '3671120705690003', '690512058936', 'JL.DR SUTO RT01/05 KARANG TIMUR KARANG TENGAH TNG', 1, '''081317084321', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(328, 'MOHAMMAD KIROM', 'DA-0164 B4', '31.7205.051171.1001', '7111.1205.6362', 'JL MANGGA 2 VIII RT.013/005 NO.124 KEL _x000D_\nANCOL JAK', 1, '''087888875021', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(329, 'BURHAN', 'DA-0165', '0952010602660223', '660212056534', 'JL BAMBU TALI 1/9 RT 002/005 KEL RAWA BUAYA JAKBAR', 1, '''021-99924379', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(330, 'BAMBANG SUMARYANTO', 'DA-0165 B1', '', '', 'JL. DUREN I RT.05/02 NO.68 KELURAHAN PEDURENAN _x000D_\n', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(331, 'ZON AFRIANTO', 'DA-0167', '3275101204620001', '620411320054', 'KRANGAN KULON RT.001/010 KEL.JATI RADEN BEKASI', 1, '''081214573877', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(332, 'UNTUNG NURDIYANTO', 'DA-0169', '0952042712725525', '7212120516933', 'JL. DURI BARU RT 09/05 KEL JEMBT BESI JAK-BAR', 1, '''085782704271', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(333, 'KHANIPUDIN', 'DA-0169 B1', '952060804800299', '8004120510366', 'KOTA BAMBU SELATAN RT007/005 PALMER JAKBAR', 1, '087888062075', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(334, 'SANANI', 'DA-0169 B2', '36.7403.271055.0003', '5510.1219.0610', 'JL PLN Gg. H AMAD RT.011/001 NO.33 KEL PNDK KARYA', 1, '''089635723754', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(335, 'INDRA', 'DA-0170', '0954030105708545', '70051205708545', 'JL PISANGAN LAMA II RT 003/004 PISANGAN JAKTIM', 1, '''081382282857', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(336, 'NURSALIM', 'DA-0171', '31.73042111560006', '561112052140', 'JL. KALI ANNYAR III RT08/ 001_x000D_\nJAKARTA BARAT', 1, '''081225394230', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(337, 'CHAIRUDIN HARAHAP', 'DA-0171 C1', '', '', 'JL CEREMAI IV/17 DEP.KEU RT 07/06 KARANG TGH TGR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(338, 'NURULLAH', 'DA-0173', '09.5007.170476.0343', '760412056093', 'TENAGA LISTRIK RT. 013/ 0016 KBN MLT_x000D_\nJKT PUSAT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(339, 'HERMANSYAH', 'DA-0173 C1', '09.5206.070758.0068', '5807.1205.1882', 'JL.PELITA II/50 RT.003/004 JATI PULO PALMERAH', 1, '02192597323', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(340, 'MOH YASIN', 'DA-0173 C2', '0952010701590236', '590112054586', 'JL PENDONGKELAN BLK RT21/16 NO.110 KEL KAPUK JKB', 1, '''95341896', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(341, 'PUJIANTO', 'DA-0173 C3', '33.2802.070771.0027', '71.0714.300523', 'JL PEKAPURAN I Gg PECEPOKAN TANAH SEREAL TAMBORA', 1, '''085310993260', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(342, 'AZIARDI', 'DA-0174', '36.0328.16276.0001', '7612.1219.2558', 'JL. KH HASIM ASHARI GG. H. YUNUS_x000D_\nRT.02/03 NO.36', 1, '''081363759407', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(343, 'IRWAN SANTOSO', 'DA-0175', '09.5206.301159.0645', '5911.1205.0390', 'JL. JATI PETAMBURAN III KOMP PELNI. RT.13/01 NO.2', 1, '''085718745445', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(344, 'M. RAWI', 'DA-0175 C1', '0952022112510586', '511212055397', 'JL RY TJ GEDONG GG SEMPIT RT08/16 85_x000D_\nTOMANG GROGO', 1, '''085715666073', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(345, 'AGUS JAYA PUTRA AS', 'DA-0177', '1055042708651002', '65002059919', 'JL. LAP RT 003/011 KRANJI BEKASI', 1, '''085710040065', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(346, 'A. NASRUL KURNIAWAN', 'DA-0177 C1', '09.5206.240257.0207', '', 'JL.ANGGREK CENDRAWASIH III RT.014/03 N.06 KMNGGSN', 1, '02137367471', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(347, 'SURAJI', 'DA-0179', '332817100820763', '820114300615', 'DS KEDAYAKAN RT 09/03 KEC WARU REJA KAB TEGAL', 1, '''021-97458310', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(348, 'KUSNADI  C', 'DA-0179 C1', '09.5204.220773.0339', '7307120512131', 'JL.KALI ANYAR VI GG.5 RT.004/005 N3 TAMBORA JAKBAR', 1, '''08211066870', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(349, 'NASLIKHAN', 'DA-0179 C2', '3173040506700023', '7006120599657', 'JL.KALI ANYAR III RT.008/01 KALI ANYAR JAK BAR._x000D_\n', 1, '''081382213476', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(350, 'JAMALUDIN', 'DA-0179 C3', '31703051107620015', '620712052049', 'Pesing Poncol Rt 07/07 Kel Kedoya Utara jakbar', 1, '''085717003504', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(351, 'DJUMIRAN', 'DA-0179 C4', '3671060907570001', '570712055228', 'JL TANAH SERATUS RT 04/11 NO.32 KEL SUDIMARA JAYA', 1, '''085219015596', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(352, 'JAMALI', 'DA-0179 C5', '33.202.050775.0001', '7507.1430.0957', 'JL PEKAPURAN I Rt.12/05 No.07 Gg PECEPOKAN TANAH', 1, '''085312829355', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(353, 'SUMARSONO', 'DA-0179-C7', '3.17410120458001E+01', '580412052714', 'JL PULO GAYUNG RT 01/05 NO 14 PET SEL JAK SEL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(354, 'ARIF BUDIMAN', 'DA-0180', '0954022104834543', '830408140191', 'JL RAYA DUREN SAWIT Gg  KAPUK III RT 005/05 JAKTIM', 1, '''081284526559', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(355, 'SUWONO', 'DA-0181', '09.525.030477.0568', '', 'JL. SRENGSENG RT002/04 RESNGSENG_x000D_\nKEMBANGAN JAKBAR', 1, '''021 33964616', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(356, 'ABING', 'DA-0182', '09510420904714001', '7104.12056.514', 'JL. KRAMT JAYA GG IV D1/ 13 F RT17/03_x000D_\nLAGOA KOJA', 1, '''021 280461731', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(357, 'ROPIDIN', 'DA-0183', '09.5204.200376.0497', '7603.1205.13781', 'JL.CIPUTAT RAYA RT.001/02 NO.48 PDK PINANG JAKSEL', 1, '085813187105', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(358, 'BINSAR SAMUEL', 'DA-0183 B1', '327508.150388.0608', '9003.1205.2017', 'JL. TEBET TIMUR IV /11A RT 001/005 TEBET JAKSEL', 1, '087877431014', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(359, 'HAL HALMI', 'DA-0183 B2', '0950033012570043', '571212058649', 'JL.CURUG RY Gg AL MADIAH I RT 08/02 NO 78 JATI CEM', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(360, 'MIZAR KARIM', 'DA-0184', '19.152006.0742', '5512.1205.4697', 'JURANG MANGU BARAT RT07/03 KEL_x000D_\nPDK JATI TGRG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(361, 'RASEJO', 'DA-0184 B1', '09.5107.150664.0785', '6406.1205.1725', 'JL. MANGGA DUA KP DA''O ATAS RT.013/05 KEL ANCOL JA', 1, '''087880222538', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(362, 'SUCIPTO', 'DA-0185', '09.5304.140459.0293', '590412054129', 'KEBAGUSAN BESAR RT.004/006 PSR MINGGU JAKSEL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(363, 'MUCHTAR', 'DA-0185 B1', '31.7410.310855.0001', '5508.1205.1337', 'JL. H MUCHTAR Gg Kodir RT.08/04 NO.33 Kel Pet Utar', 1, '''021-94782798', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(364, 'HANAFIAH', 'DA-0185 B2', '0950010507670099', '6707120594132', 'JL. RAYA TNH ABANG V Gg.Jahe VIII?65 Rt 10/02', 1, '085775265600', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(365, 'IWAN SETIAWAN 96', 'DA-0186', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(366, 'H. BEBEN SUBANDI MOHAMMAD', 'DA-0188', '3201280503570001', '570313251295', 'KP. CIJERUK RT.03/02 KEC. CIJERUK BOGOR', 1, '''085210937394', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(367, 'SUTARYONO', 'DA-0189', '09.5406.120977.0074', '7709120510629', 'JL.H.REMAIH NO.6 RT.003/007 KEL.BARU P.REBO JAKTIM', 1, '081327579897', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(368, 'ETRIAL', 'DA-0190', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(369, 'M. SOLEHUDIN', 'DA-0191', '09.5201.130863', '', 'JL. DAMAI-V BLOK. D.9/11 RT.002/05_x000D_\nCPDH MAKMUR', 1, '''021 45419371', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(370, 'MUSTOFA', 'DA-0191 C1', '09.52052602565501', '560212054850', 'JL SRENGSENG RT 02/04 NO 25 KEL SRENGSENG KEMBANGA', 1, '08811329692', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(371, 'WARNADI', 'DA-0192', '09.5202.120582.0260', '820512058577', 'JL. INDRALOKA-I/103 RT008/010_x000D_\nGROGOL JAKBAR', 1, '''081806727123', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(372, 'DARSONO', 'DA-0192 C1', '09.5204.150768.0881', '6807.1205.16022', 'JL.TAMBORA I Gg.V RT.004/03 TAMBORA JAK-BAR', 1, '''081390146898', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(373, 'KARYADI', 'DA-0193', '09.5204.070371.0553', '7103.12054599', 'JL. CIPUTAT RY RT.01/02 NO.48_x000D_\nPD PINANG KEBY LAMA', 1, '''081510584535', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(374, 'TARYADI', 'DA-0194', '953052303817061', '810312054711', 'JLGANDANA 1 KP SAWAH RT 012/04KBY LAMA JAK SEL', 1, '93993733', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(375, 'SURAJI', 'DA-0194 C1', '0951071212674029', '691212057213', 'Jl.Mangga Dua Raya Kp.Muka Rt.009/004 No.135', 1, '''087782191293', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(376, 'SUBIYANTO', 'DA-0195', '09.5304.081256.0408', '561212053141', 'JL. KEBAGUSAN BESAR RT.012/06_x000D_\nKEBAGUSAN JAK SEL', 1, '''''021 89589251', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(377, 'HADI MULYADI', 'DA-0195 C1', '0952032104550422', '550412056092', 'JL KP BARU RT 005/03 KEMBANGAN UTARA JAKBAR', 1, '''021 92061736', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(378, 'SYUKUR AMIRULAH', 'DA-0195 C2', '', '', 'Kp Sawah Rt.012/01 No.35 Kel Petukangan JAKSEL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(379, 'DADAN SYAHRULLAH', 'DA-0195 C3', '317106.241067.0001', '6710.1205.9582', 'JALAN MENTENG JAYA RT012/09 NO 62 MENTENG JAK PUS', 1, '80700137', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(380, 'FUAD HS', 'DA-0196', '31.7304160850.0007', '', 'JL GG GRINDO 6 NO.09RT.08/05_x000D_\nDURI SELATAN TAMBORA', 1, '021 99986756', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(381, 'SUHERLAN', 'DA-0196 C1', '09.5206.110459.0233', '5904.1205.4113', 'JL. ANGGREK RT.001/018 NO.1A. KEL PONDOK BENDA PAM', 1, '''021 98307670', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(382, 'PANCA HENDRA SIRAIT', 'DA-0196 C2', '09.5208.011086.5505', '8610.1205.7427', 'JL.SEMANGKA III /35 RT 013/009 KEL.JATI PULO PALME', 1, '5635090', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(383, 'EKO BAHRO', 'DA-0197', '3604231508650002', '650813200539', 'KP.CIMAUNG KADU RT016/007 CIKEUSAL SERANG - BANTEN', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(384, 'SUPARMAN', 'DA-0197 C1', '09.5102.151283.4024', '8312.1205.6455', 'RUSUN CINTA KASIH A 12-2A RT.005/007 CENGKARANG', 1, '021 94862893', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(385, 'KASDINI', 'DA-0197 C3', '36.0113.040781.0001', '8407.3210.0032', 'JL RAYA KAMPUNG GUSTI GG KANTONG_x000D_\nRT 08/015 PENJA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(386, 'KHOLID', 'DA-0197 C4', '952042607670386', '670712054075', 'JL SAWA LIO IV RT004 /06 NO 63 JEMBATAN LIMA JKB', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(387, 'JAJAN JANDAN', 'DA-0198', '3203008067900401', '''790613252314', 'KP.KONGSI RT.12/05 TANJUNG SARI KEC. CIJERUK _x000D_\n_x000D_\n', 1, '''085274569943', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(388, 'SUAIB', 'DA-0198 C1', '09.5405.020872.0362', '7208.1205.88778', 'JL.MANUNGGAL XIII NO.63 RT 001/004 BALE KAMBANG', 1, '085216680424', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(389, 'MAHINRA NAWAWI', 'DA-0198 C2', '', '', 'JL TRIPANG BLOK DM 1/2 RT 06/06 KELURAHAN KUNCIRAN', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(390, 'HAIRUDIN', 'DA-0198 C3', '09.5102.140567.0401', '6705.1205.14278', 'JL.TELUK GONG RT 013/08 KEL. PENJARINGAN', 1, '''087808343354', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(391, 'PENRIZAL', 'DA-0198 C4', '09.5102.280579.0278', '7905.2527.0597', 'JL KARTAJAYA IV GG III RT. 17/14 NO.01', 1, '''085313909772', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(392, 'NOVEL', 'DA-0199', '3276021611740001', '7411120510904', 'JL.MAJA I NO.15 RT008/018 SUKATANI CIMANGGIS-DEPOK', 1, '''081318302630', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(393, 'SYAHRIAL 199', 'DA-0199 C1', '', '', 'JL. KEMANGGISAN RY GG H TAISIR RT.02/14 NO.23 PETA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(394, 'EKO JUNI SANTOSO', 'DA-0200', '', '730612057508', 'JL.H.SARMILI RT03/02 JURANG MANGU - TANGERANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(395, 'SYAMSUDIN', 'DA-0200 C1', '09.5205071270.5522', '701212053268', 'PESING GOT RT 01/07 KEDOYA UTARA_x000D_\nJAKARTA BARAT', 1, '''081510250430', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(396, 'DATIMAN', 'DA-0202', '0950020204700416', '700412055857', 'JL. LUTZE DLM RT.003/006 KEL KARTINI JAKPUS', 1, '''081381757870', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(397, 'AGUS MUHAMMAD', 'DA-0202 B1', '09.5303.160156.0078', '560142051730', 'JL BANGKA  V RT 012/003 MAMPANG PRAPATAN JAKSEL', 1, '''021-97718145', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(398, 'HADI SUWITO', 'DA-0204', '', '6209.1205.2635', 'JL.JOGLO BARU RT 03/06 NO.73 KEL.JOGLO  KEMBANGAN', 1, '082125950959', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(399, 'AHMAD ROJIUN', 'DA-0206', '09.5204.251080', '8010120511626', 'JL PESING PANCOL RT.007/07 NO.41_x000D_\nKBN JRK JAKBAR', 1, '''081366464052', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(400, 'ARIF WAHYUDIN', 'DA-0208', '3671011110760007', '7610120552530', 'KP.SUKASIH RT.03/02 NO.1 KEL. LEUWIMEKAR BGR', 1, '''02197316423', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(401, 'NUR ANWAR', 'DA-0210', '3219052021.1748498', '820512191537', 'JL.HOS.COKROAMINOTO GG. LANGGAR RT.008/001 CIPADU', 1, '''021 93078795', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(402, 'BOHIR', 'DA-0210 B1', '31.7410.240457.0002', '5704.1205.0578', 'KP BINTARO RT.007/001 KEL PESANGRAHAN JAKBAR', 1, '''9293740', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(403, 'H. SININ', 'DA-0212', '5602.1205.0836', '950012502560200', 'JL. RAWA BOKOR KP.BR RT.05/08 NO40_x000D_\nPEGADUNGAN X D', 1, '''085210267150', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(404, 'HERU SISWANTO', 'DA-0214', '32,0329,161003925', '711013251710', 'KP.TEGAL RT.05/ 02 CILAKU TENJO_x000D_\nBOGOR TENJO', 1, '''081388573518', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(405, 'TIARMAN', 'DA-0214 C1', '09.5310.211261.0146', '6112.1055.231', 'JL. H JAELANI IIIRT.005/001 PETUKANGAN UTR JAKSEL', 1, '''085885794420', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(406, 'SELAMET', 'DA-0214 C2', '09.5205.100365.0718', '6503.1205.5445', 'JLN.KEDOYA PILAR RT 004/003 KEDOYA SEL JAKBAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(407, 'EDY JAYALAKSANA', 'DA-0214 C3', '32030115066702174', '670613253143', 'KP CIMAOK RT1/02 NO 03 KEL JUGALAJAYA', 1, '''081398220512', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(408, 'SADIM', 'DA-0218', '317305.190757.0002', '5707.1205.3171', 'PESING GADOG RT.04/04 KEDOYA UTARA', 1, '''021-37771009', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(409, 'ALI HARTONO', 'DA-0220', '36,7106,151067,0001', '6710,1261,3501', 'GG. MASJID RT.004/13 NO.67 GROGOL_x000D_\nKEBAYORAN LAMA', 1, '''021 94745392', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(410, 'GUMILAR ALAMSYAH', 'DA-0220 C1', '31.7409.130857.0004', '5708.1205.4568', 'JL. PETA BARAT RT.03/13 NO.60 KALI DERES', 1, '''021-96318726', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(411, 'UJANG SUPARMAN', 'DA-0220 C2', '09.5006.280771.0085', '710712059097', 'JL MENTENG JAYA Gg GATRIK RT.014/0 NO 17 MENTENG', 1, '''021-94626036', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(412, 'KOSIH', 'DA-0220 C3', '09.5007.040446.0262', '560412056050', 'JL REGALIA RT006/04 KELURAHAN SUSUKAN CIRACAS', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(413, 'JENAL MUHLISIN', 'DA-0221', '3173080101670013', '6701120510968', 'JL.SRENGSENG RAYA NO.37 RT.06/02 SRENGSENG JAKBAR', 1, '''085693575469', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(414, 'WARTO', 'DA-0221 B1', '33.2711.010775.0179', '7507.1428.0857', 'JL MANGGA 2 KP MUKA RT.009/004 NO.15B KEL ANCOL', 1, '''087781549225', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(415, 'ZAINUDIN', 'DA-0222', '0952063011620477', '621112056908', 'JL.JATI PULO RT.04/08 NO.27 KEL.JATI PULO PALMERAH', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(416, 'RODIH', 'DA-0223 B1', '36.7404.021278.0001', '7812.1205.45377', 'JL GELATIK BULAN BUNI RT 03/03 NO 1SAWAH LAMA', 1, '''082123069212', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(417, 'BADRUN', 'DA-0225', '09.5305.180974.7021', '7409.1205.9522', 'KP. SWH RT.011/04KEBAYORAN LAMA_x000D_\nJAKSEL', 1, '''''021 96858866', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(418, 'ALWI', 'DA-0227', '09.5206.051280.0372', '6012.1205.10755', 'PAKEMBANGAN BARAT RT 009/005 PALMERAH', 1, '08888494354', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(419, 'TAUFIK MADHASAN', 'DA-0228', '3603090308670002', '670812057382', 'JL.SAWAH LIO IV DALAM RT.03/06 JEMB. LIMA JAKBAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(420, 'SAEPUDIN', 'DA-0229', '09.5204.091162.0149', '62111.2053.2677', 'JL.KALI ANYAR X GG.2 RT 002/007 KALI ANYAR TAMBORA', 1, '08777403675', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(421, 'JUANTO', 'DA-0230', '09.5102270286.0176', '', 'JL.PEDURENAN RAYA GG. H. DUL RT.09/07 NO.20 _x000D_\n', 1, '02192407169', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(422, 'SOFARI', 'DA-0231', '09.5207.151269.0579', '691212053134', '', 1, '''08811368477', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(423, 'ARIF CANDRA BAGIO UTOMO', 'DA-0231 C1', '367107.260890.0002', '9008.1222.0679', 'JL.MUJAIR VII NO 217 RT 004/010 KARAWACI TGR', 1, '''02141537719', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(424, 'CARDAYA', 'DA-0231 C2', '3212151101510001', '6403120511715', 'JL.ANGKE JY RT07/03 NO.17KEL.ANGKE TAMBORA JAK-BAR', 1, '085216611139', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(425, 'DIAN SUHERLAN', 'DA-0231 C3', '3174020208760004', '7608120518271', 'JL MENTENG RAWA JELAWE RT.005/03 KEL PSR MANGGIS', 1, '''021-93933401', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(426, 'R. LILY WIDAYAT', 'DA-0231 C4', '09.5006.080746.0018', '4607.1205.0082', 'JL MANTRAMAN JAYA GG D RT.012/06 NO.07 KEL PENGANG', 1, '''021-92417146', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(427, 'M. SADANG', 'DA-0235', '09.5204.0708690721', '6908120515384', 'JL. SAMARASA I RT.010/005 KEL.ANGKE JAKARTA BARAT', 1, '''081345696622', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(428, 'SUPARYO', 'DA-0235 C1', '09.5003.250155.0005', '5503.1205.2447', 'JL CEMPAKA WANGI III RT 015/09 NO 14_x000D_\nHARAPAN', 1, '''021-60641263', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(429, 'DURYANTO', 'DA-0235-C2', '31.7407.141068.0005', '', 'Jl.Antena IV Rt.007/08 No.12 kel.Kramat pela I', 1, '087775064426', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(430, 'IWAN SETIAWAN  C', 'DA-0237', '3,60410180674E+015', '740613200839', 'PERUM GRAHA WALANTAKA BLK L.10/01 RT 022/06 SERANG', 1, '08815614032', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(431, 'KAMSIN', 'DA-0238', '', '', 'JAKARTA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(432, 'SUKARTA', 'DA-0238 C1', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(433, 'MASTIM', 'DA-0238 C2', '36.0328.080686.0006', '8606.1219.0903', 'JL. PEJAJARAN KP. SABI RT.005/02 KEL_x000D_\nBENCONGAN KE', 1, '''085813837728', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(434, 'SUTRISNO', 'DA-0238 C3', '31.7405.030773.0017', '7307.1205.3674', 'JL. TANAH KUSIR II GG.YBM RT.008/09_x000D_\nNO74 KBY J-S', 1, '''089636077388', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(435, 'JARUKI', 'DA-0239', '31.7304.201270.1001', '2012.1205.5852', 'KP SEKETI RT.010/07 NO.23 DUKU BENDA_x000D_\nBUMI JY TEGA', 1, '''085780856755', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(436, 'SAPUDIN', 'DA-0239 C1', '36.041509.0263.0004', '6302.1320.0016', 'KP. PAMAKAMAN GEMBOR UDIK RT.16/05 CIKANDE SERANG', 1, '''021 34031781', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(437, 'FERRY LENDO', 'DA-0239 C2', '', '550212210525', 'JL. BONJOL PONDOK KACANG BRT GRAHA BINTARO RT.01/7', 1, '''021 96625849', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(438, 'SUHENDANG', 'DA-0239 C3', '36,0218,050280,0001', '8002,1322,0335', 'JL.SETIA KAWAN GG.PERSINA 08/01 KALI ANYAR TAMBORA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(439, 'ARPENPEMI', 'DA-0241', '09.5207.201259.0855.', '5912.1205.4880.', 'JL KH ABD WAHAB 1RT 04/06 DURI KOSAMBI CENGKARENG', 1, '081382182845', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(440, 'YAYAT HIDAYAT', 'DA-0242', '09.5208.010164.1140', '540112058525', 'Jl. Raya joglo Rt.06/02 joglo. kembangan jak-bar', 1, '''083871001751', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(441, 'RIYADI', 'DA-0244', '09.5303.010675.0190', '750612058453', 'JL. BANGKA II GG 5 RT. 05 RT.015/ 02_x000D_\nPELA MAMPANG', 1, '''081282416075', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(442, 'SIHAR SIMANJUNTAK', 'DA-0244 B1', '953012406570149', '570612050827', 'JL RASAMALA I RT 05/09 NO.24 MENTENG DALAM _x000D_\n', 1, '021-94833465', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(443, 'LAYAS BR GINTING', 'DA-0247', '3174054507820018', '8207120512239', 'JL. BENDI BESAR RT 09/10 KEB LAMA UTR JAKSEL', 1, '''081375878433', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(444, 'HANAPI B.KARJAN', 'DA-0248', '3219162002.17668', '5604.1205.6819', 'KP.SOLEAR RT.04/04 SOLEAR CISOKA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(445, 'FERDIYANSYAH RIZKI H', 'DA-0250 B1', '36.7112.260293.0004', '9302.1219.0251', '', 1, '''021 95060947', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(446, 'CASSIA VERA MALAYS', 'DA-0251', '31.7401.500673.0017', '7306.1205.52217', 'TAMAN CIPULIR ESTATE F3/7 RT.01/08 KEL CIUPADU TGR', 1, '''085692581658', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(447, 'BARTEN E M RUMA HORBO', 'DA-0252', '09.5307.220776.0443', '7607.1205.47387', 'JL. GANDARIA I RT.003/010 KRAMAT PL_x000D_\nKEB.BARU JAKS', 1, '''081273373962', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(448, 'HARY SETIAWAN', 'DA-0254', '317403.171179.0001', '7911.1205.3594', 'JL.BANGKA II 5/37 RT.15/02 KEL.PELA MAMPANG', 1, '085782100079', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(449, 'DASIM B KARPIN', 'DA-0254 C1', '09.5102.260656.0354', '56061205545', 'JL TANJUNG WANGI GG PETEK RT02/16 NO 52 PENJARINGA', 1, '''085215883052', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(450, 'AGUS RIYANTO', 'DA-0257', '0952040708705529', '7008120556697', 'JL RAYA TAMBORA KP SUTENG RT03/08 NO094 TAMBORA', 1, '081385749720', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(451, 'ALI HARYANTO', 'DA-0257 C1', '33.2806.090488.0005', '8804.1430.0778', 'JL RAYA JELAMBAR GG ALADIN RT 004/02', 1, '''087809222409', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(452, 'KUSNADI  258', 'DA-0258', '36.0328.050251.0003', '6102.1205.6658', 'JL. SRIWIJAYA IX NO.03 RT.004/018 BEN_x000D_\nCONGAN K.2', 1, '''087885948500', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(453, 'RABUN', 'DA-0260', '0953032209580189', '580912056025', 'KEMANG SEL VIII A RT 13/02 KEL BANGKA JAKSEL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(454, 'MUHADI  LATIF', 'DA-0266', '09.5410.250354.0267', '5403.1205.6230', 'JL.ADIL RT 004/002 SUSUKAN KEC.CIRACAS JAKTIM', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(455, 'ASRIL', 'DA-0268', '3671051207690003', '6907120510283', 'JL.PULO INDAH RT002/04KEL.PETIR KEC.CIPONDOH TGR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(456, 'IDIE CHARSIDI', 'DA-0270', '095062005680420', '680512059937', 'JL.ANGKE JAYA I/6 NO.18 RT 001/006_x000D_\nJAK-BAR', 1, '''021-91217075', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(457, 'M. JUNIS', 'DA-0276', '32.1605.100649.0001', '9412.1205.3666', 'JL.PISANGAN RT 005/003 SATRIA MEKAR BEKASI', 1, '081280997770', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(458, 'Y. YUNTA ERRY  PRABA', 'DA-0278', '36.0331.290679.0001', '7906.1222.1352', 'Taman Adi yasa Blok G 09/10 Rt.005/008_x000D_\nCikasungka', 1, '''021-60415857', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(459, 'EDI SUCIPTO', 'DA-0280', '320306140700006', '700413270986', 'JL MUARA BARU RT0016/017 NO 18 PENJARINGAN JAKUT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(460, 'MUH NUR', 'DA-0282', '317305.010166.0010', '6601.1205.2749', 'JL.SULAIMAN Gg.SERAI RT04/03 KLP.DUA KBN.JERUK', 1, '081381413970', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(461, 'DADANG SUMPENA', 'DA-0290', '09.5208.090968.0179', '6809.1205.11561', 'JL. RY CIDODOL GG. MUSOLLAH RT06/_x000D_\n06KBY LAMA JAKS', 1, '''08176768092', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(462, 'SYAHRIAL 292', 'DA-0292', '0952022512590804', '591212050575', 'JL.TANJUNG GEDONG RY RT04/016 NO 26 GROGOL TOMANG', 1, '''08128892177', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(463, 'BAMBANG SETYO', 'DA-0300', '3603130707680002', '6807120555459', 'JL. RAYA PANJANG GG MESJID KEDOYA KBN JERUK JAKBAR', 1, '''081808991096', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(464, 'ABD. MUHEMIN', 'DA-0300 C1', '31.7304.130571.0008', '7105.1205.12532', 'JL. PEKAPURAN VI GG. PETET DLM_x000D_\nRT 005/01 NO.206', 1, '081317115986', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(465, 'CEPI SUHIRMAN', 'DA-0300 C2', '0952060508805512', '8008120514643', 'JL TOMANG PULO Gg VII RT 13/05 NO 15 JT PULO', 1, '''02131706218', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(466, 'CECEP JUFRIADI', 'DA-0300 C3', '09.5310.021066.0238', '6610.1205.13541', 'JL TOMANG PULO GG 7 RT 07/05 NO 5 JATI PULO', 1, '''08811605580', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(467, 'JAKRUDIN B KATAM', 'DA-0301', '09.5204.090581.0300', '8105.1205.15058', 'JLANGKE INDAH NO 264 RT 011/002 ANGKE TAMBORA', 1, '081380301926', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(468, 'LARSON SAMOSIR', 'DA-0302', '327501.080474.40011', '7404.1205.2963', 'JL.MANDIRI RAYA RT 002/002 AREN JAYA BEKASI TIMUR', 1, '081317706144', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(469, 'M.RUSTAM AGUSTI', 'DA-0303', '', '6708.1205.4015', 'KALI ANYAR X RT 07/06 KEL.KALI ANYAR JAKBAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(470, 'BUDI SARJONO', 'DA-0307', '31730504115600002', '561112055681', '', 1, '082124452559', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(471, 'IMRON', 'DA-0308', '3173051105590002', '590512051438', 'JL CEMPLAK I RT 02/011 NO 31 MERUYA JAKBAR', 1, '''081381861257', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(472, 'LEGIANTO', 'DA-0309', '09.5204.190565.0333', '650512055097', 'JL. DURI BARU RT.009/005 JEMBATAN BESI JAKBAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(473, 'RIJALUDIN HARAHAP', 'DA-0310', '3603312811740001', '590512054499', 'TAMAN ADIYASA BLOK J.25/15 RT.005/005 CIKUYA', 1, '''082125199842', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(474, 'WITORO', 'DA-0311', '09.5201.2300950.0104', '500912053183', 'JL JAYA VIII RT 07/09 NO 56 CENGKARENG JAK BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(475, 'BUDI SETIAWAN', 'DA-0312', '09,5102,040170,0306', '700112058289', 'Jl. B-I raya 001/013 no.05 kel pejagalan_x000D_\nJak Ut.', 1, '''085693691499', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(476, 'SOLEMAN', 'DA-0313', '317304.170664.0006', '6406.1205.59103', 'JL.KRAMAT I RT 006/007 TANAH SEREAL TAMBORA JAKBAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(477, 'URIP SUGIARTO', 'DA-0317', '10.5507.280168.0002', '6801.1205.10433', 'JL.MASJID AL-MUSARIAH RT.04/03 NO.150 KEMBANGAN', 1, '082124655255', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(478, 'SLAMET', 'DA-0318', '', '', 'JL. JOGLO BARU RT.04/06 KELURAHAN JOGLO', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(479, 'WANGSIT BIN ACH ASHAR', 'DA-0319', '09.5201.151244.5501', '3512.1205.0086', 'JL. RY PEDONGKELAN GG SETIA T001/_x000D_\n16NO.77 KAPUK', 1, '021 97712866', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00');
INSERT INTO `drivers` (`id`, `name`, `nip`, `ktp`, `sim`, `address`, `city_id`, `phone`, `join_date`, `driver_status`, `photo`, `pool_id`, `fg_blocked`, `fg_laka`, `time_inserted`, `time_modified`) VALUES
(480, 'SUGANDA BIN KASMANI', 'DA-0320', '317305.020279.1002', '8002.12050.6456', 'PESING PONCOL RT 007/007 KEDOYA UTR JAKBAR', 1, '''081398565019', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(481, 'PAHRURI BIN JAHUR', 'DA-0321', '3173043011590016', '591112052022', 'JL. H. JAMHARI RT15/01 KEL ANGKE KEC TAMBORA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(482, 'WASJAN', 'DA-0322', '3208210205590002', '590513400251', 'JL. DUREN RT 05/04 KEL KOTA BAMBU SLTN JAKBAR', 1, '''087880892318', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(483, 'ASRUL Z', 'DA-0324', '0953052503630091', '630312056641', 'PENINGARAN RT 01/09 KEL KEB LAMA_x000D_\nKEC KEB LAMA', 1, '081287639656', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(484, 'ROMLAN TINAMBUNAN', 'DA-0328', '31.7408.161165.0005', '6511.1205.0638/A/P', 'JL. JOGLO RAYA NO.18 RT.004/06 KELURAHAN : JOGLO_x000D_\n', 1, '''021-93942410', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(485, 'MOHAMMAD FIRDAUS', 'DA-0328 B1', '32.0318.100771.01588', '7107.1205.12291', 'JL KEJAKSAAAN I RT.02/06 NO.53 KEL KREO KEC LARANG', 1, '''085890249492', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(486, 'KASTONO', 'DA-0330', '3271043006670001', '670612051992/B1/U', 'KP RAWA BOKOR RT 001 / 04 KEL BENDA KEC BENDA', 1, '085883738843', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(487, 'MOCH. CHOZIN', 'DA-0331', '31.7305.110863.0008', '6308.1205.7462/BI/U', 'JL.Joglo baru Rt.004/06 No.106', 1, '021-96226912', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(488, 'ENUNG NURHANI', 'DA-0332', '36.7104.180263.0001', '6302.1205.0429/B1/U', 'Kp.Jatake Rt.001/01 No.24Kel Jatake Kec.Jati uwung', 1, '085811733383', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(489, 'MAK HUI MIN', 'DA-0338', '0952022406735516', '730612058083', 'JL. JELAMBAR JAYA II GG U/26 RT 06/02 KEL', 1, '''085883552281', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(490, 'MUHAIMIN', 'DA-0338 C1', '36.0311.300655.0001', '5606.1205.7138', 'PERUM TMN RY RAJEG BLOCK B-19/7 RT05/07 MEKAR SARI', 1, '''08179971886', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(491, 'U. SAMSUDIN', 'DA-0340', '09.5203.010350.0287', '5003.1205.3376', 'JL.KBN JERUK XVIII RT 004/009 MAPHAR TAMAN SARI', 1, '085880582093', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(492, 'SYAIFUL', 'DA-0341', '31.7401.070853.0004', '5308.1205.0359/A/U', 'JL.KEBAGUSAN KECIL Gg ksncil Rt 006/001 N0.06', 1, '08812132646', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(493, 'HENDRAWAN ZEN', 'DA-0342', '31.7509.200780.0013', '8007.1205.57321/A/U', 'JL.H.SAMIN NEONG RT.007/005 KEL.SUSUKAN - CIRACAS', 1, '''087777927233', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(494, 'ADRIZAL PILIANG', 'DA-0342 B1', '39.7113.020273.0007', '7302.1219.2016', 'JL H MUCHTAR III NO.16 RT.001/010 KEL _x000D_\nKREO KEC', 1, '''081384697539', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(495, 'SUPRI', 'DA-0346', '31.7202.121058.0011', '5810.1205.5840', 'JL.H. UJUNG GG LAHER KP.GEMPOL_x000D_\nRT01/04NO4 KEL KEB', 1, '''087775886793', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(496, 'AHMAD NUH', 'DA-0349', '0953060111720231', '7211120515189', 'PASAR JUM''AT RT 09/02 KEL LEBAK BULUS', 1, '021 - 97195481', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(497, 'SUPRIANTO', 'DA-0350', '09.5204.200573.5542', '7305.1205.6505', 'JEMBATAN BESI RT 011/001 TAMBORA JAKBAR', 1, '''08128914448', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(498, 'SUTARNO', 'DA-0351', '31.7407.010972.0001', '7209.1205.11874', 'JL.JOGLO BARU RT 005/06 KEL.JOGLO KEMBANGAN', 1, '''082123565131', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(499, 'IKHWAN H', 'DA-0355', '0952080612865515', '8612120513190', 'JL LAP BOLA NO 11 RT 08/01 KEL SRENGSENG', 1, '''60859339', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(500, 'A.SUPRIYADI', 'DA-0355 C1', '3.173081602654E+016', '540212051158', 'JL TOMANG PENYELESAIAN II RT003/01 MERUYA UTARA', 1, '''087885112792', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(501, 'SUDARSO BIN RASTAM', 'DA-0356', '0815.01534.140003', '5012.514317.0107', 'JL. GARUDA GG. LONTAR RT..001/04 KEL_x000D_\nKEBUN KOSONG', 1, '''087884997250', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(502, 'SAFRUDIN', 'DA-0356 C1', '3.17202070976E+015', '76091120514313', 'JL ANCOL SELATAN IIRT 010/07 NO 52 SUNTER AGUNG TJ', 1, '081286972542', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(503, 'DJUMADI', 'DA-0359', '3603241511630001', '691112052007', 'JL H GANOL KP PRIGI RT01/01 55 PNDK AREN TGR', 1, '''02195827341', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(504, 'NATA', 'DA-0359 C1', '3.17407150578002E+01', '7805120517755', 'JL RADIO DALAM ANTENE 4 RT08/08 NO 5 KERAMAT PELA', 1, '''087881488047', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(505, 'SAMIJO', 'DA-0360', '0952041707610507', '610712056154', 'JL.JEMBATAN BESI RT11/01 NO.14 TAMBORA JAKBAR', 1, '081210294833', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(506, 'KASMADI', 'DA-0378', '095201909570247', '570912054326', 'JL.RW BUAYA RT 04/04 NO 14 KEL.RAWA BUAYA CENGKRNG', 1, '085319392707', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(507, 'SUKENDANG', 'DA-0378 C1', '952020905810232', '810512057505', 'JL JELAMBAR TMR 49 RT 11/08 JELAMBAR BARU', 1, '087886791263', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(508, 'MUHAMMAD HABIB', 'DA-0378 C2', '', '910216330029', 'RT 003/002KEL KOTA BARUKEC KOTA SOE KAB TTS', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(509, 'YUDI', 'DA-0387', '09.5202.150773.0778', '7307.1205.55416 A/P', 'Jl.indraloka I/103 RT 008/010 wijaya kusuma grogol', 1, '0812294342332', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(510, 'MUHAMMAD RIDHO', 'DA-039 C3', '3671112212790001', '791212191389', 'Gg KIJAN DIRI RT 006/05 NEROKTOG PINANG TANGERANG', 1, '''087885177611', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(511, 'FINOT R. SILITONGA', 'DA-0390', '3173013010821002', '8210120552725', 'JL.SWADAYA III RT.003/08 NO.34 KEL CENGKARENG JAKB', 1, '081282323700', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(512, 'AGUS PRASETIYO', 'DA-0390 B1', '31.7504.250881.0010', '8108.1117.0505', 'JL DUKUH  V RT008/05 KEL DUKUH KRAMAT JATI JAKTIM', 1, '08111893515/', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(513, 'AGUS PRASETIYO', 'DA-0390B1', '3175042508810010', '810811170505', 'JL,DUKUH V RT.08/05 KEL.DUKUH KEC KRAMAT JATI', 1, '08111893515', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(514, 'MOELYONO', 'DA-0397', '33.1212.180465.0001', '6504.1447.0455', 'Jl. H rausin Rt. 001/01 No.59 Kel Klapa 2', 1, '''085293286000', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(515, 'DIMAN', 'DA-0397 C1', '09.5102.250264.0424', '6102.21205.1897', 'JL INDRALOKA 1 RT08/10 KEL WIJAYA KUSUMA JAKBAR', 1, '''087788804599', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(516, 'KARSAN', 'DA-0397 C2', '09.5007.031240.0325', '4012.1205.0089', 'INDRALOKA I RT 08/010 KEL WIJAYA KUSUMA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(517, 'JOHANNES SUMARSONO', 'DA-0400', '09.5102.230172.4010', '7201.2526.1458', 'JL. RAWABEBEK RT.018/011 KEL. _x000D_\nPENJARINGAN J-U', 1, '''085310294291', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(518, 'DASLIM', 'DA-0485', '3172011208761003', '7608120585598', 'Jl.luar Batang Rt.009/001 No.75 Kel Penjaringan', 1, '081806539174', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(519, 'BEJO DURAHIM', 'DA-0495', '3172050808680015', '620812055453', 'Jl.mangga dua VIII Rt.013/005 No.38 Kel Ancol', 1, '087888988478', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(520, 'BAMBANG MARSETYOKO', 'DB-1579', '', '', 'JAKARTA', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(521, 'CARIDI', 'DC-8341', '0952073006630449', '630612054744', 'Jl. Nurul Amal Rt. 014/05 No.07 Cengkareng Tmr', 1, '''081952673093', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(522, 'BIAYA BENGKEL, PERUSAHAAN', 'XB600', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(523, '', '', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(524, '', '', '', '', '', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(525, 'DA-0088 B4', 'KARSIM', '09.5107.040782.0224', '8207.1428.0218', 'JL MANGGA 2 KP MUKA RT.009/004 NO.15B KEL ANCOL', 1, '''087782275970', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(526, 'INDRA (NA)', '0170', '0954030105708545', '700512053759', 'JL PISANGAN LAMA II RT 003/004 PISANGAN JAKTIM', 1, '''081382282857', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(527, 'DA-0270  (BATAL)', 'D', '0952062005680420', '680512059937', 'JL. ANGKE JAYA 1/16 RT 01/06 ANGKE JAK-BAR', 1, '''021 91217075', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(528, 'SUMARNA (NA)', 'DA-0001', '-', '-', 'ASDF', 1, '02196381607', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(529, 'DADANG RISWANTO', 'DA-0002', '-', '-', 'ASD', 1, '081381572934', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(530, 'SYAFRIAL', 'DA-0003', '3.671122220571E+016', '710512058129', 'Cileduk Indah II Blok G No.05 Rt/01 Rw/010.Tangrg', 1, '02195105860', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(531, 'KARMIN', 'DA-0003 B1', '09.5207.020356.0390', '5603.1205.1023', 'JL.UTAN JATI RT 003/011 KALI DERES JAKBAR', 1, '98123482', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(532, 'M. NAZIF', 'DA-0005', '36.0326.26055.60003', '5605.1205.5728', 'JL. TIDORE JOMBANG RT 003/017_x000D_\nJOMBANG CIPUTAT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(533, 'BUYUNG MUNCAK', 'DA-0006', '-', '-', '', 1, '-', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(534, 'DA-0136 (NA)', 'DA-0012', '09.5208.010172.1122', '7201120510769', 'jL. Ry Joglo Rt04 Rw 06 Kel.Joglo_x000D_\nkembngan Jakbar', 1, '081383734136', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(535, 'ENDANG KOSASIH', 'DA-0012 C1', '3.6710320056E+015', '600512191332', 'JL DAAN MOGOT KM195 BLOK KAPU RT N05/01 NO 2 PORIS', 1, '0812155155', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(536, 'SYAHRUL', 'DA-00129', '3671130.80150.0001', '5001.1205.0972', 'JL.H.NAJIH RT 009/01 NO 37 KEL.PETUKANGAN UTR', 1, '081386429957', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(537, 'ABUN SURYA JADI', 'DA-0013', '', '', 'JL JOGLO BARU RT013/02 NO 21 B JOGLO JAK BAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(538, 'ENDI PRAAS', 'DA-0013 C1', '32.1221.161179.0001', '7705.1205.16740', 'JL DUTA BARU RT 016/07 DURI KEPA KEBON JRK JAK-BAR', 1, '081281681206', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(539, 'MARTIAS', 'DA-0013 C2', '09.5305.100169.0538', '690112056107', 'TNH KUSIR RT.012/001 KBY LAMA SLTN,KBY LAMA-JAKSEL', 1, '''081282058277', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(540, 'IRWIAN FEBRIA', 'DA-0014', '2.6710612028E+015', '8002120510673', 'KOMP KIMIA FARMA E111/12 RT005/002 CILEDUG PARUNG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(541, 'GIRI SUJATMOKO', 'DA-0014 C1', '', '', 'JL H JIAN RT05/04 CIPETE UTARA KEBAYORAN BARU', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(542, 'ANDRI YASMEN', 'DA-0014 C2', '09.5004.310177.0432', '760108.2000.27', 'KRAMAT PULO GG.XX111 RT.007/008 KRAMAT SENEN', 1, '081363308374', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(543, 'MOH. RONI', 'DA-0015', '', '', 'JL.MERUYA ILIR RT018 NO.14KEL.MERUYA UTARA JAK-BAR', 1, '085880635417', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(544, 'DARMA', 'DA-0015 C1', '09.5205.0704660397', '6624.1205.4621', 'JL.ANGKE INDAH RT 004/011 KEL.ANGKE KEC.TAMBORA', 1, '081310363356', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(545, 'SUDIONO', 'DA-0031', '3.21903201113544E+01', '', 'JL DWIYO SUDONO B1/3RT 01/02 KEL BENCONGAN KELAPA', 1, '081316641664', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(546, 'M. ROSIM', 'DA-0031 C2', '09.5201.160866.5515', '6608.1205.12370', 'JL.RAYA JOGLO RT.001/02 JOGLO KEMBANGAN JAKBAR', 1, '081905599249', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(547, 'ABD. GHOFUR', 'DA-0033', '09.5204.1205805568', '800512064032', 'JL KALI ANYAR 2RT 013/01 NO 6 KEL KALI  ANYAR', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(548, 'SUYONO', 'DA-0035', '36.71062404.690002', '6904.15590.125', 'JL.KARYA BAKTI RT.003/003 PARUNG SERAB CILEDUK', 1, '0817188978', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(549, 'SUKIRMAN', 'DA-0038', '36.0325110.553', '5305.1205.2972', 'JL.SUMBER KEHIDUPAN  RT05/03 KEDAUNG TANGGERANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(550, 'H. ASEPUDIN', 'DA-0048', '', '5107.1328.0044', 'DUSUN MEKAR BARU RT.03/01 CIKAMPEK KARAWANG', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(551, 'EDDY KHUNAEDI', 'DA-0064 C1', '0950062203742012', '740312057227', 'JL AT TAQWA 3 KAMP PONCOL PEDURENAN RT 002/001', 1, '''081908141023', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(552, 'KARMIN', 'DA-0077', '09.5207.020356.0390', '5603.1205.1023', 'JL.UTAN JATI RT 003/011 PEGADUNGAN KALI DERES JAK', 1, '''02199833438', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(553, 'BEJO', 'DA-0077 C1', '', '6703.1205.10302', 'KP.BARU SUDIMARA BRT RT 04/03 NO.127 CLDK', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(554, 'DURIAT', 'DA-0088', '', '', 'KP LUAR BATANG RT 014/003 PENJARINGAN JAK UT', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(555, 'GANDUNG SUTIYOSO', 'DA-0107', '36.7113.270577.0010', '7705.1219.0003', 'JL.INPRES XV/42 RT002/004 KEL.GAGA KEC.LARANGAN', 1, '021-7303757', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(556, 'FADLI', 'DA-0115 C1', '09.5303.150483.0022', '830412059571', 'JATI PDG RT.006/006 JATI PDG PSR MGGU JAK-SEL', 1, '08170847210', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(557, 'H. MUKTIYADI', 'DA-0123', '', '481113240091', 'LIMUS PRATAMA REGENCY BLOK J/38 LIMUS NUNGGAL', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00'),
(558, 'KHOLID(TDK DI PAKAI)', 'DA-0197 C2', '952042607670386', '670712054075', 'JL SAWA LIO IV RT004 /06 NO 63 JEMBATAN LIMA JKB', 1, '', '2012-12-18', 1, '', 1, 0, 0, '2012-12-18 00:00:00', '2012-12-18 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver_financials`
--

CREATE TABLE IF NOT EXISTS `driver_financials` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `driver_id` int(10) DEFAULT NULL,
  `financial_type_id` int(10) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `driver_financials`
--

INSERT INTO `driver_financials` (`id`, `driver_id`, `financial_type_id`, `amount`) VALUES
(1, 4, 18, '4000000.00'),
(2, 4, 10, '5000.00'),
(3, 2, 21, '0.00'),
(4, 6, 21, '0.00'),
(5, 5, 21, '0.00'),
(6, 9, 21, '0.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver_status`
--

CREATE TABLE IF NOT EXISTS `driver_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `driver_status`
--

INSERT INTO `driver_status` (`id`, `driver_status`) VALUES
(1, 'Aktif'),
(2, 'Tidak Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver_types`
--

CREATE TABLE IF NOT EXISTS `driver_types` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `driver_types`
--

INSERT INTO `driver_types` (`id`, `type`) VALUES
(1, 'Bravo'),
(2, 'Charlie');

-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_bykso`
--
CREATE TABLE IF NOT EXISTS `financial_report_bykso` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_daily`
--
CREATE TABLE IF NOT EXISTS `financial_report_daily` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`setoran_wajib` decimal(15,2)
,`tabungan_sparepart` decimal(15,2)
,`denda` decimal(15,2)
,`potongan` decimal(15,2)
,`cicilan_sparepart` decimal(15,2)
,`cicilan_ks` decimal(15,2)
,`biaya_cuci` decimal(15,2)
,`iuran_laka` decimal(15,2)
,`cicilan_dp_kso` decimal(15,2)
,`cicilan_hutang_lama` decimal(15,2)
,`ks` decimal(15,2)
,`cicilan_lain` decimal(15,2)
,`hutang_dp_sparepart` decimal(15,2)
,`setoran_cash` decimal(15,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_driver`
--
CREATE TABLE IF NOT EXISTS `financial_report_driver` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`operasi_status_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_fleet`
--
CREATE TABLE IF NOT EXISTS `financial_report_fleet` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`operasi_status_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_monthly_bykso`
--
CREATE TABLE IF NOT EXISTS `financial_report_monthly_bykso` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`monthname` varchar(9)
,`month` int(2)
,`year` int(4)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_monthly_driver`
--
CREATE TABLE IF NOT EXISTS `financial_report_monthly_driver` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`monthname` varchar(9)
,`month` int(2)
,`year` int(4)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_monthly_fleet`
--
CREATE TABLE IF NOT EXISTS `financial_report_monthly_fleet` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`monthname` varchar(9)
,`month` int(2)
,`year` int(4)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_years_bykso`
--
CREATE TABLE IF NOT EXISTS `financial_report_years_bykso` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`year` int(4)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_years_driver`
--
CREATE TABLE IF NOT EXISTS `financial_report_years_driver` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`year` int(4)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `financial_report_years_fleet`
--
CREATE TABLE IF NOT EXISTS `financial_report_years_fleet` (
`id` int(11)
,`kso_id` int(11)
,`fleet_id` int(11)
,`driver_id` int(11)
,`checkin_time` datetime
,`shift_id` int(11)
,`km_fleet` int(11)
,`operasi_time` date
,`pool_id` int(11)
,`fg_late` int(11)
,`checkin_step_id` int(11)
,`document_check_user_id` int(11)
,`physic_check_user_id` int(11)
,`bengkel_check_user_id` int(11)
,`finance_check_user_id` int(11)
,`checkin_id` int(11)
,`year` int(4)
,`setoran_wajib` decimal(37,2)
,`tabungan_sparepart` decimal(37,2)
,`denda` decimal(37,2)
,`potongan` decimal(37,2)
,`cicilan_sparepart` decimal(37,2)
,`cicilan_ks` decimal(37,2)
,`biaya_cuci` decimal(37,2)
,`iuran_laka` decimal(37,2)
,`cicilan_dp_kso` decimal(37,2)
,`cicilan_hutang_lama` decimal(37,2)
,`ks` decimal(37,2)
,`cicilan_lain` decimal(37,2)
,`hutang_dp_sparepart` decimal(37,2)
,`setoran_cash` decimal(37,2)
);
-- --------------------------------------------------------

--
-- Struktur dari tabel `financial_types`
--

CREATE TABLE IF NOT EXISTS `financial_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `financial_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data untuk tabel `financial_types`
--

INSERT INTO `financial_types` (`id`, `financial_type`) VALUES
(1, 'Setoran Wajib'),
(2, 'Tabungan Sparepart'),
(3, 'Denda'),
(4, 'Potongan'),
(5, 'Cicilan Sparepart'),
(6, 'Cicilan KS'),
(7, 'Biaya Cuci'),
(8, 'Iuran Laka'),
(9, 'Cicilan DP KSO'),
(10, 'Cicilan Hutang Lama'),
(11, 'Kurang Setor'),
(12, 'Cicilan Lain-Lain'),
(13, 'Hutang DP Sparepart'),
(14, 'Pemakaian Sparepart'),
(15, 'DP Sparepart'),
(16, 'Potongan Hari Libur'),
(17, 'Potongan Hari Libur Nasional'),
(18, 'Hutang Lama pengemudi'),
(19, 'Total Hutang KS Pengemudi'),
(20, 'Setoran Cash Pengemudi'),
(21, 'Tabungan Pengemudi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleets`
--

CREATE TABLE IF NOT EXISTS `fleets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) NOT NULL,
  `taxi_number` varchar(100) NOT NULL,
  `fleet_brand_id` int(11) NOT NULL,
  `fleet_model_id` int(11) NOT NULL,
  `engine_number` varchar(100) NOT NULL,
  `chassis_number` varchar(100) NOT NULL,
  `fleet_year_id` int(11) NOT NULL,
  `fleet_color_id` int(11) NOT NULL,
  `police_number` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `fg_status` int(11) NOT NULL COMMENT '1:Armada Didalam Pool, 2:Armada Diluar Pool',
  `fg_check` int(11) NOT NULL COMMENT '1 : Dalam Proses Checkout 2: Dalam Proses Check In',
  `fg_blocked` int(11) NOT NULL DEFAULT '0' COMMENT '0 : normal 1: Dalam Proses Blocking',
  `fg_bengkel` int(11) NOT NULL COMMENT '0: Armada Diluar Bengkel 1:Armada Di Bengkel',
  `fg_group` int(11) NOT NULL COMMENT '0: Armada Diluar Bengkel 1:Armada Di Bengkel',
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=224 ;

--
-- Dumping data untuk tabel `fleets`
--

INSERT INTO `fleets` (`id`, `pool_id`, `taxi_number`, `fleet_brand_id`, `fleet_model_id`, `engine_number`, `chassis_number`, `fleet_year_id`, `fleet_color_id`, `police_number`, `photo`, `fg_status`, `fg_check`, `fg_blocked`, `fg_bengkel`, `fg_group`, `time_inserted`, `time_modified`) VALUES
(1, 1, 'A-003', 1, 3, '1NZX929791', 'MRO53HY9399020634', 3, 3, 'B 1253 LU', '3421_162819227194705_1796953356_n.jpg', 0, 0, 0, 0, 1, '2012-12-18 17:52:00', '2012-12-18 10:50:53'),
(2, 1, 'A-004', 1, 3, '1NZX930233', 'MRO53HY9399020636', 3, 3, 'B 1254 LU', '404288_121039384717344_911703179_n.jpg', 0, 0, 0, 1, 1, '2012-12-18 17:56:02', '2012-12-18 10:54:55'),
(3, 1, 'A-005', 1, 3, '1NZX930923', 'MRO53HY9399020638', 3, 3, 'B 1255 LU', '374057_1677364452403970_535277887_n.jpg', 0, 0, 0, 0, 0, '2012-12-18 17:57:50', '2012-12-18 10:56:43'),
(4, 1, 'A006', 1, 3, '1NZX930283', 'MRO53HY9399020639', 3, 3, 'B 1256 LU', '36563_125075450974103_214890323_n.jpg', 0, 0, 0, 0, 1, '2012-12-18 17:59:30', '2012-12-18 10:58:23'),
(5, 1, 'A-008', 1, 3, '1NZX930338', 'MRO53HY9399020684', 3, 3, 'B 1248 LU', '066_rangers_kuli.jpg', 0, 0, 0, 0, 0, '2012-12-18 18:02:01', '2012-12-18 11:00:54'),
(6, 1, 'A-009', 1, 3, '1NZX931542', 'MRO53HY9399020685', 3, 3, 'B 1249 LU', '056_titanic_versi_kucing.jpg', 0, 0, 0, 0, 0, '2012-12-18 18:03:28', '2012-12-18 11:02:21'),
(9, 1, 'A-011', 1, 3, '1NZX942789', 'MRO53HY9399021452', 3, 3, 'B 1411 LU', '(udah).jpg', 0, 0, 0, 0, 0, '2012-12-18 18:07:36', '2012-12-18 11:06:29'),
(10, 1, 'A12B', 1, 3, '1NZX943440', 'MRO53HY9399021432', 3, 3, 'B 1413 LU', '002_gp_dan_lokal.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:18:30', '2012-12-18 12:17:23'),
(11, 1, 'A-015', 1, 3, '1NZX946370', 'MRO53HY9299021435', 3, 3, 'B 1415 LU', '043_tempat_duduk_bayi_mobil.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:20:42', '2012-12-18 12:19:35'),
(12, 1, 'A-019', 1, 3, '1NZX941220', 'MRO53HY9399021450', 3, 3, 'B 1979 LU', '046_motor_seksi.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:22:24', '2012-12-18 12:21:17'),
(13, 1, 'A-020', 1, 3, '1NZX946049', 'MRO53HY9399021440', 3, 3, 'B 1980 LU', '048_ngapain_liat_liat.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:24:22', '2012-12-18 12:23:15'),
(14, 1, 'A-021', 1, 3, '1NZX958929', 'MRO53HY9399022301', 3, 3, 'B 1721 LU', '074_salah_wadah_air.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:26:02', '2012-12-18 12:24:55'),
(15, 1, 'A-023', 1, 3, '1NZX958823', 'MRO53HY9399022303', 3, 3, 'B 2603 QR', '544856_293665737401846_592596250_n.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:27:19', '2012-12-18 12:26:12'),
(16, 1, 'A024', 1, 3, '1NZX958800', 'MRO53HY9399022304', 3, 3, 'B 2724 QR', '169961_321161631325136_710732419_o.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:28:36', '2012-12-18 12:27:29'),
(17, 1, 'A-026', 1, 3, '1NZX958366', 'MRO53HY9399022296', 3, 3, 'B 2826 PX', '177228_336155173149683_1465731777_o.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:30:10', '2012-12-18 12:29:03'),
(18, 1, 'A-027', 1, 3, '1NZX958901', 'MRO53HY9399022293', 3, 3, 'B 1177 QX', '229887_357383201019959_1555971296_n.jpg', 0, 0, 0, 0, 0, '2012-12-18 19:31:18', '2012-12-18 12:30:11'),
(19, 1, 'A-029', 1, 3, '1NZX958585', 'MRO53HY9399022299', 3, 3, 'B 1929 LU', '23925_302785486503293_694747105_n.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:16:56', '2012-12-18 14:15:48'),
(20, 1, 'A-030', 1, 3, '1NZX958525', 'MRO53HY9399022290', 3, 3, 'B 1570 QX', '056_titanic_versi_kucing.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:18:34', '2012-12-18 14:17:27'),
(21, 1, 'A031', 1, 3, '1NZX979781', 'MRO53HY9399023404', 3, 3, 'B 1831 OV', '192432_397676893639481_2074640665_o.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:20:30', '2012-12-18 14:19:23'),
(22, 1, 'A033B', 1, 3, '1NZX978263', 'MRO53HY9399023385', 3, 3, 'B 2163 PX', '14421_277701442350226_1626306797_n.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:21:59', '2012-12-18 14:20:52'),
(23, 1, 'A-034', 1, 3, '1NZX976564', 'MRO53HY9399023409', 3, 3, 'B 2914 AU', '68477_459621154089758_945136167_n.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:23:17', '2012-12-18 14:22:10'),
(24, 1, 'A-037', 1, 3, '1NZX978277', 'MRO53HY9399023362', 3, 3, 'B 2697 LU', '192432_397676893639481_2074640665_o.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:24:40', '2012-12-18 14:23:33'),
(25, 1, 'A-039', 1, 3, '1NZX979440', 'MRO53HY9399023357', 3, 3, 'B 1309 QX', '229887_357383201019959_1555971296_n.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:26:30', '2012-12-18 14:25:23'),
(26, 1, 'A-040', 1, 3, '1NZX979990', 'MRO53HY9399023359', 3, 3, 'B 1410 LU', 'berdapingan.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:28:08', '2012-12-18 14:27:01'),
(27, 1, 'A-041', 1, 3, '1NZX997120', 'MRO53HY9399024303', 3, 3, 'B 2902 LU', 'cahayta.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:29:18', '2012-12-18 14:28:11'),
(28, 1, 'A-042', 1, 2, '1NZX997162', 'MRO53HY9399024304', 3, 3, 'B 1842 LU', 'cinta_abadi.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:30:33', '2012-12-18 14:29:25'),
(29, 1, 'A044', 1, 3, '1NZX997224', 'MRO53HY9399024313', 3, 3, 'B 2883 LU', 'jalan_raya.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:31:33', '2012-12-18 14:30:26'),
(30, 1, 'A-046', 1, 3, '1NZX997174', 'MRO53HY9399024299', 3, 3, 'B 2696 LU', 'kopi_pagi.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:34:35', '2012-12-18 14:33:28'),
(31, 1, 'A048', 1, 3, '1NZX996448', 'MRO53HY9399024309', 3, 3, 'B 1197 LU', 'kucing_sdg_eheheh.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:35:56', '2012-12-18 14:34:49'),
(32, 1, 'A-050', 1, 3, '1NZX997050', 'MRO53HY9399024296', 3, 3, 'B 1800 LU', 'mr_ben.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:37:01', '2012-12-18 14:35:54'),
(33, 1, 'A-052', 1, 3, '1NZY057110', 'MRO53HY93A9026634', 4, 3, 'B 2672 QR', 'sapi_gigi_kawat.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:50:03', '2012-12-18 14:48:56'),
(34, 1, 'A-053', 1, 3, '1NZY058205', 'MRO53HY93A9026644', 4, 3, 'B 2673 QR', 'terkorak.jpg', 0, 0, 0, 0, 0, '2012-12-18 21:57:26', '2012-12-18 14:58:11'),
(35, 1, 'A-054', 1, 3, '1NZY058204', 'MRO53HY93A9026658', 4, 3, 'B 2604 QR', 'sukarno.jpg', 0, 0, 0, 0, 0, '2012-12-18 22:00:42', '2012-12-18 14:59:35'),
(36, 1, 'A055', 1, 3, '1NZY057991', 'MRO53HY93A9026668', 4, 3, 'B 2605 QR', 'tuyull.jpg', 0, 0, 0, 0, 0, '2012-12-18 22:02:19', '2012-12-18 15:01:11'),
(37, 1, 'A-056', 1, 3, '1NZY058581', 'MRO53HY93A902669', 4, 3, 'B 2616 QR', 'ovj_keluarga.jpg', 0, 0, 0, 0, 0, '2012-12-18 22:03:39', '2012-12-18 15:02:32'),
(38, 0, 'A047', 1, 3, '1NZ-X997207', 'MRO53HY9399024306', 3, 3, 'B 2717 LU', '123786.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:09:49', '2012-12-28 16:08:40'),
(39, 0, 'A-038', 1, 3, '1NZ-X980163', 'MRO53HY9399023368', 3, 3, 'B 1098 LU', 'f.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:11:01', '2012-12-28 16:09:52'),
(40, 0, 'A-058', 1, 3, '1NZ-Y057380', 'MRO53HY93A9026675', 4, 3, 'B 2728 QR', 'wiwid.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:13:59', '2012-12-28 16:12:49'),
(41, 0, 'A059', 1, 3, '1NZ-Y057247', 'MRO53HY93A9026677', 4, 3, 'B 2619 QR', 'yu.xls', 0, 0, 0, 0, 0, '2012-12-28 23:14:53', '2012-12-28 16:13:43'),
(42, 0, 'A-060', 1, 3, '1NZ-Y057244', 'MRO53HY93A9027516', 4, 3, 'B 2610 QR', 'poiuy.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:15:55', '2012-12-28 16:14:46'),
(43, 0, 'A-061', 1, 3, '1NZ-Y080983', 'MRO53HY93A9027516', 4, 3, 'B 1561 QX', 'ayang2.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:16:47', '2012-12-28 16:15:38'),
(44, 0, 'A062B', 1, 3, '1NZ-Y084272', 'MRO53HY93A9027753', 4, 3, 'B 1562 QX', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:18:14', '2012-12-28 16:17:05'),
(45, 0, 'A-063', 1, 3, '1NZ-Y084205', 'MRO53HY93A9027756', 4, 3, 'B 1313 QX', 'dc.0024.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:19:03', '2012-12-28 16:17:54'),
(46, 0, 'A-067', 1, 3, '1NZ-Y084658', 'MRO53HY93A9027765', 4, 3, 'B 1567 QX', 'asdf.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:19:51', '2012-12-28 16:18:41'),
(47, 0, 'A-068', 1, 3, '1NZ-Y084391', 'MRO53HY93A9027804', 4, 3, 'B 1568 QX', 'foto_martinus.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:20:34', '2012-12-28 16:19:25'),
(48, 0, 'A-069', 1, 3, '1NZ-Y084485', 'MRO53HY93A9027806', 4, 3, 'B 1469 LU', 'ls_1234_2006.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:21:53', '2012-12-28 16:20:44'),
(49, 0, 'A071', 1, 3, '1NZ-Y090876', 'MRO53HY93A9028830', 4, 3, 'B 2671 LU', 'poiuy.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:23:24', '2012-12-28 16:22:14'),
(50, 0, 'A074B', 1, 3, '1NZ-Y101024', 'MRO53HY93A9028860', 4, 3, 'B 2674 LU', 'la_1243_ba.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:24:27', '2012-12-28 16:23:17'),
(51, 0, 'A-075', 1, 3, '1NZ-Y101023', 'MRO53HY93A9028861', 4, 3, 'B 2675 LU', 'sdfas.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:25:16', '2012-12-28 16:24:06'),
(52, 0, 'A-076', 1, 3, '1NZ-Y101496', 'MRO53HY93A9028865', 4, 3, 'B 1576 QX', 'la_1243_bt.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:26:53', '2012-12-28 16:25:44'),
(53, 0, 'A-077', 1, 3, '1NZ-Y101494', 'MRO53HY93A9028869', 4, 3, 'B 2677 QR', 'l_1234_2006.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:27:40', '2012-12-28 16:26:31'),
(56, 0, 'A080', 1, 3, '1NZ-Y100627', 'MRO53HY93A9028874', 4, 3, 'B 2680 QR', '8851.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:30:09', '2012-12-28 16:28:59'),
(55, 0, 'A-078', 1, 3, '1NZ-Y101443', 'MRO53HY93A9028871', 4, 3, 'B 1578 QX', 'dc.0001.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:28:48', '2012-12-28 16:27:38'),
(58, 0, 'A-081', 1, 3, '1NZ-Y122120', 'MRO53HY93A9030064', 4, 3, 'B 2881 LU', '345.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:32:35', '2012-12-28 16:31:25'),
(59, 0, 'A083B', 1, 3, '1NZ-Y121904', 'MRO53HY93A9030070', 4, 3, 'B 2383 LU', 'la_1243_bt.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:33:59', '2012-12-28 16:32:50'),
(60, 0, 'A084', 1, 3, '1NZ-Y116764', 'MRO53HY93A99030072', 4, 3, 'B 2884 LU', 'sdfas.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:35:29', '2012-12-28 16:34:19'),
(61, 0, 'A-085', 1, 3, '1NZ-Y123228', 'MRO53HY93A9030073', 4, 3, 'B 2885 LU', '_lkj_l.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:36:28', '2012-12-28 16:35:18'),
(62, 0, 'A089', 1, 3, '1NZ-Y123021', 'MRO53HY93A9030092', 4, 3, 'B 2889 LU', 'f.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:37:30', '2012-12-28 16:36:21'),
(63, 0, 'A-091', 1, 3, '1NZ-Y128620', 'MRO53HY93A9030460', 4, 3, 'B 2691 LU', 'poiuy.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:39:08', '2012-12-28 16:37:58'),
(64, 0, 'A094B', 1, 3, '1NZ-Y141807', 'MRO53HY93A9031100', 4, 3, 'B 1794 LU', '345.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:40:33', '2012-12-28 16:39:23'),
(65, 0, 'A-096', 1, 3, '1NZ-Y141754', 'MRO53HY93A9031106', 4, 3, 'B 1196 QX', 'la_1243_bt.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:41:57', '2012-12-28 16:40:48'),
(66, 0, 'A097', 1, 3, '1NZ-Y140114', 'MRO53HY93A9031107', 4, 3, 'B 1197 QX', 'ls_1234_2006.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:43:16', '2012-12-28 16:42:06'),
(67, 0, 'A-098', 1, 3, '1NZ-Y141694', 'MRO53HY93A9031110', 4, 3, 'B 2698 LU', 'dc.0001.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:44:06', '2012-12-28 16:42:56'),
(68, 0, 'A-099', 1, 3, '1NZ-Y141350', 'MRO53HY93A9031111', 4, 3, 'B 1799 LU', 'ayang2.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:45:07', '2012-12-28 16:43:58'),
(69, 0, 'A104', 1, 3, '1NZ-Y209058', 'MRO53HY93A9035503', 4, 3, 'B 1304 QX', 'asdf.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:46:09', '2012-12-28 16:44:59'),
(70, 0, 'A106', 1, 3, '1NZ-Y206645', 'MRO53HY93A9035505', 4, 3, 'B 2606 QX', 'la_1243_bc.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:47:32', '2012-12-28 16:46:23'),
(71, 0, 'A-108', 1, 3, '1NZ-Y208786', 'MRO53HY93A9035508', 4, 3, 'B 1308 QX', 'la_1243_bc.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:48:31', '2012-12-28 16:47:21'),
(72, 0, 'A110', 1, 3, '1NZ-Y209149', 'MRO53HY93A9035510', 4, 3, 'B 1310 QX', 'f.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:49:32', '2012-12-28 16:48:22'),
(121, 2, '1900', 1, 1, '', '', 4, 3, 'B.2173.PX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(74, 0, 'A111B', 1, 3, '1NZ-Y225789', 'MRO53HY93A9036343', 4, 3, 'B 2611 QR', 'ea.a01207.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:50:37', '2012-12-28 16:49:27'),
(75, 0, 'A-112', 1, 3, '1NZ-Y225623', 'MRO53HY93A9036344', 4, 3, 'B 2912 LU', 'dc.0001.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:51:29', '2012-12-28 16:50:19'),
(76, 0, 'A115', 1, 3, '1NZ-Y216221', 'MRO53HY93A9036349', 4, 3, 'B 2915 LU', '8851.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:52:25', '2012-12-28 16:51:16'),
(77, 0, 'A-117', 1, 3, '1NZ-Y226092', 'MRO53HY93A9036353', 4, 3, 'B 2917 LU', 'poiuy.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:53:18', '2012-12-28 16:52:08'),
(78, 0, 'A-118', 1, 3, '1NZ-Y224800', 'MRO53HY93A9036354', 4, 3, 'B 2918 LU', 'ayang2.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:54:00', '2012-12-28 16:52:50'),
(79, 0, 'A-121', 1, 3, '1NZ-Y248348', 'MRO53HY93A9037551', 4, 3, 'B 2721 QR', '123786.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:57:43', '2012-12-28 16:56:34'),
(80, 0, 'A-122', 1, 3, '1NZ-Y248360', 'MRO53HY93A9037554', 4, 3, 'B 2722 QR', 'ls_1234_2006.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:58:37', '2012-12-28 16:57:28'),
(81, 0, 'A-124', 1, 3, '1NZ-Y247728', 'MRO53HY93A9037555', 4, 3, 'B 2924 VX', '345.jpg', 0, 0, 0, 0, 0, '2012-12-28 23:59:26', '2012-12-28 16:58:16'),
(82, 0, 'A-127', 1, 3, '1NZ-Y248427', 'MRO53HY93A9037561', 4, 3, 'B 1727 LU', 'poiuy.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:00:11', '2012-12-28 16:59:01'),
(83, 0, 'A-128', 1, 3, '1NZ-Y248428', 'MRO53HY93A9037564', 4, 3, 'B 2828 VX', 'wiwid.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:00:58', '2012-12-28 16:59:49'),
(84, 0, 'A-130', 1, 3, '1NZ-Y247822', 'MRO53HY93A9037566', 4, 3, 'B 2730 QR', '345.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:01:55', '2012-12-28 17:00:46'),
(85, 0, 'A-136', 1, 3, '1NZ-Y282960', 'MRO53HY93B9039031', 5, 3, 'B 2866 VX', 'la_1243_bt.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:03:06', '2012-12-28 17:01:57'),
(86, 0, 'A-138', 1, 3, '1NZ-Y282633', 'MRO53HY93B9039036', 5, 3, 'B 2948 VX', 'd1_9815.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:04:12', '2012-12-28 17:03:03'),
(87, 0, 'A-140', 1, 3, '1NZ-Y282634', 'MRO53HY93B9039040', 5, 3, 'B 2990 VX', '123786.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:05:12', '2012-12-28 17:04:02'),
(120, 2, '1895', 1, 1, '', '', 4, 3, 'B.2183.PX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(89, 0, 'A-142', 1, 3, '1NZ-Y345771', 'MRO53HY93B9042026', 5, 3, 'B 1353 SX', 'ea.a01207.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:06:27', '2012-12-28 17:05:17'),
(90, 0, 'A-151', 1, 3, '1NZ-Y342367', 'MRO53HY93B9041850', 5, 3, 'B 2151 LU', 'ea.a01207.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:09:11', '2012-12-28 17:08:01'),
(91, 0, 'A-152', 1, 3, '1NZ-Y341543', 'MR053HY93B9041852', 5, 3, 'B 2152 LU', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:15:09', '2012-12-28 17:13:59'),
(92, 0, 'A-153', 1, 3, '1NZ-Y341671', 'MR053HY93B9041854', 5, 3, 'B 2153 LU', 'ayang2.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:18:26', '2012-12-28 17:17:16'),
(119, 2, '1884', 1, 1, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(95, 0, 'A-157', 1, 3, '1NZ-Y345335', 'MR053HY93B9042119', 5, 3, 'B 2157 LU', '345.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:27:43', '2012-12-28 17:26:34'),
(96, 0, 'A-158', 1, 3, '1NZ-Y343997', 'MR053HY93B9042122', 5, 3, 'B 2158 LU', '345.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:30:45', '2012-12-28 17:29:36'),
(97, 0, 'A-159', 1, 3, '1NZ-Y346363', 'MR053HY93B9042123', 5, 3, 'B 2159 LU', 'd1_9815.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:33:34', '2012-12-28 17:32:25'),
(98, 0, 'A-160', 1, 3, '1NZ-Y347579', 'MR053HY93B9042139', 5, 3, 'B 2160 LU', 'dc.0001.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:37:13', '2012-12-28 17:36:03'),
(99, 0, 'A-161', 1, 3, '1NZ-Y370426', 'MR053HY93B9043516', 5, 3, 'B 2161 LU', '123786.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:41:03', '2012-12-28 17:39:54'),
(100, 0, 'A-162', 1, 3, '1NZ-Y367379', 'MR053HY93B9043307', 5, 3, 'B 2722 LU', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:43:19', '2012-12-28 17:42:09'),
(101, 0, 'A-170', 1, 3, '1NZ-Y378803', 'MR053HY93B904891', 5, 3, 'B 2170 LU', 'd1_9815.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:46:20', '2012-12-28 17:45:10'),
(102, 0, 'A-171', 1, 3, '1NZ-Y415676', 'MR053HY93B9045504', 5, 3, 'B 2871 VX', 'asdf.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:49:17', '2012-12-28 17:48:08'),
(103, 0, 'A172', 1, 3, '1NZ-Y417174', 'MR053HY93B9045518', 5, 3, 'B 2802VX', 'dc.0001.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:53:18', '2012-12-28 17:52:09'),
(104, 0, 'A175', 1, 3, '1NZ Y415455', 'MR053HY93B9045526', 5, 3, 'B 2835 VX', '345.jpg', 0, 0, 0, 0, 0, '2012-12-29 00:57:00', '2012-12-28 17:55:50'),
(105, 0, 'A-176', 1, 3, '1NZ-Y417600', 'MR053HY93B9045534', 5, 3, 'B 2876 VX', 'asdf.jpg', 0, 0, 0, 0, 0, '2012-12-29 01:00:06', '2012-12-28 17:58:56'),
(117, 0, 'A168', 1, 3, '1NZ-Y378921', 'MRO53HY93B9043884', 5, 3, 'B 2168 LU', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-29 19:46:31', '2012-12-29 12:45:21'),
(116, 0, 'A164', 1, 3, '1NZ-Y377894', 'MRO53HY93B9043861', 5, 3, 'B 2164 PX', 'sdfas.jpg', 0, 0, 0, 0, 0, '2012-12-29 19:45:13', '2012-12-29 12:44:03'),
(108, 0, 'A-179', 1, 3, '1NZ-Y417670', 'MR053HY93B9045547', 5, 3, 'B 2979 VX', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-29 01:10:27', '2012-12-28 18:09:18'),
(109, 0, 'A-180', 1, 3, '1NZ-Y418430', 'MR053HY93B9045579', 5, 3, 'B 2880 VX', 'ea.a4506.jpg', 0, 0, 0, 0, 0, '2012-12-29 01:21:45', '2012-12-28 18:20:36'),
(110, 0, 'A-188', 1, 3, '1NZ-Y400626', 'MR053HY93B90466725', 5, 3, 'B 2888 VX', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-29 01:24:50', '2012-12-28 18:23:41'),
(111, 0, 'A-197', 1, 3, '1NZ-Y524973', 'MR053HY93C9050219', 6, 3, 'B 1577 QX', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-29 01:30:42', '2012-12-28 18:29:32'),
(112, 0, 'A-245', 1, 3, '1NZ-Y651080', 'MR053HY93C9057523', 6, 3, 'B 1615 IU', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-29 01:35:09', '2012-12-28 18:34:00'),
(113, 0, 'A-251', 1, 3, '1NZ-Y651408', 'MR053HY93C9057542', 6, 3, 'B1621 IU', 'ex.1234111.jpg', 0, 0, 0, 0, 0, '2012-12-29 01:37:39', '2012-12-28 18:36:30'),
(115, 0, 'A001', 1, 3, '1NZ-X929723', 'MRO53HY9399020631', 3, 3, 'B 1251 LU', '8851.jpg', 0, 0, 0, 0, 0, '2012-12-29 19:43:54', '2012-12-29 12:42:44'),
(122, 2, '1930', 1, 1, '', '', 4, 3, 'B.1551.IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(123, 2, '1945', 1, 1, '', '', 4, 3, 'B.1557 IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(124, 2, '1968', 1, 1, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(125, 2, '1982A', 1, 1, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(126, 2, '1989', 1, 1, '', '', 4, 3, 'B 1986 MU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(127, 2, '2008', 1, 1, '', '', 4, 3, 'B 1616 IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(128, 2, '2019', 1, 1, '', '', 4, 3, 'B.1629.IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(129, 2, '2054', 1, 1, '', '', 4, 3, 'B 2479 AU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(130, 2, '2130', 1, 1, '', '', 4, 3, 'B 1401 IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(131, 2, '2141', 1, 1, '', '', 4, 3, 'B 1388 IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(132, 2, '2174', 1, 1, '', '', 4, 3, 'B.1671.MU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(133, 2, '2176', 1, 1, '', '', 4, 3, 'B.1416.IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(134, 2, '2187', 1, 1, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(135, 2, '2190', 1, 1, '', '', 4, 3, 'B.1932 QX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(136, 2, '2192', 1, 1, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(137, 2, '2280', 1, 1, '', '', 4, 3, 'B 1954 OV', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(138, 2, '2281', 1, 1, '', '', 4, 3, 'B 1947 OV', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(139, 2, 'C-002', 1, 2, '', '', 4, 3, 'B.1252.LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(140, 2, 'C-012', 1, 2, '', '', 4, 3, 'B 1412 LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(141, 2, 'C-017', 1, 2, '', '', 4, 3, 'B 1417 LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(142, 2, 'C-022', 1, 2, '', '', 4, 3, 'B 1202 QX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(143, 2, 'C-032', 1, 2, '', '', 4, 3, 'B 2602TU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(144, 2, 'C-035', 1, 2, '', '', 4, 3, 'B 2835 PX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(145, 2, 'C-045', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(146, 2, 'C-051', 1, 2, '', '', 4, 3, 'B.2671.QR', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(147, 2, 'C-070', 1, 2, '', '', 4, 3, 'B 1470 LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(148, 2, 'C-086', 1, 2, '', '', 4, 3, 'B.2886 LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(149, 2, 'C-087', 1, 2, '', '', 4, 3, 'B 2887 LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(150, 2, 'C-100', 1, 2, '', '', 4, 3, 'B.2700.LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(151, 2, 'C-102', 1, 2, '', '', 4, 3, 'C 1302QX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(152, 2, 'C-105', 1, 2, '', '', 4, 3, 'B 1305-QX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(153, 2, 'C-109', 1, 2, '', '', 4, 3, 'B 2609 QR', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(154, 2, 'C-118', 1, 2, '', '', 4, 3, 'B 2918 LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(155, 2, 'C-120', 1, 2, '', '', 4, 3, 'B.2720.LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(156, 2, 'C-125', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(157, 2, 'C-126', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(158, 2, 'C-135', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(159, 2, 'C-141', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(160, 2, 'C-143', 1, 2, '', '', 4, 3, 'B 1372 SX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(161, 2, 'C-146', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(162, 2, 'C-148', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(163, 2, 'C-149', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(164, 2, 'C-154', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(165, 2, 'C-156', 1, 2, '', '', 4, 3, 'B 2156 IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(166, 2, 'C-165', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(167, 2, 'C-166', 1, 2, '', '', 4, 3, 'B 2161 PX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(168, 2, 'C-169', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(169, 2, 'C-173', 1, 2, '', '', 4, 3, 'B 2803 VX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(170, 2, 'C-174', 1, 2, '', '', 4, 3, 'B 2834 VX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(171, 2, 'C-181', 1, 2, '', '', 4, 3, 'B 2881 VX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(172, 2, 'C-182', 1, 2, '', '', 4, 3, 'B 2282 SX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(173, 2, 'C-183', 1, 2, '', '', 4, 3, 'B 2833 VX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(174, 2, 'C-184', 1, 2, '', '', 4, 3, 'B 2884 VX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(175, 2, 'C-191', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(176, 2, 'C-192', 1, 2, '', '', 4, 3, 'B-2558 AU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(177, 2, 'C-199', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(178, 2, 'C-200', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(179, 2, 'C-201', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(180, 2, 'C-202', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(181, 2, 'C-203', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(182, 2, 'C-205', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(183, 2, 'C-211', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(184, 2, 'C-213', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(185, 2, 'C-214', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(186, 2, 'C-215', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(187, 2, 'C-217', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(188, 2, 'C-225', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(189, 2, 'C-229', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(190, 2, 'C-230', 1, 2, '', '', 4, 3, 'B.', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(191, 2, 'C-231', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(192, 2, 'C-232', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(193, 2, 'C-238', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(194, 2, 'C-242', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(195, 2, 'C-246', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(196, 2, 'C-247', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(197, 2, 'C-248', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(198, 2, 'C-249', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(199, 2, 'C-252', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(200, 2, 'C-253', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(201, 2, 'C-254', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(202, 2, 'C-255', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(203, 2, 'C-256', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(204, 2, 'C-257', 1, 2, '', '', 4, 3, 'B', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(205, 2, 'C-269', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(206, 2, 'C-270', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(207, 2, 'C-281', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(208, 2, 'C-283', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(209, 2, 'C-289', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(210, 2, 'C045A', 1, 2, '', '', 4, 3, 'B 2385 LU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(211, 2, 'C247A', 1, 2, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(212, 2, '1900', 1, 1, '', '', 4, 3, 'B 2179 PX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(213, 2, '1916', 1, 1, '', '', 4, 3, 'B 2825 TX', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(214, 2, '1930', 1, 1, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(215, 2, '1938', 1, 1, '', '', 4, 3, 'B 1559 IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(216, 2, '1948', 1, 1, '', '', 4, 3, 'B-1563-IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(217, 2, '1968A', 1, 1, '', '', 4, 3, '', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(218, 2, '2035', 1, 1, '', '', 4, 3, 'B-2349-AU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(219, 2, '2038', 1, 1, '', '', 4, 3, 'B 2352 AU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(220, 2, '2105', 1, 1, '', '', 4, 3, 'B-', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(221, 2, '2163', 1, 1, '', '', 4, 3, 'B 1669 MU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(222, 2, '2225A', 1, 1, '', '', 4, 3, 'B-1127-IU', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00'),
(223, 2, '2295', 1, 1, '', '', 4, 3, 'B 1996 OV', '', 1, 1, 0, 0, 0, '2013-01-25 00:00:00', '2013-01-25 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_brands`
--

CREATE TABLE IF NOT EXISTS `fleet_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_brand` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `fleet_brands`
--

INSERT INTO `fleet_brands` (`id`, `fleet_brand`) VALUES
(1, 'Toyota');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_checks`
--

CREATE TABLE IF NOT EXISTS `fleet_checks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `security_check_id` int(11) NOT NULL,
  `fisik_check_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_colors`
--

CREATE TABLE IF NOT EXISTS `fleet_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_color` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `fleet_colors`
--

INSERT INTO `fleet_colors` (`id`, `fleet_color`) VALUES
(1, 'Silver'),
(2, 'Hitam'),
(3, 'Putih');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_drivers`
--

CREATE TABLE IF NOT EXISTS `fleet_drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `fg_type` int(11) NOT NULL COMMENT '1: charlie, 2:bravo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `fleet_drivers`
--

INSERT INTO `fleet_drivers` (`id`, `fleet_id`, `driver_id`, `fg_type`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_financials`
--

CREATE TABLE IF NOT EXISTS `fleet_financials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(10) DEFAULT NULL,
  `financial_type_id` int(10) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_licenses`
--

CREATE TABLE IF NOT EXISTS `fleet_licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `fleet_license_type_id` int(11) NOT NULL,
  `license_number` varchar(100) NOT NULL,
  `validtrough` date NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `fleet_licenses`
--

INSERT INTO `fleet_licenses` (`id`, `fleet_id`, `fleet_license_type_id`, `license_number`, `validtrough`, `ket`) VALUES
(1, 1, 1, '234.12312.4235', '2012-08-31', '-'),
(2, 1, 2, '123.412.12312.23423', '2015-08-30', 'ok'),
(3, 2, 1, '14124.234245.21312', '2012-08-23', 'ok'),
(4, 2, 2, '1241.23234.123123', '2012-08-27', 'ok'),
(5, 3, 1, '56345.3423.234', '2012-08-10', 'ok'),
(6, 3, 2, '234.123.35.46', '2014-08-29', 'ok de'),
(7, 7, 1, '14.123.124.234.45', '2012-08-31', 'jj'),
(8, 7, 2, '234.234123.123.123', '2015-08-23', 'ok deh'),
(9, 10, 1, '234234234', '2012-11-30', 'sdf'),
(10, 10, 3, '234234', '2012-11-30', '2352342344'),
(11, 10, 4, '234234234', '2012-11-30', 'werwerewr'),
(12, 10, 5, '234234234', '2012-11-30', 'ertweewrwer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_license_types`
--

CREATE TABLE IF NOT EXISTS `fleet_license_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_license_type` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `fleet_license_types`
--

INSERT INTO `fleet_license_types` (`id`, `fleet_license_type`) VALUES
(1, 'STNK'),
(2, 'BPKB'),
(3, 'Emission Test'),
(4, 'Layak Operasi'),
(5, 'Tera Argo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_location_updates`
--

CREATE TABLE IF NOT EXISTS `fleet_location_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `location` varchar(200) NOT NULL,
  `time_lookup` datetime NOT NULL,
  `time_inserted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `fleet_location_updates`
--

INSERT INTO `fleet_location_updates` (`id`, `fleet_id`, `location`, `time_lookup`, `time_inserted`) VALUES
(1, 1, 'Pondok Kopi', '2012-08-15 07:44:56', '2012-08-08 13:45:11'),
(2, 2, 'Kembangan', '2012-08-08 11:45:19', '2012-08-08 13:45:22'),
(3, 3, 'Seputar Buncit Raya', '2012-08-08 12:45:32', '2012-08-08 06:45:43'),
(4, 4, 'KFC Kemang', '2012-08-08 12:45:57', '2012-08-08 13:46:05'),
(5, 5, 'McD Subroto', '2012-08-08 13:16:15', '2012-08-08 13:46:20'),
(6, 9, 'Manggarai', '2012-08-08 13:46:35', '2012-08-08 13:46:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_models`
--

CREATE TABLE IF NOT EXISTS `fleet_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_brand_id` int(11) NOT NULL,
  `fleet_model` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `fleet_models`
--

INSERT INTO `fleet_models` (`id`, `fleet_brand_id`, `fleet_model`) VALUES
(1, 1, 'Limo'),
(2, 1, 'Soluna'),
(3, 1, 'New Limo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_repairs`
--

CREATE TABLE IF NOT EXISTS `fleet_repairs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_check_id` int(11) NOT NULL,
  `request_sparepart_id` int(11) NOT NULL,
  `fg_done` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fleet_years`
--

CREATE TABLE IF NOT EXISTS `fleet_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `fleet_years`
--

INSERT INTO `fleet_years` (`id`, `fleet_year`) VALUES
(1, 2007),
(2, 2008);

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) DEFAULT NULL,
  `sparepart_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pool_id` (`pool_id`,`sparepart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kewajibans`
--

CREATE TABLE IF NOT EXISTS `kewajibans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `financial_type_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `kewajibans`
--

INSERT INTO `kewajibans` (`id`, `fleet_id`, `driver_id`, `financial_type_id`, `amount`, `total_amount`) VALUES
(1, 1, 2, 6, '0.00', '0.00'),
(2, 2, 6, 6, '0.00', '0.00'),
(3, 4, 9, 6, '5000.00', '48000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ksos`
--

CREATE TABLE IF NOT EXISTS `ksos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kso_number` varchar(100) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `bravo_driver_id` varchar(100) NOT NULL,
  `charlie_driver_id` varchar(100) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `dp` decimal(15,2) NOT NULL,
  `sisa_dp` decimal(15,2) NOT NULL,
  `sisa_kewajiban` decimal(15,2) NOT NULL,
  `setoran` decimal(15,2) NOT NULL,
  `tab_sparepart` decimal(15,2) NOT NULL,
  `ops_start` date NOT NULL,
  `ops_end` date NOT NULL,
  `attachment` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL,
  `actived` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `ksos`
--

INSERT INTO `ksos` (`id`, `kso_number`, `fleet_id`, `bravo_driver_id`, `charlie_driver_id`, `pool_id`, `total`, `dp`, `sisa_dp`, `sisa_kewajiban`, `setoran`, `tab_sparepart`, `ops_start`, `ops_end`, `attachment`, `user_id`, `last_update`, `actived`) VALUES
(1, 'DT-001/21/12/13-KSO', 1, '2', '6', 1, '0.00', '0.00', '1000000.00', '0.00', '210000.00', '35000.00', '0000-00-00', '0000-00-00', '', 1, '0000-00-00 00:00:00', 1),
(2, 'DT-002/21/12/13-KSO', 2, '4', '6', 1, '0.00', '0.00', '1000000.00', '0.00', '210000.00', '35000.00', '0000-00-00', '0000-00-00', '', 1, '0000-00-00 00:00:00', 1),
(3, 'DT-003/21/12/13-KSO', 3, '5', '6', 1, '0.00', '0.00', '1000000.00', '0.00', '210000.00', '35000.00', '0000-00-00', '0000-00-00', '', 1, '0000-00-00 00:00:00', 1),
(4, 'DT-004/21/12/13-KSO', 4, '9', '10', 1, '0.00', '1000000.00', '5500000.00', '0.00', '210000.00', '35000.00', '2013-02-25', '2013-02-27', '', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `months`
--

CREATE TABLE IF NOT EXISTS `months` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `months`
--

INSERT INTO `months` (`id`, `name`) VALUES
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Struktur dari tabel `oprasi_status`
--

CREATE TABLE IF NOT EXISTS `oprasi_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(2) DEFAULT NULL,
  `operasi_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `oprasi_status`
--

INSERT INTO `oprasi_status` (`id`, `kode`, `operasi_status`) VALUES
(1, 'OK', 'Beroperasi'),
(2, 'TP', 'Tanpa Pengemudi'),
(3, 'BP', 'Belum Pulang'),
(4, 'TL', 'Tidak Layak Jalan'),
(5, 'BS', 'Bebas Setor'),
(6, 'LL', 'Lain - Lain'),
(7, 'BL', 'Blocking');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `from_address` varchar(250) NOT NULL,
  `to_address` varchar(250) NOT NULL,
  `shuttle_time` datetime NOT NULL,
  `fleet_id` int(11) DEFAULT NULL,
  `order_status_id` int(11) DEFAULT NULL,
  `cancellation_message` text,
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_spareparts`
--

CREATE TABLE IF NOT EXISTS `order_spareparts` (
  `id` int(11) NOT NULL,
  `fg_order_type` int(11) NOT NULL COMMENT '1 : Check Out, 2:Check In, 3: Lain-lain',
  `related_id` int(11) NOT NULL,
  `sparepart_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL COMMENT 'satuan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_status`
--

CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `order_status`
--

INSERT INTO `order_status` (`id`, `order_status`) VALUES
(1, 'New'),
(2, 'Sedang Dijemput'),
(3, 'Sedang Diantar'),
(4, 'Sampai Tujuan'),
(5, 'Batal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `other_payments`
--

CREATE TABLE IF NOT EXISTS `other_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) DEFAULT NULL,
  `financial_type_id` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `other_payments`
--

INSERT INTO `other_payments` (`id`, `pool_id`, `financial_type_id`, `amount`) VALUES
(1, 1, 7, '3000.00'),
(2, 1, 8, '3000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_cuts`
--

CREATE TABLE IF NOT EXISTS `payment_cuts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pool_id` int(10) DEFAULT NULL,
  `financial_type_id` int(10) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `payment_cuts`
--

INSERT INTO `payment_cuts` (`id`, `pool_id`, `financial_type_id`, `amount`) VALUES
(1, 1, 16, '0.00'),
(2, 1, 17, '25000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pools`
--

CREATE TABLE IF NOT EXISTS `pools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_name` varchar(200) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city_id` int(11) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `code_pool` varchar(8) NOT NULL,
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `pools`
--

INSERT INTO `pools` (`id`, `pool_name`, `address`, `city_id`, `phone`, `code_pool`, `time_inserted`, `time_modified`) VALUES
(1, 'Joglo Baru', 'Jl Kembangan', 1, '0217024 6866', 'DT-DA', '0000-00-00 00:00:00', '2012-08-08 04:29:24'),
(2, 'Rawa Bokor', 'Cengkareng', 1, '0215595 0282', 'DT-DB', '0000-00-00 00:00:00', '2012-08-08 04:29:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `request_spareparts`
--

CREATE TABLE IF NOT EXISTS `request_spareparts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `sparepart_id` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `fg_check` int(11) NOT NULL COMMENT '0:Belum Cek, 1:Cek',
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `schedule_master_id` int(11) NOT NULL,
  `month` int(100) NOT NULL,
  `year` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `pool_id`, `fleet_id`, `schedule_master_id`, `month`, `year`, `user_id`, `inserted_date_set`) VALUES
(1, 1, 1, 2, 2, 2013, 1, '2013-02-26 13:49:53'),
(2, 1, 2, 2, 1, 2013, 1, '2013-02-26 13:49:58'),
(3, 1, 2, 2, 2, 2013, 1, '2013-02-26 13:50:09'),
(5, 1, 4, 1, 2, 2013, 1, '2013-02-26 13:56:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_dates`
--

CREATE TABLE IF NOT EXISTS `schedule_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `fg_check` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=144 ;

--
-- Dumping data untuk tabel `schedule_dates`
--

INSERT INTO `schedule_dates` (`id`, `schedule_id`, `date`, `driver_id`, `shift_id`, `fg_check`, `inserted_date_set`) VALUES
(1, 1, 1, 6, 1, 0, '2013-02-26 13:49:53'),
(2, 1, 2, 2, 1, 0, '2013-02-26 13:49:53'),
(3, 1, 3, 2, 1, 0, '2013-02-26 13:49:53'),
(4, 1, 4, 6, 1, 0, '2013-02-26 13:49:53'),
(5, 1, 5, 2, 1, 0, '2013-02-26 13:49:53'),
(6, 1, 6, 2, 1, 0, '2013-02-26 13:49:53'),
(7, 1, 7, 6, 1, 0, '2013-02-26 13:49:53'),
(8, 1, 8, 2, 1, 0, '2013-02-26 13:49:53'),
(9, 1, 9, 2, 1, 0, '2013-02-26 13:49:53'),
(10, 1, 10, 6, 1, 0, '2013-02-26 13:49:53'),
(11, 1, 11, 2, 1, 0, '2013-02-26 13:49:53'),
(12, 1, 12, 2, 1, 0, '2013-02-26 13:49:53'),
(13, 1, 13, 6, 1, 0, '2013-02-26 13:49:53'),
(14, 1, 14, 2, 1, 0, '2013-02-26 13:49:53'),
(15, 1, 15, 2, 1, 0, '2013-02-26 13:49:53'),
(16, 1, 16, 6, 1, 0, '2013-02-26 13:49:53'),
(17, 1, 17, 2, 1, 0, '2013-02-26 13:49:53'),
(18, 1, 18, 2, 1, 0, '2013-02-26 13:49:53'),
(19, 1, 19, 6, 1, 0, '2013-02-26 13:49:53'),
(20, 1, 20, 2, 1, 0, '2013-02-26 13:49:53'),
(21, 1, 21, 2, 1, 0, '2013-02-26 13:49:53'),
(22, 1, 22, 6, 1, 0, '2013-02-26 13:49:53'),
(23, 1, 23, 2, 1, 0, '2013-02-26 13:49:53'),
(24, 1, 24, 2, 1, 0, '2013-02-26 13:49:53'),
(25, 1, 25, 6, 1, 0, '2013-02-26 13:49:53'),
(26, 1, 26, 2, 1, 1, '2013-02-26 13:49:53'),
(27, 1, 27, 2, 1, 1, '2013-02-26 13:49:53'),
(28, 1, 28, 6, 1, 0, '2013-02-26 13:49:53'),
(29, 2, 1, 4, 1, 0, '2013-02-26 13:49:58'),
(30, 2, 2, 6, 1, 0, '2013-02-26 13:49:58'),
(31, 2, 3, 4, 1, 0, '2013-02-26 13:49:58'),
(32, 2, 4, 4, 1, 0, '2013-02-26 13:49:58'),
(33, 2, 5, 6, 1, 0, '2013-02-26 13:49:58'),
(34, 2, 6, 4, 1, 0, '2013-02-26 13:49:58'),
(35, 2, 7, 4, 1, 0, '2013-02-26 13:49:58'),
(36, 2, 8, 6, 1, 0, '2013-02-26 13:49:58'),
(37, 2, 9, 4, 1, 0, '2013-02-26 13:49:58'),
(38, 2, 10, 4, 1, 0, '2013-02-26 13:49:58'),
(39, 2, 11, 6, 1, 0, '2013-02-26 13:49:58'),
(40, 2, 12, 4, 1, 0, '2013-02-26 13:49:58'),
(41, 2, 13, 4, 1, 0, '2013-02-26 13:49:58'),
(42, 2, 14, 6, 1, 0, '2013-02-26 13:49:58'),
(43, 2, 15, 4, 1, 0, '2013-02-26 13:49:58'),
(44, 2, 16, 4, 1, 0, '2013-02-26 13:49:58'),
(45, 2, 17, 6, 1, 0, '2013-02-26 13:49:58'),
(46, 2, 18, 4, 1, 0, '2013-02-26 13:49:58'),
(47, 2, 19, 4, 1, 0, '2013-02-26 13:49:58'),
(48, 2, 20, 6, 1, 0, '2013-02-26 13:49:58'),
(49, 2, 21, 4, 1, 0, '2013-02-26 13:49:58'),
(50, 2, 22, 4, 1, 0, '2013-02-26 13:49:58'),
(51, 2, 23, 6, 1, 0, '2013-02-26 13:49:58'),
(52, 2, 24, 4, 1, 0, '2013-02-26 13:49:58'),
(53, 2, 25, 4, 1, 0, '2013-02-26 13:49:58'),
(54, 2, 26, 6, 1, 0, '2013-02-26 13:49:58'),
(55, 2, 27, 4, 1, 0, '2013-02-26 13:49:58'),
(56, 2, 28, 4, 1, 0, '2013-02-26 13:49:58'),
(57, 2, 29, 6, 1, 0, '2013-02-26 13:49:58'),
(58, 2, 30, 4, 1, 0, '2013-02-26 13:49:58'),
(59, 2, 31, 4, 1, 0, '2013-02-26 13:49:58'),
(60, 3, 1, 4, 1, 0, '2013-02-26 13:50:09'),
(61, 3, 2, 6, 1, 0, '2013-02-26 13:50:09'),
(62, 3, 3, 4, 1, 0, '2013-02-26 13:50:09'),
(63, 3, 4, 4, 1, 0, '2013-02-26 13:50:09'),
(64, 3, 5, 6, 1, 0, '2013-02-26 13:50:09'),
(65, 3, 6, 4, 1, 0, '2013-02-26 13:50:09'),
(66, 3, 7, 4, 1, 0, '2013-02-26 13:50:09'),
(67, 3, 8, 6, 1, 0, '2013-02-26 13:50:09'),
(68, 3, 9, 4, 1, 0, '2013-02-26 13:50:09'),
(69, 3, 10, 4, 1, 0, '2013-02-26 13:50:09'),
(70, 3, 11, 6, 1, 0, '2013-02-26 13:50:09'),
(71, 3, 12, 4, 1, 0, '2013-02-26 13:50:09'),
(72, 3, 13, 4, 1, 0, '2013-02-26 13:50:09'),
(73, 3, 14, 6, 1, 0, '2013-02-26 13:50:09'),
(74, 3, 15, 4, 1, 0, '2013-02-26 13:50:09'),
(75, 3, 16, 4, 1, 0, '2013-02-26 13:50:09'),
(76, 3, 17, 6, 1, 0, '2013-02-26 13:50:09'),
(77, 3, 18, 4, 1, 0, '2013-02-26 13:50:09'),
(78, 3, 19, 4, 1, 0, '2013-02-26 13:50:09'),
(79, 3, 20, 6, 1, 0, '2013-02-26 13:50:09'),
(80, 3, 21, 4, 1, 0, '2013-02-26 13:50:09'),
(81, 3, 22, 4, 1, 0, '2013-02-26 13:50:09'),
(82, 3, 23, 6, 1, 0, '2013-02-26 13:50:09'),
(83, 3, 24, 4, 1, 0, '2013-02-26 13:50:09'),
(84, 3, 25, 4, 1, 0, '2013-02-26 13:50:09'),
(85, 3, 26, 6, 1, 1, '2013-02-26 13:50:09'),
(86, 3, 27, 4, 1, 1, '2013-02-26 13:50:09'),
(87, 3, 28, 4, 1, 0, '2013-02-26 13:50:09'),
(116, 5, 1, 10, 1, 0, '2013-02-26 13:56:21'),
(117, 5, 2, 9, 1, 0, '2013-02-26 13:56:21'),
(118, 5, 3, 10, 1, 0, '2013-02-26 13:56:21'),
(119, 5, 4, 9, 1, 0, '2013-02-26 13:56:21'),
(120, 5, 5, 10, 1, 0, '2013-02-26 13:56:21'),
(121, 5, 6, 9, 1, 0, '2013-02-26 13:56:21'),
(122, 5, 7, 10, 1, 0, '2013-02-26 13:56:21'),
(123, 5, 8, 9, 1, 0, '2013-02-26 13:56:21'),
(124, 5, 9, 10, 1, 0, '2013-02-26 13:56:21'),
(125, 5, 10, 9, 1, 0, '2013-02-26 13:56:21'),
(126, 5, 11, 10, 1, 0, '2013-02-26 13:56:21'),
(127, 5, 12, 9, 1, 0, '2013-02-26 13:56:21'),
(128, 5, 13, 10, 1, 0, '2013-02-26 13:56:21'),
(129, 5, 14, 9, 1, 0, '2013-02-26 13:56:21'),
(130, 5, 15, 10, 1, 0, '2013-02-26 13:56:21'),
(131, 5, 16, 9, 1, 0, '2013-02-26 13:56:21'),
(132, 5, 17, 10, 1, 0, '2013-02-26 13:56:21'),
(133, 5, 18, 9, 1, 0, '2013-02-26 13:56:21'),
(134, 5, 19, 10, 1, 0, '2013-02-26 13:56:21'),
(135, 5, 20, 9, 1, 0, '2013-02-26 13:56:21'),
(136, 5, 21, 10, 1, 0, '2013-02-26 13:56:21'),
(137, 5, 22, 9, 1, 0, '2013-02-26 13:56:21'),
(138, 5, 23, 10, 1, 0, '2013-02-26 13:56:21'),
(139, 5, 24, 9, 1, 0, '2013-02-26 13:56:21'),
(140, 5, 25, 10, 1, 0, '2013-02-26 13:56:21'),
(141, 5, 26, 9, 1, 1, '2013-02-26 13:56:21'),
(142, 5, 27, 9, 1, 1, '2013-02-26 13:56:21'),
(143, 5, 28, 9, 1, 0, '2013-02-26 13:56:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_fleet_groups`
--

CREATE TABLE IF NOT EXISTS `schedule_fleet_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_id` int(11) DEFAULT NULL,
  `schedule_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `schedule_fleet_groups`
--

INSERT INTO `schedule_fleet_groups` (`id`, `fleet_id`, `schedule_group_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 4, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_groups`
--

CREATE TABLE IF NOT EXISTS `schedule_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group` int(10) DEFAULT NULL,
  `schedule_master_id` int(10) DEFAULT NULL,
  `pool_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `schedule_groups`
--

INSERT INTO `schedule_groups` (`id`, `group`, `schedule_master_id`, `pool_id`) VALUES
(1, 1, 2, 1),
(2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_masters`
--

CREATE TABLE IF NOT EXISTS `schedule_masters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  `bravo_interval` int(10) DEFAULT NULL,
  `charlie_interval` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `schedule_masters`
--

INSERT INTO `schedule_masters` (`id`, `name`, `user_id`, `inserted_date_set`, `bravo_interval`, `charlie_interval`) VALUES
(1, '1:1', 1, '0000-00-00 00:00:00', 1, 1),
(2, '2:1', 1, '0000-00-00 00:00:00', 2, 1),
(3, '3:1', 1, '0000-00-00 00:00:00', 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_master_dates`
--

CREATE TABLE IF NOT EXISTS `schedule_master_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_master_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `fg_bravo_charlie` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `shifts`
--

CREATE TABLE IF NOT EXISTS `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shift` varchar(100) NOT NULL,
  `jam_checkin` time NOT NULL,
  `ci_adjust` int(11) NOT NULL COMMENT 'in minutes',
  `jam_checkout` time NOT NULL,
  `co_adjust` int(11) NOT NULL COMMENT 'in minutes',
  `inserted_date_set` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `shifts`
--

INSERT INTO `shifts` (`id`, `shift`, `jam_checkin`, `ci_adjust`, `jam_checkout`, `co_adjust`, `inserted_date_set`) VALUES
(1, 'Pagi', '02:00:00', 60, '04:00:00', 0, '2012-09-26 00:00:00'),
(2, 'Kalong', '06:00:00', 0, '18:00:00', 0, '2012-09-26 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spareparts`
--

CREATE TABLE IF NOT EXISTS `spareparts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_sparepart` varchar(100) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `part_number` varchar(50) NOT NULL,
  `sp_categories_id` int(11) NOT NULL,
  `base_price` decimal(15,2) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `min_qty` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_part` (`part_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `spareparts`
--

INSERT INTO `spareparts` (`id`, `name_sparepart`, `barcode`, `part_number`, `sp_categories_id`, `base_price`, `price`, `min_qty`, `satuan`, `user_id`, `last_update`) VALUES
(1, 'BUSI', '123', '123', 1, '10000.00', '15000.00', 5, 'pcs', 1, '0000-00-00 00:00:00'),
(2, 'KLAKSON', '124', '124', 1, '10000.00', '150000.00', 5, 'pcs', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sp_categories`
--

CREATE TABLE IF NOT EXISTS `sp_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `sp_categories`
--

INSERT INTO `sp_categories` (`id`, `sp_category`) VALUES
(1, 'EGINE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_perbaikan`
--

CREATE TABLE IF NOT EXISTS `status_perbaikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `status_perbaikan`
--

INSERT INTO `status_perbaikan` (`id`, `status`) VALUES
(1, 'Belum di perbaiki'),
(2, 'Sedang di perbaiki'),
(3, 'Selesai di perbaiki'),
(4, 'Di Tunda'),
(5, 'Batal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `std_baps`
--

CREATE TABLE IF NOT EXISTS `std_baps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_bap` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `std_baps`
--

INSERT INTO `std_baps` (`id`, `std_bap`) VALUES
(1, 'Tidak Memenuhi Standar Penjemputan dan Pengantaran Pelanggan'),
(2, 'Tidak Memenuhi Ketentuan Standar Kerapihan Pengemudi'),
(3, 'Tidak Memenuhi Ketentuan Standar Kelayakkan Armada'),
(4, 'Tidak Memenuhi Kewajiban Setoran'),
(5, 'Tidak Disiplin/Melebihi Waktu Jam Pulang Operasi'),
(6, 'Tidak Sesuai Legalitas Pengemudi Peserta KSO (Bravo/Charlie Paket)'),
(7, 'Tidak Memiliki Charlie Tetap Yang Direalisasikan Dengan Perjanjian Bagi Hasil'),
(8, 'Tidak Disiplin Terhadap Jadwal Operasi Yang Sudah Disepakati'),
(9, 'Tidak Memenuhi Kewajiban Mencicil Hutang Kurang Setor / OPS'),
(10, 'Tidak Memenuhi Kewajiban Mencicil Hutang Spare Part / OPS'),
(11, 'Tidak Tertib Melakukan Jadwal Perawatan Berkala'),
(12, 'Tidak Mengikuti Ketentuan Penggunaan Fasilitas Perusahaan (RC/ARGO)'),
(13, 'Tidak Patuh Mengikuti Pelatihan Pemberdayaan Pengemudi'),
(14, 'Lain-lain');

-- --------------------------------------------------------

--
-- Struktur dari tabel `std_docs`
--

CREATE TABLE IF NOT EXISTS `std_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_doc` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `std_docs`
--

INSERT INTO `std_docs` (`id`, `std_doc`) VALUES
(1, 'STNK'),
(2, 'SIM'),
(3, 'KPP'),
(4, 'Surat Jalan'),
(5, 'KEUR'),
(6, 'TERA'),
(7, 'K/K');

-- --------------------------------------------------------

--
-- Struktur dari tabel `std_equips`
--

CREATE TABLE IF NOT EXISTS `std_equips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_equip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `std_equips`
--

INSERT INTO `std_equips` (`id`, `std_equip`) VALUES
(1, 'Ban Stip'),
(2, 'Kunci Roda'),
(3, 'Radio Calling'),
(4, 'Dongkrak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `std_fleets`
--

CREATE TABLE IF NOT EXISTS `std_fleets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_sparepart` varchar(100) NOT NULL,
  `sp_categories_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=196 ;

--
-- Dumping data untuk tabel `std_fleets`
--

INSERT INTO `std_fleets` (`id`, `name_sparepart`, `sp_categories_id`) VALUES
(1, 'Head Lamp RH', 1),
(2, 'Head Lamp LH', 1),
(3, 'Lamp Sein Spackboard Depan RH', 1),
(4, 'Lamp Sein Spackboard Depan LH', 1),
(5, 'Kaca Depan', 1),
(6, 'Bemper Depan', 1),
(7, 'Lambang Toyota', 1),
(8, 'Grill Depan', 1),
(9, 'Cover Bemper Kanan', 1),
(10, 'Cover Bemper Kiri', 1),
(11, 'Spion Kanan', 1),
(12, 'Spion Kiri', 1),
(13, 'Cover Spion Kanan', 1),
(14, 'Cover Spion Kiri', 1),
(15, 'Wifer Blade', 1),
(16, 'Rambang Wifer', 1),
(17, 'Tabung Air Radiator', 1),
(18, 'Tabung Air Wifer', 1),
(19, 'Talang Air Roda Depan Kanan', 1),
(20, 'Talang Air Roda Depan Kiri', 1),
(21, 'Kunci Pintu Depan Kanan', 1),
(22, 'Kunci Pintu Depan Kiri', 1),
(23, 'Panel Depan', 1),
(24, 'Kap Mesin', 1),
(25, 'Spackboard Depan Kanan', 1),
(26, 'Spackboard Depan Kiri', 1),
(27, 'Dudukan Shock Brekker Depan RH', 1),
(28, 'Dudukan Shock Brekker Depan LH', 1),
(29, 'Tiang Kaca Depan', 1),
(30, 'Deck Depan Kanan', 1),
(31, 'Deck Depan Kiri', 1),
(32, 'Tiang Pintu Depan Kanan', 1),
(33, 'Tiang Pintu Depan Kiri', 1),
(34, 'Casis Depan Kanan', 1),
(36, 'Casis Depan Kiri', 1),
(37, 'Frem Depan Kanan', 1),
(38, 'Frem Depan Kiri', 1),
(39, 'Cross Member Luar', 1),
(40, 'Cross Member Dalam', 1),
(41, 'Dudukan Arem Kanan', 1),
(42, 'Dudukan Arem Kiri', 1),
(43, 'Afron', 1),
(44, 'Ban Depan Kanan', 1),
(45, 'Ban Depan Kiri', 1),
(46, 'Vleg Depan Kanan', 1),
(47, 'Vleg Depan Kiri', 1),
(48, 'Shock Brekker Depan Kanan', 1),
(49, 'Shock Brekker Depan Kiri', 1),
(50, 'Pintu Depan Kanan', 2),
(51, 'Pintu Depan Kiri', 2),
(52, 'Pintu Belakang Kanan', 2),
(53, 'Pintu Belakang Kiri', 2),
(54, 'Kaca Pintu Depan Kanan', 2),
(55, 'Kaca Pintu Depan Kiri', 2),
(56, 'Kaca Pintu Belakang Kanan', 2),
(57, 'Kaca Pintu Belakang Kiri', 2),
(58, 'Kaca Segitiga Pintu Belakang RH', 2),
(59, 'Kaca Segitiga Pintu Belakang LH', 2),
(60, 'Handle Pintu Depan Kanan', 2),
(61, 'Handle Pintu Depan Kiri', 2),
(62, 'Handle Pintu Belakang Kanan', 2),
(63, 'Handle Pintu Belakang Kiri', 2),
(64, 'List Pintu Kaca Depan Kanan', 2),
(65, 'List Pintu Kaca Depan Kiri', 2),
(66, 'List Pintu Kaca Belakang Kanan', 2),
(67, 'List Pintu Kaca Belakang Kiri', 2),
(68, 'Tiang Pintu Kanan', 2),
(69, 'Tiang Pintu Kiri', 2),
(70, 'List Plang Kanan', 2),
(71, 'List Plang Kiri', 2),
(72, 'Kabin', 3),
(73, 'Dudukan List Kabin Kanan', 3),
(74, 'Dudukan List Kabin Kiri', 3),
(75, 'List Talang Air Kanan', 3),
(76, 'List Talang Air Kiri', 3),
(77, 'Karet Talang Air Kanan', 3),
(78, 'Karet Talang Air Kiri', 3),
(79, 'Spion Tengah', 4),
(80, 'Dashboard', 4),
(81, 'Dudukan Dashboard', 4),
(82, 'Speedometer', 4),
(83, 'Laci Depan', 4),
(84, 'Stir', 4),
(85, 'Dudukan Stir', 4),
(86, 'Breket Stir', 4),
(87, 'Pedal Gas', 4),
(88, 'Pedal Kopling', 4),
(89, 'Pedal Rem', 4),
(90, 'Tongkat Perseneling', 4),
(91, 'Plafon', 4),
(92, 'Lamp Plafon Lengkap Bag. Tengah', 4),
(93, 'Lamp Plafon Lengkap Bag. Depan', 4),
(94, 'Ruang Mesin', 4),
(95, 'Ruang Bagasi', 4),
(96, 'Jok Dudukan Depan Kanan', 4),
(97, 'Jok Dudukan Depan Kiri', 4),
(98, 'Jok Dudukan Belakang ', 4),
(99, 'Sandaran Jok Depan RH', 4),
(100, 'Sandaran Jok Depan LH', 4),
(101, 'Sandaran Jok Depan Belakang', 4),
(102, 'Headrash Depan Kanan', 4),
(103, 'Headrash Depan Kiri', 4),
(104, 'Safetybelt Depan Kanan', 4),
(105, 'Safetybelt Depan Kiri', 4),
(106, 'Safetybelt Belakang Kanan', 4),
(107, 'Safetybelt Belakang Kiri', 4),
(108, 'Aksesoris Dashboard Presneling', 4),
(109, 'Handle Pintu Dalam Depan RH', 4),
(110, 'Handle Pintu Dalam Depan LH', 4),
(111, 'Handle Pintu Dalam Belakang RH', 4),
(112, 'Handle Pintu Dalam Belakang LH', 4),
(113, 'Pegangan Tangan Depan RH', 4),
(114, 'Pegangan Tangan Depan LH', 4),
(115, 'Pegangan Tangan Belakang RH', 4),
(116, 'Pegangan Tangan Belakang LH', 4),
(117, 'Penamping Matahari Depan RH', 4),
(118, 'Penamping Matahari Depan LH', 4),
(119, 'Tombol-Tombol AC', 4),
(120, 'Stop Lamp Kanan', 5),
(121, 'Stop Lamp Kiri', 5),
(122, 'Kaca Belakang', 5),
(123, 'Bemper Belakang', 5),
(124, 'Mika Lampu Bemper Belakang RH', 5),
(125, 'Mika Lampu Bemper Belakang LH', 5),
(126, 'Lambang Toyota', 5),
(127, 'Kunci Bagasi', 5),
(128, 'List Bagasi', 5),
(129, 'Tiang Kaca Belakang', 5),
(130, 'Bagasi Dalam', 5),
(131, 'Deck Bagasi', 5),
(132, 'Deck Belakang Kanan', 5),
(133, 'Deck Belakang Kiri', 5),
(134, 'Spack Board Belakang Kanan', 5),
(135, 'Spack Board Belakang Kiri', 5),
(136, 'Dudukan Shock Brekker Belakang RH', 5),
(137, 'Dudukan Shock Brekker Belakang LH', 5),
(138, 'Tiang Pintu Belakang Kanan', 5),
(139, 'Tiang Pintu Belakang Kiri', 5),
(140, 'Casis Belakang Kanan', 5),
(141, 'Casis Belakang Kiri', 5),
(144, 'Velg Belakang Kanan', 5),
(145, 'Velg Belakang Kiri', 5),
(146, 'Ban Belakang Kanan', 5),
(147, 'Ban Belakang Kiri', 5),
(148, 'Shock Brekker Belakang Kanan', 5),
(149, 'Shock Brekker Belakang Kiri', 5),
(150, 'Kunci Roda', 6),
(151, 'Dongkrak', 6),
(152, 'Ban Stip', 6),
(153, 'Velg Ban Stip', 6),
(154, 'Segitiga Pengaman', 6),
(155, 'Karpet Dasar Depan', 6),
(156, 'Karpet Dasar Belakang', 6),
(157, 'Karpet Kotak Depan Kanan', 6),
(158, 'Karpet Kotak Depan Kiri', 6),
(159, 'Karpet Kotak Belakang Kanan', 6),
(160, 'Karpet Kotak Belakang Kiri', 6),
(161, 'Karpet Bagasi', 6),
(162, 'Triplek Bagasi', 6),
(163, 'Kotak Obat P3K', 6),
(164, 'Logo Dian Taxi Pintu Depan RH', 6),
(165, 'Logo Dian Taxi Pintu Depan LH', 6),
(166, 'Lambang Tarif Kaca Depan', 6),
(167, 'Lambang Tarif Kaca Belakang', 6),
(168, 'Nomor Body Pintu Belakang RH', 6),
(169, 'Nomor Body Pintu Belakang LH', 6),
(170, 'Nomor Body di Bagasi Sebelah RH', 6),
(171, 'Nomor Body di Bagasi Sebelah LH ', 6),
(172, 'Nomor Body di Bagasi Sebelah RH', 6),
(173, 'Nomor Telpon di Bagasi Sebelah LH ', 6),
(174, 'Nomor Body Dashboard Depan', 6),
(175, 'Nomor Polisi Depan', 6),
(176, 'Nomor Polisi Belakang', 6),
(177, 'Tempat KPP', 6),
(178, 'Attention Headrase Jok Depan RH', 6),
(179, 'Attention Headrase Jok Depan LH', 6),
(180, 'Lampu Bahaya', 6),
(181, 'Lampu Mahkota', 6),
(182, 'List Lampu Mahkota', 6),
(183, 'Argo', 6),
(184, 'Mic Radio Calling', 6),
(185, 'Antena Radio Calling', 6),
(186, ' Body Luar Armada', 7),
(187, ' Body Dalam Armada', 7),
(188, ' Ruangan Mesin', 7),
(189, ' Ruangan Bagasi', 7),
(190, ' Interior', 7),
(191, ' STNK', 8),
(192, ' Buku KEUR', 8),
(193, ' Buku TERA', 8),
(194, ' Kartu Izin Usaha', 8),
(195, ' Kartu Izin Koperasi', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `std_fleet_categories`
--

CREATE TABLE IF NOT EXISTS `std_fleet_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data untuk tabel `std_fleet_categories`
--

INSERT INTO `std_fleet_categories` (`id`, `sp_category`) VALUES
(1, 'Body Depan'),
(2, 'Body Samping'),
(3, 'Body Atas'),
(4, 'Body Dalam'),
(5, 'Body Belakang'),
(6, 'Perlengkapan'),
(7, 'Kebersihan Armada'),
(8, 'Kelengkapan Surat-Surat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `std_neats`
--

CREATE TABLE IF NOT EXISTS `std_neats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_neat` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `std_neats`
--

INSERT INTO `std_neats` (`id`, `std_neat`) VALUES
(1, 'Rambut'),
(2, 'Seragam batik'),
(3, 'Celana Bahan'),
(4, 'Sepatu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(150) NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fg_active` int(11) NOT NULL,
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `uname`, `pwd`, `user_group_id`, `pool_id`, `email`, `fg_active`, `time_inserted`, `time_modified`, `last_login`, `name`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1, 'ucok@kliksoluti', 1, '2012-08-08 10:44:12', '2012-08-27 07:51:33', '2012-08-08 10:44:12', 'ucok sitompul'),
(2, 'ucok', 'ucok', 4, 1, 'ucok@kliksoluti', 1, '2012-08-08 10:44:21', '2012-08-27 07:51:25', '2012-08-08 10:44:21', 'ucok sitompul'),
(3, 'fakhri', '3a7756839dddf98d75882f60a92febd8', 1, 1, 'lightzone07@gma', 1, '2012-09-18 00:00:00', '2012-09-18 00:00:00', '2012-09-18 00:00:00', 'Fakhri Syafrullah'),
(4, 'kanedi', '51e52d6a66e1f08d2d3f6d2cca21ddd5', 1, 1, 'kanedi@na.co.id', 1, '2012-10-11 08:09:54', '2012-10-11 01:18:04', '2012-10-11 08:09:14', 'Kanedi'),
(5, 'doel', '$2a$08$djBBTkVNaG9LWUdydEdYceKxtn6KDzjZa99Jq0myYVG1jOWg0huBS', 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Abdul Hafidz');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_app`
--

CREATE TABLE IF NOT EXISTS `users_app` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `users_app`
--

INSERT INTO `users_app` (`id`, `username`, `email`, `first_name`, `last_name`, `password`, `last_login`, `active`, `admin`, `pool_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', 'Abdul', 'Anshari', '$2a$08$djBBTkVNaG9LWUdydEdYceKxtn6KDzjZa99Jq0myYVG1jOWg0huBS', '2013-02-27 12:11:05', 1, 1, 1, '2012-09-26 16:11:32', '2013-02-27 12:11:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `user_groups`
--

INSERT INTO `user_groups` (`id`, `user_group`) VALUES
(1, 'Administrator'),
(2, 'Security'),
(3, 'Operation'),
(4, 'Call Center'),
(5, 'Management');

-- --------------------------------------------------------

--
-- Struktur dari tabel `work_orders`
--

CREATE TABLE IF NOT EXISTS `work_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kso_id` int(10) DEFAULT NULL,
  `wo_number` varchar(50) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `km` int(11) NOT NULL,
  `complaint` text NOT NULL,
  `information_complaint` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: belum di perbaiki  2: sedang di perbaiki 3: selesai di perbaiki 4: menunggu',
  `mechanic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inserted_date_set` datetime NOT NULL,
  `finished_date_set` datetime DEFAULT NULL,
  `fg_part_approved` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `work_orders`
--

INSERT INTO `work_orders` (`id`, `kso_id`, `wo_number`, `fleet_id`, `driver_id`, `pool_id`, `km`, `complaint`, `information_complaint`, `status`, `mechanic_id`, `user_id`, `inserted_date_set`, `finished_date_set`, `fg_part_approved`) VALUES
(1, 2, 'DT-00001/WO/2013/02/26', 2, 4, 1, 400, 'Rusak', 'rusak', 2, 0, 1, '2013-02-26 14:00:15', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wo_analisa_item`
--

CREATE TABLE IF NOT EXISTS `wo_analisa_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `wo_id` int(10) DEFAULT NULL,
  `analisa` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `wo_analisa_item`
--

INSERT INTO `wo_analisa_item` (`id`, `wo_id`, `analisa`) VALUES
(1, 1, 'Klakson rusak');

-- --------------------------------------------------------

--
-- Stand-in structure for view `wo_financial_report_bykso`
--
CREATE TABLE IF NOT EXISTS `wo_financial_report_bykso` (
`id` int(11)
,`kso_id` int(10)
,`wo_number` varchar(50)
,`fleet_id` int(11)
,`driver_id` int(11)
,`pool_id` int(11)
,`km` int(11)
,`complaint` text
,`information_complaint` text
,`status` int(11)
,`mechanic_id` int(11)
,`user_id` int(11)
,`inserted_date_set` datetime
,`pemakaian_part` decimal(42,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `wo_financial_report_daily`
--
CREATE TABLE IF NOT EXISTS `wo_financial_report_daily` (
`id` int(11)
,`kso_id` int(10)
,`wo_number` varchar(50)
,`fleet_id` int(11)
,`driver_id` int(11)
,`pool_id` int(11)
,`km` int(11)
,`complaint` text
,`information_complaint` text
,`status` int(11)
,`mechanic_id` int(11)
,`user_id` int(11)
,`inserted_date_set` datetime
,`pemakaian_part` decimal(42,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `wo_financial_report_monthly_bykso`
--
CREATE TABLE IF NOT EXISTS `wo_financial_report_monthly_bykso` (
`id` int(11)
,`kso_id` int(10)
,`wo_number` varchar(50)
,`fleet_id` int(11)
,`driver_id` int(11)
,`pool_id` int(11)
,`km` int(11)
,`complaint` text
,`information_complaint` text
,`status` int(11)
,`mechanic_id` int(11)
,`user_id` int(11)
,`inserted_date_set` datetime
,`monthname` varchar(9)
,`month` int(2)
,`year` int(4)
,`pemakaian_part` decimal(42,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `wo_financial_report_monthly_fleet`
--
CREATE TABLE IF NOT EXISTS `wo_financial_report_monthly_fleet` (
`id` int(11)
,`kso_id` int(10)
,`wo_number` varchar(50)
,`fleet_id` int(11)
,`driver_id` int(11)
,`pool_id` int(11)
,`km` int(11)
,`complaint` text
,`information_complaint` text
,`status` int(11)
,`mechanic_id` int(11)
,`user_id` int(11)
,`inserted_date_set` datetime
,`monthname` varchar(9)
,`month` int(2)
,`year` int(4)
,`pemakaian_part` decimal(42,2)
);
-- --------------------------------------------------------

--
-- Struktur dari tabel `wo_part_items`
--

CREATE TABLE IF NOT EXISTS `wo_part_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wo_id` int(11) DEFAULT NULL,
  `sparepart_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `wo_part_items`
--

INSERT INTO `wo_part_items` (`id`, `wo_id`, `sparepart_id`, `qty`, `price`) VALUES
(1, 1, 2, 1, '150000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `years`
--

CREATE TABLE IF NOT EXISTS `years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `years`
--

INSERT INTO `years` (`id`, `year`) VALUES
(1, 2012),
(2, 2013);

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_bykso`
--
DROP TABLE IF EXISTS `financial_report_bykso`;

CREATE VIEW `financial_report_bykso` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by `cin`.`kso_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_daily`
--
DROP TABLE IF EXISTS `financial_report_daily`;

CREATE VIEW `financial_report_daily` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,max(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,max(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,max(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,max(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,max(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,max(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,max(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,max(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,max(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,max(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,max(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,max(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,max(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,max(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by `cin`.`id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_driver`
--
DROP TABLE IF EXISTS `financial_report_driver`;

CREATE VIEW `financial_report_driver` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`operasi_status_id` AS `operasi_status_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by `cin`.`driver_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_fleet`
--
DROP TABLE IF EXISTS `financial_report_fleet`;

CREATE VIEW `financial_report_fleet` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`operasi_status_id` AS `operasi_status_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by `cin`.`fleet_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_monthly_bykso`
--
DROP TABLE IF EXISTS `financial_report_monthly_bykso`;

CREATE VIEW `financial_report_monthly_bykso` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,monthname(`cin`.`operasi_time`) AS `monthname`,month(`cin`.`operasi_time`) AS `month`,year(`cin`.`operasi_time`) AS `year`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by year(`cin`.`operasi_time`),month(`cin`.`operasi_time`),`cin`.`kso_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_monthly_driver`
--
DROP TABLE IF EXISTS `financial_report_monthly_driver`;

CREATE VIEW `financial_report_monthly_driver` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,monthname(`cin`.`operasi_time`) AS `monthname`,month(`cin`.`operasi_time`) AS `month`,year(`cin`.`operasi_time`) AS `year`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by year(`cin`.`operasi_time`),month(`cin`.`operasi_time`),`cin`.`driver_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_monthly_fleet`
--
DROP TABLE IF EXISTS `financial_report_monthly_fleet`;

CREATE VIEW `financial_report_monthly_fleet` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,monthname(`cin`.`operasi_time`) AS `monthname`,month(`cin`.`operasi_time`) AS `month`,year(`cin`.`operasi_time`) AS `year`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by year(`cin`.`operasi_time`),month(`cin`.`operasi_time`),`cin`.`fleet_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_years_bykso`
--
DROP TABLE IF EXISTS `financial_report_years_bykso`;

CREATE VIEW `financial_report_years_bykso` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,year(`cin`.`operasi_time`) AS `year`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by year(`cin`.`operasi_time`),`cin`.`kso_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_years_driver`
--
DROP TABLE IF EXISTS `financial_report_years_driver`;

CREATE VIEW `financial_report_years_driver` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,year(`cin`.`operasi_time`) AS `year`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by year(`cin`.`operasi_time`),`cin`.`driver_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `financial_report_years_fleet`
--
DROP TABLE IF EXISTS `financial_report_years_fleet`;

CREATE VIEW `financial_report_years_fleet` AS select `cin`.`id` AS `id`,`cin`.`kso_id` AS `kso_id`,`cin`.`fleet_id` AS `fleet_id`,`cin`.`driver_id` AS `driver_id`,`cin`.`checkin_time` AS `checkin_time`,`cin`.`shift_id` AS `shift_id`,`cin`.`km_fleet` AS `km_fleet`,`cin`.`operasi_time` AS `operasi_time`,`cin`.`pool_id` AS `pool_id`,`cin`.`fg_late` AS `fg_late`,`cin`.`checkin_step_id` AS `checkin_step_id`,`cin`.`document_check_user_id` AS `document_check_user_id`,`cin`.`physic_check_user_id` AS `physic_check_user_id`,`cin`.`bengkel_check_user_id` AS `bengkel_check_user_id`,`cin`.`finance_check_user_id` AS `finance_check_user_id`,`cf`.`checkin_id` AS `checkin_id`,year(`cin`.`operasi_time`) AS `year`,sum(if((`cf`.`financial_type_id` = 1),`cf`.`amount`,0)) AS `setoran_wajib`,sum(if((`cf`.`financial_type_id` = 2),`cf`.`amount`,0)) AS `tabungan_sparepart`,sum(if((`cf`.`financial_type_id` = 3),`cf`.`amount`,0)) AS `denda`,sum(if((`cf`.`financial_type_id` = 4),`cf`.`amount`,0)) AS `potongan`,sum(if((`cf`.`financial_type_id` = 5),`cf`.`amount`,0)) AS `cicilan_sparepart`,sum(if((`cf`.`financial_type_id` = 6),`cf`.`amount`,0)) AS `cicilan_ks`,sum(if((`cf`.`financial_type_id` = 7),`cf`.`amount`,0)) AS `biaya_cuci`,sum(if((`cf`.`financial_type_id` = 8),`cf`.`amount`,0)) AS `iuran_laka`,sum(if((`cf`.`financial_type_id` = 9),`cf`.`amount`,0)) AS `cicilan_dp_kso`,sum(if((`cf`.`financial_type_id` = 10),`cf`.`amount`,0)) AS `cicilan_hutang_lama`,sum(if((`cf`.`financial_type_id` = 11),`cf`.`amount`,0)) AS `ks`,sum(if((`cf`.`financial_type_id` = 12),`cf`.`amount`,0)) AS `cicilan_lain`,sum(if((`cf`.`financial_type_id` = 13),`cf`.`amount`,0)) AS `hutang_dp_sparepart`,sum(if((`cf`.`financial_type_id` = 20),`cf`.`amount`,0)) AS `setoran_cash` from (`checkins` `cin` left join `checkin_financials` `cf` on((`cin`.`id` = `cf`.`checkin_id`))) group by year(`cin`.`operasi_time`),`cin`.`fleet_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `wo_financial_report_bykso`
--
DROP TABLE IF EXISTS `wo_financial_report_bykso`;

CREATE VIEW `wo_financial_report_bykso` AS select `wo`.`id` AS `id`,`wo`.`kso_id` AS `kso_id`,`wo`.`wo_number` AS `wo_number`,`wo`.`fleet_id` AS `fleet_id`,`wo`.`driver_id` AS `driver_id`,`wo`.`pool_id` AS `pool_id`,`wo`.`km` AS `km`,`wo`.`complaint` AS `complaint`,`wo`.`information_complaint` AS `information_complaint`,`wo`.`status` AS `status`,`wo`.`mechanic_id` AS `mechanic_id`,`wo`.`user_id` AS `user_id`,`wo`.`inserted_date_set` AS `inserted_date_set`,sum((`part`.`qty` * `part`.`price`)) AS `pemakaian_part` from (`work_orders` `wo` left join `wo_part_items` `part` on((`wo`.`id` = `part`.`wo_id`))) where (`wo`.`status` = 3) group by `wo`.`kso_id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `wo_financial_report_daily`
--
DROP TABLE IF EXISTS `wo_financial_report_daily`;

CREATE VIEW `wo_financial_report_daily` AS select `wo`.`id` AS `id`,`wo`.`kso_id` AS `kso_id`,`wo`.`wo_number` AS `wo_number`,`wo`.`fleet_id` AS `fleet_id`,`wo`.`driver_id` AS `driver_id`,`wo`.`pool_id` AS `pool_id`,`wo`.`km` AS `km`,`wo`.`complaint` AS `complaint`,`wo`.`information_complaint` AS `information_complaint`,`wo`.`status` AS `status`,`wo`.`mechanic_id` AS `mechanic_id`,`wo`.`user_id` AS `user_id`,`wo`.`inserted_date_set` AS `inserted_date_set`,sum((`part`.`qty` * `part`.`price`)) AS `pemakaian_part` from (`work_orders` `wo` left join `wo_part_items` `part` on((`wo`.`id` = `part`.`wo_id`))) where (`wo`.`status` = 3) group by `wo`.`id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `wo_financial_report_monthly_bykso`
--
DROP TABLE IF EXISTS `wo_financial_report_monthly_bykso`;

CREATE VIEW `wo_financial_report_monthly_bykso` AS select `wo`.`id` AS `id`,`wo`.`kso_id` AS `kso_id`,`wo`.`wo_number` AS `wo_number`,`wo`.`fleet_id` AS `fleet_id`,`wo`.`driver_id` AS `driver_id`,`wo`.`pool_id` AS `pool_id`,`wo`.`km` AS `km`,`wo`.`complaint` AS `complaint`,`wo`.`information_complaint` AS `information_complaint`,`wo`.`status` AS `status`,`wo`.`mechanic_id` AS `mechanic_id`,`wo`.`user_id` AS `user_id`,`wo`.`inserted_date_set` AS `inserted_date_set`,monthname(`wo`.`inserted_date_set`) AS `monthname`,month(`wo`.`inserted_date_set`) AS `month`,year(`wo`.`inserted_date_set`) AS `year`,sum((`part`.`qty` * `part`.`price`)) AS `pemakaian_part` from (`work_orders` `wo` left join `wo_part_items` `part` on((`wo`.`id` = `part`.`wo_id`))) where (`wo`.`status` = 3) group by month(`wo`.`inserted_date_set`),`wo`.`kso_id`,`wo`.`id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `wo_financial_report_monthly_fleet`
--
DROP TABLE IF EXISTS `wo_financial_report_monthly_fleet`;

CREATE VIEW `wo_financial_report_monthly_fleet` AS select `wo`.`id` AS `id`,`wo`.`kso_id` AS `kso_id`,`wo`.`wo_number` AS `wo_number`,`wo`.`fleet_id` AS `fleet_id`,`wo`.`driver_id` AS `driver_id`,`wo`.`pool_id` AS `pool_id`,`wo`.`km` AS `km`,`wo`.`complaint` AS `complaint`,`wo`.`information_complaint` AS `information_complaint`,`wo`.`status` AS `status`,`wo`.`mechanic_id` AS `mechanic_id`,`wo`.`user_id` AS `user_id`,`wo`.`inserted_date_set` AS `inserted_date_set`,monthname(`wo`.`inserted_date_set`) AS `monthname`,month(`wo`.`inserted_date_set`) AS `month`,year(`wo`.`inserted_date_set`) AS `year`,sum((`part`.`qty` * `part`.`price`)) AS `pemakaian_part` from (`work_orders` `wo` left join `wo_part_items` `part` on((`wo`.`id` = `part`.`wo_id`))) where (`wo`.`status` = 3) group by month(`wo`.`inserted_date_set`),`wo`.`fleet_id`,`wo`.`id`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
