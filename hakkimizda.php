<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'hakkimizda';
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
        <h1><?= htmlspecialchars(t('pages.hakkimizda.hero_title'), ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars(t('pages.hakkimizda.hero_sub'), ENT_QUOTES, 'UTF-8') ?></p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="content-page content-page--wide">
          <nav class="breadcrumb">
            <a href="<?= htmlspecialchars(gravisa_url(''), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.home'), ENT_QUOTES, 'UTF-8') ?></a><span>/</span>
            <a href="<?= htmlspecialchars(gravisa_url('kurumsal'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(t('nav.corporate'), ENT_QUOTES, 'UTF-8') ?></a><span>/</span>
            <span><?= htmlspecialchars(t('pages.hakkimizda.hero_title'), ENT_QUOTES, 'UTF-8') ?></span>
          </nav>

          <!-- Önsöz -->
          <div class="content-block" style="margin-bottom: 48px;">
            <h2 class="content-block-title"><?= htmlspecialchars(t('pages.hakkimizda.preface_h'), ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.preface_p1'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.preface_p2'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.preface_p3'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.preface_p4'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text" style="font-weight: 600; color: var(--color-primary);"><?= htmlspecialchars(t('pages.hakkimizda.preface_sign'), ENT_QUOTES, 'UTF-8') ?></p>
          </div>

          <!-- Bizim Hikayemiz -->
          <div class="content-block" style="margin-bottom: 48px;">
            <h2 class="content-block-title"><?= htmlspecialchars(t('pages.hakkimizda.story_h'), ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="content-block-subtitle"><?= htmlspecialchars(t('pages.hakkimizda.story_sub'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.story_p1'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.story_p2'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.story_p3'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.story_p4'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text" style="font-weight: 600; color: var(--color-primary);"><?= htmlspecialchars(t('pages.hakkimizda.story_tag1'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text" style="font-weight: 600;"><?= htmlspecialchars(t('pages.hakkimizda.story_tag2'), ENT_QUOTES, 'UTF-8') ?></p>
            <div class="content-stats-grid">
              <div style="text-align: center; padding: 24px; background: var(--color-surface-alt); border-radius: var(--radius);">
                <strong style="display: block; font-size: 2rem; color: var(--color-primary); margin-bottom: 8px;">15+</strong>
                <span style="color: var(--color-text-muted); font-size: 0.9rem;"><?= htmlspecialchars(t('pages.hakkimizda.stat_years'), ENT_QUOTES, 'UTF-8') ?></span>
              </div>
              <div style="text-align: center; padding: 24px; background: var(--color-surface-alt); border-radius: var(--radius);">
                <strong style="display: block; font-size: 2rem; color: var(--color-primary); margin-bottom: 8px;">500+</strong>
                <span style="color: var(--color-text-muted); font-size: 0.9rem;"><?= htmlspecialchars(t('pages.hakkimizda.stat_projects'), ENT_QUOTES, 'UTF-8') ?></span>
              </div>
              <div style="text-align: center; padding: 24px; background: var(--color-surface-alt); border-radius: var(--radius);">
                <strong style="display: block; font-size: 2rem; color: var(--color-primary); margin-bottom: 8px;">319+</strong>
                <span style="color: var(--color-text-muted); font-size: 0.9rem;"><?= htmlspecialchars(t('pages.hakkimizda.stat_machines'), ENT_QUOTES, 'UTF-8') ?></span>
              </div>
            </div>
          </div>

          <!-- Neden Biz? -->
          <div class="content-block" style="margin-bottom: 48px;">
            <h2 class="content-block-title"><?= htmlspecialchars(t('pages.hakkimizda.why_h'), ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="content-block-subtitle"><?= htmlspecialchars(t('pages.hakkimizda.why_sub'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="content-block-text"><?= htmlspecialchars(t('pages.hakkimizda.why_intro'), ENT_QUOTES, 'UTF-8') ?></p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-top: 28px;">
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.why1_h'), ENT_QUOTES, 'UTF-8') ?></h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;"><?= htmlspecialchars(t('pages.hakkimizda.why1_p'), ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.why2_h'), ENT_QUOTES, 'UTF-8') ?></h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;"><?= htmlspecialchars(t('pages.hakkimizda.why2_p'), ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.why3_h'), ENT_QUOTES, 'UTF-8') ?></h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;"><?= htmlspecialchars(t('pages.hakkimizda.why3_p'), ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.why4_h'), ENT_QUOTES, 'UTF-8') ?></h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;"><?= htmlspecialchars(t('pages.hakkimizda.why4_p'), ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.why5_h'), ENT_QUOTES, 'UTF-8') ?></h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;"><?= htmlspecialchars(t('pages.hakkimizda.why5_p'), ENT_QUOTES, 'UTF-8') ?></p>
              </div>
            </div>
          </div>

          <!-- Çalışma Alanlarımız -->
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-bottom: 48px; align-items: start;">
            <div>
              <h2 style="font-size: 1.75rem; margin: 0 0 24px; color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.areas_h'), ENT_QUOTES, 'UTF-8') ?></h2>
              <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.area1'), ENT_QUOTES, 'UTF-8') ?></span>
                </li>
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.area2'), ENT_QUOTES, 'UTF-8') ?></span>
                </li>
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.area3'), ENT_QUOTES, 'UTF-8') ?></span>
                </li>
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.area4'), ENT_QUOTES, 'UTF-8') ?></span>
                </li>
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.area5'), ENT_QUOTES, 'UTF-8') ?></span>
                </li>
              </ul>
            </div>
            <div style="background: var(--color-surface-alt); padding: 40px; border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
              <h3 style="font-size: 1.25rem; margin: 0 0 20px; color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.vm_h'), ENT_QUOTES, 'UTF-8') ?></h3>
              <p style="margin: 0 0 16px; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;"><?= htmlspecialchars(t('pages.hakkimizda.vm_p'), ENT_QUOTES, 'UTF-8') ?></p>
              <a href="vizyon-misyon" class="btn btn-outline"><?= htmlspecialchars(t('pages.hakkimizda.vm_btn'), ENT_QUOTES, 'UTF-8') ?></a>
            </div>
          </div>

          <div style="margin-top: 48px; padding: 32px; background: linear-gradient(135deg, var(--color-primary-soft) 0%, var(--color-accent-soft) 100%); border-radius: var(--radius-lg); text-align: center;">
            <h3 style="font-size: 1.5rem; margin: 0 0 16px; color: var(--color-text);"><?= htmlspecialchars(t('pages.hakkimizda.cta_h'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p style="margin: 0 0 24px; color: var(--color-text-muted);"><?= htmlspecialchars(t('pages.hakkimizda.cta_p'), ENT_QUOTES, 'UTF-8') ?></p>
            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
              <a href="satis-teklifi" class="btn btn-primary"><?= htmlspecialchars(t('pages.hakkimizda.cta_sales'), ENT_QUOTES, 'UTF-8') ?></a>
              <a href="kiralama" class="btn btn-secondary"><?= htmlspecialchars(t('pages.hakkimizda.cta_rent'), ENT_QUOTES, 'UTF-8') ?></a>
              <a href="iletisim" class="btn btn-outline"><?= htmlspecialchars(t('pages.hakkimizda.cta_contact'), ENT_QUOTES, 'UTF-8') ?></a>
            </div>
          </div>

          <p style="margin-top: 32px; text-align: center;">
            <a href="<?= htmlspecialchars(gravisa_url('kurumsal'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline"><?= htmlspecialchars(t('pages.corp_common.back_corporate'), ENT_QUOTES, 'UTF-8') ?></a>
          </p>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/site-footer.php'; ?>

  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=9"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=<?= @filemtime(__DIR__ . '/assets/js/app.js') ?: 4 ?>"></script>
</body>
</html>
