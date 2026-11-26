<!-- ============================================================
     SIDEBAR
     ============================================================ -->
<aside class="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-bars me-2"></i> Menu Navigasi
    </div>

    <?php
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('user_id');
    $active  = $this->uri->segment(1);
    ?>

    <a href="<?= base_url('index.php/dashboard'); ?>" class="nav-link <?= ($active == 'dashboard' || $active == '') ? 'active' : ''; ?>">
        <i class="fas fa-chart-pie"></i> Dashboard
    </a>

    <?php if ($role_id <= 2): // Admin & Super Admin ?>
    <a href="<?= base_url('index.php/surat_masuk'); ?>" class="nav-link <?= ($active == 'surat_masuk') ? 'active' : ''; ?>">
        <i class="fas fa-inbox"></i> Surat Masuk
        <?php
        $count_sm = $this->db->where('status', 'baru')->count_all_results('surat_masuk');
        if ($count_sm > 0): ?>
        <span class="badge-sidebar"><?= $count_sm; ?></span>
        <?php endif; ?>
    </a>
    <a href="<?= base_url('index.php/surat_keluar'); ?>" class="nav-link <?= ($active == 'surat_keluar') ? 'active' : ''; ?>">
        <i class="fas fa-envelope"></i> Surat Keluar
    </a>
    <?php endif; ?>

    <a href="<?= base_url('index.php/disposisi'); ?>" class="nav-link <?= ($active == 'disposisi') ? 'active' : ''; ?>">
        <i class="fas fa-share-alt"></i> Disposisi
        <?php
        $count_dis = $this->db->where('ke_user_id', $user_id)->where('status !=', 'selesai')->count_all_results('disposisi');
        if ($count_dis > 0): ?>
        <span class="badge-sidebar"><?= $count_dis; ?></span>
        <?php endif; ?>
    </a>

    <?php if ($role_id == 1): // Super Admin ?>
    <a href="<?= base_url('index.php/user'); ?>" class="nav-link <?= ($active == 'user') ? 'active' : ''; ?>">
        <i class="fas fa-users-cog"></i> Kelola User
    </a>
    <a href="<?= base_url('index.php/log_aktivitas'); ?>" class="nav-link <?= ($active == 'log_aktivitas') ? 'active' : ''; ?>">
        <i class="fas fa-history"></i> Log Aktivitas
    </a>
    <?php endif; ?>

    <?php if ($role_id <= 2): // Admin & Super Admin ?>
    <a href="<?= base_url('index.php/klasifikasi'); ?>" class="nav-link <?= ($active == 'klasifikasi') ? 'active' : ''; ?>">
        <i class="fas fa-tags"></i> Klasifikasi
    </a>
    <a href="<?= base_url('index.php/bagian'); ?>" class="nav-link <?= ($active == 'bagian') ? 'active' : ''; ?>">
        <i class="fas fa-building"></i> Bagian
    </a>
    <a href="<?= base_url('index.php/laporan'); ?>" class="nav-link <?= ($active == 'laporan') ? 'active' : ''; ?>">
        <i class="fas fa-file-pdf"></i> Laporan
    </a>
    <?php endif; ?>

    <a href="<?= base_url('index.php/arsip'); ?>" class="nav-link <?= ($active == 'arsip') ? 'active' : ''; ?>">
        <i class="fas fa-archive"></i> Arsip Surat
    </a>
</aside>

<!-- ============================================================
     STYLE SIDEBAR
     ============================================================ -->
<style>
    .sidebar {
        width: 240px;
        flex-shrink: 0;
        background: #ffffff;
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--slate-200);
        overflow: hidden;
        height: fit-content;
        position: sticky;
        top: 92px;
        padding: 8px 0;
    }

    .sidebar .sidebar-header {
        padding: 16px 20px 12px;
        border-bottom: 1px solid var(--slate-100);
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--slate-400);
    }

    .sidebar .nav-link {
        padding: 11px 20px;
        color: var(--slate-600);
        font-weight: 500;
        font-size: 0.88rem;
        border-left: 3px solid transparent;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        border-radius: 0;
    }

    .sidebar .nav-link:hover {
        background: var(--slate-50);
        color: var(--primary);
        border-left-color: var(--accent);
    }

    .sidebar .nav-link.active {
        background: var(--slate-50);
        color: var(--primary);
        border-left-color: var(--accent);
        font-weight: 600;
    }

    .sidebar .nav-link i {
        width: 20px;
        font-size: 1rem;
        text-align: center;
        color: var(--slate-400);
    }

    .sidebar .nav-link.active i {
        color: var(--accent);
    }

    .sidebar .nav-link .badge-sidebar {
        margin-left: auto;
        background: #dc2626;
        color: #fff;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        min-width: 20px;
        text-align: center;
    }

    @media (max-width: 992px) {
        .sidebar {
            width: 100%;
            position: static;
            display: flex;
            flex-wrap: wrap;
            padding: 4px 0;
            gap: 0;
        }
        .sidebar .sidebar-header { display: none; }
        .sidebar .nav-link {
            flex: 1 0 auto;
            padding: 10px 14px;
            border-left: none;
            border-bottom: 2px solid transparent;
            font-size: 0.8rem;
            justify-content: center;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            border-left: none;
            border-bottom-color: var(--accent);
        }
        .sidebar .nav-link .badge-sidebar {
            margin-left: 6px;
        }
    }

    @media (max-width: 576px) {
        .sidebar .nav-link {
            font-size: 0.7rem;
            padding: 8px 10px;
        }
        .sidebar .nav-link i {
            font-size: 0.85rem;
        }
    }
</style>

<!-- ===== MAIN CONTENT ===== -->
<main class="main-content">