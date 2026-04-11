<?php
/**
 * Çoklu dil (TR/EN) — merkezi çeviriler + URL öneki (/tr/, /en/) + cookie.
 */

const GRAVISA_LANG_COOKIE = 'gravisa_lang';
const GRAVISA_ALLOWED_LANGS = ['tr', 'en'];

/** @var array<string, mixed>|null */
$GLOBALS['gravisa_messages'] = null;

/** @var string|null URL'den gelen dil (tr|en) veya null */
$GLOBALS['gravisa_lang_from_url'] = null;

function gravisa_load_messages(): array
{
    if ($GLOBALS['gravisa_messages'] !== null) {
        return $GLOBALS['gravisa_messages'];
    }
    $path = ROOT_PATH . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'messages.json';
    if (!is_readable($path)) {
        $GLOBALS['gravisa_messages'] = ['tr' => [], 'en' => []];
        return $GLOBALS['gravisa_messages'];
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw ?: '[]', true);
    if (!is_array($data)) {
        $data = ['tr' => [], 'en' => []];
    }
    foreach (GRAVISA_ALLOWED_LANGS as $lg) {
        if (!isset($data[$lg]) || !is_array($data[$lg])) {
            $data[$lg] = [];
        }
    }
    $GLOBALS['gravisa_messages'] = $data;
    return $data;
}

/**
 * İstek URI'sinden /{base}/tr|en/... dil önekini çıkarır.
 */
function gravisa_detect_lang_from_request(): ?string
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        $path = '/';
    }
    $path = '/' . ltrim(str_replace('\\', '/', $path), '/');
    $base = defined('BASE_PATH') ? (string) BASE_PATH : '';
    if ($base !== '' && $base !== '/' && strpos($path, $base) === 0) {
        $rest = substr($path, strlen($base));
        $path = ($rest === '' || $rest === false) ? '/' : $rest;
    }
    $path = trim($path, '/');
    if ($path === '') {
        return null;
    }
    $parts = array_values(array_filter(explode('/', $path), static function ($s) {
        return $s !== '';
    }));
    if ($parts === []) {
        return null;
    }
    $first = strtolower($parts[0]);
    if (!in_array($first, GRAVISA_ALLOWED_LANGS, true)) {
        return null;
    }
    return $first;
}

function gravisa_init_lang(): void
{
    $fromUrl = gravisa_detect_lang_from_request();
    $GLOBALS['gravisa_lang_from_url'] = $fromUrl;

    $cookieLang = $_COOKIE[GRAVISA_LANG_COOKIE] ?? '';
    $cookieLang = is_string($cookieLang) ? strtolower($cookieLang) : '';
    if (!in_array($cookieLang, GRAVISA_ALLOWED_LANGS, true)) {
        $cookieLang = '';
    }

    if ($fromUrl !== null) {
        $lang = $fromUrl;
    } elseif ($cookieLang !== '') {
        $lang = $cookieLang;
    } else {
        $lang = 'tr';
    }

    if (!defined('GRAVISA_LANG')) {
        define('GRAVISA_LANG', $lang);
    }

    // URL dil ile cookie uyumlu olsun; yenilemede korunur
    if ($fromUrl !== null && (!isset($_COOKIE[GRAVISA_LANG_COOKIE]) || $_COOKIE[GRAVISA_LANG_COOKIE] !== $fromUrl)) {
        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        setcookie(GRAVISA_LANG_COOKIE, $fromUrl, [
            'expires' => time() + 365 * 24 * 60 * 60,
            'path' => '/',
            'secure' => $secure,
            'httponly' => false,
            'samesite' => 'Lax',
        ]);
        $_COOKIE[GRAVISA_LANG_COOKIE] = $fromUrl;
    }
}

/**
 * Nokta notasyonu ile çeviri: t('nav.home')
 */
/** Anahtar yoksa null (SEO override için) */
function te(string $key): ?string
{
    gravisa_load_messages();
    $lang = defined('GRAVISA_LANG') ? GRAVISA_LANG : 'tr';
    $node = $GLOBALS['gravisa_messages'][$lang] ?? [];
    foreach (explode('.', $key) as $seg) {
        if (!is_array($node) || !array_key_exists($seg, $node)) {
            return null;
        }
        $node = $node[$seg];
    }
    return is_string($node) ? $node : null;
}

function t(string $key, string $default = ''): string
{
    gravisa_load_messages();
    $lang = defined('GRAVISA_LANG') ? GRAVISA_LANG : 'tr';
    $node = $GLOBALS['gravisa_messages'][$lang] ?? [];
    foreach (explode('.', $key) as $seg) {
        if (!is_array($node) || !array_key_exists($seg, $node)) {
            // TR fallback
            $node = $GLOBALS['gravisa_messages']['tr'] ?? [];
            foreach (explode('.', $key) as $s2) {
                if (!is_array($node) || !array_key_exists($s2, $node)) {
                    return $default !== '' ? $default : $key;
                }
                $node = $node[$s2];
            }
            return is_string($node) ? $node : ($default !== '' ? $default : $key);
        }
        $node = $node[$seg];
    }
    return is_string($node) ? $node : ($default !== '' ? $default : $key);
}

function gravisa_html_lang(): string
{
    $l = defined('GRAVISA_LANG') ? GRAVISA_LANG : 'tr';
    return $l === 'en' ? 'en' : 'tr';
}

/**
 * Dil önekli site içi yol: /{base}/en/makineler
 * $slug: index, makineler, iletisim, makine-detay (query string ayrı eklenir)
 */
function gravisa_url(string $slug = ''): string
{
    $lang = defined('GRAVISA_LANG') ? GRAVISA_LANG : 'tr';
    $base = defined('BASE_PATH') ? (string) BASE_PATH : '';
    $slug = trim($slug, '/');
    if ($slug === '' || $slug === 'index') {
        return ($base === '' ? '' : $base) . '/' . $lang;
    }
    return ($base === '' ? '' : $base) . '/' . $lang . '/' . $slug;
}

/** Çalışan PHP dosyasından sayfa slug'ı (örn. makineler, iletisim) */
function gravisa_current_page_slug(): string
{
    $script = $_SERVER['SCRIPT_NAME'] ?? 'index.php';
    $base = basename((string) $script);
    $base = preg_replace('/\.php$/i', '', $base);
    return $base === '' ? 'index' : $base;
}

/**
 * Belirli dil için tam URL (dil seçicide kullanılır). Query string ayrı eklenir.
 */
function gravisa_url_for_lang(string $lang, ?string $slug = null): string
{
    if (!in_array($lang, GRAVISA_ALLOWED_LANGS, true)) {
        $lang = 'tr';
    }
    if ($slug === null) {
        $slug = gravisa_current_page_slug();
    }
    $slug = trim((string) $slug, '/');
    $base = defined('BASE_PATH') ? (string) BASE_PATH : '';
    if ($slug === '' || $slug === 'index') {
        return ($base === '' ? '' : $base) . '/' . $lang;
    }
    return ($base === '' ? '' : $base) . '/' . $lang . '/' . $slug;
}

/** JS için kısa metinler (makine kartı, filtre vb.) */
function gravisa_js_strings(): array
{
    return [
        'detail' => t('js.detail'),
        'getQuote' => t('js.get_quote'),
        'rent' => t('js.rent'),
        'select' => t('js.select'),
        'sending' => t('js.sending'),
        'model' => t('js.model'),
        'power' => t('js.power'),
        'catAll' => t('js.cat_all'),
        'catTruck' => t('js.cat_truck'),
        'catConcrete' => t('js.cat_concrete'),
        'catLighting' => t('js.cat_lighting'),
        'catTunnel' => t('js.cat_tunnel'),
        'catSpraying' => t('js.cat_spraying'),
        'catCompressor' => t('js.cat_compressor'),
        'catOther' => t('js.cat_other'),
        'machineLabel' => t('js.machine_label'),
        'pickCategory' => t('js.pick_category'),
        'viewCategory' => t('js.view_category'),
        'showAllCategories' => t('js.show_all_categories'),
        'showLessCategories' => t('js.show_less_categories'),
        'filters_all' => t('js.filters_all'),
        'filters_clear' => t('js.filters_clear'),
        'catalog_show_filters' => t('js.catalog_show_filters'),
        'catalog_hide_filters' => t('js.catalog_hide_filters'),
        'no_results' => t('js.no_results'),
        'formSubmit' => t('js.form_submit'),
        'demoSubmit' => t('js.demo_submit'),
        'resultsCount' => t('js.results_count'),
        'stockIn' => t('js.stock_in'),
        'stockOrder' => t('js.stock_order'),
        'notSpecified' => t('js.not_specified'),
        'backCatalog' => t('js.back_catalog'),
        'errorMachineNotFound' => t('js.error_machine_not_found'),
        'catalogLink' => t('js.catalog_link'),
        'specsTitle' => t('js.specs_title'),
        'labelType' => t('js.label_type'),
        'labelBrand' => t('js.label_brand'),
        'labelTypeModel' => t('js.label_type_model'),
        'labelModelYear' => t('js.label_model_year'),
        'labelPower' => t('js.label_power'),
        'labelCapacity' => t('js.label_capacity'),
        'labelChassisSn' => t('js.label_chassis_sn'),
        'labelMotorSn' => t('js.label_motor_sn'),
        'labelMotorBrand' => t('js.label_motor_brand'),
        'labelMotorType' => t('js.label_motor_type'),
        'labelStock' => t('js.label_stock'),
        'btnSalesLarge' => t('js.btn_sales_large'),
        'btnRentLarge' => t('js.btn_rent_large'),
        'btnContactLarge' => t('js.btn_contact_large'),
        'btnDemo' => t('js.btn_demo'),
        'metaModelYear' => t('js.meta_model_year'),
        'metaPower' => t('js.meta_power'),
        'stockBadgeIn' => t('js.stock_badge_in'),
        'noPhoto' => t('js.no_photo'),
        'inventoryNo' => t('js.inventory_no'),
    ];
}
