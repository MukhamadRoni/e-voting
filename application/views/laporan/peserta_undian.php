<!-- Daftar Peserta Sah Undian Door Prize -->

<style>
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

/* ── Doorprize Badge Styling ── */
.doorprize-badge-card {
    display: inline-flex;
    flex-direction: column;
    gap: 3px;
}
.doorprize-badge-title {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    padding: 5px 12px;
    border-radius: 9999px;
    font-size: 12.5px;
    font-weight: 700;
    border: 1px solid #fcd34d;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    width: fit-content;
}
.doorprize-badge-time {
    font-size: 11px;
    color: #6b7280;
    padding-left: 4px;
}
.badge-belum-menang {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 11px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 500;
    color: #6b7280;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
}
.badge-belum-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #9ca3af;
}

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

.filter-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

@media print {
    .sidebar, .topbar, .btn-print, .btn-export, .filter-row, .filter-pills-bar, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate { 
        display: none !important; 
    }
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
    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <button type="button" class="btn btn-secondary btn-export" id="btnExportPeserta" onclick="exportPesertaUndian()" title="Export data peserta undian ke file Excel (.xlsx) sesuai filter yang dipilih">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
            <span id="btnExportText">Export Excel</span>
        </button>
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

<?php 
    $total_menang = 0;
    $total_belum_menang = 0;
    if (!empty($peserta)) {
        foreach ($peserta as $p) {
            if (!empty($p->nama_hadiah)) {
                $total_menang++;
            } else {
                $total_belum_menang++;
            }
        }
    }
?>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= number_format($total_peserta); ?></div>
        <div class="stat-label">Total Peserta Sah Undian</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" style="color:#d97706;"><?= number_format($total_menang); ?></div>
        <div class="stat-label">🎉 Pemenang Doorprize</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= number_format($total_belum_menang); ?></div>
        <div class="stat-label">Belum Memenangkan Hadiah</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">
            <?= $total_pemilih > 0 ? round(($total_peserta / $total_pemilih) * 100, 1) : 0; ?>%
        </div>
        <div class="stat-label">Partisipasi Hak Suara (DPT)</div>
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
            <select name="dept" onchange="this.form.submit()" style="height:38px; padding:0 12px; border-radius:8px; border:1px solid #e5e5e5; font-family:'DM Sans', sans-serif; font-size:13px; outline:none; background:#ffffff;">
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

    <!-- Quick Doorprize Filter Pills -->
    <div class="filter-pills-bar">
        <span style="font-size:13px; font-weight:600; color:#6b7280; margin-right:4px;">Filter Doorprize:</span>
        <button type="button" class="filter-pill active" data-filter="">
            <span>Semua Peserta</span>
            <span class="pill-count"><?= $total_peserta; ?></span>
        </button>
        <button type="button" class="filter-pill" data-filter="Sudah Menang">
            <span>🎉 Sudah Menang</span>
            <span class="pill-count" style="color:#d97706; font-weight:700;"><?= $total_menang; ?></span>
        </button>
        <button type="button" class="filter-pill" data-filter="Belum Menang">
            <span>Belum Menang</span>
            <span class="pill-count" style="color:#6b7280; font-weight:700;"><?= $total_belum_menang; ?></span>
        </button>
    </div>

    <div class="table-responsive">
        <table id="tablePeserta" class="dataTable" style="width:100%;">
            <thead>
                <tr>
                    <th style="width:50px; text-align:center;">No</th>
                    <th style="width:110px;">NIK</th>
                    <th>Nama Anggota</th>
                    <th style="width:140px;">Departemen</th>
                    <th style="width:150px; text-align:center;">Status Hak Suara</th>
                    <th style="min-width:220px;">Doorprize Dimenangkan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($peserta)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($peserta as $p): ?>
                        <tr>
                            <td style="text-align:center;"><?= $no++; ?></td>
                            <td><code style="background:#f3f4f6; padding:3px 8px; border-radius:6px; font-size:12.5px; font-weight:600; color:#1a1a1a;"><?= html_escape($p->nik); ?></code></td>
                            <td><strong style="color:#1a1a1a; font-size:14px;"><?= html_escape($p->nama); ?></strong></td>
                            <td><span class="badge badge-warning"><?= html_escape($p->dept); ?></span></td>
                            <td style="text-align:center;"><span class="badge badge-success">Sudah Memilih (Sah)</span></td>
                            <td>
                                <?php if (!empty($p->nama_hadiah)): ?>
                                    <div class="doorprize-badge-card">
                                        <span style="display:none;">Sudah Menang <?= html_escape($p->nama_hadiah); ?></span>
                                        <div class="doorprize-badge-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect width="20" height="5" x="2" y="7"></rect><line x1="12" x2="12" y1="22" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                                            <span><?= html_escape($p->nama_hadiah); ?></span>
                                        </div>
                                        <?php if (!empty($p->tanggal_menang)): ?>
                                            <div class="doorprize-badge-time">
                                                Dimenangkan: <?= date('d M Y, H:i', strtotime($p->tanggal_menang)); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="badge-belum-menang">
                                        <span style="display:none;">Belum Menang</span>
                                        <span class="badge-belum-dot"></span>
                                        Belum Menang
                                    </span>
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
var dtTablePeserta = null;
var currentDoorprizeFilter = '';

function updateExportButtonLabel() {
    var label = 'Export Excel';
    var parts = [];
    var currentDept = '<?= html_escape($dept_terpilih); ?>';
    if (currentDept) {
        parts.push(currentDept);
    }
    if (currentDoorprizeFilter) {
        parts.push(currentDoorprizeFilter);
    }
    if (parts.length > 0) {
        label += ' (' + parts.join(' - ') + ')';
    }
    var btnText = document.getElementById('btnExportText');
    if (btnText) btnText.textContent = label;
}

function exportPesertaUndian() {
    var url = '<?= site_url("laporan/export_peserta_undian"); ?>';
    var params = [];
    var currentDept = '<?= html_escape($dept_terpilih); ?>';
    if (currentDept) {
        params.push('dept=' + encodeURIComponent(currentDept));
    }
    if (currentDoorprizeFilter) {
        params.push('status=' + encodeURIComponent(currentDoorprizeFilter));
    }
    if (dtTablePeserta && dtTablePeserta.search()) {
        params.push('search=' + encodeURIComponent(dtTablePeserta.search()));
    }
    if (params.length > 0) {
        url += '?' + params.join('&');
    }
    window.location.href = url;
}

(function() {
    function initDataTable() {
        if (typeof jQuery === 'undefined' || typeof jQuery.fn.DataTable === 'undefined') {
            setTimeout(initDataTable, 50);
            return;
        }

        dtTablePeserta = $('#tablePeserta').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari NIK, Nama, Dept, Hadiah...",
                lengthMenu: "Tampilkan _MENU_ peserta",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ peserta",
                infoEmpty: "Menampilkan 0 s/d 0 dari 0 peserta",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ditemukan data peserta yang sesuai",
                emptyTable: "Belum ada anggota yang memenuhi syarat undian<?= !empty($dept_terpilih) ? ' di departemen ' . html_escape($dept_terpilih) : ''; ?>",
                paginate: {
                    first: "«",
                    previous: "‹ Sebelumnya",
                    next: "Selanjutnya ›",
                    last: "»"
                }
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            order: [[ 0, 'asc' ]],
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    className: 'text-center'
                },
                {
                    targets: 4,
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

        // Quick Doorprize Filter Pills interaction
        $('.filter-pill').on('click', function() {
            $('.filter-pill').removeClass('active');
            $(this).addClass('active');

            currentDoorprizeFilter = $(this).data('filter') || '';
            updateExportButtonLabel();

            // Column 5 is "Doorprize Dimenangkan"
            dtTablePeserta.column(5).search(currentDoorprizeFilter ? currentDoorprizeFilter : '').draw();
        });

        updateExportButtonLabel();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDataTable);
    } else {
        initDataTable();
    }
})();
</script>
