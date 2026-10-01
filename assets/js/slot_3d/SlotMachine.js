/**
 * SlotMachine.js
 * Model 3D Mesin Slot 6-Reel untuk NIK 6-Digit Anggota Koperasi
 * - 6 Gulungan Independen dengan Geometri Buffer Khusus
 * - Menampilkan Digit Jelas & Megah 0-9 (Ruby Gem Faceted & Golden Outline)
 * - Berhenti Berurutan Tiap Item (Digit 1 -> Digit 6) untuk Membentuk NIK Pemenang
 * - Efek Mekanikal Halus & Suara Mengunci Tiap Digit
 */
(function(window) {
    'use strict';

    function SlotMachine(scene, parentPivot) {
        this.scene = scene;
        this.pivot = parentPivot || scene;
        this.reels = [];
        this.isSpinning = false;
        this.isJackpot = false;
        this.spinStartTime = 0;
        this.onCompleteCallback = null;

        // 6 Reels untuk NIK 6-Digit
        this.numReels = 6;
        // 10 Simbol Angka (0 sampai 9)
        this.numSymbols = 10;
        this.twoPi = Math.PI * 2;

        // Target NIK default
        this.targetNik = '777777';

        this.init();
    }

    SlotMachine.prototype.init = function() {
        this.group = new THREE.Group();
        this.pivot.add(this.group);

        // 1. Buat Tekstur Kanvas Resolusi Tinggi untuk Angka 0-9
        this.generateReelTextures();

        // 2. Buat Casing Emas Mesin Slot Arcade
        this.buildGoldFrame();

        // 3. Buat 6 Gulungan Silinder 3D Presisi Tinggi
        this.buildReels();

        // 4. Lampu Sorot Emissive untuk Tiap Digit yang Mengunci
        this.setupGlowLights();
    };

    /**
     * Menghasilkan Tekstur Kanvas High-Res untuk Angka 0-9
     * Format: 512 x 5120 px (10 slot bujur sangkar 512 x 512 px)
     * Tiap slot berisi angka besar, tajam, bergaya kasino kristal ruby dengan garis emas
     */
    SlotMachine.prototype.generateReelTextures = function() {
        var w = 512;
        var slotH = 512;
        var h = slotH * this.numSymbols; // 5120 px

        // Kanvas Diffuse (Warna Utama)
        var canvas = document.createElement('canvas');
        canvas.width = w;
        canvas.height = h;
        var ctx = canvas.getContext('2d');

        // Kanvas Emissive (Cahaya Mandiri saat Menang/Mengunci)
        var emCanvas = document.createElement('canvas');
        emCanvas.width = w;
        emCanvas.height = h;
        var emCtx = emCanvas.getContext('2d');
        emCtx.fillStyle = '#000000';
        emCtx.fillRect(0, 0, w, h);

        for (var digit = 0; digit < this.numSymbols; digit++) {
            var yStart = digit * slotH;
            var centerY = yStart + slotH / 2;
            var centerX = w / 2;

            // 1. Background Drum Slot: Gradien Mutiara / Putih Perak Kasino
            var bgGrad = ctx.createLinearGradient(0, yStart, w, yStart);
            bgGrad.addColorStop(0, '#dbe2ea');
            bgGrad.addColorStop(0.12, '#f8fafc');
            bgGrad.addColorStop(0.5, '#ffffff');
            bgGrad.addColorStop(0.88, '#f8fafc');
            bgGrad.addColorStop(1, '#dbe2ea');
            ctx.fillStyle = bgGrad;
            ctx.fillRect(0, yStart, w, slotH);

            // 2. Pola Dot-Matrix Bersih & Elegan
            ctx.fillStyle = 'rgba(148, 163, 184, 0.35)';
            var dotSpacing = 20;
            for (var dy = yStart + 8; dy < yStart + slotH - 8; dy += dotSpacing) {
                for (var dx = 16; dx < w - 16; dx += dotSpacing) {
                    ctx.beginPath();
                    ctx.arc(dx, dy, 2, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            // 3. Garis Pembatas Metalik / Emas Antar Slot (Atas & Bawah)
            ctx.fillStyle = '#b45309';
            ctx.fillRect(0, yStart, w, 4);
            ctx.fillStyle = '#ffd700';
            ctx.fillRect(0, yStart + 2, w, 2);

            ctx.fillStyle = '#b45309';
            ctx.fillRect(0, yStart + slotH - 4, w, 4);
            ctx.fillStyle = '#ffd700';
            ctx.fillRect(0, yStart + slotH - 2, w, 2);

            // Baut Rivet Emas di Sudut Pembatas
            this.drawRivet(ctx, 24, yStart + 12);
            this.drawRivet(ctx, w - 24, yStart + 12);
            this.drawRivet(ctx, 24, yStart + slotH - 12);
            this.drawRivet(ctx, w - 24, yStart + slotH - 12);

            // 4. Bayangan Lengkung 3D Drum (Vignette Kiri & Kanan)
            var shadowL = ctx.createLinearGradient(0, yStart, 48, yStart);
            shadowL.addColorStop(0, 'rgba(0, 0, 0, 0.22)');
            shadowL.addColorStop(1, 'rgba(0, 0, 0, 0)');
            ctx.fillStyle = shadowL;
            ctx.fillRect(0, yStart, 48, slotH);

            var shadowR = ctx.createLinearGradient(w - 48, yStart, w, yStart);
            shadowR.addColorStop(0, 'rgba(0, 0, 0, 0)');
            shadowR.addColorStop(1, 'rgba(0, 0, 0, 0.22)');
            ctx.fillStyle = shadowR;
            ctx.fillRect(w - 48, yStart, 48, slotH);

            // 5. Gambar Angka 0-9 Super Jelas, Besar & Megah
            this.drawCasinoNumber(ctx, String(digit), centerX, centerY, 310, false);
            this.drawCasinoNumber(emCtx, String(digit), centerX, centerY, 310, true);
        }

        this.reelTexture = new THREE.CanvasTexture(canvas);
        this.reelTexture.wrapS = THREE.RepeatWrapping;
        this.reelTexture.wrapT = THREE.RepeatWrapping;
        this.reelTexture.anisotropy = 8;

        this.reelEmissiveMap = new THREE.CanvasTexture(emCanvas);
        this.reelEmissiveMap.wrapS = THREE.RepeatWrapping;
        this.reelEmissiveMap.wrapT = THREE.RepeatWrapping;
    };

    /**
     * Menggambar Baut Rivet Emas Dekoratif
     */
    SlotMachine.prototype.drawRivet = function(ctx, x, y) {
        ctx.save();
        ctx.beginPath();
        ctx.arc(x, y, 4, 0, Math.PI * 2);
        ctx.fillStyle = '#f59e0b';
        ctx.fill();
        ctx.strokeStyle = '#ffffff';
        ctx.lineWidth = 1;
        ctx.stroke();
        ctx.restore();
    };

    /**
     * Menggambar Angka Kasino 3D Mewah: Hitam & Gold (0-9)
     * - Garis Tepi Luar: Emas 24K Mengkilap & Bevel Perunggu 3D
     * - Isi Tubuh Angka: Hitam Onyx Premium Mengkilap
     * - Aksen: Pantulan Kilap Kaca Emas & Sparkle Bintang
     */
    SlotMachine.prototype.drawCasinoNumber = function(ctx, numStr, x, y, size, isEmissive) {
        ctx.save();
        ctx.translate(x, y);

        ctx.font = '900 ' + size + 'px "DM Sans", Impact, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';

        if (isEmissive) {
            // Emissive Map: Glowing rich gold / amber
            ctx.fillStyle = '#ffbb00';
            ctx.fillText(numStr, 0, 0);
            ctx.restore();
            return;
        }

        // A. Bayangan & Glow Emas Mewah (Gold Halo Drop Shadow)
        ctx.shadowColor = 'rgba(245, 158, 11, 0.8)';
        ctx.shadowBlur = 24;

        // B. Stroke Luar Tebal 3D Deep Bronze Gold (3D Depth Bevel)
        ctx.lineWidth = 24;
        ctx.strokeStyle = '#78350f';
        ctx.strokeText(numStr, 0, 5);

        // C. Stroke Emas Murni Mengkilap (24K Gold Rim)
        ctx.lineWidth = 19;
        ctx.strokeStyle = '#f59e0b';
        ctx.strokeText(numStr, 0, 0);

        ctx.lineWidth = 14;
        ctx.strokeStyle = '#ffd700';
        ctx.strokeText(numStr, 0, 0);

        // D. Stroke Dalam Gold Champagne Terang
        ctx.shadowBlur = 0;
        ctx.lineWidth = 5;
        ctx.strokeStyle = '#fef08a';
        ctx.strokeText(numStr, 0, 0);

        // E. Gradien Isi Angka: Hitam Onyx Berkilau (Black Onyx & Charcoal Metallic)
        var halfS = size * 0.5;
        var grad = ctx.createLinearGradient(0, -halfS, 0, halfS);
        grad.addColorStop(0, '#2b2d42');
        grad.addColorStop(0.18, '#18181b');
        grad.addColorStop(0.5, '#09090b');
        grad.addColorStop(0.82, '#18181b');
        grad.addColorStop(1, '#000000');

        ctx.fillStyle = grad;
        ctx.fillText(numStr, 0, 0);

        // F. Highlight Kilap Kaca / Emas Tipis pada Bagian Atas
        ctx.save();
        ctx.beginPath();
        ctx.rect(-halfS, -halfS, size, size * 0.44);
        ctx.clip();
        var glossGrad = ctx.createLinearGradient(0, -halfS, 0, 0);
        glossGrad.addColorStop(0, 'rgba(255, 235, 150, 0.42)');
        glossGrad.addColorStop(1, 'rgba(255, 255, 255, 0.05)');
        ctx.fillStyle = glossGrad;
        ctx.fillText(numStr, 0, 0);
        ctx.restore();

        // G. Sparkle Kilau Emas
        this.drawSparkle(ctx, halfS * 0.42, -halfS * 0.55, 16);
        this.drawSparkle(ctx, -halfS * 0.45, halfS * 0.35, 12);

        ctx.restore();
    };

    SlotMachine.prototype.drawSparkle = function(ctx, x, y, r) {
        ctx.save();
        ctx.translate(x, y);
        ctx.fillStyle = '#ffffff';
        ctx.beginPath();
        ctx.arc(0, 0, r * 0.22, 0, Math.PI * 2);
        ctx.fill();

        ctx.beginPath();
        ctx.moveTo(-r, 0);
        ctx.quadraticCurveTo(0, 0, 0, -r);
        ctx.quadraticCurveTo(0, 0, r, 0);
        ctx.quadraticCurveTo(0, 0, 0, r);
        ctx.quadraticCurveTo(0, 0, -r, 0);
        ctx.fill();
        ctx.restore();
    };

    /**
     * Membangun Casing Mesin Slot Emas Polished
     */
    SlotMachine.prototype.buildGoldFrame = function() {
        this.goldMaterial = new THREE.MeshStandardMaterial({
            color: 0xf5b700,
            roughness: 0.15,
            metalness: 0.95
        });

        this.darkGoldMaterial = new THREE.MeshStandardMaterial({
            color: 0x8a5500,
            roughness: 0.25,
            metalness: 0.9
        });

        this.bezelTrimMaterial = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            roughness: 0.1,
            metalness: 0.95
        });

        var totalWidth = 8.2;
        var totalHeight = 4.4;

        // Housing Utama
        var housingGeo = new THREE.BoxGeometry(totalWidth, totalHeight, 3.2);
        var housingMesh = new THREE.Mesh(housingGeo, this.goldMaterial);
        housingMesh.position.set(0, 0.2, -0.6);
        this.group.add(housingMesh);

        // Mahkota Lengkung Atas
        var archGeo = new THREE.CylinderGeometry(totalWidth * 0.5, totalWidth * 0.5, 3.2, 32, 1, false, 0, Math.PI);
        var archMesh = new THREE.Mesh(archGeo, this.goldMaterial);
        archMesh.rotation.z = -Math.PI / 2;
        archMesh.rotation.y = Math.PI / 2;
        archMesh.position.set(0, 2.4, -0.6);
        this.group.add(archMesh);

        // Kolom Samping Emas
        var pillarX = totalWidth * 0.5 + 0.35;
        for (var side = -1; side <= 1; side += 2) {
            var colGeo = new THREE.CylinderGeometry(0.38, 0.38, 4.5, 24);
            var colMesh = new THREE.Mesh(colGeo, this.goldMaterial);
            colMesh.position.set(side * pillarX, 0.2, 0.4);
            this.group.add(colMesh);

            for (var r = -1.6; r <= 1.6; r += 0.8) {
                var torusGeo = new THREE.TorusGeometry(0.42, 0.06, 12, 24);
                var torusMesh = new THREE.Mesh(torusGeo, this.bezelTrimMaterial);
                torusMesh.rotation.x = Math.PI / 2;
                torusMesh.position.set(side * pillarX, r + 0.2, 0.4);
                this.group.add(torusMesh);
            }
        }

        // Bezel Depan dengan Jendela Kaca
        var windowW = 7.4;
        var bezelOuterGeo = new THREE.BoxGeometry(totalWidth - 0.4, 3.2, 0.45);
        var bezelMesh = new THREE.Mesh(bezelOuterGeo, this.darkGoldMaterial);
        bezelMesh.position.set(0, 0.25, 0.85);
        this.group.add(bezelMesh);

        // Bingkai Pembatas Horizontal Atas & Bawah
        var trimTopGeo = new THREE.BoxGeometry(windowW, 0.32, 0.3);
        var trimTop = new THREE.Mesh(trimTopGeo, this.goldMaterial);
        trimTop.position.set(0, 1.7, 1.05);
        this.group.add(trimTop);

        var trimBottom = new THREE.Mesh(trimTopGeo, this.goldMaterial);
        trimBottom.position.set(0, -1.2, 1.05);
        this.group.add(trimBottom);

        // Divider Kolom Emas Vertikal di antara 6 gulungan
        var dividerPositions = [-2.2, -1.1, 0, 1.1, 2.2];
        var divGeo = new THREE.BoxGeometry(0.14, 2.7, 0.35);
        for (var d = 0; d < dividerPositions.length; d++) {
            var divMesh = new THREE.Mesh(divGeo, this.goldMaterial);
            divMesh.position.set(dividerPositions[d], 0.25, 1.1);
            this.group.add(divMesh);
        }

        // Bingkai Sisi Kiri & Kanan Jendela
        var frameEndGeo = new THREE.BoxGeometry(0.2, 2.7, 0.35);
        var leftEnd = new THREE.Mesh(frameEndGeo, this.goldMaterial);
        leftEnd.position.set(-3.4, 0.25, 1.1);
        this.group.add(leftEnd);

        var rightEnd = new THREE.Mesh(frameEndGeo, this.goldMaterial);
        rightEnd.position.set(3.4, 0.25, 1.1);
        this.group.add(rightEnd);

        // Garis Pembatas Neon Emas pada Setiap Kolom Digit
        this.reelPositionsX = [-2.75, -1.65, -0.55, 0.55, 1.65, 2.75];
        this.reelFrames = [];
        for (var c = 0; c < this.reelPositionsX.length; c++) {
            var colX = this.reelPositionsX[c];
            var boxEdges = new THREE.EdgesGeometry(new THREE.BoxGeometry(1.0, 2.65, 0.1));
            var boxLineMat = new THREE.LineBasicMaterial({
                color: 0xffaa00,
                linewidth: 2,
                transparent: true,
                opacity: 0.85
            });
            var reelOutline = new THREE.LineSegments(boxEdges, boxLineMat);
            reelOutline.position.set(colX, 0.25, 1.12);
            this.group.add(reelOutline);
            this.reelFrames.push(reelOutline);
        }

        // Payline Merah Transparan di Tengah
        var paylineGeo = new THREE.BoxGeometry(windowW - 0.2, 0.04, 0.08);
        var paylineMat = new THREE.MeshBasicMaterial({
            color: 0xff0044,
            transparent: true,
            opacity: 0.75
        });
        var payline = new THREE.Mesh(paylineGeo, paylineMat);
        payline.position.set(0, 0.25, 1.15);
        this.group.add(payline);
    };

    /**
     * Membangun Geometri Silinder Khusus untuk 6 Gulungan
     * UV dipetakan presisi:
     * - U (0..1) memetakan lebar drum dari kiri ke kanan (tegak, tidak terbalik)
     * - V (0..1) memetakan keliling drum 360 derajat sesuai 10 slot angka 0-9
     */
    SlotMachine.prototype.createReelGeometry = function(radius, width, segments) {
        var geo = new THREE.BufferGeometry();
        var positions = [];
        var uvs = [];
        var indices = [];

        for (var s = 0; s <= segments; s++) {
            var frac = s / segments;
            var theta = frac * this.twoPi;
            var cosT = Math.cos(theta);
            var sinT = Math.sin(theta);

            // Sisi Kiri drum (x = -width / 2)
            positions.push(-width / 2, sinT * radius, cosT * radius);
            uvs.push(0, frac);

            // Sisi Kanan drum (x = +width / 2)
            positions.push(width / 2, sinT * radius, cosT * radius);
            uvs.push(1, frac);
        }

        for (var s = 0; s < segments; s++) {
            var a = s * 2;
            var b = s * 2 + 1;
            var c = (s + 1) * 2;
            var d = (s + 1) * 2 + 1;
            // 2 segitiga per segmen quad
            indices.push(a, b, c);
            indices.push(b, d, c);
        }

        geo.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
        geo.setAttribute('uv', new THREE.Float32BufferAttribute(uvs, 2));
        geo.setIndex(indices);
        geo.computeVertexNormals();

        return geo;
    };

    /**
     * Menghitung Sudut Rotasi Sumbu-X untuk Digit Tertentu (0-9)
     * Agar digit tersebut tepat berada di tengah jendela payline
     */
    SlotMachine.prototype.getAngleForDigit = function(digit) {
        var d = parseInt(digit, 10);
        if (isNaN(d)) d = 0;
        // Rumus UV: v_d = (9.5 - d) / 10
        // theta_d = v_d * 2*PI
        return ((9.5 - d) / this.numSymbols) * this.twoPi;
    };

    /**
     * Membangun 6 Gulungan Independen
     */
    SlotMachine.prototype.buildReels = function() {
        var reelRadius = 1.85;
        var reelWidth = 0.96;
        var segments = 64;

        this.reelMaterials = [];
        this.reels = [];

        // Buat 1 shared geometry efisien
        var sharedGeo = this.createReelGeometry(reelRadius, reelWidth, segments);

        // Tampilan awal: Angka keberuntungan "7 7 7 7 7 7"
        var initialAngle = this.getAngleForDigit(7);

        for (var i = 0; i < this.numReels; i++) {
            var reelMat = new THREE.MeshStandardMaterial({
                map: this.reelTexture,
                emissiveMap: this.reelEmissiveMap,
                emissive: new THREE.Color(0x000000),
                emissiveIntensity: 0.0,
                roughness: 0.35,
                metalness: 0.15
            });
            this.reelMaterials.push(reelMat);

            var reelMesh = new THREE.Mesh(sharedGeo, reelMat);
            reelMesh.position.set(this.reelPositionsX[i], 0.25, -0.15);
            reelMesh.rotation.set(initialAngle, 0, 0);
            this.group.add(reelMesh);

            this.reels.push({
                id: i,
                mesh: reelMesh,
                material: reelMat,
                targetDigit: 7,
                state: 'locked', // 'spinning' | 'decelerating' | 'locked'
                speed: 0,
                startRot: initialAngle,
                targetRot: initialAngle,
                decelStartTime: 0,
                decelDuration: 0.85
            });
        }
    };

    /**
     * Lampu Sorot Point Light untuk Tiap Gulungan
     */
    SlotMachine.prototype.setupGlowLights = function() {
        this.reelLights = [];
        for (var i = 0; i < this.numReels; i++) {
            var pl = new THREE.PointLight(0xffaa00, 0, 3.5);
            pl.position.set(this.reelPositionsX[i], 0.25, 1.45);
            this.group.add(pl);
            this.reelLights.push(pl);
        }
    };

    /**
     * Memulai Putaran Segera (Dipanggil saat tombol SPIN diklik)
     */
    SlotMachine.prototype.startSpinning = function() {
        this.isSpinning = true;
        this.isJackpot = false;
        this.spinStartTime = performance.now() * 0.001;

        // Reset lampu & emissive
        for (var l = 0; l < this.numReels; l++) {
            this.reelLights[l].intensity = 0;
            this.reelMaterials[l].emissive.setHex(0x000000);
            this.reelMaterials[l].emissiveIntensity = 0;
            if (this.reelFrames[l]) {
                this.reelFrames[l].material.color.setHex(0xffaa00);
            }
        }

        // Putar semua 6 gulungan dengan kecepatan tinggi
        for (var i = 0; i < this.numReels; i++) {
            var reel = this.reels[i];
            reel.state = 'spinning';
            reel.speed = 24 + i * 1.8;
            reel.hasScheduledStop = false;
        }
    };

    /**
     * Menetapkan NIK Pemenang & Menjadwalkan Penghentian Berurutan Per Digit
     * @param {string} targetNik - NIK 6-Digit (e.g. "004135")
     * @param {function} onComplete - Callback saat ke-6 digit terkunci
     */
    SlotMachine.prototype.setTargetNik = function(targetNik, onComplete) {
        var rawNik = String(targetNik || '777777').replace(/\D/g, '');
        this.targetNik = (rawNik.length >= 6) ? rawNik.slice(0, 6) : rawNik.padStart(6, '0');
        this.onCompleteCallback = onComplete;

        // Jadwal waktu mulai melambat untuk tiap digit (Reel 0 sampai 5):
        // Digit 1: 1.0s, Digit 2: 1.8s, Digit 3: 2.6s, Digit 4: 3.4s, Digit 5: 4.2s, Digit 6: 5.0s
        var stopSchedules = [1.0, 1.8, 2.6, 3.4, 4.2, 5.0];

        for (var i = 0; i < this.numReels; i++) {
            var reel = this.reels[i];
            reel.targetDigit = parseInt(this.targetNik[i], 10) || 0;
            reel.scheduledStopTime = stopSchedules[i];
            reel.hasScheduledStop = true;
        }
    };

    /**
     * Memulai putaran dengan NIK target langsung
     */
    SlotMachine.prototype.spin = function(targetNik, onComplete) {
        this.startSpinning();
        this.setTargetNik(targetNik, onComplete);
    };

    /**
     * Membatalkan putaran jika terjadi kegagalan jaringan
     */
    SlotMachine.prototype.cancelSpin = function() {
        this.isSpinning = false;
        for (var i = 0; i < this.numReels; i++) {
            this.reels[i].state = 'locked';
            this.reels[i].speed = 0;
        }
    };

    /**
     * Loop Pembaruan Frame Utama (Dipanggil setiap frame oleh ThreeScene)
     */
    SlotMachine.prototype.update = function(delta, time) {
        if (!this.reels || this.reels.length === 0) return;

        var now = performance.now() * 0.001;
        var elapsedSinceSpin = now - this.spinStartTime;

        if (this.isSpinning) {
            for (var i = 0; i < this.numReels; i++) {
                var reel = this.reels[i];

                // 1. Cek apakah giliran gulungan ini untuk mulai melambat
                if (reel.state === 'spinning' && reel.hasScheduledStop && elapsedSinceSpin >= reel.scheduledStopTime) {
                    reel.state = 'decelerating';
                    reel.decelStartTime = now;
                    reel.decelDuration = 0.85; // 0.85s deselerasi lembut

                    var currentRot = reel.mesh.rotation.x;
                    reel.startRot = currentRot;

                    var targetTheta = this.getAngleForDigit(reel.targetDigit);

                    // Hitung jarak rotasi ke depan yang dibutuhkan
                    var rem = currentRot % this.twoPi;
                    if (rem < 0) rem += this.twoPi;

                    var diff = targetTheta - rem;
                    if (diff < 0.25) diff += this.twoPi;

                    // Tambahkan 1 putaran penuh ekstra agar kurva pengereman mulus
                    var extraSpin = 1 * this.twoPi;
                    reel.targetRot = currentRot + diff + extraSpin;
                }

                // 2. Animasi pengereman kurva Ease-Out
                if (reel.state === 'decelerating') {
                    var decelElapsed = now - reel.decelStartTime;
                    var progress = Math.min(decelElapsed / reel.decelDuration, 1.0);

                    // Easing Quartic Out: sangat halus dan realistis
                    var ease = 1 - Math.pow(1 - progress, 4);
                    reel.mesh.rotation.x = reel.startRot + (reel.targetRot - reel.startRot) * ease;

                    if (progress >= 1.0) {
                        reel.mesh.rotation.x = reel.targetRot;
                        reel.state = 'locked';
                        reel.speed = 0;

                        // Suara 'Click' / 'Thump' mekanikal terkunci per digit
                        if (window.SlotSoundEngine) {
                            window.SlotSoundEngine.playReelStop(i);
                        }

                        // Nyalakan lampu sorot dan bingkai emas untuk digit ini
                        this.reelLights[i].intensity = 4.5;
                        this.reelMaterials[i].emissive.setHex(0xffaa00);
                        this.reelMaterials[i].emissiveIntensity = 0.95;
                        if (this.reelFrames[i]) {
                            this.reelFrames[i].material.color.setHex(0xffdd00);
                        }
                    }
                } else if (reel.state === 'spinning') {
                    // Gulungan berputar normal ke bawah
                    reel.mesh.rotation.x += reel.speed * delta;
                }
            }

            // 3. Periksa apakah semua 6 digit sudah terkunci
            var allLocked = true;
            for (var j = 0; j < this.numReels; j++) {
                if (this.reels[j].state !== 'locked') {
                    allLocked = false;
                    break;
                }
            }

            if (allLocked && elapsedSinceSpin > 1.5) {
                this.isSpinning = false;
                this.isJackpot = true;

                if (typeof this.onCompleteCallback === 'function') {
                    var cb = this.onCompleteCallback;
                    this.onCompleteCallback = null;
                    cb();
                }
            }
        }

        // Efek Strobo Lampu saat Jackpot (Semua 6 Digit Terbentuk)
        if (this.isJackpot) {
            var strobe = Math.sin(time * 24) * 0.5 + 0.5;
            var intensity = (strobe > 0.3) ? 1.8 : 0.4;

            for (var k = 0; k < this.numReels; k++) {
                this.reelLights[k].intensity = 4.0 * intensity;
                this.reelMaterials[k].emissiveIntensity = 1.4 * intensity;
            }
        }
    };

    window.SlotMachine = SlotMachine;
})(window);
