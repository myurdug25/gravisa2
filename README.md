# Gravisa – Frontend Web Sitesi

İş makineleri satış ve kiralama odaklı, kriterlere uygun modern frontend.

## Çalıştırma

Tarayıcıda doğrudan açabilirsiniz:

- **Ana sayfa:** `index.html` dosyasını çift tıklayın veya bir tarayıcıda açın.
- Veya yerel sunucu ile: `npx serve .` (Node.js yüklüyse) — ardından http://localhost:3000

## Sayfalar

| Sayfa | Açıklama |
|-------|----------|
| **Ana Sayfa** | Hero, satış/kiralama CTA, stokta makineler, demo talebi formu, servis özeti, kurumsal özet, iletişim |
| **Makineler** | Makine listesi, detay (teknik bilgiler), satış/kiralama/demo butonları |
| **Satış Teklifi** | Firma bilgileri, model, adet, kullanım alanı formu |
| **Kiralama** | Günlük/aylık, operatörlü/operatörsüz, lokasyon formu |
| **Servis** | Servis ağı, mobil servis, yedek parça, garanti bilgileri |
| **Kurumsal** | Hub: Hakkımızda, Vizyon & Misyon, Referanslar, Saha Fotoğrafları’na giden kartlar |
| **Hakkımızda** | Firma geçmişi ve değerler (ayrı sayfa) |
| **Vizyon & Misyon** | Vizyon, misyon ve ilkeler (ayrı sayfa) |
| **Referanslar** | İnşaat, kamu, maden referansları (ayrı sayfa) |
| **Saha Fotoğrafları** | Projelerdeki makineler (ayrı sayfa) |
| **Üyelik** | Giriş yap / Üye ol formları |

## Özellikler

- **Strateji:** Satış ve kiralama teklifi toplama, hızlı aksiyon (butonlar, formlar)
- **Ana sayfa:** Net mesaj, satış/kiralama butonları, hemen ara / e-posta
- **Ürün sayfaları:** Foto placeholder, teknik bilgiler, teklif/kiralama butonları
- **Satış:** Firma, model, adet, kullanım alanı
- **Kiralama:** Günlük/aylık, operatörlü/operatörsüz, lokasyon
- **Servis:** Servis ağı, mobil servis, yedek parça, garanti
- **Kurumsal:** Tarihçe, referanslar, saha görselleri alanı
- **Teknik:** Mobil uyum (responsive), hızlı yükleme, SEO meta
- **Bonus:** Demo makine talebi, WhatsApp sabit buton, stokta makineler bölümü
- **Ekstra:** Üyelik (giriş / kayıt) yapısı

## Not

- Formlar şu an sadece frontend: Gönderince `alert` ile onay verilir; backend bağlandığında API’ye bağlanabilir.
- WhatsApp numarası placeholder: `905551234567` — kendi numaranızla değiştirin.
- Gerçek makine fotoğrafları için `machine-card-image` alanlarına `<img>` ekleyebilirsiniz.
