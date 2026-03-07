<?php
/**
 * Satış Teklifi Talebi API
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/Mailer.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Sadece POST istekleri kabul edilir.'], 405);
}

$raw = file_get_contents('php://input');
$input = !empty($_POST) ? $_POST : (is_array(json_decode($raw, true)) ? json_decode($raw, true) : []);

$adSoyad = sanitize($input['ad_soyad'] ?? '');
$email = sanitize($input['email'] ?? '');
$telefon = sanitize($input['telefon'] ?? '');
$firma = sanitize($input['firma'] ?? '');
$model = sanitize($input['model'] ?? '');
$adet = sanitize($input['adet'] ?? '1');
$makineId = sanitize($input['makine_id'] ?? '');
$makineModel = sanitize($input['makine_model'] ?? '');
$not = sanitize($input['not'] ?? '');

if (empty($adSoyad) || empty($email) || empty($telefon)) {
    jsonResponse(['success' => false, 'message' => 'Lütfen Ad Soyad, E-posta ve Telefon alanlarını doldurun.'], 400);
}

if (!validateEmail($email)) {
    jsonResponse(['success' => false, 'message' => 'Geçerli bir e-posta adresi girin.'], 400);
}

$data = [
    'ad_soyad' => $adSoyad,
    'email' => $email,
    'telefon' => $telefon,
    'firma' => $firma,
    'model' => $model,
    'adet' => $adet,
    'makine_id' => $makineId,
    'makine_model' => $makineModel,
    'not' => $not,
];

$id = saveSubmission('satis', $data);

$mailer = new Mailer();
$html = $mailer->buildHtmlFromData($data, 'Yeni Satış Teklifi Talebi');
$mailer->setSubject('[Gravisa] Satış Teklifi Talebi - ' . $adSoyad)->setHtmlBody($html);
$mailer->send();

jsonResponse([
    'success' => true,
    'message' => 'Teklif talebiniz alındı. En kısa sürede size özel teklifimizi ileteceğiz.',
    'id' => $id,
]);
