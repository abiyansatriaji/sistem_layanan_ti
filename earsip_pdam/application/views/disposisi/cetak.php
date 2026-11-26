<?php
// ============================================================
// PERSIAPAN DATA
// ============================================================
$nama_hari  = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$nama_bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

// "Selasa, 29 Agustus 2023"
$tgl_lengkap = function ($tgl) use ($nama_hari, $nama_bulan) {
    if (empty($tgl) || $tgl == '0000-00-00' || $tgl == '0000-00-00 00:00:00') return '-';
    $t = strtotime($tgl);
    return $nama_hari[date('w', $t)] . ', ' . date('j', $t) . ' ' . $nama_bulan[(int) date('n', $t)] . ' ' . date('Y', $t);
};
$tgl_pendek = function ($tgl) {
    if (empty($tgl) || $tgl == '0000-00-00' || $tgl == '0000-00-00 00:00:00') return '-';
    return date('d-m-Y', strtotime($tgl));
};

// Sel pihak: jabatan tebal, nama di bawahnya (jika tak ada jabatan: nama tebal, bagian di bawahnya)
$sel_pihak = function ($jabatan, $nama, $bagian) {
    if (empty($nama)) return '<span class="strip">-</span>';
    if (!empty($jabatan)) {
        return '<div class="jab">' . html_escape($jabatan) . '</div><div>' . html_escape($nama) . '</div>';
    }
    $out = '<div class="jab">' . html_escape($nama) . '</div>';
    if (!empty($bagian)) $out .= '<div>' . html_escape($bagian) . '</div>';
    return $out;
};

$label_akhir = ['diterima' => 'Diterima', 'diproses' => 'Dikerjakan', 'selesai' => 'Diselesaikan'];

// Penerima yang belum meneruskan lagi = ujung rantai
$punya_anak = [];
foreach ($riwayat as $r) {
    if (!empty($r->parent_id)) $punya_anak[$r->parent_id] = true;
}

$semua_selesai = !empty($riwayat);
$tgl_selesai_akhir = 0;
$baris = [];

foreach ($riwayat as $r) {
    // Baris: pemegang disposisi -> diteruskan kepada
    $baris[] = [
        'kiri'     => $sel_pihak($r->dari_jabatan ?? '', $r->dari_nama ?? '', $r->dari_bagian ?? ''),
        'tengah'   => $sel_pihak($r->ke_jabatan ?? '', $r->ke_nama ?? '', $r->ke_bagian ?? ''),
        'tanggal'  => $tgl_pendek($r->tgl_disposisi),
        'label'    => 'Disposisi',
        'instruksi'=> $r->instruksi ?? '',
        'catatan'  => $r->catatan ?? ''
    ];

    // Ujung rantai: tambahkan baris tindak lanjut penerima terakhir
    if (empty($punya_anak[$r->id])) {
        if ($r->status != 'selesai') $semua_selesai = false;
        if (!empty($r->tgl_selesai)) $tgl_selesai_akhir = max($tgl_selesai_akhir, strtotime($r->tgl_selesai));

        if (isset($label_akhir[$r->status])) {
            // tanggal: selesai -> tgl_selesai; selain itu -> perubahan status terakhir di log
            $tgl_aksi = '';
            if ($r->status == 'selesai' && !empty($r->tgl_selesai)) {
                $tgl_aksi = $r->tgl_selesai;
            } elseif (!empty($status_log[$r->id])) {
                $tgl_aksi = end($status_log[$r->id])->created_at;
            }
            $baris[] = [
                'kiri'     => $sel_pihak($r->ke_jabatan ?? '', $r->ke_nama ?? '', $r->ke_bagian ?? ''),
                'tengah'   => '<span class="strip">-</span>',
                'tanggal'  => $tgl_pendek($tgl_aksi),
                'label'    => $label_akhir[$r->status],
                'instruksi'=> '',
                'catatan'  => ''
            ];
        }
    }
}

$tgl_penyelesaian = ($semua_selesai && $tgl_selesai_akhir) ? $tgl_lengkap(date('Y-m-d H:i:s', $tgl_selesai_akhir)) : '-';

// "Kepada" = pemegang disposisi pertama (penerima surat di tingkat atas)
$kepada = '-';
if (!empty($riwayat)) {
    $p = $riwayat[0];
    $kepada = trim(($p->dari_jabatan ?? '') . ((!empty($p->dari_jabatan) && !empty($p->dari_nama)) ? ' — ' : '') . ($p->dari_nama ?? ''));
    if ($kepada === '') $kepada = '-';
}

$tingkat = !empty($surat->sifat_surat) ? ucfirst($surat->sifat_surat) : 'Biasa';
$waktu_cetak = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('d-m-Y H:i');
$pencetak    = $this->session->userdata('nama') ?: 'Guest';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi - <?= html_escape($surat->no_agenda ?? ''); ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm;
            @bottom-right { content: "Halaman " counter(page) " dari " counter(pages); font-size: 9px; color: #444; }
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #e5e7eb;
            font-family: Calibri, Arial, Helvetica, sans-serif;
            font-size: 12.5px;
            color: #000;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .tombol { text-align: center; padding: 14px 0 4px; }
        .tombol button {
            padding: 8px 22px; font-size: 13px; font-family: inherit;
            border: 1px solid #1f2937; border-radius: 4px; cursor: pointer;
        }
        .tombol .utama { background: #1f2937; color: #fff; }
        .tombol .biasa { background: #fff; color: #1f2937; margin-left: 6px; }

        .kertas {
            width: 100%;
            max-width: 800px;
            margin: 14px auto 28px;
            background: #fff;
            padding: 22px 24px 26px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.25);
        }

        /* Semua tabel berbingkai tipis seperti formulir */
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        td, th { border: 1px solid #000; padding: 4px 6px; vertical-align: top; word-wrap: break-word; }

        /* ===== KOP ===== */
        .kop { text-align: center; border: 1px solid #000; border-bottom: none; padding: 14px 10px 10px; }
        .kop .instansi {
            font-size: 18px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .kop .sub { font-size: 11px; margin-top: 3px; }

        .judul {
            border: 1px solid #000; text-align: center; font-weight: bold;
            letter-spacing: 0.5px; padding: 4px 0; text-transform: uppercase;
        }

        /* ===== DATA SURAT ===== */
        table.meta { border-top: none; }
        table.meta td.lbl { width: 20%; }
        table.meta td.lbl.sempit { width: 20%; }

        /* ===== RANTAI DISPOSISI ===== */
        table.rantai { margin-top: 10px; }
        table.rantai thead th {
            background: #e5e7eb; text-align: center; font-weight: bold;
            text-transform: uppercase; padding: 5px 4px;
        }
        table.rantai thead { display: table-header-group; }
        table.rantai tr { page-break-inside: avoid; }
        table.rantai td { line-height: 1.35; }
        .jab { font-weight: bold; }
        .strip { display: block; }
        .instruksi {
            margin-top: 4px; font-size: 11.5px; color: #222;
            border-top: 1px dotted #888; padding-top: 3px;
        }
        .ket-tgl { white-space: nowrap; }

        .lampiran { margin-top: 8px; font-size: 11.5px; }
        .cetak-info { margin-top: 6px; font-size: 10px; color: #444; }

        @media print {
            body { background: #fff; }
            .tombol { display: none; }
            .kertas { max-width: none; margin: 0; padding: 0; box-shadow: none; }
        }

        @media (max-width: 700px) {
            .kertas { padding: 12px; overflow-x: auto; }
            table { min-width: 600px; }
        }
    </style>
</head>
<body>

<div class="tombol">
    <button class="utama" onclick="window.print()">Cetak / Simpan sebagai PDF</button>
    <button class="biasa" onclick="window.close()">Tutup</button>
</div>

<div class="kertas">

    <div class="kop">
        <div class="instansi">Perumda Air Minum Tirta Khatulistiwa</div>
        <div class="sub">Sistem E-Arsip Surat</div>
    </div>
    <div class="judul">Lembar Disposisi</div>

    <!-- ===== DATA SURAT ===== -->
    <table class="meta">
        <tr>
            <td class="lbl">Tanggal Register</td>
            <td style="width:30%;"><?= $tgl_lengkap($surat->tgl_terima ?? ''); ?></td>
            <td class="lbl">Tingkat Keamanan</td>
            <td style="width:30%;"><?= html_escape($tingkat); ?></td>
        </tr>
        <tr>
            <td class="lbl">Nomor Agenda</td>
            <td><?= html_escape($surat->no_agenda ?? '-'); ?></td>
            <td class="lbl">Tanggal Penyelesaian</td>
            <td><?= $tgl_penyelesaian; ?></td>
        </tr>
        <tr>
            <td class="lbl">Tanggal/Nomor Surat</td>
            <td colspan="3"><?= $tgl_lengkap($surat->tgl_surat ?? ''); ?> / <?= html_escape($surat->no_surat_asal ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="lbl">Pengirim</td>
            <td colspan="3"><?= html_escape($surat->pengirim ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="lbl">Kepada</td>
            <td colspan="3"><?= html_escape($kepada); ?></td>
        </tr>
        <tr>
            <td class="lbl">Ringkasan</td>
            <td colspan="3"><?= nl2br(html_escape($surat->perihal ?? '-')); ?></td>
        </tr>
        <tr>
            <td class="lbl">Lampiran</td>
            <td colspan="3"><?= count($lampiran) > 0 ? count($lampiran) . ' berkas' : '-'; ?></td>
        </tr>
    </table>

    <!-- ===== RANTAI DISPOSISI ===== -->
    <table class="rantai">
        <colgroup>
            <col style="width:37%;">
            <col style="width:39%;">
            <col style="width:24%;">
        </colgroup>
        <thead>
            <tr>
                <th>Disposisi</th>
                <th>Diteruskan Kepada</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($baris)): ?>
                <tr><td colspan="3" style="text-align:center; padding:18px;">Surat ini belum didisposisikan.</td></tr>
            <?php else: ?>
                <?php foreach ($baris as $b): ?>
                <tr>
                    <td><?= $b['kiri']; ?></td>
                    <td>
                        <?= $b['tengah']; ?>
                        <?php if (!empty($b['instruksi']) || !empty($b['catatan'])): ?>
                        <div class="instruksi">
                            <?php if (!empty($b['instruksi'])): ?>
                                <div><em>Instruksi:</em> <?= nl2br(html_escape($b['instruksi'])); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($b['catatan'])): ?>
                                <div><em>Catatan:</em> <?= nl2br(html_escape($b['catatan'])); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="ket-tgl"><?= $b['tanggal']; ?></div>
                        <div><?= html_escape($b['label']); ?></div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="cetak-info">Dicetak: <?= $waktu_cetak; ?> WIB oleh <?= html_escape($pencetak); ?></div>

</div>

</body>
</html>