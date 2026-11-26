<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Set header untuk Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Laporan_Surat_{$tipe}_{$nama_bulan}_{$tahun}.xls");
header("Cache-Control: max-age=0");

// BOM supaya Excel membaca karakter UTF-8
echo "\xEF\xBB\xBF";
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" 
      xmlns:x="urn:schemas-microsoft-com:office:excel" 
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <meta name="ProgId" content="Excel.Sheet">
    <meta name="Generator" content="Microsoft Excel 15">
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Laporan Surat</x:Name>
                    <x:WorksheetOptions>
                        <x:DisplayGridlines/>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                            <x:PaperSizeIndex>9</x:PaperSizeIndex> <!-- 9 = A4 Landscape -->
                            <x:Scale>85</x:Scale>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
    <style>
        /* ===== STYLE STANDAR EXCEL ===== */
        body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
        
        /* Garis Kotak-kotak (Gridlines) */
        th, td { 
            border: 1px solid #000000; 
            padding: 5px 8px; 
            vertical-align: middle;
        }
        
        /* Header Tabel */
        th {
            background: #d9e1f2; /* Biru muda khas Excel */
            color: #000000;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
            text-transform: uppercase;
        }
        
        td { color: #000000; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }

        /* Baris Selang-seling */
        tr.even td { background: #f9f9f9; }
        tr.odd td { background: #ffffff; }

        /* ===== RINGKASAN & FOOTER ===== */
        .total-row td {
            font-weight: bold;
            background: #e2efda; /* Hijau muda khas Excel */
            text-align: right;
            font-size: 11pt;
        }
        .footer-note { 
            font-size: 9pt; 
            color: #666; 
            padding-top: 10px; 
            font-style: italic; 
            text-align: center;
            border: none;
        }
    </style>
</head>
<body>

<!-- ===== KOP LAPORAN (Menggunakan colspan agar ditengah) ===== -->
<table style="border: none; margin-bottom: 5px;">
    <tr>
        <td colspan="8" align="center" style="text-align: center; font-size: 16pt; font-weight: bold; color: #1e3a5f; border: none; padding-bottom: 5px;">
            PERUMDA AIR MINUM TIRTA KHATULISTIWA
        </td>
    </tr>
    <tr>
        <td colspan="8" align="center" style="text-align: center; font-size: 11pt; color: #666666; border: none;">
            Sistem E-Arsip Surat Digital
        </td>
    </tr>
    <tr>
        <td colspan="8" align="center" style="text-align: center; font-size: 14pt; font-weight: bold; padding-top: 15px; text-transform: uppercase; border: none;">
            LAPORAN SURAT <?= strtoupper($tipe); ?>
        </td>
    </tr>
    <tr>
        <td colspan="8" align="center" style="text-align: center; font-size: 11pt; border: none;">
            Periode: <?= strtoupper($nama_bulan); ?> <?= $tahun; ?>
        </td>
    </tr>
    <tr>
        <td colspan="8" align="center" style="text-align: center; font-size: 10pt; padding-bottom: 15px; font-style: italic; color: #444; border: none;">
            Bagian: <?= !empty($nama_bagian) ? $nama_bagian : 'Semua Bagian'; ?> | 
            Status: <?= !empty($status) ? ucfirst($status) : 'Semua Status'; ?> | 
            Total: <?= $total_hasil; ?> Surat
        </td>
    </tr>
</table>

<!-- ===== TABEL DATA (DINAMIS) ===== -->
<?php if ($tipe == 'masuk'): ?>
<!-- JIKA FILTER = SURAT MASUK -->
<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">No Agenda</th>
            <th width="15%">Pengirim</th>
            <th width="25%">Perihal</th>
            <th width="15%">Kepada</th>
            <th width="10%">Klasifikasi</th>
            <th width="10%">Tgl Terima</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($hasil_filter)): ?>
        <tr><td colspan="8" class="text-center" style="padding: 15px;">Tidak ada data yang sesuai filter</td></tr>
        <?php else: ?>
        <?php $no = 1; foreach ($hasil_filter as $s): ?>
        <tr class="<?= ($no % 2 == 0) ? 'even' : 'odd'; ?>">
            <td class="text-center"><?= $no++; ?></td>
            <td class="text-left"><?= htmlspecialchars($s->no_agenda); ?></td>
            <td class="text-left"><?= htmlspecialchars($s->pengirim); ?></td>
            <td class="text-left"><?= htmlspecialchars($s->perihal); ?></td>
            <td class="text-left">
                <?= !empty($s->kepada) ? implode(', ', array_map('htmlspecialchars', explode('||', $s->kepada))) : '-'; ?>
            </td>
            <td class="text-center"><?= !empty($s->kode_klasifikasi) ? htmlspecialchars($s->kode_klasifikasi) : '-'; ?></td>
            <td class="text-center"><?= date('d-m-Y', strtotime($s->tgl_terima)); ?></td>
            <td class="text-center"><?= ucfirst(htmlspecialchars($s->status)); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        <tr class="total-row">
            <td colspan="8">TOTAL SURAT MASUK: <?= $total_hasil; ?></td>
        </tr>
    </tbody>
</table>

<?php else: ?>
<!-- JIKA FILTER = SURAT KELUAR -->
<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">No Surat</th>
            <th width="15%">Tujuan</th>
            <th width="25%">Perihal</th>
            <th width="10%">Klasifikasi</th>
            <th width="10%">Tgl Surat</th>
            <th width="10%">Lampiran</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($hasil_filter)): ?>
        <tr><td colspan="8" class="text-center" style="padding: 15px;">Tidak ada data yang sesuai filter</td></tr>
        <?php else: ?>
        <?php $no = 1; foreach ($hasil_filter as $s): ?>
        <?php $jml_lampiran = (int) ($s->jumlah_lampiran ?? 0); ?>
        <tr class="<?= ($no % 2 == 0) ? 'even' : 'odd'; ?>">
            <td class="text-center"><?= $no++; ?></td>
            <td class="text-left"><?= htmlspecialchars($s->no_surat); ?></td>
            <td class="text-left"><?= htmlspecialchars($s->tujuan); ?></td>
            <td class="text-left"><?= htmlspecialchars($s->perihal); ?></td>
            <td class="text-center"><?= !empty($s->kode_klasifikasi) ? htmlspecialchars($s->kode_klasifikasi) : '-'; ?></td>
            <td class="text-center"><?= date('d-m-Y', strtotime($s->tgl_surat)); ?></td>
            <td class="text-center"><?= $jml_lampiran > 0 ? $jml_lampiran . ' File' : '-'; ?></td>
            <td class="text-center"><?= ucfirst(htmlspecialchars($s->status)); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        <tr class="total-row">
            <td colspan="8">TOTAL SURAT KELUAR: <?= $total_hasil; ?></td>
        </tr>
    </tbody>
</table>
<?php endif; ?>

<!-- ===== FOOTER ===== -->
<p class="footer-note" align="center" style="text-align: center;">Dicetak otomatis oleh Sistem E-Arsip PDAM pada: <?= date('d-m-Y H:i:s'); ?></p>

</body>
</html>