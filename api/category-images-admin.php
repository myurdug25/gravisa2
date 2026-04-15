<?php
/**
 * Admin - Kategori görselleri yönetimi
 * GET  -> { success, items, categories:[{key,label,count}] }
 * POST (multipart):
 *  - action=save, key=..., file=...
 *  - action=delete, key=...
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/security.php';

secureSessionStart();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    jsonResponse(['success' => false, 'message' => 'Yetkisiz.'], 403);
}

function _cat_norm(string $s): string {
    $s = mb_strtolower(trim($s), 'UTF-8');
    $map = ['ğ'=>'g','ü'=>'u','ş'=>'s','ı'=>'i','ö'=>'o','ç'=>'c'];
    $s = strtr($s, $map);
    $s = preg_replace('/\byeralti\b/u', 'yer alti', $s);
    $s = preg_replace('/[^a-z0-9]+/u', '-', $s);
    $s = trim($s, '-');
    return $s !== '' ? $s : 'other';
}

function _load_categories(): array {
    $file = DATA_PATH . '/makineler_admin.json';
    if (!file_exists($file)) return [];
    $items = json_decode(file_get_contents($file), true);
    if (!is_array($items)) return [];
    $groups = [];
    $labelByKey = [];
    foreach ($items as $m) {
        if (!is_array($m)) continue;
        $tip = trim((string)($m['tip'] ?? ''));
        $k = $tip !== '' ? _cat_norm($tip) : 'other';
        if (!isset($groups[$k])) $groups[$k] = 0;
        $groups[$k] += 1;
        if (!isset($labelByKey[$k])) {
            $labelByKey[$k] = $k === 'other' ? 'Diğer' : ($tip !== '' ? $tip : $k);
        }
    }
    $out = [];
    foreach ($groups as $k => $count) {
        $out[] = ['key' => $k, 'label' => $labelByKey[$k] ?? $k, 'count' => (int)$count];
    }
    usort($out, function($a, $b) {
        if ($a['key'] === 'other' && $b['key'] !== 'other') return 1;
        if ($b['key'] === 'other' && $a['key'] !== 'other') return -1;
        return strcasecmp((string)$a['label'], (string)$b['label']);
    });
    return $out;
}

function _store_path_for_key(string $key, string $ext): array {
    $key = preg_replace('/[^a-z0-9-]+/i', '', $key);
    if ($key === '') $key = 'other';
    $ext = strtolower($ext);
    if (!in_array($ext, ['jpg','jpeg','png','webp'], true)) $ext = 'jpg';
    $rel = 'images/categories/' . $key . '.' . $ext;
    $abs = ROOT_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
    return [$rel, $abs];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $items = function_exists('gravisa_get_category_images') ? gravisa_get_category_images() : [];
    $categories = _load_categories();
    jsonResponse(['success' => true, 'items' => (object)$items, 'categories' => $categories]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Sadece GET/POST kabul edilir.'], 405);
}

if (!validateCsrf()) {
    jsonResponse(['success' => false, 'message' => 'Güvenlik doğrulaması başarısız.'], 403);
}

$action = sanitize($_POST['action'] ?? '');
$key = sanitize($_POST['key'] ?? '');
$key = preg_replace('/[^a-z0-9-]+/i', '', strtolower($key));
if ($key === '') {
    jsonResponse(['success' => false, 'message' => 'Kategori anahtarı gerekli.'], 400);
}

$map = function_exists('gravisa_get_category_images') ? gravisa_get_category_images() : [];

if ($action === 'delete') {
    unset($map[$key]);
    if (!function_exists('gravisa_save_category_images')) {
        jsonResponse(['success' => false, 'message' => 'Sunucu bu özelliği desteklemiyor.'], 500);
    }
    gravisa_save_category_images($map);
    jsonResponse(['success' => true, 'items' => (object)$map]);
}

if ($action !== 'save') {
    jsonResponse(['success' => false, 'message' => 'Geçersiz işlem.'], 400);
}

if (empty($_FILES['file']) || !is_array($_FILES['file'])) {
    jsonResponse(['success' => false, 'message' => 'Dosya gerekli.'], 400);
}
$f = $_FILES['file'];
if (!empty($f['error'])) {
    jsonResponse(['success' => false, 'message' => 'Dosya yüklenemedi.'], 400);
}
if (($f['size'] ?? 0) > 8 * 1024 * 1024) {
    jsonResponse(['success' => false, 'message' => 'Dosya 8MB\'dan küçük olmalı.'], 400);
}
$name = (string)($f['name'] ?? '');
$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
[$rel, $abs] = _store_path_for_key($key, $ext);

$dir = dirname($abs);
if (!is_dir($dir)) {
    @mkdir($dir, 0755, true);
}
if (!@move_uploaded_file((string)$f['tmp_name'], $abs)) {
    jsonResponse(['success' => false, 'message' => 'Dosya kaydedilemedi.'], 500);
}

$map[$key] = $rel;
if (!function_exists('gravisa_save_category_images')) {
    jsonResponse(['success' => false, 'message' => 'Sunucu bu özelliği desteklemiyor.'], 500);
}
gravisa_save_category_images($map);
jsonResponse(['success' => true, 'items' => (object)$map, 'saved' => ['key' => $key, 'path' => $rel]]);

