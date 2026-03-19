<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'servis';
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
        <h1>Servis & Yedek Parça</h1>
        <p>Geniş servis ağımız, mobil servis imkânı ve orijinal yedek parça temini ile yanınızdayız.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="features-grid" style="margin-bottom: 48px;">
          <div class="feature-card">
            <div class="feature-icon-wrap">🔧</div>
            <h3>Servis Ağı</h3>
            <p>Türkiye genelinde yetkili servis noktalarımız ile bakım ve onarım hizmeti sunuyoruz. Periyodik bakım ve arıza müdahaleleri için 7/24 destek.</p>
            <ul>
              <li>Periyodik bakım hizmetleri</li>
              <li>Arıza tespit ve onarım</li>
              <li>Teknik destek ve danışmanlık</li>
            </ul>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">🚛</div>
            <h3>Mobil Servis</h3>
            <p>Sahada veya şantiyenizde mobil servis ekibimizle hızlı müdahale. Randevu alarak makinenizin bulunduğu lokasyonda servis.</p>
            <ul>
              <li>Sahada servis hizmeti</li>
              <li>Hızlı müdahale garantisi</li>
              <li>Uzman teknik ekip</li>
            </ul>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">⚙️</div>
            <h3>Yedek Parça</h3>
            <p>Orijinal ve uyumlu yedek parça temini. Stok takibi ve hızlı tedarik. Sipariş için bizi arayın veya WhatsApp üzerinden yazın.</p>
            <ul>
              <li>Orijinal yedek parça</li>
              <li>Hızlı tedarik garantisi</li>
              <li>Stok takibi</li>
            </ul>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">🛡️</div>
            <h3>Garanti</h3>
            <p>Satın aldığınız makinelerde ürün garantisi; yaptığımız işlerde işçilik garantisi. Garanti koşulları satış sözleşmesinde belirtilir.</p>
            <ul>
              <li>Ürün garantisi</li>
              <li>İşçilik garantisi</li>
              <li>Şeffaf garanti koşulları</li>
            </ul>
          </div>
        </div>

        <div class="two-col-grid" style="margin-bottom: 48px;">
          <div class="service-detail-card">
            <h2>Servis Talebi</h2>
            <p>Arıza veya bakım talebinizi aşağıdaki formdan iletebilirsiniz. 7/24 teknik destek hattımızdan da bize ulaşabilirsiniz.</p>
            <a href="tel:+<?= getWaNum() ?>" class="contact-quick-link">
              <span class="contact-quick-icon">📞</span>
              <div>
                <strong>Servis Hattı</strong>
                <span><?= htmlspecialchars($siteSettings['phone_display'] ?? '') ?></span>
              </div>
            </a>
            <a href="mailto:<?= htmlspecialchars($siteSettings['servis_email'] ?? $siteSettings['contact_email'] ?? '') ?>" class="contact-quick-link">
              <span class="contact-quick-icon">✉️</span>
              <div>
                <strong>E-posta</strong>
                <span><?= htmlspecialchars($siteSettings['servis_email'] ?? $siteSettings['contact_email'] ?? '') ?></span>
              </div>
            </a>
            <a href="https://wa.me/<?= getWaNum() ?>" class="btn btn-whatsapp" target="_blank" rel="noopener">WhatsApp ile Servis Talebi</a>

            <form id="servis-form" class="form-block" style="margin-top: 32px;">
              <input type="text" name="website" value="" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;" tabindex="-1" autocomplete="off" aria-hidden="true" />
              <h3 style="margin-bottom: 16px; font-size: 1.2rem;">Online Servis Talep Formu</h3>
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
              <div class="form-row">
                <label>
                  <span>E-posta</span>
                  <input type="email" name="email" required placeholder="ornek@firma.com" />
                </label>
                <label>
                  <span>Servis Türü</span>
                  <select name="servis_turu" required>
                    <option value="">Seçiniz</option>
                    <option value="periyodik">Periyodik Bakım</option>
                    <option value="ariza">Arıza / Onarım</option>
                    <option value="yedek">Yedek Parça</option>
                    <option value="diger">Diğer</option>
                  </select>
                </label>
              </div>
              <div class="form-row">
                <label>
                  <span>Makine Modeli</span>
                  <input type="text" name="makine_model" placeholder="Örn: Caterpillar 950 GC" />
                </label>
                <label>
                  <span>Seri No / Plaka</span>
                  <input type="text" name="seri_no" placeholder="Opsiyonel" />
                </label>
              </div>
              <label>
                <span>Lokasyon / Şantiye Adresi</span>
                <input type="text" name="lokasyon" required placeholder="İl, ilçe, şantiye veya çalışma adresi" />
              </label>
              <label>
                <span>Arıza / Talep Açıklaması</span>
                <textarea name="not" rows="3" required placeholder="Kısaca problemi ve talebinizi açıklayın..."></textarea>
              </label>
              <button type="submit" class="btn btn-primary">Servis Talebi Gönder</button>
            </form>
          </div>
          <div class="service-process-card">
            <h2>Servis Süreci</h2>
            <div class="process-steps">
              <div class="process-step">
                <span class="process-step-num">1</span>
                <div>
                  <strong>Talebinizi İletin</strong>
                  <span>Telefon, e-posta veya WhatsApp üzerinden bize ulaşın</span>
                </div>
              </div>
              <div class="process-step">
                <span class="process-step-num">2</span>
                <div>
                  <strong>Randevu Alın</strong>
                  <span>Uygun tarih ve saat için randevu oluşturun</span>
                </div>
              </div>
              <div class="process-step">
                <span class="process-step-num">3</span>
                <div>
                  <strong>Servis Yapılır</strong>
                  <span>Uzman ekibimiz tarafından servis gerçekleştirilir</span>
                </div>
              </div>
              <div class="process-step">
                <span class="process-step-num">4</span>
                <div>
                  <strong>Garanti</strong>
                  <span>Yapılan işler için garanti belgesi verilir</span>
                </div>
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
      var form = document.getElementById('servis-form');
      if (!form) return;
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        if (btn) { btn.disabled = true; btn.textContent = 'Gönderiliyor...'; }
        if (typeof window.submitFormToAPI === 'function') {
          window.submitFormToAPI(form, '<?= BASE_PATH ?>/api/servis.php')
            .then(function (msg) { if (typeof window.showToast === 'function') window.showToast(msg, true); else alert(msg); form.reset(); })
            .catch(function (err) { if (typeof window.showToast === 'function') window.showToast(err, false); else alert(err); })
            .finally(function () { if (btn) { btn.disabled = false; btn.textContent = 'Servis Talebi Gönder'; } });
        } else {
          if (typeof window.showToast === 'function') window.showToast('Servis talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.', true); else alert('Servis talebiniz alındı.');
          form.reset();
          if (btn) { btn.disabled = false; btn.textContent = 'Servis Talebi Gönder'; }
        }
      });
    })();
  </script>
</body>
</html>
