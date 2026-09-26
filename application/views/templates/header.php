<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/img/favicon.svg'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/datatables/dataTables.min.css'); ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ── Modern Apple-inspired DataTables Styling ── */
        .dataTables_wrapper {
            font-family: 'DM Sans', sans-serif;
            color: #1a1a1a;
            padding: 4px 0;
        }
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 16px;
            font-size: 13px;
            color: #4b5563;
        }
        .dataTables_wrapper .dataTables_length select {
            padding: 6px 14px;
            border: 1px solid #e5e5e5;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #ffffff;
            outline: none;
            margin: 0 6px;
            cursor: pointer;
            transition: border-color 0.15s ease;
        }
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #1a1a1a;
        }
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 16px;
            font-size: 13px;
            color: #4b5563;
        }
        .dataTables_wrapper .dataTables_filter input {
            padding: 8px 16px;
            border: 1px solid #e5e5e5;
            border-radius: 9999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #ffffff;
            outline: none;
            margin-left: 8px;
            min-width: 250px;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26,26,26,0.08);
        }
        table.dataTable {
            border-collapse: collapse !important;
            margin: 12px 0 16px !important;
            border-top: none !important;
            border-bottom: 1px solid #f0f0f0 !important;
        }
        table.dataTable thead th {
            border-bottom: 1px solid #e5e5e5 !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            color: #6b7280 !important;
            background: #f8fafc !important;
            padding: 14px 16px !important;
        }
        table.dataTable thead th.sorting:after,
        table.dataTable thead th.sorting_asc:after,
        table.dataTable thead th.sorting_desc:after {
            opacity: 0.4 !important;
        }
        table.dataTable tbody td {
            padding: 14px 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 14px !important;
            vertical-align: middle;
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid #f1f5f9 !important;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 13px;
            color: #64748b;
            padding-top: 18px;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
            justify-content: flex-end;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 9999px !important;
            padding: 6px 14px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            border: 1px solid #e5e5e5 !important;
            background: #ffffff !important;
            color: #1a1a1a !important;
            transition: all 0.15s ease !important;
            margin: 0 2px !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) {
            background: #f5f5f7 !important;
            border-color: #d1d5db !important;
            color: #1a1a1a !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #1a1a1a !important;
            border-color: #1a1a1a !important;
            color: #ffffff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            color: #9ca3af !important;
            border-color: #f1f5f9 !important;
            background: #f8fafc !important;
            cursor: not-allowed !important;
            opacity: 0.6;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f5f5f7;
            color: #1a1a1a;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background: #1a1a1a;
            padding: 24px 0;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar .brand {
            padding: 0 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 16px;
        }

        .sidebar .brand h2 {
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
        }

        .sidebar .brand span {
            font-size: 12px;
            color: #9ca3af;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 12px;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            font-size: 14px;
            font-weight: 400;
            color: #9ca3af;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 2px;
            transition: all 0.15s ease;
        }

        .sidebar-nav li a:hover,
        .sidebar-nav li a.active {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
            font-weight: 500;
        }

        .sidebar-nav li a svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-section {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 12px 8px;
        }

        /* ── Top Bar ── */
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
        }

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e5e5;
            padding: 0 32px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar .page-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar .user-info span {
            font-size: 14px;
            color: #6b7280;
        }

        .topbar .user-info strong {
            color: #1a1a1a;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 9999px;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .btn-logout:hover {
            background: #f5f5f7;
        }

        /* ── Content Area ── */
        .content-area {
            padding: 32px;
        }

        /* ── Card ── */
        .card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 600;
        }

        /* ── Table ── */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            background: #f5f5f7;
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
            text-align: left;
            padding: 12px 16px;
        }

        table thead th:first-child {
            border-radius: 8px 0 0 8px;
        }

        table thead th:last-child {
            border-radius: 0 8px 8px 0;
        }

        table tbody td {
            font-size: 14px;
            color: #1a1a1a;
            padding: 14px 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 9999px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s ease;
            line-height: 1.4;
        }

        .btn-primary {
            background: #1a1a1a;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #333333;
        }

        .btn-secondary {
            background: #ffffff;
            color: #1a1a1a;
            border: 1px solid #e5e5e5;
        }

        .btn-secondary:hover {
            background: #f5f5f7;
        }

        .btn-danger {
            background: #dc2626;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
        }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px;
        }

        .badge-success {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-warning {
            background: #fef9c3;
            color: #a16207;
        }

        /* ── Alert ── */
        .alert {
            padding: 12px 20px;
            border-radius: 9999px;
            font-size: 14px;
            margin-bottom: 24px;
            text-align: center;
        }

        .alert-success {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* ── Form ── */
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

        .form-group input,
        .form-group select,
        .form-group textarea {
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

        .form-group textarea {
            height: 120px;
            padding: 12px 16px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border: 2px solid #1a1a1a;
        }

        .form-group .error-text {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        /* ── Stats Cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 16px;
            padding: 24px;
        }

        .stat-card .stat-value {
            font-size: 32px;
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="brand" style="display:flex; align-items:center; gap:12px;">
        <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo" style="width:36px; height:36px; border-radius:10px; flex-shrink:0;">
        <div>
            <h2>E-Voting</h2>
            <span>Panel Admin</span>
        </div>
    </div>

    <ul class="sidebar-nav">
        <li>
            <a href="<?= site_url('admin'); ?>" class="<?= ($this->uri->segment(1) == 'admin' && !$this->uri->segment(2)) ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                Dashboard
            </a>
        </li>

        <li class="nav-section">Master Data</li>
        <li>
            <a href="<?= site_url('master_user'); ?>" class="<?= ($this->uri->segment(1) == 'master_user') ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                Data Pemilih
            </a>
        </li>
        <li>
            <a href="<?= site_url('master_kandidat'); ?>" class="<?= ($this->uri->segment(1) == 'master_kandidat') ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                Data Kandidat
            </a>
        </li>

        <li class="nav-section">Laporan</li>
        <li>
            <a href="<?= site_url('laporan/pemenang_ketua'); ?>" class="<?= ($this->uri->segment(2) == 'pemenang_ketua') ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2z"/></svg>
                Pemenang Ketua
            </a>
        </li>
        <li>
            <a href="<?= site_url('laporan/pemenang_pengawas'); ?>" class="<?= ($this->uri->segment(2) == 'pemenang_pengawas') ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2z"/></svg>
                Pemenang Pengawas
            </a>
        </li>
        <li>
            <a href="<?= site_url('laporan/trace_back'); ?>" class="<?= ($this->uri->segment(2) == 'trace_back') ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                Trace Back
            </a>
        </li>
        <li>
            <a href="<?= site_url('laporan/peserta_undian'); ?>" class="<?= ($this->uri->segment(2) == 'peserta_undian') ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2z"/></svg>
                Peserta Undian
            </a>
        </li>
        <li class="nav-section">Bilik & Panggung</li>
        <li>
            <a href="<?= site_url('voting'); ?>" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                Buka Bilik Suara ↗
            </a>
        </li>
        <li>
            <a href="<?= site_url('bilik_undian'); ?>" target="_blank" class="<?= ($this->uri->segment(1) == 'bilik_undian') ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2z"/></svg>
                Buka Bilik Undian ↗
            </a>
        </li>
        <li>
            <a href="<?= site_url('real_count'); ?>" target="_blank" class="<?= ($this->uri->segment(1) == 'real_count') ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                Real Count 3D ↗
            </a>
        </li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Bar -->
    <div class="topbar">
        <span class="page-title"><?= $title; ?></span>
        <div class="user-info">
            <span>Halo, <strong><?= $username; ?></strong></span>
            <a href="<?= site_url('real_count'); ?>" target="_blank" class="btn-logout" style="background:#4f46e5; color:#ffffff; border-color:#4f46e5;">Real Count 3D ↗</a>
            <a href="<?= site_url('bilik_undian'); ?>" target="_blank" class="btn-logout" style="background:#f59e0b; color:#ffffff; border-color:#f59e0b;">Bilik Undian ↗</a>
            <a href="<?= site_url('voting'); ?>" target="_blank" class="btn-logout" style="background:#1a1a1a; color:#ffffff; border-color:#1a1a1a;">Bilik Suara ↗</a>
            <a href="<?= site_url('auth/logout'); ?>" class="btn-logout">Logout</a>
        </div>
    </div>

    <!-- Content Area -->
    <div class="content-area">
