<?php
require_once 'config/config.php';
require_once 'classes/Database.php';

try {
    $db = Database::getInstance();
    $pdo = $db->getPdo();
    
    echo "<h2>Veritabanı Tablo Kontrolü</h2>";
    
    // Tüm tabloları listele
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<h3>Mevcut Tablolar (" . count($tables) . " adet):</h3>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
    // Tüm tabloların yapısını göster
    echo "<h3>Tüm Tablo Yapıları:</h3>";
    foreach ($tables as $table) {
        echo "<h4>$table</h4>";
        $columns = $pdo->query("DESCRIBE $table")->fetchAll(PDO::FETCH_ASSOC);
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; font-size: 12px;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>{$column['Field']}</td>";
            echo "<td>{$column['Type']}</td>";
            echo "<td>{$column['Null']}</td>";
            echo "<td>{$column['Key']}</td>";
            echo "<td>{$column['Default']}</td>";
            echo "<td>{$column['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // user_id sütunu var mı kontrol et
        $has_user_id = false;
        foreach ($columns as $column) {
            if ($column['Field'] === 'user_id') {
                $has_user_id = true;
                break;
            }
        }
        
        if ($has_user_id) {
            echo "<p style='color: green;'>✓ user_id sütunu mevcut</p>";
        } else {
            echo "<p style='color: red;'>✗ user_id sütunu YOK!</p>";
        }
        
        // Örnek veri göster
        $sampleData = $pdo->query("SELECT * FROM $table LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($sampleData)) {
            echo "<h5>Örnek Veriler (İlk 3 kayıt):</h5>";
            echo "<table border='1' style='border-collapse: collapse; margin: 5px 0; font-size: 11px;'>";
            echo "<tr>";
            foreach (array_keys($sampleData[0]) as $header) {
                echo "<th>$header</th>";
            }
            echo "</tr>";
            foreach ($sampleData as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        
        echo "<hr>";
    }
    
    // Session kontrolü
    echo "<h3>Session Bilgileri:</h3>";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    echo "<p>user_id: " . ($_SESSION['user_id'] ?? 'YOK') . "</p>";
    echo "<p>Session ID: " . session_id() . "</p>";
    
} catch (Exception $e) {
    echo "<h3>Hata:</h3>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
}
?> 