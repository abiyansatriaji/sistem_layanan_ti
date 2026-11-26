<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends MY_Controller {
    public function index() {
        $this->render('cuti/index', [
            'title' => 'Cuti & Izin', 'list' => $this->Cuti_model->by_user($this->user->id),
            'kuota' => $this->Cuti_model->kuota($this->user->id, date('Y')),
        ]);
    }

    public function ajukan() {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('jenis', 'Jenis', 'required|in_list[tahunan,sakit,izin]');
            $this->form_validation->set_rules('tgl_mulai', 'Tanggal mulai', 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]');
            $this->form_validation->set_rules('tgl_selesai', 'Tanggal selesai', 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]');
            $this->form_validation->set_rules('alasan', 'Alasan', 'required|min_length[5]');
            if (!$this->form_validation->run()) return $this->gagal(strip_tags(validation_errors(' ', ' ')));

            $a = $this->input->post('tgl_mulai');
            $b = $this->input->post('tgl_selesai');
            $jenis = $this->input->post('jenis');
            if ($b < $a) return $this->gagal('Tanggal selesai tidak boleh sebelum tanggal mulai.');
            if ((strtotime($b) - strtotime($a)) / 86400 > 90) return $this->gagal('Rentang maksimal 90 hari.');
            $hari = $this->Cuti_model->hitung_hari($a, $b);
            if ($hari < 1) return $this->gagal('Rentang tanggal tidak mengandung hari kerja.');
            if ($jenis === 'tahunan') {
                $k = $this->Cuti_model->kuota($this->user->id, date('Y', strtotime($a)));
                if ($k->total - $k->terpakai < $hari) return $this->gagal('Sisa kuota cuti tahunan tidak cukup (' . ($k->total - $k->terpakai) . ' hari).');
            }
            $file = NULL;
            if (!empty($_FILES['lampiran']['name'])) {
                $this->load->library('upload', ['upload_path' => FCPATH . 'uploads/', 'allowed_types' => 'pdf|jpg|jpeg|png', 'max_size' => 2048, 'encrypt_name' => TRUE]);
                if (!$this->upload->do_upload('lampiran')) return $this->gagal(strip_tags($this->upload->display_errors('', '')));
                $file = $this->upload->data('file_name');
            }
            $this->Cuti_model->ajukan([
                'user_id' => $this->user->id, 'jenis' => $jenis, 'tgl_mulai' => $a, 'tgl_selesai' => $b,
                'jumlah_hari' => $hari, 'alasan' => $this->input->post('alasan', TRUE), 'lampiran' => $file,
            ]);
            $this->session->set_flashdata('ok', "Pengajuan ($hari hari kerja) berhasil dikirim ke atasan.");
            redirect('cuti');
        }
        $this->render('cuti/ajukan', ['title' => 'Ajukan Cuti', 'kuota' => $this->Cuti_model->kuota($this->user->id, date('Y'))]);
    }

    private function gagal($msg) {
        $this->session->set_flashdata('err', $msg);
        redirect('cuti/ajukan');
    }

    public function batal($id = 0) {
        if ($this->input->method() !== 'post') redirect('cuti');
        $ok = $this->Cuti_model->batal((int) $id, $this->user->id);
        $this->session->set_flashdata($ok ? 'ok' : 'err', $ok ? 'Pengajuan dibatalkan.' : 'Pengajuan tidak bisa dibatalkan.');
        redirect('cuti');
    }

    public function approval() {
        $this->restrict_to('atasan');
        $this->render('cuti/approval', ['title' => 'Persetujuan Cuti', 'list' => $this->Cuti_model->pending_for($this->user->id)]);
    }

    public function proses($id = 0) {
        $this->restrict_to('atasan');
        if ($this->input->method() !== 'post') redirect('cuti/approval');
        $aksi = $this->input->post('aksi') === 'setuju' ? 'setuju' : 'tolak';
        $r = $this->Cuti_model->proses((int) $id, $aksi, $this->user->id, $this->input->post('catatan', TRUE));
        if ($r === TRUE) $this->session->set_flashdata('ok', $aksi === 'setuju' ? 'Pengajuan disetujui.' : 'Pengajuan ditolak.');
        else $this->session->set_flashdata('err', $r);
        redirect('cuti/approval');
    }
}
