<ul class="nav nav-tabs mb-3">
  <?php foreach (['roles'=>'Role','unit'=>'Unit','jenis'=>'Jenis','kategori'=>'Kategori','status'=>'Status'] as $k=>$v): ?>
    <li class="nav-item">
      <a class="nav-link <?= $key==$k?'active':'' ?>" href="<?= site_url('master/'.$k) ?>"><?= $v ?></a>
    </li>
  <?php endforeach; ?>
</ul>

<div class="row">
  <div class="col-md-5">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white fw-bold"><?= $edit_row?'Edit':'Tambah' ?> <?= $label ?></div>
      <div class="card-body">
        <?= form_open('master/'.$key) ?>
          <?php if ($edit_row): ?>
            <input type="hidden" name="id" value="<?= $edit_row->$pk ?>">
          <?php endif; ?>
          <?php foreach ($cols as $c): ?>
            <div class="mb-2">
              <label class="form-label text-capitalize"><?= str_replace('_',' ',$c) ?></label>
              <?php if ($c=='deskripsi' || $c=='keterangan'): ?>
                <textarea name="<?= $c ?>" class="form-control" rows="2"><?= $edit_row ? $edit_row->$c : '' ?></textarea>
              <?php else: ?>
                <input type="text" name="<?= $c ?>" class="form-control" value="<?= $edit_row ? $edit_row->$c : '' ?>" required>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
          <button class="btn btn-primary btn-sm">Simpan</button>
          <?php if ($edit_row): ?>
            <a href="<?= site_url('master/'.$key) ?>" class="btn btn-secondary btn-sm">Batal</a>
          <?php endif; ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>

  <div class="col-md-7">
    <div class="card border-0 shadow-sm">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <?php foreach ($cols as $c): ?><th class="text-capitalize"><?= str_replace('_',' ',$c) ?></th><?php endforeach; ?>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <?php foreach ($cols as $c): ?><td><?= $r->$c ?></td><?php endforeach; ?>
            <td>
              <a href="<?= site_url('master/'.$key.'?edit='.$r->$pk) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
              <?= form_open('master/'.$key, ['style'=>'display:inline']) ?>
                <input type="hidden" name="delete_id" value="<?= $r->$pk ?>">
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button>
              <?= form_close() ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>