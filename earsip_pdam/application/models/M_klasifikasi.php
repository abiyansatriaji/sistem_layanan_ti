<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_klasifikasi extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // ============================================================
    // GET ALL KLASIFIKASI
    // ============================================================
    public function get_all() {
        $this->db->order_by('kode_klasifikasi', 'ASC');
        return $this->db->get('klasifikasi_surat')->result();
    }

    // ============================================================
    // GET KLASIFIKASI BY ID
    // ============================================================
    public function get_by_id($id) {
        return $this->db->get_where('klasifikasi_surat', ['id' => $id])->row();
    }

    // ============================================================
    // INSERT KLASIFIKASI
    // ============================================================
    public function insert($data) {
        return $this->db->insert('klasifikasi_surat', $data);
    }

    // ============================================================
    // UPDATE KLASIFIKASI
    // ============================================================
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('klasifikasi_surat', $data);
    }

    // ============================================================
    // DELETE KLASIFIKASI
    // ============================================================
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('klasifikasi_surat');
    }

    // ============================================================
    // SEARCH KLASIFIKASI
    // ============================================================
    public function search($keyword) {
        $this->db->like('kode_klasifikasi', $keyword);
        $this->db->or_like('nama_klasifikasi', $keyword);
        $this->db->or_like('keterangan', $keyword);
        $this->db->order_by('kode_klasifikasi', 'ASC');
        return $this->db->get('klasifikasi_surat')->result();
    }

    // ============================================================
    // CEK DUPLIKAT KODE
    // ============================================================
    public function is_kode_exists($kode, $exclude_id = null) {
        $this->db->where('kode_klasifikasi', $kode);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('klasifikasi_surat');
        return $query->num_rows() > 0;
    }
}