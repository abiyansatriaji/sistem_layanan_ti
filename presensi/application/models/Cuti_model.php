<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti_model extends CI_Model {
    public function kuota($uid, $tahun) {
        $k = $this->db->get_where('kuota_cuti', ['user_id' => $uid, 'tahun' => $tahun])->row();
        if (!$k) {
            $this->db->insert('kuota_cuti', ['user_id' => $uid, 'tahun' => $tahun, 'total' => 12, 'terpakai' => 0]);
            $k = $this->db->get_where('kuota_cuti', ['user_id' => $uid, 'tahun' => $tahun])->row();
        }
        return $k;
    }

    // Hitung hari kerja: lewati Sabtu, Minggu, dan hari libur
    public function hitung_hari($a, $b) {
        $libur = array_column($this->db->select('tanggal')->get('hari_libur')->result_array(), 'tanggal');
        $n = 0;
        for ($t = strtotime($a); $t <= strtotime($b); $t += 86400) {
            if (date('N', $t) < 6 && !in_array(date('Y-m-d', $t), $libur)) $n++;
        }
        return $n;
    }

    public function ajukan($d) { return $this->db->insert('cuti', $d); }

    public function by_user($uid) {
        return $this->db->where('user_id', $uid)->order_by('id', 'DESC')->get('cuti')->result();
    }

    public function recent($limit = 6, $uid = NULL) {
        $this->db->select('c.*, u.nama')->from('cuti c')->join('users u', 'u.id = c.user_id');
        if ($uid) $this->db->where('c.user_id', $uid);
        return $this->db->order_by('c.id', 'DESC')->limit($limit)->get()->result();
    }

    public function pending_for($atasan_id) {
        return $this->db->select('c.*, u.nama, u.jabatan')->from('cuti c')
            ->join('users u', 'u.id = c.user_id')
            ->where('u.atasan_id', $atasan_id)->where('c.status', 'menunggu')
            ->order_by('c.id')->get()->result();
    }

    public function count_pending($atasan_id) {
        return $this->db->from('cuti c')->join('users u', 'u.id = c.user_id')
            ->where('u.atasan_id', $atasan_id)->where('c.status', 'menunggu')->count_all_results();
    }

    public function batal($id, $uid) {
        $this->db->where(['id' => $id, 'user_id' => $uid, 'status' => 'menunggu'])->update('cuti', ['status' => 'dibatalkan']);
        return $this->db->affected_rows() > 0;
    }

    // Return TRUE jika sukses, atau string pesan error
    public function proses($id, $aksi, $atasan_id, $catatan) {
        $c = $this->db->get_where('cuti', ['id' => $id])->row();
        if (!$c || $c->status !== 'menunggu') return 'Pengajuan tidak ditemukan atau sudah diproses.';
        $u = $this->db->get_where('users', ['id' => $c->user_id])->row();
        if (!$u || (int) $u->atasan_id !== (int) $atasan_id) return 'Anda bukan atasan langsung pegawai ini.';

        $this->db->trans_start();
        if ($aksi === 'setuju') {
            if ($c->jenis === 'tahunan') {
                $k = $this->kuota($c->user_id, date('Y', strtotime($c->tgl_mulai)));
                if ($k->total - $k->terpakai < $c->jumlah_hari) {
                    $this->db->trans_complete();
                    return 'Sisa kuota cuti pegawai tidak cukup.';
                }
                $this->db->set('terpakai', 'terpakai+' . (int) $c->jumlah_hari, FALSE)->where('id', $k->id)->update('kuota_cuti');
            }
            $status = 'disetujui';
        } else {
            $status = 'ditolak';
        }
        $this->db->where('id', $id)->update('cuti', [
            'status' => $status, 'catatan_atasan' => $catatan,
            'approved_by' => $atasan_id, 'approved_at' => date('Y-m-d H:i:s'),
        ]);
        $this->db->trans_complete();
        return $this->db->trans_status() ? TRUE : 'Gagal menyimpan data.';
    }
}
