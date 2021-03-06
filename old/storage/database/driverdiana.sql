-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-05-05 10:13:28
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table diantaksi.drivers
DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `ktp` varchar(100) NOT NULL,
  `sim` varchar(100) NOT NULL,
  `brith_place` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(250) NOT NULL,
  `kelurahan` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `join_date` date NOT NULL,
  `driver_status` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `pool_id` int(11) NOT NULL,
  `fg_blocked` int(11) NOT NULL,
  `fg_super_blocked` int(11) NOT NULL DEFAULT '0',
  `fg_laka` int(11) NOT NULL DEFAULT '0',
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nip` (`nip`)
) ENGINE=MyISAM AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

-- Dumping data for table diantaksi.drivers: 0 rows
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;
INSERT INTO `drivers` (`id`, `name`, `nip`, `ktp`, `sim`, `brith_place`, `date_of_birth`, `address`, `kelurahan`, `kecamatan`, `kota`, `city_id`, `phone`, `join_date`, `driver_status`, `photo`, `pool_id`, `fg_blocked`, `fg_super_blocked`, `fg_laka`, `time_inserted`, `time_modified`) VALUES
	(34, 'MOH. IDRIS', 'DA-0057', '09.5006.22167.0303', '-', 'JAKARTA', '1967-12-22', 'JL MENTENG SUKABUMI RT GG 1 RT08/03 NO.19', 'MENTENG', 'MENTENG', 'JAKARTA PUSAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(35, 'JEKSON SITEPU', 'DA-003 B2', '3173080708700003', '-', 'MEDAN', '1970-07-08', 'JL. KARYA SARI RT. 004/003 SRENGSENG', 'SRENGSENG', 'KEMBANGAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(36, 'AZWAR', 'DA-0004 B', '09,5401,100855,0109', '-', 'PADANG', '1955-10-08', 'KEBON SEREH BARAT RT 002/09', 'PISANGAN BARU', 'MATRAMAN', 'JAKARTA TIMUR', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(37, 'MOH. RONI', 'DA 0005 C', '09,5208,270264,0210', '-', 'JAKARTA', '1964-02-27', 'JL. MERUYA ILIR NO. 14 RT 018/04', 'MERUYA UTARA', 'KEMBANGAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(38, 'SAIDUN', 'DA-0006-B2', '3174101203630005', '-', 'BLORA', '1963-03-12', 'KAMPUNG BARU VII RT 009/002', 'ULUJAMI', 'PESANGGRAHAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(39, 'AKHMAD BADORUDIN', 'DA-0008 B', '09.5403.040572.0783', '-', 'JAKARTA', '1972-05-04', 'KP. LIO  RT.006/03', 'JATINEGARA', 'CAKUNG', 'JAKARTA TIMUR', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(40, 'JOHAN COSMOS GRODA', 'DA-007', '3671112401790006', '-', 'JAKARTA', '1979-01-24', 'JL KEPONDANG BLOK A 16/18 RT 009/007', 'KUNCIRAN INDAH', 'PINANG', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(41, 'RICHWANTO', 'DA-0011 B', '3603242602710001', '-', 'JAKARTA', '1971-02-26', 'KP. LIO RT 002/003 NO. 66', 'PARIGI', 'PONDOK AREN', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(42, 'MU ALIM', 'DA-0023 B', '09,5204,010364,0642', '-', 'DEMAK ', '1954-01-03', 'JL. KALI ANYAR IX RT 014/01 NO. 29', 'KALI ANYAR', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(43, 'UU ANWAR BIN AYU', 'DA-0029 B', '0951022610720447', '-', 'SERANG', '1972-10-26', 'JL. KAPUK MUARA Gg. EMPANG LAPANGAN RT 010/04 NO. 499', 'PEJAGALAN', 'PENJARINGAN', 'JAKARTA UTARA', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(44, 'DARYANTO', 'DA-0030 B', '09,5305,290966,0348', '-', 'PEMALANG', '1966-09-29', 'JL. KERTAJAYA I RT 0016/014 NO.22', 'PENJARINGAN', 'PENJARINGAN', 'JAKARTA UTARA', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(45, 'SUMARDI', 'DA-0041 B', '09,5205010266,0595', '-', 'INDRAMAYU', '1966-02-01', 'JL. KEPA DURI RAYA RT 007/03 NO. 14', 'DURI KEPA', 'KEBON JERUK', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(46, 'PAINO', 'DA-0043 B', '09,5204,161082,0264', '-', 'JAKARTA', '1982-10-16', 'JL. KRENDANG SELATAN RT 03/06 NO.14', 'KRENDANG', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(47, 'S. AHMAD B SALIM', 'DA-0056', '09.5308.030543.0051', '-', 'JAKARTA ', '1973-03-05', 'PENGADEGAN TIMUR RT 002/002', 'PENGADEGAN', 'PANCORAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(48, 'MANSUR', 'DA-0047', '09.5208.070971.0449', '-', 'LAMPUNG ', '1971-07-09', 'KAV DKI  BLOK 42/30 RT 002/010', 'MERUYA UTARA', 'KEMBANGAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(49, 'MAFTUHIN', 'DA-0059', '09.5003.131265.0420', '-', 'TEGAL ', '1965-12-13', 'JL KRAMAT IV UJUNG RT 013/006', 'KWITANG', 'SENEN', 'JAKARTA  PUSAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(50, 'NARAH', 'DA 0050 B', '09,5402,020968,0339', '-', 'SERANG', '1968-02-09', 'KAMPUNG BARU RT 006/07', 'KAYU PUTIH', 'PULOGADUNG', 'JAKARTA TIMUR', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(51, 'SUCIPTO', 'DA-0185', '09.5304.140459.0293', '-', 'JAKARTA', '1959-04-14', 'KEBAGUSAN BESAR RT 004/006', 'KEBAGUSAN', 'PASAR MINGGU', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(52, 'AHMAD SAITA', 'DA-0119', '3275102516500007', '-', 'JAKARTA', '1965-01-23', 'KRAGGANKULON RT 002/008', 'JATIRADEN', 'JATISAMPURNA', 'BEKASI', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(53, 'JUMADI', 'DA-0064 B', '09,5308,100973,0601', '-', 'MAGELANG', '1973-10-09', 'JL. AL FALAH RT 013/01 NO.37', 'MAMPANG PRAPATAN', 'MAMPANG PRAPATAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(54, 'ZAINIK', 'DA-0067 B', '09,5007,041057,2008', '-', 'PADANG', '1957-04-10', 'JL. PETAMBURAN II RT 011/03 NO. 17', 'PETAMBURAN', 'TANAH ABANG', 'JAKARTA PUSAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(55, 'GERSON SINAGA', 'DA-0078', '09.5205.100361.5502', '-', 'TAPANULI', '1961-10-03', 'KAMPUNG RAWA 8 RT 001/005', 'KEBON JERUK', 'KEBON JERUK', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(56, 'AHMAD ROHANI', 'DA-0069 B', '09,5303,131064,0246', '-', 'KENDAL, ', '1964-10-13', 'JL. H. ALI RT 002/07 NO. 38', 'TEGAL PARANG', 'MAMPANG PRAPATAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(57, 'SUBUR JAYA', 'DA-0070 B', '09,5207,070570,0653', '-', 'JAKARTA', '1970-05-07', 'JL. SUMUR BOR RT 006/012', 'KALIDERES', 'KALIDERES', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(58, 'SAKUR MATSARIP', 'DA-0081 B', '09.5204.140365.0222', '-', 'DEMAK', '1965-03-14', 'JL. KALI ANYAR - II  RT. 013/01', 'KALI ANYAR', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(59, 'AGUS RIZAL M', 'DA-0082 B', '09,5309,210868,7014', '-', 'PADANG', '1968-08-21', 'JL. JOE KEBAGUSAN RT 007/04 NO.14', 'KEBAGUSAN', 'PASAR MINGGU', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(60, 'SUTARJO', 'DA-0084 B2', '3671121010660006', '-', 'JAKARTA', '1966-10-10', 'JL KARYAWAN I /78 RT 003/005', 'KARANG TENGAH', 'KARANG TENGAH', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(61, 'MUKSIN', 'DA-0086 B', '09.5208.150762.0758', '-', 'JAKARTA', '1962-07-15', 'KAMP. SALO  RT. 007/04  NO. 46', 'KEMBANGAN UTARA', 'KEMBANGAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(62, 'FERIYADI', 'DA-0087-B2', ' 3674064710790006', '-', 'SUKABUMI', '1979-07-10', 'JL DR. SETIA BUDI RT 001/008', 'PAMULANG TIMUR', 'PAMULANG', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(63, 'KARSIM', 'DA-088', '09.5107.040782.0224', '-', 'PEMALANG', '1982-04-07', 'KMP MUKA RT 004/004', 'ANCOL', 'PADEMANGAN', 'JAKARTA UTARA', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(64, 'LOSMEN LUBIS', 'DA-0103 B', '3219052007,1591574', '-', 'TAPANULI UTARA', '1962-02-19', 'KP. BUARAN RT 003/07 NO.33', 'BUARAN', 'SERPONG', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(65, 'AMAR', 'DA-0073 C1', '3671092709600001', '-', 'JAKARTA', '1960-09-27', 'JL. RUSA  VI  NO22  RT.004/09', 'CIBODAS BARU', 'CIBODAS', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(66, 'ABD. MUHEMIN', 'DA-0300', '3173041305710006', '-', 'JAKARTA', '1971-05-13', 'TANAH SEREAL RT 005/01', 'TANAH SEREAL', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(67, 'LEGIONO WAHYU RAMADHANI', 'DA-8559', '3173071502800004', '-', 'BANJARNEGARA', '1980-02-15', 'JLN WIJAYA I PCK RT 012/005', 'PETOGOGAN', 'KABAYORAN BARU', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(68, 'YAKUB GINTING', 'DA-0110 B', '09,5309,010868,0606', '-', 'ACEH', '1968-08-01', 'JL. JOE Gg. H AMAT NO. 77 RT 001/06', 'LENTENG AGUNG', 'JAGAKARSA', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(69, 'M. FAUZI H.M', 'DA-0121', '3671112809630001', '-', 'JAKARTA,', '1963-09-28', 'JL. TAMBORA  III  K-39.A/10  RT. 004/02', 'KINCIRAN MAS', 'PINANG', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(70, 'MOCH SOLEHUDIN', 'DA-0123 B1', '3172010502610009', '-', 'KUNINGAN', '1961-05-02', 'JLN. TANJUNG WANGI RT 003/012', 'PENJARINGAN', 'PENJARINGAN', 'JAKARTA UTARA', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(71, 'KARYOTO', 'DA-0127', '09,5303,021169,1015', '-', 'BEKASI', '1969-11-02', 'JL. BANGKA XI  RT.006/010', 'PELA MAMPANG', 'MAMPANG PRAPATAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(72, 'SOLEH', 'DA-0128 B', '095405,050673,8563', '-', 'PEMALANG', '1973-05-06', 'KP. TENGAH GG. MUNDU RT 003/04 NO.17 B', 'KP. TENGAH', 'KRAMAT JATI', 'JAKARTA TIMUR', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(73, 'SYAHRUL', 'DA-0129 B', '3671130801500001', '-', 'PADANG', '1950-01-08', 'JL. H. NAJIH RT 009/01 NO.37', 'PETUKANGAN UTARA', 'PESANGGRAHAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(74, 'TARIM', 'DA-0132', '09.5204.091067.0501', '-', 'TEGAL', '1967-09-10', 'JL. TERATE III RT 014/004', 'JEMBATAN LIMA', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(75, 'ICHWANI', 'DA-0017', '09.5205.260467.0394', '-', 'INDRAMAYU', '1967-04-26', 'GUJI BARU RT 004/002', 'DURI KEPA', 'KEBON JERUK', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(76, 'HERMAN SUSILO', 'DA-0148 B', '09,5310,200457,0260', '-', 'PADANG ', '1957-04-20', 'JL. H. ILYAS RT 004/010 NO. 2B', 'PETUKANGAN UTARA', 'PESANGGRAHAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(77, 'MUHTAR', 'DA-0185', '3174103108550001', '-', 'JAKARTA', '1955-07-01', 'JLN. H. NAJIH RT 008/001', 'PETUKANGAN UTARA', 'PESANGGRAHAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(78, 'CHAIRUDDIN HARAHAP', 'DA-0171', '3671121005570002', '-', 'MEDAN ', '1957-10-05', 'JLN. CEREMAI IV/17 RT 07/06', 'KARANG TENGAH', 'KARANG TENGAH', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(79, 'MOHAMAD KORIM', 'DA-0163-C4', '3172050511711001', '-', 'PEMALANG ', '1971-05-11', 'JL MANGGA DUA RT VIII RT 013/005', 'ANCOL', 'PADEMANGAN', 'JAKARTA UTARA', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(80, 'BUDI SETIONO', 'DA-0031', '3603061909680001', '-', 'MADIUN ', '1968-09-19', 'PERUM GRIYA ISLAM BLOK SU NO. 04 RT 016/006', 'KRESEK', 'KRESEK', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(81, 'BAMBANG SUMARYANTO', 'DA-0165', '3671121003710002', '-', 'SEMARANG ', '1971-10-03', 'KP PEDURENAN RT 08/02', 'PEDURENAN', 'KARANG TENGAH', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(82, 'SUWONO', 'DA-0181 B', '09.5205.030477.0568', '-', 'LAMPUNG ', '1977-03-04', 'JL. SRENGSENG RAYA RT. 002/04', 'SRENGSENG', 'KEMBANGAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(83, 'RASEJO', 'DA-0184 B2', '09.5107.150664.0785', '-', 'PEMALANG ', '1964-06-15', 'KP MUKA RT 009/004', 'ANCOL', 'PADEMANGAN', 'JAKARTA UTARA', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(84, 'SYAMSUDIN', 'DA-0185', '3171060508730003', '-', 'JAKARTA', '1973-08-05', 'JLN MATRAMAN JAYA RT 006/004', 'PEGANGSAAN', 'MENTENG', 'JAKARTA PUSAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(85, 'IWAN SETIAWAN', 'DA-0186 B', '09.5204.290378.0347', '-', 'JAKARTA ', '1978-03-29', 'KP. DURI DALAM GG. GRINDO VI NO.9  RT.008/05', 'DURI DALAM', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(86, 'MARTINUS M. NGADIWIDJAJA', 'DA-0017', '3328152910730009', '-', 'JAKARTA ', '1973-10-26', 'TANJUNG HARJA RT 003/001', 'TANJUNGHARJA', 'KRAMAT', 'TEGAL', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(87, 'H. BEBEN SUBANDI MOHAMAD', 'DA-0188 B', '3201280503570001', '-', 'BOGOR, ', '1957-05-03', 'KP. CIJERUK RT 003/02', 'PALASARI', 'CIJERUK', 'BOGOR', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(88, 'HADI SUWITO', 'DA-0204 B', '3175030509620009', '-', 'BANJENGAN', '1962-09-05', 'JOGLO RT 003/006', 'JOGLO', 'KEMBANGAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(89, 'NUR ANWAR', 'DA-0210', '3219052021.1748498', '-', 'JAKARTA', '1982-05-03', 'KP. KAMURANG BAWAH RT01/02', 'PAKU ALAM', 'SERPONG', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(90, 'ARIF WAHYUDIN', 'DA-0208', '3671011110760007', '-', 'MALANG, ', '1976-11-10', 'JLN. IRMAS RT 01/10', 'CIKOKOL', 'TANGERANG', 'TANGERANG ', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(91, 'BOHIR', 'DA-0210B1', '3174102404570002', '-', 'SUKABUMI ', '1957-04-24', 'KP BINTARO RT 007/001', 'PESANGGRAHAN', 'PESANGGRAHAN', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(92, 'ZAINUDIN', 'DA-0222', '09.5206.301162.0477', '-', 'JAKARTA ', '1962-11-30', 'JATI PULO RT 004/008', 'JATI PULO', '', '', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(93, 'EDING SUSWANTORO', 'DA-0049', '3671020402750006', '-', 'BREBES ', '1975-04-02', 'KP CIKONENG GIRANG RT 001/002', 'MANIS JAYA', 'JATIUWUNG', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(94, 'ARPENPEMI', 'DA-0241', '09.5207.201259.0855', '-', 'AGAM ', '1959-12-20', 'JL PERMATA RT005/015', 'TEGAL ALUR', 'KALIDERES', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(95, 'YUSUP', 'DA-0032', '3173081403650007', '-', 'CILACAP ', '1965-03-14', 'JOGLO, RT 007/008', 'JOGLO', 'KEMBANGAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(96, 'SIHAR SIMANJUNTAK', 'DA-0244 B1', '09.5301.240657.0149', '-', 'MEDAN ', '1957-06-24', 'JLN. MENTENG DALAM RT 005/09', 'MENTENG DALAM', 'TEBET', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(97, 'LAYAS BR GINTING', 'DA-0247', '09.5402-09668.8526', '-', 'JAKARTA', '1968-06-09', 'KP. TANAH KOJA RT 003/03', 'JATINEGARA KAUM', 'PULOGADUNG', 'JAKARTA TIMUR', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(98, 'WARUN', 'DA-0248', '3171022202720006', '-', 'CILACAP', '1972-02-22', 'JLN MANGGA BESAR XIII RT 004/005', 'MANGGA DUA SELATAN', 'SAWAH BESAR', 'JAKARTA PUSAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(99, 'SUKARTA', 'DA-0238', '3171070501690011', '-', 'CIREBON ', '1969-05-01', 'JLN PEJOMPONGAN RT 012/007', 'BENDUNGAN HILIR', 'TANAH ABANG', 'JAKARTA PUSAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(100, 'MUHADI LATIF', 'DA-0266', '09.5410.250354.0267', '-', 'KEDIRI, ', '1954-03-25', 'JLN. ADIL RT 004/002', 'SUSUKAN', 'CIRACAS', 'JAKARTA TIMUR', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(101, 'IDIE CHARSIDI', 'DA-0270', '09.5206.200568.0420', '-', 'INDRAMAYU', '1968-05-20', 'JLN ANGKE JAYA I/6 RT 001/006', 'ANGKE', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(102, 'SYAHRIAL', 'DA-0292', '09.5202.251259.0804', '-', 'JAKARTA ', '1959-12-25', 'TANJUNG GEDONG RT 0020/016', 'TOMANG', 'GROGOL PETAMBURAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(103, 'JAKRUDIN', 'DA-0301', '09.5204.090581.0300', '-', 'SUBANG ', '1981-09-05', 'JL. ANGKE INDAH NO. 264 RT 011/002', 'ANGKE', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(104, 'LARSON SAMOSIR ', 'DA-0302', '3275010804740011', '-', 'MEDAN,', '1974-04-08', 'JL. MANDIRI RAYA RT 002/002', 'AREN JAYA', 'BEKASI TIMUR', 'BEKASI', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(105, 'M.R. AGUSTI', 'DA-0303', '09.5204.1808887.0150', '-', 'BREBES, ', '1969-08-18', 'JLN KALI ANYAR X RT 007/006', 'KALI ANYAR', 'TAMBORA', 'JAKARTA PUSAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(106, 'BUDI SARJONO', 'DA-0307', '3173050411560002', '-', 'PURWOKERTO ', '1956-04-11', 'JLN. KEDOYA RAYA GG RUKUN RT 03/007', 'KEDOYA UTARA', 'KEBON JERUK ', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(107, 'IMRON', 'DA-0308', '3173051105590002', '-', 'SUBANG', '1959-05-11', 'KEDOYA RT 009/002', 'KEDOYA SELATAN', 'KEBON JERUK ', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(108, 'LEGIANTO', 'DA-0309', '09.5204-190565.0333', '-', 'PEKALONGAN ', '1965-05-19', 'JLN. DURI BARU RT 009/005', 'JEMBATAN BESI', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(109, 'RIJALUDIN  HARAHAP', 'DA-0310', '3603312811740001', '-', 'JAKARTA ', '1974-11-28', 'TAMAN ADIYASA BLOK J 25/15 RT 005/005', 'CIKUYA', 'SOLEAR', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(110, 'RD. ROBY NUR SULAIMAN', 'D-8556', '317.307.140776.0004', '-', 'JAKARTA', '1976-07-14', 'KEMANGGISAN PULO II RT 002/009', 'PALMERAH', 'PALMERAH', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(111, 'WASJAN', 'DA-0322', '3208210205590002', '-', 'KUNINGAN', '1959-02-05', 'DUSUN II RT 009/004', 'CIMARANTEN', 'CIPICUNG', 'KUNINGAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(112, 'KASTONO', 'DA-330', '3671043006670001', '-', 'PEKALONGAN ', '1967-06-30', 'KP RAWA BOKOR RT 001/004', 'BENDA', 'BENDA', 'TANGERANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(113, 'SYAIFUL', 'DA-0341', '3174040708530004', '-', 'BUKIT TINGGI', '1953-07-08', 'KEBAGUSAN KECIL RT 001/001 ', 'LENTENG AGUNG', 'JAGAKARSA', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(114, 'DARNO', 'DA-1282', '3173040904580010', '-', 'JAKARTA', '1958-09-04', 'JL DURI PULO I RT 006/002', 'DURI PULO', 'GAMBIR', 'JAKARTA PUSAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(115, 'SUDARSO BIN RASTAM', 'DA-0356', '0815.01534.140003', '-', 'BREBES', '1950-12-10', 'JSGSLEMPENI RT 01/01', 'JAGALEMPENI', 'WANASARI', 'BREBES', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(116, 'AHMAD NUH', 'DA-0349', '09.5306.011172.0231', '-', 'JAKARTA', '1972-11-01', 'PASAR JUMAT RT 009/002', 'LEBAK BULUS', 'CILANDAK', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(117, 'BEJO', 'DA-0077', '09.5208.06286.5515', '-', 'BANDAR LAMPUNG', '1980-06-12', 'JL. LAPANGAN BOLA NO II RT 008/001', 'SRENGSENG', 'KEMBANGAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(118, 'YUDI', 'DA-0387', '09.5202.150773.0778', '-', 'INDRAMAYU', '1973-07-15', 'JL INDRALOKA I/103 RT 008/010', 'WIJAYA KUSUMA', 'GROGOL PETAMBURAN', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(119, 'DASLIM', 'DA-0485', '3172011208761003', '-', 'PEMALANG', '1976-12-08', 'JL LUAR BATANG RT 009/001 ', 'PENJARINGAN', 'PENJARINGAN', 'JAKARTA UTARA', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(120, 'YUNUS GONO', 'DA-0490', '317507.240975.0001', '-', 'JAKARTA', '1975-09-24', 'JLN. H. AHMAD R RT 002/004', 'PONDOK BAMBU', 'DUREN SAWIT', 'JAKARTA TIMUR', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(121, 'SAKUB  BIN CASMUN', 'DA-0501', '3329121008730005', '-', 'BREBES', '1973-10-08', 'KALIBUNTU RT 001/004', 'KALIBUNTU', 'LOSARI', 'BREBER', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(122, 'RAZI', 'DA-0051', '09.5204.2612561.0507', '-', 'INDRAMAYU', '1961-12-26', 'JL. ANGKE INDAH RT 003/002', 'ANGKE', 'TAMBORA', 'JAKARTA BARAT', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(123, 'CASSIA VERA MALAYS', 'DA-0251', '3174015006730017', '-', 'JAKARTA', '1973-06-10', 'TEBET DALAM II NO. 14 RT 006/001', 'TEBET BARAT', 'TEBET', 'JAKARTA SELATAN', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(124, 'RIANTO', 'DA-0558', '09.5403.031279.0266', '-', 'PEMALANG', '1979-03-12', 'JL PADEMANGAN UTARA GG AMBALAT RT 014/012 NO. 90', 'PADEMANGAN', 'PADEMANGAN', 'JAKARTA UTARA', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(125, 'MOHAMAD KUSWORO', 'DA-0549', '3327102006810041', '-', 'PEMALANG', '1981-06-20', 'JLN MADUKORO DESA KLAREAN RT 003/002', 'KLAREYAN', 'PETARUKAN', 'PEMALANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(126, 'HADI SUPRIYONO', 'DA-0545', '3327701203850007', '-', 'PEMALANG', '1985-12-03', 'DUSUN KEDEMUNGAN RT 002/002', 'LONING', 'PETARUKAN', 'PEMALANG', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(127, 'KURDI', 'DA-0105-B1', '3329092101820005', '-', 'BREBES', '1982-01-21', 'JLN HASANUDIN NO.8 RT 001/007', 'GANDASULI', 'BREBES', 'BREBES', 1, '', '0000-00-00', 0, '', 1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
