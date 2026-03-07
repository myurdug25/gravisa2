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
    return file_put_contents($file, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
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

$imgExisting = trim($_POST['img_existing'] ?? '');
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
    'stok'        => !empty($_POST['stok']) ? true : false,
    'img'         => $imgExisting,
];

// Görsel yükleme
if (!empty($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])) {
    $uploadDir = dirname(__DIR__) . '/assets/uploads/machines';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $origName = $_FILES['img']['name'];
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'jfif'];
    if (!in_array($ext, $allowedExt, true)) {
        jsonResponse(['success' => false, 'message' => 'Sadece JPG, PNG veya WEBP yükleyebilirsiniz.']);
    }
    if (preg_match('/[^a-zA-Z0-9._-]/', $origName)) {
        jsonResponse(['success' => false, 'message' => 'Geçersiz dosya adı.']);
    }
    $filename = 'machine_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $target = $uploadDir . '/' . $filename;
    if (!move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
        jsonResponse(['success' => false, 'message' => 'Görsel yüklenemedi.']);
    }
    $machine['img'] = 'assets/uploads/machines/' . $filename;
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
        $items[] = $machine;
    }
    $message = 'Makine güncellendi.';
}

if (!saveMachines($file, $items)) {
    jsonResponse(['success' => false, 'message' => 'Kayıt sırasında hata oluştu.']);
}

jsonResponse(['success' => true, 'message' => $message, 'items' => array_values($items)]);

