<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        if ($this->session->userdata('uid')) redirect('dashboard');
        if ($this->input->method() === 'post') {
            $u = $this->User_model->by_username(trim((string) $this->input->post('username', TRUE)));
            if ($u && $u->aktif && password_verify((string) $this->input->post('password'), $u->password)) {
                $this->session->sess_regenerate(TRUE);
                $this->session->set_userdata('uid', $u->id);
                redirect('dashboard');
            }
            $this->session->set_flashdata('err', 'Username atau password salah.');
            redirect('login');
        }
        $this->load->view('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
