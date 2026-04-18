<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'index';

$heroVideoFilename = '0415.mp4';
$heroVideoPathFs = __DIR__ . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . $heroVideoFilename;
$heroHasBgVideo = is_file($heroVideoPathFs);
$heroVideoSrc = $heroHasBgVideo
    ? (BASE_PATH . '/videos/' . rawurlencode($heroVideoFilename) . '?v=' . (int) @filemtime($heroVideoPathFs))
    : '';
// Aynı isimle hafif sürüm: 0415.mp4 → 0415-mobile.mp4 (düşük çözünürlük/bitrate; telefon için FTP ile yükleyin)
$heroVideoStem = pathinfo($heroVideoFilename, PATHINFO_FILENAME);
$heroVideoMobileFilename = $heroVideoStem . '-mobile.mp4';
$heroVideoMobilePathFs = __DIR__ . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . $heroVideoMobileFilename;
$heroHasMobileVideo = $heroHasBgVideo && is_file($heroVideoMobilePathFs);
$heroVideoMobileSrc = $heroHasMobileVideo
    ? (BASE_PATH . '/videos/' . rawurlencode($heroVideoMobileFilename) . '?v=' . (int) @filemtime($heroVideoMobilePathFs))
    : '';
$heroVideoPoster = BASE_PATH . '/images/IMG_9059.JPG.jpeg';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(gravisa_html_lang(), ENT_QUOTES, 'UTF-8') ?>">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <meta name="theme-color" content="#eef2f6" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/styles.css?v=<?= @filemtime(__DIR__ . '/assets/css/styles.css') ?: 16 ?>" />
</head>
<body<?= $heroHasBgVideo ? ' class="has-ambient-video"' : '' ?>>
  <?php if ($heroHasBgVideo): ?>
  <div class="ambient-video" aria-hidden="true" data-has-mobile-src="<?= $heroHasMobileVideo ? '1' : '0' ?>">
    <video
      class="ambient-video__media"
      poster="<?= htmlspecialchars($heroVideoPoster, ENT_QUOTES, 'UTF-8') ?>"
      autoplay
      muted
      loop
      playsinline
      preload="metadata"
      fetchpriority="low"
    >
      <?php if ($heroHasMobileVideo): ?>
      <source src="<?= htmlspecialchars($heroVideoMobileSrc, ENT_QUOTES, 'UTF-8') ?>" type="video/mp4" media="(max-width: 896px)" />
      <?php endif; ?>
      <source src="<?= htmlspecialchars($heroVideoSrc, ENT_QUOTES, 'UTF-8') ?>" type="video/mp4" />
    </video>
    <div class="ambient-video__scrim"></div>
  </div>
  <?php endif; ?>
  <a href="<?= htmlspecialchars(getWaUrl(), ENT_QUOTES, 'UTF-8') ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="<?= htmlspecialchars(t('pages.index.whatsapp_aria'), ENT_QUOTES, 'UTF-8') ?>">
    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.87 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <?php include __DIR__ . '/includes/site-header.php'; ?>

  <main<?= $heroHasBgVideo ? ' class="page-home page-home--video"' : '' ?>>
    <section class="section section-alt section-stock-top" id="stokta">
      <div class="container">
        <div class="section-header-flex">
          <div>
            <h2 class="section-title section-title-left"><?= htmlspecialchars(t('pages.index.stock_title'), ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="section-desc section-desc-left"><?= htmlspecialchars(t('pages.index.stock_desc'), ENT_QUOTES, 'UTF-8') ?></p>
          </div>
          <a href="<?= htmlspecialchars(gravisa_url('makineler'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary"><?= htmlspecialchars(t('pages.index.stock_cta'), ENT_QUOTES, 'UTF-8') ?></a>
        </div>
        <div class="category-grid" id="stokta-categories" aria-label="<?= htmlspecialchars(t('pages.index.stock_categories_aria'), ENT_QUOTES, 'UTF-8') ?>"></div>
        <div class="section-cta" style="margin-top: 18px;">
          <button type="button" class="btn btn-outline" id="stokta-categories-toggle" aria-expanded="false">
            <?= htmlspecialchars(t('pages.index.show_all_categories'), ENT_QUOTES, 'UTF-8') ?>
          </button>
        </div>
      </div>
    </section>

    <section class="hero<?= $heroHasBgVideo ? ' hero--has-video' : '' ?>">
      <div class="hero-content">
        <div class="banner-card">
          <div class="banner-card-body">
            <span class="hero-badge"><?= htmlspecialchars(t('pages.index.hero_badge'), ENT_QUOTES, 'UTF-8') ?></span>
            <h1 class="hero-title"><?= htmlspecialchars(t('pages.index.hero_title_line1'), ENT_QUOTES, 'UTF-8') ?> <span><?= htmlspecialchars(t('pages.index.hero_title_line2'), ENT_QUOTES, 'UTF-8') ?></span></h1>
            <p class="hero-subtitle"><?= htmlspecialchars(t('pages.index.hero_subtitle'), ENT_QUOTES, 'UTF-8') ?></p>
            <div class="hero-buttons">
              <a href="<?= htmlspecialchars(gravisa_url('makineler'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary btn--hero-primary"><?= htmlspecialchars(t('pages.index.btn_browse'), ENT_QUOTES, 'UTF-8') ?></a>
              <a href="<?= htmlspecialchars(gravisa_url('satis-teklifi'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline btn--hero-secondary"><?= htmlspecialchars(t('pages.index.btn_sales'), ENT_QUOTES, 'UTF-8') ?></a>
              <a href="<?= htmlspecialchars(gravisa_url('kiralama'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline btn--hero-secondary"><?= htmlspecialchars(t('pages.index.btn_rent'), ENT_QUOTES, 'UTF-8') ?></a>
            </div>
            <div class="hero-stats">
              <div class="hero-stat-card">
                <span class="hero-stat-icon">🚜</span>
                <span class="hero-stat-value">319+</span>
                <span class="hero-stat-label"><?= htmlspecialchars(t('pages.index.stat_types'), ENT_QUOTES, 'UTF-8') ?></span>
              </div>
              <div class="hero-stat-card">
                <span class="hero-stat-icon">👥</span>
                <span class="hero-stat-value">500+</span>
                <span class="hero-stat-label"><?= htmlspecialchars(t('pages.index.stat_customers'), ENT_QUOTES, 'UTF-8') ?></span>
              </div>
              <div class="hero-stat-card">
                <span class="hero-stat-icon">⭐</span>
                <span class="hero-stat-value">15+</span>
                <span class="hero-stat-label"><?= htmlspecialchars(t('pages.index.stat_exp'), ENT_QUOTES, 'UTF-8') ?></span>
              </div>
              <div class="hero-stat-card">
                <span class="hero-stat-icon">🔧</span>
                <span class="hero-stat-value">7/24</span>
                <span class="hero-stat-label"><?= htmlspecialchars(t('pages.index.stat_support'), ENT_QUOTES, 'UTF-8') ?></span>
              </div>
            </div>
          </div>
          <div class="banner-card-media" aria-hidden="true">
            <div class="hero-image-frame">
              <img src="<?= BASE_PATH ?>/images/IMG_9059.JPG.jpeg" alt="<?= htmlspecialchars(t('pages.index.img_machine_alt'), ENT_QUOTES, 'UTF-8') ?>" onerror="this.style.display='none'" />
              <span class="hero-image-fallback">🚜</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="hizmetler">
      <div class="container<?= $heroHasBgVideo ? ' home-surface' : '' ?>">
        <h2 class="section-title"><?= htmlspecialchars(t('pages.index.services_title'), ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="section-desc"><?= htmlspecialchars(t('pages.index.services_desc'), ENT_QUOTES, 'UTF-8') ?></p>
        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-icon-wrap">🚚</div>
            <h3><?= htmlspecialchars(t('pages.index.svc_sales'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.index.svc_sales_desc'), ENT_QUOTES, 'UTF-8') ?></p>
            <a href="<?= htmlspecialchars(gravisa_url('satis-teklifi'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline"><?= htmlspecialchars(t('pages.index.btn_quote'), ENT_QUOTES, 'UTF-8') ?></a>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">⏱️</div>
            <h3><?= htmlspecialchars(t('pages.index.svc_rent'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.index.svc_rent_desc'), ENT_QUOTES, 'UTF-8') ?></p>
            <a href="<?= htmlspecialchars(gravisa_url('kiralama'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline"><?= htmlspecialchars(t('pages.index.btn_rent_short'), ENT_QUOTES, 'UTF-8') ?></a>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">🔧</div>
            <h3><?= htmlspecialchars(t('pages.index.svc_service'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.index.svc_service_desc'), ENT_QUOTES, 'UTF-8') ?></p>
            <a href="<?= htmlspecialchars(gravisa_url('servis'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline"><?= htmlspecialchars(t('pages.index.btn_details'), ENT_QUOTES, 'UTF-8') ?></a>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">📦</div>
            <h3><?= htmlspecialchars(t('pages.index.svc_parts'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.index.svc_parts_desc'), ENT_QUOTES, 'UTF-8') ?></p>
            <a href="<?= htmlspecialchars(gravisa_url('servis'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline"><?= htmlspecialchars(t('pages.index.btn_contact_nav'), ENT_QUOTES, 'UTF-8') ?></a>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="demo">
      <div class="container section-inner-card<?= $heroHasBgVideo ? ' home-surface' : '' ?>">
        <h2 class="section-title"><?= htmlspecialchars(t('pages.index.demo_title'), ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="section-desc"><?= htmlspecialchars(t('pages.index.demo_desc'), ENT_QUOTES, 'UTF-8') ?></p>
        <form class="demo-form form-block" id="demo-form">
          <input type="text" name="website" value="" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;" tabindex="-1" autocomplete="off" aria-hidden="true" />
          <div class="form-row">
            <label>
              <span><?= htmlspecialchars(t('pages.index.label_name'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="text" name="name" required placeholder="<?= htmlspecialchars(t('pages.index.ph_name'), ENT_QUOTES, 'UTF-8') ?>" />
            </label>
            <label>
              <span><?= htmlspecialchars(t('pages.index.label_phone'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="tel" name="phone" required placeholder="<?= htmlspecialchars(t('pages.index.ph_phone'), ENT_QUOTES, 'UTF-8') ?>" />
            </label>
          </div>
          <label class="demo-form-email">
            <span><?= htmlspecialchars(t('pages.index.label_email'), ENT_QUOTES, 'UTF-8') ?></span>
            <input type="email" name="email" required placeholder="<?= htmlspecialchars(t('pages.index.ph_email'), ENT_QUOTES, 'UTF-8') ?>" />
          </label>
          <div class="form-row">
            <label>
              <span><?= htmlspecialchars(t('pages.index.label_machine'), ENT_QUOTES, 'UTF-8') ?></span>
              <div class="custom-select-wrap" id="machine-select-wrap" aria-label="<?= htmlspecialchars(t('pages.index.label_machine'), ENT_QUOTES, 'UTF-8') ?>">
                <button type="button" class="custom-select-trigger" id="machine-select-trigger" aria-haspopup="listbox" aria-expanded="false"><?= htmlspecialchars(t('js.select'), ENT_QUOTES, 'UTF-8') ?></button>
                <input type="hidden" name="machine" id="machine-select-input" value="" required />
                <ul class="custom-select-list" role="listbox" id="machine-select-list">
                  <li role="option" class="custom-select-option is-selected" data-value=""><?= htmlspecialchars(t('js.select'), ENT_QUOTES, 'UTF-8') ?></li>
                  <li role="option" class="custom-select-option" data-value="ekskavatör"><?= htmlspecialchars(t('pages.index.machine_exc'), ENT_QUOTES, 'UTF-8') ?></li>
                  <li role="option" class="custom-select-option" data-value="loder"><?= htmlspecialchars(t('pages.index.machine_loader'), ENT_QUOTES, 'UTF-8') ?></li>
                  <li role="option" class="custom-select-option" data-value="greyder"><?= htmlspecialchars(t('pages.index.machine_grader'), ENT_QUOTES, 'UTF-8') ?></li>
                  <li role="option" class="custom-select-option" data-value="diger"><?= htmlspecialchars(t('pages.index.machine_other'), ENT_QUOTES, 'UTF-8') ?></li>
                </ul>
              </div>
            </label>
            <label>
              <span><?= htmlspecialchars(t('pages.index.label_date'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="date" name="date" />
            </label>
          </div>
          <label>
            <span><?= htmlspecialchars(t('pages.index.label_note'), ENT_QUOTES, 'UTF-8') ?></span>
            <textarea name="note" rows="3" placeholder="<?= htmlspecialchars(t('pages.index.ph_note'), ENT_QUOTES, 'UTF-8') ?>"></textarea>
          </label>
          <div class="demo-form-actions">
            <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('pages.index.demo_submit'), ENT_QUOTES, 'UTF-8') ?></button>
          </div>
        </form>
      </div>
    </section>

    <section class="section section-alt" id="servis-ozet">
      <div class="container servis-ozet-wrap">
        <h2 class="section-title"><?= htmlspecialchars(t('pages.index.serv_block_title'), ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="section-desc"><?= htmlspecialchars(t('pages.index.serv_block_desc'), ENT_QUOTES, 'UTF-8') ?></p>
        <div class="service-list">
          <div class="service-list-item">
            <div class="service-list-icon">🔧</div>
            <div>
              <strong><?= htmlspecialchars(t('pages.index.serv_net'), ENT_QUOTES, 'UTF-8') ?></strong>
              <span><?= htmlspecialchars(t('pages.index.serv_net_desc'), ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
          <div class="service-list-item">
            <div class="service-list-icon">🚛</div>
            <div>
              <strong><?= htmlspecialchars(t('pages.index.mob_serv'), ENT_QUOTES, 'UTF-8') ?></strong>
              <span><?= htmlspecialchars(t('pages.index.mob_serv_desc'), ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
          <div class="service-list-item">
            <div class="service-list-icon">⚙️</div>
            <div>
              <strong><?= htmlspecialchars(t('pages.index.parts_short'), ENT_QUOTES, 'UTF-8') ?></strong>
              <span><?= htmlspecialchars(t('pages.index.parts_short_desc'), ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
        </div>
        <div class="servis-ozet-actions">
          <a href="<?= htmlspecialchars(gravisa_url('servis'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary servis-ozet-cta"><?= htmlspecialchars(t('pages.index.serv_cta'), ENT_QUOTES, 'UTF-8') ?></a>
        </div>
        <div class="servis-ozet-chips" role="group" aria-label="<?= htmlspecialchars(t('pages.index.quick_contact'), ENT_QUOTES, 'UTF-8') ?>">
          <a href="tel:+<?= getWaNum() ?>" class="servis-chip"><?= htmlspecialchars(t('pages.index.phone_lbl'), ENT_QUOTES, 'UTF-8') ?>: <?= htmlspecialchars($siteSettings['phone_display'] ?? '', ENT_QUOTES, 'UTF-8') ?></a>
          <a href="mailto:<?= htmlspecialchars($siteSettings['contact_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="servis-chip"><?= htmlspecialchars(t('pages.index.email_lbl'), ENT_QUOTES, 'UTF-8') ?>: <?= htmlspecialchars($siteSettings['contact_email'] ?? '', ENT_QUOTES, 'UTF-8') ?></a>
          <a href="<?= htmlspecialchars(getWaUrl(), ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener" class="servis-chip servis-chip--wa"><strong><?= htmlspecialchars(t('pages.index.wa_lbl'), ENT_QUOTES, 'UTF-8') ?></strong> — <?= htmlspecialchars(t('pages.index.wa_cta'), ENT_QUOTES, 'UTF-8') ?></a>
        </div>
      </div>
    </section>

    <section class="section" id="kurumsal-ozet">
      <div class="container<?= $heroHasBgVideo ? ' home-surface' : '' ?>">
        <h2 class="section-title"><?= htmlspecialchars(t('pages.index.why_title'), ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="section-desc"><?= htmlspecialchars(t('pages.index.why_sub'), ENT_QUOTES, 'UTF-8') ?></p>
        <p class="section-desc" style="max-width: 720px; margin: 0 auto 28px;"><?= htmlspecialchars(t('pages.index.why_p'), ENT_QUOTES, 'UTF-8') ?></p>
        <div class="trust-grid">
          <div class="trust-item"><strong>15+</strong><span><?= htmlspecialchars(t('pages.index.trust_years'), ENT_QUOTES, 'UTF-8') ?></span></div>
          <div class="trust-item"><strong>500+</strong><span><?= htmlspecialchars(t('pages.index.stat_customers'), ENT_QUOTES, 'UTF-8') ?></span></div>
          <div class="trust-item"><strong>7/24</strong><span><?= htmlspecialchars(t('pages.index.trust_support'), ENT_QUOTES, 'UTF-8') ?></span></div>
          <div class="trust-item"><strong>319+</strong><span><?= htmlspecialchars(t('pages.index.trust_types'), ENT_QUOTES, 'UTF-8') ?></span></div>
        </div>
        <div class="value-cards">
          <div class="value-card"><h4><?= htmlspecialchars(t('pages.index.v1h'), ENT_QUOTES, 'UTF-8') ?></h4><p><?= htmlspecialchars(t('pages.index.v1t'), ENT_QUOTES, 'UTF-8') ?></p></div>
          <div class="value-card"><h4><?= htmlspecialchars(t('pages.index.v2h'), ENT_QUOTES, 'UTF-8') ?></h4><p><?= htmlspecialchars(t('pages.index.v2t'), ENT_QUOTES, 'UTF-8') ?></p></div>
          <div class="value-card"><h4><?= htmlspecialchars(t('pages.index.v3h'), ENT_QUOTES, 'UTF-8') ?></h4><p><?= htmlspecialchars(t('pages.index.v3t'), ENT_QUOTES, 'UTF-8') ?></p></div>
          <div class="value-card"><h4><?= htmlspecialchars(t('pages.index.v4h'), ENT_QUOTES, 'UTF-8') ?></h4><p><?= htmlspecialchars(t('pages.index.v4t'), ENT_QUOTES, 'UTF-8') ?></p></div>
          <div class="value-card"><h4><?= htmlspecialchars(t('pages.index.v5h'), ENT_QUOTES, 'UTF-8') ?></h4><p><?= htmlspecialchars(t('pages.index.v5t'), ENT_QUOTES, 'UTF-8') ?></p></div>
        </div>
        <div class="section-cta">
          <a href="<?= htmlspecialchars(gravisa_url('hakkimizda'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary"><?= htmlspecialchars(t('pages.index.more_info'), ENT_QUOTES, 'UTF-8') ?></a>
        </div>
      </div>
    </section>

    <section class="section section-alt" id="iletisim">
      <div class="container">
        <h2 class="section-title"><?= htmlspecialchars(t('pages.index.contact_section_title'), ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="section-desc"><?= htmlspecialchars(t('pages.index.contact_section_desc'), ENT_QUOTES, 'UTF-8') ?></p>
        <div class="contact-cards">
          <div class="contact-card">
            <h3><?= htmlspecialchars(t('pages.index.addr_title'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= nl2br(htmlspecialchars($siteSettings['address'] ?? '')) ?></p>
          </div>
          <div class="contact-card">
            <h3><?= htmlspecialchars(t('pages.index.contact_title'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><strong><?= htmlspecialchars(t('pages.index.tel_lbl'), ENT_QUOTES, 'UTF-8') ?></strong> <a href="tel:+<?= getWaNum() ?>"><?= htmlspecialchars($siteSettings['phone_display'] ?? '') ?></a></p>
            <p><strong><?= htmlspecialchars(t('pages.index.email_word'), ENT_QUOTES, 'UTF-8') ?></strong> <a href="mailto:<?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?>"><?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?></a></p>
          </div>
          <div class="contact-card">
            <h3><?= htmlspecialchars(t('pages.index.quick_access'), ENT_QUOTES, 'UTF-8') ?></h3>
            <div class="contact-card-actions">
              <a href="<?= htmlspecialchars(getWaUrl(), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-whatsapp" target="_blank" rel="noopener"><?= htmlspecialchars(t('pages.index.wa_write'), ENT_QUOTES, 'UTF-8') ?></a>
              <a href="<?= htmlspecialchars(gravisa_url('iletisim'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline"><?= htmlspecialchars(t('pages.index.contact_form_btn'), ENT_QUOTES, 'UTF-8') ?></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/site-footer.php'; ?>

  <script src="<?= BASE_PATH ?>/assets/js/form-api.js?v=3"></script>
  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=9"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app-makineler.js?v=<?= @filemtime(__DIR__ . '/assets/js/app-makineler.js') ?: 14 ?>"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=<?= @filemtime(__DIR__ . '/assets/js/app.js') ?: 4 ?>"></script>
  <?php if ($heroHasBgVideo): ?>
  <script>
  (function () {
    var holder = document.querySelector('.ambient-video');
    if (!holder) return;
    var el = holder.querySelector('.ambient-video__media');
    if (!el) return;

    var hasMobileSrc = holder.getAttribute('data-has-mobile-src') === '1';
    var mqNarrow = window.matchMedia('(max-width: 896px)');
    var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    var saveData = !!(conn && conn.saveData);
    var slowNet = !!(conn && /^(2g|slow-2g)$/i.test(String(conn.effectiveType || '')));

    function goPosterOnly() {
      holder.classList.add('ambient-video--poster-only');
      var poster = el.getAttribute('poster');
      if (poster) {
        holder.style.backgroundImage = 'url("' + String(poster).replace(/"/g, '\\"') + '")';
      }
      try {
        el.pause();
        el.removeAttribute('src');
        var sources = el.querySelectorAll('source');
        for (var i = 0; i < sources.length; i++) {
          sources[i].removeAttribute('src');
        }
        el.load();
      } catch (e) {}
    }

    // Telefonda ağır videoyu zorlamayalım: -mobile.mp4 yoksa poster; saveData / yavaş şebekede de poster
    if (!hasMobileSrc && (mqNarrow.matches || saveData || slowNet)) {
      goPosterOnly();
      return;
    }

    var shouldPlay = true;
    function tryPlay() {
      if (!shouldPlay || holder.classList.contains('ambient-video--poster-only')) return;
      var p = el.play();
      if (p && typeof p.catch === 'function') p.catch(function () {});
    }
    function pause() {
      try { el.pause(); } catch (e) {}
    }
    if (document.readyState === 'complete') tryPlay();
    else window.addEventListener('load', tryPlay);

    document.addEventListener('visibilitychange', function () {
      shouldPlay = (document.visibilityState === 'visible');
      if (shouldPlay) tryPlay();
      else pause();
    });

    if ('IntersectionObserver' in window) {
      try {
        var io = new IntersectionObserver(function (entries) {
          var ent = entries && entries[0];
          var inView = !!(ent && ent.isIntersecting);
          shouldPlay = inView && (document.visibilityState === 'visible');
          if (shouldPlay) tryPlay();
          else pause();
        }, { root: null, threshold: 0.01 });
        io.observe(holder);
      } catch (e) {}
    }
  })();
  </script>
  <?php endif; ?>
</body>
</html>
