<?php
/**
 * Servis / Yedek Parça Talebi API
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
$input = !empty($_POST) ? $_POST : (is_array(json_decode($raw, true)) ? json_decode($raw, true) : []);

if (isHoneypotFilled($input)) {
    jsonResponse(['success' => true, 'message' => 'Servis talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.'], 200);
}
if (isRateLimitExceeded()) {
    jsonResponse(['success' => false, 'message' => 'Çok fazla deneme. Lütfen bir süre sonra tekrar deneyin.'], 429);
}

$adSoyad     = sanitize($input['ad_soyad'] ?? '');
$telefon     = sanitize($input['telefon'] ?? '');
$email       = sanitize($input['email'] ?? '');
$lokasyon    = sanitize($input['lokasyon'] ?? '');
$servisTuru  = sanitize($input['servis_turu'] ?? '');
$makineModel = sanitize($input['makine_model'] ?? '');
$seriNo      = sanitize($input['seri_no'] ?? '');
$not         = sanitize($input['not'] ?? '');

if (empty($adSoyad) || empty($telefon) || empty($email) || empty($lokasyon) || empty($servisTuru)) {
    jsonResponse(['success' => false, 'message' => 'Lütfen Ad Soyad, Telefon, E-posta, Lokasyon ve Servis Türü alanlarını doldurun.'], 400);
}
if (!validateEmail($email)) {
    jsonResponse(['success' => false, 'message' => 'Geçerli bir e-posta adresi girin.'], 400);
}

$servisLabels = [
    'periyodik' => 'Periyodik Bakım',
    'ariza'     => 'Arıza / Onarım',
    'yedek'     => 'Yedek Parça',
    'diger'     => 'Diğer',
];
$servisTuruText = $servisLabels[$servisTuru] ?? $servisTuru;

$data = [
    'ad_soyad'     => $adSoyad,
    'telefon'      => $telefon,
    'email'        => $email,
    'lokasyon'     => $lokasyon,
    'servis_turu'  => $servisTuruText,
    'makine_model' => $makineModel,
    'seri_no'      => $seriNo,
    'not'          => $not,
];

$id = saveSubmission('servis', $data);

$mailer = new Mailer();
$html = $mailer->buildHtmlFromData($data, 'Yeni Servis / Yedek Parça Talebi');
$mailer->setSubject('[Gravisa] Servis Talebi - ' . $servisTuruText . ' - ' . $adSoyad)
       ->setReplyTo($email, $adSoyad)
       ->setHtmlBody($html);
$mailer->send();

jsonResponse([
    'success' => true,
    'message' => 'Servis talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.',
    'id' => $id,
]);

