<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_surat_masuk extends CI_Model {

    // ============================================================
    // AMBIL SEMUA SURAT MASUK
    // ============================================================
    public function get_all() {
        $this->db->select('surat_masuk.*, klasifikasi_surat.nama_klasifikasi, users.nama as created_by_name');
        $this->db->from('surat_masuk');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_masuk.klasifikasi_id', 'left');
        $this->db->join('users', 'users.id = surat_masuk.created_by', 'left');
        $this->db->order_by('surat_masuk.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // ============================================================
    // AMBIL SURAT MASUK BERDASARKAN ID
    // ============================================================
    public function get_by_id($id) {
        $this->db->select('surat_masuk.*, klasifikasi_surat.nama_klasifikasi, users.nama as created_by_name');
        $this->db->from('surat_masuk');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_masuk.klasifikasi_id', 'left');
        $this->db->join('users', 'users.id = surat_masuk.created_by', 'left');
        $this->db->where('surat_masuk.id', $id);
        return $this->db->get()->row();
    }

    // ============================================================
    // INSERT SURAT MASUK
    // ============================================================
    public function insert($data) {
        $this->db->insert('surat_masuk', $data);
        return $this->db->insert_id();
    }

    // ============================================================
    // UPDATE SURAT MASUK
    // ============================================================
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('surat_masuk', $data);
    }

    // ============================================================
    // HAPUS SURAT MASUK
    // ============================================================
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('surat_masuk');
    }

    // ============================================================
    // CARI SURAT MASUK
    // ============================================================
    public function search($keyword) {
        $this->db->select('surat_masuk.*, klasifikasi_surat.nama_klasifikasi, users.nama as created_by_name');
        $this->db->from('surat_masuk');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_masuk.klasifikasi_id', 'left');
        $this->db->join('users', 'users.id = surat_masuk.created_by', 'left');
        $this->db->like('surat_masuk.no_agenda', $keyword);
        $this->db->or_like('surat_masuk.no_surat_asal', $keyword);
        $this->db->or_like('surat_masuk.pengirim', $keyword);
        $this->db->or_like('surat_masuk.perihal', $keyword);
        $this->db->order_by('surat_masuk.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // ============================================================
    // BUKU AGENDA SURAT MASUK (untuk cetak/PDF)
    // 'kepada' = nama penerima disposisi surat tsb (digabung koma)
    // ============================================================
    public function get_agenda($bulan = null, $tahun = null) {
        $this->db->select("
            surat_masuk.*,
            klasifikasi_surat.kode_klasifikasi,
            klasifikasi_surat.nama_klasifikasi,
            (SELECT GROUP_CONCAT(DISTINCT u.nama ORDER BY u.nama SEPARATOR '||')
               FROM disposisi d
               JOIN users u ON u.id = d.ke_user_id
              WHERE d.surat_masuk_id = surat_masuk.id) AS kepada
        ", FALSE);
        $this->db->from('surat_masuk');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_masuk.klasifikasi_id', 'left');
        // Filter periode (opsional): berdasarkan tanggal terima, sama dengan get_by_period()
        if (!empty($bulan) && !empty($tahun)) {
            $this->db->where('MONTH(surat_masuk.tgl_terima)', (int) $bulan);
            $this->db->where('YEAR(surat_masuk.tgl_terima)', (int) $tahun);
        }
        $this->db->order_by('surat_masuk.tgl_terima', 'ASC');
        $this->db->order_by('surat_masuk.id', 'ASC');
        return $this->db->get()->result();
    }

    // ============================================================
    // HITUNG TOTAL SURAT MASUK
    // ============================================================
    public function count_all() {
        return $this->db->count_all('surat_masuk');
    }

    // ============================================================
    // LAMPIRAN
    // ============================================================
    public function get_lampiran($surat_id, $tipe = 'masuk') {
        $this->db->where('surat_tipe', $tipe);
        $this->db->where('surat_id', $surat_id);
        return $this->db->get('lampiran_surat')->result();
    }

    public function insert_lampiran($data) {
        return $this->db->insert('lampiran_surat', $data);
    }

    public function delete_lampiran($id) {
        $this->db->where('id', $id);
        return $this->db->delete('lampiran_surat');
    }

    public function delete_lampiran_by_surat($surat_id, $tipe = 'masuk') {
        $this->db->where('surat_tipe', $tipe);
        $this->db->where('surat_id', $surat_id);
        return $this->db->delete('lampiran_surat');
    }
    
    // ============================================================
    // ==================== DISPOSISI ============================
    // ============================================================

    /**
     * Insert disposisi baru
     */
    public function insert_disposisi($data) {
        $this->db->insert('disposisi', $data);
        return $this->db->insert_id();
    }

    /**
     * Get disposisi by surat masuk ID (riwayat lengkap)
     */
    public function get_disposisi_by_surat($surat_masuk_id) {
        $this->db->select('
            disposisi.*,
            dari.nama as dari_nama,
            dari.username as dari_username,
            dari.jabatan as dari_jabatan,
            dari_bagian.nama_bagian as dari_bagian,
            ke.nama as ke_nama,
            ke.username as ke_username,
            ke.jabatan as ke_jabatan,
            ke_bagian.nama_bagian as ke_bagian,
            parent.instruksi as parent_instruksi,
            parent.catatan as parent_catatan
        ');
        $this->db->from('disposisi');
        $this->db->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left');
        $this->db->join('bagian as dari_bagian', 'dari_bagian.id = dari.bagian_id', 'left');
        $this->db->join('users as ke', 'ke.id = disposisi.ke_user_id', 'left');
        $this->db->join('bagian as ke_bagian', 'ke_bagian.id = ke.bagian_id', 'left');
        $this->db->join('disposisi as parent', 'parent.id = disposisi.parent_id', 'left');
        $this->db->where('disposisi.surat_masuk_id', $surat_masuk_id);
        $this->db->order_by('disposisi.tgl_disposisi', 'ASC');
        $this->db->order_by('disposisi.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Riwayat perubahan status tiap disposisi, diambil dari log aktivitas.
     * Hasil: [id_disposisi => [baris log, ...]] urut dari yang terlama.
     * Catatan: hanya ada untuk perubahan setelah log aktivitas dipasang.
     */
    public function get_status_log_by_disposisi($ids) {
        if (empty($ids)) return [];

        $this->db->select('log_aktivitas.referensi_id, log_aktivitas.aktivitas, log_aktivitas.created_at, users.nama as user_nama');
        $this->db->from('log_aktivitas');
        $this->db->join('users', 'users.id = log_aktivitas.user_id', 'left');
        $this->db->where('log_aktivitas.modul', 'disposisi');
        $this->db->where_in('log_aktivitas.referensi_id', $ids);
        $this->db->like('log_aktivitas.aktivitas', 'Mengubah status disposisi', 'after');
        $this->db->order_by('log_aktivitas.created_at', 'ASC');
        $this->db->order_by('log_aktivitas.id', 'ASC');

        $hasil = [];
        foreach ($this->db->get()->result() as $row) {
            $hasil[$row->referensi_id][] = $row;
        }
        return $hasil;
    }

    /**
     * Get disposisi by user ID (untuk yang login)
     */
    public function get_disposisi_by_user($user_id, $limit = 10, $offset = 0) {
        $this->db->select('
            disposisi.*,
            surat_masuk.no_agenda,
            surat_masuk.perihal,
            surat_masuk.pengirim,
            dari.nama as dari_nama,
            ke.nama as ke_nama
        ');
        $this->db->from('disposisi');
        $this->db->join('surat_masuk', 'surat_masuk.id = disposisi.surat_masuk_id');
        $this->db->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left');
        $this->db->join('users as ke', 'ke.id = disposisi.ke_user_id', 'left');
        $this->db->where('disposisi.ke_user_id', $user_id);
        $this->db->where('disposisi.status !=', 'selesai');
        $this->db->order_by('disposisi.tgl_disposisi', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count disposisi by user ID (belum selesai)
     */
    public function count_disposisi_by_user($user_id) {
        $this->db->where('ke_user_id', $user_id);
        $this->db->where('status !=', 'selesai');
        return $this->db->count_all_results('disposisi');
    }

    /**
     * Update status disposisi
     */
    public function update_disposisi_status($id, $status, $catatan = null) {
        $data = ['status' => $status];
        if ($status == 'selesai') {
            $data['tgl_selesai'] = date('Y-m-d H:i:s');
        }
        if ($catatan !== null) {
            $data['catatan'] = $catatan;
        }
        $this->db->where('id', $id);
        return $this->db->update('disposisi', $data);
    }

    /**
     * Get disposisi by ID
     */
    public function get_disposisi_by_id($id) {
        $this->db->select('
            disposisi.*,
            surat_masuk.no_agenda,
            surat_masuk.no_surat_asal,
            surat_masuk.perihal,
            surat_masuk.pengirim,
            surat_masuk.tgl_surat,
            surat_masuk.tgl_terima,
            klasifikasi_surat.kode_klasifikasi,
            dari.nama as dari_nama,
            ke.nama as ke_nama
        ');
        $this->db->from('disposisi');
        $this->db->join('surat_masuk', 'surat_masuk.id = disposisi.surat_masuk_id');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_masuk.klasifikasi_id', 'left');
        $this->db->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left');
        $this->db->join('users as ke', 'ke.id = disposisi.ke_user_id', 'left');
        $this->db->where('disposisi.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get semua disposisi (untuk admin)
     */
    public function get_all_disposisi($limit = 20, $offset = 0) {
        $this->db->select('
            disposisi.*,
            surat_masuk.no_agenda,
            surat_masuk.perihal,
            dari.nama as dari_nama,
            ke.nama as ke_nama
        ');
        $this->db->from('disposisi');
        $this->db->join('surat_masuk', 'surat_masuk.id = disposisi.surat_masuk_id');
        $this->db->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left');
        $this->db->join('users as ke', 'ke.id = disposisi.ke_user_id', 'left');
        $this->db->order_by('disposisi.tgl_disposisi', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count semua disposisi
     */
    public function count_all_disposisi() {
        return $this->db->count_all('disposisi');
    }

    /**
     * Hapus disposisi (beserta child-nya karena cascade)
     */
    public function delete_disposisi($id) {
        $this->db->where('id', $id);
        return $this->db->delete('disposisi');
    }

    /**
     * Hapus semua disposisi berdasarkan surat masuk ID
     */
    public function delete_disposisi_by_surat($surat_masuk_id) {
        $this->db->where('surat_masuk_id', $surat_masuk_id);
        return $this->db->delete('disposisi');
    }

    // ============================================================
    // RIWAYAT DISPOSISI BERJENJANG (dipakai bersama oleh Disposisi.php
    // dan Surat_masuk.php, supaya logikanya cuma ada di satu tempat)
    // ============================================================

    /**
     * Ambil riwayat disposisi satu surat masuk, sudah disusun berjenjang
     * (depth-first) dengan properti ->level (0,1,2,...) di tiap baris,
     * supaya view tinggal looping + indent sesuai level tanpa rekursi.
     */
    public function get_riwayat_tree($surat_masuk_id) {
        $rows = $this->get_disposisi_by_surat($surat_masuk_id);

        $by_parent = [];
        foreach ($rows as $r) {
            $pid = $r->parent_id ? $r->parent_id : 0;
            $by_parent[$pid][] = $r;
        }

        $result = [];
        $this->_flatten_riwayat($by_parent, 0, 0, $result);
        return $result;
    }

    private function _flatten_riwayat($by_parent, $parent_id, $level, &$result) {
        if (empty($by_parent[$parent_id])) return;
        foreach ($by_parent[$parent_id] as $node) {
            $node->level = $level;
            $result[] = $node;
            $this->_flatten_riwayat($by_parent, $node->id, $level + 1, $result);
        }
    }
    
   // ============================================================
// REKAP SURAT MASUK PER PERIODE
// ============================================================
public function get_summary_by_period($bulan, $tahun) {
    $this->db->select('COUNT(*) as total, status');
    $this->db->where('MONTH(tgl_terima)', $bulan);
    $this->db->where('YEAR(tgl_terima)', $tahun);
    $this->db->group_by('status');
    $query = $this->db->get('surat_masuk');
    $result = $query->result();
    
    $summary = [
        'total' => 0,
        'status' => []
    ];
    if (!empty($result)) {
        foreach ($result as $row) {
            $summary['status'][$row->status] = $row->total;
            $summary['total'] += $row->total;
        }
    }
    return $summary;
}

// ============================================================
// GET SURAT MASUK PER PERIODE (LENGKAP)
// ============================================================
public function get_by_period($bulan, $tahun) {
    $this->db->select('id, no_agenda, no_surat_asal, tgl_surat, tgl_terima, pengirim, perihal, status, created_by, created_at');
    $this->db->where('MONTH(tgl_terima)', $bulan);
    $this->db->where('YEAR(tgl_terima)', $tahun);
    $this->db->order_by('tgl_terima', 'DESC');
    $query = $this->db->get('surat_masuk');
    return $query->result(); // Pastikan return result, bukan result_array
}
// ============================================================
// FR-13: PENCARIAN MULTI-KRITERIA SURAT MASUK
// ============================================================
public function search_advanced($keyword = null, $tgl_awal = null, $tgl_akhir = null, $klasifikasi_id = null) {
    $this->db->select('surat_masuk.*, klasifikasi_surat.nama_klasifikasi, users.nama as created_by_name');
    $this->db->from('surat_masuk');
    $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_masuk.klasifikasi_id', 'left');
    $this->db->join('users', 'users.id = surat_masuk.created_by', 'left');

    // Keyword: nomor surat, perihal, pengirim
    if (!empty($keyword)) {
        $this->db->group_start();
        $this->db->like('surat_masuk.no_agenda', $keyword);
        $this->db->or_like('surat_masuk.no_surat_asal', $keyword);
        $this->db->or_like('surat_masuk.perihal', $keyword);
        $this->db->or_like('surat_masuk.pengirim', $keyword);
        $this->db->group_end();
    }

    // Filter tanggal
    if (!empty($tgl_awal)) {
        $this->db->where('surat_masuk.tgl_terima >=', $tgl_awal);
    }
    if (!empty($tgl_akhir)) {
        $this->db->where('surat_masuk.tgl_terima <=', $tgl_akhir);
    }

    // Filter klasifikasi
    if (!empty($klasifikasi_id)) {
        $this->db->where('surat_masuk.klasifikasi_id', $klasifikasi_id);
    }

    $this->db->order_by('surat_masuk.tgl_terima', 'DESC');
    return $this->db->get()->result();
}

// ============================================================
// ARSIP: HANYA SURAT YANG SUDAH SELESAI/ARSIP
// ============================================================
public function get_arsip($keyword = null, $tgl_awal = null, $tgl_akhir = null, $klasifikasi_id = null) {
    $this->db->select('surat_masuk.*, klasifikasi_surat.nama_klasifikasi');
    $this->db->from('surat_masuk');
    $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_masuk.klasifikasi_id', 'left');
    $this->db->where_in('surat_masuk.status', ['selesai', 'arsip']);

    if (!empty($keyword)) {
        $this->db->group_start();
        $this->db->like('surat_masuk.no_agenda', $keyword);
        $this->db->or_like('surat_masuk.no_surat_asal', $keyword);
        $this->db->or_like('surat_masuk.perihal', $keyword);
        $this->db->or_like('surat_masuk.pengirim', $keyword);
        $this->db->group_end();
    }
    if (!empty($tgl_awal)) {
        $this->db->where('surat_masuk.tgl_terima >=', $tgl_awal);
    }
    if (!empty($tgl_akhir)) {
        $this->db->where('surat_masuk.tgl_terima <=', $tgl_akhir);
    }
    if (!empty($klasifikasi_id)) {
        $this->db->where('surat_masuk.klasifikasi_id', $klasifikasi_id);
    }
    $this->db->order_by('surat_masuk.tgl_terima', 'DESC');
    return $this->db->get()->result();
}
}