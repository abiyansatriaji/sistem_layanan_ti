<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'form_validation']);
        $this->load->database();
        
        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }
        
        // Cek role Super Admin (hanya Super Admin yang bisa akses)
        if ($this->session->userdata('role_id') != 1) {
            redirect('index.php/dashboard');
        }
    }

    // ============================================================
    // HALAMAN UTAMA KELOLA USER
    // ============================================================
    public function index() {
        $data['title'] = 'Kelola User';
        $data['users'] = $this->User_model->get_all_users();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // TAMBAH USER
    // ============================================================
  public function tambah() {
    $data['title'] = 'Tambah User';
    $this->db->distinct();
    $this->db->where_in('id', [1,2,3,4]);
    $this->db->order_by('id', 'ASC');
    $data['roles'] = $this->db->get('roles')->result();
        
        // Ambil bagian
        $data['bagian'] = $this->db->get('bagian')->result();
        
        // Jika form disubmit
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('role_id', 'Role', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $data_user = array(
                    'nama'      => $this->input->post('nama'),
                    'username'  => $this->input->post('username'),
                    'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'role_id'   => $this->input->post('role_id'),
                    'status'    => 'aktif',
                    'created_at'=> date('Y-m-d H:i:s')
                );
                
                if ($this->User_model->insert_user($data_user)) {
                    catat_log("Menambahkan user '" . $data_user['username'] . "'", 'user', $this->db->insert_id());
                    $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
                    redirect('index.php/user');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan user!');
                }
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('user/tambah', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // EDIT USER
    // ============================================================
   public function edit($id) {
    $data['title'] = 'Edit User';
    $data['user'] = $this->User_model->get_user_by_id($id);
    $data['roles'] = $this->User_model->get_all_roles();
    $data['bagian'] = $this->User_model->get_all_bagian(); // <-- PASTIKAN INI

    if (empty($data['user'])) {
        $this->session->set_flashdata('error', 'User tidak ditemukan!');
        redirect('index.php/user');
    }
        
        // Jika form disubmit
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('role_id', 'Role', 'required');
            
            // Cek username unik (kecuali username sendiri)
            $username = $this->input->post('username');
            if ($username != $data['user']->username) {
                $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            } else {
                $this->form_validation->set_rules('username', 'Username', 'required');
            }
            
            if ($this->form_validation->run() == TRUE) {
                $data_user = array(
                    'nama'      => $this->input->post('nama'),
                    'username'  => $this->input->post('username'),
                    'role_id'   => $this->input->post('role_id')
                );
                
                // Jika password diisi, update password
                $password = $this->input->post('password');
                if (!empty($password)) {
                    $data_user['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
                
                if ($this->User_model->update_user($id, $data_user)) {
                    catat_log("Mengubah data user '" . $data_user['username'] . "' (ID " . $id . ")", 'user', $id);
                    $this->session->set_flashdata('success', 'User berhasil diperbarui!');
                    redirect('index.php/user');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui user!');
                }
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('user/edit', $data);
        $this->load->view('templates/footer');
    }

    // ============================================================
    // NONAKTIFKAN USER
    // ============================================================
    public function nonaktifkan($id) {
        // Cek jangan sampai menonaktifkan diri sendiri
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Tidak bisa menonaktifkan akun sendiri!');
            redirect('index.php/user');
        }
        
        if ($this->User_model->update_user($id, array('status' => 'nonaktif'))) {
            catat_log('Menonaktifkan user ID ' . $id, 'user', $id);
            $this->session->set_flashdata('success', 'User berhasil dinonaktifkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menonaktifkan user!');
        }
        redirect('index.php/user');
    }

    // ============================================================
    // AKTIFKAN USER
    // ============================================================
    public function aktifkan($id) {
        if ($this->User_model->update_user($id, array('status' => 'aktif'))) {
            catat_log('Mengaktifkan user ID ' . $id, 'user', $id);
            $this->session->set_flashdata('success', 'User berhasil diaktifkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengaktifkan user!');
        }
        redirect('index.php/user');
    }

    // ============================================================
    // HAPUS USER
    // ============================================================
    public function hapus($id) {
        // Cek jangan sampai menghapus diri sendiri
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus akun sendiri!');
            redirect('index.php/user');
        }
        
        if ($this->User_model->delete_user($id)) {
            catat_log('Menghapus user ID ' . $id, 'user', $id);
            $this->session->set_flashdata('success', 'User berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user!');
        }
        redirect('index.php/user');
    }

    public function simpan() {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
            return;
        }

        $data = array(
            'nama'       => $this->input->post('nama'),
            'username'   => $this->input->post('username'),
            'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT), // <-- PERBAIKAN
            'email'      => $this->input->post('email'),
            'role_id'    => $this->input->post('role_id'),
            'bagian_id'  => $this->input->post('bagian_id') ?: NULL,
            'jabatan'    => $this->input->post('jabatan'),
            'status'     => 'aktif'
        );

        $this->User_model->insert_user($data);
        catat_log("Menambahkan user '" . $data['username'] . "'", 'user', $this->db->insert_id());
        $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
        redirect('index.php/user');
    }

public function update($id) {
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('role_id', 'Role', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->edit($id);
        return;
    }

    $data = array(
        'nama'       => $this->input->post('nama'),
        'username'   => $this->input->post('username'),
        'role_id'    => $this->input->post('role_id'),
        'bagian_id'  => $this->input->post('bagian_id') ?: NULL,
        'jabatan'    => $this->input->post('jabatan')
    );

    // Jika password diisi, update dengan hash
    $password = $this->input->post('password');
    if (!empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT); // <-- PERBAIKAN
    }

    $this->User_model->update_user($id, $data);
    catat_log("Mengubah data user '" . $data['username'] . "' (ID " . $id . ")", 'user', $id);
    $this->session->set_flashdata('success', 'User berhasil diupdate!');
    redirect('index.php/user');
}

// Callback untuk cek username unik (kecuali dirinya sendiri)
public function username_check($str, $id) {
    $this->db->where('username', $str);
    $this->db->where('id !=', $id);
    $query = $this->db->get('users');
    if ($query->num_rows() > 0) {
        $this->form_validation->set_message('username_check', 'Username sudah digunakan, silakan pilih yang lain.');
        return FALSE;
    }
    return TRUE;
}
}