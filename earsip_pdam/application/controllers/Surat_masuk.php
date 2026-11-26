<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_masuk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['M_surat_masuk', 'M_klasifikasi']);
        $this->load->helper(['form', 'url', 'nomor']);
        $this->load->library(['session', 'form_validation', 'upload']);
        
        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }
        
        // Hanya Admin & Super Admin yang bisa akses (role_id 1 dan 2)
        $role = $this->session->userdata('role_id');
        if (!in_array($role, [1,2])) {
            redirect('index.php/dashboard');
        }
    }


// CETAK PDF SURAT MASUK
// ============================================================
public function cetak() {
    $data['title'] = 'Buku Agenda Surat Masuk';
    // get_agenda() = data surat masuk + kode klasifikasi + penerima disposisi (kolom Kepada)
    $data['surat_masuk'] = $this->M_surat_masuk->get_agenda();
    $data['total'] = count($data['surat_masuk']);

    $this->load->view('surat_masuk/cetak', $data);
}

// ============================================================
// EXPORT EXCEL: BUKU AGENDA SURAT MASUK (.xlsx)
// ============================================================
public function export_excel() {
    if (!class_exists('ZipArchive')) {
        $this->session->set_flashdata('error', 'Ekspor Excel membutuhkan ekstensi PHP "zip". Aktifkan extension=zip di php.ini lalu restart Apache.');
        redirect('index.php/surat_masuk');
    }

    $this->load->helper('xlsx');

    $surat = $this->M_surat_masuk->get_agenda();
    $waktu = (new DateTime('now', new DateTimeZone('Asia/Jakarta')));

    $meta = [
        'instansi' => 'PERUMDA AIR MINUM TIRTA KHATULISTIWA',
        'judul'    => 'BUKU AGENDA SURAT MASUK',
        'info'     => 'Total surat: ' . count($surat) . '   |   Dicetak: ' . $waktu->format('d-m-Y H:i')
                      . ' WIB oleh ' . ($this->session->userdata('nama') ?: 'Guest')
    ];

    $file = xlsx_buat_buku_agenda($surat, $meta);
    if ($file === false) {
        $this->session->set_flashdata('error', 'Gagal membuat file Excel.');
        redirect('index.php/surat_masuk');
    }

    catat_log('Mengekspor buku agenda surat masuk ke Excel (' . count($surat) . ' surat)', 'surat_masuk');

    xlsx_kirim_unduhan($file, 'Buku_Agenda_Surat_Masuk_' . $waktu->format('Ymd_His') . '.xlsx');
}

// ============================================================
// EXPORT WORD: BUKU AGENDA SURAT MASUK (.docx)
// ============================================================
public function export_word() {
    if (!class_exists('ZipArchive')) {
        $this->session->set_flashdata('error', 'Ekspor Word membutuhkan ekstensi PHP "zip". Aktifkan extension=zip di php.ini lalu restart Apache.');
        redirect('index.php/surat_masuk');
    }

    $this->load->helper('docx');

    $surat = $this->M_surat_masuk->get_agenda();
    $waktu = (new DateTime('now', new DateTimeZone('Asia/Jakarta')));

    $meta = [
        'instansi' => 'Perumda Air Minum Tirta Khatulistiwa',
        'judul'    => 'Buku Agenda Surat Masuk',
        'total'    => count($surat),
        'dicetak'  => $waktu->format('d-m-Y H:i') . ' WIB oleh ' . ($this->session->userdata('nama') ?: 'Guest')
    ];

    $file = docx_buat_buku_agenda($surat, $meta);
    if ($file === false) {
        $this->session->set_flashdata('error', 'Gagal membuat file Word.');
        redirect('index.php/surat_masuk');
    }

    catat_log('Mengekspor buku agenda surat masuk ke Word (' . count($surat) . ' surat)', 'surat_masuk');

    docx_kirim_unduhan($file, 'Buku_Agenda_Surat_Masuk_' . $waktu->format('Ymd_His') . '.docx');
}

    // ============================================================
    // HALAMAN UTAMA SURAT MASUK
    // ============================================================
    public function index() {
        $data['title'] = 'Surat Masuk';
        $data['surat_masuk'] = $this->M_surat_masuk->get_all();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_masuk/index', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // TAMBAH SURAT MASUK - TAMPILKAN FORM
    // ============================================================
    public function tambah() {
        $data['title'] = 'Tambah Surat Masuk';
        $data['klasifikasi'] = $this->M_klasifikasi->get_all();
        $data['no_agenda'] = generate_no_agenda(); // auto generate
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_masuk/tambah', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // SIMPAN SURAT MASUK
    // ============================================================
    public function simpan() {
        $this->form_validation->set_rules('no_surat_asal', 'No Surat Asal', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('tgl_terima', 'Tanggal Terima', 'required');
        $this->form_validation->set_rules('pengirim', 'Pengirim', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
            return;
        }

        $data = array(
            'no_agenda'      => $this->input->post('no_agenda'),
            'no_surat_asal'  => $this->input->post('no_surat_asal'),
            'tgl_surat'      => $this->input->post('tgl_surat'),
            'tgl_terima'     => $this->input->post('tgl_terima'),
            'pengirim'       => $this->input->post('pengirim'),
            'perihal'        => $this->input->post('perihal'),
            'sifat_surat'    => $this->input->post('sifat_surat'),
            'klasifikasi_id' => $this->input->post('klasifikasi_id') ?: NULL,
            'created_by'     => $this->session->userdata('user_id'),
            'status'         => 'baru'
        );

        $surat_id = $this->M_surat_masuk->insert($data);
        catat_log('Menambahkan surat masuk No. Agenda ' . ($data['no_agenda'] ?? '-'), 'surat_masuk', $surat_id);

        // Upload lampiran
        if (!empty($_FILES['lampiran']['name'][0])) {
            $this->_upload_lampiran($surat_id, 'masuk');
        }

        $this->session->set_flashdata('success', 'Surat masuk berhasil ditambahkan!');
        redirect('index.php/surat_masuk');
    }

    // ============================================================
    // EDIT SURAT MASUK - TAMPILKAN FORM
    // ============================================================
    public function edit($id) {
        $data['title'] = 'Edit Surat Masuk';
        $data['surat'] = $this->M_surat_masuk->get_by_id($id);
        $data['klasifikasi'] = $this->M_klasifikasi->get_all();
        $data['lampiran'] = $this->M_surat_masuk->get_lampiran($id, 'masuk');

        if (empty($data['surat'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('index.php/surat_masuk');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_masuk/edit', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // UPDATE SURAT MASUK
    // ============================================================
    public function update($id) {
        $this->form_validation->set_rules('no_surat_asal', 'No Surat Asal', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('tgl_terima', 'Tanggal Terima', 'required');
        $this->form_validation->set_rules('pengirim', 'Pengirim', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        $data = array(
            'no_agenda'      => $this->input->post('no_agenda'), 
            'no_surat_asal'  => $this->input->post('no_surat_asal'),
            'tgl_surat'      => $this->input->post('tgl_surat'),
            'tgl_terima'     => $this->input->post('tgl_terima'),
            'pengirim'       => $this->input->post('pengirim'),
            'perihal'        => $this->input->post('perihal'),
            'sifat_surat'    => $this->input->post('sifat_surat'),
            'klasifikasi_id' => $this->input->post('klasifikasi_id') ?: NULL
        );

        $this->M_surat_masuk->update($id, $data);
        catat_log('Mengubah data surat masuk ID ' . $id, 'surat_masuk', $id);

        // Upload lampiran baru (jika ada)
        if (!empty($_FILES['lampiran']['name'][0])) {
            $this->_upload_lampiran($id, 'masuk');
        }

        $this->session->set_flashdata('success', 'Surat masuk berhasil diperbarui!');
        redirect('index.php/surat_masuk');
    }
    
    public function no_agenda_check($str, $id) {
        $this->db->where('no_agenda', $str);
        $this->db->where('id !=', $id);
        $query = $this->db->get('surat_masuk');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('no_agenda_check', 'No Agenda sudah digunakan, silakan pilih yang lain.');
            return FALSE;
        }
        return TRUE;
    }

    // ============================================================
    // HAPUS SURAT MASUK
    // ============================================================
    public function hapus($id) {
        // Hapus lampiran terlebih dahulu
        $lampiran = $this->M_surat_masuk->get_lampiran($id, 'masuk');
        foreach ($lampiran as $l) {
            if (file_exists('./' . $l->path_file)) {
                unlink('./' . $l->path_file);
            }
        }
        $this->M_surat_masuk->delete_lampiran_by_surat($id, 'masuk');
        
        $this->M_surat_masuk->delete($id);
        catat_log('Menghapus surat masuk ID ' . $id, 'surat_masuk', $id);
        $this->session->set_flashdata('success', 'Surat masuk berhasil dihapus!');
        redirect('index.php/surat_masuk');
    }

    // ============================================================
    // CARI SURAT MASUK
    // ============================================================
    public function cari() {
        $keyword = $this->input->post('keyword');
        $data['title'] = 'Hasil Pencarian Surat Masuk';
        $data['surat_masuk'] = $this->M_surat_masuk->search($keyword);
        $data['keyword'] = $keyword;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_masuk/index', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // DETAIL SURAT MASUK (DENGAN RIWAYAT DISPOSISI)
    // ============================================================
    public function detail($id) {
        $data['title'] = 'Detail Surat Masuk';
        $data['surat'] = $this->M_surat_masuk->get_by_id($id);
        $data['lampiran'] = $this->M_surat_masuk->get_lampiran($id, 'masuk');
        $data['disposisi'] = $this->M_surat_masuk->get_disposisi_by_surat($id);
        $data['users'] = $this->db->get('users')->result();

        if (empty($data['surat'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('index.php/surat_masuk');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_masuk/detail', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // HAPUS LAMPIRAN
    // ============================================================
    public function hapus_lampiran($id_lampiran, $id_surat) {
        $this->db->where('id', $id_lampiran);
        $lampiran = $this->db->get('lampiran_surat')->row();
        
        if (empty($lampiran)) {
            $this->session->set_flashdata('error', 'Lampiran tidak ditemukan!');
            redirect('index.php/surat_masuk/edit/' . $id_surat);
            return;
        }
        
        if (file_exists('./' . $lampiran->path_file)) {
            unlink('./' . $lampiran->path_file);
        }
        
        $this->db->where('id', $id_lampiran);
        $this->db->delete('lampiran_surat');
        
        $this->session->set_flashdata('success', 'Lampiran berhasil dihapus!');
        redirect('index.php/surat_masuk/edit/' . $id_surat);
    }

    // ============================================================
    // FUNGSI UPLOAD LAMPIRAN
    // ============================================================
    private function _upload_lampiran($surat_id, $tipe = 'masuk') {
        $config['upload_path']   = './uploads/' . $tipe . '/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|zip|rar';
        $config['max_size']      = 5120; // 5MB
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
                $this->M_surat_masuk->insert_lampiran([
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
    // ==================== DISPOSISI ============================
    // ============================================================

    /**
     * Form disposisi surat masuk
     * URL: surat_masuk/disposisi/{id}
     */
    public function disposisi($id) {
        $data['title'] = 'Disposisi Surat Masuk';
        $data['surat'] = $this->M_surat_masuk->get_by_id($id);
        $data['users'] = $this->db->get('users')->result();
        
        if (empty($data['surat'])) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan!');
            redirect('index.php/surat_masuk');
        }

        // Lampiran surat asal -- harus ikut tampil di form disposisi
        $data['lampiran'] = $this->M_surat_masuk->get_lampiran($id, 'masuk');
        // Riwayat disposisi berjenjang yang sudah ada sebelum form ini dibuka
        $data['riwayat'] = $this->M_surat_masuk->get_riwayat_tree($id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_masuk/disposisi', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Simpan disposisi
     * URL: surat_masuk/simpan_disposisi
     */
    public function simpan_disposisi() {
        $this->form_validation->set_rules('surat_masuk_id', 'Surat', 'required');
        $this->form_validation->set_rules('ke_user_id', 'Tujuan', 'required');
        $this->form_validation->set_rules('instruksi', 'Instruksi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $id = $this->input->post('surat_masuk_id');
            $this->disposisi($id);
            return;
        }

        $data = array(
            'surat_masuk_id' => $this->input->post('surat_masuk_id'),
            'parent_id'      => $this->input->post('parent_id') ?: NULL,
            'dari_user_id'   => $this->session->userdata('user_id'),
            'ke_user_id'     => $this->input->post('ke_user_id'),
            'instruksi'      => $this->input->post('instruksi'),
            'catatan'        => $this->input->post('catatan'),
            'status'         => 'terkirim'
        );

        $disposisi_id = $this->M_surat_masuk->insert_disposisi($data);
        catat_log('Mendisposisikan surat masuk ID ' . $data['surat_masuk_id'] . ' ke user ID ' . $data['ke_user_id'], 'disposisi', $disposisi_id);

        // Update status surat menjadi didisposisikan
        $this->db->where('id', $this->input->post('surat_masuk_id'));
        $this->db->update('surat_masuk', ['status' => 'didisposisikan']);

        $this->session->set_flashdata('success', 'Disposisi berhasil dikirim!');
        redirect('index.php/surat_masuk/detail/' . $this->input->post('surat_masuk_id'));
    }

    /**
     * Halaman daftar disposisi (untuk semua user)
     * URL: surat_masuk/disposisi_list
     */
    public function disposisi_list() {
        $data['title'] = 'Daftar Disposisi';
        
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('user_id');
        
        if (in_array($role_id, [1, 2])) {
            // Admin & Super Admin: lihat semua
            $data['disposisi'] = $this->M_surat_masuk->get_all_disposisi(50);
            $data['total'] = $this->M_surat_masuk->count_all_disposisi();
        } else {
            // User lain: hanya lihat yang ditujukan kepadanya
            $data['disposisi'] = $this->M_surat_masuk->get_disposisi_by_user($user_id, 50);
            $data['total'] = $this->M_surat_masuk->count_disposisi_by_user($user_id);
        }
        
        // Badge notifikasi untuk disposisi baru
        $data['notif_count'] = $this->M_surat_masuk->count_disposisi_by_user($user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('disposisi/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Update status disposisi (AJAX atau form)
     * URL: surat_masuk/update_status_disposisi/{id}
     */
    public function update_status_disposisi($id) {
        $status = $this->input->post('status');
        $catatan = $this->input->post('catatan');
        
        $disposisi = $this->M_surat_masuk->get_disposisi_by_id($id);
        
        if (empty($disposisi)) {
            $this->session->set_flashdata('error', 'Data disposisi tidak ditemukan!');
            redirect('index.php/surat_masuk/disposisi_list');
        }
        
        // Cek apakah user yang login adalah penerima disposisi
        if ($disposisi->ke_user_id != $this->session->userdata('user_id')) {
            // Jika bukan penerima, hanya admin yang bisa update
            $role = $this->session->userdata('role_id');
            if (!in_array($role, [1, 2])) {
                $this->session->set_flashdata('error', 'Anda tidak memiliki akses!');
                redirect('index.php/surat_masuk/disposisi_list');
            }
        }
        
        $this->M_surat_masuk->update_disposisi_status($id, $status, $catatan);
        catat_log('Mengubah status disposisi ID ' . $id . ' menjadi ' . $status, 'disposisi', $id);
        
        // Jika status selesai, update status surat menjadi selesai
        if ($status == 'selesai') {
            $this->db->where('id', $disposisi->surat_masuk_id);
            $this->db->update('surat_masuk', ['status' => 'selesai']);
        }
        
        $this->session->set_flashdata('success', 'Status disposisi berhasil diperbarui!');
        redirect('index.php/surat_masuk/disposisi_list');
    }

    /**
     * Form teruskan disposisi (berjenjang)
     * URL: surat_masuk/teruskan_disposisi/{id}
     */
    public function teruskan_disposisi($id) {
        $data['title'] = 'Teruskan Disposisi';
        $data['disposisi'] = $this->M_surat_masuk->get_disposisi_by_id($id);
        $data['users'] = $this->db->get('users')->result();
        
        if (empty($data['disposisi'])) {
            $this->session->set_flashdata('error', 'Data disposisi tidak ditemukan!');
            redirect('index.php/surat_masuk/disposisi_list');
        }

        $surat_masuk_id = $data['disposisi']->surat_masuk_id;
        $data['surat'] = $this->M_surat_masuk->get_by_id($surat_masuk_id);
        $data['lampiran'] = $this->M_surat_masuk->get_lampiran($surat_masuk_id, 'masuk');
        $data['riwayat'] = $this->M_surat_masuk->get_riwayat_tree($surat_masuk_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('disposisi/teruskan', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Simpan disposisi diteruskan (berjenjang)
     * URL: surat_masuk/simpan_teruskan
     */
    public function simpan_teruskan() {
        $this->form_validation->set_rules('surat_masuk_id', 'Surat', 'required');
        $this->form_validation->set_rules('ke_user_id', 'Tujuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $id = $this->input->post('parent_id');
            $this->teruskan_disposisi($id);
            return;
        }

        $data = array(
            'surat_masuk_id' => $this->input->post('surat_masuk_id'),
            'parent_id'      => $this->input->post('parent_id'),
            'dari_user_id'   => $this->session->userdata('user_id'),
            'ke_user_id'     => $this->input->post('ke_user_id'),
            'instruksi'      => $this->input->post('instruksi'),
            'catatan'        => $this->input->post('catatan'),
            'status'         => 'terkirim'
        );

        $disposisi_id = $this->M_surat_masuk->insert_disposisi($data);
        catat_log('Meneruskan disposisi ID ' . $data['parent_id'] . ' ke user ID ' . $data['ke_user_id'], 'disposisi', $disposisi_id);
        
        $this->session->set_flashdata('success', 'Disposisi berhasil diteruskan!');
        redirect('index.php/surat_masuk/disposisi_list');
    }

    /**
     * Hapus disposisi (hanya untuk admin)
     * URL: surat_masuk/hapus_disposisi/{id}
     */
    public function hapus_disposisi($id) {
        $role = $this->session->userdata('role_id');
        if (!in_array($role, [1, 2])) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses!');
            redirect('index.php/surat_masuk/disposisi_list');
        }
        
        $disposisi = $this->M_surat_masuk->get_disposisi_by_id($id);
        if (empty($disposisi)) {
            $this->session->set_flashdata('error', 'Data disposisi tidak ditemukan!');
            redirect('index.php/surat_masuk/disposisi_list');
        }
        
        $this->M_surat_masuk->delete_disposisi($id);
        catat_log('Menghapus disposisi ID ' . $id, 'disposisi', $id);
        $this->session->set_flashdata('success', 'Disposisi berhasil dihapus!');
        redirect('index.php/surat_masuk/disposisi_list');
    }
}