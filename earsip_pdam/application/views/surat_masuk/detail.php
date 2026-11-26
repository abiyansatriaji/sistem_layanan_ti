<!-- ============================================================
     DETAIL SURAT MASUK - TAMPILAN SEWAJARNYA
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="fw-bold text-primary mb-0">
                <i class="fas fa-file-alt me-2"></i><?= $title; ?>
            </h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-envelope me-1"></i> Informasi lengkap surat masuk
            </p>
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

<!-- ============================================================
     KARTU DETAIL SURAT
     ============================================================ -->
<div class="card-detail">
    <div class="card-detail-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0"><?= $surat->no_agenda; ?></h5>
                <span class="text-muted small">Nomor Agenda</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-status <?= $surat->status; ?>">
                <i class="fas fa-circle me-1" style="font-size:6px;"></i>
                <?= ucfirst($surat->status); ?>
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
                    <label class="info-label">No Agenda</label>
                    <div class="info-value fw-bold"><?= $surat->no_agenda; ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">No Surat Asal</label>
                    <div class="info-value"><?= $surat->no_surat_asal; ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Tanggal Surat</label>
                    <div class="info-value"><?= date('d-m-Y', strtotime($surat->tgl_surat)); ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Tanggal Terima</label>
                    <div class="info-value"><?= date('d-m-Y', strtotime($surat->tgl_terima)); ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Pengirim</label>
                    <div class="info-value fw-semibold"><?= $surat->pengirim; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <label class="info-label">Perihal</label>
                    <div class="info-value"><?= $surat->perihal; ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Sifat Surat</label>
                    <div class="info-value">
                        <span class="badge-sifat <?= $surat->sifat_surat ?? 'biasa'; ?>">
                            <?= ucfirst($surat->sifat_surat ?? 'Biasa'); ?>
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <label class="info-label">Klasifikasi</label>
                    <div class="info-value"><?= $surat->nama_klasifikasi ?? '-'; ?></div>
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
            <a href="<?= base_url('index.php/surat_masuk'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="<?= base_url('index.php/surat_masuk/edit/' . $surat->id); ?>" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?= base_url('index.php/surat_masuk/disposisi/' . $surat->id); ?>" class="btn btn-info text-white">
                <i class="fas fa-share-alt me-1"></i> Disposisi
            </a>
            <?php if ($surat->status != 'baru'): ?>
            <a href="<?= base_url('index.php/disposisi/riwayat/' . $surat->id); ?>" class="btn btn-outline-primary">
                <i class="fas fa-stream me-1"></i> Riwayat Disposisi
            </a>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- ============================================================
     STYLE
     ============================================================ -->
<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    /* ===== CARD DETAIL ===== */
    .card-detail {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .card-detail-header {
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-detail-header .header-icon {
        width: 40px;
        height: 40px;
        background: #dbeafe;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 1.2rem;
    }

    .card-detail-body {
        padding: 24px;
    }

    /* ===== BADGE STATUS ===== */
    .badge-status {
        display: inline-block;
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .badge-status.baru { background: #fef3c7; color: #d97706; }
    .badge-status.didisposisikan { background: #dbeafe; color: #2563eb; }
    .badge-status.diproses { background: #e0e7ff; color: #4338ca; }
    .badge-status.selesai { background: #d1fae5; color: #065f46; }
    .badge-status.arsip { background: #f1f5f9; color: #64748b; }

    /* ===== BADGE SIFAT ===== */
    .badge-sifat {
        display: inline-block;
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-sifat.biasa { background: #f1f5f9; color: #64748b; }
    .badge-sifat.penting { background: #fef3c7; color: #d97706; }
    .badge-sifat.segera { background: #fce4ec; color: #b91c1c; }
    .badge-sifat.rahasia { background: #e0e7ff; color: #3730a3; }

    /* ===== INFO ITEM ===== */
    .info-item {
        margin-bottom: 12px;
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

    .btn-info {
        background: #0ea5e9;
        border: none;
        color: #fff;
    }

    .btn-info:hover {
        background: #0284c7;
        color: #fff;
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

        .card-detail-header .header-icon {
            width: 34px;
            height: 34px;
            font-size: 1rem;
        }
    }
</style>