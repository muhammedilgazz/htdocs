-- Database Backup
-- Created: 2025-07-16 06:16:11


-- Table: account_credentials
DROP TABLE IF EXISTS `account_credentials`;
CREATE TABLE `account_credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 1,
  `platform_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `login_url` text DEFAULT NULL,
  `account_type_id` int(11) DEFAULT 6,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_platform` (`platform_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: account_types
DROP TABLE IF EXISTS `account_types`;
CREATE TABLE `account_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `account_types` VALUES ('1', 'İnternet Bankacılığı', '2025-07-14 03:29:01');
INSERT INTO `account_types` VALUES ('2', 'Mail', '2025-07-14 03:29:01');
INSERT INTO `account_types` VALUES ('3', 'Sosyal Medya', '2025-07-14 03:29:01');
INSERT INTO `account_types` VALUES ('4', 'Bahis Sitesi', '2025-07-14 03:29:01');
INSERT INTO `account_types` VALUES ('5', 'Abonelik Servisi', '2025-07-14 03:29:01');
INSERT INTO `account_types` VALUES ('6', 'E-Ticaret', '2025-07-14 03:29:01');


-- Table: bank_accounts
DROP TABLE IF EXISTS `bank_accounts`;
CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_bank` (`bank_id`),
  KEY `idx_account_type` (`account_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bank_accounts` VALUES ('1', '1', 'Muhammed Veysel Ilgaz', 'TR68 0011 1000 0000 0037 2387 48', '5060302085', '5', 'Enpara', 'https://internetsubesi.enpara.com/Content/Images/logo.png', 'Ana hesap', 'own', '2025-07-07 01:33:59', '2025-07-14 03:49:39');
INSERT INTO `bank_accounts` VALUES ('2', '1', 'Yalçın Yıldırım', 'TR850006400000133910243951', '', '5', 'İsBankası', 'https://www.garantibbva.com.tr/content/experience-fragments/public-website/tr/site/header/master1/_jcr_content/root/header/headerdesktop/image.coreimg.svg/1699885476212/logo.svg', 'İş hesabı', 'other', '2025-07-07 01:33:59', '2025-07-14 03:49:39');
INSERT INTO `bank_accounts` VALUES ('3', '1', 'Buket GÖNÜL', 'TR530006701000000046269890', '', '4', 'Yapı Kredi', 'https://assets.yapikredi.com.tr/WebSite/_assets/img/Yapikredi_logo.svg?v6', 'Kişisel hesap', 'other', '2025-07-07 01:33:59', '2025-07-14 03:49:39');
INSERT INTO `bank_accounts` VALUES ('4', '1', 'Yılmaz YILDIZ', 'TR6500067010 00000090519231', '', '4', 'Yapı Kredi', 'https://assets.yapikredi.com.tr/WebSite/_assets/img/Yapikredi_logo.svg?v6', 'Ana hesap', 'other', '2025-07-07 01:33:59', '2025-07-14 03:49:39');
INSERT INTO `bank_accounts` VALUES ('5', '1', 'Semih Naci TAŞKÖPRÜ', NULL, NULL, '1', 'Ziraat', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK27-tlpGVYdDpYHpnMuqgnCsLDMXsAqfZnnNHCk82xxrxnT4mZk5bKK4EQNTeKBfvC68&usqp=CAU', NULL, 'other', '2025-07-07 02:39:14', '2025-07-14 03:49:39');
INSERT INTO `bank_accounts` VALUES ('6', '1', 'Semih Naci TAŞKÖPRÜ', NULL, NULL, '2', 'Akbank', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPmEklnIpDVFawGYW_5av94z-CE6fvok3tAA&s', NULL, 'other', '2025-07-07 02:39:44', '2025-07-14 03:49:39');


-- Table: bank_debts
DROP TABLE IF EXISTS `bank_debts`;
CREATE TABLE `bank_debts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(100) DEFAULT NULL,
  `loan_type` varchar(100) DEFAULT NULL,
  `principal` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `is_legal_process` tinyint(1) DEFAULT NULL,
  `asset_company` varchar(100) DEFAULT NULL,
  `is_installment` tinyint(1) DEFAULT NULL,
  `planned_payment_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table: execution_debts
DROP TABLE IF EXISTS `execution_debts`;
CREATE TABLE `execution_debts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(100) DEFAULT NULL,
  `creditor` varchar(100) DEFAULT NULL,
  `execution_office` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `current_debt` decimal(10,2) DEFAULT NULL,
  `principal_debt` decimal(10,2) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `planned_payment` decimal(10,2) DEFAULT NULL,
  `this_month_payment` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table: expenses
DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `category_type` enum('sabit_gider','degisken_gider','ani_ekstra','ertelenmis') NOT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `expenses` VALUES ('1', '1500.00', 'sabit_gider', 'Kira', '2025-07-16');
INSERT INTO `expenses` VALUES ('2', '250.00', 'degisken_gider', 'Market Alışverişi', '2025-07-16');
INSERT INTO `expenses` VALUES ('3', '89.90', 'ani_ekstra', 'Netflix Abonelik', '2025-07-16');


-- Table: notes
DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 1,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(50) DEFAULT 'Genel',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `status` enum('active','archived','deleted') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_category` (`category`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: personal_debts
DROP TABLE IF EXISTS `personal_debts`;
CREATE TABLE `personal_debts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_whom` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `planned_payment_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table: purchased_items
DROP TABLE IF EXISTS `purchased_items`;
CREATE TABLE `purchased_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` int(11) NOT NULL DEFAULT 0,
  `category` varchar(50) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `link` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Beklemede','Planlandı','Devam Ediyor','Tamamlandı','Ertelendi','İptal') DEFAULT 'Beklemede',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `item_type` enum('Aylık','Tek Seferlik') DEFAULT 'Tek Seferlik',
  `postpone_date` date DEFAULT NULL,
  `category_type` varchar(50) DEFAULT 'Alınacak Ürünler',
  `expense_period` varchar(10) DEFAULT '07.25',
  `priority` enum('Düşük','Orta','Yüksek','Acil') DEFAULT 'Orta',
  `notes` text DEFAULT NULL,
  `price_range` varchar(50) DEFAULT NULL,
  `is_urgent` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1016 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `purchased_items` VALUES ('1009', '1', 'İhtiyaç', 'Teknosa CELL TL Yükleme', '0.00', '', 'Telefon kredisi', 'Tamamlandı', '2025-07-06 22:33:59', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25', 'Orta', '', '', '0', '2025-07-16 07:16:08');
INSERT INTO `purchased_items` VALUES ('1010', '1', 'İhtiyaç', 'Saç Spreyi', '0.01', '', '', 'Devam Ediyor', '2025-07-13 09:03:10', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25', 'Orta', '', '', '0', '2025-07-16 07:16:08');
INSERT INTO `purchased_items` VALUES ('1011', '2', 'Teknoloji', 'Wireless Mouse', '150.00', 'https://www.teknosa.com/mouse', 'Ofis için kablosuz mouse', 'Beklemede', '2025-07-16 06:16:08', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25', 'Yüksek', '', '100-200 TL', '0', '2025-07-16 07:16:08');
INSERT INTO `purchased_items` VALUES ('1012', '3', 'Kişisel', 'Diş Fırçası', '25.00', '', 'Elektrikli diş fırçası', 'Beklemede', '2025-07-16 06:16:08', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25', 'Orta', '', '', '1', '2025-07-16 07:16:08');
INSERT INTO `purchased_items` VALUES ('1013', '4', 'Ev', 'Led Ampul', '80.00', 'https://www.trendyol.com/led-ampul', 'Yatak odası için led ampul', 'Planlandı', '2025-07-16 06:16:08', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25', 'Düşük', '', '', '0', '2025-07-16 07:16:08');
INSERT INTO `purchased_items` VALUES ('1014', '5', 'Giyim', 'Spor Ayakkabı', '450.00', 'https://www.nike.com', 'Koşu için spor ayakkabı', 'Beklemede', '2025-07-16 06:16:08', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25', 'Orta', '', '400-500 TL', '0', '2025-07-16 07:16:08');
INSERT INTO `purchased_items` VALUES ('1015', '6', 'Kitap', 'PHP Programlama Kitabı', '120.00', 'https://www.dr.com.tr', 'Web geliştirme için PHP kitabı', 'Beklemede', '2025-07-16 06:16:08', 'Tek Seferlik', NULL, 'Alınacak Ürünler', '07.25', 'Yüksek', '', '', '0', '2025-07-16 07:16:08');


-- Table: sgk_debts
DROP TABLE IF EXISTS `sgk_debts`;
CREATE TABLE `sgk_debts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(100) DEFAULT NULL,
  `period` varchar(100) DEFAULT NULL,
  `principal` decimal(10,2) DEFAULT NULL,
  `interest` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_due` date DEFAULT NULL,
  `planned_payment` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `this_month_payment` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table: tax_debts
DROP TABLE IF EXISTS `tax_debts`;
CREATE TABLE `tax_debts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(100) DEFAULT NULL,
  `period` varchar(100) DEFAULT NULL,
  `principal` decimal(10,2) DEFAULT NULL,
  `interest` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_due` date DEFAULT NULL,
  `planned_payment` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `this_month_payment` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table: user_sessions
DROP TABLE IF EXISTS `user_sessions`;
CREATE TABLE `user_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` VALUES ('1', 'admin@example.com', '$2y$10$tyQwQoAXj6kgCqTS0GB3LeqMohkLjud8wvljc8pA43viN7TPJxgg2', NULL, 'admin', 'active', '2025-07-16 03:57:58', '2025-07-14 03:31:59', 'Admin', '', 'User', 'admin', '0', NULL, '1');


-- Table: wishlist_items
DROP TABLE IF EXISTS `wishlist_items`;
CREATE TABLE `wishlist_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `wishlist_type` enum('alinacak','ihtiyac','istek','hayal','favori') DEFAULT 'istek',
  `image_url` varchar(255) DEFAULT NULL,
  `product_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `progress` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('beklemede','planlandı','satın alındı','iptal','ertelendi') DEFAULT 'beklemede',
  `notes` text DEFAULT NULL,
  `price_range` varchar(50) DEFAULT NULL,
  `is_urgent` tinyint(1) DEFAULT 0,
  `purchase_date` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `wishlist_items` VALUES ('1', 'iPhone 15 Pro', 'hayal', NULL, NULL, '45000.00', '5', NULL, '2025-07-16 07:06:03', 'beklemede', NULL, NULL, '0', NULL, '2025-07-16 07:06:15');
INSERT INTO `wishlist_items` VALUES ('2', 'Çalışma Masası', 'ihtiyac', NULL, NULL, '2500.00', '8', NULL, '2025-07-16 07:06:03', 'beklemede', NULL, NULL, '0', NULL, '2025-07-16 07:06:15');
INSERT INTO `wishlist_items` VALUES ('3', 'Bluetooth Kulaklık', 'istek', NULL, NULL, '1200.00', '6', NULL, '2025-07-16 07:06:03', 'beklemede', NULL, NULL, '0', NULL, '2025-07-16 07:06:15');

