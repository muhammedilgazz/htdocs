<?php
/**
 * Debug IBAN Display Issues
 */

require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/Iban.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug IBAN Display</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 50px auto; padding: 20px; }
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
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        .data-table th { background-color: #f8f9fa; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Debug IBAN Display Issues</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    try {
        logMessage("🔍 Debugging IBAN display issues...", 'info');
        
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        
        // 1. Direct database query
        logMessage("1️⃣ Direct database query test:", 'info');
        
        try {
            $direct_data = $pdo->query("SELECT * FROM iban_details")->fetchAll();
            
            if (empty($direct_data)) {
                logMessage("❌ No data in iban_details table", 'error');
            } else {
                logMessage("✅ Found " . count($direct_data) . " records in iban_details", 'success');
                
                echo "<table class='data-table'>";
                echo "<tr>";
                foreach (array_keys($direct_data[0]) as $header) {
                    echo "<th>$header</th>";
                }
                echo "</tr>";
                
                foreach ($direct_data as $row) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if (in_array($key, ['account_holder', 'iban_number'])) {
                            echo "<td style='background: " . (empty($value) ? '#ffebee' : '#e8f5e8') . ";'>";
                            echo empty($value) ? '❌ EMPTY' : htmlspecialchars($value);
                            echo "</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            
        } catch (PDOException $e) {
            logMessage("❌ Direct query error: " . $e->getMessage(), 'error');
        }
        
        // 2. Test Iban class query
        logMessage("2️⃣ Iban class query test:", 'info');
        
        try {
            $iban_class_query = "SELECT id.*, b.name as bank_name FROM iban_details id JOIN banks b ON id.bank_id = b.id ORDER BY id.created_at DESC";
            $iban_class_data = $pdo->query($iban_class_query)->fetchAll();
            
            if (empty($iban_class_data)) {
                logMessage("❌ Iban class query returned no results", 'error');
                
                // Check if banks table has data
                $banks_count = $pdo->query("SELECT COUNT(*) FROM banks")->fetchColumn();
                logMessage("🏦 Banks table has $banks_count records", $banks_count > 0 ? 'info' : 'error');
                
                if ($banks_count == 0) {
                    logMessage("⚠️ Banks table is empty - this breaks the JOIN", 'warning');
                }
                
            } else {
                logMessage("✅ Iban class query returned " . count($iban_class_data) . " records", 'success');
                
                echo "<h4>Iban Class Query Results:</h4>";
                echo "<table class='data-table'>";
                echo "<tr>";
                foreach (array_keys($iban_class_data[0]) as $header) {
                    echo "<th>$header</th>";
                }
                echo "</tr>";
                
                foreach ($iban_class_data as $row) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if (in_array($key, ['account_holder', 'iban_number'])) {
                            echo "<td style='background: " . (empty($value) ? '#ffebee' : '#e8f5e8') . ";'>";
                            echo empty($value) ? '❌ EMPTY' : htmlspecialchars($value);
                            echo "</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            
        } catch (PDOException $e) {
            logMessage("❌ Iban class query error: " . $e->getMessage(), 'error');
        }
        
        // 3. Test Iban class directly
        logMessage("3️⃣ Iban class object test:", 'info');
        
        try {
            $iban_model = new Iban();
            $all_ibans = $iban_model->getAll();
            
            logMessage("📊 Iban class getAll() returned " . count($all_ibans) . " records", count($all_ibans) > 0 ? 'success' : 'error');
            
            if (!empty($all_ibans)) {
                echo "<h4>Iban Class getAll() Results:</h4>";
                echo "<pre>";
                foreach ($all_ibans as $i => $iban) {
                    echo "Record $i:\n";
                    foreach ($iban as $key => $value) {
                        $display_value = empty($value) ? '❌ EMPTY' : $value;
                        echo "  $key: $display_value\n";
                    }
                    echo "\n";
                    if ($i >= 2) break; // Show only first 3 records
                }
                echo "</pre>";
            }
            
        } catch (Exception $e) {
            logMessage("❌ Iban class error: " . $e->getMessage(), 'error');
        }
        
        // 4. Test separation logic
        logMessage("4️⃣ Testing separation logic:", 'info');
        
        if (!empty($all_ibans)) {
            $my_ibans = [];
            $other_ibans = [];
            
            foreach ($all_ibans as $iban) {
                if ($iban['account_type'] === 'own') {
                    $my_ibans[] = $iban;
                } else {
                    $other_ibans[] = $iban;
                }
            }
            
            logMessage("👤 My IBANs: " . count($my_ibans), count($my_ibans) > 0 ? 'success' : 'warning');
            logMessage("👥 Other IBANs: " . count($other_ibans), count($other_ibans) > 0 ? 'success' : 'warning');
            
            echo "<h4>Separation Results:</h4>";
            echo "<p><strong>My IBANs (account_type = 'own'):</strong></p>";
            if (!empty($my_ibans)) {
                foreach ($my_ibans as $iban) {
                    echo "<p>• {$iban['account_holder']} - {$iban['iban_number']} - {$iban['bank_name']}</p>";
                }
            } else {
                echo "<p>❌ No 'own' accounts found</p>";
            }
            
            echo "<p><strong>Other IBANs (account_type = 'other'):</strong></p>";
            if (!empty($other_ibans)) {
                foreach ($other_ibans as $iban) {
                    echo "<p>• {$iban['account_holder']} - {$iban['iban_number']} - {$iban['bank_name']}</p>";
                }
            } else {
                echo "<p>❌ No 'other' accounts found</p>";
            }
        }
        
        // 5. Check banks table
        logMessage("5️⃣ Checking banks table:", 'info');
        
        try {
            $banks = $pdo->query("SELECT * FROM banks")->fetchAll();
            
            if (empty($banks)) {
                logMessage("❌ Banks table is empty!", 'error');
                
                // Add some banks
                logMessage("➕ Adding default banks...", 'warning');
                
                $default_banks = [
                    ['id' => 1, 'name' => 'Ziraat Bankası'],
                    ['id' => 2, 'name' => 'Akbank'],
                    ['id' => 3, 'name' => 'İş Bankası'],
                    ['id' => 4, 'name' => 'Yapı Kredi'],
                    ['id' => 5, 'name' => 'Enpara']
                ];
                
                foreach ($default_banks as $bank) {
                    $pdo->exec("INSERT IGNORE INTO banks (id, name) VALUES ({$bank['id']}, '{$bank['name']}')");
                }
                
                logMessage("✅ Added default banks", 'success');
                
            } else {
                logMessage("✅ Banks table has " . count($banks) . " records", 'success');
                
                echo "<h4>Banks:</h4>";
                foreach ($banks as $bank) {
                    echo "<p>• ID: {$bank['id']} - Name: {$bank['name']}</p>";
                }
            }
            
        } catch (PDOException $e) {
            logMessage("❌ Banks table error: " . $e->getMessage(), 'error');
        }
        
        echo "<br><div class='log-entry info'>";
        echo "<h4>🎯 Problem Analysis:</h4>";
        echo "<ul>";
        
        if (empty($direct_data)) {
            echo "<li>❌ <strong>Main Issue:</strong> iban_details table is empty</li>";
            echo "<li>🔄 <strong>Solution:</strong> <a href='import_iban_data.php'>Re-run IBAN data import</a></li>";
        } else {
            $has_empty_fields = false;
            foreach ($direct_data as $row) {
                if (empty($row['account_holder']) || empty($row['iban_number'])) {
                    $has_empty_fields = true;
                    break;
                }
            }
            
            if ($has_empty_fields) {
                echo "<li>❌ <strong>Main Issue:</strong> Some account_holder or iban_number fields are empty</li>";
                echo "<li>🔄 <strong>Solution:</strong> Data import mapping problem</li>";
            } else {
                echo "<li>✅ Data looks good in database</li>";
                echo "<li>🧪 <strong>Test:</strong> <a href='iban_tablosu.php'>Check IBAN page again</a></li>";
            }
        }
        
        echo "</ul>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Error: " . $e->getMessage(), 'error');
    }
    
    ?>
    
</body>
</html>