<?php
/**
 * Check Database Tables and Data
 */

require_once 'config/config.php';
require_once 'classes/Database.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Data Check</title>
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
        .table-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin: 20px 0; }
        .table-card { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; }
        .table-card h4 { margin-top: 0; color: #495057; }
        .data-sample { background: #fff; border: 1px solid #ddd; padding: 10px; margin: 10px 0; font-size: 12px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Database Data Check</h1>
    
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
    
    function getSampleData($pdo, $tableName, $limit = 3) {
        try {
            if (!tableExists($pdo, $tableName)) {
                return [];
            }
            $stmt = $pdo->query("SELECT * FROM `$tableName` LIMIT $limit");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    try {
        logMessage("🔍 Checking database tables and data...", 'info');
        
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        
        logMessage("✅ Connected to database: " . DB_NAME, 'success');
        
        // Check both old and new tables
        $tables_to_check = [
            'Old Tables' => [
                'bakiye',
                'harcama_kalemleri', 
                'hesaplar_sifreler',
                'iban_bilgileri',
                'istek_listesi'
            ],
            'New Tables' => [
                'balances',
                'expense_items',
                'account_credentials', 
                'iban_details',
                'wishlist_items',
                'categories',
                'status_types',
                'users'
            ]
        ];
        
        foreach ($tables_to_check as $section => $tables) {
            echo "<h3>$section</h3>";
            echo "<div class='table-info'>";
            
            foreach ($tables as $table) {
                $exists = tableExists($pdo, $table);
                $count = getTableRowCount($pdo, $table);
                $sample = getSampleData($pdo, $table, 2);
                
                echo "<div class='table-card'>";
                echo "<h4>$table</h4>";
                
                if ($exists) {
                    echo "<div class='success'>✅ Exists ($count rows)</div>";
                    
                    if ($count > 0 && !empty($sample)) {
                        echo "<div class='data-sample'>";
                        echo "<strong>Sample Data:</strong><br>";
                        foreach ($sample as $i => $row) {
                            echo "Row " . ($i + 1) . ": ";
                            $displayRow = [];
                            foreach ($row as $key => $value) {
                                if (strlen($value) > 30) {
                                    $value = substr($value, 0, 30) . '...';
                                }
                                $displayRow[] = "$key: $value";
                            }
                            echo implode(', ', array_slice($displayRow, 0, 3)) . "<br>";
                        }
                        echo "</div>";
                    } else if ($count == 0) {
                        echo "<div class='warning'>⚠️ Table is empty</div>";
                    }
                } else {
                    echo "<div class='error'>❌ Does not exist</div>";
                }
                
                echo "</div>";
            }
            
            echo "</div>";
        }
        
        // Check which tables have data that needs to be migrated
        logMessage("📊 Migration Analysis:", 'info');
        
        $old_tables_with_data = [];
        foreach ($tables_to_check['Old Tables'] as $table) {
            $count = getTableRowCount($pdo, $table);
            if ($count > 0) {
                $old_tables_with_data[] = "$table ($count rows)";
            }
        }
        
        $new_tables_with_data = [];
        foreach ($tables_to_check['New Tables'] as $table) {
            $count = getTableRowCount($pdo, $table);
            if ($count > 0) {
                $new_tables_with_data[] = "$table ($count rows)";
            }
        }
        
        echo "<div class='log-entry info'>";
        echo "<h4>📋 Migration Status:</h4>";
        echo "<p><strong>Old tables with data:</strong> " . (empty($old_tables_with_data) ? 'None' : implode(', ', $old_tables_with_data)) . "</p>";
        echo "<p><strong>New tables with data:</strong> " . (empty($new_tables_with_data) ? 'None' : implode(', ', $new_tables_with_data)) . "</p>";
        echo "</div>";
        
        if (!empty($old_tables_with_data) && empty(array_intersect(['expense_items', 'balances', 'wishlist_items'], explode(' ', implode(' ', $new_tables_with_data))))) {
            echo "<div class='log-entry warning'>";
            echo "<h4>⚠️ Migration Needed</h4>";
            echo "<p>Old tables contain data but new tables are empty. You need to migrate the data.</p>";
            echo "<p><a href='migrate_data.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Start Data Migration</a></p>";
            echo "</div>";
        } else if (!empty($new_tables_with_data)) {
            echo "<div class='log-entry success'>";
            echo "<h4>✅ Data Available</h4>";
            echo "<p>New tables contain data. Your application should work properly.</p>";
            echo "<p><a href='index.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🎯 Go to Application</a></p>";
            echo "</div>";
        }
        
    } catch (Exception $e) {
        logMessage("💥 Error: " . $e->getMessage(), 'error');
    }
    
    ?>
    
</body>
</html>