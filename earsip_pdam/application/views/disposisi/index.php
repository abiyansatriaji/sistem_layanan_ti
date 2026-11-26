<!-- ============================================================
     HALAMAN DISPOSISI - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-share-alt"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0"><?= $title; ?></h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-envelope me-1"></i> Kelola disposisi surat masuk
                    </p>
                </div>
            </div>
        </div>
        <div>
            <?php if($notif_count > 0): ?>
            <span class="badge bg-danger rounded-pill" style="font-size:0.9rem; padding:6px 14px;">
                <i class="fas fa-bell"></i> <?= $notif_count; ?> baru
            </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ===== STATISTIK SINGKAT ===== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-primary-light">
                <i class="fas fa-share-alt"></i>
            </div>
            <div class="stat-mini-info">
                <span class="stat-mini-number"><?= count($disposisi); ?></span>
                <span class="stat-mini-label">Total Disposisi</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-warning-light">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-mini-info">
                <?php
                $total_menunggu = 0;
                foreach($disposisi as $d) {
                    if(in_array($d->status, ['terkirim', 'diterima', 'diproses'])) $total_menunggu++;
                }
                ?>
                <span class="stat-mini-number"><?= $total_menunggu; ?></span>
                <span class="stat-mini-label">Menunggu</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-success-light">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-mini-info">
                <?php
                $total_selesai = 0;
                foreach($disposisi as $d) {
                    if($d->status == 'selesai') $total_selesai++;
                }
                ?>
                <span class="stat-mini-number"><?= $total_selesai; ?></span>
                <span class="stat-mini-label">Selesai</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-icon bg-info-light">
                <i class="fas fa-inbox"></i>
            </div>
            <div class="stat-mini-info">
                <?php
                $total_surat = $this->db->count_all('surat_masuk');
                ?>
                <span class="stat-mini-number"><?= $total_surat; ?></span>
                <span class="stat-mini-label">Total Surat</span>
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

<!-- ===== TABEL DISPOSISI ===== -->
<div class="card-custom">
    <div class="card-header-custom">
        <div class="d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i> Daftar Disposisi</span>
            <span class="badge bg-primary rounded-pill"><?= count($disposisi); ?> Disposisi</span>
        </div>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom" id="table-disposisi">
                <thead>
                    <tr>
                        <th width="40">No</th>
                        <th style="min-width:110px;">No Agenda</th>
                        <th>Perihal</th>
                        <th>Dari</th>
                        <th>Untuk</th>
                        <th>Instruksi</th>
                        <th style="min-width:100px;">Catatan</th>
                        <th width="100">Status</th>
                        <th width="110">Tgl Disposisi</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($disposisi)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-share-alt fa-2x d-block mb-2" style="color:#cbd5e1;"></i>
                                Belum ada disposisi
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach($disposisi as $d): ?>
                        <tr>
                            <td class="text-center fw-bold" style="color:#64748b;"><?= $no++; ?></td>
                            <td><strong><?= $d->no_agenda ?? '-'; ?></strong></td>
                            <td><?= $d->perihal ? substr($d->perihal, 0, 35) . (strlen($d->perihal) > 35 ? '...' : '') : '-'; ?></td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold" style="color:var(--slate-800);"><?= $d->dari_nama ?? '-'; ?></span>
                                    <span class="text-muted" style="font-size:0.65rem;"><?= $d->dari_username ?? ''; ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold" style="color:var(--slate-800);"><?= $d->ke_nama ?? '-'; ?></span>
                                    <span class="text-muted" style="font-size:0.65rem;"><?= $d->ke_username ?? ''; ?></span>
                                </div>
                            </td>
                            <td><?= $d->instruksi ?? '-'; ?></td>
                            <td>
                                <?php if(!empty($d->catatan)): ?>
                                    <span class="badge-status" style="background:var(--slate-100); color:var(--slate-600); font-size:0.7rem; white-space:normal; display:inline-block; max-width:140px;">
                                        <i class="fas fa-sticky-note text-warning me-1"></i>
                                        <?= substr($d->catatan, 0, 30); ?><?= strlen($d->catatan) > 30 ? '...' : ''; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size:0.75rem;">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $status_class = '';
                                if($d->status == 'terkirim') {
                                    $status_class = 'terkirim';
                                } elseif($d->status == 'diterima') {
                                    $status_class = 'diterima';
                                } elseif($d->status == 'diproses') {
                                    $status_class = 'diproses';
                                } elseif($d->status == 'selesai') {
                                    $status_class = 'selesai';
                                } else {
                                    $status_class = 'draft';
                                }
                                ?>
                                <span class="badge-status <?= $status_class; ?>">
                                    <i class="fas <?= $d->status == 'terkirim' ? 'fa-paper-plane' : ($d->status == 'selesai' ? 'fa-check-double' : 'fa-circle'); ?> me-1" style="font-size:6px;"></i>
                                    <?= ucfirst($d->status ?? 'Draft'); ?>
                                </span>
                            </td>
                            <td style="font-size:0.8rem; color:var(--slate-600);"><?= date('d-m-Y', strtotime($d->tgl_disposisi)); ?></td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">

                                    <!-- ===== UPDATE STATUS ===== -->
                                    <?php if(in_array($this->session->userdata('role_id'), [1, 2, 3]) || $d->ke_user_id == $this->session->userdata('user_id')): ?>
                                        <?php if($d->status != 'selesai'): ?>
                                        <button class="btn-action edit" data-bs-toggle="modal" data-bs-target="#updateStatusModal<?= $d->id; ?>" title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- ===== TERUSKAN ===== -->
                                    <?php if((in_array($this->session->userdata('role_id'), [1, 2, 3]) || $d->ke_user_id == $this->session->userdata('user_id')) && $d->status != 'selesai'): ?>
                                    <a href="<?= base_url('index.php/disposisi/teruskan/' . $d->id); ?>" class="btn-action" title="Teruskan" style="color:#d97706; border-color:#fcd34d;">
                                        <i class="fas fa-share"></i>
                                    </a>
                                    <?php endif; ?>

                                    <!-- ===== RIWAYAT BERJENJANG + LAMPIRAN ===== -->
                                    <a href="<?= base_url('index.php/disposisi/riwayat/' . $d->surat_masuk_id); ?>" class="btn-action" title="Riwayat & Lampiran" style="color:#2563eb; border-color:#93c5fd;">
                                        <i class="fas fa-stream"></i>
                                    </a>

                                    <!-- ===== CETAK LEMBAR DISPOSISI (FISIK/PDF) ===== -->
                                    <a href="<?= base_url('index.php/disposisi/cetak/' . $d->id); ?>" class="btn-action" title="Cetak Lembar Disposisi" target="_blank" style="color:#0f172a; border-color:#94a3b8;">
                                        <i class="fas fa-print"></i>
                                    </a>

                                    <!-- ===== HAPUS ===== -->
                                    <?php if(in_array($this->session->userdata('role_id'), [1, 2])): ?>
                                    <a href="<?= base_url('index.php/disposisi/hapus/' . $d->id); ?>" class="btn-action delete" onclick="return confirm('Yakin hapus disposisi ini?')" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <?php endif; ?>

                                </div>

                                <!-- ===== MODAL UPDATE STATUS + CATATAN ===== -->
                                <div class="modal fade" id="updateStatusModal<?= $d->id; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title fw-bold">
                                                    <i class="fas fa-edit text-primary me-2"></i>Update Status Disposisi
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?= base_url('index.php/disposisi/update_status/' . $d->id); ?>" method="post">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="fw-semibold" style="font-size:0.85rem;">Status <span class="text-danger">*</span></label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="diterima" <?= ($d->status == 'diterima') ? 'selected' : ''; ?>>Diterima</option>
                                                            <option value="diproses" <?= ($d->status == 'diproses') ? 'selected' : ''; ?>>Diproses</option>
                                                            <option value="selesai" <?= ($d->status == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="fw-semibold" style="font-size:0.85rem;">Catatan Tindak Lanjut</label>
                                                        <textarea name="catatan" class="form-control" rows="3" placeholder="Isi catatan tindak lanjut..."><?= $d->catatan ?? ''; ?></textarea>
                                                    </div>
                                                    <div class="alert alert-info small" style="border-radius:8px;">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        <strong>Instruksi:</strong> <?= $d->instruksi ?? '-'; ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-save me-1"></i> Update
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
     STYLE KHUSUS DISPOSISI
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
    .bg-success-light { background: #d1fae5; color: #065f46; }
    .bg-info-light { background: #e0e7ff; color: #4338ca; }

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

    /* ===== TABEL ===== */
    .table-custom {
        font-size: 0.85rem;
        margin-bottom: 0;
        width: 100%;
        min-width: 900px;
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
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.2px;
        background: var(--slate-100, #f1f5f9);
        color: var(--slate-600, #475569);
    }

    .badge-status.terkirim { background: #fef3c7; color: #d97706; }
    .badge-status.diterima { background: #dbeafe; color: #1e40af; }
    .badge-status.diproses { background: #e0e7ff; color: #4338ca; }
    .badge-status.selesai { background: #d1fae5; color: #065f46; }
    .badge-status.draft { background: #f1f5f9; color: #475569; }

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

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: 12px;
        border: 1px solid var(--slate-200, #e2e8f0);
        box-shadow: var(--shadow-lg, 0 12px 48px rgba(0,0,0,0.10));
    }

    .modal-header {
        background: var(--slate-50, #f8fafc);
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
        padding: 16px 20px;
    }

    .modal-header .modal-title {
        font-size: 1rem;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid var(--slate-200, #e2e8f0);
        padding: 12px 20px;
        background: var(--slate-50, #f8fafc);
    }

    .form-select, .form-control {
        border-radius: 8px;
        border: 2px solid var(--slate-200, #e2e8f0);
        transition: var(--transition, all 0.3s ease);
        font-size: 0.9rem;
    }

    .form-select:focus, .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
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
            min-width: 700px;
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

        .modal-dialog {
            margin: 10px;
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
            min-width: 600px;
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