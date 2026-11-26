<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    const ADMIN = ['super_admin', 'admin_hr'];
    protected $user;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('uid')) redirect('login');
        $this->load->model(['User_model', 'Presensi_model', 'Cuti_model']);
        $this->user = $this->User_model->find($this->session->userdata('uid'));
        if (!$this->user || !$this->user->aktif) {
            $this->session->sess_destroy();
            redirect('login');
        }
    }

    protected function is_admin() { return in_array($this->user->role, self::ADMIN); }

    protected function restrict_to($roles) {
        if (!in_array($this->user->role, (array) $roles)) {
            show_error('Anda tidak berhak mengakses halaman ini.', 403, 'Akses Ditolak');
        }
    }

    protected function render($view, $data = []) {
        $data['user'] = $this->user;
        $data['pending'] = $this->user->role === 'atasan' ? $this->Cuti_model->count_pending($this->user->id) : 0;
        $this->load->view('layout/header', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/footer');
    }
}
