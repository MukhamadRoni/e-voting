# Checklist Pengembangan Fitur E-Voting Koperasi

Gunakan checklist ini untuk melacak progres pengembangan dan riwayat revisi sistem (Seluruh fitur `[x]` telah selesai diimplementasikan).

## 1. Tahap Persiapan & Environment
- [x] Konfigurasi `application/config/database.php` terhubung dengan MySQL XAMPP (`db_evoting`).
- [x] Konfigurasi `base_url` (`http://localhost:8080/e-voting/`) dan `index_page` pada `application/config/config.php`.
- [x] Konfigurasi Autoload (database, session, url, form) pada `autoload.php`.
- [x] Font DM Sans & Asset lokal (tanpa dependensi internet eksternal saat offline).

## 2. Tahap Database (Query & Struktur)
- [x] Buat tabel `admin` (id, username, password [MD5], created_at).
- [x] Buat tabel `pemilih` (nik, rfid, nama, dept, pilih ['T'/'F']).
- [x] Buat tabel `kandidat_ketua` (id, no_urut, nama, foto, visi, misi, created_at).
- [x] Buat tabel `kandidat_pengawas` (id, no_urut, nama, foto, visi, misi, created_at).
- [x] Buat tabel `hasil` (id, pemilih_nik, ketua_nik, pengawas_nik, created_at).
- [x] Buat tabel `pemenang_undian` (id, pemilih_nik, nama_hadiah, status ['valid'/'tidak_valid'], created_at).
- [x] Inisialisasi data dummy pemilih, kandidat ketua & pengawas dengan foto AI generatif.

## 3. Fitur Autentikasi Admin (Controller: Auth.php)
- [x] Halaman Login UI minimalis (Apple-inspired aesthetic).
- [x] Proses validasi login (username/password MD5).
- [x] Set Session Admin (`admin_id`, `admin_username`, `admin_logged_in`).
- [x] Fitur Logout dan penghapusan session.
- [x] Core Controller `Admin_Controller` untuk proteksi otomatis seluruh route admin.

## 4. Master Data: Pemilih (Controller: Master_User.php)
- [x] Halaman Daftar (Read) data Pemilih.
- [x] **DataTables Search & Pagination:** Integrasi DataTables lokal dengan pencarian instan (NIK, Nama, Dept, RFID), pagination dinamis, pengurutan, dan penomoran otomatis.
- [x] **Filter Pills Status Voting:** Tombol filter cepat ("Semua", "Sudah Memilih", "Belum Memilih").
- [x] Fitur Tambah (Create) Pemilih (Validasi NIK & RFID unik).
- [x] Fitur Edit (Update) data Pemilih.
- [x] Fitur Hapus (Delete) data Pemilih dengan dialog konfirmasi SweetAlert2.
- [x] **Fitur Import Excel Pemilih & Pratinjau Sebelum Submit:**
  - Download template resmi Excel (`.xlsx`) via SimpleXLSXGen.
  - Upload file Excel via SimpleXLSX parser.
  - Validasi ketat struktur kolom header (`nik`, `rfid`, `nama`, `departemen`/`dept`), validasi wajib isi, dan validasi duplikasi NIK/RFID baik di dalam file maupun terhadap database.
  - **Pratinjau Data Sebelum Disimpan (Two-Step Preview):** Menampilkan ringkasan stat (Total Baris, Data Valid, Data Bermasalah) serta tabel pratinjau interaktif DataTables dengan status badge per baris (`✓ Siap Diimpor` / `✕ NIK Duplikat / Kolom Kosong`).
  - **Tombol Konfirmasi & Batal:** Operator dapat meninjau seluruh data dengan DataTables search & pagination sebelum menekan tombol *Simpan Data Valid ke Database* atau *Batalkan / Upload Ulang*.

## 5. Master Data: Kandidat (Controller: Master_Kandidat.php)
- [x] Halaman Tab Navigasi: Kandidat Ketua dan Kandidat Pengawas.
- [x] Fitur Tambah (Create) Kandidat beserta fungsi Upload Foto (`gif|jpg|jpeg|png` maks 2MB).
- [x] **Fitur Preview Foto:** Live instant image preview saat memilih file foto baru sebelum disimpan.
- [x] Fitur Edit (Update) data dan foto Kandidat (dengan tampilan foto lama dan live preview foto pengganti).
- [x] Fitur Hapus (Delete) Kandidat beserta pembersihan file fisik foto di direktori `assets/uploads/kandidat/`.

## 6. Fitur Bilik Voting Pemilih (Controller: Voting.php)
- [x] Kiosk Mode khusus Bilik Suara (`/voting`).
- [x] Halaman Identifikasi / Login Pemilih via NIK atau Scan RFID.
- [x] Validasi Pemilih: Cek status `pilih = 'T'` (jika sudah memilih, ditolak dengan notifikasi SweetAlert2).
- [x] Stepper Navigasi Voting 3 Tahap:
  1. Tahap 1: Pilih Kandidat Ketua.
  2. Tahap 2: Pilih Kandidat Pengawas.
  3. Tahap 3: Konfirmasi Pilihan Suara (Review lengkap calon ketua & pengawas sebelum submit).
- [x] Transaksi Atomic / Database Transaction: Insert ke tabel `hasil` dan update `pemilih.pilih = 'T'`.
- [x] Halaman Selesai / Terima Kasih dengan timer auto-reset 5 detik kembali ke layar standby.

## 7. Fitur Laporan & Audit (Controller: Laporan.php)
- [x] **Laporan Pemenang Ketua:** Rekap perolehan suara tiap calon ketua, persentase, dan diagram perolehan suara.
- [x] **Laporan Pemenang Pengawas:** Rekap perolehan suara tiap calon pengawas, persentase, dan diagram.
- [x] **Trace Back Suara:** Audit trail detail (NIK, Nama Pemilih, Pilihan Ketua, Pilihan Pengawas, Waktu Voting).
- [x] **Laporan Peserta Undian:** Rekap anggota berhak undian (`pilih = 'T'`), filter per departemen, tombol cetak laporan, dan shortcut ke Bilik Undian.

## 8. Fitur Panggung Bilik Undian RAT (Controller: Bilik_Undian.php)
- [x] Halaman Khusus Panggung Undian (`/bilik_undian`) dengan layout Stage / Fullscreen Kiosk.
- [x] **Autentikasi Admin Gate:** Wajib input Username & Password Admin sebelum masuk panggung undian.
- [x] **Pencegahan Pemenang Ganda:** Tabel `pemenang_undian` mencatat pemenang sah (`status = 'valid'`). Anggota yang sudah menang otomatis dieksklusi dari putaran undian berikutnya.
- [x] **Toggle Switch Auto-Valid (Enable / Disable):**
  - **Auto-Valid ON:** Pemenang yang terpilih langsung otomatis sah & tersimpan permanen.
  - **Auto-Valid OFF:** Muncul Pop-up Konfirmasi SweetAlert2 ("Apakah pemenang hadir di ruangan RAT?") dengan tombol Hijau `✓ VALID (Hadir)` dan Merah `✕ TIDAK VALID (Hangus/Undi Ulang)`.
- [x] Preset hadiah lengkap (*Grand Prize Motor, Smart TV, Kulkas, Sepeda, Voucher*, dll) serta input hadiah bebas.
- [x] Animasi slot machine putar nama interaktif dengan deselerasi halus dan Canvas Confetti lokal.
- [x] Panel sidebar live real-time daftar pemenang, tombol batalkan per pemenang, dan tombol reset undian.

## 9. Peningkatan UI/UX & Standarisasi Modern
- [x] Desain terpadu Apple-inspired minimalist (`#1a1a1a`, `#ffffff`, `#f5f5f7`, squircle cards, pill buttons `border-radius: 9999px`).
- [x] Migrasi seluruh dialog `alert()` dan `confirm()` bawaan browser ke **SweetAlert2** lokal yang modern.
- [x] Pembuatan icon dan favicon resmi SVG (`logo.svg`, `logo-horizontal.svg`, `favicon.svg`).

## 10. Fitur Real Count 3D Interactive Single Page (Controller: Real_Count.php)
- [x] Halaman Khusus Real Count 3D Stage (`/real_count`).
- [x] **Three.js 3D Engine Lokal:** Render panggung 3D dengan lighting dinamis, ambient glow, dan floating particle background.
- [x] **Tata Letak 1 Baris 3D (Top 3):** Menampilkan 3 kandidat dengan persentase suara terbesar dalam 1 baris 3D (podium silinder LED & kartu tekstur kanvas resolusi tinggi).
- [x] **Auto-Polling 10 Detik:** Memperbarui data suara dan persentase secara otomatis tanpa reload halaman.
- [x] **Animasi Pergeseran Peringkat 3D (Rank Swap):** Saat posisi perolehan suara bergeser/menyalip, kartu 3D meluncur horizontal dan melompat dinamis (arched jump) ke slot peringkat barunya.
- [x] **Tray Kandidat Lainnya (Rank 4, 5, dst):** Menampilkan kandidat di luar Top 3 pada rak bawah dengan avatar, nama, jumlah suara, dan progress bar.
- [x] **Fitur Tambahan:** Switcher Kategori (Calon Ketua / Pengawas), indikator live countdown sync, ringkasan partisipasi DPT, dan tombol Fullscreen.

