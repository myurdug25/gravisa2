<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'iletisim';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/styles.css?v=6" />
</head>
<body>
  <a href="https://wa.me/<?= getWaNum() ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <header class="header">
    <div class="container header-inner">
      <a href="index" class="logo"><img src="<?= BASE_PATH ?>/images/IMG_9059.JPG.jpeg" alt="Gravisa" /></a>
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
        <h1>İletişim</h1>
        <p>Satış, kiralama veya servis talepleriniz için formu doldurun; en kısa sürede sizinle iletişime geçelim.</p>
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
                  <span>Ad Soyad</span>
                  <input type="text" name="ad_soyad" required placeholder="Adınız Soyadınız" />
                </label>
                <label>
                  <span>Telefon</span>
                  <input type="tel" name="telefon" required placeholder="05XX XXX XX XX" />
                </label>
              </div>
              <label>
                <span>E-posta</span>
                <input type="email" name="email" required placeholder="ornek@firma.com" />
              </label>
              <label>
                <span>Konu</span>
                <select name="konu" required>
                  <option value="">Seçiniz</option>
                  <option value="satis">Satış Teklifi</option>
                  <option value="kiralama">Kiralama</option>
                  <option value="servis">Servis / Yedek Parça</option>
                  <option value="diger">Diğer</option>
                </select>
              </label>
              <label>
                <span>Mesajınız</span>
                <textarea name="mesaj" rows="4" required placeholder="Talebinizi kısaca açıklayın..."></textarea>
              </label>
              <button type="submit" class="btn btn-primary">Gönder</button>
            </form>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-top: 48px;">
            <div style="padding: 40px; background: var(--color-surface-alt); border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
              <h3 style="font-size: 1.5rem; margin: 0 0 24px; color: var(--color-text);">İletişim Bilgileri</h3>
              <div style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; align-items: start; gap: 16px;">
                  <div style="width: 48px; height: 48px; background: var(--color-primary-soft); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">📍</div>
                  <div>
                    <strong style="display: block; margin-bottom: 4px; color: var(--color-text);">Adres</strong>
                    <span style="color: var(--color-text-muted); line-height: 1.6;"><?= nl2br(htmlspecialchars($siteSettings['address'] ?? '')) ?></span>
                  </div>
                </div>
                <div style="display: flex; align-items: start; gap: 16px;">
                  <div style="width: 48px; height: 48px; background: var(--color-primary-soft); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">📞</div>
                  <div>
                    <strong style="display: block; margin-bottom: 4px; color: var(--color-text);">Telefon</strong>
                    <a href="tel:+<?= getWaNum() ?>" style="color: var(--color-primary); text-decoration: none; font-weight: 600;"><?= htmlspecialchars($siteSettings['phone_display'] ?? '') ?></a>
                  </div>
                </div>
                <div style="display: flex; align-items: start; gap: 16px;">
                  <div style="width: 48px; height: 48px; background: var(--color-primary-soft); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">✉️</div>
                  <div>
                    <strong style="display: block; margin-bottom: 4px; color: var(--color-text);">E-posta</strong>
                    <a href="mailto:<?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?>" style="color: var(--color-primary); text-decoration: none; font-weight: 600;"><?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?></a>
                  </div>
                </div>
                <div style="display: flex; align-items: start; gap: 16px;">
                  <div style="width: 48px; height: 48px; background: var(--color-primary-soft); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">💬</div>
                  <div>
                    <strong style="display: block; margin-bottom: 4px; color: var(--color-text);">WhatsApp</strong>
                    <a href="https://wa.me/<?= getWaNum() ?>" target="_blank" rel="noopener" style="color: var(--color-primary); text-decoration: none; font-weight: 600;">Hemen yaz</a>
                  </div>
                </div>
              </div>
            </div>
            <div style="padding: 40px; background: linear-gradient(135deg, var(--color-primary-soft) 0%, rgba(13, 148, 136, 0.05) 100%); border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
              <h3 style="font-size: 1.5rem; margin: 0 0 24px; color: var(--color-text);">Çalışma Saatleri</h3>
              <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid var(--color-border);">
                  <span style="color: var(--color-text); font-weight: 600;">Pazartesi - Cuma</span>
                  <span style="color: var(--color-text-muted);">09:00 - 18:00</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid var(--color-border);">
                  <span style="color: var(--color-text); font-weight: 600;">Cumartesi</span>
                  <span style="color: var(--color-text-muted);">09:00 - 14:00</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                  <span style="color: var(--color-text); font-weight: 600;">Pazar</span>
                  <span style="color: var(--color-text-muted);">Kapalı</span>
                </div>
              </div>
              <div style="margin-top: 32px; padding: 24px; background: var(--color-surface); border-radius: var(--radius);">
                <strong style="display: block; margin-bottom: 8px; color: var(--color-text);">Acil Durumlar</strong>
                <p style="margin: 0; color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6;">Acil servis talepleriniz için 7/24 WhatsApp hattımızdan bize ulaşabilirsiniz.</p>
                <a href="https://wa.me/<?= getWaNum() ?>" class="btn btn-whatsapp" target="_blank" rel="noopener" style="width: 100%; margin-top: 16px;">WhatsApp ile Yaz</a>
              </div>
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

  <script src="<?= BASE_PATH ?>/assets/js/form-api.js?v=3"></script>
  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=5"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=3"></script>
  <script>
    (function () {
      var form = document.getElementById('iletisim-form');
      if (!form) return;
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        if (btn) { btn.disabled = true; btn.textContent = 'Gönderiliyor...'; }
        if (typeof window.submitFormToAPI === 'function') {
          window.submitFormToAPI(form, '<?= BASE_PATH ?>/api/iletisim.php')
            .then(function (msg) { if (typeof window.showToast === 'function') window.showToast(msg, true); else alert(msg); form.reset(); })
            .catch(function (err) { if (typeof window.showToast === 'function') window.showToast(err, false); else alert(err); })
            .finally(function () { if (btn) { btn.disabled = false; btn.textContent = 'Gönder'; } });
        } else {
          if (typeof window.showToast === 'function') window.showToast('Mesajınız alındı. En kısa sürede sizinle iletişime geçeceğiz.', true); else alert('Mesajınız alındı.');
          form.reset();
          if (btn) { btn.disabled = false; btn.textContent = 'Gönder'; }
        }
      });
    })();
  </script>
</body>
</html>

