<?php
if (!isset($pageId)) {
    $pageId = 'index';
}
?>
<footer class="footer">
  <div class="container footer-inner">
    <div class="footer-brand">Gravisa</div>
    <div class="footer-tagline"><?= htmlspecialchars(t('footer.tagline') ?: 'İş Makineleri · Kiralama · Yedek Parça · Servis', ENT_QUOTES, 'UTF-8') ?></div>
    <nav class="footer-nav">
      <a href="<?= htmlspecialchars(gravisa_url('makineler'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.machines')) ?></a>
      <a href="<?= htmlspecialchars(gravisa_url('satis-teklifi'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.sales_quote')) ?></a>
      <a href="<?= htmlspecialchars(gravisa_url('kiralama'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.rental')) ?></a>
      <a href="<?= htmlspecialchars(gravisa_url('servis'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.service')) ?></a>
      <a href="<?= htmlspecialchars(gravisa_url('kurumsal'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.corporate')) ?></a>
      <a href="<?= htmlspecialchars(gravisa_url('iletisim'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.contact')) ?></a>
    </nav>
    <div class="footer-divider"></div>
    <div class="footer-subnav">
      <a href="<?= htmlspecialchars(gravisa_url('hakkimizda'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.about')) ?></a><span>|</span>
      <a href="<?= htmlspecialchars(gravisa_url('vizyon-misyon'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.vision')) ?></a><span>|</span>
      <a href="<?= htmlspecialchars(gravisa_url('referanslar'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.references')) ?></a><span>|</span>
      <a href="<?= htmlspecialchars(gravisa_url('saha-fotograflari'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.site_photos')) ?></a>
    </div>
    <p class="footer-copy">&copy; <?= htmlspecialchars(t('footer.rights')) ?> <?= htmlspecialchars(t('footer.made_by_prefix')) ?> <a href="https://nfssoft.com" target="_blank" rel="noopener"><?= htmlspecialchars(t('footer.made_by_link')) ?></a> <?= htmlspecialchars(t('footer.made_by_suffix')) ?></p>
  </div>
</footer>
<script>
(function () {
  try {
    localStorage.setItem('gravisa_lang', '<?= GRAVISA_LANG === 'en' ? 'en' : 'tr' ?>');
  } catch (e) {}
})();
</script>
