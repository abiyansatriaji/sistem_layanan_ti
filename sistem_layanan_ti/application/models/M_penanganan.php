<?php
class M_penanganan extends CI_Model {
    public function insert_penugasan($data) {
        return $this->db->insert('penugasan_tiket', $data);
    }

    public function penugasan_by_tiket($id_tiket) {
        return $this->db->select('p.*, u.nama AS nama_teknisi, pt.nama AS pemberi')
            ->from('penugasan_tiket p')
            ->join('users u', 'p.id_teknisi = u.id_user')
            ->join('users pt', 'p.id_pemberi_tugas = pt.id_user')
            ->where('p.id_tiket', $id_tiket)
            ->order_by('p.tanggal_penugasan', 'DESC')->get()->row();
    }

    public function insert_riwayat($data) {
        return $this->db->insert('riwayat_penanganan', $data);
    }

    public function riwayat_by_tiket($id_tiket) {
        return $this->db->select('r.*, u.nama AS nama_teknisi')
            ->from('riwayat_penanganan r')
            ->join('users u', 'r.id_teknisi = u.id_user')
            ->where('r.id_tiket', $id_tiket)
            ->order_by('r.tanggal_penanganan', 'DESC')->get()->result();
    }

    public function insert_lampiran($data) {
        return $this->db->insert('lampiran_tiket', $data);
    }

    public function lampiran_by_tiket($id_tiket) {
        return $this->db->select('l.*, u.nama AS nama_uploader, r.nama_role')
            ->from('lampiran_tiket l')
            ->join('users u', 'l.id_user = u.id_user')
            ->join('roles r', 'u.id_role = r.id_role') // Tambahan join role
            ->where('l.id_tiket', $id_tiket)
            ->order_by('l.tanggal_upload', 'DESC')->get()->result();
    }
}