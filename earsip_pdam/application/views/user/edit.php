<!-- ============================================================
     HALAMAN EDIT USER - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0"><?= $title; ?></h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-envelope me-1"></i> Perbarui data pengguna sistem manajemen surat digital
                    </p>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= base_url('index.php/user'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<!-- ===== ALERT NOTIFIKASI ===== -->
<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ============================================================
     FORM EDIT USER
     ============================================================ -->
<div class="card-form">
    <div class="card-form-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-pen-fancy"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0">Formulir Edit Pengguna</h5>
                <span class="text-muted small">Perbarui data pengguna di bawah ini</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning text-dark rounded-pill">
                <i class="fas fa-edit me-1"></i> Edit Mode
            </span>
            <span class="badge bg-<?= ($user->status == 'aktif') ? 'success' : 'danger'; ?> rounded-pill">
                <i class="fas fa-circle me-1" style="font-size:6px;"></i>
                <?= ucfirst($user->status); ?>
            </span>
        </div>
    </div>

    <div class="card-form-body">
        <?= form_open('index.php/user/update/' . $user->id, ['class' => 'form-user']); ?>

            <!-- ===== IDENTITAS ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-id-card"></i> Identitas Pengguna
                    <span class="text-muted small fw-normal ms-2">Data diri pengguna</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama lengkap" value="<?= $user->nama; ?>" autocomplete="off" required>
                            <label for="nama"><i class="fas fa-user text-muted me-1"></i> Nama Lengkap <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Nama lengkap pengguna</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" value="<?= $user->username; ?>" autocomplete="off" required>
                            <label for="username"><i class="fas fa-user-tag text-muted me-1"></i> Username <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Username harus unik, digunakan untuk login</small>
                    </div>
                </div>
            </div>

            <!-- ===== PASSWORD & EMAIL ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-lock"></i> Keamanan &amp; Kontak
                    <span class="text-muted small fw-normal ms-2">Password dan informasi kontak</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating password-wrapper">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Kosongkan jika tidak diubah" autocomplete="new-password" minlength="6">
                            <label for="password"><i class="fas fa-key text-muted me-1"></i> Password</label>
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted" id="passwordHelp"><i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email (opsional)" value="<?= $user->email; ?>" autocomplete="off">
                            <label for="email"><i class="fas fa-envelope text-muted me-1"></i> Email</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Email opsional, untuk notifikasi jika diperlukan</small>
                    </div>
                </div>
            </div>

            <!-- ===== ROLE & BAGIAN ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-briefcase"></i> Struktur Organisasi
                    <span class="text-muted small fw-normal ms-2">Role, bagian, dan jabatan</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="role_id" class="form-select" id="role_id" required>
                                <option value="">-- Pilih Role --</option>
                                <?php 
                                $role_ids = array();
                                foreach($roles as $r): 
                                    if(!in_array($r->id, $role_ids)):
                                        $role_ids[] = $r->id;
                                ?>
                                    <option value="<?= $r->id; ?>" <?= ($r->id == $user->role_id) ? 'selected' : ''; ?>>
                                        <?= $r->nama_role; ?>
                                    </option>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </select>
                            <label for="role_id"><i class="fas fa-user-shield text-muted me-1"></i> Role <span class="text-danger">*</span></label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Menentukan hak akses pengguna</small>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="bagian_id" class="form-select" id="bagian_id">
                                <option value="">-- Pilih Bagian --</option>
                                <?php 
                                // Cek apakah data bagian ada
                                if(isset($bagian) && !empty($bagian)):
                                    foreach($bagian as $b): 
                                ?>
                                    <option value="<?= $b->id; ?>" <?= ($b->id == $user->bagian_id) ? 'selected' : ''; ?>>
                                        <?= $b->nama_bagian; ?>
                                    </option>
                                <?php 
                                    endforeach; 
                                else: 
                                ?>
                                    <option value="">Tidak ada data bagian</option>
                                <?php endif; ?>
                            </select>
                            <label for="bagian_id"><i class="fas fa-building text-muted me-1"></i> Bagian</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Unit kerja pengguna</small>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Contoh: Kabag Teknik" value="<?= $user->jabatan; ?>" autocomplete="off">
                            <label for="jabatan"><i class="fas fa-user-tie text-muted me-1"></i> Jabatan</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Contoh: Kabag Teknik, Staf Administrasi</small>
                    </div>
                </div>
            </div>

            <!-- ===== STATUS AKUN (READ-ONLY) ===== -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-user-check"></i> Status Akun
                    <span class="text-muted small fw-normal ms-2">Informasi status akun</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="status" value="<?= ucfirst($user->status); ?>" disabled>
                            <label for="status"><i class="fas fa-circle text-muted me-1"></i> Status Akun</label>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Status akun saat ini: 
                            <span class="badge bg-<?= ($user->status == 'aktif') ? 'success' : 'danger'; ?>">
                                <?= ucfirst($user->status); ?>
                            </span>
                        </small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="created_at" value="<?= date('d-m-Y H:i', strtotime($user->created_at)); ?>" disabled>
                            <label for="created_at"><i class="fas fa-calendar-alt text-muted me-1"></i> Tanggal Dibuat</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Tanggal saat akun pertama kali dibuat</small>
                    </div>
                </div>
            </div>

            <!-- ===== INFORMASI SURAT ===== -->
            <div class="form-section form-section-info">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="info-icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Manajemen Surat Digital</h6>
                        <p class="small text-muted mb-0">
                            Perubahan data pengguna akan langsung mempengaruhi akses ke sistem.
                            Pastikan data yang dimasukkan sudah benar sebelum menyimpan perubahan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===== TOMBOL ===== -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-save me-2"></i> Update Pengguna
                </button>
                <a href="<?= base_url('index.php/user'); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="reset" class="btn btn-outline-secondary">
                    <i class="fas fa-undo me-1"></i> Reset
                </button>
            </div>

        <?= form_close(); ?>
    </div>
</div>

<!-- ============================================================
     STYLE KHUSUS
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
    .form-floating .form-control:disabled { background: var(--slate-100, #f1f5f9); color: var(--slate-500, #64748b); cursor: not-allowed; }
    .form-floating label { padding: 8px 16px; font-weight: 500; font-size: 0.85rem; color: var(--slate-500, #64748b); }
    .form-floating .form-control:focus ~ label, .form-floating .form-control:not(:placeholder-shown) ~ label { color: #2563eb; font-weight: 600; }
    .password-wrapper { position: relative; }
    .password-wrapper .form-control { padding-right: 50px; }
    .password-toggle { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: var(--slate-400, #94a3b8); font-size: 1.1rem; cursor: pointer; padding: 8px; transition: var(--transition, all 0.3s ease); z-index: 5; border-radius: 8px; }
    .password-toggle:hover { color: #2563eb; background: var(--blue-50, #eff6ff); }
    .password-toggle:focus { outline: none; color: #2563eb; }
    .form-section-info { background: linear-gradient(135deg, var(--blue-50, #eff6ff), #dbeafe); border-radius: 12px; padding: 18px 24px; border: 1px solid var(--blue-200, #bfdbfe); margin-top: 8px; border-bottom: none; }
    .form-section-info .info-icon { width: 44px; height: 44px; background: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 1.3rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); flex-shrink: 0; }
    .form-actions { margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--slate-200, #e2e8f0); display: flex; gap: 10px; flex-wrap: wrap; }
    .btn-submit { background: linear-gradient(135deg, #1e40af, #3b82f6); border: none; padding: 10px 32px; border-radius: 10px; font-weight: 600; font-size: 0.95rem; transition: var(--transition, all 0.3s ease); box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25); }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(37, 99, 235, 0.35); color: #fff; }
    .btn-outline-secondary { border-radius: 10px; font-weight: 500; padding: 10px 24px; border: 2px solid var(--slate-200, #e2e8f0); }
    .btn-outline-secondary:hover { background: var(--slate-50, #f8fafc); border-color: var(--slate-300, #cbd5e1); }
    @media (max-width: 768px) { .card-form-body { padding: 18px; } .card-form-header { padding: 14px 18px; } .card-form-header h5 { font-size: 0.95rem; } .form-section { margin-bottom: 20px; padding-bottom: 16px; } .form-floating .form-control, .form-floating .form-select { height: 50px; font-size: 0.85rem; } .form-actions { flex-direction: column; } .form-actions .btn { width: 100%; justify-content: center; } .form-section-info { padding: 14px 16px; } }
    @media (max-width: 576px) { .page-header .header-icon { width: 40px; height: 40px; font-size: 1rem; border-radius: 10px; } .page-header h4 { font-size: 1.1rem; } .card-form-header .header-decoration { width: 32px; height: 32px; font-size: 0.8rem; } .card-form-header .badge { font-size: 0.6rem; } .form-floating .form-control, .form-floating .form-select { height: 46px; padding-top: 14px; font-size: 0.8rem; } .form-floating label { font-size: 0.75rem; } }
</style>

<!-- ============================================================
     SCRIPT TOGGLE PASSWORD
     ============================================================ -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                }
                this.style.transform = 'scale(0.9)';
                setTimeout(() => { this.style.transform = 'scale(1)'; }, 150);
                passwordInput.focus();
            });
        }

        const passwordField = document.getElementById('password');
        const passwordHelp = document.getElementById('passwordHelp');
        if (passwordField && passwordHelp) {
            passwordField.addEventListener('input', function() {
                const val = this.value;
                if (val.length > 0 && val.length < 6) {
                    this.style.borderColor = '#dc2626';
                    passwordHelp.innerHTML = '<i class="fas fa-exclamation-circle text-danger"></i> Password minimal 6 karakter!';
                    passwordHelp.style.color = '#dc2626';
                } else if (val.length >= 6) {
                    this.style.borderColor = '#16a34a';
                    passwordHelp.innerHTML = '<i class="fas fa-check-circle text-success"></i> Password sudah aman (minimal 6 karakter)';
                    passwordHelp.style.color = '#16a34a';
                } else {
                    this.style.borderColor = '';
                    passwordHelp.innerHTML = '<i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengubah password';
                    passwordHelp.style.color = '';
                }
            });
        }
    });
</script>