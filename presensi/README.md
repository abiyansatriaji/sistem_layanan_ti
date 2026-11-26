# Sistem Presensi & Cuti Pegawai (CodeIgniter 3)

Aplikasi lengkap dan siap jalan — folder `system/` CodeIgniter 3.1.13 sudah termasuk.

## Cara pasang (XAMPP / Windows)
1. Salin folder ini ke `C:\xampp\htdocs\presensi-cuti\`
2. Jalankan Apache + MySQL di XAMPP.
3. Buka `http://localhost/phpmyadmin` → **Import** → pilih `database.sql`
   (otomatis membuat database `presensi_cuti_pdam` + data contoh).
4. Buka `http://localhost/presensi-cuti/`

Jika MySQL Anda memakai password, ubah di `application/config/database.php`.
Disarankan PHP 7.4 – 8.1. Butuh internet untuk memuat Bootstrap (CDN).

## Akun contoh (password: `password123`)
| Username | Role |
|---|---|
| superadmin | Super Admin |
| adminhr | Admin HR |
| budi.atasan | Atasan |
| siti.pegawai | Pegawai (atasan: budi.atasan) |
| andi.pegawai | Pegawai (atasan: budi.atasan) |

## Fitur
- Login berbasis role, CSRF aktif, password di-hash
- Absen masuk/pulang (waktu dari server, anti dobel absen, otomatis "terlambat" setelah 08:00 — ubah di `application/config/config.php` → `jam_masuk_batas`)
- Pengajuan cuti/izin: hitung hari kerja otomatis (lewati Sabtu, Minggu, hari libur), cek sisa kuota, lampiran opsional
- Persetujuan atasan (setuju/tolak + catatan), kuota terpotong dalam transaksi DB
- Admin: kelola pegawai, kalender hari libur, rekap bulanan + ekspor CSV (bisa dibuka di Excel)
- Dashboard per role, tampilan responsif (HP & desktop)
