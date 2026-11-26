<!-- ============================================================
     HALAMAN KELOLA USER
     ============================================================ -->

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-primary mb-0">
            <i class="fas fa-users-cog me-2"></i> Kelola User
        </h4>
        <p class="text-muted small mb-0">Manajemen akun pengguna sistem E-Arsip PDAM</p>
    </div>
    <div>
        <a href="<?= base_url('index.php/user/tambah'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah User
        </a>
        <a href="<?= base_url('index.php/dashboard'); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Alert Notifikasi -->
<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Card Tabel -->
<div class="card-custom">
    <div class="card-header-custom">
        <div class="d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i> Daftar Pengguna</span>
            <span class="badge bg-primary rounded-pill"><?= count($users ?? []); ?> User</span>
        </div>
    </div>
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom" id="table-user">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th width="100">Status</th>
                        <th width="280">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-user-slash fa-2x d-block mb-2"></i>
                                Belum ada user terdaftar
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no=1; foreach($users as $u): ?>
                        <tr>
                            <td class="fw-bold text-center"><?= $no++; ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar-sm">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span><?= $u->nama; ?></span>
                                </div>
                            </td>
                            <td><code><?= $u->username; ?></code></td>
                            <td>
                                <span class="badge-role <?= strtolower($u->nama_role ?? 'staf'); ?>">
                                    <?= $u->nama_role ?? 'Staf'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if($u->status == 'aktif'): ?>
                                    <span class="badge-status aktif"><i class="fas fa-circle me-1" style="font-size:6px;"></i> Aktif</span>
                                <?php else: ?>
                                    <span class="badge-status nonaktif"><i class="fas fa-circle me-1" style="font-size:6px;"></i> Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="<?= base_url('index.php/user/edit/' . $u->id); ?>" class="btn-action edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if($u->status == 'aktif'): ?>
                                        <a href="<?= base_url('index.php/user/nonaktifkan/' . $u->id); ?>" class="btn-action nonaktif" title="Nonaktifkan" onclick="return confirm('Nonaktifkan user ini?')">
                                            <i class="fas fa-user-slash"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('index.php//user/aktifkan/' . $u->id); ?>" class="btn-action aktifkan" title="Aktifkan" onclick="return confirm('Aktifkan user ini?')">
                                            <i class="fas fa-user-check"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if($u->id != $this->session->userdata('user_id')): ?>
                                        <a href="<?= base_url('/index.php//user/hapus/' . $u->id); ?>" class="btn-action hapus" title="Hapus" onclick="return confirm('Yakin hapus user ini?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================
     STYLE KHUSUS HALAMAN USER
     ============================================================ -->
<style>
    /* ===== CARD CUSTOM ===== */
    .card-custom {
        background: #ffffff;
        border-radius: var(--radius, 14px);
        box-shadow: var(--shadow-sm, 0 1px 3px rgba(0,0,0,0.06));
        border: 1px solid var(--slate-200, #e2e8f0);
        overflow: hidden;
        transition: var(--transition, all 0.3s ease);
    }

    .card-custom:hover {
        box-shadow: var(--shadow-md, 0 4px 20px rgba(0,0,0,0.07));
    }

    .card-header-custom {
        padding: 16px 22px;
        background: var(--slate-50, #f8fafc);
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
        font-weight: 600;
        color: var(--slate-700, #334155);
    }

    .card-body-custom {
        padding: 0;
        overflow-x: auto;
    }

    /* ===== TABEL ===== */
    .table-custom {
        font-size: 0.88rem;
        margin-bottom: 0;
        width: 100%;
        min-width: 700px;
    }

    .table-custom thead th {
        background: var(--slate-50, #f8fafc);
        color: var(--slate-600, #475569);
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-bottom: 2px solid var(--slate-200, #e2e8f0);
        padding: 12px 16px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid var(--slate-100, #f1f5f9);
        color: var(--slate-700, #334155);
        background: #ffffff;
    }

    .table-custom tbody tr:hover td {
        background: var(--blue-50, #eff6ff);
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== USER AVATAR ===== */
    .user-avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--blue-100, #dbeafe);
        color: var(--blue-600, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    /* ===== BADGE ROLE ===== */
    .badge-role {
        display: inline-block;
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .badge-role.superadmin {
        background: linear-gradient(135deg, #7c3aed, #8b5cf6);
        color: #fff;
    }

    .badge-role.admin {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: #fff;
    }

    .badge-role.pimpinan {
        background: linear-gradient(135deg, #d97706, #f59e0b);
        color: #fff;
    }

    .badge-role.staf {
        background: var(--slate-200, #e2e8f0);
        color: var(--slate-600, #475569);
    }

    .badge-role.- {
        background: var(--slate-200, #e2e8f0);
        color: var(--slate-600, #475569);
    }

    /* ===== BADGE STATUS ===== */
    .badge-status {
        display: inline-block;
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .badge-status.aktif {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-status.nonaktif {
        background: #fee2e2;
        color: #991b1b;
    }

    /* ===== TOMBOL AKSI ===== */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid transparent;
        transition: var(--transition, all 0.3s ease);
        text-decoration: none;
        font-size: 0.85rem;
        color: var(--slate-500, #64748b);
        background: var(--slate-50, #f8fafc);
        border-color: var(--slate-200, #e2e8f0);
    }

    .btn-action:hover {
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-action.edit:hover {
        background: #dbeafe;
        border-color: #60a5fa;
        color: #2563eb;
    }

    .btn-action.nonaktif:hover {
        background: #fef3c7;
        border-color: #fcd34d;
        color: #d97706;
    }

    .btn-action.aktifkan:hover {
        background: #d1fae5;
        border-color: #34d399;
        color: #065f46;
    }

    .btn-action.hapus:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }

        .table-custom {
            font-size: 0.78rem;
            min-width: 600px;
        }

        .table-custom thead th,
        .table-custom tbody td {
            padding: 8px 10px;
        }

        .badge-role,
        .badge-status {
            font-size: 0.6rem;
            padding: 2px 10px;
        }
    }

    @media (max-width: 576px) {
        .card-header-custom {
            padding: 12px 14px;
            font-size: 0.9rem;
        }

        .table-custom {
            min-width: 500px;
            font-size: 0.7rem;
        }

        .table-custom thead th,
        .table-custom tbody td {
            padding: 6px 8px;
        }

        .btn-action {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
            border-radius: 6px;
        }
    }
</style>