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

$name = sanitize($input['name'] ?? '');
$phone = sanitize($input['phone'] ?? '');
$machine = sanitize($input['machine'] ?? '');
$date = sanitize($input['date'] ?? '');
$note = sanitize($input['note'] ?? '');

if (empty($name) || empty($phone) || empty($machine)) {
    jsonResponse(['success' => false, 'message' => 'Lütfen Ad Soyad, Telefon ve Makine alanlarını doldurun.'], 400);
}

$data = [
    'name' => $name,
    'phone' => $phone,
    'machine' => $machine,
    'date' => $date,
    'note' => $note,
];

$id = saveSubmission('demo', $data);

$mailer = new Mailer();
$html = $mailer->buildHtmlFromData($data, 'Yeni Demo Makine Talebi');
$mailer->setSubject('[Gravisa] Demo Makine Talebi - ' . $name)->setHtmlBody($html);
$mailer->send();

jsonResponse([
    'success' => true,
    'message' => 'Demo talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.',
    'id' => $id,
]);
