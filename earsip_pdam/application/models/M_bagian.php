<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bagian extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil semua data bagian
     */
    public function get_all() {
        $this->db->order_by('nama_bagian', 'ASC');
        return $this->db->get('bagian')->result();
    }

    /**
     * Ambil data bagian berdasarkan ID
     */
    public function get_by_id($id) {
        return $this->db->get_where('bagian', ['id' => $id])->row();
    }

    /**
     * Tambah data bagian
     */
    public function insert($data) {
        return $this->db->insert('bagian', $data);
    }

    /**
     * Update data bagian
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('bagian', $data);
    }

    /**
     * Hapus data bagian
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('bagian');
    }

    /**
     * Cari data bagian berdasarkan keyword
     */
    public function search($keyword) {
        $this->db->like('nama_bagian', $keyword);
        $this->db->or_like('kode_bagian', $keyword);
        $this->db->order_by('nama_bagian', 'ASC');
        return $this->db->get('bagian')->result();
    }

    /**
     * Cek apakah kode_bagian sudah ada
     */
    public function is_kode_exists($kode, $exclude_id = null) {
        $this->db->where('kode_bagian', $kode);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('bagian');
        return $query->num_rows() > 0;
    }
}