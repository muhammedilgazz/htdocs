<?php
/**
 * Fix Users Table Structure
 * This script updates the users table to have the correct column structure
 */

require_once 'config/config.php';
require_once 'classes/Database.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Users Table - Budget Management</title>
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
    <h1>Fix Users Table Structure</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    try {
        logMessage("🔧 Starting users table fix...", 'info');
        
        // Connect to database
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        
        logMessage("📡 Connected to database successfully", 'success');
        
        // Check current table structure
        logMessage("🔍 Checking current users table structure...", 'info');
        
        $columns = $pdo->query("DESCRIBE users")->fetchAll(PDO::FETCH_ASSOC);
        $existing_columns = array_column($columns, 'Field');
        
        logMessage("📋 Current columns: " . implode(', ', $existing_columns), 'info');
        
        // Required columns that should exist
        $required_columns = [
            'name' => "VARCHAR(50) DEFAULT NULL",
            'middle_name' => "VARCHAR(50) DEFAULT NULL", 
            'surname' => "VARCHAR(50) DEFAULT NULL",
            'email' => "VARCHAR(255) NOT NULL",
            'username' => "VARCHAR(50) NOT NULL"
        ];
        
        // Check and add missing columns
        foreach ($required_columns as $column => $definition) {
            if (!in_array($column, $existing_columns)) {
                logMessage("➕ Adding missing column: $column", 'warning');
                
                try {
                    $pdo->exec("ALTER TABLE users ADD COLUMN `$column` $definition");
                    logMessage("✅ Added column: $column", 'success');
                } catch (PDOException $e) {
                    logMessage("❌ Failed to add column $column: " . $e->getMessage(), 'error');
                }
            } else {
                logMessage("✅ Column exists: $column", 'success');
            }
        }
        
        // Check if we have any users, if not create a default one
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        
        if ($userCount == 0) {
            logMessage("👤 No users found, creating default user...", 'warning');
            
            $defaultUser = [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'name' => 'Admin',
                'middle_name' => '',
                'surname' => 'User',
                'role' => 'admin',
                'status' => 'active'
            ];
            
            $stmt = $pdo->prepare("
                INSERT INTO users (username, email, password_hash, name, middle_name, surname, role, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $defaultUser['username'],
                $defaultUser['email'], 
                $defaultUser['password_hash'],
                $defaultUser['name'],
                $defaultUser['middle_name'],
                $defaultUser['surname'],
                $defaultUser['role'],
                $defaultUser['status']
            ]);
            
            logMessage("✅ Default user created: username=admin, password=admin123", 'success');
        } else {
            logMessage("👤 Found $userCount existing users", 'info');
        }
        
        // Test the query that was failing
        logMessage("🧪 Testing the problematic query...", 'info');
        
        try {
            $test_stmt = $pdo->prepare("SELECT name, middle_name, surname, email FROM users WHERE id = ?");
            $test_stmt->execute([1]);
            $test_result = $test_stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($test_result) {
                logMessage("✅ Query test successful! User data: " . json_encode($test_result), 'success');
            } else {
                logMessage("⚠️ Query successful but no user found with ID 1", 'warning');
            }
            
        } catch (PDOException $e) {
            logMessage("❌ Query test failed: " . $e->getMessage(), 'error');
        }
        
        // Final verification
        logMessage("🔍 Final table structure verification...", 'info');
        $final_columns = $pdo->query("DESCRIBE users")->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($final_columns as $column) {
            logMessage("📋 " . $column['Field'] . " (" . $column['Type'] . ")", 'info');
        }
        
        echo "<br><div class='log-entry success'>";
        echo "<h3>🎉 Users Table Fix Complete!</h3>";
        echo "<p>The users table has been updated with the correct structure.</p>";
        echo "<p><strong>Next steps:</strong></p>";
        echo "<ul>";
        echo "<li>✅ Required columns verified/added</li>";
        echo "<li>✅ Default user created (if needed)</li>";
        echo "<li>✅ Query compatibility tested</li>";
        echo "</ul>";
        echo "<p><a href='index.php'>🚀 Go to Application</a></p>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
        logMessage("❌ Users table fix failed!", 'error');
        
        echo "<br><div class='log-entry error'>";
        echo "<h3>❌ Fix Failed</h3>";
        echo "<p>An error occurred during users table fix:</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
    
    ?>
    
</body>
</html>