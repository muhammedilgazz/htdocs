<?php
/**
 * Fix Table Structure - Add Missing Columns
 */

require_once 'config/config.php';
require_once 'classes/Database.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Table Structure</title>
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
    <h1>Fix Table Structure</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    function columnExists($pdo, $table, $column) {
        try {
            $stmt = $pdo->prepare("SHOW COLUMNS FROM `$table` LIKE ?");
            $stmt->execute([$column]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    try {
        logMessage("🔧 Starting table structure fixes...", 'info');
        
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        
        logMessage("✅ Connected to database", 'success');
        
        // Fix balances table
        logMessage("💰 Checking balances table structure...", 'info');
        
        $balances_fixes = [
            'user_id' => "INT DEFAULT 1",
            'last_calculation' => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
        ];
        
        foreach ($balances_fixes as $column => $definition) {
            if (!columnExists($pdo, 'balances', $column)) {
                logMessage("➕ Adding column: balances.$column", 'warning');
                try {
                    $pdo->exec("ALTER TABLE balances ADD COLUMN `$column` $definition");
                    logMessage("✅ Added column: $column", 'success');
                } catch (PDOException $e) {
                    logMessage("❌ Failed to add column $column: " . $e->getMessage(), 'error');
                }
            } else {
                logMessage("✅ Column exists: balances.$column", 'success');
            }
        }
        
        // Fix expense_items table
        logMessage("💸 Checking expense_items table structure...", 'info');
        
        $expense_fixes = [
            'user_id' => "INT DEFAULT 1",
            'expense_type' => "ENUM('monthly', 'one_time') DEFAULT 'one_time'",
            'expense_period' => "VARCHAR(10) DEFAULT NULL",
            'postpone_date' => "DATE DEFAULT NULL",
            'due_date' => "DATE DEFAULT NULL"
        ];
        
        foreach ($expense_fixes as $column => $definition) {
            if (!columnExists($pdo, 'expense_items', $column)) {
                logMessage("➕ Adding column: expense_items.$column", 'warning');
                try {
                    $pdo->exec("ALTER TABLE expense_items ADD COLUMN `$column` $definition");
                    logMessage("✅ Added column: $column", 'success');
                } catch (PDOException $e) {
                    logMessage("❌ Failed to add column $column: " . $e->getMessage(), 'error');
                }
            } else {
                logMessage("✅ Column exists: expense_items.$column", 'success');
            }
        }
        
        // Fix wishlist_items table
        logMessage("🛍️ Checking wishlist_items table structure...", 'info');
        
        $wishlist_fixes = [
            'user_id' => "INT DEFAULT 1",
            'priority' => "ENUM('low', 'medium', 'high') DEFAULT 'medium'",
            'status' => "ENUM('active', 'purchased', 'removed') DEFAULT 'active'"
        ];
        
        foreach ($wishlist_fixes as $column => $definition) {
            if (!columnExists($pdo, 'wishlist_items', $column)) {
                logMessage("➕ Adding column: wishlist_items.$column", 'warning');
                try {
                    $pdo->exec("ALTER TABLE wishlist_items ADD COLUMN `$column` $definition");
                    logMessage("✅ Added column: $column", 'success');
                } catch (PDOException $e) {
                    logMessage("❌ Failed to add column $column: " . $e->getMessage(), 'error');
                }
            } else {
                logMessage("✅ Column exists: wishlist_items.$column", 'success');
            }
        }
        
        // Fix account_credentials table
        logMessage("🔐 Checking account_credentials table structure...", 'info');
        
        $account_fixes = [
            'user_id' => "INT DEFAULT 1",
            'account_type_id' => "INT DEFAULT 6"
        ];
        
        foreach ($account_fixes as $column => $definition) {
            if (!columnExists($pdo, 'account_credentials', $column)) {
                logMessage("➕ Adding column: account_credentials.$column", 'warning');
                try {
                    $pdo->exec("ALTER TABLE account_credentials ADD COLUMN `$column` $definition");
                    logMessage("✅ Added column: $column", 'success');
                } catch (PDOException $e) {
                    logMessage("❌ Failed to add column $column: " . $e->getMessage(), 'error');
                }
            } else {
                logMessage("✅ Column exists: account_credentials.$column", 'success');
            }
        }
        
        // Fix iban_details table
        logMessage("🏦 Checking iban_details table structure...", 'info');
        
        $iban_fixes = [
            'user_id' => "INT DEFAULT 1",
            'bank_id' => "INT DEFAULT 5",
            'account_type' => "ENUM('own', 'other') DEFAULT 'other'"
        ];
        
        foreach ($iban_fixes as $column => $definition) {
            if (!columnExists($pdo, 'iban_details', $column)) {
                logMessage("➕ Adding column: iban_details.$column", 'warning');
                try {
                    $pdo->exec("ALTER TABLE iban_details ADD COLUMN `$column` $definition");
                    logMessage("✅ Added column: $column", 'success');
                } catch (PDOException $e) {
                    logMessage("❌ Failed to add column $column: " . $e->getMessage(), 'error');
                }
            } else {
                logMessage("✅ Column exists: iban_details.$column", 'success');
            }
        }
        
        // Verify final structure
        logMessage("🔍 Verifying table structures...", 'info');
        
        $tables_to_verify = ['balances', 'expense_items', 'wishlist_items', 'account_credentials', 'iban_details'];
        
        foreach ($tables_to_verify as $table) {
            try {
                $columns = $pdo->query("DESCRIBE $table")->fetchAll(PDO::FETCH_COLUMN);
                logMessage("📋 $table columns: " . implode(', ', $columns), 'info');
            } catch (PDOException $e) {
                logMessage("❌ Error checking $table: " . $e->getMessage(), 'error');
            }
        }
        
        echo "<br><div class='log-entry success'>";
        echo "<h3>🎉 Table Structure Fix Complete!</h3>";
        echo "<p>All necessary columns have been added to the tables.</p>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ul>";
        echo "<li>✅ Table structures updated</li>";
        echo "<li>✅ Missing columns added</li>";
        echo "<li>🔄 <a href='import_from_butce.php'>Run data import again</a></li>";
        echo "</ul>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
        
        echo "<br><div class='log-entry error'>";
        echo "<h3>❌ Fix Failed</h3>";
        echo "<p>An error occurred during table structure fix:</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
    
    ?>
    
</body>
</html>