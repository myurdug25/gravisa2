# Gravisa – Yerel Test (XAMPP)

## 1. Projeyi XAMPP Altına Al

1. **XAMPP** kurulu olsun ([apachefriends.org](https://www.apachefriends.org)).
2. Proje klasörünü **htdocs** içine kopyala veya taşı:
   ```
   C:\xampp\htdocs\gravisa\
   ```
   (İçinde `index.html`, `api/`, `admin/`, `config/` vb. olacak.)

## 2. Apache ve MySQL’i Çalıştır

1. **XAMPP Control Panel**’i aç.
2. **Apache** ve **MySQL** için **Start**’a tıkla (yeşil olacak).

## 3. Veritabanını Oluştur

1. Tarayıcıda aç: **http://localhost/phpmyadmin**
2. Üstten **Import** (İçe Aktar) sekmesine gir.
3. **Dosya Seç** → projedeki **`database/database.sql`** dosyasını seç.
4. **Go** / **Git** butonuna tıkla.
5. Solda **gravisa** veritabanı görünmeli; içinde **talepler** tablosu oluşmuş olacak.

**Alternatif (SQL sekmesi):**  
phpMyAdmin’de **SQL** sekmesine gel, `database/database.sql` dosyasının içeriğini yapıştır, çalıştır.

## 4. Config Ayarları

`config/config.php` dosyasını aç:

- **Veritabanı** kullanılacaksa:
  - `USE_DB` → `true`
  - `DB_HOST` → `localhost`
  - `DB_NAME` → `gravisa`
  - `DB_USER` → `root`
  - `DB_PASS` → `''` (XAMPP’te varsayılan şifre boş)

- **E-posta:**  
  Yerelde `mail()` çoğu zaman çalışmaz; formlar yine de **veritabanına ve JSON’a** kaydedilir.  
  İstersen `MAIL_TO` adresini kendi adresin yap (sunucuda mail açıksa e-posta da gider).

- **Admin:**  
  `ADMIN_USER` / `ADMIN_PASS` istersen değiştir.

## 5. Siteyi Aç

Tarayıcıda:

- Ana site: **http://localhost/gravisa/**
- Admin: **http://localhost/gravisa/admin/**

(Projeyi `htdocs`’un içine `gravisa` adlı klasörle koyduğunu varsayıyoruz; farklı klasör adı kullandıysan URL’deki `gravisa`’yı onunla değiştir.)

## 6. Test Adımları

1. **http://localhost/gravisa/** → Kiralama / Satış / İletişim / Demo formlarından birini doldur, gönder.
2. **http://localhost/gravisa/admin/** → Giriş yap (admin / şifre), ilgili sekmede (Kiralama, Demo, İletişim, Satış) kaydı gör.
3. phpMyAdmin’de **gravisa** → **talepler** tablosuna gir; yeni satırların eklendiğini kontrol et.

## Veritabanı Kullanmadan (Sadece JSON)

DB kurmak istemezsen:

- `config/config.php` içinde **`USE_DB`** değerini **`false`** yap.
- Apache yeterli; MySQL’i açmana gerek yok.
- Talepler sadece **`data/*.json`** dosyalarına yazılır; admin paneli de bu dosyalardan okur.

## Özet

| Ne yapıyorsun?        | Nereye koyuyorsun?        | DB gerekli mi? |
|-----------------------|---------------------------|----------------|
| Yerel test            | `C:\xampp\htdocs\gravisa` | İstersen evet  |
| DB kullanmak          | phpMyAdmin’de import      | `database/database.sql` |
| DB kullanmamak        | Sadece `USE_DB = false`   | Hayır          |

DB kurman şart değil; projeyi XAMPP’in altına alıp Apache’yi başlatman yerel test için yeterli.
