# Gravisa – Production Deployment Rehberi

## Veri Depolama

**Projede veritabanı yok.** Tüm veriler JSON dosyalarında tutulur:
- `data/makineler_admin.json` – Makine kataloğu
- `data/saha_fotograflari.json` – Saha fotoğrafları
- `data/settings.json` – Site ayarları (iletişim, WhatsApp vb.)
- `data/*.json` – Form talepleri (kiralama, demo, iletisim, satis, servis)

`USE_DB=0` ile JSON modu kullanılır. İleride MySQL kullanmak isterseniz `config/.env` içinde `USE_DB=1` yapıp veritabanı bilgilerini doldurmanız yeterli.

---

## Deploy Öncesi Kontrol Listesi

### 1. config/.env Ayarları

| Değişken | Açıklama | Örnek |
|----------|----------|-------|
| `APP_ENV` | `production` olmalı | `production` |
| `APP_DEBUG` | `0` olmalı (hata ekranda gösterilmez) | `0` |
| `APP_URL` | Site kök URL (https zorunlu) | `https://gravisa.com` veya `https://site.com/gravisa` |
| `ADMIN_PASS` | Güçlü admin şifresi (min. 12 karakter) | — |
| `MAIL_TO` | Form taleplerinin gideceği e-posta | `info@gravisa.com` |
| `MAIL_FROM` | Gönderen adresi | `noreply@gravisa.com` |
| `MAIL_SMTP_*` | SMTP kullanacaksanız doldurun | — |

### 2. .htaccess RewriteBase

- **Site kök dizinde** (örn. `https://gravisa.com/`): `RewriteBase /`
- **Alt dizinde** (örn. `https://site.com/gravisa/`): `RewriteBase /gravisa/`

`.htaccess` dosyasının başındaki `RewriteBase` satırını buna göre güncelleyin.

### 3. Klasör İzinleri

```bash
# data/ yazılabilir olmalı (form kayıtları, ayarlar)
chmod 755 data
chmod 644 data/*.json
```

### 4. Güvenlik

- `config/.env` asla Git'e commit edilmemeli (`.gitignore`'da)
- `config/`, `data/`, `includes/` dizinleri `.htaccess` ile dışarıdan erişime kapalı
- Admin panel: `https://siteniz.com/admin/` – giriş bilgileri `.env`'den okunur

---

## Sunucu Gereksinimleri

- **PHP** 7.4+ (random_bytes, hash_equals, PDO)
- **Apache** + mod_rewrite
- **HTTPS** (production için önerilir; HSTS production'da otomatik eklenir)

---

## Hızlı Deploy

1. Projeyi sunucuya yükleyin (FTP, Git, rsync vb.)
2. `config/.env.example` → `config/.env` kopyalayın
3. `config/.env` içinde production değerlerini girin
4. `data/` klasörünün yazılabilir olduğundan emin olun
5. `.htaccess` içinde `RewriteBase` değerini ayarlayın
6. Tarayıcıda siteyi test edin
7. Admin panelden iletişim bilgilerini güncelleyin

---

## Sorun Giderme

| Sorun | Çözüm |
|-------|-------|
| 500 Internal Server Error | `APP_DEBUG=1` yapıp hata mesajına bakın; genelde `mod_rewrite` kapalı veya `RewriteBase` yanlış |
| Temiz URL çalışmıyor | Apache `mod_rewrite` etkin mi kontrol edin; `AllowOverride All` olmalı |
| Form gönderilmiyor | `data/` yazılabilir mi; PHP `mail()` veya SMTP ayarları doğru mu |
| Admin giriş olmuyor | `ADMIN_USER` ve `ADMIN_PASS` `.env`'de doğru mu |
