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
        }

        /* ── Topbar Stage ── */
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
            z-index: 50;
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
            color: #1a1a1a;
        }

        .stage-brand span {
            font-size: 12px;
            color: #6b7280;
            display: block;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-nav {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid #e5e5e5;
            background: #ffffff;
            color: #1a1a1a;
        }

        .btn-nav:hover {
            background: #f5f5f7;
        }

        .btn-nav.danger {
            border-color: #fecaca;
            color: #dc2626;
            background: #fef2f2;
        }

        .btn-nav.danger:hover {
            background: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }

        /* ── Main Stage Grid Layout ── */
        .stage-container {
            flex: 1;
            max-width: 1440px;
            width: 100%;
            margin: 0 auto;
            padding: 28px 32px 40px;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 28px;
        }

        @media (max-width: 1080px) {
            .stage-container {
                grid-template-columns: 1fr;
            }
        }

        /* ── Left Column: Arena Undian ── */
        .stage-main {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Control Bar Card */
        .control-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 20px;
            padding: 18px 24px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
        }

        .control-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .control-label {
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
        }

        .input-hadiah {
            background: #f8f9fa;
            border: 1.5px solid #e5e5e5;
            border-radius: 12px;
            padding: 8px 14px;
            color: #1a1a1a;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            outline: none;
            min-width: 220px;
            transition: all 0.15s ease;
        }

        .input-hadiah:focus {
            background: #ffffff;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.08);
        }

        .select-filter {
            background: #f8f9fa;
            border: 1.5px solid #e5e5e5;
            border-radius: 12px;
            padding: 8px 14px;
            color: #1a1a1a;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            outline: none;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .select-filter:focus {
            background: #ffffff;
            border-color: #1a1a1a;
        }

        /* Toggle Auto-Valid Switch */
        .toggle-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f5f5f7;
            padding: 6px 14px;
            border-radius: 9999px;
            border: 1px solid #e5e5e5;
            user-select: none;
        }

        .switch-toggle {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 22px;
        }

        .switch-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #d1d5db;
            transition: .25s;
            border-radius: 22px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .25s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }

        input:checked + .slider {
            background-color: #16a34a;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .toggle-status-text {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .status-on {
            color: #15803d;
        }

        .status-off {
            color: #b45309;
        }

        /* ── Big Stage Display Card ── */
        .stage-display {
            background: #ffffff;
            border: 2px solid #e5e5e5;
            border-radius: 24px;
            padding: 44px 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            min-height: 460px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .prize-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fef3c7;
            border: 1px solid #fde68a;
            color: #b45309;
            padding: 8px 22px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        /* Winner Visual Arena */
        .spinner-arena {
            width: 100%;
            margin: 32px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            position: relative;
        }

        .slot-box {
            width: 100%;
            max-width: 640px;
            background: #f8f9fa;
            border: 2px dashed #d1d5db;
            border-radius: 24px;
            padding: 36px 28px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .slot-box.spinning {
            border: 2px solid #1a1a1a;
            background: #f3f4f6;
            box-shadow: 0 0 25px rgba(26, 26, 26, 0.08);
            animation: pulse-glow-light 1.2s infinite alternate;
        }

        .slot-box.winner-revealed {
            border: 2px solid #16a34a;
            background: #f0fdf4;
            box-shadow: 0 10px 30px rgba(22, 163, 74, 0.12);
            transform: scale(1.02);
        }

        @keyframes pulse-glow-light {
            from { box-shadow: 0 0 10px rgba(26, 26, 26, 0.05); }
            to { box-shadow: 0 0 25px rgba(26, 26, 26, 0.15); }
        }

        .slot-name {
            font-size: 38px;
            font-weight: 800;
            color: #1a1a1a;
            line-height: 1.2;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
            word-break: break-word;
        }

        .slot-details {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .slot-badge {
            background: #ffffff;
            color: #4b5563;
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid #e5e5e5;
        }

        .slot-badge strong {
            color: #1a1a1a;
        }

        .slot-hint {
            color: #6b7280;
            font-size: 15px;
            font-weight: 500;
            margin-top: 8px;
        }

        /* Giant Spin Button */
        .btn-spin {
            background: #1a1a1a;
            color: #ffffff;
            border: none;
            border-radius: 9999px;
            padding: 18px 52px;
            font-family: 'DM Sans', sans-serif;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 24px rgba(26, 26, 26, 0.18);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-spin:hover:not(:disabled) {
            background: #333333;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(26, 26, 26, 0.25);
        }

        .btn-spin:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-spin:disabled {
            background: #e5e5e5;
            color: #9ca3af;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .btn-spin svg {
            width: 24px;
            height: 24px;
            transition: transform 0.6s ease;
        }

        .btn-spin.spinning svg {
            animation: spin-icon 0.8s linear infinite;
        }

        @keyframes spin-icon {
            100% { transform: rotate(360deg); }
        }

        /* ── Right Column: Daftar Pemenang Live ── */
        .stage-sidebar {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
            max-height: calc(100vh - 120px);
            position: sticky;
            top: 88px;
        }

        .sidebar-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }

        .sidebar-header h2 {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .badge-count {
            background: #1a1a1a;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
        }

        .winners-scroll-area {
            flex: 1;
            overflow-y: auto;
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .winner-card {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            transition: all 0.15s ease;
        }

        .winner-card:hover {
            border-color: #1a1a1a;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        .winner-card.newly-added {
            animation: highlight-winner 1s ease;
            border-color: #16a34a;
            background: #f0fdf4;
        }

        @keyframes highlight-winner {
            0% { background: #dcfce7; transform: scale(1.02); }
            100% { background: #f0fdf4; transform: scale(1); }
        }

        .winner-info h4 {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .winner-prize-name {
            font-size: 12px;
            font-weight: 700;
            color: #b45309;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .winner-meta {
            font-size: 12px;
            color: #6b7280;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-delete-winner {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 8px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .btn-delete-winner:hover {
            background: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }

        .empty-winners {
            text-align: center;
            padding: 40px 16px;
            color: #9ca3af;
        }

        .empty-winners svg {
            width: 42px;
            height: 42px;
            stroke: #d1d5db;
            margin-bottom: 10px;
        }

        .sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid #e5e5e5;
            background: #fafafa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ── Fullscreen Canvas Confetti ── */
        #confettiCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }

        /* ── Custom SweetAlert2 Styling ── */
        .swal2-popup {
            font-family: 'DM Sans', sans-serif !important;
            border-radius: 24px !important;
            padding: 32px !important;
            background: #ffffff !important;
            color: #1a1a1a !important;
            border: 1px solid #e5e5e5 !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }
        .swal2-title {
            font-size: 20px !important;
            font-weight: 700 !important;
            color: #1a1a1a !important;
        }
        .swal2-html-container {
            font-size: 14px !important;
            color: #4b5563 !important;
            line-height: 1.6 !important;
        }
        .swal2-confirm {
            border-radius: 9999px !important;
            font-weight: 600 !important;
            padding: 12px 28px !important;
            font-size: 14px !important;
        }
        .swal2-cancel {
            border-radius: 9999px !important;
            font-weight: 600 !important;
            padding: 12px 28px !important;
            font-size: 14px !important;
        }
    </style>
</head>
<body>

    <canvas id="confettiCanvas"></canvas>

    <!-- Topbar Stage -->
    <header class="stage-navbar">
        <a href="<?= site_url('bilik_undian'); ?>" class="stage-brand">
            <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo E-Voting">
            <div>
                <h1>Bilik Undian Door Prize</h1>
                <span>Rapat Anggota Tahunan (RAT) Koperasi</span>
            </div>
        </a>

        <div class="nav-actions">
            <span style="font-size:13px; color:#6b7280; margin-right:4px;">
                Admin: <strong style="color:#1a1a1a;"><?= html_escape($admin_name); ?></strong>
            </span>

            <button type="button" class="btn-nav" id="btnFullscreen" title="Layar Penuh (F11)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                </svg>
                <span>Fullscreen</span>
            </button>

            <a href="<?= site_url('admin'); ?>" class="btn-nav" target="_blank" title="Buka Panel Admin">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
                <span>Panel Admin</span>
            </a>

            <a href="<?= site_url('bilik_undian/logout'); ?>" class="btn-nav danger" id="btnLogoutUndian" title="Kunci Bilik Undian">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
                <span>Kunci Layar</span>
            </a>
        </div>
    </header>

    <!-- Main Stage Container -->
    <main class="stage-container">
        
        <!-- Left Column: Arena Undian -->
        <section class="stage-main">
            <!-- Control Card -->
            <div class="control-card">
                <div class="control-group">
                    <span class="control-label">Nama Hadiah:</span>
                    <input type="text" id="inputHadiah" class="input-hadiah" value="Door Prize Utama" placeholder="Contoh: Sepeda Motor, TV 43 Inch, dll">
                    
                    <select id="quickHadiah" class="select-filter" style="max-width:180px;">
                        <option value="">-- Pilih Preset Hadiah --</option>
                        <option value="Grand Prize: Sepeda Motor">Grand Prize: Sepeda Motor</option>
                        <option value="Hadiah Utama 1: Smart TV 43 Inch">Hadiah Utama: Smart TV 43"</option>
                        <option value="Hadiah Utama 2: Kulkas 2 Pintu">Hadiah Utama: Kulkas 2 Pintu</option>
                        <option value="Door Prize: Sepeda Gunung">Door Prize: Sepeda Gunung</option>
                        <option value="Door Prize: Mesin Cuci">Door Prize: Mesin Cuci</option>
                        <option value="Door Prize: Microwave Oven">Door Prize: Microwave Oven</option>
                        <option value="Door Prize: Air Fryer Digital">Door Prize: Air Fryer Digital</option>
                        <option value="Door Prize: Dispenser Galon Bawah">Door Prize: Dispenser Galon Bawah</option>
                        <option value="Hiburan: Voucher Belanja Rp 500.000">Voucher Belanja Rp 500k</option>
                    </select>
                </div>

                <div class="control-group">
                    <div class="control-group">
                        <span class="control-label">Filter Dept:</span>
                        <select id="filterDept" class="select-filter">
                            <option value="">Semua Departemen</option>
                            <?php foreach ($daftar_dept as $d): ?>
                                <option value="<?= html_escape($d->dept); ?>" <?= ($dept_terpilih === $d->dept) ? 'selected' : ''; ?>>
                                    <?= html_escape($d->dept); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- TOGGLE AUTO VALID (Requirement) -->
                    <div class="toggle-wrapper" title="Aktifkan untuk menyimpan pemenang secara otomatis tanpa dialog kehadiran">
                        <label class="switch-toggle">
                            <input type="checkbox" id="toggleAutoValid" checked>
                            <span class="slider"></span>
                        </label>
                        <span class="toggle-status-text status-on" id="toggleLabel">AUTO VALID: AKTIF</span>
                    </div>
                </div>
            </div>

            <!-- Big Stage Display Arena -->
            <div class="stage-display">
                <!-- Top Prize Badge -->
                <div class="prize-tag" id="displayHadiahBadge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76V14h2V8.76L15.38 12 17 10.83 14.92 8H20v6z"/>
                    </svg>
                    <span id="labelDisplayHadiah">Door Prize Utama</span>
                </div>

                <!-- Central Slot / Winner Showcase -->
                <div class="spinner-arena">
                    <div class="slot-box" id="slotBox">
                        <div class="slot-name" id="slotName">SIAP MENGUNDI</div>
                        <div class="slot-details" id="slotDetails" style="display:none;">
                            <span class="slot-badge">NIK: <strong id="slotNik">-</strong></span>
                            <span class="slot-badge">DEPARTEMEN: <strong id="slotDept">-</strong></span>
                            <span class="slot-badge" id="slotRfidBadge" style="display:none;">RFID: <strong id="slotRfid">-</strong></span>
                        </div>
                        <div class="slot-hint" id="slotHint">
                            Tersedia <strong id="counterPeserta" style="color:#1a1a1a; font-weight:700;"><?= $total_tersisa; ?></strong> peserta berhak undian
                        </div>
                    </div>
                </div>

                <!-- Giant Spin Action Button -->
                <div>
                    <button type="button" class="btn-spin" id="btnSpin">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0020 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 004 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/>
                        </svg>
                        <span id="btnSpinText">PUTAR UNDIAN SEKARANG</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Right Column: Live Winners Panel -->
        <aside class="stage-sidebar">
            <div class="sidebar-header">
                <h2>
                    <span>Daftar Pemenang Sah</span>
                    <span class="badge-count" id="countPemenang"><?= count($daftar_pemenang); ?></span>
                </h2>
                <?php if (!empty($daftar_pemenang)): ?>
                    <button type="button" id="btnResetUndian" class="btn-nav danger" style="padding:4px 10px; font-size:12px;">Reset</button>
                <?php endif; ?>
            </div>

            <div class="winners-scroll-area" id="winnersListContainer">
                <?php if (empty($daftar_pemenang)): ?>
                    <div class="empty-winners" id="emptyWinnersNotice">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                        <p style="font-size:14px; font-weight:600; color:#4b5563;">Belum ada pemenang undian</p>
                        <p style="font-size:12px; margin-top:4px; color:#9ca3af;">Putar undian untuk menentukan pemenang door prize RAT.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($daftar_pemenang as $w): ?>
                        <div class="winner-card" id="card-winner-<?= $w->id; ?>">
                            <div class="winner-info">
                                <div class="winner-prize-name">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2z"/></svg>
                                    <span><?= html_escape($w->nama_hadiah); ?></span>
                                </div>
                                <h4><?= html_escape($w->nama ?: 'Anggota ('.$w->pemilih_nik.')'); ?></h4>
                                <div class="winner-meta">
                                    <span>NIK: <strong><?= html_escape($w->pemilih_nik); ?></strong></span>
                                    <span>&bull;</span>
                                    <span>Dept: <strong><?= html_escape($w->dept ?: '-'); ?></strong></span>
                                    <span>&bull;</span>
                                    <span><?= date('H:i', strtotime($w->created_at)); ?></span>
                                </div>
                            </div>
                            <button type="button" class="btn-delete-winner" onclick="hapusPemenang(<?= $w->id; ?>, '<?= html_escape($w->nama ?: $w->pemilih_nik); ?>')" title="Batalkan Pemenang Ini">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="sidebar-footer">
                <span style="font-size:12px; color:#6b7280;">
                    Total Hadiah Diberikan: <strong style="color:#1a1a1a;" id="footerCount"><?= count($daftar_pemenang); ?></strong>
                </span>
                <a href="<?= site_url('laporan/peserta_undian'); ?>" target="_blank" style="font-size:12px; color:#1a1a1a; text-decoration:none; font-weight:600;">
                    Laporan Undian ↗
                </a>
            </div>
        </aside>
    </main>

    <!-- SweetAlert2 Scripts -->
    <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

    <!-- Lightweight Pure HTML5 Canvas Confetti Engine (No CDN Needed) -->
    <script>
    var ConfettiEngine = (function() {
        var canvas = document.getElementById('confettiCanvas');
        var ctx = canvas.getContext('2d');
        var particles = [];
        var animationId = null;
        var colors = ['#f59e0b', '#ef4444', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#fde047', '#06b6d4'];

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        function createParticle() {
            return {
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height * 0.3 - 50,
                w: Math.random() * 12 + 6,
                h: Math.random() * 8 + 4,
                color: colors[Math.floor(Math.random() * colors.length)],
                vx: (Math.random() - 0.5) * 6,
                vy: Math.random() * 4 + 3,
                rotation: Math.random() * 360,
                vRot: (Math.random() - 0.5) * 10,
                opacity: 1
            };
        }

        function render() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            var alive = false;

            for (var i = 0; i < particles.length; i++) {
                var p = particles[i];
                p.x += p.vx;
                p.y += p.vy;
                p.rotation += p.vRot;
                p.vy += 0.08; // gravity

                if (p.y > canvas.height - 50) {
                    p.opacity -= 0.02;
                }

                if (p.opacity > 0) {
                    alive = true;
                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate((p.rotation * Math.PI) / 180);
                    ctx.globalAlpha = p.opacity;
                    ctx.fillStyle = p.color;
                    ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
                    ctx.restore();
                }
            }

            if (alive) {
                animationId = requestAnimationFrame(render);
            } else {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles = [];
                animationId = null;
            }
        }

        return {
            blast: function(count) {
                count = count || 120;
                resize();
                for (var i = 0; i < count; i++) {
                    particles.push(createParticle());
                }
                if (!animationId) {
                    render();
                }
            }
        };
    })();
    </script>

    <!-- Stage Undian Logic & Interactions -->
    <script>
    var isSpinning = false;
    var acakUrl = "<?= site_url('bilik_undian/acak_ajax'); ?>";
    var simpanUrl = "<?= site_url('bilik_undian/simpan_pemenang_ajax'); ?>";
    var hapusUrl = "<?= site_url('bilik_undian/hapus_pemenang_ajax/'); ?>";
    var resetUrl = "<?= site_url('bilik_undian/reset_semua'); ?>";

    var inputHadiah = document.getElementById('inputHadiah');
    var quickHadiah = document.getElementById('quickHadiah');
    var filterDept = document.getElementById('filterDept');
    var toggleAutoValid = document.getElementById('toggleAutoValid');
    var toggleLabel = document.getElementById('toggleLabel');
    var labelDisplayHadiah = document.getElementById('labelDisplayHadiah');

    var btnSpin = document.getElementById('btnSpin');
    var btnSpinText = document.getElementById('btnSpinText');
    var slotBox = document.getElementById('slotBox');
    var slotName = document.getElementById('slotName');
    var slotDetails = document.getElementById('slotDetails');
    var slotNik = document.getElementById('slotNik');
    var slotDept = document.getElementById('slotDept');
    var slotRfid = document.getElementById('slotRfid');
    var slotRfidBadge = document.getElementById('slotRfidBadge');
    var slotHint = document.getElementById('slotHint');
    var counterPeserta = document.getElementById('counterPeserta');

    var countPemenang = document.getElementById('countPemenang');
    var footerCount = document.getElementById('footerCount');
    var winnersListContainer = document.getElementById('winnersListContainer');
    var emptyWinnersNotice = document.getElementById('emptyWinnersNotice');

    // ── Synchronize Hadiah Input & Preset ──
    quickHadiah.addEventListener('change', function() {
        if (this.value) {
            inputHadiah.value = this.value;
            labelDisplayHadiah.textContent = this.value;
        }
    });

    inputHadiah.addEventListener('input', function() {
        labelDisplayHadiah.textContent = this.value.trim() || 'Door Prize Utama';
    });

    // ── Filter Departemen Change ──
    filterDept.addEventListener('change', function() {
        var dept = encodeURIComponent(this.value);
        window.location.href = "<?= site_url('bilik_undian'); ?>?dept=" + dept;
    });

    // ── Toggle Auto-Valid Switch ──
    toggleAutoValid.addEventListener('change', function() {
        if (this.checked) {
            toggleLabel.textContent = 'AUTO VALID: AKTIF';
            toggleLabel.className = 'toggle-status-text status-on';
        } else {
            toggleLabel.textContent = 'AUTO VALID: NONAKTIF';
            toggleLabel.className = 'toggle-status-text status-off';
        }
    });

    // ── Fullscreen Toggle ──
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

    // ── Logout / Lock Screen Confirmation ──
    document.getElementById('btnLogoutUndian').addEventListener('click', function(e) {
        e.preventDefault();
        var href = this.getAttribute('href');
        Swal.fire({
            title: 'Kunci Bilik Undian?',
            text: 'Layar undian akan dikunci dan memerlukan password admin untuk dibuka kembali.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a1a1a',
            cancelButtonColor: '#e5e5e5',
            confirmButtonText: 'Ya, Kunci Layar',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
    });

    // ── Reset All Winners Confirmation ──
    var btnResetUndian = document.getElementById('btnResetUndian');
    if (btnResetUndian) {
        btnResetUndian.addEventListener('click', function() {
            Swal.fire({
                title: 'Reset Seluruh Undian?',
                text: 'Semua pemenang undian yang tercatat akan dihapus dan peserta dapat diundi kembali. Tindakan ini tidak dapat dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#e5e5e5',
                confirmButtonText: 'Ya, Reset Semua',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = resetUrl;
                }
            });
        });
    }

    // ── Delete Single Winner ──
    window.hapusPemenang = function(id, nama) {
        Swal.fire({
            title: 'Batalkan Pemenang?',
            html: 'Batalkan kemenangan untuk <b>' + nama + '</b>? Anggota ini akan kembali ke daftar peserta yang berhak diundi.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#e5e5e5',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Kembali'
        }).then(function(result) {
            if (result.isConfirmed) {
                fetch(hapusUrl + id, { method: 'POST' })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data.status === 'success') {
                            var card = document.getElementById('card-winner-' + id);
                            if (card) {
                                card.remove();
                            }
                            var currentTotal = parseInt(countPemenang.textContent, 10) - 1;
                            countPemenang.textContent = currentTotal;
                            footerCount.textContent = currentTotal;
                            
                            var currentSisa = parseInt(counterPeserta.textContent, 10) + 1;
                            counterPeserta.textContent = currentSisa;

                            Swal.fire({
                                icon: 'success',
                                title: 'Dibatalkan',
                                text: 'Pemenang berhasil dibatalkan dan dikembalikan ke pool peserta.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                        }
                    })
                    .catch(function(err) {
                        console.error(err);
                        Swal.fire({ icon: 'error', title: 'Error Jaringan', text: 'Terjadi kesalahan sistem.' });
                    });
            }
        });
    };

    // ── SPINNING WHEEL / SLOT ENGINE ──
    btnSpin.addEventListener('click', function() {
        if (isSpinning) return;

        var hadiah = inputHadiah.value.trim() || 'Door Prize Utama';
        var dept = filterDept.value;
        var isAutoValid = toggleAutoValid.checked;

        // Cek sisa peserta
        var sisaNow = parseInt(counterPeserta.textContent, 10);
        if (sisaNow <= 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tidak Ada Peserta Tersisa',
                text: 'Seluruh peserta yang memenuhi syarat telah memenangkan undian.',
                confirmButtonColor: '#1a1a1a'
            });
            return;
        }

        // Start UI Spinning State
        isSpinning = true;
        btnSpin.disabled = true;
        btnSpin.classList.add('spinning');
        btnSpinText.textContent = 'MENGACAK PEMENANG...';
        slotBox.className = 'slot-box spinning';
        slotDetails.style.display = 'none';
        slotHint.style.display = 'none';

        // Panggil server untuk mengacak calon pemenang
        fetch(acakUrl + '?dept=' + encodeURIComponent(dept))
            .then(function(res) { return res.json(); })
            .then(function(response) {
                if (response.status !== 'success') {
                    isSpinning = false;
                    btnSpin.disabled = false;
                    btnSpin.classList.remove('spinning');
                    btnSpinText.textContent = 'PUTAR UNDIAN SEKARANG';
                    slotBox.className = 'slot-box';
                    slotHint.style.display = 'block';

                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: response.message,
                        confirmButtonColor: '#1a1a1a'
                    });
                    return;
                }

                var winner = response.data;
                var pool = response.pool || [];

                // Visual Rolling Animation (Rapid slot deceleration effect for 3.2 seconds)
                var duration = 3200;
                var startTime = performance.now();

                function rollFrame(currentTime) {
                    var elapsed = currentTime - startTime;
                    var progress = Math.min(elapsed / duration, 1);

                    // Ambil nama acak dari pool untuk ilusi perputaran cepat
                    if (pool.length > 0) {
                        var randomCandidate = pool[Math.floor(Math.random() * pool.length)];
                        slotName.textContent = randomCandidate.nama.toUpperCase();
                    } else {
                        slotName.textContent = 'ACAK PESERTA...';
                    }

                    if (progress < 1) {
                        requestAnimationFrame(rollFrame);
                    } else {
                        // Putaran Selesai! Tampilkan Pemenang
                        revealWinner(winner, hadiah, isAutoValid, dept);
                    }
                }

                requestAnimationFrame(rollFrame);
            })
            .catch(function(err) {
                console.error(err);
                isSpinning = false;
                btnSpin.disabled = false;
                btnSpin.classList.remove('spinning');
                btnSpinText.textContent = 'PUTAR UNDIAN SEKARANG';
                slotBox.className = 'slot-box';
                slotHint.style.display = 'block';

                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Tidak dapat menghubungi server untuk mengacak undian.',
                    confirmButtonColor: '#1a1a1a'
                });
            });
    });

    // ── Reveal Winner Logic ──
    function revealWinner(winner, hadiah, isAutoValid, dept) {
        slotName.textContent = winner.nama.toUpperCase();
        slotNik.textContent = winner.nik;
        slotDept.textContent = winner.dept || '-';
        if (winner.rfid) {
            slotRfid.textContent = winner.rfid;
            slotRfidBadge.style.display = 'inline-block';
        } else {
            slotRfidBadge.style.display = 'none';
        }

        slotDetails.style.display = 'flex';
        slotBox.className = 'slot-box winner-revealed';
        btnSpin.classList.remove('spinning');

        // Check Auto-Valid toggle setting
        if (isAutoValid) {
            // Mode Auto Valid: Langsung Sah & Simpan
            saveWinnerDirectly(winner, hadiah, dept);
        } else {
            // Mode Disable Auto Valid: Wajib Pop-up Konfirmasi Valid / Tidak
            promptValidationPopup(winner, hadiah, dept);
        }
    }

    // ── Auto Valid: Save directly with celebration ──
    function saveWinnerDirectly(winner, hadiah, dept) {
        var formData = new FormData();
        formData.append('nik', winner.nik);
        formData.append('nama_hadiah', hadiah);
        formData.append('status', 'valid');
        formData.append('dept', dept);

        fetch(simpanUrl, {
            method: 'POST',
            body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            isSpinning = false;
            btnSpin.disabled = false;
            btnSpinText.textContent = 'PUTAR UNDIAN BERIKUTNYA';

            if (data.status === 'success') {
                ConfettiEngine.blast(160);
                addWinnerToSidebar(winner, hadiah);
                counterPeserta.textContent = data.sisa_peserta;
                slotHint.innerHTML = 'Selamat! Pemenang <strong>' + hadiah + '</strong> telah disahkan otomatis.';
                slotHint.style.display = 'block';

                Swal.fire({
                    icon: 'success',
                    title: 'Selamat Kepada Pemenang!',
                    html: '<div style="font-size:18px; font-weight:700; color:#1a1a1a; margin:10px 0;">' + winner.nama + '</div>' +
                          '<div style="font-size:14px; color:#6b7280; margin-bottom:12px;">NIK: ' + winner.nik + ' &bull; Dept: ' + (winner.dept || '-') + '</div>' +
                          '<div style="padding:10px 16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; color:#15803d; font-weight:700;">' + hadiah + '</div>' +
                          '<p style="font-size:13px; color:#6b7280; margin-top:14px;">(Status: Sah Otomatis & Terdata)</p>',
                    confirmButtonColor: '#1a1a1a',
                    confirmButtonText: 'Selesai & Lanjutkan'
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal Menyimpan', text: data.message });
            }
        })
        .catch(function(err) {
            console.error(err);
            isSpinning = false;
            btnSpin.disabled = false;
            btnSpinText.textContent = 'PUTAR UNDIAN SEKARANG';
        });
    }

    // ── Manual Valid: Pop-up Confirmation (Requirement: popup undian valid/tidak) ──
    function promptValidationPopup(winner, hadiah, dept) {
        Swal.fire({
            title: 'Konfirmasi Kehadiran Pemenang',
            html: '<div style="margin-top:12px;">' +
                    '<div style="font-size:22px; font-weight:800; color:#1a1a1a; margin-bottom:6px;">' + winner.nama + '</div>' +
                    '<div style="font-size:14px; color:#6b7280; margin-bottom:16px;">NIK: <b>' + winner.nik + '</b> &bull; Departemen: <b>' + (winner.dept || '-') + '</b></div>' +
                    '<div style="padding:12px 18px; background:#fef3c7; border:1px solid #fde68a; border-radius:12px; color:#b45309; font-weight:700; margin-bottom:18px;">' +
                        'Hadiah: ' + hadiah +
                    '</div>' +
                    '<div style="font-size:15px; font-weight:600; color:#1a1a1a;">Apakah anggota yang bersangkutan hadir di ruangan RAT?</div>' +
                  '</div>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a', // Green
            cancelButtonColor: '#dc2626',  // Red
            confirmButtonText: '✓ VALID (Hadir & Sah)',
            cancelButtonText: '✕ TIDAK VALID (Hangus / Undi Ulang)',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(function(result) {
            if (result.isConfirmed) {
                // User memilih VALID / HADIR
                var formData = new FormData();
                formData.append('nik', winner.nik);
                formData.append('nama_hadiah', hadiah);
                formData.append('status', 'valid');
                formData.append('dept', dept);

                fetch(simpanUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    isSpinning = false;
                    btnSpin.disabled = false;
                    btnSpinText.textContent = 'PUTAR UNDIAN BERIKUTNYA';

                    if (data.status === 'success') {
                        ConfettiEngine.blast(180);
                        addWinnerToSidebar(winner, hadiah);
                        counterPeserta.textContent = data.sisa_peserta;
                        slotHint.innerHTML = 'Pemenang <strong>' + winner.nama + '</strong> dinyatakan SAH dan HADIR.';
                        slotHint.style.display = 'block';

                        Swal.fire({
                            icon: 'success',
                            title: 'Undian Sah & Diterima!',
                            text: 'Data pemenang ' + winner.nama + ' berhasil disimpan permanen.',
                            confirmButtonColor: '#1a1a1a',
                            timer: 2000
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // User memilih TIDAK VALID / HANGUS
                isSpinning = false;
                btnSpin.disabled = false;
                btnSpinText.textContent = 'PUTAR ULANG UNDIAN';
                slotBox.className = 'slot-box';
                slotHint.innerHTML = '<span style="color:#dc2626; font-weight:600;">Undian Dibatalkan (Tidak Hadir). Silakan klik putar ulang.</span>';
                slotHint.style.display = 'block';

                Swal.fire({
                    icon: 'warning',
                    title: 'Undian Dibatalkan / Hangus',
                    html: 'Peserta <b>' + winner.nama + '</b> dinyatakan tidak hadir/tidak valid.<br>Hadiah <b>' + hadiah + '</b> tetap tersedia untuk diundi kembali.',
                    confirmButtonColor: '#1a1a1a',
                    confirmButtonText: 'Siap Undi Ulang'
                });
            }
        });
    }

    // ── Dynamic DOM Add Winner to Sidebar ──
    function addWinnerToSidebar(winner, hadiah) {
        if (emptyWinnersNotice) {
            emptyWinnersNotice.remove();
        }

        var total = parseInt(countPemenang.textContent, 10) + 1;
        countPemenang.textContent = total;
        footerCount.textContent = total;

        var now = new Date();
        var timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

        var card = document.createElement('div');
        card.className = 'winner-card newly-added';
        card.innerHTML = 
            '<div class="winner-info">' +
                '<div class="winner-prize-name">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2z"/></svg>' +
                    '<span>' + hadiah + '</span>' +
                '</div>' +
                '<h4>' + winner.nama + '</h4>' +
                '<div class="winner-meta">' +
                    '<span>NIK: <strong>' + winner.nik + '</strong></span>' +
                    '<span>&bull;</span>' +
                    '<span>Dept: <strong>' + (winner.dept || '-') + '</strong></span>' +
                    '<span>&bull;</span>' +
                    '<span>' + timeStr + '</span>' +
                '</div>' +
            '</div>';

        // Prepend to top of winners list
        winnersListContainer.insertBefore(card, winnersListContainer.firstChild);
    }
    </script>
</body>
</html>
