<?php
// ============================================================
// PERSIAPAN DATA TAMPILAN
// ============================================================
$status_class = ['terkirim' => 'primary', 'diterima' => 'info', 'diproses' => 'warning', 'selesai' => 'success'];
$status_label = ['terkirim' => 'Terkirim', 'diterima' => 'Diterima', 'diproses' => 'Diproses', 'selesai' => 'Selesai'];

$total_langkah = count($riwayat);

// Nomor langkah per disposisi + penanda mana yang sudah diteruskan lagi
$no_langkah = [];
$punya_anak = [];
$nama_langkah = [];
foreach ($riwayat as $i => $r) {
    $no_langkah[$r->id]   = $i + 1;
    $nama_langkah[$r->id] = $r->ke_nama ?? '-';
    if (!empty($r->parent_id)) $punya_anak[$r->parent_id] = true;
}

// Posisi saat ini = penerima yang belum meneruskan lagi
$posisi = [];
$semua_selesai = ($total_langkah > 0);
foreach ($riwayat as $r) {
    if (empty($punya_anak[$r->id])) {
        $posisi[] = $r;
        if ($r->status != 'selesai') $semua_selesai = false;
    }
}

// Pihak yang terlibat (pengirim maupun penerima, tanpa duplikat)
$pihak = [];
foreach ($riwayat as $r) {
    if (!empty($r->dari_user_id)) $pihak[$r->dari_user_id] = true;
    if (!empty($r->ke_user_id))   $pihak[$r->ke_user_id]   = true;
}

// Alur ringkas: pengirim pertama lalu tiap penerima berurutan
$alur = [];
if ($total_langkah > 0) {
    $alur[] = $riwayat[0]->dari_nama ?? '-';
    foreach ($riwayat as $r) {
        $nama = $r->ke_nama ?? '-';
        if (end($alur) !== $nama) $alur[] = $nama;
    }
}

// Format durasi (detik -> teks)
$fmt_durasi = function ($detik) {
    $detik = max(0, (int) $detik);
    if ($detik < 60) return 'kurang dari 1 menit';
    $hari = floor($detik / 86400);
    $jam  = floor(($detik % 86400) / 3600);
    $mnt  = floor(($detik % 3600) / 60);
    $out  = [];
    if ($hari) $out[] = $hari . ' hari';
    if ($jam)  $out[] = $jam . ' jam';
    if ($mnt && !$hari) $out[] = $mnt . ' menit';
    return implode(' ', $out);
};

// Durasi total: hanya dihitung jika semua langkah akhir sudah selesai
$durasi_total = null;
if ($semua_selesai) {
    $awal  = strtotime($riwayat[0]->tgl_disposisi);
    $akhir = 0;
    foreach ($posisi as $p) {
        if (!empty($p->tgl_selesai)) $akhir = max($akhir, strtotime($p->tgl_selesai));
    }
    if ($awal && $akhir) $durasi_total = $fmt_durasi($akhir - $awal);
}

// Gabung jabatan & bagian jadi satu baris
$jabatan_bagian = function ($jabatan, $bagian) {
    $bagian_teks = array_filter([$jabatan, $bagian], function ($v) { return !empty($v); });
    return implode(' · ', array_map('html_escape', $bagian_teks));
};
?>

<!-- ============================================================
     HALAMAN RIWAYAT DISPOSISI (BERJENJANG) - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0">Riwayat Disposisi</h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-route me-1"></i> Perjalanan surat dari pengirim awal sampai penerima terakhir
                    </p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <?php if ($total_langkah > 0): ?>
            <a href="<?= base_url('index.php/disposisi/cetak_surat/' . $surat->id); ?>" target="_blank" class="btn btn-primary">
                <i class="fas fa-print me-1"></i> Cetak Lembar Disposisi
            </a>
            <?php endif; ?>
            <a href="<?= base_url('index.php/surat_masuk/detail/' . $surat->id); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Surat
            </a>
        </div>
    </div>
</div>

<!-- ===== INFO SURAT ASAL ===== -->
<div class="card-detail mb-3">
    <div class="card-detail-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-primary"><?= html_escape($surat->no_agenda ?? '-'); ?></h5>
                <span class="text-muted small">No Agenda Surat Masuk</span>
            </div>
        </div>
        <span class="badge bg-light text-dark border">
            <i class="far fa-calendar-alt me-1"></i> Diterima
            <?= isset($surat->tgl_terima) ? date('d-m-Y', strtotime($surat->tgl_terima)) : '-'; ?>
        </span>
    </div>
    <div class="card-detail-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="info-item">
                    <label class="info-label">No Surat Asal</label>
                    <div class="info-value"><?= html_escape($surat->no_surat_asal ?? '-'); ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Tanggal Surat</label>
                    <div class="info-value"><?= !empty($surat->tgl_surat) ? date('d-m-Y', strtotime($surat->tgl_surat)) : '-'; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-item">
                    <label class="info-label">Pengirim</label>
                    <div class="info-value fw-semibold"><?= html_escape($surat->pengirim ?? '-'); ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Sifat Surat</label>
                    <div class="info-value"><?= ucfirst(html_escape(!empty($surat->sifat_surat) ? $surat->sifat_surat : 'biasa')); ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-item">
                    <label class="info-label">Perihal</label>
                    <div class="info-value"><?= html_escape($surat->perihal ?? '-'); ?></div>
                </div>
            </div>
        </div>

        <!-- ===== LAMPIRAN -- IKUT TAMPIL DI SETIAP TINGKAT ===== -->
        <div class="lampiran-section">
            <div class="lampiran-header">
                <i class="fas fa-paperclip me-2"></i>
                <span class="fw-bold">Lampiran Surat Asal</span>
                <span class="badge bg-primary rounded-pill ms-2"><?= count($lampiran); ?> File</span>
            </div>
            <?php if (empty($lampiran)): ?>
                <span class="text-muted small">Tidak ada lampiran pada surat ini.</span>
            <?php else: ?>
            <div class="lampiran-list">
                <?php foreach ($lampiran as $l): ?>
                <a href="<?= base_url('index.php/arsip/lihat/' . $l->id); ?>" target="_blank" class="lampiran-item">
                    <?php
                    $ext = strtolower(pathinfo($l->nama_file, PATHINFO_EXTENSION));
                    $icon = 'fa-file';
                    if (in_array($ext, ['pdf'])) $icon = 'fa-file-pdf';
                    elseif (in_array($ext, ['doc', 'docx'])) $icon = 'fa-file-word';
                    elseif (in_array($ext, ['xls', 'xlsx'])) $icon = 'fa-file-excel';
                    elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) $icon = 'fa-file-image';
                    elseif (in_array($ext, ['zip', 'rar'])) $icon = 'fa-file-archive';
                    ?>
                    <i class="fas <?= $icon; ?>"></i>
                    <span><?= html_escape($l->nama_file); ?></span>
                    <small>(<?= $l->ukuran_kb; ?> KB)</small>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($total_langkah > 0): ?>
<!-- ===== RINGKASAN PERJALANAN ===== -->
<div class="card-detail mb-3">
    <div class="card-detail-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration"><i class="fas fa-flag-checkered"></i></div>
            <div>
                <h5 class="fw-bold mb-0 text-primary">Ringkasan Perjalanan</h5>
                <span class="text-muted small">Gambaran singkat posisi surat saat ini</span>
            </div>
        </div>
        <?php if ($semua_selesai): ?>
            <span class="badge bg-success">Selesai</span>
        <?php else: ?>
            <span class="badge bg-warning text-dark">Dalam proses</span>
        <?php endif; ?>
    </div>
    <div class="card-detail-body">
        <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
                <div class="ringkas-box"><div class="angka"><?= $total_langkah; ?></div><div class="ket">Langkah disposisi</div></div>
            </div>
            <div class="col-6 col-md-3">
                <div class="ringkas-box"><div class="angka"><?= count($pihak); ?></div><div class="ket">Pihak terlibat</div></div>
            </div>
            <div class="col-6 col-md-3">
                <div class="ringkas-box">
                    <div class="angka-teks"><?= date('d-m-Y', strtotime($riwayat[0]->tgl_disposisi)); ?></div>
                    <div class="ket">Disposisi pertama</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="ringkas-box">
                    <div class="angka-teks"><?= $durasi_total ?? 'Belum selesai'; ?></div>
                    <div class="ket">Total durasi</div>
                </div>
            </div>
        </div>

        <div class="info-item">
            <label class="info-label">Alur surat</label>
            <div class="alur">
                <?php foreach ($alur as $i => $nama): ?>
                    <span class="alur-node"><?= html_escape($nama); ?></span>
                    <?php if ($i < count($alur) - 1): ?><i class="fas fa-long-arrow-alt-right alur-panah"></i><?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="info-item">
            <label class="info-label"><?= $semua_selesai ? 'Penerima terakhir' : 'Posisi surat saat ini'; ?></label>
            <div class="info-value">
                <?php foreach ($posisi as $p): ?>
                    <div class="mb-1">
                        <strong><?= html_escape($p->ke_nama ?? '-'); ?></strong>
                        <?php $jb = $jabatan_bagian($p->ke_jabatan ?? '', $p->ke_bagian ?? ''); ?>
                        <?php if ($jb): ?><span class="text-muted small"> — <?= $jb; ?></span><?php endif; ?>
                        <span class="badge bg-<?= $status_class[$p->status] ?? 'secondary'; ?> ms-1"><?= $status_label[$p->status] ?? ucfirst($p->status); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ===== TIMELINE RIWAYAT DISPOSISI BERJENJANG ===== -->
<div class="card-detail">
    <div class="card-detail-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-decoration">
                <i class="fas fa-stream"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-primary">Perjalanan Disposisi</h5>
                <span class="text-muted small"><?= $total_langkah; ?> langkah tercatat</span>
            </div>
        </div>
    </div>
    <div class="card-detail-body">
        <?php if (empty($riwayat)): ?>
            <div class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                Surat ini belum pernah didisposisikan.
            </div>
        <?php else: ?>
        <div class="timeline">
            <?php foreach ($riwayat as $r): ?>
            <?php
                $cls = $status_class[$r->status] ?? 'secondary';
                $dur = null;
                if (!empty($r->tgl_selesai) && !empty($r->tgl_disposisi)) {
                    $dur = $fmt_durasi(strtotime($r->tgl_selesai) - strtotime($r->tgl_disposisi));
                }
                $jb_dari = $jabatan_bagian($r->dari_jabatan ?? '', $r->dari_bagian ?? '');
                $jb_ke   = $jabatan_bagian($r->ke_jabatan ?? '', $r->ke_bagian ?? '');
            ?>
            <div class="timeline-item" style="margin-left: <?= $r->level * 28; ?>px;">
                <div class="timeline-dot bg-<?= $cls; ?>"></div>
                <div class="timeline-content">

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                        <span class="langkah-no">Langkah <?= $no_langkah[$r->id]; ?></span>
                        <span class="d-flex align-items-center gap-2">
                            <span class="badge bg-<?= $cls; ?>"><?= $status_label[$r->status] ?? ucfirst($r->status); ?></span>
                        </span>
                    </div>

                    <!-- PENGIRIM -> PENERIMA -->
                    <div class="pihak-wrap">
                        <div class="pihak">
                            <div class="pihak-label">Pengirim</div>
                            <div class="pihak-nama"><?= html_escape($r->dari_nama ?? '-'); ?></div>
                            <?php if ($jb_dari): ?><div class="pihak-jabatan"><?= $jb_dari; ?></div><?php endif; ?>
                        </div>
                        <i class="fas fa-long-arrow-alt-right pihak-panah"></i>
                        <div class="pihak">
                            <div class="pihak-label">Penerima</div>
                            <div class="pihak-nama"><?= html_escape($r->ke_nama ?? '-'); ?></div>
                            <?php if ($jb_ke): ?><div class="pihak-jabatan"><?= $jb_ke; ?></div><?php endif; ?>
                        </div>
                    </div>

                    <!-- WAKTU -->
                    <div class="meta-baris">
                        <span><i class="far fa-clock me-1"></i>Dikirim: <?= !empty($r->tgl_disposisi) ? date('d-m-Y H:i', strtotime($r->tgl_disposisi)) : '-'; ?></span>
                        <?php if (!empty($r->tgl_selesai)): ?>
                            <span><i class="far fa-check-circle me-1"></i>Selesai: <?= date('d-m-Y H:i', strtotime($r->tgl_selesai)); ?></span>
                        <?php endif; ?>
                        <?php if ($dur): ?>
                            <span><i class="fas fa-hourglass-half me-1"></i>Durasi: <?= $dur; ?></span>
                        <?php endif; ?>
                        <?php if (!empty($r->parent_id) && isset($no_langkah[$r->parent_id])): ?>
                            <span><i class="fas fa-reply me-1"></i>Diteruskan dari langkah <?= $no_langkah[$r->parent_id]; ?> (<?= html_escape($nama_langkah[$r->parent_id]); ?>)</span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($r->instruksi)): ?>
                    <div class="mt-2"><strong>Instruksi:</strong> <?= nl2br(html_escape($r->instruksi)); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($r->catatan)): ?>
                    <div class="mt-1 text-muted"><strong>Catatan:</strong> <?= nl2br(html_escape($r->catatan)); ?></div>
                    <?php endif; ?>

                    <!-- RIWAYAT PERUBAHAN STATUS (dari log aktivitas) -->
                    <?php if (!empty($status_log[$r->id])): ?>
                    <div class="status-log">
                        <div class="status-log-judul"><i class="fas fa-history me-1"></i>Perubahan status</div>
                        <?php foreach ($status_log[$r->id] as $lg): ?>
                        <?php
                            preg_match('/menjadi\s+(\w+)/i', $lg->aktivitas, $m);
                            $st = isset($m[1]) ? strtolower($m[1]) : '';
                        ?>
                        <div class="status-log-baris">
                            <span><?= date('d-m-Y H:i', strtotime($lg->created_at)); ?></span>
                            <span>
                                <?php if ($st): ?>
                                    <span class="badge bg-<?= $status_class[$st] ?? 'secondary'; ?>"><?= $status_label[$st] ?? ucfirst($st); ?></span>
                                <?php else: ?>
                                    <?= html_escape($lg->aktivitas); ?>
                                <?php endif; ?>
                            </span>
                            <span class="text-muted">oleh <?= html_escape($lg->user_nama ?? '-'); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-muted small mt-3">
            <i class="fas fa-info-circle me-1"></i>
            Riwayat perubahan status hanya tampil untuk perubahan yang terjadi setelah log aktivitas aktif.
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ============================================================
     STYLE
     ============================================================ -->
<style>
    .page-header {
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
    }
    .page-header .header-icon {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.3rem;
        box-shadow: 0 4px 16px rgba(30, 64, 175, 0.25);
    }
    .card-detail {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .card-detail-header {
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 10px;
    }
    .card-detail-header .header-decoration {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.1rem;
    }
    .card-detail-body { padding: 24px 28px; }
    .info-item { margin-bottom: 12px; }
    .info-label {
        display: block; font-size: 0.7rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.4px; color: #94a3b8;
        margin-bottom: 2px;
    }
    .info-value { font-size: 0.95rem; color: #1e293b; }

    .lampiran-section { margin-top: 20px; padding-top: 18px; border-top: 1px solid #e2e8f0; }
    .lampiran-header { display: flex; align-items: center; font-size: 0.9rem; color: #1e293b; margin-bottom: 10px; }
    .lampiran-header i { color: #64748b; }
    .lampiran-list { display: flex; flex-wrap: wrap; gap: 8px; }
    .lampiran-item {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 5px 14px 5px 10px; background: #f8fafc; border-radius: 6px;
        border: 1px solid #e2e8f0; text-decoration: none; color: #334155; font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .lampiran-item:hover { border-color: #2563eb; background: #eff6ff; color: #2563eb; }
    .lampiran-item small { font-size: 0.6rem; color: #94a3b8; }

    /* ===== RINGKASAN ===== */
    .ringkas-box {
        border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc;
        padding: 12px 14px; height: 100%;
    }
    .ringkas-box .angka { font-size: 1.6rem; font-weight: 700; color: #1e3a5f; line-height: 1.1; }
    .ringkas-box .angka-teks { font-size: 1rem; font-weight: 700; color: #1e3a5f; line-height: 1.5; }
    .ringkas-box .ket { font-size: 0.75rem; color: #64748b; margin-top: 2px; }

    .alur { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; }
    .alur-node {
        background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af;
        border-radius: 20px; padding: 3px 12px; font-size: 0.82rem; font-weight: 600;
    }
    .alur-panah { color: #94a3b8; }

    /* ===== TIMELINE BERJENJANG ===== */
    .timeline { position: relative; }
    .timeline-item {
        position: relative;
        padding: 12px 0 12px 24px;
        border-left: 2px solid #e2e8f0;
    }
    .timeline-item:last-child { border-left: 2px solid transparent; }
    .timeline-dot {
        position: absolute; left: -7px; top: 16px;
        width: 12px; height: 12px; border-radius: 50%;
        border: 2px solid #fff; box-shadow: 0 0 0 2px #e2e8f0;
    }
    .timeline-content {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
    }
    .langkah-no {
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        background: #1e3a5f; color: #fff; border-radius: 6px; padding: 2px 10px;
    }

    .pihak-wrap { display: flex; align-items: center; flex-wrap: wrap; gap: 14px; }
    .pihak { min-width: 160px; }
    .pihak-label { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; color: #94a3b8; }
    .pihak-nama { font-weight: 700; color: #1e293b; }
    .pihak-jabatan { font-size: 0.78rem; color: #64748b; }
    .pihak-panah { color: #3b82f6; font-size: 1.2rem; }

    .meta-baris {
        display: flex; flex-wrap: wrap; gap: 6px 18px;
        margin-top: 10px; font-size: 0.8rem; color: #64748b;
    }

    .status-log {
        margin-top: 10px; padding-top: 8px; border-top: 1px dashed #cbd5e1;
        font-size: 0.8rem;
    }
    .status-log-judul { font-weight: 600; color: #475569; margin-bottom: 4px; }
    .status-log-baris { display: flex; flex-wrap: wrap; gap: 4px 14px; align-items: center; padding: 2px 0; }

    @media (max-width: 768px) {
        .card-detail-body { padding: 16px; }
        .timeline-item { margin-left: 0 !important; }
        .pihak-panah { transform: rotate(90deg); }
    }
</style>