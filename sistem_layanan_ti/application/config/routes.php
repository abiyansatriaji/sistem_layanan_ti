<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['login']  = 'auth/login';
$route['logout'] = 'auth/logout';

// Dashboard
$route['dashboard'] = 'dashboard';

// Tiket
$route['tiket'] = 'tiket/index';
$route['tiket/create'] = 'tiket/create';
$route['tiket/detail/(:num)'] = 'tiket/detail/$1';
$route['tiket/verifikasi/(:num)'] = 'tiket/verifikasi/$1';
$route['tiket/tolak/(:num)'] = 'tiket/tolak/$1';

// Penugasan (Disesuaikan dengan link di view)
$route['penugasan/(:num)'] = 'penugasan/create/$1';
// Hapus route penugasan index karena tidak ada fungsinya, 
// atau arahkan kembali ke daftar tiket jika diakses manual
$route['penugasan'] = 'tiket'; 

// Penanganan (Disesuaikan dengan link di view)
$route['penanganan/(:num)'] = 'penanganan/create/$1';
$route['penanganan/selesai/(:num)'] = 'penanganan/selesai/$1';

// Master
$route['master/(:any)'] = 'master/$1';

// User
$route['user'] = 'user/index';
$route['user/create'] = 'user/create';
$route['user/edit/(:num)'] = 'user/edit/$1';
$route['user/delete/(:num)'] = 'user/delete/$1';

// Laporan
$route['laporan'] = 'laporan/index';

// Fallback (selalu taruh paling bawah)
$route['(:any)'] = 'auth/login';