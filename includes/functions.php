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

/**
 * Makine görseli: JSON’daki göreli yolu site köküne göre mutlak path yapar
 * (örn. images/makineler/x.png → /gravisa/images/makineler/x.png). Alt klasör + boş basePath JS hatasını giderir.
 */
function gravisa_normalize_machine_img(?string $img): string
{
    $img = trim((string) $img);
    if ($img === '') {
        return '';
    }
    if (preg_match('#^https?://#i', $img)) {
        return $img;
    }
    $img = str_replace('\\', '/', $img);
    $bp = defined('BASE_PATH') ? rtrim((string) BASE_PATH, '/') : '';
    if ($img[0] === '/') {
        if ($bp !== '' && strpos($img, $bp . '/') !== 0 && $img !== $bp) {
            return $bp . $img;
        }

        return $img;
    }
    if ($bp === '') {
        return '/' . ltrim($img, '/');
    }

    return $bp . '/' . ltrim($img, '/');
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

/** .env yüklendikten sonra $_ENV / getenv okur (getSettings önce loadEnv çağırır). */
function gravisa_env_value(string $key, string $default = ''): string
{
    $v = $_ENV[$key] ?? getenv($key);
    if ($v === false || $v === null) {
        return $default;
    }
    $s = trim((string) $v);

    return $s !== '' ? $s : $default;
}

/** Site ayarlarını döndürür (data/settings.json + güncel .env birleşimi) */
function getSettings(): array
{
    if (function_exists('loadEnv') && defined('ROOT_PATH')) {
        loadEnv(ROOT_PATH . DIRECTORY_SEPARATOR . 'config');
    }
    $ev = static function (string $key, string $default = ''): string {
        return gravisa_env_value($key, $default);
    };

    $waDigits = preg_replace('/\D/', '', $ev('WHATSAPP_NUMBER', ''));

    $defaults = [
        'contact_email' => $ev('CONTACT_EMAIL', $ev('MAIL_TO', 'destek@gravisa.com.tr')),
        'servis_email'  => $ev('SERVIS_EMAIL', $ev('MAIL_TO', $ev('CONTACT_EMAIL', 'servis@gravisa.com'))),
        'whatsapp_number' => $waDigits !== '' ? $waDigits : '905551234567',
        'phone_display' => $ev('PHONE_DISPLAY', '0555 123 45 67'),
        'address'       => 'Örnek Mah. Sanayi Cad. No:1' . "\n" . 'İstanbul, Türkiye',
        'mail_to'       => $ev('MAIL_TO', ''),
        'mail_from_name'=> $ev('MAIL_FROM_NAME', 'Gravisa Web Sitesi'),
        'mail_from'     => $ev('MAIL_FROM', ''),
        'seo_site_title' => 'Gravisa',
        'seo_default_description' => 'Gravisa - İş makineleri satış ve kiralama. Satış teklifi alın, günlük/aylık kiralama seçenekleri. Hızlı iletişim.',
        'seo_default_keywords' => 'iş makineleri, satış, kiralama, ekskavatör, yükleyici, Gravisa',
        'seo_pages'     => '', // JSON string: {"index":{"title":"...","description":"..."},...}
        'prefer_env_contact' => false,
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

    // Panel: "İletişimde .env öncelikli" → JSON’daki e-posta/telefon/WhatsApp yok sayılır (sadece .env)
    if (!empty($merged['prefer_env_contact'])) {
        $merged['contact_email'] = $defaults['contact_email'];
        $merged['servis_email'] = $defaults['servis_email'];
        $merged['whatsapp_number'] = $defaults['whatsapp_number'];
        $merged['phone_display'] = $defaults['phone_display'];
        $merged['mail_to'] = $defaults['mail_to'];
        $merged['mail_from_name'] = $defaults['mail_from_name'];
        $merged['mail_from'] = $defaults['mail_from'];
    } else {
        // Boş alanlarda güncel .env (panelde boş bırakıldıysa .env devreye girer)
        if (empty(trim((string) ($merged['contact_email'] ?? '')))) {
            $merged['contact_email'] = $defaults['contact_email'];
        }
        if (empty(trim((string) ($merged['servis_email'] ?? '')))) {
            $merged['servis_email'] = $defaults['servis_email'];
        }
        if (empty(trim((string) ($merged['whatsapp_number'] ?? '')))) {
            $merged['whatsapp_number'] = $defaults['whatsapp_number'];
        }
        if (empty(trim((string) ($merged['phone_display'] ?? '')))) {
            $merged['phone_display'] = $defaults['phone_display'];
        }
        if (empty(trim((string) ($merged['mail_to'] ?? '')))) {
            $merged['mail_to'] = $defaults['mail_to'];
        }
        if (empty(trim((string) ($merged['mail_from_name'] ?? '')))) {
            $merged['mail_from_name'] = $defaults['mail_from_name'];
        }
        if (empty(trim((string) ($merged['mail_from'] ?? '')))) {
            $merged['mail_from'] = $defaults['mail_from'];
        }
    }

    return $merged;
}

/**
 * Kategori görselleri haritası (admin’den yönetilen)
 * key => relative image path (örn. images/categories/ekskavator.webp)
 */
function gravisa_get_category_images(): array
{
    $file = defined('DATA_PATH') ? (DATA_PATH . '/category_images.json') : (dirname(__DIR__) . '/data/category_images.json');
    if (!file_exists($file)) {
        return [];
    }
    $raw = json_decode(file_get_contents($file), true);
    if (!is_array($raw)) {
        return [];
    }
    $out = [];
    foreach ($raw as $k => $v) {
        $key = preg_replace('/[^a-z0-9-]+/i', '', strtolower((string)$k));
        if ($key === '') continue;
        $path = trim((string)$v);
        if ($path === '' || strpos($path, '..') !== false) continue;
        $path = str_replace('\\', '/', $path);
        // Cache bust: kategori görseli güncellendiğinde tarayıcı eskiyi tutmasın
        if (defined('ROOT_PATH')) {
            $abs = ROOT_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
            if (is_file($abs)) {
                $mtime = @filemtime($abs);
                if ($mtime !== false) {
                    $sep = (strpos($path, '?') !== false) ? '&' : '?';
                    $path = $path . $sep . 'v=' . (int)$mtime;
                }
            }
        }
        $out[$key] = $path;
    }
    return $out;
}

function gravisa_save_category_images(array $map): bool
{
    if (!defined('DATA_PATH')) {
        return false;
    }
    ensureDataDir();
    $file = DATA_PATH . '/category_images.json';
    $clean = [];
    foreach ($map as $k => $v) {
        $key = preg_replace('/[^a-z0-9-]+/i', '', strtolower((string)$k));
        if ($key === '') continue;
        $path = trim((string)$v);
        if ($path === '' || strpos($path, '..') !== false) continue;
        $path = str_replace('\\', '/', $path);
        $clean[$key] = $path;
    }
    $bytes = @file_put_contents($file, json_encode($clean, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    return $bytes !== false;
}

/** WhatsApp/tel için formatlanmış numara (905331447286) */
function getWaNum(): string
{
    $s = getSettings();
    $n = preg_replace('/\D/', '', $s['whatsapp_number'] ?? '');
    if ($n && substr($n, 0, 1) !== '9' && strlen($n) >= 10) $n = '9' . $n;
    return $n ?: '905551234567';
}

/** WhatsApp sohbet linki (yalnızca numara; ön yazılı mesaj yok). */
function getWaUrl(): string
{
    return 'https://wa.me/' . getWaNum();
}

/** Site ayarlarını kaydeder */
function saveSettings(array $settings): bool
{
    ensureDataDir();
    $file = DATA_PATH . '/settings.json';
    $current = file_exists($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
    $allowed = ['contact_email', 'servis_email', 'whatsapp_number', 'phone_display', 'address', 'mail_to', 'mail_from_name', 'mail_from',
        'seo_site_title', 'seo_default_description', 'seo_default_keywords', 'seo_pages',
        'prefer_env_contact'];
    foreach ($allowed as $key) {
        if (!array_key_exists($key, $settings)) {
            continue;
        }
        if ($key === 'seo_pages') {
            $current[$key] = is_string($settings[$key]) ? $settings[$key] : json_encode($settings[$key], JSON_UNESCAPED_UNICODE);
        } elseif ($key === 'prefer_env_contact') {
            $current[$key] = (bool) $settings[$key];
        } else {
            $current[$key] = trim((string) $settings[$key]);
        }
    }
    $bytes = @file_put_contents($file, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    $ok = $bytes !== false;
    if ($ok) {
        clearstatcache(true, $file);
    }

    return $ok;
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
