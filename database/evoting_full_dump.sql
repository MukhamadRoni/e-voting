-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_evoting
-- ------------------------------------------------------
-- Server version	5.5.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','0192023a7bbd73250516f069df18b500');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hasil`
--

DROP TABLE IF EXISTS `hasil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hasil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pemilih_nik` varchar(20) NOT NULL,
  `ketua_nik` varchar(20) NOT NULL,
  `pengawas_nik` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_hasil_pemilih` (`pemilih_nik`),
  KEY `fk_hasil_ketua` (`ketua_nik`),
  KEY `fk_hasil_pengawas` (`pengawas_nik`),
  CONSTRAINT `fk_hasil_pemilih` FOREIGN KEY (`pemilih_nik`) REFERENCES `pemilih` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_hasil_ketua` FOREIGN KEY (`ketua_nik`) REFERENCES `kandidat_ketua` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_hasil_pengawas` FOREIGN KEY (`pengawas_nik`) REFERENCES `kandidat_pengawas` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hasil`
--

LOCK TABLES `hasil` WRITE;
/*!40000 ALTER TABLE `hasil` DISABLE KEYS */;
INSERT INTO `hasil` VALUES (1,'10001','3201011001','3201022001','2026-09-26 01:15:22'),(2,'10002','3201011002','3201022002','2026-09-26 01:24:10'),(3,'10003','3201011001','3201022001','2026-09-26 01:35:45'),(4,'10004','3201011001','3201022002','2026-09-26 01:48:19'),(5,'10005','3201011003','3201022003','2026-09-26 02:02:50'),(6,'10006','3201011001','3201022001','2026-09-26 02:14:12'),(7,'10007','3201011002','3201022002','2026-09-26 02:28:33'),(8,'10008','3201011001','3201022001','2026-09-26 02:41:05'),(9,'10009','3201011003','3201022001','2026-09-26 03:05:40'),(10,'10010','3201011002','3201022002','2026-09-26 03:20:15'),(11,'10011','3201011001','3201022001','2026-09-26 03:45:28'),(12,'10012','3201011001','3201022003','2026-09-26 04:10:04'),(13,'10013','3201011002','3201022001','2026-09-26 04:32:18'),(14,'10014','3201011001','3201022001','2026-09-26 06:15:52'),(15,'10015','3201011001','3201022002','2026-09-26 06:40:22'),(16,'10016','3201011002','3201022002','2026-09-26 07:05:11'),(17,'10017','3201011003','3201022003','2026-09-26 07:30:45'),(18,'10018','3201011001','3201022001','2026-09-26 08:02:30'),(19,'10019','3201011002','3201022002','2026-09-26 13:16:46'),(20,'10025','3201011002','3201022001','2026-09-26 13:17:47'),(21,'10024','3201011003','3201022001','2026-09-26 13:26:49'),(22,'10020','3201011002','3201022005','2026-09-26 14:14:54'),(23,'10021','3201011006','3201022004','2026-09-26 14:14:54'),(24,'10022','3201011003','3201022005','2026-09-26 14:14:54'),(25,'10023','3201011005','3201022005','2026-09-26 14:14:54'),(26,'10026','3201011001','3201022004','2026-09-26 14:14:54'),(27,'10027','3201011003','3201022002','2026-09-26 14:14:54'),(28,'10028','3201011001','3201022003','2026-09-26 14:14:54'),(29,'10031','3201011002','3201022005','2026-09-26 14:14:54'),(30,'10032','3201011003','3201022002','2026-09-26 14:14:54'),(31,'10033','3201011003','3201022005','2026-09-26 14:14:54'),(32,'10034','3201011003','3201022003','2026-09-26 14:14:54'),(33,'10035','3201011003','3201022002','2026-09-26 14:14:54'),(34,'10036','3201011006','3201022002','2026-09-26 14:14:54'),(35,'10037','3201011002','3201022005','2026-09-26 14:14:54'),(36,'10038','3201011004','3201022003','2026-09-26 14:14:54'),(37,'10039','3201011006','3201022002','2026-09-26 14:14:54'),(38,'10040','3201011003','3201022003','2026-09-26 14:14:54'),(39,'10041','3201011002','3201022003','2026-09-26 14:14:54'),(40,'10042','3201011004','3201022002','2026-09-26 14:14:54'),(41,'10043','3201011006','3201022004','2026-09-26 14:14:54'),(42,'10044','3201011004','3201022005','2026-09-26 13:08:25'),(43,'10045','3201011002','3201022002','2026-09-26 13:09:50'),(44,'10046','3201011003','3201022003','2026-09-26 13:10:53'),(45,'10047','3201011006','3201022001','2026-09-26 13:12:23'),(46,'10048','3201011002','3201022004','2026-09-26 13:13:49'),(47,'10049','3201011006','3201022003','2026-09-26 13:15:25'),(48,'10050','3201011001','3201022002','2026-09-26 13:16:47'),(49,'10052','3201011001','3201022003','2026-09-26 13:18:26'),(50,'10053','3201011004','3201022002','2026-09-26 13:19:46'),(51,'10054','3201011006','3201022002','2026-09-26 13:21:06'),(52,'10055','3201011001','3201022003','2026-09-26 13:22:26'),(53,'10056','3201011003','3201022001','2026-09-26 13:24:00'),(54,'10057','3201011002','3201022001','2026-09-26 13:25:15'),(55,'10058','3201011002','3201022002','2026-09-26 13:26:49'),(56,'10059','3201011002','3201022002','2026-09-26 13:27:56'),(57,'10060','3201011006','3201022002','2026-09-26 13:29:31'),(58,'10061','3201011002','3201022001','2026-09-26 13:30:52'),(59,'10062','3201011005','3201022004','2026-09-26 13:32:36'),(60,'10063','3201011002','3201022001','2026-09-26 13:33:36'),(61,'10064','3201011005','3201022002','2026-09-26 13:35:03'),(62,'10065','3201011004','3201022002','2026-09-26 13:36:37'),(63,'10066','3201011003','3201022004','2026-09-26 13:38:03'),(64,'10067','3201011005','3201022004','2026-09-26 13:39:21'),(65,'10068','3201011004','3201022001','2026-09-26 13:41:02'),(66,'10069','3201011001','3201022005','2026-09-26 13:42:24'),(67,'10070','3201011003','3201022004','2026-09-26 13:43:45'),(68,'10071','3201011002','3201022002','2026-09-26 13:45:06'),(69,'10072','3201011001','3201022004','2026-09-26 13:46:45'),(70,'10073','3201011001','3201022004','2026-09-26 13:48:00'),(71,'10074','3201011001','3201022001','2026-09-26 13:49:25'),(72,'10075','3201011003','3201022002','2026-09-26 13:50:33'),(73,'10076','3201011001','3201022005','2026-09-26 13:52:21'),(74,'10077','3201011002','3201022004','2026-09-26 13:53:44'),(75,'10078','3201011005','3201022005','2026-09-26 13:55:07'),(76,'10079','3201011002','3201022003','2026-09-26 13:56:23'),(77,'10080','3201011001','3201022005','2026-09-26 13:57:58'),(78,'10081','3201011006','3201022001','2026-09-26 13:59:28'),(79,'10082','3201011005','3201022005','2026-09-26 14:00:41'),(80,'10083','3201011003','3201022001','2026-09-26 14:01:59'),(81,'10084','3201011003','3201022001','2026-09-26 14:03:42'),(82,'10085','3201011002','3201022001','2026-09-26 14:04:55'),(83,'10086','3201011002','3201022003','2026-09-26 14:06:27'),(84,'10087','3201011003','3201022003','2026-09-26 14:07:45'),(85,'10088','3201011004','3201022003','2026-09-26 14:09:25'),(86,'10089','3201011003','3201022005','2026-09-26 14:10:28'),(87,'10090','3201011001','3201022001','2026-09-26 14:11:56'),(88,'10091','3201011006','3201022004','2026-09-26 14:13:25'),(89,'10092','3201011003','3201022003','2026-09-26 14:14:54'),(90,'10093','3201011004','3201022005','2026-09-26 14:16:29'),(91,'10094','3201011001','3201022005','2026-09-26 14:17:44');
/*!40000 ALTER TABLE `hasil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kandidat_ketua`
--

DROP TABLE IF EXISTS `kandidat_ketua`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kandidat_ketua` (
  `nik` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `visi_misi` text,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kandidat_ketua`
--

LOCK TABLES `kandidat_ketua` WRITE;
/*!40000 ALTER TABLE `kandidat_ketua` DISABLE KEYS */;
INSERT INTO `kandidat_ketua` VALUES ('3201011001','Budi Santoso, S.E.','ketua_budi.jpg','Visi:\nMenjadikan Koperasi Sejahtera Mandiri, Modern, Transparan, dan Berdaya Saing Tinggi.\n\nMisi:\n1. Digitalisasi layanan simpan pinjam dan belanja anggota.\n2. Peningkatan SHU tahunan sebesar minimal 15%.\n3. Membuka unit usaha baru yang pro-kesejahteraan anggota.'),('3201011002','Hj. Siti Rahmawati, M.M.','ketua_siti.jpg','Visi:\nKoperasi Amanah, Inklusif, dan Berkelanjutan untuk Kemakmuran Seluruh Anggota.\n\nMisi:\n1. Tata kelola keuangan yang transparan berbasis audit akuntabel.\n2. Penyediaan dana pendidikan dan bantuan darurat bagi anggota.\n3. Perluasan kemitraan usaha mikro koperasi.'),('3201011003','Hendra Gunawan, S.T.','ketua_hendra.jpg','Visi:\nTransformasi Koperasi Cepat, Tepat, dan Berbasis Teknologi Terdepan.\n\nMisi:\n1. Pengembangan aplikasi mobile koperasi untuk mempermudah transaksi.\n2. Optimalisasi pengelolaan aset koperasi untuk hasil maksimal.\n3. Pelayanan prima, ramah, dan bebas birokrasi berbelit.'),('3201011004','Dr. Ir. H. Ahmad Dahlan, M.T.','ketua_ahmad.jpg','Visi:\nKoperasi Berdaya Saing Global Berbasis Ekonomi Kreatif.\n\nMisi:\n1. Digitalisasi simpan pinjam dan kemudahan modal.\n2. Ekosistem wirausaha anggota berdaya saing.'),('3201011005','Rina Agustina, S.Kom., M.M.','ketua_rina.jpg','Visi:\nKoperasi Cerdas & Mandiri Melalui Inovasi Digital.\n\nMisi:\n1. Layanan 24/7 mobile application.\n2. Edukasi literasi finansial digital bagi anggota.'),('3201011006','H. Dedi Supriyadi, S.E.','ketua_dedi.jpg','Visi:\nKoperasi Sejahtera untuk Kesejahteraan Bersama.\n\nMisi:\n1. Peningkatan alokasi pembagian SHU.\n2. Kemitraan sembako murah berkelanjutan.');
/*!40000 ALTER TABLE `kandidat_ketua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kandidat_pengawas`
--

DROP TABLE IF EXISTS `kandidat_pengawas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kandidat_pengawas` (
  `nik` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `visi_misi` text,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kandidat_pengawas`
--

LOCK TABLES `kandidat_pengawas` WRITE;
/*!40000 ALTER TABLE `kandidat_pengawas` DISABLE KEYS */;
INSERT INTO `kandidat_pengawas` VALUES ('3201022001','Ir. Bambang Wijaya, M.Sc.','pengawas_bambang.jpg','Visi:\nPengawasan Independen, Objektif, dan Berintegritas Tinggi Demi Keberlangsungan Koperasi.\n\nMisi:\n1. Memastikan setiap transaksi sesuai dengan AD/ART dan regulasi perkoperasian.\n2. Melakukan audit berkala setiap triwulan dan mempublikasikan ringkasannya.\n3. Memberikan rekomendasi strategis bagi kemajuan pengurus.'),('3201022002','Ratna Dewi, S.E., Ak.','pengawas_ratna.jpg','Visi:\nPengawasan Keuangan yang Akurat, Transparan, dan Tanpa Kompromi terhadap Penyimpangan.\n\nMisi:\n1. Memperkuat sistem internal control di seluruh divisi koperasi.\n2. Memastikan hak-hak simpanan dan SHU anggota terlindungi secara hukum.\n3. Membuka kanal pengaduan langsung anggota yang aman dan rahasia.'),('3201022003','Agus Prasetyo, S.H.','pengawas_agus.jpg','Visi:\nMenegakkan Kepatuhan Hukum dan Keadilan untuk Semua Anggota Koperasi.\n\nMisi:\n1. Review kepatuhan hukum seluruh perjanjian dan kemitraan koperasi.\n2. Edukasi hak dan kewajiban anggota koperasi secara rutin.\n3. Menjaga netralitas dan independensi dewan pengawas.'),('3201022004','Drs. H. Mulyadi, Ak., C.A.','pengawas_mulyadi.jpg','Visi:\nPengawasan Terpadu dan Akuntabilitas Keuangan.\n\nMisi:\n1. Audit kepatuhan berkala setiap semester.\n2. Transparansi laporan keuangan terbuka bagi anggota.'),('3201022005','Nurul Hidayati, S.H., M.Kn.','pengawas_nurul.jpg','Visi:\nPerlindungan Hukum dan Kepastian Hak Simpanan Anggota.\n\nMisi:\n1. Penegakan tata kelola taat AD/ART.\n2. Layanan konsultasi hukum bagi anggota.');
/*!40000 ALTER TABLE `kandidat_pengawas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemenang_undian`
--

DROP TABLE IF EXISTS `pemenang_undian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pemenang_undian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pemilih_nik` varchar(20) NOT NULL,
  `nama_hadiah` varchar(150) NOT NULL DEFAULT 'Door Prize Utama',
  `status` enum('valid','tidak_valid') NOT NULL DEFAULT 'valid',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pemilih_nik` (`pemilih_nik`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemenang_undian`
--

LOCK TABLES `pemenang_undian` WRITE;
/*!40000 ALTER TABLE `pemenang_undian` DISABLE KEYS */;
INSERT INTO `pemenang_undian` VALUES (2,'10007','Grand Prize: Sepeda Motor','valid','2026-09-26 13:42:42'),(3,'10076','Door Prize Utama','valid','2026-09-26 14:36:33');
/*!40000 ALTER TABLE `pemenang_undian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemilih`
--

DROP TABLE IF EXISTS `pemilih`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pemilih` (
  `nik` varchar(20) NOT NULL,
  `rfid` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `pilih` enum('T','F') NOT NULL DEFAULT 'F',
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemilih`
--

LOCK TABLES `pemilih` WRITE;
/*!40000 ALTER TABLE `pemilih` DISABLE KEYS */;
INSERT INTO `pemilih` VALUES ('10001','RFID-001001','Ahmad Fauzi','Produksi','T'),('10002','RFID-001002','Rina Marlina','Keuangan','T'),('10003','RFID-001003','Dedi Kurniawan','IT & Sistem','T'),('10004','RFID-001004','Dewi Lestari','HRD & GA','T'),('10005','RFID-001005','Fajar Pratama','Produksi','T'),('10006','RFID-001006','Nurul Hidayah','Marketing','T'),('10007','RFID-001007','Bayu Saputra','Logistik','T'),('10008','RFID-001008','Eka Wahyuni','Keuangan','T'),('10009','RFID-001009','Rizky Firmansyah','IT & Sistem','T'),('10010','RFID-001010','Maya Anggraini','HRD & GA','T'),('10011','RFID-001011','Indra Lesmana','Produksi','T'),('10012','RFID-001012','Sari Indah','Marketing','T'),('10013','RFID-001013','Hadi Purnomo','Logistik','T'),('10014','RFID-001014','Tri Wulandari','Produksi','T'),('10015','RFID-001015','Arif Setiawan','Keuangan','T'),('10016','RFID-001016','Fitri Handayani','HRD & GA','T'),('10017','RFID-001017','Bagas Wicaksono','IT & Sistem','T'),('10018','RFID-001018','Yuni Astuti','Marketing','T'),('10019','RFID-001019','Gita Permata','Keuangan','T'),('10020','RFID-001020','Joko Susilo','Produksi','T'),('10021','RFID-001021','Mega Utami','Marketing','T'),('10022','RFID-001022','Randi Pratama','IT & Sistem','T'),('10023','RFID-001023','Tari Kusuma','HRD & GA','T'),('10024','RFID-001024','Wahyu Hidayat','Logistik','T'),('10025','RFID-001025','Zulham Efendi','Produksi','T'),('10026','RFID-001026','Dimas Prayoga','Produksi','T'),('10027','RFID-001027','Anisa Rahma','Keuangan','T'),('10028','RFID-001028','Bambang Haryono','Logistik','T'),('10031','RFID-001031','Hendra Setiawan','Produksi','T'),('10032','RFID-001032','Siti Nurhaliza','Keuangan','T'),('10033','RFID-001033','Bagus Pratama','IT & Sistem','T'),('10034','RFID-001034','Lestari Wulandari','HRD & GA','T'),('10035','RFID-001035','Rahmat Hidayat','Logistik','T'),('10036','RFID-001036','Dian Sastrowardoyo','Marketing','T'),('10037','RFID-001037','Rudi Choirudin','Produksi','T'),('10038','RFID-001038','Nur Aini','Keuangan','T'),('10039','RFID-001039','Farhan Alatas','IT & Sistem','T'),('10040','RFID-001040','Intan Permatasari','HRD & GA','T'),('10041','RFID-001041','Galih Firmansyah','Logistik','T'),('10042','RFID-001042','Maya Septiani','Marketing','T'),('10043','RFID-001043','Yoga Pratama','Produksi','T'),('10044','RFID-001044','Nabila Syakieb','Keuangan','T'),('10045','RFID-001045','Panji Gumilang','IT & Sistem','T'),('10046','RFID-001046','Zaskia Adya','HRD & GA','T'),('10047','RFID-001047','Aditya Nugraha','Logistik','T'),('10048','RFID-001048','Tiara Andini','Marketing','T'),('10049','RFID-001049','Bintang Pamungkas','Produksi','T'),('10050','RFID-001050','Chelsea Islan','Keuangan','T'),('10052','RFID-001052','Rian Kurniawan','Produksi','T'),('10053','RFID-001053','Dewi Sartika','Keuangan','T'),('10054','RFID-001054','Aris Munandar','HRD & GA','T'),('10055','RFID-001055','Fitri Handayani','Marketing','T'),('10056','RFID-001056','Gilang Ramadhan','IT & Sistem','T'),('10057','RFID-001057','Lestari Indah','Logistik','T'),('10058','RFID-001058','Bagus Setiawan','Quality Control','T'),('10059','RFID-001059','Dian Permata','Produksi','T'),('10060','RFID-001060','Eko Purnomo','Gudang','T'),('10061','RFID-001061','Farida Nur','Keuangan','T'),('10062','RFID-001062','Gunawan Wibowo','Operasional','T'),('10063','RFID-001063','Heni Pratiwi','Marketing','T'),('10064','RFID-001064','Irfan Maulana','IT & Sistem','T'),('10065','RFID-001065','Joko Susanto','Produksi','T'),('10066','RFID-001066','Kartika Sari','HRD & GA','T'),('10067','RFID-001067','Lukman Hakim','Logistik','T'),('10068','RFID-001068','Mega Utami','Quality Control','T'),('10069','RFID-001069','Nanda Pratama','Produksi','T'),('10070','RFID-001070','Olivia Febrianti','Keuangan','T'),('10071','RFID-001071','Putra Sanjaya','Operasional','T'),('10072','RFID-001072','Qori Anggraini','Marketing','T'),('10073','RFID-001073','Rendra Wijaya','IT & Sistem','T'),('10074','RFID-001074','Siska Amelia','HRD & GA','T'),('10075','RFID-001075','Taufik Hidayatullah','Produksi','T'),('10076','RFID-001076','Umar Said','Gudang','T'),('10077','RFID-001077','Vina Panduwinata','Keuangan','T'),('10078','RFID-001078','Wahyu Saputra','Logistik','T'),('10079','RFID-001079','Yanti Kusuma','Quality Control','T'),('10080','RFID-001080','Zainal Abidin','Operasional','T'),('10081','RFID-001081','Ahmad Fadillah','Produksi','T'),('10082','RFID-001082','Bella Safira','Marketing','T'),('10083','RFID-001083','Candra Kirana','IT & Sistem','T'),('10084','RFID-001084','Doni Firmansyah','Produksi','T'),('10085','RFID-001085','Endang Sulastri','HRD & GA','T'),('10086','RFID-001086','Faisal Tanjung','Logistik','T'),('10087','RFID-001087','Gita Gutawa','Keuangan','T'),('10088','RFID-001088','Haris Munandar','Operasional','T'),('10089','RFID-001089','Indah Permatasari','Quality Control','T'),('10090','RFID-001090','Dimas test 1','Produksi','T'),('10091','RFID-001091','Anisa test 2','Keuangan','T'),('10092','RFID-001092','Bambang test 3','Logistik','T'),('10093','RFID-001093','Marlina Susanti','IT & Sistem','T'),('10094','RFID-001094','Nugroho Adi','Produksi','T'),('10095','RFID-001095','Oki Setiana','HRD & GA','F'),('10096','RFID-001096','Pandu Pratama','Keuangan','F'),('10097','RFID-001097','Qisya Aulia','Logistik','F'),('10098','RFID-001098','Rizky Febian','Operasional','F'),('10099','RFID-001099','Sarah Sechan','Quality Control','F'),('10100','RFID-001100','Tomi Soeharto','Produksi','F'),('10101','RFID-001101','Ulfa Dwiyanti','Marketing','F'),('10102','RFID-001102','Vicky Prasetyo','Gudang','F'),('10103','RFID-001103','Wulan Guritno','HRD & GA','F'),('10104','RFID-001104','Yuda Baskoro','IT & Sistem','F'),('10105','RFID-001105','Zulfa Maharani','Keuangan','F'),('10106','RFID-001106','Aldi Taher','Produksi','F');
/*!40000 ALTER TABLE `pemilih` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-26 22:03:33
