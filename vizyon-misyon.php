<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'vizyon-misyon';
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
        <h1>Vizyon & Misyon</h1>
        <p>Nereye gidiyoruz ve nasıl bir hizmet anlayışıyla çalışıyoruz.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="content-page content-page--wide">
          <nav class="breadcrumb">
            <a href="index">Ana Sayfa</a><span>/</span>
            <a href="kurumsal">Kurumsal</a><span>/</span>
            <span>Vizyon & Misyon</span>
          </nav>

          <div class="content-block" style="margin-bottom: 48px;">
            <h2 class="content-block-title">Misyonumuz</h2>
            <p class="content-block-text">
              İş makineleri alım, satım ve kiralama sektöründe faaliyet gösteren bir kuruluş olarak temel görevimiz; inşaat, madencilik, lojistik ve altyapı projelerinde ihtiyaç duyulan yüksek performanslı ekipmanları, en yüksek kalite standartlarında ve güvenilir bir ticaret zeminiyle sunmaktır. Sadece bir tedarikçi değil, müşterilerimizin projelerini kendi projemiz gibi sahiplenen bir çözüm ortağı olma vizyonuyla hareket ediyoruz. Satış öncesi doğru ekspertiz, satış sonrası kesintisiz destek ve dürüst fiyatlandırma politikamızla, iş ortaklarımızın operasyonel risklerini minimize ederek, projelerinin her aşamasında sürdürülebilir bir verimlilik sağlamayı taahhüt ediyoruz.
            </p>
          </div>

          <div class="content-block" style="margin-bottom: 48px;">
            <h2 class="content-block-title">Vizyonumuz</h2>
            <p class="content-block-text">
              Sektördeki teknolojik dönüşümü ve pazar dinamiklerini yakından takip ederek, iş makineleri dendiğinde akla gelen ilk "güven simgesi" haline gelmek. Hizmet kalitemizi sürekli geliştirerek, yerel pazardaki liderliğimizi uluslararası standartlarla taçlandırmayı hedefliyoruz. Yenilikçi yatırım modellerimiz ve geniş makine parkurumuzla, ülkemizin kalkınmasına yön veren dev projelerin vazgeçilmez bir parçası olmak; dürüstlükten ödün vermeyen duruşumuzla sektörün referans noktası olarak anılmaktır.
            </p>
          </div>

          <h2 class="content-block-title" style="margin-top: 48px;">Değerlerimiz</h2>
          <p class="content-block-text" style="margin-bottom: 24px;">İşimizin Temelindeki Sarsılmaz İlkeler</p>
          <p class="content-block-text">
            Şirketimizin başarısı, sadece cirolarımızla değil, savunduğumuz değerlerin ne kadar arkasında durduğumuzla ölçülür. Biz, her bir projede şu beş temel değeri rehber ediniyoruz:
          </p>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-top: 28px; margin-bottom: 48px;">
            <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
              <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Dürüstlük ve Şeffaflık</h3>
              <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">Ticari faaliyetlerimizin merkezinde "güven" yer alır. Müşterilerimizle kurduğumuz ilişkilerde, makinenin çalışma saatinden teknik geçmişine kadar her bilgiyi tüm açıklığıyla paylaşırız. Söz verdiğimiz tarihte, söz verdiğimiz kalitede hizmet sunmak bizim için bir tercihten ziyade zorunluluktur.</p>
            </div>
            <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
              <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Sürekli Yenilikçilik</h3>
              <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">İş makineleri dünyası hızla dijitalleşiyor ve verimlilik odaklı hale geliyor. Biz de bu değişime ayak uydurarak makine parkurumuzu en yeni teknolojilerle güncelliyor, yakıt tasarrufu yüksek ve çevre dostu modelleri bünyemize katıyoruz. Geleneksel iş yapış biçimlerini modern çözümlerle harmanlayarak sektöre yön veriyoruz.</p>
            </div>
            <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
              <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Önce Emniyet ve İş Güvenliği</h3>
              <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">İş makineleri büyük güç demektir ve bu güç, yüksek sorumluluk gerektirir. Sunduğumuz her makinenin iş güvenliği standartlarına %100 uyumlu olmasını sağlıyor, operatör eğitimlerine ve periyodik bakımlara azami özen gösteriyoruz. Hem çalışanlarımızın hem de müşterilerimizin sahadaki güvenliği en büyük önceliğimizdir.</p>
            </div>
            <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
              <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Müşteri Odaklılık ve Ortak Başarı</h3>
              <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">Müşterilerimizi sadece birer "alıcı" olarak değil, uzun vadeli iş ortaklarımız olarak görüyoruz. Sizin projenizin başarısı, bizim referansımızdır. İhtiyaçlarınıza özel çözümler üreterek, her aşamada yanınızda duruyor ve beklentilerinizin ötesine geçmeyi hedefliyoruz.</p>
            </div>
            <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
              <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Sürdürülebilirlik ve Sorumluluk</h3>
              <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">Gelecek nesillere yaşanabilir bir dünya bırakma bilinciyle hareket ediyoruz. Operasyonlarımızda kaynak kullanımını optimize ediyor, düşük emisyonlu makinelerimizle çevresel etkiyi minimize etmeye gayret gösteriyoruz. Topluma ve çevreye karşı sorumlu bir marka olmanın gururunu yaşıyoruz.</p>
            </div>
          </div>

          <p style="margin-top: 32px;">
            <a href="kurumsal" class="btn btn-outline">← Kurumsal sayfasına dön</a>
          </p>
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

  <script src="/assets/js/site-settings.js?v=5"></script>
  <script src="/assets/js/app.js?v=2"></script>
</body>
</html>
