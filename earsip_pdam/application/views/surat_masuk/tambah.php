<!-- ============================================================
     HALAMAN TAMBAH SURAT MASUK - E-Arsip PDAM
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
                        <i class="fas fa-envelope me-1"></i> Tambahkan surat masuk baru ke dalam sistem
                    </p>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= base_url('index.php/surat_masuk'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<!-- ============================================================
     FORM TAMBAH SURAT MASUK
     ============================================================ -->
<div class="card-form">
    <div class="card-form-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-pen-fancy"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0">Formulir Tambah Surat Masuk</h5>
                <span class="text-muted small">Lengkapi data surat masuk di bawah ini</span>
            </div>
        </div>
        <span class="badge bg-primary rounded-pill">
            <i class="far fa-calendar-alt me-1"></i> <?= date('d-m-Y'); ?>
        </span>
    </div>

    <div class="card-form-body">
        <?= form_open_multipart('index.php/surat_masuk/simpan', ['class' => 'form-surat', 'autocomplete' => 'off', 'id' => 'formSurat']); ?>

           <!-- ===== IDENTITAS SURAT ===== -->
<div class="form-section">
    <div class="form-section-title">
        <i class="fas fa-file-signature"></i> Identitas Surat
        <span class="text-muted small fw-normal ms-2">Nomor dan asal surat</span>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="no_agenda" class="form-control" id="no_agenda" placeholder="No Agenda" value="<?= $no_agenda; ?>">
                <label for="no_agenda"><i class="fas fa-hashtag text-muted me-1"></i> No Agenda</label>
            </div>
            <small class="text-muted"><i class="fas fa-info-circle"></i> Biarkan kosong untuk generate otomatis</small>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="no_surat_asal" class="form-control" id="no_surat_asal" placeholder="Masukkan No Surat Asal" required autocomplete="off">
                <label for="no_surat_asal"><i class="fas fa-file text-muted me-1"></i> No Surat Asal <span class="text-danger">*</span></label>
            </div>
            <small class="text-muted"><i class="fas fa-info-circle"></i> Nomor surat dari pengirim</small>
        </div>
    </div>
</div>

            <!-- ===== TANGGAL ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-calendar-alt"></i> Tanggal
                    <span class="text-muted small fw-normal ms-2">Tanggal surat dan tanggal terima</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="tgl_surat" class="form-control" id="tgl_surat" placeholder="Tanggal Surat" required>
                            <label for="tgl_surat"><i class="fas fa-calendar-day text-muted me-1"></i> Tanggal Surat <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Tanggal pembuatan surat</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="tgl_terima" class="form-control" id="tgl_terima" placeholder="Tanggal Terima" required>
                            <label for="tgl_terima"><i class="fas fa-calendar-check text-muted me-1"></i> Tanggal Terima <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Tanggal surat diterima</small>
                    </div>
                </div>
            </div>

            <!-- ===== PENGIRIM & PERIHAL ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle"></i> Detail Surat
                    <span class="text-muted small fw-normal ms-2">Pengirim dan perihal</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="pengirim" class="form-control" id="pengirim" placeholder="Masukkan Nama Pengirim" required autocomplete="off">
                            <label for="pengirim"><i class="fas fa-user-tie text-muted me-1"></i> Pengirim <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Nama instansi/perusahaan pengirim</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="perihal" class="form-control" id="perihal" placeholder="Masukkan Perihal Surat" required autocomplete="off">
                            <label for="perihal"><i class="fas fa-align-left text-muted me-1"></i> Perihal <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Judul/pokok isi surat</small>
                    </div>
                </div>
            </div>

            <!-- ===== SIFAT & KLASIFIKASI ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-tags"></i> Klasifikasi
                    <span class="text-muted small fw-normal ms-2">Sifat dan klasifikasi surat</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="sifat_surat" class="form-select" id="sifat_surat">
                                <option value="biasa">Biasa</option>
                                <option value="penting">Penting</option>
                                <option value="rahasia">Rahasia</option>
                                <option value="segera">Segera</option>
                            </select>
                            <label for="sifat_surat"><i class="fas fa-shield-alt text-muted me-1"></i> Sifat Surat</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Tingkat kepentingan surat</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="klasifikasi_id" class="form-select" id="klasifikasi_id">
                                <option value="">-- Pilih Klasifikasi --</option>
                                <?php foreach($klasifikasi as $k): ?>
                                    <option value="<?= $k->id; ?>"><?= $k->kode_klasifikasi . ' - ' . $k->nama_klasifikasi; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="klasifikasi_id"><i class="fas fa-folder text-muted me-1"></i> Klasifikasi</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Klasifikasi jenis surat</small>
                    </div>
                </div>
            </div>

            <!-- ============================================================
                 LAMPIRAN - dengan Preview File & Thumbnail Gambar
                 ============================================================ -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-paperclip"></i> Lampiran
                    <span class="text-muted small fw-normal ms-2">Upload file pendukung (PDF, DOC, JPG, PNG, ZIP)</span>
                </div>

                <div class="upload-area">
                    <div class="upload-box" id="uploadBox">
                        <i class="fas fa-cloud-upload-alt" id="uploadIcon"></i>
                        <p class="mb-1 fw-semibold" id="uploadText">Upload Lampiran</p>
                        <span class="text-muted small">PDF, DOC, JPG, PNG, ZIP | Max 5MB</span>
                        <input type="file" name="lampiran[]" class="form-control" id="fileInput" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">
                    </div>
                </div>
                
                <!-- ===== PREVIEW FILE ===== -->
                <div id="filePreview" class="file-preview-area" style="display:none;">
                    <div class="file-preview-header">
                        <span><i class="fas fa-paperclip me-1"></i> <span id="fileCount">0</span> file yang akan diupload</span>
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
                            Data surat masuk akan tersimpan dalam sistem dan dapat diakses kapan saja.
                            Pastikan data yang dimasukkan sudah benar sebelum menyimpan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===== TOMBOL ===== -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-submit" id="btnSubmit">
                    <i class="fas fa-save me-2"></i> Simpan Surat
                </button>
                <a href="<?= base_url('index.php/surat_masuk'); ?>" class="btn btn-outline-secondary">
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
     STYLE KHUSUS TAMBAH SURAT MASUK + PREVIEW FILE + THUMBNAIL
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

    .form-floating .form-control,
    .form-floating .form-select {
        border-radius: 12px;
        border: 2px solid var(--slate-200, #e2e8f0);
        background: var(--slate-50, #f8fafc);
        transition: var(--transition, all 0.3s ease);
        font-size: 0.95rem;
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

    .form-floating .form-control:disabled,
    .form-floating .form-control[readonly] {
        background: var(--slate-100, #f1f5f9);
        color: var(--slate-500, #64748b);
        cursor: not-allowed;
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

    .form-floating .form-select:focus ~ label,
    .form-floating .form-select:not([value=""]) ~ label {
        color: #2563eb;
        font-weight: 600;
    }

    /* ===== UPLOAD AREA ===== */
    .upload-area {
        position: relative;
    }

    .upload-box {
        border: 2px dashed var(--slate-300, #cbd5e1);
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        transition: var(--transition, all 0.3s ease);
        background: var(--slate-50, #f8fafc);
        position: relative;
        cursor: pointer;
    }

    .upload-box:hover {
        border-color: #3b82f6;
        background: var(--blue-50, #eff6ff);
    }

    .upload-box.has-files {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .upload-box i {
        font-size: 2.5rem;
        color: var(--slate-400, #94a3b8);
        margin-bottom: 8px;
    }

    .upload-box.has-files i {
        color: #16a34a;
    }

    .upload-box input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    /* ===== FILE PREVIEW ===== */
    .file-preview-area {
        margin-top: 12px;
        background: var(--slate-50, #f8fafc);
        border-radius: 10px;
        border: 1px solid var(--slate-200, #e2e8f0);
        overflow: hidden;
        transition: var(--transition, all 0.3s ease);
    }

    .file-preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        background: #fff;
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--slate-700, #334155);
    }

    .file-preview-header span i {
        color: #2563eb;
    }

    .btn-clear-files {
        background: transparent;
        border: none;
        color: var(--slate-400, #94a3b8);
        padding: 4px 8px;
        border-radius: 6px;
        transition: var(--transition, all 0.3s ease);
        font-size: 0.85rem;
        cursor: pointer;
    }

    .btn-clear-files:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .file-list {
        padding: 8px 12px;
        max-height: 300px;
        overflow-y: auto;
    }

    .file-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 10px;
        border-radius: 8px;
        background: #ffffff;
        margin-bottom: 6px;
        border: 1px solid var(--slate-100, #f1f5f9);
        transition: var(--transition, all 0.3s ease);
        font-size: 0.85rem;
    }

    .file-item:last-child {
        margin-bottom: 0;
    }

    .file-item:hover {
        border-color: var(--slate-200, #e2e8f0);
    }

    /* ===== THUMBNAIL GAMBAR ===== */
    .file-thumbnail {
        width: 50px;
        height: 50px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
        background: var(--slate-100, #f1f5f9);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--slate-200, #e2e8f0);
    }

    .file-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-thumbnail .file-icon {
        font-size: 1.5rem;
        color: var(--slate-400, #94a3b8);
    }

    .file-thumbnail .file-icon.pdf { color: #dc2626; }
    .file-thumbnail .file-icon.doc { color: #2563eb; }
    .file-thumbnail .file-icon.zip { color: #4338ca; }
    .file-thumbnail .file-icon.other { color: #64748b; }

    .file-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .file-name {
        font-weight: 500;
        color: var(--slate-800, #1e293b);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-size {
        font-size: 0.7rem;
        color: var(--slate-400, #94a3b8);
    }

    .file-status {
        font-size: 0.7rem;
        color: #16a34a;
        font-weight: 600;
        white-space: nowrap;
    }

    .file-status i {
        color: #16a34a;
    }

    .btn-remove-file {
        background: transparent;
        border: none;
        color: var(--slate-400, #94a3b8);
        padding: 4px 6px;
        border-radius: 4px;
        cursor: pointer;
        transition: var(--transition, all 0.3s ease);
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    .btn-remove-file:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    /* ===== FORM SECTION INFO ===== */
    .form-section-info {
        background: linear-gradient(135deg, var(--blue-50, #eff6ff), #dbeafe);
        border-radius: 12px;
        padding: 18px 24px;
        border: 1px solid var(--blue-200, #bfdbfe);
        margin-top: 8px;
        border-bottom: none;
    }

    .form-section-info .info-icon {
        width: 44px;
        height: 44px;
        background: #ffffff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 1.3rem;
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

    /* ===== SCROLLBAR ===== */
    .file-list::-webkit-scrollbar {
        width: 4px;
    }

    .file-list::-webkit-scrollbar-track {
        background: var(--slate-100, #f1f5f9);
        border-radius: 4px;
    }

    .file-list::-webkit-scrollbar-thumb {
        background: var(--slate-300, #cbd5e1);
        border-radius: 4px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-form-body { padding: 18px; }
        .card-form-header { padding: 14px 18px; }
        .card-form-header h5 { font-size: 0.95rem; }
        .form-section { margin-bottom: 20px; padding-bottom: 16px; }
        .form-floating .form-control, .form-floating .form-select { height: 50px; font-size: 0.85rem; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
        .form-section-info { padding: 14px 16px; }
        .upload-box { padding: 20px 16px; }
        .upload-box i { font-size: 2rem; }
        .file-item { font-size: 0.78rem; }
        .file-thumbnail { width: 40px; height: 40px; }
    }

    @media (max-width: 576px) {
        .page-header .header-icon { width: 40px; height: 40px; font-size: 1rem; }
        .page-header h4 { font-size: 1.1rem; }
        .card-form-header .header-decoration { width: 32px; height: 32px; font-size: 0.8rem; }
        .form-floating .form-control, .form-floating .form-select { height: 46px; padding-top: 14px; font-size: 0.8rem; }
        .form-floating label { font-size: 0.75rem; }
        .file-thumbnail { width: 36px; height: 36px; }
    }
</style>

<!-- ============================================================
     SCRIPT PREVIEW FILE + THUMBNAIL GAMBAR
     ============================================================ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Fungsi untuk mendapatkan ikon berdasarkan ekstensi
    function getFileIconClass(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        const classes = {
            'pdf': 'pdf',
            'doc': 'doc',
            'docx': 'doc',
            'xls': 'doc',
            'xlsx': 'doc',
            'jpg': 'image',
            'jpeg': 'image',
            'png': 'image',
            'gif': 'image',
            'zip': 'zip',
            'rar': 'zip'
        };
        return classes[ext] || 'other';
    }

    function getFileIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        const icons = {
            'pdf': 'fa-file-pdf',
            'doc': 'fa-file-word',
            'docx': 'fa-file-word',
            'xls': 'fa-file-excel',
            'xlsx': 'fa-file-excel',
            'jpg': 'fa-file-image',
            'jpeg': 'fa-file-image',
            'png': 'fa-file-image',
            'gif': 'fa-file-image',
            'zip': 'fa-file-archive',
            'rar': 'fa-file-archive'
        };
        return icons[ext] || 'fa-file';
    }

    // Fungsi untuk format ukuran file
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // Fungsi untuk mengecek apakah file adalah gambar
    function isImageFile(file) {
        return file.type.startsWith('image/');
    }

    // Fungsi update preview dengan thumbnail
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

            // Buat thumbnail
            const thumbnailDiv = document.createElement('div');
            thumbnailDiv.className = 'file-thumbnail';

            if (isImage) {
                // Tampilkan thumbnail gambar
                const img = document.createElement('img');
                img.alt = file.name;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                thumbnailDiv.appendChild(img);

                // Baca file sebagai data URL
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                // Tampilkan ikon
                const iconEl = document.createElement('i');
                iconEl.className = 'fas ' + icon + ' file-icon ' + iconClass;
                thumbnailDiv.appendChild(iconEl);
            }

            // Buat info file
            const infoDiv = document.createElement('div');
            infoDiv.className = 'file-info';
            infoDiv.innerHTML = `
                <span class="file-name">${file.name}</span>
                <span class="file-size">${size}</span>
            `;

            const statusSpan = document.createElement('span');
            statusSpan.className = 'file-status';
            statusSpan.innerHTML = '<i class="fas fa-check-circle"></i> Siap diupload';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-file';
            removeBtn.dataset.index = i;
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.title = 'Hapus file';

            item.appendChild(thumbnailDiv);
            item.appendChild(infoDiv);
            item.appendChild(statusSpan);
            item.appendChild(removeBtn);

            fileList.appendChild(item);

            // Event hapus file individu
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const index = parseInt(this.dataset.index);
                const dt = new DataTransfer();
                for (let j = 0; j < files.length; j++) {
                    if (j !== index) {
                        dt.items.add(files[j]);
                    }
                }
                fileInput.files = dt.files;
                updateFilePreview(dt.files);
            });
        }
    }

    // Event saat file dipilih
    fileInput.addEventListener('change', function(e) {
        updateFilePreview(this.files);
    });

    // Hapus semua file
    clearFiles.addEventListener('click', function() {
        fileInput.value = '';
        updateFilePreview(new FileList());
    });

    // Reset form
    btnReset.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Reset semua field? Data yang sudah diisi akan hilang.')) {
            form.reset();
            fileInput.value = '';
            updateFilePreview(new FileList());
            document.querySelectorAll('.form-floating .form-control, .form-floating .form-select').forEach(function(el) {
                el.blur();
            });
        }
    });

    // Drag & Drop visual enhancement
    uploadBox.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#2563eb';
        this.style.background = '#eff6ff';
    });

    uploadBox.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '';
        this.style.background = '';
    });
});
</script>