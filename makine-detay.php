<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'makine-detay';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/styles.css?v=8" />
</head>
<body>
  <a href="https://wa.me/<?= getWaNum() ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <header class="header">
    <div class="container header-inner">
      <a href="index" class="logo"><img src="<?= BASE_PATH ?>/images/IMG_9059.JPG-removebg-preview.png" alt="Gravisa" /></a>
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
    <section class="page-hero" style="padding: 40px 0;">
      <div class="container">
        <a href="makineler" style="display: inline-flex; align-items: center; gap: 8px; color: var(--color-text-muted); margin-bottom: 16px; text-decoration: none; transition: color var(--transition);">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
          Kataloga Dön
        </a>
      </div>
    </section>

    <section class="section" style="padding-top: 0;">
      <div class="container">
        <div id="makine-detay-container" class="machine-detail-page">
          <!-- JavaScript ile doldurulacak -->
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

  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=5"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=3"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app-makineler.js?v=3"></script>
  <script>
    (function () {
      var params = new URLSearchParams(window.location.search);
      var makineId = parseInt(params.get('id'), 10);
      var container = document.getElementById('makine-detay-container');
      
      function showError() {
        container.innerHTML = '<div class="no-results"><p>Makine bulunamadı. <a href="makineler">Kataloga dön</a></p></div>';
      }
      
      if (!makineId) {
        showError();
        return;
      }
      
      function esc(s) {
        if (s == null || s === undefined) return '';
        var d = document.createElement('div');
        d.textContent = String(s);
        return d.innerHTML;
      }
      var base = (typeof window.basePath === 'string') ? window.basePath : '';
      function safeImg(src) {
        if (!src || typeof src !== 'string') return '';
        var t = src.trim().toLowerCase();
        if (t.indexOf('javascript:') === 0 || t.indexOf('data:') === 0 || t.indexOf('vbscript:') === 0) return '';
        var p = (src.charAt(0) === '/' ? '' : '/') + src;
        return base + p;
      }
      function renderMakine(makine) {
        if (!makine) {
          showError();
          return;
        }
        document.title = (makine.firma || '') + ' ' + (makine.tipModel || '') + ' | Gravisa';
      
      var imgSrc = safeImg(makine.img);
      var html = '<div class="machine-detail-modern">';
      html += '<div class="machine-detail-image-modern">';
      html += '<img src="' + esc(imgSrc) + '" alt="' + esc(makine.tipModel) + '" />';
      html += '<div class="machine-detail-badge-modern">' + esc(makine.tip) + '</div>';
      html += '</div>';
      
      html += '<div class="machine-detail-content-modern">';
      html += '<div class="machine-detail-header">';
      html += '<h1>' + esc(makine.firma) + ' ' + esc(makine.tipModel) + '</h1>';
      html += '<div class="machine-detail-meta">';
      html += '<span class="meta-item"><strong>Model Yılı:</strong> ' + esc(makine.modelYil || 'Belirtilmemiş') + '</span>';
      html += '<span class="meta-item"><strong>Güç:</strong> ' + esc(makine.guc ? makine.guc + ' ' + makine.gucBirim : 'Belirtilmemiş') + '</span>';
      html += '<span class="meta-item stok-badge ' + (makine.stok ? 'stok-var' : 'stok-yok') + '">' + (makine.stok ? '✓ Stokta' : 'Talebe Göre') + '</span>';
      html += '</div>';
      html += '</div>';
      
      html += '<div class="machine-detail-specs-modern">';
      html += '<h2>Teknik Özellikler</h2>';
      html += '<div class="specs-grid">';
      
      var specs = [
        { label: 'Tip', value: makine.tip },
        { label: 'Firma', value: makine.firma },
        { label: 'Tip / Model', value: makine.tipModel },
        { label: 'Model Yılı', value: makine.modelYil || 'Belirtilmemiş' },
        { label: 'Güç', value: makine.guc ? makine.guc + ' ' + makine.gucBirim : 'Belirtilmemiş' },
        { label: 'Kapasite', value: makine.kapasite || 'Belirtilmemiş' },
        { label: 'Şasi Seri No', value: makine.saseSeriNo || 'Belirtilmemiş' },
        { label: 'Motor Seri No', value: makine.motorSeriNo || 'Belirtilmemiş' },
        { label: 'Motor Marka', value: makine.motorMarka || 'Belirtilmemiş' },
        { label: 'Motor Tip', value: makine.motorTip || 'Belirtilmemiş' }
      ];
      
      specs.forEach(function(spec) {
        if (spec.value && spec.value !== 'Belirtilmemiş') {
          html += '<div class="spec-item">';
          html += '<span class="spec-label">' + esc(spec.label) + '</span>';
          html += '<span class="spec-value">' + esc(spec.value) + '</span>';
          html += '</div>';
        }
      });
      
      html += '</div>';
      html += '</div>';
      
      html += '<div class="machine-detail-actions-modern">';
      html += '<a href="satis-teklifi?id=' + esc(makine.id) + '" class="btn btn-primary btn-large">Satış Teklifi Al</a>';
      html += '<a href="kiralama?id=' + esc(makine.id) + '" class="btn btn-secondary btn-large">Kiralama Yap</a>';
      html += '<a href="iletisim" class="btn btn-outline btn-large">İletişime Geç</a>';
      html += '</div>';
      
      html += '</div>';
      html += '</div>';
      
      container.innerHTML = html;
      }
      
      fetch(base + '/api/makineler.php')
        .then(function(r) { return r.json(); })
        .then(function(res) {
          var items = (res && res.success && res.items) ? res.items : [];
          var makine = items.find(function(m) { return m.id === makineId; });
          renderMakine(makine);
        })
        .catch(function() { showError(); });
    })();
  </script>
</body>
</html>
