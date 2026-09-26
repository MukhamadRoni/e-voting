<style>
.winner-card {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 16px;
    position: relative;
    overflow: hidden;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.winner-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.winner-card.rank-1 {
    border-color: #3b82f6;
    background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%);
}
.winner-card .rank-badge {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 15px;
    background: #f5f5f7;
    color: #6b7280;
    flex-shrink: 0;
}
.winner-card.rank-1 .rank-badge {
    background: #3b82f6;
    color: #ffffff;
}
.winner-card .candidate-img {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    object-fit: cover;
    background: #f3f4f6;
    border: 1px solid #e5e5e5;
    flex-shrink: 0;
}
.winner-card .info {
    flex-grow: 1;
}
.winner-card .info h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 2px;
}
.winner-card .info span {
    font-size: 13px;
    color: #6b7280;
}
.winner-card .progress-wrapper {
    margin-top: 10px;
    background: #f0f0f0;
    border-radius: 9999px;
    height: 10px;
    overflow: hidden;
    max-width: 450px;
}
.winner-card .progress-bar {
    height: 100%;
    background: #1a1a1a;
    border-radius: 9999px;
    transition: width 0.4s ease;
}
.winner-card.rank-1 .progress-bar {
    background: #3b82f6;
}
.winner-card .stats-box {
    text-align: right;
    flex-shrink: 0;
}
.winner-card .vote-count {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
}
.winner-card .vote-percent {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    margin-top: 4px;
}
@media print {
    .sidebar, .topbar, .btn-print { display: none !important; }
    .main-content { margin-left: 0 !important; }
    .content-area { padding: 0 !important; }
}
</style>

<!-- Header & Action -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h2 style="font-size:22px; font-weight:700; color:#1a1a1a;">Laporan Hasil Pemilihan Pengawas</h2>
        <span style="font-size:14px; color:#6b7280;">Rekapitulasi perolehan suara kandidat pengawas koperasi secara real-time.</span>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="<?= site_url('real_count?kategori=pengawas'); ?>" target="_blank" class="btn btn-primary" style="background:#4f46e5; color:#ffffff; font-weight:700;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Buka Real Count 3D ↗
        </a>
        <button class="btn btn-secondary btn-print" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak Laporan
        </button>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= number_format($total_suara); ?></div>
        <div class="stat-label">Total Suara Masuk (Pengawas)</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= number_format($sudah_memilih); ?></div>
        <div class="stat-label">Pemilih Berpartisipasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= number_format($total_pemilih); ?></div>
        <div class="stat-label">Total DPT Terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">
            <?= $total_pemilih > 0 ? round(($sudah_memilih / $total_pemilih) * 100, 1) : 0; ?>%
        </div>
        <div class="stat-label">Tingkat Partisipasi</div>
    </div>
</div>

<!-- Kandidat Ranking Cards -->
<div class="card">
    <div class="card-header">
        <h3>Peringkat Perolehan Suara Pengawas</h3>
        <span style="font-size:13px; color:#6b7280;">Diurutkan dari suara terbanyak</span>
    </div>

    <?php if (!empty($rekap)): ?>
        <?php $rank = 1; ?>
        <?php foreach ($rekap as $k): ?>
            <?php 
                $percent = ($total_suara > 0) ? round(($k->total_suara / $total_suara) * 100, 1) : 0;
            ?>
            <div class="winner-card <?= ($rank == 1 && $k->total_suara > 0) ? 'rank-1' : ''; ?>">
                <div class="rank-badge">
                    <?php if ($rank == 1 && $k->total_suara > 0): ?>
                        ★
                    <?php else: ?>
                        <?= $rank; ?>
                    <?php endif; ?>
                </div>

                <?php if ($k->foto): ?>
                    <img src="<?= base_url('assets/uploads/kandidat/' . $k->foto); ?>" class="candidate-img" alt="<?= html_escape($k->nama); ?>">
                <?php else: ?>
                    <div class="candidate-img" style="display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:11px;">No Foto</div>
                <?php endif; ?>

                <div class="info">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <h4><?= html_escape($k->nama); ?></h4>
                        <?php if ($rank == 1 && $k->total_suara > 0): ?>
                            <span class="badge badge-success">Peringkat 1</span>
                        <?php endif; ?>
                    </div>
                    <span>NIK: <?= $k->nik; ?></span>
                    <div class="progress-wrapper">
                        <div class="progress-bar" style="width: <?= $percent; ?>%;"></div>
                    </div>
                </div>

                <div class="stats-box">
                    <div class="vote-count"><?= number_format($k->total_suara); ?></div>
                    <div class="vote-percent"><?= $percent; ?>% suara</div>
                </div>
            </div>
            <?php $rank++; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; color:#6b7280; padding:32px;">Belum ada kandidat pengawas yang terdaftar.</p>
    <?php endif; ?>
</div>

<!-- Tabel Rincian -->
<div class="card">
    <div class="card-header">
        <h3>Tabel Rekapitulasi Suara Pengawas</h3>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="80">Peringkat</th>
                    <th>NIK</th>
                    <th>Nama Kandidat</th>
                    <th width="150" style="text-align:right;">Perolehan Suara</th>
                    <th width="120" style="text-align:right;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rekap)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($rekap as $row): ?>
                        <?php 
                            $pct = ($total_suara > 0) ? round(($row->total_suara / $total_suara) * 100, 1) : 0;
                        ?>
                        <tr>
                            <td>
                                <?php if ($no == 1 && $row->total_suara > 0): ?>
                                    <span class="badge badge-success">#1</span>
                                <?php else: ?>
                                    <span style="color:#6b7280; font-weight:600;"><?= $no; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $row->nik; ?></td>
                            <td><strong><?= html_escape($row->nama); ?></strong></td>
                            <td style="text-align:right; font-weight:600;"><?= number_format($row->total_suara); ?></td>
                            <td style="text-align:right;"><?= $pct; ?>%</td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#6b7280; padding:24px;">Tidak ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
