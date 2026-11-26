<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller {
    private $map = [
        'roles'    => ['table'=>'roles',            'label'=>'Role',            'cols'=>['nama_role','deskripsi'], 'pk'=>'id_role'],
        'unit'     => ['table'=>'unit_kerja',       'label'=>'Unit Kerja',      'cols'=>['nama_unit','keterangan'], 'pk'=>'id_unit'],
        'jenis'    => ['table'=>'jenis_layanan',    'label'=>'Jenis Layanan',   'cols'=>['nama_jenis','deskripsi'], 'pk'=>'id_jenis'],
        'kategori' => ['table'=>'kategori_layanan', 'label'=>'Kategori Layanan','cols'=>['nama_kategori','deskripsi'], 'pk'=>'id_kategori'],
        'status'   => ['table'=>'status_tiket',     'label'=>'Status Tiket',    'cols'=>['nama_status','deskripsi'], 'pk'=>'id_status'],
    ];

    public function __construct() {
        parent::__construct();
        $this->load->model('M_master');
        $this->allowed_roles = ['Admin'];
    }

    public function index() { redirect('master/roles'); }

    private function _get_map($key) {
        if (!isset($this->map[$key])) show_404();
        return $this->map[$key];
    }

    public function roles()    { $this->_crud('roles'); }
    public function unit()     { $this->_crud('unit'); }
    public function jenis()    { $this->_crud('jenis'); }
    public function kategori() { $this->_crud('kategori'); }
    public function status()   { $this->_crud('status'); }

    private function _crud($key) {
        $cfg = $this->_get_map($key);
        $pk = $cfg['pk']; // Mengambil nama kolom ID yang benar

        // Proses Hapus
        if ($this->input->post('delete_id')) {
            $this->M_master->delete($cfg['table'], [$pk => $this->input->post('delete_id')]);
            $this->session->set_flashdata('success', 'Data dihapus');
            redirect('master/'.$key);
        }

        // Proses Simpan / Update
        if ($this->input->post()) {
            $data = [];
            foreach ($cfg['cols'] as $c) $data[$c] = $this->input->post($c, TRUE);

            if ($this->input->post('id')) {
                $this->M_master->update($cfg['table'], [$pk => $this->input->post('id')], $data);
                $this->session->set_flashdata('success', 'Data diupdate');
            } else {
                $this->M_master->insert($cfg['table'], $data);
                $this->session->set_flashdata('success', 'Data ditambahkan');
            }
            redirect('master/'.$key);
        }

        // Data untuk View
        $data['rows']     = $this->M_master->get($cfg['table']);
        $data['cols']     = $cfg['cols'];
        $data['label']    = $cfg['label'];
        $data['key']      = $key;
        $data['pk']       = $pk; // Kirim nama PK ke view
        $data['edit_row'] = $this->input->get('edit') ? $this->M_master->get_by($cfg['table'], [$pk => $this->input->get('edit')]) : null;
        $data['title']    = 'Master '.$cfg['label'];
        
        $this->render('master/index', $data);
    }
}