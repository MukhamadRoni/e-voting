<style>
/* ── Tabs Styling per design.md ── */
.kandidat-tabs-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    border-bottom: 1px solid #e5e5e5;
    padding-bottom: 0;
    flex-wrap: wrap;
    gap: 12px;
}
.kandidat-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: -1px;
}
.tab-btn {
    padding: 12px 24px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: #6b7280;
    background: none;
    border: none;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}
.tab-btn:hover {
    color: #1a1a1a;
}
.tab-btn.active {
    color: #1a1a1a;
    font-weight: 700;
    border-bottom-color: #1a1a1a;
}
.tab-count-badge {
    background: #f5f5f7;
    color: #4b5563;
    font-size: 12px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 9999px;
}
.tab-btn.active .tab-count-badge {
    background: #1a1a1a;
    color: #ffffff;
}
.tab-panel {
    display: none;
}
.tab-panel.active {
    display: block;
}

/* Candidate Table Aesthetics */
.kandidat-avatar-cell {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    object-fit: cover;
    border: 1px solid #e5e5e5;
    background: #f3f4f6;
    display: block;
}
.kandidat-avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    background: #f3f4f6;
    border: 1px solid #e5e5e5;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 11px;
    font-weight: 600;
}
.visi-misi-preview {
    font-size: 13px;
    color: #6b7280;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    max-width: 380px;
}
.btn-view-visi {
    font-size: 12px;
    color: #2563eb;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    font-weight: 600;
    margin-top: 4px;
    display: inline-block;
}
.btn-view-visi:hover {
    text-decoration: underline;
}

/* ── Modal Design ── */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(4px);
    z-index: 9000;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.modal-overlay.open {
    display: flex;
}
.modal-box {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px 32px;
    width: 100%;
    max-width: 680px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.15);
    border: 1px solid #e5e5e5;
    position: relative;
    animation: modalIn 0.22s ease;
}
@keyframes modalIn {
    from { opacity: 0; transform: translateY(16px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.modal-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}
.modal-close {
    width: 32px;
    height: 32px;
    border-radius: 9999px;
    border: 1px solid #e5e5e5;
    background: #f5f5f7;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #6b7280;
    transition: background 0.15s;
}
.modal-close:hover {
    background: #e5e5e5;
    color: #1a1a1a;
}
.modal-error-box {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13px;
    color: #dc2626;
    margin-bottom: 18px;
    display: none;
    line-height: 1.5;
}
.modal-footer {
    display: flex;
    gap: 10px;
    margin-top: 24px;
}
.btn-loading {
    opacity: 0.7;
    pointer-events: none;
    cursor: not-allowed;
}

/* Modal Form Layout (Grid) */
.modal-kandidat-grid {
    display: grid;
    grid-template-columns: 190px 1fr;
    gap: 24px;
    align-items: start;
}
@media (max-width: 640px) {
    .modal-kandidat-grid {
        grid-template-columns: 1fr;
    }
}
.modal-photo-zone {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.modal-photo-box {
    width: 170px;
    height: 170px;
    border-radius: 20px;
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
    margin-bottom: 10px;
}
.modal-photo-box:hover,
.modal-photo-box.dragover {
    border-color: #1a1a1a;
    background: #f5f5f7;
}
.modal-photo-box.has-foto {
    border-style: solid;
    border-color: #e5e5e5;
}
.modal-photo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
    border-radius: 18px;
}
.modal-photo-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #9ca3af;
    padding: 12px;
}
.modal-photo-placeholder svg {
    width: 36px;
    height: 36px;
    stroke: #9ca3af;
    margin-bottom: 6px;
}
.modal-photo-placeholder span {
    font-size: 12px;
    font-weight: 500;
    color: #4b5563;
}
.modal-photo-placeholder small {
    font-size: 11px;
    color: #9ca3af;
}
.modal-photo-badge {
    position: absolute;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(26, 26, 26, 0.85);
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 9999px;
    white-space: nowrap;
    display: none;
}
.btn-photo-trigger {
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 9999px;
    border: 1px solid #e5e5e5;
    background: #ffffff;
    color: #1a1a1a;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-photo-trigger:hover {
    background: #f5f5f7;
}
.btn-photo-reset {
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 9999px;
    border: 1px solid #fee2e2;
    background: #fef2f2;
    color: #dc2626;
    cursor: pointer;
    display: none;
    margin-top: 6px;
}
.btn-photo-reset:hover {
    background: #fee2e2;
}

/* ── Loading Overlay Styles ── */
.modal-loading-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(2px);
    border-radius: 20px;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 20;
}
.modal-loading-overlay.show {
    display: flex;
}
.modal-loading-spinner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
.modal-loading-spinner::before {
    content: '';
    width: 32px;
    height: 32px;
    border: 3px solid #e5e5e5;
    border-top-color: #1a1a1a;
    border-radius: 50%;
    animation: dtSpin 0.7s linear infinite;
}
.modal-loading-spinner span {
    font-size: 13px;
    font-weight: 600;
    color: #4b5563;
}

/* Fullscreen Global Loading Overlay */
.global-loading-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.35);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
}
.global-loading-overlay.show {
    display: flex;
}
.global-loading-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 20px 28px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid #e5e5e5;
    animation: modalIn 0.2s ease;
}
.global-loading-spinner {
    width: 22px;
    height: 22px;
    border: 2.5px solid #e5e5e5;
    border-top-color: #1a1a1a;
    border-radius: 50%;
    animation: dtSpin 0.7s linear infinite;
    flex-shrink: 0;
}
.global-loading-text {
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #1a1a1a;
}
@keyframes dtSpin {
    to { transform: rotate(360deg); }
}

/* Table Skeleton / Loading Row */
.table-loading-row td {
    padding: 40px !important;
    text-align: center;
    color: #6b7280;
}
.table-spinner-wrap {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
}
.table-spinner {
    width: 18px;
    height: 18px;
    border: 2.5px solid #e5e5e5;
    border-top-color: #1a1a1a;
    border-radius: 50%;
    animation: dtSpin 0.7s linear infinite;
}
</style>

<!-- ═══════════════════════════════════════════════════════════
     GLOBAL LOADING OVERLAY
═══════════════════════════════════════════════════════════ -->
<div class="global-loading-overlay" id="globalLoading">
    <div class="global-loading-card">
        <div class="global-loading-spinner"></div>
        <span class="global-loading-text" id="globalLoadingText">Memproses...</span>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     MODAL FORM KANDIDAT (TAMBAH / EDIT KETUA & PENGAWAS)
═══════════════════════════════════════════════════════════ -->
<div class="modal-overlay" id="modalKandidat">
    <div class="modal-box">
        <!-- Loading Overlay Dalam Modal -->
        <div class="modal-loading-overlay" id="modalKandidatLoading">
            <div class="modal-loading-spinner">
                <span id="modalKandidatLoadingText">Menyimpan data...</span>
            </div>
        </div>

        <div class="modal-header">
            <h3 id="modalKandidatTitle">Form Data Kandidat</h3>
            <button type="button" class="modal-close" onclick="closeKandidatModal()">✕</button>
        </div>

        <div class="modal-error-box" id="modalKandidatError"></div>

        <form id="formKandidat" enctype="multipart/form-data">
            <input type="hidden" id="formKandidatKategori" name="kategori" value="ketua">
            <input type="hidden" id="formKandidatAction" name="action" value="tambah">
            <input type="hidden" id="formKandidatOrigNik" name="orig_nik" value="">

            <div class="modal-kandidat-grid">
                <!-- Kolom Kiri: Upload & Preview Foto -->
                <div class="modal-photo-zone">
                    <label style="font-size:13px; font-weight:600; margin-bottom:8px; display:block; color:#1a1a1a;">
                        Pasfoto Kandidat
                    </label>

                    <div class="modal-photo-box" id="photoDropZone" onclick="document.getElementById('inputFoto').click()">
                        <img id="imagePreview" class="modal-photo-img" alt="Pratinjau Foto">
                        <span id="badgeFoto" class="modal-photo-badge">Foto Baru</span>
                        <div id="photoPlaceholder" class="modal-photo-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                            </svg>
                            <span>Pilih Foto</span>
                            <small>Klik atau seret file ke sini</small>
                        </div>
                    </div>

                    <input type="file" id="inputFoto" name="foto" accept="image/png, image/jpeg, image/jpg, image/gif" style="display:none;" onchange="onFotoFileSelected(this)">

                    <button type="button" class="btn-photo-trigger" onclick="document.getElementById('inputFoto').click()">📁 Pilih File</button>
                    <button type="button" id="btnBatalFoto" class="btn-photo-reset" onclick="resetFotoSelection()">↺ Batal Ganti</button>
                    <small id="fotoHelpText" style="color:#9ca3af; font-size:11px; margin-top:8px; display:block;">Maks. 2MB (JPG, PNG, GIF)</small>
                </div>

                <!-- Kolom Kanan: Input Form Fields -->
                <div>
                    <div class="form-group">
                        <label for="inputNik">NIK Kandidat <span style="color:#dc2626;">*</span></label>
                        <input type="text" id="inputNik" name="nik" placeholder="Masukkan NIK kandidat" maxlength="30" required>
                        <small id="nikHelpText" style="color:#9ca3af; font-size:11px; margin-top:4px; display:none;">NIK tidak dapat diubah setelah disimpan.</small>
                    </div>

                    <div class="form-group">
                        <label for="inputNama">Nama Lengkap & Gelar <span style="color:#dc2626;">*</span></label>
                        <input type="text" id="inputNama" name="nama" placeholder="Masukkan nama lengkap kandidat" maxlength="100" required>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label for="inputVisiMisi">Visi &amp; Misi Kandidat <span style="color:#dc2626;">*</span></label>
                        <textarea id="inputVisiMisi" name="visi_misi" style="min-height:130px;" placeholder="Tuliskan poin-poin visi & misi..." required></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSubmitKandidat">Simpan Kandidat</button>
                <button type="button" class="btn btn-secondary" onclick="closeKandidatModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     HEADER ACTION & TABS
═══════════════════════════════════════════════════════════ -->
<div class="kandidat-tabs-wrap">
    <div class="kandidat-tabs">
        <button type="button" class="tab-btn active" id="tabBtnKetua" onclick="switchKandidatTab('ketua')">
            Kandidat Ketua
            <span class="tab-count-badge" id="countBadgeKetua">0</span>
        </button>
        <button type="button" class="tab-btn" id="tabBtnPengawas" onclick="switchKandidatTab('pengawas')">
            Kandidat Pengawas
            <span class="tab-count-badge" id="countBadgePengawas">0</span>
        </button>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     PANEL TAB: KANDIDAT KETUA
═══════════════════════════════════════════════════════════ -->
<div id="panel-ketua" class="tab-panel active">
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Daftar Calon Ketua Koperasi</h3>
                <span style="font-size:13px; color:#6b7280;">Kelola data profil, foto, serta visi &amp; misi calon ketua</span>
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="openTambahModal('ketua')">
                + Tambah Kandidat Ketua
            </button>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th width="80" style="text-align:center;">Foto</th>
                        <th width="140">NIK</th>
                        <th>Nama Kandidat</th>
                        <th>Visi &amp; Misi</th>
                        <th width="150" style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyKetua">
                    <tr class="table-loading-row">
                        <td colspan="5">
                            <div class="table-spinner-wrap">
                                <div class="table-spinner"></div>
                                <span>Memuat data kandidat ketua...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     PANEL TAB: KANDIDAT PENGAWAS
═══════════════════════════════════════════════════════════ -->
<div id="panel-pengawas" class="tab-panel">
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Daftar Calon Pengawas Koperasi</h3>
                <span style="font-size:13px; color:#6b7280;">Kelola data profil, foto, serta visi &amp; misi calon pengawas</span>
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="openTambahModal('pengawas')">
                + Tambah Kandidat Pengawas
            </button>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th width="80" style="text-align:center;">Foto</th>
                        <th width="140">NIK</th>
                        <th>Nama Kandidat</th>
                        <th>Visi &amp; Misi</th>
                        <th width="150" style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPengawas">
                    <tr class="table-loading-row">
                        <td colspan="5">
                            <div class="table-spinner-wrap">
                                <div class="table-spinner"></div>
                                <span>Memuat data kandidat pengawas...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     JAVASCRIPT: CLIENT-SIDE AJAX CRUD & DOM MANIPULATION
═══════════════════════════════════════════════════════════ -->
<script>
const SITE_URL = '<?= site_url(); ?>';
const BASE_URL = '<?= base_url(); ?>';

let originalPhotoUrl = '';
let _kandidatCache = { ketua: [], pengawas: [] };

// ── Inisialisasi saat Halaman Selesai Dimuat (DOM Ready) ────────────

document.addEventListener('DOMContentLoaded', function() {
    loadKandidatData();

    // Event Tutup Modal via Klik Luar (Overlay)
    const modalEl = document.getElementById('modalKandidat');
    if (modalEl) {
        modalEl.addEventListener('click', function(e) {
            if (e.target === this) {
                closeKandidatModal();
            }
        });
    }

    // Submit Form via AJAX
    const formEl = document.getElementById('formKandidat');
    if (formEl) {
        formEl.addEventListener('submit', handleFormKandidatSubmit);
    }

    // Inisialisasi Drag & Drop Foto
    initPhotoDropZone();
});

// ── Switch Tabs (Ketua vs Pengawas) ─────────────────────────────────
function switchKandidatTab(kategori) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

    const panel = document.getElementById('panel-' + kategori);
    if (panel) panel.classList.add('active');

    const btn = document.getElementById(kategori === 'ketua' ? 'tabBtnKetua' : 'tabBtnPengawas');
    if (btn) btn.classList.add('active');
}

// ── 1. READ: Ambil Data Kandidat via AJAX (JSON) ────────────────────
function loadKandidatData() {
    fetch(SITE_URL + 'master_kandidat/get_data', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network error');
        return response.json();
    })
    .then(res => {
        if (res.status === 'success') {
            _kandidatCache.ketua = res.data.ketua || [];
            _kandidatCache.pengawas = res.data.pengawas || [];

            renderKandidatTable('tbodyKetua', _kandidatCache.ketua, 'ketua');
            renderKandidatTable('tbodyPengawas', _kandidatCache.pengawas, 'pengawas');

            const badgeKetua = document.getElementById('countBadgeKetua');
            if (badgeKetua) badgeKetua.textContent = res.data.total_ketua || _kandidatCache.ketua.length;

            const badgePengawas = document.getElementById('countBadgePengawas');
            if (badgePengawas) badgePengawas.textContent = res.data.total_pengawas || _kandidatCache.pengawas.length;
        } else {
            showTableError('tbodyKetua', res.message || 'Gagal memuat data.');
            showTableError('tbodyPengawas', res.message || 'Gagal memuat data.');
        }
    })
    .catch(() => {
        showTableError('tbodyKetua', 'Gagal menghubungi server.');
        showTableError('tbodyPengawas', 'Gagal menghubungi server.');
    });
}

function renderKandidatTable(tbodyId, list, kategori) {
    const tbody = document.getElementById(tbodyId);
    if (!tbody) return;
    tbody.innerHTML = '';

    const labelKategori = kategori === 'ketua' ? 'Ketua' : 'Pengawas';

    if (!list || list.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align:center; color:#6b7280; padding:48px 24px;">
                    <div style="font-size:15px; font-weight:600; color:#1a1a1a; margin-bottom:4px;">
                        Belum Ada Data Kandidat ${labelKategori}
                    </div>
                    <div style="font-size:13px; margin-bottom:16px;">
                        Klik tombol di bawah untuk menambahkan kandidat ${labelKategori.toLowerCase()} baru.
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="openTambahModal('${kategori}')">
                        + Tambah Kandidat ${labelKategori}
                    </button>
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    list.forEach(k => {
        const fotoHtml = k.foto
            ? `<img src="${BASE_URL}assets/uploads/kandidat/${escapeHtml(k.foto)}" class="kandidat-avatar-cell" alt="${escapeHtml(k.nama)}">`
            : `<div class="kandidat-avatar-placeholder">No Foto</div>`;

        const visiMisiClean = k.visi_misi ? escapeHtml(k.visi_misi) : '-';
        const visiMisiHtml = k.visi_misi
            ? `<div class="visi-misi-preview">${visiMisiClean.replace(/\n/g, '<br>')}</div>
               <button type="button" class="btn-view-visi" onclick="bukaVisiMisiModal('${kategori}', '${escapeHtml(k.nik)}')">Lihat Selengkapnya ↗</button>`
            : `<span style="color:#9ca3af">-</span>`;

        html += `
            <tr data-nik="${escapeHtml(k.nik)}">
                <td style="text-align:center;">${fotoHtml}</td>
                <td><code>${escapeHtml(k.nik)}</code></td>
                <td>
                    <strong style="font-size:14px; color:#1a1a1a;">${escapeHtml(k.nama)}</strong>
                    <div style="font-size:12px; color:#6b7280; margin-top:2px;">Calon ${labelKategori}</div>
                </td>
                <td>${visiMisiHtml}</td>
                <td style="text-align:center;">
                    <div style="display:inline-flex; gap:6px;">
                        <button type="button" class="btn btn-secondary btn-sm" style="padding:4px 12px; font-size:12px;" onclick="openEditModal('${kategori}', '${escapeHtml(k.nik)}')">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" style="padding:4px 12px; font-size:12px;" onclick="hapusKandidat('${kategori}', '${escapeHtml(k.nik)}', '${escapeHtml(k.nama)}')">
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}


function showTableError(tbodyId, msg) {
    const tbody = document.getElementById(tbodyId);
    if (tbody) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align:center; padding:32px; color:#dc2626; font-size:13px;">
                    ⚠️ ${escapeHtml(msg)}
                </td>
            </tr>
        `;
    }
}

// ── 2. MODAL & FORM CONTROLLER ──────────────────────────────────────
function openTambahModal(kategori) {
    resetKandidatForm();

    const label = kategori === 'ketua' ? 'Ketua' : 'Pengawas';
    document.getElementById('modalKandidatTitle').textContent = `Tambah Calon ${label}`;
    document.getElementById('btnSubmitKandidat').textContent = `Simpan Kandidat ${label}`;
    document.getElementById('formKandidatKategori').value = kategori;
    document.getElementById('formKandidatAction').value = 'tambah';
    document.getElementById('formKandidatOrigNik').value = '';

    const inputNik = document.getElementById('inputNik');
    inputNik.readOnly = false;
    inputNik.style.background = '#ffffff';
    inputNik.style.cursor = 'text';
    inputNik.style.color = '#1a1a1a';
    document.getElementById('nikHelpText').style.display = 'none';

    document.getElementById('modalKandidat').classList.add('open');
    inputNik.focus();
}

function openEditModal(kategori, nik) {
    resetKandidatForm();

    const label = kategori === 'ketua' ? 'Ketua' : 'Pengawas';
    document.getElementById('modalKandidatTitle').textContent = `Edit Calon ${label}`;
    document.getElementById('btnSubmitKandidat').textContent = 'Perbarui Data';
    document.getElementById('formKandidatKategori').value = kategori;
    document.getElementById('formKandidatAction').value = 'edit';
    document.getElementById('formKandidatOrigNik').value = nik;

    const inputNik = document.getElementById('inputNik');
    inputNik.value = nik;
    inputNik.readOnly = true;
    inputNik.style.background = '#f5f5f7';
    inputNik.style.cursor = 'not-allowed';
    inputNik.style.color = '#6b7280';
    document.getElementById('nikHelpText').style.display = 'block';

    document.getElementById('modalKandidat').classList.add('open');
    showModalLoading('Memuat data kandidat...');

    const endpoint = kategori === 'ketua' ? 'get_ketua' : 'get_pengawas';

    fetch(SITE_URL + 'master_kandidat/' + endpoint + '/' + encodeURIComponent(nik), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => {
        if (!r.ok) throw new Error('HTTP error');
        return r.json();
    })
    .then(res => {
        hideModalLoading();
        if (res.status === 'success') {
            const k = res.data;
            document.getElementById('inputNama').value = k.nama || '';
            document.getElementById('inputVisiMisi').value = k.visi_misi || '';

            if (k.foto) {
                originalPhotoUrl = `${BASE_URL}assets/uploads/kandidat/${k.foto}`;
                showPhotoPreview(originalPhotoUrl, 'Foto Saat Ini', '#1a1a1a');
            } else {
                originalPhotoUrl = '';
                resetPhotoBox();
            }
            document.getElementById('inputNama').focus();
        } else {
            if (typeof Toast !== 'undefined') {
                Toast.fire({ icon: 'error', title: res.message });
            } else {
                alert(res.message);
            }
            closeKandidatModal();
        }
    })
    .catch(() => {
        hideModalLoading();
        if (typeof Toast !== 'undefined') {
            Toast.fire({ icon: 'error', title: 'Gagal memuat data dari server.' });
        } else {
            alert('Gagal memuat data dari server.');
        }
        closeKandidatModal();
    });
}

function closeKandidatModal() {
    const modal = document.getElementById('modalKandidat');
    if (modal) modal.classList.remove('open');

    const errBox = document.getElementById('modalKandidatError');
    if (errBox) {
        errBox.style.display = 'none';
        errBox.innerHTML = '';
    }
    hideModalLoading();
}

function resetKandidatForm() {
    const form = document.getElementById('formKandidat');
    if (form) form.reset();

    const errBox = document.getElementById('modalKandidatError');
    if (errBox) {
        errBox.style.display = 'none';
        errBox.innerHTML = '';
    }

    originalPhotoUrl = '';
    resetPhotoBox();
}

// ── 3. CREATE & UPDATE: Submit Form via AJAX (FormData) ─────────────
function handleFormKandidatSubmit(e) {
    e.preventDefault();

    const kategori = document.getElementById('formKandidatKategori').value;
    const action   = document.getElementById('formKandidatAction').value;
    const origNik  = document.getElementById('formKandidatOrigNik').value;

    let targetUrl = '';
    if (action === 'tambah') {
        targetUrl = kategori === 'ketua' ? 'master_kandidat/tambah_ketua' : 'master_kandidat/tambah_pengawas';
    } else {
        targetUrl = (kategori === 'ketua' ? 'master_kandidat/edit_ketua/' : 'master_kandidat/edit_pengawas/') + encodeURIComponent(origNik);
    }

    const btn = document.getElementById('btnSubmitKandidat');
    const origBtnText = btn.textContent;
    btn.classList.add('btn-loading');
    btn.textContent = 'Menyimpan...';

    showModalLoading(action === 'tambah' ? 'Menyimpan data kandidat...' : 'Memperbarui data kandidat...');
    const errBox = document.getElementById('modalKandidatError');
    errBox.style.display = 'none';
    errBox.innerHTML = '';

    const formData = new FormData(this);

    fetch(SITE_URL + targetUrl, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        hideModalLoading();
        btn.classList.remove('btn-loading');
        btn.textContent = origBtnText;

        if (res.status === 'success') {
            closeKandidatModal();
            if (typeof Toast !== 'undefined') {
                Toast.fire({ icon: 'success', title: res.message });
            }
            loadKandidatData();
        } else {
            errBox.innerHTML = res.message || 'Terjadi kesalahan.';
            errBox.style.display = 'block';
        }
    })
    .catch(() => {
        hideModalLoading();
        btn.classList.remove('btn-loading');
        btn.textContent = origBtnText;
        errBox.innerHTML = 'Terjadi kesalahan pada server. Coba beberapa saat lagi.';
        errBox.style.display = 'block';
    });
}

// ── 4. DELETE: Hapus Data via AJAX ──────────────────────────────────
function hapusKandidat(kategori, nik, nama) {
    const label = kategori === 'ketua' ? 'calon ketua' : 'calon pengawas';
    const targetUrl = (kategori === 'ketua' ? 'master_kandidat/hapus_ketua/' : 'master_kandidat/hapus_pengawas/') + encodeURIComponent(nik);

    const doDelete = function() {
        showGlobalLoading(`Menghapus data ${label}...`);

        fetch(SITE_URL + targetUrl, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            hideGlobalLoading();
            if (res.status === 'success') {
                if (typeof Toast !== 'undefined') {
                    Toast.fire({ icon: 'success', title: res.message });
                }
                loadKandidatData();
            } else {
                if (typeof Toast !== 'undefined') {
                    Toast.fire({ icon: 'error', title: res.message });
                } else {
                    alert(res.message);
                }
            }
        })
        .catch(() => {
            hideGlobalLoading();
            if (typeof Toast !== 'undefined') {
                Toast.fire({ icon: 'error', title: 'Gagal menghubungi server saat menghapus.' });
            } else {
                alert('Gagal menghubungi server saat menghapus.');
            }
        });
    };

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: `Apakah Anda yakin ingin menghapus data ${label} <strong>${escapeHtml(nama)}</strong>? Tindakan ini permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Ya, Hapus Data',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed) {
                doDelete();
            }
        });
    } else {
        if (confirm(`Apakah Anda yakin ingin menghapus data ${label} ${nama}?`)) {
            doDelete();
        }
    }
}

// ── 5. Helper Loading & Preview Foto ────────────────────────────────
function showModalLoading(text) {
    const textEl = document.getElementById('modalKandidatLoadingText');
    if (textEl) textEl.textContent = text || 'Memproses...';

    const overlay = document.getElementById('modalKandidatLoading');
    if (overlay) overlay.classList.add('show');
}

function hideModalLoading() {
    const overlay = document.getElementById('modalKandidatLoading');
    if (overlay) overlay.classList.remove('show');
}

function showGlobalLoading(text) {
    const textEl = document.getElementById('globalLoadingText');
    if (textEl) textEl.textContent = text || 'Memproses...';

    const overlay = document.getElementById('globalLoading');
    if (overlay) overlay.classList.add('show');
}

function hideGlobalLoading() {
    const overlay = document.getElementById('globalLoading');
    if (overlay) overlay.classList.remove('show');
}

function onFotoFileSelected(input) {
    const file = input.files && input.files[0];
    if (!file) return;

    if (!file.type.match('image.*')) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Format File Salah',
                text: 'Harap pilih file gambar (JPG, JPEG, PNG, atau GIF).',
                confirmButtonColor: '#1a1a1a'
            });
        } else {
            alert('Harap pilih file gambar (JPG, JPEG, PNG, atau GIF).');
        }
        input.value = '';
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'File Terlalu Besar',
                text: 'Ukuran foto maksimal adalah 2MB.',
                confirmButtonColor: '#1a1a1a'
            });
        } else {
            alert('Ukuran foto maksimal adalah 2MB.');
        }
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        showPhotoPreview(e.target.result, 'Foto Baru Terpilih', '#15803d');
        const btnBatal = document.getElementById('btnBatalFoto');
        if (btnBatal) btnBatal.style.display = 'inline-block';
    };
    reader.readAsDataURL(file);
}

function showPhotoPreview(src, badgeText, badgeColor) {
    const img = document.getElementById('imagePreview');
    img.src = src;
    img.style.display = 'block';

    document.getElementById('photoPlaceholder').style.display = 'none';

    const badge = document.getElementById('badgeFoto');
    badge.textContent = badgeText;
    badge.style.background = badgeColor;
    badge.style.display = 'block';

    document.getElementById('photoDropZone').classList.add('has-foto');
}

function resetPhotoBox() {
    document.getElementById('inputFoto').value = '';

    const img = document.getElementById('imagePreview');
    img.src = '';
    img.style.display = 'none';

    document.getElementById('photoPlaceholder').style.display = 'flex';
    document.getElementById('badgeFoto').style.display = 'none';
    document.getElementById('photoDropZone').classList.remove('has-foto');

    const btnBatal = document.getElementById('btnBatalFoto');
    if (btnBatal) btnBatal.style.display = 'none';
}

function resetFotoSelection() {
    document.getElementById('inputFoto').value = '';

    const btnBatal = document.getElementById('btnBatalFoto');
    if (btnBatal) btnBatal.style.display = 'none';

    if (originalPhotoUrl) {
        showPhotoPreview(originalPhotoUrl, 'Foto Saat Ini', '#1a1a1a');
    } else {
        resetPhotoBox();
    }
}

function initPhotoDropZone() {
    const drop = document.getElementById('photoDropZone');
    if (!drop) return;

    ['dragenter', 'dragover'].forEach(eventName => {
        drop.addEventListener(eventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
            drop.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        drop.addEventListener(eventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
            drop.classList.remove('dragover');
        });
    });

    drop.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        if (dt && dt.files && dt.files[0]) {
            document.getElementById('inputFoto').files = dt.files;
            onFotoFileSelected(document.getElementById('inputFoto'));
        }
    });
}

// Buka Pop-up Visi Misi Kandidat (Aman dari kutip/petik dan karakter khusus)
function bukaVisiMisiModal(kategori, nik) {
    const list = _kandidatCache[kategori] || [];
    const k = list.find(item => String(item.nik) === String(nik));
    if (!k) return;

    const modalTitle = 'Visi & Misi: ' + escapeHtml(k.nama);
    const modalContent = `<div style="text-align:left; background:#fafafa; padding:18px 20px; border-radius:14px; border:1px solid #e5e5e5; max-height:340px; overflow-y:auto; font-size:14px; line-height:1.65; color:#374151; white-space:pre-line;">${escapeHtml(k.visi_misi || '-')}</div>`;

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: modalTitle,
            html: modalContent,
            confirmButtonColor: '#1a1a1a',
            confirmButtonText: 'Tutup'
        });
    } else {
        alert('Visi & Misi ' + k.nama + ':\n\n' + (k.visi_misi || '-'));
    }
}

// Fallback untuk backward-compatibility
function lihatVisiMisiModal(nama, visiMisi) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Visi & Misi: ' + escapeHtml(nama),
            html: `<div style="text-align:left; background:#fafafa; padding:16px; border-radius:12px; border:1px solid #f0f0f0; max-height:280px; overflow-y:auto; font-size:14px; line-height:1.6; white-space:pre-line;">${escapeHtml(visiMisi || '-')}</div>`,
            confirmButtonColor: '#1a1a1a',
            confirmButtonText: 'Tutup'
        });
    } else {
        alert('Visi & Misi ' + nama + ':\n\n' + (visiMisi || '-'));
    }
}


function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
</script>

