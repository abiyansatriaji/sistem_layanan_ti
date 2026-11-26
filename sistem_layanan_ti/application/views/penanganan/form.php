<h4><?= $title ?></h4>
<div class="card border-0 shadow-sm">
<div class="card-body">
  <p>Tiket: <code><?= $tiket->kode_tiket ?></code> — <?= $tiket->judul ?></p>
  <?= validation_errors('<div class="alert alert-danger">','</div>') ?>
  
  <!-- Wajib pakai multipart untuk upload file -->
  <?= form_open_multipart('penanganan/'.$tiket->id_tiket) ?>
    
    <div class="mb-3">
      <label class="form-label">Tindakan yang Dilakukan <span class="text-danger">*</span></label>
      <textarea name="tindakan" rows="3" class="form-control" required placeholder="Contoh: Mengganti kabel LAN yang putus..."></textarea>
    </div>
    
    <div class="mb-3">
      <label class="form-label">Catatan Tambahan (Opsional)</label>
      <textarea name="catatan" rows="2" class="form-control" placeholder="Contoh: Sudah dites, koneksi stabil."></textarea>
    </div>

    <!-- Ini form upload yang hanya ada di halaman teknisi -->
    <div class="mb-3">
      <label class="form-label">Upload Foto Bukti Perbaikan (Opsional)</label>
      <input type="file" name="file_bukti" class="form-control">
      <div class="form-text text-muted">Format: JPG, PNG, atau PDF. Maksimal 5MB.</div>
    </div>

    <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Penanganan</button>
    <a href="<?= site_url('tiket/detail/'.$tiket->id_tiket) ?>" class="btn btn-secondary">Batal</a>
  <?= form_close() ?>
</div></div>