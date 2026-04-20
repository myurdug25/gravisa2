<?php
/**
 * Sayfa <head> içeriği: SEO başlık, meta description, meta keywords (admin’den yönetilen)
 * Kullanım: $pageId ayarlanmış olmalı (örn. 'index', 'iletisim')
 */
if (empty($pageId)) {
    $pageId = 'index';
}
$seo = getSeoForPage($pageId);
$pageTitle = $seo['title'];
$pageDescription = $seo['description'];
$pageKeywords = $seo['keywords'];
$siteSettings = getSettings();

if (function_exists('te') && defined('GRAVISA_LANG') && GRAVISA_LANG === 'en') {
    $enTitle = te('seo.pages.' . $pageId . '.title');
    if ($enTitle !== null && $enTitle !== '') {
        $pageTitle = $enTitle;
    }
    $enDesc = te('seo.pages.' . $pageId . '.description');
    if ($enDesc !== null && $enDesc !== '') {
        $pageDescription = $enDesc;
    }
}
$gravisaQs = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? ('?' . $_SERVER['QUERY_STRING']) : '';
$gravisaSlug = function_exists('gravisa_current_page_slug') ? gravisa_current_page_slug() : 'index';
$gravisaAbs = function_exists('gravisa_url_for_lang') && defined('APP_URL') && APP_URL !== ''
    ? rtrim(APP_URL, '/')
    : ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? ''));
$gravisaHrefTr = $gravisaAbs . (function_exists('gravisa_url_for_lang') ? gravisa_url_for_lang('tr', $gravisaSlug) : '') . $gravisaQs;
$gravisaHrefEn = $gravisaAbs . (function_exists('gravisa_url_for_lang') ? gravisa_url_for_lang('en', $gravisaSlug) : '') . $gravisaQs;
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>" />
<?php if (!empty($pageKeywords)): ?>
<meta name="keywords" content="<?= htmlspecialchars($pageKeywords) ?>" />
<?php endif; ?>
<?php $bp = (defined('BASE_PATH') ? BASE_PATH : ''); ?>
<link rel="icon" href="<?= $bp ?>/favicon.ico" sizes="any" />
<link rel="icon" type="image/png" href="<?= $bp ?>/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="<?= $bp ?>/favicon-16x16.png" sizes="16x16" />
<link rel="apple-touch-icon" href="<?= $bp ?>/apple-touch-icon.png" sizes="180x180" />
<?php if (function_exists('gravisa_url_for_lang')): ?>
<link rel="alternate" hreflang="tr" href="<?= htmlspecialchars($gravisaHrefTr, ENT_QUOTES, 'UTF-8') ?>" />
<link rel="alternate" hreflang="en" href="<?= htmlspecialchars($gravisaHrefEn, ENT_QUOTES, 'UTF-8') ?>" />
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($gravisaHrefTr, ENT_QUOTES, 'UTF-8') ?>" />
<?php endif; ?>
<title><?= htmlspecialchars($pageTitle) ?></title>
<script>window.basePath='<?= addslashes(defined('BASE_PATH') ? BASE_PATH : '') ?>';<?php if (function_exists('gravisa_js_strings')): ?>window.__GRAVISA_JS=<?= json_encode(gravisa_js_strings(), JSON_UNESCAPED_UNICODE) ?>;window.GRAVISA_LANG='<?= defined('GRAVISA_LANG') ? GRAVISA_LANG : 'tr' ?>';window.gravisaLangPath=function(s){var b=window.basePath||'',g=(typeof window.GRAVISA_LANG==='string'?window.GRAVISA_LANG:'tr');s=(s||'').replace(/^\//,'');if(!s||s==='index')return b+'/'+g;return b+'/'+g+'/'+s;};<?php endif; ?>window.__siteSettings=<?= json_encode([
  'contact_email'=>$siteSettings['contact_email']??'',
  'servis_email'=>$siteSettings['servis_email']??'',
  'whatsapp_number'=>$siteSettings['whatsapp_number']??'',
  'phone_display'=>$siteSettings['phone_display']??'',
  'address'=>$siteSettings['address']??''
], JSON_UNESCAPED_UNICODE) ?>;</script>
<script>window.__categoryImages=<?= json_encode(function_exists('gravisa_get_category_images') ? gravisa_get_category_images() : [], JSON_UNESCAPED_UNICODE) ?>;</script>
<script>window.__categoryCounts=<?= json_encode(function_exists('gravisa_get_category_counts') ? gravisa_get_category_counts() : [], JSON_UNESCAPED_UNICODE) ?>;</script>
<script>window.__homeCategories=<?= json_encode($siteSettings['home_categories'] ?? [], JSON_UNESCAPED_UNICODE) ?>;</script>
<script>
(function () {
  var memoBase = null;
  window.gravisaEffectiveBasePath = function () {
    if (memoBase !== null) {
      return memoBase;
    }
    var b = (typeof window.basePath === 'string' && window.basePath) ? String(window.basePath).replace(/\/$/, '') : '';
    if (b) {
      memoBase = b;
      return memoBase;
    }
    try {
      var scripts = document.getElementsByTagName('script');
      for (var i = 0; i < scripts.length; i++) {
        var href = scripts[i].src;
        if (!href || href.indexOf('/assets/') === -1) continue;
        var u = new URL(href, window.location.href);
        var p = u.pathname;
        var ix = p.indexOf('/assets/');
        if (ix > 0) {
          memoBase = p.substring(0, ix);
          return memoBase;
        }
      }
    } catch (e) {}
    memoBase = '';
    return memoBase;
  };
  window.gravisaAssetUrl = function (src, cacheBust) {
    if (!src || typeof src !== 'string') return '';
    var s = src.replace(/^\s+|\s+$/g, '');
    if (!s) return '';
    var low = s.toLowerCase();
    if (low.indexOf('javascript:') === 0 || low.indexOf('data:') === 0 || low.indexOf('vbscript:') === 0) return '';
    if (/^https?:\/\//i.test(s)) return s;
    var b = window.gravisaEffectiveBasePath();
    var url;
    if (s.charAt(0) === '/') {
      if (!b || s.indexOf(b + '/') === 0 || s === b) url = s;
      else url = b + s;
    } else {
      url = b ? (b + '/' + s) : ('/' + s);
    }
    if (cacheBust != null && cacheBust !== '' && low.indexOf('data:') !== 0) {
      url += (url.indexOf('?') >= 0 ? '&' : '?') + 'v=' + encodeURIComponent(String(cacheBust));
    }
    return url;
  };
})();
</script>
<script>
window.__GRAVISA_UI=<?= json_encode([
  'toast_ok' => function_exists('t') ? t('toast.title_ok') : 'Talebiniz Alındı',
  'toast_err' => function_exists('t') ? t('toast.title_err') : 'Hata',
  'toast_btn' => function_exists('t') ? t('toast.btn_ok') : 'Tamam',
], JSON_UNESCAPED_UNICODE) ?>;
window.showToast=function(m,s){s=s!==false;var U=window.__GRAVISA_UI||{};var o=document.createElement('div');o.className='toast-overlay';o.innerHTML='<div class="toast-box '+(s?'success':'error')+'"><span class="toast-icon">'+(s?'✓':'✕')+'</span><h3 class="toast-title">'+(s?(U.toast_ok||'OK'):(U.toast_err||'Error'))+'</h3><p class="toast-message">'+(m||'')+'</p><button type="button" class="toast-btn">'+(U.toast_btn||'OK')+'</button></div>';document.body.appendChild(o);var c=function(){o.style.opacity='0';o.style.transition='opacity .2s';setTimeout(function(){o.remove()},200)};o.querySelector('.toast-btn').onclick=c;o.onclick=function(e){if(e.target===o)c()};setTimeout(c,5000)};
</script>
