<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'kiralama';
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
        <h1><?= htmlspecialchars(t('pages.kiralama.hero_title'), ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars(t('pages.kiralama.hero_sub'), ENT_QUOTES, 'UTF-8') ?></p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <form class="form-block" id="kiralama-form">
          <input type="text" name="website" value="" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;" tabindex="-1" autocomplete="off" aria-hidden="true" />
          <h2 style="margin-bottom:24px; font-size:1.35rem;"><?= htmlspecialchars(t('pages.kiralama.h_prefs'), ENT_QUOTES, 'UTF-8') ?></h2>
          <div class="form-row">
            <label>
              <span><?= htmlspecialchars(t('pages.kiralama.label_duration'), ENT_QUOTES, 'UTF-8') ?></span>
              <select name="sure" required>
                <option value=""><?= htmlspecialchars(t('pages.kiralama.opt_select'), ENT_QUOTES, 'UTF-8') ?></option>
                <option value="gunluk"><?= htmlspecialchars(t('pages.kiralama.opt_daily'), ENT_QUOTES, 'UTF-8') ?></option>
                <option value="haftalik"><?= htmlspecialchars(t('pages.kiralama.opt_weekly'), ENT_QUOTES, 'UTF-8') ?></option>
                <option value="aylik"><?= htmlspecialchars(t('pages.kiralama.opt_monthly'), ENT_QUOTES, 'UTF-8') ?></option>
                <option value="uzun-donem"><?= htmlspecialchars(t('pages.kiralama.opt_long'), ENT_QUOTES, 'UTF-8') ?></option>
              </select>
            </label>
            <label>
              <span><?= htmlspecialchars(t('pages.kiralama.label_operator'), ENT_QUOTES, 'UTF-8') ?></span>
              <select name="operator" required>
                <option value=""><?= htmlspecialchars(t('pages.kiralama.opt_select'), ENT_QUOTES, 'UTF-8') ?></option>
                <option value="operatörlü"><?= htmlspecialchars(t('pages.kiralama.opt_op_with'), ENT_QUOTES, 'UTF-8') ?></option>
                <option value="operatörsüz"><?= htmlspecialchars(t('pages.kiralama.opt_op_without'), ENT_QUOTES, 'UTF-8') ?></option>
              </select>
            </label>
          </div>
          <div id="makine-bilgileri" class="makine-preview" style="display: none; background: var(--color-surface-alt); padding: 20px; border-radius: var(--radius); margin-bottom: 24px; border: 2px solid var(--color-primary);">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
              <img id="makine-resim" class="makine-preview__thumb" src="" alt="" />
              <div>
                <h3 id="makine-adi" style="margin: 0 0 4px; font-size: 1.1rem; color: var(--color-text);"></h3>
                <p id="makine-detay" style="margin: 0; font-size: 0.9rem; color: var(--color-text-muted);"></p>
              </div>
            </div>
            <input type="hidden" name="makine_id" id="makine-id" />
            <input type="hidden" name="makine_model" id="makine-model" />
          </div>
          <label>
            <span><?= htmlspecialchars(t('pages.kiralama.label_machine_model'), ENT_QUOTES, 'UTF-8') ?></span>
            <select name="model" id="kiralama-model">
              <option value=""><?= htmlspecialchars(t('pages.kiralama.select_model_placeholder'), ENT_QUOTES, 'UTF-8') ?></option>
            </select>
          </label>

          <h2 style="margin: 32px 0 24px; font-size: 1.35rem;"><?= htmlspecialchars(t('pages.kiralama.h_location'), ENT_QUOTES, 'UTF-8') ?></h2>
          <label>
            <span><?= htmlspecialchars(t('pages.kiralama.label_site'), ENT_QUOTES, 'UTF-8') ?></span>
            <input type="text" name="lokasyon" required placeholder="<?= htmlspecialchars(t('pages.kiralama.ph_site'), ENT_QUOTES, 'UTF-8') ?>" />
          </label>
          <div class="form-row">
            <label>
              <span><?= htmlspecialchars(t('pages.kiralama.label_start'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="date" name="baslangic" />
            </label>
            <label>
              <span><?= htmlspecialchars(t('pages.kiralama.label_end'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="date" name="bitis" />
            </label>
          </div>
          <div class="form-row">
            <label>
              <span><?= htmlspecialchars(t('pages.kiralama.label_name'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="text" name="ad_soyad" required placeholder="<?= htmlspecialchars(t('pages.kiralama.ph_name'), ENT_QUOTES, 'UTF-8') ?>" />
            </label>
            <label>
              <span><?= htmlspecialchars(t('pages.kiralama.label_email'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="email" name="email" required placeholder="<?= htmlspecialchars(t('pages.kiralama.ph_email'), ENT_QUOTES, 'UTF-8') ?>" />
            </label>
          </div>
          <div class="form-row">
            <label>
              <span><?= htmlspecialchars(t('pages.kiralama.label_phone'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="tel" name="telefon" required placeholder="<?= htmlspecialchars(t('pages.kiralama.ph_phone'), ENT_QUOTES, 'UTF-8') ?>" />
            </label>
            <label>
              <span><?= htmlspecialchars(t('pages.kiralama.label_company'), ENT_QUOTES, 'UTF-8') ?></span>
              <input type="text" name="firma" placeholder="<?= htmlspecialchars(t('pages.kiralama.ph_company'), ENT_QUOTES, 'UTF-8') ?>" />
            </label>
          </div>
          <label>
            <span><?= htmlspecialchars(t('pages.kiralama.label_notes'), ENT_QUOTES, 'UTF-8') ?></span>
            <textarea name="not" rows="3" placeholder="<?= htmlspecialchars(t('pages.kiralama.ph_notes'), ENT_QUOTES, 'UTF-8') ?>"></textarea>
          </label>
          <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('pages.kiralama.btn_submit'), ENT_QUOTES, 'UTF-8') ?></button>
        </form>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/site-footer.php'; ?>

<script src="<?= BASE_PATH ?>/assets/js/form-api.js?v=3"></script>
<script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=9"></script>
<script src="<?= BASE_PATH ?>/assets/js/app.js?v=<?= @filemtime(__DIR__ . '/assets/js/app.js') ?: 4 ?>"></script>
<script src="<?= BASE_PATH ?>/assets/js/app-makineler.js?v=11"></script>
  <script>
    (function () {
      var FORM = <?= json_encode([
        'sending' => t('js.sending'),
        'btnSubmit' => t('pages.kiralama.btn_submit'),
        'toastFallback' => t('pages.kiralama.toast_fallback'),
      ], JSON_UNESCAPED_UNICODE) ?>;
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
      function findMakineByParam(makineler, modelId) {
        if (!modelId || !makineler || !makineler.length) return null;
        var q = String(modelId).trim();
        var n = parseInt(q, 10);
        return makineler.find(function (m) {
          if (String(m.id) === q) return true;
          if (!isNaN(n) && Number(m.id) === n) return true;
          if (isNaN(n) && q) {
            var ql = q.toLowerCase();
            var tm = (m.tipModel && String(m.tipModel).toLowerCase()) || '';
            var full = String((m.firma || '') + ' ' + (m.tipModel || '')).toLowerCase();
            return tm.indexOf(ql) >= 0 || full.indexOf(ql) >= 0;
          }
          return false;
        }) || null;
      }
      function resolveMakineImg(makine) {
        if (!makine) return '';
        if (typeof window.gravisaResolveMachineImage === 'function') {
          var u = window.gravisaResolveMachineImage(makine);
          if (u) return u;
        }
        return safeImg(makine.img || '', makine.img_mtime);
      }
      function showMakineInfo(makine) {
        if (!makine) return;
        var makineBilgileri = document.getElementById('makine-bilgileri');
        if (!makineBilgileri) return;
        makineBilgileri.style.display = 'block';
        var imgUrl = resolveMakineImg(makine);
        var imgEl = document.getElementById('makine-resim');
        if (imgEl) {
          imgEl.onerror = null;
          if (imgUrl) {
            imgEl.onerror = function () { this.style.display = 'none'; };
            imgEl.src = imgUrl;
            imgEl.alt = makine.tipModel || '';
            imgEl.style.display = '';
          } else {
            imgEl.removeAttribute('src');
            imgEl.alt = '';
            imgEl.style.display = 'none';
          }
        }
        document.getElementById('makine-adi').textContent = makine.firma + ' ' + makine.tipModel;
        var detayText = makine.tip;
        if (makine.modelYil) detayText += ' • ' + makine.modelYil;
        if (makine.guc) detayText += ' • ' + makine.guc + ' ' + makine.gucBirim;
        document.getElementById('makine-detay').textContent = detayText;
        document.getElementById('makine-id').value = makine.id;
        document.getElementById('makine-model').value = makine.firma + ' ' + makine.tipModel;
        var modelSelect = document.getElementById('kiralama-model');
        if (modelSelect) modelSelect.value = String(makine.id);
      }
      function populateSelect(makineler) {
        var modelSelect = document.getElementById('kiralama-model');
        if (!modelSelect || !makineler.length || modelSelect.options.length > 1) return;
        makineler.forEach(function (m) {
          var opt = document.createElement('option');
          opt.value = m.id;
          opt.textContent = m.firma + ' ' + m.tipModel + ' (' + m.tip + ')';
          modelSelect.appendChild(opt);
        });
      }
      function applyFromUrl(makineler) {
        var params = new URLSearchParams(window.location.search);
        var modelId = params.get('id') || params.get('model');
        if (modelId) {
          var makine = findMakineByParam(makineler, modelId);
          if (makine) showMakineInfo(makine);
        }
      }
      var kiralamaUiBound = false;
      function bindKiralamaUi() {
        if (kiralamaUiBound) return;
        kiralamaUiBound = true;
        var modelSelect = document.getElementById('kiralama-model');
        if (modelSelect) {
          modelSelect.addEventListener('change', function () {
            var makineler = window.makineler || [];
            var selectedId = this.value;
            if (selectedId && makineler.length) {
              var makine = makineler.find(function (m) { return String(m.id) === String(selectedId); });
              if (makine) showMakineInfo(makine);
              else document.getElementById('makine-bilgileri').style.display = 'none';
            } else {
              document.getElementById('makine-bilgileri').style.display = 'none';
            }
          });
        }
        document.getElementById('kiralama-form').addEventListener('submit', function (e) {
          e.preventDefault();
          var form = this;
          var btn = form.querySelector('button[type="submit"]');
          if (btn) { btn.disabled = true; btn.textContent = FORM.sending; }
          if (typeof window.submitFormToAPI === 'function') {
            window.submitFormToAPI(form, '<?= BASE_PATH ?>/api/kiralama.php')
              .then(function (msg) { if (typeof window.showToast === 'function') window.showToast(msg, true); else alert(msg); form.reset(); document.getElementById('makine-bilgileri').style.display = 'none'; })
              .catch(function (err) { if (typeof window.showToast === 'function') window.showToast(err, false); else alert(err); })
              .finally(function () { if (btn) { btn.disabled = false; btn.textContent = FORM.btnSubmit; } });
          } else {
            if (typeof window.showToast === 'function') window.showToast(FORM.toastFallback, true); else alert(FORM.toastFallback);
            form.reset();
            document.getElementById('makine-bilgileri').style.display = 'none';
            if (btn) { btn.disabled = false; btn.textContent = FORM.btnSubmit; }
          }
        });
      }
      function initKiralama() {
        var makineler = window.makineler || [];
        if (!makineler.length) {
          setTimeout(initKiralama, 100);
          return;
        }
        populateSelect(makineler);
        applyFromUrl(makineler);
        bindKiralamaUi();
      }
      window.addEventListener('gravisa-machines-loaded', function () {
        var makineler = window.makineler || [];
        populateSelect(makineler);
        applyFromUrl(makineler);
        bindKiralamaUi();
      });
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initKiralama);
      } else {
        initKiralama();
      }
    })();
  </script>
</body>
</html>
