<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_tiket');
        $this->allowed_roles = ['Admin','Kepala TI'];
    }

    public function index() {
        $data['by_status']   = $this->M_tiket->count_by_status();
        $data['by_kategori'] = $this->M_tiket->count_by_kategori();
        $data['tikets']      = $this->M_tiket->get_all();
        $data['title']       = 'Laporan';
        $this->render('laporan/index', $data);
    }
}