# e-voting

Aplikasi E-Voting dan Undian RAT Koperasi Modern berbasis CodeIgniter 3, Three.js 3D Real Count, RFID Voting, dan SweetAlert2.

---

## 🚀 Fitur Utama

1. **Bilik Suara Digital (RFID / NIK):**
   - Mendukung input via kartu RFID scanner atau ketik NIK manual.
   - 3 Tahap Alur: Pemilihan Ketua ➔ Pemilihan Pengawas ➔ Konfirmasi Pilihan.
   - Validasi satu suara per anggota (mencegah *double voting*).

2. **Panggung Real Count 3D Interactive (Three.js):**
   - Visualisasi panggung 3D mandiri dengan kartu resolusi tinggi dan *lighting ambient*.
   - Formasi podium Olympic Winner (Peringkat 1 di Tengah, Peringkat 2 di Kiri, Peringkat 3 di Kanan).
   - Auto-polling setiap 10 detik dengan animasi *smooth 3D rank swap / jump*.
   - Rak bawah (*bottom tray*) untuk kandidat peringkat ke-4 ke atas.
   - Pilihan kategori (Ketua / Pengawas) & mode Fullscreen.

3. **Bilik Undian RAT (Door Prize Lottery):**
   - Layar khusus dengan gerbang autentikasi password admin.
   - Fitur *Slot Spinner* animasi acak dengan filter peserta yang sudah sah voting.
   - Toggle Auto-Valid ON/OFF dan Pop-up konfirmasi kehadiran pemenang.
   - Riwayat pemenang langsung (*live winners sidebar*) & efek selebrasi konfeti.
   - Mencegah anggota yang sudah menang sah mendapatkan undian ganda.

4. **Manajemen DPT (Data Pemilih Tetap):**
   - Integrasi DataTables lengkap: *live search*, *custom pagination*, *quick status filter*.
   - Fitur Import Excel dua tahap (*Two-Step Preview*) dengan validasi duplikasi NIK sebelum commit ke database.

5. **Manajemen Kandidat:**
   - Kelola data Calon Ketua dan Calon Pengawas.
   - Upload foto dengan validasi format dan resolusi otomatis.

6. **Laporan & Rekapitulasi:**
   - Rekap suara Ketua & Pengawas, audit trail suara masuk, dan ekspor data.

---

## 🛠️ Persyaratan Sistem

- **PHP:** 7.4 / 8.x
- **Web Server:** Apache (XAMPP / Laragon)
- **Database:** MySQL / MariaDB
- **Browser:** Chrome / Edge / Firefox modern (mendukung WebGL Three.js)

---

## 📦 Panduan Instalasi

1. Clone repositori ini:
   ```bash
   git clone https://github.com/MukhamadRoni/e-voting.git
   ```
2. Pindahkan folder proyek ke web root webserver Anda (misal `C:/xampp/htdocs/e-voting`).
3. Import database `database/db_evoting.sql` atau gunakan skema di folder `database/` ke MySQL database `db_evoting`.
4. Buka file `application/config/config.php` dan sesuaikan `$config['base_url']`.
5. Buka `application/config/database.php` dan sesuaikan koneksi database Anda.
6. Buka aplikasi di browser: `http://localhost/e-voting/`

---

## 🔐 Akun Default Admin
- **Username:** `admin`
- **Password:** `admin123`

---

## 📄 Lisensi
Hak Cipta © 2026 E-Voting Koperasi.
