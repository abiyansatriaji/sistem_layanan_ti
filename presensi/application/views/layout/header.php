<?php
$cur = uri_string() ?: 'dashboard';
$admin = in_array($user->role, ['super_admin', 'admin_hr']);
$menu = [
    ['dashboard', 'Dashboard', 'bi-grid-1x2-fill', TRUE],
    ['presensi', 'Presensi', 'bi-fingerprint', TRUE],
    ['cuti', 'Cuti & Izin', 'bi-calendar2-heart-fill', TRUE],
    ['cuti/approval', 'Persetujuan Cuti', 'bi-patch-check-fill', $user->role === 'atasan'],
    ['admin/pegawai', 'Data Pegawai', 'bi-people-fill', $admin],
    ['admin/libur', 'Hari Libur', 'bi-calendar-x-fill', $admin],
    ['admin/rekap', 'Rekap Laporan', 'bi-file-earmark-bar-graph-fill', $admin],
];
?><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= html_escape($title) ?> · Presensi & Cuti</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>
<body>
<div class="d-lg-none sidebar d-flex justify-content-between align-items-center py-2">
    <div class="brand"><i class="bi bi-droplet-half"></i> Presensi & Cuti</div>
    <button class="btn btn-sm btn-light" data-bs-toggle="collapse" data-bs-target="#side"><i class="bi bi-list fs-5"></i></button>
</div>
<aside class="sidebar collapse d-lg-flex flex-column" id="side">
    <div class="brand mb-4 d-none d-lg-flex"><i class="bi bi-droplet-half"></i><div>Presensi & Cuti<div class="fw-normal small opacity-75">Tirta Khatulistiwa</div></div></div>
    <nav class="nav flex-column mb-auto">
    <?php foreach ($menu as $mn): if (!$mn[3]) continue;
        $active = ($cur === $mn[0]) || ($mn[0] === 'cuti' && strpos($cur, 'cuti') === 0 && $cur !== 'cuti/approval'); ?>
        <a class="nav-link <?= $active ? 'active' : '' ?>" href="<?= site_url($mn[0]) ?>">
            <i class="bi <?= $mn[2] ?>"></i> <span class="flex-grow-1"><?= $mn[1] ?></span>
            <?php if ($mn[0] === 'cuti/approval' && $pending > 0): ?><span class="badge bg-danger rounded-pill"><?= $pending ?></span><?php endif; ?>
        </a>
    <?php endforeach; ?>
    </nav>
    <div class="userbox mt-4">
        <div class="fw-semibold"><?= html_escape($user->nama) ?></div>
        <div class="opacity-75 small mb-2"><?= role_label($user->role) ?></div>
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-light w-100"><i class="bi bi-box-arrow-right"></i> Keluar</a>
    </div>
</aside>
<main class="main p-3 p-lg-4">
<?php if ($fm = $this->session->flashdata('ok')): ?><div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle-fill"></i> <?= html_escape($fm) ?></div><?php endif; ?>
<?php if ($fm = $this->session->flashdata('err')): ?><div class="alert alert-danger border-0 shadow-sm"><i class="bi bi-exclamation-triangle-fill"></i> <?= html_escape($fm) ?></div><?php endif; ?>
