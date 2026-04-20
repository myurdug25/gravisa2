<?php
/**
 * Admin - Makpark CSV import (mevcut img/stok/teknik alanlarını koruyarak)
 *
 * POST multipart:
 *  - file: CSV (Makpark.xlsx -> CSV olarak kaydedilmiş)
 *  - mode: merge (varsayılan) | replace
 *
 * CSV kolonları (en az):
 *  - NO
 *  - TİP (kategori)  (dosyada bozuk encoding olabilir)
 *  - FIRMA (opsiyonel)
 *  - TİP/PLAKA veya KOD (tipModel için)
 *  - Model (yıl gibi)
 *  - S.No (şasi seri)
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/security.php';
require_once dirname(__DIR__) . '/includes/xlsx-reader.php';

secureSessionStart();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    jsonResponse(['success' => false, 'message' => 'Yetkisiz.'], 403);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Sadece POST kabul edilir.'], 405);
}
if (!validateCsrf()) {
    jsonResponse(['success' => false, 'message' => 'Güvenlik doğrulaması başarısız.'], 403);
}

$mode = $_POST['mode'] ?? 'merge';
if (!in_array($mode, ['merge', 'replace'], true)) {
    $mode = 'merge';
}

if (empty($_FILES['file']) || !isset($_FILES['file']['tmp_name'])) {
    jsonResponse(['success' => false, 'message' => 'Dosya seçin (CSV veya XLSX).'], 400);
}
$err = (int)($_FILES['file']['error'] ?? UPLOAD_ERR_OK);
if ($err !== UPLOAD_ERR_OK) {
    $errMsg = [
        UPLOAD_ERR_INI_SIZE   => 'Dosya çok büyük (sunucu upload limiti).',
        UPLOAD_ERR_FORM_SIZE  => 'Dosya çok büyük (form limiti).',
        UPLOAD_ERR_PARTIAL    => 'Dosya kısmen yüklendi, tekrar deneyin.',
        UPLOAD_ERR_NO_FILE    => 'Dosya seçilmedi.',
        UPLOAD_ERR_NO_TMP_DIR => 'Sunucu geçici klasörü yok.',
        UPLOAD_ERR_CANT_WRITE => 'Sunucuya yazılamadı (izin).',
        UPLOAD_ERR_EXTENSION  => 'Yükleme bir eklenti tarafından engellendi.',
    ];
    jsonResponse(['success' => false, 'message' => ($errMsg[$err] ?? ('Yükleme hatası: ' . $err))], 400);
}
$tmp = $_FILES['file']['tmp_name'];
if (!is_uploaded_file($tmp)) {
    jsonResponse(['success' => false, 'message' => 'Dosya yükleme doğrulanamadı.'], 400);
}
$origName = (string)($_FILES['file']['name'] ?? '');
$ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

$dataFile = DATA_PATH . '/makineler_admin.json';
$current = [];
if (file_exists($dataFile)) {
    $dec = json_decode(file_get_contents($dataFile), true);
    $current = is_array($dec) ? $dec : [];
}

// no -> existing
$byNo = [];
$maxId = 10000;
foreach ($current as $it) {
    if (!is_array($it)) continue;
    $id = (int)($it['id'] ?? 0);
    if ($id > $maxId) $maxId = $id;
    $no = trim((string)($it['no'] ?? ''));
    if ($no !== '') {
        $byNo[$no] = $it;
    }
}

function _norm_header(string $s): string {
    $s = trim(mb_strtolower($s, 'UTF-8'));
    $s = str_replace(['ı','İ'], ['i','i'], $s);
    $s = preg_replace('/\s+/', ' ', $s);
    // Makpark mojibake ihtimalleri için kaba normalize
    $s = strtr($s, ['�' => '', "\xC2\xA0" => ' ']);
    return $s;
}
function _clean_cell($v): string {
    if ($v === null) return '';
    $s = trim((string)$v);
    if ($s === '' || strtolower($s) === 'nan') return '';
    // 1.0 -> 1
    if (preg_match('/^\d+\.0$/', $s)) $s = substr($s, 0, -2);
    return $s;
}

// rows: [ [header...], [row...], ... ]
$rows = [];
if ($ext === 'xlsx') {
    $sheets = function_exists('gravisa_xlsx_read_all_rows') ? gravisa_xlsx_read_all_rows($tmp) : [];
    if (!$sheets) {
        jsonResponse(['success' => false, 'message' => 'XLSX okunamadı (ZipArchive/SimpleXML gerekli). CSV olarak kaydedip deneyin.'], 400);
    }
    // flatten all sheets
    foreach ($sheets as $sheetRows) {
        if (!is_array($sheetRows) || count($sheetRows) < 2) continue;
        // first non-empty header row
        $header = null;
        $start = 0;
        for ($i = 0; $i < count($sheetRows); $i++) {
            $r = $sheetRows[$i];
            if (!is_array($r)) continue;
            $joined = implode('', array_map('trim', $r));
            if ($joined === '') continue;
            $header = $r;
            $start = $i + 1;
            break;
        }
        if (!$header) continue;
        $rows[] = $header;
        for ($i = $start; $i < count($sheetRows); $i++) {
            $r = $sheetRows[$i];
            if (!is_array($r)) continue;
            $rows[] = $r;
        }
    }
    if (count($rows) < 2) {
        jsonResponse(['success' => false, 'message' => 'XLSX içinde okunabilir tablo bulunamadı.'], 400);
    }
} else {
    // CSV oku (utf-8 veya windows-1254 olabilir → best-effort iconv)
    $raw = file_get_contents($tmp);
    if ($raw === false) {
        jsonResponse(['success' => false, 'message' => 'CSV okunamadı.'], 400);
    }
    // BOM temizle
    $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
    $lines = preg_split("/\r\n|\n|\r/", $raw);
    if (!$lines || count($lines) < 2) {
        jsonResponse(['success' => false, 'message' => 'CSV boş görünüyor.'], 400);
    }
    // delimiter tespit
    $firstLine = $lines[0];
    $delim = (substr_count($firstLine, ';') >= substr_count($firstLine, ',')) ? ';' : ',';
    foreach ($lines as $ln) {
        if (trim($ln) === '') continue;
        $rows[] = str_getcsv($ln, $delim);
    }
    if (count($rows) < 2) {
        jsonResponse(['success' => false, 'message' => 'CSV boş görünüyor.'], 400);
    }
}

// header parse
$header = $rows[0];
if (!$header || count($header) < 2) {
    jsonResponse(['success' => false, 'message' => 'Dosya başlığı okunamadı.'], 400);
}
$map = [];
foreach ($header as $idx => $h) {
    $hn = _norm_header((string)$h);
    if ($hn === '') continue;
    $map[$hn] = $idx;
}
// kolon bul (Makpark varyasyonları)
$ixNo = $map['no'] ?? null;
$ixTip = $map['tip'] ?? ($map['tıp'] ?? ($map['t�p'] ?? null));
$ixFirma = $map['firma'] ?? ($map['fırma'] ?? ($map['f�rma'] ?? null));
$ixTipPlaka = $map['tip/plaka'] ?? ($map['tıp/plaka'] ?? ($map['t�p/plaka'] ?? ($map['tip plaka'] ?? ($map['t�p/plaka'] ?? null))));
$ixKod = $map['kod'] ?? null;
$ixModel = $map['model'] ?? null;
$ixSno = $map['s.no'] ?? ($map['s.no '] ?? ($map['sno'] ?? ($map['s.no'] ?? null)));
$ixMtip = $map['m.tipi'] ?? ($map['m.tipi '] ?? ($map['m tipi'] ?? null));

if ($ixNo === null) {
    jsonResponse(['success' => false, 'message' => 'CSV içinde NO kolonu bulunamadı.'], 400);
}
if ($ixTip === null && $ixMtip === null) {
    jsonResponse(['success' => false, 'message' => 'CSV içinde TİP (kategori) kolonu bulunamadı.'], 400);
}

// mevcut alanları koru
function _carry_fields(array $dst, array $src): array {
    foreach (['img','stok','teknik','motorSeriNo','motorMarka','motorTip','guc','gucBirim','kapasite'] as $k) {
        if (array_key_exists($k, $src) && $src[$k] !== null && trim((string)$src[$k]) !== '') {
            $dst[$k] = $src[$k];
        }
    }
    return $dst;
}

$out = [];
$seenNo = [];
$skipped = 0;
$added = 0;
$merged = 0;

for ($i = 1; $i < count($rows); $i++) {
    $row = $rows[$i];
    if (!$row || count($row) < 2) continue;

    $no = _clean_cell($row[$ixNo] ?? '');
    $tip = $ixTip !== null ? _clean_cell($row[$ixTip] ?? '') : '';
    if ($tip === '' && $ixMtip !== null) $tip = _clean_cell($row[$ixMtip] ?? '');
    $firma = $ixFirma !== null ? _clean_cell($row[$ixFirma] ?? '') : '';
    $tipPlaka = $ixTipPlaka !== null ? _clean_cell($row[$ixTipPlaka] ?? '') : '';
    $kod = $ixKod !== null ? _clean_cell($row[$ixKod] ?? '') : '';
    $model = $ixModel !== null ? _clean_cell($row[$ixModel] ?? '') : '';
    $sno = $ixSno !== null ? _clean_cell($row[$ixSno] ?? '') : '';

    // boş satır (NO var ama içerik yok) → atla
    $tipModel = $tipPlaka !== '' ? $tipPlaka : ($kod !== '' ? $kod : '');
    $modelYil = preg_match('/^\d{4}$/', $model) ? $model : '';
    if ($tip === '' && $firma === '' && $tipModel === '' && $modelYil === '' && $sno === '') {
        $skipped++;
        continue;
    }

    if ($no === '') {
        // NO boşsa satır güvenilmez, atla
        $skipped++;
        continue;
    }
    if (!isset($seenNo[$no])) $seenNo[$no] = 0;
    $seenNo[$no] += 1;
    $noFinal = $seenNo[$no] === 1 ? $no : ($no . '-' . $seenNo[$no]);

    $existing = $byNo[$noFinal] ?? null;
    $id = $existing ? (int)($existing['id'] ?? 0) : 0;
    if ($id <= 0) {
        $maxId += 1;
        $id = $maxId;
    }

    $item = [
        'id' => $id,
        'no' => $noFinal,
        'tip' => $tip,
        'firma' => $firma,
        'tipModel' => $tipModel,
        'modelYil' => $modelYil,
        'guc' => '',
        'gucBirim' => '',
        'kapasite' => '',
        'saseSeriNo' => $sno,
        'motorSeriNo' => '',
        'motorMarka' => '',
        'motorTip' => '',
        'teknik' => '',
        'stok' => false,
        'img' => '',
    ];
    if ($existing && $mode === 'merge') {
        $item = _carry_fields($item, $existing);
        $merged++;
    } else {
        $added++;
    }
    $out[] = $item;
}

if (empty($out)) {
    jsonResponse(['success' => false, 'message' => 'CSV içinden kayıt çıkmadı.'], 400);
}

ensureDataDir();
$bak = $dataFile . '.bak_before_csv_import';
@copy($dataFile, $bak);

file_put_contents($dataFile, json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

$imgCount = 0;
foreach ($out as $it) {
    if (!empty(trim((string)($it['img'] ?? '')))) $imgCount++;
}

jsonResponse([
    'success' => true,
    'message' => 'İçe aktarıldı. Kayıt: ' . count($out) . ', görselli: ' . $imgCount . ', birleştirilen: ' . $merged . ', atlanan: ' . $skipped . '.',
    'count' => count($out),
    'img_count' => $imgCount,
    'merged' => $merged,
    'skipped' => $skipped,
]);

