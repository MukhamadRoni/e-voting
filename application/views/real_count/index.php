<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($title); ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/img/favicon.svg'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.css'); ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f8f9fa;
            color: #1a1a1a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            user-select: none;
        }

        /* ── Topbar Stage Header ── */
        .stage-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e5e5;
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .stage-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1a1a1a;
        }

        .stage-brand img {
            width: 36px;
            height: 36px;
            border-radius: 10px;
        }

        .stage-brand h1 {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.2;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1a1a1a;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 8px rgba(239, 68, 68, 0.6);
            animation: pulse-live 1.2s infinite ease-in-out;
        }

        @keyframes pulse-live {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.5; }
        }

        .stage-brand span {
            font-size: 12px;
            color: #6b7280;
            display: block;
        }

        /* Kategori Segmented Control */
        .segmented-control {
            display: flex;
            background: #f1f2f4;
            padding: 4px;
            border-radius: 9999px;
            border: 1px solid #e2e4e8;
            gap: 4px;
        }

        .segment-btn {
            padding: 7px 20px;
            border-radius: 9999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .segment-btn.active {
            background: #ffffff;
            color: #1a1a1a;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .segment-btn:hover:not(.active) {
            color: #1a1a1a;
        }

        /* Topbar Controls */
        .stage-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pill-widget {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f5f5f7;
            border: 1px solid #e5e5e5;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            color: #4b5563;
        }

        .btn-action-icon {
            background: #ffffff;
            color: #1a1a1a;
            border: 1px solid #e5e5e5;
            border-radius: 9999px;
            padding: 8px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .btn-action-icon:hover {
            background: #f5f5f7;
        }

        /* ── Main Stage Area ── */
        .realcount-stage {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            min-height: calc(100vh - 64px);
        }

        /* Stats Bar Banner */
        .stage-stats-banner {
            max-width: 1280px;
            margin: 18px auto 0;
            padding: 0 24px;
            width: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            z-index: 20;
        }

        .stat-glass-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 18px;
            padding: 14px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
        }

        .stat-glass-card .label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-glass-card .value {
            font-size: 24px;
            font-weight: 800;
            color: #1a1a1a;
            margin-top: 2px;
        }

        /* 3D Canvas Viewport Container */
        .canvas-3d-wrapper {
            flex: 1;
            width: 100%;
            min-height: 540px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #threeCanvas {
            width: 100% !important;
            height: 100% !important;
            display: block;
            outline: none;
        }

        .hint-overlay {
            position: absolute;
            top: 14px;
            left: 50%;
            transform: translateX(-50%);
            background: #ffffff;
            border: 1px solid #e5e5e5;
            padding: 6px 18px;
            border-radius: 9999px;
            font-size: 12px;
            color: #4b5563;
            pointer-events: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            z-index: 10;
        }

        /* ── Bottom Tray: Kandidat Lainnya (Rank 4, 5, dst) ── */
        .bottom-tray-container {
            background: #ffffff;
            border-top: 1px solid #e5e5e5;
            padding: 18px 36px 24px;
            z-index: 20;
        }

        .tray-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .tray-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .tray-header h3 {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .other-candidates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 14px;
        }

        .other-candidate-card {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 16px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.2s ease;
        }

        .other-candidate-card:hover {
            border-color: #1a1a1a;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transform: translateY(-2px);
        }

        .other-rank-badge {
            width: 32px;
            height: 32px;
            background: #ffffff;
            color: #1a1a1a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            border: 1px solid #e5e5e5;
        }

        .other-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #e5e5e5;
            background: #f5f5f7;
        }

        .other-info {
            flex: 1;
            min-width: 0;
        }

        .other-name {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .other-votes {
            font-size: 12px;
            color: #6b7280;
            margin-top: 3px;
            display: flex;
            justify-content: space-between;
        }

        .other-progress-bg {
            height: 6px;
            background: #e5e5e5;
            border-radius: 9999px;
            margin-top: 6px;
            overflow: hidden;
        }

        .other-progress-bar {
            height: 100%;
            background: #1a1a1a;
            border-radius: 9999px;
            transition: width 0.6s ease;
        }

        /* ── Rank Shift Notification Banner ── */
        .rank-shift-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 16px;
            padding: 16px 24px;
            color: #1a1a1a;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 1000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .rank-shift-toast.show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body>

    <!-- Topbar Stage Header -->
    <header class="stage-navbar">
        <a href="<?= site_url('real_count'); ?>" class="stage-brand">
            <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo E-Voting">
            <div>
                <h1>
                    <span>Real Count 3D Interactive</span>
                    <span class="live-dot" title="Live Polling Active"></span>
                </h1>
                <span>Hasil Suara Pemilihan Terkini &bull; RAT Koperasi</span>
            </div>
        </a>

        <!-- Kategori Switcher: Ketua vs Pengawas -->
        <div class="segmented-control">
            <button type="button" class="segment-btn <?= ($kategori === 'ketua') ? 'active' : ''; ?>" onclick="switchKategori('ketua')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <span>Calon Ketua</span>
            </button>
            <button type="button" class="segment-btn <?= ($kategori === 'pengawas') ? 'active' : ''; ?>" onclick="switchKategori('pengawas')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2z"/></svg>
                <span>Calon Pengawas</span>
            </button>
        </div>

        <!-- Controls -->
        <div class="stage-controls">
            <!-- Countdown Timer Indicator -->
            <div class="pill-widget" id="updateTimerPill" title="Auto-refresh setiap 10 detik">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>Sync: <strong id="countdownText" style="color:#1a1a1a;">10s</strong></span>
            </div>

            <!-- Manual Refresh -->
            <button type="button" class="btn-action-icon" onclick="fetchRealCountData(true)" title="Segarkan Data Sekarang">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0020 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 004 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                <span>Refresh</span>
            </button>

            <!-- Fullscreen -->
            <button type="button" class="btn-action-icon" id="btnFullscreen" title="Layar Penuh (F11)">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
                <span>Fullscreen</span>
            </button>

            <!-- Link Admin -->
            <a href="<?= site_url('admin'); ?>" class="btn-action-icon" target="_blank" title="Buka Panel Admin">
                <span>Panel Admin ↗</span>
            </a>
        </div>
    </header>

    <!-- Main Real Count Stage -->
    <main class="realcount-stage">
        
        <!-- Stats Bar Banner -->
        <div class="stage-stats-banner">
            <div class="stat-glass-card">
                <div>
                    <div class="label">Total Suara Masuk</div>
                    <div class="value" id="displayTotalSuara"><?= $total_suara; ?> <span style="font-size:14px; color:#6b7280; font-weight:500;">Suara</span></div>
                </div>
                <div style="color:#1a1a1a;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
            </div>

            <div class="stat-glass-card">
                <div>
                    <div class="label">Partisipasi DPT</div>
                    <div class="value" id="displayPersenPartisipasi">
                        <?= ($total_dpt > 0) ? round(($total_suara / $total_dpt) * 100, 1) : 0; ?>%
                    </div>
                </div>
                <div style="color:#16a34a;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </div>
            </div>

            <div class="stat-glass-card">
                <div>
                    <div class="label">Total Pemilih DPT</div>
                    <div class="value" id="displayTotalDpt"><?= $total_dpt; ?> <span style="font-size:14px; color:#6b7280; font-weight:500;">Anggota</span></div>
                </div>
                <div style="color:#b45309;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76V14h2V8.76L15.38 12 17 10.83 14.92 8H20v6z"/></svg>
                </div>
            </div>

            <div class="stat-glass-card">
                <div>
                    <div class="label">Terakhir Diperbarui</div>
                    <div class="value" id="displayUpdatedAt" style="font-size:18px; color:#1a1a1a;"><?= date('H:i:s'); ?> WIB</div>
                </div>
                <div style="color:#6b7280;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm4.2 14.2L11 13V7h1.5v5.2l4.5 2.7-.8 1.3z"/></svg>
                </div>
            </div>
        </div>

        <!-- 3D Canvas Viewport -->
        <div class="canvas-3d-wrapper" id="canvasWrapper">
            <div class="hint-overlay">
                👑 <strong>Peringkat 1 (Pusat Panggung)</strong> &bull; Gerakkan kursor untuk efek 3D Parallax &bull; Sinkronisasi otomatis
            </div>
            <canvas id="threeCanvas"></canvas>
        </div>

        <!-- Bottom Tray: Kandidat Lainnya (Rank 4, 5, dst jika ada) -->
        <div class="bottom-tray-container" id="bottomTray" style="display:none;">
            <div class="tray-inner">
                <div class="tray-header">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        <span>Kandidat Lainnya (Klasemen Lanjutan)</span>
                    </h3>
                    <span style="font-size:12px; color:#6b7280;" id="otherCountBadge">0 Kandidat</span>
                </div>
                <div class="other-candidates-grid" id="otherCandidatesGrid">
                    <!-- Dynamic Other Candidate Cards -->
                </div>
            </div>
        </div>
    </main>

    <!-- Rank Shift Notification Toast -->
    <div class="rank-shift-toast" id="rankShiftToast">
        <div style="font-size:24px;">🔥</div>
        <div>
            <div style="font-size:14px; font-weight:700; color:#1a1a1a;">Perubahan Peringkat Terdeteksi!</div>
            <div style="font-size:12px; color:#6b7280;" id="rankShiftToastMsg">Posisi suara kandidat telah bergeser secara dinamis.</div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('assets/vendor/threejs/three.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

    <script>
    // ═══════════════════════════════════════════════════════════
    // THREE.JS 3D INTERACTIVE REAL COUNT ENGINE (LIGHT MINIMALIST)
    // ═══════════════════════════════════════════════════════════

    var activeKategori = "<?= $kategori; ?>";
    var ajaxUrl = "<?= site_url('real_count/data_ajax'); ?>";
    var prevRanksMap = {}; // mapping nik -> previous rank to detect shifts
    var cardMeshes = {};   // mapping nik -> 3D Object Group

    var scene, camera, renderer;
    var canvasWrapper = document.getElementById('canvasWrapper');
    var canvas = document.getElementById('threeCanvas');

    var mouseX = 0, mouseY = 0;
    var targetCameraX = 0, targetCameraY = 1.4;

    // ── OLYMPIC / STAGE WINNER PODIUM LAYOUT ──
    // Peringkat 1 (Rank 1): DITENGAH (Center X = 0.0, elevated Y = 0.25, Scale = 1.18)
    // Peringkat 2 (Rank 2): DISAMPING KIRI (Left X = -5.6, Y = -0.35, Scale = 1.02)
    // Peringkat 3 (Rank 3): DISAMPING KANAN (Right X = 5.6, Y = -0.55, Scale = 0.98)
    var slotPositions = [
        { x:  0.0, y:  0.25, z:  0.4, scale: 1.18 }, // Rank 1 (Center - Leader)
        { x: -5.6, y: -0.35, z: -0.2, scale: 1.02 }, // Rank 2 (Left)
        { x:  5.6, y: -0.55, z: -0.4, scale: 0.98 }  // Rank 3 (Right)
    ];

    var rankThemes = [
        { 
            color: 0xf59e0b, 
            hex: '#f59e0b', 
            label: '★ PERINGKAT 1 (LEADER) ★', 
            badgeBg: '#78350f', 
            badgeText: '#fde047',
            badgeBorder: '#f59e0b',
            barColor: '#f59e0b',
            accent: '#fbbf24',
            cardBgTop: 'rgba(245, 158, 11, 0.22)',
            cardBgBottom: '#0b1120',
            podiumColor: 0xd4af37, // Polished Metallic Gold
            podiumMetalness: 0.90,
            podiumRoughness: 0.18,
            ledColor: 0xfbbf24     // Luminous Gold LED
        }, // Rank 1: Gold / Emas
        { 
            color: 0x38bdf8, 
            hex: '#38bdf8', 
            label: '★ PERINGKAT 2 ★', 
            badgeBg: '#075985', 
            badgeText: '#7dd3fc',
            badgeBorder: '#38bdf8',
            barColor: '#38bdf8',
            accent: '#7dd3fc',
            cardBgTop: 'rgba(56, 189, 248, 0.20)',
            cardBgBottom: '#0b1120',
            podiumColor: 0xc4cbd4, // Polished Metallic Silver / Platinum
            podiumMetalness: 0.92,
            podiumRoughness: 0.16,
            ledColor: 0x38bdf8     // Luminous Silver / Cyan LED
        }, // Rank 2: Silver / Perak
        { 
            color: 0xa855f7, 
            hex: '#a855f7', 
            label: '★ PERINGKAT 3 ★', 
            badgeBg: '#581c87', 
            badgeText: '#e9d5ff',
            badgeBorder: '#a855f7',
            barColor: '#a855f7',
            accent: '#c084fc',
            cardBgTop: 'rgba(168, 85, 247, 0.20)',
            cardBgBottom: '#0b1120',
            podiumColor: 0xcd7f32, // Polished Metallic Bronze / Perunggu
            podiumMetalness: 0.88,
            podiumRoughness: 0.22,
            ledColor: 0xf97316     // Luminous Bronze / Amber LED
        }  // Rank 3: Bronze / Perunggu
    ];

    // ── 1. Init Three.js Scene ──
    function init3DScene() {
        scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0xf8f9fa, 0.02);

        var width = canvasWrapper.clientWidth;
        var height = canvasWrapper.clientHeight;

        camera = new THREE.PerspectiveCamera(46, width / height, 0.1, 1000);
        camera.position.set(0, 1.4, 16.2);
        camera.lookAt(0, 0.3, 0);

        renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: true });
        renderer.setSize(width, height);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.15;

        // Ambient & Directional Lighting for Bright Studio Look
        var ambientLight = new THREE.AmbientLight(0xffffff, 1.15);
        scene.add(ambientLight);

        // Center Spotlight for Podium
        var centerSpot = new THREE.SpotLight(0xffffff, 1.4, 40, Math.PI / 3, 0.4);
        centerSpot.position.set(0, 14, 10);
        scene.add(centerSpot);

        // Floating Background Subtle Particles
        initParticles();

        // Window resize
        window.addEventListener('resize', onWindowResize);

        // Mouse Parallax Effect
        document.addEventListener('mousemove', function(e) {
            mouseX = (e.clientX / window.innerWidth) * 2 - 1;
            mouseY = -(e.clientY / window.innerHeight) * 2 + 1;
            targetCameraX = mouseX * 1.5;
            targetCameraY = 1.4 + mouseY * 0.7;
        });

        // Start render loop
        animate();
    }

    // ── 2. Background Floating Particles ──
    var particlesMesh;
    function initParticles() {
        var particleCount = 180;
        var geometry = new THREE.BufferGeometry();
        var positions = new Float32Array(particleCount * 3);

        for (var i = 0; i < particleCount * 3; i += 3) {
            positions[i] = (Math.random() - 0.5) * 45;
            positions[i + 1] = (Math.random() - 0.5) * 25;
            positions[i + 2] = (Math.random() - 0.5) * 25 - 6;
        }

        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

        var material = new THREE.PointsMaterial({
            color: 0x94a3b8,
            size: 0.12,
            transparent: true,
            opacity: 0.35
        });

        particlesMesh = new THREE.Points(geometry, material);
        scene.add(particlesMesh);
    }

    // ── 3. High-Resolution Texture Generator (High-Contrast Rich Dark 3D Cards) ──
    function createCardTexture(candidate, rankIndex, callback) {
        var cardCanvas = document.createElement('canvas');
        cardCanvas.width = 800;
        cardCanvas.height = 1100;
        var ctx = cardCanvas.getContext('2d');

        var theme = rankThemes[rankIndex] || rankThemes[2];
        var isRank1 = (rankIndex === 0);

        // Base Dark Rounded Card
        ctx.fillStyle = '#0f172a';
        roundRect(ctx, 16, 16, 768, 1068, 42, true, false);

        // Inner Card Gradient with Saturated Rank Tint
        var innerGrad = ctx.createLinearGradient(0, 0, 0, 1100);
        innerGrad.addColorStop(0, theme.cardBgTop);
        innerGrad.addColorStop(0.35, '#1e293b');
        innerGrad.addColorStop(1, '#0b0f19');
        ctx.fillStyle = innerGrad;
        roundRect(ctx, 16, 16, 768, 1068, 42, true, false);

        // Crisp Glowing Dual-Tone Outer Border Rim
        ctx.lineWidth = isRank1 ? 10 : 7;
        var borderGrad = ctx.createLinearGradient(0, 0, 800, 1100);
        borderGrad.addColorStop(0, theme.accent);
        borderGrad.addColorStop(0.5, '#475569');
        borderGrad.addColorStop(1, theme.hex);
        ctx.strokeStyle = borderGrad;
        roundRect(ctx, 16, 16, 768, 1068, 42, false, true);

        // ── Header Rank Badge (Pill Shaped per design.md) ──
        ctx.fillStyle = theme.badgeBg;
        roundRect(ctx, 160, 46, 480, 56, 28, true, false);
        ctx.strokeStyle = theme.badgeBorder;
        ctx.lineWidth = 3;
        roundRect(ctx, 160, 46, 480, 56, 28, false, true);

        ctx.fillStyle = theme.badgeText;
        ctx.font = 'bold 23px "DM Sans", sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(theme.label, 400, 83);

        // ── Candidate Photo Box ──
        var img = new Image();
        img.crossOrigin = 'anonymous';
        img.src = candidate.foto_url;

        function drawContents() {
            var photoCenterX = 400;
            var photoCenterY = 280;
            var photoRadius = isRank1 ? 140 : 130;

            // Draw Photo Circle
            ctx.save();
            ctx.beginPath();
            ctx.arc(photoCenterX, photoCenterY, photoRadius, 0, Math.PI * 2);
            ctx.closePath();
            ctx.clip();
            try {
                ctx.drawImage(img, photoCenterX - photoRadius, photoCenterY - photoRadius, photoRadius * 2, photoRadius * 2);
            } catch(e) {
                ctx.fillStyle = '#1e293b';
                ctx.fill();
            }
            ctx.restore();

            // Photo Outer Stroke
            ctx.beginPath();
            ctx.arc(photoCenterX, photoCenterY, photoRadius + 2, 0, Math.PI * 2);
            ctx.strokeStyle = theme.accent;
            ctx.lineWidth = isRank1 ? 8 : 6;
            ctx.stroke();

            // ── Candidate Name (Pure Crisp White) ──
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 38px "DM Sans", sans-serif';
            ctx.textAlign = 'center';
            var name = candidate.nama.length > 24 ? candidate.nama.substring(0, 22) + '...' : candidate.nama;
            ctx.fillText(name, 400, 480);

            // ── NIK Pill ──
            ctx.fillStyle = '#1e293b';
            roundRect(ctx, 260, 506, 280, 40, 20, true, false);
            ctx.strokeStyle = '#334155';
            ctx.lineWidth = 1.5;
            roundRect(ctx, 260, 506, 280, 40, 20, false, true);

            ctx.fillStyle = '#cbd5e1';
            ctx.font = '600 19px "DM Sans", sans-serif';
            ctx.fillText('NIK: ' + candidate.nik, 400, 532);

            // ── Giant Vote Percentage (DM Sans 800) ──
            ctx.fillStyle = theme.accent;
            ctx.font = '800 96px "DM Sans", sans-serif';
            ctx.fillText(candidate.persentase + '%', 400, 650);

            // ── Vote Count Badge (Crisp White) ──
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 34px "DM Sans", sans-serif';
            ctx.fillText(candidate.total_suara + ' Suara Masuk', 400, 720);

            // ── Progress Bar Track & Fill (Pill Shaped) ──
            ctx.fillStyle = '#1e293b';
            roundRect(ctx, 70, 770, 660, 34, 17, true, false);

            var barWidth = Math.max(34, (candidate.persentase / 100) * 660);
            ctx.fillStyle = theme.barColor;
            roundRect(ctx, 70, 770, barWidth, 34, 17, true, false);

            // ── Card Footer Subtitle ──
            ctx.fillStyle = '#64748b';
            ctx.font = '600 19px "DM Sans", sans-serif';
            ctx.fillText('E-VOTING KOPERASI REAL COUNT', 400, 875);

            var texture = new THREE.CanvasTexture(cardCanvas);
            texture.needsUpdate = true;
            if (callback) callback(texture);
        }

        img.onload = drawContents;
        img.onerror = drawContents;
    }

    function roundRect(ctx, x, y, width, height, radius, fill, stroke) {
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        ctx.lineTo(x + width, y + height - radius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
        ctx.lineTo(x + radius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
        if (fill) ctx.fill();
        if (stroke) ctx.stroke();
    }

    // ── 4. Build or Update 3D Candidate Cards (Peringkat 1 di Tengah, 2 di Kiri, 3 di Kanan) ──
    function update3DStage(candidates) {
        var top3 = candidates.slice(0, 3);
        var activeIds = {};

        top3.forEach(function(cand, rankIndex) {
            var targetSlot = slotPositions[rankIndex] || { x: 0, y: 0, z: 0, scale: 1.0 };
            activeIds[cand.nik] = true;

            var prevRank = prevRanksMap[cand.nik];
            var isRankShifted = (prevRank !== undefined && prevRank !== (rankIndex + 1));

            if (!cardMeshes[cand.nik]) {
                // Buat 3D Object Group Baru untuk Kandidat ini
                var group = new THREE.Group();
                group.position.set(targetSlot.x, targetSlot.y, targetSlot.z);
                group.targetX = targetSlot.x;
                group.targetY = targetSlot.y;
                group.targetZ = targetSlot.z;
                group.targetScale = targetSlot.scale;
                group.candidateNik = cand.nik;
                group.currentRank = rankIndex + 1;
                group.jumpOffset = 0;

                // Base 3D Pedestal Cylinder (Polished Gold / Silver / Bronze per Peringkat)
                var baseGeo = new THREE.CylinderGeometry(2.1, 2.3, 0.45, 36);
                var baseMat = new THREE.MeshStandardMaterial({
                    color: rankThemes[rankIndex].podiumColor,
                    metalness: rankThemes[rankIndex].podiumMetalness,
                    roughness: rankThemes[rankIndex].podiumRoughness
                });
                var baseMesh = new THREE.Mesh(baseGeo, baseMat);
                baseMesh.position.y = -2.6;
                group.add(baseMesh);
                group.baseMesh = baseMesh;

                // LED Ring Torus pada Base
                var ringGeo = new THREE.TorusGeometry(2.15, 0.07, 16, 48);
                var ringMat = new THREE.MeshBasicMaterial({ color: rankThemes[rankIndex].ledColor });
                var ringMesh = new THREE.Mesh(ringGeo, ringMat);
                ringMesh.rotation.x = Math.PI / 2;
                ringMesh.position.y = -2.35;
                group.add(ringMesh);
                group.ringMesh = ringMesh;

                // Main Floating 3D Plane Card
                var cardGeo = new THREE.PlaneGeometry(4.8, 6.6);
                var cardMat = new THREE.MeshBasicMaterial({ transparent: true, side: THREE.DoubleSide });
                var cardMesh = new THREE.Mesh(cardGeo, cardMat);
                cardMesh.position.y = 0.85;
                group.add(cardMesh);
                group.cardMesh = cardMesh;

                // Generate High-Res Texture
                createCardTexture(cand, rankIndex, function(texture) {
                    cardMat.map = texture;
                    cardMat.needsUpdate = true;
                });

                scene.add(group);
                cardMeshes[cand.nik] = group;
            } else {
                // Update Posisi Target dan Tekstur Card yang Sudah Ada
                var group = cardMeshes[cand.nik];
                group.targetX = targetSlot.x;
                group.targetY = targetSlot.y;
                group.targetZ = targetSlot.z;
                group.targetScale = targetSlot.scale;
                group.currentRank = rankIndex + 1;

                if (group.baseMesh && group.baseMesh.material) {
                    group.baseMesh.material.color.setHex(rankThemes[rankIndex].podiumColor);
                    group.baseMesh.material.metalness = rankThemes[rankIndex].podiumMetalness;
                    group.baseMesh.material.roughness = rankThemes[rankIndex].podiumRoughness;
                }

                if (group.ringMesh && group.ringMesh.material) {
                    group.ringMesh.material.color.setHex(rankThemes[rankIndex].ledColor);
                }

                // Jika Peringkat Bergeser -> Berikan Animasi Lompat & Geser 3D
                if (isRankShifted) {
                    group.jumpOffset = 1.0; // Trigger upward arch while sliding!
                    showRankShiftToast(cand.nama, prevRank, rankIndex + 1);
                }

                // Update texture with latest votes & percentage
                createCardTexture(cand, rankIndex, function(texture) {
                    if (group.cardMesh && group.cardMesh.material) {
                        group.cardMesh.material.map = texture;
                        group.cardMesh.material.needsUpdate = true;
                    }
                });
            }

            // Simpan rank terkini untuk perbandingan polling berikutnya
            prevRanksMap[cand.nik] = rankIndex + 1;
        });

        // Hapus kandidat dari 3D scene jika terlempar keluar dari Top 3
        Object.keys(cardMeshes).forEach(function(nik) {
            if (!activeIds[nik]) {
                var meshToRemove = cardMeshes[nik];
                scene.remove(meshToRemove);
                delete cardMeshes[nik];
                delete prevRanksMap[nik];
            }
        });

        // Update Bottom Tray untuk kandidat rank 4 ke bawah
        updateBottomTray(candidates.slice(3));
    }

    // ── 5. Update Bottom Shelf (Rank 4, 5, dst) ──
    function updateBottomTray(otherCandidates) {
        var bottomTray = document.getElementById('bottomTray');
        var grid = document.getElementById('otherCandidatesGrid');
        var badge = document.getElementById('otherCountBadge');

        if (!otherCandidates || otherCandidates.length === 0) {
            bottomTray.style.display = 'none';
            return;
        }

        bottomTray.style.display = 'block';
        badge.textContent = otherCandidates.length + ' Kandidat';
        grid.innerHTML = '';

        otherCandidates.forEach(function(cand) {
            var card = document.createElement('div');
            card.className = 'other-candidate-card';
            card.innerHTML = 
                '<div class="other-rank-badge">#' + cand.rank + '</div>' +
                '<img src="' + cand.foto_url + '" class="other-avatar" alt="' + cand.nama + '">' +
                '<div class="other-info">' +
                    '<div class="other-name">' + cand.nama + '</div>' +
                    '<div class="other-votes">' +
                        '<span>' + cand.total_suara + ' Suara</span>' +
                        '<strong style="color:#1a1a1a;">' + cand.persentase + '%</strong>' +
                    '</div>' +
                    '<div class="other-progress-bg">' +
                        '<div class="other-progress-bar" style="width:' + cand.persentase + '%;"></div>' +
                    '</div>' +
                '</div>';
            grid.appendChild(card);
        });
    }

    // ── 6. Animation Loop with Smooth 3D Rank Swapping & Interpolation ──
    var clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);

        var delta = clock.getDelta();
        var time = clock.getElapsedTime();

        // Smooth Camera Parallax
        camera.position.x += (targetCameraX - camera.position.x) * 0.04;
        camera.position.y += (targetCameraY - camera.position.y) * 0.04;
        camera.lookAt(0, 0.3, 0);

        // Rotate Background Particles gently
        if (particlesMesh) {
            particlesMesh.rotation.y = time * 0.02;
        }

        // Animate each 3D Candidate Group
        Object.keys(cardMeshes).forEach(function(nik, idx) {
            var group = cardMeshes[nik];

            // 3D Horizontal Slide towards target X (Rank swap interpolation)
            group.position.x += (group.targetX - group.position.x) * 0.07;
            group.position.z += (group.targetZ - group.position.z) * 0.07;

            // Arched Jump effect when swapping rank
            if (group.jumpOffset > 0.01) {
                group.jumpOffset -= delta * 1.5;
            } else {
                group.jumpOffset = 0;
            }
            var jumpY = Math.sin(group.jumpOffset * Math.PI) * 1.1;

            // Gentle floating/breathing animation
            var floatY = Math.sin(time * 2 + idx * 1.5) * 0.07;
            group.position.y = group.targetY + floatY + jumpY;

            // Smooth scale transition
            var currentScale = group.scale.x;
            var newScale = currentScale + (group.targetScale - currentScale) * 0.06;
            group.scale.set(newScale, newScale, newScale);

            // Subtle 3D tilt based on horizontal velocity
            var vx = (group.targetX - group.position.x);
            group.rotation.y = -vx * 0.07;
            group.rotation.z = -vx * 0.025;
        });

        renderer.render(scene, camera);
    }

    function onWindowResize() {
        if (!canvasWrapper) return;
        var width = canvasWrapper.clientWidth;
        var height = canvasWrapper.clientHeight;
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    }

    // ── 7. Auto-Polling Data Engine (Every 10 Seconds) ──
    var countdown = 10;
    var countdownText = document.getElementById('countdownText');
    var isFetching = false;

    function fetchRealCountData(isManual) {
        if (isFetching) return;
        isFetching = true;

        if (isManual) {
            countdown = 10;
        }

        fetch(ajaxUrl + '?kategori=' + encodeURIComponent(activeKategori))
            .then(function(res) { return res.json(); })
            .then(function(response) {
                isFetching = false;
                if (response.status === 'success') {
                    // Update Header Stats
                    document.getElementById('displayTotalSuara').innerHTML = response.total_suara + ' <span style="font-size:14px; color:#6b7280; font-weight:500;">Suara</span>';
                    document.getElementById('displayPersenPartisipasi').textContent = response.persen_partisipasi + '%';
                    document.getElementById('displayTotalDpt').innerHTML = response.total_dpt + ' <span style="font-size:14px; color:#6b7280; font-weight:500;">Anggota</span>';
                    document.getElementById('displayUpdatedAt').textContent = response.updated_at;

                    // Update 3D Stage & Bottom Tray
                    update3DStage(response.kandidat);
                }
            })
            .catch(function(err) {
                isFetching = false;
                console.error('Error fetching real count:', err);
            });
    }

    // Interval 10 Detik
    setInterval(function() {
        countdown--;
        if (countdown <= 0) {
            countdown = 10;
            fetchRealCountData(false);
        }
        countdownText.textContent = countdown + 's';
    }, 1000);

    // ── 8. Switch Kategori (Ketua vs Pengawas) ──
    window.switchKategori = function(kat) {
        if (activeKategori === kat) return;
        activeKategori = kat;

        // Reset and clean 3D scene meshes for clean category transition
        Object.keys(cardMeshes).forEach(function(nik) {
            scene.remove(cardMeshes[nik]);
        });
        cardMeshes = {};
        prevRanksMap = {};

        // Update URL query without page reload
        var newUrl = window.location.pathname + '?kategori=' + kat;
        window.history.pushState({ path: newUrl }, '', newUrl);

        // Update segmented control buttons
        document.querySelectorAll('.segment-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        if (event && event.currentTarget) {
            event.currentTarget.classList.add('active');
        }

        countdown = 10;
        fetchRealCountData(true);
    };

    // ── 9. Rank Shift Toast Notification ──
    function showRankShiftToast(kandidatName, oldRank, newRank) {
        var toast = document.getElementById('rankShiftToast');
        var msg = document.getElementById('rankShiftToastMsg');

        msg.innerHTML = '<strong>' + kandidatName + '</strong> bergeser dari <b>#' + oldRank + '</b> ke <b>#' + newRank + '</b>!';
        toast.classList.add('show');

        setTimeout(function() {
            toast.classList.remove('show');
        }, 4500);
    }

    // ── 10. Fullscreen API Toggle ──
    document.getElementById('btnFullscreen').addEventListener('click', function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(function(err) {
                console.log(err);
            });
            this.querySelector('span').textContent = 'Exit Screen';
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
                this.querySelector('span').textContent = 'Fullscreen';
            }
        }
    });

    // ── Initialize on Page Load ──
    document.addEventListener('DOMContentLoaded', function() {
        init3DScene();
        fetchRealCountData(true);
    });
    </script>
</body>
</html>
