<h4><?= $title ?></h4>
<?= validation_errors('<div class="alert alert-danger">','</div>') ?>
<div class="card border-0 shadow-sm"><div class="card-body">
<?php $edit = isset($user_edit) ? $user_edit : null; ?>
<?= form_open($edit ? 'user/edit/'.$edit->id_user : 'user/create') ?>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="nama" class="form-control" value="<?= $edit ? $edit->nama : set_value('nama') ?>" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" value="<?= $edit ? $edit->username : set_value('username') ?>" <?= $edit?'readonly':'' ?> required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Password <?= $edit?'(kosongkan jika tidak diubah)':'' ?></label>
      <input type="password" name="password" class="form-control" <?= $edit?'':'required' ?>>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= $edit ? $edit->email : set_value('email') ?>">
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">No HP</label>
      <input type="text" name="no_hp" class="form-control" value="<?= $edit ? $edit->no_hp : set_value('no_hp') ?>">
    </div>
    <div class="col-md-3 mb-3">
      <label class="form-label">Role</label>
      <select name="id_role" class="form-select" required>
        <?php foreach ($roles as $r): ?>
          <option value="<?= $r->id_role ?>" <?= ($edit && $edit->id_role==$r->id_role)?'selected':'' ?>><?= $r->nama_role ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3 mb-3">
      <label class="form-label">Unit</label>
      <select name="id_unit" class="form-select" required>
        <?php foreach ($units as $un): ?>
          <option value="<?= $un->id_unit ?>" <?= ($edit && $edit->id_unit==$un->id_unit)?'selected':'' ?>><?= $un->nama_unit ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3 mb-3">
      <label class="form-label">Status</label>
      <select name="status_akun" class="form-select">
        <option value="Aktif" <?= ($edit && $edit->status_akun=='Aktif')?'selected':'' ?>>Aktif</option>
        <option value="Tidak Aktif" <?= ($edit && $edit->status_akun=='Tidak Aktif')?'selected':'' ?>>Tidak Aktif</option>
      </select>
    </div>
  </div>
  <button class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('user') ?>" class="btn btn-secondary">Batal</a>
<?= form_close() ?>
</div></div>