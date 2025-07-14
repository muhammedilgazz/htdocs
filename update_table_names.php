<?php
/**
 * Update Table Names Script
 * This script updates all PHP files to use new English table names instead of Turkish ones
 */

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Table Names - Budget Management</title>
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
        .file-list { max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Update Table Names in PHP Files</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    function updateFileContent($filePath, $replacements) {
        $content = file_get_contents($filePath);
        $originalContent = $content;
        
        foreach ($replacements as $old => $new) {
            $content = str_replace($old, $new, $content);
        }
        
        if ($content !== $originalContent) {
            file_put_contents($filePath, $content);
            return true;
        }
        return false;
    }
    
    try {
        logMessage("🔄 Starting table name updates...", 'info');
        
        // Define table name mappings (Turkish -> English)
        $tableReplacements = [
            'harcama_kalemleri' => 'expense_items',
            'kategori_tipleri' => 'categories', 
            'odemeler' => 'payments',
            'bakiye' => 'balances',
            'kullanicilar' => 'users',
            'notlar' => 'notes',
            'gorevler' => 'todos',
            'ruyalar' => 'dream_goals',
            'butceler' => 'budgets',
            'borclar' => 'debts',
            'hesap_bilgileri' => 'account_credentials',
            'iban_bilgileri' => 'iban_details',
            'istek_listesi' => 'wishlist_items'
        ];
        
        // Column name mappings that might be needed
        $columnReplacements = [
            'kategori_tipi' => 'category_id',
            'kullanici_id' => 'user_id',
            'kalem_adi' => 'item_name',
            'miktar' => 'amount',
            'aciklama' => 'description',
            'durum' => 'status_id',
            'olusturma_tarihi' => 'created_at',
            'guncelleme_tarihi' => 'updated_at'
        ];
        
        // Get all PHP files
        $phpFiles = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.'));
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $phpFiles[] = $file->getPathname();
            }
        }
        
        logMessage("📁 Found " . count($phpFiles) . " PHP files to check", 'info');
        
        $updatedFiles = [];
        $errorFiles = [];
        
        foreach ($phpFiles as $file) {
            // Skip certain files
            if (strpos($file, 'vendor') !== false || 
                strpos($file, 'node_modules') !== false ||
                strpos($file, 'update_table_names.php') !== false ||
                strpos($file, 'fix_users_table.php') !== false) {
                continue;
            }
            
            try {
                // Read file content to check if it contains old table names
                $content = file_get_contents($file);
                $hasOldNames = false;
                
                foreach ($tableReplacements as $oldName => $newName) {
                    if (strpos($content, $oldName) !== false) {
                        $hasOldNames = true;
                        break;
                    }
                }
                
                if ($hasOldNames) {
                    logMessage("🔍 Processing: " . basename($file), 'info');
                    
                    // First update table names
                    $updated = updateFileContent($file, $tableReplacements);
                    
                    if ($updated) {
                        $updatedFiles[] = $file;
                        logMessage("✅ Updated: " . basename($file), 'success');
                    }
                }
                
            } catch (Exception $e) {
                $errorFiles[] = $file . " - " . $e->getMessage();
                logMessage("❌ Error processing " . basename($file) . ": " . $e->getMessage(), 'error');
            }
        }
        
        logMessage("📊 Update Summary:", 'info');
        logMessage("✅ Files updated: " . count($updatedFiles), 'success');
        logMessage("❌ Files with errors: " . count($errorFiles), count($errorFiles) > 0 ? 'error' : 'success');
        
        if (!empty($updatedFiles)) {
            echo "<div class='log-entry info'>";
            echo "<h4>📝 Updated Files:</h4>";
            echo "<div class='file-list'>";
            foreach ($updatedFiles as $file) {
                echo "• " . basename($file) . "<br>";
            }
            echo "</div>";
            echo "</div>";
        }
        
        if (!empty($errorFiles)) {
            echo "<div class='log-entry error'>";
            echo "<h4>❌ Files with Errors:</h4>";
            echo "<div class='file-list'>";
            foreach ($errorFiles as $error) {
                echo "• " . $error . "<br>";
            }
            echo "</div>";
            echo "</div>";
        }
        
        // Now let's also check for specific common issues and provide manual fixes
        logMessage("🔧 Checking for common query patterns that need manual review...", 'warning');
        
        $manualReviewFiles = [];
        foreach ($phpFiles as $file) {
            if (strpos($file, 'vendor') !== false || 
                strpos($file, 'node_modules') !== false ||
                strpos($file, 'update_table_names.php') !== false) {
                continue;
            }
            
            $content = file_get_contents($file);
            
            // Check for complex queries that might need manual review
            if (preg_match('/kategori_tipi\s*=\s*[\'"]/', $content) ||
                preg_match('/WHERE\s+kategori_tipi/', $content) ||
                preg_match('/JOIN.*kategori_tipleri/', $content)) {
                $manualReviewFiles[] = basename($file);
            }
        }
        
        if (!empty($manualReviewFiles)) {
            echo "<div class='log-entry warning'>";
            echo "<h4>⚠️ Files needing manual review for column references:</h4>";
            echo "<div class='file-list'>";
            foreach ($manualReviewFiles as $file) {
                echo "• " . $file . " - Check category-related queries<br>";
            }
            echo "</div>";
            echo "</div>";
        }
        
        echo "<br><div class='log-entry success'>";
        echo "<h3>🎉 Table Name Update Complete!</h3>";
        echo "<p>PHP files have been updated to use new English table names.</p>";
        echo "<p><strong>Important Notes:</strong></p>";
        echo "<ul>";
        echo "<li>✅ Old table names (harcama_kalemleri, etc.) → New names (expense_items, etc.)</li>";
        echo "<li>⚠️ Some files may need manual review for complex queries</li>";
        echo "<li>🔄 Clear any application cache if you have one</li>";
        echo "<li>🧪 Test the application functionality</li>";
        echo "</ul>";
        echo "<p><a href='index.php'>🚀 Go to Application</a></p>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
        
        echo "<br><div class='log-entry error'>";
        echo "<h3>❌ Update Failed</h3>";
        echo "<p>An error occurred during table name updates:</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
    
    ?>
    
</body>
</html>