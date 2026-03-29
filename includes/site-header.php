<?php
/** @var string $pageId */
if (!isset($pageId)) {
    $pageId = 'index';
}
$slug = gravisa_current_page_slug();
$slugNorm = ($slug === '' || $slug === '/' || $slug === 'index') ? 'index' : $slug;
$qs = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? ('?' . $_SERVER['QUERY_STRING']) : '';
$hrefTr = htmlspecialchars(gravisa_url_for_lang('tr', $slug) . $qs, ENT_QUOTES, 'UTF-8');
$hrefEn = htmlspecialchars(gravisa_url_for_lang('en', $slug) . $qs, ENT_QUOTES, 'UTF-8');
$langTrActive = GRAVISA_LANG === 'tr' ? ' is-active' : '';
$langEnActive = GRAVISA_LANG === 'en' ? ' is-active' : '';
$isActive = function (string $target) use ($slugNorm): bool {
    return $slugNorm === $target;
};
$isCorporateActive = function () use ($slugNorm): bool {
    return in_array($slugNorm, ['kurumsal', 'hakkimizda', 'vizyon-misyon', 'referanslar', 'saha-fotograflari'], true);
};
?>
<header class="header">
  <div class="container header-inner">
    <a href="<?= htmlspecialchars(gravisa_url(''), ENT_QUOTES, 'UTF-8') ?>" class="logo" aria-label="Gravisa"><img src="<?= BASE_PATH ?>/images/gravisa-transparan-logo.png" alt="Gravisa" /></a>
    <nav class="nav" id="main-nav">
      <ul>
        <li><a href="<?= htmlspecialchars(gravisa_url(''), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('index') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.home')) ?></a></li>
        <li><a href="<?= htmlspecialchars(gravisa_url('makineler'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('makineler') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.machines')) ?></a></li>
        <li><a href="<?= htmlspecialchars(gravisa_url('satis-teklifi'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('satis-teklifi') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.sales_quote')) ?></a></li>
        <li><a href="<?= htmlspecialchars(gravisa_url('kiralama'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('kiralama') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.rental')) ?></a></li>
        <li><a href="<?= htmlspecialchars(gravisa_url('servis'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('servis') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.service')) ?></a></li>
        <li class="nav-dropdown">
          <a href="<?= htmlspecialchars(gravisa_url('kurumsal'), ENT_QUOTES, 'UTF-8') ?>" class="<?= $isCorporateActive() ? 'is-active' : '' ?>"<?= $isActive('kurumsal') ? ' aria-current="page"' : '' ?> aria-expanded="false" aria-controls="nav-corporate-sub"><?= htmlspecialchars(t('nav.corporate')) ?></a>
          <ul id="nav-corporate-sub">
            <li><a href="<?= htmlspecialchars(gravisa_url('hakkimizda'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('hakkimizda') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.about')) ?></a></li>
            <li><a href="<?= htmlspecialchars(gravisa_url('vizyon-misyon'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('vizyon-misyon') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.vision')) ?></a></li>
            <li><a href="<?= htmlspecialchars(gravisa_url('referanslar'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('referanslar') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.references')) ?></a></li>
            <li><a href="<?= htmlspecialchars(gravisa_url('saha-fotograflari'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('saha-fotograflari') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.site_photos')) ?></a></li>
          </ul>
        </li>
        <li><a href="<?= htmlspecialchars(gravisa_url('iletisim'), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive('iletisim') ? ' class="is-active" aria-current="page"' : '' ?>><?= htmlspecialchars(t('nav.contact')) ?></a></li>
      </ul>
    </nav>
    <div class="header-end">
      <div class="lang-switcher" role="group" aria-label="<?= htmlspecialchars(t('nav.lang_menu'), ENT_QUOTES, 'UTF-8') ?>">
        <a class="lang-switcher__btn<?= $langTrActive ?>" href="<?= $hrefTr ?>" hreflang="tr" lang="tr" aria-label="<?= htmlspecialchars(t('nav.lang_switch_tr'), ENT_QUOTES, 'UTF-8') ?>"<?= GRAVISA_LANG === 'tr' ? ' aria-current="true"' : '' ?>><span class="lang-switcher__abbr">TR</span></a>
        <a class="lang-switcher__btn<?= $langEnActive ?>" href="<?= $hrefEn ?>" hreflang="en" lang="en" aria-label="<?= htmlspecialchars(t('nav.lang_switch_en'), ENT_QUOTES, 'UTF-8') ?>"<?= GRAVISA_LANG === 'en' ? ' aria-current="true"' : '' ?>><span class="lang-switcher__abbr">EN</span></a>
      </div>
      <button class="nav-toggle" aria-label="<?= htmlspecialchars(t('nav.menu_open'), ENT_QUOTES, 'UTF-8') ?>" aria-expanded="false" aria-controls="main-nav">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>
<div class="nav-overlay" data-nav-overlay hidden></div>
