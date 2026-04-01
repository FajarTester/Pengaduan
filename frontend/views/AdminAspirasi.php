<?

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=login');
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Aspirasi Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --p1: #667eea;
            --p2: #764ba2;
            --p-light: #eef0fd;
            --p-mid: rgba(102, 126, 234, 0.12);
            --p-border: rgba(102, 126, 234, 0.18);
            --dark: #1a1d2e;
            --mid: #4a5068;
            --soft: #8b8fa8;
            --bg: #f2f3fb;
            --card: #ffffff;
            --radius: 18px;
            --radius-sm: 10px;
            --sh-sm: 0 2px 12px rgba(102, 126, 234, 0.09);
            --sh-md: 0 8px 32px rgba(102, 126, 234, 0.14);
            --sh-lg: 0 20px 60px rgba(102, 126, 234, 0.22);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ─── PAGE LOAD ANIMATION ─── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(.94);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideRight {
            from {
                opacity: 0;
                transform: translateX(-18px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, .35);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes toastSlide {
            from {
                opacity: 0;
                transform: translateY(20px) scale(.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* ─── NAVBAR ─── */
        .navbar {
            background: linear-gradient(135deg, var(--p1), var(--p2));
            background-size: 200% 200%;
            animation: gradientShift 6s ease infinite;
            box-shadow: 0 4px 28px rgba(102, 126, 234, .35);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 28px;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 11px;
            animation: slideRight .5s ease both;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, .2);
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            backdrop-filter: blur(8px);
        }

        .brand-text {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 800;
            color: white;
            letter-spacing: -.4px;
        }

        .brand-text span {
            background: rgba(255, 255, 255, .25);
            border-radius: 5px;
            padding: 1px 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase;
            vertical-align: middle;
            margin-left: 6px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeIn .6s ease .2s both;
        }

        .admin-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 999px;
            padding: 6px 14px 6px 7px;
            backdrop-filter: blur(8px);
        }

        .admin-avatar {
            width: 26px;
            height: 26px;
            background: rgba(255, 255, 255, .9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--p1);
            font-size: 13px;
        }

        .admin-name {
            color: white;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: .1px;
        }

        .btn-logout {
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .3);
            color: white;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 16px;
            border-radius: 9px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, .28);
            color: white;
        }

        /* ─── HERO ─── */
        .hero {
            background: linear-gradient(135deg, var(--p1), var(--p2));
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
            padding: 34px 0 70px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fff' fill-opacity='0.04' fill-rule='evenodd'%3E%3Ccircle cx='40' cy='40' r='14'/%3E%3Ccircle cx='0' cy='0' r='14'/%3E%3Ccircle cx='80' cy='0' r='14'/%3E%3Ccircle cx='0' cy='80' r='14'/%3E%3Ccircle cx='80' cy='80' r='14'/%3E%3C/g%3E%3C/svg%3E");
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 50px;
            background: var(--bg);
            clip-path: ellipse(55% 100% at 50% 100%);
        }

        .hero-inner {
            position: relative;
            z-index: 1;
            animation: fadeUp .55s ease both;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .3);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 12px;
            backdrop-filter: blur(6px);
        }

        .hero-title {
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: white;
            letter-spacing: -.6px;
            margin-bottom: 6px;
        }

        .hero-sub {
            color: rgba(255, 255, 255, .72);
            font-size: 13.5px;
            margin-bottom: 28px;
        }

        /* STAT CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .stat-card {
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 14px;
            padding: 16px 18px;
            color: white;
            cursor: default;
            backdrop-filter: blur(10px);
            transition: all .22s;
            animation: fadeUp .5s ease both;
        }

        .stat-card:nth-child(1) {
            animation-delay: .1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: .18s;
        }

        .stat-card:nth-child(3) {
            animation-delay: .26s;
        }

        .stat-card:nth-child(4) {
            animation-delay: .34s;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, .24);
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            background: rgba(255, 255, 255, .18);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .stat-num {
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
            animation: countUp .6s ease both;
        }

        .stat-lbl {
            font-size: 11.5px;
            opacity: .75;
            font-weight: 600;
            margin-top: 3px;
        }

        .stat-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        /* ─── MAIN CONTENT ─── */
        .main-wrap {
            margin-top: -36px;
            position: relative;
            z-index: 10;
            padding-bottom: 60px;
        }

        /* ─── PANEL ─── */
        .panel {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--sh-md);
            overflow: hidden;
            animation: scaleIn .45s ease .2s both;
        }

        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--p-border);
        }

        .panel-head-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ph-icon {
            width: 40px;
            height: 40px;
            background: var(--p-light);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--p1);
            font-size: 18px;
            flex-shrink: 0;
        }

        .ph-title {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 15.5px;
            color: var(--dark);
            margin: 0;
        }

        .ph-sub {
            font-size: 12px;
            color: var(--soft);
            margin: 0;
        }

        .total-badge {
            background: var(--p-light);
            color: var(--p1);
            font-size: 12px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 999px;
            border: 1px solid var(--p-border);
        }

        /* ─── FILTER BAR ─── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 24px;
            border-bottom: 1px solid var(--p-border);
            flex-wrap: wrap;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--soft);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-right: 4px;
        }

        .ftab {
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            border: 1.5px solid var(--p-border);
            background: transparent;
            color: var(--mid);
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s;
            text-decoration: none;
            display: inline-block;
        }

        .ftab.active,
        .ftab:hover {
            background: linear-gradient(135deg, var(--p1), var(--p2));
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 14px rgba(102, 126, 234, .3);
        }

        .search-wrap {
            margin-left: auto;
            position: relative;
        }

        .search-input {
            border: 1.5px solid var(--p-border);
            border-radius: 10px;
            padding: 7px 14px 7px 36px;
            font-size: 13px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            background: #fafbff;
            outline: none;
            width: 200px;
            transition: all .2s;
        }

        .search-input:focus {
            border-color: var(--p1);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, .1);
            background: white;
        }

        .search-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--soft);
            font-size: 14px;
            pointer-events: none;
        }

        /* ─── TABLE ─── */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 13px 18px;
            font-size: 11px;
            font-weight: 800;
            color: var(--soft);
            text-transform: uppercase;
            letter-spacing: .8px;
            background: #fafbff;
            border-bottom: 1.5px solid var(--p-border);
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid rgba(102, 126, 234, .08);
            transition: all .18s;
            animation: fadeUp .35s ease both;
        }

        tbody tr:hover {
            background: var(--p-light);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody td {
            padding: 14px 18px;
            font-size: 13.5px;
            color: var(--mid);
            vertical-align: middle;
        }

        .id-badge {
            font-family: 'Sora', sans-serif;
            font-size: 11.5px;
            font-weight: 800;
            color: var(--p1);
            background: var(--p-light);
            border: 1px solid var(--p-border);
            border-radius: 7px;
            padding: 3px 9px;
        }

        .nis-chip {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .nis-avatar {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--p1), var(--p2));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .nis-text {
            font-weight: 600;
            color: var(--dark);
            font-size: 13px;
        }

        .cat-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--p-light);
            border: 1px solid var(--p-border);
            border-radius: 7px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 600;
            color: var(--p1);
        }

        .loc-text {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: var(--mid);
        }

        .loc-text i {
            color: var(--p1);
            font-size: 12px;
        }

        .ket-short {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 13px;
            color: var(--mid);
        }

        /* STATUS BADGES */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
        }

        .sbadge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .sb-menunggu {
            background: #fff8e1;
            color: #d49900;
            border: 1.5px solid #ffe082;
        }

        .sb-proses {
            background: #e8f0fe;
            color: #1a73e8;
            border: 1.5px solid #aecbfa;
        }

        .sb-selesai {
            background: #e6f4ea;
            color: #1e8e3e;
            border: 1.5px solid #a8d5b5;
        }

        .sb-ditolak {
            background: #fce8e6;
            color: #d93025;
            border: 1.5px solid #f5b8b4;
        }

        .sb-menunggu.pulse {
            animation: pulse-ring 2s infinite;
        }

        /* ACTION BTN */
        .btn-review {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--p1), var(--p2));
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
            padding: 7px 16px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(102, 126, 234, .3);
            transition: all .2s;
        }

        .btn-review:hover {
            box-shadow: 0 7px 22px rgba(102, 126, 234, .45);
            transform: translateY(-1px);
        }

        /* EMPTY */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            animation: fadeUp .4s ease both;
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            background: var(--p-light);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 16px;
        }

        .empty-title {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--soft);
        }

        /* ─── MODAL ─── */
        .custom-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .custom-modal-backdrop.show {
            display: flex;
        }

        .modal-box {
            background: #ffffff;
            /* Pastikan putih solid */
            border-radius: 22px;
            width: 100%;
            max-width: 580px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            animation: scaleIn .3s cubic-bezier(.34, 1.4, .64, 1) both;
            z-index: 1001;
        }

        .modal-header {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            padding: 22px 24px;
            border-radius: 22px 22px 0 0;
            position: relative;
        }

        .modal-header-id {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, .7);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 4px;
        }

        .modal-header-title {
            font-family: 'Sora', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: white;
            letter-spacing: -.3px;
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, .2);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .18s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, .35);
        }

        .modal-body {
            padding: 24px;
        }

        /* INFO GRID */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #ffffff;
            border: 1.5px solid var(--p-border);
            border-radius: 12px;
            padding: 12px 14px;
            transition: all .18s;
        }

        #mKet {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .info-item:hover {
            background: var(--p-light);
            border-color: var(--p1);
        }

        .info-item-label {
            font-size: 10.5px;
            font-weight: 800;
            color: var(--soft);
            text-transform: uppercase;
            letter-spacing: .7px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .info-item-label i {
            color: var(--p1);
        }

        .info-item-value {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--dark);
        }

        .info-full {
            grid-column: 1 / -1;
        }

        .isi-box {
            background: #fafbff;
            border: 1.5px solid var(--p-border);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 13.5px;
            color: var(--mid);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .prev-feedback {
            background: linear-gradient(135deg, #f0f3ff, #f5f0ff);
            border: 1.5px solid var(--p-border);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .pf-label {
            font-size: 11px;
            font-weight: 800;
            color: var(--p1);
            text-transform: uppercase;
            letter-spacing: .7px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pf-text {
            font-size: 13px;
            color: var(--mid);
            line-height: 1.6;
        }

        /* FORM IN MODAL */
        .divider {
            border: none;
            height: 1.5px;
            background: var(--p-border);
            margin: 20px 0;
        }

        .form-section-title {
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .form-section-title::before {
            content: '';
            width: 4px;
            height: 16px;
            background: linear-gradient(180deg, var(--p1), var(--p2));
            border-radius: 2px;
        }

        .form-label-m {
            font-size: 12px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-label-m i {
            color: var(--p1);
        }

        .form-control-m,
        .form-select-m {
            width: 100%;
            border: 1.5px solid var(--p-border);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            background: #fafbff;
            outline: none;
            transition: all .2s;
        }

        .form-control-m:focus,
        .form-select-m:focus {
            border-color: var(--p1);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, .12);
            background: white;
        }

        textarea.form-control-m {
            resize: none;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 16px;
        }

        .status-opt {
            border: 2px solid var(--p-border);
            border-radius: 10px;
            padding: 9px 6px;
            text-align: center;
            cursor: pointer;
            transition: all .18s;
            font-size: 12px;
            font-weight: 700;
            color: var(--mid);
            background: #fafbff;
        }

        .status-opt .s-em {
            display: block;
            font-size: 18px;
            margin-bottom: 3px;
        }

        .status-opt:hover {
            border-color: var(--p1);
        }

        .status-opt.sel-menunggu {
            border-color: #d49900;
            background: #fff8e1;
            color: #d49900;
        }

        .status-opt.sel-proses {
            border-color: #1a73e8;
            background: #e8f0fe;
            color: #1a73e8;
        }

        .status-opt.sel-selesai {
            border-color: #1e8e3e;
            background: #e6f4ea;
            color: #1e8e3e;
        }

        .status-opt.sel-ditolak {
            border-color: #d93025;
            background: #fce8e6;
            color: #d93025;
        }

        select#modal-status-field {
            display: none;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-cancel-m {
            flex: 1;
            padding: 12px;
            border: 2px solid var(--p-border);
            border-radius: 12px;
            background: transparent;
            color: var(--mid);
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-cancel-m:hover {
            border-color: var(--p1);
            color: var(--p1);
            background: var(--p-light);
        }

        .btn-save-m {
            flex: 2;
            padding: 12px;
            background: linear-gradient(135deg, var(--p1), var(--p2));
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(102, 126, 234, .35);
            transition: all .22s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn-save-m:hover {
            box-shadow: 0 10px 28px rgba(102, 126, 234, .5);
            transform: translateY(-1px);
        }

        .btn-save-m:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none !important;
        }

        .spinner {
            width: 15px;
            height: 15px;
            border: 2px solid rgba(255, 255, 255, .4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            display: none;
        }

        /* ─── TOAST ─── */
        .toast-wrap {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            border-radius: 14px;
            padding: 14px 18px;
            box-shadow: 0 12px 36px rgba(20, 18, 40, .18);
            border-left: 4px solid var(--p1);
            font-size: 13.5px;
            font-weight: 600;
            color: var(--dark);
            min-width: 260px;
            animation: toastSlide .3s ease both;
        }

        .toast-item.success {
            border-left-color: #1e8e3e;
        }

        .toast-item.error {
            border-left-color: #d93025;
        }

        .toast-em {
            font-size: 18px;
        }

        /* ─── SUCCESS PAGE ─── */
        .alert-success-custom {
            background: linear-gradient(135deg, #e6f4ea, #f0faf2);
            border: 1.5px solid #a8d5b5;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeUp .4s ease both;
        }

        .alert-success-custom i {
            color: #1e8e3e;
            font-size: 18px;
        }

        .alert-success-custom span {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e8e3e;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .status-grid {
                grid-template-columns: 1fr 1fr;
            }

            .filter-bar {
                gap: 7px;
            }

            .search-wrap {
                width: 100%;
            }

            .search-input {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container-lg">
            <div class="navbar-inner">
                <div class="brand-wrap">
                    <div class="brand-icon">🛡️</div>
                    <div>
                        <div class="brand-text">
                            Aspirasi<span>ADMIN</span>
                        </div>
                    </div>
                </div>
                <div class="nav-right">
                    <div class="admin-chip">
                        <div class="admin-avatar"><i class="bi bi-shield-fill"></i></div>
                        <span class="admin-name">
                            <?php echo htmlspecialchars($_SESSION['admin']['username'] ?? 'Guest'); ?>
                        </span>
                    </div>
                    <a href="index.php?page=logout" class="btn-logout">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <div class="hero">
        <div class="container-lg">
            <div class="hero-inner">
                <div class="hero-badge"><i class="bi bi-bar-chart-fill"></i> Dashboard Admin</div>
                <h1 class="hero-title">Kelola Aspirasi Siswa 🎓</h1>
                <p class="hero-sub">Tinjau, tanggapi, dan selesaikan setiap aspirasi yang masuk</p>

                <?php
                $total = count($pengaduan);
                $menunggu = count(array_filter($pengaduan, fn($p) => $p['status'] === 'Menunggu'));
                $proses = count(array_filter($pengaduan, fn($p) => $p['status'] === 'Proses'));
                $selesai = count(array_filter($pengaduan, fn($p) => $p['status'] === 'Selesai'));
                $ditolak = count(array_filter($pengaduan, fn($p) => $p['status'] === 'Ditolak'));
                ?>
                <div class="stats-grid">
                    <div class="stat-card" style="animation-delay:.08s">
                        <div class="stat-icon">📋</div>
                        <div class="stat-num" data-target="<?php echo $total; ?>">0</div>
                        <div class="stat-lbl"><span class="stat-dot" style="background:#fff;opacity:.6"></span>Total
                            Masuk</div>
                    </div>
                    <div class="stat-card" style="animation-delay:.16s">
                        <div class="stat-icon">⏳</div>
                        <div class="stat-num" data-target="<?php echo $menunggu; ?>">0</div>
                        <div class="stat-lbl"><span class="stat-dot" style="background:#fbbf24"></span>Menunggu</div>
                    </div>
                    <div class="stat-card" style="animation-delay:.24s">
                        <div class="stat-icon">🔄</div>
                        <div class="stat-num" data-target="<?php echo $proses; ?>">0</div>
                        <div class="stat-lbl"><span class="stat-dot" style="background:#60a5fa"></span>Diproses</div>
                    </div>
                    <div class="stat-card" style="animation-delay:.32s">
                        <div class="stat-icon">✅</div>
                        <div class="stat-num" data-target="<?php echo $selesai; ?>">0</div>
                        <div class="stat-lbl"><span class="stat-dot" style="background:#34d399"></span>Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main-wrap">
        <div class="container-lg">

            <?php if (!empty($_GET['success'])): ?>
                <div class="alert-success-custom">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Review berhasil disimpan dan siswa telah mendapat tanggapan.</span>
                </div>
            <?php endif; ?>

            <div class="panel">
                <!-- PANEL HEAD -->
                <div class="panel-head">
                    <div class="panel-head-left">
                        <div class="ph-icon"><i class="bi bi-clipboard2-data-fill"></i></div>
                        <div>
                            <p class="ph-title">Daftar Aspirasi</p>
                            <p class="ph-sub">Klik tombol Review untuk mengelola setiap aspirasi</p>
                        </div>
                    </div>
                    <span class="total-badge"><?php echo $total; ?> entri</span>
                </div>

                <!-- FILTER BAR -->
                <div class="filter-bar">
                    <span class="filter-label">Filter:</span>
                    <a href="index.php?page=admin"
                        class="ftab <?php echo empty($_GET['filter_status']) ? 'active' : ''; ?>">Semua</a>
                    <?php foreach ([
                        'Menunggu' => '⏳',
                        'Proses' => '🔄',
                        'Selesai' => '✅',
                        'Ditolak' => '❌',
                    ] as $s => $em): ?>
                        <a href="index.php?page=admin&filter_status=<?php echo $s; ?>"
                            class="ftab <?php echo ($_GET['filter_status'] ?? '') === $s ? 'active' : ''; ?>">
                            <?php echo "$em $s"; ?>
                        </a>
                    <?php endforeach; ?>

                    <div class="search-wrap">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="search-input" id="tableSearch" placeholder="Cari NIS, kategori...">
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-wrap">
                    <?php if (empty($pengaduan)): ?>
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <div class="empty-title">Tidak Ada Aspirasi</div>
                            <p class="empty-sub">Belum ada aspirasi yang masuk sesuai filter ini.</p>
                        </div>
                    <?php else: ?>
                        <table id="mainTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Siswa</th>
                                    <th>Kategori</th>
                                    <th>Lokasi</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pengaduan as $i => $p):
                                    $status = $p['status'] ?? 'Menunggu';
                                    $namaKat = htmlspecialchars($kategoriMap[$p['id_kategori']] ?? 'N/A');
                                    $ketFull = htmlspecialchars($p['ket']);
                                    $ketShort = mb_strlen($p['ket']) > 50
                                        ? mb_substr($ketFull, 0, 50) . '…'
                                        : $ketFull;
                                    $badgeClass = match ($status) {
                                        'Menunggu' => 'sb-menunggu' . ($status === 'Menunggu' ? ' pulse' : ''),
                                        'Proses' => 'sb-proses',
                                        'Selesai' => 'sb-selesai',
                                        'Ditolak' => 'sb-ditolak',
                                        default => 'sb-menunggu',
                                    };
                                    $initials = mb_strtoupper(mb_substr($p['nis'], 0, 2));
                                    ?>
                                    <tr style="animation-delay: <?php echo $i * 0.05; ?>s"
                                        data-search="<?php echo strtolower($p['nis'] . ' ' . $namaKat . ' ' . $p['lokasi']); ?>">
                                        <td><span class="id-badge">#<?php echo $p['id_pelaporan']; ?></span></td>
                                        <td>
                                            <div class="nis-chip">
                                                <div class="nis-avatar"><?php echo $initials; ?></div>
                                                <span class="nis-text"><?php echo htmlspecialchars($p['nis']); ?></span>
                                            </div>
                                        </td>
                                        <td><span class="cat-tag"><i class="bi bi-tag-fill"></i><?php echo $namaKat; ?></span>
                                        </td>
                                        <td>
                                            <span class="loc-text">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                <?php echo htmlspecialchars($p['lokasi']); ?>
                                            </span>
                                        </td>
                                        <td><span class="ket-short"
                                                title="<?php echo $ketFull; ?>"><?php echo $ketShort; ?></span></td>
                                        <td><span class="sbadge <?php echo $badgeClass; ?>"><?php echo $status; ?></span></td>
                                        <td>
                                            <button class="btn-review" data-id="<?= $p['id_pelaporan']; ?>"
                                                data-nis="<?= htmlspecialchars($p['nis']); ?>" data-kat="<?= $namaKat; ?>"
                                                data-lokasi="<?= htmlspecialchars($p['lokasi']); ?>"
                                                data-ket="<?= htmlspecialchars($p['ket']); ?>" data-status="<?= $status; ?>"
                                                data-feedback="<?= htmlspecialchars($p['feedback'] ?? ''); ?>"
                                                data-idkat="<?= (int) $p['id_kategori']; ?>" onclick="handleReview(this)">
                                                <i class="bi bi-pencil-fill"></i> Review
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="custom-modal-backdrop" id="reviewModal">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-id">Review Aspirasi</div>
                <div class="modal-header-title" id="modalTitle">—</div>
                <button class="modal-close" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-item-label"><i class="bi bi-person-fill"></i> NIS Siswa</div>
                        <div class="info-item-value" id="mNis">—</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label"><i class="bi bi-geo-alt-fill"></i> Lokasi</div>
                        <div class="info-item-value" id="mLokasi">—</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label"><i class="bi bi-tag-fill"></i> Kategori</div>
                        <div class="info-item-value" id="mKat">—</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label"><i class="bi bi-circle-fill"></i> Status Saat Ini</div>
                        <div class="info-item-value" id="mStatusBadge">—</div>
                    </div>
                    <div class="info-item info-full">
                        <div class="info-item-label"><i class="bi bi-chat-left-text-fill"></i> Isi Aspirasi</div>
                        <div class="info-item-value" id="mKet"
                            style="white-space:pre-wrap;line-height:1.65;font-weight:400;color:var(--mid)">—</div>
                    </div>
                </div>

                <div id="mPrevFeedback" class="prev-feedback" style="display:none">
                    <div class="pf-label"><i class="bi bi-chat-dots-fill"></i> Feedback Sebelumnya</div>
                    <div class="pf-text" id="mPrevFeedbackText">—</div>
                </div>

                <hr class="divider">

                <form id="reviewForm" data-id="" data-kategori="">
                    <div class="form-section-title">Update Status & Tanggapan</div>

                    <div class="mb-3">
                        <div class="form-label-m"><i class="bi bi-toggle-on"></i> Ubah Status</div>
                        <div class="status-grid" id="statusGrid">
                            <div class="status-opt" data-status="Menunggu" onclick="pickStatus('Menunggu',this)">
                                <span class="s-em">⏳</span>Menunggu
                            </div>
                            <div class="status-opt" data-status="Proses" onclick="pickStatus('Proses',this)">
                                <span class="s-em">🔄</span>Diproses
                            </div>
                            <div class="status-opt" data-status="Selesai" onclick="pickStatus('Selesai',this)">
                                <span class="s-em">✅</span>Selesai
                            </div>
                            <div class="status-opt" data-status="Ditolak" onclick="pickStatus('Ditolak',this)">
                                <span class="s-em">❌</span>Ditolak
                            </div>
                        </div>
                        <select id="modal-status-field" name="status" style="display:none">
                            <option value="Menunggu">Menunggu</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-m" for="modalFeedback">
                            <i class="bi bi-chat-left-text-fill"></i> Tanggapan / Feedback <span
                                style="color:#d93025">*</span>
                        </label>
                        <textarea class="form-control-m" id="modalFeedback" name="feedback" rows="4"
                            placeholder="Berikan tanggapan yang jelas dan informatif untuk siswa..."
                            required></textarea>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-cancel-m" onclick="closeModal()">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn-save-m" id="saveBtn">
                            <div class="spinner" id="saveSpinner"></div>
                            <i class="bi bi-check-circle-fill" id="saveIcon"></i>
                            <span id="saveTxt">Simpan Review</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TOAST CONTAINER -->
    <div class="toast-wrap" id="toastWrap"></div>

    <script>
        /* ─── COUNT-UP ANIMATION ─── */
        document.querySelectorAll('.stat-num[data-target]').forEach(el => {
            const target = parseInt(el.dataset.target);
            if (target === 0) { el.textContent = '0'; return; }
            let cur = 0;
            const step = Math.ceil(target / 25);
            const timer = setInterval(() => {
                cur = Math.min(cur + step, target);
                el.textContent = cur;
                if (cur >= target) clearInterval(timer);
            }, 40);
        });

        /* ─── TABLE STAGGER ─── */
        document.querySelectorAll('tbody tr').forEach((tr, i) => {
            tr.style.opacity = '0';
            tr.style.transform = 'translateY(10px)';
            tr.style.transition = `opacity .3s ease ${i * .05}s, transform .3s ease ${i * .05}s`;
            setTimeout(() => {
                tr.style.opacity = '1';
                tr.style.transform = 'translateY(0)';
            }, 80);
        });

        /* ─── SEARCH ─── */
        document.getElementById('tableSearch')?.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#mainTable tbody tr').forEach(tr => {
                tr.style.display = tr.dataset.search.includes(q) ? '' : 'none';
            });
        });

        /* ─── MODAL ─── */
        let currentId = null;

        const statusMap = {
            'Menunggu': 'sel-menunggu',
            'Proses': 'sel-proses',
            'Selesai': 'sel-selesai',
            'Ditolak': 'sel-ditolak',
        };
        const badgeMap = {
            'Menunggu': '<span class="sbadge sb-menunggu">Menunggu</span>',
            'Proses': '<span class="sbadge sb-proses">Proses</span>',
            'Selesai': '<span class="sbadge sb-selesai">Selesai</span>',
            'Ditolak': '<span class="sbadge sb-ditolak">Ditolak</span>',
        };

        function openModal(id, nis, kat, lokasi, ket, status, feedback, idKat) {
            currentId = id;
            document.getElementById('modalTitle').textContent = `Aspirasi #${id}`;
            document.getElementById('mNis').textContent = nis;
            document.getElementById('mLokasi').textContent = lokasi;
            document.getElementById('mKat').textContent = kat;
            document.getElementById('mStatusBadge').innerHTML = badgeMap[status] || status;
            document.getElementById('mKet').textContent = ket;

            const prevBox = document.getElementById('mPrevFeedback');
            if (feedback) {
                prevBox.style.display = '';
                document.getElementById('mPrevFeedbackText').textContent = feedback;
            } else {
                prevBox.style.display = 'none';
            }

            document.getElementById('modalFeedback').value = feedback || '';
            document.getElementById('reviewForm').dataset.id = id;
            document.getElementById('reviewForm').dataset.kategori = idKat;

            pickStatus(status);

            const modal = document.getElementById('reviewModal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('reviewModal').classList.remove('show');
            document.body.style.overflow = '';
        }

        function pickStatus(val, el) {
            // 1. Bersihkan semua class aktif dari grid status
            document.querySelectorAll('.status-opt').forEach(o => {
                o.classList.remove('sel-menunggu', 'sel-proses', 'sel-selesai', 'sel-ditolak');
            });

            // 2. Jika dipanggil manual tanpa klik (dari openModal), cari elemennya berdasarkan data-status
            if (!el) {
                el = document.querySelector(`.status-opt[data-status="${val}"]`);
            }

            // 3. Jika elemen ditemukan, beri class warna sesuai status
            if (el) {
                const colorClass = statusMap[val] || '';
                if (colorClass) {
                    el.classList.add(colorClass);
                }

                // 4. SINKRONISASI: Masukkan nilai ke input select yang akan dikirim ke server
                const field = document.getElementById('modal-status-field');
                if (field) {
                    field.value = val;
                    console.log("Status terpilih:", field.value); // Untuk debug
                }
            }
        }

        function handleReview(btn) {
            // Ambil semua data dari atribut data-*
            const id = btn.getAttribute('data-id');
            const nis = btn.getAttribute('data-nis');
            const kat = btn.getAttribute('data-kat');
            const lokasi = btn.getAttribute('data-lokasi');
            const ket = btn.getAttribute('data-ket');
            const status = btn.getAttribute('data-status');
            const feedback = btn.getAttribute('data-feedback');
            const idKat = btn.getAttribute('data-idkat');

            // Panggil fungsi openModal yang sudah ada
            openModal(id, nis, kat, lokasi, ket, status, feedback, idKat);
        }

        /* ─── SUBMIT ─── */
        document.getElementById('reviewForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const id = parseInt(this.dataset.id);
            const idKat = parseInt(this.dataset.kategori);
            const status = document.getElementById('modal-status-field').value;
            const feedback = document.getElementById('modalFeedback').value.trim();

            if (!feedback) { showToast('⚠️ Feedback tidak boleh kosong', 'error'); return; }
            if (!status) { showToast('⚠️ Pilih status terlebih dahulu', 'error'); return; }

            const btn = document.getElementById('saveBtn');
            const spin = document.getElementById('saveSpinner');
            const icon = document.getElementById('saveIcon');
            const txt = document.getElementById('saveTxt');
            btn.disabled = true;
            spin.style.display = 'block';
            icon.style.display = 'none';
            txt.textContent = 'Menyimpan...';

            try {
                const res = await fetch('index.php?page=admin_review', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id_pelaporan: id, status, feedback, id_kategori: idKat }),
                });
                const json = await res.json().catch(() => ({}));

                if (res.ok && json.success) {
                    showToast('✅ Review berhasil disimpan!', 'success');
                    closeModal();
                    setTimeout(() => window.location.reload(), 1300);
                } else {
                    showToast('❌ ' + (json.error || 'Terjadi kesalahan server'), 'error');
                }
            } catch {
                showToast('❌ Tidak dapat menghubungi server', 'error');
            } finally {
                btn.disabled = false;
                spin.style.display = 'none';
                icon.style.display = '';
                txt.textContent = 'Simpan Review';
            }
        });

        /* ─── TOAST ─── */
        function showToast(msg, type = 'info') {
            const wrap = document.getElementById('toastWrap');
            const el = document.createElement('div');
            el.className = `toast-item ${type}`;
            const icons = { success: '✅', error: '❌', info: 'ℹ️' };
            el.innerHTML = `<span class="toast-em">${icons[type] || 'ℹ️'}</span><span>${msg}</span>`;
            wrap.appendChild(el);
            setTimeout(() => {
                el.style.transition = 'opacity .3s, transform .3s';
                el.style.opacity = '0';
                el.style.transform = 'translateY(10px)';
                setTimeout(() => el.remove(), 300);
            }, 3200);
        }

    </script>
</body>

</html>