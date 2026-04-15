<?php
/**
 * Admin - Makineler CRUD (JSON + opsiyonel görsel upload)
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/security.php';

secureSessionStart();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    jsonResponse(['success' => false, 'message' => 'Yetkisiz.'], 403);
}

$file = DATA_PATH . '/makineler_admin.json';

function loadMachines(string $file): array
{
    if (!file_exists($file)) {
        return [];
    }
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : [];
}

function saveMachines(string $file, array $items): bool
{
    ensureDataDir();
    $json = json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    return file_put_contents($file, $json, LOCK_EX) !== false;
}

/**
 * Listede ve sitede tek satır: aynı kategori (tip) + aynı model (tipModel) yalnızca bir kez.
 * tipModel boşsa aynı kategorideki farklı makineleri birleştirmemek için firma/yıl/güç/kapasite de anahtara girer.
 */
function gravisaMachineTipModelKey(array $m): string
{
    $tip = strtolower(trim((string) ($m['tip'] ?? '')));
    $tm = strtolower(trim((string) ($m['tipModel'] ?? '')));
    if ($tm !== '') {
        return $tip . "\x1e" . $tm;
    }
    $guc = strtolower(str_replace(',', '.', trim((string) ($m['guc'] ?? ''))));
    $gucBirim = strtolower(trim((string) ($m['gucBirim'] ?? '')));
    $kap = strtolower(preg_replace('/\s+/', '', (string) ($m['kapasite'] ?? '')));
    $firma = strtolower(trim((string) ($m['firma'] ?? '')));
    $yil = strtolower(trim((string) ($m['modelYil'] ?? '')));

    return $tip . "\x1e" . $firma . "\x1e" . $yil . "\x1e" . $guc . '|' . $gucBirim . "\x1e" . $kap;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $items = loadMachines($file);
    jsonResponse(['success' => true, 'items' => array_values($items)]);
}

// POST: create/update/delete
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Sadece GET/POST kabul edilir.'], 405);
}

if (!validateCsrf()) {
    jsonResponse(['success' => false, 'message' => 'Güvenlik doğrulaması başarısız.'], 403);
}

$action = $_POST['action'] ?? 'save';
$items = loadMachines($file);

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if (!$id) {
        jsonResponse(['success' => false, 'message' => 'Geçersiz ID.']);
    }
    $found = false;
    foreach ($items as $idx => $m) {
        if ((int)($m['id'] ?? 0) === $id) {
            $found = true;
            unset($items[$idx]);
            break;
        }
    }
    if (!$found) {
        jsonResponse(['success' => false, 'message' => 'Makine bulunamadı.']);
    }
    $items = array_values($items);
    if (!saveMachines($file, $items)) {
        jsonResponse(['success' => false, 'message' => 'Silme sırasında hata oluştu.']);
    }
    jsonResponse(['success' => true, 'message' => 'Makine silindi.', 'items' => $items]);
}

// save (create/update)
$id = (int)($_POST['id'] ?? 0);

$imgExisting = trim((string)($_POST['img_existing'] ?? ''));
$allowedImgPrefixes = ['images/makineler/', 'assets/uploads/machines/'];
$imgExisting = sanitizeImagePath($imgExisting, $allowedImgPrefixes);

$machine = [
    'id'          => $id,
    'no'          => sanitize($_POST['no'] ?? '', 50),
    'tip'         => sanitize($_POST['tip'] ?? '', 100),
    'firma'       => sanitize($_POST['firma'] ?? '', 100),
    'tipModel'    => sanitize($_POST['tipModel'] ?? '', 150),
    'modelYil'    => sanitize($_POST['modelYil'] ?? '', 20),
    'guc'         => sanitize($_POST['guc'] ?? '', 30),
    'gucBirim'    => sanitize($_POST['gucBirim'] ?? '', 20),
    'kapasite'    => sanitize($_POST['kapasite'] ?? '', 100),
    'saseSeriNo'  => sanitize($_POST['saseSeriNo'] ?? '', 100),
    'motorSeriNo' => sanitize($_POST['motorSeriNo'] ?? '', 100),
    'motorMarka'  => sanitize($_POST['motorMarka'] ?? '', 50),
    'motorTip'    => sanitize($_POST['motorTip'] ?? '', 50),
    // Çok satırlı teknik özellikler (örn. "Çalışma Ağırlığı: 12 ton")
    'teknik'      => sanitize($_POST['teknik'] ?? '', 4000),
    'stok'        => !empty($_POST['stok']) ? true : false,
    'img'         => $imgExisting,
];

// Görsel yükleme (site ile aynı klasör: images/makineler — göreli yol tutarlı)
if (!empty($_FILES['img']) && isset($_FILES['img']['tmp_name'])) {
    $err = (int)($_FILES['img']['error'] ?? UPLOAD_ERR_OK);
    if ($err !== UPLOAD_ERR_OK) {
        $errMsg = [
            UPLOAD_ERR_INI_SIZE   => 'Dosya çok büyük (sunucu upload limiti).',
            UPLOAD_ERR_FORM_SIZE  => 'Dosya çok büyük (form limiti).',
            UPLOAD_ERR_PARTIAL    => 'Dosya kısmen yüklendi, tekrar deneyin.',
            UPLOAD_ERR_NO_FILE    => '',
            UPLOAD_ERR_NO_TMP_DIR => 'Sunucu geçici klasörü yok.',
            UPLOAD_ERR_CANT_WRITE => 'Sunucuya yazılamadı (izin).',
            UPLOAD_ERR_EXTENSION  => 'Yükleme bir eklenti tarafından engellendi.',
        ];
        $msg = $errMsg[$err] ?? ('Yükleme hatası kodu: ' . $err);
        if ($msg !== '') {
            jsonResponse(['success' => false, 'message' => $msg]);
        }
    } elseif (is_uploaded_file($_FILES['img']['tmp_name'])) {
        $uploadDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'makineler';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            jsonResponse(['success' => false, 'message' => 'Görsel klasörü oluşturulamadı (images/makineler).']);
        }
        $origName = (string)($_FILES['img']['name'] ?? '');
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'jfif'];
        if (!in_array($ext, $allowedExt, true)) {
            jsonResponse(['success' => false, 'message' => 'Sadece JPG, PNG, WEBP veya JFIF yükleyebilirsiniz.']);
        }
        // Güncellemede dosya adında ID olsun (yanlış makineye yazıldı izlenimi / hata ayıklama)
        $suffix = bin2hex(random_bytes(4));
        if ($id > 0) {
            $filename = 'makine_' . $id . '_' . $suffix . '.' . $ext;
        } else {
            $filename = 'makine_' . time() . '_' . $suffix . '.' . $ext;
        }
        $target = $uploadDir . DIRECTORY_SEPARATOR . $filename;
        if (!move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            jsonResponse(['success' => false, 'message' => 'Görsel diske yazılamadı (izin veya disk).']);
        }
        $probe = @getimagesize($target);
        if ($probe === false) {
            @unlink($target);
            jsonResponse(['success' => false, 'message' => 'Yüklenen dosya geçerli bir resim değil.']);
        }
        $machine['img'] = 'images/makineler/' . $filename;
    }
}

$keyNew = gravisaMachineTipModelKey($machine);
$noNorm = trim((string) $machine['no']);
foreach ($items as $m) {
    $otherId = (int) ($m['id'] ?? 0);
    if ($id > 0 && $otherId === $id) {
        continue;
    }
    if ($noNorm !== '' && trim((string) ($m['no'] ?? '')) === $noNorm) {
        jsonResponse([
            'success' => false,
            'message' => 'Bu envanter numarası (No) zaten kullanılıyor (ID #' . $otherId . '). Listeden o kaydı düzenleyin; yeni satır açmayın.',
        ]);
    }
    if (gravisaMachineTipModelKey($m) === $keyNew) {
        jsonResponse([
            'success' => false,
            'message' => 'Bu kategori ve model zaten kayıtlı (ID #' . $otherId . '). Aynı Tip + Tip/Model ile ikinci satır oluşturulamaz; mevcut kaydı düzenleyin. İki farklı ürünü ayırmak için Tip/Model alanına farklı bir metin yazın (ör. model + kısa not).',
        ]);
    }
}

// Yeni ID
if ($id <= 0) {
    $maxId = 10000;
    foreach ($items as $m) {
        $mid = (int)($m['id'] ?? 0);
        if ($mid > $maxId) $maxId = $mid;
    }
    $machine['id'] = $maxId + 1;
    if ($machine['no'] === '') {
        $machine['no'] = (string)$machine['id'];
    }
    $items[] = $machine;
    $message = 'Makine eklendi.';
} else {
    $updated = false;
    foreach ($items as $idx => $m) {
        if ((int)($m['id'] ?? 0) === $id) {
            $machine['id'] = $id;
            if ($machine['img'] === '' && !empty($m['img'])) {
                $machine['img'] = $m['img'];
            }
            if ($machine['no'] === '' && !empty($m['no'])) {
                $machine['no'] = $m['no'];
            }
            $items[$idx] = $machine;
            $updated = true;
            break;
        }
    }
    if (!$updated) {
        jsonResponse([
            'success' => false,
            'message' => 'Bu ID ile makine bulunamadı. Sayfayı yenileyip tekrar deneyin veya “Yeni makine” ile ekleyin.',
        ]);
    }
    $message = 'Makine güncellendi.';
}

if (!saveMachines($file, $items)) {
    jsonResponse(['success' => false, 'message' => 'Kayıt sırasında hata oluştu.']);
}

$savedId = (int)($machine['id'] ?? 0);
jsonResponse(['success' => true, 'message' => $message, 'items' => array_values($items), 'saved_id' => $savedId]);

