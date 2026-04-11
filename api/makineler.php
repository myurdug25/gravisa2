<?php
/**
 * Public - Makineler listesi (auth gerektirmez)
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');

$file = DATA_PATH . '/makineler_admin.json';
$items = [];

if (file_exists($file)) {
    $data = json_decode(file_get_contents($file), true);
    $items = is_array($data) ? $data : [];
    /* img: JSON’daki göreli yol (images/makineler/…) — tarayıcıda window.gravisaAssetUrl + basePath birleştirir */
}

jsonResponse(['success' => true, 'items' => array_values($items)]);
