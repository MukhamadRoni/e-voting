<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($title); ?></title>
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
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            background: #ffffff;
            color: #1a1a1a;
            width: 100%;
            max-width: 440px;
            border-radius: 24px;
            padding: 44px 36px;
            border: 1px solid #e5e5e5;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            position: relative;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-logo-wrap {
            width: 68px;
            height: 68px;
            background: #f5f5f7;
            border: 1px solid #e5e5e5;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .brand-logo-wrap img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            border-radius: 10px;
        }

        .brand-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .brand-header p {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .badge-security {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f5f5f7;
            color: #4b5563;
            padding: 5px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper svg {
            position: absolute;
            left: 14px;
            width: 18px;
            height: 18px;
            fill: #9ca3af;
            pointer-events: none;
        }

        .input-wrapper input {
            width: 100%;
            height: 48px;
            padding: 0 16px 0 44px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: #1a1a1a;
            background: #ffffff;
            border: 1.5px solid #e5e5e5;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s ease;
        }

        .input-wrapper input:focus {
            background: #ffffff;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.08);
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            background: #1a1a1a;
            color: #ffffff;
            border: none;
            border-radius: 9999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
            transition: all 0.15s ease;
        }

        .btn-submit:hover {
            background: #333333;
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .auth-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .auth-footer a {
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .auth-footer a:hover {
            color: #1a1a1a;
        }

        /* ── SweetAlert2 Custom Styling ── */
        .swal2-popup {
            font-family: 'DM Sans', sans-serif !important;
            border-radius: 24px !important;
            padding: 32px !important;
            border: 1px solid #e5e5e5 !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
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
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="brand-header">
            <div class="brand-logo-wrap">
                <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo E-Voting">
            </div>
            <h1>Bilik Undian Door Prize</h1>
            <p>Otorisasi Administrator diwajibkan untuk mengoperasikan panggung undian RAT Koperasi</p>
        </div>

        <div style="text-align: center;">
            <div class="badge-security">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
                <span>Akses Khusus Admin Terverifikasi</span>
            </div>
        </div>

        <form action="<?= site_url('bilik_undian/auth_proses'); ?>" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="username">Username Admin</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    <input type="text" id="username" name="username" placeholder="Masukkan username admin" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password Admin</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <span>Buka Bilik Undian</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5 13h11.86l-5.43 5.43 1.42 1.42L21.14 12l-8.29-8.29-1.42 1.42 5.43 5.43H5v2.44z"/>
                </svg>
            </button>
        </form>

        <div class="auth-footer">
            <a href="<?= site_url('admin'); ?>">← Panel Dashboard</a>
            <a href="<?= site_url('voting'); ?>" target="_blank">Bilik Suara ↗</a>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
    <script>
    <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Otentikasi Gagal',
            text: <?= json_encode($this->session->flashdata('error')); ?>,
            confirmButtonColor: '#1a1a1a',
            confirmButtonText: 'Coba Lagi'
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: <?= json_encode($this->session->flashdata('success')); ?>,
            confirmButtonColor: '#1a1a1a',
            confirmButtonText: 'Lanjutkan'
        });
    <?php endif; ?>
    </script>
</body>
</html>
