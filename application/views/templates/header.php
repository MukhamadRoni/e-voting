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
        :root {
            --sidebar-width: 240px;
            --sidebar-collapsed-width: 60px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #1a1a1a;
            padding: 16px 0;
            overflow: visible;
            z-index: 100;
            transition: width 0.25s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* Brand area */
        .sidebar .brand {
            padding: 0 16px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            overflow: hidden;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .sidebar .brand .brand-text {
            transition: opacity 0.2s ease, width 0.25s ease;
            overflow: hidden;
        }

        .sidebar.collapsed .brand .brand-text {
            opacity: 0;
            width: 0;
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

        /* Toggle button */
        .sidebar-toggle {
            position: absolute;
            top: 16px;
            right: -12px;
            width: 24px;
            height: 24px;
            background: #252528;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 101;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.35);
            transition: all 0.25s ease;
        }

        .sidebar-toggle:hover {
            background: #323338;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .sidebar-toggle svg {
            width: 12px;
            height: 12px;
            stroke: #94a3b8;
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: transform 0.25s ease, stroke 0.2s ease;
        }

        .sidebar-toggle:hover svg {
            stroke: #ffffff;
        }

        .sidebar.collapsed .sidebar-toggle svg {
            transform: rotate(180deg);
        }

        /* Nav list */
        .sidebar-nav {
            list-style: none;
            padding: 0 8px;
            overflow-y: auto;
            overflow-x: visible;
            flex: 1;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.15) transparent;
        }

        /* Modern Custom Scrollbar: Remove native OS/browser scrollbar buttons */
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .sidebar-nav::-webkit-scrollbar-button {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        /* Hide scrollbar completely when collapsed to keep icons perfectly centered */
        .sidebar.collapsed .sidebar-nav {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar.collapsed .sidebar-nav::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 3px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            overflow: visible;
            position: relative;
        }

        .sidebar.collapsed .sidebar-nav li a {
            justify-content: center;
            padding: 6px 0;
            gap: 0;
        }

        .sidebar-nav li a:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #f1f5f9;
        }

        .sidebar-nav li a.active {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            font-weight: 600;
        }

        /* ── Modern Grey Base Icon Badge ── */
        .sidebar-nav li a .nav-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #252528;
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav li a .nav-icon svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
            transition: transform 0.2s ease, stroke 0.2s ease;
        }

        .sidebar-nav li a:hover .nav-icon {
            background: #323338;
            border-color: rgba(255, 255, 255, 0.16);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.35);
        }

        .sidebar-nav li a:hover .nav-icon svg {
            transform: scale(1.08);
        }

        .sidebar-nav li a.active .nav-icon {
            background: #3f4046;
            border-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        }

        .sidebar-nav li a.active .nav-icon svg {
            transform: scale(1.05);
        }

        /* Label text in nav */
        .sidebar-nav li a .nav-label {
            transition: opacity 0.15s ease, max-width 0.25s ease;
            overflow: hidden;
            max-width: 200px;
        }

        .sidebar.collapsed .sidebar-nav li a .nav-label {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
        }

        /* Section label */
        .sidebar-nav .nav-section {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 10px 6px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s ease, max-height 0.25s ease, padding 0.25s ease;
            max-height: 40px;
        }

        .sidebar.collapsed .sidebar-nav .nav-section {
            opacity: 0;
            max-height: 0;
            padding: 0;
        }

        /* Tooltip on hover (collapsed mode) — rendered via JS */
        #sidebar-tooltip {
            position: fixed;
            left: 0;
            top: 0;
            background: #333333;
            color: #ffffff;
            font-size: 13px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            padding: 6px 12px;
            border-radius: 8px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.15s ease;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        #sidebar-tooltip.visible {
            opacity: 1;
        }

        /* ── Top Bar ── */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.25s ease;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
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
<div class="sidebar" id="sidebar">
    <!-- Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
    </button>

    <div class="brand">
        <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo" style="width:36px; height:36px; border-radius:10px; flex-shrink:0;">
        <div class="brand-text">
            <h2>E-Voting</h2>
            <span>Panel Admin</span>
        </div>
    </div>

    <ul class="sidebar-nav">
        <li>
            <a href="<?= site_url('admin'); ?>" data-tooltip="Dashboard" class="<?= ($this->uri->segment(1) == 'admin' && !$this->uri->segment(2)) ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1.5"/><rect width="7" height="5" x="14" y="3" rx="1.5"/><rect width="7" height="9" x="14" y="12" rx="1.5"/><rect width="7" height="5" x="3" y="16" rx="1.5"/></svg>
                </div>
                <span class="nav-label">Dashboard</span>
            </a>
        </li>

        <li class="nav-section">Master Data</li>
        <li>
            <a href="<?= site_url('master_user'); ?>" data-tooltip="Data Pemilih" class="<?= ($this->uri->segment(1) == 'master_user') ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="nav-label">Data Pemilih</span>
            </a>
        </li>
        <li>
            <a href="<?= site_url('master_kandidat'); ?>" data-tooltip="Data Kandidat" class="<?= ($this->uri->segment(1) == 'master_kandidat') ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="m16 11 2 2 4-4"/></svg>
                </div>
                <span class="nav-label">Data Kandidat</span>
            </a>
        </li>

        <li class="nav-section">Laporan</li>
        <li>
            <a href="<?= site_url('laporan/pemenang_ketua'); ?>" data-tooltip="Pemenang Ketua" class="<?= ($this->uri->segment(2) == 'pemenang_ketua') ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6 9H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2"/><path d="M18 9h2a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2"/><path d="M12 17v4"/><path d="M8 21h8"/><path d="M6 3h12a3 3 0 0 1 3 3v2a7 7 0 0 1-14 0V6a3 3 0 0 1 3-3Z"/></svg>
                </div>
                <span class="nav-label">Pemenang Ketua</span>
            </a>
        </li>
        <li>
            <a href="<?= site_url('laporan/pemenang_pengawas'); ?>" data-tooltip="Pemenang Pengawas" class="<?= ($this->uri->segment(2) == 'pemenang_pengawas') ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <span class="nav-label">Pemenang Pengawas</span>
            </a>
        </li>
        <li>
            <a href="<?= site_url('laporan/trace_back'); ?>" data-tooltip="Trace Back" class="<?= ($this->uri->segment(2) == 'trace_back') ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>
                </div>
                <span class="nav-label">Trace Back</span>
            </a>
        </li>
        <li>
            <a href="<?= site_url('laporan/peserta_undian'); ?>" data-tooltip="Peserta Undian" class="<?= ($this->uri->segment(2) == 'peserta_undian') ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
                </div>
                <span class="nav-label">Peserta Undian</span>
            </a>
        </li>
        <li class="nav-section">Bilik &amp; Panggung</li>
        <li>
            <a href="<?= site_url('voting'); ?>" data-tooltip="Buka Bilik Suara" target="_blank">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 10h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10Z"/><path d="M8 10V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4"/><path d="m9 14 2 2 4-4"/></svg>
                </div>
                <span class="nav-label">Buka Bilik Suara ↗</span>
            </a>
        </li>
        <li>
            <a href="<?= site_url('bilik_undian'); ?>" data-tooltip="Buka Bilik Undian" target="_blank" class="<?= ($this->uri->segment(1) == 'bilik_undian') ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 4.8 0 0 1 12 7.5a4.8 4.8 0 0 1 4.5-4.5 2.5 2.5 0 0 1 0 5"/></svg>
                </div>
                <span class="nav-label">Buka Bilik Undian ↗</span>
            </a>
        </li>
        <li>
            <a href="<?= site_url('real_count'); ?>" data-tooltip="Real Count 3D" target="_blank" class="<?= ($this->uri->segment(1) == 'real_count') ? 'active' : ''; ?>">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                </div>
                <span class="nav-label">Real Count 3D ↗</span>
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
