-- Gravisa - XAMPP MySQL veritabanı
-- phpMyAdmin'de bu dosyayı import edin veya SQL sekmesinde çalıştırın

CREATE DATABASE IF NOT EXISTS gravisa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gravisa;

-- Tüm form talepleri tek tabloda (tip: kiralama, demo, iletisim, satis)
CREATE TABLE IF NOT EXISTS talepler (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tip VARCHAR(20) NOT NULL,
  veri JSON NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_tip (tip),
  INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
