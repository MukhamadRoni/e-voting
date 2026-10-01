/**
 * ThreeScene.js
 * Inisialisasi Kanvas Three.js, Kamera, Renderer, Loop Animasi & Interaksi Parallax
 */
(function(window) {
    'use strict';

    function ThreeScene(containerId) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error('ThreeScene: Container element not found:', containerId);
            return;
        }

        this.width = this.container.clientWidth || 800;
        this.height = this.container.clientHeight || 560;
        this.subscribers = [];
        this.isJackpot = false;
        this.isSpinning = false;
        this.mouseX = 0;
        this.mouseY = 0;
        this.targetRotationX = 0;
        this.targetRotationY = 0;

        this.init();
    }

    ThreeScene.prototype.init = function() {
        var self = this;

        // 1. Scene
        this.scene = new THREE.Scene();
        // Radial purple/magenta fog to blend background depth
        this.scene.fog = new THREE.FogExp2(0x180528, 0.025);

        // 2. Camera
        this.camera = new THREE.PerspectiveCamera(42, this.width / this.height, 0.1, 100);
        this.camera.position.set(0, 0.3, 9.6);
        this.cameraBasePos = this.camera.position.clone();

        // 3. Renderer with high visual fidelity
        this.renderer = new THREE.WebGLRenderer({
            antialias: true,
            alpha: true,
            powerPreference: 'high-performance'
        });
        this.renderer.setSize(this.width, this.height);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 1.35;
        this.renderer.outputEncoding = THREE.sRGBEncoding;

        this.renderer.domElement.style.width = '100%';
        this.renderer.domElement.style.height = '100%';
        this.renderer.domElement.style.display = 'block';
        this.renderer.domElement.style.outline = 'none';

        this.container.appendChild(this.renderer.domElement);

        // Sub-scene root container for gentle tilt
        this.mainPivot = new THREE.Group();
        this.scene.add(this.mainPivot);

        // 4. Resize listener
        window.addEventListener('resize', function() {
            self.onResize();
        });

        // 5. Subtle interactive mouse tilt with natural 3/4 perspective base angle (like spin machine.png)
        this.baseRotationY = 0.06;
        this.baseRotationX = 0.03;
        this.targetRotationY = this.baseRotationY;
        this.targetRotationX = this.baseRotationX;
        this.mainPivot.rotation.y = this.baseRotationY;
        this.mainPivot.rotation.x = this.baseRotationX;

        this.container.addEventListener('mousemove', function(e) {
            var rect = self.container.getBoundingClientRect();
            var x = (e.clientX - rect.left) / rect.width - 0.5;
            var y = (e.clientY - rect.top) / rect.height - 0.5;
            self.targetRotationY = self.baseRotationY + x * 0.16;
            self.targetRotationX = self.baseRotationX - y * 0.10;
        });

        this.container.addEventListener('mouseleave', function() {
            self.targetRotationX = self.baseRotationX;
            self.targetRotationY = self.baseRotationY;
        });

        // Start render loop
        this.clock = new THREE.Clock();
        this.animate = this.animate.bind(this);
        requestAnimationFrame(this.animate);
    };

    ThreeScene.prototype.onResize = function() {
        if (!this.container) return;
        this.width = this.container.clientWidth;
        this.height = this.container.clientHeight;
        if (this.width === 0 || this.height === 0) return;

        this.camera.aspect = this.width / this.height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(this.width, this.height);
    };

    ThreeScene.prototype.subscribe = function(updateFn) {
        if (typeof updateFn === 'function') {
            this.subscribers.push(updateFn);
        }
    };

    ThreeScene.prototype.setJackpotMode = function(active) {
        this.isJackpot = !!active;
    };

    ThreeScene.prototype.setSpinningMode = function(active) {
        this.isSpinning = !!active;
    };

    ThreeScene.prototype.animate = function() {
        requestAnimationFrame(this.animate);

        var delta = this.clock.getDelta();
        var time = this.clock.getElapsedTime();

        // Smooth camera tilt / parallax
        this.mainPivot.rotation.y += (this.targetRotationY - this.mainPivot.rotation.y) * 0.08;
        this.mainPivot.rotation.x += (this.targetRotationX - this.mainPivot.rotation.x) * 0.08;

        // Dynamic camera punch during jackpot celebration
        if (this.isJackpot) {
            var shake = Math.sin(time * 30) * 0.025;
            var pulse = Math.sin(time * 6) * 0.15;
            this.camera.position.z = this.cameraBasePos.z - 0.35 + pulse;
            this.camera.position.y = this.cameraBasePos.y + shake;
        } else {
            this.camera.position.lerp(this.cameraBasePos, 0.08);
        }

        // Notify subscribers (SlotMachine, LightingManager, ParticleSystem)
        for (var i = 0; i < this.subscribers.length; i++) {
            this.subscribers[i](delta, time);
        }

        this.renderer.render(this.scene, this.camera);
    };

    window.ThreeScene = ThreeScene;
})(window);
