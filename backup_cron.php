<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/BackupManager.php';

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