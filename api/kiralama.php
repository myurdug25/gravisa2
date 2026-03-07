<?php
/**
 * Kiralama Talebi API
 * POST ile form verisi alır, e-posta gönderir, JSON dosyasına kaydeder
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/Mailer.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Sadece POST istekleri kabul edilir.'], 405);
}

$raw = file_get_contents('php://input');
$input = [];
if (!empty($_POST)) {
    $input = $_POST;
} elseif (!empty($raw)) {
    $decoded = json_decode($raw, true);
    $input = is_array($decoded) ? $decoded : [];
}

$adSoyad = sanitize($input['ad_soyad'] ?? '');
$email = sanitize($input['email'] ?? '');
$telefon = sanitize($input['telefon'] ?? '');
$lokasyon = sanitize($input['lokasyon'] ?? '');
$sure = sanitize($input['sure'] ?? '');
$operator = sanitize($input['operator'] ?? '');
$baslangic = sanitize($input['baslangic'] ?? '');
$bitis = sanitize($input['bitis'] ?? '');
$model = sanitize($input['model'] ?? '');
$makineId = sanitize($input['makine_id'] ?? '');
$makineModel = sanitize($input['makine_model'] ?? '');
$firma = sanitize($input['firma'] ?? '');
$not = sanitize($input['not'] ?? '');

if (empty($adSoyad) || empty($email) || empty($telefon) || empty($lokasyon) || empty($sure) || empty($operator)) {
    jsonResponse(['success' => false, 'message' => 'Lütfen zorunlu alanları doldurun.'], 400);
}

if (!validateEmail($email)) {
    jsonResponse(['success' => false, 'message' => 'Geçerli bir e-posta adresi girin.'], 400);
}

$data = [
    'ad_soyad' => $adSoyad,
    'email' => $email,
    'telefon' => $telefon,
    'lokasyon' => $lokasyon,
    'sure' => $sure,
    'operator' => $operator,
    'baslangic' => $baslangic,
    'bitis' => $bitis,
    'model' => $model,
    'makine_id' => $makineId,
    'makine_model' => $makineModel,
    'firma' => $firma,
    'not' => $not,
];

$id = saveSubmission('kiralama', $data);

$mailer = new Mailer();
$html = $mailer->buildHtmlFromData($data, 'Yeni Kiralama Talebi');
$mailer->setSubject('[Gravisa] Yeni Kiralama Talebi - ' . $adSoyad)
    ->setHtmlBody($html);

$sent = $mailer->send();

jsonResponse([
    'success' => true,
    'message' => 'Kiralama talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.',
    'id' => $id,
]);
