    </div><!-- /.content-area -->
</div><!-- /.main-content -->

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

<style>
/* ── Custom SweetAlert2 Styling per design.md ── */
.swal2-popup {
    font-family: 'DM Sans', sans-serif !important;
    border-radius: 20px !important;
    padding: 24px 28px !important;
    border: 1px solid #e5e5e5 !important;
    box-shadow: 0 16px 36px rgba(0,0,0,0.08) !important;
}
.swal2-title {
    font-size: 20px !important;
    font-weight: 700 !important;
    color: #1a1a1a !important;
    padding-top: 10px !important;
}
.swal2-html-container {
    font-size: 14px !important;
    color: #4b5563 !important;
    line-height: 1.6 !important;
    margin-top: 8px !important;
}
.swal2-actions {
    gap: 10px !important;
    margin-top: 24px !important;
}
.swal2-confirm {
    border-radius: 9999px !important;
    font-weight: 600 !important;
    padding: 10px 24px !important;
    font-size: 14px !important;
    box-shadow: none !important;
    outline: none !important;
}
.swal2-cancel {
    border-radius: 9999px !important;
    font-weight: 600 !important;
    padding: 10px 24px !important;
    font-size: 14px !important;
    box-shadow: none !important;
    border: 1px solid #e5e5e5 !important;
    color: #1a1a1a !important;
    background: #ffffff !important;
    outline: none !important;
}
.swal2-cancel:hover {
    background: #f5f5f7 !important;
}
</style>

<script>
// Toast configuration
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

// Flashdata Notifications
<?php if ($this->session->flashdata('success')): ?>
    Toast.fire({
        icon: 'success',
        title: <?= json_encode($this->session->flashdata('success')); ?>
    });
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    Swal.fire({
        icon: 'error',
        title: 'Perhatian',
        html: <?= json_encode($this->session->flashdata('error')); ?>,
        confirmButtonColor: '#1a1a1a',
        confirmButtonText: 'Tutup'
    });
<?php endif; ?>

// Universal SweetAlert2 confirmation for Delete buttons
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(e) {
        var target = e.target.closest('a.btn-danger, a.btn-hapus, [data-confirm]');
        if (target) {
            e.preventDefault();
            var href = target.getAttribute('href');
            var confirmMsg = target.getAttribute('data-confirm') || 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.';

            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: confirmMsg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        }
    });
});
</script>

</body>
</html>
