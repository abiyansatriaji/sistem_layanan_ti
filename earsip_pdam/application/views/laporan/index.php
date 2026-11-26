<!-- ============================================================
     HALAMAN LAPORAN - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0"><?= $title; ?></h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-chart-bar me-1"></i> Rekapitulasi surat berdasarkan periode, bagian, dan status
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     FILTER LAPORAN (DINAMIS)
     ============================================================ -->
<div class="card-custom mb-4">
    <div class="card-header-custom">
        <span><i class="fas fa-filter me-2"></i> Filter Data Laporan</span>
    </div>
    <div class="card-body-custom p-3">
        <form method="get" action="<?= base_url('index.php/laporan'); ?>" class="row g-3" autocomplete="off">
            
            <!-- Tipe Surat -->
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">Tipe Surat</label>
                <select name="tipe" class="form-select" style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
                    <option value="masuk" <?= ($tipe == 'masuk') ? 'selected' : ''; ?>>Surat Masuk</option>
                    <option value="keluar" <?= ($tipe == 'keluar') ? 'selected' : ''; ?>>Surat Keluar</option>
                </select>
            </div>

            <!-- Bulan -->
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">Bulan</label>
                <select name="bulan" class="form-select" style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
                    <?php foreach($months as $k => $v): ?>
                    <option value="<?= $k; ?>" <?= ($k == $bulan) ? 'selected' : ''; ?>><?= $v; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tahun -->
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">Tahun</label>
                <select name="tahun" class="form-select" style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
                    <?php for($i=date('Y')-3; $i<=date('Y'); $i++): ?>
                    <option value="<?= $i; ?>" <?= ($i == $tahun) ? 'selected' : ''; ?>><?= $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Bagian -->
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">Bagian</label>
                <select name="bagian_id" class="form-select" style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
                    <option value="">-- Semua Bagian --</option>
                    <?php foreach($list_bagian as $b): ?>
                    <option value="<?= $b->id; ?>" <?= ($b->id == $bagian_id) ? 'selected' : ''; ?>><?= $b->nama_bagian; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Status (Opsional menyesuaikan Tipe) -->
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">Status</label>
                <select name="status" class="form-select" style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
                    <option value="">-- Semua Status --</option>
                    <?php if($tipe == 'masuk'): ?>
                        <option value="baru" <?= ($status == 'baru') ? 'selected' : ''; ?>>Baru</option>
                        <option value="didisposisikan" <?= ($status == 'didisposisikan') ? 'selected' : ''; ?>>Didisposisikan</option>
                        <option value="diproses" <?= ($status == 'diproses') ? 'selected' : ''; ?>>Diproses</option>
                        <option value="selesai" <?= ($status == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                        <option value="arsip" <?= ($status == 'arsip') ? 'selected' : ''; ?>>Arsip</option>
                    <?php else: ?>
                        <option value="draft" <?= ($status == 'draft') ? 'selected' : ''; ?>>Draft</option>
                        <option value="dikirim" <?= ($status == 'dikirim') ? 'selected' : ''; ?>>Dikirim</option>
                        <option value="arsip" <?= ($status == 'arsip') ? 'selected' : ''; ?>>Arsip</option>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Tombol Aksi -->
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; font-weight:600;">
                    <i class="fas fa-search me-1"></i> Terapkan
                </button>
            </div>
            
            <div class="col-md-12 d-flex align-items-end gap-2 mt-4">
                <a href="<?= base_url('index.php/laporan/export_excel?tipe='.$tipe.'&bulan='.$bulan.'&tahun='.$tahun.'&bagian_id='.$bagian_id.'&status='.$status); ?>" 
                   class="btn btn-success" 
                   style="border-radius:10px; font-weight:600; background:linear-gradient(135deg,#059669,#10b981); border:none;">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
                <a href="<?= base_url('index.php/laporan/cetak?tipe='.$tipe.'&bulan='.$bulan.'&tahun='.$tahun.'&bagian_id='.$bagian_id.'&status='.$status); ?>" 
                   target="_blank" 
                   class="btn btn-danger" 
                   style="border-radius:10px; font-weight:600; background:linear-gradient(135deg,#dc2626,#ef4444); border:none;">
                    <i class="fas fa-file-pdf me-1"></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ===== NOTIFIKASI ===== -->
<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ============================================================
     RINGKASAN FILTER AKTIF
     ============================================================ -->
<div class="info-periode mb-4">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="info-periode-icon">
            <i class="fas fa-filter"></i>
        </div>
        <div>
            <h6 class="fw-bold mb-0">Filter Aktif</h6>
            <p class="small text-muted mb-0">
                Tipe: <strong><?= ucfirst($tipe); ?></strong> &nbsp;|&nbsp; 
                Periode: <strong><?= $nama_bulan . ' ' . $tahun; ?></strong> &nbsp;|&nbsp; 
                Bagian: <strong><?= !empty($bagian_id) ? 'Terpilih' : 'Semua'; ?></strong> &nbsp;|&nbsp; 
                Status: <strong><?= !empty($status) ? ucfirst($status) : 'Semua'; ?></strong>
            </p>
        </div>
        <div class="ms-auto">
            <span class="badge bg-primary rounded-pill" style="font-size: 0.9rem; padding: 8px 16px;">
                <i class="fas fa-list me-1"></i> <?= $total_hasil; ?> Data Ditemukan
            </span>
        </div>
    </div>
</div>

<!-- ============================================================
     TABEL HASIL FILTER (DINAMIS)
     ============================================================ -->
<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div class="d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-2"></i> Daftar <?= ucfirst($tipe); ?></span>
        </div>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <?php if($tipe == 'masuk'): ?>
                        <tr>
                            <th width="50">No</th>
                            <th style="min-width:120px;">No Agenda</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th style="min-width:110px;">Tgl Terima</th>
                            <th width="120">Status</th>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <th width="50">No</th>
                            <th style="min-width:120px;">No Surat</th>
                            <th>Tujuan</th>
                            <th>Perihal</th>
                            <th style="min-width:100px;">Tgl Surat</th>
                            <th width="120">Status</th>
                        </tr>
                    <?php endif; ?>
                </thead>
                <tbody>
                    <?php if(empty($hasil_filter)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-search fa-2x d-block mb-2" style="color:#cbd5e1;"></i>
                                Tidak ada data yang sesuai dengan filter Anda.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no=1; foreach($hasil_filter as $s): ?>
                        <tr>
                            <td class="text-center fw-bold" style="color:#64748b;"><?= $no++; ?></td>
                            
                            <?php if($tipe == 'masuk'): ?>
                                <td><strong><?= $s->no_agenda; ?></strong></td>
                                <td><?= $s->pengirim; ?></td>
                                <td><?= substr($s->perihal, 0, 50); ?><?= strlen($s->perihal) > 50 ? '...' : ''; ?></td>
                                <td><?= date('d-m-Y', strtotime($s->tgl_terima)); ?></td>
                            <?php else: ?>
                                <td><strong><?= $s->no_surat; ?></strong></td>
                                <td><?= $s->tujuan; ?></td>
                                <td><?= substr($s->perihal, 0, 50); ?><?= strlen($s->perihal) > 50 ? '...' : ''; ?></td>
                                <td><?= date('d-m-Y', strtotime($s->tgl_surat)); ?></td>
                            <?php endif; ?>
                            
                            <td>
                                <span class="badge-status <?= $s->status; ?>"><?= ucfirst($s->status); ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================
     STYLE KHUSUS LAPORAN (Tetap Sama)
     ============================================================ -->
<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
    }

    .page-header .header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.3rem;
        box-shadow: 0 4px 16px rgba(30, 64, 175, 0.25);
    }

    /* ===== CARD CUSTOM ===== */
    .card-custom {
        background: #fff;
        border-radius: var(--radius, 14px);
        box-shadow: var(--shadow-sm, 0 1px 3px rgba(0,0,0,0.06));
        border: 1px solid var(--slate-200, #e2e8f0);
        overflow: hidden;
        transition: var(--transition, all 0.3s ease);
    }

    .card-custom:hover {
        box-shadow: var(--shadow-md, 0 4px 20px rgba(0,0,0,0.07));
    }

    .card-header-custom {
        padding: 14px 22px;
        background: var(--slate-50, #f8fafc);
        border-bottom: 1px solid var(--slate-200, #e2e8f0);
        font-weight: 600;
        color: var(--slate-700, #334155);
    }

    .card-body-custom {
        padding: 0;
        overflow-x: auto;
    }

    /* ===== TABEL ===== */
    .table-custom {
        font-size: 0.85rem;
        margin-bottom: 0;
        width: 100%;
        min-width: 700px;
    }

    .table-custom thead th {
        background: var(--slate-50, #f8fafc);
        color: var(--slate-600, #475569);
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-bottom: 2px solid var(--slate-200, #e2e8f0);
        padding: 12px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--slate-100, #f1f5f9);
        color: var(--slate-700, #334155);
        background: #fff;
    }

    .table-custom tbody tr:hover td {
        background: var(--blue-50, #eff6ff);
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== BADGE STATUS ===== */
    .badge-status {
        display: inline-block;
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.2px;
    }

    .badge-status.baru { background: #fef3c7; color: #d97706; }
    .badge-status.didisposisikan { background: #dbeafe; color: #2563eb; }
    .badge-status.diproses { background: #e0e7ff; color: #4338ca; }
    .badge-status.selesai { background: #d1fae5; color: #065f46; }
    .badge-status.arsip { background: #f1f5f9; color: #64748b; }
    .badge-status.draft { background: #f1f5f9; color: #475569; }
    .badge-status.dikirim { background: #dbeafe; color: #1e40af; }
    .badge-status.terkirim { background: #dbeafe; color: #1e40af; }

    /* ===== INFO PERIODE ===== */
    .info-periode {
        background: linear-gradient(135deg, var(--blue-50, #eff6ff), #dbeafe);
        border-radius: 12px;
        padding: 16px 22px;
        border: 1px solid var(--blue-200, #bfdbfe);
        margin-top: 8px;
    }

    .info-periode-icon {
        width: 44px;
        height: 44px;
        background: #ffffff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 1.3rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        flex-shrink: 0;
    }

    .info-periode h6 {
        color: var(--slate-800, #1e293b);
        font-size: 0.9rem;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .page-header .header-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .page-header h4 {
            font-size: 1.1rem;
        }

        .table-custom {
            font-size: 0.78rem;
            min-width: 600px;
        }

        .table-custom thead th,
        .table-custom tbody td {
            padding: 8px 10px;
        }

        .badge-status {
            font-size: 0.65rem;
            padding: 2px 10px;
        }

        .info-periode {
            padding: 14px 16px;
        }
    }

    @media (max-width: 576px) {
        .table-custom {
            min-width: 500px;
            font-size: 0.7rem;
        }

        .table-custom thead th,
        .table-custom tbody td {
            padding: 6px 8px;
        }

        .info-periode-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }
    }
</style>