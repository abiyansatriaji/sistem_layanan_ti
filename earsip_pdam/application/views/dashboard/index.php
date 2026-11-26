<!-- ============================================================
     STATISTIK
     ============================================================ -->
<div class="row g-3 g-md-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon"><i class="fas fa-inbox"></i></div>
            <div class="number"><?= number_format($total_surat_masuk ?? 0); ?></div>
            <div class="label">Surat Masuk</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon"><i class="fas fa-envelope"></i></div>
            <div class="number"><?= number_format($total_surat_keluar ?? 0); ?></div>
            <div class="label">Surat Keluar</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon"><i class="fas fa-share-alt"></i></div>
            <div class="number"><?= number_format($total_disposisi ?? 0); ?></div>
            <div class="label">Disposisi</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon"><i class="fas fa-users"></i></div>
            <div class="number"><?= number_format($total_users ?? 0); ?></div>
            <div class="label">Pengguna Aktif</div>
        </div>
    </div>
</div>

<!-- ============================================================
     GRAFIK SURAT MASUK & KELUAR
     ============================================================ -->
<div class="card-custom">
    <div class="card-title">
        <i class="fas fa-chart-bar"></i> Grafik Surat Masuk & Keluar
        <span class="text-muted small fw-normal ms-2">12 Bulan Terakhir</span>
    </div>
    <div class="chart-container">
        <?php if (!$has_data): ?>
            <div class="chart-empty">
                <i class="fas fa-chart-line"></i>
                <p>Belum ada data surat masuk dan keluar</p>
                <span class="text-muted small">Data akan muncul setelah ada surat yang tercatat</span>
            </div>
        <?php endif; ?>
        <canvas id="suratChart" <?= !$has_data ? 'style="display:none;"' : ''; ?>></canvas>
    </div>
</div>

<!-- ============================================================
     SURAT MASUK TERBARU
     ============================================================ -->
<div class="card-custom">
    <div class="card-title"><i class="fas fa-clock"></i> Surat Masuk Terbaru</div>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>No Agenda</th>
                    <th>Perihal</th>
                    <th>Pengirim</th>
                    <th>Tgl Terima</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($surat_masuk_terbaru)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada surat masuk</td></tr>
                <?php else: ?>
                    <?php foreach ($surat_masuk_terbaru as $s): ?>
                        <tr>
                            <td><strong><?= $s['no_agenda'] ?? '-'; ?></strong></td>
                            <td><?= substr($s['perihal'] ?? '', 0, 45); ?>...</td>
                            <td><?= $s['pengirim'] ?? '-'; ?></td>
                            <td><?= date('d-m-Y', strtotime($s['tgl_terima'])); ?></td>
                            <td><span class="badge-status <?= $s['status'] ?? 'baru'; ?>"><?= ucfirst($s['status'] ?? 'baru'); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer-action">
        <a href="<?= base_url('index.php/surat_masuk'); ?>" class="btn-outline-primary-custom">
            <i class="fas fa-arrow-right"></i> Lihat Semua Surat Masuk
        </a>
    </div>
</div>

<!-- ============================================================
     DISPOSISI MENUNGGU TINDAK LANJUT
     ============================================================ -->
<div class="card-custom">
    <div class="card-title"><i class="fas fa-share-alt"></i> Disposisi Menunggu Tindak Lanjut</div>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>No Agenda</th>
                    <th>Perihal</th>
                    <th>Dari</th>
                    <th>Instruksi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($disposisi_masuk)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada disposisi masuk</td></tr>
                <?php else: ?>
                    <?php foreach ($disposisi_masuk as $d): ?>
                        <tr>
                            <td><?= $d['no_agenda'] ?? '-'; ?></td>
                            <td><?= $d['perihal'] ?? '-'; ?></td>
                            <td><?= $d['dari_nama'] ?? '-'; ?></td>
                            <td><?= $d['instruksi'] ?? '-'; ?></td>
                            <td><span class="badge-status <?= $d['status']; ?>"><?= ucfirst($d['status']); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer-action">
        <a href="<?= base_url('index.php/surat_masuk/disposisi_list'); ?>" class="btn-outline-primary-custom">
            <i class="fas fa-arrow-right"></i> Lihat Semua Disposisi
        </a>
    </div>
</div>

<!-- ============================================================
     STYLE KHUSUS INDEX
     ============================================================ -->
<style>
    .stat-card {
        background: #fff;
        border-radius: var(--radius);
        padding: 22px 16px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--slate-200);
        transition: var(--transition);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--accent);
    }

    .stat-card .icon {
        font-size: 2rem;
        color: var(--accent);
        margin-bottom: 6px;
        display: inline-block;
        background: var(--slate-50);
        width: 56px;
        height: 56px;
        line-height: 56px;
        border-radius: 50%;
        transition: var(--transition);
    }

    .stat-card:hover .icon {
        background: var(--accent);
        color: #fff;
        transform: scale(1.05);
    }

    .stat-card .number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .stat-card .label {
        color: var(--slate-500);
        font-weight: 500;
        font-size: 0.85rem;
        margin-top: 2px;
    }

    .card-custom {
        background: #fff;
        border-radius: var(--radius);
        padding: 22px 22px 18px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--slate-200);
        transition: var(--transition);
        margin-bottom: 20px;
    }

    .card-custom:hover {
        box-shadow: var(--shadow-md);
        border-color: var(--slate-300);
    }

    .card-custom .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-custom .card-title i {
        color: var(--accent);
        font-size: 1.1rem;
    }

    /* ===== GRAFIK ===== */
    .chart-container {
        position: relative;
        height: 280px;
        width: 100%;
    }

    .chart-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #94a3b8;
        padding: 30px 0;
    }

    .chart-empty i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    .chart-empty p {
        font-size: 1rem;
        font-weight: 500;
        color: #64748b;
        margin-bottom: 4px;
    }

    @media (max-width: 768px) {
        .chart-container {
            height: 220px;
        }
    }

    @media (max-width: 576px) {
        .chart-container {
            height: 180px;
        }
        .chart-empty i {
            font-size: 2rem;
        }
        .chart-empty p {
            font-size: 0.85rem;
        }
    }

    /* ===== TABEL ===== */
    .table-custom {
        font-size: 0.88rem;
        margin-bottom: 0;
    }

    .table-custom thead th {
        background: var(--slate-50);
        color: var(--slate-600);
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-bottom: 2px solid var(--slate-200);
        padding: 10px 12px;
    }

    .table-custom tbody td {
        padding: 9px 12px;
        vertical-align: middle;
        border-bottom: 1px solid var(--slate-100);
        color: var(--slate-700);
    }

    .table-custom tbody tr:hover {
        background: var(--slate-50);
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-status {
        display: inline-block;
        padding: 2px 14px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.2px;
    }

    .badge-status.baru { background: #fef3c7; color: #d97706; }
    .badge-status.didisposisikan { background: #dbeafe; color: #2563eb; }
    .badge-status.diproses { background: #e0e7ff; color: #4338ca; }
    .badge-status.selesai { background: #d1fae5; color: #065f46; }
    .badge-status.arsip { background: #f1f5f9; color: #64748b; }
    .badge-status.terkirim { background: #fef3c7; color: #d97706; }
    .badge-status.diterima { background: #dbeafe; color: #2563eb; }
    .badge-status.menunggu { background: #fef3c7; color: #92400e; }
    .badge-status.proses { background: #fce4ec; color: #b91c1c; }
    .badge-status.ditolak { background: #fee2e2; color: #991b1b; }

    .btn-outline-primary-custom {
        color: var(--accent);
        border: 1.5px solid var(--slate-200);
        background: transparent;
        padding: 5px 18px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.8rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-outline-primary-custom:hover {
        background: var(--slate-50);
        border-color: var(--accent);
        color: var(--primary);
        text-decoration: none;
    }

    .card-footer-action {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid var(--slate-100);
        text-align: right;
    }

    @media (max-width: 768px) {
        .stat-card { padding: 16px 12px; }
        .stat-card .number { font-size: 1.5rem; }
        .stat-card .icon { width: 44px; height: 44px; line-height: 44px; font-size: 1.4rem; }
        .card-custom { padding: 16px 14px; }
        .table-custom { font-size: 0.78rem; }
        .table-custom thead th, .table-custom tbody td { padding: 6px 8px; }
        .badge-status { font-size: 0.6rem; padding: 1px 10px; }
        .btn-outline-primary-custom { font-size: 0.7rem; padding: 4px 14px; }
    }

    @media (max-width: 576px) {
        .stat-card .number { font-size: 1.2rem; }
        .stat-card .icon { width: 36px; height: 36px; line-height: 36px; font-size: 1.1rem; }
    }
</style>

<!-- ============================================================
     SCRIPT CHART.JS
     ============================================================ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($has_data): ?>
    const ctx = document.getElementById('suratChart').getContext('2d');

    const labels = <?= $chart_bulan; ?>;
    const dataMasuk = <?= $chart_masuk; ?>;
    const dataKeluar = <?= $chart_keluar; ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: dataMasuk,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: '#2563eb',
                    borderWidth: 2,
                    borderRadius: 4,
                    barPercentage: 0.4,
                },
                {
                    label: 'Surat Keluar',
                    data: dataKeluar,
                    backgroundColor: 'rgba(245, 158, 11, 0.7)',
                    borderColor: '#d97706',
                    borderWidth: 2,
                    borderRadius: 4,
                    barPercentage: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 14, weight: '700' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' surat';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 },
                        color: '#64748b'
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 10, weight: '500' },
                        color: '#64748b',
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
    <?php endif; ?>
})
</script>