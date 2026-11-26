<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');

        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }
        
        $this->load->model('M_dashboard');
        $this->load->model('User_model');
        $this->load->helper('nomor');
        $this->load->database();
    }

    public function index() {
        $data['title'] = 'Dashboard';
        
        // ===== STATISTIK =====
        $data['total_surat_masuk'] = $this->db->count_all('surat_masuk');
        $data['total_surat_keluar'] = $this->db->count_all('surat_keluar');
        $data['total_disposisi'] = $this->db->count_all('disposisi');
        $data['total_users'] = $this->User_model->count_active_users();
        
        // ===== SURAT MASUK TERBARU (5 data) =====
        $this->db->order_by('id', 'desc');
        $this->db->limit(5);
        $data['surat_masuk_terbaru'] = $this->db->get('surat_masuk')->result_array();

        // ===== DISPOSISI MASUK TERBARU (5 data) + JOIN =====
        $this->db->select('d.*, sm.no_agenda, sm.perihal, u.nama as dari_nama');
        $this->db->from('disposisi d');
        $this->db->join('surat_masuk sm', 'sm.id = d.surat_masuk_id', 'left');
        $this->db->join('users u', 'u.id = d.dari_user_id', 'left');
        $this->db->order_by('d.id', 'desc');
        $this->db->limit(5);
        $data['disposisi_masuk'] = $this->db->get()->result_array();

        // ===== GRAFIK: Surat Masuk & Keluar per Bulan (12 bulan terakhir) =====
        $bulan = array();
        $masuk = array();
        $keluar = array();

        for ($i = 11; $i >= 0; $i--) {
            $tgl = date('Y-m-01', strtotime("-$i months"));
            $bulan_ini = date('M Y', strtotime($tgl));
            $bulan[] = $bulan_ini;

            // Hitung surat masuk bulan ini (pakai tgl_terima)
            $start = date('Y-m-01', strtotime($tgl));
            $end = date('Y-m-t', strtotime($tgl));
            
            // Surat Masuk
            $this->db->where('tgl_terima >=', $start);
            $this->db->where('tgl_terima <=', $end);
            $total_masuk = $this->db->count_all_results('surat_masuk');
            $masuk[] = $total_masuk;

            // Surat Keluar (pakai tgl_surat)
            $this->db->where('tgl_surat >=', $start);
            $this->db->where('tgl_surat <=', $end);
            $total_keluar = $this->db->count_all_results('surat_keluar');
            $keluar[] = $total_keluar;
        }

        $data['chart_bulan'] = json_encode($bulan);
        $data['chart_masuk'] = json_encode($masuk);
        $data['chart_keluar'] = json_encode($keluar);
        
        // Cek apakah semua data 0 (untuk menampilkan pesan)
        $data['has_data'] = (array_sum($masuk) + array_sum($keluar)) > 0;

        // ===== LOAD VIEW =====
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}