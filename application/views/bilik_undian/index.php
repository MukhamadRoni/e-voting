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

        /* ── Big Stage Display Arena with Authentic MegaSpinner Casino Aesthetics ── */
        .stage-display {
            background-color: #080a10;
            background-image: 
                radial-gradient(circle at 10% 50%, rgba(0, 220, 255, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 90% 50%, rgba(255, 90, 0, 0.22) 0%, transparent 45%),
                radial-gradient(ellipse at 50% 50%, rgba(30, 5, 40, 0.95) 0%, #06020c 100%),
                radial-gradient(rgba(255, 200, 50, 0.2) 1.5px, transparent 1.5px);
            background-size: 100% 100%, 100% 100%, 100% 100%, 14px 14px;
            border: 3px solid #ffaa00;
            border-radius: 28px;
            padding: 16px 20px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 0 35px rgba(255, 120, 0, 0.35),
                0 0 15px rgba(0, 220, 255, 0.25),
                inset 0 0 40px rgba(0, 0, 0, 0.9),
                0 20px 50px rgba(0, 0, 0, 0.6);
            min-height: 640px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: stretch;
            gap: 12px;
        }

        /* ── TOP CASINO ARCADE HEADER HUD ── */
        .casino-top-hud {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            z-index: 5;
            padding: 0 8px;
        }

        .hud-box {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hud-last-winner {
            background: #000000;
            border: 2px solid #ff9900;
            border-radius: 14px;
            padding: 4px 14px 6px;
            box-shadow: 0 0 12px rgba(255, 153, 0, 0.4), inset 0 2px 4px rgba(255, 255, 255, 0.15);
            min-width: 190px;
            text-align: center;
        }

        .hud-label-yellow {
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1.5px;
            color: #ffcc00;
            text-shadow: 0 0 8px rgba(255, 204, 0, 0.8);
            margin-bottom: 2px;
        }

        .hud-screen-black {
            font-family: 'DM Sans', monospace, sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        /* Center MegaSpinner 3D Logo */
        .hud-center-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo-megaspinner {
            font-family: 'DM Sans', Impact, sans-serif;
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 2px;
            line-height: 1;
            text-transform: uppercase;
            background: linear-gradient(180deg, #ffffff 0%, #bbf2f6 30%, #00d2ff 60%, #0077aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 0 #002233) drop-shadow(0 0 15px rgba(0, 210, 255, 0.8));
            position: relative;
        }

        .logo-megaspinner span {
            font-size: 14px;
            vertical-align: super;
            -webkit-text-fill-color: #ffd700;
        }

        .logo-sub-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #000000;
            border: 1px solid #ffaa00;
            border-radius: 6px;
            padding: 2px 10px;
            margin-top: 3px;
            box-shadow: 0 0 8px rgba(255, 170, 0, 0.5);
        }

        .logo-sub-badge .badge-text {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #ffdd44;
            text-transform: uppercase;
        }

        .badge-dot-left, .badge-dot-right {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #ff3300;
            box-shadow: 0 0 5px #ff3300;
        }

        /* Jackpot Marquee Screen */
        .hud-jackpot-screen {
            background: #000000;
            border: 2px dashed #ffaa00;
            border-radius: 14px;
            padding: 4px 16px 6px;
            box-shadow: 0 0 14px rgba(255, 170, 0, 0.5), inset 0 2px 4px rgba(255, 255, 255, 0.15);
            min-width: 190px;
            text-align: center;
            animation: marqueeBorderGlow 1.5s infinite alternate;
        }

        @keyframes marqueeBorderGlow {
            0% { border-color: #ffaa00; box-shadow: 0 0 12px rgba(255, 170, 0, 0.4); }
            100% { border-color: #ff3300; box-shadow: 0 0 20px rgba(255, 51, 0, 0.8); }
        }

        .hud-label-orange {
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1.5px;
            color: #ff7700;
            text-shadow: 0 0 8px rgba(255, 119, 0, 0.8);
            margin-bottom: 2px;
        }

        .hud-screen-jackpot span {
            color: #ffe600;
            font-weight: 800;
            text-shadow: 0 0 10px rgba(255, 230, 0, 0.7);
        }

        /* ── MAIN CASINO ARENA WITH FLANKING PAYLINE NUMBER TILES ── */
        .casino-main-arena {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            flex: 1;
            gap: 10px;
        }

        /* Vertical Payline Number Tiles (Left & Right) */
        .payline-column {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 390px;
            width: 32px;
            z-index: 4;
            user-select: none;
        }

        .payline-tile {
            width: 30px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 900;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .payline-left .payline-tile {
            background: linear-gradient(135deg, #021e33 0%, #053b61 100%);
            border: 1.5px solid #00d2ff;
            color: #ffe600;
            box-shadow: 0 0 8px rgba(0, 210, 255, 0.5), inset 0 1px 2px rgba(255, 255, 255, 0.4);
            text-shadow: 0 1px 2px #000;
        }

        .payline-right .payline-tile {
            background: linear-gradient(135deg, #380d00 0%, #6b1b00 100%);
            border: 1.5px solid #ff6600;
            color: #ffe600;
            box-shadow: 0 0 8px rgba(255, 102, 0, 0.5), inset 0 1px 2px rgba(255, 255, 255, 0.4);
            text-shadow: 0 1px 2px #000;
        }

        .payline-tile.active-tile {
            transform: scale(1.15);
            animation: tilePulse 1s infinite alternate;
        }

        @keyframes tilePulse {
            0% { filter: brightness(1); }
            100% { filter: brightness(1.4); }
        }

        /* 3D Canvas Showcase Area */
        .slot-3d-wrapper {
            flex: 1;
            height: 410px;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slot-3d-canvas-container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 2;
        }

        /* Celebratory Overlay: JACKPOT! with Animated Gold Gradient */
        .jackpot-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            opacity: 0;
            transform: scale(0.85);
            transition: all 0.45s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: radial-gradient(circle at center, rgba(30, 0, 45, 0.75) 0%, rgba(10, 0, 18, 0.88) 100%);
            backdrop-filter: blur(4px);
            padding: 20px;
        }

        .jackpot-overlay.active {
            opacity: 1;
            transform: scale(1);
            pointer-events: auto;
        }

        .jackpot-badge-top {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 3px;
            color: #ffd700;
            text-shadow: 0 0 12px rgba(255, 215, 0, 0.8);
            margin-bottom: 4px;
            text-transform: uppercase;
            animation: pulse-glow 1s infinite alternate;
        }

        .jackpot-text-title {
            font-size: 52px;
            font-weight: 900;
            letter-spacing: 2px;
            line-height: 1.1;
            margin-bottom: 14px;
            background: linear-gradient(135deg, #fff7ad 0%, #ffa900 25%, #ffffff 50%, #ffa900 75%, #ff4500 100%);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: goldShine 2.5s ease infinite alternate, titleBounce 0.8s ease infinite alternate;
            filter: drop-shadow(0 6px 16px rgba(0, 0, 0, 0.9));
        }

        @keyframes goldShine {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        @keyframes titleBounce {
            from { transform: scale(1); }
            to { transform: scale(1.04); }
        }

        @keyframes pulse-glow {
            from { opacity: 0.7; }
            to { opacity: 1; text-shadow: 0 0 20px rgba(255, 215, 0, 1); }
        }

        .jackpot-winner-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 215, 0, 0.5);
            border-radius: 20px;
            padding: 16px 28px;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), inset 0 0 20px rgba(255, 215, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .jackpot-winner-tag span {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #38bdf8;
            text-transform: uppercase;
        }

        .jackpot-winner-name {
            font-size: 26px;
            font-weight: 900;
            color: #ffffff;
            margin: 6px 0 4px;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
            word-break: break-word;
        }

        .jackpot-winner-meta {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 10px;
        }

        .jackpot-prize-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #15803d, #16a34a);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            padding: 6px 18px;
            border-radius: 9999px;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.4);
        }

        /* ── BOTTOM CASINO ARCADE DASHBOARD ── */
        .casino-bottom-dashboard {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            z-index: 6;
            flex-wrap: wrap;
            padding-top: 6px;
        }

        /* Arcade Info Button */
        .btn-arcade-info {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: linear-gradient(180deg, #00d2ff 0%, #0077b6 100%);
            border: 2px solid #a5f3fc;
            box-shadow: 0 4px 12px rgba(0, 210, 255, 0.5), inset 0 2px 3px rgba(255, 255, 255, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
            color: #ffffff;
            cursor: pointer;
            transition: transform 0.15s ease;
        }

        .btn-arcade-info:hover {
            transform: scale(1.06);
        }

        /* Dashboard Meter Pills (TOTAL BET, CREDITS, WIN) */
        .dashboard-meter-pill {
            background: #000000;
            border: 2px solid #ffaa00;
            border-radius: 9999px;
            padding: 4px 16px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 0 10px rgba(255, 170, 0, 0.3), inset 0 2px 4px rgba(255, 255, 255, 0.15);
            min-height: 46px;
        }

        .btn-meter-circle {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(180deg, #fde047 0%, #d97706 100%);
            border: 1.5px solid #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 900;
            color: #000000;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
            user-select: none;
        }

        .meter-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 1.1;
        }

        .meter-title {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #ffaa00;
            text-transform: uppercase;
        }

        .meter-value {
            font-family: 'DM Sans', monospace, sans-serif;
            font-size: 16px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        /* Arcade Auto Button */
        .btn-arcade-auto {
            background: linear-gradient(180deg, #ff8800 0%, #b45309 100%);
            border: 2px solid #fde047;
            border-radius: 12px;
            padding: 6px 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(255, 136, 0, 0.4), inset 0 2px 3px rgba(255, 255, 255, 0.5);
            transition: all 0.15s ease;
            height: 46px;
        }

        .btn-arcade-auto:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .auto-light-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 8px #22c55e;
        }

        .auto-text {
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 1px;
            color: #ffffff;
            text-shadow: 0 1px 3px #000;
        }

        /* ── HERO GIANT ARCADE SPIN BUTTON (Match Reference Image) ── */
        .btn-arcade-spin {
            background: linear-gradient(180deg, #ff2200 0%, #ff5500 40%, #d90429 80%, #990000 100%);
            border: 3.5px solid #ffd700;
            border-radius: 14px;
            padding: 8px 46px;
            min-height: 52px;
            font-family: 'DM Sans', Impact, sans-serif;
            font-size: 26px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #fff275;
            text-transform: uppercase;
            text-shadow: 0 2px 4px #000000, 0 0 14px rgba(255, 240, 100, 0.8);
            cursor: pointer;
            box-shadow: 
                0 8px 25px rgba(255, 50, 0, 0.65), 
                0 0 15px rgba(255, 215, 0, 0.5),
                inset 0 3px 5px rgba(255, 255, 255, 0.6);
            transition: all 0.15s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-arcade-spin:hover:not(:disabled) {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 
                0 12px 30px rgba(255, 50, 0, 0.8), 
                0 0 20px rgba(255, 215, 0, 0.7),
                inset 0 3px 6px rgba(255, 255, 255, 0.8);
            filter: brightness(1.08);
        }

        .btn-arcade-spin:active:not(:disabled) {
            transform: translateY(1px) scale(0.98);
        }

        .btn-arcade-spin:disabled {
            background: #374151;
            border-color: #6b7280;
            color: #9ca3af;
            cursor: not-allowed;
            box-shadow: none;
            text-shadow: none;
            transform: none;
        }

        /* WIN SCOREBOARD PANEL */
        .meter-win {
            background: #000000;
            border: 2px solid #eab308;
            border-radius: 12px;
            padding: 4px 18px;
            min-width: 140px;
        }

        .meter-win-value {
            color: #4ade80;
            font-size: 20px;
            text-shadow: 0 0 10px rgba(74, 222, 128, 0.7);
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

            <!-- Big Stage Display Arena with Authentic MegaSpinner Casino Aesthetics -->
            <div class="stage-display stage-display-casino">
                
                <!-- TOP CASINO ARCADE HEADER HUD (from reference image) -->
                <div class="casino-top-hud">
                    <!-- Left: LAST WINNER Screen -->
                    <div class="hud-box hud-last-winner">
                        <div class="hud-label-yellow">LAST WINNER</div>
                        <div class="hud-screen-black">
                            <span id="hudLastWinner">
                                <?php if (!empty($daftar_pemenang)): ?>
                                    <?= html_escape($daftar_pemenang[0]->pemilih_nik); ?> - <?= html_escape($daftar_pemenang[0]->nama ?: 'Pemenang'); ?>
                                <?php else: ?>
                                    SIAP MENGUNDI
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>

                    <!-- Center: 3D MEGASPINNER Logo -->
                    <div class="hud-center-logo">
                        <div class="logo-megaspinner">MEGASPINNER<span>&reg;</span></div>
                        <div class="logo-sub-badge">
                            <span class="badge-dot-left"></span>
                            <span class="badge-text">RAT KOPERASI</span>
                            <span class="badge-dot-right"></span>
                        </div>
                    </div>

                    <!-- Right: JACKPOT Screen with Marquee Neon Bulbs -->
                    <div class="hud-box hud-jackpot-screen">
                        <div class="hud-label-orange">
                            <span style="color:#ffcc00;">&bull;</span>
                            JACKPOT
                            <span style="color:#ffcc00;">&bull;</span>
                        </div>
                        <div class="hud-screen-black hud-screen-jackpot">
                            <span id="labelDisplayHadiah">Door Prize Utama</span>
                        </div>
                    </div>
                </div>

                <!-- MAIN CASINO ARENA WITH FLANKING PAYLINE NUMBER TILES -->
                <div class="casino-main-arena">
                    <!-- Left Payline Number Tiles (Cyan/Blue LED Glow) -->
                    <div class="payline-column payline-left">
                        <div class="payline-tile">4</div>
                        <div class="payline-tile">2</div>
                        <div class="payline-tile">9</div>
                        <div class="payline-tile">6</div>
                        <div class="payline-tile active-tile">1</div>
                        <div class="payline-tile">10</div>
                        <div class="payline-tile">7</div>
                        <div class="payline-tile">8</div>
                        <div class="payline-tile">3</div>
                        <div class="payline-tile">5</div>
                    </div>

                    <!-- 3D Canvas Showcase Area -->
                    <div class="slot-3d-wrapper">
                        <!-- Three.js Canvas Container -->
                        <div id="slot3dCanvasContainer" class="slot-3d-canvas-container"></div>

                        <!-- Celebratory Overlay: JACKPOT! with Animated Gold Gradient -->
                        <div id="jackpotOverlay" class="jackpot-overlay">
                            <div class="jackpot-badge-top">★ GRAND CASINO JACKPOT ★</div>
                            <h2 class="jackpot-text-title" id="jackpotTitleText">JACKPOT! NIK RAT</h2>
                            
                            <div class="jackpot-winner-card">
                                <div class="jackpot-winner-tag">
                                    <span>SELAMAT KEPADA PEMENANG</span>
                                </div>
                                <div class="jackpot-winner-name" id="jackpotWinnerName">-</div>
                                <div class="jackpot-winner-meta" id="jackpotWinnerMeta">-</div>
                                <div class="jackpot-prize-pill">
                                    🏆 <span id="jackpotPrizeLabel">Door Prize Utama</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Payline Number Tiles (Fiery Amber/Red LED Glow) -->
                    <div class="payline-column payline-right">
                        <div class="payline-tile">15</div>
                        <div class="payline-tile">13</div>
                        <div class="payline-tile">18</div>
                        <div class="payline-tile">16</div>
                        <div class="payline-tile active-tile">11</div>
                        <div class="payline-tile">20</div>
                        <div class="payline-tile">17</div>
                        <div class="payline-tile">19</div>
                        <div class="payline-tile">12</div>
                        <div class="payline-tile">14</div>
                    </div>
                </div>

                <!-- BOTTOM CASINO ARCADE DASHBOARD (from reference image) -->
                <div class="casino-bottom-dashboard">
                    <!-- Left: Info Pill Button -->
                    <button type="button" class="btn-arcade-info" title="Informasi Undian RAT">
                        <span>ℹ</span>
                    </button>

                    <!-- Hidden Counter for JS Logic -->
                    <span id="counterPeserta" style="display:none;"><?= $total_tersisa; ?></span>

                    <!-- AUTO BUTTON -->
                    <div class="btn-arcade-auto" id="btnArcadeAuto" title="Klik untuk beralih mode Auto Valid">
                        <span class="auto-light-indicator" id="arcadeAutoIndicator"></span>
                        <span class="auto-text">AUTO</span>
                    </div>

                    <!-- GIANT ARCADE SPIN BUTTON (Match Reference Image!) -->
                    <button type="button" class="btn-arcade-spin" id="btnSpin">
                        <span class="spin-text" id="btnSpinText">SPIN</span>
                    </button>

                    <!-- WIN SCOREBOARD PANEL -->
                    <div class="dashboard-meter-pill meter-win">
                        <div class="meter-content">
                            <span class="meter-title">WIN (PEMENANG)</span>
                            <span class="meter-value meter-win-value" id="meterWinCount"><?= count($daftar_pemenang); ?></span>
                        </div>
                    </div>
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

    <!-- Three.js 3D Library -->
    <script src="<?= base_url('assets/vendor/threejs/three.min.js'); ?>"></script>

    <!-- 3D Casino Slot Machine Modular Architecture Scripts -->
    <script src="<?= base_url('assets/js/slot_3d/ThreeScene.js'); ?>"></script>
    <script src="<?= base_url('assets/js/slot_3d/LightingManager.js'); ?>"></script>
    <script src="<?= base_url('assets/js/slot_3d/SlotMachine.js'); ?>"></script>
    <script src="<?= base_url('assets/js/slot_3d/ParticleSystem.js'); ?>"></script>
    <script src="<?= base_url('assets/js/slot_3d/UIManager.js'); ?>"></script>

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

    // ── Toggle Auto-Valid Switch & Arcade Auto Button ──
    var btnArcadeAuto = document.getElementById('btnArcadeAuto');
    var arcadeAutoIndicator = document.getElementById('arcadeAutoIndicator');

    toggleAutoValid.addEventListener('change', function() {
        if (this.checked) {
            toggleLabel.textContent = 'AUTO VALID: AKTIF';
            toggleLabel.className = 'toggle-status-text status-on';
            if (arcadeAutoIndicator) {
                arcadeAutoIndicator.style.background = '#22c55e';
                arcadeAutoIndicator.style.boxShadow = '0 0 8px #22c55e';
            }
        } else {
            toggleLabel.textContent = 'AUTO VALID: NONAKTIF';
            toggleLabel.className = 'toggle-status-text status-off';
            if (arcadeAutoIndicator) {
                arcadeAutoIndicator.style.background = '#ef4444';
                arcadeAutoIndicator.style.boxShadow = '0 0 8px #ef4444';
            }
        }
    });

    if (btnArcadeAuto) {
        btnArcadeAuto.addEventListener('click', function() {
            toggleAutoValid.checked = !toggleAutoValid.checked;
            toggleAutoValid.dispatchEvent(new Event('change'));
        });
    }

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
                            var meterWin = document.getElementById('meterWinCount');
                            if (meterWin) meterWin.textContent = currentTotal;
                            
                            var currentSisa = parseInt(counterPeserta.textContent, 10) + 1;
                            counterPeserta.textContent = currentSisa;
                            var meterCredits = document.getElementById('meterCredits');
                            if (meterCredits) meterCredits.textContent = (currentSisa * 100).toLocaleString('id-ID');

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

    // ── Inisialisasi Arsitektur Modular Three.js 3D Casino Slot Machine ──
    var threeScene = new ThreeScene('slot3dCanvasContainer');
    var lightingManager = new LightingManager(threeScene.scene, threeScene.mainPivot);
    var slotMachine = new SlotMachine(threeScene.scene, threeScene.mainPivot);
    var particleSystem = new ParticleSystem(threeScene.scene, threeScene.mainPivot);

    // Daftarkan listener render loop Three.js
    threeScene.subscribe(function(delta, time) {
        lightingManager.update(delta, time);
        slotMachine.update(delta, time);
        particleSystem.update(delta, time);
    });

    // Inisialisasi UIManager & Hubungkan Kontrol SPA
    var uiManager = new UIManager({
        threeScene: threeScene,
        slotMachine: slotMachine,
        lightingManager: lightingManager,
        particleSystem: particleSystem,
        btnSpinId: 'btnSpin',
        btnSpinTextId: 'btnSpinText',
        overlayId: 'jackpotOverlay',
        acakUrl: acakUrl,
        simpanUrl: simpanUrl
    });

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

        // Sync Casino HUD Meters
        var hudLast = document.getElementById('hudLastWinner');
        if (hudLast) {
            hudLast.textContent = winner.nik + ' - ' + winner.nama;
        }
        var meterWin = document.getElementById('meterWinCount');
        if (meterWin) {
            meterWin.textContent = total;
        }
        var sisaEl = document.getElementById('counterPeserta');
        var creditsEl = document.getElementById('meterCredits');
        if (sisaEl && creditsEl) {
            var sVal = parseInt(sisaEl.textContent, 10) || 0;
            creditsEl.textContent = (sVal * 100).toLocaleString('id-ID');
        }
    }
    window.addWinnerToSidebar = addWinnerToSidebar;
    </script>
</body>
</html>
