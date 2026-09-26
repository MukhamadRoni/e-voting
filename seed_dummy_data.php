<?php
/**
 * Seeder Dummy Data untuk E-Voting Koperasi
 */
define('BASEPATH', 'cli');
require_once __DIR__ . '/application/config/database.php';

$db_config = $db['default'];
$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error . "\n");
}

echo "=== MEMBUAT AVATAR PLACEHOLDER KANDIDAT ===\n";
$upload_dir = __DIR__ . '/assets/uploads/kandidat/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

function generate_avatar($filepath, $initials, $bg_color_hex) {
    $size = 200;
    $img = imagecreatetruecolor($size, $size);

    // Parse hex color
    list($r, $g, $b) = sscanf($bg_color_hex, "#%02x%02x%02x");
    $bg = imagecolorallocate($img, $r, $g, $b);
    imagefilledrectangle($img, 0, 0, $size, $size, $bg);

    // Text color
    $white = imagecolorallocate($img, 255, 255, 255);
    $font_size = 5; // Built-in font 1-5
    $text = $initials;
    $font_width = imagefontwidth($font_size) * strlen($text);
    $font_height = imagefontheight($font_size);
    $x = ($size - $font_width) / 2;
    $y = ($size - $font_height) / 2;

    imagestring($img, $font_size, $x, $y, $text, $white);
    imagepng($img, $filepath);
    imagedestroy($img);
}

generate_avatar($upload_dir . 'ketua_budi.png', 'BS', '#2563eb');
generate_avatar($upload_dir . 'ketua_siti.png', 'SR', '#7c3aed');
generate_avatar($upload_dir . 'ketua_hendra.png', 'HG', '#059669');
generate_avatar($upload_dir . 'pengawas_bambang.png', 'BW', '#d97706');
generate_avatar($upload_dir . 'pengawas_ratna.png', 'RD', '#db2777');
generate_avatar($upload_dir . 'pengawas_agus.png', 'AP', '#4b5563');

echo "Avatar kandidat berhasil dibuat di: $upload_dir\n\n";

// Disable foreign keys temporarily if any, clean tables
echo "=== RESET TABEL (KANDIDAT, PEMILIH, HASIL) ===\n";
$mysqli->query("SET FOREIGN_KEY_CHECKS = 0;");
$mysqli->query("TRUNCATE TABLE hasil;");
$mysqli->query("TRUNCATE TABLE kandidat_ketua;");
$mysqli->query("TRUNCATE TABLE kandidat_pengawas;");
$mysqli->query("TRUNCATE TABLE pemilih;");
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1;");

echo "=== MEMASUKKAN KANDIDAT KETUA ===\n";
$ketua = [
    [
        'nik' => '3201011001',
        'nama' => 'Budi Santoso, S.E.',
        'foto' => 'ketua_budi.jpg',
        'visi_misi' => "Visi:\nMenjadikan Koperasi Sejahtera Mandiri, Modern, Transparan, dan Berdaya Saing Tinggi.\n\nMisi:\n1. Digitalisasi layanan simpan pinjam dan belanja anggota.\n2. Peningkatan SHU tahunan sebesar minimal 15%.\n3. Membuka unit usaha baru yang pro-kesejahteraan anggota."
    ],
    [
        'nik' => '3201011002',
        'nama' => 'Hj. Siti Rahmawati, M.M.',
        'foto' => 'ketua_siti.jpg',
        'visi_misi' => "Visi:\nKoperasi Amanah, Inklusif, dan Berkelanjutan untuk Kemakmuran Seluruh Anggota.\n\nMisi:\n1. Tata kelola keuangan yang transparan berbasis audit akuntabel.\n2. Penyediaan dana pendidikan dan bantuan darurat bagi anggota.\n3. Perluasan kemitraan usaha mikro koperasi."
    ],
    [
        'nik' => '3201011003',
        'nama' => 'Hendra Gunawan, S.T.',
        'foto' => 'ketua_hendra.jpg',
        'visi_misi' => "Visi:\nTransformasi Koperasi Cepat, Tepat, dan Berbasis Teknologi Terdepan.\n\nMisi:\n1. Pengembangan aplikasi mobile koperasi untuk mempermudah transaksi.\n2. Optimalisasi pengelolaan aset koperasi untuk hasil maksimal.\n3. Pelayanan prima, ramah, dan bebas birokrasi berbelit."
    ]
];

$stmt_ketua = $mysqli->prepare("INSERT INTO kandidat_ketua (nik, nama, foto, visi_misi) VALUES (?, ?, ?, ?)");
foreach ($ketua as $k) {
    $stmt_ketua->bind_param("ssss", $k['nik'], $k['nama'], $k['foto'], $k['visi_misi']);
    $stmt_ketua->execute();
    echo "  + Kandidat Ketua: {$k['nama']} ({$k['nik']})\n";
}

echo "\n=== MEMASUKKAN KANDIDAT PENGAWAS ===\n";
$pengawas = [
    [
        'nik' => '3201022001',
        'nama' => 'Ir. Bambang Wijaya, M.Sc.',
        'foto' => 'pengawas_bambang.jpg',
        'visi_misi' => "Visi:\nPengawasan Independen, Objektif, dan Berintegritas Tinggi Demi Keberlangsungan Koperasi.\n\nMisi:\n1. Memastikan setiap transaksi sesuai dengan AD/ART dan regulasi perkoperasian.\n2. Melakukan audit berkala setiap triwulan dan mempublikasikan ringkasannya.\n3. Memberikan rekomendasi strategis bagi kemajuan pengurus."
    ],
    [
        'nik' => '3201022002',
        'nama' => 'Ratna Dewi, S.E., Ak.',
        'foto' => 'pengawas_ratna.jpg',
        'visi_misi' => "Visi:\nPengawasan Keuangan yang Akurat, Transparan, dan Tanpa Kompromi terhadap Penyimpangan.\n\nMisi:\n1. Memperkuat sistem internal control di seluruh divisi koperasi.\n2. Memastikan hak-hak simpanan dan SHU anggota terlindungi secara hukum.\n3. Membuka kanal pengaduan langsung anggota yang aman dan rahasia."
    ],
    [
        'nik' => '3201022003',
        'nama' => 'Agus Prasetyo, S.H.',
        'foto' => 'pengawas_agus.jpg',
        'visi_misi' => "Visi:\nMenegakkan Kepatuhan Hukum dan Keadilan untuk Semua Anggota Koperasi.\n\nMisi:\n1. Review kepatuhan hukum seluruh perjanjian dan kemitraan koperasi.\n2. Edukasi hak dan kewajiban anggota koperasi secara rutin.\n3. Menjaga netralitas dan independensi dewan pengawas."
    ]
];

$stmt_pengawas = $mysqli->prepare("INSERT INTO kandidat_pengawas (nik, nama, foto, visi_misi) VALUES (?, ?, ?, ?)");
foreach ($pengawas as $p) {
    $stmt_pengawas->bind_param("ssss", $p['nik'], $p['nama'], $p['foto'], $p['visi_misi']);
    $stmt_pengawas->execute();
    echo "  + Kandidat Pengawas: {$p['nama']} ({$p['nik']})\n";
}

echo "\n=== MEMASUKKAN DATA PEMILIH (25 ANGGOTA) ===\n";
$pemilih = [
    // 18 Anggota yang sudah memilih (pilih = 'T')
    ['nik' => '10001', 'rfid' => 'RFID-001001', 'nama' => 'Ahmad Fauzi', 'dept' => 'Produksi', 'pilih' => 'T'],
    ['nik' => '10002', 'rfid' => 'RFID-001002', 'nama' => 'Rina Marlina', 'dept' => 'Keuangan', 'pilih' => 'T'],
    ['nik' => '10003', 'rfid' => 'RFID-001003', 'nama' => 'Dedi Kurniawan', 'dept' => 'IT & Sistem', 'pilih' => 'T'],
    ['nik' => '10004', 'rfid' => 'RFID-001004', 'nama' => 'Dewi Lestari', 'dept' => 'HRD & GA', 'pilih' => 'T'],
    ['nik' => '10005', 'rfid' => 'RFID-001005', 'nama' => 'Fajar Pratama', 'dept' => 'Produksi', 'pilih' => 'T'],
    ['nik' => '10006', 'rfid' => 'RFID-001006', 'nama' => 'Nurul Hidayah', 'dept' => 'Marketing', 'pilih' => 'T'],
    ['nik' => '10007', 'rfid' => 'RFID-001007', 'nama' => 'Bayu Saputra', 'dept' => 'Logistik', 'pilih' => 'T'],
    ['nik' => '10008', 'rfid' => 'RFID-001008', 'nama' => 'Eka Wahyuni', 'dept' => 'Keuangan', 'pilih' => 'T'],
    ['nik' => '10009', 'rfid' => 'RFID-001009', 'nama' => 'Rizky Firmansyah', 'dept' => 'IT & Sistem', 'pilih' => 'T'],
    ['nik' => '10010', 'rfid' => 'RFID-001010', 'nama' => 'Maya Anggraini', 'dept' => 'HRD & GA', 'pilih' => 'T'],
    ['nik' => '10011', 'rfid' => 'RFID-001011', 'nama' => 'Indra Lesmana', 'dept' => 'Produksi', 'pilih' => 'T'],
    ['nik' => '10012', 'rfid' => 'RFID-001012', 'nama' => 'Sari Indah', 'dept' => 'Marketing', 'pilih' => 'T'],
    ['nik' => '10013', 'rfid' => 'RFID-001013', 'nama' => 'Hadi Purnomo', 'dept' => 'Logistik', 'pilih' => 'T'],
    ['nik' => '10014', 'rfid' => 'RFID-001014', 'nama' => 'Tri Wulandari', 'dept' => 'Produksi', 'pilih' => 'T'],
    ['nik' => '10015', 'rfid' => 'RFID-001015', 'nama' => 'Arif Setiawan', 'dept' => 'Keuangan', 'pilih' => 'T'],
    ['nik' => '10016', 'rfid' => 'RFID-001016', 'nama' => 'Fitri Handayani', 'dept' => 'HRD & GA', 'pilih' => 'T'],
    ['nik' => '10017', 'rfid' => 'RFID-001017', 'nama' => 'Bagas Wicaksono', 'dept' => 'IT & Sistem', 'pilih' => 'T'],
    ['nik' => '10018', 'rfid' => 'RFID-001018', 'nama' => 'Yuni Astuti', 'dept' => 'Marketing', 'pilih' => 'T'],

    // 7 Anggota yang belum memilih (pilih = 'F') -> Bisa untuk demo voting!
    ['nik' => '10019', 'rfid' => 'RFID-001019', 'nama' => 'Gita Permata', 'dept' => 'Keuangan', 'pilih' => 'F'],
    ['nik' => '10020', 'rfid' => 'RFID-001020', 'nama' => 'Joko Susilo', 'dept' => 'Produksi', 'pilih' => 'F'],
    ['nik' => '10021', 'rfid' => 'RFID-001021', 'nama' => 'Mega Utami', 'dept' => 'Marketing', 'pilih' => 'F'],
    ['nik' => '10022', 'rfid' => 'RFID-001022', 'nama' => 'Randi Pratama', 'dept' => 'IT & Sistem', 'pilih' => 'F'],
    ['nik' => '10023', 'rfid' => 'RFID-001023', 'nama' => 'Tari Kusuma', 'dept' => 'HRD & GA', 'pilih' => 'F'],
    ['nik' => '10024', 'rfid' => 'RFID-001024', 'nama' => 'Wahyu Hidayat', 'dept' => 'Logistik', 'pilih' => 'F'],
    ['nik' => '10025', 'rfid' => 'RFID-001025', 'nama' => 'Zulham Efendi', 'dept' => 'Produksi', 'pilih' => 'F'],
];

$stmt_pemilih = $mysqli->prepare("INSERT INTO pemilih (nik, rfid, nama, dept, pilih) VALUES (?, ?, ?, ?, ?)");
foreach ($pemilih as $p) {
    $stmt_pemilih->bind_param("sssss", $p['nik'], $p['rfid'], $p['nama'], $p['dept'], $p['pilih']);
    $stmt_pemilih->execute();
}
echo "  Total pemilih berhasil dimasukkan: " . count($pemilih) . " anggota (18 sudah memilih, 7 belum memilih).\n";

echo "\n=== MEMASUKKAN HASIL SUARA (18 SUARA SAH) ===\n";
// Distribusi voting yang realistis:
// Ketua:
//   3201011001 (Budi Santoso) -> 10 suara (55.6%)
//   3201011002 (Siti Rahmawati) -> 5 suara (27.8%)
//   3201011003 (Hendra Gunawan) -> 3 suara (16.7%)
// Pengawas:
//   3201022001 (Bambang Wijaya) -> 9 suara (50.0%)
//   3201022002 (Ratna Dewi) -> 6 suara (33.3%)
//   3201022003 (Agus Prasetyo) -> 3 suara (16.7%)

$suara = [
    ['pemilih' => '10001', 'ketua' => '3201011001', 'pengawas' => '3201022001', 'time' => '2026-09-26 08:15:22'],
    ['pemilih' => '10002', 'ketua' => '3201011002', 'pengawas' => '3201022002', 'time' => '2026-09-26 08:24:10'],
    ['pemilih' => '10003', 'ketua' => '3201011001', 'pengawas' => '3201022001', 'time' => '2026-09-26 08:35:45'],
    ['pemilih' => '10004', 'ketua' => '3201011001', 'pengawas' => '3201022002', 'time' => '2026-09-26 08:48:19'],
    ['pemilih' => '10005', 'ketua' => '3201011003', 'pengawas' => '3201022003', 'time' => '2026-09-26 09:02:50'],
    ['pemilih' => '10006', 'ketua' => '3201011001', 'pengawas' => '3201022001', 'time' => '2026-09-26 09:14:12'],
    ['pemilih' => '10007', 'ketua' => '3201011002', 'pengawas' => '3201022002', 'time' => '2026-09-26 09:28:33'],
    ['pemilih' => '10008', 'ketua' => '3201011001', 'pengawas' => '3201022001', 'time' => '2026-09-26 09:41:05'],
    ['pemilih' => '10009', 'ketua' => '3201011003', 'pengawas' => '3201022001', 'time' => '2026-09-26 10:05:40'],
    ['pemilih' => '10010', 'ketua' => '3201011002', 'pengawas' => '3201022002', 'time' => '2026-09-26 10:20:15'],
    ['pemilih' => '10011', 'ketua' => '3201011001', 'pengawas' => '3201022001', 'time' => '2026-09-26 10:45:28'],
    ['pemilih' => '10012', 'ketua' => '3201011001', 'pengawas' => '3201022003', 'time' => '2026-09-26 11:10:04'],
    ['pemilih' => '10013', 'ketua' => '3201011002', 'pengawas' => '3201022001', 'time' => '2026-09-26 11:32:18'],
    ['pemilih' => '10014', 'ketua' => '3201011001', 'pengawas' => '3201022001', 'time' => '2026-09-26 13:15:52'],
    ['pemilih' => '10015', 'ketua' => '3201011001', 'pengawas' => '3201022002', 'time' => '2026-09-26 13:40:22'],
    ['pemilih' => '10016', 'ketua' => '3201011002', 'pengawas' => '3201022002', 'time' => '2026-09-26 14:05:11'],
    ['pemilih' => '10017', 'ketua' => '3201011003', 'pengawas' => '3201022003', 'time' => '2026-09-26 14:30:45'],
    ['pemilih' => '10018', 'ketua' => '3201011001', 'pengawas' => '3201022001', 'time' => '2026-09-26 15:02:30'],
];

$stmt_hasil = $mysqli->prepare("INSERT INTO hasil (pemilih_nik, ketua_nik, pengawas_nik, created_at) VALUES (?, ?, ?, ?)");
foreach ($suara as $s) {
    $stmt_hasil->bind_param("ssss", $s['pemilih'], $s['ketua'], $s['pengawas'], $s['time']);
    $stmt_hasil->execute();
}

echo "  Total hasil voting dimasukkan: " . count($suara) . " suara.\n";
echo "\n=== PROSES SEEDING DUMMY DATA BERHASIL SEMPURNA! ===\n";

$mysqli->close();
