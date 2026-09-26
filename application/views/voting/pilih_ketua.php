<style>
.section-title-wrap {
    text-align: center;
    margin-bottom: 36px;
}
.section-title-wrap h2 {
    font-size: 26px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 6px;
}
.section-title-wrap p {
    font-size: 15px;
    color: #6b7280;
}

.kandidat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.kandidat-card {
    background: #ffffff;
    border: 2px solid #e5e5e5;
    border-radius: 20px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transition: all 0.2s ease;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    position: relative;
}

.kandidat-card:hover {
    border-color: #1a1a1a;
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.07);
}

.kandidat-card.is-selected {
    border-color: #16a34a;
    background: #f0fdf4;
}

.candidate-avatar {
    width: 140px;
    height: 140px;
    border-radius: 20px;
    object-fit: cover;
    margin-bottom: 18px;
    border: 1px solid #e5e5e5;
    background: #f3f4f6;
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
}

.candidate-name {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 4px;
}

.candidate-nik {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 16px;
    background: #f5f5f7;
    padding: 4px 12px;
    border-radius: 9999px;
}

.visi-misi-box {
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 14px;
    font-size: 13px;
    color: #4b5563;
    line-height: 1.5;
    text-align: left;
    white-space: pre-line;
    max-height: 160px;
    overflow-y: auto;
    width: 100%;
    margin-bottom: 20px;
}

.btn-choose {
    width: 100%;
    height: 48px;
    font-size: 15px;
    font-weight: 700;
}
</style>

<div class="section-title-wrap">
    <h2>Langkah 1: Pilih Calon Ketua Koperasi</h2>
    <p>Silakan telusuri visi & misi setiap calon, lalu klik tombol <strong>"Pilih Calon Ini"</strong> pada kandidat pilihan Anda.</p>
</div>

<div class="kandidat-grid">
    <?php if (!empty($kandidat)): ?>
        <?php foreach ($kandidat as $k): ?>
            <?php $isSelected = ($terpilih == $k->nik); ?>
            <div class="kandidat-card <?= $isSelected ? 'is-selected' : ''; ?>">
                <?php if ($k->foto): ?>
                    <img src="<?= base_url('assets/uploads/kandidat/' . $k->foto); ?>" class="candidate-avatar" alt="<?= html_escape($k->nama); ?>">
                <?php else: ?>
                    <div class="candidate-avatar" style="display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:13px;">No Foto</div>
                <?php endif; ?>

                <div class="candidate-name"><?= html_escape($k->nama); ?></div>
                <div class="candidate-nik">NIK: <?= $k->nik; ?></div>

                <div class="visi-misi-box">
                    <strong>Visi & Misi:</strong><br>
                    <?= html_escape($k->visi_misi ?: 'Tidak ada deskripsi visi & misi.'); ?>
                </div>

                <form method="post" action="<?= site_url('voting/pilih_ketua_proses'); ?>" style="width:100%;">
                    <input type="hidden" name="ketua_nik" value="<?= $k->nik; ?>">
                    <button type="submit" class="btn <?= $isSelected ? 'btn-success' : 'btn-primary'; ?> btn-choose">
                        <?= $isSelected ? '✓ Terpilih (Klik untuk lanjut)' : 'Pilih Calon Ini →'; ?>
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; color:#6b7280; grid-column:1/-1;">Belum ada calon ketua yang terdaftar.</p>
    <?php endif; ?>
</div>
