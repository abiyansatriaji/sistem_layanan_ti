<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['M_surat_masuk', 'M_surat_keluar']);
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation']);

        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }
        // Hanya Admin, Super Admin & Pimpinan
        $role = $this->session->userdata('role_id');
        if (!in_array($role, [1, 2, 3])) {
            $this->session->set_flashdata('error', 'Akses ditolak!');
            redirect('index.php/dashboard');
        }
    }

    // ============================================================
    // FUNGSI BANTUAN QUERY (Agar tidak menulis ulang query panjang)
    // ============================================================
    private function _build_query($tipe, $bulan, $tahun, $bagian_id, $status) {
        if ($tipe == 'masuk') {
            // Ambil kode klasifikasi dan kumpulkan nama penerima disposisi (dipisah '||')
            $this->db->select('surat_masuk.*, klasifikasi_surat.kode_klasifikasi, klasifikasi_surat.nama_klasifikasi,
                (SELECT GROUP_CONCAT(u.nama SEPARATOR "||") 
                 FROM disposisi d 
                 JOIN users u ON u.id = d.ke_user_id 
                 WHERE d.surat_masuk_id = surat_masuk.id) as kepada');
            $this->db->from('surat_masuk');
            $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_masuk.klasifikasi_id', 'left');
            
            $this->db->where('MONTH(surat_masuk.tgl_terima)', $bulan);
            $this->db->where('YEAR(surat_masuk.tgl_terima)', $tahun);
            
            if (!empty($status)) {
                $this->db->where('surat_masuk.status', $status);
            }
            if (!empty($bagian_id)) {
                // Gunakan alias 'creator' agar tidak bentrok dengan tabel 'users' di subquery
                $this->db->join('users as creator', 'creator.id = surat_masuk.created_by', 'left');
                $this->db->where('creator.bagian_id', $bagian_id);
            }
            $this->db->order_by('surat_masuk.id', 'DESC');
        } else {
            // Surat keluar cukup join dengan klasifikasi
            $this->db->select('surat_keluar.*, klasifikasi_surat.kode_klasifikasi, klasifikasi_surat.nama_klasifikasi');
            $this->db->from('surat_keluar');
            $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_keluar.klasifikasi_id', 'left');
            
            $this->db->where('MONTH(surat_keluar.tgl_surat)', $bulan);
            $this->db->where('YEAR(surat_keluar.tgl_surat)', $tahun);
            
            if (!empty($status)) {
                $this->db->where('surat_keluar.status', $status);
            }
            if (!empty($bagian_id)) {
                $this->db->where('surat_keluar.bagian_id', $bagian_id);
            }
            $this->db->order_by('surat_keluar.id', 'DESC');
        }
        return $this->db->get()->result();
    }

    // ============================================================
    // HALAMAN UTAMA LAPORAN DENGAN FILTER
    // ============================================================
    public function index() {
        $data['title'] = 'Laporan Surat';
        
        $data['bulan']       = $this->input->get('bulan') ?: date('m');
        $data['tahun']       = $this->input->get('tahun') ?: date('Y');
        $data['bagian_id']   = $this->input->get('bagian_id') ?: '';
        $data['status']      = $this->input->get('status') ?: '';
        $data['tipe']        = $this->input->get('tipe') ?: 'masuk'; 

        $data['months'] = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $data['list_bagian'] = $this->db->get('bagian')->result();

        // Panggil fungsi bantuan query
        $data['hasil_filter'] = $this->_build_query($data['tipe'], $data['bulan'], $data['tahun'], $data['bagian_id'], $data['status']);
        $data['total_hasil'] = count($data['hasil_filter']);
        $data['nama_bulan'] = $data['months'][(int)$data['bulan']];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // EXPORT EXCEL DENGAN FILTER
    // ============================================================
    public function export_excel() {
        $data['bulan']       = $this->input->get('bulan') ?: date('m');
        $data['tahun']       = $this->input->get('tahun') ?: date('Y');
        $data['bagian_id']   = $this->input->get('bagian_id') ?: '';
        $data['status']      = $this->input->get('status') ?: '';
        $data['tipe']        = $this->input->get('tipe') ?: 'masuk';
        $data['nama_bulan']  = $this->_get_nama_bulan($data['bulan']);

        if (!empty($data['bagian_id'])) {
            $bagian = $this->db->get_where('bagian', ['id' => $data['bagian_id']])->row();
            $data['nama_bagian'] = $bagian ? $bagian->nama_bagian : 'Semua Bagian';
        } else {
            $data['nama_bagian'] = 'Semua Bagian';
        }

        $data['hasil_filter'] = $this->_build_query($data['tipe'], $data['bulan'], $data['tahun'], $data['bagian_id'], $data['status']);
        $data['total_hasil'] = count($data['hasil_filter']);
        
        $this->load->view('laporan/export_excel', $data);
    }

    // ============================================================
    // CETAK PDF DENGAN FILTER
    // ============================================================
    public function cetak() {
        $data['bulan']       = $this->input->get('bulan') ?: date('m');
        $data['tahun']       = $this->input->get('tahun') ?: date('Y');
        $data['bagian_id']   = $this->input->get('bagian_id') ?: '';
        $data['status']      = $this->input->get('status') ?: '';
        $data['tipe']        = $this->input->get('tipe') ?: 'masuk';
        $data['nama_bulan']  = $this->_get_nama_bulan($data['bulan']);
        $data['username']    = $this->session->userdata('nama');

        if (!empty($data['bagian_id'])) {
            $bagian = $this->db->get_where('bagian', ['id' => $data['bagian_id']])->row();
            $data['nama_bagian'] = $bagian ? $bagian->nama_bagian : 'Semua Bagian';
        } else {
            $data['nama_bagian'] = 'Semua Bagian';
        }

        $data['hasil_filter'] = $this->_build_query($data['tipe'], $data['bulan'], $data['tahun'], $data['bagian_id'], $data['status']);
        $data['total_hasil'] = count($data['hasil_filter']);

        $data['title'] = 'Laporan ' . ucfirst($data['tipe']) . ' ' . $data['nama_bulan'] . ' ' . $data['tahun'];
        $this->load->view('laporan/cetak', $data);
    }

    private function _get_nama_bulan($bulan) {
        $nama = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        return $nama[(int)$bulan] ?? 'Bulan';
    }
}