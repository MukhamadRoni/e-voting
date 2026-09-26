<style>
/* ── Two Column Layout for Profile Editing per design.md ── */
.candidate-form-grid {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 36px;
    align-items: start;
}

@media (max-width: 768px) {
    .candidate-form-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
}

/* Photo Dropzone & Preview Box */
.photo-upload-zone {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.photo-preview-box {
    width: 190px;
    height: 190px;
    border-radius: 24px;
    border: 2px dashed #d1d5db;
    background: #fafafa;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    overflow: hidden;
    position: relative;
    transition: all 0.2s ease;
    margin-bottom: 12px;
}

.photo-preview-box:hover,
.photo-preview-box.dragover {
    border-color: #1a1a1a;
    background: #f5f5f7;
    transform: scale(1.01);
}

.photo-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
    border-radius: 22px;
}

.photo-placeholder-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px;
    color: #9ca3af;
}

.photo-placeholder-content svg {
    width: 44px;
    height: 44px;
    margin-bottom: 8px;
    stroke: #9ca3af;
}

.photo-placeholder-content span {
    font-size: 13px;
    font-weight: 500;
    color: #4b5563;
    line-height: 1.3;
}

.photo-placeholder-content small {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
}

.photo-actions {
    display: flex;
    gap: 8px;
    width: 100%;
    justify-content: center;
}

.btn-upload-trigger {
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 9999px;
    border: 1px solid #e5e5e5;
    background: #ffffff;
    color: #1a1a1a;
    cursor: pointer;
    transition: background 0.15s ease;
}
.btn-upload-trigger:hover {
    background: #f5f5f7;
}

.btn-remove-photo {
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 9999px;
    border: 1px solid #fee2e2;
    background: #fef2f2;
    color: #dc2626;
    cursor: pointer;
    display: none;
}
.btn-remove-photo:hover {
    background: #fee2e2;
}

.hidden-file-input {
    display: none;
}
</style>

<div class="card">
    <div class="card-header">
        <div>
            <h3>Tambah Kandidat Ketua</h3>
            <span style="font-size:13px; color:#6b7280;">Lengkapi biodata dan unggah pasfoto calon ketua koperasi</span>
        </div>
        <a href="<?= site_url('master_kandidat'); ?>" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <?= form_open_multipart('master_kandidat/tambah_ketua', array('id' => 'formKandidat')); ?>

        <div class="candidate-form-grid">
            <!-- Kolom Kiri: Live Preview & Upload Foto -->
            <div class="photo-upload-zone">
                <label style="font-size:14px; font-weight:600; color:#1a1a1a; margin-bottom:10px; display:block;">
                    Foto Kandidat
                </label>

                <div class="photo-preview-box" id="dropZone" onclick="document.getElementById('fotoInput').click()">
                    <!-- Gambar Preview -->
                    <img id="imagePreview" class="photo-preview-img" alt="Preview Foto">

                    <!-- Konten Placeholder Default -->
                    <div id="placeholderContent" class="photo-placeholder-content">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                        <span>Pilih Foto</span>
                        <small>Klik atau tarik file ke sini</small>
                    </div>
                </div>

                <!-- Input File Asli (Hidden) -->
                <input type="file" name="foto" id="fotoInput" class="hidden-file-input" accept="image/png, image/jpeg, image/jpg, image/gif">

                <!-- Tombol Aksi Upload & Hapus -->
                <div class="photo-actions">
                    <button type="button" class="btn-upload-trigger" onclick="document.getElementById('fotoInput').click()">
                        📁 Pilih File
                    </button>
                    <button type="button" id="btnHapusPreview" class="btn-remove-photo" onclick="resetPhotoPreview()">
                        ✕ Hapus
                    </button>
                </div>

                <small style="color:#9ca3af; font-size:12px; margin-top:8px; display:block;">Format: JPG, PNG, GIF (Maks. 2MB)</small>
            </div>

            <!-- Kolom Kanan: Form Data -->
            <div>
                <div class="form-group">
                    <label for="nik">NIK Kandidat <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="nik" id="nik" value="<?= set_value('nik'); ?>" placeholder="Masukkan NIK kandidat (contoh: 3201011001)" required>
                    <div class="error-text"><?= form_error('nik'); ?></div>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap & Gelar <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="nama" id="nama" value="<?= set_value('nama'); ?>" placeholder="Masukkan nama lengkap beserta gelar (contoh: Budi Santoso, S.E.)" required>
                    <div class="error-text"><?= form_error('nama'); ?></div>
                </div>

                <div class="form-group">
                    <label for="visi_misi">Visi & Misi Kandidat <span style="color:#dc2626;">*</span></label>
                    <textarea name="visi_misi" id="visi_misi" style="min-height:160px;" placeholder="Tuliskan Visi dan Misi kandidat secara rinci..." required><?= set_value('visi_misi'); ?></textarea>
                    <div class="error-text"><?= form_error('visi_misi'); ?></div>
                </div>

                <div style="display:flex; gap:12px; margin-top:16px;">
                    <button type="submit" class="btn btn-primary" style="padding:10px 28px;">Simpan Data Kandidat</button>
                    <a href="<?= site_url('master_kandidat'); ?>" class="btn btn-secondary" style="padding:10px 24px;">Batal</a>
                </div>
            </div>
        </div>

    <?= form_close(); ?>
</div>

<script>
// Live Image Preview & Drag and Drop Handler
const fotoInput = document.getElementById('fotoInput');
const imagePreview = document.getElementById('imagePreview');
const placeholderContent = document.getElementById('placeholderContent');
const btnHapusPreview = document.getElementById('btnHapusPreview');
const dropZone = document.getElementById('dropZone');

function handleFile(file) {
    if (!file) return;

    // Validasi tipe file
    if (!file.type.match('image.*')) {
        Swal.fire({
            icon: 'error',
            title: 'File Tidak Sesuai',
            text: 'Harap pilih file gambar (JPG, JPEG, PNG, atau GIF).',
            confirmButtonColor: '#1a1a1a'
        });
        resetPhotoPreview();
        return;
    }

    // Validasi ukuran file (Maks 2MB)
    const maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        Swal.fire({
            icon: 'warning',
            title: 'Ukuran Terlalu Besar',
            text: 'Ukuran foto melebihi 2MB. Silakan gunakan foto dengan ukuran lebih kecil.',
            confirmButtonColor: '#1a1a1a'
        });
        resetPhotoPreview();
        return;
    }

    // Tampilkan live preview
    const reader = new FileReader();
    reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';
        placeholderContent.style.display = 'none';
        btnHapusPreview.style.display = 'inline-block';
        dropZone.style.borderStyle = 'solid';
        dropZone.style.borderColor = '#1a1a1a';
    };
    reader.readAsDataURL(file);
}

// Event change pada input file
fotoInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        handleFile(this.files[0]);
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
        fotoInput.files = files;
        handleFile(files[0]);
    }
});

function resetPhotoPreview() {
    fotoInput.value = '';
    imagePreview.src = '';
    imagePreview.style.display = 'none';
    placeholderContent.style.display = 'flex';
    btnHapusPreview.style.display = 'none';
    dropZone.style.borderStyle = 'dashed';
    dropZone.style.borderColor = '#d1d5db';
}
</script>
