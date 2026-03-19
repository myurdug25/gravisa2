# Gravisa

İş makineleri satış ve kiralama web sitesi.

## Kurulum

1. Repoyu klonlayın veya ZIP indirin
2. `config/.env.example` dosyasını `config/.env` olarak kopyalayın
3. `.env` içinde `APP_URL`, `ADMIN_PASS`, `MAIL_*` değerlerini girin
4. Detaylı kurulum: **DEPLOY.txt**

## Gereksinimler

- PHP 7.4+
- Apache (mod_rewrite)
- MySQL (opsiyonel, JSON modu varsayılan)

## Local geliştirme (XAMPP)

1. Projeyi `htdocs/gravisa/` içine koyun
2. `.htaccess` içinde `RewriteBase /gravisa/` yapın
3. `http://localhost/gravisa/` adresinden test edin

## Yapı

- `index.php` – Ana sayfa
- `admin/` – Yönetim paneli
- `api/` – Form ve veri API’leri
- `data/` – JSON veriler (makineler, ayarlar, talepler)
- `images/` – Logo, saha fotoğrafları
- `assets/` – CSS, JS, hero görselleri
