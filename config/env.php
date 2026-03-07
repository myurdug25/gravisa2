<?php
/**
 * Basit .env yükleyici (Composer gerektirmez)
 * config/.env dosyasını okur; config/ .htaccess ile dışarıdan erişime kapalı olmalı.
 */

function loadEnv(string $dir): void
{
    $envFile = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '.env';
    if (!is_file($envFile) || !is_readable($envFile)) {
        return;
    }
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') === false) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        if ($name === '') {
            continue;
        }
        $_ENV[$name] = $value;
        if (!getenv($name)) {
            putenv("$name=$value");
        }
    }
}
