<?php
/**
 * Admin - Saha Fotoğrafları CRUD
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/security.php';

secureSessionStart();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    jsonResponse(['success' => false, 'message' => 'Yetkisiz.'], 403);
}

$file = DATA_PATH . '/saha_fotograflari.json';

function loadSahaPhotos(string $file): array
{
    if (!file_exists($file)) {
        return [];
    }
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : [];
}

function saveSahaPhotos(string $file, array $items): bool
{
    ensureDataDir();
    return file_put_contents($file, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $items = loadSahaPhotos($file);
    jsonResponse(['success' => true, 'items' => array_values($items)]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Sadece GET/POST kabul edilir.'], 405);
}

if (!validateCsrf()) {
    jsonResponse(['success' => false, 'message' => 'Güvenlik doğrulaması başarısız.'], 403);
}

$action = $_POST['action'] ?? 'save';
$items = loadSahaPhotos($file);

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if (!$id) {
        jsonResponse(['success' => false, 'message' => 'Geçersiz ID.']);
    }
    $found = false;
    foreach ($items as $idx => $p) {
        if ((int)($p['id'] ?? 0) === $id) {
            $found = true;
            unset($items[$idx]);
            break;
        }
    }
    if (!$found) {
        jsonResponse(['success' => false, 'message' => 'Fotoğraf bulunamadı.']);
    }
    $items = array_values($items);
    if (!saveSahaPhotos($file, $items)) {
        jsonResponse(['success' => false, 'message' => 'Silme sırasında hata oluştu.']);
    }
    jsonResponse(['success' => true, 'message' => 'Fotoğraf silindi.', 'items' => $items]);
}

// save (create/update)
$id = (int)($_POST['id'] ?? 0);

$imgExisting = trim($_POST['img_existing'] ?? '');
$imgPath = trim($_POST['img_path'] ?? '');
$allowedImgPrefixes = ['images/saha/', 'images/saha-fotograflari/', 'assets/uploads/'];
$imgExisting = sanitizeImagePath($imgExisting, $allowedImgPrefixes);
$imgPath = sanitizeImagePath($imgPath, $allowedImgPrefixes);

$photo = [
    'id'          => $id,
    'title'       => sanitize($_POST['title'] ?? '', 200),
    'description' => sanitize($_POST['description'] ?? '', 500),
    'img'         => $imgExisting,
    'sort_order'  => (int)($_POST['sort_order'] ?? 0),
];

// Görsel yükleme
if (!empty($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])) {
    $uploadDir = dirname(__DIR__) . '/images/saha';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $origName = $_FILES['img']['name'];
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'jfif'];
    if (!in_array($ext, $allowedExt, true)) {
        jsonResponse(['success' => false, 'message' => 'Sadece JPG, PNG veya WEBP yükleyebilirsiniz.']);
    }
    $filename = 'saha_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $target = $uploadDir . '/' . $filename;
    if (!move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
        jsonResponse(['success' => false, 'message' => 'Görsel yüklenemedi.']);
    }
    $photo['img'] = 'images/saha/' . $filename;
}

// Mevcut images klasöründen seçim (path ile)
if ($imgPath !== '' && empty($_FILES['img']['tmp_name']) && empty($photo['img'])) {
    $photo['img'] = $imgPath;
}

// Yeni ID
if ($id <= 0) {
    $maxId = 0;
    foreach ($items as $p) {
        $pid = (int)($p['id'] ?? 0);
        if ($pid > $maxId) $maxId = $pid;
    }
    $photo['id'] = $maxId + 1;
    $items[] = $photo;
    $message = 'Fotoğraf eklendi.';
} else {
    $updated = false;
    foreach ($items as $idx => $p) {
        if ((int)($p['id'] ?? 0) === $id) {
            $photo['id'] = $id;
            if ($photo['img'] === '' && !empty($p['img'])) {
                $photo['img'] = $p['img'];
            }
            $items[$idx] = $photo;
            $updated = true;
            break;
        }
    }
    if (!$updated) {
        $items[] = $photo;
    }
    $message = 'Fotoğraf güncellendi.';
}

if (!saveSahaPhotos($file, $items)) {
    jsonResponse(['success' => false, 'message' => 'Kayıt sırasında hata oluştu.']);
}

jsonResponse(['success' => true, 'message' => $message, 'items' => array_values($items)]);
