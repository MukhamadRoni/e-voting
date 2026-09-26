# Spesifikasi Lingkungan Docker E-Voting (CI3)

Dokumen ini berisi spesifikasi Docker untuk menjalankan aplikasi E-Voting Koperasi berbasis CodeIgniter 3 dengan PHP 7.4 dan MySQL. Tujuannya agar environment konsisten antara local development dan server production.

## 1. Struktur Direktori
Harap buat struktur file berikut di root folder project:
- `docker-compose.yml`
- `Dockerfile`
- `application/` (Folder CI3)
- `system/` (Folder CI3)
- `index.php` (File CI3)

## 2. Dockerfile
Buatkan `Dockerfile` dengan spesifikasi image PHP 7.4 Apache dan instalasi ekstensi database yang dibutuhkan oleh CodeIgniter 3.

```dockerfile
FROM php:7.4-apache

# Install ekstensi MySQL untuk CodeIgniter 3
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Aktifkan mod_rewrite Apache (Penting untuk routing CI3)
RUN a2enmod rewrite

# Update dan install dependensi dasar (opsional/bila perlu)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

# Set working directory
WORKDIR /var/www/html
```

## 3. docker-compose.yml
Buatkan file `docker-compose.yml` untuk mengorkestrasi *web server* dan *database*. Gunakan konfigurasi berikut:

```yaml
version: '3.8'

services:
  web:
    build: .
    ports:
      - "8000:80"
    volumes:
      - ./:/var/www/html
    environment:
      - CI_ENV=development
    depends_on:
      - db

  db:
    image: mysql:5.7
    ports:
      - "3306:3306"
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: db_evoting
      MYSQL_USER: user_evoting
      MYSQL_PASSWORD: password_evoting
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

## 4. Instruksi Migrasi (Local ke Server)
Untuk memindahkan aplikasi ke server, cukup berikan instruksi ini pada terminal server:
1. Pindahkan seluruh file project (termasuk `docker-compose.yml` dan `Dockerfile`) ke server.
2. Jalankan perintah `docker-compose up -d --build` di server.
3. Import database hasil export dari lokal ke MySQL container di server (bisa menggunakan phpMyAdmin tambahan jika diperlukan, atau via CLI Docker).
```