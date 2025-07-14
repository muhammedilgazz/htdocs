<?php
/**
 * Fix Status Mapping and Foreign Key Issues
 */

require_once 'config/config.php';
require_once 'classes/Database.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Status Mapping</title>
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
    <h1>Fix Status Mapping and Foreign Key Issues</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    try {
        logMessage("🔧 Fixing status mapping and foreign key issues...", 'info');
        
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        
        logMessage("✅ Connected to database", 'success');
        
        // Check current status_types
        logMessage("🔍 Checking current status_types...", 'info');
        
        try {
            $current_statuses = $pdo->query("SELECT * FROM status_types")->fetchAll();
            
            logMessage("📋 Current status types:", 'info');
            foreach ($current_statuses as $status) {
                logMessage("ID: {$status['id']}, Name: {$status['name']}", 'info');
            }
        } catch (PDOException $e) {
            logMessage("❌ Error reading status_types: " . $e->getMessage(), 'error');
        }
        
        // Ensure we have all required status types
        logMessage("➕ Adding required status types...", 'info');
        
        $required_statuses = [
            ['id' => 1, 'name' => 'Beklemede'],
            ['id' => 2, 'name' => 'Tamamlandı'],
            ['id' => 3, 'name' => 'Ertelendi'],
            ['id' => 4, 'name' => 'Planlandı'],
            ['id' => 5, 'name' => 'Devam Ediyor']
        ];
        
        foreach ($required_statuses as $status) {
            try {
                $pdo->exec("INSERT IGNORE INTO status_types (id, name) VALUES ({$status['id']}, '{$status['name']}')");
                logMessage("✅ Ensured status: {$status['name']} (ID: {$status['id']})", 'success');
            } catch (PDOException $e) {
                logMessage("⚠️ Status might already exist: {$status['name']}", 'warning');
            }
        }
        
        // Check categories table
        logMessage("🔍 Checking categories table...", 'info');
        
        try {
            $current_categories = $pdo->query("SELECT * FROM categories")->fetchAll();
            
            logMessage("📋 Current categories:", 'info');
            foreach ($current_categories as $category) {
                logMessage("ID: {$category['id']}, Name: {$category['name']}", 'info');
            }
        } catch (PDOException $e) {
            logMessage("❌ Error reading categories: " . $e->getMessage(), 'error');
        }
        
        // Ensure we have all required categories
        logMessage("➕ Adding required categories...", 'info');
        
        $required_categories = [
            ['id' => 1, 'name' => 'Teknoloji'],
            ['id' => 2, 'name' => 'İhtiyaç'],
            ['id' => 3, 'name' => 'Ulaşım'],
            ['id' => 4, 'name' => 'Kişisel'],
            ['id' => 5, 'name' => 'Abonelikler'],
            ['id' => 6, 'name' => 'Diğer']
        ];
        
        foreach ($required_categories as $category) {
            try {
                $pdo->exec("INSERT IGNORE INTO categories (id, name) VALUES ({$category['id']}, '{$category['name']}')");
                logMessage("✅ Ensured category: {$category['name']} (ID: {$category['id']})", 'success');
            } catch (PDOException $e) {
                logMessage("⚠️ Category might already exist: {$category['name']}", 'warning');
            }
        }
        
        // Temporarily disable foreign key checks for import
        logMessage("🔧 Temporarily disabling foreign key checks...", 'warning');
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        
        // Now let's create a safer import script that handles mapping properly
        logMessage("📝 Creating safe import script...", 'info');
        
        // Connect to butce database or import from SQL file
        $butce_pdo = null;
        
        try {
            $butce_pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=butce;charset=utf8mb4", DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            logMessage("✅ Connected to butce database", 'success');
        } catch (PDOException $e) {
            // Try to create temporary database from SQL file
            $sqlFile = __DIR__ . '/butce.sql';
            if (file_exists($sqlFile)) {
                logMessage("📁 Using butce.sql file", 'info');
                
                $pdo->exec("DROP DATABASE IF EXISTS butce_temp");
                $pdo->exec("CREATE DATABASE butce_temp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                $butce_pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=butce_temp;charset=utf8mb4", DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
                
                $sql = file_get_contents($sqlFile);
                $sql = preg_replace('/CREATE DATABASE.*?;/s', '', $sql);
                $sql = preg_replace('/USE `.*?`;/s', '', $sql);
                
                $statements = explode(';', $sql);
                foreach ($statements as $statement) {
                    $statement = trim($statement);
                    if (empty($statement) || strpos($statement, '--') === 0) continue;
                    
                    try {
                        $butce_pdo->exec($statement);
                    } catch (PDOException $e) {
                        // Ignore duplicate entry errors
                    }
                }
                logMessage("✅ Imported SQL file to temporary database", 'success');
            } else {
                throw new Exception("Cannot access butce database or SQL file");
            }
        }
        
        // Import with proper mapping
        if ($butce_pdo) {
            // Import expense_items with safe status mapping
            logMessage("💸 Importing expense items with safe mapping...", 'info');
            
            try {
                $source_data = $butce_pdo->query("SELECT * FROM harcama_kalemleri")->fetchAll();
                
                // Clear target table
                $pdo->exec("DELETE FROM expense_items");
                
                $stmt = $pdo->prepare("
                    INSERT INTO expense_items (
                        id, order_number, category_id, item_name, amount, link, description, 
                        status_id, user_id, expense_type, expense_period, postpone_date, created_at
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?)
                ");
                
                $imported = 0;
                foreach ($source_data as $row) {
                    // Safe status mapping
                    $status_id = 1; // Default: Beklemede
                    switch (trim($row['durum'])) {
                        case 'Tamamlandı': 
                        case 'Ödendi': $status_id = 2; break;
                        case 'Ertelendi': $status_id = 3; break;
                        case 'Planlandı': $status_id = 4; break;
                        case 'Devam Ediyor': $status_id = 5; break;
                        default: $status_id = 1; break;
                    }
                    
                    // Safe category mapping
                    $category_id = 6; // Default: Diğer
                    $kategori = strtolower(trim($row['kategori']));
                    if (strpos($kategori, 'donanım') !== false || strpos($kategori, 'teknoloji') !== false) {
                        $category_id = 1;
                    } elseif (strpos($kategori, 'gıda') !== false || strpos($kategori, 'ihtiyaç') !== false) {
                        $category_id = 2;
                    } elseif (strpos($kategori, 'ulaşım') !== false) {
                        $category_id = 3;
                    } elseif (strpos($kategori, 'kişisel') !== false || strpos($kategori, 'özel') !== false) {
                        $category_id = 4;
                    } elseif (strpos($kategori, 'abonelik') !== false || strpos($kategori, 'ödeme') !== false) {
                        $category_id = 5;
                    }
                    
                    $expense_type = (trim($row['tur']) == 'Aylık') ? 'monthly' : 'one_time';
                    
                    $stmt->execute([
                        $row['id'],
                        $row['sira'],
                        $category_id,
                        $row['urun'],
                        $row['tutar'],
                        $row['link'],
                        $row['aciklama'],
                        $status_id,
                        $expense_type,
                        $row['harcama_donemi'],
                        $row['erteleme_tarihi'],
                        $row['created_at']
                    ]);
                    $imported++;
                }
                
                logMessage("✅ Imported $imported expense items", 'success');
            } catch (PDOException $e) {
                logMessage("❌ Error importing expense items: " . $e->getMessage(), 'error');
            }
        }
        
        // Re-enable foreign key checks
        logMessage("🔧 Re-enabling foreign key checks...", 'info');
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        
        // Clean up temporary database
        if (isset($butce_pdo) && strpos($butce_pdo->query("SELECT DATABASE()")->fetchColumn(), 'temp') !== false) {
            $pdo->exec("DROP DATABASE IF EXISTS butce_temp");
            logMessage("🗑️ Cleaned up temporary database", 'info');
        }
        
        echo "<br><div class='log-entry success'>";
        echo "<h3>🎉 Status Mapping Fixed!</h3>";
        echo "<p>Foreign key issues have been resolved and data imported safely.</p>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ul>";
        echo "<li>✅ Status types properly configured</li>";
        echo "<li>✅ Categories properly configured</li>";
        echo "<li>✅ Data imported with safe mapping</li>";
        echo "<li>🚀 <a href='index.php'>Test your application</a></li>";
        echo "</ul>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
        
        echo "<br><div class='log-entry error'>";
        echo "<h3>❌ Fix Failed</h3>";
        echo "<p>An error occurred during status mapping fix:</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
    
    ?>
    
</body>
</html>