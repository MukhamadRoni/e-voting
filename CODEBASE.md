# Codebase Overview - E-Voting & Undian RAT Koperasi

Dokumen ini adalah ringkasan arsitektur, database, rute, dan logika bisnis sistem. Untuk dokumentasi lengkap, silakan lihat [`.agents/codebase_reference.md`](.agents/codebase_reference.md) dan [`.agents/checklist_fitur_e_voting.md`](.agents/checklist_fitur_e_voting.md).

---

## 📌 Ringkasan Cepat

- **Stack:** CodeIgniter 3 (PHP 7.4/8.x), MySQL `db_evoting`, Apache Port `8080`
- **URL Basis:** `http://localhost:8080/e-voting/`
- **Default Admin:** `admin` / `admin123`
- **Vendor Lokal:** SweetAlert2, DataTables, jQuery, SimpleXLSX (100% offline-ready)

---

## 🗂️ Rute Utama Aplikasi

| URL Rute | Controller | Fungsi & Deskripsi |
| :--- | :--- | :--- |
| `/auth` | `Auth.php` | Login & Logout Admin |
| `/admin` | `Admin.php` | Dashboard Admin & Statistik Suara |
| `/master_user` | `Master_User.php` | Data Pemilih (DPT), Search & Pagination DataTables, Filter Status, Import Excel |
| `/master_kandidat` | `Master_Kandidat.php` | Data Calon Ketua & Pengawas, Upload & Live Preview Foto |
| `/voting` | `Voting.php` | Bilik Suara Digital (Tap RFID / Input NIK -> Pilih Ketua -> Pilih Pengawas -> Konfirmasi -> Selesai) |
| `/bilik_undian` | `Bilik_Undian.php` | Panggung Bilik Undian RAT (Gate Password Admin, Slot Spinner, Toggle Auto-Valid ON/OFF, Pop-up Konfirmasi, Live Winners, Confetti) |
| `/real_count` | `Real_Count.php` | Panggung Real Count 3D Interactive Three.js (1 Baris 3D Top 3, Polling 10s, Animasi Geser 3D Rank Swap, Tray Kandidat Lain) |
| `/laporan` | `Laporan.php` | Rekap Pemenang Ketua, Pemenang Pengawas, Trace Back Suara, Peserta Undian |

---

## 🗄️ Database Tables (`db_evoting`)
1. `admin`: Akun admin (MD5 password).
2. `pemilih`: NIK, RFID, Nama, Dept, Status Pilih (`'T'`/`'F'`).
3. `kandidat_ketua`: Nomor Urut, Nama, Foto, Visi, Misi Calon Ketua.
4. `kandidat_pengawas`: Nomor Urut, Nama, Foto, Visi, Misi Calon Pengawas.
5. `hasil`: Transaksi suara (ID, NIK Pemilih, NIK Ketua, NIK Pengawas, Waktu).
6. `pemenang_undian`: Riwayat pemenang door prize RAT (`status = 'valid'` mencegah undian ganda).
