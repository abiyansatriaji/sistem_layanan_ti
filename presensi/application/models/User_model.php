<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function find($id) { return $this->db->get_where('users', ['id' => $id])->row(); }
    public function by_username($u) { return $this->db->get_where('users', ['username' => $u])->row(); }

    public function all() {
        return $this->db->select('u.*, a.nama AS atasan_nama')
            ->from('users u')->join('users a', 'a.id = u.atasan_id', 'left')
            ->order_by('u.nama')->get()->result();
    }
    public function atasan_list() {
        return $this->db->where('role', 'atasan')->where('aktif', 1)->order_by('nama')->get('users')->result();
    }
    public function create($d) {
        $this->db->trans_start();
        $this->db->insert('users', $d);
        $id = $this->db->insert_id();
        $this->db->insert('kuota_cuti', ['user_id' => $id, 'tahun' => date('Y'), 'total' => 12, 'terpakai' => 0]);
        $this->db->trans_complete();
        return $id;
    }
    public function toggle($id) {
        $this->db->set('aktif', '1-aktif', FALSE)->where('id', $id)->update('users');
    }
}
