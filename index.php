<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'index';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <meta name="theme-color" content="#eef2f6" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/css/styles.css" />
</head>
<body>
  <!-- WhatsApp floating button -->
  <a href="https://wa.me/<?= getWaNum() ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp ile iletişim">
    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <header class="header">
    <div class="container header-inner">
      <a href="index" class="logo">Gravisa</a>
      <button class="nav-toggle" aria-label="Menüyü aç" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
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
    <!-- Hero -->
    <section class="hero">
      <div class="hero-content">
        <div class="banner-card">
          <div class="banner-card-body">
            <span class="hero-badge">Gravisa'ya hoş geldiniz</span>
            <h1 class="hero-title">İş Makinelerinde <span>Güvenilir Çözüm Ortağınız</span></h1>
            <p class="hero-subtitle">Satış ve kiralama için hemen teklif alın. Türkiye genelinde servis ve yedek parça desteği. Üyelik zorunlu değil; hızlıca randevu planlayın.</p>
            <div class="hero-buttons">
              <a href="satis-teklifi" class="btn btn-primary">Satış Teklifi Al</a>
              <a href="makineler" class="btn btn-outline">Makineleri İncele</a>
              <a href="kiralama" class="btn btn-outline">Kiralama Yap</a>
            </div>
            <div class="hero-stats">
              <div class="hero-stat-card">
                <span class="hero-stat-icon">🚜</span>
                <span class="hero-stat-value">319+</span>
                <span class="hero-stat-label">Makine Çeşidi</span>
              </div>
              <div class="hero-stat-card">
                <span class="hero-stat-icon">👥</span>
                <span class="hero-stat-value">500+</span>
                <span class="hero-stat-label">Mutlu Müşteri</span>
              </div>
              <div class="hero-stat-card">
                <span class="hero-stat-icon">⭐</span>
                <span class="hero-stat-value">15+</span>
                <span class="hero-stat-label">Yıllık Tecrübe</span>
              </div>
              <div class="hero-stat-card">
                <span class="hero-stat-icon">🔧</span>
                <span class="hero-stat-value">7/24</span>
                <span class="hero-stat-label">Teknik Destek</span>
              </div>
            </div>
          </div>
          <div class="banner-card-media" aria-hidden="true">
            <div class="hero-image-frame">
              <img src="images/WhatsApp Image 2026-02-17 at 15.37.57 (2).jpeg" alt="İş makinesi" onerror="this.style.display='none'" />
              <span class="hero-image-fallback">🚜</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section section-alt" id="stokta">
      <div class="container">
        <div class="section-header-flex">
          <div>
            <h2 class="section-title section-title-left">Stokta Makineler</h2>
            <p class="section-desc section-desc-left">Hemen teslim edilebilecek makinelerimizi inceleyin</p>
          </div>
          <a href="makineler" class="btn btn-primary">Tüm Makineleri Gör</a>
        </div>
        <div class="machine-grid" id="stokta-grid"></div>
      </div>
    </section>

    <section class="section" id="hizmetler">
      <div class="container">
        <h2 class="section-title">Hizmetlerimiz</h2>
        <p class="section-desc">Geniş hizmet yelpazemiz ile ihtiyaçlarınıza çözüm sunuyoruz</p>
        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-icon-wrap">🚚</div>
            <h3>Satış</h3>
            <p>Yeni ve ikinci el iş makineleri satışı. Geniş ürün yelpazesi ve esnek ödeme seçenekleri.</p>
            <a href="satis-teklifi" class="btn btn-outline">Teklif Al</a>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">⏱️</div>
            <h3>Kiralama</h3>
            <p>Günlük, haftalık, aylık ve uzun dönem kiralama. Operatörlü veya operatörsüz seçenekler.</p>
            <a href="kiralama" class="btn btn-outline">Kirala</a>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">🔧</div>
            <h3>Servis</h3>
            <p>Türkiye genelinde servis ağı, mobil servis ve orijinal yedek parça temini.</p>
            <a href="servis" class="btn btn-outline">Detaylar</a>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrap">📦</div>
            <h3>Yedek Parça</h3>
            <p>Orijinal ve uyumlu yedek parça stokları. Hızlı tedarik ve teslimat garantisi.</p>
            <a href="servis" class="btn btn-outline">İletişim</a>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="demo">
      <div class="container section-inner-card">
        <h2 class="section-title">Demo Makine Talebi</h2>
        <p class="section-desc">İstediğiniz makineyi sahada denemek için talebinizi iletin.</p>
        <form class="demo-form form-block" id="demo-form">
          <input type="text" name="website" value="" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;" tabindex="-1" autocomplete="off" aria-hidden="true" />
          <div class="form-row">
            <label>
              <span>Ad Soyad</span>
              <input type="text" name="name" required placeholder="Adınız Soyadınız" />
            </label>
            <label>
              <span>Telefon</span>
              <input type="tel" name="phone" required placeholder="05XX XXX XX XX" />
            </label>
          </div>
          <label>
            <span>E-posta</span>
            <input type="email" name="email" required placeholder="ornek@firma.com" />
          </label>
          <div class="form-row">
            <label>
              <span>İlgilendiğiniz Makine</span>
              <div class="custom-select-wrap" id="machine-select-wrap" aria-label="İlgilendiğiniz Makine">
                <button type="button" class="custom-select-trigger" id="machine-select-trigger" aria-haspopup="listbox" aria-expanded="false">Seçiniz</button>
                <input type="hidden" name="machine" id="machine-select-input" value="" required />
                <ul class="custom-select-list" role="listbox" id="machine-select-list">
                  <li role="option" class="custom-select-option is-selected" data-value="">Seçiniz</li>
                  <li role="option" class="custom-select-option" data-value="ekskavatör">Ekskavatör</li>
                  <li role="option" class="custom-select-option" data-value="loder">Loder</li>
                  <li role="option" class="custom-select-option" data-value="greyder">Greyder</li>
                  <li role="option" class="custom-select-option" data-value="diger">Diğer</li>
                </ul>
              </div>
            </label>
            <label>
              <span>Tercih Edilen Tarih</span>
              <input type="date" name="date" />
            </label>
          </div>
          <label>
            <span>Not</span>
            <textarea name="note" rows="3" placeholder="Ek bilgi veya adres..."></textarea>
          </label>
          <button type="submit" class="btn btn-primary">Demo Talebi Gönder</button>
        </form>
      </div>
    </section>

    <section class="section section-alt" id="servis-ozet">
      <div class="container">
        <div class="two-col-grid">
          <div>
            <h2 class="section-title section-title-left">Servis & Yedek Parça</h2>
            <p class="section-desc section-desc-left">Geniş servis ağımız ve mobil servis imkânı ile yanınızdayız. 7/24 teknik destek ve hızlı müdahale garantisi.</p>
            <div class="service-list">
              <div class="service-list-item">
                <div class="service-list-icon">🔧</div>
                <div>
                  <strong>Servis Ağı</strong>
                  <span>Türkiye genelinde yetkili servis noktalarımız</span>
                </div>
              </div>
              <div class="service-list-item">
                <div class="service-list-icon">🚛</div>
                <div>
                  <strong>Mobil Servis</strong>
                  <span>Sahada mobil servis hizmeti</span>
                </div>
              </div>
              <div class="service-list-item">
                <div class="service-list-icon">⚙️</div>
                <div>
                  <strong>Yedek Parça</strong>
                  <span>Orijinal yedek parça temini</span>
                </div>
              </div>
            </div>
            <a href="servis" class="btn btn-primary">Servis Detayları</a>
          </div>
          <div class="contact-quick-card">
            <h3>Hızlı İletişim</h3>
            <a href="tel:+<?= getWaNum() ?>" class="contact-quick-link">
              <span class="contact-quick-icon">📞</span>
              <div>
                <strong>Telefon</strong>
                <span><?= htmlspecialchars($siteSettings['phone_display'] ?? '') ?></span>
              </div>
            </a>
            <a href="mailto:<?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?>" class="contact-quick-link">
              <span class="contact-quick-icon">✉️</span>
              <div>
                <strong>E-posta</strong>
                <span><?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?></span>
              </div>
            </a>
            <a href="https://wa.me/<?= getWaNum() ?>" target="_blank" rel="noopener" class="contact-quick-link contact-quick-primary">
              <span class="contact-quick-icon">💬</span>
              <div>
                <strong>WhatsApp</strong>
                <span>Hemen yazın</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="kurumsal-ozet">
      <div class="container">
        <h2 class="section-title">Neden Biz?</h2>
        <p class="section-desc">Gücümüzü Tecrübemizden, Hızımızı Teknolojimizden Alıyoruz</p>
        <p class="section-desc" style="max-width: 720px; margin: 0 auto 28px;">İş makineleri sektörü, sadece metal ve hidrolikten ibaret değildir; bu sektör bir zaman ve maliyet yönetimi sanatıdır. İşte bizi rakiplerimizden ayıran temel farklarımız:</p>
        <div class="trust-grid">
          <div class="trust-item"><strong>15+</strong><span>Yıllık Tecrübe</span></div>
          <div class="trust-item"><strong>500+</strong><span>Mutlu Müşteri</span></div>
          <div class="trust-item"><strong>7/24</strong><span>Teknik Destek</span></div>
          <div class="trust-item"><strong>319+</strong><span>Makine Çeşidi</span></div>
        </div>
        <div class="value-cards">
          <div class="value-card"><h4>Bütünleşik Çözüm</h4><p>Projenize en uygun makineyi belirlemek için teknik danışmanlık. Alım, satım ve kiralama tek çatı altında.</p></div>
          <div class="value-card"><h4>Kusursuz Makine Parkuru</h4><p>"Sıfır Arıza" vizyonuyla periyodik denetim. İşinizin durmasına değil, hızlanmasına odaklanıyoruz.</p></div>
          <div class="value-card"><h4>Hızlı Teknik Destek</h4><p>Mobil servis ekiplerimizle en kısa sürede müdahale. Projenizin aksamasının önüne geçiyoruz.</p></div>
          <div class="value-card"><h4>Şeffaf Ticaret</h4><p>Ekspertiz raporları ve net sözleşmeler. Sürpriz maliyetlere yer vermeyen dürüst fiyatlandırma.</p></div>
          <div class="value-card"><h4>Finansal Esneklik</h4><p>Esnek ödeme seçenekleri ve kiralama modelleri ile sermayenizi en verimli şekilde kullanın.</p></div>
        </div>
        <div class="section-cta">
          <a href="hakkimizda" class="btn btn-primary">Detaylı Bilgi</a>
        </div>
      </div>
    </section>

    <section class="section section-alt" id="iletisim">
      <div class="container">
        <h2 class="section-title">İletişim</h2>
        <p class="section-desc">Sorularınız için bizimle iletişime geçin</p>
        <div class="contact-cards">
          <div class="contact-card">
            <h3>Adres</h3>
            <p><?= nl2br(htmlspecialchars($siteSettings['address'] ?? '')) ?></p>
          </div>
          <div class="contact-card">
            <h3>İletişim</h3>
            <p><strong>Tel:</strong> <a href="tel:+<?= getWaNum() ?>"><?= htmlspecialchars($siteSettings['phone_display'] ?? '') ?></a></p>
            <p><strong>E-posta:</strong> <a href="mailto:<?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?>"><?= htmlspecialchars($siteSettings['contact_email'] ?? '') ?></a></p>
          </div>
          <div class="contact-card">
            <h3>Hızlı Erişim</h3>
            <div class="contact-card-actions">
              <a href="https://wa.me/<?= getWaNum() ?>" class="btn btn-whatsapp" target="_blank" rel="noopener">WhatsApp ile Yaz</a>
              <a href="iletisim" class="btn btn-outline">İletişim Formu</a>
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

  <script src="/assets/js/form-api.js?v=3"></script>
  <script src="/assets/js/site-settings.js?v=5"></script>
  <script src="/assets/js/app.js?v=2"></script>
  <script src="/assets/js/app-makineler.js?v=2"></script>
</body>
</html>
