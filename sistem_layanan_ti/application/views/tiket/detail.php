<div class="d-flex justify-content-between mb-3">
  <h4><?= $title ?></h4>
  <a href="<?= site_url('tiket') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
</div>

<div class="row">
<div class="col-md-8">
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <h5><?= $tiket->judul ?></h5>
        <span class="badge bg-info align-self-start"><?= $tiket->nama_status ?></span>
      </div>
      <div class="text-muted small mb-3">
        <code><?= $tiket->kode_tiket ?></code> · <?= date('d/m/Y H:i', strtotime($tiket->tanggal_laporan)) ?>
      </div>
      <dl class="row mb-0">
        <dt class="col-3">Pelapor</dt><dd class="col-9"><?= $tiket->nama_pelapor ?></dd>
        <dt class="col-3">Jenis</dt><dd class="col-9"><?= $tiket->nama_jenis ?></dd>
        <dt class="col-3">Kategori</dt><dd class="col-9"><?= $tiket->nama_kategori ?></dd>
        <dt class="col-3">Lokasi</dt><dd class="col-9"><?= $tiket->lokasi ?: '-' ?></dd>
        <dt class="col-3">Prioritas</dt><dd class="col-9"><?= $tiket->prioritas ?></dd>
        <dt class="col-3">Deskripsi</dt><dd class="col-9"><?= nl2br(htmlspecialchars($tiket->deskripsi)) ?></dd>
      </dl>

      <hr>
            <hr>

      <!-- 🔔 PEMBERITAHUAN UNTUK TEKNISI -->
      <?php if ($user['nama_role'] == 'Teknisi'): ?>
          <?php if ($tiket->id_status == 3): ?>
              <div class="alert alert-warning shadow-sm border-0">
                  <i class="bi bi-bell-fill"></i> <strong>Pemberitahuan Penugasan:</strong> Admin baru saja menugaskan tiket ini kepada Anda. Silakan klik tombol <b>Mulai Penanganan</b> di bawah untuk memproses tiket.
              </div>
          <?php elseif ($tiket->id_status == 4): ?>
              <div class="alert alert-info shadow-sm border-0">
                  <i class="bi bi-tools"></i> <strong>Status Diproses:</strong> Tiket ini sedang Anda kerjakan. Jika masalah sudah teratasi, silakan klik tombol <b>Selesaikan</b>.
              </div>
          <?php elseif ($tiket->id_status == 5): ?>
              <div class="alert alert-success shadow-sm border-0">
                  <i class="bi bi-check-circle-fill"></i> <strong>Selesai:</strong> Tiket ini telah berhasil diselesaikan.
              </div>
          <?php endif; ?>
      <?php endif; ?>

      <!-- Aksi Admin -->
      <?php if ($user['nama_role']=='Admin' && $tiket->id_status==1): ?>
        <a href="<?= site_url('tiket/verifikasi/'.$tiket->id_tiket) ?>" class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i> Verifikasi</a>
        <a href="<?= site_url('tiket/tolak/'.$tiket->id_tiket) ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Tolak tiket ini?')"><i class="bi bi-x-lg"></i> Tolak</a>
      <?php endif; ?>

      <?php if ($user['nama_role']=='Admin' && in_array($tiket->id_status,[2,3,4]) ): ?>
        <a href="<?= site_url('penugasan/'.$tiket->id_tiket) ?>" class="btn btn-warning btn-sm">Tugaskan Teknisi</a>
      <?php endif; ?>

      <!-- Aksi Teknisi (Hanya untuk Teknisi) -->
<?php if ($user['nama_role'] == 'Teknisi' && in_array($tiket->id_status,[3,4]) ): ?>
        <?php if ($tiket->id_status == 3): ?>
            <!-- Jika baru ditugaskan -->
            <a href="<?= site_url('penanganan/'.$tiket->id_tiket) ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-play-circle"></i> Mulai Penanganan
            </a>
        <?php else: ?>
            <!-- Jika sudah diproses -->
            <a href="<?= site_url('penanganan/'.$tiket->id_tiket) ?>" class="btn btn-info btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Progress
            </a>
            <a href="<?= site_url('penanganan/selesai/'.$tiket->id_tiket) ?>" class="btn btn-success btn-sm"
               onclick="return confirm('Apakah Anda yakin masalah sudah teratasi dan ingin menyelesaikan tiket ini?')">
               <i class="bi bi-check-lg"></i> Selesaikan
            </a>
        <?php endif; ?>
      <?php endif; ?>

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white fw-bold">Riwayat Penanganan</div>
    <ul class="list-group list-group-flush">
      <?php foreach ($riwayat as $r): ?>
      <li class="list-group-item">
        <div class="d-flex justify-content-between">
          <strong><?= $r->nama_teknisi ?></strong>
          <small class="text-muted"><?= date('d/m/Y H:i', strtotime($r->tanggal_penanganan)) ?></small>
        </div>
        <div><?= nl2br(htmlspecialchars($r->tindakan)) ?></div>
        <?php if ($r->catatan): ?><small class="text-muted">Catatan: <?= htmlspecialchars($r->catatan) ?></small><?php endif; ?>
      </li>
      <?php endforeach; ?>
      <?php if (empty($riwayat)): ?>
        <li class="list-group-item text-muted text-center">Belum ada riwayat</li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<div class="col-md-4">
  <?php if ($penugasan): ?>
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white fw-bold">Penugasan</div>
    <div class="card-body small">
      <div>Teknisi: <strong><?= $penugasan->nama_teknisi ?></strong></div>
      <div>Oleh: <?= $penugasan->pemberi ?></div>
      <div>Tanggal: <?= date('d/m/Y H:i', strtotime($penugasan->tanggal_penugasan)) ?></div>
      <?php if ($penugasan->catatan_penugasan): ?>
        <div class="mt-2 text-muted"><?= nl2br(htmlspecialchars($penugasan->catatan_penugasan)) ?></div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>

   <div class="card border-0 shadow-sm mt-3">
    <div class="card-header bg-white fw-bold"><i class="bi bi-paperclip"></i> Lampiran & Bukti</div>
    <ul class="list-group list-group-flush">
      <?php foreach ($lampiran as $l): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <a href="<?= base_url($l->path_file) ?>" target="_blank" class="fw-bold text-decoration-none">
              <i class="bi bi-file-earmark-image"></i> <?= $l->nama_file ?>
            </a>
            <div class="small text-muted mt-1">
              Diunggah oleh: <b><?= $l->nama_uploader ?></b> 
              <span class="badge bg-secondary"><?= $l->nama_role ?></span><br>
              <?= date('d/m/Y H:i', strtotime($l->tanggal_upload)) ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
      <?php if (empty($lampiran)): ?>
        <li class="list-group-item text-muted small text-center py-3">Belum ada lampiran atau bukti foto.</li>
      <?php endif; ?>
    </ul>
    
    <!-- Form Upload: Sembunyikan jika tiket sudah Selesai atau Ditolak -->
    <?php if ($tiket->id_status != 5 && $tiket->id_status != 6): ?>
    <div class="card-body bg-light">
      <label class="form-label small fw-bold">Upload Lampiran / Bukti Perbaikan</label>
      <?= form_open_multipart('tiket/detail/'.$tiket->id_tiket) ?>
        <input type="file" name="file" class="form-control form-control-sm mb-2" required>
        <button name="upload_lampiran" value="1" class="btn btn-outline-primary btn-sm w-100">
          <i class="bi bi-cloud-arrow-up"></i> Upload File
        </button>
      <?= form_close() ?>
    </div>
    <?php endif; ?>
  </div>