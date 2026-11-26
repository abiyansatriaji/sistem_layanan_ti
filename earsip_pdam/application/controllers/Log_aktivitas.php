<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_aktivitas extends CI_Controller {

    // Pilihan retensi yang diizinkan (bulan). Sengaja minimal 6 bulan
    // supaya log baru tidak bisa terhapus lewat fitur pembersihan.
    private $retensi_boleh = [6, 12, 24];
    private $per_page = 25;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_log');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }

        // Audit log hanya untuk Super Admin (IT)
        if ($this->session->userdata('role_id') != 1) {
            $this->session->set_flashdata('error', 'Akses ditolak! Log aktivitas hanya untuk Super Admin.');
            redirect('index.php/dashboard');
        }
    }

    public function index() {
        $data['title'] = 'Log Aktivitas';

        $filter = [
            'user_id'   => $this->input->get('user_id'),
            'modul'     => $this->input->get('modul'),
            'tgl_awal'  => $this->input->get('tgl_awal'),
            'tgl_akhir' => $this->input->get('tgl_akhir'),
            'keyword'   => $this->input->get('keyword')
        ];

        // ----- Pagination -----
        $total       = $this->M_log->count_filtered($filter);
        $total_pages = max(1, (int) ceil($total / $this->per_page));
        $page        = min(max(1, (int) $this->input->get('page')), $total_pages);
        $offset      = ($page - 1) * $this->per_page;

        $data['filter']       = $filter;
        $data['log']          = $this->M_log->get_all($filter, $this->per_page, $offset);
        $data['users']        = $this->db->get('users')->result();
        $data['total_hari']   = $this->M_log->count_today();
        $data['total_semua']  = $this->M_log->count_all();
        $data['total_filter'] = $total;
        $data['page']         = $page;
        $data['total_pages']  = $total_pages;
        $data['offset']       = $offset;
        // query string filter (tanpa page) agar filter terbawa saat pindah halaman
        $data['qs']           = http_build_query(array_filter($filter, function ($v) {
            return $v !== null && $v !== '';
        }));

        // ----- Info pembersihan: berapa baris yang akan terhapus per pilihan -----
        $retensi = [];
        foreach ($this->retensi_boleh as $b) {
            $retensi[$b] = $this->M_log->count_older_than($b);
        }
        $data['retensi'] = $retensi;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('log_aktivitas/index', $data);
        $this->load->view('templates/footer');
    }

    // Hapus log yang lebih lama dari N bulan. Hanya lewat POST.
    public function bersihkan() {
        if ($this->input->method() !== 'post') {
            redirect('index.php/log_aktivitas');
        }

        $bulan = (int) $this->input->post('bulan');
        if (!in_array($bulan, $this->retensi_boleh, true)) {
            $this->session->set_flashdata('error', 'Pilihan periode tidak valid.');
            redirect('index.php/log_aktivitas');
        }

        $jumlah = $this->M_log->delete_older_than($bulan);

        // Catat SETELAH hapus, supaya jejak pembersihan ini sendiri tidak ikut hilang
        catat_log('Membersihkan log aktivitas lebih lama dari ' . $bulan . ' bulan (' . $jumlah . ' baris dihapus)', 'log');

        $this->session->set_flashdata('success', $jumlah . ' log lebih lama dari ' . $bulan . ' bulan berhasil dihapus.');
        redirect('index.php/log_aktivitas');
    }
}