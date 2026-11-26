<div class="col-md-2 sidebar p-0">
    <h5><i class="bi bi-droplet-fill"></i> PDAM TI</h5>
    <div class="px-2 pb-3 small opacity-75"><?= $user['nama'] ?> — <?= $user['nama_role'] ?></div>
    <a href="<?= site_url('dashboard') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="<?= site_url('tiket') ?>"><i class="bi bi-ticket-perforated"></i> Tiket</a>
    <?php if (in_array($user['nama_role'], ['Pelapor','Admin'])): ?>
        <a href="<?= site_url('tiket/create') ?>"><i class="bi bi-plus-circle"></i> Buat Tiket</a>
    <?php endif; ?>
    <?php if ($user['nama_role'] === 'Admin'): ?>
        <a href="<?= site_url('user') ?>"><i class="bi bi-people"></i> User</a>
        <a href="<?= site_url('master/roles') ?>"><i class="bi bi-diagram-3"></i> Master Data</a>
    <?php endif; ?>
    <?php if (in_array($user['nama_role'], ['Admin','Kepala TI'])): ?>
        <a href="<?= site_url('laporan') ?>"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <?php endif; ?>
    <a href="<?= site_url('auth/logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>
<div class="col-md-10 p-4">
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>