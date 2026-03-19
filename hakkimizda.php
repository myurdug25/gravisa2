<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'hakkimizda';
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
        <h1>Hakkımızda</h1>
        <p>İş makineleri satış ve kiralama alanında güvenilir çözüm ortağınız Gravisa’nın hikayesi ve değerleri.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="content-page content-page--wide">
          <nav class="breadcrumb">
            <a href="index">Ana Sayfa</a><span>/</span>
            <a href="kurumsal">Kurumsal</a><span>/</span>
            <span>Hakkımızda</span>
          </nav>

          <!-- Önsöz -->
          <div class="content-block" style="margin-bottom: 48px;">
            <h2 class="content-block-title">Çözüm Ortaklığında Yeni Bir Standart: Gravisa</h2>
            <p class="content-block-text">
              Modern inşaat ve altyapı dünyası, her geçen gün daha karmaşık, daha hızlı ve daha hatasız operasyonlar gerektiriyor. Projelerin başarıya ulaşması; doğru zamanda, doğru teknik özelliklere sahip ve sorunsuz çalışan iş makinelerinin varlığına bağlıdır. Gravisa olarak biz, sektördeki bu kritik ihtiyacı profesyonel bir ekosistemle karşılamak üzere kurulduk.
            </p>
            <p class="content-block-text">
              Elinizdeki bu katalog, sunduğumuz geniş hizmet yelpazesinin, teknik kabiliyetlerimizin ve kalite anlayışımızın bir özetidir. Katalog içerisinde bulacağınız her bir makine; titiz bir ekspertiz sürecinden geçmiş, bakımları en yüksek standartlarda yapılmış ve yüksek çalışma verimliliği vaat eden modellerden seçilmiştir. Satış ve kiralama departmanlarımız, projenizin ölçeği ne olursa olsun size en optimize maliyet-fayda dengesini sunmak için uzmanlaşmıştır.
            </p>
            <p class="content-block-text">
              Sadece makine tedarik eden bir firma olmanın ötesinde; teknik destek, yedek parça danışmanlığı ve operasyonel rehberlik hizmetlerimizle, işinizin her aşamasında 'çözüm merkezi' olma misyonunu üstleniyoruz. Amacımız, müşterilerimizin iş makineleriyle ilgili tüm kaygılarını ortadan kaldırmak ve onların tamamen kendi uzmanlık alanlarına odaklanmalarını sağlamaktır.
            </p>
            <p class="content-block-text">
              Bu kataloğu incelediğinizde, sadece donanım değil, aynı zamanda kurumsal bir disiplin ve güçlü bir satış sonrası hizmet taahhüdü bulacaksınız. İhtiyaç duyduğunuz her an, uzman ekibimizle projelerinizin hızına hız katmaya hazırız.
            </p>
            <p class="content-block-text" style="font-weight: 600; color: var(--color-primary);">Gravisa Ailesi Olarak Başarılar Dileriz.</p>
          </div>

          <!-- Başkanın Mesajı -->
          <div class="content-block content-block-highlight" style="margin-bottom: 48px;">
            <h2 class="content-block-title">Başkanın Mesajı</h2>
            <p class="content-block-text" style="font-style: italic; font-size: 1.05rem;">
              "Değerli İş Ortaklarımız ve Paydaşlarımız;<br><br>
              Ağır sanayi ve inşaat sektörü, bir ülkenin kalkınma yolculuğundaki en temel taşlardan biridir. Bizler, bu büyük çarkın işleyişine güç katmak, projelerinizi sadece makinelerle değil, güven ve tecrübeyle desteklemek amacıyla yola çıktık. İş makineleri sektöründe geçirdiğimiz yıllar boyunca öğrendiğimiz en önemli ders; doğru ekipmanın sadece bir araç değil, projenin kalbi olduğudur.<br><br>
              Şirketimizi kurarken temel motivasyonumuz, sektördeki 'güven' ve 'kesintisiz hizmet' ihtiyacına profesyonel bir yanıt vermekti. Bugün, alım-satım ve kiralama süreçlerinde sadece bir ticari partner değil, her zorlu saha koşulunda yanınızda duran bir yol arkadaşı olmayı hedefliyoruz. Bizim için başarı; sadece teslim ettiğimiz makinelerin sayısı değil, o makinelerin çalıştığı şantiyelerde yükselen değerler ve sizlerin yüzündeki memnuniyettir.<br><br>
              Teknolojinin hızla dönüştüğü günümüzde, makine parkurumuzu sürekli güncelliyor ve dünya standartlarını yerel tecrübemizle harmanlıyoruz. Dürüstlükten ödün vermeyen ticaret anlayışımızla, her el sıkışmamızın arkasında durmaya devam edeceğiz. Bu katalog, sadece sunduğumuz makinelerin bir dökümü değil; işimize olan tutkumuzun ve sizlere verdiğimiz sözün bir yansımasıdır.<br><br>
              Bizlere güvenen, enerjimize ortak olan tüm dostlarımıza ve özveriyle çalışan ekibimize teşekkürlerimi sunarım. Daha büyük projelerde, daha güçlü yarınlarda birlikte yürümek dileğiyle."
            </p>
            <p style="margin: 24px 0 0; font-weight: 700; color: var(--color-primary);">Ahmet Burak GÜLEÇ</p>
            <p style="margin: 4px 0 0; font-size: 0.9rem; color: var(--color-text-muted);">Yönetim Kurulu Başkanı</p>
          </div>

          <!-- Bizim Hikayemiz -->
          <div class="content-block" style="margin-bottom: 48px;">
            <h2 class="content-block-title">İşinize Güç, Projenize Değer Katıyoruz</h2>
            <p class="content-block-subtitle">Başarının Temeli: Bizim Hikayemiz</p>
            <p class="content-block-text">
              Gravisa, inşaat ve ağır sanayi sektörünün kalbinde, sahanın tozunu yutmuş, zorlukları bizzat tecrübe etmiş bir vizyonun eseri olarak kuruldu. Yolculuğumuz, sadece iş makinesi alıp satmak değil; Türkiye'nin yükselen projelerine güç katmak, altyapı ve üstyapı çalışmalarında karşılaşılan operasyonel engelleri profesyonel çözümlerle aşmak hedefiyle başladı.
            </p>
            <p class="content-block-text">
              Kuruluşumuzdan itibaren temel ilkemiz; "Doğru makine, doğru proje ile buluştuğunda başarı kaçınılmazdır" anlayışı oldu. Sektördeki derin tecrübemizi, modern dünyanın hızıyla birleştirerek kısa sürede iş makinesi alım-satım ve kiralama alanında güvenin adresi haline geldik. Bizim için her bir makine, sadece bir metal yığını değil; bir barajın temeli, bir yolun başlangıcı veya bir şehrin silüetini değiştiren bir yapının en sadık yardımcısıdır.
            </p>
            <p class="content-block-text">
              Gravisa olarak, parkurumuzdaki her bir iş makinesini titizlikle seçiyor, en zorlu saha koşullarında dahi yüksek performans sergileyecek kondisyonda tutuyoruz. Kiralama süreçlerimizde esneklik ve hızı, satış süreçlerimizde ise şeffaflık ve dürüstlüğü merkeze alıyoruz. Biliyoruz ki; iş makineleri sektörü sadece bir ticaret alanı değil, bir güven köprüsüdür. Bu köprünün her iki ucunda da memnuniyeti ve sürdürülebilirliği sağlamak en büyük önceliğimizdir.
            </p>
            <p class="content-block-text">
              Bugün, genişleyen makine parkurumuz, uzman teknik ekibimiz ve çözüm odaklı yaklaşımımızla sektörün dinamik gücü olarak yolumuza devam ediyoruz. Sadece bugünün projelerini değil, yarının dünyasını inşa edecek olan profesyonellere omuz veriyoruz. Geçmişimizden aldığımız güçle, geleceğe sağlam adımlarla yürüyor; her yeni projede iş ortaklarımızın yükünü hafifletmenin gururunu yaşıyoruz.
            </p>
            <p class="content-block-text" style="font-weight: 600; color: var(--color-primary);">Siz hayal edin, biz o hayalleri gerçeğe dönüştürecek gücü sahaya indirelim.</p>
            <p class="content-block-text" style="font-weight: 600;">Gravisa: Güçlü Yarınların Sarsılmaz Temeli.</p>
            <div class="content-stats-grid">
              <div style="text-align: center; padding: 24px; background: var(--color-surface-alt); border-radius: var(--radius);">
                <strong style="display: block; font-size: 2rem; color: var(--color-primary); margin-bottom: 8px;">15+</strong>
                <span style="color: var(--color-text-muted); font-size: 0.9rem;">Yıl Deneyim</span>
              </div>
              <div style="text-align: center; padding: 24px; background: var(--color-surface-alt); border-radius: var(--radius);">
                <strong style="display: block; font-size: 2rem; color: var(--color-primary); margin-bottom: 8px;">500+</strong>
                <span style="color: var(--color-text-muted); font-size: 0.9rem;">Proje</span>
              </div>
              <div style="text-align: center; padding: 24px; background: var(--color-surface-alt); border-radius: var(--radius);">
                <strong style="display: block; font-size: 2rem; color: var(--color-primary); margin-bottom: 8px;">319+</strong>
                <span style="color: var(--color-text-muted); font-size: 0.9rem;">Makine</span>
              </div>
            </div>
          </div>

          <!-- Neden Biz? -->
          <div class="content-block" style="margin-bottom: 48px;">
            <h2 class="content-block-title">Neden Biz?</h2>
            <p class="content-block-subtitle">Gücümüzü Tecrübemizden, Hızımızı Teknolojimizden Alıyoruz</p>
            <p class="content-block-text">
              İş makineleri sektörü, sadece metal ve hidrolikten ibaret değildir; bu sektör bir zaman ve maliyet yönetimi sanatıdır. İşte bizi rakiplerimizden ayıran ve projelerinizin vazgeçilmez bir parçası yapan temel farklarımız:
            </p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-top: 28px;">
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Bütünleşik Çözüm Kapasitesi</h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">Sadece makine satmıyor veya kiralamıyoruz. Projenizin büyüklüğüne, zemin yapısına ve bütçesine en uygun makineyi belirlemek için teknik danışmanlık sağlıyoruz. Alım, satım ve kiralama süreçlerinin tamamını tek çatı altında toplayarak operasyonel yükünüzü hafifletiyoruz.</p>
              </div>
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Kusursuz Makine Parkuru ve Bakım Standartları</h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">Portföyümüzdeki tüm makineler, en zorlu saha koşullarında dahi maksimum performans gösterecek şekilde periyodik olarak uzman teknisyenlerimizce denetlenir. "Sıfır Arıza" vizyonuyla hareket ederek, işinizin durmasına değil, hızlanmasına odaklanıyoruz.</p>
              </div>
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Hızlı ve Yerinde Teknik Destek</h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">Şantiyede geçen her dakikanın maliyetinin farkındayız. Herhangi bir teknik aksaklık durumunda, mobil servis ekiplerimizle en kısa sürede müdahale ederek projenizin aksamasının önüne geçiyoruz.</p>
              </div>
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Şeffaf ve Adil Ticaret Anlayışı</h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">İster ikinci el alım-satım olsun ister uzun dönem kiralama; tüm süreçlerimizde şeffaf ekspertiz raporları ve net sözleşmelerle ilerliyoruz. Sürpriz maliyetlere yer vermeyen, dürüst fiyatlandırma politikamızla güven inşa ediyoruz.</p>
              </div>
              <div style="padding: 28px; background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                <h3 style="font-size: 1.15rem; margin: 0 0 12px; color: var(--color-text);">Finansal Esneklik</h3>
                <p style="margin: 0; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">Yatırım planlarınıza göre şekillenen esnek ödeme seçenekleri ve kiralama modelleri sunarak, sermayenizi en verimli şekilde kullanmanıza olanak tanıyoruz.</p>
              </div>
            </div>
          </div>

          <!-- Çalışma Alanlarımız -->
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-bottom: 48px; align-items: start;">
            <div>
              <h2 style="font-size: 1.75rem; margin: 0 0 24px; color: var(--color-text);">Çalışma Alanlarımız</h2>
              <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);">İnşaat ve Altyapı Projeleri</span>
                </li>
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);">Madencilik ve Taş Ocakları</span>
                </li>
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);">Tünel ve Metro İnşaatları</span>
                </li>
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);">Endüstriyel Tesisler</span>
                </li>
                <li style="display: flex; align-items: center; gap: 12px;">
                  <span style="width: 8px; height: 8px; background: var(--color-primary); border-radius: 50%;"></span>
                  <span style="color: var(--color-text);">Tarım ve Ormancılık</span>
                </li>
              </ul>
            </div>
            <div style="background: var(--color-surface-alt); padding: 40px; border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
              <h3 style="font-size: 1.25rem; margin: 0 0 20px; color: var(--color-text);">Vizyon & Misyon</h3>
              <p style="margin: 0 0 16px; color: var(--color-text-muted); line-height: 1.7; font-size: 0.9375rem;">Misyonumuz ve vizyonumuz hakkında detaylı bilgi için Vizyon & Misyon sayfamızı inceleyebilirsiniz.</p>
              <a href="vizyon-misyon" class="btn btn-outline">Vizyon & Misyon</a>
            </div>
          </div>

          <div style="margin-top: 48px; padding: 32px; background: linear-gradient(135deg, var(--color-primary-soft) 0%, var(--color-accent-soft) 100%); border-radius: var(--radius-lg); text-align: center;">
            <h3 style="font-size: 1.5rem; margin: 0 0 16px; color: var(--color-text);">Bizimle Çalışmak İster misiniz?</h3>
            <p style="margin: 0 0 24px; color: var(--color-text-muted);">Projelerinizde güvenilir bir çözüm ortağı arıyorsanız bizimle iletişime geçin.</p>
            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
              <a href="satis-teklifi" class="btn btn-primary">Satış Teklifi Al</a>
              <a href="kiralama" class="btn btn-secondary">Kiralama Yap</a>
              <a href="iletisim" class="btn btn-outline">İletişime Geç</a>
            </div>
          </div>

          <p style="margin-top: 32px; text-align: center;">
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
