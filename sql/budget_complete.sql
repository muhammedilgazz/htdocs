-- =====================================================
-- Budget Management System - Complete Database Schema
-- Database: budget
-- Version: 2.0.0
-- Date: 2024-07-14
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create database
CREATE DATABASE IF NOT EXISTS `budget` 
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `budget`;

-- =====================================================
-- LOOKUP TABLES (Reference Data)
-- =====================================================

-- Categories table with enhanced type system
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `type` ENUM('sabit_gider', 'degisken_gider', 'borc_odemesi', 'ani_ekstra', 'ertelenmis', 'wishlist') NOT NULL,
    `description` TEXT,
    `icon` VARCHAR(50) DEFAULT NULL,
    `color` VARCHAR(7) DEFAULT '#6366f1',
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_type` (`type`),
    INDEX `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Account types for credentials management
CREATE TABLE IF NOT EXISTS `account_types` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `icon` VARCHAR(50) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Banks table for IBAN management
CREATE TABLE IF NOT EXISTS `banks` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE,
    `short_name` VARCHAR(20),
    `logo_path` VARCHAR(200),
    `swift_code` VARCHAR(11),
    `website` VARCHAR(255),
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Status types for various entities
CREATE TABLE IF NOT EXISTS `status_types` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `description` TEXT,
    `color` VARCHAR(7) DEFAULT '#6c757d',
    `icon` VARCHAR(50) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- MAIN TABLES (Business Logic)
-- =====================================================

-- Users table with enhanced security
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `name` VARCHAR(50) DEFAULT NULL,
    `middle_name` VARCHAR(50) DEFAULT NULL,
    `surname` VARCHAR(50) DEFAULT NULL,
    `full_name` VARCHAR(255) GENERATED ALWAYS AS (CONCAT_WS(' ', name, middle_name, surname)) STORED,
    `timeofbirth` DATE DEFAULT NULL,
    `avatar` VARCHAR(255) DEFAULT NULL,
    `role` ENUM('admin', 'user') DEFAULT 'user',
    `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    `is_active` BOOLEAN DEFAULT TRUE,
    `failed_attempts` INT DEFAULT 0,
    `locked_until` DATETIME DEFAULT NULL,
    `last_login` TIMESTAMP NULL,
    `email_verified_at` TIMESTAMP NULL,
    `two_factor_enabled` BOOLEAN DEFAULT FALSE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_username` (`username`),
    INDEX `idx_email` (`email`),
    INDEX `idx_status` (`status`),
    INDEX `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payments table (renamed from odemeler)
CREATE TABLE IF NOT EXISTS `payments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `person_name` VARCHAR(100) NOT NULL,
    `iban` VARCHAR(50),
    `amount` DECIMAL(10,2) NOT NULL,
    `description` TEXT,
    `due_date` DATE,
    `payment_date` DATE,
    `status_id` INT DEFAULT 1,
    `user_id` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`status_id`) REFERENCES `status_types`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_status` (`status_id`),
    INDEX `idx_user` (`user_id`),
    INDEX `idx_due_date` (`due_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Balances table (renamed from bakiye)
CREATE TABLE IF NOT EXISTS `balances` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT 1,
    `total_balance` DECIMAL(15,2) DEFAULT 0,
    `last_calculation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Expense items table (renamed from harcama_kalemleri)
CREATE TABLE IF NOT EXISTS `expense_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_number` INT NOT NULL,
    `category_id` INT NOT NULL,
    `item_name` VARCHAR(200) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `link` TEXT,
    `description` TEXT,
    `status_id` INT DEFAULT 1,
    `user_id` INT DEFAULT 1,
    `expense_type` ENUM('monthly', 'one_time') DEFAULT 'one_time',
    `expense_period` VARCHAR(10) DEFAULT NULL,
    `postpone_date` DATE DEFAULT NULL,
    `due_date` DATE DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
    FOREIGN KEY (`status_id`) REFERENCES `status_types`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_category` (`category_id`),
    INDEX `idx_status` (`status_id`),
    INDEX `idx_user` (`user_id`),
    INDEX `idx_due_date` (`due_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Wishlist items table (renamed from istek_listesi)
CREATE TABLE IF NOT EXISTS `wishlist_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `item_name` VARCHAR(200) NOT NULL,
    `category_id` INT NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `image_path` TEXT,
    `link` TEXT,
    `description` TEXT,
    `will_get` BOOLEAN DEFAULT FALSE,
    `wishlist_type` ENUM('ihtiyac', 'istek', 'favori') DEFAULT 'istek',
    `priority` ENUM('low', 'medium', 'high') DEFAULT 'medium',
    `user_id` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_category` (`category_id`),
    INDEX `idx_type` (`wishlist_type`),
    INDEX `idx_will_get` (`will_get`),
    INDEX `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Account credentials table (renamed from hesaplar_sifreler)
CREATE TABLE IF NOT EXISTS `account_credentials` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `platform` VARCHAR(100) NOT NULL,
    `username` VARCHAR(100) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `login_link` TEXT,
    `account_type_id` INT NOT NULL,
    `user_id` INT DEFAULT 1,
    `notes` TEXT,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`account_type_id`) REFERENCES `account_types`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_platform` (`platform`),
    INDEX `idx_type` (`account_type_id`),
    INDEX `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- IBAN details table (renamed from iban_bilgileri)
CREATE TABLE IF NOT EXISTS `iban_details` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `account_holder_name` VARCHAR(100) NOT NULL,
    `iban` VARCHAR(50),
    `easy_address` VARCHAR(50),
    `bank_id` INT NOT NULL,
    `account_type` ENUM('kendi', 'diger') DEFAULT 'diger',
    `description` TEXT,
    `user_id` INT DEFAULT 1,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`bank_id`) REFERENCES `banks`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_bank` (`bank_id`),
    INDEX `idx_type` (`account_type`),
    INDEX `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notes table
CREATE TABLE IF NOT EXISTS `notes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT,
    `category` VARCHAR(50) DEFAULT 'general',
    `tags` JSON DEFAULT NULL,
    `is_pinned` BOOLEAN DEFAULT FALSE,
    `user_id` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_category` (`category`),
    INDEX `idx_pinned` (`is_pinned`),
    INDEX `idx_user` (`user_id`),
    FULLTEXT KEY `idx_search` (`title`, `content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Projects table
CREATE TABLE IF NOT EXISTS `projects` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `status_id` INT DEFAULT 1,
    `user_id` INT DEFAULT 1,
    `start_date` DATE,
    `end_date` DATE,
    `budget` DECIMAL(15,2) DEFAULT 0,
    `spent` DECIMAL(15,2) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`status_id`) REFERENCES `status_types`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_status` (`status_id`),
    INDEX `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Todos table
CREATE TABLE IF NOT EXISTS `todos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `task` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `status_id` INT DEFAULT 1,
    `project_id` INT NULL,
    `user_id` INT DEFAULT 1,
    `priority` ENUM('low', 'medium', 'high') DEFAULT 'medium',
    `due_date` DATE,
    `completed_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`status_id`) REFERENCES `status_types`(`id`),
    FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_status` (`status_id`),
    INDEX `idx_project` (`project_id`),
    INDEX `idx_user` (`user_id`),
    INDEX `idx_due_date` (`due_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dream goals table
CREATE TABLE IF NOT EXISTS `dream_goals` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `goal_name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `target_amount` DECIMAL(15,2),
    `current_amount` DECIMAL(15,2) DEFAULT 0,
    `target_date` DATE,
    `status_id` INT DEFAULT 1,
    `user_id` INT DEFAULT 1,
    `category` VARCHAR(50) DEFAULT 'general',
    `is_achieved` BOOLEAN DEFAULT FALSE,
    `achieved_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`status_id`) REFERENCES `status_types`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_status` (`status_id`),
    INDEX `idx_user` (`user_id`),
    INDEX `idx_target_date` (`target_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Budgets table
CREATE TABLE IF NOT EXISTS `budgets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `budget_amount` DECIMAL(15,2) NOT NULL,
    `spent_amount` DECIMAL(15,2) DEFAULT 0,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `user_id` INT DEFAULT 1,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_category` (`category_id`),
    INDEX `idx_user` (`user_id`),
    INDEX `idx_dates` (`start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Debts table
CREATE TABLE IF NOT EXISTS `debts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `creditor_name` VARCHAR(100),
    `debt_type` ENUM('vergi', 'sgk', 'banka', 'icra', 'sahis') NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `remaining_amount` DECIMAL(10,2) NOT NULL,
    `due_date` DATE,
    `status_id` INT DEFAULT 1,
    `user_id` INT DEFAULT 1,
    `description` TEXT,
    `payment_plan` JSON DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`status_id`) REFERENCES `status_types`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_type` (`debt_type`),
    INDEX `idx_status` (`status_id`),
    INDEX `idx_user` (`user_id`),
    INDEX `idx_due_date` (`due_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SECURITY & LOGGING TABLES
-- =====================================================

-- Login logs table
CREATE TABLE IF NOT EXISTS `login_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `identifier` VARCHAR(255) NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `ip_address` VARCHAR(45),
    `user_agent` TEXT,
    `failure_reason` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_identifier` (`identifier`),
    INDEX `idx_status` (`status`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Rate limits table
CREATE TABLE IF NOT EXISTS `rate_limits` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `action` VARCHAR(100) NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `attempts` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_action_ip` (`action`, `ip_address`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User sessions table
CREATE TABLE IF NOT EXISTS `user_sessions` (
    `id` VARCHAR(128) PRIMARY KEY,
    `user_id` INT NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `user_agent` TEXT,
    `expires_at` DATETIME NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_user` (`user_id`),
    INDEX `idx_expires` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DEFAULT DATA INSERTION
-- =====================================================

-- Insert default status types
INSERT INTO `status_types` (`name`, `description`, `color`) VALUES
('Beklemede', 'Henüz yapılmadı ya da ödenmedi', '#ffc107'),
('Tamamlandı', 'İşlem tamamlandı', '#28a745'),
('İptal Edildi', 'İptal edildi', '#dc3545'),
('Planlandı', 'Gelecekte yapılması planlandı', '#17a2b8'),
('Devam Ediyor', 'İşlem devam ediyor', '#fd7e14'),
('Ertelendi', 'Daha sonraya ertelendi', '#6f42c1');

-- Insert default categories
INSERT INTO `categories` (`name`, `type`, `description`, `icon`, `color`) VALUES
('Sabit Giderler', 'sabit_gider', 'Aylık düzenli giderler', 'repeat', '#dc3545'),
('Değişken Giderler', 'degisken_gider', 'Aylık değişken giderler', 'trending_up', '#fd7e14'),
('Borç Ödemeleri', 'borc_odemesi', 'Borç ve kredi ödemeleri', 'account_balance', '#6f42c1'),
('Ani/Ekstra Harcama', 'ani_ekstra', 'Beklenmeyen harcamalar', 'flash_on', '#e83e8c'),
('Ertelenmiş', 'ertelenmis', 'Ertelenmiş harcamalar', 'schedule', '#6c757d'),
('Alınacak Ürünler', 'wishlist', 'İstek listesi ürünleri', 'shopping_cart', '#20c997');

-- Insert default account types
INSERT INTO `account_types` (`name`, `description`) VALUES
('İnternet Bankacılığı', 'Banka hesap bilgileri'),
('Mail', 'E-posta hesapları'),
('Sosyal Medya', 'Sosyal medya platformları'),
('Bahis Sitesi', 'Bahis ve oyun siteleri'),
('Abonelik Servisi', 'Aylık abonelik servisleri'),
('E-Ticaret', 'Alışveriş siteleri');

-- Insert default banks
INSERT INTO `banks` (`name`, `short_name`, `logo_path`) VALUES
('Türkiye Cumhuriyeti Ziraat Bankası', 'Ziraat', '/assets/images/banks/ziraat.png'),
('Türkiye İş Bankası', 'İşbank', '/assets/images/banks/isbank.png'),
('Garanti BBVA', 'Garanti', '/assets/images/banks/garanti.png'),
('Yapı ve Kredi Bankası', 'Yapı Kredi', '/assets/images/banks/yapikredi.png'),
('Akbank T.A.Ş.', 'Akbank', '/assets/images/banks/akbank.png'),
('Enpara.com', 'Enpara', '/assets/images/banks/enpara.png'),
('Denizbank', 'Denizbank', '/assets/images/banks/denizbank.png'),
('Vakıfbank', 'Vakıfbank', '/assets/images/banks/vakifbank.png');

-- Insert default admin user
INSERT INTO `users` (`username`, `email`, `password_hash`, `name`, `surname`, `role`, `status`) VALUES
('admin', 'admin@budget.local', '$2y$10$/z.lf3a6Xpp0nlJLYh41u.NrsEJoEjM7I2dpigX5DueLkZACqBIAG', 'System', 'Administrator', 'admin', 'active');

-- Insert default balance record
INSERT INTO `balances` (`user_id`, `total_balance`) VALUES (1, 0.00);

-- =====================================================
-- PERFORMANCE OPTIMIZATIONS
-- =====================================================

-- Additional indexes for better performance
ALTER TABLE `expense_items` ADD INDEX `idx_created_period` (`created_at`, `expense_period`);
ALTER TABLE `payments` ADD INDEX `idx_amount_status` (`amount`, `status_id`);
ALTER TABLE `wishlist_items` ADD INDEX `idx_price_type` (`price`, `wishlist_type`);
ALTER TABLE `login_logs` ADD INDEX `idx_status_date` (`status`, `created_at`);

-- =====================================================
-- VIEWS FOR COMMON QUERIES
-- =====================================================

-- Active expenses view
CREATE OR REPLACE VIEW `v_active_expenses` AS
SELECT 
    e.id,
    e.item_name,
    e.amount,
    c.name as category_name,
    c.type as category_type,
    s.name as status_name,
    s.color as status_color,
    e.created_at
FROM `expense_items` e
JOIN `categories` c ON e.category_id = c.id
JOIN `status_types` s ON e.status_id = s.id
WHERE s.name IN ('Beklemede', 'Devam Ediyor', 'Planlandı');

-- Monthly expense summary view
CREATE OR REPLACE VIEW `v_monthly_summary` AS
SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month,
    c.type as category_type,
    COUNT(*) as item_count,
    SUM(amount) as total_amount
FROM `expense_items` e
JOIN `categories` c ON e.category_id = c.id
GROUP BY DATE_FORMAT(created_at, '%Y-%m'), c.type
ORDER BY month DESC, category_type;

-- =====================================================
-- STORED PROCEDURES
-- =====================================================

DELIMITER //

-- Calculate user balance
CREATE PROCEDURE `CalculateUserBalance`(IN userId INT)
BEGIN
    DECLARE totalIncome DECIMAL(15,2) DEFAULT 0;
    DECLARE totalExpenses DECIMAL(15,2) DEFAULT 0;
    DECLARE currentBalance DECIMAL(15,2) DEFAULT 0;
    
    -- Calculate total income (payments)
    SELECT COALESCE(SUM(amount), 0) INTO totalIncome 
    FROM payments 
    WHERE user_id = userId AND status_id = (SELECT id FROM status_types WHERE name = 'Tamamlandı');
    
    -- Calculate total expenses
    SELECT COALESCE(SUM(amount), 0) INTO totalExpenses 
    FROM expense_items 
    WHERE user_id = userId AND status_id = (SELECT id FROM status_types WHERE name = 'Tamamlandı');
    
    SET currentBalance = totalIncome - totalExpenses;
    
    -- Update balance table
    INSERT INTO balances (user_id, total_balance) 
    VALUES (userId, currentBalance)
    ON DUPLICATE KEY UPDATE 
        total_balance = currentBalance,
        last_calculation = CURRENT_TIMESTAMP;
        
END //

DELIMITER ;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;