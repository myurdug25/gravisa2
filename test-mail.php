<?php
/**
 * Mail testi - Sadece APP_DEBUG=1 iken çalışır (local test).
 * Tarayıcıdan: http://localhost/gravisa/test-mail.php
 * Production'da .htaccess ile engelleyebilir veya bu dosyayı silebilirsiniz.
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/Mailer.php';

header('Content-Type: text/html; charset=utf-8');

if (!defined('APP_DEBUG') || !APP_DEBUG) {
    echo '<p style="color:red;">Bu sayfa sadece APP_DEBUG=1 iken çalışır (local test).</p>';
    exit;
}

$to = $_GET['to'] ?? (defined('MAIL_TO') ? MAIL_TO : '');
if (empty($to)) {
    echo '<p style="color:red;">.env içinde MAIL_TO dolu olmalı veya ?to=mail@adres.com verin.</p>';
    exit;
}

$mailer = new Mailer();
$mailer->setTo($to);
$mailer->setSubject('[Gravisa Test] ' . date('Y-m-d H:i:s'));
$mailer->setHtmlBody(
    '<p>Bu bir test e-postasıdır.</p>' .
    '<p>SMTP: ' . (defined('MAIL_SMTP_HOST') && MAIL_SMTP_HOST ? MAIL_SMTP_HOST . ':' . (MAIL_SMTP_PORT ?? '') : 'PHP mail()') . '</p>' .
    '<p>Gönderen: ' . (defined('MAIL_FROM') ? MAIL_FROM : '') . '</p>' .
    '<p>Zaman: ' . date('Y-m-d H:i:s') . '</p>'
);

$ok = $mailer->send();

if ($ok) {
    echo '<p style="color:green;">Test e-postası gönderildi → ' . htmlspecialchars($to) . '</p>';
    echo '<p>Kutunuzu (ve spam klasörünü) kontrol edin.</p>';
} else {
    echo '<p style="color:red;">Gönderilemedi. .env SMTP bilgilerini (MAIL_SMTP_HOST, USER, PASS) kontrol edin.</p>';
}
