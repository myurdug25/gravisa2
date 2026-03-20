<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageId = 'kiralama';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/styles.css?v=10" />
</head>
<body>
  <a href="https://wa.me/<?= getWaNum() ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <header class="header">
    <div class="container header-inner">
      <a href="index" class="logo"><img src="<?= BASE_PATH ?>/images/IMG_9059.JPG-removebg-preview.png" alt="Gravisa" /></a>
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
        <h1>Kiralama</h1>
        <p>Günlük veya aylık, operatörlü veya operatörsüz kiralama seçenekleri. Lokasyon bilginizi paylaşın.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <form class="form-block" id="kiralama-form">
          <input type="text" name="website" value="" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;" tabindex="-1" autocomplete="off" aria-hidden="true" />
          <h2 style="margin-bottom:24px; font-size:1.35rem;">Kiralama Tercihleri</h2>
          <div class="form-row">
            <label>
              <span>Kiralama Süresi</span>
              <select name="sure" required>
                <option value="">Seçiniz</option>
                <option value="gunluk">Günlük</option>
                <option value="haftalik">Haftalık</option>
                <option value="aylik">Aylık</option>
                <option value="uzun-donem">Uzun Dönem (3+ ay)</option>
              </select>
            </label>
            <label>
              <span>Operatör</span>
              <select name="operator" required>
                <option value="">Seçiniz</option>
                <option value="operatörlü">Operatörlü</option>
                <option value="operatörsüz">Operatörsüz</option>
              </select>
            </label>
          </div>
          <div id="makine-bilgileri" class="makine-preview" style="display: none; background: var(--color-surface-alt); padding: 20px; border-radius: var(--radius); margin-bottom: 24px; border: 2px solid var(--color-primary);">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
              <img id="makine-resim" src="" alt="" style="width: 80px; height: 60px; object-fit: cover; border-radius: var(--radius);" />
              <div>
                <h3 id="makine-adi" style="margin: 0 0 4px; font-size: 1.1rem; color: var(--color-text);"></h3>
                <p id="makine-detay" style="margin: 0; font-size: 0.9rem; color: var(--color-text-muted);"></p>
              </div>
            </div>
            <input type="hidden" name="makine_id" id="makine-id" />
            <input type="hidden" name="makine_model" id="makine-model" />
          </div>
          <label>
            <span>Makine Modeli</span>
            <select name="model" id="kiralama-model">
              <option value="">Makine seçiniz (opsiyonel)</option>
            </select>
          </label>

          <h2 style="margin: 32px 0 24px; font-size: 1.35rem;">Lokasyon & İletişim</h2>
          <label>
            <span>Şantiye / Çalışma Adresi</span>
            <input type="text" name="lokasyon" required placeholder="İl, ilçe, mahalle veya tam adres" />
          </label>
          <div class="form-row">
            <label>
              <span>Başlangıç Tarihi</span>
              <input type="date" name="baslangic" />
            </label>
            <label>
              <span>Bitiş Tarihi (Tahmini)</span>
              <input type="date" name="bitis" />
            </label>
          </div>
          <div class="form-row">
            <label>
              <span>Ad Soyad</span>
              <input type="text" name="ad_soyad" required placeholder="Adınız Soyadınız" />
            </label>
            <label>
              <span>E-posta</span>
              <input type="email" name="email" required placeholder="ornek@email.com" />
            </label>
          </div>
          <div class="form-row">
            <label>
              <span>Telefon</span>
              <input type="tel" name="telefon" required placeholder="05XX XXX XX XX" />
            </label>
            <label>
              <span>Firma / Ünvan (Opsiyonel)</span>
              <input type="text" name="firma" placeholder="Firma adı" />
            </label>
          </div>
          <label>
            <span>Ek Notlar</span>
            <textarea name="not" rows="3" placeholder="Özel talepler..."></textarea>
          </label>
          <button type="submit" class="btn btn-primary">Kiralama Talebi Gönder</button>
        </form>
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
      <p class="footer-copy">&copy; Gravisa. Tüm hakları saklıdır. Bu site Nfs Soft (nfssoft.com) tarafından yapıldı.</p>
    </div>
  </footer>

<script src="<?= BASE_PATH ?>/assets/js/form-api.js?v=3"></script>
<script src="<?= BASE_PATH ?>/assets/js/site-settings.js?v=5"></script>
<script src="<?= BASE_PATH ?>/assets/js/app.js?v=3"></script>
<script src="<?= BASE_PATH ?>/assets/js/app-makineler.js?v=3"></script>
  <script>
    (function () {
      // Makine verilerinin yüklenmesini bekle
      function initKiralama() {
        // Makine verilerini global scope'tan al
        var makineler = window.makineler || [];
        
        if (makineler.length === 0) {
          // Eğer henüz yüklenmediyse biraz bekle
          setTimeout(initKiralama, 100);
          return;
        }
      
      // Model select'i doldur
      var modelSelect = document.getElementById('kiralama-model');
      if (modelSelect && makineler.length > 0) {
        makineler.forEach(function(m) {
          var opt = document.createElement('option');
          opt.value = m.id;
          opt.textContent = m.firma + ' ' + m.tipModel + ' (' + m.tip + ')';
          modelSelect.appendChild(opt);
        });
      }
      
      // URL parametrelerinden makine bilgilerini al
      var params = new URLSearchParams(window.location.search);
      var modelId = params.get('id') || params.get('model');
      
      function showMakineInfo(makine) {
        if (!makine) return;
        
        var makineBilgileri = document.getElementById('makine-bilgileri');
        if (!makineBilgileri) return;
        
        // Makine bilgilerini göster
        makineBilgileri.style.display = 'block';
        document.getElementById('makine-resim').src = makine.img;
        document.getElementById('makine-resim').alt = makine.tipModel;
        document.getElementById('makine-adi').textContent = makine.firma + ' ' + makine.tipModel;
        var detayText = makine.tip;
        if (makine.modelYil) detayText += ' • ' + makine.modelYil;
        if (makine.guc) detayText += ' • ' + makine.guc + ' ' + makine.gucBirim;
        document.getElementById('makine-detay').textContent = detayText;
        document.getElementById('makine-id').value = makine.id;
        document.getElementById('makine-model').value = makine.firma + ' ' + makine.tipModel;
        
        // Select'i de güncelle
        if (modelSelect) {
          modelSelect.value = makine.id;
        }
      }
      
      if (modelId && makineler.length > 0) {
        var makineIdNum = parseInt(modelId, 10);
        var makine = makineler.find(function(m) { 
          return m.id === makineIdNum || 
                 (isNaN(makineIdNum) && (
                   m.tipModel.toLowerCase().includes(modelId.toLowerCase()) || 
                   (m.firma + ' ' + m.tipModel).toLowerCase().includes(modelId.toLowerCase())
                 ));
        });
        
        if (makine) {
          showMakineInfo(makine);
        }
      }
      
      // Model değiştiğinde makine bilgilerini güncelle
      if (modelSelect) {
        modelSelect.addEventListener('change', function() {
          var selectedId = this.value;
          if (selectedId && makineler.length > 0) {
            var selectedIdNum = parseInt(selectedId, 10);
            var makine = makineler.find(function(m) { return m.id === selectedIdNum; });
            if (makine) {
              showMakineInfo(makine);
            } else {
              document.getElementById('makine-bilgileri').style.display = 'none';
            }
          } else {
            document.getElementById('makine-bilgileri').style.display = 'none';
          }
        });
      }
      
      // Form gönderimi
      document.getElementById('kiralama-form').addEventListener('submit', function (e) {
        e.preventDefault();
        var form = this;
        var btn = form.querySelector('button[type="submit"]');
        if (btn) { btn.disabled = true; btn.textContent = 'Gönderiliyor...'; }
        if (typeof window.submitFormToAPI === 'function') {
          window.submitFormToAPI(form, '<?= BASE_PATH ?>/api/kiralama.php')
            .then(function (msg) { if (typeof window.showToast === 'function') window.showToast(msg, true); else alert(msg); form.reset(); document.getElementById('makine-bilgileri').style.display = 'none'; })
            .catch(function (err) { if (typeof window.showToast === 'function') window.showToast(err, false); else alert(err); })
            .finally(function () { if (btn) { btn.disabled = false; btn.textContent = 'Kiralama Talebi Gönder'; } });
        } else {
          if (typeof window.showToast === 'function') window.showToast('Kiralama talebiniz alındı. En kısa sürede size dönüş yapacağız.', true); else alert('Kiralama talebiniz alındı.');
          form.reset();
          document.getElementById('makine-bilgileri').style.display = 'none';
          if (btn) { btn.disabled = false; btn.textContent = 'Kiralama Talebi Gönder'; }
        }
      });
      }
      
      // Sayfa yüklendiğinde başlat
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initKiralama);
      } else {
        initKiralama();
      }
    })();
  </script>
</body>
</html>
