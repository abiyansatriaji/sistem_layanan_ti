<!-- ============================================================
     HALAMAN DETAIL SURAT KELUAR - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0">Detail Surat Keluar</h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-envelope me-1"></i> Informasi lengkap surat keluar
                    </p>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= base_url('index.php/surat_keluar'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<!-- ============================================================
     CARD DETAIL SURAT
     ============================================================ -->
<div class="card-detail">
    <div class="card-detail-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-envelope"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-primary"><?= $surat->no_surat; ?></h5>
                <span class="text-muted small">Nomor Surat</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php
            $status_class = [
                'draft' => 'secondary',
                'dikirim' => 'primary',
                'terkirim' => 'success',
                'selesai' => 'success',
                'arsip' => 'secondary'
            ];
            $status_label = [
                'draft' => 'Draft',
                'dikirim' => 'Dikirim',
                'terkirim' => 'Terkirim',
                'selesai' => 'Selesai',
                'arsip' => 'Arsip'
            ];
            ?>
            <span class="badge-status <?= $surat->status; ?>">
                <i class="fas fa-circle me-1" style="font-size:6px;"></i>
                <?= $status_label[$surat->status] ?? ucfirst($surat->status); ?>
            </span>
            <span class="badge bg-light text-dark border">
                <i class="far fa-calendar-alt me-1"></i>
                <?= date('d-m-Y', strtotime($surat->created_at)); ?>
            </span>
        </div>
    </div>

    <div class="card-detail-body">

        <!-- ===== INFORMASI SURAT ===== -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-item">
                    <label class="info-label">No Surat</label>
                    <div class="info-value fw-bold"><?= $surat->no_surat; ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Tanggal Surat</label>
                    <div class="info-value"><?= date('d-m-Y', strtotime($surat->tgl_surat)); ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Tujuan</label>
                    <div class="info-value fw-semibold"><?= $surat->tujuan; ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Perihal</label>
                    <div class="info-value"><?= $surat->perihal; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <label class="info-label">Klasifikasi</label>
                    <div class="info-value"><?= $surat->nama_klasifikasi ?? '-'; ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Bagian</label>
                    <div class="info-value"><?= $surat->nama_bagian ?? '-'; ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Status</label>
                    <div class="info-value">
                        <span class="badge-status <?= $surat->status; ?>"><?= $status_label[$surat->status] ?? ucfirst($surat->status); ?></span>
                    </div>
                </div>
                <div class="info-item">
                    <label class="info-label">Dibuat Oleh</label>
                    <div class="info-value"><?= $surat->created_by_name; ?></div>
                </div>
            </div>
        </div>

        <!-- ===== LAMPIRAN ===== -->
        <?php if(!empty($lampiran)): ?>
        <div class="lampiran-section">
            <div class="lampiran-header">
                <i class="fas fa-paperclip me-2"></i>
                <span class="fw-bold">Lampiran</span>
                <span class="badge bg-primary rounded-pill ms-2"><?= count($lampiran); ?> File</span>
            </div>
            <div class="lampiran-list">
                <?php foreach($lampiran as $l): ?>
                <a href="<?= base_url($l->path_file); ?>" target="_blank" class="lampiran-item">
                    <?php
                    $ext = pathinfo($l->nama_file, PATHINFO_EXTENSION);
                    $icon = 'fa-file';
                    if(in_array($ext, ['pdf'])) $icon = 'fa-file-pdf';
                    elseif(in_array($ext, ['doc','docx'])) $icon = 'fa-file-word';
                    elseif(in_array($ext, ['xls','xlsx'])) $icon = 'fa-file-excel';
                    elseif(in_array($ext, ['jpg','jpeg','png','gif'])) $icon = 'fa-file-image';
                    elseif(in_array($ext, ['zip','rar'])) $icon = 'fa-file-archive';
                    ?>
                    <i class="fas <?= $icon; ?>"></i>
                    <span><?= $l->nama_file; ?></span>
                    <small>(<?= $l->ukuran_kb; ?> KB)</small>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- ===== TOMBOL AKSI ===== -->
        <div class="action-buttons">
            <a href="<?= base_url('index.php/surat_keluar'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="<?= base_url('index.php/surat_keluar/edit/' . $surat->id); ?>" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
        </div>

    </div>
</div>

<!-- ============================================================
     STYLE KHUSUS DETAIL SURAT KELUAR
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

    /* ===== CARD DETAIL ===== */
    .card-detail {
        background: #ffffff;
        border-radius: var(--radius, 14px);
        border: 1px solid var(--slate-200, #e2e8f0);
        overflow: hidden;
        box-shadow: var(--shadow-sm, 0 1px 3px rgba(0,0,0,0.06));
        transition: var(--transition, all 0.3s ease);
    }

    .card-detail:hover {
        box-shadow: var(--shadow-md, 0 4px 20px rgba(0,0,0,0.07));
    }

    .card-detail-header {
        padding: 16px 24px;
        background: var(--slate-50, #f8fafc);
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-detail-header .header-decoration {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.1rem;
    }

    .card-detail-body {
        padding: 24px 28px;
    }

    /* ===== BADGE STATUS ===== */
    .badge-status {
        display: inline-block;
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.2px;
    }

    .badge-status.draft { background: #f1f5f9; color: #475569; }
    .badge-status.dikirim { background: #dbeafe; color: #1e40af; }
    .badge-status.terkirim { background: #d1fae5; color: #065f46; }
    .badge-status.selesai { background: #d1fae5; color: #065f46; }
    .badge-status.arsip { background: #f1f5f9; color: #64748b; }

    /* ===== INFO ITEM ===== */
    .info-item {
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #94a3b8;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 0.95rem;
        color: #1e293b;
        word-wrap: break-word;
    }

    /* ===== LAMPIRAN ===== */
    .lampiran-section {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #e2e8f0;
    }

    .lampiran-header {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .lampiran-header i {
        color: #64748b;
    }

    .lampiran-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .lampiran-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 14px 5px 10px;
        background: #f8fafc;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        color: #334155;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .lampiran-item:hover {
        text-decoration: none;
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
    }

    .lampiran-item i {
        color: #64748b;
        font-size: 0.95rem;
    }

    .lampiran-item:hover i {
        color: #2563eb;
    }

    .lampiran-item small {
        font-size: 0.6rem;
        color: #94a3b8;
    }

    /* ===== TOMBOL AKSI ===== */
    .action-buttons {
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-buttons .btn {
        padding: 6px 20px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .btn-outline-secondary {
        border: 1px solid #e2e8f0;
        color: #64748b;
    }

    .btn-outline-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-success {
        background: #22c55e;
        border: none;
        color: #fff;
    }

    .btn-success:hover {
        background: #16a34a;
        color: #fff;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-detail-header {
            padding: 12px 16px;
        }

        .card-detail-body {
            padding: 16px;
        }

        .info-value {
            font-size: 0.85rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }

        .lampiran-list {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .page-header h4 {
            font-size: 1.1rem;
        }

        .card-detail-header .header-decoration {
            width: 34px;
            height: 34px;
            font-size: 0.9rem;
        }

        .card-detail-header h5 {
            font-size: 0.95rem;
        }
    }
</style>