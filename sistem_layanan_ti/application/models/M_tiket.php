<?php
class M_tiket extends CI_Model {

    public function get_all($filter = []) {
        $this->db->select('t.*, u.nama AS nama_pelapor,
                           j.nama_jenis, k.nama_kategori, s.nama_status')
            ->from('tiket_layanan t')
            ->join('users u', 't.id_user = u.id_user')
            ->join('jenis_layanan j', 't.id_jenis = j.id_jenis')
            ->join('kategori_layanan k', 't.id_kategori = k.id_kategori')
            ->join('status_tiket s', 't.id_status = s.id_status')
            ->order_by('t.tanggal_laporan', 'DESC');

        if (!empty($filter['id_user']))
            $this->db->where('t.id_user', $filter['id_user']);
        if (!empty($filter['id_status']))
            $this->db->where('t.id_status', $filter['id_status']);
        if (!empty($filter['id_teknisi']))
            $this->db->where('t.id_tiket IN (SELECT id_tiket FROM penugasan_tiket WHERE id_teknisi = '.intval($filter['id_teknisi']).')');
        if (!empty($filter['q']))
            $this->db->like('t.judul', $filter['q']);

        return $this->db->get()->result();
    }

        public function get_by_id($id) {
        return $this->db->select('t.*, u.nama AS nama_pelapor, u.email AS email_pelapor,
                                  j.nama_jenis, k.nama_kategori, s.nama_status')
            ->from('tiket_layanan t')
            ->join('users u', 't.id_user = u.id_user', 'left')
            ->join('jenis_layanan j', 't.id_jenis = j.id_jenis', 'left')
            ->join('kategori_layanan k', 't.id_kategori = k.id_kategori', 'left')
            ->join('status_tiket s', 't.id_status = s.id_status', 'left')
            ->where('t.id_tiket', $id)->get()->row();
    }

    public function generate_kode() {
        $row = $this->db->select('MAX(id_tiket) AS max_id')->get('tiket_layanan')->row();
        $next = ($row->max_id ?? 0) + 1;
        return 'TKT'.date('Ymd').str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function insert($data) {
        $this->db->insert('tiket_layanan', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id_tiket', $id);
        return $this->db->update('tiket_layanan', $data);
    }

    public function count_by_status() {
        return $this->db->select('s.nama_status, COUNT(t.id_tiket) AS total')
            ->from('status_tiket s')
            ->join('tiket_layanan t', 't.id_status = s.id_status', 'left')
            ->group_by('s.id_status')->get()->result();
    }

    public function count_by_kategori() {
        return $this->db->select('k.nama_kategori, COUNT(t.id_tiket) AS total')
            ->from('kategori_layanan k')
            ->join('tiket_layanan t', 't.id_kategori = k.id_kategori', 'left')
            ->group_by('k.id_kategori')->get()->result();
    }
}