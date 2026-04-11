<?php
/**
 * Public - Makineler listesi (auth gerektirmez)
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

header('Content-Type: application/json; charset=utf-8');
// Admin güncellemesi sonrası liste anında güncellensin (eski JSON önbelleği = eski görsel yolu)
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$file = DATA_PATH . '/makineler_admin.json';
$items = [];

if (file_exists($file)) {
    $data = json_decode(file_get_contents($file), true);
    $items = is_array($data) ? $data : [];
}

$root = dirname(__DIR__);
foreach ($items as $i => $it) {
    if (!is_array($it)) {
        continue;
    }
    $rel = isset($it['img']) ? trim((string) $it['img']) : '';
    if ($rel === '' || strpos($rel, '..') !== false) {
        continue;
    }
    $norm = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rel);
    $abs = $root . DIRECTORY_SEPARATOR . $norm;
    if (is_file($abs)) {
        $mtime = @filemtime($abs);
        if ($mtime !== false) {
            $items[$i]['img_mtime'] = $mtime;
        }
    }
}

jsonResponse(['success' => true, 'items' => array_values($items)]);
