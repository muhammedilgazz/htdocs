<?php
class BackupManager {
    private $pdo;
    private $backupDir;
    
    public function __construct($pdo, $backupDir = 'backups/') {
        $this->pdo = $pdo;
        $this->backupDir = $backupDir;
        
        if (!is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }
    }
    
    public function createBackup() {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $this->backupDir . $filename;
        
        $tables = $this->getTables();
        $sql = "-- Database Backup\n-- Created: " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($tables as $table) {
            $sql .= $this->exportTable($table);
        }
        
        if (file_put_contents($filepath, $sql)) {
            $this->cleanOldBackups();
            return $filename;
        }
        
        throw new Exception('Backup oluşturulamadı');
    }
    
    private function getTables() {
        $stmt = $this->pdo->query("SHOW TABLES");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    private function exportTable($table) {
        $sql = "\n-- Table: $table\n";
        $sql .= "DROP TABLE IF EXISTS `$table`;\n";
        
        // Table structure
        $stmt = $this->pdo->query("SHOW CREATE TABLE `$table`");
        $row = $stmt->fetch();
        $sql .= $row['Create Table'] . ";\n\n";
        
        // Table data
        $stmt = $this->pdo->query("SELECT * FROM `$table`");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $values = array_map(function($value) {
                return $value === null ? 'NULL' : $this->pdo->quote($value);
            }, $row);
            
            $sql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
        }
        
        return $sql . "\n";
    }
    
    private function cleanOldBackups($keepDays = 7) {
        $files = glob($this->backupDir . 'backup_*.sql');
        $cutoff = time() - ($keepDays * 24 * 60 * 60);
        
        foreach ($files as $file) {
            if (filemtime($file) < $cutoff) {
                unlink($file);
            }
        }
    }
    
    public function restoreBackup($filename) {
        $filepath = $this->backupDir . $filename;
        
        if (!file_exists($filepath)) {
            throw new Exception('Backup dosyası bulunamadı');
        }
        
        $sql = file_get_contents($filepath);
        $statements = explode(';', $sql);
        
        $this->pdo->beginTransaction();
        
        try {
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $this->pdo->exec($statement);
                }
            }
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }
    
    public function getBackupList() {
        $files = glob($this->backupDir . 'backup_*.sql');
        $backups = [];
        
        foreach ($files as $file) {
            $backups[] = [
                'filename' => basename($file),
                'size' => filesize($file),
                'created' => filemtime($file)
            ];
        }
        
        usort($backups, function($a, $b) {
            return $b['created'] - $a['created'];
        });
        
        return $backups;
    }
}
?>