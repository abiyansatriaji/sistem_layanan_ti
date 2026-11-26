<?php
class M_user extends CI_Model {
    public function get_all() {
        return $this->db->select('u.*, r.nama_role, uk.nama_unit')
            ->from('users u')
            ->join('roles r', 'u.id_role = r.id_role')
            ->join('unit_kerja uk', 'u.id_unit = uk.id_unit')
            ->order_by('u.nama')->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('users', ['id_user' => $id])->row();
    }

    public function insert($data) {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        return $this->db->insert('users', $data);
    }

    public function update($id, $data) {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        $this->db->where('id_user', $id);
        return $this->db->update('users', $data);
    }

    public function delete($id) {
        return $this->db->delete('users', ['id_user' => $id]);
    }

    public function get_teknisi() {
        return $this->db->select('u.id_user, u.nama')
            ->from('users u')
            ->join('roles r', 'u.id_role = r.id_role')
            ->where('r.nama_role', 'Teknisi')
            ->where('u.status_akun', 'Aktif')
            ->get()->result();
    }
}