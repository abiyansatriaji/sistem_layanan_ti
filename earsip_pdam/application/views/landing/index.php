<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Arsip PDAM Tirta Khatulistiwa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        /* ============================================================
           ROOT & RESET
           ============================================================ */
        :root {
            --blue-50: #f0f7ff;
            --blue-100: #e0f2fe;
            --blue-200: #bae6fd;
            --blue-300: #7dd3fc;
            --blue-400: #38bdf8;
            --blue-500: #0284c7;
            --blue-600: #0284c7;
            --blue-700: #0369a1;
            --blue-800: #075985;
            --blue-900: #0c4a6e;
            --blue-950: #082f49;

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

            --primary: #0284c7;
            --primary-light: #38bdf8;
            --primary-dark: #0369a1;
            --primary-gradient: linear-gradient(135deg, #075985 0%, #0284c7 50%, #2563eb 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 8px 30px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 20px 40px rgba(15, 23, 42, 0.12);
            --radius: 18px;
            --radius-sm: 12px;
            --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #fcfdfe;
            color: var(--slate-800);
            line-height: 1.6;
            scroll-behavior: smooth;
            padding-top: 76px;
        }

        a {
            text-decoration: none;
        }

        /* ============================================================
           NAVBAR
           ============================================================ */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            padding: 12px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            transition: var(--transition);
        }

        .navbar-custom.scrolled {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 8px 0;
            background: rgba(255, 255, 255, 0.95);
        }

        .navbar-custom .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
        }

        .navbar-custom .brand {
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--blue-900) !important;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .navbar-custom .brand i {
            color: var(--blue-500);
            font-size: 1.6rem;
        }

        .navbar-custom .brand .sub {
            font-weight: 500;
            font-size: 0.72rem;
            color: var(--slate-500);
            display: block;
            margin-top: -1px;
            letter-spacing: 0.3px;
        }

        .navbar-custom .nav-menu {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .navbar-custom .nav-link {
            color: var(--slate-700) !important;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            white-space: nowrap;
        }

        .navbar-custom .nav-link:hover {
            color: var(--blue-600) !important;
            background: var(--blue-50);
        }

        .btn-login-nav {
            background: var(--primary-gradient);
            color: #fff !important;
            border: none;
            border-radius: var(--radius-sm);
            padding: 10px 24px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.25);
            white-space: nowrap;
            margin-left: 8px;
        }

        .btn-login-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(2, 132, 199, 0.35);
            color: #fff !important;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 68px;
            }
            .navbar-custom .brand {
                font-size: 1rem;
            }
            .navbar-custom .brand i {
                font-size: 1.3rem;
            }
            .navbar-custom .brand .sub {
                font-size: 0.6rem;
            }
            .navbar-custom .nav-link {
                padding: 6px 10px;
                font-size: 0.8rem;
            }
            .btn-login-nav {
                padding: 7px 16px;
                font-size: 0.8rem;
                gap: 6px;
                margin-left: 0;
            }
            .btn-login-nav .login-text {
                display: none;
            }
            .btn-login-nav i {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-custom .nav-link {
                padding: 4px 8px;
                font-size: 0.75rem;
            }
            .btn-login-nav {
                padding: 6px 12px;
            }
            .navbar-custom .brand {
                font-size: 0.85rem;
                gap: 8px;
            }
            .navbar-custom .brand i {
                font-size: 1.1rem;
            }
            .navbar-custom .brand .sub {
                font-size: 0.5rem;
            }
        }

        /* ============================================================
           HERO
           ============================================================ */
        .hero {
            background-color: #07192f;
            background-image:
                radial-gradient(circle at 80% 20%, rgba(2, 132, 199, 0.15) 0%, transparent 40%),
                linear-gradient(90deg, rgba(7, 25, 47, 0.94) 0%, rgba(7, 25, 47, 0.82) 45%, rgba(7, 25, 47, 0.45) 75%, rgba(7, 25, 47, 0.25) 100%),
                url('<?= base_url("assets/img/bg_perumda.png"); ?>');
            background-repeat: no-repeat, no-repeat, no-repeat;
            background-position: center, center, center 60%;
            background-size: cover, cover, cover;
            color: #fff;
            padding: 100px 0 100px;
            min-height: 640px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero > .container { width: 100%; }

        .hero::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 60%;
            height: 120%;
            background: radial-gradient(circle at 70% 50%, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero .badge-hero {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 8px 20px 8px 14px;
            border-radius: 100px;
            font-size: 0.825rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #e0f2fe;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .hero h1 {
            font-size: 3.4rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin-bottom: 22px;
        }

        .hero h1 .highlight {
            position: relative;
            display: inline-block;
            color: #7dd3fc;
        }

        .hero h1 .highlight::after {
            content: '';
            position: absolute;
            bottom: 6px;
            left: 0;
            right: 0;
            height: 8px;
            background: rgba(56, 189, 248, 0.3);
            border-radius: 4px;
            z-index: -1;
        }

        .hero .lead {
            font-size: 1.15rem;
            opacity: 0.9;
            max-width: 530px;
            margin-bottom: 32px;
            font-weight: 400;
            line-height: 1.7;
        }

        .hero .btn-group-hero {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 36px;
        }

        .hero .btn-hero-primary {
            background: #ffffff;
            color: var(--blue-800);
            border-radius: var(--radius-sm);
            padding: 14px 36px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .hero .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            background: #f8fafc;
            color: var(--blue-900);
        }

        .hero .btn-hero-outline {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(8px);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--radius-sm);
            padding: 13px 32px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .hero .btn-hero-outline:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.7);
            color: #fff;
            transform: translateY(-3px);
        }

        .hero .hero-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .hero .hero-tags .tag {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(6px);
            padding: 6px 18px;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .hero .hero-tags .tag i {
            color: #38bdf8;
            margin-right: 6px;
        }

        .hero .hero-visual {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero .hero-visual .hero-image-card {
            width: 100%;
            max-width: 580px;
            border-radius: 24px;
            overflow: hidden;
            background: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
            animation: float-card 6s ease-in-out infinite;
        }

        .hero .hero-visual .hero-image-card img {
            display: block;
            width: 100%;
            height: auto;
        }

        @keyframes float-card {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .hero .hero-visual .icon-ring {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: pulse-ring 4s ease-in-out infinite;
        }

        .hero .hero-visual .icon-ring i {
            font-size: 80px;
            opacity: 0.3;
            color: #fff;
        }

        @keyframes pulse-ring {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.85; }
        }

        /* ============================================================
           STATISTIK
           ============================================================ */
        .stat-section {
            padding: 60px 0;
            background: var(--slate-50);
            border-bottom: 1px solid var(--slate-200);
            position: relative;
        }

        .stat-card {
            background: #ffffff;
            border-radius: var(--radius);
            padding: 30px 24px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid rgba(226, 232, 240, 0.8);
            height: 100%;
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: var(--blue-200);
        }

        .stat-card .stat-icon {
            font-size: 1.5rem;
            color: var(--blue-600);
            margin-bottom: 12px;
            width: 52px;
            height: 52px;
            background: var(--blue-50);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card .number {
            font-size: 2.3rem;
            font-weight: 800;
            color: var(--slate-900);
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .stat-card .label {
            color: var(--slate-500);
            font-weight: 600;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        /* ============================================================
           SEJARAH PERUSAHAAN
           ============================================================ */
        .sejarah-section {
            padding: 100px 0;
            position: relative;
            background-color: #f8fafc;
            background-image:
                linear-gradient(180deg, rgba(248, 250, 252, 0.88) 0%, rgba(248, 250, 252, 0.75) 100%),
                url('<?= base_url("assets/img/bg-sejarah.jpg"); ?>');
            background-repeat: no-repeat, no-repeat;
            background-position: center, center;
            background-size: cover, cover;
            background-attachment: scroll, fixed;
        }

        .sejarah-section .timeline-wrap {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 40px 40px 16px 44px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--blue-50);
            color: var(--blue-700);
            font-weight: 700;
            font-size: 0.78rem;
            padding: 6px 18px;
            border-radius: 100px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 14px;
            border: 1px solid var(--blue-100);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--slate-900);
        }

        .section-subtitle {
            color: var(--slate-600);
            max-width: 640px;
            margin: 10px auto 0;
            font-size: 1.05rem;
        }

        .sejarah-section .section-subtitle {
            color: var(--slate-600);
        }

        .sejarah-section .sejarah-head {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 32px 28px;
            max-width: 780px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(255, 255, 255, 0.9);
        }

        .timeline {
            position: relative;
            padding-left: 32px;
            border-left: 2px dashed var(--blue-300);
            margin-top: 30px;
        }

        .sejarah-section .timeline {
            margin-top: 0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 36px;
            padding-left: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -40px;
            top: 4px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--blue-600);
            border: 4px solid #fff;
            box-shadow: 0 0 0 3px var(--blue-100);
        }

        .timeline-item .year {
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--blue-700);
            margin-bottom: 6px;
            display: inline-block;
            background: var(--blue-50);
            padding: 2px 12px;
            border-radius: 6px;
        }

        .timeline-item .desc {
            color: var(--slate-600);
            font-size: 0.95rem;
            margin-bottom: 0;
            line-height: 1.65;
        }

        /* ============================================================
           FITUR
           ============================================================ */
        .fitur-section {
            padding: 100px 0;
            background: #ffffff;
        }

        .fitur-card {
            background: #fff;
            border-radius: var(--radius);
            padding: 36px 30px;
            text-align: left;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            height: 100%;
            border: 1px solid var(--slate-200);
            position: relative;
            overflow: hidden;
        }

        .fitur-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            opacity: 0;
            transition: var(--transition);
        }

        .fitur-card:hover::before {
            opacity: 1;
        }

        .fitur-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }

        .fitur-card .icon {
            font-size: 1.5rem;
            color: var(--blue-600);
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--blue-50);
            width: 58px;
            height: 58px;
            border-radius: 16px;
            transition: var(--transition);
        }

        .fitur-card:hover .icon {
            background: var(--blue-600);
            color: #fff;
            transform: scale(1.05);
        }

        .fitur-card h5 {
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 10px;
            color: var(--slate-900);
        }

        .fitur-card p {
            color: var(--slate-500);
            font-size: 0.925rem;
            margin-bottom: 0;
            line-height: 1.6;
        }

        /* ============================================================
           CTA
           ============================================================ */
        .cta-section {
            background: var(--primary-gradient);
            color: #fff;
            padding: 90px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 200%;
            background: radial-gradient(circle at 80% 50%, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .cta-section .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-section h2 {
            font-weight: 800;
            font-size: 2.6rem;
            letter-spacing: -0.03em;
        }

        .cta-section .lead {
            opacity: 0.9;
            font-size: 1.15rem;
            font-weight: 400;
        }

        .btn-cta {
            background: #fff;
            color: var(--blue-800);
            border-radius: var(--radius-sm);
            padding: 16px 44px;
            font-weight: 700;
            font-size: 1rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            color: var(--blue-900);
            background: #f8fafc;
        }

        /* ============================================================
           KONTAK
           ============================================================ */
        .kontak-section {
            padding: 100px 0;
            background: var(--slate-50);
        }

        .kontak-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            border: 1px solid var(--slate-200);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .kontak-card:hover {
            border-color: var(--blue-200);
            box-shadow: var(--shadow-md);
        }

        .kontak-card .kontak-item {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            padding: 16px 0;
            border-bottom: 1px solid var(--slate-100);
        }

        .kontak-card .kontak-item:last-child {
            border-bottom: none;
        }

        .kontak-card .kontak-item i {
            color: var(--blue-600);
            font-size: 1.25rem;
            width: 44px;
            height: 44px;
            background: var(--blue-50);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .kontak-card .kontak-item .text {
            color: var(--slate-600);
            font-size: 0.95rem;
        }

        .kontak-card .kontak-item .text strong {
            color: var(--slate-900);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 2px;
        }

        .kontak-card .kontak-item a {
            color: var(--blue-600);
            font-weight: 500;
            transition: var(--transition);
        }

        .kontak-card .kontak-item a:hover {
            color: var(--blue-800);
        }

        .social-links {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--slate-100);
            color: var(--slate-700);
            font-size: 1.1rem;
            transition: var(--transition);
            border: 1px solid var(--slate-200);
        }

        .social-links a:hover {
            background: var(--blue-600);
            color: #fff;
            border-color: var(--blue-600);
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.25);
        }

        /* ============================================================
           FOOTER
           ============================================================ */
        .footer {
            background: var(--slate-900);
            color: rgba(255, 255, 255, 0.65);
            padding: 70px 0 30px;
        }

        .footer h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 20px;
            letter-spacing: -0.01em;
        }

        .footer .brand-footer {
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer .brand-footer i {
            color: var(--blue-400);
        }

        .footer a {
            color: rgba(255, 255, 255, 0.6);
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .footer a:hover {
            color: #fff;
        }

        .footer .social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 10px;
            margin-right: 8px;
            transition: var(--transition);
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer .social a:hover {
            background: var(--blue-600);
            color: #fff;
            transform: translateY(-2px);
            border-color: var(--blue-600);
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 10px;
        }

        .footer ul li i {
            font-size: 0.65rem;
            margin-right: 8px;
            color: var(--blue-400);
        }

        .footer hr {
            border-color: rgba(255, 255, 255, 0.08);
            margin: 40px 0 24px;
        }

        .footer .copy {
            font-size: 0.85rem;
            opacity: 0.6;
        }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 991px) {
            .hero h1 { font-size: 2.6rem; }
            .hero .lead { font-size: 1rem; }
            .section-title { font-size: 2.1rem; }
        }

        @media (max-width: 768px) {
            .hero { padding: 80px 0 60px; }
            .hero h1 { font-size: 2.1rem; }
            .hero .lead { font-size: 0.95rem; }
            .hero .btn-group-hero { flex-direction: column; width: 100%; }
            .hero .btn-group-hero .btn-hero-primary,
            .hero .btn-group-hero .btn-hero-outline { justify-content: center; width: 100%; }
            .hero .hero-visual .icon-ring { width: 140px; height: 140px; }
            .hero .hero-visual .icon-ring i { font-size: 56px; }
            .stat-card .number { font-size: 1.8rem; }
            .section-title { font-size: 1.8rem; }
            .sejarah-section, .fitur-section, .kontak-section, .cta-section { padding: 60px 0; }
            .cta-section h2 { font-size: 1.9rem; }
            .footer { padding: 50px 0 20px; }
            .timeline { padding-left: 20px; }
            .timeline-item { padding-left: 12px; }
            .timeline-item::before { left: -30px; width: 14px; height: 14px; }
            .sejarah-section .timeline-wrap { padding: 24px 20px 8px 24px; }
            .fitur-card { text-align: center; }
        }

        @media (max-width: 576px) {
            .hero h1 { font-size: 1.8rem; }
            .hero .hero-tags .tag { font-size: 0.7rem; padding: 4px 14px; }
            .fitur-card, .kontak-card { padding: 24px 20px; }
            .stat-card { padding: 20px 14px; }
            .stat-card .number { font-size: 1.6rem; }
        }

        @media (max-width: 991px) {
            .hero {
                display: block;
                min-height: 0;
                padding: 80px 0 60px;
                background-image:
                    linear-gradient(180deg, rgba(7, 25, 47, 0.92) 0%, rgba(7, 25, 47, 0.8) 100%),
                    url('<?= base_url("assets/img/bg_perumda.png"); ?>');
                background-position: center, center;
            }

            .sejarah-section {
                background-attachment: scroll, scroll;
            }
        }

        .navbar-custom .brand .brand-logo {
            height: 44px;
            width: auto;
            object-fit: contain;
            flex-shrink: 0;
        }
        @media (max-width: 768px) {
            .navbar-custom .brand .brand-logo { height: 36px; }
        }
        @media (max-width: 576px) {
            .navbar-custom .brand .brand-logo { height: 30px; }
        }

        /* ============================================================
           PREMIUM UI REFRESH — mempertahankan background asli
           ============================================================ */
        :root {
            --radius: 22px;
            --radius-sm: 14px;
            --shadow-sm: 0 8px 24px rgba(15, 23, 42, .055);
            --shadow-md: 0 18px 45px rgba(15, 23, 42, .10);
            --shadow-lg: 0 28px 65px rgba(15, 23, 42, .15);
        }

        html { scroll-padding-top: 88px; }
        body { overflow-x: hidden; }
        ::selection { background: rgba(56, 189, 248, .25); color: #082f49; }

        .navbar-custom {
            padding: 13px 0;
            box-shadow: 0 4px 24px rgba(15, 23, 42, .035);
        }
        .navbar-custom .brand { gap: 13px; }
        .navbar-custom .brand-logo {
            padding: 4px;
            background: #fff;
            border-radius: 12px;
            filter: drop-shadow(0 4px 8px rgba(2, 132, 199, .10));
        }
        .navbar-custom .nav-link { position: relative; }
        .navbar-custom .nav-link::after {
            content: "";
            position: absolute;
            left: 18px; right: 18px; bottom: 3px;
            height: 2px; border-radius: 10px;
            background: var(--blue-500);
            transform: scaleX(0); transform-origin: center;
            transition: transform .25s ease;
        }
        .navbar-custom .nav-link:hover::after { transform: scaleX(1); }

        /* Foto hero tetap menggunakan bg_perumda.png */
        .hero {
            min-height: 680px;
            padding: 112px 0 104px;
            background-position: center, center, center 56%;
            isolation: isolate;
        }
        .hero::after {
            content: "";
            position: absolute; inset: 0;
            z-index: -1; pointer-events: none;
            background: linear-gradient(0deg, rgba(4, 17, 34, .28), transparent 45%);
        }
        .hero .row { position: relative; }
        .hero .hero-content { max-width: 720px; }
        .hero .badge-hero {
            padding: 10px 18px 10px 14px;
            letter-spacing: .02em;
            background: rgba(8, 47, 73, .42);
            border-color: rgba(186, 230, 253, .30);
        }
        .hero h1 {
            font-size: clamp(2.65rem, 4.2vw, 4.15rem);
            line-height: 1.12;
            letter-spacing: -.045em;
            max-width: 720px;
            text-wrap: balance;
            text-shadow: 0 3px 24px rgba(0, 0, 0, .15);
        }
        .hero h1 .highlight { color: #7dd3fc; }
        .hero .lead {
            max-width: 570px;
            font-size: 1.08rem;
            color: rgba(255,255,255,.88);
        }
        .hero .btn-group-hero { gap: 12px; }
        .hero .btn-hero-primary, .hero .btn-hero-outline {
            min-height: 52px;
            border-radius: 14px;
        }
        .hero .btn-hero-primary { padding-inline: 27px; }
        .hero .btn-hero-outline { padding-inline: 24px; }
        .hero .hero-tags { gap: 9px; }
        .hero .hero-tags .tag {
            padding: 8px 14px;
            background: rgba(255,255,255,.09);
            border-color: rgba(255,255,255,.17);
        }

        .stat-section {
            padding: 42px 0;
            background: linear-gradient(180deg, #f1f7fc 0%, #f8fafc 100%);
        }
        .stat-card {
            padding: 27px 20px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(15,23,42,.045);
        }
        .stat-card .stat-icon {
            width: 56px; height: 56px;
            border-radius: 17px;
            background: linear-gradient(145deg, #e0f2fe, #f0f9ff);
        }
        .stat-card .number { font-size: clamp(1.7rem, 2.2vw, 2.25rem); }

        .sejarah-section {
            background-position: center, center;
            background-size: cover, cover;
        }
        .sejarah-section .sejarah-head {
            padding: 34px 30px;
            box-shadow: 0 18px 45px rgba(15,23,42,.09);
        }
        .sejarah-section .timeline-wrap {
            border-radius: 26px;
            padding: 42px 42px 18px 46px;
            box-shadow: 0 24px 65px rgba(15,23,42,.14);
            background: rgba(255,255,255,.94);
        }
        .timeline { border-left-style: solid; border-left-color: #bae6fd; }
        .timeline-item { margin-bottom: 34px; }
        .timeline-item .year { border: 1px solid #dbeafe; }

        .fitur-section { background: linear-gradient(180deg, #fff 0%, #f8fbff 100%); }
        .fitur-card {
            padding: 34px 30px;
            border-radius: 22px;
            box-shadow: 0 8px 26px rgba(15,23,42,.045);
        }
        .fitur-card::before { opacity: .7; height: 3px; }
        .fitur-card .icon {
            border-radius: 18px;
            background: linear-gradient(145deg, #e0f2fe, #f0f9ff);
        }
        .fitur-card:hover .icon {
            box-shadow: 0 10px 24px rgba(2,132,199,.22);
        }
        .fitur-card h5 { letter-spacing: -.015em; }

        .cta-section {
            background: var(--primary-gradient);
            padding: 92px 0;
        }
        .cta-section h2 {
            font-size: clamp(2rem, 3.5vw, 2.85rem);
            text-wrap: balance;
        }
        .btn-cta { border-radius: 15px; }

        .kontak-section {
            background: linear-gradient(180deg, #f1f7fc 0%, #f8fafc 100%);
        }
        .kontak-card {
            padding: 42px;
            border-radius: 26px;
            box-shadow: 0 15px 45px rgba(15,23,42,.065);
        }
        .kontak-card .kontak-item { padding: 19px 0; }
        .kontak-card .kontak-item i {
            border-radius: 15px;
            background: linear-gradient(145deg, #e0f2fe, #f0f9ff);
        }
        .social-links a { border-radius: 13px; }

        .footer {
            background: linear-gradient(145deg, #071426 0%, #0f172a 70%, #082f49 100%);
        }
        .footer .brand-footer i { color: #7dd3fc; }
        .footer .copy { line-height: 1.7; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
        @media (max-width: 991px) {
            .hero { min-height: auto; padding: 86px 0 76px; }
            .hero h1 { font-size: clamp(2.3rem, 5.5vw, 3.3rem); }
            .hero .hero-content { max-width: 760px; }
        }
        @media (max-width: 768px) {
            .navbar-custom .navbar-container { gap: 8px; }
            .navbar-custom .nav-menu { gap: 2px; }
            .navbar-custom .nav-link { padding: 7px 9px; }
            .hero { padding: 72px 0 60px; }
            .hero .badge-hero { margin-bottom: 20px; }
            .hero .lead { font-size: .98rem; }
            .stat-section { padding: 30px 0; }
            .stat-card { border-radius: 17px; }
            .sejarah-section .sejarah-head { padding: 26px 20px; }
            .sejarah-section .timeline-wrap { padding: 28px 20px 8px 24px; }
            .fitur-card { padding: 28px 22px; }
            .kontak-card { padding: 28px 24px; }
        }
        @media (max-width: 576px) {
            .navbar-custom .brand { gap: 7px; font-size: .78rem; }
            .navbar-custom .brand .sub { font-size: .52rem; }
            .navbar-custom .brand-logo { height: 29px; }
            .navbar-custom .nav-menu { gap: 0; }
            .navbar-custom .nav-link { padding: 6px 6px; font-size: .7rem; }
            .navbar-custom .nav-link::after { left: 6px; right: 6px; }
            .btn-login-nav { padding: 7px 10px; }
            .hero h1 { font-size: clamp(1.9rem, 8vw, 2.5rem); }
            .hero .btn-group-hero { gap: 10px; }
            .hero .btn-hero-primary, .hero .btn-hero-outline {
                width: 100%; justify-content: center; padding: 13px 16px;
            }
            .hero .hero-tags .tag { padding: 6px 10px; font-size: .68rem; }
            .section-title { font-size: 1.75rem; }
            .section-subtitle { font-size: .95rem; }
            .stat-card { padding: 19px 10px; }
            .stat-card .stat-icon { width: 45px; height: 45px; font-size: 1.2rem; }
            .stat-card .label { font-size: .76rem; }
            .kontak-card { padding: 22px 18px; }
            .kontak-card .kontak-item { gap: 12px; }
            .kontak-card .kontak-item i { width: 40px; height: 40px; font-size: 1.05rem; }
        }



        /* NAVBAR ACTIVE STATE: indikator menu yang sedang dipilih */
        .navbar-custom .nav-menu .nav-link {
            position: relative;
            isolation: isolate;
            transition: color .25s ease, background .25s ease, box-shadow .25s ease, transform .25s ease;
        }
        .navbar-custom .nav-menu .nav-link::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            border-radius: 12px;
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
            border: 1px solid rgba(2, 132, 199, .12);
            opacity: 0;
            transform: scale(.94);
            transition: opacity .25s ease, transform .25s ease;
        }
        .navbar-custom .nav-menu .nav-link.active,
        .navbar-custom .nav-menu .nav-link[aria-current="location"] {
            color: #0369a1 !important;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(2, 132, 199, .08);
        }
        .navbar-custom .nav-menu .nav-link.active::before,
        .navbar-custom .nav-menu .nav-link[aria-current="location"]::before {
            opacity: 1;
            transform: scale(1);
        }
        .navbar-custom .nav-menu .nav-link.active::after,
        .navbar-custom .nav-menu .nav-link[aria-current="location"]::after {
            transform: scaleX(1);
        }
        .navbar-custom .nav-menu .nav-link:focus-visible {
            outline: 3px solid rgba(14, 165, 233, .35);
            outline-offset: 3px;
        }
        @media (max-width: 576px) {
            .navbar-custom .nav-menu .nav-link::before { border-radius: 9px; }
        }

    </style>
</head>
<body>

    <!-- ============================================================
    NAVBAR
    ============================================================ -->
    <nav class="navbar-custom" id="navbar">
        <div class="container navbar-container">
            <a class="brand" href="#home">
                <img src="<?= base_url('assets/img/logo_perumda.png'); ?>" alt="Logo Perumda Air Minum Tirta Khatulistiwa" class="brand-logo" />
                <div>
                    Perumda Tirta Khatulistiwa
                    <span class="sub">E-Arsip Digital</span>
                </div>
            </a>
            <div class="nav-menu">
                <a href="#sejarah" class="nav-link">Sejarah</a>
                <a href="#fitur" class="nav-link">Fitur</a>
                <a href="#kontak" class="nav-link">Kontak</a>
                <a href="<?= base_url('index.php/auth'); ?>" class="btn-login-nav">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="login-text">Login</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- ============================================================
    HERO
    ============================================================ -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 hero-content">
                    <div class="badge-hero">
                        <i class="fas fa-circle" style="font-size: 6px; color: #38bdf8;"></i>
                        Sistem Digital Terintegrasi
                    </div>
                    <h1>
                        Kelola Surat Menyurat
                        <span class="highlight">Lebih Mudah</span>
                        &amp; Cepat
                    </h1>
                    <p class="lead">
                        E-Arsip PDAM adalah sistem manajemen surat digital untuk
                        Perumda Air Minum Tirta Khatulistiwa. Catat, lacak, dan
                        arsipkan semua surat dengan praktis.
                    </p>
                    <div class="btn-group-hero">
                        <a href="<?= base_url('index.php/auth'); ?>" class="btn-hero-primary">
                            <i class="fas fa-sign-in-alt"></i> Login Sekarang
                        </a>
                        <a href="#sejarah" class="btn-hero-outline">
                            <i class="fas fa-info-circle"></i> Sejarah Perusahaan
                        </a>
                    </div>
                    <div class="hero-tags">
                        <span class="tag"><i class="fas fa-check-circle"></i> Digital</span>
                        <span class="tag"><i class="fas fa-check-circle"></i> Terintegrasi</span>
                        <span class="tag"><i class="fas fa-check-circle"></i> Aman</span>
                        <span class="tag"><i class="fas fa-check-circle"></i> Real-time</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    STATISTIK (DATA REAL)
    ============================================================ -->
    <section class="stat-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-inbox"></i></div>
                        <div class="number"><?= number_format($total_surat_masuk ?? 1247); ?></div>
                        <div class="label">Surat Masuk</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
                        <div class="number"><?= number_format($total_surat_keluar ?? 876); ?></div>
                        <div class="label">Surat Keluar</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-share-alt"></i></div>
                        <div class="number"><?= number_format($total_disposisi ?? 432); ?></div>
                        <div class="label">Disposisi</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="number"><?= number_format($total_users ?? 68); ?></div>
                        <div class="label">Pengguna Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    SEJARAH PERUSAHAAN (timeline) - background foto gedung
    ============================================================ -->
    <section id="sejarah" class="sejarah-section">
        <div class="container">
            <div class="text-center mb-5 sejarah-head">
                <span class="section-badge"><i class="fas fa-clock-rotate-left me-1"></i> Perjalanan Kami</span>
                <h2 class="section-title">Sejarah Perusahaan</h2>
                <p class="section-subtitle">
                    Perumda Air Minum Tirta Khatulistiwa berkomitmen menyediakan air bersih bagi masyarakat Pontianak sejak 1959.
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="timeline-wrap">
                        <div class="timeline">
                            <!-- 1959 -->
                            <div class="timeline-item">
                                <div class="year">1959</div>
                                <div class="desc">
                                    Pembangunan sarana dan prasarana infrastruktur air bersih kota Pontianak dimulai.
                                </div>
                            </div>
                            <!-- 1962 -->
                            <div class="timeline-item">
                                <div class="year">1962</div>
                                <div class="desc">
                                    Dioperasikan dan dikelola oleh Pemerintah melalui Dinas Saluran Air Minum, ditandai dengan pembangunan Instalasi No. 1 Kap. 100 l/detik di Komp. IPA Imam Bonjol.
                                </div>
                            </div>
                            <!-- 1975 -->
                            <div class="timeline-item">
                                <div class="year">1975</div>
                                <div class="desc">
                                    Perusahaan Daerah Air Minum (PDAM) didirikan melalui PERDA Nomor 03 Tahun 1975.
                                </div>
                            </div>
                            <!-- 2009 -->
                            <div class="timeline-item">
                                <div class="year">2009</div>
                                <div class="desc">
                                    Perubahan PERDA melalui Peraturan Daerah Nomor 03 Tahun 2009 dan Pengaturan tentang Pelayanan Air Minum kepada pelanggan di atur dalam Peraturan Daerah Nomor 04 Tahun 2009.
                                </div>
                            </div>
                            <!-- 2020 -->
                            <div class="timeline-item">
                                <div class="year">2020</div>
                                <div class="desc">
                                    Perda No 1 tahun 2020 Tentang Perusahaan Umum Daerah Air Minum Tirta Khatulistiwa.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    FITUR
    ============================================================ -->
    <section id="fitur" class="fitur-section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-badge"><i class="fas fa-star me-1"></i> Fitur Unggulan</span>
                <h2 class="section-title">Solusi Lengkap untuk Arsip Digital</h2>
                <p class="section-subtitle">
                    Berbagai fitur dirancang untuk memudahkan pengelolaan surat
                    menyurat di lingkungan PDAM.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="fitur-card">
                        <div class="icon"><i class="fas fa-inbox"></i></div>
                        <h5>Surat Masuk</h5>
                        <p>Input surat dengan nomor agenda otomatis, upload lampiran, dan disposisi langsung.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card">
                        <div class="icon"><i class="fas fa-paper-plane"></i></div>
                        <h5>Surat Keluar</h5>
                        <p>Penomoran otomatis sesuai klasifikasi dan bagian, lengkap dengan lampiran.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card">
                        <div class="icon"><i class="fas fa-diagram-project"></i></div>
                        <h5>Disposisi Berjenjang</h5>
                        <p>Lacak alur disposisi dari pimpinan hingga staf dengan status real-time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card">
                        <div class="icon"><i class="fas fa-magnifying-glass"></i></div>
                        <h5>Pencarian Arsip</h5>
                        <p>Cari surat berdasarkan nomor, tanggal, perihal, pengirim, atau klasifikasi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card">
                        <div class="icon"><i class="fas fa-file-export"></i></div>
                        <h5>Laporan &amp; Ekspor</h5>
                        <p>Rekap surat per periode dengan ekspor ke Excel dan PDF.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card">
                        <div class="icon"><i class="fas fa-user-shield"></i></div>
                        <h5>Multi-User Role</h5>
                        <p>Hak akses berbeda untuk Super Admin, Admin, Pimpinan, dan Staf.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    CTA
    ============================================================ -->
    <section class="cta-section">
        <div class="container cta-content">
            <div class="text-center">
                <h2>Siap Beralih ke Sistem Digital?</h2>
                <p class="lead mb-4">
                    Kelola surat lebih efisien dan transparan dengan E-Arsip PDAM.
                </p>
                <a href="<?= base_url('index.php/auth'); ?>" class="btn-cta">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================
    KONTAK
    ============================================================ -->
    <section id="kontak" class="kontak-section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-badge"><i class="fas fa-address-card me-1"></i> Hubungi Kami</span>
                <h2 class="section-title">Kontak Perusahaan</h2>
                <p class="section-subtitle">
                    Hubungi kami melalui kontak dan media sosial resmi berikut.
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="kontak-card">
                        <!-- Alamat -->
                        <div class="kontak-item">
                            <i class="fas fa-location-dot"></i>
                            <div>
                                <div class="text"><strong>Alamat</strong></div>
                                <div class="text">
                                    <a href="https://www.google.com/maps?q=Jl.+Imam+Bonjol+No.+430,+Pontianak,+Kalimantan+Barat" target="_blank" style="color: var(--slate-600); text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                        📍 Jl. Imam Bonjol No. 430, Kota Pontianak, Kalimantan Barat
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Telepon -->
                        <div class="kontak-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <div class="text"><strong>Telepon</strong></div>
                                <div class="text">0561 - 769999</div>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="kontak-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <div class="text"><strong>Email</strong></div>
                                <div class="text">
                                    <a href="mailto:humas@pdamtirtakhatulistiwa.com">
                                        humas@pdamtirtakhatulistiwa.com
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Website -->
                        <div class="kontak-item">
                            <i class="fas fa-globe"></i>
                            <div>
                                <div class="text"><strong>Website</strong></div>
                                <div class="text">
                                    <a href="https://www.pdamtirtakhatulistiwa.com/site" target="_blank">
                                        pdamtirtakhatulistiwa.com
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Media Sosial -->
                        <div class="kontak-item" style="border-bottom: none; padding-bottom: 4px;">
                            <i class="fas fa-share-nodes"></i>
                            <div>
                                <div class="text"><strong>Media Sosial</strong></div>
                                <div class="social-links">
                                    <a href="https://www.youtube.com/@perumdamtirtakhatulistiwa" target="_blank" title="YouTube">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                    <a href="https://www.facebook.com/perumdamtirtakhatulistiwa/" target="_blank" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://www.instagram.com/perumdamtirtakhatulistiwa/" target="_blank" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="https://x.com/PerumdamTK" target="_blank" title="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    FOOTER
    ============================================================ -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="brand-footer mb-3">
                        <i class="fas fa-droplet"></i> Perumda Tirta Khatulistiwa
                    </div>
                    <p style="font-size: 0.9rem; max-width: 280px; line-height: 1.6;">
                        Sistem Manajemen Surat Menyurat Digital untuk Perumda Air Minum Tirta Khatulistiwa.
                    </p>
                    <div class="social">
                        <a href="https://www.youtube.com/@perumdamtirtakhatulistiwa" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.facebook.com/perumdamtirtakhatulistiwa/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/perumdamtirtakhatulistiwa/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://x.com/PerumdamTK" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Menu</h5>
                    <ul>
                        <li><a href="#home"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="#sejarah"><i class="fas fa-chevron-right"></i> Sejarah</a></li>
                        <li><a href="#fitur"><i class="fas fa-chevron-right"></i> Fitur</a></li>
                        <li><a href="#kontak"><i class="fas fa-chevron-right"></i> Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kontak</h5>
                    <ul style="font-size: 0.88rem;">
                        <li><i class="fas fa-phone"></i> 0561 - 769999</li>
                        <li><i class="fas fa-envelope"></i> humas@pdamtirtakhatulistiwa.com</li>
                        <li><i class="fas fa-location-dot"></i> Jl. Imam Bonjol No.430, Pontianak</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Ikuti Kami</h5>
                    <ul style="font-size: 0.88rem;">
                        <li><a href="https://x.com/PerumdamTK" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="https://www.instagram.com/perumdamtirtakhatulistiwa/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="https://www.youtube.com/@perumdamtirtakhatulistiwa" target="_blank"><i class="fab fa-youtube"></i> YouTube</a></li>
                    </ul>
                </div>
            </div>
            <hr />
            <div class="text-center">
                <p class="copy mb-1">&copy; 2026 Perumda Air Minum Tirta Khatulistiwa. All Rights Reserved.</p>
                <p class="copy mb-0" style="font-size: 0.75rem; opacity: 0.5;">Program Magang D3 Manajemen Informasi</p>
            </div>
        </div>
    </footer>

    <!-- ============================================================
    SCRIPTS
    ============================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const offset = 80;
                    const top = target.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });



        // Indikator aktif pada menu navbar: klik menu dan posisi scroll.
        (function () {
            const navLinks = Array.from(document.querySelectorAll('#navbar .nav-menu .nav-link[href^="#"]'));
            const sections = navLinks
                .map(link => document.querySelector(link.getAttribute('href')))
                .filter(Boolean);

            function setActiveLink(id) {
                navLinks.forEach(link => {
                    const isActive = link.getAttribute('href') === '#' + id;
                    link.classList.toggle('active', isActive);
                    if (isActive) {
                        link.setAttribute('aria-current', 'location');
                    } else {
                        link.removeAttribute('aria-current');
                    }
                });
            }

            // Saat menu diklik, indikator langsung berubah.
            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    const id = this.getAttribute('href').slice(1);
                    setActiveLink(id);
                });
            });

            // Saat pengguna scroll manual, menu yang sesuai ikut aktif.
            if ('IntersectionObserver' in window && sections.length) {
                const observer = new IntersectionObserver(entries => {
                    const visibleSections = entries
                        .filter(entry => entry.isIntersecting)
                        .sort((a, b) => b.intersectionRatio - a.intersectionRatio);
                    if (visibleSections.length) setActiveLink(visibleSections[0].target.id);
                }, {
                    root: null,
                    rootMargin: '-22% 0px -58% 0px',
                    threshold: [0, 0.1, 0.25, 0.5]
                });
                sections.forEach(section => observer.observe(section));
            }

            // Sinkronkan status jika halaman dibuka langsung melalui URL #section.
            const initialId = window.location.hash.slice(1);
            if (initialId && sections.some(section => section.id === initialId)) {
                setActiveLink(initialId);
            } else if (sections.length) {
                setActiveLink(sections[0].id);
            }
        })();

        // Hero visual pulse
        const ring = document.querySelector('.icon-ring');
        if (ring) {
            setInterval(() => {
                ring.style.transition = 'transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1)';
                ring.style.transform = 'scale(0.96)';
                setTimeout(() => {
                    ring.style.transform = 'scale(1)';
                }, 400);
            }, 4000);
        }
    </script>

</body>
</html>