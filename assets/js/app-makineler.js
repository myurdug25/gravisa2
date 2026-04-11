(function () {
  'use strict';
  var base = (typeof window.basePath === 'string') ? window.basePath : '';
  var J = window.__GRAVISA_JS || {};
  function langPath(slug) {
    return typeof window.gravisaLangPath === 'function' ? window.gravisaLangPath(slug) : slug;
  }
  function addQuery(url, key, value) {
    var sep = url.indexOf('?') >= 0 ? '&' : '?';
    return url + sep + encodeURIComponent(key) + '=' + encodeURIComponent(String(value));
  }
  function fmtResults(n) {
    var tpl = J.resultsCount || '%d makine bulundu';
    return String(tpl).replace('%d', String(n));
  }

  // Makineler API'den yüklenir (api/makineler.php -> data/makineler_admin.json)
  window.makineler = [];

  var grid = document.getElementById('makineler-grid');
  var categoriesGrid = document.getElementById('catalog-categories');
  var categoryFilterInput = document.getElementById('category-filter');
  var categoriesToggleBtn = document.getElementById('catalog-categories-toggle');
  var detaySection = document.getElementById('makine-detay');
  var detayIcerik = document.getElementById('makine-detay-icerik');
  var searchInput = document.getElementById('catalog-search');
  var filterTip = document.getElementById('filter-tip');
  var filterFirma = document.getElementById('filter-firma');
  var filterGuc = document.getElementById('filter-guc');
  var filterModelYil = document.getElementById('filter-model-yil');
  var resetFiltersBtn = document.getElementById('reset-filters');
  var resultsInfo = document.getElementById('results-info');
  var noResults = document.getElementById('no-results');

  var filteredMakineler = window.makineler;
  var activeCatKey = '';

  function normalize(s) {
    return String(s || '')
      .toLowerCase()
      .replace(/ğ/g, 'g').replace(/ü/g, 'u').replace(/ş/g, 's').replace(/ı/g, 'i').replace(/ö/g, 'o').replace(/ç/g, 'c');
  }

  function tipKey(label) {
    var t = normalize(label);
    t = t.replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    return t || 'other';
  }

  function categoryKey(m) {
    if (!m || !m.tip) return 'other';
    return tipKey(m.tip);
  }

  function categoryLabelFromKey(key) {
    if (key === 'other') return (J.catOther || 'Diğer');
    return key;
  }

  function categoryIcon(key) {
    if (key === 'other') return '📦';
    return '🏷️';
  }

  function getCatFromQuery() {
    var params = new URLSearchParams(window.location.search);
    var c = params.get('cat');
    return (c && typeof c === 'string') ? c : '';
  }

  function escapeHtml(s) {
    if (s == null || s === undefined) return '';
    var str = String(s);
    var div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  function safeImgSrc(src) {
    if (typeof window.gravisaAssetUrl === 'function') {
      return window.gravisaAssetUrl(src);
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

  function loadMachinesFromAPI() {
    var apiBase = (typeof window.gravisaEffectiveBasePath === 'function') ? window.gravisaEffectiveBasePath() : base;
    return fetch(apiBase + '/api/makineler.php')
      .then(function(r) { return r.json(); })
      .then(function(res) {
        if (!res.success || !Array.isArray(res.items)) {
          try {
            window.dispatchEvent(new CustomEvent('gravisa-machines-loaded'));
          } catch (e) {}
          return;
        }
        window.makineler = res.items;
        filteredMakineler = window.makineler;
        try {
          window.dispatchEvent(new CustomEvent('gravisa-machines-loaded'));
        } catch (e) {}
        // Filtreleri yeniden oluştur
        if (filterTip) {
          filterTip.innerHTML = '<option value=\"\">Tümü</option>';
        }
        if (filterFirma) {
          filterFirma.innerHTML = '<option value=\"\">Tümü</option>';
        }
        if (filterModelYil) {
          filterModelYil.innerHTML = '<option value=\"\">Tümü</option>';
        }
        if (filterTip && filterFirma && filterModelYil) populateFilters();
        renderResults();
      })
      .catch(function() {
        // sessiz geç
      });
  }

  function getQueryId() {
    var params = new URLSearchParams(window.location.search);
    return params.get('id') ? parseInt(params.get('id'), 10) : null;
  }

  function populateFilters() {
    if (!filterTip || !filterFirma || !filterModelYil) return;
    var tipler = [...new Set(window.makineler.map(function(m) { return m.tip; }))].sort();
    var firmalar = [...new Set(window.makineler.map(function(m) { return m.firma; }))].sort();
    var modelYillari = [...new Set(window.makineler.map(function(m) { return m.modelYil; }))].sort(function(a, b) { return b - a; });

    tipler.forEach(function(tip) {
      var opt = document.createElement('option');
      opt.value = tip;
      opt.textContent = tip;
      filterTip.appendChild(opt);
    });

    firmalar.forEach(function(firma) {
      var opt = document.createElement('option');
      opt.value = firma;
      opt.textContent = firma;
      filterFirma.appendChild(opt);
    });

    modelYillari.forEach(function(yil) {
      var opt = document.createElement('option');
      opt.value = yil;
      opt.textContent = yil;
      filterModelYil.appendChild(opt);
    });
  }

  function filterMakineler() {
    var searchTerm = searchInput ? (searchInput.value || '').toLowerCase() : '';
    var tipFilter = filterTip ? filterTip.value : '';
    var firmaFilter = filterFirma ? filterFirma.value : '';
    var gucFilter = filterGuc ? filterGuc.value : '';
    var modelYilFilter = filterModelYil ? filterModelYil.value : '';

    // Tip seçilmişse (dropdown) kategori seçim gibi davran (kullanıcı “kategori” seçtiğini düşünüyor)
    if (!activeCatKey && tipFilter) {
      activeCatKey = tipKey(tipFilter);
    }

    filteredMakineler = window.makineler.filter(function(m) {
      if (activeCatKey) {
        if (categoryKey(m) !== activeCatKey) return false;
      }
      var matchSearch = !searchTerm || 
        (m.firma || '').toLowerCase().includes(searchTerm) ||
        (m.tipModel || '').toLowerCase().includes(searchTerm) ||
        (m.tip || '').toLowerCase().includes(searchTerm) ||
        (m.motorTip || '').toLowerCase().includes(searchTerm);

      var matchTip = !tipFilter || m.tip === tipFilter;
      var matchFirma = !firmaFilter || m.firma === firmaFilter;
      var matchModelYil = !modelYilFilter || m.modelYil === modelYilFilter;

      var matchGuc = true;
      if (gucFilter) {
        var gucNum = parseInt(m.guc, 10);
        if (gucFilter === '0-50') matchGuc = gucNum >= 0 && gucNum <= 50;
        else if (gucFilter === '50-100') matchGuc = gucNum > 50 && gucNum <= 100;
        else if (gucFilter === '100-150') matchGuc = gucNum > 100 && gucNum <= 150;
        else if (gucFilter === '150+') matchGuc = gucNum > 150;
      }

      return matchSearch && matchTip && matchFirma && matchModelYil && matchGuc;
    });

    renderResults();
    closeFiltersOnMobileIfOpen();
  }

  function renderResults() {
    if (!grid) return;

    grid.innerHTML = '';
    var searchTerm = searchInput ? (searchInput.value || '').trim() : '';
    var tipFilter = filterTip ? (filterTip.value || '') : '';
    var firmaFilter = filterFirma ? (filterFirma.value || '') : '';
    var gucFilter = filterGuc ? (filterGuc.value || '') : '';
    var modelYilFilter = filterModelYil ? (filterModelYil.value || '') : '';
    var hasAnyFilter = !!(activeCatKey || searchTerm || tipFilter || firmaFilter || gucFilter || modelYilFilter);

    if (resultsInfo) {
      resultsInfo.textContent = hasAnyFilter ? fmtResults(filteredMakineler.length) : (J.pickCategory || '');
    }

    if (!hasAnyFilter) {
      if (noResults) noResults.style.display = 'none';
      return;
    }

    if (noResults) {
      noResults.style.display = filteredMakineler.length === 0 ? 'block' : 'none';
    }

    filteredMakineler.forEach(function(m) {
      grid.appendChild(renderCard(m));
    });
  }

  function renderCategoryCards() {
    if (!categoriesGrid) return;
    categoriesGrid.innerHTML = '';
    var groups = {};
    var labelByKey = {};
    window.makineler.forEach(function(m) {
      var k = categoryKey(m);
      if (!groups[k]) groups[k] = [];
      groups[k].push(m);
      if (!labelByKey[k]) {
        labelByKey[k] = (k === 'other') ? (J.catOther || 'Diğer') : String(m.tip || categoryLabelFromKey(k));
      }
    });
    var available = Object.keys(groups).filter(function(k) { return (groups[k] || []).length > 0; });
    available.sort(function(a, b) {
      if (a === 'other' && b !== 'other') return 1;
      if (b === 'other' && a !== 'other') return -1;
      return String(labelByKey[a] || a).localeCompare(String(labelByKey[b] || b), 'tr');
    });

    // Kategori araması uygula
    var q = categoryFilterInput ? normalize(categoryFilterInput.value || '') : '';
    var filteredKeys = available.filter(function(k) {
      var lbl = normalize(labelByKey[k] || categoryLabelFromKey(k));
      return !q || lbl.indexOf(q) >= 0;
    });

    // İlk ekranda tümünü göstermeyelim: toggle ile açılır
    var isExpanded = categoriesGrid.getAttribute('data-expanded') === '1';
    function calcLimit() {
      var w = window.innerWidth || 1024;
      if (w <= 480) return 6;
      if (w <= 900) return 10;
      return 16;
    }
    var limit = calcLimit();
    var keysToRender = isExpanded ? filteredKeys : filteredKeys.slice(0, limit);

    keysToRender.forEach(function(k) {
      var a = document.createElement('button');
      a.type = 'button';
      a.className = 'category-card';
      a.setAttribute('data-label', String(labelByKey[k] || categoryLabelFromKey(k)));
      a.innerHTML =
        '<div class="category-card__icon" aria-hidden="true">' + escapeHtml(categoryIcon(k)) + '</div>' +
        '<div class="category-card__body">' +
          '<div class="category-card__title">' + escapeHtml(labelByKey[k] || categoryLabelFromKey(k)) + '</div>' +
          '<div class="category-card__meta">' + escapeHtml(String((groups[k] || []).length)) + ' ' + escapeHtml(J.machineLabel || 'makine') + '</div>' +
        '</div>' +
        '<div class="category-card__chev" aria-hidden="true">→</div>';
      a.addEventListener('click', function() {
        activeCatKey = k;
        if (categoriesGrid) {
          Array.prototype.forEach.call(categoriesGrid.querySelectorAll('.category-card'), function(btn) {
            btn.classList.toggle('is-active', btn === a);
          });
        }
        filterMakineler();
        var el = document.getElementById('makineler-grid');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
      categoriesGrid.appendChild(a);
    });

    if (categoriesToggleBtn) {
      var needsToggle = filteredKeys.length > limit;
      categoriesToggleBtn.style.display = needsToggle ? '' : 'none';
      categoriesToggleBtn.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
      categoriesToggleBtn.classList.toggle('category-toggle-sticky', !!(needsToggle && isExpanded));
      if (document.body) document.body.classList.toggle('has-fixed-category-toggle', !!(needsToggle && isExpanded));
      categoriesToggleBtn.textContent = isExpanded
        ? (J.showLessCategories || 'Daha az göster')
        : (J.showAllCategories || 'Tüm kategorileri gör');
    }
  }

  function rerenderCategories() {
    renderCategoryCards();
  }

  function renderCard(m) {
    var article = document.createElement('article');
    article.className = 'machine-card';
    var imgSrc = safeImgSrc(m.img);
    var imgHtml = imgSrc
      ? '<div class="machine-card-image"><img src="' + escapeHtml(imgSrc) + '" alt="' + escapeHtml(m.tipModel) + '" loading="lazy" /></div>'
      : '<div class="machine-card-image machine-card-image--empty" role="img" aria-label="' + escapeHtml(J.noPhoto || '') + '"><span>' + escapeHtml(J.noPhoto || '') + '</span></div>';
    article.innerHTML =
      imgHtml +
      '<div class="machine-card-body">' +
        '<div class="machine-card-badges">' +
          '<span class="machine-card-badge">' + escapeHtml(m.tip) + '</span>' +
          (m.stok ? '<span class="machine-card-badge machine-card-badge--stock">' + escapeHtml(J.stockIn || 'Stokta') + '</span>' : '<span class="machine-card-badge">' + escapeHtml(J.stockOrder || 'Talebe göre') + '</span>') +
        '</div>' +
        '<h3 class="machine-card-title">' + escapeHtml(m.firma) + ' ' + escapeHtml(m.tipModel) + '</h3>' +
        '<p class="machine-card-meta">' + escapeHtml(J.model || 'Model') + ': ' + escapeHtml(m.modelYil) + ' &bull; ' + escapeHtml(J.power || 'Güç') + ': ' + escapeHtml(m.guc) + ' ' + escapeHtml(m.gucBirim) + '</p>' +
        '<p class="machine-card-spec">' + escapeHtml(m.kapasite) + '</p>' +
        '<div class="machine-card-actions" style="display:grid;grid-template-columns:1fr 1fr;gap:10px">' +
          '<a href="' + escapeHtml(addQuery(langPath('makine-detay'), 'id', m.id)) + '" class="btn btn-outline">' + escapeHtml(J.detail || 'Detay') + '</a>' +
          '<a href="' + escapeHtml(addQuery(langPath('satis-teklifi'), 'id', m.id)) + '" class="btn btn-primary">' + escapeHtml(J.getQuote || 'Teklif Al') + '</a>' +
          '<a href="' + escapeHtml(addQuery(langPath('kiralama'), 'id', m.id)) + '" class="btn btn-secondary" style="grid-column:1 / -1">' + escapeHtml(J.rent || 'Kirala') + '</a>' +
        '</div>' +
      '</div>';
    return article;
  }

  function renderDetay(m) {
    var dImg = safeImgSrc(m.img);
    var dImgBlock = dImg
      ? '<div class="machine-detail-image"><img src="' + escapeHtml(dImg) + '" alt="' + escapeHtml(m.tipModel) + '" /></div>'
      : '<div class="machine-detail-image machine-detail-image--empty"><span>' + escapeHtml(J.noPhoto || '') + '</span></div>';
    return (
      dImgBlock +
      '<div>' +
        '<div class="machine-detail-badge">' + m.tip + '</div>' +
        '<h2 style="margin:0 0 8px; font-size:1.75rem;">' + m.firma + ' ' + m.tipModel + '</h2>' +
        '<p style="color: var(--color-text-muted); margin-bottom: 24px;">' + escapeHtml(J.metaModelYear || 'Model Yılı:') + ' ' + escapeHtml(m.modelYil) + '</p>' +
        '<ul class="machine-detail-specs">' +
          '<li><span>' + escapeHtml(J.labelType || 'Tip') + '</span><span>' + escapeHtml(m.tip) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelBrand || 'Firma') + '</span><span>' + escapeHtml(m.firma) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelTypeModel || 'Tip / Model') + '</span><span>' + escapeHtml(m.tipModel) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelModelYear || 'Model Yılı') + '</span><span>' + escapeHtml(m.modelYil) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelPower || 'Güç') + '</span><span>' + escapeHtml(m.guc) + ' ' + escapeHtml(m.gucBirim) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelCapacity || 'Kapasite') + '</span><span>' + escapeHtml(m.kapasite) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelChassisSn || 'Şasi Seri No') + '</span><span>' + escapeHtml(m.saseSeriNo) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelMotorSn || 'Motor Seri No') + '</span><span>' + escapeHtml(m.motorSeriNo) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelMotorBrand || 'Motor Marka') + '</span><span>' + escapeHtml(m.motorMarka) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelMotorType || 'Motor Tip') + '</span><span>' + escapeHtml(m.motorTip) + '</span></li>' +
          '<li><span>' + escapeHtml(J.labelStock || 'Stok Durumu') + '</span><span>' + escapeHtml(m.stok ? (J.stockIn || 'Stokta') : (J.stockOrder || 'Talebe göre')) + '</span></li>' +
        '</ul>' +
        '<div class="machine-detail-actions">' +
          '<a href="' + escapeHtml(addQuery(langPath('satis-teklifi'), 'model', (m.firma + ' ' + m.tipModel))) + '" class="btn btn-primary">' + escapeHtml(J.btnSalesLarge || 'Satış Teklifi Al') + '</a>' +
          '<a href="' + escapeHtml(addQuery(langPath('kiralama'), 'model', (m.firma + ' ' + m.tipModel))) + '" class="btn btn-secondary">' + escapeHtml(J.btnRentLarge || 'Kiralama Yap') + '</a>' +
          '<a href="' + escapeHtml(langPath('index')) + '#demo' + '" class="btn btn-outline">' + escapeHtml(J.btnDemo || 'Demo Talebi') + '</a>' +
        '</div>' +
      '</div>'
    );
  }

  // Event listeners
  if (searchInput) {
    searchInput.addEventListener('input', filterMakineler);
  }
  if (filterTip) filterTip.addEventListener('change', filterMakineler);
  if (filterFirma) filterFirma.addEventListener('change', filterMakineler);
  if (filterGuc) filterGuc.addEventListener('change', filterMakineler);
  if (filterModelYil) filterModelYil.addEventListener('change', filterMakineler);
  if (resetFiltersBtn) {
    resetFiltersBtn.addEventListener('click', function() {
      if (searchInput) searchInput.value = '';
      if (filterTip) filterTip.value = '';
      if (filterFirma) filterFirma.value = '';
      if (filterGuc) filterGuc.value = '';
      if (filterModelYil) filterModelYil.value = '';
      activeCatKey = '';
      filterMakineler();
    });
  }

  function closeFiltersOnMobileIfOpen() {
    var filtersToggle = document.getElementById('catalog-filters-toggle');
    var catalogSidebar = document.getElementById('catalog-filters');
    if (!filtersToggle || !catalogSidebar) return;
    if (window.matchMedia('(max-width: 768px)').matches && !catalogSidebar.classList.contains('is-collapsed')) {
      catalogSidebar.classList.add('is-collapsed');
      filtersToggle.setAttribute('aria-expanded', 'false');
    }
  }

  // Mobil: Filtreler açılır/kapanır
  var filtersToggle = document.getElementById('catalog-filters-toggle');
  var catalogSidebar = document.getElementById('catalog-filters');
  if (filtersToggle && catalogSidebar) {
    if (window.matchMedia('(max-width: 768px)').matches) {
      catalogSidebar.classList.add('is-collapsed');
      filtersToggle.setAttribute('aria-expanded', 'false');
    }
    filtersToggle.addEventListener('click', function() {
      catalogSidebar.classList.toggle('is-collapsed');
      filtersToggle.setAttribute('aria-expanded', catalogSidebar.classList.contains('is-collapsed') ? 'false' : 'true');
    });
    window.addEventListener('resize', function() {
      if (window.matchMedia('(max-width: 768px)').matches) {
        if (!catalogSidebar.classList.contains('is-collapsed')) {
          filtersToggle.style.display = '';
        }
      } else {
        catalogSidebar.classList.remove('is-collapsed');
        filtersToggle.setAttribute('aria-expanded', 'true');
      }
    });
  }

  // İlk yükleme - API'den makineleri çek, sonra filtreleri doldur ve listele
  loadMachinesFromAPI().then(function() {
    if (filterTip && filterFirma && filterModelYil) populateFilters();
    renderCategoryCards();
    activeCatKey = getCatFromQuery();
    renderResults();
    if (activeCatKey) {
      filterMakineler();
    }
  });

  if (categoryFilterInput) {
    categoryFilterInput.addEventListener('input', function() {
      if (categoriesGrid) categoriesGrid.setAttribute('data-expanded', '0');
      rerenderCategories();
    });
  }

  if (categoriesToggleBtn && categoriesGrid) {
    categoriesToggleBtn.addEventListener('click', function() {
      var isExpanded = categoriesGrid.getAttribute('data-expanded') === '1';
      categoriesGrid.setAttribute('data-expanded', isExpanded ? '0' : '1');
      rerenderCategories();
    });
    window.addEventListener('resize', function() {
      // limit değişebilir
      rerenderCategories();
    });
  }
})();
