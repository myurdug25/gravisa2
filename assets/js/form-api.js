/**
 * Form API - PHP backend'e talep gönderimi
 * Kiralama, Demo, İletişim, Satış formları bu modülü kullanır
 */
(function () {
  'use strict';

  window.showToast = function (message, isSuccess) {
    isSuccess = isSuccess !== false;
    var overlay = document.createElement('div');
    overlay.className = 'toast-overlay';
    overlay.innerHTML = '<div class="toast-box ' + (isSuccess ? 'success' : 'error') + '">' +
      '<span class="toast-icon">' + (isSuccess ? '✓' : '✕') + '</span>' +
      '<h3 class="toast-title">' + (isSuccess ? 'Talebiniz Alındı' : 'Hata') + '</h3>' +
      '<p class="toast-message">' + (message || '') + '</p>' +
      '<button type="button" class="toast-btn">Tamam</button></div>';
    document.body.appendChild(overlay);
    var close = function () {
      overlay.style.opacity = '0';
      overlay.style.transition = 'opacity 0.2s ease';
      setTimeout(function () { overlay.remove(); }, 200);
    };
    overlay.querySelector('.toast-btn').addEventListener('click', close);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });
    setTimeout(close, 5000);
  };

  window.submitFormToAPI = function (formEl, apiPath) {
    return new Promise(function (resolve, reject) {
      var fd = new FormData(formEl);
      var data = {};
      fd.forEach(function (v, k) { data[k] = v; });

      fetch(apiPath, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) {
            resolve(res.message);
          } else {
            reject(res.message || 'Bir hata oluştu.');
          }
        })
        .catch(function (err) {
          reject('Bağlantı hatası. Lütfen internet bağlantınızı kontrol edin veya daha sonra tekrar deneyin.');
        });
    });
  };
})();
