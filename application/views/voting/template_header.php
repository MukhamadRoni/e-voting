<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#f8f9fa">
    <title><?= $title; ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/img/favicon.svg'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.css'); ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        /* ── Mencegah Glitch Hitam Saat Fullscreen & Modal di Tablet ── */
        html,
        body {
            background-color: #f8f9fa !important;
            background: #f8f9fa !important;
            min-height: 100%;
            width: 100%;
        }

        :fullscreen,
        ::backdrop,
        :fullscreen::backdrop,
        :-webkit-full-screen,
        :-webkit-full-screen::backdrop,
        :-moz-full-screen,
        :-moz-full-screen::backdrop,
        :-ms-fullscreen,
        :-ms-fullscreen::backdrop {
            background-color: #f8f9fa !important;
            background: #f8f9fa !important;
        }

        /* Mencegah layer collapse & black glitch saat SweetAlert2 muncul di tablet fullscreen */
        html.swal2-shown,
        body.swal2-shown,
        html.swal2-height-auto,
        body.swal2-height-auto {
            height: 100% !important;
            min-height: 100% !important;
            background-color: #f8f9fa !important;
            background: #f8f9fa !important;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: #1a1a1a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Topbar Kiosk ── */
        .kiosk-navbar {
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

        .kiosk-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1a1a1a;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: #1a1a1a;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 16px;
        }

        .kiosk-brand h1 {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.2;
        }

        .kiosk-brand span {
            font-size: 12px;
            color: #6b7280;
            display: block;
        }

        /* Stepper */
        .stepper {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #9ca3af;
        }

        .step-item.active {
            color: #1a1a1a;
            font-weight: 700;
        }

        .step-item.done {
            color: #15803d;
        }

        .step-circle {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            background: #f0f0f0;
            color: #6b7280;
        }

        .step-item.active .step-circle {
            background: #1a1a1a;
            color: #ffffff;
        }

        .step-item.done .step-circle {
            background: #dcfce7;
            color: #15803d;
        }

        .voter-badge-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f5f5f7;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
        }

        .btn-cancel-voter {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
            font-size: 12px;
            margin-left: 6px;
            padding: 2px 8px;
            border-radius: 6px;
            background: rgba(220, 38, 38, 0.08);
            transition: background 0.15s ease;
        }

        .btn-cancel-voter:hover {
            background: rgba(220, 38, 38, 0.15);
        }

        /* ── Fullscreen Toggle & Navbar Actions ── */
        .kiosk-navbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-kiosk-fullscreen {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 15px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            color: #1a1a1a;
            background: #ffffff;
            border: 1px solid #e5e5e5;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            user-select: none;
            outline: none;
        }

        .btn-kiosk-fullscreen:hover {
            background: #f5f5f7;
            border-color: #d1d5db;
            transform: translateY(-1px);
        }

        .btn-kiosk-fullscreen:active {
            transform: translateY(0) scale(0.98);
        }

        .btn-kiosk-fullscreen.is-active {
            background: #1a1a1a;
            color: #ffffff;
            border-color: #1a1a1a;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }

        .btn-kiosk-fullscreen.is-active svg {
            stroke: #ffffff;
        }

        .btn-link-admin {
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .btn-link-admin:hover {
            color: #1a1a1a;
            background: #f5f5f7;
        }

        /* ── Floating Resume Fullscreen Banner (Tablet / Kiosk) ── */
        .kiosk-fs-prompt {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: #1a1a1a;
            color: #ffffff;
            padding: 10px 22px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            z-index: 99999;
            cursor: pointer;
            animation: pulseFsBanner 2.2s infinite ease-in-out;
            user-select: none;
            white-space: nowrap;
        }

        .kiosk-fs-prompt svg {
            stroke: #ffffff;
            flex-shrink: 0;
        }

        @keyframes pulseFsBanner {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-4px); }
        }

        /* Main Container */
        .main-container {
            flex: 1;
            padding: 32px 24px 100px;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .kiosk-navbar {
                padding: 0 16px;
                height: 58px;
            }
            .kiosk-brand h1 {
                font-size: 15px;
            }
            .kiosk-brand span {
                display: none;
            }
            .stepper .step-item span {
                display: none;
            }
            .voter-badge-pill {
                padding: 4px 10px;
                font-size: 12px;
            }
            .kiosk-navbar-actions {
                gap: 8px;
            }
            .btn-kiosk-fullscreen {
                padding: 6px 10px;
            }
            .btn-kiosk-fullscreen span {
                display: none;
            }
            .btn-link-admin {
                font-size: 12px;
                padding: 4px 8px;
            }
            .main-container {
                padding: 20px 14px 100px;
            }
        }

        /* Buttons & Alerts */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 9999px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .btn-primary {
            background: #1a1a1a;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #333333;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #ffffff;
            color: #1a1a1a;
            border: 1px solid #e5e5e5;
        }

        .btn-secondary:hover {
            background: #f5f5f7;
        }

        .btn-success {
            background: #16a34a;
            color: #ffffff;
        }

        .btn-success:hover {
            background: #15803d;
        }

        .alert {
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>
<body>

<header class="kiosk-navbar">
    <a href="<?= site_url('voting'); ?>" class="kiosk-brand">
        <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo" style="width:36px; height:36px; border-radius:10px;">
        <div>
            <h1>E-Voting Koperasi</h1>
            <span>Bilik Suara Digital</span>
        </div>
    </a>

    <div id="kioskStepperContainer">
    <?php if (isset($step)): ?>
        <div class="stepper">
            <div class="step-item <?= ($step == 1) ? 'active' : 'done'; ?>">
                <div class="step-circle"><?= ($step > 1) ? '✓' : '1'; ?></div>
                <span>Pilih Ketua & Pengawas</span>
            </div>
            <span style="color:#d1d5db;">→</span>
            <div class="step-item <?= ($step == 2) ? 'active' : ''; ?>">
                <div class="step-circle"><?= ($step == 2) ? '✓' : '2'; ?></div>
                <span>Selesai</span>
            </div>
        </div>
    <?php endif; ?>
    </div>

    <div class="kiosk-navbar-actions">
        <button type="button" class="btn-kiosk-fullscreen" id="btnFullscreen" title="Layar Penuh (F11)">
            <svg class="fs-icon-enter" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
            </svg>
            <svg class="fs-icon-exit" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"></path>
            </svg>
            <span>Fullscreen</span>
        </button>

        <div id="kioskVoterBadgeContainer">
        <?php if (isset($voter)): ?>
            <div class="voter-badge-pill">
                <span>Pemilih: <strong><?= html_escape($voter['nama']); ?></strong> (<?= html_escape($voter['dept']); ?>)</span>
                <a href="<?= site_url('voting/batal'); ?>" class="btn-cancel-voter" onclick="return confirm('Batalkan sesi pemilih ini?');">Batal</a>
            </div>
        <?php else: ?>
            <a href="<?= site_url('auth'); ?>" class="btn-link-admin">Panel Admin →</a>
        <?php endif; ?>
        </div>
    </div>
</header>

<div id="kioskFsPrompt" class="kiosk-fs-prompt" title="Ketuk untuk masuk ke mode layar penuh">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
    </svg>
    <span>Mode Kiosk: Ketuk layar untuk Layar Penuh ⛶</span>
</div>

<main class="main-container" id="votingMainContainer">
