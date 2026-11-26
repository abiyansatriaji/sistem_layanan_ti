<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk · Presensi & Cuti</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>
<body>
<div class="login-wrap">
  <div class="login-card">
    <div class="login-logo"><i class="bi bi-droplet-half"></i></div>
    <h4 class="text-center fw-bold mb-1">Presensi & Cuti Pegawai</h4>
    <p class="text-center text-secondary mb-4">Perumda Air Minum Tirta Khatulistiwa</p>
    <?php if ($e = $this->session->flashdata('err')): ?><div class="alert alert-danger py-2"><?= html_escape($e) ?></div><?php endif; ?>
    <?= form_open('login') ?>
      <label class="form-label small fw-semibold">Username</label>
      <div class="input-group mb-3"><span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
        <input name="username" class="form-control" autofocus required></div>
      <label class="form-label small fw-semibold">Password</label>
      <div class="input-group mb-4"><span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
        <input type="password" name="password" class="form-control" required></div>
      <button class="btn btn-brand w-100 py-2">Masuk</button>
    <?= form_close() ?>
    <div class="mt-4 small text-secondary bg-light rounded-3 p-3">
      <b>Akun contoh</b> (password: <code>password123</code>)<br>
      superadmin · adminhr · budi.atasan · siti.pegawai
    </div>
  </div>
</div>
</body>
</html>
