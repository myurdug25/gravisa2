<?php
/**
 * Yardımcı fonksiyonlar
 */

function jsonResponse(array $data, int $code = 200): void
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function sanitize($value, int $maxLength = 10000): string
{
    if (is_array($value)) {
        return implode(', ', array_map(function ($v) use ($maxLength) {
            return sanitize($v, $maxLength);
        }, $value));
    }
    $s = trim(strip_tags((string)$value));
    if ($maxLength > 0 && mb_strlen($s) > $maxLength) {
        $s = mb_substr($s, 0, $maxLength);
    }
    return $s;
}

/** Talep ID formatı doğrula: type_id (type whitelist, id alfanumerik/underscore) */
function sanitizeSubmissionId(string $id): ?string
{
    if ($id === '' || strlen($id) > 80) {
        return null;
    }
    $allowedTypes = ['kiralama', 'demo', 'iletisim', 'satis', 'servis'];
    $parts = explode('_', $id, 2);
    if (count($parts) !== 2 || !in_array($parts[0], $allowedTypes, true)) {
        return null;
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $parts[1])) {
        return null;
    }
    return $id;
}

/** SEO pages JSON - geçerli JSON döndürür, değerleri sanitize eder */
function sanitizeJsonPages(string $json): string
{
    if (trim($json) === '') {
        return '';
    }
    $decoded = json_decode($json, true);
    if (!is_array($decoded)) {
        return '';
    }
    $allowedKeys = ['title', 'description', 'keywords'];
    $result = [];
    foreach ($decoded as $pageId => $pageData) {
        if (!is_array($pageData) || !preg_match('/^[a-z0-9_-]+$/', (string)$pageId)) {
            continue;
        }
        $result[$pageId] = [];
        foreach ($allowedKeys as $key) {
            if (isset($pageData[$key]) && is_string($pageData[$key])) {
                $result[$pageId][$key] = sanitize($pageData[$key], 500);
            }
        }
    }
    return json_encode($result, JSON_UNESCAPED_UNICODE);
}

/** Dosya yolu path traversal kontrolü - sadece izin verilen prefix altında */
function sanitizeImagePath(string $path, array $allowedPrefixes): string
{
    $path = trim($path);
    if ($path === '') {
        return '';
    }
    $path = str_replace('\\', '/', $path);
    $path = preg_replace('#/+#', '/', $path);
    if (strpos($path, '..') !== false || $path[0] === '/') {
        return '';
    }
    foreach ($allowedPrefixes as $prefix) {
        if (strpos($path, $prefix) === 0) {
            return $path;
        }
    }
    return '';
}

/** img src için güvenli URL - javascript:, data:, vbscript: engellenir */
function safeImgSrc(string $url): string
{
    $url = trim($url);
    if ($url === '') return '';
    $lower = strtolower($url);
    if (strpos($lower, 'javascript:') === 0 || strpos($lower, 'vbscript:') === 0 || strpos($lower, 'data:') === 0) {
        return '';
    }
    return $url;
}

function validateEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePhone(string $phone): bool
{
    $cleaned = preg_replace('/\D/', '', $phone);
    return strlen($cleaned) >= 10;
}

/** Bot koruması: Gizli alan doluysa (honeypot) true döner = reddet */
function isHoneypotFilled(array $input): bool
{
    $honeypot = trim((string)($input['website'] ?? $input['url'] ?? ''));
    return $honeypot !== '';
}

/** IP başına dakikada max talep (spam engeli). Aşımda true döner = reddet */
function isRateLimitExceeded(int $maxPerMinutes = 5, int $windowMinutes = 15): bool
{
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
    if ($ip === '') return false;
    $ip = trim(explode(',', $ip)[0]);
    ensureDataDir();
    $file = DATA_PATH . '/rate_limit.json';
    $now = time();
    $cutoff = $now - ($windowMinutes * 60);
    $data = [];
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true) ?: [];
    }
    if (!isset($data[$ip]) || !is_array($data[$ip])) {
        $data[$ip] = [];
    }
    $data[$ip] = array_values(array_filter($data[$ip], function ($ts) use ($cutoff) { return $ts > $cutoff; }));
    if (count($data[$ip]) >= $maxPerMinutes) {
        return true;
    }
    $data[$ip][] = $now;
    file_put_contents($file, json_encode($data), LOCK_EX);
    return false;
}

function ensureDataDir(): void
{
    if (!is_dir(DATA_PATH)) {
        mkdir(DATA_PATH, 0755, true);
    }
}

function saveSubmission(string $type, array $data): string
{
    $data['created_at'] = date('Y-m-d H:i:s');

    if (defined('USE_DB') && USE_DB && defined('DB_NAME') && DB_NAME) {
        require_once ROOT_PATH . '/includes/Database.php';
        return Database::saveSubmission($type, $data);
    }

    ensureDataDir();
    $id = $type . '_' . date('YmdHis') . '_' . substr(uniqid(), -6);
    $file = DATA_PATH . '/' . $type . '.json';
    $all = [];
    if (file_exists($file)) {
        $all = json_decode(file_get_contents($file), true) ?: [];
    }
    $all[$id] = $data;
    file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $id;
}

/** Site ayarlarını döndürür (config sabitleriyle birleşik) */
function getSettings(): array
{
    $defaults = [
        'contact_email' => (defined('CONTACT_EMAIL') && CONTACT_EMAIL) ? CONTACT_EMAIL : (defined('MAIL_TO') ? MAIL_TO : 'info@gravisa.com'),
        'servis_email'  => (defined('SERVIS_EMAIL_ENV') && SERVIS_EMAIL_ENV) ? SERVIS_EMAIL_ENV : 'servis@gravisa.com',
        'whatsapp_number' => (defined('WHATSAPP_NUMBER') && WHATSAPP_NUMBER) ? WHATSAPP_NUMBER : '905551234567',
        'phone_display' => (defined('PHONE_DISPLAY') && PHONE_DISPLAY) ? PHONE_DISPLAY : '0555 123 45 67',
        'address'       => 'Örnek Mah. Sanayi Cad. No:1' . "\n" . 'İstanbul, Türkiye',
        'mail_to'       => defined('MAIL_TO') ? MAIL_TO : '',
        'mail_from_name'=> defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Gravisa Web Sitesi',
        'mail_from'     => defined('MAIL_FROM') ? MAIL_FROM : '',
        'seo_site_title' => 'Gravisa',
        'seo_default_description' => 'Gravisa - İş makineleri satış ve kiralama. Satış teklifi alın, günlük/aylık kiralama seçenekleri. Hızlı iletişim.',
        'seo_default_keywords' => 'iş makineleri, satış, kiralama, ekskavatör, yükleyici, Gravisa',
        'seo_pages'     => '', // JSON string: {"index":{"title":"...","description":"..."},...}
    ];
    $file = defined('DATA_PATH') ? DATA_PATH . '/settings.json' : (dirname(__DIR__) . '/data/settings.json');
    clearstatcache(true, $file);
    if (!file_exists($file)) {
        return $defaults;
    }
    $saved = json_decode(file_get_contents($file), true);
    if (!is_array($saved)) {
        return $defaults;
    }
    $merged = array_merge($defaults, $saved);
    // Boş değerlerde .env fallback (admin kaydetmemişse .env kullanılır)
    if (empty(trim($merged['contact_email'] ?? '')) && defined('CONTACT_EMAIL') && CONTACT_EMAIL) $merged['contact_email'] = CONTACT_EMAIL;
    if (empty(trim($merged['servis_email'] ?? '')) && defined('SERVIS_EMAIL_ENV') && SERVIS_EMAIL_ENV) $merged['servis_email'] = SERVIS_EMAIL_ENV;
    if (empty(trim($merged['whatsapp_number'] ?? '')) && defined('WHATSAPP_NUMBER') && WHATSAPP_NUMBER) $merged['whatsapp_number'] = WHATSAPP_NUMBER;
    if (empty(trim($merged['phone_display'] ?? '')) && defined('PHONE_DISPLAY') && PHONE_DISPLAY) $merged['phone_display'] = PHONE_DISPLAY;
    return $merged;
}

/** Site ayarlarını kaydeder */
function saveSettings(array $settings): bool
{
    ensureDataDir();
    $file = DATA_PATH . '/settings.json';
    $current = file_exists($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
    $allowed = ['contact_email', 'servis_email', 'whatsapp_number', 'phone_display', 'address', 'mail_to', 'mail_from_name', 'mail_from',
        'seo_site_title', 'seo_default_description', 'seo_default_keywords', 'seo_pages'];
    foreach ($allowed as $key) {
        if (array_key_exists($key, $settings)) {
            $current[$key] = $key === 'seo_pages' ? (is_string($settings[$key]) ? $settings[$key] : json_encode($settings[$key], JSON_UNESCAPED_UNICODE)) : trim((string)$settings[$key]);
        }
    }
    return file_put_contents($file, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

/** Sayfa ID’sine göre SEO başlık, açıklama ve anahtar kelimeleri döndürür (admin’den yönetilen) */
function getSeoForPage(string $pageId): array
{
    $settings = getSettings();
    $defaultTitles = [
        'index' => 'İş Makineleri Satış & Kiralama',
        'iletisim' => 'İletişim',
        'makineler' => 'Makineler',
        'satis-teklifi' => 'Satış Teklifi',
        'kiralama' => 'Kiralama',
        'servis' => 'Servis',
        'kurumsal' => 'Kurumsal',
        'hakkimizda' => 'Hakkımızda',
        'vizyon-misyon' => 'Vizyon & Misyon',
        'referanslar' => 'Referanslar',
        'saha-fotograflari' => 'Saha Fotoğrafları',
        'makine-detay' => 'Makine Detay',
    ];
    $siteTitle = $settings['seo_site_title'] ?? 'Gravisa';
    $defaultDesc = $settings['seo_default_description'] ?? '';
    $defaultKeywords = $settings['seo_default_keywords'] ?? '';
    $pages = $settings['seo_pages'] ?? '';
    $seoPages = is_string($pages) ? (json_decode($pages, true) ?: []) : (is_array($pages) ? $pages : []);
    $page = $seoPages[$pageId] ?? [];
    $title = $page['title'] ?? ($siteTitle . ' | ' . ($defaultTitles[$pageId] ?? $pageId));
    $description = $page['description'] ?? $defaultDesc;
    $keywords = $page['keywords'] ?? $defaultKeywords;
    return ['title' => $title, 'description' => $description, 'keywords' => $keywords];
}

/** Teklif/talep cevabı günceller (JSON veya DB) */
function updateSubmissionReply(string $id, string $replyText, bool $emailSent = false): bool
{
    if (sanitizeSubmissionId($id) !== $id) {
        return false;
    }
    $parts = explode('_', $id, 2);
    if (count($parts) !== 2) {
        return false;
    }
    $type = $parts[0];
    if (defined('USE_DB') && USE_DB && defined('DB_NAME') && DB_NAME) {
        require_once ROOT_PATH . '/includes/Database.php';
        $data = Database::getSubmissionById($id);
        if (!$data) {
            return false;
        }
        $data['admin_reply'] = $replyText;
        $data['replied_at'] = date('Y-m-d H:i:s');
        $data['reply_email_sent'] = $emailSent;
        return Database::updateSubmission($id, $data);
    }
    $file = DATA_PATH . '/' . $type . '.json';
    if (!file_exists($file)) {
        return false;
    }
    $all = json_decode(file_get_contents($file), true) ?: [];
    if (!isset($all[$id])) {
        return false;
    }
    $all[$id]['admin_reply'] = $replyText;
    $all[$id]['replied_at'] = date('Y-m-d H:i:s');
    $all[$id]['reply_email_sent'] = $emailSent;
    file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return true;
}

/** Talebi okundu olarak işaretler (JSON veya DB) */
function markSubmissionRead(string $id): bool
{
    if (sanitizeSubmissionId($id) !== $id) {
        return false;
    }
    $parts = explode('_', $id, 2);
    if (count($parts) !== 2) {
        return false;
    }
    $type = $parts[0];
    if (defined('USE_DB') && USE_DB && defined('DB_NAME') && DB_NAME) {
        require_once ROOT_PATH . '/includes/Database.php';
        $data = Database::getSubmissionById($id);
        if (!$data) {
            return false;
        }
        $data['admin_read'] = true;
        $data['read_at'] = date('Y-m-d H:i:s');
        return Database::updateSubmission($id, $data);
    }
    $file = DATA_PATH . '/' . $type . '.json';
    if (!file_exists($file)) {
        return false;
    }
    $all = json_decode(file_get_contents($file), true) ?: [];
    if (!isset($all[$id])) {
        return false;
    }
    $all[$id]['admin_read'] = true;
    $all[$id]['read_at'] = date('Y-m-d H:i:s');
    file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return true;
}

/** Talebi tamamen siler (JSON veya DB) */
function deleteSubmission(string $id): bool
{
    if (sanitizeSubmissionId($id) !== $id) {
        return false;
    }
    $parts = explode('_', $id, 2);
    if (count($parts) !== 2) {
        return false;
    }
    $type = $parts[0];
    if (defined('USE_DB') && USE_DB && defined('DB_NAME') && DB_NAME) {
        require_once ROOT_PATH . '/includes/Database.php';
        return Database::deleteSubmission($id);
    }
    $file = DATA_PATH . '/' . $type . '.json';
    if (!file_exists($file)) {
        return false;
    }
    $all = json_decode(file_get_contents($file), true) ?: [];
    if (!isset($all[$id])) {
        return false;
    }
    unset($all[$id]);
    file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return true;
}
