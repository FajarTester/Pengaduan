<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspirasi Saya - Aplikasi Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #667eea;
            --primary-end: #764ba2;
            --primary-light: #eef0fd;
            --primary-mid: rgba(102, 126, 234, 0.12);
            --text-dark: #1a1d2e;
            --text-mid: #4a5068;
            --text-soft: #8b8fa8;
            --bg: #f4f5fb;
            --card-bg: #ffffff;
            --border: rgba(102, 126, 234, 0.15);
            --shadow-sm: 0 2px 12px rgba(102, 126, 234, 0.08);
            --shadow-md: 0 8px 32px rgba(102, 126, 234, 0.14);
            --shadow-lg: 0 20px 60px rgba(102, 126, 234, 0.18);
            --radius: 18px;
            --radius-sm: 10px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-end) 100%);
            box-shadow: 0 4px 24px rgba(102, 126, 234, 0.3);
            padding: 0 0;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
        }

        .navbar-brand-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            backdrop-filter: blur(6px);
        }

        .brand-text {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 17px;
            color: white;
            letter-spacing: -0.3px;
        }

        .brand-text span {
            opacity: 0.75;
            font-weight: 400;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
            padding: 6px 14px 6px 8px;
            backdrop-filter: blur(8px);
        }

        .user-avatar {
            width: 26px;
            height: 26px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 13px;
        }

        .user-info {
            color: white;
            font-size: 12.5px;
            font-weight: 600;
            line-height: 1;
        }

        .user-info small {
            font-weight: 400;
            opacity: 0.8;
            display: block;
            font-size: 11px;
            margin-top: 1px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none;
            transition: all .2s;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.28);
            color: white;
        }

        /* ── HERO STRIP ── */
        .page-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-end) 100%);
            padding: 32px 0 64px;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-family: 'Sora', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: white;
            margin: 0 0 6px;
            letter-spacing: -0.5px;
        }

        .hero-sub {
            color: rgba(255, 255, 255, 0.72);
            font-size: 14px;
            margin: 0;
        }

        .stats-row {
            display: flex;
            gap: 12px;
            margin-top: 22px;
        }

        .stat-chip {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 12px;
            padding: 10px 16px;
            color: white;
            backdrop-filter: blur(8px);
            flex: 1;
            text-align: center;
        }

        .stat-chip .num {
            font-family: 'Sora', sans-serif;
            font-size: 22px;
            font-weight: 700;
            display: block;
            line-height: 1;
        }

        .stat-chip .lbl {
            font-size: 11px;
            opacity: 0.75;
            margin-top: 3px;
            display: block;
        }

        /* ── MAIN LAYOUT ── */
        .main-wrap {
            margin-top: -36px;
            position: relative;
            z-index: 10;
            padding-bottom: 60px;
        }

        /* ── CARD ── */
        .panel {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .panel-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .panel-icon {
            width: 38px;
            height: 38px;
            background: var(--primary-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 17px;
            flex-shrink: 0;
        }

        .panel-title {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-dark);
            margin: 0;
        }

        .panel-sub {
            font-size: 12px;
            color: var(--text-soft);
            margin: 0;
        }

        .panel-body {
            padding: 20px 24px;
        }

        /* ── FILTER TABS ── */
        .filter-tabs {
            display: flex;
            gap: 6px;
            padding: 14px 24px;
            border-bottom: 1px solid var(--border);
            overflow-x: auto;
            scrollbar-width: none;
        }

        .filter-tabs::-webkit-scrollbar {
            display: none;
        }

        .ftab {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 600;
            border: 1.5px solid var(--border);
            background: transparent;
            color: var(--text-mid);
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s;
        }

        .ftab.active,
        .ftab:hover {
            background: linear-gradient(135deg, var(--primary), var(--primary-end));
            border-color: transparent;
            color: white;
        }

        /* ── ASPIRASI ITEM ── */
        .aspirasi-item {
            padding: 18px;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            margin-bottom: 12px;
            background: white;
            transition: all .22s;
            position: relative;
            overflow: hidden;
        }

        .aspirasi-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--primary), var(--primary-end));
            border-radius: 0 2px 2px 0;
        }

        .aspirasi-item:hover {
            box-shadow: var(--shadow-md);
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateY(-1px);
        }

        .aspirasi-item:last-child {
            margin-bottom: 0;
        }

        .ai-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
            gap: 10px;
        }

        .ai-id {
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            background: var(--primary-light);
            border-radius: 6px;
            padding: 3px 8px;
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.3px;
        }

        /* STATUS BADGES */
        .badge-status {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .s-menunggu {
            background: #fff8e1;
            color: #e6a800;
            border: 1px solid #ffe082;
        }

        .s-proses {
            background: #e8f0fe;
            color: #1a73e8;
            border: 1px solid #aecbfa;
        }

        .s-selesai {
            background: #e6f4ea;
            color: #1e8e3e;
            border: 1px solid #a8d5b5;
        }

        .s-ditolak {
            background: #fce8e6;
            color: #d93025;
            border: 1px solid #f5b8b4;
        }

        .ai-title {
            font-weight: 700;
            font-size: 14.5px;
            color: var(--text-dark);
            margin: 0 0 6px;
            line-height: 1.4;
        }

        .ai-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 8px;
        }

        .meta-tag {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--text-mid);
        }

        .meta-tag i {
            color: var(--primary);
            font-size: 13px;
        }

        .ai-desc {
            font-size: 13.5px;
            color: var(--text-mid);
            line-height: 1.65;
            margin-bottom: 0;
        }

        .feedback-box {
            background: linear-gradient(135deg, #f0f3ff 0%, #f5f0ff 100%);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            margin-top: 12px;
        }

        .feedback-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .feedback-text {
            font-size: 13px;
            color: var(--text-mid);
            line-height: 1.6;
        }

        .ai-actions {
            display: flex;
            gap: 8px;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px dashed var(--border);
        }

        .btn-edit {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 8px;
            background: #fff8e1;
            color: #e6a800;
            border: 1.5px solid #ffe082;
            text-decoration: none;
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit:hover {
            background: #ffe082;
            color: #b07d00;
        }

        .btn-del {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 8px;
            background: #fce8e6;
            color: #d93025;
            border: 1.5px solid #f5b8b4;
            text-decoration: none;
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-del:hover {
            background: #f5b8b4;
            color: #a50e0e;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            background: var(--primary-light);
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
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--text-soft);
        }

        /* ── FORM PANEL ── */
        .form-label {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-label i {
            color: var(--primary);
        }

        .form-control,
        .form-select {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13.5px;
            padding: 10px 14px;
            color: var(--text-dark);
            background: #fafbff;
            transition: all .2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.12);
            background: white;
        }

        textarea.form-control {
            resize: none;
        }

        .category-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px;
            margin-bottom: 4px;
        }

        .cat-option {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 9px 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-mid);
            transition: all .18s;
            background: #fafbff;
        }

        .cat-option:hover,
        .cat-option.selected {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
        }

        .cat-option .cat-em {
            font-size: 15px;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-end) 100%);
            border: none;
            color: white;
            font-weight: 700;
            font-size: 14px;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
            transition: all .22s;
            letter-spacing: 0.2px;
        }

        .btn-submit:hover {
            box-shadow: 0 10px 28px rgba(102, 126, 234, 0.5);
            transform: translateY(-1px);
            color: white;
        }

        /* ── TIPS BOX ── */
        .tips-box {
            background: linear-gradient(135deg, #f0f3ff 0%, #f5f0ff 100%);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px;
            margin-top: 16px;
        }

        .tips-title {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tips-list {
            margin: 0;
            padding-left: 0;
            list-style: none;
        }

        .tips-list li {
            font-size: 12px;
            color: var(--text-mid);
            padding: 3px 0;
            display: flex;
            gap: 6px;
        }

        .tips-list li::before {
            content: '✓';
            color: var(--primary);
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ── CHAR COUNTER ── */
        .char-counter {
            text-align: right;
            font-size: 11px;
            color: var(--text-soft);
            margin-top: 4px;
        }

        /* ── CATEGORY SELECT HIDDEN ── */
        #id_kategori {
            display: none;
        }

        @media (max-width: 768px) {
            .stats-row {
                gap: 8px;
            }

            .stat-chip .num {
                font-size: 18px;
            }

            .category-grid {
                grid-template-columns: 1fr 1fr;
            }

            .panel-body {
                padding: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container-lg">
            <div class="navbar-inner">
                <div class="navbar-brand-wrap">
                    <div class="brand-icon">📝</div>
                    <div>
                        <div class="brand-text">Aspirasi<span>Sekolah</span></div>
                    </div>
                </div>
                <div class="navbar-user">
                    <div class="user-chip">
                        <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
                        <div class="user-info">
                            <?php echo $_SESSION['user']['nis']; ?>
                            <small><?php echo $_SESSION['user']['kelas']; ?></small>
                        </div>
                    </div>
                    <a class="logout-btn" href="index.php?page=logout">
                        <i class="bi bi-box-arrow-right me-1"></i>Keluar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <div class="page-hero">
        <div class="container-lg">
            <div class="hero-content">
                <h1 class="hero-title">Suara Kamu, Perubahan Nyata 🎯</h1>
                <p class="hero-sub">Sampaikan aspirasi dan keluhan kamu untuk lingkungan sekolah yang lebih baik</p>
                <div class="stats-row">
                    <div class="stat-chip">
                        <span class="num"><?php echo count($pengaduan); ?></span>
                        <span class="lbl">Total Aspirasi</span>
                    </div>
                    <div class="stat-chip">
                        <span
                            class="num"><?php echo count(array_filter($pengaduan, fn($p) => ($p['status'] ?? 'Menunggu') === 'Menunggu')); ?></span>
                        <span class="lbl">Menunggu</span>
                    </div>
                    <div class="stat-chip">
                        <span
                            class="num"><?php echo count(array_filter($pengaduan, fn($p) => ($p['status'] ?? '') === 'Selesai')); ?></span>
                        <span class="lbl">Selesai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main-wrap">
        <div class="container-lg">
            <div class="row g-4">

                <!-- LIST ASPIRASI -->
                <div class="col-lg-7">
                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                            <div>
                                <p class="panel-title">Aspirasi Saya</p>
                                <p class="panel-sub">Riwayat pengaduan & aspirasi yang pernah dikirim</p>
                            </div>
                        </div>

                        <!-- FILTER TABS -->
                        <div class="filter-tabs">
                            <button class="ftab active" onclick="filterStatus('semua', this)">Semua</button>
                            <button class="ftab" onclick="filterStatus('Menunggu', this)">⏳ Menunggu</button>
                            <button class="ftab" onclick="filterStatus('Proses', this)">🔄 Diproses</button>
                            <button class="ftab" onclick="filterStatus('Selesai', this)">✅ Selesai</button>
                            <button class="ftab" onclick="filterStatus('Ditolak', this)">❌ Ditolak</button>
                        </div>

                        <div class="panel-body">
                            <?php if (empty($pengaduan)): ?>
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <div class="empty-title">Belum Ada Aspirasi</div>
                                    <p class="empty-sub">Kamu belum pernah mengirim aspirasi.<br>Yuk, sampaikan aspirasimu
                                        sekarang!</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($pengaduan as $p):
                                    $status = $p['status'] ?? 'Menunggu';
                                    $badgeClass = match ($status) {
                                        'Menunggu' => 's-menunggu',
                                        'Proses' => 's-proses',
                                        'Selesai' => 's-selesai',
                                        'Ditolak' => 's-ditolak',
                                        default => 's-menunggu'
                                    };
                                    ?>
                                    <div class="aspirasi-item" data-status="<?php echo $status; ?>">
                                        <div class="ai-top">
                                            <span class="ai-id">#<?php echo htmlspecialchars($p['id_pelaporan']); ?></span>
                                            <span class="badge-status <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                                        </div>
                                        <p class="ai-title"><?php echo htmlspecialchars($p['ket']); ?></p>
                                        <div class="ai-meta">
                                            <span class="meta-tag">
                                                <i class="bi bi-tag-fill"></i>
                                                <?php echo htmlspecialchars($kategoriMap[$p['id_kategori']] ?? 'N/A'); ?>
                                            </span>
                                            <span class="meta-tag">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                <?php echo htmlspecialchars($p['lokasi']); ?>
                                            </span>
                                        </div>
                                        <?php if (!empty($p['feedback'])): ?>
                                            <div class="feedback-box">
                                                <div class="feedback-label"><i class="bi bi-chat-dots-fill"></i> Tanggapan Admin
                                                </div>
                                                <div class="feedback-text"><?php echo htmlspecialchars($p['feedback']); ?></div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($status === 'Menunggu'): ?>
                                            <div class="ai-actions">
                                                <a href="index.php?page=aspirasi&action=edit&id=<?php echo $p['id_pelaporan']; ?>"
                                                    class="btn-edit">
                                                    <i class="bi bi-pencil-fill"></i> Edit
                                                </a>
                                                <a href="index.php?page=aspirasi&action=delete&id=<?php echo $p['id_pelaporan']; ?>"
                                                    class="btn-del" onclick="return confirm('Yakin ingin menghapus aspirasi ini?')">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- FORM ASPIRASI -->
                <div class="col-lg-5">
                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-icon"><i class="bi bi-plus-circle-fill"></i></div>
                            <div>
                                <p class="panel-title">Buat Aspirasi Baru</p>
                                <p class="panel-sub">Isi form di bawah ini dengan lengkap dan jelas</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="index.php?page=aspirasi&action=create">
                                <!-- KATEGORI -->
                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-grid-fill"></i> Kategori Masalah <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="id_kategori" name="id_kategori" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($kategori as $k): ?>
                                            <option value="<?php echo $k['id_kategori']; ?>">
                                                <?php echo htmlspecialchars($k['ket_kategori']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <!-- VISUAL CATEGORY GRID -->
                                    <div class="category-grid" id="catGrid">
                                        <div class="cat-option" onclick="selectCat(this, 'sarana')" data-val="sarana">
                                            <span class="cat-em">🏫</span> Sarana & Prasarana
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'kebersihan')"
                                            data-val="kebersihan">
                                            <span class="cat-em">🧹</span> Kebersihan
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'akademik')"
                                            data-val="akademik">
                                            <span class="cat-em">📚</span> Akademik & KBM
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'ekskul')" data-val="ekskul">
                                            <span class="cat-em">⚽</span> Ekstrakurikuler
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'bullying')"
                                            data-val="bullying">
                                            <span class="cat-em">🛡️</span> Bullying & Keamanan
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'kantin')" data-val="kantin">
                                            <span class="cat-em">🍱</span> Kantin & Makanan
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'toilet')" data-val="toilet">
                                            <span class="cat-em">🚽</span> Toilet & Sanitasi
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'perpustakaan')"
                                            data-val="perpustakaan">
                                            <span class="cat-em">📖</span> Perpustakaan
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'guru')" data-val="guru">
                                            <span class="cat-em">👩‍🏫</span> Guru & Staf
                                        </div>
                                        <div class="cat-option" onclick="selectCat(this, 'lainnya')" data-val="lainnya">
                                            <span class="cat-em">💬</span> Lainnya
                                        </div>
                                    </div>
                                </div>

                                <!-- LOKASI -->
                                <div class="mb-3">
                                    <label class="form-label" for="lokasi"><i class="bi bi-geo-alt-fill"></i> Lokasi
                                        Kejadian <span class="text-danger">*</span></label>
                                    <select class="form-select" id="lokasi" name="lokasi" required>
                                        <option value="">-- Pilih Lokasi --</option>
                                        <optgroup label="📦 Area Belajar">
                                            <option>Ruang Kelas</option>
                                            <option>Laboratorium IPA</option>
                                            <option>Laboratorium Komputer</option>
                                            <option>Perpustakaan</option>
                                            <option>Aula / Gedung Serba Guna</option>
                                        </optgroup>
                                        <optgroup label="🌿 Area Umum">
                                            <option>Halaman / Lapangan</option>
                                            <option>Kantin</option>
                                            <option>Toilet</option>
                                            <option>Parkiran</option>
                                            <option>Koridor / Selasar</option>
                                            <option>Pos Satpam</option>
                                        </optgroup>
                                        <optgroup label="🏢 Area Administrasi">
                                            <option>Ruang Guru</option>
                                            <option>Ruang Kepala Sekolah</option>
                                            <option>Tata Usaha</option>
                                            <option>Ruang BK</option>
                                            <option>UKS</option>
                                        </optgroup>
                                        <option value="lainnya">Lainnya (tulis di keterangan)</option>
                                    </select>
                                </div>

                                <!-- KETERANGAN -->
                                <div class="mb-3">
                                    <label class="form-label" for="ket"><i class="bi bi-chat-left-text-fill"></i>
                                        Keterangan Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="ket" name="ket" rows="4"
                                        placeholder="Jelaskan aspirasi atau keluhan kamu secara detail. Semakin jelas, semakin cepat ditangani! 💪"
                                        required maxlength="500" oninput="updateCount(this)"></textarea>
                                    <div class="char-counter"><span id="charCount">0</span> / 500 karakter</div>
                                </div>

                                <button type="submit" class="btn btn-submit">
                                    <i class="bi bi-send-fill me-2"></i>Kirim Aspirasi Sekarang
                                </button>
                            </form>

                            <div class="tips-box">
                                <div class="tips-title"><i class="bi bi-lightbulb-fill"></i> Tips Aspirasi yang Baik
                                </div>
                                <ul class="tips-list">
                                    <li>Jelaskan masalah secara spesifik dan jelas</li>
                                    <li>Sertakan lokasi kejadian dengan tepat</li>
                                    <li>Pilih kategori yang paling sesuai</li>
                                    <li>Gunakan bahasa yang sopan dan santun</li>
                                    <li>Aspirasi akan diproses dalam 1–3 hari kerja</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter by status
        function filterStatus(status, btn) {
            document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.aspirasi-item').forEach(item => {
                if (status === 'semua' || item.dataset.status === status) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Category grid selection (visual only, maps to select)
        function selectCat(el, val) {
            // 1. Efek visual: hapus kelas selected dari semua box, tambah ke yang diklik
            document.querySelectorAll('.cat-option').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');

            // 2. Sinkronisasi dengan elemen <select> yang asli
            const sel = document.getElementById('id_kategori');
            let found = false;

            for (let i = 0; i < sel.options.length; i++) {
                let opt = sel.options[i];
                // Mencari apakah teks di dropdown mengandung kata kunci dari grid (misal: "Sarana")
                if (opt.text.toLowerCase().includes(val.toLowerCase())) {
                    sel.selectedIndex = i;
                    found = true;
                    break;
                }
            }

            if (!found) console.warn("Kategori tidak ditemukan di dropdown utama");
        }

        // Char counter
        function updateCount(el) {
            document.getElementById('charCount').textContent = el.value.length;
        }

        // Smooth appear for items
        document.querySelectorAll('.aspirasi-item').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(14px)';
            el.style.transition = `opacity .35s ease ${i * 0.07}s, transform .35s ease ${i * 0.07}s`;
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 60);
        });
    </script>
</body>

</html>