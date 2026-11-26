
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Layanan TI PDAM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1763c6;
            --primary-dark: #124a96;
            --text-dark: #1b2e48;
            --text-muted: #7b8798;
            --border: #e6ebf2;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            font-family: 'Poppins', sans-serif;
            background: #f2f5fa;
        }

        /* CONTAINER */

        .login-container {
            width: 100%;
            max-width: 1080px;
            min-height: 640px;
            display: grid;
            grid-template-columns: 46% 54%;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(25, 55, 95, 0.12);
        }

        /* PANEL KIRI */

        .left-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 38px 40px 28px;
            color: #fff;
            background:
                linear-gradient(
                    145deg,
                    rgba(9, 39, 91, 0.86),
                    rgba(17, 77, 145, 0.76),
                    rgba(7, 32, 76, 0.90)
                ),
                url('<?= base_url("assets/img/bg-pdam.png") ?>');
            background-size: cover;
            background-position: center;
        }

        /* LOGO */

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand img {
            width: 52px;
            height: 52px;
            padding: 5px;
            object-fit: contain;
            background: #fff;
            border-radius: 10px;
        }

        .brand-text strong {
            display: block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .4px;
        }

        .brand-text span {
            display: block;
            margin-top: 3px;
            font-size: 10px;
            color: rgba(255,255,255,.75);
            letter-spacing: .5px;
        }

        /* KONTEN KIRI */

        .welcome-content {
            margin: auto 0;
            padding: 70px 0;
        }

        .welcome-label {
            display: inline-block;
            margin-bottom: 20px;
            padding: 7px 12px;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 5px;
            background: rgba(255,255,255,.10);
            color: #d9ebff;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 1.2px;
        }

        .welcome-content h1 {
            max-width: 390px;
            margin-bottom: 17px;
            color: #fff;
            font-size: 34px;
            line-height: 1.4;
            font-weight: 700;
        }

        .welcome-content h1 span {
            color: #8bd3ff;
        }

        .welcome-content p {
            max-width: 365px;
            margin: 0;
            color: rgba(255,255,255,.83);
            font-size: 12px;
            line-height: 2;
            font-weight: 300;
        }

        .welcome-line {
            width: 48px;
            height: 3px;
            margin-top: 25px;
            border-radius: 5px;
            background: #80cfff;
        }

        /* FOOTER KIRI */

        .left-footer {
            display: flex;
            align-items: center;
            gap: 9px;
            padding-top: 18px;
            border-top: 1px solid rgba(255,255,255,.20);
            color: rgba(255,255,255,.75);
            font-size: 9px;
        }

        .left-footer i {
            font-size: 13px;
            color: #9bdcff;
        }

        /* PANEL KANAN */

        .right-panel {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 55px 65px 75px;
            background: #fff;
        }

        .login-content {
            width: 100%;
            max-width: 380px;
        }

        /* HEADER LOGIN */

        .login-heading {
            margin-bottom: 35px;
        }

        .login-heading h2 {
            margin-bottom: 10px;
            color: var(--text-dark);
            font-size: 27px;
            font-weight: 700;
        }

        .login-heading h2 span {
            color: var(--primary);
        }

        .login-heading p {
            margin: 0;
            color: var(--text-muted);
            font-size: 11px;
            line-height: 1.9;
        }

        .heading-line {
            width: 38px;
            height: 3px;
            margin-top: 20px;
            border-radius: 5px;
            background: var(--primary);
        }

        /* FORM */

        .form-label {
            margin-bottom: 9px;
            color: #34445b;
            font-size: 11px;
            font-weight: 600;
        }

        .input-group {
            height: 49px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fafbfd;
            transition: .2s;
        }

        .input-group:focus-within {
            border-color: #6a9de0;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(23,99,198,.08);
        }

        .input-group-text {
            padding-left: 15px;
            border: none;
            background: transparent;
            color: #8b9aaf;
            font-size: 14px;
        }

        .form-control {
            border: none;
            background: transparent;
            color: #263b56;
            font-size: 11px;
            box-shadow: none !important;
        }

        .form-control::placeholder {
            color: #a7b1bf;
            font-size: 10px;
        }

        .password-toggle {
            padding: 0 15px;
            border: none;
            background: transparent;
            color: #8797aa;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* TOMBOL */

        .btn-login {
            width: 100%;
            height: 49px;
            margin-top: 12px;
            border: none;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            transition: .2s;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            box-shadow: 0 7px 16px rgba(23,99,198,.18);
        }

        .btn-login i {
            margin-left: 7px;
        }

        /* INFORMASI */

        .login-info {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-top: 24px;
            padding-top: 17px;
            border-top: 1px solid #edf0f5;
        }

        .login-info i {
            margin-top: 2px;
            color: #6d91bd;
            font-size: 13px;
        }

        .login-info p {
            margin: 0;
            color: #8793a3;
            font-size: 9px;
            line-height: 1.8;
        }

        /* ALERT */

        .alert {
            border-radius: 8px;
            font-size: 11px;
        }

        /* FOOTER KANAN */

        .right-footer {
            position: absolute;
            right: 20px;
            bottom: 22px;
            left: 20px;
            color: #a0aab8;
            text-align: center;
            font-size: 9px;
        }

        /* TABLET */

        @media (max-width: 900px) {
            body {
                padding: 20px;
            }

            .login-container {
                grid-template-columns: 44% 56%;
                min-height: 590px;
            }

            .left-panel {
                padding: 30px 27px 25px;
            }

            .welcome-content h1 {
                font-size: 28px;
            }

            .right-panel {
                padding: 40px 35px 65px;
            }
        }

        /* MOBILE */

        @media (max-width: 700px) {
            body {
                display: block;
                padding: 0;
                background: #fff;
            }

            .login-container {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                border-radius: 0;
                box-shadow: none;
            }

            .left-panel {
                min-height: 330px;
                padding: 25px 24px;
            }

            .brand img {
                width: 45px;
                height: 45px;
            }

            .welcome-content {
                padding: 40px 0 20px;
            }

            .welcome-content h1 {
                font-size: 27px;
            }

            .welcome-content p {
                font-size: 11px;
            }

            .left-footer {
                margin-top: 15px;
            }

            .right-panel {
                min-height: 500px;
                padding: 45px 25px 75px;
            }

            .login-content {
                max-width: 430px;
            }

            .login-heading h2 {
                font-size: 25px;
            }
        }

        @media (max-width: 380px) {
            .welcome-content h1 {
                font-size: 24px;
            }

            .left-panel {
                min-height: 310px;
            }

            .right-panel {
                padding-right: 20px;
                padding-left: 20px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <!-- PANEL KIRI -->
    <section class="left-panel">

        <div class="brand">
            <img
                src="<?= base_url('assets/img/logo_perumda.png') ?>"
                alt="Logo Perumda Air Minum"
            >

            <div class="brand-text">
                <strong>PERUMDA AIR MINUM</strong>
                <span>TIRTA KHATULISTIWA</span>
            </div>
        </div>

        <div class="welcome-content">

            <div class="welcome-label">
                SISTEM INFORMASI LAYANAN TI
            </div>

            <h1>
                Layanan TI,<br>
                Lebih Mudah dan <span>Terarah.</span>
            </h1>

            <p>
                Platform layanan teknologi informasi untuk
                menyampaikan laporan gangguan dan permintaan
                layanan secara lebih mudah, terstruktur, dan efisien.
            </p>

            <div class="welcome-line"></div>

        </div>

        <div class="left-footer">
            <i class="bi bi-geo-alt-fill"></i>
            Perumda Air Minum Tirta Khatulistiwa · Pontianak
        </div>

    </section>


    <!-- PANEL KANAN -->
    <section class="right-panel">

        <div class="login-content">

            <div class="login-heading">

                <h2>
                    Selamat <span>Datang.</span>
                </h2>

                <p>
                    Masuk ke akun Anda untuk mengakses
                    sistem layanan Teknologi Informasi.
                </p>

                <div class="heading-line"></div>

            </div>


            <!-- PESAN ERROR -->
            <?php if ($this->session->flashdata('error')): ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    <i class="bi bi-exclamation-circle-fill me-2"></i>

                    <?= html_escape($this->session->flashdata('error')) ?>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                    </button>

                </div>

            <?php endif; ?>


            <!-- VALIDASI -->
            <?php if (validation_errors()): ?>

                <div class="alert alert-danger">
                    <?= validation_errors() ?>
                </div>

            <?php endif; ?>


            <!-- FORM LOGIN -->
            <form
                action="<?= base_url('index.php/auth/login') ?>"
                method="post">

                <?php if ($this->config->item('csrf_protection')): ?>
                    <input
                        type="hidden"
                        name="<?= $this->security->get_csrf_token_name() ?>"
                        value="<?= $this->security->get_csrf_hash() ?>"
                    >
                <?php endif; ?>


                <!-- USERNAME -->
                <div class="mb-4">

                    <label for="username" class="form-label">
                        Username
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>

                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="form-control"
                            placeholder="Masukkan username"
                            value="<?= html_escape(set_value('username')) ?>"
                            autocomplete="username"
                            required
                            autofocus
                        >

                    </div>

                </div>


                <!-- PASSWORD -->
                <div class="mb-3">

                    <label for="password" class="form-label">
                        Password
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-label="Tampilkan password">

                            <i class="bi bi-eye" id="eyeIcon"></i>

                        </button>

                    </div>

                </div>


                <!-- TOMBOL LOGIN -->
                <button type="submit" class="btn-login">
                    Masuk ke Sistem
                    <i class="bi bi-arrow-right"></i>
                </button>

            </form>


            <!-- INFORMASI -->
            <div class="login-info">

                <i class="bi bi-info-circle"></i>

                <p>
                    Gunakan akun yang telah terdaftar untuk
                    mengakses sistem layanan TI.
                </p>

            </div>

        </div>


        <!-- FOOTER -->
        <div class="right-footer">
            &copy; <?= date('Y') ?> Perumda Air Minum Tirta Khatulistiwa.
            All rights reserved.
        </div>

    </section>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
            togglePassword.setAttribute('aria-label', 'Sembunyikan password');
        } else {
            password.type = 'password';
            eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
            togglePassword.setAttribute('aria-label', 'Tampilkan password');
        }

    });
</script>

</body>
</html>
