<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'saha-fotograflari';

$sahaPhotos = [];
$sahaFile = defined('DATA_PATH') ? DATA_PATH . '/saha_fotograflari.json' : __DIR__ . '/data/saha_fotograflari.json';
if (file_exists($sahaFile)) {
    $sahaPhotos = json_decode(file_get_contents($sahaFile), true) ?: [];
    usort($sahaPhotos, function($a, $b) { return ($a['sort_order'] ?? 0) - ($b['sort_order'] ?? 0); });
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/styles.css?v=13" />
</head>
<body>
  <a href="https://wa.me/<?= getWaNum() ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <header class="header">
    <div class="container header-inner">
      <a href="index" class="logo" aria-label="Gravisa"><img src="<?= BASE_PATH ?>/images/gravisa-transparan-logo.png" alt="Gravisa" /></a>
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
        <h1>Saha Fotoğrafları</h1>
        <p>Makinelerimizin projelerdeki görünümü. Sahada çekilen gerçek fotoğraflarımız.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <nav class="breadcrumb" style="margin-bottom: 32px;">
          <a href="index">Ana Sayfa</a><span>/</span>
          <a href="kurumsal">Kurumsal</a><span>/</span>
          <span>Saha Fotoğrafları</span>
        </nav>

        <div class="machine-grid saha-grid" id="saha-fotograflari-grid">
          <?php if (empty($sahaPhotos)): ?>
          <p style="grid-column: 1/-1; text-align: center; color: var(--color-text-muted); padding: 40px;">Henüz saha fotoğrafı eklenmemiş. Admin panelden ekleyebilirsiniz.</p>
          <?php else: ?>
          <?php foreach ($sahaPhotos as $photo): ?>
          <?php
            $rawImg = safeImgSrc($photo['img'] ?? '');
            $path = ($rawImg !== '' && substr($rawImg, 0, 1) === '/') ? $rawImg : '/' . ltrim($rawImg, '/');
            $path = (defined('BASE_PATH') ? BASE_PATH : '') . $path;
            $imgSrc = htmlspecialchars($path, ENT_QUOTES, 'UTF-8');
            $imgSrcEncoded = str_replace([' ', '(', ')'], ['%20', '%28', '%29'], $imgSrc);
            $title = htmlspecialchars($photo['title'] ?? 'Saha Fotoğrafı', ENT_QUOTES, 'UTF-8');
            $desc = htmlspecialchars($photo['description'] ?? '', ENT_QUOTES, 'UTF-8');
          ?>
          <div class="machine-card" style="height:100%;">
            <div class="machine-card-image" style="aspect-ratio:4/3; overflow:hidden;">
              <img src="<?= $imgSrcEncoded ?>" alt="<?= $title ?>" loading="lazy" style="width:100%; height:100%; object-fit:cover; object-position:center;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
              <span class="hero-image-fallback" style="display:none; width:100%; height:100%; align-items:center; justify-content:center; background:var(--color-surface-alt); font-size:2rem;">🖼️</span>
            </div>
            <div class="machine-card-body" style="min-height:128px; display:flex; flex-direction:column;">
              <h3 class="machine-card-title" style="min-height:2.7em;"><?= $title ?></h3>
              <?php if ($desc): ?>
              <p class="machine-card-meta" style="min-height:2.9em; margin-bottom:0;"><?= $desc ?></p>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
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
      <p class="footer-copy">&copy; Gravisa. Tüm hakları saklıdır. Bu site Nfs Soft (<a href="https://nfssoft.com" target="_blank" rel="noopener">nfssoft.com</a>) tarafından yapıldı.</p>
    </div>
  </footer>

  <script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=5"></script>
  <script src="<?= BASE_PATH ?>/assets/js/app.js?v=3"></script>
</body>
</html>
