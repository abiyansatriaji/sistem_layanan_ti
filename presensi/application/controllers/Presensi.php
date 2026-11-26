<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi extends MY_Controller {
    public function index() {
        $bulan = date('Y-m');
        $this->render('presensi/index', [
            'title' => 'Presensi', 'today' => $this->Presensi_model->today($this->user->id),
            'riwayat' => $this->Presensi_model->riwayat($this->user->id, $bulan), 'bulan' => $bulan,
            'batas' => substr($this->config->item('jam_masuk_batas'), 0, 5),
        ]);
    }

    public function masuk() {
        if ($this->input->method() !== 'post') redirect('presensi');
        if ($this->Presensi_model->masuk($this->user->id)) $this->session->set_flashdata('ok', 'Absen masuk berhasil dicatat.');
        else $this->session->set_flashdata('err', 'Anda sudah absen masuk hari ini.');
        redirect('presensi');
    }

    public function pulang() {
        if ($this->input->method() !== 'post') redirect('presensi');
        if ($this->Presensi_model->pulang($this->user->id)) $this->session->set_flashdata('ok', 'Absen pulang berhasil dicatat. Hati-hati di jalan!');
        else $this->session->set_flashdata('err', 'Belum absen masuk, atau sudah absen pulang.');
        redirect('presensi');
    }
}
