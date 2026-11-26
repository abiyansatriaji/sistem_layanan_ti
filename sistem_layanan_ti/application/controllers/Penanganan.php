<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penanganan extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['M_tiket','M_penanganan']);
        $this->allowed_roles = ['Teknisi'];
    }

    public function create($id_tiket) {
        $tiket = $this->M_tiket->get_by_id($id_tiket);
        
        // 1. Cek apakah tiket ada
        if (!$tiket) {
            $this->session->set_flashdata('error', 'Tiket tidak ditemukan.');
            redirect('tiket');
        }

        // 2. Cek apakah Teknisi yang login memang ditugaskan di tiket ini
        if ($this->user['nama_role'] == 'Teknisi') {
            $penugasan = $this->M_penanganan->penugasan_by_tiket($id_tiket);
            if (!$penugasan || $penugasan->id_teknisi != $this->user['id_user']) {
                $this->session->set_flashdata('error', 'Anda tidak ditugaskan untuk menangani tiket ini.');
                redirect('tiket');
            }
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('tindakan', 'Tindakan', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                // A. Simpan Riwayat Penanganan (Teks)
                $this->M_penanganan->insert_riwayat([
                    'id_tiket'    => $id_tiket,
                    'id_teknisi'  => $this->user['id_user'],
                    'tindakan'    => $this->input->post('tindakan', TRUE),
                    'catatan'     => $this->input->post('catatan', TRUE),
                ]);

                                // B. Logika Upload File Bukti (Jika Ada)
                if (!empty($_FILES['file_bukti']['name'])) {
                    $config['upload_path']   = './uploads/lampiran/';
                    // Perluas tipe file, tambahkan webp/gif untuk jaga-jaga
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp'; 
                    $config['max_size']      = 10240; // Naikkan jadi 10MB
                    $config['encrypt_name']  = TRUE; 
                    
                    // Tambahkan baris ini untuk mematikan pengecekan MIME yang terlalu ketat
                    $config['detect_mime']   = FALSE; 

                    // Buat folder otomatis jika belum ada
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, TRUE);
                    }

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file_bukti')) {
                        $file_data = $this->upload->data();
                        
                        $this->M_penanganan->insert_lampiran([
                            'id_tiket'  => $id_tiket,
                            'id_user'   => $this->user['id_user'],
                            'nama_file' => $file_data['client_name'], 
                            'path_file' => 'uploads/lampiran/' . $file_data['file_name'] 
                        ]);
                    } else {
                        // Tampilkan pesan error yang lebih jelas
                        $error_msg = $this->upload->display_errors('', '');
                        $this->session->set_flashdata('error', 'Gagal upload foto: ' . $error_msg . ' (Pastikan format benar & ukuran < 10MB)');
                    }
                }

                // C. Update Status Tiket menjadi Diproses (4)
                $this->M_tiket->update($id_tiket, ['id_status' => 4]); 
                
                $this->session->set_flashdata('success', 'Catatan penanganan berhasil disimpan.');
                redirect('tiket/detail/'.$id_tiket);
            }
        }

        $data['tiket'] = $tiket;
        $data['title'] = 'Catat Penanganan';
        $this->render('penanganan/form', $data);
    }

    public function selesai($id_tiket) {
        $tiket = $this->M_tiket->get_by_id($id_tiket);
        
        // 1. Cek apakah tiket ada
        if (!$tiket) {
            $this->session->set_flashdata('error', 'Tiket tidak ditemukan.');
            redirect('tiket');
        }

        // 2. Cek apakah status valid
        if (!in_array($tiket->id_status, [3, 4])) {
            $this->session->set_flashdata('error', 'Tiket tidak dapat diselesaikan karena statusnya belum sesuai.');
            redirect('tiket/detail/'.$id_tiket);
        }

        // 3. Cek apakah Teknisi berhak
        if ($this->user['nama_role'] == 'Teknisi') {
            $penugasan = $this->M_penanganan->penugasan_by_tiket($id_tiket);
            if (!$penugasan || $penugasan->id_teknisi != $this->user['id_user']) {
                $this->session->set_flashdata('error', 'Anda tidak berhak menyelesaikan tiket ini.');
                redirect('tiket/detail/'.$id_tiket);
            }
        }

        // 4. Update Status ke Selesai (5)
        $this->M_tiket->update($id_tiket, [
            'id_status'       => 5,
            'tanggal_selesai' => date('Y-m-d H:i:s'),
        ]);
        
        $this->session->set_flashdata('success', 'Tiket telah berhasil diselesaikan.');
        redirect('tiket/detail/'.$id_tiket);
    }
}