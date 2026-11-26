<?php $h = (int) date('H'); $salam = $h < 11 ? 'Selamat pagi' : ($h < 15 ? 'Selamat siang' : ($h < 18 ? 'Selamat sore' : 'Selamat malam')); ?>
<div class="hero mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
  <div>
    <div class="opacity-75"><?= $salam ?>,</div>
    <h3 class="fw-bold mb-1"><?= html_escape($user->nama) ?></h3>
    <div class="opacity-75"><?= html_escape($user->jabatan) ?> · <?= tgl_id(date('Y-m-d')) ?></div>
  </div>
  <div class="text-lg-end">
    <div class="clock" id="clock">--:--:--</div>
    <a href="<?= site_url('presensi') ?>" class="btn btn-light fw-semibold mt-2"><i class="bi bi-fingerprint"></i>
      <?= $today ? ($today->jam_pulang ? 'Lihat Presensi' : 'Absen Pulang') : 'Absen Masuk' ?></a>
  </div>
</div>
<div class="row g-3 mb-4">
<?php foreach ($stats as $s): ?>
  <div class="col-6 col-xl-3"><div class="card-x stat">
    <div class="ico bg-<?= $s[3] ?>-subtle text-<?= $s[3] ?>"><i class="bi <?= $s[2] ?>"></i></div>
    <div><div class="v"><?= html_escape($s[1]) ?></div><div class="l"><?= $s[0] ?></div></div>
  </div></div>
<?php endforeach; ?>
</div>
<div class="card-x p-3 p-lg-4">
  <div class="d-flex justify-content-between mb-2"><h5 class="fw-bold mb-0">Pengajuan Cuti Terbaru</h5><a href="<?= site_url('cuti') ?>" class="small">Lihat semua</a></div>
  <div class="table-responsive"><table class="table align-middle mb-0">
    <thead><tr><th>Pegawai</th><th>Jenis</th><th>Tanggal</th><th>Hari</th><th>Status</th></tr></thead><tbody>
    <?php foreach ($recent as $r): ?>
      <tr><td><?= html_escape($r->nama) ?></td><td><?= ucfirst($r->jenis) ?></td>
      <td><?= tgl_id($r->tgl_mulai) ?> – <?= tgl_id($r->tgl_selesai) ?></td><td><?= $r->jumlah_hari ?></td><td><?= badge($r->status) ?></td></tr>
    <?php endforeach; if (!$recent): ?><tr><td colspan="5" class="text-center text-secondary py-4">Belum ada pengajuan.</td></tr><?php endif; ?>
  </tbody></table></div>
</div>
