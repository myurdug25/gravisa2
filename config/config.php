<?php
/**
 * Gravisa - Ana Yapılandırma
 * Hassas bilgiler .env dosyasından okunur (config/.env).
 */

$configDir = __DIR__;
$rootDir = dirname($configDir);

require_once $configDir . '/env.php';
loadEnv($configDir);

$env = function (string $key, $default = '') {
    $v = $_ENV[$key] ?? getenv($key);
    return $v !== false && $v !== '' ? $v : $default;
};

$envBool = function (string $key, bool $default = false) use ($env): bool {
    $v = strtolower(trim($env($key)));
    if ($v === '1' || $v === 'true' || $v === 'on' || $v === 'yes') return true;
    if ($v === '0' || $v === 'false' || $v === 'off' || $v === 'no') return false;
    return $default;
};

// Hata raporlama (production'da ekran gösterme)
$isDebug = $envBool('APP_DEBUG', false);
error_reporting(E_ALL);
ini_set('display_errors', $isDebug ? '1' : '0');
ini_set('log_errors', '1');

if (!$isDebug && function_exists('ini_set')) {
    ini_set('expose_php', '0');
}

date_default_timezone_set($env('APP_TIMEZONE', 'Europe/Istanbul'));

// E-posta
define('MAIL_TO', $env('MAIL_TO', 'destek@gravisa.com.tr'));
define('MAIL_FROM_NAME', $env('MAIL_FROM_NAME', 'Gravisa Web Sitesi'));
define('MAIL_FROM', $env('MAIL_FROM', 'destek@gravisa.com.tr'));

// Site iletişim bilgileri (.env'den - admin panel boşsa bunlar kullanılır)
define('CONTACT_EMAIL', $env('CONTACT_EMAIL', $env('MAIL_TO', '')));
define('SERVIS_EMAIL_ENV', $env('SERVIS_EMAIL', $env('MAIL_TO', '')));
define('WHATSAPP_NUMBER', $env('WHATSAPP_NUMBER', ''));
define('PHONE_DISPLAY', $env('PHONE_DISPLAY', ''));
define('MAIL_SMTP_HOST', $env('MAIL_SMTP_HOST'));
define('MAIL_SMTP_PORT', (int) $env('MAIL_SMTP_PORT', '587'));
define('MAIL_SMTP_USER', $env('MAIL_SMTP_USER'));
define('MAIL_SMTP_PASS', $env('MAIL_SMTP_PASS'));
define('MAIL_SMTP_SECURE', $env('MAIL_SMTP_SECURE', 'tls'));

// Admin
define('ADMIN_USER', $env('ADMIN_USER', 'admin'));
define('ADMIN_PASS', $env('ADMIN_PASS', ''));
define('SESSION_LIFETIME', (int) $env('SESSION_LIFETIME', '3600'));

// Veritabanı
define('USE_DB', $envBool('USE_DB', false));
define('DB_HOST', $env('DB_HOST', 'localhost'));
define('DB_NAME', $env('DB_NAME', 'gravisa'));
define('DB_USER', $env('DB_USER', 'root'));
define('DB_PASS', $env('DB_PASS', ''));

// Yollar
define('ROOT_PATH', $rootDir);
define('DATA_PATH', $rootDir . DIRECTORY_SEPARATOR . 'data');

// Web base path: XAMPP'ta /gravisa, production'da '' (kök)
// Öneri: config/.env içinde BASE_PATH=gravisa (alt klasör) veya boş (site kökü).
$envBase = $env('BASE_PATH', null);
if ($envBase !== null && $envBase !== '') {
    define('BASE_PATH', '/' . trim($envBase, '/'));
} else {
    // PHP_SELF sanal yolu (örn. /gravisa/tr/makineler) verebilir; BASE_PATH için kullanma.
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    $scriptDir = dirname($script);
    $base = ($scriptDir === '/' || $scriptDir === '.' || $scriptDir === '') ? '' : rtrim($scriptDir, '/');

    // SCRIPT_NAME güvenilmezse: index.php dosyasının document root'a göre klasörü
    if ($base === '' && !empty($_SERVER['SCRIPT_FILENAME']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
        $doc = realpath($_SERVER['DOCUMENT_ROOT']);
        $sf = realpath($_SERVER['SCRIPT_FILENAME']);
        if ($doc !== false && $sf !== false) {
            $doc = str_replace('\\', '/', $doc);
            $sf = str_replace('\\', '/', $sf);
            if (strpos($sf, $doc) === 0) {
                $rel = substr($sf, strlen($doc));
                $rel = '/' . ltrim(str_replace('\\', '/', $rel), '/');
                $relDir = dirname($rel);
                if ($relDir !== '/' && $relDir !== '.' && $relDir !== '\\') {
                    $base = rtrim(str_replace('\\', '/', $relDir), '/');
                }
            }
        }
    }

    define('BASE_PATH', $base);
}

require_once $rootDir . '/includes/i18n.php';
gravisa_init_lang();

// Ortam
define('APP_ENV', $env('APP_ENV', 'production'));
define('APP_DEBUG', $isDebug);
define('APP_URL', rtrim($env('APP_URL', ''), '/'));

// Güvenlik başlıkları (her istekte)
if (php_sapi_name() !== 'cli') {
    require_once $rootDir . '/includes/security.php';
    securityHeaders();
}
