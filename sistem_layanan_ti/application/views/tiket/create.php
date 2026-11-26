<h4><?= $title ?></h4>
<?= validation_errors('<div class="alert alert-danger">','</div>') ?>
<div class="card border-0 shadow-sm">
<div class="card-body">
<?= form_open('tiket/create') ?>
  <div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="judul" class="form-control" value="<?= set_value('judul') ?>" required>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Jenis Layanan</label>
      <select name="id_jenis" class="form-select" required>
        <option value="">- Pilih -</option>
        <?php foreach ($jenis as $j): ?>
          <option value="<?= $j->id_jenis ?>"><?= $j->nama_jenis ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Kategori</label>
      <select name="id_kategori" class="form-select" required>
        <option value="">- Pilih -</option>
        <?php foreach ($kategori as $k): ?>
          <option value="<?= $k->id_kategori ?>"><?= $k->nama_kategori ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Lokasi</label>
      <input type="text" name="lokasi" class="form-control" value="<?= set_value('lokasi') ?>">
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Prioritas</label>
      <select name="prioritas" class="form-select">
        <option value="Rendah">Rendah</option>
        <option value="Sedang" selected>Sedang</option>
        <option value="Tinggi">Tinggi</option>
      </select>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" rows="4" class="form-control" required><?= set_value('deskripsi') ?></textarea>
  </div>
  <button class="btn btn-primary">Simpan Tiket</button>
  <a href="<?= site_url('tiket') ?>" class="btn btn-secondary">Batal</a>
<?= form_close() ?>
</div></div>