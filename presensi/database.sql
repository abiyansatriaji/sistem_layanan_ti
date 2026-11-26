CREATE DATABASE IF NOT EXISTS presensi_cuti_pdam CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE presensi_cuti_pdam;
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS cuti, presensi, kuota_cuti, hari_libur, users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  nip VARCHAR(30) DEFAULT NULL,
  jabatan VARCHAR(100) DEFAULT NULL,
  role ENUM('super_admin','admin_hr','atasan','pegawai') NOT NULL DEFAULT 'pegawai',
  atasan_id INT DEFAULT NULL,
  aktif TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE presensi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  tanggal DATE NOT NULL,
  jam_masuk DATETIME DEFAULT NULL,
  jam_pulang DATETIME DEFAULT NULL,
  status ENUM('hadir','terlambat') NOT NULL DEFAULT 'hadir',
  UNIQUE KEY uq_user_tanggal (user_id, tanggal),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE kuota_cuti (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  tahun SMALLINT NOT NULL,
  total INT NOT NULL DEFAULT 12,
  terpakai INT NOT NULL DEFAULT 0,
  UNIQUE KEY uq_user_tahun (user_id, tahun),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE hari_libur (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tanggal DATE NOT NULL UNIQUE,
  keterangan VARCHAR(150) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE cuti (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  jenis ENUM('tahunan','sakit','izin') NOT NULL DEFAULT 'tahunan',
  tgl_mulai DATE NOT NULL,
  tgl_selesai DATE NOT NULL,
  jumlah_hari INT NOT NULL,
  alasan TEXT NOT NULL,
  lampiran VARCHAR(255) DEFAULT NULL,
  status ENUM('menunggu','disetujui','ditolak','dibatalkan') NOT NULL DEFAULT 'menunggu',
  catatan_atasan VARCHAR(255) DEFAULT NULL,
  approved_by INT DEFAULT NULL,
  approved_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Password semua akun contoh: password123
INSERT INTO users (id,username,password,nama,nip,jabatan,role,atasan_id) VALUES
(1,'superadmin','$2y$10$/4Njw2XXBcbrohTRBFEDxefYez7SOBnY.3fBfUxHw6VBNl.uevJCi','Super Admin','000001','Administrator Sistem','super_admin',NULL),
(2,'adminhr','$2y$10$/4Njw2XXBcbrohTRBFEDxefYez7SOBnY.3fBfUxHw6VBNl.uevJCi','Rina Kusuma','100002','Staf Kepegawaian','admin_hr',NULL),
(3,'budi.atasan','$2y$10$/4Njw2XXBcbrohTRBFEDxefYez7SOBnY.3fBfUxHw6VBNl.uevJCi','Budi Santoso','100003','Kepala Bagian Teknik','atasan',NULL),
(4,'siti.pegawai','$2y$10$/4Njw2XXBcbrohTRBFEDxefYez7SOBnY.3fBfUxHw6VBNl.uevJCi','Siti Aminah','100004','Staf Pelayanan Pelanggan','pegawai',3),
(5,'andi.pegawai','$2y$10$/4Njw2XXBcbrohTRBFEDxefYez7SOBnY.3fBfUxHw6VBNl.uevJCi','Andi Pratama','100005','Staf Distribusi Air','pegawai',3);

INSERT INTO kuota_cuti (user_id,tahun,total,terpakai) VALUES (1,2026,12,0),(2,2026,12,0),(3,2026,12,0),(4,2026,12,2),(5,2026,12,0);
INSERT INTO hari_libur (tanggal,keterangan) VALUES ('2026-01-01','Tahun Baru Masehi'),('2026-08-17','Hari Kemerdekaan RI'),('2026-12-25','Hari Raya Natal'),('2027-01-01','Tahun Baru Masehi');
INSERT INTO cuti (user_id,jenis,tgl_mulai,tgl_selesai,jumlah_hari,alasan,status) VALUES (4,'tahunan','2026-10-12','2026-10-14',3,'Keperluan keluarga di luar kota','menunggu');
