(function () {
  'use strict';

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

  // Mobil: Kurumsal dropdown – tıklanınca aç/kapa (sayfaya gitme)
  var navDropdown = document.querySelector('.nav-dropdown');
  if (navDropdown) {
    var dropdownLink = navDropdown.querySelector('a');
    if (dropdownLink) {
      dropdownLink.addEventListener('click', function (e) {
        if (window.innerWidth <= 768) {
          e.preventDefault();
          navDropdown.classList.toggle('is-open');
          dropdownLink.setAttribute('aria-expanded', navDropdown.classList.contains('is-open'));
        }
      });
    }
  }

  // Hero görsel slider
  var heroBg = document.querySelector('.hero-bg');
  if (heroBg) {
    var heroImages = [
      '/assets/hero-1.png',
      '/assets/machine-2.png',
      '/assets/machine-3.png',
      '/assets/machine-4.png',
      '/assets/machine-5.png',
      '/assets/machine-6.png'
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

  // Stokta makineler (ana sayfa)
  var stoktaGrid = document.getElementById('stokta-grid');
  if (stoktaGrid) {
    function renderStoktaMakineler() {
      // Makine verilerini global scope'tan al
      var makineler = window.makineler || [];
      
      if (makineler.length === 0) {
        // Eğer henüz yüklenmediyse biraz bekle
        setTimeout(renderStoktaMakineler, 100);
        return;
      }
      
      // Stokta olan ilk 4 makineyi göster
      var stoktaMakineler = makineler.filter(function(m) { return m.stok === true; }).slice(0, 4);
      
      if (stoktaMakineler.length === 0) {
        // Eğer stokta makine yoksa ilk 4 makineyi göster
        stoktaMakineler = makineler.slice(0, 4);
      }
      
      function esc(s) {
        if (s == null || s === undefined) return '';
        var d = document.createElement('div');
        d.textContent = String(s);
        return d.innerHTML;
      }
      function safeImg(src) {
        if (!src || typeof src !== 'string') return '';
        var t = src.trim().toLowerCase();
        if (t.indexOf('javascript:') === 0 || t.indexOf('data:') === 0 || t.indexOf('vbscript:') === 0) return '';
        return (src.charAt(0) === '/' ? '' : '/') + src;
      }
      stoktaGrid.innerHTML = ''; // Önce temizle
      
      stoktaMakineler.forEach(function (m) {
        var card = document.createElement('article');
        card.className = 'machine-card';
        var metaText = '';
        if (m.modelYil) metaText += 'Model: ' + m.modelYil;
        if (m.guc) {
          if (metaText) metaText += ' • ';
          metaText += 'Güç: ' + m.guc + ' ' + m.gucBirim;
        }
        var imgSrc = safeImg(m.img);
        card.innerHTML =
          '<div class="machine-card-image"><img src="' + esc(imgSrc) + '" alt="' + esc(m.tipModel) + '" /></div>' +
          '<div class="machine-card-body">' +
            '<div class="machine-card-badge">' + esc(m.tip) + '</div>' +
            '<h3 class="machine-card-title">' + esc(m.firma) + ' ' + esc(m.tipModel) + '</h3>' +
            '<p class="machine-card-meta">' + esc(metaText || m.kapasite || '') + '</p>' +
            '<p class="machine-card-spec">' + esc(m.kapasite || '') + '</p>' +
            '<div class="machine-card-actions">' +
              '<a href="makine-detay?id=' + esc(m.id) + '" class="btn btn-outline">Detay</a>' +
              '<a href="satis-teklifi?id=' + esc(m.id) + '" class="btn btn-primary">Teklif Al</a>' +
              '<a href="kiralama?id=' + esc(m.id) + '" class="btn btn-secondary">Kirala</a>' +
            '</div>' +
          '</div>';
        stoktaGrid.appendChild(card);
      });
    }
    
    // Sayfa yüklendiğinde başlat
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function() {
        // app-makineler.js yüklenmesini bekle
        setTimeout(renderStoktaMakineler, 200);
      });
    } else {
      setTimeout(renderStoktaMakineler, 200);
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
      if (trigger) trigger.textContent = text || 'Seçiniz';
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
        trig.textContent = 'Seçiniz';
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
      if (btn) { btn.disabled = true; btn.textContent = 'Gönderiliyor...'; }
      if (typeof window.submitFormToAPI === 'function') {
        window.submitFormToAPI(demoForm, '/api/demo.php')
          .then(function (msg) { if (typeof window.showToast === 'function') window.showToast(msg, true); else alert(msg); demoForm.reset(); })
          .catch(function (err) { if (typeof window.showToast === 'function') window.showToast(err, false); else alert(err); })
          .finally(function () { if (btn) { btn.disabled = false; btn.textContent = 'Demo Talebi Gönder'; } });
      } else {
        if (typeof window.showToast === 'function') window.showToast('Demo talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.', true); else alert('Demo talebiniz alındı.');
        demoForm.reset();
        if (btn) { btn.disabled = false; btn.textContent = 'Demo Talebi Gönder'; }
      }
    });
  }
})();
