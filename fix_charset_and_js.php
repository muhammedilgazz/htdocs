<?php
/**
 * Fix Charset and JavaScript Issues
 */

require_once 'config/config.php';
require_once 'classes/Database.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Charset and JS Issues</title>
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
    <h1>Fix Charset and JavaScript Issues</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    try {
        logMessage("🔧 Fixing charset and JavaScript issues...", 'info');
        
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        
        // Check current charset
        logMessage("🔍 Checking database charset...", 'info');
        
        $charset = $pdo->query("SELECT @@character_set_database")->fetchColumn();
        $collation = $pdo->query("SELECT @@collation_database")->fetchColumn();
        
        logMessage("📋 Database charset: $charset", 'info');
        logMessage("📋 Database collation: $collation", 'info');
        
        // Set connection charset
        $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
        logMessage("✅ Set connection charset to utf8mb4", 'success');
        
        // Check IBAN data with charset
        logMessage("🏦 Checking IBAN data with proper charset...", 'info');
        
        try {
            $iban_data = $pdo->query("SELECT id, account_holder, iban_number, bank_name, account_type FROM iban_details LIMIT 3")->fetchAll();
            
            if (!empty($iban_data)) {
                logMessage("✅ Found " . count($iban_data) . " IBAN records", 'success');
                
                foreach ($iban_data as $iban) {
                    $holder = mb_convert_encoding($iban['account_holder'], 'UTF-8', 'auto');
                    $bank = mb_convert_encoding($iban['bank_name'], 'UTF-8', 'auto');
                    logMessage("📋 IBAN: {$iban['iban_number']} - Holder: $holder - Bank: $bank - Type: {$iban['account_type']}", 'info');
                }
            } else {
                logMessage("⚠️ No IBAN data found", 'warning');
            }
            
        } catch (PDOException $e) {
            logMessage("❌ Error reading IBAN data: " . $e->getMessage(), 'error');
        }
        
        // Test JavaScript modules
        logMessage("🧪 Testing JavaScript module files...", 'info');
        
        $js_files = [
            'assets/js/modules/core.js',
            'assets/js/modules/ui.js', 
            'assets/js/modules/forms.js',
            'assets/js/modules/navigation.js',
            'assets/js/scripts.js'
        ];
        
        foreach ($js_files as $file) {
            if (file_exists($file)) {
                $size = filesize($file);
                logMessage("✅ $file exists ($size bytes)", 'success');
            } else {
                logMessage("❌ $file missing", 'error');
            }
        }
        
        // Check vendor files
        logMessage("📦 Checking vendor files...", 'info');
        
        $vendor_files = [
            'assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js',
            'assets/vendor/toastr/toastr.min.js'
        ];
        
        foreach ($vendor_files as $file) {
            if (file_exists($file)) {
                logMessage("✅ $file exists", 'success');
            } else {
                logMessage("❌ $file missing - will use CDN fallback", 'warning');
            }
        }
        
        echo "<br><div class='log-entry info'>";
        echo "<h4>🎯 Next Steps:</h4>";
        echo "<ul>";
        echo "<li>1. <a href='iban_tablosu.php'>Test IBAN page</a> - Should show Turkish characters correctly</li>";
        echo "<li>2. <a href='index.php'>Test main page</a> - Check console for JavaScript errors</li>";
        echo "<li>3. Open browser developer tools (F12) to check console</li>";
        echo "</ul>";
        echo "</div>";
        
        echo "<br><div class='log-entry warning'>";
        echo "<h4>🔧 Manual Fixes Needed:</h4>";
        echo "<ul>";
        echo "<li><strong>If Turkish characters still don't show:</strong> Check your database was created with utf8mb4_unicode_ci collation</li>";
        echo "<li><strong>If JavaScript menus don't work:</strong> Check browser console (F12) for specific errors</li>";
        echo "<li><strong>If vendor files are missing:</strong> We're using CDN versions which should work</li>";
        echo "</ul>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Error: " . $e->getMessage(), 'error');
    }
    
    ?>
    
</body>
</html>