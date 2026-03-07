/**
 * Form API - PHP backend'e talep gönderimi
 * Kiralama, Demo, İletişim, Satış formları bu modülü kullanır
 */
(function () {
  'use strict';

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
