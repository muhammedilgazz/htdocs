<?php
/**
 * Import IBAN Data Specifically
 */

require_once 'config/config.php';
require_once 'classes/Database.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import IBAN Data</title>
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
    <h1>Import IBAN Data</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    try {
        logMessage("🏦 Starting IBAN data import...", 'info');
        
        // Connect to budget database
        $budget_pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=budget;charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        // Connect to butce database
        $butce_pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=butce;charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        logMessage("✅ Connected to both databases", 'success');
        
        // Get IBAN data from butce
        $source_data = $butce_pdo->query("SELECT * FROM iban_bilgileri")->fetchAll();
        logMessage("📊 Found " . count($source_data) . " IBAN records in source", 'info');
        
        // Clear existing data
        $budget_pdo->exec("DELETE FROM iban_details");
        logMessage("🗑️ Cleared existing IBAN data", 'warning');
        
        // Prepare insert statement
        $stmt = $budget_pdo->prepare("
            INSERT INTO iban_details (
                id, user_id, account_holder, iban_number, easy_address, 
                bank_id, bank_name, bank_logo, description, account_type, created_at
            ) VALUES (?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $imported = 0;
        foreach ($source_data as $row) {
            // Map bank to bank_id
            $bank_id = 5; // Default: Diğer
            switch (strtolower(trim($row['banka']))) {
                case 'ziraat': $bank_id = 1; break;
                case 'akbank': $bank_id = 2; break;
                case 'işbankası':
                case 'isbankası': $bank_id = 3; break;
                case 'yapı kredi': $bank_id = 4; break;
                case 'enpara': $bank_id = 5; break;
            }
            
            // Map account type
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
            logMessage("✅ Imported: {$row['hesap_sahibi']} - {$row['banka']}", 'success');
        }
        
        logMessage("🎉 Successfully imported $imported IBAN records", 'success');
        
        // Verify import
        $final_count = $budget_pdo->query("SELECT COUNT(*) FROM iban_details")->fetchColumn();
        logMessage("📊 Final count in iban_details: $final_count", 'success');
        
        echo "<br><div class='log-entry success'>";
        echo "<h3>🎉 IBAN Import Complete!</h3>";
        echo "<p>Successfully imported $imported IBAN records.</p>";
        echo "<p><a href='iban_tablosu.php'>🧪 Test IBAN Page</a></p>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Error: " . $e->getMessage(), 'error');
    }
    
    ?>
    
</body>
</html>