<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <h3 class="page-title">Rekap Presensi & Cuti</h3>
  <form method="get" action="<?= site_url('admin/rekap') ?>" class="d-flex gap-2">
    <input type="month" name="bulan" value="<?= html_escape($bulan) ?>" class="form-control">
    <button class="btn btn-brand">Tampilkan</button>
    <a class="btn btn-success" href="<?= site_url('admin/rekap') . '?bulan=' . $bulan . '&csv=1' ?>"><i class="bi bi-file-earmark-excel"></i> CSV</a>
  </form>
</div>
<div class="card-x p-3 p-lg-4">
  <div class="mb-3 text-secondary">Periode <b><?= nama_bulan(substr($bulan, 5, 2)) ?> <?= substr($bulan, 0, 4) ?></b></div>
  <div class="table-responsive"><table class="table align-middle mb-0">
    <thead><tr><th>Nama</th><th>NIP</th><th>Jabatan</th><th class="text-center">Hadir</th><th class="text-center">Terlambat</th><th class="text-center">Hari Cuti</th></tr></thead><tbody>
    <?php foreach ($rows as $r): ?>
      <tr><td class="fw-semibold"><?= html_escape($r->nama) ?></td><td><?= html_escape($r->nip) ?></td><td><?= html_escape($r->jabatan) ?></td>
      <td class="text-center"><span class="badge text-bg-success"><?= $r->hadir ?></span></td>
      <td class="text-center"><span class="badge text-bg-warning"><?= $r->terlambat ?></span></td>
      <td class="text-center"><span class="badge text-bg-info"><?= $r->cuti ?></span></td></tr>
    <?php endforeach; if (!$rows): ?><tr><td colspan="6" class="text-center text-secondary py-4">Tidak ada data.</td></tr><?php endif; ?>
  </tbody></table></div>
</div>
