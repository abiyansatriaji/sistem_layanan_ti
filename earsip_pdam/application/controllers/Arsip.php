<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['M_surat_masuk', 'M_surat_keluar', 'M_klasifikasi']);
        $this->load->helper(['form', 'url', 'download']);
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }
    }

    // ============================================================
    // FR-13: HALAMAN PENCARIAN
    // ============================================================
    public function index() {
        $data['title'] = 'Pencarian & Arsip Surat';
        $data['klasifikasi'] = $this->M_klasifikasi->get_all();

        // Ambil filter dari GET
        $keyword = $this->input->get('keyword');
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $klasifikasi_id = $this->input->get('klasifikasi_id');
        $tipe = $this->input->get('tipe') ?: 'masuk';

        $data['keyword'] = $keyword;
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['klasifikasi_id'] = $klasifikasi_id;
        $data['tipe'] = $tipe;

        if ($tipe == 'masuk') {
            $data['hasil'] = $this->M_surat_masuk->search_advanced($keyword, $tgl_awal, $tgl_akhir, $klasifikasi_id);
        } else {
            $data['hasil'] = $this->M_surat_keluar->search_advanced($keyword, $tgl_awal, $tgl_akhir, $klasifikasi_id);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arsip/index', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // FR-14: DOWNLOAD LAMPIRAN (force download)
    // ============================================================
    public function download($id) {
        $lampiran = $this->db->get_where('lampiran_surat', ['id' => $id])->row();

        if (empty($lampiran)) {
            show_error('File tidak ditemukan!', 404);
        }

        // Normalisasi path (hindari double slash / leading slash)
        $rel_path = ltrim($lampiran->path_file, '/\\');
        $path = FCPATH . $rel_path;

        if (!file_exists($path)) {
            show_error('File tidak ada di server: ' . $rel_path, 404);
        }

        // Bersihkan output buffer agar file tidak corrupt
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Force download
        force_download(basename($lampiran->nama_file), file_get_contents($path));
        exit;
    }

    // ============================================================
    // FR-14: LIHAT LAMPIRAN
    // - PDF & Gambar → preview inline di browser
    // - Office (docx/xlsx/pptx) & Archive (zip/rar) → halaman info + tombol download
    // ============================================================
    public function lihat($id) {
        $lampiran = $this->db->get_where('lampiran_surat', ['id' => $id])->row();

        if (empty($lampiran)) {
            show_error('File tidak ditemukan!', 404);
        }

        // Normalisasi path
        $rel_path = ltrim($lampiran->path_file, '/\\');
        $path = FCPATH . $rel_path;

        if (!file_exists($path)) {
            show_error('File tidak ada di server: ' . $rel_path, 404);
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // ============================================
        // File yang BISA di-preview langsung di browser
        // ============================================
        $previewable = [
            'pdf'  => 'application/pdf',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
            'bmp'  => 'image/bmp',
            'svg'  => 'image/svg+xml',
            'txt'  => 'text/plain',
        ];

        // ============================================
        // File Office & Archive → tampilkan halaman info
        // ============================================
        $office  = ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'odt', 'ods', 'odp'];
        $archive = ['zip', 'rar', '7z', 'tar', 'gz'];

        if (in_array($ext, $office) || in_array($ext, $archive)) {
            $this->_tampilkan_halaman_info($lampiran, $ext, $office);
            return;
        }

        // ============================================
        // File previewable → kirim inline
        // ============================================
        $mime = $previewable[$ext] ?? 'application/octet-stream';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: ' . $mime);
        header('Content-Disposition: inline; filename="' . basename($lampiran->nama_file) . '"');
        header('Content-Length: ' . filesize($path));
        header('Cache-Control: public, max-age=0');
        header('Pragma: public');
        header('X-Content-Type-Options: nosniff');

        readfile($path);
        exit;
    }

      // ============================================================
    // PRIVATE: Tampilkan halaman info "Preview Tidak Tersedia"
    // ============================================================
    private function _tampilkan_halaman_info($lampiran, $ext, $office) {
        $file_url   = base_url('index.php/arsip/download/' . $lampiran->id);
        $file_name  = htmlspecialchars($lampiran->nama_file);
        $file_size  = isset($lampiran->ukuran_kb) ? round($lampiran->ukuran_kb, 2) . ' KB' : '-';
        $tipe_label = in_array($ext, $office) ? 'Dokumen Office' : 'File Arsip (ZIP/RAR)';

        // ✅ Fallback URL kalau window.close() di-block
        $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $back_url = !empty($referrer) ? $referrer : base_url('index.php/arsip');

        // Icon emoji berdasarkan tipe
        if (in_array($ext, ['doc', 'docx', 'odt'])) {
            $icon = '📝';
        } elseif (in_array($ext, ['xls', 'xlsx', 'ods'])) {
            $icon = '📊';
        } elseif (in_array($ext, ['ppt', 'pptx', 'odp'])) {
            $icon = '📽️';
        } else {
            $icon = '🗜️';
        }

        echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Preview Tidak Tersedia</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' rel='stylesheet'>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eef5 100%);
            min-height: 100vh;
            padding: 40px 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .preview-box {
            max-width: 560px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
        }
        .preview-icon {
            font-size: 80px;
            line-height: 1;
            margin-bottom: 20px;
        }
        .preview-box h3 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .file-info {
            background: #f8fafc;
            border-radius: 10px;
            padding: 16px 20px;
            margin: 24px 0;
            text-align: left;
            border-left: 4px solid #0d6efd;
        }
        .file-info .row-item {
            display: flex;
            padding: 6px 0;
            font-size: 14px;
        }
        .file-info .label {
            color: #64748b;
            width: 100px;
            flex-shrink: 0;
        }
        .file-info .value {
            color: #1e293b;
            font-weight: 500;
            word-break: break-all;
        }
        .btn-download {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: #fff;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-download:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(13, 110, 253, 0.4);
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            background: none;
            border: none;
            text-decoration: none;
            margin-top: 20px;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
            font-family: inherit;
        }
        .btn-back:hover {
            color: #0d6efd;
            background: #f1f5f9;
        }
        .alert-info-custom {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-top: 16px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class='preview-box'>
        <div class='preview-icon'>{$icon}</div>
        <h3>Preview Tidak Tersedia</h3>
        <p class='text-muted mb-0' style='font-size: 14px;'>
            Browser tidak dapat menampilkan file <strong>{$tipe_label}</strong> secara langsung.
            Silakan download file untuk membukanya.
        </p>

        <div class='file-info'>
            <div class='row-item'>
                <div class='label'><i class='fas fa-file'></i> Nama File</div>
                <div class='value'>{$file_name}</div>
            </div>
            <div class='row-item'>
                <div class='label'><i class='fas fa-hdd'></i> Ukuran</div>
                <div class='value'>{$file_size}</div>
            </div>
            <div class='row-item'>
                <div class='label'><i class='fas fa-tag'></i> Tipe</div>
                <div class='value'>" . strtoupper($ext) . " - {$tipe_label}</div>
            </div>
        </div>

        <a href='{$file_url}' class='btn-download'>
            <i class='fas fa-download'></i> Download File
        </a>

        <div>
            <button type='button' onclick='tutupAtauKembali()' class='btn-back'>
                <i class='fas fa-times'></i> Tutup
            </button>
        </div>

        <div class='alert-info-custom'>
            <i class='fas fa-info-circle'></i>
            <strong>Info:</strong> File PDF dan gambar dapat dipreview langsung di browser.
            Untuk file Office/ZIP, silakan download terlebih dahulu.
        </div>
    </div>

    <script>
        function tutupAtauKembali() {
            // 1. Coba tutup tab
            window.close();

            // 2. Fallback: kalau tab masih terbuka (close di-block),
            //    redirect ke halaman arsip
            setTimeout(function() {
                if (!window.closed) {
                    window.location.href = '{$back_url}';
                }
            }, 300);
        }
    </script>
</body>
</html>";
        exit;
    }

    // ============================================================
    // ARSIP SURAT (hanya status selesai/arsip)
    // ============================================================
    public function surat_arsip() {
        $data['title'] = 'Arsip Surat';
        $data['klasifikasi'] = $this->M_klasifikasi->get_all();

        $keyword = $this->input->get('keyword');
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $klasifikasi_id = $this->input->get('klasifikasi_id');
        $tipe = $this->input->get('tipe') ?: 'masuk';

        $data['keyword'] = $keyword;
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['klasifikasi_id'] = $klasifikasi_id;
        $data['tipe'] = $tipe;

        if ($tipe == 'masuk') {
            $data['hasil'] = $this->M_surat_masuk->get_arsip($keyword, $tgl_awal, $tgl_akhir, $klasifikasi_id);
        } else {
            $data['hasil'] = $this->M_surat_keluar->get_arsip($keyword, $tgl_awal, $tgl_akhir, $klasifikasi_id);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arsip/surat_arsip', $data);
        $this->load->view('templates/footer');
    }
}