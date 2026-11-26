<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['M_tiket','M_master','M_penanganan']);
    }

    public function index() {
        $filter = [];
        if ($this->user['nama_role'] == 'Pelapor')  $filter['id_user']    = $this->user['id_user'];
        if ($this->user['nama_role'] == 'Teknisi')  $filter['id_teknisi'] = $this->user['id_user'];
        if ($this->input->get('q'))    $filter['q']        = $this->input->get('q');
        if ($this->input->get('status')) $filter['id_status'] = $this->input->get('status');

        $data['tikets'] = $this->M_tiket->get_all($filter);
        $data['status_list'] = $this->M_master->get('status_tiket');
        $data['title'] = 'Daftar Tiket';
        $this->render('tiket/index', $data);
    }

    public function create() {
        if (!in_array($this->user['nama_role'], ['Pelapor','Admin'])) show_error('Akses ditolak', 403);

        if ($this->input->post()) {
            $this->form_validation->set_rules('judul', 'Judul', 'required|min_length[5]');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
            $this->form_validation->set_rules('id_jenis', 'Jenis', 'required');
            $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = [
                    'kode_tiket'   => $this->M_tiket->generate_kode(),
                    'id_user'      => $this->user['id_user'],
                    'id_jenis'     => $this->input->post('id_jenis'),
                    'id_kategori'  => $this->input->post('id_kategori'),
                    'id_status'    => 1, // Menunggu
                    'judul'        => $this->input->post('judul', TRUE),
                    'deskripsi'    => $this->input->post('deskripsi', TRUE),
                    'lokasi'       => $this->input->post('lokasi', TRUE),
                    'prioritas'    => $this->input->post('prioritas') ?: 'Sedang',
                ];
                $id = $this->M_tiket->insert($data);
                $this->session->set_flashdata('success', 'Tiket berhasil dibuat: '.$data['kode_tiket']);
                redirect('tiket/detail/'.$id);
            }
        }

        $data['jenis']    = $this->M_master->get('jenis_layanan');
        $data['kategori'] = $this->M_master->get('kategori_layanan');
        $data['title']    = 'Buat Tiket';
        $this->render('tiket/create', $data);
    }

    public function detail($id) {
        $tiket = $this->M_tiket->get_by_id($id);
        if (!$tiket) show_404();

         // --- TAMBAHKAN VALIDASI INI ---
        // Pelapor hanya boleh melihat tiket miliknya sendiri
        if ($this->user['nama_role'] == 'Pelapor' && $tiket->id_user != $this->user['id_user']) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke tiket ini.');
            redirect('tiket');
        }

        $data['tiket']     = $tiket;
        $data['penugasan'] = $this->M_penanganan->penugasan_by_tiket($id);
        $data['riwayat']   = $this->M_penanganan->riwayat_by_tiket($id);
        $data['lampiran']  = $this->M_penanganan->lampiran_by_tiket($id);
        $data['title']     = 'Detail Tiket '.$tiket->kode_tiket;

        // Handle upload lampiran
        if ($this->input->post('upload_lampiran')) {
            $config = [
                'upload_path'   => './uploads/lampiran/',
                'allowed_types' => 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx',
                'max_size'      => 5120,
                'encrypt_name'  => TRUE,
            ];
            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $file = $this->upload->data();
                $this->M_penanganan->insert_lampiran([
                    'id_tiket'  => $id,
                    'id_user'   => $this->user['id_user'],
                    'nama_file' => $file['client_name'],
                    'path_file' => 'uploads/lampiran/'.$file['file_name'],
                ]);
                $this->session->set_flashdata('success', 'Lampiran berhasil diupload');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
            redirect('tiket/detail/'.$id);
        }

        $this->render('tiket/detail', $data);
    }

    public function verifikasi($id) {
        if ($this->user['nama_role'] != 'Admin') show_error('Akses ditolak', 403);
        $this->M_tiket->update($id, ['id_status' => 2]);
        $this->session->set_flashdata('success', 'Tiket diverifikasi.');
        redirect('tiket/detail/'.$id);
    }

    public function tolak($id) {
        if ($this->user['nama_role'] != 'Admin') show_error('Akses ditolak', 403);
        $this->M_tiket->update($id, ['id_status' => 6]);
        $this->session->set_flashdata('success', 'Tiket ditolak.');
        redirect('tiket/detail/'.$id);
    }
}