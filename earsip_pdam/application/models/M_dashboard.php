<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

    public function count_surat_masuk() {
        return $this->db->count_all('surat_masuk');
    }

    public function count_surat_keluar() {
        return $this->db->count_all('surat_keluar');
    }

    public function count_disposisi() {
        return $this->db->count_all('disposisi');
    }

    public function count_users() {
        return $this->db->where('status', 'aktif')->count_all_results('users');
    }

    public function get_surat_masuk_terbaru($limit = 5) {
        $this->db->select('surat_masuk.*, users.nama as created_by_name');
        $this->db->from('surat_masuk');
        $this->db->join('users', 'users.id = surat_masuk.created_by', 'left');
        $this->db->order_by('surat_masuk.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_disposisi_by_user($user_id, $limit = 5) {
        $this->db->select('disposisi.*, surat_masuk.no_agenda, surat_masuk.perihal, users.nama as dari_nama');
        $this->db->from('disposisi');
        $this->db->join('surat_masuk', 'surat_masuk.id = disposisi.surat_masuk_id');
        $this->db->join('users', 'users.id = disposisi.dari_user_id');
        $this->db->where('disposisi.ke_user_id', $user_id);
        $this->db->where('disposisi.status !=', 'selesai');
        $this->db->order_by('disposisi.tgl_disposisi', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    // ===== GRAFIK BULANAN =====
    public function get_grafik_bulanan() {
        $data = [];
        $tahun = date('Y');
        
        for ($i = 1; $i <= 12; $i++) {
            $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
            $this->db->where('YEAR(tgl_surat)', $tahun);
            $this->db->where('MONTH(tgl_surat)', $i);
            $data[$i] = $this->db->count_all_results('surat_masuk');
        }
        return $data;
    }
}