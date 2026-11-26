<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function index() {
        $uid = $this->user->id;
        $today = date('Y-m-d');
        $p = $this->Presensi_model->today($uid);
        if ($this->is_admin()) {
            $stats = [
                ['Total Pegawai', $this->db->where_in('role', ['atasan', 'pegawai'])->where('aktif', 1)->count_all_results('users'), 'bi-people-fill', 'primary'],
                ['Hadir Hari Ini', $this->db->where('tanggal', $today)->count_all_results('presensi'), 'bi-check-circle-fill', 'success'],
                ['Terlambat Hari Ini', $this->db->where(['tanggal' => $today, 'status' => 'terlambat'])->count_all_results('presensi'), 'bi-alarm-fill', 'warning'],
                ['Cuti Menunggu', $this->db->where('status', 'menunggu')->count_all_results('cuti'), 'bi-hourglass-split', 'info'],
            ];
            $recent = $this->Cuti_model->recent(6);
        } else {
            $k = $this->Cuti_model->kuota($uid, date('Y'));
            $stats = [
                ['Status Hari Ini', $p ? ($p->jam_pulang ? 'Sudah Pulang' : 'Sudah Masuk') : 'Belum Absen', 'bi-fingerprint', $p ? 'success' : 'secondary'],
                ['Sisa Kuota Cuti', ($k->total - $k->terpakai) . ' hari', 'bi-calendar2-heart-fill', 'primary'],
                ['Cuti Terpakai', $k->terpakai . ' hari', 'bi-calendar-check-fill', 'info'],
                [$this->user->role === 'atasan' ? 'Perlu Disetujui' : 'Cuti Menunggu',
                    $this->user->role === 'atasan' ? $this->Cuti_model->count_pending($uid) : $this->db->where(['user_id' => $uid, 'status' => 'menunggu'])->count_all_results('cuti'),
                    'bi-hourglass-split', 'warning'],
            ];
            $recent = $this->Cuti_model->recent(6, $uid);
        }
        $this->render('dashboard/index', ['stats' => $stats, 'recent' => $recent, 'today' => $p, 'title' => 'Dashboard']);
    }
}
