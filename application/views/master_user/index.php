<!-- Daftar Data Pemilih -->

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
</style>

<div class="card">
    <div class="card-header">
        <div>
            <h3>Daftar Pemilih</h3>
            <span style="font-size:13px; color:#6b7280;">Total <strong><?= count($pemilih); ?></strong> anggota terdaftar dalam DPT</span>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="<?= site_url('master_user/import'); ?>" class="btn btn-secondary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Import Excel
            </a>
            <a href="<?= site_url('master_user/tambah'); ?>" class="btn btn-primary btn-sm">+ Tambah Pemilih</a>
        </div>
    </div>

    <!-- Quick Status Filter Pills -->
    <?php 
        $countSudah = 0;
        $countBelum = 0;
        foreach ($pemilih as $p) {
            if ($p->pilih === 'T') $countSudah++;
            else $countBelum++;
        }
    ?>
    <div class="filter-pills-bar">
        <span style="font-size:13px; font-weight:600; color:#6b7280; margin-right:4px;">Filter Status:</span>
        <button type="button" class="filter-pill active" data-filter="">
            <span>Semua</span>
            <span class="pill-count"><?= count($pemilih); ?></span>
        </button>
        <button type="button" class="filter-pill" data-filter="Sudah">
            <span>Sudah Memilih</span>
            <span class="pill-count" style="color:#15803d; font-weight:700;"><?= $countSudah; ?></span>
        </button>
        <button type="button" class="filter-pill" data-filter="Belum">
            <span>Belum Memilih</span>
            <span class="pill-count" style="color:#a16207; font-weight:700;"><?= $countBelum; ?></span>
        </button>
    </div>

    <div class="table-responsive">
        <table id="tablePemilih" class="dataTable" style="width:100%;">
            <thead>
                <tr>
                    <th style="width: 50px; text-align:center;">No</th>
                    <th>NIK</th>
                    <th>RFID</th>
                    <th>Nama</th>
                    <th>Department</th>
                    <th style="width: 130px; text-align:center;">Status Voting</th>
                    <th style="width: 140px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($pemilih as $p): ?>
                    <tr>
                        <td style="text-align:center;"><?= $no++; ?></td>
                        <td><strong><?= html_escape($p->nik); ?></strong></td>
                        <td><code style="background:#f3f4f6; padding:2px 6px; border-radius:6px; font-size:12px;"><?= html_escape($p->rfid); ?></code></td>
                        <td style="font-weight:600;"><?= html_escape($p->nama); ?></td>
                        <td><?= html_escape($p->dept); ?></td>
                        <td style="text-align:center;">
                            <?php if ($p->pilih == 'T'): ?>
                                <span class="badge badge-success">Sudah Memilih</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Belum Memilih</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <a href="<?= site_url('master_user/edit/' . $p->nik); ?>" class="btn btn-secondary btn-sm" style="padding:4px 12px; font-size:12px;">Edit</a>
                            <a href="<?= site_url('master_user/hapus/' . $p->nik); ?>" class="btn btn-danger btn-sm btn-hapus" style="padding:4px 12px; font-size:12px;" data-confirm="Apakah Anda yakin ingin menghapus data pemilih <strong><?= html_escape($p->nama); ?></strong> (NIK: <?= $p->nik; ?>)?">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
        var table = $('#tablePemilih').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari NIK, Nama, Dept, RFID...",
                lengthMenu: "Tampilkan _MENU_ pemilih",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ pemilih",
                infoEmpty: "Menampilkan 0 s/d 0 dari 0 pemilih",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ditemukan data pemilih yang sesuai pencarian",
                emptyTable: "Belum ada data pemilih di database",
                paginate: {
                    first: "«",
                    previous: "‹ Sebelumnya",
                    next: "Selanjutnya ›",
                    last: "»"
                }
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            order: [[ 1, 'asc' ]], // Default sort by NIK asc
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    className: 'text-center'
                },
                {
                    targets: [5, 6],
                    orderable: false
                }
            ],
            dom: '<"top-controls"lf>rt<"bottom-controls"ip>',
            drawCallback: function(settings) {
                // Auto-renumber column 0 based on current page start index
                var api = this.api();
                var start = api.page.info().start;
                api.column(0, {page: 'current'}).nodes().each(function(cell, i) {
                    cell.innerHTML = start + i + 1;
                });
            }
        });

        // Quick status filter pills interaction
        $('.filter-pill').on('click', function() {
            $('.filter-pill').removeClass('active');
            $(this).addClass('active');

            var filterValue = $(this).data('filter');
            // Column 5 is Status Voting
            table.column(5).search(filterValue ? filterValue : '').draw();
        });
    }
});
</script>
