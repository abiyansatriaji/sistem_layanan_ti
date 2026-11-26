<!-- ============================================================
     HALAMAN DAFTAR KLASIFIKASI - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0"><?= $title; ?></h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-folder me-1"></i> Kelola klasifikasi surat untuk memudahkan pengelompokan arsip
                    </p>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= base_url('index.php/klasifikasi/tambah'); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Klasifikasi
            </a>
        </div>
    </div>
</div>

<!-- ===== STATISTIK SINGKAT ===== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-primary-light">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-mini-info">
                <span class="stat-mini-number"><?= count($klasifikasi); ?></span>
                <span class="stat-mini-label">Total Klasifikasi</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== NOTIFIKASI ===== -->
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

<!-- ===== SEARCH FORM ===== -->
<div class="card-custom mb-4">
    <div class="card-body-custom p-3">
        <form action="<?= base_url('index.php/klasifikasi/cari'); ?>" method="post" class="row g-3" autocomplete="off">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="keyword" class="form-control border-start-0" 
                           placeholder="Cari berdasarkan Kode, Nama, atau Keterangan..." 
                           value="<?= isset($keyword) ? $keyword : ''; ?>" 
                           autocomplete="off">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </div>
        </form>
        <?php if(isset($keyword) && !empty($keyword)): ?>
            <div class="mt-2 text-muted small">
                <i class="fas fa-filter me-1"></i> Menampilkan hasil pencarian: <strong>"<?= $keyword; ?>"</strong>
                <a href="<?= base_url('index.php/klasifikasi'); ?>" class="ms-2 text-primary">Reset</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== TABEL KLASIFIKASI ===== -->
<div class="card-custom">
    <div class="card-header-custom">
        <div class="d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i> Daftar Klasifikasi</span>
            <span class="badge bg-primary rounded-pill"><?= count($klasifikasi); ?> Klasifikasi</span>
        </div>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom" id="table-klasifikasi">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th style="min-width:110px;">Kode</th>
                        <th>Nama Klasifikasi</th>
                        <th>Keterangan</th>
                        <th style="min-width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($klasifikasi)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-tags fa-2x d-block mb-2" style="color:#cbd5e1;"></i>
                                Belum ada data klasifikasi
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach($klasifikasi as $k): ?>
                        <tr>
                            <td class="text-center fw-bold" style="color:#64748b;"><?= $no++; ?></td>
                            <td>
                                <span class="badge-status" style="background:#dbeafe; color:#1e40af; font-weight:600;">
                                    <?= $k->kode_klasifikasi; ?>
                                </span>
                            </td>
                            <td><strong><?= $k->nama_klasifikasi; ?></strong></td>
                            <td><?= $k->keterangan ?: '<span class="text-muted">—</span>'; ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('index.php/klasifikasi/edit/' . $k->id); ?>" class="btn-action edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('index.php/klasifikasi/hapus/' . $k->id); ?>" class="btn-action delete" onclick="return confirm('Yakin hapus klasifikasi ini?')" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
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
     STYLE KHUSUS KLASIFIKASI
     ============================================================ -->
<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
    }

    .page-header .header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.3rem;
        box-shadow: 0 4px 16px rgba(30, 64, 175, 0.25);
    }

    /* ===== STAT MINI ===== */
    .stat-mini {
        background: #fff;
        border-radius: var(--radius, 14px);
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: var(--shadow-sm, 0 1px 3px rgba(0,0,0,0.06));
        border: 1px solid var(--slate-200, #e2e8f0);
        transition: var(--transition, all 0.3s ease);
        height: 100%;
    }

    .stat-mini:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md, 0 4px 20px rgba(0,0,0,0.07));
        border-color: var(--blue-200, #bfdbfe);
    }

    .stat-mini-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .bg-primary-light { background: #dbeafe; color: #1e40af; }

    .stat-mini-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .stat-mini-number {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--slate-800, #1e293b);
        letter-spacing: -0.02em;
    }

    .stat-mini-label {
        font-size: 0.75rem;
        color: var(--slate-500, #64748b);
        font-weight: 500;
    }

    /* ===== CARD CUSTOM ===== */
    .card-custom {
        background: #fff;
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

    /* ===== INPUT GROUP SEARCH ===== */
    .input-group-text {
        background: #fff;
        border: 1px solid var(--slate-200, #e2e8f0);
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: var(--slate-400, #94a3b8);
    }

    .input-group .form-control {
        border: 1px solid var(--slate-200, #e2e8f0);
        border-left: none;
        border-radius: 0 10px 10px 0;
        padding: 10px 16px;
        font-size: 0.95rem;
        background: #fff;
        transition: var(--transition, all 0.3s ease);
    }

    .input-group .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
        outline: none;
    }

    .input-group .form-control::placeholder {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    /* ===== TABEL ===== */
    .table-custom {
        font-size: 0.85rem;
        margin-bottom: 0;
        width: 100%;
        min-width: 600px;
    }

    .table-custom thead th {
        background: var(--slate-50, #f8fafc);
        color: var(--slate-600, #475569);
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-bottom: 2px solid var(--slate-200, #e2e8f0);
        padding: 12px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--slate-100, #f1f5f9);
        color: var(--slate-700, #334155);
        background: #fff;
    }

    .table-custom tbody tr:hover td {
        background: var(--blue-50, #eff6ff);
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== BADGE STATUS ===== */
    .badge-status {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.2px;
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
        font-size: 0.8rem;
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

    .btn-action.delete:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .page-header .header-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .page-header h4 {
            font-size: 1.1rem;
        }

        .stat-mini {
            padding: 12px 14px;
        }

        .stat-mini-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .stat-mini-number {
            font-size: 1.2rem;
        }

        .table-custom {
            font-size: 0.78rem;
            min-width: 500px;
        }

        .table-custom thead th,
        .table-custom tbody td {
            padding: 8px 10px;
        }

        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }

        .input-group .form-control {
            font-size: 0.85rem;
            padding: 8px 12px;
        }
    }

    @media (max-width: 576px) {
        .stat-mini-number {
            font-size: 1rem;
        }

        .stat-mini-label {
            font-size: 0.65rem;
        }

        .table-custom {
            min-width: 400px;
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