<?php
/**
 * Gelirler tablosu kurulum scripti
 * Bu dosyayı çalıştırarak incomes tablosunu oluşturabilirsiniz
 */

require_once __DIR__ . '/bootstrap.php';

use App\Core\DatabaseConnection;

try {
    $pdo = DatabaseConnection::getPDO();
    
    // Tablo oluşturma SQL'i
    $createTableSQL = "
    CREATE TABLE IF NOT EXISTS `incomes` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `title` varchar(255) NOT NULL,
      `currency` varchar(10) NOT NULL DEFAULT 'TRY',
      `amount` decimal(10,2) NOT NULL,
      `period` enum('daily','weekly','monthly','yearly','one_time') NOT NULL DEFAULT 'monthly',
      `receive_date` date NOT NULL,
      `is_debt` enum('yes','no') NOT NULL DEFAULT 'no',
      `description` text,
      `status` enum('active','inactive','pending') NOT NULL DEFAULT 'active',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_user_id` (`user_id`),
      KEY `idx_period` (`period`),
      KEY `idx_receive_date` (`receive_date`),
      KEY `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    // Tabloyu oluştur
    $pdo->exec($createTableSQL);
    echo "✅ Incomes tablosu başarıyla oluşturuldu.\n";
    
    // Örnek veri ekleme
    $insertSampleSQL = "
    INSERT INTO `incomes` (`user_id`, `title`, `currency`, `amount`, `period`, `receive_date`, `is_debt`, `description`, `status`) VALUES
    (1, 'USA Kira', 'USD', 2194.00, 'monthly', '2025-08-07', 'no', 'Amerika\'daki ev kirası', 'active')
    ON DUPLICATE KEY UPDATE id=id;
    ";
    
    $pdo->exec($insertSampleSQL);
    echo "✅ Örnek veri başarıyla eklendi.\n";
    
    // Tablo yapısını kontrol et
    $result = $pdo->query("DESCRIBE incomes");
    echo "\n📋 Tablo yapısı:\n";
    echo str_repeat("-", 50) . "\n";
    while ($row = $result->fetch()) {
        printf("%-15s %-15s %-10s %-10s\n", 
            $row['Field'], 
            $row['Type'], 
            $row['Null'], 
            $row['Key']
        );
    }
    
    // Veri sayısını kontrol et
    $count = $pdo->query("SELECT COUNT(*) as count FROM incomes")->fetch()['count'];
    echo "\n📊 Toplam kayıt sayısı: $count\n";
    
    echo "\n🎉 Gelirler modülü başarıyla kuruldu!\n";
    
} catch (Exception $e) {
    echo "❌ Hata: " . $e->getMessage() . "\n";
    exit(1);
} 