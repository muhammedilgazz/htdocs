-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 16 Tem 2025, 05:07:01
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
-- Veritabanı: `budget_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `account_credentials`
--

CREATE TABLE `account_credentials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 1,
  `platform_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `login_url` text DEFAULT NULL,
  `account_type_id` int(11) DEFAULT 6,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `account_types`
--

CREATE TABLE `account_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `account_types`
--

INSERT INTO `account_types` (`id`, `name`, `created_at`) VALUES
(1, 'İnternet Bankacılığı', '2025-07-14 00:29:01'),
(2, 'Mail', '2025-07-14 00:29:01'),
(3, 'Sosyal Medya', '2025-07-14 00:29:01'),
(4, 'Bahis Sitesi', '2025-07-14 00:29:01'),
(5, 'Abonelik Servisi', '2025-07-14 00:29:01'),
(6, 'E-Ticaret', '2025-07-14 00:29:01');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 1,
  `account_holder` varchar(100) NOT NULL,
  `iban_number` varchar(50) DEFAULT NULL,
  `easy_address` varchar(50) DEFAULT NULL,
  `bank_id` int(11) DEFAULT 5,
  `bank_name` varchar(100) NOT NULL,
  `bank_logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `account_type` enum('own','other') DEFAULT 'other',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `user_id`, `account_holder`, `iban_number`, `easy_address`, `bank_id`, `bank_name`, `bank_logo`, `description`, `account_type`, `created_at`, `updated_at`) VALUES
(1, 1, 'Muhammed Veysel Ilgaz', 'TR68 0011 1000 0000 0037 2387 48', '5060302085', 5, 'Enpara', 'https://internetsubesi.enpara.com/Content/Images/logo.png', 'Ana hesap', 'own', '2025-07-06 22:33:59', '2025-07-14 00:49:39'),
(2, 1, 'Yalçın Yıldırım', 'TR850006400000133910243951', '', 5, 'İsBankası', 'https://www.garantibbva.com.tr/content/experience-fragments/public-website/tr/site/header/master1/_jcr_content/root/header/headerdesktop/image.coreimg.svg/1699885476212/logo.svg', 'İş hesabı', 'other', '2025-07-06 22:33:59', '2025-07-14 00:49:39'),
(3, 1, 'Buket GÖNÜL', 'TR530006701000000046269890', '', 4, 'Yapı Kredi', 'https://assets.yapikredi.com.tr/WebSite/_assets/img/Yapikredi_logo.svg?v6', 'Kişisel hesap', 'other', '2025-07-06 22:33:59', '2025-07-14 00:49:39'),
(4, 1, 'Yılmaz YILDIZ', 'TR6500067010 00000090519231', '', 4, 'Yapı Kredi', 'https://assets.yapikredi.com.tr/WebSite/_assets/img/Yapikredi_logo.svg?v6', 'Ana hesap', 'other', '2025-07-06 22:33:59', '2025-07-14 00:49:39'),
(5, 1, 'Semih Naci TAŞKÖPRÜ', NULL, NULL, 1, 'Ziraat', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK27-tlpGVYdDpYHpnMuqgnCsLDMXsAqfZnnNHCk82xxrxnT4mZk5bKK4EQNTeKBfvC68&usqp=CAU', NULL, 'other', '2025-07-06 23:39:14', '2025-07-14 00:49:39'),
(6, 1, 'Semih Naci TAŞKÖPRÜ', NULL, NULL, 2, 'Akbank', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPmEklnIpDVFawGYW_5av94z-CE6fvok3tAA&s', NULL, 'other', '2025-07-06 23:39:44', '2025-07-14 00:49:39');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bank_debts`
--

CREATE TABLE `bank_debts` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `loan_type` varchar(100) DEFAULT NULL,
  `principal` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `is_legal_process` tinyint(1) DEFAULT NULL,
  `asset_company` varchar(100) DEFAULT NULL,
  `is_installment` tinyint(1) DEFAULT NULL,
  `planned_payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `execution_debts`
--

CREATE TABLE `execution_debts` (
  `id` int(11) NOT NULL,
  `owner` varchar(100) DEFAULT NULL,
  `creditor` varchar(100) DEFAULT NULL,
  `execution_office` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `current_debt` decimal(10,2) DEFAULT NULL,
  `principal_debt` decimal(10,2) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `planned_payment` decimal(10,2) DEFAULT NULL,
  `this_month_payment` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category_type` enum('sabit_gider','degisken_gider','ani_ekstra','ertelenmis') NOT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 1,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(50) DEFAULT 'Genel',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `status` enum('active','archived','deleted') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personal_debts`
--

CREATE TABLE `personal_debts` (
  `id` int(11) NOT NULL,
  `to_whom` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `planned_payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sgk_debts`
--

CREATE TABLE `sgk_debts` (
  `id` int(11) NOT NULL,
  `owner` varchar(100) DEFAULT NULL,
  `period` varchar(100) DEFAULT NULL,
  `principal` decimal(10,2) DEFAULT NULL,
  `interest` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_due` date DEFAULT NULL,
  `planned_payment` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `this_month_payment` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tax_debts`
--

CREATE TABLE `tax_debts` (
  `id` int(11) NOT NULL,
  `owner` varchar(100) DEFAULT NULL,
  `period` varchar(100) DEFAULT NULL,
  `principal` decimal(10,2) DEFAULT NULL,
  `interest` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_due` date DEFAULT NULL,
  `planned_payment` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `this_month_payment` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `full_name`, `role`, `status`, `last_login`, `created_at`, `name`, `middle_name`, `surname`, `username`, `failed_attempts`, `locked_until`, `is_active`) VALUES
(1, 'admin@example.com', '$2y$10$tyQwQoAXj6kgCqTS0GB3LeqMohkLjud8wvljc8pA43viN7TPJxgg2', NULL, 'admin', 'active', '2025-07-16 00:57:58', '2025-07-14 00:31:59', 'Admin', '', 'User', 'admin', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `wishlist_type` enum('alinacak','ihtiyac','istek','hayal','favori') DEFAULT 'istek',
  `image_url` varchar(255) DEFAULT NULL,
  `product_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `progress` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `account_credentials`
--
ALTER TABLE `account_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_platform` (`platform_name`);

--
-- Tablo için indeksler `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Tablo için indeksler `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_bank` (`bank_id`),
  ADD KEY `idx_account_type` (`account_type`);

--
-- Tablo için indeksler `bank_debts`
--
ALTER TABLE `bank_debts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `execution_debts`
--
ALTER TABLE `execution_debts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_status` (`status`);

--
-- Tablo için indeksler `personal_debts`
--
ALTER TABLE `personal_debts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sgk_debts`
--
ALTER TABLE `sgk_debts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tax_debts`
--
ALTER TABLE `tax_debts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `account_credentials`
--
ALTER TABLE `account_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `bank_debts`
--
ALTER TABLE `bank_debts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `execution_debts`
--
ALTER TABLE `execution_debts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `personal_debts`
--
ALTER TABLE `personal_debts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `sgk_debts`
--
ALTER TABLE `sgk_debts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `tax_debts`
--
ALTER TABLE `tax_debts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
