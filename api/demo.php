<?php
/**
 * Demo Makine Talebi API
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

if (isHoneypotFilled($input)) {
    jsonResponse(['success' => true, 'message' => 'Demo talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.'], 200);
}
if (isRateLimitExceeded()) {
    jsonResponse(['success' => false, 'message' => 'Çok fazla deneme. Lütfen bir süre sonra tekrar deneyin.'], 429);
}

$name = sanitize($input['name'] ?? '');
$phone = sanitize($input['phone'] ?? '');
$email = sanitize($input['email'] ?? '');
$machine = sanitize($input['machine'] ?? '');
$date = sanitize($input['date'] ?? '');
$note = sanitize($input['note'] ?? '');

if (empty($name) || empty($phone) || empty($email) || empty($machine)) {
    jsonResponse(['success' => false, 'message' => 'Lütfen Ad Soyad, Telefon, E-posta ve Makine alanlarını doldurun.'], 400);
}
if (!validateEmail($email)) {
    jsonResponse(['success' => false, 'message' => 'Geçerli bir e-posta adresi girin.'], 400);
}

$data = [
    'name' => $name,
    'phone' => $phone,
    'email' => $email,
    'machine' => $machine,
    'date' => $date,
    'note' => $note,
];

$id = saveSubmission('demo', $data);

$mailer = new Mailer();
$html = $mailer->buildHtmlFromData($data, 'Yeni Demo Makine Talebi');
$mailer->setSubject('[Gravisa] Demo Makine Talebi - ' . $name)
    ->setReplyTo($email, $name)
    ->setHtmlBody($html);
$mailer->send();

jsonResponse([
    'success' => true,
    'message' => 'Demo talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.',
    'id' => $id,
]);
