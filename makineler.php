<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'makineler';
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
        <h1><?= htmlspecialchars(t('pages.makineler.hero_title'), ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars(t('pages.makineler.hero_sub'), ENT_QUOTES, 'UTF-8') ?></p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="catalog-categories" aria-label="<?= htmlspecialchars(t('pages.index.stock_categories_aria'), ENT_QUOTES, 'UTF-8') ?>">
          <div class="catalog-categories__head">
            <h2 class="section-title section-title-left" style="margin:0;"><?= htmlspecialchars(t('pages.index.stock_categories_aria'), ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="section-desc section-desc-left" style="max-width: 720px;"><?= htmlspecialchars(t('pages.makineler.pick_category_desc'), ENT_QUOTES, 'UTF-8') ?></p>
          </div>
          <div class="catalog-categories__controls">
            <input type="text" class="category-filter-input" id="category-filter" placeholder="<?= htmlspecialchars(t('pages.makineler.category_search_ph'), ENT_QUOTES, 'UTF-8') ?>" />
          </div>
          <div class="category-grid" id="catalog-categories"></div>
          <div class="section-cta" style="margin-top: 14px;">
            <button type="button" class="btn btn-outline" id="catalog-categories-toggle" aria-expanded="false">
              <?= htmlspecialchars(t('pages.index.show_all_categories'), ENT_QUOTES, 'UTF-8') ?>
            </button>
          </div>
        </div>
        <div class="catalog-layout">
          <aside class="catalog-sidebar" id="catalog-filters">
            <div class="catalog-filters">
              <h2 class="catalog-filters-title"><?= htmlspecialchars(t('pages.makineler.filters'), ENT_QUOTES, 'UTF-8') ?></h2>
              <div class="catalog-search">
                <input type="text" id="catalog-search" placeholder="<?= htmlspecialchars(t('pages.makineler.search_ph'), ENT_QUOTES, 'UTF-8') ?>" />
              </div>
              <div class="catalog-filter-group">
                <label>
                  <span><?= htmlspecialchars(t('pages.makineler.type'), ENT_QUOTES, 'UTF-8') ?></span>
                  <select id="filter-tip">
                    <option value=""><?= htmlspecialchars(t('js.filters_all'), ENT_QUOTES, 'UTF-8') ?></option>
                  </select>
                </label>
                <label>
                  <span><?= htmlspecialchars(t('pages.makineler.firm'), ENT_QUOTES, 'UTF-8') ?></span>
                  <select id="filter-firma">
                    <option value=""><?= htmlspecialchars(t('js.filters_all'), ENT_QUOTES, 'UTF-8') ?></option>
                  </select>
                </label>
                <label>
                  <span><?= htmlspecialchars(t('pages.makineler.power_kw'), ENT_QUOTES, 'UTF-8') ?></span>
                  <select id="filter-guc">
                    <option value=""><?= htmlspecialchars(t('js.filters_all'), ENT_QUOTES, 'UTF-8') ?></option>
                    <option value="0-50">0-50 kW</option>
                    <option value="50-100">50-100 kW</option>
                    <option value="100-150">100-150 kW</option>
                    <option value="150+">150+ kW</option>
                  </select>
                </label>
                <label>
                  <span><?= htmlspecialchars(t('pages.makineler.model_year'), ENT_QUOTES, 'UTF-8') ?></span>
                  <select id="filter-model-yil">
                    <option value=""><?= htmlspecialchars(t('js.filters_all'), ENT_QUOTES, 'UTF-8') ?></option>
                  </select>
                </label>
                <button type="button" class="btn btn-outline" id="reset-filters" style="width: 100%; margin-top: 8px;"><?= htmlspecialchars(t('js.filters_clear'), ENT_QUOTES, 'UTF-8') ?></button>
              </div>
            </div>
          </aside>

          <div class="catalog-content">
            <button type="button" class="catalog-filters-toggle" id="catalog-filters-toggle" aria-expanded="false" aria-controls="catalog-filters">
              <span><?= htmlspecialchars(t('pages.makineler.filters'), ENT_QUOTES, 'UTF-8') ?></span>
              <span class="filter-icon" aria-hidden="true">▼</span>
            </button>
            <div class="catalog-results-info" id="results-info"></div>

            <div class="machine-grid" id="makineler-grid"></div>

            <div id="no-results" class="no-results" style="display: none;">
              <p><?= htmlspecialchars(t('js.no_results'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <?php include __DIR__ . '/includes/site-footer.php'; ?>

  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=8"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=<?= @filemtime(__DIR__ . '/assets/js/app.js') ?: 4 ?>"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app-makineler.js?v=8"></script>
</body>
</html>
