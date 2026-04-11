<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'servis';
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
        <h1><?= htmlspecialchars(t('pages.servis.hero_title'), ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars(t('pages.servis.hero_sub'), ENT_QUOTES, 'UTF-8') ?></p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="features-grid" style="margin-bottom: 48px;">
          <div class="feature-card">
            <div class="feature-icon-wrap">🔧</div>
            <h3><?= htmlspecialchars(t('pages.servis.feat_net_h'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.servis.feat_net_p'), ENT_QUOTES, 'UTF-8') ?></p>
            <ul>
              <li><?= htmlspecialchars(t('pages.servis.feat_net_li1'), ENT_QUOTES, 'UTF-8') ?></li>
              <li><?= htmlspecialchars(t('pages.servis.feat_net_li2'), ENT_QUOTES, 'UTF-8') ?></li>
              <li><?= htmlspecialchars(t('pages.servis.feat_net_li3'), ENT_QUOTES, 'UTF-8') ?></li>
            </ul>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">🚛</div>
            <h3><?= htmlspecialchars(t('pages.servis.feat_mob_h'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.servis.feat_mob_p'), ENT_QUOTES, 'UTF-8') ?></p>
            <ul>
              <li><?= htmlspecialchars(t('pages.servis.feat_mob_li1'), ENT_QUOTES, 'UTF-8') ?></li>
              <li><?= htmlspecialchars(t('pages.servis.feat_mob_li2'), ENT_QUOTES, 'UTF-8') ?></li>
              <li><?= htmlspecialchars(t('pages.servis.feat_mob_li3'), ENT_QUOTES, 'UTF-8') ?></li>
            </ul>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">⚙️</div>
            <h3><?= htmlspecialchars(t('pages.servis.feat_parts_h'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.servis.feat_parts_p'), ENT_QUOTES, 'UTF-8') ?></p>
            <ul>
              <li><?= htmlspecialchars(t('pages.servis.feat_parts_li1'), ENT_QUOTES, 'UTF-8') ?></li>
              <li><?= htmlspecialchars(t('pages.servis.feat_parts_li2'), ENT_QUOTES, 'UTF-8') ?></li>
              <li><?= htmlspecialchars(t('pages.servis.feat_parts_li3'), ENT_QUOTES, 'UTF-8') ?></li>
            </ul>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">🛡️</div>
            <h3><?= htmlspecialchars(t('pages.servis.feat_warr_h'), ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars(t('pages.servis.feat_warr_p'), ENT_QUOTES, 'UTF-8') ?></p>
            <ul>
              <li><?= htmlspecialchars(t('pages.servis.feat_warr_li1'), ENT_QUOTES, 'UTF-8') ?></li>
              <li><?= htmlspecialchars(t('pages.servis.feat_warr_li2'), ENT_QUOTES, 'UTF-8') ?></li>
              <li><?= htmlspecialchars(t('pages.servis.feat_warr_li3'), ENT_QUOTES, 'UTF-8') ?></li>
            </ul>
          </div>
        </div>

        <div class="two-col-grid" style="margin-bottom: 48px;">
          <div class="service-detail-card">
            <h2><?= htmlspecialchars(t('pages.servis.block_request_h'), ENT_QUOTES, 'UTF-8') ?></h2>
            <p><?= htmlspecialchars(t('pages.servis.block_request_p'), ENT_QUOTES, 'UTF-8') ?></p>
            <a href="tel:+<?= getWaNum() ?>" class="contact-quick-link">
              <span class="contact-quick-icon">📞</span>
              <div>
                <strong><?= htmlspecialchars(t('pages.servis.label_service_line'), ENT_QUOTES, 'UTF-8') ?></strong>
                <span><?= htmlspecialchars($siteSettings['phone_display'] ?? '') ?></span>
              </div>
            </a>
            <a href="mailto:<?= htmlspecialchars($siteSettings['servis_email'] ?? $siteSettings['contact_email'] ?? '') ?>" class="contact-quick-link">
              <span class="contact-quick-icon">✉️</span>
              <div>
                <strong><?= htmlspecialchars(t('pages.servis.label_email_short'), ENT_QUOTES, 'UTF-8') ?></strong>
                <span><?= htmlspecialchars($siteSettings['servis_email'] ?? $siteSettings['contact_email'] ?? '') ?></span>
              </div>
            </a>
            <a href="<?= htmlspecialchars(getWaUrl(), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-whatsapp" target="_blank" rel="noopener"><?= htmlspecialchars(t('pages.servis.btn_whatsapp_service'), ENT_QUOTES, 'UTF-8') ?></a>

            <form id="servis-form" class="form-block" style="margin-top: 32px;">
              <input type="text" name="website" value="" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;" tabindex="-1" autocomplete="off" aria-hidden="true" />
              <h3 style="margin-bottom: 16px; font-size: 1.2rem;"><?= htmlspecialchars(t('pages.servis.form_online_h'), ENT_QUOTES, 'UTF-8') ?></h3>
              <div class="form-row">
                <label>
                  <span><?= htmlspecialchars(t('pages.servis.label_name'), ENT_QUOTES, 'UTF-8') ?></span>
                  <input type="text" name="ad_soyad" required placeholder="<?= htmlspecialchars(t('pages.servis.ph_name'), ENT_QUOTES, 'UTF-8') ?>" />
                </label>
                <label>
                  <span><?= htmlspecialchars(t('pages.servis.label_phone'), ENT_QUOTES, 'UTF-8') ?></span>
                  <input type="tel" name="telefon" required placeholder="<?= htmlspecialchars(t('pages.servis.ph_phone'), ENT_QUOTES, 'UTF-8') ?>" />
                </label>
              </div>
              <div class="form-row">
                <label>
                  <span><?= htmlspecialchars(t('pages.servis.label_email'), ENT_QUOTES, 'UTF-8') ?></span>
                  <input type="email" name="email" required placeholder="<?= htmlspecialchars(t('pages.servis.ph_email'), ENT_QUOTES, 'UTF-8') ?>" />
                </label>
                <label>
                  <span><?= htmlspecialchars(t('pages.servis.label_servis_turu'), ENT_QUOTES, 'UTF-8') ?></span>
                  <select name="servis_turu" required>
                    <option value=""><?= htmlspecialchars(t('pages.servis.opt_select'), ENT_QUOTES, 'UTF-8') ?></option>
                    <option value="periyodik"><?= htmlspecialchars(t('pages.servis.opt_periyodik'), ENT_QUOTES, 'UTF-8') ?></option>
                    <option value="ariza"><?= htmlspecialchars(t('pages.servis.opt_ariza'), ENT_QUOTES, 'UTF-8') ?></option>
                    <option value="yedek"><?= htmlspecialchars(t('pages.servis.opt_yedek'), ENT_QUOTES, 'UTF-8') ?></option>
                    <option value="diger"><?= htmlspecialchars(t('pages.servis.opt_diger'), ENT_QUOTES, 'UTF-8') ?></option>
                  </select>
                </label>
              </div>
              <div class="form-row">
                <label>
                  <span><?= htmlspecialchars(t('pages.servis.label_makine_model'), ENT_QUOTES, 'UTF-8') ?></span>
                  <input type="text" name="makine_model" placeholder="<?= htmlspecialchars(t('pages.servis.ph_makine_model'), ENT_QUOTES, 'UTF-8') ?>" />
                </label>
                <label>
                  <span><?= htmlspecialchars(t('pages.servis.label_seri'), ENT_QUOTES, 'UTF-8') ?></span>
                  <input type="text" name="seri_no" placeholder="<?= htmlspecialchars(t('pages.servis.ph_seri'), ENT_QUOTES, 'UTF-8') ?>" />
                </label>
              </div>
              <label>
                <span><?= htmlspecialchars(t('pages.servis.label_lokasyon'), ENT_QUOTES, 'UTF-8') ?></span>
                <input type="text" name="lokasyon" required placeholder="<?= htmlspecialchars(t('pages.servis.ph_lokasyon'), ENT_QUOTES, 'UTF-8') ?>" />
              </label>
              <label>
                <span><?= htmlspecialchars(t('pages.servis.label_aciklama'), ENT_QUOTES, 'UTF-8') ?></span>
                <textarea name="not" rows="3" required placeholder="<?= htmlspecialchars(t('pages.servis.ph_aciklama'), ENT_QUOTES, 'UTF-8') ?>"></textarea>
              </label>
              <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('pages.servis.btn_submit'), ENT_QUOTES, 'UTF-8') ?></button>
            </form>
          </div>
          <div class="service-process-card">
            <h2><?= htmlspecialchars(t('pages.servis.process_h'), ENT_QUOTES, 'UTF-8') ?></h2>
            <div class="process-steps">
              <div class="process-step">
                <span class="process-step-num">1</span>
                <div>
                  <strong><?= htmlspecialchars(t('pages.servis.step1_t'), ENT_QUOTES, 'UTF-8') ?></strong>
                  <span><?= htmlspecialchars(t('pages.servis.step1_d'), ENT_QUOTES, 'UTF-8') ?></span>
                </div>
              </div>
              <div class="process-step">
                <span class="process-step-num">2</span>
                <div>
                  <strong><?= htmlspecialchars(t('pages.servis.step2_t'), ENT_QUOTES, 'UTF-8') ?></strong>
                  <span><?= htmlspecialchars(t('pages.servis.step2_d'), ENT_QUOTES, 'UTF-8') ?></span>
                </div>
              </div>
              <div class="process-step">
                <span class="process-step-num">3</span>
                <div>
                  <strong><?= htmlspecialchars(t('pages.servis.step3_t'), ENT_QUOTES, 'UTF-8') ?></strong>
                  <span><?= htmlspecialchars(t('pages.servis.step3_d'), ENT_QUOTES, 'UTF-8') ?></span>
                </div>
              </div>
              <div class="process-step">
                <span class="process-step-num">4</span>
                <div>
                  <strong><?= htmlspecialchars(t('pages.servis.step4_t'), ENT_QUOTES, 'UTF-8') ?></strong>
                  <span><?= htmlspecialchars(t('pages.servis.step4_d'), ENT_QUOTES, 'UTF-8') ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/site-footer.php'; ?>

  <script src="<?= BASE_PATH ?>/assets/js/form-api.js?v=3"></script>
  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=9"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=<?= @filemtime(__DIR__ . '/assets/js/app.js') ?: 4 ?>"></script>
  <script>
    (function () {
      var J = window.__GRAVISA_JS || {};
      var FORM = <?= json_encode([
        'sending' => t('js.sending'),
        'toastFallback' => t('pages.servis.toast_fallback'),
        'btnSubmit' => t('pages.servis.btn_submit'),
      ], JSON_UNESCAPED_UNICODE) ?>;
      var form = document.getElementById('servis-form');
      if (!form) return;
      var submitLabel = form.querySelector('button[type="submit"]');
      var defaultSubmit = submitLabel ? submitLabel.textContent : FORM.btnSubmit;
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        if (btn) { btn.disabled = true; btn.textContent = J.sending || FORM.sending; }
        if (typeof window.submitFormToAPI === 'function') {
          window.submitFormToAPI(form, '<?= BASE_PATH ?>/api/servis.php')
            .then(function (msg) { if (typeof window.showToast === 'function') window.showToast(msg, true); else alert(msg); form.reset(); })
            .catch(function (err) { if (typeof window.showToast === 'function') window.showToast(err, false); else alert(err); })
            .finally(function () { if (btn) { btn.disabled = false; btn.textContent = defaultSubmit; } });
        } else {
          if (typeof window.showToast === 'function') window.showToast(FORM.toastFallback, true); else alert(FORM.toastFallback);
          form.reset();
          if (btn) { btn.disabled = false; btn.textContent = defaultSubmit; }
        }
      });
    })();
  </script>
</body>
</html>
