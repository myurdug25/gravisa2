<?php
/**
 * Admin - Kategori sayıları (manuel override)
 * GET  -> { success, items, categories:[{key,label,count}] }
 * POST -> action=save|delete, key, count
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/security.php';

secureSessionStart();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    jsonResponse(['success' => false, 'message' => 'Yetkisiz.'], 403);
}

function _cat_norm2(string $s): string {
    $s = mb_strtolower(trim($s), 'UTF-8');
    $map = ['ğ'=>'g','ü'=>'u','ş'=>'s','ı'=>'i','ö'=>'o','ç'=>'c'];
    $s = strtr($s, $map);
    $s = preg_replace('/\byeralti\b/u', 'yer alti', $s);
    $s = preg_replace('/[^a-z0-9]+/u', '-', $s);
    $s = trim($s, '-');
    return $s !== '' ? $s : 'other';
}

function _load_categories2(): array {
    $file = DATA_PATH . '/makineler_admin.json';
    if (!file_exists($file)) return [];
    $items = json_decode(file_get_contents($file), true);
    if (!is_array($items)) return [];
    $groups = [];
    $labelByKey = [];
    foreach ($items as $m) {
        if (!is_array($m)) continue;
        $tip = trim((string)($m['tip'] ?? ''));
        $k = $tip !== '' ? _cat_norm2($tip) : 'other';
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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $items = function_exists('gravisa_get_category_counts') ? gravisa_get_category_counts() : [];
    $categories = _load_categories2();
    jsonResponse(['success' => true, 'items' => (object)$items, 'categories' => $categories]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Sadece GET/POST kabul edilir.'], 405);
}

if (!validateCsrf()) {
    jsonResponse(['success' => false, 'message' => 'Güvenlik doğrulaması başarısız.'], 403);
}

$action = $_POST['action'] ?? '';
$key = preg_replace('/[^a-z0-9-]+/i', '', strtolower((string)($_POST['key'] ?? '')));
if ($key === '') {
    jsonResponse(['success' => false, 'message' => 'Geçersiz kategori key.'], 400);
}

$map = function_exists('gravisa_get_category_counts') ? gravisa_get_category_counts() : [];

if ($action === 'delete') {
    unset($map[$key]);
    if (!function_exists('gravisa_save_category_counts') || !gravisa_save_category_counts($map)) {
        jsonResponse(['success' => false, 'message' => 'Kayıt sırasında hata oluştu.'], 500);
    }
    jsonResponse(['success' => true, 'message' => 'Silindi.']);
}

// save
$count = (int)($_POST['count'] ?? 0);
if ($count < 0) $count = 0;
$map[$key] = $count;
if (!function_exists('gravisa_save_category_counts') || !gravisa_save_category_counts($map)) {
    jsonResponse(['success' => false, 'message' => 'Kayıt sırasında hata oluştu.'], 500);
}
jsonResponse(['success' => true, 'message' => 'Kaydedildi.']);

