<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_surat_keluar extends CI_Model {

    // ============================================================
    // GET ALL SURAT KELUAR
    // ============================================================
    public function get_all() {
        $this->db->select('
            surat_keluar.*,
            klasifikasi_surat.nama_klasifikasi,
            klasifikasi_surat.kode_klasifikasi,
            bagian.nama_bagian,
            bagian.kode_bagian,
            users.nama as created_by_name
        ');
        $this->db->from('surat_keluar');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_keluar.klasifikasi_id', 'left');
        $this->db->join('bagian', 'bagian.id = surat_keluar.bagian_id', 'left');
        $this->db->join('users', 'users.id = surat_keluar.created_by', 'left');
        $this->db->order_by('surat_keluar.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // ============================================================
    // GET SURAT KELUAR BY ID
    // ============================================================
    public function get_by_id($id) {
        $this->db->select('
            surat_keluar.*,
            klasifikasi_surat.nama_klasifikasi,
            klasifikasi_surat.kode_klasifikasi,
            bagian.nama_bagian,
            bagian.kode_bagian,
            users.nama as created_by_name
        ');
        $this->db->from('surat_keluar');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_keluar.klasifikasi_id', 'left');
        $this->db->join('bagian', 'bagian.id = surat_keluar.bagian_id', 'left');
        $this->db->join('users', 'users.id = surat_keluar.created_by', 'left');
        $this->db->where('surat_keluar.id', $id);
        return $this->db->get()->row();
    }

    // ============================================================
    // INSERT SURAT KELUAR
    // ============================================================
    public function insert($data) {
        $this->db->insert('surat_keluar', $data);
        return $this->db->insert_id();
    }

    // ============================================================
    // UPDATE SURAT KELUAR
    // ============================================================
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('surat_keluar', $data);
    }

    // ============================================================
    // DELETE SURAT KELUAR
    // ============================================================
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('surat_keluar');
    }

    // ============================================================
    // SEARCH SURAT KELUAR
    // ============================================================
    public function search($keyword) {
        $this->db->select('
            surat_keluar.*,
            klasifikasi_surat.nama_klasifikasi,
            klasifikasi_surat.kode_klasifikasi,
            bagian.nama_bagian,
            bagian.kode_bagian,
            users.nama as created_by_name
        ');
        $this->db->from('surat_keluar');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_keluar.klasifikasi_id', 'left');
        $this->db->join('bagian', 'bagian.id = surat_keluar.bagian_id', 'left');
        $this->db->join('users', 'users.id = surat_keluar.created_by', 'left');
        $this->db->like('surat_keluar.no_surat', $keyword);
        $this->db->or_like('surat_keluar.tujuan', $keyword);
        $this->db->or_like('surat_keluar.perihal', $keyword);
        $this->db->order_by('surat_keluar.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // ============================================================
    // COUNT TOTAL
    // ============================================================
    public function count_all() {
        return $this->db->count_all('surat_keluar');
    }

    // ============================================================
    // LAMPIRAN
    // ============================================================
    public function get_lampiran($surat_id, $tipe = 'keluar') {
        $this->db->where('surat_tipe', $tipe);
        $this->db->where('surat_id', $surat_id);
        return $this->db->get('lampiran_surat')->result();
    }

    public function insert_lampiran($data) {
        return $this->db->insert('lampiran_surat', $data);
    }

    public function delete_lampiran_by_surat($surat_id, $tipe = 'keluar') {
        $this->db->where('surat_tipe', $tipe);
        $this->db->where('surat_id', $surat_id);
        return $this->db->delete('lampiran_surat');
    }

    // ============================================================
    // GET STATUS LABEL
    // ============================================================
    public function get_status_label($status) {
        $labels = [
            'draft'   => ['label' => 'Draft', 'class' => 'secondary'],
            'dikirim' => ['label' => 'Dikirim', 'class' => 'primary'],
            'arsip'   => ['label' => 'Arsip', 'class' => 'success']
        ];
        return $labels[$status] ?? ['label' => ucfirst($status), 'class' => 'secondary'];
    }

 // ============================================================
// REKAP SURAT KELUAR PER PERIODE
// ============================================================
public function get_summary_by_period($bulan, $tahun) {
    $this->db->select('COUNT(*) as total, status');
    $this->db->where('MONTH(tgl_surat)', $bulan);
    $this->db->where('YEAR(tgl_surat)', $tahun);
    $this->db->group_by('status');
    $query = $this->db->get('surat_keluar');
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
// GET SURAT KELUAR PER PERIODE (LENGKAP)
// ============================================================
public function get_by_period($bulan, $tahun) {
    $this->db->select('id, no_surat, tgl_surat, tujuan, perihal, status, created_by, created_at');
    $this->db->where('MONTH(tgl_surat)', $bulan);
    $this->db->where('YEAR(tgl_surat)', $tahun);
    $this->db->order_by('tgl_surat', 'DESC');
    $query = $this->db->get('surat_keluar');
    return $query->result();
    }
    // ============================================================
// FR-13: PENCARIAN MULTI-KRITERIA SURAT KELUAR
// ============================================================
public function search_advanced($keyword = null, $tgl_awal = null, $tgl_akhir = null, $klasifikasi_id = null) {
    $this->db->select('surat_keluar.*, klasifikasi_surat.nama_klasifikasi');
    $this->db->from('surat_keluar');
    $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_keluar.klasifikasi_id', 'left');

    if (!empty($keyword)) {
        $this->db->group_start();
        $this->db->like('surat_keluar.no_surat', $keyword);
        $this->db->or_like('surat_keluar.perihal', $keyword);
        $this->db->or_like('surat_keluar.tujuan', $keyword);
        $this->db->group_end();
    }
    if (!empty($tgl_awal)) {
        $this->db->where('surat_keluar.tgl_surat >=', $tgl_awal);
    }
    if (!empty($tgl_akhir)) {
        $this->db->where('surat_keluar.tgl_surat <=', $tgl_akhir);
    }
    if (!empty($klasifikasi_id)) {
        $this->db->where('surat_keluar.klasifikasi_id', $klasifikasi_id);
    }
    $this->db->order_by('surat_keluar.tgl_surat', 'DESC');
    return $this->db->get()->result();
}

public function get_arsip($keyword = null, $tgl_awal = null, $tgl_akhir = null, $klasifikasi_id = null) {
    $this->db->select('surat_keluar.*, klasifikasi_surat.nama_klasifikasi');
    $this->db->from('surat_keluar');
    $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_keluar.klasifikasi_id', 'left');
    $this->db->where('surat_keluar.status', 'arsip');

    if (!empty($keyword)) {
        $this->db->group_start();
        $this->db->like('surat_keluar.no_surat', $keyword);
        $this->db->or_like('surat_keluar.perihal', $keyword);
        $this->db->or_like('surat_keluar.tujuan', $keyword);
        $this->db->group_end();
    }
    if (!empty($tgl_awal)) {
        $this->db->where('surat_keluar.tgl_surat >=', $tgl_awal);
    }
    if (!empty($tgl_akhir)) {
        $this->db->where('surat_keluar.tgl_surat <=', $tgl_akhir);
    }
    if (!empty($klasifikasi_id)) {
        $this->db->where('surat_keluar.klasifikasi_id', $klasifikasi_id);
    }
    $this->db->order_by('surat_keluar.tgl_surat', 'DESC');
    return $this->db->get()->result();
}

// ============================================================
// BUKU AGENDA SURAT KELUAR (untuk cetak)
// jumlah_lampiran = banyaknya berkas lampiran surat tsb
// ============================================================
public function get_agenda($bulan = null, $tahun = null) {
    $this->db->select("
        surat_keluar.*,
        klasifikasi_surat.kode_klasifikasi,
        (SELECT COUNT(*) FROM lampiran_surat l
          WHERE l.surat_tipe = 'keluar' AND l.surat_id = surat_keluar.id) AS jumlah_lampiran
    ", FALSE);
    $this->db->from('surat_keluar');
    $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id = surat_keluar.klasifikasi_id', 'left');
    // Filter periode (opsional): berdasarkan tanggal surat, sama dengan get_by_period()
    if (!empty($bulan) && !empty($tahun)) {
        $this->db->where('MONTH(surat_keluar.tgl_surat)', (int) $bulan);
        $this->db->where('YEAR(surat_keluar.tgl_surat)', (int) $tahun);
    }
    $this->db->order_by('surat_keluar.tgl_surat', 'ASC');
    $this->db->order_by('surat_keluar.id', 'ASC');
    return $this->db->get()->result();
}
}