<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['M_tiket','M_penanganan','M_user']);
        $this->allowed_roles = ['Admin'];
    }

    public function create($id_tiket) {
     $tiket = $this->M_tiket->get_by_id($id_tiket);
if (!$tiket) {
    $this->session->set_flashdata('error', 'Gagal: Tiket dengan ID ' . $id_tiket . ' tidak ditemukan di database.');
    redirect('tiket');
}

        if ($this->input->post()) {
            $this->form_validation->set_rules('id_teknisi', 'Teknisi', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->M_penanganan->insert_penugasan([
                    'id_tiket'          => $id_tiket,
                    'id_teknisi'        => $this->input->post('id_teknisi'),
                    'id_pemberi_tugas'  => $this->user['id_user'],
                    'catatan_penugasan' => $this->input->post('catatan_penugasan', TRUE),
                ]);
                $this->M_tiket->update($id_tiket, ['id_status' => 3]);
                $this->session->set_flashdata('success', 'Tiket berhasil ditugaskan.');
                redirect('tiket/detail/'.$id_tiket);
            }
        }

        $data['tiket']    = $tiket;
        $data['teknisi']  = $this->M_user->get_teknisi();
        $data['title']    = 'Tugaskan Tiket';
        $this->render('penugasan/form', $data);
    }
}