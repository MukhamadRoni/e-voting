# Skema Database E-Voting Koperasi (`db_evoting`)

Database: `db_evoting` (MySQL on `localhost:3306` / XAMPP port `8080`)

---

## 1. Tabel `admin` (Autentikasi Administrator)
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT AUTO_INCREMENT PRIMARY KEY | ID Admin |
| `username` | VARCHAR(50) NOT NULL UNIQUE | Username login (cth: `admin`) |
| `password` | VARCHAR(255) NOT NULL | Password hash MD5 (cth: `admin123` -> `0192023a7bbd73250516f069df18b500`) |
| `created_at` | TIMESTAMP DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan akun |

---

## 2. Tabel `pemilih` (Daftar Pemilih Tetap - DPT)
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `nik` | VARCHAR(20) PRIMARY KEY | Nomor Induk Karyawan / Anggota (Unik) |
| `rfid` | VARCHAR(50) NOT NULL UNIQUE | Nomor Kartu / Tag RFID |
| `nama` | VARCHAR(100) NOT NULL | Nama Lengkap Anggota |
| `dept` | VARCHAR(50) NOT NULL | Departemen / Divisi Anggota |
| `pilih` | ENUM('T', 'F') DEFAULT 'F' | Status Voting: `'T'` (Sudah Memilih), `'F'` (Belum Memilih) |

---

## 3. Tabel `kandidat_ketua` (Kandidat Calon Ketua Koperasi)
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT AUTO_INCREMENT PRIMARY KEY | ID Kandidat |
| `no_urut` | INT NOT NULL | Nomor Urut Calon (1, 2, 3...) |
| `nama` | VARCHAR(100) NOT NULL | Nama Calon Ketua |
| `foto` | VARCHAR(255) NULL | Nama file foto di `assets/uploads/kandidat/` |
| `visi` | TEXT NULL | Pernyataan Visi |
| `misi` | TEXT NULL | Poin-poin Misi |
| `created_at` | TIMESTAMP DEFAULT CURRENT_TIMESTAMP | Waktu pendaftaran |

---

## 4. Tabel `kandidat_pengawas` (Kandidat Calon Pengawas Koperasi)
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT AUTO_INCREMENT PRIMARY KEY | ID Kandidat |
| `no_urut` | INT NOT NULL | Nomor Urut Calon (1, 2, 3...) |
| `nama` | VARCHAR(100) NOT NULL | Nama Calon Pengawas |
| `foto` | VARCHAR(255) NULL | Nama file foto di `assets/uploads/kandidat/` |
| `visi` | TEXT NULL | Pernyataan Visi |
| `misi` | TEXT NULL | Poin-poin Misi |
| `created_at` | TIMESTAMP DEFAULT CURRENT_TIMESTAMP | Waktu pendaftaran |

---

## 5. Tabel `hasil` (Transaksi Surat Suara Voting)
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT AUTO_INCREMENT PRIMARY KEY | ID Surat Suara |
| `pemilih_nik` | VARCHAR(20) NOT NULL | FK ke `pemilih.nik` |
| `ketua_nik` | VARCHAR(20) NOT NULL | Pilihan Ketua (Nomor / ID Kandidat Ketua) |
| `pengawas_nik`| VARCHAR(20) NOT NULL | Pilihan Pengawas (Nomor / ID Kandidat Pengawas) |
| `created_at` | TIMESTAMP DEFAULT CURRENT_TIMESTAMP | Waktu pencoblosan digital |

---

## 6. Tabel `pemenang_undian` (Riwayat Pemenang Door Prize RAT)
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT AUTO_INCREMENT PRIMARY KEY | ID Catatan Pemenang |
| `pemilih_nik` | VARCHAR(20) NOT NULL | FK ke `pemilih.nik` |
| `nama_hadiah` | VARCHAR(150) NOT NULL | Nama hadiah door prize |
| `status` | ENUM('valid', 'tidak_valid') DEFAULT 'valid' | Status undian: `'valid'` (Sah/Hadir), `'tidak_valid'` (Gugur) |
| `created_at` | TIMESTAMP DEFAULT CURRENT_TIMESTAMP | Waktu pengundian |

> **Catatan Logika Undian:** Query peserta undian menyaring anggota dengan `pemilih.pilih = 'T'` dan `nik NOT IN (SELECT pemilih_nik FROM pemenang_undian WHERE status = 'valid')` sehingga pemenang yang sah tidak akan pernah terpilih kembali.
