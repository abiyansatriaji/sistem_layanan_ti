<div class="d-flex justify-content-between mb-3">
  <h4><?= $title ?></h4>
  <?php if (in_array($user['nama_role'], ['Pelapor','Admin'])): ?>
    <a href="<?= site_url('tiket/create') ?>" class="btn btn-primary">+ Buat Tiket</a>
  <?php endif; ?>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-4"><input type="text" name="q" value="<?= $this->input->get('q') ?>" class="form-control" placeholder="Cari judul..."></div>
  <div class="col-md-3">
    <select name="status" class="form-select">
      <option value="">Semua Status</option>
      <?php foreach ($status_list as $s): ?>
        <option value="<?= $s->id_status ?>" <?= ($this->input->get('status')==$s->id_status)?'selected':'' ?>><?= $s->nama_status ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-2"><button class="btn btn-secondary">Filter</button></div>
</form>

<div class="card border-0 shadow-sm">
<table class="table table-hover mb-0">
<thead class="table-light"><tr>
  <th>Kode</th><th>Judul</th><th>Pelapor</th><th>Kategori</th><th>Prioritas</th><th>Status</th><th>Tgl</th><th>Aksi</th>
</tr></thead>
<tbody>
<?php foreach ($tikets as $t): ?>
<tr>
  <td><code><?= $t->kode_tiket ?></code></td>
  <td><?= $t->judul ?></td>
  <td><?= $t->nama_pelapor ?></td>
  <td><?= $t->nama_kategori ?></td>
  <td><span class="badge bg-<?= $t->prioritas=='Tinggi'?'danger':($t->prioritas=='Sedang'?'warning':'secondary') ?>"><?= $t->prioritas ?></span></td>
  <td><span class="badge bg-info"><?= $t->nama_status ?></span></td>
  <td><?= date('d/m/Y', strtotime($t->tanggal_laporan)) ?></td>
  <td><a href="<?= site_url('tiket/detail/'.$t->id_tiket) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
</tr>
<?php endforeach; ?>
<?php if (empty($tikets)): ?>
<tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>