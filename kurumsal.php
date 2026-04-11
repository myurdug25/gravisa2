<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'kurumsal';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(gravisa_html_lang(), ENT_QUOTES, 'UTF-8') ?>">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/styles.css?v=<?= @filemtime(__DIR__ . '/assets/css/styles.css') ?: 16 ?>" />
</head>
<body>
  <a href="<?= htmlspecialchars(getWaUrl(), ENT_QUOTES, 'UTF-8') ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="<?= htmlspecialchars(t('pages.index.whatsapp_aria'), ENT_QUOTES, 'UTF-8') ?>">
    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <?php include __DIR__ . '/includes/site-header.php'; ?>

  <main>
    <section class="page-hero">
      <div class="container">
        <h1><?= htmlspecialchars(t('pages.kurumsal.hero_title'), ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars(t('pages.kurumsal.hero_sub'), ENT_QUOTES, 'UTF-8') ?></p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="corp-hub-grid">
          <a href="<?= htmlspecialchars(gravisa_url('hakkimizda'), ENT_QUOTES, 'UTF-8') ?>" class="corp-hub-card">
            <h3><?= htmlspecialchars(t('pages.kurumsal.card_about_t'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.kurumsal.card_about_d'), ENT_QUOTES, 'UTF-8') ?></p>
            <span class="card-link-label"><?= htmlspecialchars(t('pages.kurumsal.link_more'), ENT_QUOTES, 'UTF-8') ?></span>
          </a>
          <a href="<?= htmlspecialchars(gravisa_url('vizyon-misyon'), ENT_QUOTES, 'UTF-8') ?>" class="corp-hub-card">
            <h3><?= htmlspecialchars(t('pages.kurumsal.card_vm_t'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.kurumsal.card_vm_d'), ENT_QUOTES, 'UTF-8') ?></p>
            <span class="card-link-label"><?= htmlspecialchars(t('pages.kurumsal.link_more'), ENT_QUOTES, 'UTF-8') ?></span>
          </a>
          <a href="<?= htmlspecialchars(gravisa_url('referanslar'), ENT_QUOTES, 'UTF-8') ?>" class="corp-hub-card">
            <h3><?= htmlspecialchars(t('pages.kurumsal.card_ref_t'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.kurumsal.card_ref_d'), ENT_QUOTES, 'UTF-8') ?></p>
            <span class="card-link-label"><?= htmlspecialchars(t('pages.kurumsal.link_refs'), ENT_QUOTES, 'UTF-8') ?></span>
          </a>
          <a href="<?= htmlspecialchars(gravisa_url('saha-fotograflari'), ENT_QUOTES, 'UTF-8') ?>" class="corp-hub-card">
            <h3><?= htmlspecialchars(t('pages.kurumsal.card_photo_t'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.kurumsal.card_photo_d'), ENT_QUOTES, 'UTF-8') ?></p>
            <span class="card-link-label"><?= htmlspecialchars(t('pages.kurumsal.link_photos'), ENT_QUOTES, 'UTF-8') ?></span>
          </a>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/site-footer.php'; ?>

  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=8"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=<?= @filemtime(__DIR__ . '/assets/js/app.js') ?: 4 ?>"></script>
</body>
</html>
