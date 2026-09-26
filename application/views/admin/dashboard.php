<!-- Dashboard Content -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $this->db->count_all('pemilih'); ?></div>
        <div class="stat-label">Total Pemilih</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $this->db->count_all('kandidat_ketua'); ?></div>
        <div class="stat-label">Kandidat Ketua</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $this->db->count_all('kandidat_pengawas'); ?></div>
        <div class="stat-label">Kandidat Pengawas</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $this->db->count_all('hasil'); ?></div>
        <div class="stat-label">Total Sudah Voting</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Selamat Datang</h3>
    </div>
    <p style="font-size:14px; color:#6b7280; line-height:1.6;">
        Selamat datang di <strong>Panel Admin E-Voting Koperasi</strong>. 
        Gunakan menu di sidebar untuk mengelola data pemilih, kandidat, serta melihat laporan hasil voting.
    </p>
</div>
