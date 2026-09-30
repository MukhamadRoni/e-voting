</main>

<footer style="background:#ffffff; border-top:1px solid #e5e5e5; padding:16px 32px; text-align:center; font-size:13px; color:#9ca3af; margin-top:auto;">
    E-Voting Koperasi &copy; <?= date('Y'); ?> &bull; Sistem Pemilihan Langsung, Umum, Bebas, dan Rahasia
</footer>

<script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

<style>
/* ── Custom SweetAlert2 Styling per design.md ── */
.swal2-container {
    background-color: rgba(0, 0, 0, 0.4) !important;
    -webkit-backdrop-filter: blur(4px) !important;
    backdrop-filter: blur(4px) !important;
}
.swal2-container.swal2-backdrop-show {
    background-color: rgba(0, 0, 0, 0.4) !important;
}
html.swal2-shown,
body.swal2-shown,
html.swal2-height-auto,
body.swal2-height-auto {
    height: 100% !important;
    min-height: 100% !important;
    background-color: #f8f9fa !important;
    background: #f8f9fa !important;
}
.swal2-popup {
    font-family: 'DM Sans', sans-serif !important;
    border-radius: 24px !important;
    padding: 32px !important;
    border: 1px solid #e5e5e5 !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
    background: #ffffff !important;
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
// Prevent SweetAlert2 from collapsing viewport height to auto (fixes tablet black flash)
if (typeof Swal !== 'undefined') {
    var _origSwalFire = Swal.fire;
    Swal.fire = function() {
        var args = Array.prototype.slice.call(arguments);
        if (typeof args[0] === 'object' && args[0] !== null) {
            if (args[0].heightAuto === undefined) {
                args[0].heightAuto = false;
            }
        }
        return _origSwalFire.apply(this, args);
    };
}

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

    // Helper Escape HTML
    function escapeHtmlKiosk(str) {
        if (!str) return '';
        var d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    // Eksekusi script di dalam HTML yang dimuat secara dinamis
    window.setContentAndRunScripts = function(container, html) {
        if (!container) return;
        container.innerHTML = html;
        var scripts = container.querySelectorAll('script');
        scripts.forEach(function(oldScript) {
            var newScript = document.createElement('script');
            Array.from(oldScript.attributes).forEach(function(attr) {
                newScript.setAttribute(attr.name, attr.value);
            });
            newScript.textContent = oldScript.textContent;
            oldScript.parentNode.replaceChild(newScript, oldScript);
        });
    };

    // Update Stepper & Voter Badge di Navbar tanpa reload halaman
    window.updateKioskNavbarState = function(step, voter) {
        var stepperEl = document.getElementById('kioskStepperContainer');
        var badgeEl   = document.getElementById('kioskVoterBadgeContainer');

        if (stepperEl) {
            if (step === 1) {
                stepperEl.innerHTML = '<div class="stepper">' +
                    '<div class="step-item active"><div class="step-circle">1</div><span>Pilih Ketua & Pengawas</span></div>' +
                    '<span style="color:#d1d5db;">→</span>' +
                    '<div class="step-item"><div class="step-circle">2</div><span>Selesai</span></div>' +
                    '</div>';
            } else if (step === 2) {
                stepperEl.innerHTML = '<div class="stepper">' +
                    '<div class="step-item done"><div class="step-circle">✓</div><span>Pilih Ketua & Pengawas</span></div>' +
                    '<span style="color:#d1d5db;">→</span>' +
                    '<div class="step-item active"><div class="step-circle">✓</div><span>Selesai</span></div>' +
                    '</div>';
            } else {
                stepperEl.innerHTML = '';
            }
        }

        if (badgeEl) {
            if (voter && voter.nama) {
                badgeEl.innerHTML = '<div class="voter-badge-pill">' +
                    '<span>Pemilih: <strong>' + escapeHtmlKiosk(voter.nama) + '</strong> (' + escapeHtmlKiosk(voter.dept || '') + ')</span>' +
                    '<a href="<?= site_url('voting/batal'); ?>" class="btn-cancel-voter">Batal</a>' +
                    '</div>';
                attachCancelVoterListeners();
            } else {
                badgeEl.innerHTML = '<a href="<?= site_url('auth'); ?>" class="btn-link-admin">Panel Admin →</a>';
            }
        }
    };

    // Navigasi Seamless Kiosk (SPA View Swap agar browser TIDAK PERNAH keluar dari Fullscreen)
    window.navigateKiosk = function(url, onDone) {
        var mainEl = document.getElementById('votingMainContainer');
        if (!mainEl) {
            window.location.href = url;
            return;
        }

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function(res) {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(function(data) {
            if (data.status === 'success' && data.data && data.data.html) {
                if (data.data.title) document.title = data.data.title;
                try {
                    window.history.pushState({ url: url }, '', url);
                } catch(e) {}

                updateKioskNavbarState(data.data.step, data.data.voter);
                setContentAndRunScripts(mainEl, data.data.html);

                // Selalu fokuskan ke id inputIdentitas saat halaman voting dibuka/dimuat dinamis tanpa membuka keyboard virtual tablet
                var rfidInput = document.getElementById('inputIdentitas');
                if (rfidInput) {
                    if (rfidInput.getAttribute('inputmode') === 'none' && 'virtualKeyboard' in navigator) {
                        navigator.virtualKeyboard.hide();
                    }
                    setTimeout(function() {
                        try {
                            rfidInput.focus({ preventScroll: true });
                            if (rfidInput.setSelectionRange) {
                                var len = rfidInput.value.length;
                                rfidInput.setSelectionRange(len, len);
                            }
                        } catch(e) {}
                    }, 50);
                    setTimeout(function() {
                        try { rfidInput.focus({ preventScroll: true }); } catch(e) {}
                    }, 200);
                }

                // Pastikan fullscreen tetap aktif di tablet jika preferensi aktif
                if (getSavedFsPref() === '1' && !isFsActive()) {
                    requestFs(document.documentElement).catch(function() {});
                }

                if (typeof onDone === 'function') onDone(data);
            } else if (data.data && data.data.redirect) {
                navigateKiosk(data.data.redirect);
            } else {
                window.location.href = url;
            }
        })
        .catch(function(err) {
            console.warn('Seamless navigation fallback to location.href:', err);
            window.location.href = url;
        });
    };

    // SweetAlert2 Confirmation for Cancel Voter in Header
    function attachCancelVoterListeners() {
        var cancelLinks = document.querySelectorAll('.btn-cancel-voter');
        cancelLinks.forEach(function(link) {
            link.removeAttribute('onclick');
            link.onclick = function(e) {
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
                    reverseButtons: true,
                    heightAuto: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Membatalkan Sesi...',
                            text: 'Mohon tunggu sebentar...',
                            allowOutsideClick: false,
                            heightAuto: false,
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
                            Swal.close();
                            if (res.status === 'success' && res.data && res.data.redirect) {
                                navigateKiosk(res.data.redirect);
                            } else {
                                window.location.href = href;
                            }
                        })
                        .catch(function() {
                            window.location.href = href;
                        });
                    }
                });
            };
        });
    }

    attachCancelVoterListeners();

    // ── Mode Fullscreen Kiosk Pemilihan ──
    var btnFs    = document.getElementById('btnFullscreen');
    var promptFs = document.getElementById('kioskFsPrompt');

    function getFsElement() {
        return document.fullscreenElement ||
               document.webkitFullscreenElement ||
               document.mozFullScreenElement ||
               document.msFullscreenElement || null;
    }

    function isFsActive() {
        return !!getFsElement();
    }

    function getSavedFsPref() {
        try {
            var val = localStorage.getItem('voting_kiosk_fullscreen');
            if (val === null) {
                val = sessionStorage.getItem('voting_kiosk_fullscreen');
            }
            return val;
        } catch(e) {
            return null;
        }
    }

    function setSavedFsPref(val) {
        try {
            localStorage.setItem('voting_kiosk_fullscreen', val);
            sessionStorage.setItem('voting_kiosk_fullscreen', val);
        } catch(e) {}
    }

    // Auto-detect parameter URL ?autofs=1 atau ?fullscreen=1
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('autofs') === '1' || urlParams.get('fullscreen') === '1') {
        setSavedFsPref('1');
    }

    function showPromptBanner() {
        if (promptFs && !isFsActive() && getSavedFsPref() === '1') {
            promptFs.style.display = 'inline-flex';
        }
    }

    function hidePromptBanner() {
        if (promptFs) {
            promptFs.style.display = 'none';
        }
    }

    function requestFs(el) {
        if (!el) el = document.documentElement;
        try {
            var promise = null;
            if (el.requestFullscreen) {
                promise = el.requestFullscreen();
            } else if (el.webkitRequestFullscreen) {
                promise = el.webkitRequestFullscreen();
            } else if (el.mozRequestFullScreen) {
                promise = el.mozRequestFullScreen();
            } else if (el.msRequestFullscreen) {
                promise = el.msRequestFullscreen();
            } else {
                return Promise.reject(new Error('Fullscreen not supported'));
            }
            if (promise && typeof promise.then === 'function') {
                return promise;
            }
            return Promise.resolve();
        } catch(err) {
            return Promise.reject(err);
        }
    }

    function exitFs() {
        try {
            var promise = null;
            if (document.exitFullscreen) {
                promise = document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                promise = document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                promise = document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                promise = document.msExitFullscreen();
            } else {
                return Promise.reject(new Error('Exit fullscreen not supported'));
            }
            if (promise && typeof promise.then === 'function') {
                return promise;
            }
            return Promise.resolve();
        } catch(err) {
            return Promise.reject(err);
        }
    }

    function updateFullscreenUI() {
        var active = isFsActive();
        var currentBtn = document.getElementById('btnFullscreen');
        if (currentBtn) {
            var iconEnter = currentBtn.querySelector('.fs-icon-enter');
            var iconExit  = currentBtn.querySelector('.fs-icon-exit');
            var labelFs   = currentBtn.querySelector('span');

            if (active) {
                currentBtn.classList.add('is-active');
                if (iconEnter) iconEnter.style.display = 'none';
                if (iconExit) iconExit.style.display = 'inline-block';
                if (labelFs) labelFs.textContent = 'Exit Screen';
                currentBtn.setAttribute('title', 'Keluar dari Mode Layar Penuh (Esc)');
                setSavedFsPref('1');
                hidePromptBanner();
            } else {
                currentBtn.classList.remove('is-active');
                if (iconEnter) iconEnter.style.display = 'inline-block';
                if (iconExit) iconExit.style.display = 'none';
                if (labelFs) labelFs.textContent = 'Fullscreen';
                currentBtn.setAttribute('title', 'Layar Penuh (F11)');

                if (getSavedFsPref() === '1') {
                    showPromptBanner();
                }
            }
        }
    }

    // Event listener click delegation untuk tombol fullscreen & prompt banner
    document.addEventListener('click', function(e) {
        var clickedBtn = e.target.closest('#btnFullscreen');
        if (clickedBtn) {
            e.preventDefault();
            if (!isFsActive()) {
                setSavedFsPref('1');
                requestFs(document.documentElement).then(function() {
                    updateFullscreenUI();
                }).catch(function(err) {
                    console.warn('Fullscreen request rejected:', err);
                });
            } else {
                setSavedFsPref('0');
                hidePromptBanner();
                exitFs().then(function() {
                    updateFullscreenUI();
                }).catch(function(err) {
                    console.warn('Exit fullscreen rejected:', err);
                });
            }
            return;
        }

        var clickedPrompt = e.target.closest('#kioskFsPrompt');
        if (clickedPrompt) {
            e.preventDefault();
            requestFs(document.documentElement).then(function() {
                updateFullscreenUI();
            }).catch(function(err) {
                console.warn('Fullscreen request rejected:', err);
            });
            return;
        }
    });

    // Event listener perubahan status fullscreen dari browser / tombol keyboard Esc
    ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'MSFullscreenChange'].forEach(function(evt) {
        document.addEventListener(evt, updateFullscreenUI);
    });

    // Dukungan shortcut F11
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F11') {
            e.preventDefault();
            if (!isFsActive()) {
                setSavedFsPref('1');
                requestFs(document.documentElement);
            } else {
                setSavedFsPref('0');
                exitFs();
            }
        }
    });

    // Inisialisasi awal UI
    updateFullscreenUI();

    // Pemulihan otomatis mode fullscreen antar halaman bilik suara di tablet/layar
    if (getSavedFsPref() === '1' && !isFsActive()) {
        requestFs(document.documentElement).catch(function() {
            showPromptBanner();

            var resumeOnFirstInteraction = function(e) {
                if (getSavedFsPref() === '1' && !isFsActive()) {
                    requestFs(document.documentElement).then(function() {
                        hidePromptBanner();
                        updateFullscreenUI();
                    }).catch(function() {});
                }
                document.removeEventListener('click', resumeOnFirstInteraction, true);
                document.removeEventListener('touchend', resumeOnFirstInteraction, true);
                document.removeEventListener('pointerup', resumeOnFirstInteraction, true);
            };

            document.addEventListener('click', resumeOnFirstInteraction, true);
            document.addEventListener('touchend', resumeOnFirstInteraction, true);
            document.addEventListener('pointerup', resumeOnFirstInteraction, true);
        });
    }

    // Selalu fokuskan ke id inputIdentitas setiap kali halaman voting terbuka tanpa memicu keyboard virtual tablet
    function autoFocusInputIdentitas() {
        var inputId = document.getElementById('inputIdentitas');
        if (inputId) {
            try {
                if (inputId.getAttribute('inputmode') === 'none' && 'virtualKeyboard' in navigator) {
                    navigator.virtualKeyboard.hide();
                }
                inputId.focus({ preventScroll: true });
                if (inputId.setSelectionRange) {
                    var len = inputId.value.length;
                    inputId.setSelectionRange(len, len);
                }
            } catch(e) {}
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', autoFocusInputIdentitas);
    } else {
        autoFocusInputIdentitas();
    }
    setTimeout(autoFocusInputIdentitas, 80);
    setTimeout(autoFocusInputIdentitas, 250);
</script>

</body>
</html>
