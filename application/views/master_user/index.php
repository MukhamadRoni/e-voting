<!-- Daftar Data Pemilih -->

<style>
/* ── Filter Pills Bar ── */
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
    max-width: 520px;
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

/* ── Modal Loading Overlay ── */
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

/* ── Global Fullscreen Loading Overlay ── */
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

/* ── Table Loading (persis seperti master_kandidat) ── */
.table-loading-row td,
#tablePemilih tbody td.dataTables_empty {
    padding: 40px !important;
    text-align: center !important;
    color: #6b7280 !important;
}
.table-spinner-wrap {
    display: inline-flex;
    align-items: center;
    justify-content: center;
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
    flex-shrink: 0;
}
.table-overlay-loading {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(2px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 50;
    border-radius: 12px;
}
.table-overlay-loading.show {
    display: flex;
}
.dataTables_wrapper {
    position: relative !important;
}
</style>

<!-- ═══════════════════════════════════════════════════════════
     GLOBAL FULLSCREEN LOADING OVERLAY
═══════════════════════════════════════════════════════════ -->
<div class="global-loading-overlay" id="globalLoading">
    <div class="global-loading-card">
        <div class="global-loading-spinner"></div>
        <span class="global-loading-text" id="globalLoadingText">Memproses...</span>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     MODAL FORM PEMILIH (TAMBAH / EDIT)
═══════════════════════════════════════════════════════════ -->
<div class="modal-overlay" id="modalPemilih">
    <div class="modal-box">
        <!-- Loading Overlay Modal -->
        <div class="modal-loading-overlay" id="modalPemilihLoading">
            <div class="modal-loading-spinner">
                <span id="modalPemilihLoadingText">Menyimpan data...</span>
            </div>
        </div>

        <div class="modal-header">
            <h3 id="modalPemilihTitle">Form Pemilih</h3>
            <button type="button" class="modal-close" onclick="closePemilihModal()">✕</button>
        </div>

        <div class="modal-error-box" id="modalPemilihError"></div>

        <form id="formPemilih">
            <input type="hidden" id="formPemilihAction" name="action" value="tambah">
            <input type="hidden" id="formPemilihOrigNik" name="orig_nik" value="">

            <div class="form-group">
                <label for="inputNik">NIK <span style="color:#dc2626;">*</span></label>
                <input type="text" id="inputNik" name="nik" placeholder="Masukkan NIK" maxlength="20" required>
                <small id="nikHelpText" style="color:#9ca3af; font-size:11px; margin-top:4px; display:none;">NIK bersifat permanen dan tidak dapat diubah.</small>
            </div>

            <div class="form-group">
                <label for="inputRfid">Nomor RFID <span style="color:#dc2626;">*</span></label>
                <input type="text" id="inputRfid" name="rfid" placeholder="Masukkan kode RFID kartu" maxlength="50" required>
            </div>

            <div class="form-group">
                <label for="inputNama">Nama Lengkap <span style="color:#dc2626;">*</span></label>
                <input type="text" id="inputNama" name="nama" placeholder="Masukkan nama lengkap pemilih" maxlength="100" required>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label for="inputDept">Department <span style="color:#dc2626;">*</span></label>
                <input type="text" id="inputDept" name="dept" placeholder="Masukkan department / divisi" maxlength="50" required>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSubmitPemilih">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="closePemilihModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     CARD UTAMA: DAFTAR DATA PEMILIH
═══════════════════════════════════════════════════════════ -->
<div class="card">
    <div class="card-header">
        <div>
            <h3>Daftar Pemilih</h3>
            <span style="font-size:13px; color:#6b7280;">Total <strong id="totalPemilih">0</strong> anggota terdaftar dalam DPT</span>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="<?= site_url('master_user/import'); ?>" class="btn btn-secondary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Import Excel
            </a>
            <button type="button" class="btn btn-primary btn-sm" onclick="openTambahModal()">
                + Tambah Pemilih
            </button>
        </div>
    </div>

    <!-- Quick Status Filter Pills -->
    <div class="filter-pills-bar">
        <span style="font-size:13px; font-weight:600; color:#6b7280; margin-right:4px;">Filter Status:</span>
        <button type="button" class="filter-pill active" data-filter="" onclick="filterPemilihStatus('', this)">
            <span>Semua</span>
            <span class="pill-count" id="pillAll">0</span>
        </button>
        <button type="button" class="filter-pill" data-filter="Sudah Memilih" onclick="filterPemilihStatus('Sudah Memilih', this)">
            <span>Sudah Memilih</span>
            <span class="pill-count" id="pillSudah" style="color:#15803d; font-weight:700;">0</span>
        </button>
        <button type="button" class="filter-pill" data-filter="Belum Memilih" onclick="filterPemilihStatus('Belum Memilih', this)">
            <span>Belum Memilih</span>
            <span class="pill-count" id="pillBelum" style="color:#a16207; font-weight:700;">0</span>
        </button>
    </div>

    <div class="table-responsive" style="position: relative; min-height: 220px;">
        <!-- Loading Overlay (persis seperti master_kandidat) -->
        <div class="table-overlay-loading show" id="tableLoadingOverlay">
            <div class="table-spinner-wrap">
                <div class="table-spinner"></div>
                <span>Memuat data pemilih...</span>
            </div>
        </div>

        <table id="tablePemilih" class="dataTable" style="width:100%;">
            <thead>
                <tr>
                    <th style="width: 50px; text-align:center;">No</th>
                    <th>NIK</th>
                    <th>RFID</th>
                    <th>Nama</th>
                    <th>Department</th>
                    <th style="width: 130px; text-align:center;">Status Voting</th>
                    <th style="width: 140px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Diisi secara dinamis via AJAX DataTable -->
            </tbody>
        </table>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     JAVASCRIPT: CLIENT-SIDE AJAX CRUD & DOM MANIPULATION
═══════════════════════════════════════════════════════════ -->
<script>
const SITE_URL = '<?= site_url(); ?>';
let dtPemilih = null;

// ── Inisialisasi saat Halaman Selesai Dimuat (DOM Ready) ────────────
document.addEventListener('DOMContentLoaded', function() {
    initDataTable();
    loadPemilihData();

    // Event Tutup Modal via Klik Luar (Overlay)
    const modalEl = document.getElementById('modalPemilih');
    if (modalEl) {
        modalEl.addEventListener('click', function(e) {
            if (e.target === this) {
                closePemilihModal();
            }
        });
    }

    // Submit Form Pemilih via AJAX
    const formEl = document.getElementById('formPemilih');
    if (formEl) {
        formEl.addEventListener('submit', handleFormPemilihSubmit);
    }
});

// ── Inisialisasi DataTable ──────────────────────────────────────────
function initDataTable() {
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
        dtPemilih = $('#tablePemilih').DataTable({
            processing: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari NIK, Nama, Dept, RFID...",
                lengthMenu: "Tampilkan _MENU_ pemilih",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ pemilih",
                infoEmpty: "Menampilkan 0 s/d 0 dari 0 pemilih",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ditemukan data pemilih yang sesuai pencarian",
                emptyTable: '<div class="table-spinner-wrap"><div class="table-spinner"></div><span>Memuat data pemilih...</span></div>',
                paginate: {
                    first: "«",
                    previous: "‹ Sebelumnya",
                    next: "Selanjutnya ›",
                    last: "»"
                }
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            order: [[1, 'asc']], // Default sort by NIK asc
            columnDefs: [
                { targets: 0, searchable: false, orderable: false, className: 'text-center' },
                { targets: 5, className: 'text-center' },
                { targets: 6, searchable: false, orderable: false, className: 'text-center' }
            ],
            dom: '<"top-controls"lf>rt<"bottom-controls"ip>',
            drawCallback: function() {
                var api = this.api();
                var start = api.page.info().start;
                api.column(0, { page: 'current' }).nodes().each(function(cell, i) {
                    cell.innerHTML = start + i + 1;
                });
            }
        });
    }
}

// ── 1. READ: Ambil Seluruh Data Pemilih via AJAX (JSON) ─────────────
function setTableLoading(show) {
    const overlay = document.getElementById('tableLoadingOverlay');
    if (overlay) {
        if (show) {
            overlay.classList.add('show');
        } else {
            overlay.classList.remove('show');
        }
    }
}

function loadPemilihData() {
    setTableLoading(true);

    fetch(SITE_URL + 'master_user/get_data', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(res => {
        setTableLoading(false);
        if (res.status === 'success') {
            const list = res.data.pemilih || [];
            const summary = res.data.summary || { total: list.length, sudah: 0, belum: 0 };

            // Update badge dan statistik di DOM
            const totalEl = document.getElementById('totalPemilih');
            if (totalEl) totalEl.textContent = summary.total;

            const pillAll = document.getElementById('pillAll');
            if (pillAll) pillAll.textContent = summary.total;

            const pillSudah = document.getElementById('pillSudah');
            if (pillSudah) pillSudah.textContent = summary.sudah;

            const pillBelum = document.getElementById('pillBelum');
            if (pillBelum) pillBelum.textContent = summary.belum;

            // Rebuild isi baris DataTables
            if (dtPemilih) {
                dtPemilih.clear();

                if (list.length === 0) {
                    dtPemilih.draw(false);
                    const emptyCell = document.querySelector('#tablePemilih tbody td.dataTables_empty');
                    if (emptyCell) {
                        emptyCell.innerHTML = `
                            <div style="padding: 16px 0;">
                                <div style="font-size:14px; font-weight:600; color:#1a1a1a; margin-bottom:4px;">
                                    Belum Ada Data Pemilih
                                </div>
                                <div style="font-size:13px; color:#6b7280; margin-bottom:12px;">
                                    Belum ada data pemilih yang terdaftar di database.
                                </div>
                                <button type="button" class="btn btn-primary btn-sm" onclick="openTambahModal()">
                                    + Tambah Pemilih Baru
                                </button>
                            </div>
                        `;
                    }
                } else {
                    const rowsData = list.map((p, idx) => {
                        const statusBadge = p.pilih === 'T'
                            ? '<span class="badge badge-success">Sudah Memilih</span>'
                            : '<span class="badge badge-warning">Belum Memilih</span>';

                        const rfidCode = `<code style="background:#f3f4f6; padding:2px 6px; border-radius:6px; font-size:12px;">${escapeHtml(p.rfid)}</code>`;

                        const actionButtons = `
                            <div style="display:inline-flex; gap:6px;">
                                <button type="button" class="btn btn-secondary btn-sm" style="padding:4px 12px; font-size:12px;" onclick="openEditModal('${escapeHtml(p.nik)}')">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" style="padding:4px 12px; font-size:12px;" onclick="hapusPemilih('${escapeHtml(p.nik)}', '${escapeHtml(p.nama)}')">
                                    Hapus
                                </button>
                            </div>
                        `;

                        return [
                            idx + 1,
                            `<strong>${escapeHtml(p.nik)}</strong>`,
                            rfidCode,
                            `<span style="font-weight:600;">${escapeHtml(p.nama)}</span>`,
                            escapeHtml(p.dept),
                            statusBadge,
                            actionButtons
                        ];
                    });

                    dtPemilih.rows.add(rowsData).draw(false);
                }
            }
        } else {
            const emptyCell = document.querySelector('#tablePemilih tbody td.dataTables_empty');
            if (emptyCell) {
                emptyCell.innerHTML = `
                    <div style="padding: 16px 0; color: #dc2626;">
                        ⚠️ ${escapeHtml(res.message || 'Gagal memuat data pemilih.')}
                    </div>
                `;
            }
            if (typeof Toast !== 'undefined') {
                Toast.fire({ icon: 'error', title: res.message || 'Gagal memuat data.' });
            }
        }
    })
    .catch(() => {
        setTableLoading(false);
        const emptyCell = document.querySelector('#tablePemilih tbody td.dataTables_empty');
        if (emptyCell) {
            emptyCell.innerHTML = `
                <div style="padding: 16px 0; color: #dc2626;">
                    ⚠️ Gagal menghubungi server. Silakan coba lagi.
                </div>
            `;
        }
        if (typeof Toast !== 'undefined') {
            Toast.fire({ icon: 'error', title: 'Gagal menghubungi server.' });
        }
    });
}

// ── Quick Filter Pills ──────────────────────────────────────────────
function filterPemilihStatus(statusText, btnEl) {
    document.querySelectorAll('.filter-pill').forEach(el => el.classList.remove('active'));
    if (btnEl) btnEl.classList.add('active');

    if (dtPemilih) {
        // Kolom indeks 5 adalah kolom status voting
        dtPemilih.column(5).search(statusText ? statusText : '').draw();
    }
}

// ── 2. MODAL & FORM CONTROLLER ──────────────────────────────────────
function openTambahModal() {
    resetPemilihForm();

    document.getElementById('modalPemilihTitle').textContent = 'Tambah Pemilih Baru';
    document.getElementById('btnSubmitPemilih').textContent = 'Simpan';
    document.getElementById('formPemilihAction').value = 'tambah';
    document.getElementById('formPemilihOrigNik').value = '';

    const inputNik = document.getElementById('inputNik');
    inputNik.readOnly = false;
    inputNik.style.background = '#ffffff';
    inputNik.style.cursor = 'text';
    inputNik.style.color = '#1a1a1a';
    document.getElementById('nikHelpText').style.display = 'none';

    document.getElementById('modalPemilih').classList.add('open');
    inputNik.focus();
}

function openEditModal(nik) {
    resetPemilihForm();

    document.getElementById('modalPemilihTitle').textContent = 'Edit Data Pemilih';
    document.getElementById('btnSubmitPemilih').textContent = 'Perbarui Data';
    document.getElementById('formPemilihAction').value = 'edit';
    document.getElementById('formPemilihOrigNik').value = nik;

    const inputNik = document.getElementById('inputNik');
    inputNik.value = nik;
    inputNik.readOnly = true;
    inputNik.style.background = '#f5f5f7';
    inputNik.style.cursor = 'not-allowed';
    inputNik.style.color = '#6b7280';
    document.getElementById('nikHelpText').style.display = 'block';

    document.getElementById('modalPemilih').classList.add('open');
    showModalLoading('Memuat data pemilih...');

    fetch(SITE_URL + 'master_user/get_pemilih/' + encodeURIComponent(nik), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => {
        if (!r.ok) throw new Error('HTTP error');
        return r.json();
    })
    .then(res => {
        hideModalLoading();
        if (res.status === 'success') {
            const p = res.data;
            document.getElementById('inputRfid').value = p.rfid || '';
            document.getElementById('inputNama').value = p.nama || '';
            document.getElementById('inputDept').value = p.dept || '';
            document.getElementById('inputRfid').focus();
        } else {
            if (typeof Toast !== 'undefined') {
                Toast.fire({ icon: 'error', title: res.message });
            } else {
                alert(res.message);
            }
            closePemilihModal();
        }
    })
    .catch(() => {
        hideModalLoading();
        if (typeof Toast !== 'undefined') {
            Toast.fire({ icon: 'error', title: 'Gagal memuat data dari server.' });
        } else {
            alert('Gagal memuat data dari server.');
        }
        closePemilihModal();
    });
}

function closePemilihModal() {
    const modal = document.getElementById('modalPemilih');
    if (modal) modal.classList.remove('open');

    const errBox = document.getElementById('modalPemilihError');
    if (errBox) {
        errBox.style.display = 'none';
        errBox.innerHTML = '';
    }
    hideModalLoading();
}

function resetPemilihForm() {
    const form = document.getElementById('formPemilih');
    if (form) form.reset();

    const errBox = document.getElementById('modalPemilihError');
    if (errBox) {
        errBox.style.display = 'none';
        errBox.innerHTML = '';
    }
}

// ── 3. CREATE & UPDATE: Submit Form Pemilih via AJAX ────────────────
function handleFormPemilihSubmit(e) {
    e.preventDefault();

    const action  = document.getElementById('formPemilihAction').value;
    const origNik = document.getElementById('formPemilihOrigNik').value;

    const targetUrl = action === 'tambah'
        ? 'master_user/tambah'
        : 'master_user/edit/' + encodeURIComponent(origNik);

    const btn = document.getElementById('btnSubmitPemilih');
    const origBtnText = btn.textContent;
    btn.classList.add('btn-loading');
    btn.textContent = 'Menyimpan...';

    showModalLoading(action === 'tambah' ? 'Menyimpan data pemilih...' : 'Memperbarui data pemilih...');
    const errBox = document.getElementById('modalPemilihError');
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
            closePemilihModal();
            if (typeof Toast !== 'undefined') {
                Toast.fire({ icon: 'success', title: res.message });
            }
            loadPemilihData(); // Refresh DataTable tanpa reload halaman
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

// ── 4. DELETE: Hapus Pemilih via AJAX ───────────────────────────────
function hapusPemilih(nik, nama) {
    const doDelete = function() {
        showGlobalLoading('Menghapus data pemilih...');

        fetch(SITE_URL + 'master_user/hapus/' + encodeURIComponent(nik), {
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
                loadPemilihData(); // Refresh data tanpa reload halaman
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
            html: `Apakah Anda yakin ingin menghapus data pemilih <strong>${escapeHtml(nama)}</strong> (NIK: ${escapeHtml(nik)})?`,
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
        if (confirm(`Apakah Anda yakin ingin menghapus data pemilih ${nama} (NIK: ${nik})?`)) {
            doDelete();
        }
    }
}

// ── 5. Helper Loading & Utilities ───────────────────────────────────
function showModalLoading(text) {
    const textEl = document.getElementById('modalPemilihLoadingText');
    if (textEl) textEl.textContent = text || 'Memproses...';

    const overlay = document.getElementById('modalPemilihLoading');
    if (overlay) overlay.classList.add('show');
}

function hideModalLoading() {
    const overlay = document.getElementById('modalPemilihLoading');
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
