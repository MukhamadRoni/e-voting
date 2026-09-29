-- ============================================
-- Database Schema: E-Voting Koperasi
-- ============================================

CREATE DATABASE IF NOT EXISTS `db_evoting`
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE `db_evoting`;

-- --------------------------------------------
-- 1. Tabel Pemilih
-- --------------------------------------------
CREATE TABLE IF NOT EXISTS `pemilih` (
  `nik` VARCHAR(20) NOT NULL,
  `rfid` VARCHAR(50) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `dept` VARCHAR(50) NOT NULL,
  `pilih` ENUM('T','F') NOT NULL DEFAULT 'F',
  PRIMARY KEY (`nik`),
  UNIQUE KEY `idx_pemilih_rfid` (`rfid`),
  KEY `idx_pemilih_pilih` (`pilih`),
  KEY `idx_pemilih_pilih_dept` (`pilih`, `dept`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------
-- 2. Tabel Kandidat Ketua
-- --------------------------------------------
CREATE TABLE IF NOT EXISTS `kandidat_ketua` (
  `nik` VARCHAR(20) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `visi_misi` TEXT,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------
-- 3. Tabel Kandidat Pengawas
-- --------------------------------------------
CREATE TABLE IF NOT EXISTS `kandidat_pengawas` (
  `nik` VARCHAR(20) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `visi_misi` TEXT,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------
-- 4. Tabel Hasil (Transaksi Voting)
-- --------------------------------------------
CREATE TABLE IF NOT EXISTS `hasil` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pemilih_nik` VARCHAR(20) NOT NULL,
  `ketua_nik` VARCHAR(20) NOT NULL,
  `pengawas_nik` VARCHAR(20) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_hasil_pemilih` (`pemilih_nik`),
  KEY `fk_hasil_ketua` (`ketua_nik`),
  KEY `fk_hasil_pengawas` (`pengawas_nik`),
  KEY `idx_hasil_created_at` (`created_at`),
  CONSTRAINT `fk_hasil_pemilih` FOREIGN KEY (`pemilih_nik`) REFERENCES `pemilih` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_hasil_ketua` FOREIGN KEY (`ketua_nik`) REFERENCES `kandidat_ketua` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_hasil_pengawas` FOREIGN KEY (`pengawas_nik`) REFERENCES `kandidat_pengawas` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------
-- 5. Tabel Pemenang Undian (Door Prize)
-- --------------------------------------------
CREATE TABLE IF NOT EXISTS `pemenang_undian` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pemilih_nik` VARCHAR(20) NOT NULL,
  `nama_hadiah` VARCHAR(150) NOT NULL DEFAULT 'Door Prize Utama',
  `status` ENUM('valid','tidak_valid') NOT NULL DEFAULT 'valid',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pemilih_nik` (`pemilih_nik`),
  KEY `idx_pemenang_status_nik` (`status`, `pemilih_nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------
-- 6. Tabel Admin (untuk autentikasi)
-- --------------------------------------------
CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default admin (password: admin123)
INSERT INTO `admin` (`username`, `password`) VALUES
('admin', MD5('admin123'))
ON DUPLICATE KEY UPDATE `username` = `username`;
