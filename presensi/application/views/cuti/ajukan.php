<h3 class="page-title mb-4">Ajukan Cuti / Izin</h3>
<div class="row"><div class="col-lg-7"><div class="card-x p-4">
  <?= form_open_multipart('cuti/ajukan') ?>
    <div class="mb-3"><label class="form-label fw-semibold">Jenis</label>
      <select name="jenis" class="form-select"><option value="tahunan">Cuti Tahunan (sisa <?= $kuota->total - $kuota->terpakai ?> hari)</option><option value="sakit">Sakit</option><option value="izin">Izin</option></select></div>
    <div class="row g-3 mb-3">
      <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Mulai</label><input type="date" name="tgl_mulai" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Selesai</label><input type="date" name="tgl_selesai" class="form-control" required></div>
    </div>
    <div class="mb-3"><label class="form-label fw-semibold">Alasan</label><textarea name="alasan" rows="3" class="form-control" required></textarea></div>
    <div class="mb-4"><label class="form-label fw-semibold">Lampiran <span class="text-secondary fw-normal">(opsional, PDF/JPG/PNG maks 2 MB)</span></label><input type="file" name="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png"></div>
    <button class="btn btn-brand"><i class="bi bi-send"></i> Kirim Pengajuan</button>
    <a href="<?= site_url('cuti') ?>" class="btn btn-light">Batal</a>
  <?= form_close() ?>
</div></div>
<div class="col-lg-5 mt-3 mt-lg-0"><div class="card-x p-4 small text-secondary">
  <h6 class="fw-bold text-dark"><i class="bi bi-info-circle"></i> Ketentuan</h6>
  Jumlah hari dihitung otomatis dengan melewati Sabtu, Minggu, dan hari libur. Hanya cuti tahunan yang memotong kuota, dan kuota baru berkurang setelah atasan menyetujui.
</div></div></div>
