# 📖 Template Dokumentasi Fitur E-Voting

Gunakan template ini untuk mendokumentasikan setiap fitur yang telah selesai dikerjakan oleh Agent. Buat file baru atau tambahkan ke log dokumentasi menggunakan format di bawah ini untuk setiap fitur.

---

## 📌 Nama Fitur: [Contoh: Master Data Pemilih (CRUD)]
**Status:** [Selesai / Perlu Perbaikan / Dalam Pengerjaan]
**Tanggal Selesai:** [YYYY-MM-DD]

### 1. Deskripsi Singkat
[Jelaskan fungsi dari fitur ini. Contoh: Modul ini digunakan oleh admin untuk mengelola data anggota koperasi yang memiliki hak suara, mencakup penambahan NIK, RFID, Nama, Departemen, dan melacak status apakah sudah memilih atau belum.]

### 2. Daftar File yang Terlibat / Dimodifikasi
Catat semua file CodeIgniter 3 yang dibuat atau disentuh selama pengerjaan fitur ini:
*   **Controller:** `application/controllers/[Nama_controller].php`
*   **Model:** `application/models/[Nama_model].php`
*   **View:** `application/views/[folder_view]/[nama_view].php`
*   **Lainnya:** [Misal: file JavaScript, CSS kustom, atau file Config routing]

### 3. Interaksi Database
[Sebutkan tabel yang digunakan dan operasi apa saja yang dilakukan]
*   **Tabel yang diakses:** `[nama_tabel]`
*   **Operasi:** [Misal: SELECT, INSERT, UPDATE status, DELETE]
*   **Catatan Query:** [Opsional: Tuliskan jika ada query kompleks, misalnya JOIN untuk halaman laporan]

### 4. Daftar Rute / URL (Endpoints)
Daftar URL yang bisa diakses untuk fitur ini beserta fungsinya:
*   `GET /[controller]/[method]` - [Deskripsi fungsi, misal: Menampilkan list data]
*   `POST /[controller]/[method]` - [Deskripsi fungsi, misal: Memproses form submit dan validasi]

### 5. Logika Sistem (Business Logic) & Validasi
[Jelaskan aturan khusus yang diterapkan oleh Agent pada fitur ini.]
*   *Contoh 1: Validasi form memastikan NIK tidak boleh duplikat (is_unique).*
*   *Contoh 2: Data pemilih tidak bisa dihapus jika NIK tersebut sudah tercatat di tabel `hasil` voting (mencegah error integritas relasi).*
*   *Contoh 3: Setelah berhasil insert, set flashdata session untuk notifikasi sukses.*

### 6. Langkah Pengujian (Testing Steps)
[Langkah-langkah untuk memverifikasi bahwa fitur berjalan dengan benar]
1.  Buka halaman URL `...`
2.  Lakukan aksi `[Klik tombol X / Isi form Y]`
3.  Ekspektasi Hasil: `[Muncul notifikasi sukses / Data bertambah di database / Redirect ke halaman Z]`

---