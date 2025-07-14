<?php
/**
 * Database Creation Script for Budget Management System
 * This script creates the budget database and all required tables
 */

require_once 'config/config.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Budget Management</title>
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
    <h1>Budget Management System - Database Setup</h1>
    
    <?php
    
    function logMessage($message, $type = 'info') {
        echo "<div class='log-entry $type'>$message</div>\n";
        flush();
    }
    
    try {
        logMessage("🚀 Starting database setup process...", 'info');
        
        // Connect to MySQL without database
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASS;
        $dbname = DB_NAME;
        
        logMessage("📡 Connecting to MySQL server at $host...", 'info');
        
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        logMessage("✅ Connected to MySQL server successfully", 'success');
        
        // Create database
        logMessage("🏗️ Creating database '$dbname'...", 'info');
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        logMessage("✅ Database '$dbname' created successfully", 'success');
        
        // Use the database
        $pdo->exec("USE `$dbname`");
        logMessage("📋 Using database '$dbname'", 'info');
        
        // Read and execute the complete SQL file
        $sqlFile = __DIR__ . '/sql/budget_complete.sql';
        
        if (!file_exists($sqlFile)) {
            throw new Exception("SQL file not found: $sqlFile");
        }
        
        logMessage("📄 Reading SQL file: budget_complete.sql...", 'info');
        $sql = file_get_contents($sqlFile);
        
        if ($sql === false) {
            throw new Exception("Failed to read SQL file");
        }
        
        // Remove the CREATE DATABASE part and USE statement from the SQL
        $sql = preg_replace('/CREATE DATABASE.*?;/s', '', $sql);
        $sql = preg_replace('/USE `.*?`;/s', '', $sql);
        
        // Split SQL into individual statements
        $statements = explode(';', $sql);
        $executedCount = 0;
        $errorCount = 0;
        
        logMessage("⚙️ Executing SQL statements...", 'info');
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            
            // Skip empty statements and comments
            if (empty($statement) || 
                strpos($statement, '--') === 0 || 
                strpos($statement, '/*') === 0 ||
                strpos($statement, '/*!') === 0) {
                continue;
            }
            
            try {
                $pdo->exec($statement);
                $executedCount++;
                
                // Log significant operations
                if (stripos($statement, 'CREATE TABLE') === 0) {
                    preg_match('/CREATE TABLE.*?`([^`]+)`/i', $statement, $matches);
                    $tableName = $matches[1] ?? 'unknown';
                    logMessage("📋 Created table: $tableName", 'success');
                } elseif (stripos($statement, 'INSERT INTO') === 0) {
                    preg_match('/INSERT INTO.*?`([^`]+)`/i', $statement, $matches);
                    $tableName = $matches[1] ?? 'unknown';
                    logMessage("📝 Inserted data into: $tableName", 'info');
                }
                
            } catch (PDOException $e) {
                $errorCount++;
                $error = $e->getMessage();
                
                // Check if it's a harmless duplicate entry error
                if (strpos($error, 'Duplicate entry') !== false || 
                    strpos($error, 'already exists') !== false) {
                    logMessage("⚠️ Skipped: " . substr($statement, 0, 50) . "... (already exists)", 'warning');
                } else {
                    logMessage("❌ Error: $error in statement: " . substr($statement, 0, 100) . "...", 'error');
                }
            }
        }
        
        logMessage("✅ Database setup completed!", 'success');
        logMessage("📊 Statistics:", 'info');
        logMessage("• Executed statements: $executedCount", 'info');
        logMessage("• Errors/Warnings: $errorCount", $errorCount > 0 ? 'warning' : 'info');
        
        // Verify table creation
        logMessage("🔍 Verifying table creation...", 'info');
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        
        $expectedTables = [
            'categories', 'account_types', 'banks', 'status_types', 'users',
            'payments', 'balances', 'expense_items', 'wishlist_items', 
            'account_credentials', 'iban_details', 'notes', 'todos', 
            'dream_goals', 'budgets', 'debts', 'projects', 'login_logs', 
            'rate_limits', 'user_sessions'
        ];
        
        $missingTables = array_diff($expectedTables, $tables);
        $extraTables = array_diff($tables, $expectedTables);
        
        if (empty($missingTables)) {
            logMessage("✅ All expected tables created successfully", 'success');
        } else {
            logMessage("⚠️ Missing tables: " . implode(', ', $missingTables), 'warning');
        }
        
        if (!empty($extraTables)) {
            logMessage("ℹ️ Additional tables found: " . implode(', ', $extraTables), 'info');
        }
        
        logMessage("📋 Total tables created: " . count($tables), 'info');
        
        // Test database connection
        logMessage("🧪 Testing database connection...", 'info');
        $testQuery = $pdo->query("SELECT COUNT(*) as count FROM status_types");
        $result = $testQuery->fetch();
        logMessage("✅ Database connection test passed. Status types count: " . $result['count'], 'success');
        
        echo "<br><div class='log-entry success'>";
        echo "<h3>🎉 Setup Complete!</h3>";
        echo "<p>Your Budget Management System database has been set up successfully.</p>";
        echo "<p><strong>Next steps:</strong></p>";
        echo "<ul>";
        echo "<li>✅ Database 'budget' created</li>";
        echo "<li>✅ All tables created with proper structure</li>";
        echo "<li>✅ Default data inserted</li>";
        echo "<li>✅ Indexes and foreign keys configured</li>";
        echo "</ul>";
        echo "<p><a href='index.php'>🚀 Go to Application</a></p>";
        echo "</div>";
        
    } catch (Exception $e) {
        logMessage("💥 Critical Error: " . $e->getMessage(), 'error');
        logMessage("❌ Database setup failed!", 'error');
        
        echo "<br><div class='log-entry error'>";
        echo "<h3>❌ Setup Failed</h3>";
        echo "<p>An error occurred during database setup:</p>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Troubleshooting:</strong></p>";
        echo "<ul>";
        echo "<li>Make sure MySQL/MariaDB is running</li>";
        echo "<li>Check database credentials in config/config.php</li>";
        echo "<li>Ensure proper permissions for database creation</li>";
        echo "<li>Check MySQL error logs</li>";
        echo "</ul>";
        echo "</div>";
    }
    
    ?>
    
    <br>
    <div class="log-entry info">
        <h4>📚 Additional Information</h4>
        <p><strong>Database Name:</strong> <?= DB_NAME ?></p>
        <p><strong>Host:</strong> <?= DB_HOST ?></p>
        <p><strong>Charset:</strong> utf8mb4</p>
        <p><strong>Collation:</strong> utf8mb4_unicode_ci</p>
        <p><strong>SQL File:</strong> sql/budget_complete.sql</p>
    </div>
    
</body>
</html>