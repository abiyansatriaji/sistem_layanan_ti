<!-- ============================================================
     HALAMAN TAMBAH KLASIFIKASI - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0"><?= $title; ?></h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-tags me-1"></i> Tambahkan klasifikasi surat baru ke dalam sistem
                    </p>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= base_url('index.php/klasifikasi'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<!-- ============================================================
     FORM TAMBAH KLASIFIKASI
     ============================================================ -->
<div class="card-form">
    <div class="card-form-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-pen-fancy"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0">Formulir Tambah Klasifikasi</h5>
                <span class="text-muted small">Lengkapi data klasifikasi di bawah ini</span>
            </div>
        </div>
        <span class="badge bg-primary rounded-pill">
            <i class="far fa-calendar-alt me-1"></i> <?= date('d-m-Y'); ?>
        </span>
    </div>

    <div class="card-form-body">
        <?= form_open('index.php/klasifikasi/simpan', ['class' => 'form-klasifikasi', 'autocomplete' => 'off']); ?>

            <!-- ===== IDENTITAS KLASIFIKASI ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-tag"></i> Identitas Klasifikasi
                    <span class="text-muted small fw-normal ms-2">Kode dan nama klasifikasi</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="kode_klasifikasi" class="form-control" id="kode_klasifikasi" placeholder="Masukkan Kode Klasifikasi" required autofocus autocomplete="off">
                            <label for="kode_klasifikasi"><i class="fas fa-hashtag text-muted me-1"></i> Kode Klasifikasi <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Maksimal 10 karakter, huruf/angka/garis bawah</small>
                    </div>
                    <div class="col-md-8">
                        <div class="form-floating">
                            <input type="text" name="nama_klasifikasi" class="form-control" id="nama_klasifikasi" placeholder="Masukkan Nama Klasifikasi" required autocomplete="off">
                            <label for="nama_klasifikasi"><i class="fas fa-folder text-muted me-1"></i> Nama Klasifikasi <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Contoh: Administrasi, Keuangan, Teknik</small>
                    </div>
                </div>
            </div>

            <!-- ===== KETERANGAN ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-align-left"></i> Keterangan
                    <span class="text-muted small fw-normal ms-2">Deskripsi tambahan (opsional)</span>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan" style="height:80px;" autocomplete="off"></textarea>
                            <label for="keterangan"><i class="fas fa-sticky-note text-muted me-1"></i> Keterangan</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Keterangan tambahan untuk klasifikasi (opsional)</small>
                    </div>
                </div>
            </div>

            <!-- ===== INFORMASI ===== -->
            <div class="form-section form-section-info">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="info-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Klasifikasi Surat</h6>
                        <p class="small text-muted mb-0">
                            Klasifikasi digunakan untuk mengelompokkan surat berdasarkan jenis atau bidang.
                            Kode klasifikasi akan digunakan dalam penomoran surat keluar.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===== TOMBOL ===== -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-save me-2"></i> Simpan Klasifikasi
                </button>
                <a href="<?= base_url('index.php/klasifikasi'); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="reset" class="btn btn-outline-secondary" id="btnReset">
                    <i class="fas fa-undo me-1"></i> Reset
                </button>
            </div>

        <?= form_close(); ?>
    </div>
</div>

<!-- ============================================================
     STYLE KHUSUS TAMBAH KLASIFIKASI
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
        padding: 18px 28px;
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
        padding: 28px;
    }

    /* ===== FORM SECTION ===== */
    .form-section {
        margin-bottom: 28px;
        padding-bottom: 24px;
        border-bottom: 1px dashed var(--slate-200, #e2e8f0);
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .form-section-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--slate-700, #334155);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title i {
        color: var(--accent, #3182ce);
        font-size: 1rem;
        width: 22px;
    }

    /* ===== FORM FLOATING ===== */
    .form-floating {
        position: relative;
    }

    .form-floating .form-control {
        border-radius: 12px;
        border: 2px solid var(--slate-200, #e2e8f0);
        background: var(--slate-50, #f8fafc);
        transition: var(--transition, all 0.3s ease);
        font-size: 0.95rem;
        height: 58px;
        padding-top: 18px;
        padding-bottom: 8px;
    }

    .form-floating .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
        background: #ffffff;
    }

    .form-floating label {
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.85rem;
        color: var(--slate-500, #64748b);
    }

    .form-floating .form-control:focus ~ label,
    .form-floating .form-control:not(:placeholder-shown) ~ label {
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
        margin-top: 28px;
        padding-top: 20px;
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
        font-size: 0.95rem;
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
        .card-form-body {
            padding: 18px;
        }

        .card-form-header {
            padding: 14px 18px;
        }

        .card-form-header h5 {
            font-size: 0.95rem;
        }

        .form-section {
            margin-bottom: 20px;
            padding-bottom: 16px;
        }

        .form-floating .form-control {
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
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .page-header h4 {
            font-size: 1.1rem;
        }

        .card-form-header .header-decoration {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }

        .form-floating .form-control {
            height: 46px;
            padding-top: 14px;
            font-size: 0.8rem;
        }

        .form-floating label {
            font-size: 0.75rem;
        }
    }
</style>