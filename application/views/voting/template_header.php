<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/img/favicon.svg'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    <div>
        <?php if (isset($voter)): ?>
            <div class="voter-badge-pill">
                <span>Pemilih: <strong><?= html_escape($voter['nama']); ?></strong> (<?= html_escape($voter['dept']); ?>)</span>
                <a href="<?= site_url('voting/batal'); ?>" class="btn-cancel-voter" onclick="return confirm('Batalkan sesi pemilih ini?');">Batal</a>
            </div>
        <?php else: ?>
            <a href="<?= site_url('auth'); ?>" style="font-size:13px; color:#6b7280; text-decoration:none;">Panel Admin →</a>
        <?php endif; ?>
    </div>
</header>

<main class="main-container">
