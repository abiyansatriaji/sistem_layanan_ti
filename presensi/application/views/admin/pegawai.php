<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <h3 class="page-title">Data Pegawai</h3>
  <button class="btn btn-brand" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus-fill"></i> Tambah Pegawai</button>
</div>
<div class="card-x p-3 p-lg-4"><div class="table-responsive"><table class="table align-middle mb-0">
  <thead><tr><th>Nama</th><th>NIP</th><th>Jabatan</th><th>Role</th><th>Atasan</th><th>Status</th><th></th></tr></thead><tbody>
  <?php foreach ($list as $u): ?>
    <tr><td class="fw-semibold"><?= html_escape($u->nama) ?><div class="small text-secondary fw-normal">@<?= html_escape($u->username) ?></div></td>
    <td><?= html_escape($u->nip) ?></td><td><?= html_escape($u->jabatan) ?></td><td><?= role_label($u->role) ?></td><td><?= html_escape($u->atasan_nama ?: '-') ?></td>
    <td><span class="badge rounded-pill text-bg-<?= $u->aktif ? 'success' : 'secondary' ?>"><?= $u->aktif ? 'Aktif' : 'Nonaktif' ?></span></td>
    <td class="text-end"><?php if ($u->id != $user->id): ?><?= form_open('admin/toggle/' . $u->id) ?><button class="btn btn-sm btn-outline-secondary"><?= $u->aktif ? 'Nonaktifkan' : 'Aktifkan' ?></button><?= form_close() ?><?php endif; ?></td></tr>
  <?php endforeach; ?>
</tbody></table></div></div>
<div class="modal fade" id="tambah" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content" style="border-radius:20px">
  <?= form_open('admin/simpan') ?>
  <div class="modal-header border-0"><h5 class="modal-title fw-bold">Tambah Pegawai</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
  <div class="modal-body row g-3">
    <div class="col-12"><input name="nama" class="form-control" placeholder="Nama lengkap" required></div>
    <div class="col-6"><input name="nip" class="form-control" placeholder="NIP"></div>
    <div class="col-6"><input name="jabatan" class="form-control" placeholder="Jabatan"></div>
    <div class="col-6"><input name="username" class="form-control" placeholder="Username" required></div>
    <div class="col-6"><input type="password" name="password" class="form-control" placeholder="Password (min. 6)" required></div>
    <div class="col-6"><select name="role" class="form-select"><option value="pegawai">Pegawai</option><option value="atasan">Atasan</option><option value="admin_hr">Admin HR</option></select></div>
    <div class="col-6"><select name="atasan_id" class="form-select"><option value="">— Atasan langsung —</option><?php foreach ($atasan as $a): ?><option value="<?= $a->id ?>"><?= html_escape($a->nama) ?></option><?php endforeach; ?></select></div>
  </div>
  <div class="modal-footer border-0"><button class="btn btn-brand">Simpan</button></div>
  <?= form_close() ?>
</div></div></div>
