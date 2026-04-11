<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'makine-detay';
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
    <section class="page-hero" style="padding: 40px 0;">
      <div class="container">
        <a href="<?= htmlspecialchars(gravisa_url('makineler'), ENT_QUOTES, 'UTF-8') ?>" style="display: inline-flex; align-items: center; gap: 8px; color: var(--color-text-muted); margin-bottom: 16px; text-decoration: none; transition: color var(--transition);">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
          <?= htmlspecialchars(t('js.back_catalog'), ENT_QUOTES, 'UTF-8') ?>
        </a>
      </div>
    </section>

    <section class="section" style="padding-top: 0;">
      <div class="container">
        <div id="makine-detay-container" class="machine-detail-page"></div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/site-footer.php'; ?>

  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=9"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=<?= @filemtime(__DIR__ . '/assets/js/app.js') ?: 4 ?>"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app-makineler.js?v=14"></script>
  <script>
    (function () {
      var J = window.__GRAVISA_JS || {};
      function langPath(slug) {
        return typeof window.gravisaLangPath === 'function' ? window.gravisaLangPath(slug) : slug;
      }
      var params = new URLSearchParams(window.location.search);
      var makineId = parseInt(params.get('id'), 10);
      var container = document.getElementById('makine-detay-container');

      function showError() {
        var back = langPath('makineler');
        container.innerHTML = '<div class="no-results"><p>' + (J.errorMachineNotFound || 'Makine bulunamadı.') + ' <a href="' + back + '">' + (J.catalogLink || 'Kataloga dön') + '</a></p></div>';
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
      function safeImg(src, imgMtime) {
        if (typeof window.gravisaAssetUrl === 'function') {
          return window.gravisaAssetUrl(src, imgMtime);
        }
        if (!src || typeof src !== 'string') return '';
        var s = src.trim();
        if (!s) return '';
        var t = s.toLowerCase();
        if (t.indexOf('javascript:') === 0 || t.indexOf('data:') === 0 || t.indexOf('vbscript:') === 0) return '';
        if (/^https?:\/\//i.test(s)) return s;
        var b = base.replace(/\/$/, '');
        return s.charAt(0) === '/' ? s : (b ? (b + '/' + s) : ('/' + s));
      }

      var ns = J.notSpecified || 'Belirtilmemiş';

      function machineTitleUi(m) {
        if (!m) return '';
        if (typeof window.gravisaMachineDisplayTitle === 'function') {
          return window.gravisaMachineDisplayTitle(m);
        }
        var f = String(m.firma || '').trim();
        var t = String(m.tipModel || '').trim();
        if (!f) return t;
        if (!t || t.toLowerCase() === f.toLowerCase()) return f;
        if (t.toLowerCase().indexOf(f.toLowerCase() + ' ') === 0) return t;
        return f + ' ' + t;
      }

      function renderMakine(makine) {
        if (!makine) {
          showError();
          return;
        }
        var titleLine = machineTitleUi(makine);
        document.title = titleLine + ' | Gravisa';

        var imgSrc = (typeof window.gravisaResolveMachineImage === 'function')
          ? window.gravisaResolveMachineImage(makine)
          : safeImg(makine.img, makine.img_mtime);
        var stockBadge = makine.stok ? (J.stockBadgeIn || '✓ Stokta') : (J.stockOrder || 'Talebe göre');
        var html = '<div class="machine-detail-modern">';
        html += '<div class="machine-detail-image-modern' + (imgSrc ? '' : ' machine-detail-image-modern--empty') + '">';
        if (imgSrc) {
          html += '<img src="' + esc(imgSrc) + '" alt="' + esc(titleLine) + '" />';
        } else {
          html += '<span role="img" aria-label="' + esc(J.noPhoto || '') + '">' + esc(J.noPhoto || '') + '</span>';
        }
        html += '<div class="machine-detail-badge-modern">' + esc(makine.tip) + '</div>';
        html += '</div>';

        html += '<div class="machine-detail-content-modern">';
        html += '<div class="machine-detail-header">';
        html += '<h1>' + esc(titleLine) + '</h1>';
        html += '<div class="machine-detail-meta">';
        html += '<span class="meta-item"><strong>' + esc(J.metaModelYear || 'Model Yılı:') + '</strong> ' + esc(makine.modelYil || ns) + '</span>';
        html += '<span class="meta-item"><strong>' + esc(J.metaPower || 'Güç:') + '</strong> ' + esc(makine.guc ? makine.guc + ' ' + makine.gucBirim : ns) + '</span>';
        html += '<span class="meta-item stok-badge ' + (makine.stok ? 'stok-var' : 'stok-yok') + '">' + esc(stockBadge) + '</span>';
        html += '</div>';
        html += '</div>';

        html += '<div class="machine-detail-specs-modern">';
        html += '<h2>' + esc(J.specsTitle || 'Teknik Özellikler') + '</h2>';
        html += '<div class="specs-grid">';

        var specs = [
          { label: J.labelType || 'Tip', value: makine.tip },
          { label: J.labelBrand || 'Firma', value: makine.firma },
          { label: J.labelTypeModel || 'Tip / Model', value: makine.tipModel },
          { label: J.labelModelYear || 'Model Yılı', value: makine.modelYil || ns },
          { label: J.labelPower || 'Güç', value: makine.guc ? makine.guc + ' ' + makine.gucBirim : ns },
          { label: J.labelCapacity || 'Kapasite', value: makine.kapasite || ns },
          { label: J.labelChassisSn || 'Şasi Seri No', value: makine.saseSeriNo || ns },
          { label: J.labelMotorSn || 'Motor Seri No', value: makine.motorSeriNo || ns },
          { label: J.labelMotorBrand || 'Motor Marka', value: makine.motorMarka || ns },
          { label: J.labelMotorType || 'Motor Tip', value: makine.motorTip || ns },
          { label: J.labelStock || 'Stok Durumu', value: makine.stok ? (J.stockIn || 'Stokta') : (J.stockOrder || 'Talebe göre') }
        ];

        specs.forEach(function (spec) {
          if (spec.value && spec.value !== ns) {
            html += '<div class="spec-item">';
            html += '<span class="spec-label">' + esc(spec.label) + '</span>';
            html += '<span class="spec-value">' + esc(spec.value) + '</span>';
            html += '</div>';
          }
        });

        html += '</div>';
        html += '</div>';

        html += '<div class="machine-detail-actions-modern">';
        html += '<a href="' + esc(langPath('satis-teklifi')) + '?id=' + esc(makine.id) + '" class="btn btn-primary btn-large">' + esc(J.btnSalesLarge || 'Satış Teklifi Al') + '</a>';
        html += '<a href="' + esc(langPath('kiralama')) + '?id=' + esc(makine.id) + '" class="btn btn-secondary btn-large">' + esc(J.btnRentLarge || 'Kiralama Yap') + '</a>';
        html += '<a href="' + esc(langPath('iletisim')) + '" class="btn btn-outline btn-large">' + esc(J.btnContactLarge || 'İletişime Geç') + '</a>';
        html += '</div>';

        html += '</div>';
        html += '</div>';

        container.innerHTML = html;
      }

      fetch((typeof window.gravisaEffectiveBasePath === 'function' ? window.gravisaEffectiveBasePath() : base) + '/api/makineler.php')
        .then(function(r) { return r.json(); })
        .then(function(res) {
          var items = (res && res.success && res.items) ? res.items : [];
          window.makineler = items;
          if (typeof window.gravisaRebuildMachinePhotos === 'function') {
            window.gravisaRebuildMachinePhotos();
          }
          var makine = items.find(function(m) { return m.id === makineId; });
          renderMakine(makine);
        })
        .catch(function() { showError(); });
    })();
  </script>
</body>
</html>
