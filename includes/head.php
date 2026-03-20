<?php
/**
 * Sayfa <head> içeriği: SEO başlık, meta description, meta keywords (admin’den yönetilen)
 * Kullanım: $pageId ayarlanmış olmalı (örn. 'index', 'iletisim')
 */
if (empty($pageId)) $pageId = 'index';
$seo = getSeoForPage($pageId);
$pageTitle = $seo['title'];
$pageDescription = $seo['description'];
$pageKeywords = $seo['keywords'];
$siteSettings = getSettings();
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>" />
<?php if (!empty($pageKeywords)): ?>
<meta name="keywords" content="<?= htmlspecialchars($pageKeywords) ?>" />
<?php endif; ?>
<link rel="icon" type="image/png" href="<?= (defined('BASE_PATH') ? BASE_PATH : '') ?>/images/IMG_9059.JPG-removebg-preview.png" />
<title><?= htmlspecialchars($pageTitle) ?></title>
<script>window.basePath='<?= addslashes(defined('BASE_PATH') ? BASE_PATH : '') ?>';window.__siteSettings=<?= json_encode([
  'contact_email'=>$siteSettings['contact_email']??'',
  'servis_email'=>$siteSettings['servis_email']??'',
  'whatsapp_number'=>$siteSettings['whatsapp_number']??'',
  'phone_display'=>$siteSettings['phone_display']??'',
  'address'=>$siteSettings['address']??''
], JSON_UNESCAPED_UNICODE) ?>;</script>
<script>
window.showToast=function(m,s){s=s!==false;var o=document.createElement('div');o.className='toast-overlay';o.innerHTML='<div class="toast-box '+(s?'success':'error')+'"><span class="toast-icon">'+(s?'✓':'✕')+'</span><h3 class="toast-title">'+(s?'Talebiniz Alındı':'Hata')+'</h3><p class="toast-message">'+(m||'')+'</p><button type="button" class="toast-btn">Tamam</button></div>';document.body.appendChild(o);var c=function(){o.style.opacity='0';o.style.transition='opacity .2s';setTimeout(function(){o.remove()},200)};o.querySelector('.toast-btn').onclick=c;o.onclick=function(e){if(e.target===o)c()};setTimeout(c,5000)};
</script>
