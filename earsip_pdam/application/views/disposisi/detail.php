<!-- ============================================================
     RIWAYAT DISPOSISI LENGKAP - E-Arsip PDAM
     ============================================================ -->
<div class="mt-4">
    <div class="card-custom" style="margin-bottom:0;">
        <!-- Header -->
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="header-decoration" style="width:36px; height:36px; background: linear-gradient(135deg, #1e40af, #3b82f6); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.1rem;">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-primary">Riwayat Disposisi</h5>
                <p class="text-muted small mb-0">Riwayat lengkap disposisi surat ini (siapa, kapan, catatan)</p>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <?php if(!empty($disposisi)): ?>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th width="40">No</th>
                        <th style="min-width:120px;">Dari</th>
                        <th style="min-width:120px;">Untuk</th>
                        <th>Instruksi</th>
                        <th>Catatan</th>
                        <th width="120">Status</th>
                        <th width="150">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($disposisi as $d): ?>
                    <tr>
                        <td class="text-center fw-bold" style="color:#64748b;"><?= $no++; ?></td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold" style="color:var(--slate-800);"><?= $d->dari_nama; ?></span>
                                <span class="text-muted" style="font-size:0.7rem;"><?= $d->dari_username; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold" style="color:var(--slate-800);"><?= $d->ke_nama; ?></span>
                                <span class="text-muted" style="font-size:0.7rem;"><?= $d->ke_username; ?></span>
                            </div>
                        </td>
                        <td><?= $d->instruksi; ?></td>
                        <td><?= $d->catatan ?: '<span class="text-muted">-</span>'; ?></td>
                        <td>
                            <?php
                            // Tentukan class status
                            $status_class = '';
                            $status_icon = '';
                            if($d->status == 'selesai') {
                                $status_class = 'selesai';
                                $status_icon = 'fa-check-double';
                            } elseif($d->status == 'terkirim') {
                                $status_class = 'terkirim';
                                $status_icon = 'fa-paper-plane';
                            } else {
                                $status_class = 'proses';
                                $status_icon = 'fa-spinner fa-spin';
                            }
                            ?>
                            <span class="badge-status <?= $status_class; ?>">
                                <i class="fas <?= $status_icon; ?> me-1"></i><?= ucfirst($d->status); ?>
                            </span>
                            <?php if($d->parent_id): ?>
                            <span class="badge-status" style="background:var(--slate-100); color:var(--slate-500); font-size:0.6rem; margin-left:4px;">
                                <i class="fas fa-share"></i> diteruskan
                            </span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:0.85rem; color:var(--slate-600);"><?= date('d-m-Y H:i', strtotime($d->tgl_disposisi)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center text-muted py-3">
            <i class="fas fa-inbox fa-2x d-block mb-2" style="color:#cbd5e1;"></i>
            <p>Belum ada disposisi untuk surat ini</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ============================================================
     TOMBOL AKSI
     ============================================================ -->
<div class="mt-3 d-flex flex-wrap gap-2">
    <?php if($surat->status != 'selesai' && $surat->status != 'arsip'): ?>
    <a href="<?= base_url('index.php/surat_masuk/disposisi/' . $surat->id); ?>" class="btn btn-primary btn-submit">
        <i class="fas fa-share-alt me-1"></i> Disposisikan
    </a>
    <?php endif; ?>
    <a href="<?= base_url('index.php/surat_masuk'); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
    <a href="<?= base_url('index.php/surat_masuk/edit/' . $surat->id); ?>" class="btn btn-warning">
        <i class="fas fa-edit me-1"></i> Edit
    </a>
</div>

<!-- ============================================================
     STYLE TAMBAHAN (jika belum ada di halaman ini)
     ============================================================ -->
<style>
    /* Pastikan badge status disposisi memiliki warna yang sesuai */
    .badge-status.proses { background: #dbeafe; color: #1e40af; }
    .badge-status.terkirim { background: #fef3c7; color: #d97706; }
    .badge-status.selesai { background: #d1fae5; color: #065f46; }
</style>