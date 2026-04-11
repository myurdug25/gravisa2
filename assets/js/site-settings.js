/**
 * Site ayarlarını sayfadaki [data-site] elemanlarına uygular.
 * Önce window.__siteSettings (PHP'den) kullanır, yoksa api/settings.php'den çeker.
 * Admin panelden yapılan iletişim maili, WhatsApp, telefon, adres güncellemeleri tüm sayfalara yansır.
 */
(function () {
  function applySettings(settings) {
    if (!settings) return;
    var list = document.querySelectorAll('[data-site]');
    list.forEach(function (el) {
      var key = el.getAttribute('data-site');
      var val = settings[key];
      if (val === undefined || val === null) return;
      var isLink = el.tagName === 'A';
      if (key === 'contact_email') {
        if (isLink) { el.href = 'mailto:' + val; el.textContent = val || el.textContent; }
        else el.textContent = val;
      } else if (key === 'servis_email') {
        if (isLink) { el.href = 'mailto:' + val; el.textContent = val || el.textContent; }
        else el.textContent = val;
      } else if (key === 'contact_phone') {
        var num = (settings.whatsapp_number || '').replace(/\D/g, '');
        if (num.indexOf('9') !== 0 && num.length >= 10) num = '9' + num;
        var displayPhone = settings.phone_display || '';
        if (isLink) { el.href = 'tel:+' + (num || '905551234567'); el.textContent = displayPhone || el.textContent; }
      } else if (key === 'phone_display') {
        el.textContent = settings.phone_display || val || '';
      } else if (key === 'whatsapp') {
        var wa = (settings.whatsapp_number || '').replace(/\D/g, '');
        if (wa.indexOf('9') !== 0 && wa.length >= 10) wa = '9' + wa;
        if (isLink && wa) {
          var lang = (typeof window.GRAVISA_LANG === 'string' ? window.GRAVISA_LANG : 'tr');
          var adminTr = (settings.whatsapp_prefill_tr || '').trim();
          var adminEn = (settings.whatsapp_prefill_en || '').trim();
          var pre = '';
          if (lang === 'en' && adminEn) pre = adminEn;
          else if (lang !== 'en' && adminTr) pre = adminTr;
          if (!pre && typeof window.__GRAVISA_WA_PREFILL === 'string' && window.__GRAVISA_WA_PREFILL.trim()) {
            pre = window.__GRAVISA_WA_PREFILL.trim();
          }
          if (!pre) pre = 'Merhaba, Gravisa ekibiyiz. Size nasıl yardımcı olabiliriz?';
          el.href = 'https://wa.me/' + wa + '?text=' + encodeURIComponent(pre);
        }
      } else if (key === 'address') {
        var safeAddr = (val + '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        el.innerHTML = safeAddr.replace(/\n/g, '<br>');
      }
    });
  }
  if (window.__siteSettings) {
    applySettings(window.__siteSettings);
  }
  // Her zaman API'den güncel veriyi çek (basePath ile local/production uyumlu)
  var base = (typeof window.basePath === 'string') ? window.basePath : '';
  var apiUrl = (window.location.origin || (window.location.protocol + '//' + window.location.host)) + base + '/api/settings.php?t=' + Date.now();
  fetch(apiUrl)
    .then(function (r) { return r.json(); })
    .then(applySettings)
    .catch(function () {});
})();
