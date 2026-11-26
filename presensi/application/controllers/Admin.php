<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->restrict_to(self::ADMIN);
    }

    public function pegawai() {
        $this->render('admin/pegawai', ['title' => 'Data Pegawai', 'list' => $this->User_model->all(), 'atasan' => $this->User_model->atasan_list()]);
    }

    public function simpan() {
        if ($this->input->method() !== 'post') redirect('admin/pegawai');
        $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[100]');
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_dash|min_length[3]|is_unique[users.username]', ['is_unique' => 'Username sudah dipakai.']);
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[pegawai,atasan,admin_hr]');
        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('err', strip_tags(validation_errors(' ', ' ')));
            redirect('admin/pegawai');
        }
        $atasan = (int) $this->input->post('atasan_id');
        $this->User_model->create([
            'nama' => $this->input->post('nama', TRUE), 'nip' => $this->input->post('nip', TRUE),
            'jabatan' => $this->input->post('jabatan', TRUE), 'username' => $this->input->post('username', TRUE),
            'password' => password_hash((string) $this->input->post('password'), PASSWORD_DEFAULT),
            'role' => $this->input->post('role'), 'atasan_id' => $atasan ?: NULL,
        ]);
        $this->session->set_flashdata('ok', 'Pegawai baru ditambahkan.');
        redirect('admin/pegawai');
    }

    public function toggle($id = 0) {
        if ($this->input->method() === 'post' && (int) $id !== (int) $this->user->id) {
            $this->User_model->toggle((int) $id);
            $this->session->set_flashdata('ok', 'Status akun diperbarui.');
        }
        redirect('admin/pegawai');
    }

    public function libur() {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]|is_unique[hari_libur.tanggal]', ['is_unique' => 'Tanggal itu sudah terdaftar.']);
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|max_length[150]');
            if ($this->form_validation->run()) {
                $this->db->insert('hari_libur', ['tanggal' => $this->input->post('tanggal'), 'keterangan' => $this->input->post('keterangan', TRUE)]);
                $this->session->set_flashdata('ok', 'Hari libur ditambahkan.');
            } else {
                $this->session->set_flashdata('err', strip_tags(validation_errors(' ', ' ')));
            }
            redirect('admin/libur');
        }
        $this->render('admin/libur', ['title' => 'Hari Libur', 'list' => $this->db->order_by('tanggal', 'DESC')->get('hari_libur')->result()]);
    }

    public function hapus_libur($id = 0) {
        if ($this->input->method() === 'post') {
            $this->db->delete('hari_libur', ['id' => (int) $id]);
            $this->session->set_flashdata('ok', 'Hari libur dihapus.');
        }
        redirect('admin/libur');
    }

    public function rekap() {
        $bulan = $this->input->get('bulan');
        if (!preg_match('/^\d{4}-\d{2}$/', (string) $bulan)) $bulan = date('Y-m');
        $rows = $this->Presensi_model->rekap($bulan);
        if ($this->input->get('csv')) {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="rekap-presensi-' . $bulan . '.csv"');
            $o = fopen('php://output', 'w');
            fwrite($o, "\xEF\xBB\xBF");
            fputcsv($o, ['Nama', 'NIP', 'Jabatan', 'Hadir', 'Terlambat', 'Hari Cuti Disetujui']);
            foreach ($rows as $r) fputcsv($o, [$r->nama, $r->nip, $r->jabatan, $r->hadir, $r->terlambat, $r->cuti]);
            fclose($o);
            return;
        }
        $this->render('admin/rekap', ['title' => 'Rekap Laporan', 'rows' => $rows, 'bulan' => $bulan]);
    }
}
