<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {
    public function login($username, $password) {
        $user = $this->db->select('u.*, r.nama_role, uk.nama_unit')
            ->from('users u')
            ->join('roles r', 'u.id_role = r.id_role')
            ->join('unit_kerja uk', 'u.id_unit = uk.id_unit')
            ->where('u.username', $username)
            ->where('u.status_akun', 'Aktif')
            ->get()->row();

        // Jika user ditemukan dan password cocok
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}