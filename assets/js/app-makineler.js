(function () {
  'use strict';

  // Makineler API'den yüklenir (api/makineler.php -> data/makineler_admin.json)
  window.makineler = [];

  var grid = document.getElementById('makineler-grid');
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

  function escapeHtml(s) {
    if (s == null || s === undefined) return '';
    var str = String(s);
    var div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  function safeImgSrc(src) {
    if (!src || typeof src !== 'string') return '';
    var t = src.trim().toLowerCase();
    if (t.indexOf('javascript:') === 0 || t.indexOf('data:') === 0 || t.indexOf('vbscript:') === 0) return '';
    return src;
  }

  function loadMachinesFromAPI() {
    return fetch('api/makineler.php')
      .then(function(r) { return r.json(); })
      .then(function(res) {
        if (!res.success || !Array.isArray(res.items)) return;
        window.makineler = res.items;
        filteredMakineler = window.makineler;
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
        populateFilters();
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
    var searchTerm = (searchInput.value || '').toLowerCase();
    var tipFilter = filterTip.value;
    var firmaFilter = filterFirma.value;
    var gucFilter = filterGuc.value;
    var modelYilFilter = filterModelYil.value;

    filteredMakineler = window.makineler.filter(function(m) {
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
  }

  function renderResults() {
    if (!grid) return;

    grid.innerHTML = '';
    noResults.style.display = filteredMakineler.length === 0 ? 'block' : 'none';

    if (resultsInfo) {
      resultsInfo.textContent = filteredMakineler.length + ' makine bulundu';
    }

    filteredMakineler.forEach(function(m) {
      grid.appendChild(renderCard(m));
    });
  }

  function renderCard(m) {
    var article = document.createElement('article');
    article.className = 'machine-card';
    var imgSrc = safeImgSrc(m.img);
    article.innerHTML =
      '<div class="machine-card-image"><img src="' + escapeHtml(imgSrc) + '" alt="' + escapeHtml(m.tipModel) + '" /></div>' +
      '<div class="machine-card-body">' +
        '<div class="machine-card-badge">' + escapeHtml(m.tip) + '</div>' +
        '<h3 class="machine-card-title">' + escapeHtml(m.firma) + ' ' + escapeHtml(m.tipModel) + '</h3>' +
        '<p class="machine-card-meta">Model: ' + escapeHtml(m.modelYil) + ' &bull; Güç: ' + escapeHtml(m.guc) + ' ' + escapeHtml(m.gucBirim) + '</p>' +
        '<p class="machine-card-spec">' + escapeHtml(m.kapasite) + '</p>' +
        '<div class="machine-card-actions">' +
          '<a href="makine-detay?id=' + escapeHtml(m.id) + '" class="btn btn-outline">Detay</a>' +
          '<a href="satis-teklifi?id=' + escapeHtml(m.id) + '" class="btn btn-primary">Teklif Al</a>' +
          '<a href="kiralama?id=' + escapeHtml(m.id) + '" class="btn btn-secondary">Kirala</a>' +
        '</div>' +
      '</div>';
    return article;
  }

  function renderDetay(m) {
    return (
      '<div class="machine-detail-image"><img src="' + m.img + '" alt="' + m.tipModel + '" /></div>' +
      '<div>' +
        '<div class="machine-detail-badge">' + m.tip + '</div>' +
        '<h2 style="margin:0 0 8px; font-size:1.75rem;">' + m.firma + ' ' + m.tipModel + '</h2>' +
        '<p style="color: var(--color-text-muted); margin-bottom: 24px;">Model Yılı: ' + m.modelYil + '</p>' +
        '<ul class="machine-detail-specs">' +
          '<li><span>Tip</span><span>' + m.tip + '</span></li>' +
          '<li><span>Firma</span><span>' + m.firma + '</span></li>' +
          '<li><span>Tip / Model</span><span>' + m.tipModel + '</span></li>' +
          '<li><span>Model Yılı</span><span>' + m.modelYil + '</span></li>' +
          '<li><span>Güç</span><span>' + m.guc + ' ' + m.gucBirim + '</span></li>' +
          '<li><span>Kapasite</span><span>' + m.kapasite + '</span></li>' +
          '<li><span>Şasi Seri No</span><span>' + m.saseSeriNo + '</span></li>' +
          '<li><span>Motor Seri No</span><span>' + m.motorSeriNo + '</span></li>' +
          '<li><span>Motor Marka</span><span>' + m.motorMarka + '</span></li>' +
          '<li><span>Motor Tip</span><span>' + m.motorTip + '</span></li>' +
          '<li><span>Stok Durumu</span><span>' + (m.stok ? 'Stokta' : 'Talebe göre') + '</span></li>' +
        '</ul>' +
        '<div class="machine-detail-actions">' +
          '<a href="satis-teklifi?model=' + encodeURIComponent(m.firma + ' ' + m.tipModel) + '" class="btn btn-primary">Satış Teklifi Al</a>' +
          '<a href="kiralama?model=' + encodeURIComponent(m.firma + ' ' + m.tipModel) + '" class="btn btn-secondary">Kiralama Yap</a>' +
          '<a href="index#demo" class="btn btn-outline">Demo Talebi</a>' +
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
      searchInput.value = '';
      filterTip.value = '';
      filterFirma.value = '';
      filterGuc.value = '';
      filterModelYil.value = '';
      filterMakineler();
    });
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
    populateFilters();
    renderResults();
  });
})();
