<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'makineler';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/css/styles.css" />
</head>
<body>
  <a href="https://wa.me/<?= getWaNum() ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <header class="header">
    <div class="container header-inner">
      <a href="index" class="logo">Gravisa</a>
      <button class="nav-toggle" aria-label="Menü" aria-expanded="false"><span></span><span></span><span></span></button>
      <nav class="nav" id="main-nav">
        <ul>
          <li><a href="index">Ana Sayfa</a></li>
          <li><a href="makineler">Makineler</a></li>
          <li><a href="satis-teklifi">Satış Teklifi</a></li>
          <li><a href="kiralama">Kiralama</a></li>
          <li><a href="servis">Servis</a></li>
          <li class="nav-dropdown">
            <a href="kurumsal">Kurumsal</a>
            <ul>
              <li><a href="hakkimizda">Hakkımızda</a></li>
              <li><a href="vizyon-misyon">Vizyon & Misyon</a></li>
              <li><a href="referanslar">Referanslar</a></li>
              <li><a href="saha-fotograflari">Saha Fotoğrafları</a></li>
            </ul>
          </li>
          <li><a href="iletisim">İletişim</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section class="page-hero">
      <div class="container">
        <h1>Makine Kataloğu</h1>
        <p>Filtreleme ve arama ile ihtiyacınıza uygun makineleri bulun. Detaylı teknik bilgiler ve teklif alın.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="catalog-layout">
          <!-- Sol Taraf: Sabit Filtreler -->
          <aside class="catalog-sidebar" id="catalog-filters">
            <div class="catalog-filters">
              <h2 class="catalog-filters-title">Filtreler</h2>
              <div class="catalog-search">
                <input type="text" id="catalog-search" placeholder="Firma, model veya tip ara..." />
              </div>
              <div class="catalog-filter-group">
                <label>
                  <span>Tip (Kategori)</span>
                  <select id="filter-tip">
                    <option value="">Tümü</option>
                  </select>
                </label>
                <label>
                  <span>Firma</span>
                  <select id="filter-firma">
                    <option value="">Tümü</option>
                  </select>
                </label>
                <label>
                  <span>Güç (kW)</span>
                  <select id="filter-guc">
                    <option value="">Tümü</option>
                    <option value="0-50">0-50 kW</option>
                    <option value="50-100">50-100 kW</option>
                    <option value="100-150">100-150 kW</option>
                    <option value="150+">150+ kW</option>
                  </select>
                </label>
                <label>
                  <span>Model Yılı</span>
                  <select id="filter-model-yil">
                    <option value="">Tümü</option>
                  </select>
                </label>
                <button type="button" class="btn btn-outline" id="reset-filters" style="width: 100%; margin-top: 8px;">Filtreleri Temizle</button>
              </div>
            </div>
          </aside>

          <!-- Sağ Taraf: Sonuçlar -->
          <div class="catalog-content">
            <button type="button" class="catalog-filters-toggle" id="catalog-filters-toggle" aria-expanded="false" aria-controls="catalog-filters">
              <span>Filtreler</span>
              <span class="filter-icon" aria-hidden="true">▼</span>
            </button>
            <div class="catalog-results-info" id="results-info"></div>

            <div class="machine-grid" id="makineler-grid">
              <!-- app-makineler.js ile doldurulacak -->
            </div>

            <div id="no-results" class="no-results" style="display: none;">
              <p>Filtre kriterlerinize uygun makine bulunamadı.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer class="footer">
    <div class="container footer-inner">
      <div class="footer-brand">Gravisa</div>
      <nav class="footer-nav">
        <a href="makineler">Makineler</a>
        <a href="satis-teklifi">Satış Teklifi</a>
        <a href="kiralama">Kiralama</a>
        <a href="servis">Servis</a>
        <a href="kurumsal">Kurumsal</a>
        <a href="iletisim">İletişim</a>
      </nav>
      <div class="footer-subnav">
        <a href="hakkimizda">Hakkımızda</a><span>|</span>
        <a href="vizyon-misyon">Vizyon & Misyon</a><span>|</span>
        <a href="referanslar">Referanslar</a><span>|</span>
        <a href="saha-fotograflari">Saha Fotoğrafları</a>
      </div>
      <p class="footer-copy">&copy; Gravisa. Tüm hakları saklıdır.</p>
    </div>
  </footer>

  <script src="/assets/js/site-settings.js?v=5"></script>
  <script src="/assets/js/app.js?v=2"></script>
  <script src="/assets/js/app-makineler.js?v=2"></script>
</body>
</html>
