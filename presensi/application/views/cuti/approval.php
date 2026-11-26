<h3 class="page-title mb-4">Persetujuan Cuti</h3>
<?php if (!$list): ?><div class="card-x p-5 text-center text-secondary"><i class="bi bi-inbox fs-1"></i><div class="mt-2">Tidak ada pengajuan yang menunggu persetujuan.</div></div><?php endif; ?>
<div class="row g-3">
<?php foreach ($list as $r): ?>
  <div class="col-lg-6"><div class="card-x p-4">
    <div class="d-flex justify-content-between"><div><div class="fw-bold fs-5"><?= html_escape($r->nama) ?></div><div class="small text-secondary"><?= html_escape($r->jabatan) ?></div></div><?= badge($r->status) ?></div>
    <hr>
    <div class="small mb-1"><b><?= ucfirst($r->jenis) ?></b> · <?= tgl_id($r->tgl_mulai) ?> – <?= tgl_id($r->tgl_selesai) ?> (<?= $r->jumlah_hari ?> hari kerja)</div>
    <div class="mb-2"><?= html_escape($r->alasan) ?></div>
    <?php if ($r->lampiran): ?><a class="small" target="_blank" href="<?= base_url('uploads/' . $r->lampiran) ?>"><i class="bi bi-paperclip"></i> Lihat lampiran</a><?php endif; ?>
    <?= form_open('cuti/proses/' . $r->id, ['class' => 'mt-3']) ?>
      <input name="catatan" class="form-control mb-2" placeholder="Catatan (opsional)" maxlength="250">
      <div class="d-flex gap-2">
        <button name="aksi" value="setuju" class="btn btn-success flex-fill"><i class="bi bi-check-lg"></i> Setujui</button>
        <button name="aksi" value="tolak" class="btn btn-outline-danger flex-fill"><i class="bi bi-x-lg"></i> Tolak</button>
      </div>
    <?= form_close() ?>
  </div></div>
<?php endforeach; ?>
</div>
