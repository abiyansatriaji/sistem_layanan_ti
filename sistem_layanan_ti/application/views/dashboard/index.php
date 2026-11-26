<!-- Custom CSS -->
<style>
    .card-stats { border: none; border-radius: 15px; color: white; transition: transform 0.2s; }
    .card-stats:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
    .bg-gradient-primary { background: linear-gradient(135deg, #1f3c88, #2d56b8); }
    .bg-gradient-success { background: linear-gradient(135deg, #11998e, #38ef7d); }
    .bg-gradient-warning { background: linear-gradient(135deg, #f12711, #f5af19); }
    .bg-gradient-danger  { background: linear-gradient(135deg, #cb2d3e, #ef473a); }
    .bg-gradient-info    { background: linear-gradient(135deg, #2193b0, #6dd5ed); }
    .card-stats .icon { font-size: 2.5rem; opacity: 0.5; position: absolute; right: 15px; bottom: 10px; }
    .welcome-banner { background: url('https://www.transparenttextures.com/patterns/cubes.png') #1f3c88; color: white; border-radius: 15px; }
</style>

<!-- Banner Sambutan (Untuk Semua Role) -->
<div class="card welcome-banner shadow-sm mb-4 border-0">
    <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div class="mb-3 mb-md-0">
            <h4 class="fw-bold mb-1">Selamat Datang, <?= $user['nama'] ?>! 👋</h4>
            <p class="mb-0 text-white-50">Anda login sebagai <strong><?= $user['nama_role'] ?></strong> di Unit <?= $user['nama_unit'] ?>.</p>
        </div>
        
        <!-- TOMBOL KHUSUS PELAPOR -->
        <?php if ($user['nama_role'] == 'Pelapor'): ?>
            <a href="<?= site_url('tiket/create') ?>" class="btn btn-light btn-lg fw-bold text-primary shadow">
                <i class="bi bi-plus-circle-fill"></i> Buat Laporan Baru
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($user['nama_role'] == 'Pelapor'): ?>
    <!-- ========================================== -->
    <!-- TAMPILAN KHUSUS PELAPOR (SIMPEL)           -->
    <!-- ========================================== -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card card-stats bg-gradient-primary h-100 shadow-sm">
                <div class="card-body position-relative">
                    <h6 class="text-uppercase mb-2 opacity-75">Total Laporan Saya</h6>
                    <h2 class="mb-0 fw-bold"><?= count($tikets) ?></h2>
                    <i class="bi bi-ticket-perforated icon"></i>
                </div>
            </div>
        </div>
        <?php 
            // Hitung tiket pelapor yang sedang diproses dan selesai
            $proses = 0; $selesai = 0;
            foreach($tikets as $t) {
                if(in_array($t->nama_status, ['Ditugaskan', 'Diproses'])) $proses++;
                if($t->nama_status == 'Selesai') $selesai++;
            }
        ?>
        <div class="col-md-4 mb-3">
            <div class="card card-stats bg-gradient-warning h-100 shadow-sm">
                <div class="card-body position-relative">
                    <h6 class="text-uppercase mb-2 opacity-75">Sedang Diproses</h6>
                    <h2 class="mb-0 fw-bold"><?= $proses ?></h2>
                    <i class="bi bi-gear-wide-connected icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-stats bg-gradient-success h-100 shadow-sm">
                <div class="card-body position-relative">
                    <h6 class="text-uppercase mb-2 opacity-75">Selesai</h6>
                    <h2 class="mb-0 fw-bold"><?= $selesai ?></h2>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- ========================================== -->
    <!-- TAMPILAN UNTUK ADMIN, TEKNISI, KEPALA TI   -->
    <!-- ========================================== -->
    <div class="row mb-4">
        <?php 
        $main_status = [
            'Menunggu' => ['color' => 'warning', 'icon' => 'hourglass-split'],
            'Diproses' => ['color' => 'primary', 'icon' => 'gear-wide-connected'],
            'Selesai'  => ['color' => 'success', 'icon' => 'check-circle'],
            'Ditolak'  => ['color' => 'danger', 'icon' => 'x-circle']
        ];

        foreach ($main_status as $status_name => $style):
            $total = 0;
            foreach ($status_data as $s) {
                if ($s->nama_status == $status_name) {
                    $total = $s->total;
                    break;
                }
            }
        ?>
        <div class="col-md-3 mb-3">
            <div class="card card-stats bg-gradient-<?= $style['color'] ?> h-100 shadow-sm">
                <div class="card-body position-relative">
                    <h6 class="text-uppercase mb-2 opacity-75"><?= $status_name ?></h6>
                    <h2 class="mb-0 fw-bold"><?= $total ?></h2>
                    <i class="bi bi-<?= $style['icon'] ?> icon"></i>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Area Grafik (Hanya untuk Admin/Teknisi/Kepala TI) -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold border-0 pt-3">
                    <i class="bi bi-pie-chart-fill text-primary"></i> Distribusi Status
                </div>
                <div class="card-body d-flex justify-content-center">
                    <canvas id="chartStatus" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold border-0 pt-3">
                    <i class="bi bi-bar-chart-fill text-success"></i> Tiket Berdasarkan Kategori
                </div>
                <div class="card-body">
                    <canvas id="chartKategori" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- ========================================== -->
<!-- TABEL TIKET TERBARU (Tampil untuk semua)   -->
<!-- ========================================== -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold border-0 pt-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history text-secondary"></i> <?= $user['nama_role'] == 'Pelapor' ? 'Laporan Terbaru Saya' : '5 Tiket Terbaru' ?></span>
        <a href="<?= site_url('tiket') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Tiket</th>
                        <th>Judul</th>
                        <?php if ($user['nama_role'] != 'Pelapor'): ?>
                            <th>Pelapor</th>
                        <?php endif; ?>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach (array_slice($tikets, 0, 5) as $t): ?>
                    <tr>
                        <td><code class="text-primary"><?= $t->kode_tiket ?></code></td>
                        <td class="fw-medium"><?= $t->judul ?></td>
                        <?php if ($user['nama_role'] != 'Pelapor'): ?>
                            <td><?= $t->nama_pelapor ?></td>
                        <?php endif; ?>
                        <td>
                            <?php 
                                $badge = 'secondary';
                                if($t->nama_status == 'Menunggu') $badge = 'warning text-dark';
                                if($t->nama_status == 'Diverifikasi') $badge = 'info text-dark';
                                if($t->nama_status == 'Ditugaskan') $badge = 'primary';
                                if($t->nama_status == 'Diproses') $badge = 'primary';
                                if($t->nama_status == 'Selesai') $badge = 'success';
                                if($t->nama_status == 'Ditolak') $badge = 'danger';
                            ?>
                            <span class="badge bg-<?= $badge ?>"><?= $t->nama_status ?></span>
                        </td>
                        <td>
                            <a href="<?= site_url('tiket/detail/'.$t->id_tiket) ?>" class="btn btn-sm btn-outline-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($tikets)): ?>
                    <tr><td colspan="<?= $user['nama_role'] == 'Pelapor' ? '4' : '5' ?>" class="text-center text-muted py-4">Belum ada tiket masuk.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script Chart.js (Hanya dimuat jika bukan Pelapor) -->
<?php if ($user['nama_role'] != 'Pelapor'): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const statusLabels = <?= json_encode($chart_status_labels) ?>;
    const statusData = <?= json_encode($chart_status_data) ?>;
    const colorMap = {
        'Menunggu': '#ffc107', 'Diverifikasi': '#0dcaf0', 'Ditugaskan': '#6f42c1', 
        'Diproses': '#0d6efd', 'Selesai': '#198754', 'Ditolak': '#dc3545'
    };
    const bgColors = statusLabels.map(label => colorMap[label] || '#6c757d');

    const ctxStatus = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{ data: statusData, backgroundColor: bgColors, borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
    });

    const ctxKategori = document.getElementById('chartKategori').getContext('2d');
    new Chart(ctxKategori, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chart_kategori_labels) ?>,
            datasets: [{
                label: 'Jumlah Tiket',
                data: <?= json_encode($chart_kategori_data) ?>,
                backgroundColor: 'rgba(45, 86, 184, 0.7)',
                borderColor: 'rgba(45, 86, 184, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            plugins: { legend: { display: false } }
        }
    });
</script>
<?php endif; ?>