<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function log_aktivitas($user_id, $aktivitas, $modul = null, $referensi = null)
    {
        $data = array(
            'user_id'      => $user_id,
            'aktivitas'    => $aktivitas,
            'modul'        => $modul,
            'referensi_id' => $referensi,
            'ip_address'   => $this->input->ip_address(),
            'created_at'   => date('Y-m-d H:i:s')
        );
        return $this->db->insert('log_aktivitas', $data);
    }

    public function get_logs($limit = 50, $offset = 0)
    {
        $this->db->select('log_aktivitas.*, users.nama, users.username');
        $this->db->from('log_aktivitas');
        $this->db->join('users', 'users.id = log_aktivitas.user_id', 'left');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_logs()
    {
        return $this->db->count_all('log_aktivitas');
    }
}