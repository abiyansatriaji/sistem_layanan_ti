<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seed extends CI_Controller {
    public function index() {
        $users = [
            ['id_role'=>1, 'id_unit'=>4, 'nama'=>'Admin TI',      'username'=>'admin',     'password'=>'admin123'],
            ['id_role'=>2, 'id_unit'=>1, 'nama'=>'Budi Pelapor',  'username'=>'pelapor',   'password'=>'pelapor123'],
            ['id_role'=>3, 'id_unit'=>4, 'nama'=>'Andi Teknisi',  'username'=>'teknisi',   'password'=>'teknisi123'],
            ['id_role'=>4, 'id_unit'=>4, 'nama'=>'Kepala TI',     'username'=>'kepalati',  'password'=>'kepalati123'],
        ];
        foreach ($users as $u) {
            if (!$this->db->get_where('users', ['username'=>$u['username']])->row()) {
                $u['password'] = password_hash($u['password'], PASSWORD_DEFAULT);
                $u['email']    = $u['username'].'@pdam.com';
                $u['no_hp']    = '081234567890';
                $this->db->insert('users', $u);
            }
        }
        echo "<h3>Seed berhasil!</h3>
              <p>admin/admin123<br>pelapor/pelapor123<br>
              teknisi/teknisi123<br>kepalati/kepalati123</p>
              <a href='".base_url('auth/login')."'>Login</a>";
    }
}