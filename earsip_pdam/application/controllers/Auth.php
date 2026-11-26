<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_auth');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('index.php/dashboard');
        }
        $data['title'] = 'Login E-Arsip PDAM';
        $this->load->view('auth/login', $data);
    }

   public function login() {
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    if (empty($username) || empty($password)) {
        $this->session->set_flashdata('error', 'Username dan Password harus diisi!');
        redirect('index.php/auth');
        return;
    }

    // Gunakan method cek_login dari M_auth
    $user = $this->M_auth->cek_login($username, $password);

    if ($user) {
        $this->session->set_userdata([
            'user_id'   => $user->id,
            'username'  => $user->username,
            'nama'      => $user->nama,
            'role_id'   => $user->role_id,
            'role_name' => $user->nama_role,
            'bagian_id' => $user->bagian_id,
            'logged_in' => TRUE
        ]);
        catat_log('Login ke sistem', 'auth', null, $user->id);
        redirect('index.php/dashboard');
    } else {
        catat_log("Login gagal untuk username '" . $username . "'", 'auth');
        $this->session->set_flashdata('error', 'Username atau Password salah!');
        redirect('index.php/auth');
    }
}
    

    public function logout() {
        catat_log('Logout dari sistem', 'auth');
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Anda berhasil logout!');
        redirect('index.php/auth');
    }
}