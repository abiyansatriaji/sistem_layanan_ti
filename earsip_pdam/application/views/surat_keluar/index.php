<!-- ============================================================
     HALAMAN SURAT KELUAR - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0"><?= $title; ?></h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-envelope me-1"></i> Kelola surat keluar yang dikirim oleh perusahaan
                    </p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('index.php/surat_keluar/tambah'); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Surat Keluar
            </a>
            <a href="<?= base_url('index.php/surat_keluar/cetak_semua'); ?>" class="btn btn-success" target="_blank">
                <i class="fas fa-print me-1"></i> Cetak Pdf
            </a>
        </div>
    </div>
</div>

<!-- ===== STATISTIK SINGKAT ===== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-primary-light">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-mini-info">
                <span class="stat-mini-number"><?= count($surat_keluar); ?></span>
                <span class="stat-mini-label">Total Surat</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-warning-light">
                <i class="fas fa-pencil-alt"></i>
            </div>
            <div class="stat-mini-info">
                <?php
                $total_draft = 0;
                foreach($surat_keluar as $s) {
                    if($s->status == 'draft') $total_draft++;
                }
                ?>
                <span class="stat-mini-number"><?= $total_draft; ?></span>
                <span class="stat-mini-label">Draft</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-info-light">
                <i class="fas fa-paper-plane"></i>
            </div>
            <div class="stat-mini-info">
                <?php
                $total_dikirim = 0;
                foreach($surat_keluar as $s) {
                    if(in_array($s->status, ['dikirim', 'terkirim'])) $total_dikirim++;
                }
                ?>
                <span class="stat-mini-number"><?= $total_dikirim; ?></span>
                <span class="stat-mini-label">Dikirim</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-success-light">
                <i class="fas fa-archive"></i>
            </div>
            <div class="stat-mini-info">
                <?php
                $total_arsip = 0;
                foreach($surat_keluar as $s) {
                    if($s->status == 'arsip') $total_arsip++;
                }
                ?>
                <span class="stat-mini-number"><?= $total_arsip; ?></span>
                <span class="stat-mini-label">Arsip</span>
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
        <form action="<?= base_url('index.php/surat_keluar/cari'); ?>" method="post" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="keyword" class="form-control border-start-0" 
                           placeholder="Cari berdasarkan No Surat, Tujuan, atau Perihal..." 
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
                <a href="<?= base_url('index.php/surat_keluar'); ?>" class="ms-2 text-primary">Reset</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== TABEL SURAT KELUAR ===== -->
<div class="card-custom">
    <div class="card-header-custom">
        <div class="d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i> Daftar Surat Keluar</span>
            <span class="badge bg-primary rounded-pill"><?= count($surat_keluar); ?> Surat</span>
        </div>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom" id="table-surat-keluar">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th style="min-width:130px;">No Surat</th>
                        <th>Tujuan</th>
                        <th>Perihal</th>
                        <th>Klasifikasi</th>
                        <th width="110">Tgl Surat</th>
                        <th width="100">Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($surat_keluar)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-envelope fa-2x d-block mb-2"></i>
                                Belum ada data surat keluar
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach($surat_keluar as $sk): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $no++; ?></td>
                            <td><strong><?= $sk->no_surat; ?></strong></td>
                            <td><?= $sk->tujuan; ?></td>
                            <td><?= substr($sk->perihal, 0, 45); ?><?= strlen($sk->perihal) > 45 ? '...' : ''; ?></td>
                            <td><?= $sk->nama_klasifikasi ?? '-'; ?></td>
                            <td><?= date('d-m-Y', strtotime($sk->tgl_surat)); ?></td>
                            <td>
                                <?php
                                $status_class = [
                                    'draft' => 'secondary',
                                    'dikirim' => 'primary',
                                    'terkirim' => 'success',
                                    'selesai' => 'success',
                                    'arsip' => 'secondary'
                                ];
                                ?>
                                <span class="badge-status <?= $sk->status; ?>"><?= ucfirst($sk->status); ?></span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('index.php/surat_keluar/detail/' . $sk->id); ?>" class="btn-action view" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('index.php/surat_keluar/edit/' . $sk->id); ?>" class="btn-action edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    </a>
                                    <a href="<?= base_url('index.php/surat_keluar/hapus/' . $sk->id); ?>" class="btn-action delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus surat ini?')">
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
     STYLE KHUSUS SURAT KELUAR
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
    .bg-warning-light { background: #fef3c7; color: #d97706; }
    .bg-info-light { background: #e0e7ff; color: #4338ca; }
    .bg-success-light { background: #d1fae5; color: #065f46; }

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
        font-size: 0.88rem;
        margin-bottom: 0;
        width: 100%;
        min-width: 800px;
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
        padding: 11px 16px;
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
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.2px;
    }

    .badge-status.draft { background: #f1f5f9; color: #475569; }
    .badge-status.dikirim { background: #dbeafe; color: #2563eb; }
    .badge-status.terkirim { background: #d1fae5; color: #065f46; }
    .badge-status.selesai { background: #d1fae5; color: #065f46; }
    .badge-status.arsip { background: #f1f5f9; color: #64748b; }

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

    .btn-action.view:hover {
        background: #dbeafe;
        border-color: #60a5fa;
        color: #2563eb;
    }

    .btn-action.edit:hover {
        background: #fef3c7;
        border-color: #fcd34d;
        color: #d97706;
    }

    .btn-action.print:hover {
        background: #d1fae5;
        border-color: #34d399;
        color: #065f46;
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
            font-size: 0.8rem;
            min-width: 650px;
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
            min-width: 550px;
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