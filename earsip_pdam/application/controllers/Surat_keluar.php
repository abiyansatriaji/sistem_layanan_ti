<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_keluar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('M_surat_keluar');
        $this->load->model('M_klasifikasi');
        $this->load->model('M_bagian');
        
        $this->load->helper(['form', 'url', 'nomor']);
        $this->load->library(['session', 'form_validation', 'upload']);
        
        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }
        
        $role = $this->session->userdata('role_id');
        if (!in_array($role, [1, 2])) {
            redirect('index.php/dashboard');
        }
    }

    // ============================================================
    // HALAMAN UTAMA
    // ============================================================
    public function index() {
        $data['title'] = 'Surat Keluar';
        $data['surat_keluar'] = $this->M_surat_keluar->get_all();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('surat_keluar/index', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // TAMBAH SURAT KELUAR
    // ============================================================
    public function tambah() {
        $data['title'] = 'Tambah Surat Keluar';
        // PREVIEW saja, tidak menaikkan nomor sesungguhnya.
        // Nomor final baru digenerate saat data disimpan (lihat simpan()).
        $data['no_surat'] = peek_no_surat_keluar('UM');
        $data['klasifikasi'] = $this->M_klasifikasi->get_all();
        $data['bagian'] = $this->M_bagian->get_all();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_keluar/tambah', $data);
        $this->load->view('templates/footer');
    }

    // ===== GENERATE NO SURAT VIA AJAX =====
    public function generate_no() {
        $kode = $this->input->get('kode') ?? 'UM';
        $this->load->helper('nomor');
        // PREVIEW saja untuk ditampilkan di form. Nomor sesungguhnya
        // baru digenerate & dikunci saat surat benar-benar disimpan.
        echo peek_no_surat_keluar($kode);
    }

    // ============================================================
    // SIMPAN SURAT KELUAR
    // ============================================================
    public function simpan() {
        // no_surat TIDAK divalidasi/diterima dari form lagi -- selalu
        // digenerate oleh sistem di bawah, supaya tidak bisa diubah manual
        // dan tidak pernah dobel.
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
            return;
        }

        $klasifikasi_id = $this->input->post('klasifikasi_id') ?: NULL;

        $kode = 'UM';
        if ($klasifikasi_id) {
            $k = $this->db->get_where('klasifikasi_surat', ['id' => $klasifikasi_id])->row();
            $kode = $k->kode_klasifikasi ?? 'UM';
        }

        // Generate nomor surat yang SESUNGGUHNYA (atomic, anti-dobel).
        // Ini satu-satunya tempat nomor final ditentukan.
        $no_surat = generate_no_surat_keluar($kode);

        $data = array(
            'no_surat'       => $no_surat,
            'tgl_surat'      => $this->input->post('tgl_surat'),
            'tujuan'         => $this->input->post('tujuan'),
            'perihal'        => $this->input->post('perihal'),
            'klasifikasi_id' => $klasifikasi_id,
            'bagian_id'      => $this->input->post('bagian_id') ?: NULL,
            'status'         => $this->input->post('status') ?: 'draft',
            'created_by'     => $this->session->userdata('user_id')
        );

        $surat_id = $this->M_surat_keluar->insert($data);
        catat_log('Menambahkan surat keluar No. Surat ' . $no_surat, 'surat_keluar', $surat_id);

        if (!empty($_FILES['lampiran']['name'][0])) {
            $this->_upload_lampiran($surat_id, 'keluar');
        }

        $this->session->set_flashdata('success', 'Surat keluar berhasil ditambahkan! No. Surat: ' . $no_surat);
        redirect('index.php/surat_keluar');
    }

    // ============================================================
    // EDIT SURAT KELUAR
    // ============================================================
    public function edit($id) {
        $data['title'] = 'Edit Surat Keluar';
        $data['surat'] = $this->M_surat_keluar->get_by_id($id);
        $data['klasifikasi'] = $this->M_klasifikasi->get_all();
        $data['bagian'] = $this->M_bagian->get_all();
        $data['lampiran'] = $this->M_surat_keluar->get_lampiran($id, 'keluar');

        if (empty($data['surat'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('index.php/surat_keluar');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('surat_keluar/edit', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // UPDATE SURAT KELUAR
    // ============================================================
    public function update($id) {
        // no_surat sengaja TIDAK diedit di sini -- nomor surat bersifat
        // tetap sejak pertama kali dibuat oleh sistem.
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        $data = array(
            'tgl_surat'      => $this->input->post('tgl_surat'),
            'tujuan'         => $this->input->post('tujuan'),
            'perihal'        => $this->input->post('perihal'),
            'klasifikasi_id' => $this->input->post('klasifikasi_id') ?: NULL,
            'bagian_id'      => $this->input->post('bagian_id') ?: NULL,
            'status'         => $this->input->post('status')
        );

        $this->M_surat_keluar->update($id, $data);
        catat_log('Mengubah data surat keluar ID ' . $id, 'surat_keluar', $id);

        if (!empty($_FILES['lampiran']['name'][0])) {
            $this->_upload_lampiran($id, 'keluar');
        }

        $this->session->set_flashdata('success', 'Surat keluar berhasil diperbarui!');
        redirect('index.php/surat_keluar');
    }

    // ============================================================
    // HAPUS SURAT KELUAR
    // ============================================================
    public function hapus($id) {
        $lampiran = $this->M_surat_keluar->get_lampiran($id, 'keluar');
        foreach ($lampiran as $l) {
            if (file_exists('./' . $l->path_file)) {
                unlink('./' . $l->path_file);
            }
        }
        $this->M_surat_keluar->delete_lampiran_by_surat($id, 'keluar');
        $this->M_surat_keluar->delete($id);
        catat_log('Menghapus surat keluar ID ' . $id, 'surat_keluar', $id);
        $this->session->set_flashdata('success', 'Surat keluar berhasil dihapus!');
        redirect('index.php/surat_keluar');
    }

    // ============================================================
    // CARI SURAT KELUAR
    // ============================================================
    public function cari() {
        $keyword = $this->input->post('keyword');
        $data['title'] = 'Hasil Pencarian Surat Keluar';
        $data['surat_keluar'] = $this->M_surat_keluar->search($keyword);
        $data['keyword'] = $keyword;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('surat_keluar/index', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // DETAIL SURAT KELUAR
    // ============================================================
    public function detail($id) {
        $data['title'] = 'Detail Surat Keluar';
        $data['surat'] = $this->M_surat_keluar->get_by_id($id);
        $data['lampiran'] = $this->M_surat_keluar->get_lampiran($id, 'keluar');

        if (empty($data['surat'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('index.php/surat_keluar');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('surat_keluar/detail', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // HAPUS LAMPIRAN
    // ============================================================
    public function hapus_lampiran($id, $surat_id) {
        $lampiran = $this->M_surat_keluar->get_lampiran($id, 'keluar');
        if (!empty($lampiran)) {
            foreach ($lampiran as $l) {
                if (file_exists('./' . $l->path_file)) {
                    unlink('./' . $l->path_file);
                }
            }
            $this->M_surat_keluar->delete_lampiran_by_surat($id, 'keluar');
            $this->session->set_flashdata('success', 'Lampiran berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada lampiran!');
        }
        redirect('index.php/surat_keluar/edit/' . $surat_id);
    }

    // ============================================================
    // UPLOAD LAMPIRAN
    // ============================================================
    private function _upload_lampiran($surat_id, $tipe = 'keluar') {
        $config['upload_path']   = './uploads/' . $tipe . '/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|zip|rar';
        $config['max_size']      = 5120;
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->upload->initialize($config);

        $files = $_FILES['lampiran'];
        $count = count($files['name']);

        for ($i = 0; $i < $count; $i++) {
            $_FILES['file'] = [
                'name'     => $files['name'][$i],
                'type'     => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error'    => $files['error'][$i],
                'size'     => $files['size'][$i]
            ];

            if ($this->upload->do_upload('file')) {
                $upload_data = $this->upload->data();
                $this->M_surat_keluar->insert_lampiran([
                    'surat_tipe'  => $tipe,
                    'surat_id'    => $surat_id,
                    'nama_file'   => $upload_data['orig_name'],
                    'path_file'   => 'uploads/' . $tipe . '/' . $upload_data['file_name'],
                    'ukuran_kb'   => round($upload_data['file_size'], 2),
                    'uploaded_by' => $this->session->userdata('user_id')
                ]);
            }
        }
    }

    // ============================================================
    // CETAK SEMUA SURAT KELUAR (DAFTAR)
    // ============================================================
    public function cetak_semua() {
        $data['title'] = 'Buku Agenda Surat Keluar';
        $data['surat_keluar'] = $this->M_surat_keluar->get_agenda();
        $data['total'] = count($data['surat_keluar']);
        $this->load->view('surat_keluar/cetak_semua', $data);
    }
    

}