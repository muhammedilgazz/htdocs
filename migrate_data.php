<?php
/**
 * Data Migration Script
 * This script migrates data from old Turkish table names to new English table names
 */

require_once 'config/config.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Migration - Budget Management</title>
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
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0; }
        .stat-card { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; text-align: center; }
    </style>
</head>
<body>
    <h1>Data Migration from Old Tables to New Tables</h1>
    
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
    
    function getTableRowCount($pdo, $tableName) {
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
        logMessage("🚀 Starting data migration process...", 'info');
        
        // Connect to database
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASS;
        $dbname = DB_NAME;
        
        logMessage("📡 Connecting to database '$dbname'...", 'info');
        
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        logMessage("✅ Connected to database successfully", 'success');
        
        // Define table mappings and their migration strategies
        $migrations = [
            'bakiye' => [
                'target' => 'balances',
                'mapping' => [
                    'id' => 'id',
                    'toplam_bakiye' => 'total_balance',
                    'updated_at' => 'updated_at'
                ],
                'defaults' => [
                    'user_id' => 1,
                    'last_calculation' => 'NOW()'
                ]
            ],
            'harcama_kalemleri' => [
                'target' => 'expense_items',
                'mapping' => [
                    'id' => 'id',
                    'sira' => 'order_number',
                    'urun' => 'item_name',
                    'tutar' => 'amount',
                    'link' => 'link',
                    'aciklama' => 'description',
                    'created_at' => 'created_at',
                    'tur' => 'expense_type',
                    'erteleme_tarihi' => 'postpone_date',
                    'harcama_donemi' => 'expense_period'
                ],
                'transforms' => [
                    'expense_type' => "CASE 
                        WHEN tur = 'Aylık' THEN 'monthly' 
                        ELSE 'one_time' 
                    END",
                    'status_id' => "CASE 
                        WHEN durum = 'Tamamlandı' THEN 2
                        WHEN durum = 'Beklemede' THEN 1
                        WHEN durum = 'Ertelendi' THEN 3
                        WHEN durum = 'Planlandı' THEN 4
                        WHEN durum = 'Devam Ediyor' THEN 5
                        ELSE 1 
                    END",
                    'category_id' => "CASE 
                        WHEN kategori IN ('donanım', 'teknoloji', 'Teknoloji') THEN 1
                        WHEN kategori IN ('gıda', 'İhtiyaç') THEN 2
                        WHEN kategori IN ('ulaşım') THEN 3
                        WHEN kategori IN ('kişisel', 'Kişisel', 'Özel') THEN 4
                        WHEN kategori IN ('abonelikler', 'ödeme') THEN 5
                        ELSE 6 
                    END"
                ],
                'defaults' => [
                    'user_id' => 1
                ]
            ],
            'hesaplar_sifreler' => [
                'target' => 'account_credentials',
                'mapping' => [
                    'id' => 'id',
                    'platform' => 'platform_name',
                    'kullanici_adi' => 'username',
                    'giris_linki' => 'login_url',
                    'created_at' => 'created_at',
                    'password_hash' => 'password_hash'
                ],
                'transforms' => [
                    'account_type_id' => "CASE 
                        WHEN hesap_turu = 'İnternet Bankacılığı' THEN 1
                        WHEN hesap_turu = 'Mail' THEN 2
                        WHEN hesap_turu = 'Sosyal Medya' THEN 3
                        WHEN hesap_turu = 'Bahis Sitesi' THEN 6
                        ELSE 6 
                    END"
                ],
                'defaults' => [
                    'user_id' => 1
                ]
            ],
            'iban_bilgileri' => [
                'target' => 'iban_details',
                'mapping' => [
                    'id' => 'id',
                    'hesap_sahibi' => 'account_holder',
                    'iban' => 'iban_number',
                    'kolay_adres' => 'easy_address',
                    'banka' => 'bank_name',
                    'logo' => 'bank_logo',
                    'aciklama' => 'description',
                    'created_at' => 'created_at'
                ],
                'transforms' => [
                    'bank_id' => "CASE 
                        WHEN banka = 'Ziraat' THEN 1
                        WHEN banka = 'Akbank' THEN 2
                        WHEN banka = 'İsBankası' THEN 3
                        WHEN banka = 'Yapı Kredi' THEN 4
                        WHEN banka = 'Enpara' THEN 5
                        ELSE 5 
                    END",
                    'account_type' => "CASE 
                        WHEN hesap_turu = 'kendi' THEN 'own'
                        ELSE 'other' 
                    END"
                ],
                'defaults' => [
                    'user_id' => 1
                ]
            ],
            'istek_listesi' => [
                'target' => 'wishlist_items',
                'mapping' => [
                    'id' => 'id',
                    'ad' => 'item_name',
                    'kategori' => 'category',
                    'fiyat' => 'price',
                    'gorsel' => 'image_url',
                    'link' => 'product_url',
                    'created_at' => 'created_at'
                ],
                'transforms' => [
                    'priority' => "CASE 
                        WHEN will_get = 'yes' THEN 'high'
                        ELSE 'medium' 
                    END"
                ],
                'defaults' => [
                    'user_id' => 1,
                    'status' => 'active'
                ]
            ]
        ];
        
        $migrationStats = [];
        
        // Check which old tables exist
        logMessage("🔍 Checking existing tables...", 'info');
        
        foreach ($migrations as $oldTable => $config) {
            $oldExists = tableExists($pdo, $oldTable);
            $newExists = tableExists($pdo, $config['target']);
            $oldCount = getTableRowCount($pdo, $oldTable);
            $newCount = getTableRowCount($pdo, $config['target']);
            
            logMessage("📋 $oldTable → {$config['target']}: Old($oldCount) → New($newCount)", 
                $oldExists ? 'info' : 'warning');
            
            $migrationStats[$oldTable] = [
                'old_exists' => $oldExists,
                'new_exists' => $newExists,
                'old_count' => $oldCount,
                'new_count' => $newCount
            ];
        }
        
        echo "<div class='stats'>";
        foreach ($migrationStats as $table => $stats) {
            echo "<div class='stat-card'>";
            echo "<h4>$table</h4>";
            echo "<div>Old: {$stats['old_count']} rows</div>";
            echo "<div>New: {$stats['new_count']} rows</div>";
            echo "<div>" . ($stats['old_exists'] ? '✅ Exists' : '❌ Missing') . "</div>";
            echo "</div>";
        }
        echo "</div>";
        
        // Perform migrations
        logMessage("🔄 Starting data migration...", 'info');
        
        $totalMigrated = 0;
        $errors = [];
        
        foreach ($migrations as $oldTable => $config) {
            if (!$migrationStats[$oldTable]['old_exists']) {
                logMessage("⚠️ Skipping $oldTable - table doesn't exist", 'warning');
                continue;
            }
            
            if (!$migrationStats[$oldTable]['new_exists']) {
                logMessage("❌ Skipping $oldTable - target table {$config['target']} doesn't exist", 'error');
                continue;
            }
            
            try {
                logMessage("📦 Migrating $oldTable to {$config['target']}...", 'info');
                
                // Build SELECT statement
                $selectColumns = [];
                $insertColumns = [];
                $insertValues = [];
                
                // Regular column mappings
                foreach ($config['mapping'] as $oldCol => $newCol) {
                    $selectColumns[] = "`$oldCol`";
                    $insertColumns[] = "`$newCol`";
                    $insertValues[] = "?";
                }
                
                // Transformed columns
                if (isset($config['transforms'])) {
                    foreach ($config['transforms'] as $newCol => $transform) {
                        $selectColumns[] = "($transform)";
                        $insertColumns[] = "`$newCol`";
                        $insertValues[] = "?";
                    }
                }
                
                // Default columns
                if (isset($config['defaults'])) {
                    foreach ($config['defaults'] as $newCol => $defaultValue) {
                        $insertColumns[] = "`$newCol`";
                        if ($defaultValue === 'NOW()') {
                            $insertValues[] = "NOW()";
                        } else {
                            $insertValues[] = "?";
                        }
                    }
                }
                
                // Fetch data from old table
                $selectSql = "SELECT " . implode(', ', $selectColumns) . " FROM `$oldTable`";
                $stmt = $pdo->prepare($selectSql);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                
                if (empty($rows)) {
                    logMessage("⚠️ No data found in $oldTable", 'warning');
                    continue;
                }
                
                // Clear target table first
                $pdo->exec("DELETE FROM `{$config['target']}`");
                logMessage("🗑️ Cleared target table {$config['target']}", 'info');
                
                // Prepare insert statement
                $insertSql = "INSERT INTO `{$config['target']}` (" . 
                    implode(', ', $insertColumns) . ") VALUES (" . 
                    implode(', ', $insertValues) . ")";
                
                $insertStmt = $pdo->prepare($insertSql);
                
                $migratedCount = 0;
                foreach ($rows as $row) {
                    $values = array_values($row);
                    
                    // Add default values (except NOW() which is already in SQL)
                    if (isset($config['defaults'])) {
                        foreach ($config['defaults'] as $newCol => $defaultValue) {
                            if ($defaultValue !== 'NOW()') {
                                $values[] = $defaultValue;
                            }
                        }
                    }
                    
                    $insertStmt->execute($values);
                    $migratedCount++;
                }
                
                $totalMigrated += $migratedCount;
                logMessage("✅ Migrated $migratedCount rows from $oldTable to {$config['target']}", 'success');
                
            } catch (Exception $e) {
                $error = "❌ Error migrating $oldTable: " . $e->getMessage();
                logMessage($error, 'error');
                $errors[] = $error;
            }
        }
        
        // Final verification
        logMessage("🔍 Verifying migration results...", 'info');
        
        echo "<div class='stats'>";
        echo "<h3>Migration Results</h3>";
        foreach ($migrations as $oldTable => $config) {
            $newCount = getTableRowCount($pdo, $config['target']);
            echo "<div class='stat-card'>";
            echo "<h4>{$config['target']}</h4>";
            echo "<div>Final count: $newCount rows</div>";
            echo "</div>";
        }
        echo "</div>";
        
        if (!empty($errors)) {
            echo "<div class='log-entry error'>";
            echo "<h4>❌ Migration Errors:</h4>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
        
        echo "<br><div class='log-entry success'>";
        echo "<h3>🎉 Data Migration Complete!</h3>";
        echo "<p><strong>Summary:</strong></p>";
        echo "<ul>";
        echo "<li>✅ Total rows migrated: $totalMigrated</li>";
        echo "<li>✅ Tables processed: " . count($migrations) . "</li>";
        echo "<li>❌ Errors encountered: " . count($errors) . "</li>";
        echo "</ul>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ul>";
        echo "<li>1. <a href='update_table_names.php'>Update PHP files to use new table names</a></li>";
        echo "<li>2. <a href='index.php'>Test the application</a></li>";
        echo "<li>3. Backup old tables if needed</li>";
        echo "</ul>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
        
        echo "<br><div class='log-entry error'>";
        echo "<h3>❌ Migration Failed</h3>";
        echo "<p>An error occurred during data migration:</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
    
    ?>
    
</body>
</html>