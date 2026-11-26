<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_roles extends CI_Model {

    public function get_all() {
        return $this->db->get('roles')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('roles', ['id' => $id])->row();
    }
}