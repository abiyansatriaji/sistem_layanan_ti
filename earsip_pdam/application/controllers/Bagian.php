<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bagian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_bagian');
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation']);

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }

        // Hanya Admin & Super Admin yang boleh akses (role_id 1 dan 2)
        $role = $this->session->userdata('role_id');
        if (!in_array($role, [1, 2])) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses!');
            redirect('index.php/dashboard');
        }
    }

    /**
     * Halaman utama (daftar bagian)
     */
    public function index() {
        $data['title'] = 'Data Bagian';
        $data['bagian'] = $this->M_bagian->get_all();
        $data['role_id'] = $this->session->userdata('role_id');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bagian/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Form tambah bagian
     */
    public function tambah() {
        $data['title'] = 'Tambah Bagian';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bagian/tambah', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Simpan data bagian
     */
    public function simpan() {
        $this->form_validation->set_rules('nama_bagian', 'Nama Bagian', 'required');
        $this->form_validation->set_rules('kode_bagian', 'Kode Bagian', 'required|callback_kode_check');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
            return;
        }

        $data = array(
            'nama_bagian' => $this->input->post('nama_bagian'),
            'kode_bagian' => strtoupper($this->input->post('kode_bagian'))
        );

        if ($this->M_bagian->insert($data)) {
            $this->session->set_flashdata('success', 'Data bagian berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan data bagian!');
        }

        redirect('index.php/bagian');
    }

    /**
     * Form edit bagian
     */
    public function edit($id) {
        $data['title'] = 'Edit Bagian';
        $data['bagian'] = $this->M_bagian->get_by_id($id);

        if (empty($data['bagian'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('index.php/bagian');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bagian/edit', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Update data bagian
     */
    public function update($id) {
        $this->form_validation->set_rules('nama_bagian', 'Nama Bagian', 'required');
        $this->form_validation->set_rules('kode_bagian', 'Kode Bagian', 'required|callback_kode_check[' . $id . ']');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        $data = array(
            'nama_bagian' => $this->input->post('nama_bagian'),
            'kode_bagian' => strtoupper($this->input->post('kode_bagian'))
        );

        if ($this->M_bagian->update($id, $data)) {
            $this->session->set_flashdata('success', 'Data bagian berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data bagian!');
        }

        redirect('index.php/bagian');
    }

    /**
     * Hapus data bagian
     */
    public function hapus($id) {
        // Cek apakah bagian digunakan di tabel lain (users, surat_keluar)
        $this->db->where('bagian_id', $id);
        $used_in_users = $this->db->count_all_results('users');

        if ($used_in_users > 0) {
            $this->session->set_flashdata('error', 'Bagian tidak bisa dihapus karena masih digunakan oleh data pegawai!');
            redirect('index.php/bagian');
        }

        if ($this->M_bagian->delete($id)) {
            $this->session->set_flashdata('success', 'Data bagian berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data bagian!');
        }

        redirect('index.php/bagian');
    }

    /**
     * Cari data bagian
     */
    public function cari() {
        $keyword = $this->input->post('keyword');
        $data['title'] = 'Hasil Pencarian Bagian';
        $data['bagian'] = $this->M_bagian->search($keyword);
        $data['keyword'] = $keyword;
        $data['role_id'] = $this->session->userdata('role_id');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bagian/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Callback: Cek kode bagian unik
     */
    public function kode_check($str, $id = null) {
        if ($this->M_bagian->is_kode_exists($str, $id)) {
            $this->form_validation->set_message('kode_check', 'Kode bagian <strong>' . $str . '</strong> sudah terdaftar!');
            return FALSE;
        }
        return TRUE;
    }
}