<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // ============================================================
    // CEK LOGIN DENGAN PASSWORD_HASH + FALLBACK MD5
    // ============================================================
    public function cek_login($username, $password) {
        // Cari user berdasarkan username
        $this->db->select('users.*, roles.nama_role');
        $this->db->from('users');
        $this->db->join('roles', 'users.role_id = roles.id', 'left');
        $this->db->where('users.username', $username);
        $this->db->where('users.status', 'aktif');
        $query = $this->db->get();
        $user = $query->row();

        if (!$user) {
            return false;
        }

        // ===== CEK PASSWORD DENGAN password_verify =====
        if (password_verify($password, $user->password)) {
            return $user;
        }

        // ===== FALLBACK: CEK MD5 (untuk user lama) =====
        if (md5($password) == $user->password) {
            // Update password ke hash baru
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $this->db->where('id', $user->id)->update('users', ['password' => $new_hash]);
            return $user;
        }

        return false;
    }

    // ============================================================
// GET USER BY USERNAME (untuk Auth controller)
// ============================================================
public function get_user_by_username($username) {
    $this->db->select('users.*, roles.nama_role');
    $this->db->from('users');
    $this->db->join('roles', 'users.role_id = roles.id', 'left');
    $this->db->where('users.username', $username);
    $this->db->where('users.status', 'aktif');
    return $this->db->get()->row();
}

    // ============================================================
    // LOG AKTIVITAS
    // ============================================================
    public function log_aktivitas($user_id, $aktivitas, $modul = NULL, $referensi_id = NULL) {
        $data = [
            'user_id'     => $user_id,
            'aktivitas'   => $aktivitas,
            'modul'       => $modul,
            'referensi_id' => $referensi_id,
            'ip_address'  => $this->input->ip_address(),
            'created_at'  => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('log_aktivitas', $data);
    }
}