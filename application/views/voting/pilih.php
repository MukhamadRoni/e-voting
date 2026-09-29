<style>
/* ── Container & Section Titles ── */
.voting-header {
    text-align: center;
    margin-bottom: 32px;
}
.voting-header h2 {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}
.voting-header p {
    font-size: 15px;
    color: #6b7280;
    max-width: 720px;
    margin: 0 auto;
    line-height: 1.5;
}

.voting-section {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 24px;
    padding: 28px 24px;
    margin-bottom: 32px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
}

.section-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding-bottom: 20px;
    margin-bottom: 24px;
    border-bottom: 1px solid #f3f4f6;
}

.section-head-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.section-badge-pill {
    background: #1a1a1a;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 6px 14px;
    border-radius: 9999px;
}

.section-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 2px 0;
}

.section-desc {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.25s ease;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}

.status-badge.selected {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

/* ── 3-Column Responsive Grid ── */
.candidate-row-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

/* Tablet & Laptop: Exactly 3 cards in 1 horizontal row */
@media (min-width: 768px) {
    .candidate-row-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 16px;
    }
}

@media (min-width: 1024px) {
    .candidate-row-grid {
        gap: 24px;
    }
}

/* ── Candidate Card ── */
.candidate-card {
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 20px;
    padding: 22px 18px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    cursor: pointer;
    transition: all 0.22s ease-in-out;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
}

.candidate-card:hover {
    border-color: #94a3b8;
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.07);
}

.candidate-card.is-selected {
    border-color: #16a34a;
    background: #f0fdf4;
    box-shadow: 0 10px 28px rgba(22, 163, 74, 0.16);
    transform: translateY(-3px);
}

/* Number Tag */
.candidate-number {
    position: absolute;
    top: 16px;
    left: 16px;
    width: 32px;
    height: 32px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    transition: all 0.2s ease;
}

.candidate-card.is-selected .candidate-number {
    background: #16a34a;
    color: #ffffff;
}

/* Selected Pill Tag */
.selected-badge-pill {
    position: absolute;
    top: 16px;
    right: 16px;
    background: #16a34a;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 9999px;
    display: none;
    align-items: center;
    gap: 4px;
    box-shadow: 0 2px 6px rgba(22, 163, 74, 0.3);
    animation: fadeInScale 0.2s ease;
}

.candidate-card.is-selected .selected-badge-pill {
    display: inline-flex;
}

@keyframes fadeInScale {
    0% { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

/* Candidate Photo */
.avatar-wrap {
    width: 120px;
    height: 120px;
    margin-top: 10px;
    margin-bottom: 16px;
    border-radius: 20px;
    overflow: hidden;
    background: #f3f4f6;
    border: 3px solid #ffffff;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    position: relative;
    flex-shrink: 0;
}

.candidate-card.is-selected .avatar-wrap {
    border-color: #16a34a;
    box-shadow: 0 6px 18px rgba(22, 163, 74, 0.22);
}

.avatar-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 13px;
    font-weight: 600;
    background: #f1f5f9;
}

/* Candidate Text */
.candidate-name {
    font-size: 17px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 4px;
    line-height: 1.35;
    min-height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.candidate-nik {
    font-size: 12px;
    font-weight: 500;
    color: #64748b;
    background: #f1f5f9;
    padding: 3px 12px;
    border-radius: 9999px;
    margin-bottom: 18px;
    display: inline-block;
}

.candidate-card.is-selected .candidate-nik {
    background: #dcfce7;
    color: #166534;
}

/* Candidate Action Buttons */
.card-actions {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: auto;
}

.btn-card-action {
    width: 100%;
    height: 44px;
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.15s ease;
    border: none;
    text-decoration: none;
}

.btn-visi-misi {
    background: #f8fafc;
    color: #334155;
    border: 1.5px solid #e2e8f0;
}

.btn-visi-misi:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #0f172a;
}

.btn-pilih {
    background: #1e293b;
    color: #ffffff;
}

.btn-pilih:hover {
    background: #0f172a;
    transform: translateY(-1px);
}

.candidate-card.is-selected .btn-pilih {
    background: #16a34a;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
}

.candidate-card.is-selected .btn-pilih:hover {
    background: #15803d;
}

/* ── Sticky Bottom Bar Summary ── */
.voting-sticky-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-top: 1px solid #e5e7eb;
    box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.08);
    padding: 14px 24px;
    z-index: 40;
}

.sticky-bar-inner {
    max-width: 1280px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.sticky-summary-items {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.summary-item-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #4b5563;
    flex-shrink: 0;
    transition: all 0.2s ease;
}

.summary-item.active .summary-item-icon {
    background: #dcfce7;
    color: #15803d;
}

.summary-item-content {
    display: flex;
    flex-direction: column;
}

.summary-item-label {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #6b7280;
}

.summary-item-value {
    font-size: 14px;
    font-weight: 700;
    color: #9ca3af;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 220px;
}

.summary-item.active .summary-item-value {
    color: #15803d;
}

.sticky-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-submit-vote {
    height: 48px;
    padding: 0 32px;
    border-radius: 9999px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #94a3b8;
    color: #ffffff;
}

.btn-submit-vote.ready {
    background: #16a34a;
    box-shadow: 0 4px 16px rgba(22, 163, 74, 0.35);
}

.btn-submit-vote.ready:hover {
    background: #15803d;
    transform: translateY(-1px);
}

/* Modal Visi Misi Styling */
.modal-visi-body {
    text-align: left;
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
    max-height: 60vh;
    overflow-y: auto;
    padding: 4px 8px 12px;
}

.modal-candidate-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding-bottom: 16px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.modal-candidate-avatar {
    width: 72px;
    height: 72px;
    border-radius: 16px;
    object-fit: cover;
    border: 2px solid #e5e7eb;
    background: #f3f4f6;
    flex-shrink: 0;
}

.modal-candidate-info h3 {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 4px 0;
}

.modal-candidate-info span {
    font-size: 13px;
    color: #6b7280;
}

.modal-section-title {
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #111827;
    margin: 16px 0 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.modal-text-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 16px;
    white-space: pre-line;
    font-size: 14px;
    color: #334155;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .voting-header h2 {
        font-size: 22px;
    }
    .voting-section {
        padding: 20px 14px;
        border-radius: 18px;
    }
    .avatar-wrap {
        width: 100px;
        height: 100px;
    }
    .candidate-name {
        font-size: 16px;
        min-height: auto;
    }
    .sticky-bar-inner {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    .sticky-summary-items {
        justify-content: space-between;
        gap: 12px;
    }
    .summary-item-value {
        max-width: 140px;
    }
    .btn-submit-vote {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="voting-header">
    <h2>Bilik Suara: Pemilihan Calon Ketua & Pengawas</h2>
    <p>Silakan telusuri visi & misi setiap calon, lalu tentukan <strong>1 Calon Ketua (Baris 1)</strong> dan <strong>1 Calon Pengawas (Baris 2)</strong> pilihan Anda.</p>
</div>

<!-- ========================================================
     ROW 1: CALON KETUA KOPERASI (3 KANDIDAT)
     ======================================================== -->
<section class="voting-section">
    <div class="section-head">
        <div class="section-head-left">
            <span class="section-badge-pill">Baris 1</span>
            <div>
                <h3 class="section-title">Calon Ketua Koperasi</h3>
                <p class="section-desc">Pilih salah satu dari 3 kandidat ketua koperasi di bawah ini</p>
            </div>
        </div>
        <div>
            <span class="status-badge pending" id="statusBadgeKetua">
                ⚠️ Belum Dipilih
            </span>
        </div>
    </div>

    <div class="candidate-row-grid">
        <?php if (!empty($kandidat_ketua)): ?>
            <?php foreach ($kandidat_ketua as $idx => $k): ?>
                <?php 
                    $noUrut = sprintf("%02d", $idx + 1);
                    $isSelected = ($terpilih_ketua == $k->nik);
                    $fotoUrl = $k->foto ? base_url('assets/uploads/kandidat/' . $k->foto) : '';
                ?>
                <div class="candidate-card <?= $isSelected ? 'is-selected' : ''; ?>"
                     id="card-ketua-<?= $k->nik; ?>"
                     onclick="handleCardClick('ketua', '<?= $k->nik; ?>', '<?= html_escape($k->nama); ?>', '<?= $fotoUrl; ?>', '<?= $noUrut; ?>')">
                    
                    <div class="candidate-number"><?= $noUrut; ?></div>
                    <div class="selected-badge-pill">✓ Terpilih</div>

                    <div class="avatar-wrap">
                        <?php if ($fotoUrl): ?>
                            <img src="<?= $fotoUrl; ?>" alt="<?= html_escape($k->nama); ?>" loading="lazy">
                        <?php else: ?>
                            <div class="avatar-placeholder">No Foto</div>
                        <?php endif; ?>
                    </div>

                    <div class="candidate-name"><?= html_escape($k->nama); ?></div>
                    <div class="candidate-nik">NIK: <?= $k->nik; ?></div>

                    <div class="card-actions" onclick="event.stopPropagation();">
                        <button type="button" 
                                class="btn-card-action btn-visi-misi"
                                onclick="openVisiMisiModal('Calon Ketua', '<?= $noUrut; ?>', '<?= html_escape($k->nama); ?>', '<?= $k->nik; ?>', '<?= $fotoUrl; ?>', <?= htmlspecialchars(json_encode($k->visi_misi ?: 'Tidak ada deskripsi visi & misi.'), ENT_QUOTES, 'UTF-8'); ?>, 'ketua')">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            Lihat Visi Misi
                        </button>

                        <button type="button" 
                                class="btn-card-action btn-pilih"
                                id="btn-pilih-ketua-<?= $k->nik; ?>"
                                onclick="selectCandidate('ketua', '<?= $k->nik; ?>', '<?= html_escape($k->nama); ?>', '<?= $fotoUrl; ?>', '<?= $noUrut; ?>')">
                            <?= $isSelected ? '✓ Terpilih' : 'Pilih Calon Ini'; ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; color:#6b7280; grid-column:1/-1;">Belum ada kandidat ketua yang terdaftar.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================================
     ROW 2: CALON PENGAWAS KOPERASI (3 KANDIDAT)
     ======================================================== -->
<section class="voting-section">
    <div class="section-head">
        <div class="section-head-left">
            <span class="section-badge-pill">Baris 2</span>
            <div>
                <h3 class="section-title">Calon Pengawas Koperasi</h3>
                <p class="section-desc">Pilih salah satu dari 3 kandidat pengawas koperasi di bawah ini</p>
            </div>
        </div>
        <div>
            <span class="status-badge pending" id="statusBadgePengawas">
                ⚠️ Belum Dipilih
            </span>
        </div>
    </div>

    <div class="candidate-row-grid">
        <?php if (!empty($kandidat_pengawas)): ?>
            <?php foreach ($kandidat_pengawas as $idx => $k): ?>
                <?php 
                    $noUrut = sprintf("%02d", $idx + 1);
                    $isSelected = ($terpilih_pengawas == $k->nik);
                    $fotoUrl = $k->foto ? base_url('assets/uploads/kandidat/' . $k->foto) : '';
                ?>
                <div class="candidate-card <?= $isSelected ? 'is-selected' : ''; ?>"
                     id="card-pengawas-<?= $k->nik; ?>"
                     onclick="handleCardClick('pengawas', '<?= $k->nik; ?>', '<?= html_escape($k->nama); ?>', '<?= $fotoUrl; ?>', '<?= $noUrut; ?>')">
                    
                    <div class="candidate-number"><?= $noUrut; ?></div>
                    <div class="selected-badge-pill">✓ Terpilih</div>

                    <div class="avatar-wrap">
                        <?php if ($fotoUrl): ?>
                            <img src="<?= $fotoUrl; ?>" alt="<?= html_escape($k->nama); ?>" loading="lazy">
                        <?php else: ?>
                            <div class="avatar-placeholder">No Foto</div>
                        <?php endif; ?>
                    </div>

                    <div class="candidate-name"><?= html_escape($k->nama); ?></div>
                    <div class="candidate-nik">NIK: <?= $k->nik; ?></div>

                    <div class="card-actions" onclick="event.stopPropagation();">
                        <button type="button" 
                                class="btn-card-action btn-visi-misi"
                                onclick="openVisiMisiModal('Calon Pengawas', '<?= $noUrut; ?>', '<?= html_escape($k->nama); ?>', '<?= $k->nik; ?>', '<?= $fotoUrl; ?>', <?= htmlspecialchars(json_encode($k->visi_misi ?: 'Tidak ada deskripsi visi & misi.'), ENT_QUOTES, 'UTF-8'); ?>, 'pengawas')">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            Lihat Visi Misi
                        </button>

                        <button type="button" 
                                class="btn-card-action btn-pilih"
                                id="btn-pilih-pengawas-<?= $k->nik; ?>"
                                onclick="selectCandidate('pengawas', '<?= $k->nik; ?>', '<?= html_escape($k->nama); ?>', '<?= $fotoUrl; ?>', '<?= $noUrut; ?>')">
                            <?= $isSelected ? '✓ Terpilih' : 'Pilih Calon Ini'; ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; color:#6b7280; grid-column:1/-1;">Belum ada kandidat pengawas yang terdaftar.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================================
     FORM SUBMIT TERSEMBUNYI
     ======================================================== -->
<form id="formKirimSuara" method="post" action="<?= site_url('voting/kirim_suara'); ?>">
    <input type="hidden" name="ketua_nik" id="inputKetuaNik" value="<?= html_escape($terpilih_ketua); ?>">
    <input type="hidden" name="pengawas_nik" id="inputPengawasNik" value="<?= html_escape($terpilih_pengawas); ?>">
</form>

<!-- ========================================================
     STICKY BOTTOM ACTION BAR (SUMMARY & SUBMIT)
     ======================================================== -->
<div class="voting-sticky-bar">
    <div class="sticky-bar-inner">
        <div class="sticky-summary-items">
            <!-- Calon Ketua Terpilih -->
            <div class="summary-item" id="summaryItemKetua">
                <div class="summary-item-icon">👑</div>
                <div class="summary-item-content">
                    <span class="summary-item-label">Ketua Terpilih</span>
                    <span class="summary-item-value" id="summaryKetuaVal">Belum dipilih</span>
                </div>
            </div>

            <!-- Calon Pengawas Terpilih -->
            <div class="summary-item" id="summaryItemPengawas">
                <div class="summary-item-icon">⚖️</div>
                <div class="summary-item-content">
                    <span class="summary-item-label">Pengawas Terpilih</span>
                    <span class="summary-item-value" id="summaryPengawasVal">Belum dipilih</span>
                </div>
            </div>
        </div>

        <div class="sticky-actions">
            <a href="<?= site_url('voting/batal'); ?>" class="btn btn-secondary" style="padding:10px 20px; font-size:14px;" onclick="return handleBatalClick(event, this.href);">
                Batal
            </a>
            <button type="button" class="btn-submit-vote" id="btnSubmitVote" onclick="handleKirimSuara()">
                <span>Kirim Suara</span>
                <span id="counterPilihan">(0/2)</span>
            </button>
        </div>
    </div>
</div>

<script>
// Data State Pemilihan
var currentSelection = {
    ketua: {
        nik: '<?= $terpilih_ketua; ?>',
        nama: '',
        foto: '',
        noUrut: ''
    },
    pengawas: {
        nik: '<?= $terpilih_pengawas; ?>',
        nama: '',
        foto: '',
        noUrut: ''
    }
};

// Inisialisasi awal saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Cari data awal jika sudah ada di session
    <?php if (!empty($kandidat_ketua)): ?>
        <?php foreach ($kandidat_ketua as $idx => $k): ?>
            if (currentSelection.ketua.nik === '<?= $k->nik; ?>') {
                currentSelection.ketua.nama = <?= json_encode($k->nama); ?>;
                currentSelection.ketua.foto = '<?= $k->foto ? base_url("assets/uploads/kandidat/" . $k->foto) : ""; ?>';
                currentSelection.ketua.noUrut = '<?= sprintf("%02d", $idx + 1); ?>';
            }
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($kandidat_pengawas)): ?>
        <?php foreach ($kandidat_pengawas as $idx => $k): ?>
            if (currentSelection.pengawas.nik === '<?= $k->nik; ?>') {
                currentSelection.pengawas.nama = <?= json_encode($k->nama); ?>;
                currentSelection.pengawas.foto = '<?= $k->foto ? base_url("assets/uploads/kandidat/" . $k->foto) : ""; ?>';
                currentSelection.pengawas.noUrut = '<?= sprintf("%02d", $idx + 1); ?>';
            }
        <?php endforeach; ?>
    <?php endif; ?>

    updateUiState();
});

// Handler saat kartu diklik
function handleCardClick(category, nik, nama, foto, noUrut) {
    selectCandidate(category, nik, nama, foto, noUrut);
}

// Fungsi memilih kandidat
function selectCandidate(category, nik, nama, foto, noUrut) {
    // Update data state
    currentSelection[category] = {
        nik: nik,
        nama: nama,
        foto: foto,
        noUrut: noUrut
    };

    // Update input form
    if (category === 'ketua') {
        document.getElementById('inputKetuaNik').value = nik;
    } else {
        document.getElementById('inputPengawasNik').value = nik;
    }

    // Update UI
    updateUiState();
}

// Update tampilan visual status pemilihan
function updateUiState() {
    // 1. Update Kartu Ketua
    document.querySelectorAll('[id^="card-ketua-"]').forEach(function(card) {
        card.classList.remove('is-selected');
    });
    document.querySelectorAll('[id^="btn-pilih-ketua-"]').forEach(function(btn) {
        btn.innerText = 'Pilih Calon Ini';
    });

    var statusBadgeKetua = document.getElementById('statusBadgeKetua');
    var summaryItemKetua = document.getElementById('summaryItemKetua');
    var summaryKetuaVal  = document.getElementById('summaryKetuaVal');

    if (currentSelection.ketua.nik) {
        var selectedCardKetua = document.getElementById('card-ketua-' + currentSelection.ketua.nik);
        var selectedBtnKetua  = document.getElementById('btn-pilih-ketua-' + currentSelection.ketua.nik);

        if (selectedCardKetua) selectedCardKetua.classList.add('is-selected');
        if (selectedBtnKetua) selectedBtnKetua.innerText = '✓ Terpilih';

        statusBadgeKetua.className = 'status-badge selected';
        statusBadgeKetua.innerHTML = '✓ Terpilih: ' + escapeHtml(currentSelection.ketua.nama);

        summaryItemKetua.classList.add('active');
        summaryKetuaVal.innerText = currentSelection.ketua.nama;
    } else {
        statusBadgeKetua.className = 'status-badge pending';
        statusBadgeKetua.innerHTML = '⚠️ Belum Dipilih';

        summaryItemKetua.classList.remove('active');
        summaryKetuaVal.innerText = 'Belum dipilih';
    }

    // 2. Update Kartu Pengawas
    document.querySelectorAll('[id^="card-pengawas-"]').forEach(function(card) {
        card.classList.remove('is-selected');
    });
    document.querySelectorAll('[id^="btn-pilih-pengawas-"]').forEach(function(btn) {
        btn.innerText = 'Pilih Calon Ini';
    });

    var statusBadgePengawas = document.getElementById('statusBadgePengawas');
    var summaryItemPengawas = document.getElementById('summaryItemPengawas');
    var summaryPengawasVal  = document.getElementById('summaryPengawasVal');

    if (currentSelection.pengawas.nik) {
        var selectedCardPengawas = document.getElementById('card-pengawas-' + currentSelection.pengawas.nik);
        var selectedBtnPengawas  = document.getElementById('btn-pilih-pengawas-' + currentSelection.pengawas.nik);

        if (selectedCardPengawas) selectedCardPengawas.classList.add('is-selected');
        if (selectedBtnPengawas) selectedBtnPengawas.innerText = '✓ Terpilih';

        statusBadgePengawas.className = 'status-badge selected';
        statusBadgePengawas.innerHTML = '✓ Terpilih: ' + escapeHtml(currentSelection.pengawas.nama);

        summaryItemPengawas.classList.add('active');
        summaryPengawasVal.innerText = currentSelection.pengawas.nama;
    } else {
        statusBadgePengawas.className = 'status-badge pending';
        statusBadgePengawas.innerHTML = '⚠️ Belum Dipilih';

        summaryItemPengawas.classList.remove('active');
        summaryPengawasVal.innerText = 'Belum dipilih';
    }

    // 3. Update Tombol Kirim Suara & Counter
    var btnSubmit = document.getElementById('btnSubmitVote');
    var counterPilihan = document.getElementById('counterPilihan');
    var totalSelected = (currentSelection.ketua.nik ? 1 : 0) + (currentSelection.pengawas.nik ? 1 : 0);

    counterPilihan.innerText = '(' + totalSelected + '/2)';

    if (totalSelected === 2) {
        btnSubmit.classList.add('ready');
        btnSubmit.innerHTML = '<span>✓ Kirim Suara Saya</span> <span id="counterPilihan">(2/2 Selesai)</span>';
    } else {
        btnSubmit.classList.remove('ready');
        btnSubmit.innerHTML = '<span>Kirim Suara</span> <span id="counterPilihan">(' + totalSelected + '/2)</span>';
    }
}

// Modal Visi Misi SweetAlert2
function openVisiMisiModal(categoryTitle, noUrut, nama, nik, fotoUrl, visiMisiText, category) {
    var avatarHtml = fotoUrl ? 
        '<img src="' + fotoUrl + '" class="modal-candidate-avatar" alt="' + escapeHtml(nama) + '">' :
        '<div class="modal-candidate-avatar" style="display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:12px;">No Foto</div>';

    var modalHtml = 
        '<div class="modal-candidate-header">' +
            avatarHtml +
            '<div class="modal-candidate-info">' +
                '<span style="background:#f1f5f9; color:#475569; padding:2px 10px; border-radius:9999px; font-weight:700; font-size:11px; display:inline-block; margin-bottom:4px;">' +
                    categoryTitle + ' &bull; No. ' + noUrut +
                '</span>' +
                '<h3>' + escapeHtml(nama) + '</h3>' +
                '<span>NIK: ' + nik + '</span>' +
            '</div>' +
        '</div>' +
        '<div class="modal-visi-body">' +
            '<div class="modal-section-title">📄 Visi & Misi Kandidat:</div>' +
            '<div class="modal-text-box">' + escapeHtml(visiMisiText) + '</div>' +
        '</div>';

    var isCurrent = (currentSelection[category].nik === nik);

    Swal.fire({
        html: modalHtml,
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: isCurrent ? '✓ Sudah Terpilih' : '✓ Pilih Kandidat Ini',
        cancelButtonText: 'Tutup',
        reverseButtons: true,
        width: '600px',
        padding: '24px'
    }).then(function(result) {
        if (result.isConfirmed) {
            selectCandidate(category, nik, nama, fotoUrl, noUrut);
        }
    });
}

// Handler Kirim Suara dengan Konfirmasi SweetAlert2
function handleKirimSuara() {
    if (!currentSelection.ketua.nik && !currentSelection.pengawas.nik) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilihan Belum Lengkap',
            text: 'Silakan pilih 1 Calon Ketua dan 1 Calon Pengawas terlebih dahulu.',
            confirmButtonColor: '#1a1a1a',
            confirmButtonText: 'Mengerti'
        });
        return;
    }

    if (!currentSelection.ketua.nik) {
        Swal.fire({
            icon: 'warning',
            title: 'Calon Ketua Belum Dipilih',
            text: 'Silakan pilih salah satu calon pada Baris 1 (Calon Ketua).',
            confirmButtonColor: '#1a1a1a',
            confirmButtonText: 'Pilih Ketua'
        });
        return;
    }

    if (!currentSelection.pengawas.nik) {
        Swal.fire({
            icon: 'warning',
            title: 'Calon Pengawas Belum Dipilih',
            text: 'Silakan pilih salah satu calon pada Baris 2 (Calon Pengawas).',
            confirmButtonColor: '#1a1a1a',
            confirmButtonText: 'Pilih Pengawas'
        });
        return;
    }

    // Keduanya sudah dipilih -> Tampilkan Ringkasan Konfirmasi
    var ketuaAvatar = currentSelection.ketua.foto ?
        '<img src="' + currentSelection.ketua.foto + '" style="width:70px; height:70px; border-radius:14px; object-fit:cover; margin:0 auto 10px; display:block; border:2px solid #e5e7eb;">' :
        '<div style="width:70px; height:70px; border-radius:14px; background:#f3f4f6; margin:0 auto 10px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">No Foto</div>';

    var pengawasAvatar = currentSelection.pengawas.foto ?
        '<img src="' + currentSelection.pengawas.foto + '" style="width:70px; height:70px; border-radius:14px; object-fit:cover; margin:0 auto 10px; display:block; border:2px solid #e5e7eb;">' :
        '<div style="width:70px; height:70px; border-radius:14px; background:#f3f4f6; margin:0 auto 10px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">No Foto</div>';

    var summaryConfirmHtml = 
        '<p style="font-size:14px; color:#4b5563; margin-bottom:20px;">Mohon periksa kembali pilihan Anda sebelum suara dicatat secara permanen:</p>' +
        '<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; text-align:center;">' +
            '<div style="background:#f8fafc; border:2px solid #16a34a; border-radius:16px; padding:16px 10px;">' +
                '<span style="font-size:11px; font-weight:700; color:#166534; background:#dcfce7; padding:2px 10px; border-radius:9999px; text-transform:uppercase; display:inline-block; margin-bottom:8px;">Calon Ketua</span>' +
                ketuaAvatar +
                '<div style="font-weight:700; font-size:14px; color:#111827; line-height:1.3;">' + escapeHtml(currentSelection.ketua.nama) + '</div>' +
                '<div style="font-size:12px; color:#6b7280; margin-top:2px;">NIK: ' + currentSelection.ketua.nik + '</div>' +
            '</div>' +
            '<div style="background:#f8fafc; border:2px solid #16a34a; border-radius:16px; padding:16px 10px;">' +
                '<span style="font-size:11px; font-weight:700; color:#166534; background:#dcfce7; padding:2px 10px; border-radius:9999px; text-transform:uppercase; display:inline-block; margin-bottom:8px;">Calon Pengawas</span>' +
                pengawasAvatar +
                '<div style="font-weight:700; font-size:14px; color:#111827; line-height:1.3;">' + escapeHtml(currentSelection.pengawas.nama) + '</div>' +
                '<div style="font-size:12px; color:#6b7280; margin-top:2px;">NIK: ' + currentSelection.pengawas.nik + '</div>' +
            '</div>' +
        '</div>' +
        '<div style="background:#fef3c7; border:1px solid #fde68a; color:#92400e; font-size:13px; padding:10px 14px; border-radius:10px; text-align:left; line-height:1.4;">' +
            '⚠️ <strong>Perhatian:</strong> Pilihan bersifat rahasia dan final. Hak suara hanya dapat digunakan 1 kali.' +
        '</div>';

    Swal.fire({
        title: 'Konfirmasi Pilihan Suara',
        html: summaryConfirmHtml,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '✓ Ya, Kirim Suara Sekarang',
        cancelButtonText: 'Periksa Kembali',
        reverseButtons: true,
        width: '640px'
    }).then(function(result) {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menyimpan Suara...',
                text: 'Mohon tunggu, suara Anda sedang dicatat ke sistem.',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });
            document.getElementById('formKirimSuara').submit();
        }
    });
}

// Konfirmasi pembatalan sesi
function handleBatalClick(e, url) {
    e.preventDefault();
    Swal.fire({
        title: 'Batalkan Sesi Voting?',
        text: 'Pilihan Anda akan direset dan bilik suara akan kembali ke layar awal standby.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Lanjutkan Memilih',
        reverseButtons: true
    }).then(function(result) {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
    return false;
}

// Helper escape HTML
function escapeHtml(text) {
    if (!text) return '';
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
}
</script>
