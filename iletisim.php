<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'iletisim';
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
        <h1><?= htmlspecialchars(t('pages.iletisim.hero_title'), ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars(t('pages.iletisim.hero_sub'), ENT_QUOTES, 'UTF-8') ?></p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="content-page">
          <div class="form-block" style="max-width: 720px; margin-bottom: 40px;">
            <form id="iletisim-form">
              <input type="text" name="website" value="" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;" tabindex="-1" autocomplete="off" aria-hidden="true" />
              <div class="form-row">
                <label>
                  <span><?= htmlspecialchars(t('pages.iletisim.label_name'), ENT_QUOTES, 'UTF-8') ?></span>
                  <input type="text" name="ad_soyad" required placeholder="<?= htmlspecialchars(t('pages.iletisim.ph_name'), ENT_QUOTES, 'UTF-8') ?>" />
                </label>
                <label>
                  <span><?= htmlspecialchars(t('pages.iletisim.label_phone'), ENT_QUOTES, 'UTF-8') ?></span>
                  <input type="tel" name="telefon" required placeholder="<?= htmlspecialchars(t('pages.iletisim.ph_phone'), ENT_QUOTES, 'UTF-8') ?>" />
                </label>
              </div>
              <label>
                <span><?= htmlspecialchars(t('pages.iletisim.label_email'), ENT_QUOTES, 'UTF-8') ?></span>
                <input type="email" name="email" required placeholder="<?= htmlspecialchars(t('pages.iletisim.ph_email'), ENT_QUOTES, 'UTF-8') ?>" />
              </label>
              <label>
                <span><?= htmlspecialchars(t('pages.iletisim.label_subject'), ENT_QUOTES, 'UTF-8') ?></span>
                <select name="konu" required>
                  <option value=""><?= htmlspecialchars(t('pages.iletisim.opt_select'), ENT_QUOTES, 'UTF-8') ?></option>
                  <option value="satis"><?= htmlspecialchars(t('pages.iletisim.opt_sales'), ENT_QUOTES, 'UTF-8') ?></option>
                  <option value="kiralama"><?= htmlspecialchars(t('pages.iletisim.opt_rent'), ENT_QUOTES, 'UTF-8') ?></option>
                  <option value="servis"><?= htmlspecialchars(t('pages.iletisim.opt_service'), ENT_QUOTES, 'UTF-8') ?></option>
                  <option value="diger"><?= htmlspecialchars(t('pages.iletisim.opt_other'), ENT_QUOTES, 'UTF-8') ?></option>
                </select>
              </label>
              <label>
                <span><?= htmlspecialchars(t('pages.iletisim.label_message'), ENT_QUOTES, 'UTF-8') ?></span>
                <textarea name="mesaj" rows="4" required placeholder="<?= htmlspecialchars(t('pages.iletisim.ph_message'), ENT_QUOTES, 'UTF-8') ?>"></textarea>
              </label>
              <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('js.form_submit'), ENT_QUOTES, 'UTF-8') ?></button>
            </form>
          </div>

          <div class="contact-info-grid">
            <div class="contact-info-card">
              <h3 class="contact-info-title"><?= htmlspecialchars(t('pages.iletisim.info_title'), ENT_QUOTES, 'UTF-8') ?></h3>
              <div class="contact-info-list">
                <div class="contact-info-item">
                  <div class="contact-info-icon">📍</div>
                  <div class="contact-info-text">
                    <strong><?= htmlspecialchars(t('pages.iletisim.addr_lbl'), ENT_QUOTES, 'UTF-8') ?></strong>
                    <span><?= nl2br(htmlspecialchars($siteSettings['address'] ?? '')) ?></span>
                  </div>
                </div>
                <div class="contact-info-item">
                  <div class="contact-info-icon">📞</div>
                  <div class="contact-info-text">
                    <strong><?= htmlspecialchars(t('pages.iletisim.phone_lbl'), ENT_QUOTES, 'UTF-8') ?></strong>
                    <a href="tel:+<?= getWaNum() ?>"><?= htmlspecialchars($siteSettings['phone_display'] ?? '') ?></a>
                  </div>
                </div>
                <div class="contact-info-item">
                  <div class="contact-info-icon">✉️</div>
                  <div class="contact-info-text">
                    <strong><?= htmlspecialchars(t('pages.iletisim.email_lbl'), ENT_QUOTES, 'UTF-8') ?></strong>
                    <a href="mailto:<?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?>"><?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?></a>
                  </div>
                </div>
                <div class="contact-info-item">
                  <div class="contact-info-icon">💬</div>
                  <div class="contact-info-text">
                    <strong><?= htmlspecialchars(t('pages.iletisim.wa_lbl'), ENT_QUOTES, 'UTF-8') ?></strong>
                    <a href="<?= htmlspecialchars(getWaUrl(), ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener"><?= htmlspecialchars(t('pages.iletisim.wa_short'), ENT_QUOTES, 'UTF-8') ?></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="contact-hours-card">
              <h3 class="contact-info-title"><?= htmlspecialchars(t('pages.iletisim.hours_title'), ENT_QUOTES, 'UTF-8') ?></h3>
              <div class="contact-hours-list">
                <div class="contact-hours-row">
                  <span class="contact-hours-day"><?= htmlspecialchars(t('pages.iletisim.dow_week'), ENT_QUOTES, 'UTF-8') ?></span>
                  <span class="contact-hours-time">09:00 - 18:00</span>
                </div>
                <div class="contact-hours-row">
                  <span class="contact-hours-day"><?= htmlspecialchars(t('pages.iletisim.dow_sat'), ENT_QUOTES, 'UTF-8') ?></span>
                  <span class="contact-hours-time">09:00 - 14:00</span>
                </div>
                <div class="contact-hours-row is-last">
                  <span class="contact-hours-day"><?= htmlspecialchars(t('pages.iletisim.dow_sun'), ENT_QUOTES, 'UTF-8') ?></span>
                  <span class="contact-hours-time"><?= htmlspecialchars(t('pages.iletisim.closed'), ENT_QUOTES, 'UTF-8') ?></span>
                </div>
              </div>
              <div class="contact-emergency">
                <strong><?= htmlspecialchars(t('pages.iletisim.emergency_title'), ENT_QUOTES, 'UTF-8') ?></strong>
                <p><?= htmlspecialchars(t('pages.iletisim.emergency_text'), ENT_QUOTES, 'UTF-8') ?></p>
                <a href="<?= htmlspecialchars(getWaUrl(), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-whatsapp" target="_blank" rel="noopener" style="width: 100%; margin-top: 16px;"><?= htmlspecialchars(t('pages.iletisim.wa_btn'), ENT_QUOTES, 'UTF-8') ?></a>
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
      var form = document.getElementById('iletisim-form');
      if (!form) return;
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        var submitLabel = J.formSubmit || 'Gönder';
        if (btn) { btn.disabled = true; btn.textContent = J.sending || 'Gönderiliyor...'; }
        if (typeof window.submitFormToAPI === 'function') {
          window.submitFormToAPI(form, '<?= BASE_PATH ?>/api/iletisim.php')
            .then(function (msg) { if (typeof window.showToast === 'function') window.showToast(msg, true); else alert(msg); form.reset(); })
            .catch(function (err) { if (typeof window.showToast === 'function') window.showToast(err, false); else alert(err); })
            .finally(function () { if (btn) { btn.disabled = false; btn.textContent = submitLabel; } });
        } else {
          if (typeof window.showToast === 'function') window.showToast('Mesajınız alındı. En kısa sürede sizinle iletişime geçeceğiz.', true); else alert('Mesajınız alındı.');
          form.reset();
          if (btn) { btn.disabled = false; btn.textContent = submitLabel; }
        }
      });
    })();
  </script>
</body>
</html>
