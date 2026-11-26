<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Generate nomor agenda surat masuk
 * Format: [nomor_urut]/[bulan_romawi]/[tahun]
 */
function generate_no_agenda() {
    $CI =& get_instance();
    $CI->load->database();

    $bulan = date('n');
    $tahun = date('Y');
    $bulan_romawi = romawi($bulan);

    $CI->db->trans_start();

    $CI->db->query("SELECT * FROM counter_nomor_surat WHERE tipe = 'masuk' AND tahun = {$tahun} AND bulan = {$bulan} FOR UPDATE");

    $counter = $CI->db->get_where('counter_nomor_surat', [
        'tipe' => 'masuk',
        'tahun' => $tahun,
        'bulan' => $bulan
    ])->row();

    if ($counter) {
        $nomor_urut = $counter->nomor_urut + 1;
        $CI->db->where('id', $counter->id);
        $CI->db->update('counter_nomor_surat', ['nomor_urut' => $nomor_urut]);
    } else {
        $nomor_urut = 1;
        $CI->db->insert('counter_nomor_surat', [
            'tipe' => 'masuk',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'nomor_urut' => $nomor_urut
        ]);
    }

    $CI->db->trans_complete();

    return sprintf('%04d/%s/%d', $nomor_urut, $bulan_romawi, $tahun);
}


if (!function_exists('romawi')) {
    function romawi($angka) {
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        return $romawi[$angka] ?? $angka;
    }
}

/**
 * ============================================================
 * NOMOR SURAT KELUAR
 * Format tersimpan: [urut 4 digit]/[kode_klasifikasi]/[bulan_romawi]/[tahun]
 * Contoh: 0001/UM/IX/2026
 *
 * Dipecah jadi 2 fungsi:
 * - peek_no_surat_keluar()   -> HANYA untuk preview di form/AJAX.
 *                               Tidak mengunci apa pun, tidak menaikkan counter.
 *                               Boleh dipanggil berkali-kali dengan aman.
 * - generate_no_surat_keluar() -> Dipanggil TEPAT SEKALI, HANYA saat data
 *                               benar-benar disimpan (controller simpan()).
 *                               Mengunci baris counter (FOR UPDATE) supaya
 *                               dua request yang hampir bersamaan tidak
 *                               pernah mendapat nomor yang sama.
 * ============================================================
 */

if (!function_exists('_cari_urut_terakhir_keluar')) {
    // Helper internal: dipakai sebagai titik awal (seed) ketika baris counter
    // untuk kode+bulan+tahun ini belum pernah dibuat, supaya nyambung dengan
    // data lama yang sudah ada di tabel surat_keluar (bukan mulai dari 0 lagi).
    function _cari_urut_terakhir_keluar($CI, $suffix) {
        // suffix contoh: "/UM/IX/2026" -> cari no_surat yang DIAKHIRI pola ini
        $CI->db->like('no_surat', $suffix, 'before'); // no_surat LIKE '%/UM/IX/2026'
        $CI->db->order_by('id', 'DESC');
        $CI->db->limit(1);
        $last = $CI->db->get('surat_keluar')->row();

        if ($last) {
            $parts = explode('/', $last->no_surat);
            return intval($parts[0]);
        }
        return 0;
    }
}

if (!function_exists('peek_no_surat_keluar')) {
    function peek_no_surat_keluar($kode_klasifikasi = 'UM') {
        $CI =& get_instance();
        $CI->load->database();

        $bulan        = date('n');
        $tahun        = date('Y');
        $bulan_romawi = romawi($bulan);
        $tipe_counter = 'keluar_' . strtoupper($kode_klasifikasi);
        $suffix       = '/' . $kode_klasifikasi . '/' . $bulan_romawi . '/' . $tahun;

        $counter = $CI->db->get_where('counter_nomor_surat', [
            'tipe'  => $tipe_counter,
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->row();

        if ($counter) {
            $urut = $counter->nomor_urut + 1;
        } else {
            $urut = _cari_urut_terakhir_keluar($CI, $suffix) + 1;
        }

        $urut_str = str_pad($urut, 4, '0', STR_PAD_LEFT);
        return $urut_str . $suffix;
    }
}

if (!function_exists('generate_no_surat_keluar')) {
    function generate_no_surat_keluar($kode_klasifikasi = 'UM') {
        $CI =& get_instance();
        $CI->load->database();

        $bulan        = date('n');
        $tahun        = date('Y');
        $bulan_romawi = romawi($bulan);
        $tipe_counter = 'keluar_' . strtoupper($kode_klasifikasi);
        $suffix       = '/' . $kode_klasifikasi . '/' . $bulan_romawi . '/' . $tahun;

        $CI->db->trans_start();

        // Kunci baris counter ini supaya request lain menunggu giliran
        // (mencegah dua surat mendapat nomor urut yang sama)
        $CI->db->query(
            "SELECT * FROM counter_nomor_surat WHERE tipe = ? AND tahun = ? AND bulan = ? FOR UPDATE",
            [$tipe_counter, $tahun, $bulan]
        );

        $counter = $CI->db->get_where('counter_nomor_surat', [
            'tipe'  => $tipe_counter,
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->row();

        if ($counter) {
            $urut = $counter->nomor_urut + 1;
            $CI->db->where('id', $counter->id);
            $CI->db->update('counter_nomor_surat', ['nomor_urut' => $urut]);
        } else {
            // Baris counter belum pernah ada untuk kode+bulan+tahun ini.
            // Selaraskan dulu dengan data lama supaya tidak tabrakan.
            $urut = _cari_urut_terakhir_keluar($CI, $suffix) + 1;
            $CI->db->insert('counter_nomor_surat', [
                'tipe'       => $tipe_counter,
                'tahun'      => $tahun,
                'bulan'      => $bulan,
                'nomor_urut' => $urut
            ]);
        }

        $CI->db->trans_complete();

        $urut_str = str_pad($urut, 4, '0', STR_PAD_LEFT);
        return $urut_str . $suffix;
    }
}