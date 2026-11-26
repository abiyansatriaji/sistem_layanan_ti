<!-- ============================================================
     HALAMAN EDIT SURAT KELUAR - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0"><?= $title; ?></h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-envelope me-1"></i> Perbarui data surat keluar yang sudah tercatat
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
     FORM EDIT SURAT KELUAR
     ============================================================ -->
<div class="card-form">
    <div class="card-form-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-pen-fancy"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0">Formulir Edit Surat Keluar</h5>
                <span class="text-muted small">Perbarui data surat keluar di bawah ini</span>
            </div>
        </div>
        <span class="badge bg-warning text-dark rounded-pill">
            <i class="fas fa-edit me-1"></i> Edit Mode
        </span>
    </div>

    <div class="card-form-body">
        <?= form_open_multipart('index.php/surat_keluar/update/' . $surat->id, ['class' => 'form-surat', 'autocomplete' => 'off', 'id' => 'formSurat']); ?>

            <!-- ===== IDENTITAS SURAT ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-file-signature"></i> Identitas Surat
                    <span class="text-muted small fw-normal ms-2">Nomor surat dan tanggal</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating" style="position:relative;">
                            <input type="text" name="no_surat" class="form-control" id="no_surat" value="<?= $surat->no_surat; ?>" autocomplete="off" readonly style="background:#f1f5f9; cursor:not-allowed;">
                            <label for="no_surat"><i class="fas fa-hashtag text-muted me-1"></i> No Surat</label>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-1 mt-1">
                            <small class="text-muted">
                                <i class="fas fa-lock"></i> Nomor surat bersifat tetap sejak dibuat dan tidak dapat diubah.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="tgl_surat" class="form-control" id="tgl_surat" placeholder="mm/dd/yyyy" value="<?= $surat->tgl_surat; ?>" required>
                            <label for="tgl_surat"><i class="fas fa-calendar-day text-muted me-1"></i> Tanggal Surat (mm/dd/yyyy) <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Format: mm/dd/yyyy</small>
                    </div>
                </div>
            </div>

            <!-- ===== TUJUAN & PERIHAL ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle"></i> Detail Surat
                    <span class="text-muted small fw-normal ms-2">Tujuan dan perihal</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="tujuan" class="form-control" id="tujuan" placeholder="Masukkan Nama Tujuan" value="<?= $surat->tujuan; ?>" required autocomplete="off">
                            <label for="tujuan"><i class="fas fa-user-tie text-muted me-1"></i> Tujuan <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Nama instansi/unit tujuan</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="perihal" class="form-control" id="perihal" placeholder="Masukkan Perihal Surat" value="<?= $surat->perihal; ?>" required autocomplete="off">
                            <label for="perihal"><i class="fas fa-align-left text-muted me-1"></i> Perihal <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Judul/pokok isi surat</small>
                    </div>
                </div>
            </div>

            <!-- ===== KLASIFIKASI, BAGIAN, STATUS ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-tags"></i> Klasifikasi & Status
                    <span class="text-muted small fw-normal ms-2">Klasifikasi, bagian, dan status surat</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="klasifikasi_id" class="form-select" id="klasifikasi_id">
                                <option value="">-- Pilih Klasifikasi --</option>
                                <?php foreach($klasifikasi as $k): ?>
                                    <option value="<?= $k->id; ?>" data-kode="<?= $k->kode_klasifikasi; ?>" <?= ($k->id == $surat->klasifikasi_id) ? 'selected' : ''; ?>>
                                        <?= $k->kode_klasifikasi . ' - ' . $k->nama_klasifikasi; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="klasifikasi_id"><i class="fas fa-folder text-muted me-1"></i> Klasifikasi</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Klasifikasi jenis surat (mempengaruhi nomor surat)</small>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="bagian_id" class="form-select" id="bagian_id">
                                <option value="">-- Pilih Bagian --</option>
                                <?php foreach($bagian as $b): ?>
                                    <option value="<?= $b->id; ?>" <?= ($b->id == $surat->bagian_id) ? 'selected' : ''; ?>>
                                        <?= $b->nama_bagian; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="bagian_id"><i class="fas fa-building text-muted me-1"></i> Bagian</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Unit kerja pengirim</small>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="status" class="form-select" id="status">
                                <option value="draft" <?= ($surat->status == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                <option value="dikirim" <?= ($surat->status == 'dikirim') ? 'selected' : ''; ?>>Dikirim</option>
                                <option value="arsip" <?= ($surat->status == 'arsip') ? 'selected' : ''; ?>>Arsip</option>
                            </select>
                            <label for="status"><i class="fas fa-circle text-muted me-1"></i> Status</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Status surat saat ini</small>
                    </div>
                </div>
            </div>

            <!-- ============================================================
                 LAMPIRAN YANG SUDAH ADA
                 ============================================================ -->
            <?php if(!empty($lampiran)): ?>
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-paperclip"></i> Lampiran Saat Ini
                    <span class="text-muted small fw-normal ms-2">File yang sudah diupload sebelumnya</span>
                </div>
                <div class="existing-lampiran">
                    <?php foreach($lampiran as $l): ?>
                    <div class="lampiran-item-existing">
                        <div class="lampiran-item-existing-icon">
                            <?php
                            $ext = pathinfo($l->nama_file, PATHINFO_EXTENSION);
                            $icon = 'fa-file';
                            if(in_array($ext, ['pdf'])) $icon = 'fa-file-pdf';
                            elseif(in_array($ext, ['doc','docx'])) $icon = 'fa-file-word';
                            elseif(in_array($ext, ['jpg','jpeg','png','gif'])) $icon = 'fa-file-image';
                            elseif(in_array($ext, ['zip','rar'])) $icon = 'fa-file-archive';
                            ?>
                            <i class="fas <?= $icon; ?>"></i>
                        </div>
                        <div class="lampiran-item-existing-info">
                            <span class="lampiran-item-existing-name"><?= $l->nama_file; ?></span>
                            <span class="lampiran-item-existing-size"><?= $l->ukuran_kb; ?> KB</span>
                        </div>
                        <a href="<?= base_url($l->path_file); ?>" target="_blank" class="btn-sm btn-outline-primary" title="Lihat File">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= base_url('index.php/surat_keluar/hapus_lampiran/' . $l->id . '/' . $surat->id); ?>" class="btn-sm btn-outline-danger" onclick="return confirm('Hapus lampiran ini?')" title="Hapus Lampiran">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================================
                 TAMBAH LAMPIRAN BARU
                 ============================================================ -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-upload"></i> Tambah Lampiran Baru
                    <span class="text-muted small fw-normal ms-2">Upload file pendukung tambahan</span>
                </div>

                <div class="upload-area">
                    <div class="upload-box" id="uploadBox">
                        <i class="fas fa-cloud-upload-alt" id="uploadIcon"></i>
                        <p class="mb-1 fw-semibold" id="uploadText">Upload Lampiran</p>
                        <span class="text-muted small">PDF, DOC, JPG, PNG, ZIP | Max 5MB</span>
                        <input type="file" name="lampiran[]" class="form-control" id="fileInput" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">
                    </div>
                </div>
                
                <!-- ===== PREVIEW FILE BARU ===== -->
                <div id="filePreview" class="file-preview-area" style="display:none;">
                    <div class="file-preview-header">
                        <span><i class="fas fa-paperclip me-1"></i> <span id="fileCount">0</span> file akan ditambahkan</span>
                        <button type="button" class="btn-clear-files" id="clearFiles" title="Hapus semua file">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div id="fileList" class="file-list"></div>
                </div>
                
                <small class="text-muted"><i class="fas fa-info-circle"></i> Untuk file gambar (JPG/PNG), akan ditampilkan thumbnail preview</small>
            </div>

            <!-- ===== INFORMASI ===== -->
            <div class="form-section form-section-info">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="info-icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Manajemen Surat Digital</h6>
                        <p class="small text-muted mb-0">
                            Perubahan data surat akan langsung memperbarui informasi di sistem.
                            Pastikan data yang dimasukkan sudah benar sebelum menyimpan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===== TOMBOL ===== -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-submit" id="btnSubmit">
                    <i class="fas fa-save me-2"></i> Update Surat
                </button>
                <a href="<?= base_url('index.php/surat_keluar'); ?>" class="btn btn-outline-secondary">
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
     STYLE KHUSUS EDIT SURAT KELUAR
     ============================================================ -->
<style>
    .page-header { margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid var(--slate-200, #e2e8f0); }
    .page-header .header-icon { width: 48px; height: 48px; background: linear-gradient(135deg, #d97706, #f59e0b); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.3rem; box-shadow: 0 4px 16px rgba(217, 119, 6, 0.25); }
    
    .card-form { background: #ffffff; border-radius: var(--radius, 16px); box-shadow: var(--shadow-md, 0 4px 20px rgba(0,0,0,0.07)); border: 1px solid var(--slate-200, #e2e8f0); overflow: hidden; transition: var(--transition, all 0.3s ease); }
    .card-form:hover { box-shadow: var(--shadow-lg, 0 12px 48px rgba(0,0,0,0.10)); }
    .card-form-header { padding: 18px 28px; background: var(--slate-50, #f8fafc); border-bottom: 1px solid var(--slate-200, #e2e8f0); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
    .card-form-header .header-decoration { width: 40px; height: 40px; background: linear-gradient(135deg, #d97706, #f59e0b); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1rem; }
    .card-form-body { padding: 28px; }
    
    .form-section { margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px dashed var(--slate-200, #e2e8f0); }
    .form-section:last-of-type { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .form-section-title { font-weight: 600; font-size: 0.9rem; color: var(--slate-700, #334155); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .form-section-title i { color: var(--accent, #3182ce); font-size: 1rem; width: 22px; }
    
    .form-floating { position: relative; }
    .form-floating .form-control, .form-floating .form-select { border-radius: 12px; border: 2px solid var(--slate-200, #e2e8f0); background: var(--slate-50, #f8fafc); transition: var(--transition, all 0.3s ease); font-size: 0.95rem; height: 58px; padding-top: 18px; padding-bottom: 8px; }
    .form-floating .form-control:focus, .form-floating .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08); background: #ffffff; }
    .form-floating label { padding: 8px 16px; font-weight: 500; font-size: 0.85rem; color: var(--slate-500, #64748b); }
    .form-floating .form-control:focus ~ label, .form-floating .form-control:not(:placeholder-shown) ~ label { color: #2563eb; font-weight: 600; }
    .form-floating .form-select:focus ~ label, .form-floating .form-select:not([value=""]) ~ label { color: #2563eb; font-weight: 600; }

    /* ===== TOMBOL GENERATE ===== */
    .btn-generate-no {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 1rem;
        cursor: pointer;
        padding: 6px 10px;
        border-radius: 8px;
        transition: all 0.25s ease;
        z-index: 5;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-generate-no:hover {
        background: #eff6ff;
        border-color: #60a5fa;
        color: #2563eb;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .btn-generate-no:active {
        transform: translateY(-50%) scale(0.95);
    }
    .btn-generate-no:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f1f5f9;
    }
    .btn-generate-no i {
        font-size: 0.9rem;
    }

    .upload-area { position: relative; }
    .upload-box { border: 2px dashed var(--slate-300, #cbd5e1); border-radius: 12px; padding: 30px 20px; text-align: center; transition: var(--transition, all 0.3s ease); background: var(--slate-50, #f8fafc); position: relative; cursor: pointer; }
    .upload-box:hover { border-color: #3b82f6; background: var(--blue-50, #eff6ff); }
    .upload-box.has-files { border-color: #16a34a; background: #f0fdf4; }
    .upload-box i { font-size: 2.5rem; color: var(--slate-400, #94a3b8); margin-bottom: 8px; }
    .upload-box.has-files i { color: #16a34a; }
    .upload-box input[type="file"] { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    
    .file-preview-area { margin-top: 12px; background: var(--slate-50, #f8fafc); border-radius: 10px; border: 1px solid var(--slate-200, #e2e8f0); overflow: hidden; }
    .file-preview-header { display: flex; justify-content: space-between; align-items: center; padding: 10px 16px; background: #fff; border-bottom: 1px solid var(--slate-200, #e2e8f0); font-weight: 600; font-size: 0.85rem; color: var(--slate-700, #334155); }
    .file-preview-header span i { color: #2563eb; }
    .btn-clear-files { background: transparent; border: none; color: var(--slate-400, #94a3b8); padding: 4px 8px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; }
    .btn-clear-files:hover { background: #fee2e2; color: #dc2626; }
    .file-list { padding: 8px 12px; max-height: 250px; overflow-y: auto; }
    .file-item { display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 8px; background: #ffffff; margin-bottom: 6px; border: 1px solid var(--slate-100, #f1f5f9); font-size: 0.85rem; }
    .file-item:last-child { margin-bottom: 0; }
    .file-thumbnail { width: 50px; height: 50px; border-radius: 6px; overflow: hidden; flex-shrink: 0; background: var(--slate-100, #f1f5f9); display: flex; align-items: center; justify-content: center; border: 1px solid var(--slate-200, #e2e8f0); }
    .file-thumbnail img { width: 100%; height: 100%; object-fit: cover; }
    .file-thumbnail .file-icon { font-size: 1.5rem; color: var(--slate-400, #94a3b8); }
    .file-thumbnail .file-icon.pdf { color: #dc2626; }
    .file-thumbnail .file-icon.doc { color: #2563eb; }
    .file-thumbnail .file-icon.zip { color: #4338ca; }
    .file-thumbnail .file-icon.other { color: #64748b; }
    .file-info { flex: 1; display: flex; flex-direction: column; min-width: 0; }
    .file-name { font-weight: 500; color: var(--slate-800, #1e293b); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .file-size { font-size: 0.7rem; color: var(--slate-400, #94a3b8); }
    .file-status { font-size: 0.7rem; color: #16a34a; font-weight: 600; white-space: nowrap; }
    .file-status i { color: #16a34a; }
    .btn-remove-file { background: transparent; border: none; color: var(--slate-400, #94a3b8); padding: 4px 6px; border-radius: 4px; cursor: pointer; font-size: 0.75rem; flex-shrink: 0; }
    .btn-remove-file:hover { background: #fee2e2; color: #dc2626; }
    
    .existing-lampiran { display: flex; flex-wrap: wrap; gap: 8px; }
    .lampiran-item-existing { display: flex; align-items: center; gap: 10px; padding: 8px 14px 8px 10px; background: var(--slate-50, #f8fafc); border-radius: 8px; border: 1px solid var(--slate-200, #e2e8f0); font-size: 0.85rem; }
    .lampiran-item-existing-icon { width: 32px; height: 32px; border-radius: 6px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 1rem; }
    .lampiran-item-existing-info { display: flex; flex-direction: column; }
    .lampiran-item-existing-name { font-weight: 500; color: var(--slate-800, #1e293b); }
    .lampiran-item-existing-size { font-size: 0.7rem; color: var(--slate-400, #94a3b8); }
    .lampiran-item-existing .btn-sm { padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; text-decoration: none; transition: var(--transition, all 0.3s ease); }
    .lampiran-item-existing .btn-sm:hover { transform: translateY(-1px); }
    .lampiran-item-existing .btn-outline-primary { border: 1px solid var(--slate-200, #e2e8f0); color: #2563eb; background: transparent; }
    .lampiran-item-existing .btn-outline-primary:hover { background: #dbeafe; border-color: #60a5fa; }
    .lampiran-item-existing .btn-outline-danger { border: 1px solid var(--slate-200, #e2e8f0); color: #dc2626; background: transparent; }
    .lampiran-item-existing .btn-outline-danger:hover { background: #fee2e2; border-color: #fca5a5; }
    
    .form-section-info { background: linear-gradient(135deg, var(--blue-50, #eff6ff), #dbeafe); border-radius: 12px; padding: 18px 24px; border: 1px solid var(--blue-200, #bfdbfe); margin-top: 8px; border-bottom: none; }
    .form-section-info .info-icon { width: 44px; height: 44px; background: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); flex-shrink: 0; }
    
    .form-actions { margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--slate-200, #e2e8f0); display: flex; gap: 10px; flex-wrap: wrap; }
    .btn-submit { background: linear-gradient(135deg, #1e40af, #3b82f6); border: none; padding: 10px 32px; border-radius: 10px; font-weight: 600; font-size: 0.95rem; transition: var(--transition, all 0.3s ease); box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25); }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(37, 99, 235, 0.35); color: #fff; }
    .btn-outline-secondary { border-radius: 10px; font-weight: 500; padding: 10px 24px; border: 2px solid var(--slate-200, #e2e8f0); }
    .btn-outline-secondary:hover { background: var(--slate-50, #f8fafc); border-color: var(--slate-300, #cbd5e1); }
    
    @media (max-width: 768px) {
        .card-form-body { padding: 18px; }
        .card-form-header { padding: 14px 18px; }
        .form-floating .form-control, .form-floating .form-select { height: 50px; font-size: 0.85rem; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
        .upload-box { padding: 20px 16px; }
        .upload-box i { font-size: 2rem; }
        .file-thumbnail { width: 40px; height: 40px; }
        .existing-lampiran { flex-direction: column; }
    }
    @media (max-width: 576px) {
        .page-header .header-icon { width: 40px; height: 40px; font-size: 1rem; }
        .card-form-header .header-decoration { width: 32px; height: 32px; font-size: 0.8rem; }
        .form-floating .form-control, .form-floating .form-select { height: 46px; padding-top: 14px; font-size: 0.8rem; }
        .form-floating label { font-size: 0.75rem; }
        .file-thumbnail { width: 36px; height: 36px; }
        .btn-generate-no { padding: 4px 8px; font-size: 0.85rem; }
    }
</style>

<!-- ============================================================
     SCRIPT PREVIEW FILE + GENERATE NO SURAT OTOMATIS SAAT KLASIFIKASI BERUBAH
     ============================================================ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== PREVIEW FILE =====
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileList = document.getElementById('fileList');
    const fileCount = document.getElementById('fileCount');
    const clearFiles = document.getElementById('clearFiles');
    const uploadBox = document.getElementById('uploadBox');
    const uploadText = document.getElementById('uploadText');
    const uploadIcon = document.getElementById('uploadIcon');
    const btnReset = document.getElementById('btnReset');
    const form = document.getElementById('formSurat');

    function getFileIconClass(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        const classes = { 'pdf':'pdf','doc':'doc','docx':'doc','xls':'doc','xlsx':'doc',
                          'jpg':'image','jpeg':'image','png':'image','gif':'image',
                          'zip':'zip','rar':'zip' };
        return classes[ext] || 'other';
    }

    function getFileIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        const icons = { 'pdf':'fa-file-pdf','doc':'fa-file-word','docx':'fa-file-word',
                        'xls':'fa-file-excel','xlsx':'fa-file-excel',
                        'jpg':'fa-file-image','jpeg':'fa-file-image','png':'fa-file-image',
                        'gif':'fa-file-image','zip':'fa-file-archive','rar':'fa-file-archive' };
        return icons[ext] || 'fa-file';
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function isImageFile(file) {
        return file.type && file.type.startsWith('image/');
    }

    function updateFilePreview(files) {
        fileList.innerHTML = '';
        if (files.length === 0) {
            filePreview.style.display = 'none';
            uploadBox.classList.remove('has-files');
            uploadText.textContent = 'Upload Lampiran';
            uploadIcon.className = 'fas fa-cloud-upload-alt';
            return;
        }
        filePreview.style.display = 'block';
        uploadBox.classList.add('has-files');
        uploadText.textContent = files.length + ' file dipilih';
        uploadIcon.className = 'fas fa-check-circle';
        fileCount.textContent = files.length;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const icon = getFileIcon(file.name);
            const iconClass = getFileIconClass(file.name);
            const size = formatFileSize(file.size);
            const isImage = isImageFile(file);

            const item = document.createElement('div');
            item.className = 'file-item';

            const thumb = document.createElement('div');
            thumb.className = 'file-thumbnail';
            if (isImage) {
                const img = document.createElement('img');
                const reader = new FileReader();
                reader.onload = function(e) { img.src = e.target.result; };
                reader.readAsDataURL(file);
                thumb.appendChild(img);
            } else {
                const iconEl = document.createElement('i');
                iconEl.className = 'fas ' + icon + ' file-icon ' + iconClass;
                thumb.appendChild(iconEl);
            }
            item.appendChild(thumb);

            const info = document.createElement('div');
            info.className = 'file-info';
            info.innerHTML = `<span class="file-name">${file.name}</span><span class="file-size">${size}</span>`;
            item.appendChild(info);

            const status = document.createElement('span');
            status.className = 'file-status';
            status.innerHTML = '<i class="fas fa-check-circle"></i> Siap diupload';
            item.appendChild(status);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-file';
            removeBtn.dataset.index = i;
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.title = 'Hapus file';
            item.appendChild(removeBtn);

            fileList.appendChild(item);

            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const idx = parseInt(this.dataset.index);
                const dt = new DataTransfer();
                for (let j = 0; j < files.length; j++) {
                    if (j !== idx) dt.items.add(files[j]);
                }
                fileInput.files = dt.files;
                updateFilePreview(dt.files);
            });
        }
    }

    fileInput.addEventListener('change', function() {
        updateFilePreview(this.files);
    });

    clearFiles.addEventListener('click', function() {
        fileInput.value = '';
        updateFilePreview(new FileList());
    });

    btnReset.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Reset semua field? Data yang sudah diisi akan hilang.')) {
            form.reset();
            fileInput.value = '';
            updateFilePreview(new FileList());
            document.querySelectorAll('.form-floating .form-control, .form-floating .form-select').forEach(el => el.blur());
        }
    });

});
</script>