<style>
.top-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 16px;
}
.bottom-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 16px;
}
@media print {
    .sidebar, .topbar, .btn-print, .btn-export, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate { display: none !important; }
    .main-content { margin-left: 0 !important; }
    .content-area { padding: 0 !important; }
}
</style>

<!-- Header & Action -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h2 style="font-size:22px; font-weight:700; color:#1a1a1a;">Laporan Trace Back (Audit Trail)</h2>
        <span style="font-size:14px; color:#6b7280;">Log audit seluruh data suara masuk untuk verifikasi integritas pemilu.</span>
    </div>
    <div style="display:flex; gap:10px;">
        <button type="button" class="btn btn-secondary btn-export" onclick="exportTraceBack()" title="Export log audit ke file Excel (.xlsx)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Export Excel
        </button>
        <button class="btn btn-secondary btn-print" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak Log Audit
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h3>Daftar Log Suara Masuk</h3>
            <span style="font-size:13px; color:#6b7280;">Total <strong><?= number_format($total_suara); ?></strong> catatan suara terekam</span>
        </div>
    </div>

    <div class="table-responsive">
        <table id="traceTable" class="dataTable" style="width:100%;">
            <thead>
                <tr>
                    <th style="width:50px; text-align:center;">No</th>
                    <th style="width:160px;">Waktu Voting</th>
                    <th style="width:120px;">NIK Pemilih</th>
                    <th>Nama Pemilih</th>
                    <th style="width:140px;">Departemen</th>
                    <th>Pilihan Ketua</th>
                    <th>Pilihan Pengawas</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($trace)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($trace as $row): ?>
                        <tr>
                            <td style="text-align:center;"><?= $no++; ?></td>
                            <td data-order="<?= strtotime($row->created_at); ?>" style="color:#6b7280; font-size:13px; white-space:nowrap;">
                                <?= date('d M Y, H:i:s', strtotime($row->created_at)); ?>
                            </td>
                            <td><code style="background:#f3f4f6; padding:3px 8px; border-radius:6px; font-size:12.5px; font-weight:600; color:#1a1a1a;"><?= $row->pemilih_nik; ?></code></td>
                            <td><strong style="color:#1a1a1a; font-size:14px;"><?= html_escape($row->nama_pemilih ?: '-'); ?></strong></td>
                            <td><span class="badge badge-warning"><?= html_escape($row->dept_pemilih ?: '-'); ?></span></td>
                            <td>
                                <?php if ($row->nama_ketua): ?>
                                    <strong style="color:#1a1a1a; font-size:13.5px;"><?= html_escape($row->nama_ketua); ?></strong>
                                    <div style="font-size:11px; color:#6b7280; margin-top:2px;">NIK: <?= $row->ketua_nik; ?></div>
                                <?php else: ?>
                                    <span style="color:#9ca3af; font-size:13px; font-style:italic;">Tidak memilih</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row->nama_pengawas): ?>
                                    <strong style="color:#1a1a1a; font-size:13.5px;"><?= html_escape($row->nama_pengawas); ?></strong>
                                    <div style="font-size:11px; color:#6b7280; margin-top:2px;">NIK: <?= $row->pengawas_nik; ?></div>
                                <?php else: ?>
                                    <span style="color:#9ca3af; font-size:13px; font-style:italic;">Tidak memilih</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
var dtTraceTable = null;

function exportTraceBack() {
    var url = '<?= site_url("laporan/export_trace_back"); ?>';
    if (dtTraceTable && dtTraceTable.search()) {
        url += '?search=' + encodeURIComponent(dtTraceTable.search());
    }
    window.location.href = url;
}

(function() {
    function initDataTable() {
        if (typeof jQuery === 'undefined' || typeof jQuery.fn.DataTable === 'undefined') {
            setTimeout(initDataTable, 50);
            return;
        }

        dtTraceTable = $('#traceTable').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari NIK, Nama, Dept, Pilihan...",
                lengthMenu: "Tampilkan _MENU_ log suara",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ log suara",
                infoEmpty: "Menampilkan 0 s/d 0 dari 0 log suara",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ditemukan log suara yang sesuai pencarian",
                emptyTable: "Belum ada data suara masuk yang terekam",
                paginate: {
                    first: "«",
                    previous: "‹ Sebelumnya",
                    next: "Selanjutnya ›",
                    last: "»"
                }
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            order: [[ 1, 'desc' ]], // Default sort by Waktu Voting descending
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    className: 'text-center'
                }
            ],
            dom: '<"top-controls"lf>rt<"bottom-controls"ip>',
            drawCallback: function(settings) {
                var api = this.api();
                var start = api.page.info().start;
                api.column(0, {page: 'current'}).nodes().each(function(cell, i) {
                    cell.innerHTML = start + i + 1;
                });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDataTable);
    } else {
        initDataTable();
    }
})();
</script>
