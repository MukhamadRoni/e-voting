<style>
/* ── Kiosk Viewport Optimization (No-Scroll Bilik Suara) ── */
body {
    overflow-x: hidden;
}

.main-container {
    padding: 14px 28px 84px !important;
    max-width: 1820px !important;
    width: 96% !important;
    margin: 0 auto;
    box-sizing: border-box;
}

/* ── Kiosk Stepper Panel ── */
.kiosk-stepper-panel {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}

.stepper-track-buttons {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 6px 14px;
    border-radius: 9999px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
}

.stepper-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 6px 16px;
    border-radius: 9999px;
    border: 1.5px solid transparent;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: 'DM Sans', sans-serif;
    color: #64748b;
}

.stepper-btn:hover {
    background: #f8fafc;
}

.stepper-btn.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
    box-shadow: 0 3px 10px rgba(15, 23, 42, 0.18);
}

.stepper-btn.done:not(.active) {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #166534;
}

.stepper-btn-num {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.07);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
}

.stepper-btn.active .stepper-btn-num {
    background: rgba(255, 255, 255, 0.22);
    color: #ffffff;
}

.stepper-btn.done:not(.active) .stepper-btn-num {
    background: #dcfce7;
    color: #15803d;
}

.stepper-btn-info {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.stepper-btn-category {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.75;
}

.stepper-btn-title {
    font-size: 13.5px;
    font-weight: 700;
    line-height: 1.2;
}

.stepper-btn-status {
    font-size: 11.5px;
    font-weight: 600;
    padding: 3.5px 12px;
    border-radius: 9999px;
    white-space: nowrap;
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.stepper-btn-status.pending {
    background: #f1f5f9;
    color: #64748b;
}

.stepper-btn.active .stepper-btn-status.pending {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

.stepper-btn-status.selected {
    background: #dcfce7;
    color: #15803d;
}

.stepper-btn.active .stepper-btn-status.selected {
    background: #16a34a;
    color: #ffffff;
}

.stepper-arrow-indicator {
    color: #94a3b8;
    display: flex;
    align-items: center;
}

/* ── Slider Wrapper & Horizontal Track (Slide Tanpa Reload Page) ── */
.voting-slider-wrapper {
    width: 100%;
    overflow: hidden;
    position: relative;
    border-radius: 22px;
}

.voting-slider-track {
    display: flex;
    width: 200%;
    transition: transform 0.38s cubic-bezier(0.16, 1, 0.3, 1);
    transform: translateX(0%);
    will-change: transform;
}

.voting-slider-track.show-pengawas {
    transform: translateX(-50%);
}

.voting-slide {
    width: 50%;
    flex-shrink: 0;
    box-sizing: border-box;
    padding: 2px 6px;
}

.voting-section-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 22px;
    padding: 22px 28px 24px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
}

.section-head-compact {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding-bottom: 16px;
    margin-bottom: 18px;
    border-bottom: 1px solid #f1f5f9;
}

.section-head-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.section-badge-pill {
    background: #0f172a;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 5px 14px;
    border-radius: 9999px;
}

.section-title {
    font-size: 19px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 3px 0;
}

.section-desc {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.btn-slide-nav {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 18px;
    border-radius: 9999px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #334155;
    transition: all 0.15s ease;
}

.btn-slide-nav:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #94a3b8;
}

.btn-slide-nav-next {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}

.btn-slide-nav-next:hover {
    background: #1e293b;
    color: #ffffff;
}

/* ── 3-Column Responsive Grid (Padat & Proporsional Sesuai voting_after.png) ── */
.candidate-row-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
}

.candidate-card {
    background: #ffffff;
    border: 2px solid #e2e8f0;
    border-radius: 20px;
    padding: 24px 20px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
}

.candidate-card:hover {
    border-color: #94a3b8;
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
}

.candidate-card.is-selected {
    border-color: #16a34a;
    background: #f0fdf4;
    box-shadow: 0 8px 24px rgba(22, 163, 74, 0.14);
    transform: translateY(-2px);
}

.candidate-number {
    position: absolute;
    top: 14px;
    left: 14px;
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
}

.candidate-card.is-selected .candidate-number {
    background: #16a34a;
    color: #ffffff;
}

.selected-badge-pill {
    position: absolute;
    top: 14px;
    right: 14px;
    background: #16a34a;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 9999px;
    display: none;
    align-items: center;
    gap: 4px;
}

.candidate-card.is-selected .selected-badge-pill {
    display: inline-flex;
}

.avatar-wrap {
    width: 132px;
    height: 132px;
    margin-top: 8px;
    margin-bottom: 14px;
    border-radius: 20px;
    overflow: hidden;
    background: #f3f4f6;
    border: 3px solid #ffffff;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
    flex-shrink: 0;
}

.candidate-card.is-selected .avatar-wrap {
    border-color: #16a34a;
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
    font-size: 12px;
    font-weight: 600;
    background: #f1f5f9;
}

.candidate-name {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
    line-height: 1.3;
    min-height: 42px;
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
    margin-bottom: 16px;
}

.candidate-card.is-selected .candidate-nik {
    background: #dcfce7;
    color: #166534;
}

.card-actions {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: auto;
}

.btn-card-action {
    width: 100%;
    height: 42px;
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
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
}

.btn-pilih {
    background: #0f172a;
    color: #ffffff;
}

.btn-pilih:hover {
    background: #1e293b;
}

.candidate-card.is-selected .btn-pilih {
    background: #16a34a;
    color: #ffffff;
    box-shadow: 0 3px 10px rgba(22, 163, 74, 0.25);
}

.candidate-card.is-selected .btn-pilih:hover {
    background: #15803d;
}

/* ── Sticky Bottom Bar ── */
.voting-sticky-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.96);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-top: 1px solid #e2e8f0;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
    padding: 8px 24px;
    z-index: 40;
}

.sticky-bar-inner {
    max-width: 1820px;
    width: 96%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.sticky-summary-items {
    display: flex;
    align-items: center;
    gap: 16px;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 4px 10px;
    border-radius: 12px;
    transition: background 0.15s ease;
}

.summary-item:hover {
    background: #f8fafc;
}

.summary-item-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    color: #475569;
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
    font-size: 10px;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #64748b;
}

.summary-item-value {
    font-size: 13px;
    font-weight: 700;
    color: #94a3b8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 180px;
}

.summary-item.active .summary-item-value {
    color: #166534;
}

.sticky-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-submit-vote {
    height: 44px;
    padding: 0 28px;
    border-radius: 9999px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
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
    box-shadow: 0 4px 14px rgba(22, 163, 74, 0.35);
}

.btn-submit-vote.ready:hover {
    background: #15803d;
    transform: translateY(-1px);
}

.btn-submit-vote.btn-loading {
    opacity: 0.9;
    pointer-events: none;
    cursor: not-allowed;
    background: #15803d !important;
}

.btn-submit-vote .spinner-sm {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2.5px solid rgba(255, 255, 255, 0.35);
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: dtSpin 0.7s linear infinite;
    vertical-align: middle;
}

/* ── Fullscreen Kiosk Vote Loader Overlay ── */
.vote-loading-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    -webkit-backdrop-filter: blur(8px);
    backdrop-filter: blur(8px);
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
}

.vote-loading-overlay.show {
    display: flex;
}

.vote-loading-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border-radius: 28px;
    padding: 40px 32px;
    max-width: 440px;
    width: 100%;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    animation: voteLoaderPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes voteLoaderPop {
    from { opacity: 0; transform: scale(0.92) translateY(16px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

.vote-loading-spinner-ring {
    width: 64px;
    height: 64px;
    border: 5px solid #f1f5f9;
    border-top-color: #16a34a;
    border-right-color: #16a34a;
    border-radius: 50%;
    animation: voteSpin 0.8s linear infinite;
    margin-bottom: 24px;
}

.vote-loading-spinner-ring.success {
    animation: none;
    border-color: #16a34a;
    background: #dcfce7;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vote-loading-spinner-ring.success::after {
    content: '✓';
    font-size: 32px;
    font-weight: 700;
    color: #16a34a;
    line-height: 1;
}

@keyframes voteSpin {
    to { transform: rotate(360deg); }
}

.vote-loading-title {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
    letter-spacing: -0.3px;
}

.vote-loading-desc {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 22px;
}

.vote-loading-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
    padding: 7px 16px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
}

.vote-loading-badge svg {
    stroke: #16a34a;
    flex-shrink: 0;
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
    .candidate-row-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    .stepper-btn-status {
        display: none;
    }
    .sticky-bar-inner {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    .sticky-summary-items {
        justify-content: space-between;
        gap: 10px;
    }
    .summary-item-value {
        max-width: 130px;
    }
    .btn-submit-vote {
        width: 100%;
        justify-content: center;
    }
}
</style>

<!-- ========================================================
     KIOSK STEPPER PANEL (STEP 1 & STEP 2)
     ======================================================== -->
<div class="kiosk-stepper-panel">
    <div class="stepper-track-buttons">
        <button type="button" class="stepper-btn active" id="stepBtnKetua" onclick="goToSlide(1)">
            <span class="stepper-btn-num">1</span>
            <div class="stepper-btn-info">
                <span class="stepper-btn-category">Tahap 1</span>
                <span class="stepper-btn-title">Calon Ketua</span>
            </div>
            <span class="stepper-btn-status pending" id="stepStatusKetua">Belum Dipilih</span>
        </button>

        <div class="stepper-arrow-indicator">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </div>

        <button type="button" class="stepper-btn" id="stepBtnPengawas" onclick="goToSlide(2)">
            <span class="stepper-btn-num">2</span>
            <div class="stepper-btn-info">
                <span class="stepper-btn-category">Tahap 2</span>
                <span class="stepper-btn-title">Calon Pengawas</span>
            </div>
            <span class="stepper-btn-status pending" id="stepStatusPengawas">Belum Dipilih</span>
        </button>
    </div>
</div>

<!-- ========================================================
     HORIZONTAL SLIDER WRAPPER (KETUA & PENGAWAS SEHALAMAN)
     ======================================================== -->
<div class="voting-slider-wrapper">
    <div class="voting-slider-track" id="votingSliderTrack">
        
        <!-- ── SLIDE 1: CALON KETUA KOPERASI ── -->
        <div class="voting-slide" id="slideKetua">
            <div class="voting-section-card">
                <div class="section-head-compact">
                    <div class="section-head-left">
                        <span class="section-badge-pill">Tahap 1</span>
                        <div>
                            <h3 class="section-title">Pilih 1 Calon Ketua Koperasi</h3>
                            <p class="section-desc">Pilih calon ketua pilihan Anda, sistem otomatis melanjutkan ke calon pengawas</p>
                        </div>
                    </div>
                    <div class="section-head-right">
                        <button type="button" class="btn-slide-nav btn-slide-nav-next" id="btnHeaderNextToPengawas" onclick="goToSlide(2)" style="display:none;">
                            <span>Lanjut ke Pengawas</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
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
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        Visi & Misi
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
            </div>
        </div>

        <!-- ── SLIDE 2: CALON PENGAWAS KOPERASI ── -->
        <div class="voting-slide" id="slidePengawas">
            <div class="voting-section-card">
                <div class="section-head-compact">
                    <div class="section-head-left">
                        <span class="section-badge-pill" style="background:#2563eb;">Tahap 2</span>
                        <div>
                            <h3 class="section-title">Pilih 1 Calon Pengawas Koperasi</h3>
                            <p class="section-desc">Pilih salah satu dari 3 kandidat pengawas koperasi di bawah ini</p>
                        </div>
                    </div>
                    <div class="section-head-right">
                        <button type="button" class="btn-slide-nav" onclick="goToSlide(1)">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                            <span>Ubah Pilihan Ketua</span>
                        </button>
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
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        Visi & Misi
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
            </div>
        </div>

    </div>
</div>

<!-- ========================================================
     FORM SUBMIT TERSEMBUNYI
     ======================================================== -->
<?php 
    $current_tablet = isset($tablet) && $tablet !== '' ? $tablet : $this->session->userdata('voting_tablet'); 
?>
<form id="formKirimSuara" method="post" action="<?= site_url('voting/kirim_suara'); ?>">
    <input type="hidden" name="ketua_nik" id="inputKetuaNik" value="<?= html_escape($terpilih_ketua); ?>">
    <input type="hidden" name="pengawas_nik" id="inputPengawasNik" value="<?= html_escape($terpilih_pengawas); ?>">
    <input type="hidden" name="tablet" id="inputVotingTablet" value="<?= html_escape($current_tablet); ?>">
</form>

<!-- ========================================================
     STICKY BOTTOM ACTION BAR (SUMMARY & SUBMIT)
     ======================================================== -->
<div class="voting-sticky-bar">
    <div class="sticky-bar-inner">
        <div class="sticky-summary-items">
            <!-- Calon Ketua Terpilih -->
            <div class="summary-item" id="summaryItemKetua" onclick="goToSlide(1)" title="Klik untuk melihat atau mengubah pilihan Calon Ketua">
                <div class="summary-item-icon">👑</div>
                <div class="summary-item-content">
                    <span class="summary-item-label">Ketua Terpilih</span>
                    <span class="summary-item-value" id="summaryKetuaVal">Belum dipilih</span>
                </div>
            </div>

            <!-- Calon Pengawas Terpilih -->
            <div class="summary-item" id="summaryItemPengawas" onclick="goToSlide(2)" title="Klik untuk melihat atau mengubah pilihan Calon Pengawas">
                <div class="summary-item-icon">⚖️</div>
                <div class="summary-item-content">
                    <span class="summary-item-label">Pengawas Terpilih</span>
                    <span class="summary-item-value" id="summaryPengawasVal">Belum dipilih</span>
                </div>
            </div>

            <!-- Informasi Tablet di Sticky Bottom Bar -->
            <div class="summary-item summary-item-tablet" id="summaryItemTablet" style="<?= !empty($current_tablet) ? 'display:flex;' : 'display:none;'; ?> cursor:default;" title="Bilik Suara">
                <div class="summary-item-icon" style="background:#f1f5f9; color:#0f172a;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                </div>
                <div class="summary-item-content">
                    <span class="summary-item-label">Bilik Suara</span>
                    <span class="summary-item-value" id="summaryTabletVal" style="color:#0f172a; font-weight:700;">Tablet <?= html_escape($current_tablet); ?></span>
                </div>
            </div>
        </div>

        <div class="sticky-actions">
            <a href="<?= site_url('voting/batal'); ?>" class="btn btn-secondary" style="padding:8px 18px; font-size:13px;" onclick="return handleBatalClick(event, this.href);">
                Batal
            </a>
            <button type="button" class="btn-submit-vote" id="btnSubmitVote" onclick="handleKirimSuara()">
                <span>Kirim Suara</span>
                <span id="counterPilihan">(0/2)</span>
            </button>
        </div>
    </div>
</div>

<!-- ========================================================
     VOTE LOADING OVERLAY (KIOSK SUBMIT SPINNER)
     ======================================================== -->
<div id="voteLoadingOverlay" class="vote-loading-overlay" aria-live="polite">
    <div class="vote-loading-card">
        <div id="voteLoadingSpinner" class="vote-loading-spinner-ring"></div>
        <div id="voteLoadingTitle" class="vote-loading-title">Menyimpan Suara...</div>
        <div id="voteLoadingDesc" class="vote-loading-desc">Mohon tunggu sebentar, hak suara Anda sedang dicatat dan dienkripsi secara aman ke dalam sistem.</div>
        <div id="voteLoadingBadge" class="vote-loading-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <span id="voteLoadingBadgeText">Enkripsi Suara Pemilih Aktif</span>
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

var currentSlide = 1;

// Inisialisasi awal saat halaman dimuat
function initPilihUi() {
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

    // Pastikan informasi tablet tersinkronisasi
    if (typeof syncTabletInfoUI === 'function') {
        syncTabletInfoUI('<?= !empty($current_tablet) ? html_escape($current_tablet) : ""; ?>');
    }

    // Jika ketua sudah terpilih di session namun pengawas belum, arahkan ke slide pengawas
    if (currentSelection.ketua.nik && !currentSelection.pengawas.nik) {
        goToSlide(2);
    } else {
        goToSlide(1);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPilihUi);
} else {
    initPilihUi();
}

// Navigasi Slide (Tahap 1 Ketua <-> Tahap 2 Pengawas)
function goToSlide(slideNum) {
    var track = document.getElementById('votingSliderTrack');
    var btnKetua = document.getElementById('stepBtnKetua');
    var btnPengawas = document.getElementById('stepBtnPengawas');

    if (!track) return;

    if (slideNum === 2) {
        track.classList.add('show-pengawas');
        currentSlide = 2;

        if (btnKetua) {
            btnKetua.classList.remove('active');
            if (currentSelection.ketua.nik) btnKetua.classList.add('done');
        }
        if (btnPengawas) {
            btnPengawas.classList.add('active');
        }
    } else {
        track.classList.remove('show-pengawas');
        currentSlide = 1;

        if (btnPengawas) {
            btnPengawas.classList.remove('active');
            if (currentSelection.pengawas.nik) btnPengawas.classList.add('done');
        }
        if (btnKetua) {
            btnKetua.classList.add('active');
        }
    }
}

// Handler saat kartu diklik
function handleCardClick(category, nik, nama, foto, noUrut) {
    selectCandidate(category, nik, nama, foto, noUrut);
}

// Fungsi memilih kandidat
function selectCandidate(category, nik, nama, foto, noUrut) {
    currentSelection[category] = {
        nik: nik,
        nama: nama,
        foto: foto,
        noUrut: noUrut
    };

    if (category === 'ketua') {
        document.getElementById('inputKetuaNik').value = nik;
    } else {
        document.getElementById('inputPengawasNik').value = nik;
    }

    updateUiState();

    // Setelah memilih ketua, langsung slide tampil pilih pengawas tanpa berubah page
    if (category === 'ketua') {
        setTimeout(function() {
            goToSlide(2);
        }, 260);
    }
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

    var stepBtnKetua    = document.getElementById('stepBtnKetua');
    var stepStatusKetua = document.getElementById('stepStatusKetua');
    var summaryItemKetua = document.getElementById('summaryItemKetua');
    var summaryKetuaVal  = document.getElementById('summaryKetuaVal');
    var btnHeaderNext   = document.getElementById('btnHeaderNextToPengawas');

    if (currentSelection.ketua.nik) {
        var selectedCardKetua = document.getElementById('card-ketua-' + currentSelection.ketua.nik);
        var selectedBtnKetua  = document.getElementById('btn-pilih-ketua-' + currentSelection.ketua.nik);

        if (selectedCardKetua) selectedCardKetua.classList.add('is-selected');
        if (selectedBtnKetua) selectedBtnKetua.innerText = '✓ Terpilih';

        if (stepStatusKetua) {
            stepStatusKetua.className = 'stepper-btn-status selected';
            stepStatusKetua.innerText = '✓ ' + currentSelection.ketua.nama;
        }
        if (stepBtnKetua) stepBtnKetua.classList.add('done');

        if (summaryItemKetua) summaryItemKetua.classList.add('active');
        if (summaryKetuaVal) summaryKetuaVal.innerText = currentSelection.ketua.nama;

        if (btnHeaderNext) btnHeaderNext.style.display = 'inline-flex';
    } else {
        if (stepStatusKetua) {
            stepStatusKetua.className = 'stepper-btn-status pending';
            stepStatusKetua.innerText = 'Belum Dipilih';
        }
        if (stepBtnKetua) stepBtnKetua.classList.remove('done');

        if (summaryItemKetua) summaryItemKetua.classList.remove('active');
        if (summaryKetuaVal) summaryKetuaVal.innerText = 'Belum dipilih';

        if (btnHeaderNext) btnHeaderNext.style.display = 'none';
    }

    // 2. Update Kartu Pengawas
    document.querySelectorAll('[id^="card-pengawas-"]').forEach(function(card) {
        card.classList.remove('is-selected');
    });
    document.querySelectorAll('[id^="btn-pilih-pengawas-"]').forEach(function(btn) {
        btn.innerText = 'Pilih Calon Ini';
    });

    var stepBtnPengawas    = document.getElementById('stepBtnPengawas');
    var stepStatusPengawas = document.getElementById('stepStatusPengawas');
    var summaryItemPengawas = document.getElementById('summaryItemPengawas');
    var summaryPengawasVal  = document.getElementById('summaryPengawasVal');

    if (currentSelection.pengawas.nik) {
        var selectedCardPengawas = document.getElementById('card-pengawas-' + currentSelection.pengawas.nik);
        var selectedBtnPengawas  = document.getElementById('btn-pilih-pengawas-' + currentSelection.pengawas.nik);

        if (selectedCardPengawas) selectedCardPengawas.classList.add('is-selected');
        if (selectedBtnPengawas) selectedBtnPengawas.innerText = '✓ Terpilih';

        if (stepStatusPengawas) {
            stepStatusPengawas.className = 'stepper-btn-status selected';
            stepStatusPengawas.innerText = '✓ ' + currentSelection.pengawas.nama;
        }
        if (stepBtnPengawas) stepBtnPengawas.classList.add('done');

        if (summaryItemPengawas) summaryItemPengawas.classList.add('active');
        if (summaryPengawasVal) summaryPengawasVal.innerText = currentSelection.pengawas.nama;
    } else {
        if (stepStatusPengawas) {
            stepStatusPengawas.className = 'stepper-btn-status pending';
            stepStatusPengawas.innerText = 'Belum Dipilih';
        }
        if (stepBtnPengawas) stepBtnPengawas.classList.remove('done');

        if (summaryItemPengawas) summaryItemPengawas.classList.remove('active');
        if (summaryPengawasVal) summaryPengawasVal.innerText = 'Belum dipilih';
    }

    // 3. Update Tombol Kirim Suara & Counter
    var btnSubmit = document.getElementById('btnSubmitVote');
    var counterPilihan = document.getElementById('counterPilihan');
    var totalSelected = (currentSelection.ketua.nik ? 1 : 0) + (currentSelection.pengawas.nik ? 1 : 0);

    if (counterPilihan) counterPilihan.innerText = '(' + totalSelected + '/2)';

    if (btnSubmit) {
        if (totalSelected === 2) {
            btnSubmit.classList.add('ready');
            btnSubmit.innerHTML = '<span>✓ Kirim Suara Saya</span> <span id="counterPilihan">(2/2 Selesai)</span>';
        } else {
            btnSubmit.classList.remove('ready');
            btnSubmit.innerHTML = '<span>Kirim Suara</span> <span id="counterPilihan">(' + totalSelected + '/2)</span>';
        }
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
        width: '580px',
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
        goToSlide(1);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'info',
                title: 'Silakan pilih 1 Calon Ketua terlebih dahulu',
                showConfirmButton: false,
                timer: 2200
            });
        }
        return;
    }

    if (!currentSelection.ketua.nik) {
        goToSlide(1);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'warning',
                title: 'Calon Ketua belum dipilih',
                showConfirmButton: false,
                timer: 2200
            });
        }
        return;
    }

    if (!currentSelection.pengawas.nik) {
        goToSlide(2);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'info',
                title: 'Silakan tentukan 1 Calon Pengawas untuk menyelesaikan suara',
                showConfirmButton: false,
                timer: 2200
            });
        }
        return;
    }

    // Keduanya sudah dipilih -> Tampilkan Ringkasan Konfirmasi
    var ketuaAvatar = currentSelection.ketua.foto ? 
        '<img src="' + currentSelection.ketua.foto + '" style="width:68px; height:68px; border-radius:14px; object-fit:cover; margin:0 auto 8px; display:block; border:2px solid #e5e7eb;">' :
        '<div style="width:68px; height:68px; border-radius:14px; background:#f3f4f6; margin:0 auto 8px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">No Foto</div>';

    var pengawasAvatar = currentSelection.pengawas.foto ? 
        '<img src="' + currentSelection.pengawas.foto + '" style="width:68px; height:68px; border-radius:14px; object-fit:cover; margin:0 auto 8px; display:block; border:2px solid #e5e7eb;">' :
        '<div style="width:68px; height:68px; border-radius:14px; background:#f3f4f6; margin:0 auto 8px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">No Foto</div>';

    var summaryConfirmHtml = 
        '<p style="font-size:14px; color:#4b5563; margin-bottom:16px;">Pastikan dua kandidat di bawah ini sudah sesuai dengan pilihan nurani Anda:</p>' +
        '<div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px;">' +
            '<div style="background:#f8fafc; border:2px solid #bbf7d0; border-radius:16px; padding:14px; text-align:center;">' +
                '<span style="background:#16a34a; color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; padding:3px 10px; border-radius:9999px; display:inline-block; margin-bottom:8px;">Calon Ketua (No. ' + currentSelection.ketua.noUrut + ')</span>' +
                ketuaAvatar +
                '<div style="font-weight:700; font-size:14px; color:#111827; line-height:1.3;">' + escapeHtml(currentSelection.ketua.nama) + '</div>' +
                '<div style="font-size:12px; color:#6b7280; margin-top:2px;">NIK: ' + currentSelection.ketua.nik + '</div>' +
            '</div>' +
            '<div style="background:#f8fafc; border:2px solid #bbf7d0; border-radius:16px; padding:14px; text-align:center;">' +
                '<span style="background:#2563eb; color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; padding:3px 10px; border-radius:9999px; display:inline-block; margin-bottom:8px;">Calon Pengawas (No. ' + currentSelection.pengawas.noUrut + ')</span>' +
                pengawasAvatar +
                '<div style="font-weight:700; font-size:14px; color:#111827; line-height:1.3;">' + escapeHtml(currentSelection.pengawas.nama) + '</div>' +
                '<div style="font-size:12px; color:#6b7280; margin-top:2px;">NIK: ' + currentSelection.pengawas.nik + '</div>' +
            '</div>' +
        '</div>' +
        '<div style="background:#fef3c7; border:1px solid #fde68a; color:#92400e; font-size:12px; padding:10px 14px; border-radius:10px; text-align:left; line-height:1.4;">' +
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
        width: '620px'
    }).then(function(result) {
        if (result.isConfirmed) {
            if (typeof Swal !== 'undefined' && Swal.close) {
                Swal.close();
            }
            showVoteLoader();

            var form = document.getElementById('formKirimSuara');
            var inpTab = document.getElementById('inputVotingTablet');
            if (inpTab && !inpTab.value) {
                var storedTab = localStorage.getItem('voting_tablet') || sessionStorage.getItem('voting_tablet');
                if (storedTab) inpTab.value = storedTab;
            }
            var formData = new FormData(form);
            var startTime = Date.now();
            var minDisplayTime = 800;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(function(response) {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(function(res) {
                var elapsed = Date.now() - startTime;
                var remaining = Math.max(0, minDisplayTime - elapsed);

                setTimeout(function() {
                    if (res.status === 'success') {
                        var titleEl = document.getElementById('voteLoadingTitle');
                        var descEl = document.getElementById('voteLoadingDesc');
                        var badgeTextEl = document.getElementById('voteLoadingBadgeText');
                        var spinnerEl = document.getElementById('voteLoadingSpinner');

                        if (titleEl) titleEl.textContent = 'Suara Berhasil Dicatat!';
                        if (descEl) descEl.textContent = res.message || 'Hak suara Anda telah resmi dicatat ke sistem. Mengalihkan ke halaman voting awal...';
                        if (badgeTextEl) badgeTextEl.textContent = 'Hak Suara Resmi Tersimpan';
                        if (spinnerEl) spinnerEl.classList.add('success');

                        // Loading screen tetap muncul sampai page diarahkan ke halaman voting awal
                        var targetUrl = (res.data && res.data.redirect) ? res.data.redirect : '<?= site_url("voting"); ?>';

                        setTimeout(function() {
                            if (typeof navigateKiosk === 'function') {
                                navigateKiosk(targetUrl);
                            } else {
                                window.location.href = targetUrl;
                            }
                        }, 800);
                    } else {
                        hideVoteLoader();

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan Suara',
                            html: res.message,
                            confirmButtonColor: '#1a1a1a',
                            confirmButtonText: 'Saya Mengerti',
                            heightAuto: false
                        }).then(function() {
                            if (res.data && res.data.redirect) {
                                if (typeof navigateKiosk === 'function') {
                                    navigateKiosk(res.data.redirect);
                                } else {
                                    window.location.href = res.data.redirect;
                                }
                            }
                        });
                    }
                }, remaining);
            })
            .catch(function() {
                var elapsed = Date.now() - startTime;
                var remaining = Math.max(0, minDisplayTime - elapsed);

                setTimeout(function() {
                    hideVoteLoader();

                    Swal.fire({
                        icon: 'error',
                        title: 'Koneksi Terputus',
                        text: 'Gagal menghubungi server bilik suara. Silakan periksa jaringan dan coba lagi.',
                        confirmButtonColor: '#1a1a1a',
                        confirmButtonText: 'Coba Lagi',
                        heightAuto: false
                    });
                }, remaining);
            });
        }
    });
}

// Helper Loader Overlay & Tombol
function showVoteLoader() {
    var loader = document.getElementById('voteLoadingOverlay');
    if (loader) {
        loader.classList.add('show');
    }
    var titleEl = document.getElementById('voteLoadingTitle');
    var descEl = document.getElementById('voteLoadingDesc');
    var badgeTextEl = document.getElementById('voteLoadingBadgeText');
    var spinnerEl = document.getElementById('voteLoadingSpinner');

    if (titleEl) titleEl.textContent = 'Menyimpan Suara...';
    if (descEl) descEl.textContent = 'Mohon tunggu sebentar, hak suara Anda sedang dicatat dan dienkripsi secara aman ke dalam sistem.';
    if (badgeTextEl) badgeTextEl.textContent = 'Enkripsi Suara Pemilih Aktif';
    if (spinnerEl) spinnerEl.classList.remove('success');

    var btn = document.getElementById('btnSubmitVote');
    if (btn) {
        btn.disabled = true;
        btn.classList.add('btn-loading');
        btn.innerHTML = '<span class="spinner-sm"></span> <span>Menyimpan Suara...</span>';
    }
}

function hideVoteLoader() {
    var loader = document.getElementById('voteLoadingOverlay');
    if (loader) {
        loader.classList.remove('show');
    }
    var btn = document.getElementById('btnSubmitVote');
    if (btn) {
        btn.disabled = false;
        btn.classList.remove('btn-loading');
        var totalSelected = (currentSelection.ketua.nik ? 1 : 0) + (currentSelection.pengawas.nik ? 1 : 0);
        if (totalSelected === 2) {
            btn.classList.add('ready');
            btn.innerHTML = '<span>✓ Kirim Suara Saya</span> <span id="counterPilihan">(2/2 Selesai)</span>';
        } else {
            btn.classList.remove('ready');
            btn.innerHTML = '<span>Kirim Suara</span> <span id="counterPilihan">(' + totalSelected + '/2)</span>';
        }
    }
}

// Konfirmasi pembatalan sesi via AJAX
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
        reverseButtons: true,
        heightAuto: false
    }).then(function(result) {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Membatalkan Sesi...',
                text: 'Mohon tunggu sebentar, mengembalikan bilik suara ke layar awal...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                heightAuto: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.status === 'success' && res.data && res.data.redirect) {
                    if (typeof navigateKiosk === 'function') {
                        navigateKiosk(res.data.redirect, function() {
                            setTimeout(function() {
                                Swal.close();
                            }, 60);
                        });
                    } else {
                        window.location.href = res.data.redirect;
                    }
                } else {
                    Swal.close();
                    window.location.href = url;
                }
            })
            .catch(function() {
                Swal.close();
                window.location.href = url;
            });
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
