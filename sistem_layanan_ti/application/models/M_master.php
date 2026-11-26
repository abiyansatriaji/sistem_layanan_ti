<?php
class M_master extends CI_Model {
    public function get($table, $order = null) {
        if ($order) $this->db->order_by($order);
        return $this->db->get($table)->result();
    }
    public function get_by($table, $where) {
        return $this->db->get_where($table, $where)->row();
    }
    public function insert($table, $data) {
        return $this->db->insert($table, $data);
    }
    public function update($table, $where, $data) {
        return $this->db->update($table, $data, $where);
    }
    public function delete($table, $where) {
        return $this->db->delete($table, $where);
    }
}