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
            background-color: #f5f5f7;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 32px;
            border: 1px solid #e5e5e5;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header .brand-icon {
            width: 56px;
            height: 56px;
            background: #1a1a1a;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .login-header .brand-icon svg {
            width: 28px;
            height: 28px;
            fill: #ffffff;
        }

        .login-header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.3;
            margin-bottom: 4px;
        }

        .login-header p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            font-size: 14px;
            padding: 12px 16px;
            border-radius: 9999px;
            margin-bottom: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            height: 44px;
            padding: 0 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: #1a1a1a;
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .form-group input:focus {
            border: 2px solid #1a1a1a;
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        .form-group .error-text {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn-login {
            width: 100%;
            height: 44px;
            background: #1a1a1a;
            color: #ffffff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 9999px;
            cursor: pointer;
            transition: background 0.15s ease;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: #333333;
        }

        .btn-login:active {
            background: #4a4a4a;
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div style="margin: 0 auto 16px; width: 64px; height: 64px;">
                    <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo" style="width:64px; height:64px; border-radius:16px;">
                </div>
                <h1>E-Voting Koperasi</h1>
                <p>Masuk ke panel admin</p>
            </div>

            <?= form_open('auth/process'); ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan username" value="<?= set_value('username'); ?>" autofocus>
                    <?= form_error('username', '<p class="error-text">', '</p>'); ?>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password">
                    <?= form_error('password', '<p class="error-text">', '</p>'); ?>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            <?= form_close(); ?>
        </div>

        <p class="footer-text">© <?= date('Y'); ?> E-Voting Koperasi</p>
    </div>

    <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
    <script>
    <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Masuk',
            html: <?= json_encode($this->session->flashdata('error')); ?>,
            confirmButtonColor: '#1a1a1a',
            confirmButtonText: 'Coba Lagi',
            customClass: {
                popup: 'swal2-custom-popup',
                confirmButton: 'swal2-confirm-pill'
            }
        });
    <?php endif; ?>
    </script>
</body>
</html>
