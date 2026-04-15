(function () {
  'use strict';

  var J = window.__GRAVISA_JS || {};
  function langPath(slug) {
    return typeof window.gravisaLangPath === 'function' ? window.gravisaLangPath(slug) : slug;
  }
  function addQuery(url, key, value) {
    var sep = url.indexOf('?') >= 0 ? '&' : '?';
    return url + sep + encodeURIComponent(key) + '=' + encodeURIComponent(String(value));
  }

  // Mobil menü
  var navToggle = document.querySelector('.nav-toggle');
  var nav = document.querySelector('#main-nav');
  if (navToggle && nav) {
    navToggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', open);
    });
    document.addEventListener('click', function (e) {
      if (nav.classList.contains('is-open') && !nav.contains(e.target) && !navToggle.contains(e.target)) {
        nav.classList.remove('is-open');
        navToggle.setAttribute('aria-expanded', 'false');
        var dd = document.querySelector('.nav-dropdown.is-open');
        if (dd) { dd.classList.remove('is-open'); }
      }
    });
  }

  // Mobil: Kurumsal dropdown – ok butonu ile aç/kapa (link navigasyon yapar)
  var navDropdown = document.querySelector('.nav-dropdown');
  if (navDropdown) {
    var dropdownToggle = navDropdown.querySelector('.nav-dropdown-toggle');
    if (dropdownToggle) {
      dropdownToggle.addEventListener('click', function () {
        if (window.innerWidth <= 768) {
          var open = navDropdown.classList.toggle('is-open');
          dropdownToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
      });
    }
  }

  var base = (typeof window.basePath === 'string') ? window.basePath : '';
  // Hero görsel slider
  var heroBg = document.querySelector('.hero-bg');
  if (heroBg) {
    var heroImages = [
      base + '/assets/hero-1.png',
      base + '/assets/machine-2.png',
      base + '/assets/machine-3.png',
      base + '/assets/machine-4.png',
      base + '/assets/machine-5.png',
      base + '/assets/machine-6.png'
    ];
    var currentHeroIndex = 0;

    function setHeroBackground(index) {
      heroBg.style.backgroundImage = "url('" + heroImages[index] + "')";
    }

    setHeroBackground(currentHeroIndex);

    setInterval(function () {
      heroBg.style.opacity = '0';
      setTimeout(function () {
        currentHeroIndex = (currentHeroIndex + 1) % heroImages.length;
        setHeroBackground(currentHeroIndex);
        heroBg.style.opacity = '1';
      }, 400);
    }, 6000);
  }

  // Ana sayfa: stok kategorileri (kategori kartları - görselli)
  var stoktaCats = document.getElementById('stokta-categories');
  var stoktaCatsToggle = document.getElementById('stokta-categories-toggle');
  if (stoktaCats) {
    function renderStoktaKategoriler() {
      // Makine verilerini global scope'tan al
      var makineler = window.makineler || [];
      
      if (makineler.length === 0) {
        // Eğer henüz yüklenmediyse biraz bekle
        setTimeout(renderStoktaKategoriler, 100);
        return;
      }
      
      // Stokta olan makineler
      var stoktaMakineler = makineler.filter(function(m) { return m && m.stok === true; });
      if (stoktaMakineler.length === 0) {
        // Eğer stokta makine yoksa yine de ilk 8 makineyi göster (boş kalmasın)
        stoktaMakineler = makineler.slice(0, 8);
      }
      
      function esc(s) {
        if (s == null || s === undefined) return '';
        var d = document.createElement('div');
        d.textContent = String(s);
        return d.innerHTML;
      }
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
        if (s.charAt(0) === '/') return s;
        var b = base.replace(/\/$/, '');
        return b ? (b + '/' + s.replace(/^\//, '')) : ('/' + s.replace(/^\//, ''));
      }

      function normalize(s) {
        return String(s || '')
          .toLowerCase()
          .replace(/ğ/g, 'g').replace(/ü/g, 'u').replace(/ş/g, 's').replace(/ı/g, 'i').replace(/ö/g, 'o').replace(/ç/g, 'c');
      }

      // Kategori anahtarı: makinenin kendi tip'inden türet (eks. "Ekskavatör" ayrı kategori olur)
      function tipKey(label) {
        var t = normalize(label);
        t = t.replace(/\byeralti\b/g, 'yer alti');
        t = t.replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        return t || 'other';
      }

      function categoryKey(m) {
        if (!m || !m.tip) return 'other';
        return tipKey(m.tip);
      }

      function categoryLabelFromKey(key) {
        // Key -> label çözmek için grup içindeki ilk makinenin tip'ini kullanacağız.
        if (key === 'other') return (J.catOther || 'Diğer');
        return key;
      }

      var groups = {};
      var labelByKey = {};
      var firstByKey = {};
      stoktaMakineler.forEach(function(m) {
        var k = categoryKey(m);
        if (!groups[k]) groups[k] = [];
        groups[k].push(m);
        if (!firstByKey[k]) firstByKey[k] = m;
        if (!labelByKey[k]) {
          if (k === 'other') labelByKey[k] = (J.catOther || 'Diğer');
          else labelByKey[k] = String(m.tip || categoryLabelFromKey(k));
        }
      });

      /* Kategori görseli: bu kategorideki makineleri ID sırasıyla dene; görsel, katalog kartıyla aynı kaynaktan
         (gravisaResolveMachineImage = kendi img veya sitedeki havuz yedeği). Sadece JSON’daki img’ye bakmak yetmez. */
      function categoryCardImgSrc(k) {
        // Admin'de manuel seçilmiş kategori görseli varsa onu kullan
        try {
          var map = window.__categoryImages || {};
          if (map && map[k]) {
            var u0 = safeImg(String(map[k]));
            if (u0) return u0;
          }
        } catch (e) {}
        var group = (groups[k] || []).slice().sort(function(a, b) {
          return (parseInt(a && a.id, 10) || 0) - (parseInt(b && b.id, 10) || 0);
        });
        var resolveImg = (typeof window.gravisaResolveMachineImage === 'function')
          ? window.gravisaResolveMachineImage
          : null;
        var i;
        for (i = 0; i < group.length; i++) {
          var m = group[i];
          if (!m) continue;
          var u = '';
          if (resolveImg) {
            u = resolveImg(m) || '';
          } else if (m.img && String(m.img).trim() !== '') {
            u = safeImg(m.img, m.img_mtime) || '';
          }
          if (u) return u;
        }
        return '';
      }
      var available = Object.keys(groups).filter(function(k) { return (groups[k] || []).length > 0; });
      // Önce en çok ürün olan kategoriler; aynı sayıda ise Türkçe alfabetik
      available.sort(function(a, b) {
        var ca = (groups[a] || []).length;
        var cb = (groups[b] || []).length;
        if (cb !== ca) return cb - ca;
        return String(labelByKey[a] || a).localeCompare(String(labelByKey[b] || b), 'tr');
      });

      // İlk ekranda her şeyi göstermek yerine kısalt (toggle ile tamamı açılır)
      var isExpanded = stoktaCats.getAttribute('data-expanded') === '1';
      function calcLimit() {
        var w = window.innerWidth || 1024;
        if (w <= 480) return 4;
        if (w <= 900) return 6;
        return 8;
      }
      var limit = calcLimit();
      var listToRender = isExpanded ? available : available.slice(0, limit);

      stoktaCats.innerHTML = '';

      listToRender.forEach(function(k) {
        var count = (groups[k] || []).length;
        var imgSrc = categoryCardImgSrc(k);
        var label = labelByKey[k] || categoryLabelFromKey(k);
        var href = addQuery(langPath('makineler'), 'cat', k);
        var catImgHtml = imgSrc
          ? '<div class="machine-card-image"><img src="' + esc(imgSrc) + '" alt="' + esc(label) + '" loading="lazy" /></div>'
          : '<div class="machine-card-image machine-card-image--empty" role="img" aria-label="' + esc(J.noPhoto || '') + '"><span>' + esc(J.noPhoto || '') + '</span></div>';

        var card = document.createElement('article');
        card.className = 'machine-card category-machine-card';
        card.innerHTML =
          catImgHtml +
          '<div class="machine-card-body">' +
            '<div class="machine-card-badges">' +
              '<span class="machine-card-badge">' + esc(label) + '</span>' +
              '<span class="machine-card-badge machine-card-badge--stock">' + esc(J.stockIn || 'Stokta') + '</span>' +
            '</div>' +
            '<h3 class="machine-card-title">' + esc(label) + '</h3>' +
            '<p class="machine-card-meta">' + esc(String(count)) + ' ' + esc(J.machineLabel || 'makine') + '</p>' +
            '<div class="machine-card-actions" style="display:grid;grid-template-columns:1fr;gap:10px">' +
              '<a href="' + esc(href) + '" class="btn btn-primary">' + esc(J.viewCategory || 'Makineleri Gör') + '</a>' +
            '</div>' +
          '</div>';
        stoktaCats.appendChild(card);
      });

      // Toggle görünürlüğü + metni
      if (stoktaCatsToggle) {
        var needsToggle = available.length > limit;
        stoktaCatsToggle.style.display = needsToggle ? '' : 'none';
        stoktaCatsToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
        stoktaCatsToggle.classList.toggle('category-toggle-sticky', !!(needsToggle && isExpanded));
        if (document.body) document.body.classList.toggle('has-fixed-category-toggle', !!(needsToggle && isExpanded));
        stoktaCatsToggle.textContent = isExpanded
          ? (J.showLessCategories || 'Daha az göster')
          : (J.showAllCategories || 'Tüm kategorileri gör');
      }
    }
    
    // Sayfa yüklendiğinde başlat
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function() {
        // app-makineler.js yüklenmesini bekle
        setTimeout(renderStoktaKategoriler, 200);
      });
    } else {
      setTimeout(renderStoktaKategoriler, 200);
    }

    window.addEventListener('gravisa-machines-loaded', function() {
      renderStoktaKategoriler();
    });

    if (stoktaCatsToggle) {
      stoktaCatsToggle.addEventListener('click', function() {
        var isExpanded = stoktaCats.getAttribute('data-expanded') === '1';
        stoktaCats.setAttribute('data-expanded', isExpanded ? '0' : '1');
        renderStoktaKategoriler();
      });
      window.addEventListener('resize', function() {
        // limit değişebilir, yeniden çiz
        renderStoktaKategoriler();
      });
    }
  }

  // Özel dropdown: İlgilendiğiniz Makine (açılan liste sivri köşeli)
  var machineWrap = document.getElementById('machine-select-wrap');
  if (machineWrap) {
    var trigger = document.getElementById('machine-select-trigger');
    var input = document.getElementById('machine-select-input');
    var list = document.getElementById('machine-select-list');
    var options = list ? list.querySelectorAll('.custom-select-option') : [];

    function updateTrigger(text, value) {
      if (trigger) trigger.textContent = text || (J.select || 'Seçiniz');
      if (input) input.value = value || '';
      if (input) input.setAttribute('data-value', value || '');
      options.forEach(function (opt) {
        opt.classList.toggle('is-selected', (opt.getAttribute('data-value') || '') === (value || ''));
      });
    }

    function close() {
      machineWrap.classList.remove('is-open');
      if (trigger) trigger.setAttribute('aria-expanded', 'false');
    }

    if (trigger && list) {
      trigger.addEventListener('click', function (e) {
        e.preventDefault();
        var isOpen = machineWrap.classList.toggle('is-open');
        trigger.setAttribute('aria-expanded', isOpen);
      });
    }
    options.forEach(function (opt) {
      opt.addEventListener('click', function (e) {
        e.preventDefault();
        var val = opt.getAttribute('data-value');
        var text = opt.textContent.trim();
        updateTrigger(text, val);
        close();
      });
    });
    document.addEventListener('click', function (e) {
      if (machineWrap && machineWrap.contains(e.target)) return;
      close();
    });
  }

  // Demo form
  var demoForm = document.getElementById('demo-form');
  if (demoForm) {
    demoForm.addEventListener('reset', function () {
      var wrap = document.getElementById('machine-select-wrap');
      var trig = document.getElementById('machine-select-trigger');
      var inp = document.getElementById('machine-select-input');
      var listEl = document.getElementById('machine-select-list');
      if (wrap && trig && inp && listEl) {
        trig.textContent = J.select || 'Seçiniz';
        inp.value = '';
        listEl.querySelectorAll('.custom-select-option').forEach(function (opt) {
          opt.classList.toggle('is-selected', (opt.getAttribute('data-value') || '') === '');
        });
      }
    });
    demoForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var machineInput = document.getElementById('machine-select-input');
      if (machineInput && !machineInput.value && machineInput.required) {
        var wrap = document.getElementById('machine-select-wrap');
        if (wrap) wrap.classList.add('is-open');
        return;
      }
      var btn = demoForm.querySelector('button[type="submit"]');
      if (btn) { btn.disabled = true; btn.textContent = J.sending || 'Gönderiliyor...'; }
      if (typeof window.submitFormToAPI === 'function') {
        window.submitFormToAPI(demoForm, base + '/api/demo.php')
          .then(function (msg) { if (typeof window.showToast === 'function') window.showToast(msg, true); else alert(msg); demoForm.reset(); })
          .catch(function (err) { if (typeof window.showToast === 'function') window.showToast(err, false); else alert(err); })
          .finally(function () { if (btn) { btn.disabled = false; btn.textContent = J.demoSubmit || 'Demo Talebi Gönder'; } });
      } else {
        if (typeof window.showToast === 'function') window.showToast('Demo talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.', true); else alert('Demo talebiniz alındı.');
        demoForm.reset();
        if (btn) { btn.disabled = false; btn.textContent = J.demoSubmit || 'Demo Talebi Gönder'; }
      }
    });
  }
})();
