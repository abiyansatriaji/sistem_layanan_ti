<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $user;
    protected $allowed_roles = [];

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->user = [
            'id_user'   => $this->session->userdata('id_user'),
            'nama'      => $this->session->userdata('nama'),
            'username'  => $this->session->userdata('username'),
            'id_role'   => $this->session->userdata('id_role'),
            'nama_role' => $this->session->userdata('nama_role'),
            'id_unit'   => $this->session->userdata('id_unit'),
            'nama_unit' => $this->session->userdata('nama_unit'),
        ];

        if (!empty($this->allowed_roles) &&
            !in_array($this->user['nama_role'], $this->allowed_roles)) {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403);
        }
    }

    protected function render($view, $data = []) {
        $data['user'] = $this->user;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('templates/footer', $data);
    }
}