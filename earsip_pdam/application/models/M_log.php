<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_log extends CI_Model {

    // Terapkan filter yang sama untuk daftar & hitung total
    private function _apply_filter($filter) {
        if (!empty($filter['user_id'])) {
            $this->db->where('log_aktivitas.user_id', $filter['user_id']);
        }
        if (!empty($filter['modul'])) {
            $this->db->where('log_aktivitas.modul', $filter['modul']);
        }
        if (!empty($filter['tgl_awal'])) {
            $this->db->where('log_aktivitas.created_at >=', $filter['tgl_awal'] . ' 00:00:00');
        }
        if (!empty($filter['tgl_akhir'])) {
            $this->db->where('log_aktivitas.created_at <=', $filter['tgl_akhir'] . ' 23:59:59');
        }
        if (!empty($filter['keyword'])) {
            $this->db->like('log_aktivitas.aktivitas', $filter['keyword']);
        }
    }

    public function get_all($filter = [], $limit = 25, $offset = 0) {
        $this->db->select('log_aktivitas.*, users.nama as user_nama, users.username as user_username');
        $this->db->from('log_aktivitas');
        $this->db->join('users', 'users.id = log_aktivitas.user_id', 'left');
        $this->_apply_filter($filter);
        $this->db->order_by('log_aktivitas.created_at', 'DESC');
        $this->db->order_by('log_aktivitas.id', 'DESC');
        $this->db->limit((int) $limit, (int) $offset);
        return $this->db->get()->result();
    }

    public function count_filtered($filter = []) {
        $this->db->from('log_aktivitas');
        $this->_apply_filter($filter);
        return $this->db->count_all_results();
    }

    public function count_today() {
        $hari_ini = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d');
        $this->db->where('created_at >=', $hari_ini . ' 00:00:00');
        return $this->db->count_all_results('log_aktivitas');
    }

    public function count_all() {
        return $this->db->count_all('log_aktivitas');
    }

    // Batas waktu (WIB): log yang lebih lama dari $bulan bulan dihitung "lama"
    private function _cutoff($bulan) {
        $dt = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $dt->modify('-' . (int) $bulan . ' months');
        return $dt->format('Y-m-d H:i:s');
    }

    public function count_older_than($bulan) {
        $this->db->where('created_at <', $this->_cutoff($bulan));
        return $this->db->count_all_results('log_aktivitas');
    }

    public function delete_older_than($bulan) {
        $this->db->where('created_at <', $this->_cutoff($bulan));
        $this->db->delete('log_aktivitas');
        return $this->db->affected_rows();
    }
}