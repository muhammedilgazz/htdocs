-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 14 Tem 2025, 00:12:03
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `butce`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bakiye`
--

CREATE TABLE `bakiye` (
  `id` int(11) NOT NULL,
  `toplam_bakiye` decimal(15,2) DEFAULT 0.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `bakiye`
--

INSERT INTO `bakiye` (`id`, `toplam_bakiye`, `updated_at`) VALUES
(1, 1245480.00, '2025-07-09 20:28:12');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `harcama_kalemleri`
--

CREATE TABLE `harcama_kalemleri` (
  `id` int(11) NOT NULL,
  `sira` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `urun` varchar(200) NOT NULL,
  `tutar` decimal(10,2) NOT NULL,
  `link` text DEFAULT NULL,
  `aciklama` text DEFAULT NULL,
  `durum` varchar(50) DEFAULT 'Beklemede',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tur` enum('Aylık','Tek Seferlik') NOT NULL DEFAULT 'Tek Seferlik',
  `erteleme_tarihi` date DEFAULT NULL,
  `kategori_tipi` varchar(32) DEFAULT 'Ani/Ekstra Harcama',
  `harcama_donemi` varchar(5) DEFAULT '07.25'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `harcama_kalemleri`
--

INSERT INTO `harcama_kalemleri` (`id`, `sira`, `kategori`, `urun`, `tutar`, `link`, `aciklama`, `durum`, `created_at`, `tur`, `erteleme_tarihi`, `kategori_tipi`, `harcama_donemi`) VALUES
(1, 1, 'İhtiyaç', 'Teknosa CELL TL Yükleme', 0.00, '', 'Telefon kredisi', 'Tamamlandı', '2025-07-06 22:33:59', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25'),
(2, 2, 'ödeme', 'Colendi Money Pay Ödeme', 0.00, '', 'Ödeme sistemi', 'Tamamlandı', '2025-07-06 22:33:59', 'Tek Seferlik', NULL, 'Sabit Giderler', '07.25'),
(4, 4, 'abonelikler', 'Google Drive', 0.00, 'https://one.google.com/dynamic-plans', 'Bulut depolama', 'Beklemede', '2025-07-06 22:33:59', 'Tek Seferlik', NULL, 'Sabit Giderler', '07.25'),
(5, 5, 'abonelikler', 'Youtube Premium', 0.00, 'https://www.youtube.com/paid_memberships', 'Aylık abonelik', 'Planlandı', '2025-07-06 22:33:59', 'Tek Seferlik', NULL, 'Sabit Giderler', '07.25'),
(6, 6, 'donanım', 'Klavye', 480.00, 'https://www.teknosa.com/everest-b-2012', 'Everest KM-6121', 'Beklemede', '2025-07-13 00:30:57', 'Tek Seferlik', NULL, 'Ani/Ekstra Harcama', '07.25'),
(7, 7, 'donanım', 'Mousepad', 200.00, '', '', 'Beklemede', '2025-07-13 00:30:57', 'Tek Seferlik', NULL, 'Ani/Ekstra Harcama', '07.25'),
(8, 8, 'kişisel', 'Moser Tarak Seti 1-4 No', 149.00, 'https://www.trendyol.com/moser/1400-kesim-tarak-seti', '', 'Beklemede', '2025-07-13 00:30:57', 'Tek Seferlik', NULL, 'Ani/Ekstra Harcama', '07.25'),
(9, 9, 'abonelikler', 'Chat GPT', 0.00, '', '', 'Planlandı', '2025-07-06 23:10:35', 'Tek Seferlik', NULL, 'Sabit Giderler', '07.25'),
(10, 10, 'ulaşım', 'Scooter', 16000.00, '', '', 'Beklemede', '2025-07-08 05:39:04', 'Tek Seferlik', NULL, 'Değişken Giderler', '07.25'),
(11, 11, 'kişisel', 'Vural Yusuf Yüksek', 0.00, '', '', 'Beklemede', '2025-07-08 05:39:04', 'Tek Seferlik', NULL, 'Ani/Ekstra Harcama', '07.25'),
(14, 14, 'aksesuar', 'Laptop Çantası', 1000.00, '', '', 'Beklemede', '2025-07-08 05:39:04', 'Tek Seferlik', NULL, 'Ani/Ekstra Harcama', '07.25'),
(16, 16, 'donanım', 'Kulaklık', 600.00, 'https://www.teknosa.com/preo-ms36-dokunmatik-kontrol', 'Preo MS36', 'Ertelendi', '2025-07-13 00:30:57', 'Tek Seferlik', '2025-08-13', 'Ani/Ekstra Harcama', '08.25'),
(17, 17, 'gıda', 'Yemek', 0.00, '', 'Yalcın\'da', 'Planlandı', '2025-07-06 23:10:35', 'Tek Seferlik', NULL, 'Değişken Giderler', '07.25'),
(18, 18, 'abonelikler', 'Hornet Premium', 0.00, '', '', 'Planlandı', '2025-07-06 23:10:35', 'Tek Seferlik', NULL, 'Sabit Giderler', '07.25'),
(20, 1, 'Kişisel', 'Makrobet', 0.00, 'https://makrobet683.com/tr', NULL, 'Beklemede', '2025-07-07 07:52:36', 'Tek Seferlik', NULL, 'Ani/Ekstra Harcama', '07.25'),
(21, 0, 'Teknoloji', 'Promptly.guru alan adı', 120.00, NULL, NULL, 'Beklemede', '2025-07-07 08:08:50', 'Tek Seferlik', NULL, 'Ani/Ekstra Harcama', '07.25'),
(22, 1, 'Özel', 'Yusuf\'a mextup ile mektup', 250.00, NULL, NULL, 'Beklemede', '2025-07-07 09:00:36', 'Tek Seferlik', NULL, 'Ani/Ekstra Harcama', '07.25'),
(23, 1, 'İhtiyaç', 'Saç Spreyi', 0.01, '', '', 'Devam Ediyor', '2025-07-13 09:03:10', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hesaplar_sifreler`
--

CREATE TABLE `hesaplar_sifreler` (
  `id` int(11) NOT NULL,
  `platform` varchar(100) NOT NULL,
  `kullanici_adi` varchar(100) NOT NULL,
  `giris_linki` text DEFAULT NULL,
  `hesap_turu` enum('İnternet Bankacılığı','Mail','Sosyal Medya','Bahis Sitesi') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `hesaplar_sifreler`
--

INSERT INTO `hesaplar_sifreler` (`id`, `platform`, `kullanici_adi`, `giris_linki`, `hesap_turu`, `created_at`, `password_hash`) VALUES
(1, 'Ziraat Bankası', 'mveyselilgaz', 'https://bireysel.ziraatbank.com.tr', 'İnternet Bankacılığı', '2025-07-06 22:33:59', '86a2f5de787edb937de1230a6ff9220a39e50f9c8d62137b852ea6df74badbba'),
(2, 'Gmail', 'mveysel@gmail.com', 'https://gmail.com', 'Mail', '2025-07-06 22:33:59', '9185952e547d66955c66fb173e2ebc2c3caf8c1cef96c81895924eadd363b8ec'),
(3, 'Instagram', '@mveyselilgaz', 'https://instagram.com', 'Sosyal Medya', '2025-07-06 22:33:59', 'a2c07543ca0e388026c19a1be3afc76f2ef6e1f39a2108d28a220df037c9ba75');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iban_bilgileri`
--

CREATE TABLE `iban_bilgileri` (
  `id` int(11) NOT NULL,
  `hesap_sahibi` varchar(100) NOT NULL,
  `iban` varchar(50) DEFAULT NULL,
  `kolay_adres` varchar(50) DEFAULT NULL,
  `banka` varchar(100) NOT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `aciklama` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hesap_turu` varchar(50) DEFAULT 'diger'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `iban_bilgileri`
--

INSERT INTO `iban_bilgileri` (`id`, `hesap_sahibi`, `iban`, `kolay_adres`, `banka`, `logo`, `aciklama`, `created_at`, `hesap_turu`) VALUES
(1, 'Muhammed Veysel Ilgaz', 'TR68 0011 1000 0000 0037 2387 48', '5060302085', 'Enpara', 'https://internetsubesi.enpara.com/Content/Images/logo.png', 'Ana hesap', '2025-07-06 22:33:59', 'kendi'),
(2, 'Yalçın Yıldırım', 'TR850006400000133910243951', '', 'İsBankası', 'https://www.garantibbva.com.tr/content/experience-fragments/public-website/tr/site/header/master1/_jcr_content/root/header/headerdesktop/image.coreimg.svg/1699885476212/logo.svg', 'İş hesabı', '2025-07-06 22:33:59', 'diger'),
(3, 'Buket GÖNÜL', 'TR530006701000000046269890', '', 'Yapı Kredi', 'https://assets.yapikredi.com.tr/WebSite/_assets/img/Yapikredi_logo.svg?v6', 'Kişisel hesap', '2025-07-06 22:33:59', 'diger'),
(4, 'Yılmaz YILDIZ', 'TR6500067010 00000090519231', '', 'Yapı Kredi', 'https://assets.yapikredi.com.tr/WebSite/_assets/img/Yapikredi_logo.svg?v6', 'Ana hesap', '2025-07-06 22:33:59', 'diger'),
(5, 'Semih Naci TAŞKÖPRÜ', NULL, NULL, 'Ziraat', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK27-tlpGVYdDpYHpnMuqgnCsLDMXsAqfZnnNHCk82xxrxnT4mZk5bKK4EQNTeKBfvC68&usqp=CAU', NULL, '2025-07-06 23:39:14', 'diger'),
(6, 'Semih Naci TAŞKÖPRÜ', NULL, NULL, 'Akbank', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPmEklnIpDVFawGYW_5av94z-CE6fvok3tAA&s', NULL, '2025-07-06 23:39:44', 'diger');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `istek_listesi`
--

CREATE TABLE `istek_listesi` (
  `id` int(11) NOT NULL,
  `ad` varchar(200) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `fiyat` decimal(10,2) NOT NULL,
  `gorsel` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `will_get` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `istek_listesi`
--

INSERT INTO `istek_listesi` (`id`, `ad`, `kategori`, `fiyat`, `gorsel`, `link`, `created_at`, `will_get`) VALUES
(1, 'Samsung Galaxy Watch5 44MM', 'aksesuar', 6489.00, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/145061605/145061605_0_MC/15984a57.png', 'https://www.teknosa.com/samsunggalaxy-watch5-44mm-safir-akilli-saat', '2025-07-08 05:39:04', 'no'),
(2, 'Samsung Galaxy Tab S10 Ultra 5G', 'teknoloji', 49999.00, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/786400252/786400252_0_MC/dd2ef30144f448368de0b2ca62944b9e.jpg', 'https://www.teknosa.com/samsung-galaxy-tab-s10-ultra-5g', '2025-07-08 05:39:04', 'no'),
(3, 'Preo Mcs020 14.1\" Notebook Çantası', 'aksesuar', 399.90, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/125049600/125049600_0_MC/74978930.jpg', 'https://www.teknosa.com/preo-mcs020-141-mycase-siyah-notebook-cantasi', '2025-07-08 05:39:04', 'no'),
(4, 'Preo MCS019 15.6\" Sırt Çantası', 'aksesuar', 999.90, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/125047196/125047196_0_MC/74835743.png', 'https://www.teknosa.com/preo-mcs019-156-mycase-siyah-notebook-sirt-cantasi', '2025-07-08 05:39:04', 'yes'),
(5, 'Ducati Pro-I Evo Scooter', 'ulaşım', 16000.00, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/789130013/789130013_0_MC/5b42353c9b87419e833106020318dbbe.jpg', 'https://www.teknosa.com/ducati-proi-evo-siyah-elektrikli-scooter', '2025-07-08 05:39:04', 'yes'),
(8, 'Preo Mcs020 14.1\" Mycase Siyah Notebook Çantası', 'aksesuar', 399.90, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/125049600/125049600_0_MC/74978930.jpg', 'https://www.teknosa.com/preo-mcs020-141-mycase-siyah-notebook-cantasi-p-125049600?shopId=teknosa', '2025-07-06 21:53:46', 'no'),
(14, 'No Regrets Enjeksiyon Baskı Tişört (Taş)', 'kıyafet', 279.99, 'https://cdn.myikas.com/images/742980eb-81e4-4260-85f7-70a141e1ea7c/cdec9e55-9550-4d56-81a1-501eee639776/image_1512.webp', 'https://tenamoda.com/erkek-bisiklet-yaka-no-regrets-enjeksiyon-baski-tisort-5ye2062114?Renk=Ta%C5%9F&Beden=S', '2025-07-06 21:53:46', 'yes'),
(15, 'Omuz ve Yanları Biyeli Kağıt Tişört (Siyah)', 'kıyafet', 399.99, 'https://cdn.myikas.com/images/742980eb-81e4-4260-85f7-70a141e1ea7c/40c39b1d-a9fa-43c7-aed1-5895b8ca474c/image_1512.webp', 'https://tenamoda.com/erkek-bisiklet-yaka-omuz-ve-yanlari-biyeli-kagi-tisort-5yetscl4141?Renk=Siyah&Beden=S', '2025-07-06 21:53:46', 'yes'),
(16, 'Omuz ve Yanları Biyeli Kağıt Tişört (Lacivert)', 'kıyafet', 399.99, 'https://cdn.myikas.com/images/742980eb-81e4-4260-85f7-70a141e1ea7c/ddf0a939-a961-49df-ba5b-f23127bef0d0/image_1512.webp', 'https://cdn.myikas.com/images/742980eb-81e4-4260-85f7-70a141e1ea7c/ddf0a939-a961-49df-ba5b-f23127bef0d0/image_1512.webp', '2025-07-06 21:53:46', 'yes'),
(17, 'Jake Siyah Comfort Jean Skinny (31W 32L)', 'kıyafet', 1299.99, 'https://sky-static.mavi.com/mnresize/820/1162/0042216291_image_2.jpg', 'https://www.mavi.com/jake-siyah-comfort-jean-pantolon/p/0042216291', '2025-07-06 21:53:46', 'yes'),
(18, 'HP Color Laser MFP 179FNW', 'teknoloji', 16535.00, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/600/600/productimage/125099897/125099897_4_MC/43797819.png', 'https://www.teknosa.com/hp-color-laser-mfp-179fnw-faks-fotokopi-tarayici-ethernet-wifi-cok-fonksiyonlu-renkli-lazer-yazici-4zb97a-p-125099897', '2025-07-06 21:53:46', 'no');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `status` enum('success','failed','logout') NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `login_logs`
--

INSERT INTO `login_logs` (`id`, `identifier`, `status`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, '1', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-13 07:58:41'),
(2, 'admn', 'failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-13 07:58:49'),
(3, 'admin', 'failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-13 07:58:59'),
(4, '1', 'success', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-13 08:01:39'),
(5, 'admin@budget.local', 'failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-13 16:49:29'),
(6, '1', 'success', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-13 16:49:40');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `odemeler`
--

CREATE TABLE `odemeler` (
  `id` int(11) NOT NULL,
  `kisi_adi` varchar(100) NOT NULL,
  `iban` varchar(50) DEFAULT NULL,
  `tutar` decimal(10,2) NOT NULL,
  `durum` enum('Beklemede','Gecikmiş','Planlandı','Ödendi') DEFAULT 'Beklemede',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `odemeler`
--

INSERT INTO `odemeler` (`id`, `kisi_adi`, `iban`, `tutar`, `durum`, `created_at`) VALUES
(1, 'Buket GÖNÜL', 'TR530006701000000046269890', 0.00, 'Planlandı', '2025-07-06 21:47:39'),
(2, 'Şenay POLAT', NULL, 0.00, 'Planlandı', '2025-07-06 21:47:39'),
(3, 'Yılmaz YILDIZ', 'TR65 0006 7010 0000 0090 5192 31', 0.00, 'Planlandı', '2025-07-06 21:47:39'),
(4, 'Yalcın YILDIRIM', '', 100.00, 'Ödendi', '2025-07-06 21:47:39'),
(5, 'Vural Yusuf YÜKSEK', '50000TL', 0.00, 'Beklemede', '2025-07-07 08:05:40');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rate_limits`
--

CREATE TABLE `rate_limits` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `endpoint` varchar(100) NOT NULL,
  `attempts` int(11) DEFAULT 1,
  `window_start` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rate_limits`
--

INSERT INTO `rate_limits` (`id`, `ip_address`, `endpoint`, `attempts`, `window_start`) VALUES
(1, '::1', 'login', 1, '2025-07-10 16:38:27'),
(2, '::1', 'login', 1, '2025-07-10 16:45:25'),
(3, '::1', 'login', 1, '2025-07-10 16:45:48'),
(4, '::1', 'login', 1, '2025-07-10 16:59:48'),
(5, '::1', 'login', 1, '2025-07-10 17:00:07'),
(6, '::1', 'login', 1, '2025-07-10 17:21:07'),
(7, '::1', 'login', 1, '2025-07-10 17:57:19');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `timeofbirth` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `failed_attempts` int(11) DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `name`, `middle_name`, `surname`, `timeofbirth`, `avatar`, `password_hash`, `is_active`, `failed_attempts`, `locked_until`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@budget.local', 'Muhammed', 'Veysel', 'ILGAZ', '0000-00-00', 'assets/images/avatar/3.jpg', '$2y$10$/z.lf3a6Xpp0nlJLYh41u.NrsEJoEjM7I2dpigX5DueLkZACqBIAG', 1, 0, NULL, '2025-07-13 19:49:40', '2025-07-10 16:40:51', '2025-07-13 16:49:40');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `expires_at`, `created_at`) VALUES
('e8lrfhd4io0qqmektk51ke2dud', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-11 20:21:14', '2025-07-10 17:21:14'),
('g8kumk1bk06461pfr1o41vq26n', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-11 20:02:38', '2025-07-10 17:02:38'),
('o3ujj3ohcfpa4ac8dj717h5cb3', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-14 01:25:19', '2025-07-12 22:25:19');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `bakiye`
--
ALTER TABLE `bakiye`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `harcama_kalemleri`
--
ALTER TABLE `harcama_kalemleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kategori` (`kategori`),
  ADD KEY `idx_durum` (`durum`);

--
-- Tablo için indeksler `hesaplar_sifreler`
--
ALTER TABLE `hesaplar_sifreler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `iban_bilgileri`
--
ALTER TABLE `iban_bilgileri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `istek_listesi`
--
ALTER TABLE `istek_listesi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_will_get` (`will_get`),
  ADD KEY `idx_kategori` (`kategori`);

--
-- Tablo için indeksler `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `odemeler`
--
ALTER TABLE `odemeler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_durum` (`durum`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Tablo için indeksler `rate_limits`
--
ALTER TABLE `rate_limits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_endpoint` (`ip_address`,`endpoint`),
  ADD KEY `idx_window_start` (`window_start`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`);

--
-- Tablo için indeksler `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `bakiye`
--
ALTER TABLE `bakiye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `harcama_kalemleri`
--
ALTER TABLE `harcama_kalemleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `hesaplar_sifreler`
--
ALTER TABLE `hesaplar_sifreler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `iban_bilgileri`
--
ALTER TABLE `iban_bilgileri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `istek_listesi`
--
ALTER TABLE `istek_listesi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `odemeler`
--
ALTER TABLE `odemeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `rate_limits`
--
ALTER TABLE `rate_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
