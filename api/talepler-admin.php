<?php
/**
 * Admin - Talepler yönetimi (sil / okundu vb.)
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
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

$action = $_POST['action'] ?? '';
$id = sanitizeSubmissionId(trim($_POST['id'] ?? ''));

if (!$id) {
    jsonResponse(['success' => false, 'message' => 'Geçersiz istek ID.']);
}

$allowedActions = ['delete', 'mark_read'];
if (!in_array($action, $allowedActions, true)) {
    jsonResponse(['success' => false, 'message' => 'Geçersiz işlem.']);
}

if ($action === 'delete') {
    if (!deleteSubmission($id)) {
        jsonResponse(['success' => false, 'message' => 'Kayıt silinirken hata oluştu veya kayıt bulunamadı.']);
    }
    jsonResponse(['success' => true, 'message' => 'Talep silindi.']);
}

if ($action === 'mark_read') {
    if (!markSubmissionRead($id)) {
        jsonResponse(['success' => false, 'message' => 'Kayıt güncellenemedi.']);
    }
    jsonResponse(['success' => true, 'message' => 'Talep okundu olarak işaretlendi.']);
}

jsonResponse(['success' => false, 'message' => 'Geçersiz işlem.']);

