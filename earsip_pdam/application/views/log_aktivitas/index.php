<?php
// Warna badge per modul
$modul_class = [
    'auth'         => 'secondary',
    'surat_masuk'  => 'primary',
    'surat_keluar' => 'success',
    'disposisi'    => 'warning',
    'user'         => 'info',
    'log'          => 'danger',
    'laporan'      => 'dark'
];
$modul_label = [
    'auth'         => 'Auth',
    'surat_masuk'  => 'Surat Masuk',
    'surat_keluar' => 'Surat Keluar',
    'disposisi'    => 'Disposisi',
    'user'         => 'Kelola User',
    'log'          => 'Log',
    'laporan'      => 'Laporan'
];

// Helper kecil untuk link pagination (filter ikut terbawa)
$page_url = function ($p) use ($qs) {
    return base_url('index.php/log_aktivitas') . '?' . ($qs ? $qs . '&' : '') . 'page=' . $p;
};
?>

<div class="page-header mb-4">
    <h4 class="fw-bold text-primary mb-0"><i class="fas fa-history me-2"></i><?= $title; ?></h4>
    <p class="text-muted small mb-0">Audit trail aktivitas penting: login, surat, disposisi, dan kelola user</p>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ===== RINGKASAN ===== -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="log-stat">
            <div class="num"><?= $total_hari; ?></div>
            <div class="lbl">Aktivitas hari ini</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="log-stat">
            <div class="num"><?= $total_semua; ?></div>
            <div class="lbl">Total seluruh log</div>
        </div>
    </div>
</div>

<!-- ===== FILTER ===== -->
<div class="log-card mb-4">
    <form method="get" action="<?= base_url('index.php/log_aktivitas'); ?>" class="row g-3" autocomplete="off">
        <div class="col-md-3">
            <label class="fw-semibold small">Pengguna</label>
            <select name="user_id" class="form-select">
                <option value="">-- Semua --</option>
                <?php foreach ($users as $u): ?>
                <option value="<?= $u->id; ?>" <?= ($filter['user_id'] == $u->id) ? 'selected' : ''; ?>><?= html_escape($u->nama); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="fw-semibold small">Modul</label>
            <select name="modul" class="form-select">
                <option value="">-- Semua --</option>
                <?php foreach ($modul_label as $k => $v): ?>
                <option value="<?= $k; ?>" <?= ($filter['modul'] == $k) ? 'selected' : ''; ?>><?= $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="fw-semibold small">Tanggal Awal</label>
            <input type="date" name="tgl_awal" class="form-control" value="<?= html_escape($filter['tgl_awal']); ?>">
        </div>
        <div class="col-md-2">
            <label class="fw-semibold small">Tanggal Akhir</label>
            <input type="date" name="tgl_akhir" class="form-control" value="<?= html_escape($filter['tgl_akhir']); ?>">
        </div>
        <div class="col-md-3">
            <label class="fw-semibold small">Kata Kunci</label>
            <input type="text" name="keyword" class="form-control" placeholder="Isi aktivitas..." value="<?= html_escape($filter['keyword']); ?>" autocomplete="off">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
            <a href="<?= base_url('index.php/log_aktivitas'); ?>" class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</a>
        </div>
    </form>
</div>

<!-- ===== TABEL LOG ===== -->
<div class="log-card mb-4">
    <h6 class="fw-bold mb-3"><i class="fas fa-list me-2"></i>Riwayat Aktivitas
        <span class="badge bg-primary rounded-pill ms-2"><?= $total_filter; ?></span>
        <?php if ($total_filter > 0): ?>
        <small class="text-muted fw-normal ms-2">
            menampilkan <?= $offset + 1; ?>–<?= $offset + count($log); ?> dari <?= $total_filter; ?>
        </small>
        <?php endif; ?>
    </h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:50px;">No</th>
                    <th style="width:160px;">Waktu</th>
                    <th>Pengguna</th>
                    <th style="width:120px;">Modul</th>
                    <th>Aktivitas</th>
                    <th style="width:80px;">Ref. ID</th>
                    <th style="width:130px;">IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($log)): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada log aktivitas</td></tr>
                <?php else: ?>
                <?php $no = $offset + 1; foreach ($log as $l): ?>
                <?php $cls = $modul_class[$l->modul] ?? 'dark'; ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="small"><?= date('d-m-Y H:i:s', strtotime($l->created_at)); ?></td>
                    <td>
                        <?php if ($l->user_nama): ?>
                            <strong><?= html_escape($l->user_nama); ?></strong>
                            <div class="text-muted small">@<?= html_escape($l->user_username); ?></div>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge bg-<?= $cls; ?>"><?= $modul_label[$l->modul] ?? ($l->modul ?: '-'); ?></span></td>
                    <td><?= html_escape($l->aktivitas); ?></td>
                    <td><?= $l->referensi_id ?: '-'; ?></td>
                    <td class="small text-muted"><?= html_escape($l->ip_address); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- ===== PAGINATION ===== -->
    <?php if ($total_pages > 1): ?>
    <nav class="mt-3" aria-label="Halaman log">
        <ul class="pagination pagination-sm justify-content-center mb-0 flex-wrap">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?= $page_url($page - 1); ?>">&laquo; Sebelumnya</a>
            </li>

            <?php
            $start = max(1, $page - 2);
            $end   = min($total_pages, $page + 2);
            if ($start > 1): ?>
                <li class="page-item"><a class="page-link" href="<?= $page_url(1); ?>">1</a></li>
                <?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="<?= $page_url($i); ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($end < $total_pages): ?>
                <?php if ($end < $total_pages - 1): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
                <li class="page-item"><a class="page-link" href="<?= $page_url($total_pages); ?>"><?= $total_pages; ?></a></li>
            <?php endif; ?>

            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?= $page_url($page + 1); ?>">Berikutnya &raquo;</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<!-- ===== PEMBERSIHAN LOG LAMA ===== -->
<div class="log-card log-danger">
    <h6 class="fw-bold mb-1"><i class="fas fa-broom me-2"></i>Bersihkan Log Lama</h6>
    <p class="text-muted small mb-3">
        Menghapus <strong>permanen</strong> log yang lebih tua dari periode yang dipilih.
        Log yang lebih baru dari 6 bulan tidak bisa dihapus lewat fitur ini.
        Pembersihan ini sendiri akan tercatat di log.
    </p>
    <form method="post" action="<?= base_url('index.php/log_aktivitas/bersihkan'); ?>"
          class="row g-2 align-items-end"
          onsubmit="return confirmBersihkan(this);">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="col-md-5">
            <label class="fw-semibold small">Hapus log yang lebih lama dari</label>
            <select name="bulan" class="form-select" id="bulanBersih">
                <?php foreach ($retensi as $bulan => $jumlah): ?>
                <option value="<?= $bulan; ?>" data-jumlah="<?= $jumlah; ?>" <?= ($jumlah == 0) ? 'disabled' : ''; ?>>
                    <?= $bulan; ?> bulan — <?= $jumlah; ?> log akan dihapus
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-trash-alt me-1"></i> Bersihkan
            </button>
        </div>
    </form>
    <?php if (array_sum($retensi) == 0): ?>
        <div class="text-muted small mt-2"><i class="fas fa-info-circle me-1"></i>Belum ada log yang cukup lama untuk dibersihkan.</div>
    <?php endif; ?>
</div>

<script>
function confirmBersihkan(form) {
    var sel = form.querySelector('#bulanBersih');
    var opt = sel.options[sel.selectedIndex];
    if (!opt || opt.disabled) {
        alert('Belum ada log yang cukup lama untuk dibersihkan.');
        return false;
    }
    return confirm('Hapus PERMANEN ' + opt.getAttribute('data-jumlah') + ' log yang lebih lama dari ' + opt.value + ' bulan?\n\nTindakan ini tidak dapat dibatalkan.');
}
</script>

<style>
    .log-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .log-card.log-danger { border-color: #fecaca; background: #fffafa; }
    .log-stat {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
    }
    .log-stat .num { font-size: 1.8rem; font-weight: 700; color: #1e3a5f; line-height: 1; }
    .log-stat .lbl { font-size: 0.8rem; color: #64748b; margin-top: 4px; }
    @media (max-width: 768px) {
        .log-card { padding: 14px; }
    }
</style>