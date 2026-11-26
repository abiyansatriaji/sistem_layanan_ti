<!-- ============================================================
     HALAMAN TERUSKAN DISPOSISI - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-share"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0">Teruskan Disposisi</h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-envelope me-1"></i> Teruskan disposisi ke pengguna lain untuk ditindaklanjuti
                    </p>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= base_url('index.php/disposisi'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<!-- ============================================================
     INFORMASI DISPOSISI ASAL
     ============================================================ -->
<div class="card-detail mb-4">
    <div class="card-detail-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-primary">Informasi Disposisi Asal</h5>
                <span class="text-muted small">Data disposisi yang akan diteruskan</span>
            </div>
        </div>
        <span class="badge-status <?= $disposisi->status; ?>">
            <i class="fas fa-circle me-1" style="font-size:6px;"></i>
            <?= ucfirst($disposisi->status); ?>
        </span>
    </div>
    <div class="card-detail-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-item">
                    <label class="info-label">Surat</label>
                    <div class="info-value fw-semibold"><?= $disposisi->no_agenda; ?> - <?= $disposisi->perihal; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <label class="info-label">Instruksi</label>
                    <div class="info-value"><?= $disposisi->instruksi ?? '-'; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <label class="info-label">Dari</label>
                    <div class="info-value fw-semibold"><?= $disposisi->dari_nama; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <label class="info-label">Untuk</label>
                    <div class="info-value fw-semibold"><?= $disposisi->ke_nama; ?></div>
                </div>
            </div>
            <?php if(!empty($disposisi->catatan)): ?>
            <div class="col-12">
                <div class="info-item">
                    <label class="info-label">Catatan</label>
                    <div class="info-value"><?= $disposisi->catatan; ?></div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- ===== LAMPIRAN -- IKUT TAMPIL SAMPAI TINGKAT MANAPUN ===== -->
        <?php if (isset($lampiran)): ?>
        <div class="lampiran-section">
            <div class="lampiran-header">
                <i class="fas fa-paperclip me-2"></i>
                <span class="fw-bold">Lampiran Surat</span>
                <span class="badge bg-primary rounded-pill ms-2"><?= count($lampiran); ?> File</span>
            </div>
            <?php if (empty($lampiran)): ?>
                <span class="text-muted small">Tidak ada lampiran pada surat ini.</span>
            <?php else: ?>
            <div class="lampiran-list">
                <?php foreach ($lampiran as $l): ?>
                <a href="<?= base_url('index.php/arsip/lihat/' . $l->id); ?>" target="_blank" class="lampiran-item">
                    <?php
                    $ext = pathinfo($l->nama_file, PATHINFO_EXTENSION);
                    $icon = 'fa-file';
                    if (in_array($ext, ['pdf'])) $icon = 'fa-file-pdf';
                    elseif (in_array($ext, ['doc', 'docx'])) $icon = 'fa-file-word';
                    elseif (in_array($ext, ['xls', 'xlsx'])) $icon = 'fa-file-excel';
                    elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) $icon = 'fa-file-image';
                    elseif (in_array($ext, ['zip', 'rar'])) $icon = 'fa-file-archive';
                    ?>
                    <i class="fas <?= $icon; ?>"></i>
                    <span><?= $l->nama_file; ?></span>
                    <small>(<?= $l->ukuran_kb; ?> KB)</small>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- ===== RIWAYAT DISPOSISI BERJENJANG SEBELUM INI ===== -->
        <?php if (!empty($riwayat)): ?>
        <div class="lampiran-section">
            <div class="lampiran-header">
                <i class="fas fa-stream me-2"></i>
                <span class="fw-bold">Riwayat Disposisi Sebelumnya</span>
                <span class="badge bg-secondary rounded-pill ms-2"><?= count($riwayat); ?> langkah</span>
            </div>
            <div class="timeline">
                <?php foreach ($riwayat as $r): ?>
                <?php
                    $status_class = ['terkirim' => 'primary', 'diterima' => 'info', 'diproses' => 'warning', 'selesai' => 'success'];
                    $cls = $status_class[$r->status] ?? 'secondary';
                ?>
                <div class="timeline-item" style="margin-left: <?= $r->level * 24; ?>px;">
                    <div class="timeline-dot bg-<?= $cls; ?>"></div>
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="fw-semibold small">
                                <?= $r->dari_nama ?? '-'; ?> <i class="fas fa-long-arrow-alt-right mx-1 text-primary"></i> <?= $r->ke_nama ?? '-'; ?>
                            </div>
                            <span class="badge bg-<?= $cls; ?>" style="font-size:0.65rem;"><?= ucfirst($r->status); ?></span>
                        </div>
                        <?php if (!empty($r->instruksi)): ?>
                        <div class="small mt-1"><?= $r->instruksi; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ============================================================
     FORM TERUSKAN DISPOSISI
     ============================================================ -->
<div class="card-form">
    <div class="card-form-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-pen-fancy"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0">Formulir Teruskan Disposisi</h5>
                <span class="text-muted small">Pilih penerima dan tambahkan instruksi</span>
            </div>
        </div>
        <span class="badge bg-warning text-dark rounded-pill">
            <i class="fas fa-share me-1"></i> Teruskan
        </span>
    </div>

    <div class="card-form-body">
        <?= form_open('index.php/disposisi/simpan_teruskan', ['class' => 'form-disposisi', 'autocomplete' => 'off']); ?>
            <input type="hidden" name="parent_id" value="<?= $disposisi->id; ?>">
            <input type="hidden" name="surat_masuk_id" value="<?= $disposisi->surat_masuk_id; ?>">

            <!-- ===== DARI (Readonly) ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-user"></i> Pengirim
                    <span class="text-muted small fw-normal ms-2">Anda sebagai pengirim</span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="dari" value="<?= $this->session->userdata('nama'); ?>" readonly>
                            <label for="dari"><i class="fas fa-user-tie text-muted me-1"></i> Dari</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Anda adalah pengirim disposisi ini</small>
                    </div>
                </div>
            </div>

            <!-- ===== PENERIMA ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-user-check"></i> Penerima
                    <span class="text-muted small fw-normal ms-2">Pilih penerima disposisi</span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="ke_user_id" class="form-select" id="ke_user_id" required>
                                <option value="">-- Pilih Penerima --</option>
                                <?php foreach($users as $u): ?>
                                    <?php if($u->id != $this->session->userdata('user_id')): ?>
                                    <option value="<?= $u->id; ?>"><?= $u->nama; ?> (<?= $u->username; ?>)</option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <label for="ke_user_id"><i class="fas fa-user text-muted me-1"></i> Teruskan Ke <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Pilih pengguna yang akan menerima disposisi</small>
                    </div>
                </div>
            </div>

            <!-- ===== INSTRUKSI & CATATAN ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-comment-dots"></i> Instruksi &amp; Catatan
                    <span class="text-muted small fw-normal ms-2">Tambahkan instruksi tambahan</span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <textarea name="instruksi" class="form-control" id="instruksi" placeholder="Instruksi tambahan" style="height:80px;"></textarea>
                            <label for="instruksi"><i class="fas fa-bullhorn text-muted me-1"></i> Instruksi Tambahan</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Instruksi tambahan untuk penerima (opsional)</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <textarea name="catatan" class="form-control" id="catatan" placeholder="Catatan tambahan" style="height:80px;"></textarea>
                            <label for="catatan"><i class="fas fa-sticky-note text-muted me-1"></i> Catatan</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Catatan tambahan untuk arsip (opsional)</small>
                    </div>
                </div>
            </div>

            <!-- ===== INFORMASI ===== -->
            <div class="form-section form-section-info">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="info-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Alur Disposisi</h6>
                        <p class="small text-muted mb-0">
                            Disposisi akan diteruskan ke pengguna yang dipilih. Penerima akan mendapatkan notifikasi dan dapat memperbarui status disposisi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===== TOMBOL ===== -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-paper-plane me-2"></i> Teruskan
                </button>
                <a href="<?= base_url('index.php/disposisi'); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>

        <?= form_close(); ?>
    </div>
</div>

<!-- ============================================================
     STYLE KHUSUS HALAMAN TERUSKAN
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

    /* ===== CARD DETAIL (Informasi Disposisi Asal) ===== */
    .card-detail {
        background: #ffffff;
        border-radius: var(--radius, 14px);
        border: 1px solid var(--slate-200, #e2e8f0);
        overflow: hidden;
        box-shadow: var(--shadow-sm, 0 1px 3px rgba(0,0,0,0.06));
    }

    .card-detail-header {
        padding: 14px 22px;
        background: var(--slate-50, #f8fafc);
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-detail-header .header-decoration {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1rem;
    }

    .card-detail-body {
        padding: 18px 22px;
    }

    /* ===== INFO ITEM ===== */
    .info-item {
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 1px solid var(--slate-100, #f1f5f9);
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
        margin-bottom: 1px;
    }

    .info-value {
        font-size: 0.9rem;
        color: #1e293b;
        word-wrap: break-word;
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

    /* ===== CARD FORM ===== */
    .card-form {
        background: #ffffff;
        border-radius: var(--radius, 16px);
        box-shadow: var(--shadow-md, 0 4px 20px rgba(0,0,0,0.07));
        border: 1px solid var(--slate-200, #e2e8f0);
        overflow: hidden;
        transition: var(--transition, all 0.3s ease);
    }

    .card-form:hover {
        box-shadow: var(--shadow-lg, 0 12px 48px rgba(0,0,0,0.10));
    }

    .card-form-header {
        padding: 16px 24px;
        background: var(--slate-50, #f8fafc);
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-form-header .header-decoration {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1rem;
    }

    .card-form-body {
        padding: 24px 28px;
    }

    /* ===== FORM SECTION ===== */
    .form-section {
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px dashed var(--slate-200, #e2e8f0);
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .form-section-title {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--slate-700, #334155);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title i {
        color: var(--accent, #3182ce);
        font-size: 0.9rem;
        width: 20px;
    }

    /* ===== FORM FLOATING ===== */
    .form-floating {
        position: relative;
    }

    .form-floating .form-control,
    .form-floating .form-select {
        border-radius: 12px;
        border: 2px solid var(--slate-200, #e2e8f0);
        background: var(--slate-50, #f8fafc);
        transition: var(--transition, all 0.3s ease);
        font-size: 0.9rem;
        height: 58px;
        padding-top: 18px;
        padding-bottom: 8px;
    }

    .form-floating .form-control:focus,
    .form-floating .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
        background: #ffffff;
    }

    .form-floating .form-control[readonly] {
        background: var(--slate-100, #f1f5f9);
        color: var(--slate-500, #64748b);
        cursor: not-allowed;
    }

    .form-floating label {
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.8rem;
        color: var(--slate-500, #64748b);
    }

    .form-floating .form-control:focus ~ label,
    .form-floating .form-control:not(:placeholder-shown) ~ label {
        color: #2563eb;
        font-weight: 600;
    }

    .form-floating .form-select:focus ~ label,
    .form-floating .form-select:not([value=""]) ~ label {
        color: #2563eb;
        font-weight: 600;
    }

    .form-floating textarea.form-control {
        height: 80px;
        padding-top: 20px;
        resize: vertical;
    }

    .form-floating textarea.form-control ~ label {
        padding-top: 12px;
    }

    /* ===== FORM SECTION INFO ===== */
    .form-section-info {
        background: linear-gradient(135deg, var(--blue-50, #eff6ff), #dbeafe);
        border-radius: 12px;
        padding: 14px 20px;
        border: 1px solid var(--blue-200, #bfdbfe);
        margin-top: 4px;
        border-bottom: none;
    }

    .form-section-info .info-icon {
        width: 40px;
        height: 40px;
        background: #ffffff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 1.2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        flex-shrink: 0;
    }

    /* ===== FORM ACTIONS ===== */
    .form-actions {
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid var(--slate-200, #e2e8f0);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-submit {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        border: none;
        padding: 10px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition, all 0.3s ease);
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(37, 99, 235, 0.35);
        color: #fff;
    }

    .btn-outline-secondary {
        border-radius: 10px;
        font-weight: 500;
        padding: 10px 24px;
        border: 2px solid var(--slate-200, #e2e8f0);
    }

    .btn-outline-secondary:hover {
        background: var(--slate-50, #f8fafc);
        border-color: var(--slate-300, #cbd5e1);
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

        .card-detail-body {
            padding: 14px 16px;
        }

        .card-form-body {
            padding: 18px;
        }

        .card-form-header {
            padding: 14px 18px;
        }

        .form-floating .form-control,
        .form-floating .form-select {
            height: 50px;
            font-size: 0.85rem;
        }

        .form-floating textarea.form-control {
            height: 70px;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .form-section-info {
            padding: 14px 16px;
        }
    }

    @media (max-width: 576px) {
        .page-header .header-icon {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .card-form-header .header-decoration {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }

        .form-floating .form-control,
        .form-floating .form-select {
            height: 46px;
            padding-top: 14px;
            font-size: 0.8rem;
        }

        .form-floating label {
            font-size: 0.75rem;
        }

        .card-detail-header .header-decoration {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }

        .card-detail-header h5 {
            font-size: 0.95rem;
        }
    }

    /* ===== LAMPIRAN ===== */
    .lampiran-section {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid var(--slate-200, #e2e8f0);
    }
    .lampiran-header {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: var(--slate-800, #1e293b);
        margin-bottom: 10px;
    }
    .lampiran-header i { color: var(--slate-500, #64748b); }
    .lampiran-list { display: flex; flex-wrap: wrap; gap: 8px; }
    .lampiran-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 14px 5px 10px;
        background: var(--slate-50, #f8fafc);
        border-radius: 6px;
        border: 1px solid var(--slate-200, #e2e8f0);
        text-decoration: none;
        color: var(--slate-700, #334155);
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .lampiran-item:hover {
        text-decoration: none;
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
    }
    .lampiran-item small { font-size: 0.6rem; color: var(--slate-400, #94a3b8); }

    /* ===== TIMELINE RIWAYAT BERJENJANG (mini, di form) ===== */
    .timeline { position: relative; }
    .timeline-item {
        position: relative;
        padding: 10px 0 10px 22px;
        border-left: 2px solid var(--slate-200, #e2e8f0);
    }
    .timeline-item:last-child { border-left: 2px solid transparent; }
    .timeline-dot {
        position: absolute; left: -6px; top: 14px;
        width: 10px; height: 10px; border-radius: 50%;
        border: 2px solid #fff; box-shadow: 0 0 0 2px var(--slate-200, #e2e8f0);
    }
    .timeline-content {
        background: var(--slate-50, #f8fafc);
        border: 1px solid var(--slate-200, #e2e8f0);
        border-radius: 8px;
        padding: 8px 12px;
    }
</style>