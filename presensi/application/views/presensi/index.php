<div class="row g-4">
  <div class="col-lg-5">
    <div class="hero text-center h-100">
      <div class="opacity-75"><?= tgl_id(date('Y-m-d')) ?></div>
      <div class="clock my-2" id="clock">--:--:--</div>
      <div class="small opacity-75 mb-4">Batas masuk pukul <?= $batas ?> · waktu dicatat oleh server</div>
      <div class="d-flex gap-2 justify-content-center mb-4">
        <div class="bg-white bg-opacity-10 rounded-4 p-3 flex-fill"><div class="small opacity-75">Masuk</div><div class="fs-4 fw-bold"><?= $today ? jam($today->jam_masuk) : '--:--' ?></div></div>
        <div class="bg-white bg-opacity-10 rounded-4 p-3 flex-fill"><div class="small opacity-75">Pulang</div><div class="fs-4 fw-bold"><?= $today ? jam($today->jam_pulang) : '--:--' ?></div></div>
      </div>
      <?php if (!$today): ?>
        <?= form_open('presensi/masuk') ?><button class="btn btn-light btn-absen w-100"><i class="bi bi-box-arrow-in-right"></i> Absen Masuk</button><?= form_close() ?>
      <?php elseif (!$today->jam_pulang): ?>
        <?= form_open('presensi/pulang') ?><button class="btn btn-warning btn-absen w-100"><i class="bi bi-box-arrow-right"></i> Absen Pulang</button><?= form_close() ?>
      <?php else: ?>
        <div class="fw-semibold"><i class="bi bi-check-circle-fill"></i> Presensi hari ini selesai</div>
      <?php endif; ?>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="card-x p-3 p-lg-4">
      <h5 class="fw-bold">Riwayat <?= nama_bulan(substr($bulan, 5, 2)) ?> <?= substr($bulan, 0, 4) ?></h5>
      <div class="table-responsive"><table class="table align-middle mb-0">
        <thead><tr><th>Tanggal</th><th>Masuk</th><th>Pulang</th><th>Status</th></tr></thead><tbody>
        <?php foreach ($riwayat as $r): ?>
          <tr><td><?= tgl_id($r->tanggal) ?></td><td><?= jam($r->jam_masuk) ?></td><td><?= jam($r->jam_pulang) ?></td><td><?= badge($r->status) ?></td></tr>
        <?php endforeach; if (!$riwayat): ?><tr><td colspan="4" class="text-center text-secondary py-4">Belum ada data presensi bulan ini.</td></tr><?php endif; ?>
      </tbody></table></div>
    </div>
  </div>
</div>
