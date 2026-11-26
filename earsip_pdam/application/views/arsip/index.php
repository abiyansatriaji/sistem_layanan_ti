<!-- ============================================================
     HALAMAN PENCARIAN ARSIP - E-Arsip PDAM
     ============================================================ -->

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0"><?= $title; ?></h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-archive me-1"></i> Cari arsip surat masuk dan surat keluar
                    </p>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= base_url('index.php/arsip/surat_arsip'); ?>" class="btn btn-success">
                <i class="fas fa-archive me-1"></i> Lihat Arsip Lengkap
            </a>
        </div>
    </div>
</div>

<!-- ============================================================
     FILTER PENCARIAN
     ============================================================ -->
<div class="card-custom mb-4">
    <div class="card-header-custom">
        <span><i class="fas fa-filter me-2"></i> Filter Pencarian</span>
    </div>
    <div class="card-body-custom p-3">
        <form method="get" action="<?= base_url('index.php/arsip'); ?>" class="row g-3" autocomplete="off">
            <div class="col-md-4">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">
                    <i class="fas fa-keyboard text-muted me-1"></i> Kata Kunci
                </label>
                <input type="text" name="keyword" class="form-control" 
                       placeholder="Nomor, perihal, pengirim/tujuan..." 
                       value="<?= $keyword; ?>" autocomplete="off"
                       style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">
                    <i class="fas fa-tag text-muted me-1"></i> Tipe Surat
                </label>
                <select name="tipe" class="form-select" 
                        style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
                    <option value="masuk" <?= ($tipe == 'masuk') ? 'selected' : ''; ?>>📥 Surat Masuk</option>
                    <option value="keluar" <?= ($tipe == 'keluar') ? 'selected' : ''; ?>>📤 Surat Keluar</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">
                    <i class="fas fa-folder text-muted me-1"></i> Klasifikasi
                </label>
                <select name="klasifikasi_id" class="form-select" 
                        style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
                    <option value="">-- Semua --</option>
                    <?php foreach($klasifikasi as $k): ?>
                    <option value="<?= $k->id; ?>" <?= ($k->id == $klasifikasi_id) ? 'selected' : ''; ?>>
                        <?= $k->kode_klasifikasi . ' - ' . $k->nama_klasifikasi; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">
                    <i class="fas fa-calendar-alt text-muted me-1"></i> Tanggal Awal
                </label>
                <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>"
                       style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--slate-700);">
                    <i class="fas fa-calendar-check text-muted me-1"></i> Tanggal Akhir
                </label>
                <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>"
                       style="border-radius:10px; border:2px solid var(--slate-200); font-size:0.9rem;">
            </div>
            <div class="col-md-12 d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-primary" style="border-radius:10px; font-weight:600;">
                    <i class="fas fa-search me-1"></i> Cari Arsip
                </button>
                <a href="<?= base_url('index.php/arsip'); ?>" class="btn btn-outline-secondary" style="border-radius:10px;">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================
     HASIL PENCARIAN
     ============================================================ -->
<div class="card-custom">
    <div class="card-header-custom">
        <div class="d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-list me-2"></i> Hasil Pencarian
                <?php if(!empty($keyword)): ?>
                    <span class="text-muted small fw-normal ms-2">— "<?= $keyword; ?>"</span>
                <?php endif; ?>
            </span>
            <span class="badge bg-primary rounded-pill"><?= count($hasil); ?> Data</span>
        </div>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th style="min-width:120px;">Nomor</th>
                        <th>Perihal</th>
                        <th><?= ($tipe == 'masuk') ? 'Pengirim' : 'Tujuan'; ?></th>
                        <th>Klasifikasi</th>
                        <th style="min-width:110px;">Tanggal</th>
                        <th width="110">Status</th>
                        <th width="120">Lampiran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($hasil)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-search fa-2x d-block mb-2" style="color:#cbd5e1;"></i>
                            Tidak ada hasil yang ditemukan
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php $no=1; foreach($hasil as $h): ?>
                    <tr>
                        <td class="text-center fw-bold" style="color:#64748b;"><?= $no++; ?></td>
                        <td><strong><?= ($tipe == 'masuk') ? $h->no_agenda : $h->no_surat; ?></strong></td>
                        <td><?= htmlspecialchars(substr($h->perihal, 0, 45)) . (strlen($h->perihal) > 45 ? '...' : ''); ?></td>
                        <td><?= htmlspecialchars(($tipe == 'masuk') ? $h->pengirim : $h->tujuan); ?></td>
                        <td><?= $h->nama_klasifikasi ?? '<span class="text-muted">-</span>'; ?></td>
                        <td><?= date('d-m-Y', strtotime($tipe == 'masuk' ? $h->tgl_terima : $h->tgl_surat)); ?></td>
                        <td>
                            <span class="badge-status <?= $h->status; ?>"><?= ucfirst($h->status); ?></span>
                        </td>
                        <td>
                            <?php 
                            $lampiran = $this->db->get_where('lampiran_surat', [
                                'surat_tipe' => $tipe,
                                'surat_id' => $h->id
                            ])->result();
                            
                            if(!empty($lampiran)):
                                foreach($lampiran as $l): ?>
                                    <a href="<?= base_url('index.php/arsip/lihat/' . $l->id); ?>" 
                                       class="btn-action view" target="_blank" title="Lihat Lampiran">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('index.php/arsip/download/' . $l->id); ?>" 
                                       class="btn-action download" title="Download Lampiran">
                                        <i class="fas fa-download"></i>
                                    </a>
                                <?php endforeach;
                            else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
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
     STYLE KHUSUS PENCARIAN ARSIP
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
        min-width: 800px;
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

    /* ===== TOMBOL AKSI ===== */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid var(--slate-200, #e2e8f0);
        transition: var(--transition, all 0.3s ease);
        text-decoration: none;
        font-size: 0.8rem;
        color: var(--slate-500, #64748b);
        background: var(--slate-50, #f8fafc);
    }

    .btn-action:hover {
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-action.view:hover {
        background: #dbeafe;
        border-color: #60a5fa;
        color: #2563eb;
    }

    .btn-action.download:hover {
        background: #d1fae5;
        border-color: #34d399;
        color: #065f46;
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
            min-width: 700px;
        }

        .table-custom thead th,
        .table-custom tbody td {
            padding: 8px 10px;
        }

        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .table-custom {
            min-width: 600px;
            font-size: 0.7rem;
        }

        .table-custom thead th,
        .table-custom tbody td {
            padding: 6px 8px;
        }

        .btn-action {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
            border-radius: 6px;
        }
    }
</style>