/**
 * Site ayarlarını api/settings.php üzerinden alıp sayfadaki [data-site] elemanlarına uygular.
 * Admin panelden yapılan iletişim maili, WhatsApp, telefon, adres güncellemeleri otomatik yansır.
 */
(function () {
  function applySettings(s) {
    if (!s) return;
    var list = document.querySelectorAll('[data-site]');
    list.forEach(function (el) {
      var key = el.getAttribute('data-site');
      var val = s[key];
      if (val === undefined || val === null) return;
      var isLink = el.tagName === 'A';
      if (key === 'contact_email') {
        if (isLink) el.href = 'mailto:' + val;
        else el.textContent = val;
      } else if (key === 'servis_email') {
        if (isLink) el.href = 'mailto:' + val;
        else el.textContent = val;
      } else if (key === 'contact_phone') {
        var num = (s.whatsapp_number || '').replace(/\D/g, '');
        if (num.indexOf('9') !== 0 && num.length >= 10) num = '9' + num;
        if (isLink) el.href = 'tel:+' + (num || '905551234567');
      } else if (key === 'phone_display') {
        el.textContent = s.phone_display || val || '';
      } else if (key === 'whatsapp') {
        var wa = (s.whatsapp_number || '').replace(/\D/g, '');
        if (wa.indexOf('9') !== 0 && wa.length >= 10) wa = '9' + wa;
        if (isLink) el.href = 'https://wa.me/' + (wa || '905551234567');
      } else if (key === 'address') {
        var s = (val + '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        el.innerHTML = s.replace(/\n/g, '<br>');
      }
    });
  }
  fetch('api/settings.php')
    .then(function (r) { return r.json(); })
    .then(applySettings)
    .catch(function () {});
})();
