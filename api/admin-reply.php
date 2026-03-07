<?php
/**
 * Admin - Talep cevabı kaydet / müşteriye e-posta gönder
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/Mailer.php';
require_once dirname(__DIR__) . '/includes/security.php';

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

$raw = file_get_contents('php://input');
$input = is_array(json_decode($raw, true)) ? json_decode($raw, true) : [];
$input = array_merge($_POST, $input);

$id = sanitizeSubmissionId(trim($input['id'] ?? ''));
$replyText = sanitize($input['reply'] ?? $input['reply_text'] ?? '', 5000);
$sendEmail = !empty($input['send_email']);

if (!$id || $replyText === '') {
    jsonResponse(['success' => false, 'message' => 'Talep ID ve cevap metni gerekli.']);
}

$parts = explode('_', $id, 2);
$type = $parts[0] ?? '';

// Mevcut talebi al (e-posta gönderilecekse müşteri bilgisi için)
$customerEmail = '';
$customerName = '';
$requestSubject = 'Talebiniz';
if (defined('USE_DB') && USE_DB && defined('DB_NAME') && DB_NAME) {
    require_once dirname(__DIR__) . '/includes/Database.php';
    $data = Database::getSubmissionById($id);
} else {
    $file = DATA_PATH . '/' . $type . '.json';
    $all = file_exists($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
    $data = $all[$id] ?? null;
}
if ($data) {
    $customerEmail = $data['email'] ?? '';
    $customerName = $data['ad_soyad'] ?? $data['name'] ?? 'Müşteri';
    $requestSubject = $data['konu'] ?? $data['model'] ?? 'Talebiniz';
}

$emailSent = false;
if ($sendEmail && $replyText && $customerEmail) {
    $mailer = new Mailer();
    $emailSent = $mailer->sendReplyToCustomer($customerEmail, $customerName, $replyText, $requestSubject);
}

if (!updateSubmissionReply($id, $replyText, $emailSent)) {
    jsonResponse(['success' => false, 'message' => 'Cevap kaydedilemedi.']);
}

jsonResponse([
    'success' => true,
    'message' => $emailSent ? 'Cevap kaydedildi ve müşteriye e-posta gönderildi.' : 'Cevap kaydedildi.',
]);
