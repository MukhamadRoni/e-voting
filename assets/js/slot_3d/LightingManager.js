/**
 * LightingManager.js
 * Manajemen Pencahayaan 3D, Rim Backlight, Sunburst Ray Shader, Cincin & Ornamen Neon
 */
(function(window) {
    'use strict';

    function LightingManager(scene, mainPivot) {
        this.scene = scene;
        this.pivot = mainPivot || scene;
        this.isJackpot = false;
        this.isSpinning = false;
        this.neonElements = [];

        this.init();
    }

    LightingManager.prototype.init = function() {
        var self = this;

        // 1. Ambient Light (Rich Deep Magenta/Violet glow)
        this.ambientLight = new THREE.AmbientLight(0x3b0764, 1.4);
        this.scene.add(this.ambientLight);

        // 2. Main Key Light (Golden sheen from top front)
        this.keyLight = new THREE.DirectionalLight(0xfff7ed, 2.2);
        this.keyLight.position.set(2, 6, 6);
        this.scene.add(this.keyLight);

        // 3. Fill Light (Soft warm amber from left)
        this.fillLight = new THREE.DirectionalLight(0xfbbf24, 1.2);
        this.fillLight.position.set(-5, 2, 4);
        this.scene.add(this.fillLight);

        // 4. Backlights / Intense Rim Lighting (Crucial requirement: Violet & Magenta burst)
        this.rimLight1 = new THREE.PointLight(0xff007f, 4.0, 18);
        this.rimLight1.position.set(0, 0.5, -1.8);
        this.scene.add(this.rimLight1);

        this.rimLight2 = new THREE.PointLight(0x9333ea, 5.0, 20);
        this.rimLight2.position.set(-2.5, 1.2, -2.0);
        this.scene.add(this.rimLight2);

        this.rimLight3 = new THREE.PointLight(0xec4899, 5.0, 20);
        this.rimLight3.position.set(2.5, 1.2, -2.0);
        this.scene.add(this.rimLight3);

        // 5. Sunburst / God Rays Background Plane behind slot machine
        this.createSunburstRays();

        // 6. Neon Rings, Stars, and Neon Arrows
        this.createNeonBackdrop();
    };

    LightingManager.prototype.createSunburstRays = function() {
        // High quality radial sunburst shader
        var vertexShader = [
            'varying vec2 vUv;',
            'void main() {',
            '    vUv = uv;',
            '    gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);',
            '}'
        ].join('\n');

        var fragmentShader = [
            'uniform float uTime;',
            'uniform float uIntensity;',
            'uniform vec3 uColorCenter;',
            'uniform vec3 uColorEdge;',
            'varying vec2 vUv;',
            '#define PI 3.14159265359',
            'void main() {',
            '    vec2 p = vUv - vec2(0.5);',
            '    float dist = length(p);',
            '    float angle = atan(p.y, p.x);',
            '    // Radial light rays',
            '    float rays = sin(angle * 16.0 + uTime * 1.5) * 0.5 + 0.5;',
            '    rays = pow(rays, 2.2);',
            '    // Radial falloff',
            '    float glow = smoothstep(0.5, 0.05, dist);',
            '    vec3 col = mix(uColorCenter, uColorEdge, dist * 1.6);',
            '    float alpha = (glow * 0.45 + rays * glow * 0.85) * uIntensity;',
            '    gl_FragColor = vec4(col * (1.2 + rays * 0.8), alpha);',
            '}'
        ].join('\n');

        this.rayUniforms = {
            uTime: { value: 0 },
            uIntensity: { value: 0.85 },
            uColorCenter: { value: new THREE.Color(0xff0080) }, // Hot Magenta
            uColorEdge: { value: new THREE.Color(0x3b0764) }   // Deep Violet
        };

        var rayMat = new THREE.ShaderMaterial({
            vertexShader: vertexShader,
            fragmentShader: fragmentShader,
            uniforms: this.rayUniforms,
            transparent: true,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
            side: THREE.DoubleSide
        });

        var rayGeo = new THREE.PlaneGeometry(16, 16);
        this.rayMesh = new THREE.Mesh(rayGeo, rayMat);
        this.rayMesh.position.set(0, 0.3, -2.8);
        this.scene.add(this.rayMesh);
    };

    LightingManager.prototype.createNeonBackdrop = function() {
        this.neonGroup = new THREE.Group();
        this.neonGroup.position.set(0, 0.4, -2.2);
        this.scene.add(this.neonGroup);

        // A. Neon Concentric Rings (Cyan, Magenta, Gold)
        var ringConfigs = [
            { radius: 3.3, tube: 0.035, color: 0xff00a0, speed: 1.0 },
            { radius: 4.1, tube: 0.045, color: 0x00f0ff, speed: -0.7 },
            { radius: 4.8, tube: 0.030, color: 0xffb703, speed: 0.8 }
        ];

        var self = this;
        ringConfigs.forEach(function(cfg) {
            var geo = new THREE.TorusGeometry(cfg.radius, cfg.tube, 16, 100);
            var mat = new THREE.MeshBasicMaterial({
                color: cfg.color,
                transparent: true,
                opacity: 0.75,
                blending: THREE.AdditiveBlending
            });
            var ring = new THREE.Mesh(geo, mat);
            self.neonGroup.add(ring);

            self.neonElements.push({
                mesh: ring,
                baseColor: new THREE.Color(cfg.color),
                baseOpacity: 0.75,
                speed: cfg.speed,
                type: 'ring'
            });
        });

        // B. Neon 5-Point Stars
        this.createNeonStar(-4.6, 2.2, 0.65, 0xffd700);
        this.createNeonStar(4.6, 2.2, 0.65, 0xffd700);
        this.createNeonStar(-5.2, -0.6, 0.5, 0xff007f);
        this.createNeonStar(5.2, -0.6, 0.5, 0xff007f);

        // C. Neon Arrows pointing toward the reels (Casino Style)
        this.createNeonArrow(-4.8, 0.3, 0.8, 0, 0x00ffff);      // Points Right
        this.createNeonArrow(4.8, 0.3, 0.8, Math.PI, 0x00ffff); // Points Left
    };

    LightingManager.prototype.createNeonStar = function(x, y, scale, colorHex) {
        var shape = new THREE.Shape();
        var points = 5;
        var outerR = scale;
        var innerR = scale * 0.42;

        for (var i = 0; i < points * 2; i++) {
            var r = (i % 2 === 0) ? outerR : innerR;
            var a = (i / (points * 2)) * Math.PI * 2 - Math.PI / 2;
            var px = Math.cos(a) * r;
            var py = Math.sin(a) * r;
            if (i === 0) shape.moveTo(px, py);
            else shape.lineTo(px, py);
        }
        shape.closePath();

        var geo = new THREE.ShapeGeometry(shape);
        // Wireframe edges or line outline for glowing neon look
        var edges = new THREE.EdgesGeometry(geo);
        var lineMat = new THREE.LineBasicMaterial({
            color: colorHex,
            linewidth: 3,
            transparent: true,
            opacity: 0.9,
            blending: THREE.AdditiveBlending
        });
        var starLine = new THREE.LineSegments(edges, lineMat);
        starLine.position.set(x, y, 0);

        // Soft inner glow fill
        var fillMat = new THREE.MeshBasicMaterial({
            color: colorHex,
            transparent: true,
            opacity: 0.25,
            blending: THREE.AdditiveBlending,
            side: THREE.DoubleSide
        });
        var starFill = new THREE.Mesh(geo, fillMat);
        starLine.add(starFill);

        this.neonGroup.add(starLine);
        this.neonElements.push({
            mesh: starLine,
            baseColor: new THREE.Color(colorHex),
            baseOpacity: 0.9,
            rotSpeed: 0.5,
            type: 'star'
        });
    };

    LightingManager.prototype.createNeonArrow = function(x, y, scale, rotZ, colorHex) {
        var shape = new THREE.Shape();
        // Modern chevron / arrow shape
        shape.moveTo(-scale * 0.4, scale * 0.5);
        shape.lineTo(scale * 0.2, 0);
        shape.lineTo(-scale * 0.4, -scale * 0.5);
        shape.lineTo(-scale * 0.15, -scale * 0.5);
        shape.lineTo(scale * 0.45, 0);
        shape.lineTo(-scale * 0.15, scale * 0.5);
        shape.closePath();

        var geo = new THREE.ShapeGeometry(shape);
        var edges = new THREE.EdgesGeometry(geo);
        var lineMat = new THREE.LineBasicMaterial({
            color: colorHex,
            linewidth: 3,
            transparent: true,
            opacity: 0.95,
            blending: THREE.AdditiveBlending
        });
        var arrow = new THREE.LineSegments(edges, lineMat);
        arrow.position.set(x, y, 0);
        arrow.rotation.z = rotZ;

        var fillMat = new THREE.MeshBasicMaterial({
            color: colorHex,
            transparent: true,
            opacity: 0.35,
            blending: THREE.AdditiveBlending,
            side: THREE.DoubleSide
        });
        arrow.add(new THREE.Mesh(geo, fillMat));

        this.neonGroup.add(arrow);
        this.neonElements.push({
            mesh: arrow,
            baseColor: new THREE.Color(colorHex),
            baseOpacity: 0.95,
            type: 'arrow',
            baseX: x
        });
    };

    LightingManager.prototype.setJackpotMode = function(active) {
        this.isJackpot = !!active;
    };

    LightingManager.prototype.setSpinningMode = function(active) {
        this.isSpinning = !!active;
    };

    LightingManager.prototype.update = function(delta, time) {
        // 1. Update Sunburst Ray Shader
        if (this.rayUniforms) {
            this.rayUniforms.uTime.value = time;
            var targetIntensity = this.isJackpot ? 2.4 : (this.isSpinning ? 1.4 : 0.85);
            this.rayUniforms.uIntensity.value += (targetIntensity - this.rayUniforms.uIntensity.value) * 0.1;
        }

        if (this.rayMesh) {
            // Rotate rays faster during spin & jackpot
            var spinSpeed = this.isJackpot ? 0.8 : (this.isSpinning ? 0.35 : 0.08);
            this.rayMesh.rotation.z += delta * spinSpeed;
        }

        // 2. Dynamic Rim Light Intensities
        var pulseFreq = this.isJackpot ? 18.0 : (this.isSpinning ? 8.0 : 2.5);
        var pulse = Math.sin(time * pulseFreq) * 0.5 + 0.5;

        if (this.isJackpot) {
            this.rimLight1.intensity = 10.0 + pulse * 6.0;
            this.rimLight2.intensity = 12.0 + (1 - pulse) * 6.0;
            this.rimLight3.intensity = 12.0 + pulse * 6.0;
            this.ambientLight.intensity = 2.4 + pulse * 0.8;
            this.keyLight.intensity = 3.2;
        } else if (this.isSpinning) {
            this.rimLight1.intensity = 6.0 + pulse * 2.0;
            this.rimLight2.intensity = 7.0 + pulse * 2.0;
            this.rimLight3.intensity = 7.0 + pulse * 2.0;
            this.ambientLight.intensity = 1.6;
        } else {
            this.rimLight1.intensity = 4.0 + pulse * 1.0;
            this.rimLight2.intensity = 5.0 + pulse * 1.2;
            this.rimLight3.intensity = 5.0 + pulse * 1.2;
            this.ambientLight.intensity = 1.4;
            this.keyLight.intensity = 2.2;
        }

        // 3. Neon Rings & Stars Pulse Animations
        for (var i = 0; i < this.neonElements.length; i++) {
            var item = this.neonElements[i];
            if (item.type === 'ring') {
                item.mesh.rotation.z += delta * item.speed * (this.isJackpot ? 3.0 : 1.0);
                var ringPulse = Math.sin(time * pulseFreq + i) * 0.3 + 0.7;
                item.mesh.material.opacity = item.baseOpacity * ringPulse;
            } else if (item.type === 'star') {
                item.mesh.rotation.z += delta * item.rotSpeed * (this.isJackpot ? 4.0 : 1.0);
                var starPulse = Math.sin(time * pulseFreq * 1.2 + i * 2) * 0.4 + 0.8;
                item.mesh.material.opacity = item.baseOpacity * starPulse;
                var starScale = 1.0 + (this.isJackpot ? Math.sin(time * 16) * 0.18 : 0);
                item.mesh.scale.set(starScale, starScale, starScale);
            } else if (item.type === 'arrow') {
                // Arrows pulse & nudge inward
                var arrowPulse = Math.sin(time * pulseFreq * 1.5) * 0.5 + 0.5;
                item.mesh.material.opacity = 0.5 + arrowPulse * 0.5;
                var nudge = Math.sin(time * pulseFreq) * 0.12;
                if (item.baseX < 0) {
                    item.mesh.position.x = item.baseX + nudge;
                } else {
                    item.mesh.position.x = item.baseX - nudge;
                }
            }
        }
    };

    window.LightingManager = LightingManager;
})(window);
