<?php
/**
 * Güvenlik yardımcıları: CSRF, güvenli oturum, başlıklar
 */

/** Güvenli oturum başlat (sadece bir kez) */
function secureSessionStart(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.use_strict_mode', '1');
    if ($isSecure) {
        ini_set('session.cookie_secure', '1');
    }
    session_start();
}

/** CSRF token üret veya mevcut olanı döndür */
function csrfToken(): string
{
    secureSessionStart();
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

/** CSRF token doğrula (POST/request body için) */
function validateCsrf(): bool
{
    secureSessionStart();
    $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if ($token === '' || !isset($_SESSION['_csrf_token'])) {
        return false;
    }
    return hash_equals((string) $_SESSION['_csrf_token'], $token);
}

/** CSRF input alanı HTML */
function csrfField(): string
{
    return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars(csrfToken()) . '" />';
}

/** Güvenlik başlıklarını ekle */
function securityHeaders(): void
{
    if (headers_sent()) {
        return;
    }
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\'; style-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com https://fonts.gstatic.com; font-src \'self\' https://fonts.gstatic.com; img-src \'self\' data: https: blob:; connect-src \'self\'; frame-ancestors \'self\'; base-uri \'self\'; form-action \'self\';');
    if (defined('APP_ENV') && APP_ENV === 'production') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains', false);
    }
}

/** XSS korumalı HTML çıktı */
function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
