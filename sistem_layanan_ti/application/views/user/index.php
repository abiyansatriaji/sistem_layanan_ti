<div class="d-flex justify-content-between mb-3">
  <h4><?= $title ?></h4>
  <a href="<?= site_url('user/create') ?>" class="btn btn-primary">+ Tambah User</a>
</div>
<div class="card border-0 shadow-sm">
<table class="table table-hover mb-0">
<thead class="table-light"><tr>
  <th>Nama</th><th>Username</th><th>Role</th><th>Unit</th><th>Email</th><th>Status</th><th>Aksi</th>
</tr></thead>
<tbody>
<?php foreach ($users as $u): ?>
<tr>
  <td><?= $u->nama ?></td>
  <td><code><?= $u->username ?></code></td>
  <td><?= $u->nama_role ?></td>
  <td><?= $u->nama_unit ?></td>
  <td><?= $u->email ?></td>
  <td><span class="badge bg-<?= $u->status_akun=='Aktif'?'success':'secondary' ?>"><?= $u->status_akun ?></span></td>
  <td>
    <a href="<?= site_url('user/edit/'.$u->id_user) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
    <a href="<?= site_url('user/delete/'.$u->id_user) ?>" class="btn btn-sm btn-outline-danger"
       onclick="return confirm('Hapus user?')">Hapus</a>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>