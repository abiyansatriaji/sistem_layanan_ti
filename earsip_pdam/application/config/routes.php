
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Landing & Auth
$route['default_controller'] = 'Auth';
$route['auth'] = 'Auth/index';
$route['auth/login'] = 'Auth/login';
$route['auth/logout'] = 'Auth/logout';

// Dashboard
$route['dashboard'] = 'Dashboard/index';

// Surat Masuk
$route['surat_masuk'] = 'Surat_masuk/index';
$route['surat_masuk/tambah'] = 'Surat_masuk/tambah';
$route['surat_masuk/simpan'] = 'Surat_masuk/simpan';
$route['surat_masuk/edit/(:num)'] = 'Surat_masuk/edit/$1';
$route['surat_masuk/update/(:num)'] = 'Surat_masuk/update/$1';
$route['surat_masuk/hapus/(:num)'] = 'Surat_masuk/hapus/$1';
$route['surat_masuk/detail/(:num)'] = 'Surat_masuk/detail/$1';
$route['surat_masuk/cari'] = 'Surat_masuk/cari';
$route['surat_masuk/cetak'] = 'Surat_masuk/cetak';
$route['surat_masuk/hapus_lampiran/(:num)'] = 'Surat_keluar/hapus_lampiran/$1';

// ===== SURAT KELUAR =====
$route['surat_keluar'] = 'Surat_keluar/index';
$route['surat_keluar/tambah'] = 'Surat_keluar/tambah';
$route['surat_keluar/simpan'] = 'Surat_keluar/simpan';
$route['surat_keluar/edit/(:num)'] = 'Surat_keluar/edit/$1';
$route['surat_keluar/update/(:num)'] = 'Surat_keluar/update/$1';
$route['surat_keluar/hapus/(:num)'] = 'Surat_keluar/hapus/$1';
$route['surat_keluar/detail/(:num)'] = 'Surat_keluar/detail/$1';
$route['surat_keluar/cari'] = 'Surat_keluar/cari';
$route['surat_keluar/cetak'] = 'Surat_keluar/cetak';
$route['surat_keluar/cetak_semua'] = 'Surat_keluar/cetak_semua';
$route['surat_keluar/hapus_lampiran/(:num)'] = 'Surat_keluar/hapus_lampiran/$1';

// ===== DISPOSISI =====
$route['disposisi'] = 'Disposisi/index';
$route['surat_masuk/disposisi/(:num)'] = 'Surat_masuk/disposisi/$1';
$route['surat_masuk/simpan_disposisi'] = 'Surat_masuk/simpan_disposisi';
$route['surat_masuk/disposisi_list'] = 'Surat_masuk/disposisi_list';
$route['surat_masuk/update_status_disposisi/(:num)'] = 'Surat_masuk/update_status_disposisi/$1';
$route['surat_masuk/teruskan_disposisi/(:num)'] = 'Surat_masuk/teruskan_disposisi/$1';
$route['surat_masuk/simpan_teruskan'] = 'Surat_masuk/simpan_teruskan';
$route['surat_masuk/hapus_disposisi/(:num)'] = 'Surat_masuk/hapus_disposisi/$1';

// Master Data
$route['klasifikasi'] = 'Klasifikasi/index';
$route['klasifikasi/tambah'] = 'Klasifikasi/tambah';
$route['klasifikasi/simpan'] = 'Klasifikasi/simpan';
$route['klasifikasi/edit/(:num)'] = 'Klasifikasi/edit/$1';
$route['klasifikasi/update/(:num)'] = 'Klasifikasi/update/$1';
$route['klasifikasi/hapus/(:num)'] = 'Klasifikasi/hapus/$1';

// Bagian
$route['bagian'] = 'Bagian/index';
$route['bagian/tambah'] = 'Bagian/tambah';
$route['bagian/simpan'] = 'Bagian/simpan';
$route['bagian/edit/(:num)'] = 'Bagian/edit/$1';
$route['bagian/update/(:num)'] = 'Bagian/update/$1';
$route['bagian/hapus/(:num)'] = 'Bagian/hapus/$1';
$route['bagian/cari'] = 'Bagian/cari';

// Kelola User
$route['user'] = 'User/index';
$route['user/tambah'] = 'User/tambah';
$route['user/simpan'] = 'User/simpan';
$route['user/edit/(:num)'] = 'User/edit/$1';
$route['user/update/(:num)'] = 'User/update/$1';
$route['user/hapus/(:num)'] = 'User/hapus/$1';

// ===== LAPORAN =====
$route['laporan'] = 'Laporan/index';
$route['laporan/export_excel'] = 'Laporan/export_excel';
$route['laporan/cetak'] = 'Laporan/cetak';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// ===== LANDING PAGE =====
$route['default_controller'] = 'Landing';
$route['landing'] = 'Landing/index';

// ===== USER (Super Admin) =====
$route['user'] = 'User/index';
$route['user/tambah'] = 'User/tambah';
$route['user/simpan'] = 'User/simpan';
$route['user/edit/(:num)'] = 'User/edit/$1';
$route['user/update/(:num)'] = 'User/update/$1';
$route['user/nonaktifkan/(:num)'] = 'User/nonaktifkan/$1';
$route['user/aktifkan/(:num)'] = 'User/aktifkan/$1';
$route['user/hapus/(:num)'] = 'User/hapus/$1';

// ===== ARSIP & PENCARIAN =====
$route['arsip'] = 'Arsip/index';
$route['arsip/surat_arsip'] = 'Arsip/surat_arsip';
$route['arsip/download/(:num)'] = 'Arsip/download/$1';
$route['arsip/lihat/(:num)'] = 'Arsip/lihat/$1';