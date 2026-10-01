/**
 * SlotMachine.js
 * Model 3D Mesin Slot Kasino Klasik (Berdasarkan Referensi: spin machine.png)
 * - Casing Lengkung Modern & Elegan dengan Lapisan Emas 24K Polished
 * - 6 Gulungan Independen untuk NIK 6-Digit Koperasi
 * - 6 Jendela Berbingkai Emas dengan Divider Vertikal & Rel Horizontal Beveled
 * - Tuas Mekanikal Klasik (Slot Arm) di Sisi Kiri dengan Bola Knob Merah Mengkilap
 * - Animasi Tuas Menarik Turun & Memantul Saat Tombol SPIN Ditekan
 * - Tombol / Permata Dome Merah Dekoratif di Atas Casing
 * - Font Angka Hitam & Gold (Onyx Black & 24K Gold 3D Rim)
 * - Pengereman Berurutan Tiap Item (Digit 1 -> Digit 6) Membentuk NIK Pemenang
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

        // Animasi Tuas Samping (Slot Lever Arm)
        this.isLeverPulling = false;
        this.leverPullStartTime = 0;

        // 6 Reels untuk NIK 6-Digit
        this.numReels = 6;
        this.numSymbols = 10;
        this.twoPi = Math.PI * 2;

        // Target NIK default
        this.targetNik = '777777';

        this.init();
    }

    SlotMachine.prototype.init = function() {
        this.group = new THREE.Group();
        this.pivot.add(this.group);

        // 1. Buat Tekstur Kanvas Resolusi Tinggi untuk Angka Hitam & Gold (0-9)
        this.generateReelTextures();

        // 2. Buat Casing Mesin Slot Sesuai Referensi spin machine.png
        this.buildMachineModel();

        // 3. Buat 6 Gulungan Silinder 3D
        this.buildReels();

        // 4. Lampu Sorot Emissive untuk Tiap Digit yang Mengunci
        this.setupGlowLights();
    };

    /**
     * Menghasilkan Tekstur Kanvas High-Res untuk Angka 0-9 (Hitam & Gold)
     */
    SlotMachine.prototype.generateReelTextures = function() {
        var w = 512;
        var slotH = 512;
        var h = slotH * this.numSymbols; // 5120 px

        var canvas = document.createElement('canvas');
        canvas.width = w;
        canvas.height = h;
        var ctx = canvas.getContext('2d');

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

            // 1. Background Drum Slot: Gradien Mutiara Kasino Putih Bersih
            var bgGrad = ctx.createLinearGradient(0, yStart, w, yStart);
            bgGrad.addColorStop(0, '#d1d8e0');
            bgGrad.addColorStop(0.12, '#f8fafc');
            bgGrad.addColorStop(0.5, '#ffffff');
            bgGrad.addColorStop(0.88, '#f8fafc');
            bgGrad.addColorStop(1, '#d1d8e0');
            ctx.fillStyle = bgGrad;
            ctx.fillRect(0, yStart, w, slotH);

            // 2. Pola Dot-Matrix Halus
            ctx.fillStyle = 'rgba(148, 163, 184, 0.35)';
            var dotSpacing = 20;
            for (var dy = yStart + 8; dy < yStart + slotH - 8; dy += dotSpacing) {
                for (var dx = 16; dx < w - 16; dx += dotSpacing) {
                    ctx.beginPath();
                    ctx.arc(dx, dy, 2, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            // 3. Garis Pembatas Metalik / Emas Antar Slot
            ctx.fillStyle = '#b45309';
            ctx.fillRect(0, yStart, w, 4);
            ctx.fillStyle = '#ffd700';
            ctx.fillRect(0, yStart + 2, w, 2);

            ctx.fillStyle = '#b45309';
            ctx.fillRect(0, yStart + slotH - 4, w, 4);
            ctx.fillStyle = '#ffd700';
            ctx.fillRect(0, yStart + slotH - 2, w, 2);

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

            // 5. Gambar Angka Hitam & Gold (0-9)
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
     * Menggambar Angka Kasino 3D Hitam & Gold
     */
    SlotMachine.prototype.drawCasinoNumber = function(ctx, numStr, x, y, size, isEmissive) {
        ctx.save();
        ctx.translate(x, y);

        ctx.font = '900 ' + size + 'px "DM Sans", Impact, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';

        if (isEmissive) {
            ctx.fillStyle = '#ffbb00';
            ctx.fillText(numStr, 0, 0);
            ctx.restore();
            return;
        }

        // A. Bayangan & Glow Emas Mewah
        ctx.shadowColor = 'rgba(245, 158, 11, 0.8)';
        ctx.shadowBlur = 24;

        // B. Stroke Luar Tebal 3D Deep Bronze Gold
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

        // E. Isi Tubuh Angka: Hitam Onyx Berkilau
        var halfS = size * 0.5;
        var grad = ctx.createLinearGradient(0, -halfS, 0, halfS);
        grad.addColorStop(0, '#2b2d42');
        grad.addColorStop(0.18, '#18181b');
        grad.addColorStop(0.5, '#09090b');
        grad.addColorStop(0.82, '#18181b');
        grad.addColorStop(1, '#000000');

        ctx.fillStyle = grad;
        ctx.fillText(numStr, 0, 0);

        // F. Highlight Kilap Kaca Emas di Bagian Atas
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
     * Membangun Model 3D Mesin Slot Berdasarkan Referensi spin machine.png
     */
    SlotMachine.prototype.buildMachineModel = function() {
        // Material Emas 24K Mengkilap Mirror-Polished
        this.goldMaterial = new THREE.MeshStandardMaterial({
            color: 0xfcc02e,
            roughness: 0.12,
            metalness: 0.95
        });

        // Material Emas Perunggu Bevel Dalam
        this.darkGoldMaterial = new THREE.MeshStandardMaterial({
            color: 0xb8860b,
            roughness: 0.2,
            metalness: 0.92
        });

        // Material Casing Belakang/Samping (Dark Polished Charcoal Metallic)
        this.cabinetMaterial = new THREE.MeshStandardMaterial({
            color: 0x1c1917,
            roughness: 0.25,
            metalness: 0.88
        });

        // Material Chrome / Silver Reflektif
        this.chromeMaterial = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            roughness: 0.08,
            metalness: 0.98
        });

        // Material Knob Merah Mengkilap (Cherry-Red Gloss Lacquer)
        this.redKnobMaterial = new THREE.MeshStandardMaterial({
            color: 0xee0022,
            roughness: 0.08,
            metalness: 0.25
        });

        var totalWidth = 7.7;
        var totalHeight = 3.35;
        this.reelPositionsX = [-2.75, -1.65, -0.55, 0.55, 1.65, 2.75];

        // ── A. Casing Belakang & Samping (Curved Dark Cabinet Shell) ──
        var cabShape = new THREE.Shape();
        cabShape.moveTo(-0.1, -1.65);
        cabShape.lineTo(0.9, -1.65);
        cabShape.lineTo(0.9, 1.65);
        cabShape.lineTo(-0.1, 1.65);
        cabShape.quadraticCurveTo(-1.4, 1.45, -1.5, 0.0);
        cabShape.quadraticCurveTo(-1.4, -1.45, -0.1, -1.65);
        cabShape.closePath();

        var cabGeo = new THREE.ExtrudeGeometry(cabShape, {
            steps: 1,
            depth: totalWidth - 0.2,
            bevelEnabled: true,
            bevelThickness: 0.12,
            bevelSize: 0.1,
            bevelSegments: 3
        });
        cabGeo.center();
        var cabMesh = new THREE.Mesh(cabGeo, this.cabinetMaterial);
        cabMesh.rotation.y = Math.PI / 2;
        cabMesh.position.set(0, 0.25, -0.4);
        this.group.add(cabMesh);

        // ── B. Front Bezel Faceplate Emas Tebal dengan 6 Lubang Jendela ──
        var fpShape = new THREE.Shape();
        var halfW = totalWidth / 2;
        var halfH = totalHeight / 2;
        var r = 0.35;

        // Sudut Luar Membulat Halus (Rounded Rectangle)
        fpShape.moveTo(-halfW + r, -halfH);
        fpShape.lineTo(halfW - r, -halfH);
        fpShape.quadraticCurveTo(halfW, -halfH, halfW, -halfH + r);
        fpShape.lineTo(halfW, halfH - r);
        fpShape.quadraticCurveTo(halfW, halfH, halfW - r, halfH);
        fpShape.lineTo(-halfW + r, halfH);
        fpShape.quadraticCurveTo(-halfW, halfH, -halfW, halfH - r);
        fpShape.lineTo(-halfW, -halfH + r);
        fpShape.quadraticCurveTo(-halfW, -halfH, -halfW + r, -halfH);

        // 6 Lubang Jendela Persegi Panjang Berujung Melengkung
        for (var i = 0; i < this.reelPositionsX.length; i++) {
            var cx = this.reelPositionsX[i];
            var hole = new THREE.Path();
            var hw = 0.98 / 2;
            var hh = 2.45 / 2;
            var hr = 0.12;

            hole.moveTo(cx - hw + hr, -hh);
            hole.lineTo(cx + hw - hr, -hh);
            hole.quadraticCurveTo(cx + hw, -hh, cx + hw, -hh + hr);
            hole.lineTo(cx + hw, hh - hr);
            hole.quadraticCurveTo(cx + hw, hh, cx + hw - hr, hh);
            hole.lineTo(cx - hw + hr, hh);
            hole.quadraticCurveTo(cx - hw, hh, cx - hw, hh - hr);
            hole.lineTo(cx - hw, -hh + hr);
            hole.quadraticCurveTo(cx - hw, -hh, cx - hw + hr, -hh);
            fpShape.holes.push(hole);
        }

        var faceplateGeo = new THREE.ExtrudeGeometry(fpShape, {
            steps: 1,
            depth: 0.22,
            bevelEnabled: true,
            bevelThickness: 0.08,
            bevelSize: 0.08,
            bevelSegments: 3
        });
        var faceplateMesh = new THREE.Mesh(faceplateGeo, this.goldMaterial);
        faceplateMesh.position.set(0, 0.25, 0.95);
        this.group.add(faceplateMesh);

        // ── C. Divider Kolom Emas Cembung di Antara Jendela (Sesuai Referensi) ──
        var dividerPositions = [-2.2, -1.1, 0, 1.1, 2.2];
        for (var d = 0; d < dividerPositions.length; d++) {
            var divGeo = new THREE.CylinderGeometry(0.085, 0.085, 2.45, 16);
            var divMesh = new THREE.Mesh(divGeo, this.goldMaterial);
            divMesh.position.set(dividerPositions[d], 0.25, 1.2);
            this.group.add(divMesh);

            // Tutup Kubah Halus di Ujung Atas & Bawah Divider
            var capTop = new THREE.Mesh(new THREE.SphereGeometry(0.085, 12, 12), this.goldMaterial);
            capTop.position.set(dividerPositions[d], 1.48, 1.2);
            this.group.add(capTop);

            var capBot = new THREE.Mesh(new THREE.SphereGeometry(0.085, 12, 12), this.goldMaterial);
            capBot.position.set(dividerPositions[d], -0.98, 1.2);
            this.group.add(capBot);
        }

        // Divider Ujung Luar Kiri & Kanan
        for (var e = -1; e <= 1; e += 2) {
            var endColGeo = new THREE.CylinderGeometry(0.11, 0.11, 2.45, 16);
            var endCol = new THREE.Mesh(endColGeo, this.goldMaterial);
            endCol.position.set(e * 3.32, 0.25, 1.2);
            this.group.add(endCol);
        }

        // ── D. Rel Horizontal Beveled Atas & Bawah (Sesuai Referensi) ──
        var railTopGeo = new THREE.CylinderGeometry(0.12, 0.12, totalWidth - 0.2, 16);
        var railTop = new THREE.Mesh(railTopGeo, this.goldMaterial);
        railTop.rotation.z = Math.PI / 2;
        railTop.position.set(0, 1.58, 1.18);
        this.group.add(railTop);

        var railBottomGeo = new THREE.CylinderGeometry(0.14, 0.14, totalWidth - 0.2, 16);
        var railBottom = new THREE.Mesh(railBottomGeo, this.goldMaterial);
        railBottom.rotation.z = Math.PI / 2;
        railBottom.position.set(0, -1.08, 1.18);
        this.group.add(railBottom);

        // Ledge Dasar Bawah (Stepped Base Pedestal)
        var baseFootGeo = new THREE.BoxGeometry(totalWidth + 0.15, 0.22, 0.55);
        var baseFoot = new THREE.Mesh(baseFootGeo, this.goldMaterial);
        baseFoot.position.set(0, -1.35, 1.05);
        this.group.add(baseFoot);

        // ── E. Tombol / Permata Dome Merah di Atas Casing (Sesuai Gambar) ──
        for (var b = 0; b < this.reelPositionsX.length; b++) {
            var bx = this.reelPositionsX[b];

            // Cincin Collar Emas
            var collarGeo = new THREE.CylinderGeometry(0.12, 0.14, 0.05, 16);
            var collarMesh = new THREE.Mesh(collarGeo, this.goldMaterial);
            collarMesh.position.set(bx, 1.95, 0.85);
            this.group.add(collarMesh);

            // Kubah Merah Mengkilap
            var domeGeo = new THREE.SphereGeometry(0.09, 16, 16, 0, Math.PI * 2, 0, Math.PI / 2);
            var domeMesh = new THREE.Mesh(domeGeo, this.redKnobMaterial);
            domeMesh.position.set(bx, 1.97, 0.85);
            this.group.add(domeMesh);
        }

        // ── F. Tuas Mekanikal Slot Klasik (Slot Lever Arm di Sisi Kiri) ──
        var leverMountX = -halfW - 0.15;
        var leverMountY = 0.25;
        var leverMountZ = 0.0;

        // Hub / Flens Piringan Emas yang Terpasang di Dinding Samping
        var hubBaseGeo = new THREE.CylinderGeometry(0.44, 0.48, 0.14, 32);
        var hubBase = new THREE.Mesh(hubBaseGeo, this.goldMaterial);
        hubBase.rotation.z = Math.PI / 2;
        hubBase.position.set(leverMountX + 0.07, leverMountY, leverMountZ);
        this.group.add(hubBase);

        // Cincin Chrome Konsentris di Piringan
        var hubRingGeo = new THREE.TorusGeometry(0.3, 0.035, 12, 24);
        var hubRing = new THREE.Mesh(hubRingGeo, this.chromeMaterial);
        hubRing.rotation.y = Math.PI / 2;
        hubRing.position.set(leverMountX - 0.01, leverMountY, leverMountZ);
        this.group.add(hubRing);

        var hubCapGeo = new THREE.CylinderGeometry(0.18, 0.18, 0.2, 24);
        var hubCap = new THREE.Mesh(hubCapGeo, this.goldMaterial);
        hubCap.rotation.z = Math.PI / 2;
        hubCap.position.set(leverMountX - 0.04, leverMountY, leverMountZ);
        this.group.add(hubCap);

        // Group Pivot yang Berotasi saat Tuas Ditarik (Slot Arm Movement)
        this.leverPivot = new THREE.Group();
        this.leverPivot.position.set(leverMountX - 0.12, leverMountY, leverMountZ);
        this.leverPivot.rotation.x = -0.15; // Posisi santai sedikit condong ke belakang
        this.group.add(this.leverPivot);

        // Batang Tuas Logam (Chrome / Gold Rod)
        var rodGeo = new THREE.CylinderGeometry(0.065, 0.075, 1.75, 16);
        var rodMesh = new THREE.Mesh(rodGeo, this.chromeMaterial);
        rodMesh.position.set(0, 0.82, 0.12);
        rodMesh.rotation.x = -0.12;
        this.leverPivot.add(rodMesh);

        // Collar Emas di Bawah Bola
        var collarKnobGeo = new THREE.CylinderGeometry(0.11, 0.075, 0.12, 16);
        var collarKnob = new THREE.Mesh(collarKnobGeo, this.goldMaterial);
        collarKnob.position.set(0, 1.66, 0.24);
        this.leverPivot.add(collarKnob);

        // Bola Knob Merah Mengkilap Ikonik (Cherry-Red Ball Knob)
        var ballKnobGeo = new THREE.SphereGeometry(0.28, 32, 32);
        var ballKnobMesh = new THREE.Mesh(ballKnobGeo, this.redKnobMaterial);
        ballKnobMesh.position.set(0, 1.78, 0.28);
        this.leverPivot.add(ballKnobMesh);

        // Highlight Kilap Specular di Knob
        var glintGeo = new THREE.SphereGeometry(0.06, 12, 12);
        var glintMat = new THREE.MeshBasicMaterial({ color: 0xffffff, transparent: true, opacity: 0.7 });
        var glintMesh = new THREE.Mesh(glintGeo, glintMat);
        glintMesh.position.set(0.08, 1.9, 0.44);
        this.leverPivot.add(glintMesh);

        // ── G. Bingkai Garis Emas Halus pada Masing-Masing Jendela ──
        this.reelFrames = [];
        for (var c = 0; c < this.reelPositionsX.length; c++) {
            var colX = this.reelPositionsX[c];
            var boxEdges = new THREE.EdgesGeometry(new THREE.BoxGeometry(0.98, 2.45, 0.05));
            var boxLineMat = new THREE.LineBasicMaterial({
                color: 0xffaa00,
                linewidth: 2,
                transparent: true,
                opacity: 0.8
            });
            var reelOutline = new THREE.LineSegments(boxEdges, boxLineMat);
            reelOutline.position.set(colX, 0.25, 1.18);
            this.group.add(reelOutline);
            this.reelFrames.push(reelOutline);
        }
    };

    /**
     * Membangun Geometri Silinder Khusus untuk 6 Gulungan
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

            positions.push(-width / 2, sinT * radius, cosT * radius);
            uvs.push(0, frac);

            positions.push(width / 2, sinT * radius, cosT * radius);
            uvs.push(1, frac);
        }

        for (var s = 0; s < segments; s++) {
            var a = s * 2;
            var b = s * 2 + 1;
            var c = (s + 1) * 2;
            var d = (s + 1) * 2 + 1;
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
     */
    SlotMachine.prototype.getAngleForDigit = function(digit) {
        var d = parseInt(digit, 10);
        if (isNaN(d)) d = 0;
        return ((9.5 - d) / this.numSymbols) * this.twoPi;
    };

    /**
     * Membangun 6 Gulungan Silinder di Dalam Casing
     */
    SlotMachine.prototype.buildReels = function() {
        var reelRadius = 1.85;
        var reelWidth = 0.94;
        var segments = 64;

        this.reelMaterials = [];
        this.reels = [];

        var sharedGeo = this.createReelGeometry(reelRadius, reelWidth, segments);
        var initialAngle = this.getAngleForDigit(7); // Angka keberuntungan "7 7 7 7 7 7"

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
                state: 'locked',
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

        // Picu Animasi Tuas Menarik Turun (Physical Lever Pull Down!)
        this.isLeverPulling = true;
        this.leverPullStartTime = this.spinStartTime;

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
     */
    SlotMachine.prototype.setTargetNik = function(targetNik, onComplete) {
        var rawNik = String(targetNik || '777777').replace(/\D/g, '');
        this.targetNik = (rawNik.length >= 6) ? rawNik.slice(0, 6) : rawNik.padStart(6, '0');
        this.onCompleteCallback = onComplete;

        // Jadwal waktu mulai melambat untuk tiap digit (Digit 1 -> 6):
        var stopSchedules = [1.0, 1.8, 2.6, 3.4, 4.2, 5.0];

        for (var i = 0; i < this.numReels; i++) {
            var reel = this.reels[i];
            reel.targetDigit = parseInt(this.targetNik[i], 10) || 0;
            reel.scheduledStopTime = stopSchedules[i];
            reel.hasScheduledStop = true;
        }
    };

    SlotMachine.prototype.spin = function(targetNik, onComplete) {
        this.startSpinning();
        this.setTargetNik(targetNik, onComplete);
    };

    SlotMachine.prototype.cancelSpin = function() {
        this.isSpinning = false;
        this.isLeverPulling = false;
        if (this.leverPivot) this.leverPivot.rotation.x = -0.15;
        for (var i = 0; i < this.numReels; i++) {
            this.reels[i].state = 'locked';
            this.reels[i].speed = 0;
        }
    };

    /**
     * Loop Pembaruan Frame Utama
     */
    SlotMachine.prototype.update = function(delta, time) {
        if (!this.reels || this.reels.length === 0) return;

        var now = performance.now() * 0.001;

        // ── 1. Animasi Fisik Tarikan Tuas Samping (Mechanical Lever Pull) ──
        if (this.isLeverPulling && this.leverPivot) {
            var leverElapsed = now - this.leverPullStartTime;
            if (leverElapsed < 0.22) {
                // Tarik ke depan & bawah (0 -> 0.22 detik)
                var pDown = leverElapsed / 0.22;
                var easeDown = pDown * pDown;
                this.leverPivot.rotation.x = -0.15 + (0.95 - (-0.15)) * easeDown;
            } else if (leverElapsed < 0.58) {
                // Pantulan pegas mekanik kembali ke atas (0.22 -> 0.58 detik)
                var pUp = (leverElapsed - 0.22) / 0.36;
                // Elastic overshoot curve
                var elastic = Math.cos(pUp * Math.PI * 0.5) * (1 - pUp * 0.4);
                this.leverPivot.rotation.x = -0.15 + (0.95 - (-0.15)) * elastic;
            } else {
                this.leverPivot.rotation.x = -0.15;
                this.isLeverPulling = false;
            }
        }

        // ── 2. Animasi Putaran dan Pengereman 6 Gulungan ──
        var elapsedSinceSpin = now - this.spinStartTime;

        if (this.isSpinning) {
            for (var i = 0; i < this.numReels; i++) {
                var reel = this.reels[i];

                // Cek jadwal pengereman
                if (reel.state === 'spinning' && reel.hasScheduledStop && elapsedSinceSpin >= reel.scheduledStopTime) {
                    reel.state = 'decelerating';
                    reel.decelStartTime = now;
                    reel.decelDuration = 0.85;

                    var currentRot = reel.mesh.rotation.x;
                    reel.startRot = currentRot;

                    var targetTheta = this.getAngleForDigit(reel.targetDigit);

                    var rem = currentRot % this.twoPi;
                    if (rem < 0) rem += this.twoPi;

                    var diff = targetTheta - rem;
                    if (diff < 0.25) diff += this.twoPi;

                    var extraSpin = 1 * this.twoPi;
                    reel.targetRot = currentRot + diff + extraSpin;
                }

                // Animasi pengereman kurva Ease-Out
                if (reel.state === 'decelerating') {
                    var decelElapsed = now - reel.decelStartTime;
                    var progress = Math.min(decelElapsed / reel.decelDuration, 1.0);
                    var ease = 1 - Math.pow(1 - progress, 4);
                    reel.mesh.rotation.x = reel.startRot + (reel.targetRot - reel.startRot) * ease;

                    if (progress >= 1.0) {
                        reel.mesh.rotation.x = reel.targetRot;
                        reel.state = 'locked';
                        reel.speed = 0;

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
                    reel.mesh.rotation.x += reel.speed * delta;
                }
            }

            // Cek apakah semua 6 digit sudah terkunci
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

        // Efek Strobo Lampu Emas saat Jackpot
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
