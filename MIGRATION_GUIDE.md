# 🚀 Panduan Lengkap Migrasi & Deployment E-Voting Koperasi

Dokumen ini memuat panduan langkah-demi-langkah (*step-by-step*) untuk memindahkan (**migrasi**) aplikasi **E-Voting Koperasi Modern** ke server baru (VPS/Cloud/Dedicated Server) maupun ke komputer/localhost lain.

Tersedia **2 metode utama**:
1. [**Metode 1: Menggunakan Docker & Docker Compose**](#-metode-1-migrasi--deployment-dengan-docker--docker-compose-rekomendasi) *(Paling Cepat, Terisolasi, & Bebas Konflik Versi)*
2. [**Metode 2: Migrasi Baremetal / Native Server**](#-metode-2-migrasi-baremetal--native-server)
   - [A. Server Linux (Ubuntu / Debian VPS / Cloud)](#a-migrasi-ke-server-linux-ubuntu--debian)
   - [B. Localhost / PC Baru (Windows XAMPP / Laragon)](#b-migrasi-ke-localhost--komputer-lain-windows-xampp--laragon)
3. [**Prosedur Backup & Restore Data**](#-prosedur-backup--restore-data-antar-server)
4. [**Troubleshooting & Checklist Keamanan**](#-troubleshooting--solusi-kendala-umum)

---

## 📋 Prasyarat Sistem (System Requirements)

| Komponen | Spesifikasi Minimum | Rekomendasi |
| :--- | :--- | :--- |
| **Sistem Operasi** | Linux (Ubuntu 20.04+, Debian 11+, AlmaLinux), Windows 10/11, macOS | Ubuntu 22.04 LTS Server / Docker |
| **Web Server** | Apache 2.4+ (`mod_rewrite` aktif) atau Nginx 1.18+ | Apache 2.4 / Nginx Reverse Proxy |
| **PHP Runtime** | PHP 7.4.x s/d 8.2.x | PHP 8.1 / 8.2 |
| **Ekstensi PHP Wajib** | `mysqli`, `pdo_mysql`, `gd`, `zip`, `mbstring`, `curl`, `json` | Seluruh ekstensi terinstal aktif |
| **Database Engine** | MySQL 5.7 / 8.0 atau MariaDB 10.4+ | MySQL 8.0 / MariaDB 10.6 |
| **Browser Klien** | Chrome / Edge / Firefox dengan dukungan WebGL (untuk 3D Real Count) | Resolusi layar min. 1366x768 |

---

## 🐳 METODE 1: Migrasi & Deployment dengan Docker & Docker Compose (Rekomendasi)

Metode Docker menjamin aplikasi berjalan identik di semua platform tanpa perlu menginstal PHP atau MySQL secara manual di host OS.

### Arsitektur Container:
- **`app`**: Container PHP 8.1-Apache dengan CodeIgniter 3, ekstensi GD, Zip, MySQLi, dan Apache mod_rewrite aktif.
- **`db`**: Container MySQL 8.0 dengan otomatisasi inisialisasi skema & data dari `database/evoting_full_dump.sql`.

```
                  ┌────────────────────────────────────────┐
                  │           Host OS / Server             │
                  │                                        │
  Browser / Kiosk │   Port 8080 (Web)     Port 3307 (DB)   │
       │          └───┬───────────────────────────┬────────┘
       │              │                           │
       ▼              ▼                           ▼
┌──────────────┐ ┌───────────────┐         ┌───────────────┐
│ Layar Client │ │ Container APP │◄───────►│ Container DB  │
│ (Bilik/3D)   │ │ (PHP 8.1 CI3) │ Network │  (MySQL 8.0)  │
└──────────────┘ └───────────────┘         └───────────────┘
```

---

### Langkah 1: Clone Repositori ke Server Baru
Pastikan **Docker Engine** dan **Docker Compose** telah terinstal di server tujuan.

```bash
# Clone source code dari GitHub
git clone https://github.com/MukhamadRoni/e-voting.git /opt/e-voting
cd /opt/e-voting
```

---

### Langkah 2: Konfigurasi File Environment (`.env`)
Salin file `.env.example` menjadi `.env`, lalu sesuaikan parameter domain/IP server:

```bash
cp .env.example .env
nano .env
```

Isi parameter `.env`:
```env
# URL Akses Aplikasi (Gunakan domain atau IP Publik server)
BASE_URL=http://192.168.1.100:8080/
# Jika menggunakan Domain / HTTPS:
# BASE_URL=https://voting.koperasi-anda.com/

# Port Mapping pada Server Host
APP_PORT=8080
DB_PORT=3307

# Kredensial Database Container
DB_HOST=db
DB_USER=root
DB_PASS=PasswordKoperasiSuperAman2026!
DB_NAME=db_evoting

# Mode: development / production
CI_ENV=production
```

---

### Langkah 3: Build & Jalankan Container
Jalankan satu perintah berikut:

```bash
docker-compose up -d --build
```

Docker akan secara otomatis:
1. Mengunduh base image PHP 8.1 Apache & MySQL 8.0.
2. Memasang seluruh ekstensi PHP yang dibutuhkan (`gd`, `mysqli`, `pdo_mysql`, `zip`).
3. Mengaktifkan modul Apache `rewrite`.
4. Mengimpor skema database dan data dummy/awal dari `database/evoting_full_dump.sql`.
5. Mengatur hak akses folder `assets/uploads/` dan `application/logs/`.

---

### Langkah 4: Verifikasi & Cek Status
Periksa status kontainer yang sedang berjalan:

```bash
docker-compose ps
```

Periksa log aplikasi secara real-time jika diperlukan:
```bash
docker-compose logs -f app
```

Aplikasi kini dapat langsung diakses di peramban:
- **Panel Login Admin**: `http://<IP_SERVER>:8080/auth`
- **Bilik Suara (Kiosk)**: `http://<IP_SERVER>:8080/voting`
- **Real Count 3D Live**: `http://<IP_SERVER>:8080/real_count`
- **Bilik Undian Doorprize**: `http://<IP_SERVER>:8080/bilik_undian`

---

### Perintah Operasional Docker Penting:

| Aksi | Perintah |
| :--- | :--- |
| **Menjalankan di latar belakang** | `docker-compose up -d` |
| **Menghentikan layanan** | `docker-compose down` |
| **Menghentikan & hapus volume database** | `docker-compose down -v` *(Hati-hati: data DB terhapus)* |
| **Restart aplikasi** | `docker-compose restart app` |
| **Akses terminal kontainer web** | `docker exec -it evoting_app bash` |
| **Akses konsol MySQL** | `docker exec -it evoting_db mysql -u root -p db_evoting` |

---

## 🖥️ METODE 2: Migrasi Baremetal / Native Server

---

### A. Migrasi ke Server Linux (Ubuntu / Debian)

Gunakan panduan ini jika Anda menggunakan VPS (DigitalOcean, AWS EC2, Linode, IDCloudHost, Niagahoster, Biznet, dll.) tanpa Docker.

#### Langkah 1: Update Server & Pasang Paket Dependensi
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y apache2 mysql-server git curl unzip
sudo apt install -y php8.1 php8.1-cli php8.1-common php8.1-mysql php8.1-gd \
                    php8.1-mbstring php8.1-xml php8.1-zip php8.1-curl libapache2-mod-php8.1
```

#### Langkah 2: Aktifkan Modul Apache Rewrite
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Langkah 3: Setup Database MySQL
Masuk ke konsol MySQL di server:
```bash
sudo mysql
```

Jalankan query pembuatan database & user:
```sql
CREATE DATABASE db_evoting CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'evoting_user'@'localhost' IDENTIFIED BY 'PasswordKoperasiKuat2026!';
GRANT ALL PRIVILEGES ON db_evoting.* TO 'evoting_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Langkah 4: Clone Codebase & Import Database Dump
```bash
# Clone ke direktori DocumentRoot
sudo git clone https://github.com/MukhamadRoni/e-voting.git /var/www/html/e-voting

# Import struktur tabel dan data ke MySQL
sudo mysql -u evoting_user -p'PasswordKoperasiKuat2026!' db_evoting < /var/www/html/e-voting/database/evoting_full_dump.sql
```

#### Langkah 5: Konfigurasi VirtualHost Apache
Buat file konfigurasi VirtualHost baru:
```bash
sudo nano /etc/apache2/sites-available/evoting.conf
```

Tempelkan konfigurasi berikut (sesuaikan `ServerName` dengan domain atau IP Anda):
```apache
<VirtualHost *:80>
    ServerName voting.koperasi-anda.com
    ServerAdmin admin@koperasi-anda.com
    DocumentRoot /var/www/html/e-voting

    <Directory /var/www/html/e-voting>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/evoting_error.log
    CustomLog ${APACHE_LOG_DIR}/evoting_access.log combined
</VirtualHost>
```

Aktifkan VirtualHost dan reload Apache:
```bash
sudo a2ensite evoting.conf
sudo a2dissite 000-default.conf
sudo systemctl reload apache2
```

#### Langkah 6: Konfigurasi File Aplikasi CodeIgniter
Sesuaikan konfigurasi URL dan koneksi Database di server:

**1. Konfigurasi URL (`application/config/config.php`):**
```php
$config['base_url'] = 'http://voting.koperasi-anda.com/';
// Atau jika di subfolder: 'http://192.168.1.100/e-voting/'
$config['index_page'] = '';
```

**2. Konfigurasi Database (`application/config/database.php`):**
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'evoting_user',
    'password' => 'PasswordKoperasiKuat2026!',
    'database' => 'db_evoting',
    'dbdriver' => 'mysqli',
    // ...
);
```

#### Langkah 7: Atur Permission Folder
Pastikan Apache memiliki izin menulis ke folder uploads foto kandidat dan log sistem:
```bash
sudo chown -R www-data:www-data /var/www/html/e-voting
sudo chmod -R 755 /var/www/html/e-voting
sudo chmod -R 775 /var/www/html/e-voting/assets/uploads
sudo chmod -R 775 /var/www/html/e-voting/application/logs
```

#### Langkah 8: Pasang SSL Gratis (HTTPS) dengan Let's Encrypt (Opsional tapi Direkomendasikan)
```bash
sudo apt install -y certbot python3-certbot-apache
sudo certbot --apache -d voting.koperasi-anda.com
```

---

### B. Migrasi ke Localhost / Komputer Lain (Windows XAMPP / Laragon)

Cocok untuk instalasi pada laptop operator RAT atau server lokal di lokasi acara (offline LAN).

#### Langkah 1: Siapkan XAMPP / Laragon
1. Unduh dan pasang **XAMPP** (PHP 7.4 - 8.2) atau **Laragon**.
2. Jalankan modul **Apache** dan **MySQL**.

#### Langkah 2: Copy Codebase ke Web Root
1. Download ZIP proyek dari GitHub atau clone via Git:
   ```powershell
   git clone https://github.com/MukhamadRoni/e-voting.git C:\xampp\htdocs\e-voting
   ```
2. Pastikan file berada di `C:\xampp\htdocs\e-voting\`.

#### Langkah 3: Import Database via phpMyAdmin / Command Line
**Opsi A (phpMyAdmin):**
1. Buka browser ke `http://localhost/phpmyadmin/`
2. Buat database baru bernama `db_evoting` dengan Collation `utf8mb4_unicode_ci`.
3. Klik tab **Import** -> Pilih file `C:\xampp\htdocs\e-voting\database\evoting_full_dump.sql` -> Klik **Go / Kirim**.

**Opsi B (PowerShell / Command Prompt):**
```powershell
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS db_evoting CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
C:\xampp\mysql\bin\mysql.exe -u root db_evoting < "C:\xampp\htdocs\e-voting\database\evoting_full_dump.sql"
```

#### Langkah 4: Verifikasi Konfigurasi
Periksa file `application/config/config.php`:
```php
// Jika Apache berjalan di port default 80:
$config['base_url'] = 'http://localhost/e-voting/';

// Jika Apache berjalan di port 8080 (seperti port kustom XAMPP):
$config['base_url'] = 'http://localhost:8080/e-voting/';
```

Periksa file `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_evoting',
    'dbdriver' => 'mysqli',
    // ...
);
```

Buka browser dan uji coba di: `http://localhost/e-voting/` (atau `http://localhost:8080/e-voting/`).

---

## 💾 Prosedur Backup & Restore Data Antar Server

Jika Anda ingin memindahkan data voting dan DPT riil yang sudah berjalan ke server lain:

### 1. Export Data dari Server Asal:

**Export Database:**
```bash
# Linux / Docker
mysqldump -u root -p db_evoting > backup_evoting_$(date +%Y%m%d_%H%M%S).sql

# Windows XAMPP
C:\xampp\mysql\bin\mysqldump.exe -u root db_evoting > C:\backup_evoting.sql
```

**Export Folder Foto Kandidat:**
```bash
# Buat arsip zip foto kandidat yang diunggah
zip -r uploads_kandidat_backup.zip assets/uploads/kandidat/
```

### 2. Restore Data di Server Tujuan:

```bash
# Restore Database
mysql -u root -p db_evoting < backup_evoting.sql

# Restore Folder Foto Kandidat
unzip uploads_kandidat_backup.zip -d assets/uploads/
```

---

## 🛠️ Troubleshooting & Solusi Kendala Umum

### 1. Error 404 (Page Not Found) Saat Membuka Menu Sub-Halaman
- **Penyebab**: Modul `mod_rewrite` Apache belum aktif atau konfigurasi `AllowOverride All` belum disetujui di VirtualHost.
- **Solusi**:
  1. Pastikan file `.htaccess` ada di root folder aplikasi.
  2. Di Linux: jalankan `sudo a2enmod rewrite` dan pastikan di `/etc/apache2/apache2.conf` atau VirtualHost terdapat directive:
     ```apache
     <Directory /var/www/html/e-voting>
         AllowOverride All
     </Directory>
     ```
  3. Restart Apache: `sudo systemctl restart apache2`.

### 2. Tampilan CSS, Font DM Sans, atau Gambar Logo Rusak (Broken Assets)
- **Penyebab**: Nilai `$config['base_url']` di `application/config/config.php` tidak sesuai dengan domain/IP port tempat aplikasi berjalan.
- **Solusi**: Pastikan selalu menyertakan trailing slash `/` di akhir URL, contoh: `http://192.168.1.50/e-voting/` bukan `http://192.168.1.50/e-voting`.

### 3. Gagal Upload Foto Kandidat (Error Upload Directory Not Writable)
- **Penyebab**: Hak akses folder `./assets/uploads/kandidat/` belum diberikan izin write ke user web server (`www-data`).
- **Solusi**:
  ```bash
  sudo chmod -R 777 /var/www/html/e-voting/assets/uploads
  ```

### 4. Animasi 3D Real Count Tidak Muncul / Layar Blank Putih
- **Penyebab**: Browser tidak mendukung akselerasi WebGL atau kartu grafis dinonaktifkan.
- **Solusi**:
  1. Pastikan menggunakan browser modern (Google Chrome, Microsoft Edge, Firefox).
  2. Buka `chrome://settings/system` dan aktifkan opsi **"Use graphics acceleration when available"**.

### 5. Error Database Connection "Access Denied" atau "Connection Refused"
- **Penyebab**: Kredensial username/password/host di `application/config/database.php` tidak cocok dengan server database MySQL.
- **Solusi**: Uji koneksi terminal `mysql -u <username> -p -h <hostname> <database>` dan pastikan service MySQL berstatus aktif (`systemctl status mysql`).

---

## 🔒 Checklist Keamanan Menjelang Hari-H (Production Hardening)

Sebelum digunakan secara resmi pada acara Rapat Anggota Tahunan (RAT):

- [ ] **Ubah Environment ke Production**: Buka file `index.php` di root, ubah baris 56:
  ```php
  define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
  ```
  *(Mencegah kebocoran struktur query SQL atau pesan debug error ke layar pemilih).*
- [ ] **Ganti Password Default Admin**: Masuk ke menu admin dan ubah kata sandi default `admin` menjadi kombinasi kuat.
- [ ] **Amankan Jaringan LAN**: Jika acara diadakan offline, gunakan router WiFi terdedikasi tanpa akses internet luar untuk mencegah intervensi pihak luar.
- [ ] **Backup Berkala**: Ambil dump database cadangan sebelum sesi pemilihan dimulai dan setelah pemilihan selesai.
- [ ] **Uji Coba Bilik Suara Kiosk**: Pastikan mode fullscreen (F11) diaktifkan pada monitor bilik suara agar pemilih fokus pada antarmuka pemilihan.

---

*Dokumen ini disusun untuk E-Voting Koperasi Modern &copy; 2026. Dikembangkan dengan CodeIgniter 3, Three.js WebGL, Tailwind/DM Sans UI, dan MySQL.*
