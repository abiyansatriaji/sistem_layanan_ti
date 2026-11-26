<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disposisi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_surat_masuk');
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'form_validation']);
        
        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }
    }

    // ===== HALAMAN DAFTAR DISPOSISI (FR-10) =====
    public function index() {
        $data['title'] = 'Daftar Disposisi';
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('user_id');
        
        if (in_array($role_id, [1, 2])) {
            $data['disposisi'] = $this->M_surat_masuk->get_all_disposisi(50);
        } else {
            $data['disposisi'] = $this->M_surat_masuk->get_disposisi_by_user($user_id, 50);
        }
        
        $data['notif_count'] = $this->M_surat_masuk->count_disposisi_by_user($user_id);
        $data['role_id'] = $role_id;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('disposisi/index', $data);
        $this->load->view('templates/footer');
    }

    // ===== FORM DISPOSISI (FR-07) =====
    public function form($surat_id) {
        $role_id = $this->session->userdata('role_id');
        if (!in_array($role_id, [1, 2])) {
            $this->session->set_flashdata('error', 'Akses ditolak!');
            redirect('index.php/disposisi');
        }
        
        $data['title'] = 'Disposisi Surat Masuk';
        $data['surat'] = $this->M_surat_masuk->get_by_id($surat_id);
        $data['users'] = $this->db->get('users')->result();
        
        if (empty($data['surat'])) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan!');
            redirect('index.php/surat_masuk');
        }

        // Lampiran surat asal -- ikut ditampilkan di setiap tahap disposisi
        $data['lampiran'] = $this->M_surat_masuk->get_lampiran($surat_id, 'masuk');
        // Riwayat disposisi berjenjang yang sudah ada sebelum form ini dibuka
        $data['riwayat'] = $this->M_surat_masuk->get_riwayat_tree($surat_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_masuk/disposisi', $data);
        $this->load->view('templates/footer');
    }

    // ===== SIMPAN DISPOSISI =====
    public function simpan() {
        $role_id = $this->session->userdata('role_id');
        if (!in_array($role_id, [1, 2])) {
            $this->session->set_flashdata('error', 'Akses ditolak!');
            redirect('index.php/disposisi');
        }
        
        $this->form_validation->set_rules('surat_masuk_id', 'Surat', 'required');
        $this->form_validation->set_rules('ke_user_id', 'Tujuan', 'required');
        $this->form_validation->set_rules('instruksi', 'Instruksi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $id = $this->input->post('surat_masuk_id');
            $this->form($id);
            return;
        }

        $data = [
            'surat_masuk_id' => $this->input->post('surat_masuk_id'),
            'parent_id'      => $this->input->post('parent_id') ?: NULL,
            'dari_user_id'   => $this->session->userdata('user_id'),
            'ke_user_id'     => $this->input->post('ke_user_id'),
            'instruksi'      => $this->input->post('instruksi'),
            'catatan'        => $this->input->post('catatan'),
            'status'         => 'terkirim'
        ];

        $disposisi_id = $this->M_surat_masuk->insert_disposisi($data);
        catat_log('Mendisposisikan surat masuk ID ' . $data['surat_masuk_id'] . ' ke user ID ' . $data['ke_user_id'], 'disposisi', $disposisi_id);

        $this->db->where('id', $this->input->post('surat_masuk_id'));
        $this->db->update('surat_masuk', ['status' => 'didisposisikan']);

        $this->session->set_flashdata('success', 'Disposisi berhasil dikirim!');
        redirect('index.php/surat_masuk/detail/' . $this->input->post('surat_masuk_id'));
    }

    // ===== UPDATE STATUS DISPOSISI (FR-11) =====
    public function update_status($id) {
        $status = $this->input->post('status');
        $catatan = $this->input->post('catatan');
        
        $disposisi = $this->M_surat_masuk->get_disposisi_by_id($id);
        
        if (empty($disposisi)) {
            $this->session->set_flashdata('error', 'Data disposisi tidak ditemukan!');
            redirect('index.php/disposisi');
        }
        
        $user_id = $this->session->userdata('user_id');
        $role_id = $this->session->userdata('role_id');
        
        if ($disposisi->ke_user_id != $user_id && !in_array($role_id, [1, 2,3])) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses!');
            redirect('index.php/disposisi');
        }
        
        $this->M_surat_masuk->update_disposisi_status($id, $status, $catatan);
        catat_log('Mengubah status disposisi ID ' . $id . ' menjadi ' . $status, 'disposisi', $id);
        
        if ($status == 'selesai') {
            $this->db->where('id', $disposisi->surat_masuk_id);
            $this->db->update('surat_masuk', ['status' => 'selesai']);
        }
        
        $this->session->set_flashdata('success', 'Status disposisi berhasil diperbarui!');
        redirect('index.php/disposisi');
    }

    // ===== FORM TERUSKAN DISPOSISI (FR-12) =====
    public function teruskan($id) {
        $data['title'] = 'Teruskan Disposisi';
        $data['disposisi'] = $this->M_surat_masuk->get_disposisi_by_id($id);
        $data['users'] = $this->db->get('users')->result();
        
        if (empty($data['disposisi'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('index.php/disposisi');
        }

        // Boleh meneruskan jika: admin/super admin/pimpinan (role 1,2,3),
        // ATAU dia sendiri penerima disposisi ini -- siapapun rolenya (termasuk staff)
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('user_id');
        $is_penerima = ($data['disposisi']->ke_user_id == $user_id);

        if (!in_array($role_id, [1, 2, 3]) && !$is_penerima) {
            $this->session->set_flashdata('error', 'Akses ditolak!');
            redirect('index.php/disposisi');
        }

        if ($data['disposisi']->status == 'selesai') {
            $this->session->set_flashdata('error', 'Disposisi yang sudah selesai tidak dapat diteruskan lagi!');
            redirect('index.php/disposisi');
        }

        $surat_masuk_id = $data['disposisi']->surat_masuk_id;

        // Surat asal + lampirannya -- harus tetap ikut terlihat walau sudah
        // diteruskan berkali-kali ke tingkat berikutnya
        $data['surat'] = $this->M_surat_masuk->get_by_id($surat_masuk_id);
        $data['lampiran'] = $this->M_surat_masuk->get_lampiran($surat_masuk_id, 'masuk');

        // Riwayat lengkap seluruh rantai disposisi sampai titik ini
        $data['riwayat'] = $this->M_surat_masuk->get_riwayat_tree($surat_masuk_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('disposisi/teruskan', $data);
        $this->load->view('templates/footer');
    }

   public function simpan_teruskan() {
    $this->form_validation->set_rules('surat_masuk_id', 'Surat', 'required');
    $this->form_validation->set_rules('ke_user_id', 'Tujuan', 'required');

    if ($this->form_validation->run() == FALSE) {
        $id = $this->input->post('parent_id');
        $this->teruskan($id);
        return;
    }

    $ke_user_id = $this->input->post('ke_user_id');
    
    // Cek apakah ke_user_id valid
    $user = $this->db->get_where('users', ['id' => $ke_user_id])->row();
    if (!$user) {
        $this->session->set_flashdata('error', 'User tujuan tidak ditemukan!');
        redirect('index.php/disposisi/teruskan/' . $this->input->post('parent_id'));
    }

    $data = array(
        'surat_masuk_id' => $this->input->post('surat_masuk_id'),
        'parent_id'      => $this->input->post('parent_id'),
        'dari_user_id'   => $this->session->userdata('user_id'),
        'ke_user_id'     => $ke_user_id,
        'instruksi'      => $this->input->post('instruksi') ?: $this->input->post('instruksi_tambahan'),
        'catatan'        => $this->input->post('catatan'),
        'status'         => 'terkirim'
    );

    // Debug: cek data sebelum insert (hapus setelah selesai)
    // var_dump($data); exit;

    $disposisi_id = $this->M_surat_masuk->insert_disposisi($data);
    catat_log('Meneruskan disposisi ID ' . $data['parent_id'] . ' ke ' . $user->nama, 'disposisi', $disposisi_id);
    $this->session->set_flashdata('success', 'Disposisi berhasil diteruskan ke ' . $user->nama . '!');
    redirect('index.php/disposisi');
}
    // ===== CETAK LEMBAR DISPOSISI (SELURUH RANTAI DALAM SATU LEMBAR) =====
    // Dipanggil dari tombol cetak per disposisi: yang dicetak tetap seluruh
    // perjalanan surat tersebut, bukan hanya satu langkah.
    public function cetak($id) {
        $disposisi = $this->M_surat_masuk->get_disposisi_by_id($id);

        if (empty($disposisi)) {
            $this->session->set_flashdata('error', 'Data disposisi tidak ditemukan!');
            redirect('index.php/disposisi');
        }

        $this->_tampil_cetak($disposisi->surat_masuk_id);
    }

    // Cetak langsung berdasarkan ID surat masuk (dipakai tombol di halaman riwayat)
    public function cetak_surat($surat_masuk_id) {
        $this->_tampil_cetak($surat_masuk_id);
    }

    private function _tampil_cetak($surat_masuk_id) {
        $surat = $this->M_surat_masuk->get_by_id($surat_masuk_id);

        if (empty($surat)) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan!');
            redirect('index.php/disposisi');
        }

        $data['surat']    = $surat;
        $data['lampiran'] = $this->M_surat_masuk->get_lampiran($surat_masuk_id, 'masuk');
        $data['riwayat']  = $this->M_surat_masuk->get_riwayat_tree($surat_masuk_id);

        $ids = array_map(function ($r) { return $r->id; }, $data['riwayat']);
        $data['status_log'] = $this->M_surat_masuk->get_status_log_by_disposisi($ids);

        // View cetak polos, tanpa header/sidebar aplikasi
        $this->load->view('disposisi/cetak', $data);
    }

    // ===== RIWAYAT DISPOSISI BERJENJANG (FULL CHAIN) + LAMPIRAN =====
    public function riwayat($surat_masuk_id) {
        $data['title'] = 'Riwayat Disposisi';
        $data['surat'] = $this->M_surat_masuk->get_by_id($surat_masuk_id);

        if (empty($data['surat'])) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan!');
            redirect('index.php/surat_masuk');
        }

        $data['lampiran'] = $this->M_surat_masuk->get_lampiran($surat_masuk_id, 'masuk');
        $data['riwayat'] = $this->M_surat_masuk->get_riwayat_tree($surat_masuk_id);

        // Riwayat perubahan status tiap langkah (dari log aktivitas)
        $ids = array_map(function ($r) { return $r->id; }, $data['riwayat']);
        $data['status_log'] = $this->M_surat_masuk->get_status_log_by_disposisi($ids);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('disposisi/riwayat', $data);
        $this->load->view('templates/footer');
    }

    // ===== HAPUS DISPOSISI =====
    public function hapus($id) {
        $role_id = $this->session->userdata('role_id');
        if (!in_array($role_id, [1, 2,3])) {
            $this->session->set_flashdata('error', 'Akses ditolak!');
            redirect('index.php/disposisi');
        }
        
        $disposisi = $this->M_surat_masuk->get_disposisi_by_id($id);
        if (empty($disposisi)) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('index.php/disposisi');
        }
        
        $this->M_surat_masuk->delete_disposisi($id);
        catat_log('Menghapus disposisi ID ' . $id, 'disposisi', $id);
        $this->session->set_flashdata('success', 'Disposisi berhasil dihapus!');
        redirect('index.php/disposisi');
    }
}