<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Klasifikasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_klasifikasi');
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation']);

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }

        // Hanya Super Admin (1) & Admin (2) yang boleh akses
        $role = $this->session->userdata('role_id');
        if (!in_array($role, [1, 2])) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses!');
            redirect('index.php/dashboard');
        }
    }

    // ============================================================
    // HALAMAN UTAMA KLASIFIKASI
    // ============================================================
    public function index() {
        $data['title'] = 'Data Klasifikasi Surat';
        $data['klasifikasi'] = $this->M_klasifikasi->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('klasifikasi/index', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // TAMBAH KLASIFIKASI
    // ============================================================
    public function tambah() {
        $data['title'] = 'Tambah Klasifikasi Surat';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('klasifikasi/tambah', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // SIMPAN KLASIFIKASI
    // ============================================================
    public function simpan() {
        $this->form_validation->set_rules('kode_klasifikasi', 'Kode Klasifikasi', 'required|alpha_dash');
        $this->form_validation->set_rules('nama_klasifikasi', 'Nama Klasifikasi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
            return;
        }

        // Cek duplikat kode
        $kode = $this->input->post('kode_klasifikasi');
        if ($this->M_klasifikasi->is_kode_exists($kode)) {
            $this->session->set_flashdata('error', 'Kode klasifikasi "' . $kode . '" sudah terdaftar!');
            redirect('index.php/klasifikasi/tambah');
            return;
        }

        $data = [
            'kode_klasifikasi' => strtoupper($kode),
            'nama_klasifikasi' => $this->input->post('nama_klasifikasi'),
            'keterangan'       => $this->input->post('keterangan')
        ];

        $this->M_klasifikasi->insert($data);
        $this->session->set_flashdata('success', 'Klasifikasi berhasil ditambahkan!');
        redirect('index.php/klasifikasi');
    }

    // ============================================================
    // EDIT KLASIFIKASI
    // ============================================================
    public function edit($id) {
        $data['title'] = 'Edit Klasifikasi Surat';
        $data['klasifikasi'] = $this->M_klasifikasi->get_by_id($id);

        if (empty($data['klasifikasi'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('index.php/klasifikasi');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('klasifikasi/edit', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // UPDATE KLASIFIKASI
    // ============================================================
    public function update($id) {
        $this->form_validation->set_rules('kode_klasifikasi', 'Kode Klasifikasi', 'required|alpha_dash');
        $this->form_validation->set_rules('nama_klasifikasi', 'Nama Klasifikasi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        $kode = $this->input->post('kode_klasifikasi');
        // Cek duplikat kode (kecuali dirinya sendiri)
        if ($this->M_klasifikasi->is_kode_exists($kode, $id)) {
            $this->session->set_flashdata('error', 'Kode klasifikasi "' . $kode . '" sudah digunakan oleh klasifikasi lain!');
            redirect('index.php/klasifikasi/edit/' . $id);
            return;
        }

        $data = [
            'kode_klasifikasi' => strtoupper($kode),
            'nama_klasifikasi' => $this->input->post('nama_klasifikasi'),
            'keterangan'       => $this->input->post('keterangan')
        ];

        $this->M_klasifikasi->update($id, $data);
        $this->session->set_flashdata('success', 'Klasifikasi berhasil diperbarui!');
        redirect('index.php/klasifikasi');
    }

    // ============================================================
    // HAPUS KLASIFIKASI
    // ============================================================
    public function hapus($id) {
        // Cek apakah klasifikasi sedang digunakan di surat
        $this->db->where('klasifikasi_id', $id);
        $count_surat = $this->db->count_all_results('surat_masuk');
        $this->db->where('klasifikasi_id', $id);
        $count_surat_keluar = $this->db->count_all_results('surat_keluar');

        if ($count_surat > 0 || $count_surat_keluar > 0) {
            $this->session->set_flashdata('error', 'Klasifikasi tidak dapat dihapus karena masih digunakan di surat!');
            redirect('index.php/klasifikasi');
        }

        $this->M_klasifikasi->delete($id);
        $this->session->set_flashdata('success', 'Klasifikasi berhasil dihapus!');
        redirect('index.php/klasifikasi');
    }

    // ============================================================
    // CARI KLASIFIKASI
    // ============================================================
    public function cari() {
        $keyword = $this->input->post('keyword');
        $data['title'] = 'Hasil Pencarian Klasifikasi';
        $data['klasifikasi'] = $this->M_klasifikasi->search($keyword);
        $data['keyword'] = $keyword;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('klasifikasi/index', $data);
        $this->load->view('templates/footer');
    }
}