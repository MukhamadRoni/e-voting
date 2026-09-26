<?php if ($is_preview): ?>
<!-- ═══════════════════════════════════════════════════════════ -->
<!-- STATE 2: PRATINJAU DATA IMPORT SEBELUM DISUBMIT           -->
<!-- ═══════════════════════════════════════════════════════════ -->

<style>
.preview-summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.preview-stat-card {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 16px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
}
.stat-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stat-icon-wrap svg {
    width: 24px;
    height: 24px;
}
.filter-pills-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.filter-pill {
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 600;
    color: #4b5563;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    cursor: pointer;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    user-select: none;
}
.filter-pill:hover {
    background: #e5e7eb;
    color: #1a1a1a;
}
.filter-pill.active {
    background: #1a1a1a;
    color: #ffffff;
    border-color: #1a1a1a;
}
.filter-pill .pill-count {
    font-size: 11px;
    padding: 1px 7px;
    border-radius: 9999px;
    background: rgba(0, 0, 0, 0.08);
}
.filter-pill.active .pill-count {
    background: rgba(255, 255, 255, 0.2);
}
</style>

<!-- Action Header -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
    <div>
        <h2 style="font-size:22px; font-weight:700; color:#1a1a1a;">Pratinjau Data Import Excel</h2>
        <span style="font-size:14px; color:#6b7280;">File: <strong style="color:#1a1a1a;"><?= html_escape($file_name); ?></strong> &bull; Periksa kelayakan data sebelum disimpan secara permanen.</span>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="<?= site_url('master_user/batal_import'); ?>" class="btn btn-secondary btn-sm" id="btnBatalImport">
            ✕ Batalkan / Upload Ulang
        </a>
        <?php if ($preview_summary['valid'] > 0): ?>
            <a href="<?= site_url('master_user/simpan_import'); ?>" class="btn btn-primary btn-sm" id="btnSimpanImport" style="background:#16a34a; border-color:#16a34a;">
                ✓ Simpan <?= $preview_summary['valid']; ?> Data Valid ke Database
            </a>
        <?php else: ?>
            <button class="btn btn-primary btn-sm" disabled style="background:#9ca3af; cursor:not-allowed;">
                Tidak Ada Data Valid
            </button>
        <?php endif; ?>
    </div>
</div>

<!-- Summary Stat Cards -->
<div class="preview-summary-grid">
    <div class="preview-stat-card">
        <div class="stat-icon-wrap" style="background:#eff6ff; color:#2563eb;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <div style="font-size:24px; font-weight:700; color:#1a1a1a; line-height:1.2;"><?= $preview_summary['total']; ?></div>
            <div style="font-size:13px; color:#6b7280; margin-top:2px;">Total Baris Terdeteksi</div>
        </div>
    </div>

    <div class="preview-stat-card">
        <div class="stat-icon-wrap" style="background:#ecfdf5; color:#16a34a;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <div style="font-size:24px; font-weight:700; color:#16a34a; line-height:1.2;"><?= $preview_summary['valid']; ?></div>
            <div style="font-size:13px; color:#6b7280; margin-top:2px;">Data Valid (Siap Diimpor)</div>
        </div>
    </div>

    <div class="preview-stat-card">
        <div class="stat-icon-wrap" style="background:#fef2f2; color:#dc2626;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div>
            <div style="font-size:24px; font-weight:700; color:#dc2626; line-height:1.2;"><?= $preview_summary['invalid']; ?></div>
            <div style="font-size:13px; color:#6b7280; margin-top:2px;">Data Bermasalah (Dilewati)</div>
        </div>
    </div>
</div>

<?php if ($preview_summary['invalid'] > 0): ?>
    <div class="alert alert-error" style="text-align:left; border-radius:14px; margin-bottom:20px; font-size:13px;">
        <strong>Perhatian:</strong> Ditemukan <strong><?= $preview_summary['invalid']; ?> baris data bermasalah</strong> (duplikat NIK/RFID atau format kosong). 
        Baris yang bermasalah akan <em>otomatis dilewati</em>, dan sistem hanya akan mengimpor <strong><?= $preview_summary['valid']; ?> data pemilih yang valid</strong> saat Anda menekan tombol simpan.
    </div>
<?php endif; ?>

<!-- Preview Table Card with DataTables -->
<div class="card">
    <div class="card-header">
        <div>
            <h3>Tabel Pratinjau Baris Data Excel</h3>
            <span style="font-size:13px; color:#6b7280;">Gunakan fitur pencarian & filter untuk meninjau status setiap baris</span>
        </div>
    </div>

    <!-- Quick Status Filter Pills -->
    <div class="filter-pills-bar">
        <span style="font-size:13px; font-weight:600; color:#6b7280; margin-right:4px;">Filter Baris:</span>
        <button type="button" class="filter-pill active" data-filter="">
            <span>Semua Baris</span>
            <span class="pill-count"><?= $preview_summary['total']; ?></span>
        </button>
        <button type="button" class="filter-pill" data-filter="Valid">
            <span>Hanya Valid</span>
            <span class="pill-count" style="color:#15803d; font-weight:700;"><?= $preview_summary['valid']; ?></span>
        </button>
        <button type="button" class="filter-pill" data-filter="Bermasalah">
            <span>Hanya Bermasalah</span>
            <span class="pill-count" style="color:#dc2626; font-weight:700;"><?= $preview_summary['invalid']; ?></span>
        </button>
    </div>

    <div class="table-responsive">
        <table id="tablePreviewImport" class="dataTable" style="width:100%;">
            <thead>
                <tr>
                    <th style="width:70px; text-align:center;">Baris</th>
                    <th>NIK</th>
                    <th>RFID</th>
                    <th>Nama</th>
                    <th>Departemen</th>
                    <th style="width:140px; text-align:center;">Status</th>
                    <th>Keterangan Validasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($preview_rows as $row): ?>
                    <tr style="<?= !$row['is_valid'] ? 'background:#fffbfb;' : ''; ?>">
                        <td style="text-align:center; font-weight:600; color:#6b7280;">#<?= $row['row']; ?></td>
                        <td><strong><?= html_escape($row['nik']); ?></strong></td>
                        <td><code style="background:#f3f4f6; padding:2px 6px; border-radius:6px; font-size:12px;"><?= html_escape($row['rfid']); ?></code></td>
                        <td style="font-weight:600;"><?= html_escape($row['nama']); ?></td>
                        <td><?= html_escape($row['dept']); ?></td>
                        <td style="text-align:center;">
                            <?php if ($row['is_valid']): ?>
                                <span class="badge badge-success">Valid</span>
                            <?php else: ?>
                                <span class="badge" style="background:#fee2e2; color:#dc2626;">Bermasalah</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['is_valid']): ?>
                                <span style="color:#15803d; font-size:13px; font-weight:600;">✓ Siap Diimpor</span>
                            <?php else: ?>
                                <span style="color:#dc2626; font-size:13px; font-weight:600;">✕ <?= html_escape($row['keterangan']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
        var table = $('#tablePreviewImport').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari NIK, Nama, Dept, Keterangan...",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ baris",
                infoEmpty: "Menampilkan 0 s/d 0 dari 0 baris",
                infoFiltered: "(disaring dari _MAX_ total baris)",
                zeroRecords: "Tidak ditemukan baris yang sesuai pencarian",
                paginate: {
                    first: "«",
                    previous: "‹ Sebelumnya",
                    next: "Selanjutnya ›",
                    last: "»"
                }
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            order: [[ 0, 'asc' ]],
            columnDefs: [
                { targets: [0, 5], className: 'text-center' }
            ]
        });

        // Filter pills interaction
        $('.filter-pill').on('click', function() {
            $('.filter-pill').removeClass('active');
            $(this).addClass('active');

            var filterValue = $(this).data('filter');
            // Column 5 is Status
            table.column(5).search(filterValue ? filterValue : '').draw();
        });
    }

    // Confirmation on Commit Simpan Import
    var btnSimpan = document.getElementById('btnSimpanImport');
    if (btnSimpan) {
        btnSimpan.addEventListener('click', function(e) {
            e.preventDefault();
            var href = this.getAttribute('href');
            var validCount = <?= (int)$preview_summary['valid']; ?>;
            var invalidCount = <?= (int)$preview_summary['invalid']; ?>;

            var confirmText = 'Sebanyak <b>' + validCount + ' data pemilih yang valid</b> akan disimpan ke database.';
            if (invalidCount > 0) {
                confirmText += '<br><span style="color:#dc2626; font-size:13px;">(' + invalidCount + ' data bermasalah akan dilewati secara otomatis).</span>';
            }

            Swal.fire({
                title: 'Konfirmasi Simpan Data?',
                html: confirmText,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                confirmButtonText: 'Ya, Simpan ke Database',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menyimpan Data Pemilih...',
                        html: 'Mohon tunggu beberapa saat.',
                        allowOutsideClick: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });
                    window.location.href = href;
                }
            });
        });
    }

    // Confirmation on Cancel Import Preview
    var btnBatal = document.getElementById('btnBatalImport');
    if (btnBatal) {
        btnBatal.addEventListener('click', function(e) {
            e.preventDefault();
            var href = this.getAttribute('href');
            Swal.fire({
                title: 'Batalkan Pratinjau?',
                text: 'Data yang telah dibaca dari file Excel akan dihapus dan Anda dapat mengunggah file baru.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Kembali'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    }
});
</script>

<?php else: ?>
<!-- ═══════════════════════════════════════════════════════════ -->
<!-- STATE 1: FORM UPLOAD FILE EXCEL                            -->
<!-- ═══════════════════════════════════════════════════════════ -->

<style>
.import-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    align-items: start;
}

@media (max-width: 900px) {
    .import-grid {
        grid-template-columns: 1fr;
    }
}

/* Upload Dropzone */
.excel-dropzone {
    border: 2px dashed #d1d5db;
    border-radius: 20px;
    background: #fafafa;
    padding: 40px 24px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 20px;
}

.excel-dropzone:hover,
.excel-dropzone.dragover {
    border-color: #1a1a1a;
    background: #f5f5f7;
    transform: scale(1.01);
}

.excel-icon-circle {
    width: 68px;
    height: 68px;
    background: #ecfdf5;
    border-radius: 18px;
    margin: 0 auto 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #15803d;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.12);
}

.excel-icon-circle svg {
    width: 34px;
    height: 34px;
}

.excel-dropzone h4 {
    font-size: 17px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 4px;
}

.excel-dropzone p {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 0;
}

/* File Selected Box */
.selected-file-card {
    display: none;
    background: #ffffff;
    border: 1px solid #10b981;
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 20px;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);
}

.selected-file-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.selected-file-icon {
    width: 38px;
    height: 38px;
    background: #dcfce7;
    color: #15803d;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
}

.rule-list {
    list-style: none;
    padding: 0;
    margin: 16px 0;
}

.rule-list li {
    font-size: 13px;
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 8px;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.rule-list li strong {
    color: #1a1a1a;
}
</style>

<!-- Action Header -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <div>
        <h2 style="font-size:22px; font-weight:700; color:#1a1a1a;">Import Data Pemilih via Excel</h2>
        <span style="font-size:14px; color:#6b7280;">Tambahkan data pemilih (DPT) dalam jumlah banyak secara massal dan otomatis.</span>
    </div>
    <a href="<?= site_url('master_user'); ?>" class="btn btn-secondary btn-sm">← Kembali ke Data Pemilih</a>
</div>

<div class="import-grid">
    <!-- Card 1: Panduan & Download Template -->
    <div class="card">
        <div class="card-header">
            <h3>1. Unduh Template & Ketentuan Format</h3>
        </div>

        <p style="font-size:14px; color:#4b5563; line-height:1.5;">
            Untuk memastikan data pemilih terverifikasi dengan valid, file Excel yang diunggah <strong>wajib menggunakan struktur kolom template resmi</strong> di bawah ini.
        </p>

        <ul class="rule-list">
            <li>
                <span style="color:#10b981; font-weight:700;">✓</span>
                <span><strong>Format File:</strong> Wajib berekstensi <code>.xlsx</code> (Microsoft Excel 2007 ke atas).</span>
            </li>
            <li>
                <span style="color:#10b981; font-weight:700;">✓</span>
                <span><strong>Baris Pertama (Header):</strong> Wajib berisi persis 4 kolom: <code>NIK</code>, <code>RFID</code>, <code>Nama</code>, <code>Departemen</code>.</span>
            </li>
            <li>
                <span style="color:#10b981; font-weight:700;">✓</span>
                <span><strong>NIK:</strong> Wajib diisi, unik, tidak boleh duplikat di file maupun di database (maks. 20 karakter).</span>
            </li>
            <li>
                <span style="color:#10b981; font-weight:700;">✓</span>
                <span><strong>RFID:</strong> Wajib diisi, unik, kode kartu/tag RFID pemilih (maks. 50 karakter).</span>
            </li>
            <li>
                <span style="color:#10b981; font-weight:700;">✓</span>
                <span><strong>Nama & Departemen:</strong> Wajib diisi (tidak boleh dibiarkan kosong).</span>
            </li>
        </ul>

        <!-- Preview Contoh Tabel Excel -->
        <div style="margin: 16px 0 24px;">
            <span style="font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:#6b7280; display:block; margin-bottom:8px;">
                Contoh Struktur Tabel Template:
            </span>
            <div class="table-responsive">
                <table style="font-size:13px;">
                    <thead>
                        <tr>
                            <th style="background:#f3f4f6;">NIK</th>
                            <th style="background:#f3f4f6;">RFID</th>
                            <th style="background:#f3f4f6;">Nama</th>
                            <th style="background:#f3f4f6;">Departemen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>10026</code></td>
                            <td><code>RFID-001026</code></td>
                            <td>Dimas Prayoga</td>
                            <td>Produksi</td>
                        </tr>
                        <tr>
                            <td><code>10027</code></td>
                            <td><code>RFID-001027</code></td>
                            <td>Anisa Rahma</td>
                            <td>Keuangan</td>
                        </tr>
                        <tr>
                            <td><code>10028</code></td>
                            <td><code>RFID-001028</code></td>
                            <td>Bambang Haryono</td>
                            <td>Logistik</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="<?= site_url('master_user/download_template'); ?>" class="btn btn-secondary" style="width:100%; border-color:#1a1a1a;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Unduh Template Resmi Excel (.xlsx)
        </a>
    </div>

    <!-- Card 2: Upload Dropzone & Form Submit -->
    <div class="card">
        <div class="card-header">
            <h3>2. Unggah File Excel</h3>
        </div>

        <?= form_open_multipart('master_user/proses_import', array('id' => 'formImport')); ?>

            <div class="excel-dropzone" id="dropZone" onclick="document.getElementById('fileExcel').click()">
                <div class="excel-icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h4>Pilih File Excel</h4>
                <p>Klik di sini atau tarik file <strong>.xlsx</strong> Anda ke dalam area ini</p>
                <small style="color:#9ca3af; font-size:12px; margin-top:8px; display:block;">Maksimal ukuran file: 5MB</small>
            </div>

            <!-- Input file hidden -->
            <input type="file" name="file_excel" id="fileExcel" style="display:none;" accept=".xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>

            <!-- Card Informasi File Terpilih -->
            <div id="selectedFileCard" class="selected-file-card">
                <div class="selected-file-info">
                    <div class="selected-file-icon">XLS</div>
                    <div>
                        <strong id="fileName" style="font-size:14px; color:#1a1a1a; display:block;">nama_file.xlsx</strong>
                        <span id="fileSize" style="font-size:12px; color:#6b7280;">0 KB</span>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="resetFileSelection()" style="padding:4px 10px; font-size:12px;">
                    ✕ Ganti
                </button>
            </div>

            <button type="submit" id="btnSubmitImport" class="btn btn-primary" style="width:100%; height:48px; font-size:15px;" disabled>
                Upload & Pratinjau Data Excel →
            </button>

        <?= form_close(); ?>
    </div>
</div>

<script>
const fileInput = document.getElementById('fileExcel');
const dropZone = document.getElementById('dropZone');
const selectedFileCard = document.getElementById('selectedFileCard');
const fileNameDisplay = document.getElementById('fileName');
const fileSizeDisplay = document.getElementById('fileSize');
const btnSubmit = document.getElementById('btnSubmitImport');
const formImport = document.getElementById('formImport');

function validateAndSelectFile(file) {
    if (!file) return;

    // Validasi ekstensi harus .xlsx
    const fileName = file.name;
    const fileExt = fileName.split('.').pop().toLowerCase();

    if (fileExt !== 'xlsx') {
        Swal.fire({
            icon: 'error',
            title: 'Format File Ditolak',
            html: 'File <strong>' + fileName + '</strong> bukan file Excel berformat <code>.xlsx</code>.<br><br>Harap konversi atau simpan ulang file Anda ke format <strong>.xlsx</strong>.',
            confirmButtonColor: '#1a1a1a'
        });
        resetFileSelection();
        return;
    }

    // Validasi ukuran file (maks 5MB)
    const maxSize = 5 * 1024 * 1024;
    if (file.size > maxSize) {
        Swal.fire({
            icon: 'warning',
            title: 'File Terlalu Besar',
            text: 'Ukuran file melebihi 5MB. Silakan gunakan file dengan ukuran lebih kecil.',
            confirmButtonColor: '#1a1a1a'
        });
        resetFileSelection();
        return;
    }

    // Tampilkan informasi file
    fileNameDisplay.innerText = fileName;
    fileSizeDisplay.innerText = (file.size / 1024).toFixed(1) + ' KB';
    selectedFileCard.style.display = 'flex';
    dropZone.style.display = 'none';
    btnSubmit.disabled = false;
    btnSubmit.style.opacity = '1';
}

fileInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        validateAndSelectFile(this.files[0]);
    }
});

// Drag and drop event listeners
['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.add('dragover');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('dragover');
    }, false);
});

dropZone.addEventListener('drop', function(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    if (files && files[0]) {
        fileInput.files = files;
        validateAndSelectFile(files[0]);
    }
});

function resetFileSelection() {
    fileInput.value = '';
    selectedFileCard.style.display = 'none';
    dropZone.style.display = 'block';
    btnSubmit.disabled = true;
    btnSubmit.style.opacity = '0.5';
}

// Loading state on form submit
formImport.addEventListener('submit', function() {
    Swal.fire({
        title: 'Membaca Data Excel...',
        html: 'Sistem sedang memvalidasi struktur kolom dan menyiapkan pratinjau data.',
        allowOutsideClick: false,
        didOpen: function() {
            Swal.showLoading();
        }
    });
});
</script>
<?php endif; ?>
