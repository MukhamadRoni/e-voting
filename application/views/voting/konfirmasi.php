<style>
.section-title-wrap {
    text-align: center;
    margin-bottom: 32px;
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

.confirm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
    max-width: 900px;
    margin: 0 auto 32px;
}

.confirm-card {
    background: #ffffff;
    border: 2px solid #1a1a1a;
    border-radius: 20px;
    padding: 28px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}

.confirm-card .role-badge {
    display: inline-block;
    padding: 4px 16px;
    background: #1a1a1a;
    color: #ffffff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 9999px;
    margin-bottom: 16px;
}

.confirm-avatar {
    width: 120px;
    height: 120px;
    border-radius: 16px;
    object-fit: cover;
    margin: 0 auto 16px;
    display: block;
    border: 1px solid #e5e5e5;
    background: #f3f4f6;
}

.confirm-name {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 4px;
}

.confirm-nik {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 20px;
}

.final-action-wrap {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 20px;
    padding: 32px;
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}

.warning-callout {
    background: #fffbeb;
    border: 1px solid #fde68a;
    color: #92400e;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 14px;
    margin-bottom: 24px;
    line-height: 1.5;
}
</style>

<div class="section-title-wrap">
    <h2>Langkah 3: Konfirmasi Pilihan Suara Anda</h2>
    <p>Mohon periksa kembali pilihan Anda sebelum suara dicatat ke dalam sistem database.</p>
</div>

<div class="confirm-grid">
    <!-- Pilihan Ketua -->
    <div class="confirm-card">
        <span class="role-badge">Pilihan Calon Ketua</span>
        <?php if ($ketua->foto): ?>
            <img src="<?= base_url('assets/uploads/kandidat/' . $ketua->foto); ?>" class="confirm-avatar" alt="<?= html_escape($ketua->nama); ?>">
        <?php else: ?>
            <div class="confirm-avatar" style="display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">No Foto</div>
        <?php endif; ?>
        <div class="confirm-name"><?= html_escape($ketua->nama); ?></div>
        <div class="confirm-nik">NIK: <?= $ketua->nik; ?></div>
        <a href="<?= site_url('voting/ketua'); ?>" class="btn btn-secondary" style="padding:6px 16px; font-size:13px;">
            ✎ Ubah Pilihan
        </a>
    </div>

    <!-- Pilihan Pengawas -->
    <div class="confirm-card">
        <span class="role-badge">Pilihan Calon Pengawas</span>
        <?php if ($pengawas->foto): ?>
            <img src="<?= base_url('assets/uploads/kandidat/' . $pengawas->foto); ?>" class="confirm-avatar" alt="<?= html_escape($pengawas->nama); ?>">
        <?php else: ?>
            <div class="confirm-avatar" style="display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">No Foto</div>
        <?php endif; ?>
        <div class="confirm-name"><?= html_escape($pengawas->nama); ?></div>
        <div class="confirm-nik">NIK: <?= $pengawas->nik; ?></div>
        <a href="<?= site_url('voting/pengawas'); ?>" class="btn btn-secondary" style="padding:6px 16px; font-size:13px;">
            ✎ Ubah Pilihan
        </a>
    </div>
</div>

<div class="final-action-wrap">
    <div class="warning-callout">
        ⚠️ <strong>PENTING:</strong> Setelah menekan tombol <strong>"Kirim Suara Saya"</strong>, pilihan suara Anda akan dicatat secara permanen dan hak suara Anda tidak dapat digunakan kembali.
    </div>

    <form method="post" action="<?= site_url('voting/kirim_suara'); ?>" id="formKirimSuara">
        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
            <button type="button" id="btnKirimSuara" class="btn btn-success" style="padding:16px 40px; font-size:17px; font-weight:700;">
                ✓ YA, KIRIM SUARA SAYA
            </button>
            <a href="<?= site_url('voting/batal'); ?>" id="btnBatalVoting" class="btn btn-secondary" style="padding:16px 28px; font-size:15px;">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnKirim = document.getElementById('btnKirimSuara');
    if (btnKirim) {
        btnKirim.addEventListener('click', function() {
            Swal.fire({
                title: 'Kirim Suara Anda?',
                html: 'Pastikan pilihan Anda untuk <strong>Calon Ketua</strong> dan <strong>Calon Pengawas</strong> sudah sesuai.<br><br><span style="color:#b45309; font-size:13px; background:#fef3c7; padding:4px 12px; border-radius:9999px;">⚠️ Suara bersifat final dan tidak dapat diubah</span>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                confirmButtonText: '✓ Ya, Kirim Suara Sekarang',
                cancelButtonText: 'Periksa Kembali',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Suara...',
                        text: 'Mohon tunggu, suara Anda sedang dicatat.',
                        allowOutsideClick: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('formKirimSuara').submit();
                }
            });
        });
    }

    var btnBatal = document.getElementById('btnBatalVoting');
    if (btnBatal) {
        btnBatal.addEventListener('click', function(e) {
            e.preventDefault();
            var href = this.getAttribute('href');
            Swal.fire({
                title: 'Batalkan Sesi Voting?',
                text: 'Sesi voting akan direset dan kembali ke layar awal standby.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Lanjutkan Memilih',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    }
});
</script>
