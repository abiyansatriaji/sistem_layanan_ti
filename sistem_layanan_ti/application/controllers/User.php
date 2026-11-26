<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_user');
        $this->allowed_roles = ['Admin'];
    }

    public function index() {
        $data['users'] = $this->M_user->get_all();
        $data['title'] = 'Manajemen User';
        $this->render('user/index', $data);
    }

    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('nama','Nama','required');
            $this->form_validation->set_rules('username','Username','required|is_unique[users.username]');
            $this->form_validation->set_rules('password','Password','required|min_length[5]');
            $this->form_validation->set_rules('id_role','Role','required');
            $this->form_validation->set_rules('id_unit','Unit','required');
            if ($this->form_validation->run() == TRUE) {
                $this->M_user->insert($this->input->post(NULL, TRUE));
                $this->session->set_flashdata('success', 'User berhasil ditambahkan');
                redirect('user');
            }
        }
        $data['roles'] = $this->db->get('roles')->result();
        $data['units'] = $this->db->get('unit_kerja')->result();
        $data['title'] = 'Tambah User';
        $this->render('user/form', $data);
    }

    public function edit($id) {
        $user = $this->M_user->get_by_id($id);
        if (!$user) show_404();

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama','Nama','required');
            $this->form_validation->set_rules('id_role','Role','required');
            $this->form_validation->set_rules('id_unit','Unit','required');
            if ($this->form_validation->run() == TRUE) {
                $this->M_user->update($id, $this->input->post(NULL, TRUE));
                $this->session->set_flashdata('success', 'User diupdate');
                redirect('user');
            }
        }
        $data['user_edit'] = $user;
        $data['roles'] = $this->db->get('roles')->result();
        $data['units'] = $this->db->get('unit_kerja')->result();
        $data['title'] = 'Edit User';
        $this->render('user/form', $data);
    }

    public function delete($id) {
        if ($id == $this->user['id_user']) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri');
            redirect('user');
        }
        $this->M_user->delete($id);
        $this->session->set_flashdata('success', 'User dihapus');
        redirect('user');
    }
}