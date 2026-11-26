<?php
$waktu       = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
$waktu_cetak = $waktu->format('d-m-Y H:i');
$tanggal_ttd = $waktu->format('d-m-Y');
$pencetak    = !empty($username) ? $username : 'Guest';

$total_hasil = count($hasil_filter);

$tgl = function ($v) {
    return (!empty($v) && strpos($v, '0000') !== 0) ? date('d-m-Y', strtotime($v)) : '-';
};
?>
<!DOCTYPE html>
<html lang="id" spellcheck="false">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title><?= html_escape($title); ?></title>
    <style>
        ::spelling-error { text-decoration: none !important; }
        ::grammar-error { text-decoration: none !important; }

        @page { size: A4 landscape; margin: 0; }
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #e5e7eb;
            font-family: Calibri, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ===== TOMBOL ===== */
        .tombol { text-align: center; padding: 14px 0 4px; }
        .tombol button {
            padding: 8px 22px; font-size: 13px; font-family: inherit;
            border: 1px solid #1f2937; border-radius: 4px; cursor: pointer;
        }
        .tombol .utama { background: #1f2937; color: #fff; }
        .tombol .biasa { background: #fff; color: #1f2937; margin-left: 6px; }

        /* ===== KERTAS ===== */
        .kertas {
            width: 100%; max-width: 1120px;
            margin: 14px auto 28px;
            background: #fff; padding: 24px 28px 28px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.25);
        }

        table { border-collapse: collapse; }
        table.halaman { width: 100%; }
        table.halaman > thead > tr > td,
        table.halaman > tfoot > tr > td,
        table.halaman > tbody > tr > td { padding: 0; border: none; }
        .ruang { height: 0; }

        /* ===== KOP ===== */
        table.kop { width: 100%; }
        table.kop td { padding: 0; text-align: center; }
        table.kop td.instansi { font-size: 15px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.6px; }
        table.kop td.badan { font-size: 11px; }
        table.kop td.alamat { font-size: 10px; color: #333; }
        table.kop td.kontak { font-size: 10px; color: #333; padding-bottom: 8px; border-bottom: 2px solid #000; }

        table.judul { width: 100%; margin: 8px 0 6px; }
        table.judul td { padding: 0; text-align: center; }
        table.judul td.laporan { font-size: 15px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.6px; }
        table.judul td.periode { font-size: 12px; padding-top: 2px; }
        table.judul td.filter-info { font-size: 11px; padding-top: 4px; color: #444; }

        /* ===== BARIS INFO ===== */
        table.info { width: 100%; margin-bottom: 12px; }
        table.info td { padding: 0; font-size: 10.5px; }

        /* ===== TABEL UMUM ===== */
        table.agenda { width: 100%; table-layout: fixed; border: 1.5px solid #000; }
        table.agenda th, table.agenda td {
            padding: 5px 6px;
            vertical-align: middle;
            word-wrap: break-word;
            line-height: 1.3;
        }
        table.agenda thead { display: table-header-group; }
        table.agenda tr { page-break-inside: avoid; break-inside: avoid; }

        /* ----- Tabel Surat Masuk (Jika tipe = masuk) ----- */
        table.masuk { font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11px; }
        table.masuk thead th {
            background: #e5e7eb; border: 1px solid #000; text-align: center;
            font-size: 10.5px; font-weight: bold; text-transform: uppercase;
            letter-spacing: 0.3px; padding: 6px 4px;
        }
        table.masuk thead tr.nomor th {
            background: #f3f4f6; font-size: 9px; font-weight: normal;
            line-height: 11px; height: 14px; padding: 1px 4px;
        }
        table.masuk tbody td {
            border-left: 1px solid #000; border-right: 1px solid #000;
            border-bottom: 1px solid #9ca3af;
        }
        table.masuk tbody tr:nth-child(even) td { background: #f9fafb; }
        table.masuk tbody tr:last-child td { border-bottom: 1.5px solid #000; }

        /* ----- Tabel Surat Keluar (Jika tipe = keluar) ----- */
        table.keluar { font-family: 'Times New Roman', Times, serif; font-size: 12px; }
        table.keluar thead th {
            border: 1px solid #000; text-align: center;
            font-size: 12px; font-weight: normal; padding: 6px 4px;
        }
        table.keluar thead tr.nomor th {
            font-size: 11px; line-height: 13px; height: 15px; padding: 1px 4px;
        }
        table.keluar tbody td {
            border-left: 1px solid #000; border-right: 1px solid #000;
            border-bottom: 1px solid #777;
        }
        table.keluar tbody tr:last-child td { border-bottom: 1.5px solid #000; }

        .tengah { text-align: center; }
        .nowrap { white-space: nowrap; }
        .kosong { text-align: center; padding: 20px 8px; font-style: italic; color: #555; }
        .total-info { margin-top: 6px; font-size: 11px; font-weight: bold; }

        /* ===== TANDA TANGAN ===== */
        table.ttd-tabel { width: 100%; margin-top: 20px; page-break-inside: avoid; break-inside: avoid; }
        table.ttd-tabel td { padding: 0; vertical-align: bottom; }
        .catatan-cetak { font-size: 9.5px; color: #444; line-height: 1.5; }
        .ttd { text-align: center; font-size: 11.5px; width: 250px; }
        .ttd .ruang-ttd { height: 44px; }
        .ttd .garis { border-bottom: 1px solid #000; margin: 0 20px; }
        .ttd .nip { margin-top: 4px; font-size: 10.5px; }

        /* ===== CETAK ===== */
        @media print {
            body { background: #fff; }
            .tombol { display: none; }
            .kertas { max-width: none; margin: 0; padding: 0 12mm; box-shadow: none; }
            .ruang { height: 12mm; }
            * { text-decoration-skip-ink: none; }
        }

        @media screen and (max-width: 900px) {
            .kertas { padding: 14px; overflow-x: auto; }
            table.agenda { min-width: 860px; }
        }
    </style>
</head>
<body spellcheck="false">

<div class="tombol">
    <button class="utama" onclick="window.print()">Cetak / Simpan sebagai PDF</button>
    <button class="biasa" onclick="window.close()">Tutup</button>
</div>

<div class="kertas">
<table class="halaman">
    <thead><tr><td><div class="ruang"></div></td></tr></thead>
    <tfoot><tr><td><div class="ruang"></div></td></tr></tfoot>
    <tbody><tr><td>

        <!-- ===== KOP ===== -->
        <table class="kop" cellspacing="0" cellpadding="0">
            <tr><td class="instansi" align="center">Perumda Air Minum Tirta Khatulistiwa</td></tr>
            <tr><td class="badan" align="center">Perusahaan Umum Daerah Air Minum</td></tr>
            <tr><td class="alamat" align="center">Jl. Imam Bonjol No. 430, Pontianak, Kalimantan Barat 78243</td></tr>
            <tr><td class="kontak" align="center">Telp. (0561) 769999 &nbsp;|&nbsp; Email: humas@pdamtirtakhatulistiwa.com</td></tr>
        </table>

        <!-- ===== JUDUL LAPORAN & INFO FILTER ===== -->
        <table class="judul" cellspacing="0" cellpadding="0">
            <tr><td class="laporan" align="center">Laporan Surat <?= ucfirst($tipe); ?></td></tr>
            <tr><td class="periode" align="center">Periode: <?= html_escape($nama_bulan . ' ' . $tahun); ?></td></tr>
            <tr>
                <td class="filter-info" align="center">
                    Bagian: <strong><?= !empty($nama_bagian) ? html_escape($nama_bagian) : 'Semua Bagian'; ?></strong> &nbsp;|&nbsp; 
                    Status: <strong><?= !empty($status) ? ucfirst(html_escape($status)) : 'Semua Status'; ?></strong>
                </td>
            </tr>
        </table>

        <table class="info" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left">Total Data: <strong><?= $total_hasil; ?></strong> surat</td>
                <td align="right">Dicetak: <?= $waktu_cetak; ?> WIB oleh <?= html_escape($pencetak); ?></td>
            </tr>
        </table>

        <!-- ============================================================
             KONDISI 1: JIKA TIPE = MASUK
             ============================================================ -->
        <?php if ($tipe == 'masuk'): ?>
            <table class="agenda masuk" cellspacing="0" cellpadding="4">
                <colgroup>
                    <col width="8%"  style="width:8%;">
                    <col width="9%"  style="width:9%;">
                    <col width="13%" style="width:13%;">
                    <col width="8%"  style="width:8%;">
                    <col width="20%" style="width:20%;">
                    <col width="15%" style="width:15%;">
                    <col width="13%" style="width:13%;">
                    <col width="8%"  style="width:8%;">
                    <col width="6%"  style="width:6%;">
                </colgroup>
                <thead>
                    <tr>
                        <th valign="middle" align="center">Tanggal<br>Terima</th>
                        <th valign="middle" align="center">No.<br>Agenda</th>
                        <th valign="middle" align="center">No.<br>Surat</th>
                        <th valign="middle" align="center">Tgl.<br>Surat</th>
                        <th valign="middle" align="center">Isi<br>Ringkas</th>
                        <th valign="middle" align="center">Dari</th>
                        <th valign="middle" align="center">Kepada</th>
                        <th valign="middle" align="center">Kode<br>Klasifikasi</th>
                        <th valign="middle" align="center">Ket.</th>
                    </tr>
                    <tr class="nomor">
                        <th valign="middle" align="center">1</th><th valign="middle" align="center">2</th>
                        <th valign="middle" align="center">3</th><th valign="middle" align="center">4</th>
                        <th valign="middle" align="center">5</th><th valign="middle" align="center">6</th>
                        <th valign="middle" align="center">7</th><th valign="middle" align="center">8</th>
                        <th valign="middle" align="center">9</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($hasil_filter)): ?>
                        <tr><td colspan="9" class="kosong" align="center">Tidak ada data surat masuk yang sesuai filter</td></tr>
                    <?php else: ?>
                        <?php foreach ($hasil_filter as $s): ?>
                        <tr>
                            <td valign="middle" align="center" class="tengah nowrap"><?= $tgl($s->tgl_terima); ?></td>
                            <td valign="middle" align="center" class="tengah nowrap"><?= html_escape($s->no_agenda); ?></td>
                            <td valign="middle" align="left"><?= html_escape($s->no_surat_asal); ?></td>
                            <td valign="middle" align="center" class="tengah nowrap"><?= $tgl($s->tgl_surat); ?></td>
                            <td valign="middle" align="left"><?= html_escape($s->perihal); ?></td>
                            <td valign="middle" align="left"><?= html_escape($s->pengirim); ?></td>
                            <td valign="middle" align="left"><?= !empty($s->kepada) ? implode('<br>', array_map('html_escape', explode('||', $s->kepada))) : '-'; ?></td>
                            <td valign="middle" align="center" class="tengah"><?= !empty($s->kode_klasifikasi) ? html_escape($s->kode_klasifikasi) : '-'; ?></td>
                            <td valign="middle" align="center" class="tengah"><?= ucfirst(html_escape(!empty($s->sifat_surat) ? $s->sifat_surat : 'biasa')); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="total-info">Total Surat Masuk: <strong><?= $total_hasil; ?></strong> surat</div>

        <!-- ============================================================
             KONDISI 2: JIKA TIPE = KELUAR
             ============================================================ -->
        <?php else: ?>
            <table class="agenda keluar" cellspacing="0" cellpadding="4">
                <colgroup>
                    <col width="5%"  style="width:5%;">
                    <col width="15%" style="width:15%;">
                    <col width="10%" style="width:10%;">
                    <col width="22%" style="width:22%;">
                    <col width="28%" style="width:28%;">
                    <col width="8%"  style="width:8%;">
                    <col width="12%" style="width:12%;">
                </colgroup>
                <thead>
                    <tr>
                        <th rowspan="2" valign="middle" align="center">No</th>
                        <th colspan="2" valign="middle" align="center">Surat</th>
                        <th rowspan="2" valign="middle" align="center">Kepada</th>
                        <th rowspan="2" valign="middle" align="center">Perihal</th>
                        <th rowspan="2" valign="middle" align="center">Lampiran</th>
                        <th rowspan="2" valign="middle" align="center">Ket.</th>
                    </tr>
                    <tr>
                        <th valign="middle" align="center">Nomor dan Kode Surat</th>
                        <th valign="middle" align="center">Tanggal Surat</th>
                    </tr>
                    <tr class="nomor">
                        <th valign="middle" align="center">1</th><th valign="middle" align="center">2</th>
                        <th valign="middle" align="center">3</th><th valign="middle" align="center">4</th>
                        <th valign="middle" align="center">5</th><th valign="middle" align="center">6</th>
                        <th valign="middle" align="center">7</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($hasil_filter)): ?>
                        <tr><td colspan="7" class="kosong" align="center">Tidak ada data surat keluar yang sesuai filter</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($hasil_filter as $s): ?>
                        <?php $jml_lampiran = (int) ($s->jumlah_lampiran ?? 0); ?>
                        <tr>
                            <td valign="middle" align="center" class="tengah"><?= $no++; ?></td>
                            <td valign="middle" align="left"><?= html_escape($s->no_surat); ?></td>
                            <td valign="middle" align="center" class="tengah nowrap"><?= $tgl($s->tgl_surat); ?></td>
                            <td valign="middle" align="left"><?= html_escape($s->tujuan); ?></td>
                            <td valign="middle" align="left"><?= html_escape($s->perihal); ?></td>
                            <td valign="middle" align="center" class="tengah"><?= $jml_lampiran > 0 ? $jml_lampiran . ' berkas' : '-'; ?></td>
                            <td valign="middle" align="center" class="tengah"><?= !empty($s->status) ? ucfirst(html_escape($s->status)) : '-'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="total-info">Total Surat Keluar: <strong><?= $total_hasil; ?></strong> surat</div>
        <?php endif; ?>

        <!-- ===== TANDA TANGAN ===== -->
        <table class="ttd-tabel" cellspacing="0" cellpadding="0">
            <tr>
                <td class="catatan-cetak" align="left">
                    Keterangan: Dicetak otomatis berdasarkan filter yang dipilih.<br>
                    <?= ($tipe == 'masuk') ? 'Ket. = sifat surat, Kepada = penerima disposisi.' : 'Lampiran = jumlah file, Ket. = status surat.'; ?>
                </td>
                <td class="ttd" align="center" width="250">
                    <div>Pontianak, <?= $tanggal_ttd; ?></div>
                    <div>Kepala Unit Administrasi</div>
                    <div class="ruang-ttd"></div>
                    <div class="garis"></div>
                    <div class="nip">NIP. ........................</div>
                </td>
            </tr>
        </table>

    </td></tr></tbody>
</table>
</div>

</body>
</html>