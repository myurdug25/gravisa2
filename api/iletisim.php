<?php
/**
 * İletişim Formu API
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
$telefon = sanitize($input['telefon'] ?? '');
$email = sanitize($input['email'] ?? '');
$konu = sanitize($input['konu'] ?? '');
$mesaj = sanitize($input['mesaj'] ?? '');

if (empty($adSoyad) || empty($telefon) || empty($konu) || empty($mesaj)) {
    jsonResponse(['success' => false, 'message' => 'Lütfen zorunlu alanları doldurun.'], 400);
}

if (!empty($email) && !validateEmail($email)) {
    jsonResponse(['success' => false, 'message' => 'Geçerli bir e-posta adresi girin.'], 400);
}

$konuLabels = ['satis' => 'Satış Teklifi', 'kiralama' => 'Kiralama', 'servis' => 'Servis / Yedek Parça', 'diger' => 'Diğer'];
$konuText = $konuLabels[$konu] ?? $konu;

$data = [
    'ad_soyad' => $adSoyad,
    'telefon' => $telefon,
    'email' => $email,
    'konu' => $konuText,
    'mesaj' => $mesaj,
];

$id = saveSubmission('iletisim', $data);

$mailer = new Mailer();
$html = $mailer->buildHtmlFromData($data, 'Yeni İletişim Talebi - ' . $konuText);
$mailer->setSubject('[Gravisa] İletişim Talebi - ' . $konuText . ' - ' . $adSoyad)->setHtmlBody($html);
$mailer->send();

jsonResponse([
    'success' => true,
    'message' => 'Mesajınız alındı. En kısa sürede size dönüş yapacağız.',
    'id' => $id,
]);
