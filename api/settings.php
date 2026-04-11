<?php
/**
 * Site ayarları API
 * GET = herkese açık (sadece gösterim için alanlar)
 * POST = sadece admin (ayarları kaydet)
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    $all = getSettings();
    // Frontend için sadece gösterim alanları (mail_to gibi dahili alanları da dönebiliriz; frontend kullanmaz)
    $public = [
        'contact_email'    => $all['contact_email'],
        'servis_email'     => $all['servis_email'],
        'whatsapp_number'  => $all['whatsapp_number'],
        'phone_display'    => $all['phone_display'],
        'address'          => $all['address'],
    ];
    echo json_encode($public, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__DIR__) . '/includes/security.php';
    secureSessionStart();
    if (empty($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        jsonResponse(['success' => false, 'message' => 'Yetkisiz.'], 403);
    }
    if (!validateCsrf()) {
        jsonResponse(['success' => false, 'message' => 'Güvenlik doğrulaması başarısız.'], 403);
    }
    $raw = file_get_contents('php://input');
    $input = is_array(json_decode($raw, true)) ? json_decode($raw, true) : [];
    $input = array_merge($_POST, $input);
    $settings = [
        'contact_email'    => sanitize($input['contact_email'] ?? ''),
        'servis_email'     => sanitize($input['servis_email'] ?? ''),
        'whatsapp_number'  => preg_replace('/\D/', '', $input['whatsapp_number'] ?? ''),
        'phone_display'    => sanitize($input['phone_display'] ?? ''),
        'address'          => sanitize($input['address'] ?? ''),
        'mail_to'          => sanitize($input['mail_to'] ?? ''),
        'mail_from_name'   => sanitize($input['mail_from_name'] ?? ''),
        'mail_from'        => sanitize($input['mail_from'] ?? ''),
        'seo_site_title'   => sanitize($input['seo_site_title'] ?? ''),
        'seo_default_description' => sanitize($input['seo_default_description'] ?? ''),
        'seo_default_keywords'    => sanitize($input['seo_default_keywords'] ?? ''),
        'seo_pages'        => sanitizeJsonPages($input['seo_pages'] ?? ''),
        'prefer_env_contact' => !empty($input['prefer_env_contact']),
    ];
    if (saveSettings($settings)) {
        jsonResponse(['success' => true, 'message' => 'Ayarlar kaydedildi.']);
    }
    $dataPath = defined('DATA_PATH') ? DATA_PATH : '';
    $hint = '';
    if ($dataPath !== '' && (!is_dir($dataPath) || !is_writable($dataPath))) {
        $hint = ' data/ klasörü yazılabilir olmalı (chmod 755 veya 775).';
    }
    jsonResponse(['success' => false, 'message' => 'Kayıt sırasında hata oluştu.' . $hint], 500);
}

jsonResponse(['success' => false, 'message' => 'Geçersiz istek.'], 405);
