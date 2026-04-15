<?php
/**
 * Public - Kategori görselleri haritası
 * JSON: { success: true, items: { "ekskavator": "images/categories/ekskavator.webp", ... } }
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

if (!function_exists('gravisa_get_category_images')) {
    jsonResponse(['success' => true, 'items' => (object)[]]);
}

$items = gravisa_get_category_images();
jsonResponse(['success' => true, 'items' => (object)$items]);

