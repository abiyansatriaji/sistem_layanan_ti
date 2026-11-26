<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // ============================================================
    // GET ALL USERS
    // ============================================================
    public function get_all_users() {
        $this->db->select('users.*, roles.nama_role');
        $this->db->from('users');
        $this->db->join('roles', 'users.role_id = roles.id', 'left');
        $this->db->order_by('users.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // ============================================================
    // GET USER BY ID
    // ============================================================
    public function get_user_by_id($id) {
        $this->db->select('users.*, roles.nama_role');
        $this->db->from('users');
        $this->db->join('roles', 'users.role_id = roles.id', 'left');
        $this->db->where('users.id', $id);
        return $this->db->get()->row();
    }

    // ============================================================
    // GET ALL ROLES
    // ============================================================
    public function get_all_roles() {
        return $this->db->get('roles')->result();
    }

    // ============================================================
    // GET ALL BAGIAN <-- TAMBAHKAN INI
    // ============================================================
    public function get_all_bagian() {
        return $this->db->get('bagian')->result();
    }

    // ============================================================
    // INSERT USER
    // ============================================================
    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    // ============================================================
    // UPDATE USER
    // ============================================================
    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    // ============================================================
    // DELETE USER
    // ============================================================
    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    // ============================================================
    // HITUNG USER AKTIF
    // ============================================================
    public function count_active_users() {
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results('users');
    }

    // ============================================================
    // CEK USERNAME UNIK
    // ============================================================
    public function is_username_unique($username, $id = null) {
        $this->db->where('username', $username);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('users');
        return $query->num_rows() == 0;
    }
}