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
    width: 64px;
    height: 64px;
    border-radius: 14px;
    object-fit: cover;
    border: 1px solid #e5e5e5;
    background: #f3f4f6;
    display: block;
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
</style>

<!-- Header Action & Tabs -->
<div class="kandidat-tabs-wrap">
    <div class="kandidat-tabs">
        <button class="tab-btn active" onclick="switchTab('ketua', this)">
            Kandidat Ketua
            <span class="tab-count-badge"><?= count($ketua); ?></span>
        </button>
        <button class="tab-btn" onclick="switchTab('pengawas', this)">
            Kandidat Pengawas
            <span class="tab-count-badge"><?= count($pengawas); ?></span>
        </button>
    </div>
</div>

<!-- Tab: Kandidat Ketua -->
<div id="tab-ketua" class="tab-panel active">
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Daftar Calon Ketua Koperasi</h3>
                <span style="font-size:13px; color:#6b7280;">Kelola data profil, foto, serta visi & misi calon ketua</span>
            </div>
            <a href="<?= site_url('master_kandidat/tambah_ketua'); ?>" class="btn btn-primary btn-sm">+ Tambah Kandidat Ketua</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th width="80">Foto</th>
                        <th width="140">NIK</th>
                        <th>Nama Kandidat</th>
                        <th>Visi & Misi</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ketua)): ?>
                        <?php foreach ($ketua as $k): ?>
                            <tr>
                                <td>
                                    <?php if ($k->foto): ?>
                                        <img src="<?= base_url('assets/uploads/kandidat/' . $k->foto); ?>" class="kandidat-avatar-cell" alt="<?= html_escape($k->nama); ?>">
                                    <?php else: ?>
                                        <div class="kandidat-avatar-cell" style="display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:11px;">No Foto</div>
                                    <?php endif; ?>
                                </td>
                                <td><code><?= $k->nik; ?></code></td>
                                <td>
                                    <strong style="font-size:15px; color:#1a1a1a;"><?= html_escape($k->nama); ?></strong>
                                    <div style="font-size:12px; color:#6b7280; margin-top:2px;">Calon Ketua</div>
                                </td>
                                <td>
                                    <div class="visi-misi-preview">
                                        <?= nl2br(html_escape($k->visi_misi ?: '-')); ?>
                                    </div>
                                    <?php if (!empty($k->visi_misi)): ?>
                                        <button type="button" class="btn-view-visi" onclick="lihatVisiMisi(<?= htmlspecialchars(json_encode($k->nama), ENT_QUOTES, 'UTF-8'); ?>, <?= htmlspecialchars(json_encode($k->visi_misi), ENT_QUOTES, 'UTF-8'); ?>)">
                                            Lihat Selengkapnya ↗
                                        </button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display:flex; gap:6px;">
                                        <a href="<?= site_url('master_kandidat/edit_ketua/' . $k->nik); ?>" class="btn btn-secondary btn-sm">Edit</a>
                                        <a href="<?= site_url('master_kandidat/hapus_ketua/' . $k->nik); ?>" class="btn btn-danger btn-sm btn-hapus" data-confirm="Apakah Anda yakin ingin menghapus kandidat ketua <strong><?= html_escape($k->nama); ?></strong>?">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; color:#6b7280; padding:40px;">
                                <div style="font-size:15px; font-weight:600; color:#1a1a1a; margin-bottom:4px;">Belum Ada Data Kandidat Ketua</div>
                                <div style="font-size:13px; margin-bottom:16px;">Klik tombol di bawah untuk menambahkan calon ketua baru.</div>
                                <a href="<?= site_url('master_kandidat/tambah_ketua'); ?>" class="btn btn-primary btn-sm">+ Tambah Kandidat Ketua</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab: Kandidat Pengawas -->
<div id="tab-pengawas" class="tab-panel">
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Daftar Calon Pengawas Koperasi</h3>
                <span style="font-size:13px; color:#6b7280;">Kelola data profil, foto, serta visi & misi calon pengawas</span>
            </div>
            <a href="<?= site_url('master_kandidat/tambah_pengawas'); ?>" class="btn btn-primary btn-sm">+ Tambah Kandidat Pengawas</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th width="80">Foto</th>
                        <th width="140">NIK</th>
                        <th>Nama Kandidat</th>
                        <th>Visi & Misi</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pengawas)): ?>
                        <?php foreach ($pengawas as $p): ?>
                            <tr>
                                <td>
                                    <?php if ($p->foto): ?>
                                        <img src="<?= base_url('assets/uploads/kandidat/' . $p->foto); ?>" class="kandidat-avatar-cell" alt="<?= html_escape($p->nama); ?>">
                                    <?php else: ?>
                                        <div class="kandidat-avatar-cell" style="display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:11px;">No Foto</div>
                                    <?php endif; ?>
                                </td>
                                <td><code><?= $p->nik; ?></code></td>
                                <td>
                                    <strong style="font-size:15px; color:#1a1a1a;"><?= html_escape($p->nama); ?></strong>
                                    <div style="font-size:12px; color:#6b7280; margin-top:2px;">Calon Pengawas</div>
                                </td>
                                <td>
                                    <div class="visi-misi-preview">
                                        <?= nl2br(html_escape($p->visi_misi ?: '-')); ?>
                                    </div>
                                    <?php if (!empty($p->visi_misi)): ?>
                                        <button type="button" class="btn-view-visi" onclick="lihatVisiMisi(<?= htmlspecialchars(json_encode($p->nama), ENT_QUOTES, 'UTF-8'); ?>, <?= htmlspecialchars(json_encode($p->visi_misi), ENT_QUOTES, 'UTF-8'); ?>)">
                                            Lihat Selengkapnya ↗
                                        </button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display:flex; gap:6px;">
                                        <a href="<?= site_url('master_kandidat/edit_pengawas/' . $p->nik); ?>" class="btn btn-secondary btn-sm">Edit</a>
                                        <a href="<?= site_url('master_kandidat/hapus_pengawas/' . $p->nik); ?>" class="btn btn-danger btn-sm btn-hapus" data-confirm="Apakah Anda yakin ingin menghapus kandidat pengawas <strong><?= html_escape($p->nama); ?></strong>?">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; color:#6b7280; padding:40px;">
                                <div style="font-size:15px; font-weight:600; color:#1a1a1a; margin-bottom:4px;">Belum Ada Data Kandidat Pengawas</div>
                                <div style="font-size:13px; margin-bottom:16px;">Klik tombol di bawah untuk menambahkan calon pengawas baru.</div>
                                <a href="<?= site_url('master_kandidat/tambah_pengawas'); ?>" class="btn btn-primary btn-sm">+ Tambah Kandidat Pengawas</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-panel').forEach(function(p) { p.classList.remove('active'); });
    document.querySelectorAll('.tab-btn').forEach(function(b) { b.classList.remove('active'); });
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}

function lihatVisiMisi(nama, visiMisi) {
    Swal.fire({
        title: 'Visi & Misi: ' + nama,
        html: '<div style="text-align:left; background:#fafafa; padding:16px; border-radius:12px; border:1px solid #f0f0f0; max-height:280px; overflow-y:auto; font-size:14px; line-height:1.6; white-space:pre-line;">' + visiMisi + '</div>',
        confirmButtonColor: '#1a1a1a',
        confirmButtonText: 'Tutup'
    });
}
</script>
