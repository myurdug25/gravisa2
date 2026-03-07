# Gravisa - Kurulum ve Yapılandırma

## Gereksinimler

- PHP 7.4+ (random_bytes, hash_equals)
- Apache + mod_rewrite (temiz URL ve .htaccess için)

## Kurulum

1. **Ortam dosyası:** `config/.env.example` dosyasını `config/.env` olarak kopyalayın:
   ```bash
   cp config/.env.example config/.env
   ```
2. **config/.env** içinde şunları düzenleyin:
   - `APP_ENV=production`
   - `APP_DEBUG=0` (canlıda hata ekranda gösterilmesin)
   - `ADMIN_PASS` – güçlü bir şifre
   - `MAIL_TO`, `MAIL_FROM` – e-posta adresleri
   - İsteğe bağlı: `APP_URL` (örn. `https://site.com` veya `https://site.com/gravisa`)

3. **RewriteBase:** Site kök dizindeyse (örn. `https://site.com/`) `.htaccess` içinde `RewriteBase /` yapın. Alt dizindeyse (örn. `https://site.com/gravisa/`) `RewriteBase /gravisa/` kalsın.

## URL’ler (temiz, .php yok)

Tarayıcıda adresler `.php` olmadan açılır; Apache içten ilgili `.php` dosyasına yönlendirir.

| Sayfa        | URL (örnek)        |
|-------------|---------------------|
| Ana sayfa   | `/` veya `/index`   |
| İletişim    | `/iletisim`         |
| Makineler   | `/makineler`        |
| Satış teklifi | `/satis-teklifi`  |
| Kiralama    | `/kiralama`         |
| Servis      | `/servis`           |
| Kurumsal    | `/kurumsal`         |
| …           | aynı mantık         |

Admin panel: `/admin/`, `/admin/login.php` (admin için .php kullanılır).

## Güvenlik (production)

- **.env** sadece `config/` içinde; `config/` .htaccess ile dışarıdan erişime kapalı.
- **CSRF:** Admin giriş, ayar kaydetme ve talep cevaplama istekleri token ile doğrulanır.
- **Oturum:** HttpOnly, SameSite=Lax; HTTPS’te Secure cookie.
- **Başlıklar:** X-Content-Type-Options, X-Frame-Options, X-XSS-Protection, Referrer-Policy; production’da HSTS.
- **Hata:** `APP_DEBUG=0` iken ekranda hata gösterilmez, log’a yazılır.

## Admin Panel

- **URL:** `https://siteniz.com/admin/` (veya `.../gravisa/admin/`)
- Giriş bilgileri: `config/.env` içindeki `ADMIN_USER` ve `ADMIN_PASS`.

## Form API

| Form      | Endpoint           |
|----------|---------------------|
| Kiralama | `api/kiralama.php`  |
| Demo     | `api/demo.php`      |
| İletişim | `api/iletisim.php`  |
| Satış    | `api/satis.php`     |

## Yerel test

```bash
cd gravisa
php -S localhost:8000
```

Temiz URL’ler için Apache mod_rewrite gerekir; PHP dahili sunucusunda `/iletisim` yerine `iletisim.php` kullanın.
