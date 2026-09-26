# Product Requirements Document (PRD) - E-Voting Koperasi

## Tech Stack
- Framework: CodeIgniter 3 (CI3)
- Database: MySQL
- PHP Version: 7.4

## Pages & Features
1. **Page Admin**
   - **Login Admin**: Autentikasi untuk masuk ke dashboard admin.
   - **Master User (Pemilih)**: CRUD data pemilih koperasi.
   - **Master Kandidat**: CRUD data kandidat (dibagi menjadi Kandidat Ketua dan Kandidat Pengawas).
   
2. **Laporan (Reports)**
   - **Pemenang Ketua Koperasi**: Menampilkan total suara tiap calon ketua beserta rinciannya.
   - **Pemenang Pengawas Koperasi**: Menampilkan total suara tiap calon pengawas beserta rinciannya.
   - **Trace Back Voting**: Menampilkan data anggota (pemilih) beserta siapa Ketua dan Pengawas yang mereka pilih.
   - **Peserta Undian**: Menampilkan daftar anggota yang berhak mengikuti undian (berdasarkan status sudah melakukan voting).
