<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'referanslar';
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
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section class="page-hero">
      <div class="container">
        <h1>Referanslar</h1>
        <p>Birlikte çalıştığımız kurum ve projelerden bazıları.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <nav class="breadcrumb" style="margin-bottom: 32px;">
          <a href="index">Ana Sayfa</a><span>/</span>
          <a href="kurumsal">Kurumsal</a><span>/</span>
          <span>Referanslar</span>
        </nav>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px; margin-bottom: 48px;">
          <div style="padding: 40px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-top: 4px solid var(--color-primary);">
            <div style="width: 64px; height: 64px; background: var(--color-primary-soft); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; font-size: 2rem;">🏗️</div>
            <h3 style="font-size: 1.5rem; margin: 0 0 16px; color: var(--color-text);">İnşaat Firmaları</h3>
            <p style="margin: 0 0 20px; color: var(--color-text-muted); line-height: 1.7;">Büyük ölçekli konut ve altyapı projelerinde makine tedarikçisi olarak yer aldık. Ekskavatör ve loder kiralama referanslarımız bulunmaktadır.</p>
            <div style="padding-top: 20px; border-top: 1px solid var(--color-border);">
              <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Konut Projeleri</span>
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Altyapı</span>
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Ekskavatör</span>
              </div>
            </div>
          </div>
          <div style="padding: 40px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-top: 4px solid var(--color-accent);">
            <div style="width: 64px; height: 64px; background: var(--color-accent-soft); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; font-size: 2rem;">🏛️</div>
            <h3 style="font-size: 1.5rem; margin: 0 0 16px; color: var(--color-text);">Kamu Projeleri</h3>
            <p style="margin: 0 0 20px; color: var(--color-text-muted); line-height: 1.7;">Belediye ve kamu kurumlarına kiralama ve satış hizmeti verdik. Yol, kanalizasyon ve peyzaj projelerinde ekipman desteği sağladık.</p>
            <div style="padding-top: 20px; border-top: 1px solid var(--color-border);">
              <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Belediye</span>
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Kamu</span>
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Yol Projeleri</span>
              </div>
            </div>
          </div>
          <div style="padding: 40px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-top: 4px solid var(--color-primary);">
            <div style="width: 64px; height: 64px; background: var(--color-primary-soft); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; font-size: 2rem;">⛏️</div>
            <h3 style="font-size: 1.5rem; margin: 0 0 16px; color: var(--color-text);">Maden & Taş Ocakları</h3>
            <p style="margin: 0 0 20px; color: var(--color-text-muted); line-height: 1.7;">Agrega ve maden sahalarında ekskavatör ve loder kiralama referanslarımız bulunmaktadır. Uzun dönem kiralama anlaşmalarıyla hizmet verdik.</p>
            <div style="padding-top: 20px; border-top: 1px solid var(--color-border);">
              <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Maden</span>
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Agrega</span>
                <span style="padding: 6px 12px; background: var(--color-surface-alt); border-radius: var(--radius); font-size: 0.85rem; color: var(--color-text-muted);">Uzun Dönem</span>
              </div>
            </div>
          </div>
        </div>

        <div style="padding: 40px; background: linear-gradient(135deg, var(--color-primary-soft) 0%, rgba(13, 148, 136, 0.05) 100%); border-radius: var(--radius-lg); border: 1px solid var(--color-border); margin-bottom: 32px;">
          <h3 style="font-size: 1.75rem; margin: 0 0 20px; color: var(--color-text); text-align: center;">Referans İstatistikleri</h3>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 32px;">
            <div style="text-align: center;">
              <div style="font-size: 3rem; font-weight: 800; color: var(--color-primary); margin-bottom: 8px;">150+</div>
              <div style="color: var(--color-text-muted); font-weight: 600;">Tamamlanan Proje</div>
            </div>
            <div style="text-align: center;">
              <div style="font-size: 3rem; font-weight: 800; color: var(--color-primary); margin-bottom: 8px;">80+</div>
              <div style="color: var(--color-text-muted); font-weight: 600;">Mutlu Müşteri</div>
            </div>
            <div style="text-align: center;">
              <div style="font-size: 3rem; font-weight: 800; color: var(--color-primary); margin-bottom: 8px;">15+</div>
              <div style="color: var(--color-text-muted); font-weight: 600;">Yıl Deneyim</div>
            </div>
            <div style="text-align: center;">
              <div style="font-size: 3rem; font-weight: 800; color: var(--color-primary); margin-bottom: 8px;">%98</div>
              <div style="color: var(--color-text-muted); font-weight: 600;">Memnuniyet Oranı</div>
            </div>
          </div>
        </div>

        <p style="text-align: center; margin-top: 40px;">
          <a href="kurumsal" class="btn btn-outline">← Kurumsal sayfasına dön</a>
        </p>
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

  <script src="/assets/js/site-settings.js?v=5"></script>
  <script src="/assets/js/app.js?v=2"></script>
</body>
</html>
