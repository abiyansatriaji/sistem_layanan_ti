<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['M_tiket','M_master']);
    }

    public function index() {
        $filter = [];
        if ($this->user['nama_role'] == 'Pelapor')  $filter['id_user']   = $this->user['id_user'];
        if ($this->user['nama_role'] == 'Teknisi')  $filter['id_teknisi']= $this->user['id_user'];

        $data['tikets'] = $this->M_tiket->get_all($filter);
        $data['title']  = 'Dashboard';

        // Olah data untuk Grafik Status
        $status_data = $this->M_tiket->count_by_status();
        $data['status_data'] = $status_data; // <-- Variabel yang sebelumnya hilang
        $data['chart_status_labels'] = [];
        $data['chart_status_data'] = [];
        foreach ($status_data as $s) {
            $data['chart_status_labels'][] = $s->nama_status;
            $data['chart_status_data'][] = (int)$s->total;
        }

        // Olah data untuk Grafik Kategori
        $kategori_data = $this->M_tiket->count_by_kategori();
        $data['chart_kategori_labels'] = [];
        $data['chart_kategori_data'] = [];
        foreach ($kategori_data as $k) {
            $data['chart_kategori_labels'][] = $k->nama_kategori;
            $data['chart_kategori_data'][] = (int)$k->total;
        }

        $this->render('dashboard/index', $data);
    }
}