<?php
/**
 * Check IBAN Data
 */

require_once 'config/config.php';
require_once 'classes/Database.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IBAN Data Check</title>
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
        .data-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <h1>IBAN Data Check</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    try {
        logMessage("🔍 Checking IBAN data...", 'info');
        
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        
        // Check iban_details table structure
        logMessage("📋 Checking iban_details table structure...", 'info');
        
        try {
            $columns = $pdo->query("DESCRIBE iban_details")->fetchAll();
            
            echo "<table class='data-table'>";
            echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
            foreach ($columns as $column) {
                echo "<tr>";
                echo "<td>{$column['Field']}</td>";
                echo "<td>{$column['Type']}</td>";
                echo "<td>{$column['Null']}</td>";
                echo "<td>{$column['Key']}</td>";
                echo "<td>{$column['Default']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } catch (PDOException $e) {
            logMessage("❌ Error checking table structure: " . $e->getMessage(), 'error');
        }
        
        // Check data count
        logMessage("📊 Checking data count...", 'info');
        
        try {
            $count = $pdo->query("SELECT COUNT(*) FROM iban_details")->fetchColumn();
            logMessage("📈 Total records in iban_details: $count", $count > 0 ? 'success' : 'warning');
            
            if ($count > 0) {
                // Show sample data
                logMessage("📄 Sample data from iban_details:", 'info');
                
                $sample = $pdo->query("SELECT * FROM iban_details LIMIT 3")->fetchAll();
                
                if (!empty($sample)) {
                    echo "<table class='data-table'>";
                    echo "<tr>";
                    foreach (array_keys($sample[0]) as $header) {
                        echo "<th>$header</th>";
                    }
                    echo "</tr>";
                    
                    foreach ($sample as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
            
        } catch (PDOException $e) {
            logMessage("❌ Error checking data: " . $e->getMessage(), 'error');
        }
        
        // Check if butce database has data to import
        logMessage("🔍 Checking source data (butce)...", 'info');
        
        try {
            // Try to connect to butce database
            $butce_pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=butce;charset=utf8mb4", DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            
            $butce_count = $butce_pdo->query("SELECT COUNT(*) FROM iban_bilgileri")->fetchColumn();
            logMessage("📈 Records in butce.iban_bilgileri: $butce_count", $butce_count > 0 ? 'success' : 'warning');
            
            if ($butce_count > 0) {
                $butce_sample = $butce_pdo->query("SELECT * FROM iban_bilgileri LIMIT 3")->fetchAll();
                
                logMessage("📄 Sample data from butce.iban_bilgileri:", 'info');
                echo "<table class='data-table'>";
                echo "<tr>";
                foreach (array_keys($butce_sample[0]) as $header) {
                    echo "<th>$header</th>";
                }
                echo "</tr>";
                
                foreach ($butce_sample as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            
        } catch (PDOException $e) {
            logMessage("⚠️ Could not access butce database: " . $e->getMessage(), 'warning');
            
            // Try SQL file
            $sqlFile = __DIR__ . '/butce.sql';
            if (file_exists($sqlFile)) {
                logMessage("📁 Found butce.sql file, checking for IBAN data...", 'info');
                
                $sql_content = file_get_contents($sqlFile);
                if (strpos($sql_content, 'iban_bilgileri') !== false) {
                    logMessage("✅ Found iban_bilgileri data in SQL file", 'success');
                    
                    // Extract INSERT statements for iban_bilgileri
                    if (preg_match('/INSERT INTO `iban_bilgileri`.*?;/s', $sql_content, $matches)) {
                        logMessage("📄 IBAN data found in SQL file:", 'info');
                        echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto;'>";
                        echo htmlspecialchars(substr($matches[0], 0, 500)) . "...";
                        echo "</pre>";
                    }
                } else {
                    logMessage("❌ No iban_bilgileri data found in SQL file", 'error');
                }
            } else {
                logMessage("❌ butce.sql file not found", 'error');
            }
        }
        
        // Test the Iban class query
        logMessage("🧪 Testing Iban class query...", 'info');
        
        try {
            $test_query = "SELECT id.*, b.name as bank_name FROM iban_details id JOIN banks b ON id.bank_id = b.id ORDER BY id.created_at DESC";
            $result = $pdo->query($test_query)->fetchAll();
            
            logMessage("✅ Iban class query works, returned " . count($result) . " rows", count($result) > 0 ? 'success' : 'warning');
            
            if (count($result) > 0) {
                logMessage("📄 Query result sample:", 'info');
                echo "<table class='data-table'>";
                echo "<tr>";
                foreach (array_keys($result[0]) as $header) {
                    echo "<th>$header</th>";
                }
                echo "</tr>";
                
                foreach (array_slice($result, 0, 3) as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            
        } catch (PDOException $e) {
            logMessage("❌ Error testing Iban class query: " . $e->getMessage(), 'error');
            
            // Try simpler query
            try {
                $simple_result = $pdo->query("SELECT * FROM iban_details")->fetchAll();
                logMessage("✅ Simple query works, returned " . count($simple_result) . " rows", 'success');
            } catch (PDOException $e2) {
                logMessage("❌ Even simple query failed: " . $e2->getMessage(), 'error');
            }
        }
        
        echo "<br><div class='log-entry info'>";
        echo "<h4>🎯 Next Steps:</h4>";
        echo "<ul>";
        
        $iban_count = 0;
        try {
            $iban_count = $pdo->query("SELECT COUNT(*) FROM iban_details")->fetchColumn();
        } catch (Exception $e) {}
        
        if ($iban_count == 0) {
            echo "<li>❌ No IBAN data found</li>";
            echo "<li>🔄 <a href='fix_status_mapping.php'>Run data import again</a></li>";
            echo "<li>📝 Or manually add some IBAN records</li>";
        } else {
            echo "<li>✅ IBAN data exists ($iban_count records)</li>";
            echo "<li>🔧 <a href='fix_iban_class.php'>Fix Iban class column names</a></li>";
            echo "<li>🧪 <a href='iban_tablosu.php'>Test IBAN page</a></li>";
        }
        
        echo "</ul>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
    }
    
    ?>
    
</body>
</html>