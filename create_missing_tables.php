<?php
/**
 * Create Missing Tables
 */

require_once 'config/config.php';
require_once 'classes/Database.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Missing Tables</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
        .log-entry { margin: 10px 0; padding: 10px; border-left: 4px solid #ccc; background: #f8f9fa; }
        .log-entry.success { border-color: #28a745; }
        .log-entry.error { border-color: #dc3545; }
        .log-entry.warning { border-color: #ffc107; }
        .log-entry.info { border-color: #17a2b8; }
    </style>
</head>
<body>
    <h1>Create Missing Tables</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    function tableExists($pdo, $tableName) {
        try {
            $result = $pdo->query("SELECT 1 FROM `$tableName` LIMIT 1");
            return $result !== false;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    try {
        logMessage("🏗️ Creating missing tables...", 'info');
        
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        
        logMessage("✅ Connected to database", 'success');
        
        // Create account_credentials table
        if (!tableExists($pdo, 'account_credentials')) {
            logMessage("🔐 Creating account_credentials table...", 'warning');
            
            $sql = "
            CREATE TABLE `account_credentials` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT DEFAULT 1,
                `platform_name` VARCHAR(100) NOT NULL,
                `username` VARCHAR(100) NOT NULL,
                `login_url` TEXT DEFAULT NULL,
                `account_type_id` INT DEFAULT 6,
                `password_hash` VARCHAR(255) DEFAULT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_user` (`user_id`),
                INDEX `idx_platform` (`platform_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            $pdo->exec($sql);
            logMessage("✅ Created account_credentials table", 'success');
        } else {
            logMessage("✅ account_credentials table already exists", 'success');
        }
        
        // Create iban_details table
        if (!tableExists($pdo, 'iban_details')) {
            logMessage("🏦 Creating iban_details table...", 'warning');
            
            $sql = "
            CREATE TABLE `iban_details` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT DEFAULT 1,
                `account_holder` VARCHAR(100) NOT NULL,
                `iban_number` VARCHAR(50) DEFAULT NULL,
                `easy_address` VARCHAR(50) DEFAULT NULL,
                `bank_id` INT DEFAULT 5,
                `bank_name` VARCHAR(100) NOT NULL,
                `bank_logo` VARCHAR(255) DEFAULT NULL,
                `description` TEXT DEFAULT NULL,
                `account_type` ENUM('own', 'other') DEFAULT 'other',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_user` (`user_id`),
                INDEX `idx_bank` (`bank_id`),
                INDEX `idx_account_type` (`account_type`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            $pdo->exec($sql);
            logMessage("✅ Created iban_details table", 'success');
        } else {
            logMessage("✅ iban_details table already exists", 'success');
        }
        
        // Create notes table if not exists
        if (!tableExists($pdo, 'notes')) {
            logMessage("📝 Creating notes table...", 'warning');
            
            $sql = "
            CREATE TABLE `notes` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT DEFAULT 1,
                `title` VARCHAR(200) NOT NULL,
                `content` TEXT NOT NULL,
                `category` VARCHAR(50) DEFAULT 'Genel',
                `priority` ENUM('low', 'medium', 'high') DEFAULT 'medium',
                `status` ENUM('active', 'archived', 'deleted') DEFAULT 'active',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_user` (`user_id`),
                INDEX `idx_category` (`category`),
                INDEX `idx_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            $pdo->exec($sql);
            logMessage("✅ Created notes table", 'success');
        } else {
            logMessage("✅ notes table already exists", 'success');
        }
        
        // Create todos table if not exists
        if (!tableExists($pdo, 'todos')) {
            logMessage("✅ Creating todos table...", 'warning');
            
            $sql = "
            CREATE TABLE `todos` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT DEFAULT 1,
                `title` VARCHAR(200) NOT NULL,
                `description` TEXT DEFAULT NULL,
                `category` VARCHAR(50) DEFAULT 'Genel',
                `priority` ENUM('low', 'medium', 'high') DEFAULT 'medium',
                `status` ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
                `due_date` DATE DEFAULT NULL,
                `completed_at` TIMESTAMP NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_user` (`user_id`),
                INDEX `idx_status` (`status`),
                INDEX `idx_due_date` (`due_date`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            $pdo->exec($sql);
            logMessage("✅ Created todos table", 'success');
        } else {
            logMessage("✅ todos table already exists", 'success');
        }
        
        // Create payments table if not exists
        if (!tableExists($pdo, 'payments')) {
            logMessage("💳 Creating payments table...", 'warning');
            
            $sql = "
            CREATE TABLE `payments` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT DEFAULT 1,
                `person_name` VARCHAR(100) NOT NULL,
                `iban` VARCHAR(50) DEFAULT NULL,
                `amount` DECIMAL(10,2) NOT NULL,
                `description` TEXT DEFAULT NULL,
                `due_date` DATE DEFAULT NULL,
                `payment_date` DATE DEFAULT NULL,
                `status_id` INT DEFAULT 1,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_user` (`user_id`),
                INDEX `idx_status` (`status_id`),
                INDEX `idx_due_date` (`due_date`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            $pdo->exec($sql);
            logMessage("✅ Created payments table", 'success');
        } else {
            logMessage("✅ payments table already exists", 'success');
        }
        
        // Verify all tables exist now
        logMessage("🔍 Verifying all tables...", 'info');
        
        $required_tables = [
            'users', 'categories', 'status_types', 'account_types', 'banks',
            'balances', 'expense_items', 'wishlist_items', 'account_credentials',
            'iban_details', 'notes', 'todos', 'payments'
        ];
        
        $missing_tables = [];
        $existing_tables = [];
        
        foreach ($required_tables as $table) {
            if (tableExists($pdo, $table)) {
                $existing_tables[] = $table;
            } else {
                $missing_tables[] = $table;
            }
        }
        
        echo "<div class='log-entry info'>";
        echo "<h4>📊 Table Status:</h4>";
        echo "<p><strong>Existing tables (" . count($existing_tables) . "):</strong> " . implode(', ', $existing_tables) . "</p>";
        if (!empty($missing_tables)) {
            echo "<p><strong>Missing tables (" . count($missing_tables) . "):</strong> " . implode(', ', $missing_tables) . "</p>";
        }
        echo "</div>";
        
        if (empty($missing_tables)) {
            echo "<br><div class='log-entry success'>";
            echo "<h3>🎉 All Tables Created Successfully!</h3>";
            echo "<p>All required tables are now present in the database.</p>";
            echo "<p><strong>Next Steps:</strong></p>";
            echo "<ul>";
            echo "<li>✅ All tables created</li>";
            echo "<li>🔄 <a href='import_from_butce.php'>Run data import now</a></li>";
            echo "</ul>";
            echo "</div>";
        } else {
            echo "<br><div class='log-entry warning'>";
            echo "<h3>⚠️ Some Tables Still Missing</h3>";
            echo "<p>You may need to run the complete database setup script.</p>";
            echo "<p><a href='create_db.php'>🔄 Run Complete Database Setup</a></p>";
            echo "</div>";
        }
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
        
        echo "<br><div class='log-entry error'>";
        echo "<h3>❌ Table Creation Failed</h3>";
        echo "<p>An error occurred during table creation:</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
    
    ?>
    
</body>
</html>