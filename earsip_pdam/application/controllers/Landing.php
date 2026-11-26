<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database(); // Load database
    }

    public function index() {
        // Ambil data real dari database
        $data['total_surat_masuk'] = $this->db->count_all('surat_masuk');
        $data['total_surat_keluar'] = $this->db->count_all('surat_keluar');
        $data['total_disposisi'] = $this->db->count_all('disposisi');
        $data['total_users'] = $this->db->count_all('users');
        // Hanya hitung user dengan status 'aktif'
        $data['total_users'] = $this->db->where('status', 'aktif')->count_all_results('users');
        $this->load->view('landing/index', $data);
    }
    
}