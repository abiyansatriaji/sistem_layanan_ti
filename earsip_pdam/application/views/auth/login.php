<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap" rel="stylesheet">
    <style>
        /* ===== RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #2563eb 100%);
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        /* ===== Background Ornaments ===== */
        body::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -10%;
            width: 50%;
            height: 80%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 40%;
            height: 60%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* ===== Floating Particles ===== */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            pointer-events: none;
            animation: float-particle 25s ease-in-out infinite alternate;
        }

        .particle:nth-child(1) { width: 350px; height: 350px; top: -120px; right: -100px; animation-delay: 0s; }
        .particle:nth-child(2) { width: 250px; height: 250px; bottom: -80px; left: -80px; animation-delay: -6s; }
        .particle:nth-child(3) { width: 180px; height: 180px; top: 50%; right: -50px; animation-delay: -12s; }

        @keyframes float-particle {
            0% { transform: translate(0, 0) scale(1); opacity: 0.2; }
            100% { transform: translate(50px, -40px) scale(1.3); opacity: 0.5; }
        }

        /* ============================================================
           LOGIN WRAPPER (2 kolom)
           ============================================================ */
        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            max-width: 1000px;
            width: 100%;
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.40), 0 0 0 1px rgba(255, 255, 255, 0.06);
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        /* ===== LEFT SIDE - BRANDING ===== */
        .login-brand {
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            color: #fff;
            position: relative;
            isolation: isolate;

            /* ===== FOTO BACKGROUND SISI KIRI ===== */
            background-color: #0f2440;
            background-image: url('<?= base_url("assets/img/bg-pdam.png"); ?>');
            background-size: cover;
            background-position: 62% center;
            background-repeat: no-repeat;
        }

        /* Lapisan gelap tipis agar teks putih tetap terbaca */
        .login-brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                rgba(30, 64, 175, 0.55) 0%,
                rgba(15, 36, 64, 0.80) 50%,
                rgba(10, 26, 51, 0.92) 100%);
            z-index: -1;
        }

        .login-brand .brand-logo {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .login-brand .brand-logo .logo-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #60a5fa;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .login-brand .brand-logo .logo-icon.has-img {
            background: #ffffff;
            padding: 6px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.30);
        }

        .login-brand .brand-logo .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-brand .brand-logo .logo-text {
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            opacity: 0.9;
            line-height: 1.3;
        }

        .login-brand .brand-logo .logo-text strong {
            display: block;
            font-size: 1.6rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.02em;
            opacity: 1;
        }

        .login-brand .brand-title {
            font-size: 2.4rem;
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: 12px;
        }

        .login-brand .brand-title span {
            color: #93c5fd;
        }

        .login-brand .brand-desc {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 320px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .login-brand .brand-features {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .login-brand .brand-features .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            opacity: 0.95;
        }

        .login-brand .brand-features .feature-item i {
            color: #60a5fa;
            font-size: 1rem;
            width: 20px;
        }

        /* ===== RIGHT SIDE - FORM ===== */
        .login-form {
            background: #ffffff;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form .form-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-form .form-header h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .login-form .form-header h3 span {
            color: #2563eb;
        }

        .login-form .form-header p {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        /* ===== Form Controls ===== */
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
            margin-bottom: 4px;
        }

        /* ===== INPUT GROUP PASSWORD DENGAN TOGGLE ===== */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            border-radius: 12px;
            padding: 12px 48px 12px 16px;
            border: 2px solid #e2e8f0;
            font-size: 0.95rem;
            background: #f8fafc;
            transition: all 0.25s ease;
            color: #0f172a;
            width: 100%;
        }

        .password-wrapper .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.10);
            background: #ffffff;
        }

        .password-wrapper .form-control::placeholder {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 1.1rem;
            cursor: pointer;
            padding: 4px;
            transition: var(--transition, all 0.3s ease);
            z-index: 5;
        }

        .password-toggle:hover {
            color: #2563eb;
        }

        .password-toggle:focus {
            outline: none;
        }

        /* ===== Button ===== */
        .btn-login {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.30);
            position: relative;
            overflow: hidden;
            margin-top: 4px;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.10), transparent);
            transition: left 0.6s ease;
        }

        .btn-login:hover::after {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.40);
            color: #fff;
        }

        /* ===== Alert ===== */
        .alert {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            border: none;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
        }

        /* ===== Back Link ===== */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .back-link:hover {
            color: #2563eb;
            text-decoration: none;
        }

        /* ===== Demo Box ===== */
        .demo-box {
            background: #f1f5f9;
            border-radius: 14px;
            padding: 16px 18px;
            margin-top: 18px;
            border: 1px solid #e2e8f0;
        }

        .demo-box .demo-title {
            font-weight: 600;
            font-size: 0.75rem;
            color: #475569;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .demo-box .demo-title i {
            color: #3b82f6;
            margin-right: 6px;
        }

        .demo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 12px;
        }

        .demo-item {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px 6px;
            font-size: 0.75rem;
            color: #334155;
            padding: 2px 0;
        }

        .demo-item .badge-role {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            padding: 1px 8px;
            border-radius: 20px;
            font-size: 0.55rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            flex-shrink: 0;
        }

        .demo-item .badge-role.super {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
        }
        .demo-item .badge-role.admin {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
        }
        .demo-item .badge-role.pimpinan {
            background: linear-gradient(135deg, #d97706, #f59e0b);
        }
        .demo-item .badge-role.staf {
            background: linear-gradient(135deg, #059669, #10b981);
        }

        .demo-item .username {
            font-weight: 500;
            color: #0f172a;
        }

        .demo-item .password {
            color: #94a3b8;
            font-size: 0.65rem;
        }

        /* ===== Footer ===== */
        .login-footer {
            text-align: center;
            margin-top: 16px;
            font-size: 0.7rem;
            color: #94a3b8;
        }

        .login-footer a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-footer a:hover {
            color: #3b82f6;
        }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 992px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                max-width: 480px;
                border-radius: 28px;
            }

            .login-brand {
                padding: 32px 30px 20px;
                align-items: center;
                text-align: center;
            }

            .login-brand .brand-title {
                font-size: 2rem;
            }

            .login-brand .brand-desc {
                max-width: 100%;
            }

            .login-brand .brand-features {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }

            .login-form {
                padding: 30px 28px 32px;
            }
        }

        @media (max-width: 576px) {
            .login-brand .brand-title {
                font-size: 1.6rem;
            }
            .login-brand .brand-logo .logo-text strong {
                font-size: 1.3rem;
            }
            .login-form {
                padding: 24px 18px 28px;
            }
            .demo-grid {
                grid-template-columns: 1fr;
            }
            .login-form .form-header h3 {
                font-size: 1.3rem;
            }
            .btn-login {
                padding: 12px;
                font-size: 0.9rem;
            }
            .password-wrapper .form-control {
                padding: 10px 44px 10px 14px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

    <!-- ===== Background Ornaments ===== -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <!-- ============================================================
    LOGIN WRAPPER (2 KOLOM)
    ============================================================ -->
    <div class="login-wrapper">

        <!-- ===== LEFT: BRANDING ===== -->
        <div class="login-brand">
            <div class="brand-logo">
                <div class="logo-icon has-img">
                    <img src="<?= base_url('assets/img/logo_perumda.png'); ?>" alt="Logo Perumda Air Minum Tirta Khatulistiwa">
                </div>
                <div class="logo-text">
                    <strong>PERUMDA</strong>
                    AIR MINUM TIRTA KHATULISTIWA
                </div>
            </div>

            <div class="brand-title">
                E-Arsip <span>Digital</span>
            </div>

            <p class="brand-desc">
                Sistem manajemen surat menyurat digital yang terintegrasi untuk mendukung operasional Perumda Air Minum Tirta Khatulistiwa.
            </p>

            <div class="brand-features">
                <span class="feature-item">
                    <i class="fas fa-check-circle"></i> Surat Masuk & Keluar
                </span>
                <span class="feature-item">
                    <i class="fas fa-check-circle"></i> Disposisi Berjenjang
                </span>
                <span class="feature-item">
                    <i class="fas fa-check-circle"></i> Laporan & Ekspor
                </span>
                <span class="feature-item">
                    <i class="fas fa-check-circle"></i> Multi-User Role
                </span>
            </div>
        </div>

        <!-- ===== RIGHT: FORM ===== -->
        <div class="login-form">

            <div class="form-header">
                <h3>Login <span>E-Arsip</span></h3>
                <p>Masuk ke sistem manajemen surat digital</p>
            </div>

            <!-- Alert -->
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <!-- Form Login - dengan autocomplete OFF -->
            <?= form_open('index.php/auth/login', ['autocomplete' => 'off']); ?>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user me-2" style="color: #94a3b8;"></i>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock me-2" style="color: #94a3b8;"></i>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required autocomplete="new-password">
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk
                </button>
            <?= form_close(); ?>

            <!-- Tombol Kembali -->
            <div style="margin-top: 14px; text-align: center;">
                <a href="<?= base_url('index.php/'); ?>" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Landing Page
                </a>
            </div>

            <!-- Akun Demo -->
            <div class="demo-box">
                <div class="demo-title">
                    <i class="fas fa-flask"></i> Akun Demo
                </div>
                <div class="demo-grid">
                    <div class="demo-item">
                        <span class="badge-role super">Super Admin</span>
                        <span class="username">superadmin</span>
                        <span class="password">/ superadmin123</span>
                    </div>
                    <div class="demo-item">
                        <span class="badge-role admin">Admin</span>
                        <span class="username">admin</span>
                        <span class="password">/ admin123</span>
                    </div>
                    <div class="demo-item">
                        <span class="badge-role pimpinan">Pimpinan</span>
                        <span class="username">pimpinan</span>
                        <span class="password">/ pimpinan123</span>
                    </div>
                    <div class="demo-item">
                        <span class="badge-role staf">Staf</span>
                        <span class="username">staf</span>
                        <span class="password">/ staf123</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                &copy; <?= date('Y'); ?> <a href="#" style="font-weight: 500; color: #1e293b;">PDAM Tirta Khatulistiwa</a>
            </div>

        </div>
        <!-- end login-form -->

    </div>
    <!-- end login-wrapper -->

    <!-- ============================================================
    SCRIPTS - Toggle Password
    ============================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== TOGGLE PASSWORD SHOW/HIDE =====
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    // Toggle tipe input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Ganti ikon
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    }

                    // Beri efek fokus
                    passwordInput.focus();
                });

                // Opsional: toggle dengan shortcut keyboard (Ctrl+Shift+P)
                document.addEventListener('keydown', function(e) {
                    if (e.ctrlKey && e.shiftKey && (e.key === 'P' || e.key === 'p')) {
                        e.preventDefault();
                        togglePassword.click();
                    }
                });
            }
        });
    </script>

</body>
</html>