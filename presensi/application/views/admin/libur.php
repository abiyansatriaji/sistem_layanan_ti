<h3 class="page-title mb-4">Kalender Hari Libur</h3>
<div class="row g-4">
  <div class="col-lg-4"><div class="card-x p-4">
    <h6 class="fw-bold mb-3">Tambah Hari Libur</h6>
    <?= form_open('admin/libur') ?>
      <input type="date" name="tanggal" class="form-control mb-2" required>
      <input name="keterangan" class="form-control mb-3" placeholder="Keterangan" required>
      <button class="btn btn-brand w-100">Tambah</button>
    <?= form_close() ?>
  </div></div>
  <div class="col-lg-8"><div class="card-x p-3 p-lg-4"><div class="table-responsive"><table class="table align-middle mb-0">
    <thead><tr><th>Tanggal</th><th>Keterangan</th><th></th></tr></thead><tbody>
    <?php foreach ($list as $l): ?>
      <tr><td><?= tgl_id($l->tanggal) ?></td><td><?= html_escape($l->keterangan) ?></td>
      <td class="text-end"><?= form_open('admin/hapus_libur/' . $l->id, ['onsubmit' => "return confirm('Hapus hari libur ini?')"]) ?><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button><?= form_close() ?></td></tr>
    <?php endforeach; if (!$list): ?><tr><td colspan="3" class="text-center text-secondary py-4">Belum ada data.</td></tr><?php endif; ?>
  </tbody></table></div></div></div>
</div>
