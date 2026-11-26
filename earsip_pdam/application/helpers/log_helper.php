<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('catat_log')) {
    /**
     * Catat satu baris log aktivitas (audit trail, FR-17).
     *
     * @param string      $aktivitas    Deskripsi, contoh: "Menambahkan surat masuk No. Agenda 0001/IX/2026"
     * @param string|null $modul        'auth' | 'surat_masuk' | 'surat_keluar' | 'disposisi'
     * @param int|null    $referensi_id ID record terkait (surat / disposisi), boleh null
     * @param int|null    $user_id      Isi manual hanya jika session belum ada (mis. saat login)
     */
    function catat_log($aktivitas, $modul = null, $referensi_id = null, $user_id = null) {
        $CI =& get_instance();
        $CI->load->database();

        if ($user_id === null) {
            $CI->load->library('session');
            $user_id = $CI->session->userdata('user_id') ?: null;
        }

        // Log tidak boleh membuat proses utama gagal
        try {
            $CI->db->insert('log_aktivitas', [
                'user_id'      => $user_id,
                'aktivitas'    => mb_substr($aktivitas, 0, 255),
                'modul'        => $modul,
                'referensi_id' => $referensi_id ?: null,
                'ip_address'   => $CI->input->ip_address(),
                // Selalu WIB, tidak tergantung setelan zona waktu server
                'created_at'   => (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            log_message('error', 'catat_log gagal: ' . $e->getMessage());
        }
    }
}