<?php defined('BASEPATH') OR exit('No direct script access allowed');

function tgl_id($d) {
    if (!$d) return '-';
    $b = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $t = strtotime($d);
    return date('j', $t) . ' ' . $b[(int) date('n', $t)] . ' ' . date('Y', $t);
}
function jam($d) { return $d ? date('H:i', strtotime($d)) : '--:--'; }
function nama_bulan($n) {
    $b = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return $b[(int) $n];
}
function badge($s) {
    $map = ['hadir' => 'success', 'terlambat' => 'warning', 'menunggu' => 'warning', 'disetujui' => 'success', 'ditolak' => 'danger', 'dibatalkan' => 'secondary'];
    $c = isset($map[$s]) ? $map[$s] : 'secondary';
    return '<span class="badge rounded-pill text-bg-' . $c . '">' . ucfirst(html_escape($s)) . '</span>';
}
function role_label($r) {
    $m = ['super_admin' => 'Super Admin', 'admin_hr' => 'Admin HR', 'atasan' => 'Atasan', 'pegawai' => 'Pegawai'];
    return isset($m[$r]) ? $m[$r] : $r;
}
