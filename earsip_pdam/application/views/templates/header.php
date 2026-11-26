<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Arsip PDAM - <?= $title ?? 'Dashboard'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e3a5f;
            --primary-light: #2a4a7f;
            --primary-dark: #0f2440;
            --accent: #3182ce;
            --accent-light: #60a5fa;
            --accent-dark: #1e40af;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 20px rgba(0,0,0,0.07);
            --shadow-lg: 0 12px 48px rgba(0,0,0,0.10);
            --radius: 14px;
            --radius-sm: 10px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--slate-100);
            color: var(--slate-800);
            min-height: 100vh;
            padding-top: 68px;
        }

        /* ============================================================
           NAVBAR
           ============================================================ */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            transition: var(--transition);
            box-shadow: 0 2px 20px rgba(0,0,0,0.04);
        }

        .navbar-custom .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-custom .brand {
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--primary) !important;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .navbar-custom .brand i {
            color: var(--accent);
            font-size: 1.4rem;
        }

        /* Logo Perumda di pojok kiri navbar */
        .navbar-custom .brand .brand-logo {
            height: 44px;
            width: auto;
            object-fit: contain;
            flex-shrink: 0;
        }

        .navbar-custom .brand .sub {
            font-weight: 400;
            font-size: 0.65rem;
            color: var(--slate-500);
            display: block;
            margin-top: -2px;
            letter-spacing: 0.3px;
        }

        .navbar-custom .user-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .navbar-custom .user-info .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--slate-600);
            font-size: 1rem;
        }

        .navbar-custom .user-info .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--slate-800);
        }

        .navbar-custom .user-info .user-role {
            font-size: 0.7rem;
            background: var(--accent);
            color: #fff;
            padding: 2px 14px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .btn-logout-nav {
            color: var(--slate-500);
            background: transparent;
            border: 1.5px solid var(--slate-200);
            border-radius: var(--radius-sm);
            padding: 6px 16px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout-nav:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626;
            text-decoration: none;
        }

        /* ============================================================
           APP WRAPPER (untuk sidebar + konten)
           ============================================================ */
        .app-wrapper {
            display: flex;
            gap: 24px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px;
            min-height: calc(100vh - 68px - 80px);
        }

        /* ============================================================
           MAIN CONTENT
           ============================================================ */
        .main-content {
            flex: 1;
            min-width: 0;
        }

        /* ============================================================
           FOOTER
           ============================================================ */
        .app-footer {
            background: #ffffff;
            border-top: 1px solid var(--slate-200);
            padding: 16px 24px;
            text-align: center;
            color: var(--slate-400);
            font-size: 0.8rem;
            max-width: 1400px;
            margin: 0 auto 24px;
        }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 992px) {
            .app-wrapper {
                flex-direction: column;
                padding: 16px;
                gap: 16px;
            }
            .navbar-custom .user-info .user-name { display: none; }
            .navbar-custom .user-info .user-role { font-size: 0.6rem; padding: 1px 10px; }
        }

        @media (max-width: 576px) {
            body { padding-top: 60px; }
            .app-wrapper { padding: 12px; }
            .navbar-custom .brand { font-size: 0.95rem; }
            .navbar-custom .brand .brand-logo { height: 34px; }
            .navbar-custom .brand .sub { display: none; }
            .btn-logout-nav span { display: none; }
            .btn-logout-nav { padding: 6px 12px; }
            .app-footer { padding: 12px 16px; font-size: 0.7rem; }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar-custom">
    <div class="navbar-container">
        <a class="brand" href="<?= base_url('index.php/dashboard'); ?>">
            <img src="<?= base_url('assets/img/logo_perumda.png'); ?>"
                 alt="Logo Perumda Air Minum Tirta Khatulistiwa"
                 class="brand-logo">
            <div>
                E-Arsip PDAM
                <span class="sub">Sistem Manajemen Surat</span>
            </div>
        </a>
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <span class="user-name"><?= $this->session->userdata('nama') ?? 'User'; ?></span>
            <span class="user-role"><?= $this->session->userdata('role_name') ?? 'Staff'; ?></span>
            <a href="<?= base_url('index.php/auth/logout'); ?>" class="btn-logout-nav" onclick="return confirm('Yakin ingin logout?')">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</nav>

<!-- ===== APP WRAPPER ===== -->
<div class="app-wrapper">
<!-- (lanjutkan dengan sisa file Anda yang sudah ada: sidebar, konten, footer, dan penutup </div></body></html>) -->