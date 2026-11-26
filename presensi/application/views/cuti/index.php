<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <h3 class="page-title">Cuti & Izin Saya</h3>
  <a href="<?= site_url('cuti/ajukan') ?>" class="btn btn-brand"><i class="bi bi-plus-lg"></i> Ajukan Cuti</a>
</div>
<div class="row g-3 mb-4">
  <?php foreach ([['Total Kuota ' . date('Y'), $kuota->total, 'bi-calendar2-week-fill', 'primary'], ['Terpakai', $kuota->terpakai, 'bi-calendar-check-fill', 'info'], ['Sisa', $kuota->total - $kuota->terpakai, 'bi-calendar2-heart-fill', 'success']] as $s): ?>
  <div class="col-12 col-md-4"><div class="card-x stat"><div class="ico bg-<?= $s[3] ?>-subtle text-<?= $s[3] ?>"><i class="bi <?= $s[2] ?>"></i></div>
    <div><div class="v"><?= $s[1] ?> hari</div><div class="l"><?= $s[0] ?></div></div></div></div>
  <?php endforeach; ?>
</div>
<div class="card-x p-3 p-lg-4"><div class="table-responsive"><table class="table align-middle mb-0">
  <thead><tr><th>Jenis</th><th>Tanggal</th><th>Hari</th><th>Alasan</th><th>Status</th><th></th></tr></thead><tbody>
  <?php foreach ($list as $r): ?>
    <tr><td><?= ucfirst($r->jenis) ?></td><td><?= tgl_id($r->tgl_mulai) ?> – <?= tgl_id($r->tgl_selesai) ?></td><td><?= $r->jumlah_hari ?></td>
    <td style="max-width:260px"><?= html_escape($r->alasan) ?><?php if ($r->catatan_atasan): ?><div class="small text-secondary">Catatan atasan: <?= html_escape($r->catatan_atasan) ?></div><?php endif; ?></td>
    <td><?= badge($r->status) ?></td>
    <td class="text-end"><?php if ($r->status === 'menunggu'): ?><?= form_open('cuti/batal/' . $r->id, ['onsubmit' => "return confirm('Batalkan pengajuan ini?')"]) ?><button class="btn btn-sm btn-outline-danger">Batalkan</button><?= form_close() ?><?php endif; ?></td></tr>
  <?php endforeach; if (!$list): ?><tr><td colspan="6" class="text-center text-secondary py-4">Belum ada pengajuan.</td></tr><?php endif; ?>
</tbody></table></div></div>
