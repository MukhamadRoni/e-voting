</main>

<footer style="background:#ffffff; border-top:1px solid #e5e5e5; padding:16px 32px; text-align:center; font-size:13px; color:#9ca3af; margin-top:auto;">
    E-Voting Koperasi &copy; <?= date('Y'); ?> &bull; Sistem Pemilihan Langsung, Umum, Bebas, dan Rahasia
</footer>

<script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

<style>
/* ── Custom SweetAlert2 Styling per design.md ── */
.swal2-popup {
    font-family: 'DM Sans', sans-serif !important;
    border-radius: 24px !important;
    padding: 32px !important;
    border: 1px solid #e5e5e5 !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
}
.swal2-title {
    font-size: 22px !important;
    font-weight: 700 !important;
    color: #1a1a1a !important;
    padding-top: 10px !important;
}
.swal2-html-container {
    font-size: 15px !important;
    color: #4b5563 !important;
    line-height: 1.6 !important;
    margin-top: 10px !important;
}
.swal2-actions {
    gap: 12px !important;
    margin-top: 28px !important;
}
.swal2-confirm {
    border-radius: 9999px !important;
    font-weight: 600 !important;
    padding: 12px 28px !important;
    font-size: 15px !important;
    box-shadow: none !important;
}
.swal2-cancel {
    border-radius: 9999px !important;
    font-weight: 600 !important;
    padding: 12px 28px !important;
    font-size: 15px !important;
    box-shadow: none !important;
    border: 1px solid #e5e5e5 !important;
    color: #1a1a1a !important;
    background: #ffffff !important;
}
.swal2-cancel:hover {
    background: #f5f5f7 !important;
}
</style>

<script>
// Error Alert Handler
<?php if ($this->session->flashdata('error')): ?>
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian Pemilih',
        html: <?= json_encode($this->session->flashdata('error')); ?>,
        confirmButtonColor: '#1a1a1a',
        confirmButtonText: 'Saya Mengerti'
    });
<?php endif; ?>

// Success Toast / Alert Handler
<?php if ($this->session->flashdata('success')): ?>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        html: <?= json_encode($this->session->flashdata('success')); ?>,
        confirmButtonColor: '#1a1a1a',
        confirmButtonText: 'Lanjutkan'
    });
<?php endif; ?>

// SweetAlert2 Confirmation for Cancel Voter in Header
document.addEventListener('DOMContentLoaded', function() {
    var cancelLinks = document.querySelectorAll('.btn-cancel-voter');
    cancelLinks.forEach(function(link) {
        link.removeAttribute('onclick'); // remove old confirm()
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var href = this.getAttribute('href');
            Swal.fire({
                title: 'Batalkan Sesi Pemilih?',
                text: 'Proses pemilihan akan dibatalkan dan sistem akan kembali ke layar awal standby.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Kembali',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Membatalkan Sesi...',
                        text: 'Mohon tunggu sebentar...',
                        allowOutsideClick: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });

                    fetch(href, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(function(r) { return r.json(); })
                    .then(function(res) {
                        if (res.status === 'success' && res.data && res.data.redirect) {
                            window.location.href = res.data.redirect;
                        } else {
                            window.location.href = href;
                        }
                    })
                    .catch(function() {
                        window.location.href = href;
                    });
                }
            });
        });
    });

    // ── Mode Fullscreen Kiosk Pemilihan ──
    var btnFs = document.getElementById('btnFullscreen');
    if (btnFs) {
        var iconEnter = btnFs.querySelector('.fs-icon-enter');
        var iconExit  = btnFs.querySelector('.fs-icon-exit');
        var labelFs   = btnFs.querySelector('span');

        function getFsElement() {
            return document.fullscreenElement ||
                   document.webkitFullscreenElement ||
                   document.mozFullScreenElement ||
                   document.msFullscreenElement || null;
        }

        function isFsActive() {
            return !!getFsElement();
        }

        function requestFs(el) {
            if (el.requestFullscreen) {
                return el.requestFullscreen();
            } else if (el.webkitRequestFullscreen) {
                return el.webkitRequestFullscreen();
            } else if (el.mozRequestFullScreen) {
                return el.mozRequestFullScreen();
            } else if (el.msRequestFullscreen) {
                return el.msRequestFullscreen();
            }
            return Promise.reject(new Error('Fullscreen not supported'));
        }

        function exitFs() {
            if (document.exitFullscreen) {
                return document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                return document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                return document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                return document.msExitFullscreen();
            }
            return Promise.reject(new Error('Exit fullscreen not supported'));
        }

        function updateFullscreenUI() {
            var active = isFsActive();
            if (active) {
                btnFs.classList.add('is-active');
                if (iconEnter) iconEnter.style.display = 'none';
                if (iconExit) iconExit.style.display = 'inline-block';
                if (labelFs) labelFs.textContent = 'Exit Screen';
                btnFs.setAttribute('title', 'Keluar dari Mode Layar Penuh (Esc)');
                try { sessionStorage.setItem('voting_kiosk_fullscreen', '1'); } catch(e) {}
            } else {
                btnFs.classList.remove('is-active');
                if (iconEnter) iconEnter.style.display = 'inline-block';
                if (iconExit) iconExit.style.display = 'none';
                if (labelFs) labelFs.textContent = 'Fullscreen';
                btnFs.setAttribute('title', 'Layar Penuh (F11)');
                try {
                    // Jika keluar secara manual dari fullscreen
                    if (sessionStorage.getItem('voting_kiosk_fullscreen') === '1' && !active) {
                        sessionStorage.setItem('voting_kiosk_fullscreen', '0');
                    }
                } catch(e) {}
            }
        }

        function toggleFullscreen() {
            if (!isFsActive()) {
                requestFs(document.documentElement).then(function() {
                    try { sessionStorage.setItem('voting_kiosk_fullscreen', '1'); } catch(e) {}
                    updateFullscreenUI();
                }).catch(function(err) {
                    console.warn('Fullscreen request rejected:', err);
                });
            } else {
                try { sessionStorage.setItem('voting_kiosk_fullscreen', '0'); } catch(e) {}
                exitFs().then(function() {
                    updateFullscreenUI();
                }).catch(function(err) {
                    console.warn('Exit fullscreen rejected:', err);
                });
            }
        }

        btnFs.addEventListener('click', function(e) {
            e.preventDefault();
            toggleFullscreen();
        });

        // Event listener perubahan status fullscreen dari browser / tombol keyboard Esc
        ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'MSFullscreenChange'].forEach(function(evt) {
            document.addEventListener(evt, updateFullscreenUI);
        });

        // Dukungan shortcut F11
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F11') {
                e.preventDefault();
                toggleFullscreen();
            }
        });

        // Inisialisasi awal UI
        updateFullscreenUI();

        // Pemulihan otomatis mode fullscreen antar halaman bilik suara (RFID -> Pilih -> Selesai)
        try {
            if (sessionStorage.getItem('voting_kiosk_fullscreen') === '1' && !isFsActive()) {
                // Browser memerlukan interaksi pengguna (user gesture) jika navigasi baru
                var resumeFullscreenOnGesture = function() {
                    if (sessionStorage.getItem('voting_kiosk_fullscreen') === '1' && !isFsActive()) {
                        requestFs(document.documentElement).catch(function() {});
                    }
                    document.removeEventListener('click', resumeFullscreenOnGesture);
                    document.removeEventListener('touchstart', resumeFullscreenOnGesture);
                };
                document.addEventListener('click', resumeFullscreenOnGesture, { once: true });
                document.addEventListener('touchstart', resumeFullscreenOnGesture, { once: true });
            }
        } catch(e) {}
    }
});
</script>

</body>
</html>
