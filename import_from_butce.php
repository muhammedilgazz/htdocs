<?php
/**
 * Import Data from 'butce' Database to 'budget' Database
 * This script imports data from the old butce database to the new budget database
 */

require_once 'config/config.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import from Butce Database</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 50px auto; padding: 20px; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
        .log-entry { margin: 10px 0; padding: 10px; border-left: 4px solid #ccc; background: #f8f9fa; }
        .log-entry.success { border-color: #28a745; }
        .log-entry.error { border-color: #dc3545; }
        .log-entry.warning { border-color: #ffc107; }
        .log-entry.info { border-color: #17a2b8; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .stat-card { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; text-align: center; }
    </style>
</head>
<body>
    <h1>Import Data from 'butce' Database to 'budget' Database</h1>
    
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
    
    function getRowCount($pdo, $tableName) {
        try {
            if (!tableExists($pdo, $tableName)) {
                return 0;
            }
            $result = $pdo->query("SELECT COUNT(*) FROM `$tableName`");
            return $result->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    try {
        logMessage("🚀 Starting data import from 'butce' to 'budget'...", 'info');
        
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASS;
        
        // Connect to butce database
        logMessage("📡 Connecting to 'butce' database...", 'info');
        try {
            $butce_pdo = new PDO("mysql:host=$host;dbname=butce;charset=utf8mb4", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            logMessage("✅ Connected to 'butce' database", 'success');
        } catch (PDOException $e) {
            logMessage("❌ Could not connect to 'butce' database: " . $e->getMessage(), 'error');
            logMessage("ℹ️ This might mean 'butce' database doesn't exist or data is in a SQL file", 'info');
            
            // Try to import from SQL file instead
            $sqlFile = __DIR__ . '/butce.sql';
            if (file_exists($sqlFile)) {
                logMessage("📁 Found butce.sql file, will import from there", 'info');
                
                // Connect to budget database
                $budget_pdo = new PDO("mysql:host=$host;dbname=budget;charset=utf8mb4", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
                
                logMessage("📄 Reading SQL file...", 'info');
                $sql = file_get_contents($sqlFile);
                
                // Create temporary database to import butce.sql
                logMessage("🏗️ Creating temporary 'butce_temp' database...", 'info');
                $budget_pdo->exec("DROP DATABASE IF EXISTS butce_temp");
                $budget_pdo->exec("CREATE DATABASE butce_temp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                // Connect to temp database
                $butce_pdo = new PDO("mysql:host=$host;dbname=butce_temp;charset=utf8mb4", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
                
                // Import SQL file into temp database
                logMessage("📥 Importing SQL file into temporary database...", 'info');
                
                // Remove database creation commands from SQL
                $sql = preg_replace('/CREATE DATABASE.*?;/s', '', $sql);
                $sql = preg_replace('/USE `.*?`;/s', '', $sql);
                
                // Split and execute statements
                $statements = explode(';', $sql);
                $imported_statements = 0;
                
                foreach ($statements as $statement) {
                    $statement = trim($statement);
                    if (empty($statement) || strpos($statement, '--') === 0 || strpos($statement, '/*') === 0) {
                        continue;
                    }
                    
                    try {
                        $butce_pdo->exec($statement);
                        $imported_statements++;
                    } catch (PDOException $e) {
                        // Skip errors for already existing data
                        if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                            logMessage("⚠️ SQL Error: " . $e->getMessage(), 'warning');
                        }
                    }
                }
                
                logMessage("✅ Imported $imported_statements SQL statements", 'success');
            } else {
                throw new Exception("Could not connect to 'butce' database and butce.sql file not found");
            }
        }
        
        // Connect to budget database
        logMessage("📡 Connecting to 'budget' database...", 'info');
        $budget_pdo = new PDO("mysql:host=$host;dbname=budget;charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        logMessage("✅ Connected to 'budget' database", 'success');
        
        // Check source data
        logMessage("🔍 Checking source data...", 'info');
        
        $source_tables = [
            'bakiye' => getRowCount($butce_pdo, 'bakiye'),
            'harcama_kalemleri' => getRowCount($butce_pdo, 'harcama_kalemleri'),
            'hesaplar_sifreler' => getRowCount($butce_pdo, 'hesaplar_sifreler'),
            'iban_bilgileri' => getRowCount($butce_pdo, 'iban_bilgileri'),
            'istek_listesi' => getRowCount($butce_pdo, 'istek_listesi')
        ];
        
        echo "<div class='stats'>";
        echo "<h3>Source Data (from butce database)</h3>";
        foreach ($source_tables as $table => $count) {
            echo "<div class='stat-card'>";
            echo "<h4>$table</h4>";
            echo "<div>" . ($count > 0 ? "✅ $count rows" : "⚪ Empty") . "</div>";
            echo "</div>";
        }
        echo "</div>";
        
        $total_rows_to_import = array_sum($source_tables);
        logMessage("📊 Total rows to import: $total_rows_to_import", 'info');
        
        if ($total_rows_to_import == 0) {
            logMessage("⚠️ No data found to import", 'warning');
            exit;
        }
        
        // Start migration
        logMessage("🔄 Starting data migration...", 'info');
        
        $imported_totals = [];
        
        // 1. Import balances (bakiye -> balances)
        if ($source_tables['bakiye'] > 0) {
            logMessage("💰 Importing balances...", 'info');
            
            $source_data = $butce_pdo->query("SELECT * FROM bakiye")->fetchAll();
            $budget_pdo->exec("DELETE FROM balances");
            
            $stmt = $budget_pdo->prepare("INSERT INTO balances (id, user_id, total_balance, last_calculation, updated_at) VALUES (?, 1, ?, NOW(), ?)");
            
            $imported = 0;
            foreach ($source_data as $row) {
                $stmt->execute([
                    $row['id'],
                    $row['toplam_bakiye'],
                    $row['updated_at']
                ]);
                $imported++;
            }
            
            $imported_totals['balances'] = $imported;
            logMessage("✅ Imported $imported balance records", 'success');
        }
        
        // 2. Import expense items (harcama_kalemleri -> expense_items)
        if ($source_tables['harcama_kalemleri'] > 0) {
            logMessage("💸 Importing expense items...", 'info');
            
            $source_data = $butce_pdo->query("SELECT * FROM harcama_kalemleri")->fetchAll();
            $budget_pdo->exec("DELETE FROM expense_items");
            
            $stmt = $budget_pdo->prepare("
                INSERT INTO expense_items (
                    id, order_number, category_id, item_name, amount, link, description, 
                    status_id, user_id, expense_type, expense_period, postpone_date, created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?)
            ");
            
            $imported = 0;
            foreach ($source_data as $row) {
                // Map status to status_id
                $status_id = 1; // Default: Beklemede
                switch ($row['durum']) {
                    case 'Tamamlandı': $status_id = 2; break;
                    case 'Ertelendi': $status_id = 3; break;
                    case 'Planlandı': $status_id = 4; break;
                    case 'Devam Ediyor': $status_id = 5; break;
                }
                
                // Map category to category_id
                $category_id = 6; // Default: Diğer
                switch (strtolower($row['kategori'])) {
                    case 'donanım':
                    case 'teknoloji': $category_id = 1; break;
                    case 'gıda':
                    case 'ihtiyaç': $category_id = 2; break;
                    case 'ulaşım': $category_id = 3; break;
                    case 'kişisel':
                    case 'özel': $category_id = 4; break;
                    case 'abonelikler':
                    case 'ödeme': $category_id = 5; break;
                }
                
                // Map expense type
                $expense_type = ($row['tur'] == 'Aylık') ? 'monthly' : 'one_time';
                
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
            
            $imported_totals['expense_items'] = $imported;
            logMessage("✅ Imported $imported expense items", 'success');
        }
        
        // 3. Import wishlist items (istek_listesi -> wishlist_items)
        if ($source_tables['istek_listesi'] > 0) {
            logMessage("🛍️ Importing wishlist items...", 'info');
            
            $source_data = $butce_pdo->query("SELECT * FROM istek_listesi")->fetchAll();
            $budget_pdo->exec("DELETE FROM wishlist_items");
            
            $stmt = $budget_pdo->prepare("
                INSERT INTO wishlist_items (
                    id, user_id, item_name, category, price, image_url, product_url, 
                    priority, status, created_at
                ) VALUES (?, 1, ?, ?, ?, ?, ?, ?, 'active', ?)
            ");
            
            $imported = 0;
            foreach ($source_data as $row) {
                $priority = ($row['will_get'] == 'yes') ? 'high' : 'medium';
                
                $stmt->execute([
                    $row['id'],
                    $row['ad'],
                    $row['kategori'],
                    $row['fiyat'],
                    $row['gorsel'],
                    $row['link'],
                    $priority,
                    $row['created_at']
                ]);
                $imported++;
            }
            
            $imported_totals['wishlist_items'] = $imported;
            logMessage("✅ Imported $imported wishlist items", 'success');
        }
        
        // 4. Import account credentials (hesaplar_sifreler -> account_credentials)
        if ($source_tables['hesaplar_sifreler'] > 0) {
            logMessage("🔐 Importing account credentials...", 'info');
            
            $source_data = $butce_pdo->query("SELECT * FROM hesaplar_sifreler")->fetchAll();
            $budget_pdo->exec("DELETE FROM account_credentials");
            
            $stmt = $budget_pdo->prepare("
                INSERT INTO account_credentials (
                    id, user_id, platform_name, username, login_url, account_type_id, 
                    password_hash, created_at
                ) VALUES (?, 1, ?, ?, ?, ?, ?, ?)
            ");
            
            $imported = 0;
            foreach ($source_data as $row) {
                // Map account type
                $account_type_id = 6; // Default: Diğer
                switch ($row['hesap_turu']) {
                    case 'İnternet Bankacılığı': $account_type_id = 1; break;
                    case 'Mail': $account_type_id = 2; break;
                    case 'Sosyal Medya': $account_type_id = 3; break;
                    case 'Bahis Sitesi': $account_type_id = 6; break;
                }
                
                $stmt->execute([
                    $row['id'],
                    $row['platform'],
                    $row['kullanici_adi'],
                    $row['giris_linki'],
                    $account_type_id,
                    $row['password_hash'],
                    $row['created_at']
                ]);
                $imported++;
            }
            
            $imported_totals['account_credentials'] = $imported;
            logMessage("✅ Imported $imported account credentials", 'success');
        }
        
        // 5. Import IBAN details (iban_bilgileri -> iban_details)
        if ($source_tables['iban_bilgileri'] > 0) {
            logMessage("🏦 Importing IBAN details...", 'info');
            
            $source_data = $butce_pdo->query("SELECT * FROM iban_bilgileri")->fetchAll();
            $budget_pdo->exec("DELETE FROM iban_details");
            
            $stmt = $budget_pdo->prepare("
                INSERT INTO iban_details (
                    id, user_id, account_holder, iban_number, easy_address, bank_id, 
                    bank_name, bank_logo, description, account_type, created_at
                ) VALUES (?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $imported = 0;
            foreach ($source_data as $row) {
                // Map bank to bank_id
                $bank_id = 5; // Default: Diğer
                switch (strtolower($row['banka'])) {
                    case 'ziraat': $bank_id = 1; break;
                    case 'akbank': $bank_id = 2; break;
                    case 'işbankası':
                    case 'isbankası': $bank_id = 3; break;
                    case 'yapı kredi': $bank_id = 4; break;
                    case 'enpara': $bank_id = 5; break;
                }
                
                $account_type = ($row['hesap_turu'] == 'kendi') ? 'own' : 'other';
                
                $stmt->execute([
                    $row['id'],
                    $row['hesap_sahibi'],
                    $row['iban'],
                    $row['kolay_adres'],
                    $bank_id,
                    $row['banka'],
                    $row['logo'],
                    $row['aciklama'],
                    $account_type,
                    $row['created_at']
                ]);
                $imported++;
            }
            
            $imported_totals['iban_details'] = $imported;
            logMessage("✅ Imported $imported IBAN details", 'success');
        }
        
        // Cleanup temporary database
        if (isset($butce_pdo) && strpos($butce_pdo->query("SELECT DATABASE()")->fetchColumn(), 'temp') !== false) {
            logMessage("🗑️ Cleaning up temporary database...", 'info');
            $budget_pdo->exec("DROP DATABASE IF EXISTS butce_temp");
        }
        
        // Final summary
        $total_imported = array_sum($imported_totals);
        
        echo "<div class='stats'>";
        echo "<h3>Import Results</h3>";
        foreach ($imported_totals as $table => $count) {
            echo "<div class='stat-card'>";
            echo "<h4>$table</h4>";
            echo "<div class='success'>✅ $count rows</div>";
            echo "</div>";
        }
        echo "</div>";
        
        echo "<br><div class='log-entry success'>";
        echo "<h3>🎉 Data Import Complete!</h3>";
        echo "<p><strong>Summary:</strong></p>";
        echo "<ul>";
        echo "<li>✅ Total imported: $total_imported rows</li>";
        echo "<li>✅ Tables updated: " . count($imported_totals) . "</li>";
        echo "<li>✅ Data mapping applied for categories, statuses, and types</li>";
        echo "</ul>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ul>";
        echo "<li>1. <a href='index.php'>🚀 Test your application</a></li>";
        echo "<li>2. Check that all data appears correctly</li>";
        echo "<li>3. Verify functionality works as expected</li>";
        echo "</ul>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
        
        echo "<br><div class='log-entry error'>";
        echo "<h3>❌ Import Failed</h3>";
        echo "<p>An error occurred during data import:</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
    
    ?>
    
</body>
</html>