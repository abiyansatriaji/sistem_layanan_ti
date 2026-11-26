<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_model extends CI_Model {
    public function today($uid) {
        return $this->db->get_where('presensi', ['user_id' => $uid, 'tanggal' => date('Y-m-d')])->row();
    }

    // Waktu SELALU dari server, bukan dari input pengguna
    public function masuk($uid) {
        if ($this->today($uid)) return FALSE;
        $status = (date('H:i:s') > $this->config->item('jam_masuk_batas')) ? 'terlambat' : 'hadir';
        return $this->db->insert('presensi', [
            'user_id' => $uid, 'tanggal' => date('Y-m-d'),
            'jam_masuk' => date('Y-m-d H:i:s'), 'status' => $status,
        ]);
    }

    public function pulang($uid) {
        $p = $this->today($uid);
        if (!$p || $p->jam_pulang) return FALSE;
        return $this->db->where('id', $p->id)->update('presensi', ['jam_pulang' => date('Y-m-d H:i:s')]);
    }

    public function riwayat($uid, $bulan) {
        return $this->db->where('user_id', $uid)
            ->where('tanggal >=', $bulan . '-01')->where('tanggal <=', date('Y-m-t', strtotime($bulan . '-01')))
            ->order_by('tanggal', 'DESC')->get('presensi')->result();
    }

    public function rekap($bulan) {
        $a = $bulan . '-01';
        $b = date('Y-m-t', strtotime($a));
        $sql = "SELECT u.nama, u.nip, u.jabatan,
            (SELECT COUNT(*) FROM presensi p WHERE p.user_id=u.id AND p.tanggal BETWEEN ? AND ? AND p.status='hadir') AS hadir,
            (SELECT COUNT(*) FROM presensi p WHERE p.user_id=u.id AND p.tanggal BETWEEN ? AND ? AND p.status='terlambat') AS terlambat,
            (SELECT COALESCE(SUM(c.jumlah_hari),0) FROM cuti c WHERE c.user_id=u.id AND c.status='disetujui' AND c.tgl_mulai BETWEEN ? AND ?) AS cuti
            FROM users u WHERE u.role IN ('atasan','pegawai') AND u.aktif=1 ORDER BY u.nama";
        return $this->db->query($sql, [$a, $b, $a, $b, $a, $b])->result();
    }
}
