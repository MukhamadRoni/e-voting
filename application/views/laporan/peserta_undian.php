<style>
.doorprize-box {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: #ffffff;
    border-radius: 20px;
    padding: 32px;
    margin-bottom: 28px;
    text-align: center;
    position: relative;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.doorprize-box h3 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 8px;
}
.doorprize-box p {
    font-size: 14px;
    color: #9ca3af;
    max-width: 500px;
    margin: 0 auto 20px;
}
.spin-winner-card {
    background: rgba(255, 255, 255, 0.08);
    border: 2px dashed rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 24px;
    max-width: 480px;
    margin: 0 auto 24px;
    min-height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.winner-name-display {
    font-size: 26px;
    font-weight: 700;
    color: #f59e0b;
    margin-bottom: 4px;
}
.winner-detail-display {
    font-size: 14px;
    color: #d1d5db;
}
.btn-spin {
    background: #f59e0b;
    color: #1a1a1a;
    font-size: 15px;
    font-weight: 700;
    padding: 12px 32px;
    border-radius: 9999px;
    border: none;
    cursor: pointer;
    transition: transform 0.15s ease, background 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-spin:hover {
    background: #d97706;
    transform: translateY(-2px);
}
.filter-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
@media print {
    .sidebar, .topbar, .btn-print, .doorprize-box, .filter-row { display: none !important; }
    .main-content { margin-left: 0 !important; }
    .content-area { padding: 0 !important; }
}
</style>

<!-- Header & Action -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h2 style="font-size:22px; font-weight:700; color:#1a1a1a;">Daftar Peserta Undian Door Prize</h2>
        <span style="font-size:14px; color:#6b7280;">Daftar anggota yang telah menggunakan hak suara dan berhak mengikuti undian door prize.</span>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="<?= site_url('bilik_undian'); ?>" target="_blank" class="btn btn-primary" style="background:#f59e0b; color:#1a1a1a; font-weight:700;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2z"/></svg>
            Buka Panggung Bilik Undian ↗
        </a>
        <button class="btn btn-secondary btn-print" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak Daftar Peserta
        </button>
    </div>
</div>

<!-- Doorprize Lucky Draw Interactive Box -->
<!--<div class="doorprize-box">
    <h3>🎉 Undian Door Prize RAT Koperasi</h3>
    <p>Sistem pengundian otomatis secara acak dari anggota yang telah terdaftar dan menggunakan hak pilihnya.</p>
    
    <div class="spin-winner-card" id="winnerCard">
        <div id="initialText" style="color:#9ca3af; font-size:15px;">
            Klik tombol di bawah untuk mengundi pemenang secara acak
        </div>
        <div id="winnerContent" style="display:none;">
            <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#10b981; font-weight:700; margin-bottom:4px;">SELAMAT KEPADA PEMENANG!</div>
            <div class="winner-name-display" id="winnerNama">-</div>
            <div class="winner-detail-display" id="winnerDetail">-</div>
        </div>
    </div>

    <button type="button" class="btn-spin" id="spinBtn" onclick="kocokUndian()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
        <span>Acak Pemenang Door Prize</span>
    </button>
</div>-->

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= number_format($total_peserta); ?></div>
        <div class="stat-label">Anggota Berhak Ikut Undian</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= number_format($total_pemilih); ?></div>
        <div class="stat-label">Total Semua Anggota (DPT)</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">
            <?= $total_pemilih > 0 ? round(($total_peserta / $total_pemilih) * 100, 1) : 0; ?>%
        </div>
        <div class="stat-label">Persentase Partisipasi</div>
    </div>
</div>

<!-- Table Card -->
<div class="card">
    <div class="filter-row">
        <div>
            <h3>Daftar Peserta Sah Undian</h3>
            <span style="font-size:13px; color:#6b7280;">Hanya anggota dengan status voting <strong>Sudah Memilih</strong></span>
        </div>

        <!-- Filter Departemen -->
        <form method="get" action="<?= site_url('laporan/peserta_undian'); ?>" style="display:flex; gap:8px;">
            <select name="dept" onchange="this.form.submit()" style="height:38px; padding:0 12px; border-radius:8px; border:1px solid #e5e5e5; font-family:'DM Sans', sans-serif; font-size:13px; outline:none;">
                <option value="">-- Semua Departemen --</option>
                <?php if (!empty($daftar_dept)): ?>
                    <?php foreach ($daftar_dept as $d): ?>
                        <option value="<?= html_escape($d->dept); ?>" <?= ($dept_terpilih == $d->dept) ? 'selected' : ''; ?>>
                            <?= html_escape($d->dept); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php if (!empty($dept_terpilih)): ?>
                <a href="<?= site_url('laporan/peserta_undian'); ?>" class="btn btn-secondary btn-sm" style="height:38px; line-height:38px; padding:0 12px;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>NIK</th>
                    <th>Nama Anggota</th>
                    <th>Departemen</th>
                    <th>Status Hak Suara</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($peserta)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($peserta as $p): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><code><?= $p->nik; ?></code></td>
                            <td><strong><?= html_escape($p->nama); ?></strong></td>
                            <td><span class="badge badge-warning"><?= html_escape($p->dept); ?></span></td>
                            <td><span class="badge badge-success">Sudah Memilih (Sah)</span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#6b7280; padding:32px;">
                            Belum ada anggota yang memenuhi syarat undian<?= !empty($dept_terpilih) ? ' di departemen ini' : ''; ?>.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
var isSpinning = false;

function kocokUndian() {
    if (isSpinning) return;

    var currentDept = "<?= $dept_terpilih; ?>";
    var url = "<?= site_url('laporan/kocok_undian_ajax'); ?>" + (currentDept ? "?dept=" + encodeURIComponent(currentDept) : "");
    var spinBtn = document.getElementById("spinBtn");
    var initialText = document.getElementById("initialText");
    var winnerContent = document.getElementById("winnerContent");
    var winnerNama = document.getElementById("winnerNama");
    var winnerDetail = document.getElementById("winnerDetail");

    isSpinning = true;
    spinBtn.disabled = true;
    spinBtn.style.opacity = "0.7";
    initialText.style.display = "none";
    winnerContent.style.display = "block";
    winnerNama.style.color = "#f59e0b";

    // Efek rolling / mengacak nama
    var dummyNames = ["Mengacak nama pemenang...", "Memilih dari peserta...", "Hampir selesai...", "Siapakah pemenangnya?"];
    var counter = 0;
    var rollInterval = setInterval(function() {
        winnerNama.innerText = dummyNames[counter % dummyNames.length];
        winnerDetail.innerText = "Harap tunggu...";
        counter++;
    }, 120);

    fetch(url)
        .then(response => response.json())
        .then(res => {
            setTimeout(function() {
                clearInterval(rollInterval);
                isSpinning = false;
                spinBtn.disabled = false;
                spinBtn.style.opacity = "1";

                if (res.status === 'success') {
                    winnerNama.innerText = res.data.nama;
                    winnerDetail.innerText = "NIK: " + res.data.nik + " • Departemen: " + res.data.dept;
                } else {
                    winnerNama.innerText = "Tidak Ada Peserta";
                    winnerDetail.innerText = res.message || "Belum ada anggota yang berhak ikut undian.";
                }
            }, 1800);
        })
        .catch(err => {
            clearInterval(rollInterval);
            isSpinning = false;
            spinBtn.disabled = false;
            spinBtn.style.opacity = "1";
            winnerNama.innerText = "Gagal Mengundi";
            winnerDetail.innerText = "Terjadi kesalahan koneksi.";
        });
}
</script>
