<?php
require_once 'config/config.php';
require_once 'models/Database.php';

if (file_exists(__DIR__ . '/models/BackupManager.php')) {
    require_once __DIR__ . '/models/BackupManager.php';
}

try {
    $db = Database::getInstance();
    $backupManager = new BackupManager($db->getPdo());
    
    $filename = $backupManager->createBackup();
    echo "Backup created: $filename\n";
    
    // Log the backup
    error_log("Automatic backup created: $filename");
    
} catch (Exception $e) {
    error_log("Backup failed: " . $e->getMessage());
    echo "Backup failed: " . $e->getMessage() . "\n";
}
?>