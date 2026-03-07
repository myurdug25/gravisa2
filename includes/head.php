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
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>" />
<?php if (!empty($pageKeywords)): ?>
<meta name="keywords" content="<?= htmlspecialchars($pageKeywords) ?>" />
<?php endif; ?>
<title><?= htmlspecialchars($pageTitle) ?></title>
