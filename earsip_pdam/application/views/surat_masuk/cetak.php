<?php
$waktu_cetak = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('d-m-Y H:i');
$pencetak    = $this->session->userdata('nama') ?: 'Guest';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title><?= html_escape($title); ?></title>
    <style>
        /* Margin halaman 0 supaya browser tidak menempelkan tanggal, judul, dan
           alamat web di pojok kertas. Jarak tepi dibuat lewat baris pengisi (.ruang). */
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

        /* ===== TOMBOL (tidak ikut tercetak) ===== */
        .tombol { text-align: center; padding: 14px 0 4px; }
        .tombol button {
            padding: 8px 22px; font-size: 13px; font-family: inherit;
            border: 1px solid #1f2937; border-radius: 4px; cursor: pointer;
        }
        .tombol .utama { background: #1f2937; color: #fff; }
        .tombol .biasa { background: #fff; color: #1f2937; margin-left: 6px; }

        /* ===== KERTAS ===== */
        .kertas {
            width: 100%;
            max-width: 1120px;
            margin: 14px auto 28px;
            background: #fff;
            padding: 24px 28px 28px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.25);
        }

        table { border-collapse: collapse; }
        table.halaman { width: 100%; }
        table.halaman > thead > tr > td,
        table.halaman > tfoot > tr > td,
        table.halaman > tbody > tr > td { padding: 0; border: none; }
        .ruang { height: 0; }

        /* ===== KOP ===== */
        table.kop { width: 100%; margin-bottom: 8px; }
        table.kop td { padding: 0; text-align: center; }
        table.kop td.instansi { font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.6px; }
        table.kop td.judul {
            font-size: 17px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.8px;
            padding: 3px 0 8px; border-bottom: 2px solid #000;
        }

        /* ===== BARIS INFO ===== */
        table.info { width: 100%; margin-bottom: 8px; }
        table.info td { padding: 0; font-size: 10.5px; }

        /* ===== TABEL BUKU AGENDA ===== */
        table.agenda { width: 100%; table-layout: fixed; border: 1.5px solid #000; }
        table.agenda th, table.agenda td {
            padding: 4px 6px;
            vertical-align: middle;
            word-wrap: break-word;
            line-height: 1.3;
        }
        table.agenda thead th {
            background: #e5e7eb;
            border: 1px solid #000;
            text-align: center;
            font-size: 10.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 5px 4px;
        }
        table.agenda thead tr.nomor th {
            background: #f3f4f6;
            font-size: 9px;
            font-weight: normal;
            line-height: 11px;
            height: 14px;
            padding: 1px 4px;
        }
        table.agenda thead { display: table-header-group; }

        table.agenda tbody td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #9ca3af;
        }
        table.agenda tbody tr:nth-child(even) td { background: #f9fafb; }
        table.agenda tbody tr:last-child td { border-bottom: 1.5px solid #000; }
        table.agenda tr { page-break-inside: avoid; break-inside: avoid; }

        .tengah { text-align: center; }
        .nowrap { white-space: nowrap; }
        .kosong { text-align: center; padding: 22px 8px; color: #555; font-style: italic; }

        /* ===== TANDA TANGAN ===== */
        table.ttd-tabel { width: 100%; margin-top: 14px; page-break-inside: avoid; break-inside: avoid; }
        table.ttd-tabel td { padding: 0; vertical-align: bottom; }
        .catatan-cetak { font-size: 9.5px; color: #444; }
        .ttd { text-align: center; font-size: 11px; width: 240px; }
        .ttd .ruang-ttd { height: 44px; }
        .ttd .garis { border-bottom: 1px solid #000; margin: 0 20px; }
        .ttd .jabatan { margin-top: 4px; font-weight: bold; }

        /* ===== CETAK ===== */
        @media print {
            body { background: #fff; }
            .tombol { display: none; }
            .kertas { max-width: none; margin: 0; padding: 0 12mm; box-shadow: none; }
            .ruang { height: 12mm; }
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

        <table class="kop" cellspacing="0" cellpadding="0">
            <tr><td class="instansi" align="center">Perumda Air Minum Tirta Khatulistiwa</td></tr>
            <tr><td class="judul" align="center"><?= html_escape($title); ?></td></tr>
        </table>

        <table class="info" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left">Total surat: <strong><?= $total; ?></strong></td>
                <td align="right">Dicetak: <?= $waktu_cetak; ?> WIB oleh <?= html_escape($pencetak); ?></td>
            </tr>
        </table>

        <table class="agenda" cellspacing="0" cellpadding="4">
            <colgroup>
                <col width="8%"  style="width:8%;">   <!-- 1 Tanggal Terima -->
                <col width="9%"  style="width:9%;">   <!-- 2 No. Agenda -->
                <col width="13%" style="width:13%;">  <!-- 3 No. Surat -->
                <col width="8%"  style="width:8%;">   <!-- 4 Tgl. Surat -->
                <col width="20%" style="width:20%;">  <!-- 5 Isi Ringkas -->
                <col width="15%" style="width:15%;">  <!-- 6 Dari -->
                <col width="13%" style="width:13%;">  <!-- 7 Kepada -->
                <col width="8%"  style="width:8%;">   <!-- 8 Kode Klasifikasi -->
                <col width="6%"  style="width:6%;">   <!-- 9 Ket. -->
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
            <tbody class="data">
                <?php if (empty($surat_masuk)): ?>
                    <tr><td colspan="9" class="kosong" align="center">Belum ada data surat masuk</td></tr>
                <?php else: ?>
                    <?php foreach ($surat_masuk as $s): ?>
                    <tr>
                        <td valign="middle" align="center" class="tengah nowrap"><?= !empty($s->tgl_terima) ? date('d-m-Y', strtotime($s->tgl_terima)) : '-'; ?></td>
                        <td valign="middle" align="center" class="tengah nowrap"><?= html_escape($s->no_agenda); ?></td>
                        <td valign="middle" align="left"><?= html_escape($s->no_surat_asal); ?></td>
                        <td valign="middle" align="center" class="tengah nowrap"><?= !empty($s->tgl_surat) ? date('d-m-Y', strtotime($s->tgl_surat)) : '-'; ?></td>
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

        <table class="ttd-tabel" cellspacing="0" cellpadding="0">
            <tr>
                <td class="catatan-cetak" align="left">Keterangan: Ket. = sifat surat. Kepada = penerima disposisi.</td>
                <td class="ttd" align="center" width="240">
                    <div>Mengetahui,</div>
                    <div class="ruang-ttd"></div>
                    <div class="garis"></div>
                    <div class="jabatan">Kepala Unit Administrasi</div>
                </td>
            </tr>
        </table>

    </td></tr></tbody>
</table>
</div>

</body>
</html>