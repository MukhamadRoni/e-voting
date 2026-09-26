# Arsitektur Backend CI3

## Controllers
- `Auth.php`: Handle login/logout admin menggunakan session CI3.
- `Admin.php`: Dashboard utama.
- `Master_User.php`: Handle CRUD tabel `pemilih`.
- `Master_Kandidat.php`: Handle CRUD tabel `kandidat_ketua` dan `kandidat_pengawas`.
- `Laporan.php`: Mengatur output data laporan.

## Models & Query Logic (Laporan_model.php)
Buatkan fungsi di model dengan Query Builder CI3 untuk laporan berikut:
1. **get_pemenang_ketua()**: Lakukan COUNT pada tabel `hasil` di-group berdasarkan `ketua_nik`, lalu JOIN dengan tabel `kandidat_ketua` untuk mendapatkan nama.
2. **get_pemenang_pengawas()**: Lakukan COUNT pada tabel `hasil` di-group berdasarkan `pengawas_nik`, lalu JOIN dengan tabel `kandidat_pengawas`.
3. **get_trace_back()**: Lakukan JOIN antara tabel `hasil`, `pemilih`, `kandidat_ketua`, dan `kandidat_pengawas` untuk melihat NIK Pemilih memilih siapa secara spesifik.
4. **get_peserta_undian()**: Lakukan SELECT pada tabel `pemilih` dimana status `pilih = 'T'` (True).
