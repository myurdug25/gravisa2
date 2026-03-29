<?php
/** @var string $pageId */
if (!isset($pageId)) {
    $pageId = 'index';
}
$slug = gravisa_current_page_slug();
$qs = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? ('?' . $_SERVER['QUERY_STRING']) : '';
$hrefTr = htmlspecialchars(gravisa_url_for_lang('tr', $slug) . $qs, ENT_QUOTES, 'UTF-8');
$hrefEn = htmlspecialchars(gravisa_url_for_lang('en', $slug) . $qs, ENT_QUOTES, 'UTF-8');
$langTrActive = GRAVISA_LANG === 'tr' ? ' is-active' : '';
$langEnActive = GRAVISA_LANG === 'en' ? ' is-active' : '';
?>
<header class="header">
  <div class="container header-inner">
    <a href="<?= htmlspecialchars(gravisa_url(''), ENT_QUOTES, 'UTF-8') ?>" class="logo" aria-label="Gravisa"><img src="<?= BASE_PATH ?>/images/gravisa-transparan-logo.png" alt="Gravisa" /></a>
    <nav class="nav" id="main-nav">
      <ul>
        <li><a href="<?= htmlspecialchars(gravisa_url(''), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.home')) ?></a></li>
        <li><a href="<?= htmlspecialchars(gravisa_url('makineler'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.machines')) ?></a></li>
        <li><a href="<?= htmlspecialchars(gravisa_url('satis-teklifi'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.sales_quote')) ?></a></li>
        <li><a href="<?= htmlspecialchars(gravisa_url('kiralama'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.rental')) ?></a></li>
        <li><a href="<?= htmlspecialchars(gravisa_url('servis'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.service')) ?></a></li>
        <li class="nav-dropdown">
          <div class="nav-dropdown-head">
            <a class="nav-dropdown-link" href="<?= htmlspecialchars(gravisa_url('kurumsal'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.corporate')) ?></a>
            <button type="button" class="nav-dropdown-toggle" aria-label="<?= htmlspecialchars(t('nav.corporate'), ENT_QUOTES, 'UTF-8') ?>" aria-expanded="false"></button>
          </div>
          <ul>
            <li><a href="<?= htmlspecialchars(gravisa_url('hakkimizda'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.about')) ?></a></li>
            <li><a href="<?= htmlspecialchars(gravisa_url('vizyon-misyon'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.vision')) ?></a></li>
            <li><a href="<?= htmlspecialchars(gravisa_url('referanslar'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.references')) ?></a></li>
            <li><a href="<?= htmlspecialchars(gravisa_url('saha-fotograflari'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.site_photos')) ?></a></li>
          </ul>
        </li>
        <li><a href="<?= htmlspecialchars(gravisa_url('iletisim'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.contact')) ?></a></li>
      </ul>
    </nav>
    <div class="header-end">
      <div class="lang-switcher" role="group" aria-label="<?= htmlspecialchars(t('nav.lang_menu'), ENT_QUOTES, 'UTF-8') ?>">
        <a class="lang-switcher__btn<?= $langTrActive ?>" href="<?= $hrefTr ?>" hreflang="tr" lang="tr" aria-label="<?= htmlspecialchars(t('nav.lang_switch_tr'), ENT_QUOTES, 'UTF-8') ?>"<?= GRAVISA_LANG === 'tr' ? ' aria-current="true"' : '' ?>><span class="lang-switcher__abbr">TR</span></a>
        <a class="lang-switcher__btn<?= $langEnActive ?>" href="<?= $hrefEn ?>" hreflang="en" lang="en" aria-label="<?= htmlspecialchars(t('nav.lang_switch_en'), ENT_QUOTES, 'UTF-8') ?>"<?= GRAVISA_LANG === 'en' ? ' aria-current="true"' : '' ?>><span class="lang-switcher__abbr">EN</span></a>
      </div>
      <button class="nav-toggle" aria-label="<?= htmlspecialchars(t('nav.menu_open'), ENT_QUOTES, 'UTF-8') ?>" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>
