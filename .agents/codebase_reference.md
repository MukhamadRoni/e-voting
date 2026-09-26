# Codebase Reference: Sistem E-Voting & Undian RAT Koperasi

> **Dokumen Panduan Codebase untuk AI Agent & Pengembang**  
> Gunakan dokumen ini sebagai referensi arsitektur, database, rute, model, dan aturan bisnis tanpa perlu membaca keseluruhan file dari awal.

---

## 1. Spesifikasi Sistem & Lingkungan
- **Framework:** CodeIgniter 3.1.13 (PHP MVC)
- **PHP Version:** PHP 7.4.x / 8.x
- **Web Server:** Apache (XAMPP pada port `8080`, `base_url = "http://localhost:8080/e-voting/"`)
- **Database:** MySQL `db_evoting` pada `localhost:3306` (User: `root`, Password: `""`)
- **Desain & Tema:** Apple-inspired Minimalist (Warna Utama: `#1a1a1a`, Latar: `#f5f5f7`, Squircle Cards `border-radius: 16px/24px`, Pill Buttons `border-radius: 9999px`, Font: `DM Sans`)
- **Library & Vendor Lokal (Offline-First):**
  - **SweetAlert2:** `assets/vendor/sweetalert2/` (`sweetalert2.all.min.js`, `sweetalert2.min.css`)
  - **DataTables:** `assets/vendor/datatables/` (`jquery.dataTables.min.js`, `dataTables.min.css`)
  - **jQuery:** `assets/vendor/jquery/` (`jquery.min.js` v3.7.1)
  - **Excel Parser/Generator:** `application/libraries/SimpleXLSX.php` & `SimpleXLSXGen.php`
  - **Canvas Confetti:** Pure HTML5 Canvas Engine terintegrasi (tanpa CDN eksternal)

---

## 2. Struktur Database (`db_evoting`)

### A. Tabel `admin` (Kredensial Admin)
- `id` (INT PK AI), `username` (VARCHAR 50 UNIQUE), `password` (VARCHAR 255 MD5), `created_at` (TIMESTAMP)
- **Default Akun:** `admin` / `admin123` (MD5: `0192023a7bbd73250516f069df18b500`)

### B. Tabel `pemilih` (Daftar Pemilih Tetap - DPT)
- `nik` (VARCHAR 20 PK), `rfid` (VARCHAR 50 UNIQUE), `nama` (VARCHAR 100), `dept` (VARCHAR 50), `pilih` (ENUM `'T'`,`'F'` DEFAULT `'F'`)
- Status `'T'` = Sudah Memilih (berhak ikut undian), `'F'` = Belum Memilih

### C. Tabel `kandidat_ketua` (Calon Ketua)
- `id` (INT PK AI), `no_urut` (INT), `nama` (VARCHAR 100), `foto` (VARCHAR 255), `visi` (TEXT), `misi` (TEXT), `created_at` (TIMESTAMP)

### D. Tabel `kandidat_pengawas` (Calon Pengawas)
- `id` (INT PK AI), `no_urut` (INT), `nama` (VARCHAR 100), `foto` (VARCHAR 255), `visi` (TEXT), `misi` (TEXT), `created_at` (TIMESTAMP)

### E. Tabel `hasil` (Surat Suara Transaksi Voting)
- `id` (INT PK AI), `pemilih_nik` (VARCHAR 20), `ketua_nik` (VARCHAR 20), `pengawas_nik` (VARCHAR 20), `created_at` (TIMESTAMP)

### F. Tabel `pemenang_undian` (Riwayat Pemenang Door Prize RAT)
- `id` (INT PK AI), `pemilih_nik` (VARCHAR 20), `nama_hadiah` (VARCHAR 150), `status` (ENUM `'valid'`,`'tidak_valid'`), `created_at` (TIMESTAMP)

---

## 3. Peta Controller, Model, & View

```
application/
├── core/
│   └── MY_Controller.php          -> Admin_Controller (Cek session admin_logged_in)
├── controllers/
│   ├── Auth.php                   -> Login & Logout admin (/auth, /auth/process, /auth/logout)
│   ├── Admin.php                  -> Dashboard utama admin (/admin)
│   ├── Master_User.php            -> CRUD Pemilih, DataTables, Excel Import/Template (/master_user)
│   ├── Master_Kandidat.php        -> CRUD Kandidat Ketua & Pengawas, upload & live preview foto (/master_kandidat)
│   ├── Voting.php                 -> Kiosk Bilik Suara (/voting, /voting/identifikasi, /voting/pilih_ketua, ...)
│   ├── Bilik_Undian.php           -> Panggung Bilik Undian RAT (/bilik_undian, /bilik_undian/acak_ajax, ...)
│   ├── Real_Count.php             -> Panggung Real Count 3D Interactive Three.js (/real_count, /real_count/data_ajax)
│   └── Laporan.php                -> Rekap suara ketua, pengawas, trace back, peserta undian (/laporan)
├── models/
│   ├── Auth_model.php             -> login($username, $password)
│   ├── Pemilih_model.php          -> get_all(), get_by_nik(), insert(), update(), delete(), import_batch()
│   ├── Kandidat_model.php         -> get_all_ketua(), get_all_pengawas(), insert, update, delete
│   ├── Voting_model.php           -> get_pemilih_by_rfid_or_nik(), simpan_suara() [DB Transaction]
│   ├── Undian_model.php           -> get_peserta_berhak(), count_peserta_tersisa(), simpan_pemenang(), reset()
│   └── Laporan_model.php          -> get_rekap_ketua(), get_rekap_pengawas(), get_trace_back(), get_peserta_undian()
└── views/
    ├── templates/                 -> header.php, footer.php (Admin Layout dengan DataTables & SweetAlert2)
    ├── auth/login.php             -> Form Login Admin
    ├── admin/dashboard.php        -> Statistik DPT, total suara masuk, persentase, quick action
    ├── master_user/               -> index.php (DataTables + Quick Filters), tambah.php, edit.php, import.php (Two-Step Preview)
    ├── master_kandidat/           -> index.php (Tab Ketua & Pengawas), tambah_ketua.php, edit_ketua.php, ...
    ├── voting/                    -> template_header.php, template_footer.php, identifikasi.php, pilih_ketua.php, pilih_pengawas.php, konfirmasi.php, selesai.php
    ├── bilik_undian/              -> auth_gate.php (Password Admin Gate), index.php (Panggung Stage Undian)
    ├── real_count/                -> index.php (Panggung Real Count 3D Three.js, Auto-Polling 10s, 3D Rank Swap)
    └── laporan/                   -> pemenang_ketua.php, pemenang_pengawas.php, trace_back.php, peserta_undian.php
```

---

## 4. Alur & Logika Bisnis Utama (Core Workflows)

### 1. Alur Bilik Suara / Voting Digital (`/voting`)
1. **Identifikasi:** Pemilih memasukkan NIK atau Tap Kartu RFID pada halaman `/voting`.
2. **Validasi:** Sistem mengecek:
   - Apakah data pemilih terdaftar di tabel `pemilih`.
   - Apakah `pilih == 'T'`. Jika sudah memilih, akses ditolak dengan pesan peringatan SweetAlert2.
3. **Pilih Ketua (`voting/pilih_ketua`):** Pemilih memilih 1 calon ketua dari daftar kandidat.
4. **Pilih Pengawas (`voting/pilih_pengawas`):** Pemilih memilih 1 calon pengawas.
5. **Konfirmasi Suara (`voting/konfirmasi`):** Review pilihan sebelum dicetak ke surat suara digital.
6. **Submit Suara (`voting/submit`):**
   - Menjalankan **Database Transaction** (`$this->db->trans_start()`):
     - Insert data ke tabel `hasil` (`pemilih_nik`, `ketua_nik`, `pengawas_nik`).
     - Update status pemilih menjadi `pilih = 'T'` pada tabel `pemilih`.
   - Redirect ke halaman `voting/selesai` (Auto-reset dalam 5 detik kembali ke layar identifikasi).

### 2. Alur Panggung Bilik Undian RAT (`/bilik_undian`)
1. **Autentikasi Admin Gate:**
   - Halaman `/bilik_undian` memeriksa session `undian_authenticated`.
   - Jika belum login, operator **wajib memasukkan username & password admin** pada view `auth_gate.php`.
2. **Pool Peserta Berhak:**
   - Hanya anggota yang sudah memilih (`pemilih.pilih = 'T'`) DAN belum tercatat sebagai pemenang sah (`nik NOT IN (SELECT pemilih_nik FROM pemenang_undian WHERE status = 'valid')`).
3. **Toggle Auto-Valid Switch:**
   - **Auto-Valid ON (Default):** Saat tombol putar selesai, pemenang otomatis disahkan, disimpan ke database via AJAX (`simpan_pemenang_ajax`), konfeti meledak, dan kuota sisa berkurang.
   - **Auto-Valid OFF:** Setelah roda acak berhenti, muncul **SweetAlert2 Modal Konfirmasi Kehadiran**:
     - Tombol Hijau `✓ VALID (Hadir & Sah)` -> Disimpan ke database, konfeti menyala, kuota berkurang.
     - Tombol Merah `✕ TIDAK VALID (Hangus/Undi Ulang)` -> Tidak disimpan ke database pemenang, status hadiah tetap utuh, dan operator dapat mengundi ulang peserta lain.
4. **Live Winners Feed:**
   - Pemenang otomatis bertambah di panel kanan panggung dengan opsi pembatalan per item (mengembalikan peserta ke pool undian) atau Reset Semua.

### 3. Alur Import Excel Data Pemilih & Pratinjau (`/master_user/import`)
- Menggunakan library `SimpleXLSX` dan `SimpleXLSXGen` (tanpa dependensi Composer).
- Menyediakan download template `.xlsx` via `/master_user/download_template`.
- **Dua Tahap (Two-Step Workflow):**
  1. **Unggah & Validasi:** Mengunggah file `.xlsx`, memvalidasi header (`nik`, `rfid`, `nama`, `departemen`/`dept`), cek kolom wajib isi, serta cek duplikasi NIK/RFID baik di dalam file maupun terhadap database `pemilih`.
  2. **Pratinjau Interaktif DataTables:** Menampilkan hasil pembacaan sebelum disimpan ke database, lengkap dengan kartu ringkasan (*Total Baris*, *Siap Diimpor*, *Bermasalah*), status badge per baris (`✓ Siap Diimpor` vs `✕ NIK Duplikat / Kosong`), filter pills, serta tombol konfirmasi *Simpan ke Database* atau *Batalkan / Upload Ulang*.

---

## 5. UI/UX & Standar Desain
1. **Pill Buttons & Squircle Cards:** Seluruh tombol aksi utama menggunakan kelas `.btn`, `.btn-primary`, `.btn-secondary`, `.btn-danger` dengan `border-radius: 9999px`.
2. **SweetAlert2 Universal:** Tidak ada penggunaan `alert()` atau `confirm()` bawaan browser. Seluruh notifikasi flashdata dan tombol hapus menggunakan SweetAlert2 lokal di `assets/vendor/sweetalert2/`.
3. **DataTables Pemilih:** Halaman Data Pemilih dilengkapi pencarian instan (search box rounded), filter cepat status ("Semua", "Sudah Memilih", "Belum Memilih"), pagination dinamis, dan penomoran otomatis.
4. **Live Photo Preview:** Seluruh form upload kandidat ketua dan pengawas memiliki fitur instant image preview saat file dipilih.

---

## 6. Kredensial & Data Uji Default
- **Admin Panel:** `http://localhost:8080/e-voting/auth` (`admin` / `admin123`)
- **Bilik Suara (Kiosk):** `http://localhost:8080/e-voting/voting` (Test NIK: `10001` s/d `10050` / RFID: `RFID-001001` s/d `RFID-001050`)
- **Bilik Undian (Stage):** `http://localhost:8080/e-voting/bilik_undian` (Login via kredensial admin)
- **Real Count 3D (Live):** `http://localhost:8080/e-voting/real_count`
- **Daftar Kandidat Ketua (6 Kandidat):**
  1. `3201011001` - Budi Santoso, S.E. (`ketua_budi.jpg`)
  2. `3201011002` - Hj. Siti Rahmawati, M.M. (`ketua_siti.jpg`)
  3. `3201011003` - Hendra Gunawan, S.T. (`ketua_hendra.jpg`)
  4. `3201011004` - Dr. Ir. H. Ahmad Dahlan, M.T. (`ketua_ahmad.jpg`)
  5. `3201011005` - Rina Agustina, S.Kom., M.M. (`ketua_rina.jpg`)
  6. `3201011006` - H. Dedi Supriyadi, S.E. (`ketua_dedi.jpg`)
- **Daftar Kandidat Pengawas (5 Kandidat):**
  1. `3201022001` - Ir. Bambang Wijaya, M.Sc. (`pengawas_bambang.jpg`)
  2. `3201022002` - Ratna Dewi, S.E., Ak. (`pengawas_ratna.jpg`)
  3. `3201022003` - Agus Prasetyo, S.H. (`pengawas_agus.jpg`)
  4. `3201022004` - Drs. H. Mulyadi, Ak., C.A. (`pengawas_mulyadi.jpg`)
  5. `3201022005` - Nurul Hidayati, S.H., M.Kn. (`pengawas_nurul.jpg`)
- **Total DPT Pemilih:** 51 Anggota (41 Suara Masuk / 80.4% Partisipasi)
