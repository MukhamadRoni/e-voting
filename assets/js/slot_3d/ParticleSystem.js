/**
 * ParticleSystem.js
 * Sistem Partikel Cahaya Lembut Latar Belakang & Hujan Konfeti Emas 3D Dinamis
 */
(function(window) {
    'use strict';

    function ParticleSystem(scene, parentPivot) {
        this.scene = scene;
        this.pivot = parentPivot || scene;
        this.isJackpot = false;

        this.init();
    }

    ParticleSystem.prototype.init = function() {
        // 1. Soft Ambient Floating Light Particles (Backdrop)
        this.createAmbientGlowParticles();

        // 2. Dynamic 3D Gold Confetti Cascade
        this.createGoldConfettiSystem();
    };

    /**
     * Soft floating light orbs in the background purple-magenta aura
     */
    ParticleSystem.prototype.createAmbientGlowParticles = function() {
        var count = 90;
        var geometry = new THREE.BufferGeometry();
        var positions = new Float32Array(count * 3);
        var scales = new Float32Array(count);
        var speeds = new Float32Array(count);

        for (var i = 0; i < count; i++) {
            positions[i * 3 + 0] = (Math.random() - 0.5) * 16;
            positions[i * 3 + 1] = (Math.random() - 0.5) * 10;
            positions[i * 3 + 2] = (Math.random() - 0.5) * 4 - 2.5;

            scales[i] = Math.random() * 20 + 8;
            speeds[i] = Math.random() * 0.4 + 0.1;
        }

        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

        // Soft radial glow circle texture
        var canvas = document.createElement('canvas');
        canvas.width = 64;
        canvas.height = 64;
        var ctx = canvas.getContext('2d');
        var grad = ctx.createRadialGradient(32, 32, 0, 32, 32, 32);
        grad.addColorStop(0, 'rgba(255, 120, 220, 1.0)');
        grad.addColorStop(0.4, 'rgba(210, 50, 255, 0.45)');
        grad.addColorStop(1, 'rgba(210, 50, 255, 0)');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 64, 64);

        var glowTex = new THREE.CanvasTexture(canvas);

        var material = new THREE.PointsMaterial({
            size: 0.55,
            map: glowTex,
            transparent: true,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
            opacity: 0.65
        });

        this.ambientPoints = new THREE.Points(geometry, material);
        this.ambientPositions = positions;
        this.ambientSpeeds = speeds;
        this.ambientCount = count;
        this.scene.add(this.ambientPoints);
    };

    /**
     * 3D Golden Confetti Flakes (Rectangles with dynamic flutter, spin & gravity)
     */
    ParticleSystem.prototype.createGoldConfettiSystem = function() {
        this.confettiCount = 350;
        this.confettiData = [];

        var flakeGeo = new THREE.PlaneGeometry(0.16, 0.28);
        var goldFlakeMat = new THREE.MeshStandardMaterial({
            color: 0xffd700,
            roughness: 0.15,
            metalness: 0.95,
            side: THREE.DoubleSide
        });

        this.confettiMesh = new THREE.InstancedMesh(flakeGeo, goldFlakeMat, this.confettiCount);
        this.dummy = new THREE.Object3D();

        var colors = [
            new THREE.Color(0xffd700), // Pure Gold
            new THREE.Color(0xffb703), // Amber Gold
            new THREE.Color(0xfef08a), // Pale Glitter Gold
            new THREE.Color(0xff007f), // Hot Magenta accent
            new THREE.Color(0xffffff)  // Sparkle Diamond White
        ];

        for (var i = 0; i < this.confettiCount; i++) {
            var color = colors[Math.floor(Math.random() * colors.length)];
            this.confettiMesh.setColorAt(i, color);

            // Initially positioned above screen or dormant
            this.confettiData.push({
                x: (Math.random() - 0.5) * 12,
                y: Math.random() * 8 + 4,
                z: (Math.random() - 0.5) * 5 + 0.5,
                vx: (Math.random() - 0.5) * 1.5,
                vy: -Math.random() * 2.5 - 1.2,
                vz: (Math.random() - 0.5) * 1.5,
                rotX: Math.random() * Math.PI,
                rotY: Math.random() * Math.PI,
                rotZ: Math.random() * Math.PI,
                vRotX: (Math.random() - 0.5) * 6,
                vRotY: (Math.random() - 0.5) * 7,
                vRotZ: (Math.random() - 0.5) * 4,
                active: false
            });

            this.dummy.position.set(0, -999, 0);
            this.dummy.updateMatrix();
            this.confettiMesh.setMatrixAt(i, this.dummy.matrix);
        }

        if (this.confettiMesh.instanceColor) {
            this.confettiMesh.instanceColor.needsUpdate = true;
        }
        this.confettiMesh.instanceMatrix.needsUpdate = true;
        this.scene.add(this.confettiMesh);
    };

    /**
     * Explode gold confetti on Jackpot!
     */
    ParticleSystem.prototype.burstJackpotConfetti = function() {
        this.isJackpot = true;

        for (var i = 0; i < this.confettiCount; i++) {
            var c = this.confettiData[i];
            c.active = true;
            // Spawn across the 6 reels
            c.x = (Math.random() - 0.5) * 6.5;
            c.y = (Math.random() - 0.5) * 2 + 0.5;
            c.z = Math.random() * 1.5 + 0.5;

            // Explosive outward burst velocity
            var angle = Math.random() * Math.PI * 2;
            var force = Math.random() * 5 + 3;
            c.vx = Math.cos(angle) * force;
            c.vy = Math.sin(angle) * force * 0.7 + 3.5; // Upward surge
            c.vz = (Math.random() - 0.5) * 3;
        }
    };

    ParticleSystem.prototype.setJackpotMode = function(active) {
        this.isJackpot = !!active;
        if (this.isJackpot) {
            this.burstJackpotConfetti();
        }
    };

    ParticleSystem.prototype.update = function(delta, time) {
        // 1. Update Soft Ambient Light Particles
        if (this.ambientPoints) {
            var pos = this.ambientPositions;
            for (var i = 0; i < this.ambientCount; i++) {
                pos[i * 3 + 1] += this.ambientSpeeds[i] * delta;
                if (pos[i * 3 + 1] > 6) {
                    pos[i * 3 + 1] = -5;
                }
            }
            this.ambientPoints.geometry.attributes.position.needsUpdate = true;
            this.ambientPoints.rotation.y = time * 0.04;
        }

        // 2. Update 3D Gold Confetti Cascade
        if (this.confettiMesh) {
            var matrixUpdated = false;

            for (var j = 0; j < this.confettiCount; j++) {
                var item = this.confettiData[j];
                if (!item.active) continue;

                matrixUpdated = true;

                // Physics simulation
                item.x += item.vx * delta;
                item.y += item.vy * delta;
                item.z += item.vz * delta;

                // Air drag & fluttering gravity
                item.vx *= 0.985;
                item.vz *= 0.985;
                item.vy -= 4.2 * delta; // Gravity

                // Terminal velocity flutter
                if (item.vy < -3.2) item.vy = -3.2;

                // Continuous rotation flutter
                item.rotX += item.vRotX * delta;
                item.rotY += item.vRotY * delta;
                item.rotZ += item.vRotZ * delta;

                // Floor recycle during jackpot celebration
                if (item.y < -4.8) {
                    if (this.isJackpot) {
                        // Recycle from top for continuous golden rainfall
                        item.y = 5.2 + Math.random() * 2;
                        item.x = (Math.random() - 0.5) * 11;
                        item.z = (Math.random() - 0.5) * 4 + 0.5;
                        item.vy = -Math.random() * 2.5 - 1.2;
                        item.vx = (Math.random() - 0.5) * 1.5;
                    } else {
                        item.active = false;
                        item.y = -999;
                    }
                }

                this.dummy.position.set(item.x, item.y, item.z);
                this.dummy.rotation.set(item.rotX, item.rotY, item.rotZ);
                this.dummy.scale.set(1, 1, 1);
                this.dummy.updateMatrix();
                this.confettiMesh.setMatrixAt(j, this.dummy.matrix);
            }

            if (matrixUpdated) {
                this.confettiMesh.instanceMatrix.needsUpdate = true;
            }
        }
    };

    window.ParticleSystem = ParticleSystem;
})(window);
