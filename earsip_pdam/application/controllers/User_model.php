<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_bagian() {
        return $this->db->get('bagian')->result();
    }

    // ===== AMBIL SEMUA ROLE =====
    public function get_all_roles() {
        return $this->db->get('roles')->result();
    }

    // ===== AMBIL SEMUA USER =====
    public function get_all_users() {
        $this->db->select('users.*, roles.nama_role, bagian.nama_bagian');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->join('bagian', 'bagian.id = users.bagian_id', 'left');
        $this->db->order_by('users.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // ===== AMBIL USER BERDASARKAN ID =====
    public function get_user_by_id($id) {
        $this->db->select('users.*, roles.nama_role, bagian.nama_bagian');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->join('bagian', 'bagian.id = users.bagian_id', 'left');
        $this->db->where('users.id', $id);
        return $this->db->get()->row();
    }

    // ===== INSERT USER =====
    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    // ===== UPDATE USER =====
    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    // ===== UPDATE STATUS (AKTIF / NONAKTIF) =====
    public function update_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('users', ['status' => $status]);
    }

    // ===== DELETE USER =====
    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    // ===== CEK USERNAME UNIK =====
    public function is_username_exists($username, $exclude_id = null) {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
}