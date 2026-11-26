<h4><?= $title ?></h4>
<div class="row mb-4">
  <div class="col-md-6">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white fw-bold">Tiket per Status</div>
      <ul class="list-group list-group-flush">
        <?php foreach ($by_status as $b): ?>
          <li class="list-group-item d-flex justify-content-between">
            <?= $b->nama_status ?><strong><?= $b->total ?></strong>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white fw-bold">Tiket per Kategori</div>
      <ul class="list-group list-group-flush">
        <?php foreach ($by_kategori as $b): ?>
          <li class="list-group-item d-flex justify-content-between">
            <?= $b->nama_kategori ?><strong><?= $b->total ?></strong>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-header bg-white fw-bold">Semua Tiket</div>
  <table class="table table-hover mb-0">
    <thead class="table-light"><tr>
      <th>Kode</th><th>Judul</th><th>Pelapor</th><th>Status</th><th>Tanggal</th>
    </tr></thead>
    <tbody>
    <?php foreach ($tikets as $t): ?>
      <tr>
        <td><code><?= $t->kode_tiket ?></code></td>
        <td><?= $t->judul ?></td>
        <td><?= $t->nama_pelapor ?></td>
        <td><span class="badge bg-info"><?= $t->nama_status ?></span></td>
        <td><?= date('d/m/Y', strtotime($t->tanggal_laporan)) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>