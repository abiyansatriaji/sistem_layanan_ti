<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_auth');
    }

    public function index() { $this->login(); }

    public function login() {
        if ($this->session->userdata('logged_in')) redirect('dashboard');

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $user = $this->M_auth->login(
                    $this->input->post('username', TRUE),
                    $this->input->post('password')
                );
                
                if ($user) {
                    $this->session->set_userdata([
                        'id_user'   => $user->id_user,
                        'nama'      => $user->nama,
                        'username'  => $user->username,
                        'id_role'   => $user->id_role,
                        'nama_role' => $user->nama_role,
                        'id_unit'   => $user->id_unit,
                        'nama_unit' => $user->nama_unit,
                        'logged_in' => TRUE
                    ]);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Username/password salah atau akun tidak aktif.');
                    redirect('auth/login');
                }
            }
        }
        $this->load->view('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}