<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pembuat file .xlsx sederhana TANPA library tambahan.
 * Syarat: ekstensi PHP "zip" aktif (di XAMPP: aktifkan extension=zip di php.ini).
 *
 * Dipakai untuk ekspor Buku Agenda Surat Masuk (format kolom sama dengan cetak).
 */

if (!function_exists('xlsx_kolom')) {
    // 0 -> A, 1 -> B, ... 26 -> AA
    function xlsx_kolom($indeks) {
        $huruf = '';
        $n = $indeks + 1;
        while ($n > 0) {
            $m = ($n - 1) % 26;
            $huruf = chr(65 + $m) . $huruf;
            $n = intdiv($n - 1, 26);
        }
        return $huruf;
    }
}

if (!function_exists('xlsx_bersih')) {
    // Buang karakter yang tidak boleh ada di XML, lalu escape
    function xlsx_bersih($teks) {
        $teks = (string) $teks;
        $utf8 = @iconv('UTF-8', 'UTF-8//IGNORE', $teks);
        if ($utf8 !== false) $teks = $utf8;
        $bersih = preg_replace('/[^\x09\x0A\x0D\x20-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $teks);
        if ($bersih !== null) $teks = $bersih;
        return htmlspecialchars($teks, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('xlsx_sel_teks')) {
    function xlsx_sel_teks($ref, $teks, $gaya) {
        if ($teks === null || $teks === '') {
            return '<c r="' . $ref . '" s="' . $gaya . '"/>';
        }
        return '<c r="' . $ref . '" s="' . $gaya . '" t="inlineStr"><is><t xml:space="preserve">'
             . xlsx_bersih($teks) . '</t></is></c>';
    }
}

if (!function_exists('xlsx_sel_angka')) {
    function xlsx_sel_angka($ref, $angka, $gaya) {
        if ($angka === null) return '<c r="' . $ref . '" s="' . $gaya . '"/>';
        return '<c r="' . $ref . '" s="' . $gaya . '"><v>' . $angka . '</v></c>';
    }
}

if (!function_exists('xlsx_serial_tanggal')) {
    // 'Y-m-d' (atau datetime) -> nomor seri tanggal Excel; null jika kosong/tidak valid
    function xlsx_serial_tanggal($tgl) {
        if (empty($tgl) || strpos($tgl, '0000') === 0) return null;
        $t = strtotime(substr($tgl, 0, 10) . ' 00:00:00 UTC');
        if ($t === false) return null;
        return (int) floor($t / 86400) + 25569;
    }
}

if (!function_exists('xlsx_xml_styles')) {
    // Gaya sel: 0 normal, 1 kop, 2 judul, 3 info, 4 header, 5 nomor kolom,
    // 6 isi rata kiri, 7 isi rata tengah, 8 tanggal (dd-mm-yyyy)
    function xlsx_xml_styles() {
        $styles = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<numFmts count="1"><numFmt numFmtId="164" formatCode="dd\-mm\-yyyy"/></numFmts>'
            . '<fonts count="6">'
            . '<font><sz val="11"/><name val="Calibri"/><family val="2"/></font>'
            . '<font><b/><sz val="12"/><name val="Calibri"/><family val="2"/></font>'
            . '<font><b/><sz val="15"/><name val="Calibri"/><family val="2"/></font>'
            . '<font><b/><sz val="11"/><name val="Calibri"/><family val="2"/></font>'
            . '<font><sz val="9"/><name val="Calibri"/><family val="2"/></font>'
            . '<font><sz val="10"/><name val="Calibri"/><family val="2"/></font>'
            . '</fonts>'
            . '<fills count="4">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFE5E7EB"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFF3F4F6"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="2">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border><left style="thin"><color rgb="FF000000"/></left><right style="thin"><color rgb="FF000000"/></right>'
            . '<top style="thin"><color rgb="FF000000"/></top><bottom style="thin"><color rgb="FF000000"/></bottom><diagonal/></border>'
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="9">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="5" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment horizontal="left" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="3" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="4" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="left" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';

        return $styles;
    }
}

if (!function_exists('xlsx_xml_sheet')) {
    // Merakit XML satu sheet. $beku = jumlah baris yang dibekukan (judul tabel)
    function xlsx_xml_sheet($lebar_kolom, $baris, $merge, $kol_akhir, $baris_akhir, $beku = 0) {
        $cols = '';
        foreach ($lebar_kolom as $i => $lebar) {
            $cols .= '<col min="' . ($i + 1) . '" max="' . ($i + 1) . '" width="' . $lebar . '" customWidth="1"/>';
        }

        $merge_xml = '<mergeCells count="' . count($merge) . '">';
        foreach ($merge as $m) $merge_xml .= '<mergeCell ref="' . $m . '"/>';
        $merge_xml .= '</mergeCells>';

        // Pembekuan baris (freeze panes) dimatikan secara bawaan ($beku = 0): area beku yang
        // tinggi membuat tampilan terlihat "terpisah" saat di-zoom atau digulir.
        $tampilan = '<sheetView workbookViewId="0"/>';
        if ($beku > 0) {
            $atas = $beku + 1;
            $tampilan = '<sheetView workbookViewId="0">'
                . '<pane ySplit="' . $beku . '" topLeftCell="A' . $atas . '" activePane="bottomLeft" state="frozen"/>'
                . '<selection pane="bottomLeft" activeCell="A' . $atas . '" sqref="A' . $atas . '"/>'
                . '</sheetView>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetPr><pageSetUpPr fitToPage="1"/></sheetPr>'
            . '<dimension ref="A1:' . $kol_akhir . $baris_akhir . '"/>'
            . '<sheetViews>' . $tampilan . '</sheetViews>'
            . '<sheetFormatPr defaultRowHeight="15"/>'
            . '<cols>' . $cols . '</cols>'
            . '<sheetData>' . implode('', $baris) . '</sheetData>'
            . $merge_xml
            . '<printOptions horizontalCentered="1"/>'
            . '<pageMargins left="0.4" right="0.4" top="0.5" bottom="0.5" header="0.3" footer="0.3"/>'
            . '<pageSetup paperSize="9" orientation="landscape" fitToWidth="1" fitToHeight="0"/>'
            // nomor surat seperti "12334" memang disimpan sebagai teks; jangan tandai sebagai kesalahan
            . '<ignoredErrors><ignoredError sqref="A1:' . $kol_akhir . $baris_akhir . '" numberStoredAsText="1"/></ignoredErrors>'
            . '</worksheet>';
    }
}

if (!function_exists('xlsx_sheet_masuk')) {
    // Sheet buku agenda surat masuk (9 kolom). Return ['xml', 'judul_cetak']
    function xlsx_sheet_masuk($surat_masuk, $instansi, $judul, $info) {
        $meta = ['instansi' => $instansi, 'judul' => $judul, 'info' => $info];
        $judul_kolom = ['Tanggal Terima', 'No. Agenda', 'No. Surat', 'Tgl. Surat', 'Isi Ringkas', 'Dari', 'Kepada', 'Kode Klasifikasi', 'Ket.'];
        $lebar_kolom = [14, 15, 22, 14, 38, 26, 26, 14, 12];
        $jml_kolom   = count($judul_kolom);
        $kol_akhir   = xlsx_kolom($jml_kolom - 1); // I

        // Gaya (indeks cellXfs di styles.xml)
        $G_KOP = 1; $G_JUDUL = 2; $G_INFO = 3; $G_HEAD = 4; $G_NOMOR = 5;
        $G_KIRI = 6; $G_TENGAH = 7; $G_TANGGAL = 8;

        $baris = [];
        $merge = [];

        // ----- Baris 1-3: kop -----
        $baris[] = '<row r="1" ht="20" customHeight="1">' . xlsx_sel_teks('A1', $meta['instansi'], $G_KOP) . '</row>';
        $baris[] = '<row r="2" ht="24" customHeight="1">' . xlsx_sel_teks('A2', $meta['judul'], $G_JUDUL) . '</row>';
        $baris[] = '<row r="3" ht="16" customHeight="1">' . xlsx_sel_teks('A3', $meta['info'], $G_INFO) . '</row>';
        $merge[] = 'A1:' . $kol_akhir . '1';
        $merge[] = 'A2:' . $kol_akhir . '2';
        $merge[] = 'A3:' . $kol_akhir . '3';

        // ----- Baris 4: jarak -----
        $baris[] = '<row r="4" ht="6" customHeight="1"/>';

        // ----- Baris 5: judul kolom, baris 6: nomor kolom 1..9 -----
        $sel = '';
        foreach ($judul_kolom as $i => $nama) {
            $sel .= xlsx_sel_teks(xlsx_kolom($i) . '5', $nama, $G_HEAD);
        }
        $baris[] = '<row r="5" ht="32" customHeight="1">' . $sel . '</row>';

        $sel = '';
        for ($i = 0; $i < $jml_kolom; $i++) {
            $sel .= xlsx_sel_angka(xlsx_kolom($i) . '6', $i + 1, $G_NOMOR);
        }
        $baris[] = '<row r="6" ht="15" customHeight="1">' . $sel . '</row>';

        // ----- Data mulai baris 7 -----
        $r = 7;
        if (empty($surat_masuk)) {
            $baris[] = '<row r="7">' . xlsx_sel_teks('A7', 'Belum ada data surat masuk', $G_TENGAH) . '</row>';
            $merge[] = 'A7:' . $kol_akhir . '7';
            $r = 8;
        } else {
            foreach ($surat_masuk as $s) {
                $kepada = !empty($s->kepada) ? str_replace('||', "\n", $s->kepada) : '-';
                $sifat  = !empty($s->sifat_surat) ? ucfirst($s->sifat_surat) : 'Biasa';

                $sel  = xlsx_sel_angka('A' . $r, xlsx_serial_tanggal($s->tgl_terima), $G_TANGGAL);
                $sel .= xlsx_sel_teks('B' . $r, $s->no_agenda, $G_TENGAH);
                $sel .= xlsx_sel_teks('C' . $r, $s->no_surat_asal, $G_KIRI);
                $sel .= xlsx_sel_angka('D' . $r, xlsx_serial_tanggal($s->tgl_surat), $G_TANGGAL);
                $sel .= xlsx_sel_teks('E' . $r, $s->perihal, $G_KIRI);
                $sel .= xlsx_sel_teks('F' . $r, $s->pengirim, $G_KIRI);
                $sel .= xlsx_sel_teks('G' . $r, $kepada, $G_KIRI);
                $sel .= xlsx_sel_teks('H' . $r, !empty($s->kode_klasifikasi) ? $s->kode_klasifikasi : '-', $G_TENGAH);
                $sel .= xlsx_sel_teks('I' . $r, $sifat, $G_TENGAH);

                $baris[] = '<row r="' . $r . '">' . $sel . '</row>';
                $r++;
            }
        }
        $baris_akhir = $r - 1;

        $xml = xlsx_xml_sheet($lebar_kolom, $baris, $merge, $kol_akhir, $baris_akhir);
        return ['xml' => $xml, 'judul_cetak' => '$5:$6'];
    }
}

if (!function_exists('xlsx_sheet_keluar')) {
    // Sheet buku agenda surat keluar (7 kolom, judul 2 tingkat). Return ['xml', 'judul_cetak']
    function xlsx_sheet_keluar($surat_keluar, $instansi, $judul, $info) {
        $lebar_kolom = [6, 26, 14, 34, 46, 12, 14];
        $kol_akhir   = 'G';
        $G_KOP = 1; $G_JUDUL = 2; $G_INFO = 3; $G_HEAD = 4; $G_NOMOR = 5;
        $G_KIRI = 6; $G_TENGAH = 7; $G_TANGGAL = 8;

        $baris = [];
        $merge = [];

        // Kop (baris 1-3) + jarak (baris 4)
        $baris[] = '<row r="1" ht="20" customHeight="1">' . xlsx_sel_teks('A1', $instansi, $G_KOP) . '</row>';
        $baris[] = '<row r="2" ht="24" customHeight="1">' . xlsx_sel_teks('A2', $judul, $G_JUDUL) . '</row>';
        $baris[] = '<row r="3" ht="16" customHeight="1">' . xlsx_sel_teks('A3', $info, $G_INFO) . '</row>';
        $merge[] = 'A1:' . $kol_akhir . '1';
        $merge[] = 'A2:' . $kol_akhir . '2';
        $merge[] = 'A3:' . $kol_akhir . '3';
        $baris[] = '<row r="4" ht="6" customHeight="1"/>';

        // Judul tabel 2 tingkat (baris 5-6): sel yang digabung tetap diberi gaya agar garisnya lengkap
        $baris[] = '<row r="5" ht="20" customHeight="1">'
            . xlsx_sel_teks('A5', 'No', $G_HEAD)
            . xlsx_sel_teks('B5', 'Surat', $G_HEAD)
            . xlsx_sel_teks('C5', '', $G_HEAD)
            . xlsx_sel_teks('D5', 'Kepada', $G_HEAD)
            . xlsx_sel_teks('E5', 'Perihal', $G_HEAD)
            . xlsx_sel_teks('F5', 'Lampiran', $G_HEAD)
            . xlsx_sel_teks('G5', 'Status', $G_HEAD)
            . '</row>';
        $baris[] = '<row r="6" ht="20" customHeight="1">'
            . xlsx_sel_teks('A6', '', $G_HEAD)
            . xlsx_sel_teks('B6', 'Nomor dan Kode Surat', $G_HEAD)
            . xlsx_sel_teks('C6', 'Tanggal Surat', $G_HEAD)
            . xlsx_sel_teks('D6', '', $G_HEAD)
            . xlsx_sel_teks('E6', '', $G_HEAD)
            . xlsx_sel_teks('F6', '', $G_HEAD)
            . xlsx_sel_teks('G6', '', $G_HEAD)
            . '</row>';
        foreach (['A5:A6', 'B5:C5', 'D5:D6', 'E5:E6', 'F5:F6', 'G5:G6'] as $m) $merge[] = $m;

        // Nomor kolom 1..7 (baris 7)
        $sel = '';
        for ($i = 0; $i < 7; $i++) {
            $sel .= xlsx_sel_angka(xlsx_kolom($i) . '7', $i + 1, $G_NOMOR);
        }
        $baris[] = '<row r="7" ht="15" customHeight="1">' . $sel . '</row>';

        // Data mulai baris 8
        $r = 8;
        if (empty($surat_keluar)) {
            $baris[] = '<row r="8">' . xlsx_sel_teks('A8', 'Tidak ada surat keluar pada periode ini', $G_TENGAH) . '</row>';
            $merge[] = 'A8:' . $kol_akhir . '8';
            $r = 9;
        } else {
            $no = 1;
            foreach ($surat_keluar as $s) {
                $jml = (int) ($s->jumlah_lampiran ?? 0);

                $sel  = xlsx_sel_angka('A' . $r, $no++, $G_TENGAH);
                $sel .= xlsx_sel_teks('B' . $r, $s->no_surat, $G_KIRI);
                $sel .= xlsx_sel_angka('C' . $r, xlsx_serial_tanggal($s->tgl_surat), $G_TANGGAL);
                $sel .= xlsx_sel_teks('D' . $r, $s->tujuan, $G_KIRI);
                $sel .= xlsx_sel_teks('E' . $r, $s->perihal, $G_KIRI);
                $sel .= xlsx_sel_teks('F' . $r, $jml > 0 ? $jml . ' berkas' : '-', $G_TENGAH);
                $sel .= xlsx_sel_teks('G' . $r, !empty($s->status) ? ucfirst($s->status) : '-', $G_TENGAH);

                $baris[] = '<row r="' . $r . '">' . $sel . '</row>';
                $r++;
            }
        }
        $baris_akhir = $r - 1;

        $xml = xlsx_xml_sheet($lebar_kolom, $baris, $merge, $kol_akhir, $baris_akhir);
        return ['xml' => $xml, 'judul_cetak' => '$5:$7'];
    }
}

if (!function_exists('xlsx_tulis_paket')) {
    /**
     * Membungkus satu atau beberapa sheet menjadi file .xlsx di folder sementara.
     * @param array $sheets [['nama' => 'Surat Masuk', 'xml' => '...', 'judul_cetak' => '$5:$6'], ...]
     * @return string|false path file sementara
     */
    function xlsx_tulis_paket($sheets) {
        $n = count($sheets);
        $daftar = ''; $nama_def = ''; $rel_sheet = ''; $override_sheet = '';
        foreach ($sheets as $i => $sh) {
            $no = $i + 1;
            $daftar .= '<sheet name="' . $sh['nama'] . '" sheetId="' . $no . '" r:id="rId' . $no . '"/>';
            // judul tabel diulang di setiap halaman saat dicetak
            $nama_def .= '<definedName name="_xlnm.Print_Titles" localSheetId="' . $i . '">\'' . $sh['nama'] . '\'!' . $sh['judul_cetak'] . '</definedName>';
            $rel_sheet .= '<Relationship Id="rId' . $no . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet' . $no . '.xml"/>';
            $override_sheet .= '<Override PartName="/xl/worksheets/sheet' . $no . '.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
        }

        $workbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<bookViews><workbookView/></bookViews>'
            . '<sheets>' . $daftar . '</sheets>'
            . '<definedNames>' . $nama_def . '</definedNames>'
            . '</workbook>';

        $wb_rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . $rel_sheet
            . '<Relationship Id="rId' . ($n + 1) . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';

        $root_rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';

        $content_types = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . $override_sheet
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';

        $tmp = tempnam(sys_get_temp_dir(), 'agenda');
        $zip = new ZipArchive();
        if ($zip->open($tmp, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return false;
        }
        $zip->addFromString('[Content_Types].xml', $content_types);
        $zip->addFromString('_rels/.rels', $root_rels);
        $zip->addFromString('xl/workbook.xml', $workbook);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $wb_rels);
        $zip->addFromString('xl/styles.xml', xlsx_xml_styles());
        foreach ($sheets as $i => $sh) {
            $zip->addFromString('xl/worksheets/sheet' . ($i + 1) . '.xml', $sh['xml']);
        }
        $zip->close();

        return $tmp;
    }
}

if (!function_exists('xlsx_buat_buku_agenda')) {
    /**
     * Buku Agenda Surat Masuk (satu sheet).
     * @param array $surat_masuk hasil M_surat_masuk::get_agenda()
     * @param array $meta        instansi, judul, info
     */
    function xlsx_buat_buku_agenda($surat_masuk, $meta) {
        $s = xlsx_sheet_masuk($surat_masuk, $meta['instansi'], $meta['judul'], $meta['info']);
        return xlsx_tulis_paket([['nama' => 'Buku Agenda', 'xml' => $s['xml'], 'judul_cetak' => $s['judul_cetak']]]);
    }
}

if (!function_exists('xlsx_buat_laporan_periode')) {
    /**
     * Laporan surat per periode: sheet "Surat Masuk" dan sheet "Surat Keluar".
     * @param array $surat_masuk  M_surat_masuk::get_agenda($bulan, $tahun)
     * @param array $surat_keluar M_surat_keluar::get_agenda($bulan, $tahun)
     * @param array $meta         instansi, periode, dicetak
     */
    function xlsx_buat_laporan_periode($surat_masuk, $surat_keluar, $meta) {
        $info_masuk  = $meta['periode'] . '   |   Total surat masuk: ' . count($surat_masuk) . '   |   Dicetak: ' . $meta['dicetak'];
        $info_keluar = $meta['periode'] . '   |   Total surat keluar: ' . count($surat_keluar) . '   |   Dicetak: ' . $meta['dicetak'];

        $m = xlsx_sheet_masuk($surat_masuk, $meta['instansi'], 'LAPORAN SURAT MASUK', $info_masuk);
        $k = xlsx_sheet_keluar($surat_keluar, $meta['instansi'], 'LAPORAN SURAT KELUAR', $info_keluar);

        return xlsx_tulis_paket([
            ['nama' => 'Surat Masuk',  'xml' => $m['xml'], 'judul_cetak' => $m['judul_cetak']],
            ['nama' => 'Surat Keluar', 'xml' => $k['xml'], 'judul_cetak' => $k['judul_cetak']],
        ]);
    }
}

if (!function_exists('xlsx_kirim_unduhan')) {
    // Kirim file sementara ke browser sebagai unduhan lalu hapus
    function xlsx_kirim_unduhan($path, $nama_file) {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $nama_file . '"');
        header('Content-Length: ' . filesize($path));
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        readfile($path);
        @unlink($path);
        exit;
    }
}