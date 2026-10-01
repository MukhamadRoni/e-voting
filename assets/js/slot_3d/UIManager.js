/**
 * UIManager.js & SoundEngine
 * Manajemen Antarmuka Pengguna, Tombol Spin HTML/CSS,
 * Overlay Teks "JACKPOT! 777" Gradien Emas Beranimasi,
 * Web Audio Synthesizer, & Integrasi API Undian RAT
 */
(function(window) {
    'use strict';

    // ── Web Audio Synthesizer (Zero Dependencies / Works Offline) ──
    var SlotSoundEngine = (function() {
        var audioCtx = null;

        function getCtx() {
            if (!audioCtx) {
                var AudioContext = window.AudioContext || window.webkitAudioContext;
                if (AudioContext) audioCtx = new AudioContext();
            }
            if (audioCtx && audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            return audioCtx;
        }

        return {
            playSpinStart: function() {
                var ctx = getCtx();
                if (!ctx) return;
                var osc = ctx.createOscillator();
                var gain = ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(220, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.35);
                gain.gain.setValueAtTime(0.2, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.35);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.35);
            },
            playReelStop: function(reelIndex) {
                var ctx = getCtx();
                if (!ctx) return;
                var osc = ctx.createOscillator();
                var gain = ctx.createGain();
                osc.type = 'sine';
                var freq = 340 + reelIndex * 85; // Ascending mechanical lock tones for each of the 6 digits
                osc.frequency.setValueAtTime(freq, ctx.currentTime);
                gain.gain.setValueAtTime(0.35, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.18);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.18);
            },
            playJackpotFanfare: function() {
                var ctx = getCtx();
                if (!ctx) return;
                var notes = [523.25, 659.25, 783.99, 1046.50, 1318.51, 1567.98]; // C5 Major Arpeggio
                notes.forEach(function(freq, idx) {
                    var osc = ctx.createOscillator();
                    var gain = ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.value = freq;
                    var t = ctx.currentTime + idx * 0.12;
                    gain.gain.setValueAtTime(0.25, t);
                    gain.gain.exponentialRampToValueAtTime(0.001, t + 0.6);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(t);
                    osc.stop(t + 0.6);
                });
            }
        };
    })();
    window.SlotSoundEngine = SlotSoundEngine;

    // ── UIManager ──
    function UIManager(options) {
        this.threeScene = options.threeScene;
        this.slotMachine = options.slotMachine;
        this.lightingManager = options.lightingManager;
        this.particleSystem = options.particleSystem;

        this.btnSpin = document.getElementById(options.btnSpinId || 'btnSpin');
        this.btnSpinText = document.getElementById(options.btnSpinTextId || 'btnSpinText');
        this.overlay = document.getElementById(options.overlayId || 'jackpotOverlay');
        this.inputHadiah = document.getElementById('inputHadiah');
        this.filterDept = document.getElementById('filterDept');
        this.toggleAutoValid = document.getElementById('toggleAutoValid');
        this.counterPeserta = document.getElementById('counterPeserta');

        this.acakUrl = options.acakUrl;
        this.simpanUrl = options.simpanUrl;

        this.isBusy = false;
        this.cachedWinner = null;

        this.init();
    }

    UIManager.prototype.init = function() {
        var self = this;

        if (this.btnSpin) {
            this.btnSpin.addEventListener('click', function() {
                self.onSpinClick();
            });
        }
    };

    UIManager.prototype.onSpinClick = function() {
        if (this.isBusy) return;

        var sisa = parseInt(this.counterPeserta ? this.counterPeserta.textContent : '1', 10);
        if (sisa <= 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tidak Ada Peserta Tersisa',
                text: 'Seluruh peserta yang berhak telah memenangkan undian door prize.',
                confirmButtonColor: '#1a1a1a'
            });
            return;
        }

        var hadiah = this.inputHadiah ? (this.inputHadiah.value.trim() || 'Door Prize Utama') : 'Door Prize Utama';
        var dept = this.filterDept ? this.filterDept.value : '';
        var isAutoValid = this.toggleAutoValid ? this.toggleAutoValid.checked : true;

        this.isBusy = true;
        this.setButtonState('spinning');
        this.hideJackpotOverlay();

        // Turn on spinning mode for lighting and sound
        if (this.lightingManager) this.lightingManager.setSpinningMode(true);
        if (this.threeScene) this.threeScene.setSpinningMode(true);
        SlotSoundEngine.playSpinStart();

        // Start 3D reels immediately
        if (this.slotMachine) {
            this.slotMachine.startSpinning();
        }

        var self = this;

        // Fetch candidate from server while reels start rolling
        fetch(this.acakUrl + '?dept=' + encodeURIComponent(dept))
            .then(function(res) { return res.json(); })
            .then(function(response) {
                if (response.status !== 'success') {
                    if (self.slotMachine) self.slotMachine.cancelSpin();
                    self.resetSpinState();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: response.message,
                        confirmButtonColor: '#1a1a1a'
                    });
                    return;
                }

                self.cachedWinner = response.data;

                // Launch sequential stopping per digit to form winner's 6-digit NIK!
                var targetNik = (self.cachedWinner && self.cachedWinner.nik) ? self.cachedWinner.nik : '000000';
                self.slotMachine.setTargetNik(targetNik, function() {
                    self.onJackpotLanded(self.cachedWinner, hadiah, isAutoValid, dept);
                });
            })
            .catch(function(err) {
                console.error(err);
                if (self.slotMachine) self.slotMachine.cancelSpin();
                self.resetSpinState();
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Tidak dapat menghubungi server undian.',
                    confirmButtonColor: '#1a1a1a'
                });
            });
    };

    /**
     * Triggered when all 6 reels land sequentially on winner's NIK (JACKPOT!)
     */
    UIManager.prototype.onJackpotLanded = function(winner, hadiah, isAutoValid, dept) {
        var self = this;

        // 1. Play victory fanfare
        SlotSoundEngine.playJackpotFanfare();

        // 2. Trigger Visual Celebrations
        if (this.lightingManager) {
            this.lightingManager.setSpinningMode(false);
            this.lightingManager.setJackpotMode(true);
        }
        if (this.particleSystem) {
            this.particleSystem.setJackpotMode(true);
        }
        if (this.threeScene) {
            this.threeScene.setSpinningMode(false);
            this.threeScene.setJackpotMode(true);
        }

        // Also trigger full-screen 2D canvas confetti blast if available
        if (window.ConfettiEngine) {
            window.ConfettiEngine.blast(180);
        }

        // 3. Show the Glorious "JACKPOT! [NIK]" Animated Gold Gradient Overlay
        this.showJackpotOverlay(winner, hadiah);

        // 4. Proceed with Bilik Undian Verification Workflow after celebration display
        setTimeout(function() {
            if (isAutoValid) {
                self.saveWinnerDirectly(winner, hadiah, dept);
            } else {
                self.promptValidationPopup(winner, hadiah, dept);
            }
        }, 1600);
    };

    UIManager.prototype.showJackpotOverlay = function(winner, hadiah) {
        if (!this.overlay) return;

        var titleEl = document.getElementById('jackpotTitleText');
        var nameEl = document.getElementById('jackpotWinnerName');
        var metaEl = document.getElementById('jackpotWinnerMeta');
        var prizeEl = document.getElementById('jackpotPrizeLabel');

        if (titleEl && winner) {
            titleEl.textContent = 'JACKPOT! ' + winner.nik;
        }
        if (nameEl && winner) nameEl.textContent = winner.nama.toUpperCase();
        if (metaEl && winner) {
            metaEl.textContent = 'NIK: ' + winner.nik + ' • DEPARTEMEN: ' + (winner.dept || '-');
        }
        if (prizeEl) prizeEl.textContent = hadiah;

        this.overlay.classList.add('active');
    };

    UIManager.prototype.hideJackpotOverlay = function() {
        if (this.overlay) {
            this.overlay.classList.remove('active');
        }
    };

    UIManager.prototype.setButtonState = function(state) {
        if (!this.btnSpin) return;

        if (state === 'spinning') {
            this.btnSpin.disabled = true;
            this.btnSpin.classList.add('spinning');
            if (this.btnSpinText) this.btnSpinText.textContent = 'MENGACAK 6-DIGIT NIK...';
        } else if (state === 'ready') {
            this.btnSpin.disabled = false;
            this.btnSpin.classList.remove('spinning');
            if (this.btnSpinText) this.btnSpinText.textContent = 'PUTAR UNDIAN BERIKUTNYA';
        } else {
            this.btnSpin.disabled = false;
            this.btnSpin.classList.remove('spinning');
            if (this.btnSpinText) this.btnSpinText.textContent = 'PUTAR UNDIAN SEKARANG';
        }
    };

    UIManager.prototype.resetSpinState = function() {
        this.isBusy = false;
        this.setButtonState('idle');
        if (this.lightingManager) {
            this.lightingManager.setSpinningMode(false);
            this.lightingManager.setJackpotMode(false);
        }
        if (this.particleSystem) {
            this.particleSystem.setJackpotMode(false);
        }
        if (this.threeScene) {
            this.threeScene.setSpinningMode(false);
            this.threeScene.setJackpotMode(false);
        }
        if (this.slotMachine) {
            this.slotMachine.isSpinning = false;
            this.slotMachine.isJackpot = false;
        }
    };

    /**
     * Auto Valid: Save directly to database
     */
    UIManager.prototype.saveWinnerDirectly = function(winner, hadiah, dept) {
        var self = this;
        var formData = new FormData();
        formData.append('nik', winner.nik);
        formData.append('nama_hadiah', hadiah);
        formData.append('status', 'valid');
        formData.append('dept', dept);

        fetch(this.simpanUrl, {
            method: 'POST',
            body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            self.isBusy = false;
            self.setButtonState('ready');

            if (data.status === 'success') {
                if (typeof window.addWinnerToSidebar === 'function') {
                    window.addWinnerToSidebar(winner, hadiah);
                }
                if (self.counterPeserta) {
                    self.counterPeserta.textContent = data.sisa_peserta;
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal Menyimpan', text: data.message });
            }
        })
        .catch(function(err) {
            console.error(err);
            self.resetSpinState();
        });
    };

    /**
     * Manual Valid: Prompt presence validation popup
     */
    UIManager.prototype.promptValidationPopup = function(winner, hadiah, dept) {
        var self = this;

        Swal.fire({
            title: 'Konfirmasi Kehadiran Pemenang',
            html: '<div style="margin-top:12px;">' +
                    '<div style="font-size:22px; font-weight:800; color:#1a1a1a; margin-bottom:6px;">' + winner.nama + '</div>' +
                    '<div style="font-size:14px; color:#6b7280; margin-bottom:16px;">NIK: <b>' + winner.nik + '</b> • Departemen: <b>' + (winner.dept || '-') + '</b></div>' +
                    '<div style="padding:12px 18px; background:#fef3c7; border:1px solid #fde68a; border-radius:12px; color:#b45309; font-weight:700; margin-bottom:18px;">' +
                        'Hadiah: ' + hadiah +
                    '</div>' +
                    '<div style="font-size:15px; font-weight:600; color:#1a1a1a;">Apakah anggota yang bersangkutan hadir di ruangan RAT?</div>' +
                  '</div>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#dc2626',
            confirmButtonText: '✓ VALID (Hadir & Sah)',
            cancelButtonText: '✕ TIDAK VALID (Hangus / Undi Ulang)',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(function(result) {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('nik', winner.nik);
                formData.append('nama_hadiah', hadiah);
                formData.append('status', 'valid');
                formData.append('dept', dept);

                fetch(self.simpanUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    self.isBusy = false;
                    self.setButtonState('ready');

                    if (data.status === 'success') {
                        if (typeof window.addWinnerToSidebar === 'function') {
                            window.addWinnerToSidebar(winner, hadiah);
                        }
                        if (self.counterPeserta) {
                            self.counterPeserta.textContent = data.sisa_peserta;
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Undian Sah & Diterima!',
                            text: 'Pemenang ' + winner.nama + ' berhasil disimpan permanen.',
                            confirmButtonColor: '#1a1a1a',
                            timer: 2000
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                self.resetSpinState();
                self.hideJackpotOverlay();

                Swal.fire({
                    icon: 'warning',
                    title: 'Undian Dibatalkan / Hangus',
                    html: 'Peserta <b>' + winner.nama + '</b> dinyatakan tidak hadir.<br>Hadiah <b>' + hadiah + '</b> dapat diundi kembali.',
                    confirmButtonColor: '#1a1a1a',
                    confirmButtonText: 'Siap Undi Ulang'
                });
            }
        });
    };

    window.UIManager = UIManager;
})(window);
