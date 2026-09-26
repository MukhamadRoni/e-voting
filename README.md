# 🗳️ E-Voting Koperasi Modern & Bilik Undian RAT

Platform **E-Voting Koperasi**, **Bilik Undian Doorprize**, dan **Panggung Real Count 3D Interaktif** berbasis CodeIgniter 3, Three.js WebGL, RFID/QR Scanner, dan Tailwind/DM Sans UI.

---

## 📑 Daftar Dokumen Penting

- 🚀 [**Panduan Migrasi & Deployment Lengkap (Docker & Baremetal)**](MIGRATION_GUIDE.md)
- 📄 [**Product Showcase & Dokumen Marketing PDF**](E-VOTING_KOPERASI_PRODUCT_SHOWCASE.pdf)
- 💾 [**Full Database Schema & Seed Data (SQL Dump)**](database/evoting_full_dump.sql)

---

## ⚡ Quick Start dengan Docker (Rekomendasi)

Jalankan seluruh sistem (PHP 8.1 Apache + MySQL 8.0 + Auto Database Seed) hanya dengan **1 perintah**:

```bash
# 1. Clone repositori
git clone https://github.com/MukhamadRoni/e-voting.git
cd e-voting

# 2. Salin environment file
cp .env.example .env

# 3. Jalankan container
docker-compose up -d --build
```

Aplikasi langsung siap diakses di:
- **Panel Admin**: `http://localhost:8080/auth` *(User: `admin` | Pass: `admin123`)*
- **Bilik Suara (Kiosk)**: `http://localhost:8080/voting`
- **Panggung Real Count 3D**: `http://localhost:8080/real_count`
- **Bilik Undian Doorprize**: `http://localhost:8080/bilik_undian`

---

## 🛠️ Instalasi Manual / Baremetal (XAMPP / Linux Server)

Untuk panduan lengkap instalasi baremetal Linux VPS (Ubuntu/Debian) atau Windows XAMPP/Laragon, silakan buka [**`MIGRATION_GUIDE.md`**](MIGRATION_GUIDE.md).

Ringkasan cepat:
1. Pindahkan folder proyek ke `htdocs` web server.
2. Buat database `db_evoting` di MySQL dan import [`database/evoting_full_dump.sql`](database/evoting_full_dump.sql).
3. Sesuaikan `base_url` di `application/config/config.php` dan koneksi di `application/config/database.php`.
4. Buka di browser.

---

## 🌟 Fitur Utama

1. **Bilik Suara Digital (RFID / Token NIK):**
   - Mendukung input kartu RFID scanner atau ketik NIK manual.
   - 3 Tahap Alur: Pemilihan Ketua ➔ Pemilihan Pengawas ➔ Konfirmasi Pilihan.
   - Proteksi satu suara per anggota (*anti double-voting*).

2. **Panggung Real Count 3D Interactive (Three.js WebGL):**
   - Formasi podium Olympic Winner (Peringkat 1 di Tengah, Peringkat 2 di Kiri, Peringkat 3 di Kanan).
   - Kaki podium berbalut material metalik Gold, Silver, dan Bronze.
   - Permukaan kartu Obsidian Dark berbingkai LED glow dan tipografi putih kontras tinggi.
   - Auto-polling setiap 10 detik dengan animasi lompatan 3D saat urutan ranking bergeser.

3. **Bilik Undian Door Prize RAT (3-Column Slot Machine Reel):**
   - Layar panggung khusus dilindungi autentikasi panitia.
   - Fitur *Slot Spinner* acak hanya untuk anggota yang sudah sah memberikan hak suara.
   - Toggle Auto-Valid ON/OFF dan verifikasi kehadiran pemenang.
   - Live winners sidebar & efek selebrasi konfeti.

4. **Manajemen DPT (Data Pemilih Tetap):**
   - DataTables interaktif: *live search*, *custom pagination*, *quick status filter*.
   - Import Excel dua tahap (*Two-Step Preview*) dengan validasi duplikasi NIK sebelum commit.

5. **Manajemen Kandidat:**
   - Kelola profil Calon Ketua dan Calon Pengawas.
   - Upload foto resolusi tinggi serta teks visi dan misi.

6. **Laporan & Rekapitulasi:**
   - Rekap suara Ketua & Pengawas siap cetak A4 dan audit trail (*trace back*) transaksi suara masuk.

---

## 🔐 Akun Default Admin
- **Username:** `admin`
- **Password:** `admin123`

---

## 📄 Lisensi
Hak Cipta © 2026 E-Voting Koperasi Modern.
