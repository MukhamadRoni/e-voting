<style>
.search-bar {
    display: flex;
    gap: 12px;
    align-items: center;
    max-width: 400px;
}
.search-input {
    width: 100%;
    height: 40px;
    padding: 0 14px;
    border-radius: 8px;
    border: 1px solid #e5e5e5;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    outline: none;
    transition: border 0.15s ease;
}
.search-input:focus {
    border: 2px solid #1a1a1a;
}
@media print {
    .sidebar, .topbar, .btn-print, .search-bar { display: none !important; }
    .main-content { margin-left: 0 !important; }
    .content-area { padding: 0 !important; }
}
</style>

<!-- Header & Action -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <div>
        <h2 style="font-size:22px; font-weight:700; color:#1a1a1a;">Laporan Trace Back (Audit Trail)</h2>
        <span style="font-size:14px; color:#6b7280;">Log audit seluruh data suara masuk untuk verifikasi integritas pemilu.</span>
    </div>
    <div style="display:flex; gap:10px;">
        <button class="btn btn-secondary btn-print" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak Log Audit
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header" style="flex-wrap:wrap; gap:16px;">
        <div>
            <h3>Daftar Log Suara Masuk</h3>
            <span style="font-size:13px; color:#6b7280;">Total <strong><?= number_format($total_suara); ?></strong> catatan suara terekam</span>
        </div>
        <div class="search-bar">
            <input type="text" id="searchInput" class="search-input" placeholder="Cari NIK, Nama, Departemen..." onkeyup="filterTable()">
        </div>
    </div>

    <div class="table-responsive">
        <table id="traceTable">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Waktu Voting</th>
                    <th>NIK Pemilih</th>
                    <th>Nama Pemilih</th>
                    <th>Departemen</th>
                    <th>Pilihan Ketua</th>
                    <th>Pilihan Pengawas</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($trace)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($trace as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td style="color:#6b7280; font-size:13px; white-space:nowrap;">
                                <?= date('d M Y, H:i:s', strtotime($row->created_at)); ?>
                            </td>
                            <td><code><?= $row->pemilih_nik; ?></code></td>
                            <td><strong><?= html_escape($row->nama_pemilih ?: '-'); ?></strong></td>
                            <td><span class="badge badge-warning"><?= html_escape($row->dept_pemilih ?: '-'); ?></span></td>
                            <td>
                                <?php if ($row->nama_ketua): ?>
                                    <strong><?= html_escape($row->nama_ketua); ?></strong>
                                    <div style="font-size:11px; color:#6b7280;">NIK: <?= $row->ketua_nik; ?></div>
                                <?php else: ?>
                                    <span style="color:#9ca3af;">Tidak memilih</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row->nama_pengawas): ?>
                                    <strong><?= html_escape($row->nama_pengawas); ?></strong>
                                    <div style="font-size:11px; color:#6b7280;">NIK: <?= $row->pengawas_nik; ?></div>
                                <?php else: ?>
                                    <span style="color:#9ca3af;">Tidak memilih</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; color:#6b7280; padding:32px;">Belum ada data suara masuk yang terekam.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filterTable() {
    var input = document.getElementById("searchInput");
    var filter = input.value.toLowerCase();
    var table = document.getElementById("traceTable");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var tdText = tr[i].textContent || tr[i].innerText;
        if (tdText.toLowerCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>
