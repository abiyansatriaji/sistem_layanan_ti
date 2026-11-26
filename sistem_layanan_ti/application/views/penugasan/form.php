<h4><?= $title ?></h4>
<div class="card border-0 shadow-sm">
<div class="card-body">
  <p>Tiket: <code><?= $tiket->kode_tiket ?></code> — <?= $tiket->judul ?></p>
  <?= validation_errors('<div class="alert alert-danger">','</div>') ?>
  <?= form_open('penugasan/'.$tiket->id_tiket) ?>
    <div class="mb-3">
      <label class="form-label">Pilih Teknisi</label>
      <select name="id_teknisi" class="form-select" required>
        <option value="">- Pilih Teknisi -</option>
        <?php foreach ($teknisi as $t): ?>
          <option value="<?= $t->id_user ?>"><?= $t->nama ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Catatan Penugasan</label>
      <textarea name="catatan_penugasan" rows="3" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Tugaskan</button>
    <a href="<?= site_url('tiket/detail/'.$tiket->id_tiket) ?>" class="btn btn-secondary">Batal</a>
  <?= form_close() ?>
</div></div>