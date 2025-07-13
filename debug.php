<?php
// Debug script to test database queries and performance
$start_time = microtime(true);

echo "<h2>Database Performance Test</h2>";

try {
    require_once './config/database.php';
    echo "✅ Database connection: OK<br>";
    
    // Test each query individually
    $queries = [
        'odemeler' => "SELECT * FROM odemeler ORDER BY id",
        'harcama_kalemleri' => "SELECT * FROM harcama_kalemleri ORDER BY sira", 
        'istek_listesi' => "SELECT * FROM istek_listesi ORDER BY id",
        'hesaplar_sifreler' => "SELECT * FROM hesaplar_sifreler ORDER BY id",
        'iban_bilgileri' => "SELECT * FROM iban_bilgileri ORDER BY id",
        'alinanlar' => "SELECT * FROM istek_listesi WHERE will_get = 'yes' ORDER BY id",
        'sum_odemeler' => "SELECT SUM(tutar) FROM odemeler",
        'sum_alinanlar' => "SELECT SUM(fiyat) FROM istek_listesi WHERE will_get = 'yes'",
        'count_alinanlar' => "SELECT COUNT(*) FROM istek_listesi WHERE will_get = 'yes'"
    ];
    
    foreach($queries as $name => $query) {
        $query_start = microtime(true);
        $stmt = $pdo->query($query);
        $result = $stmt->fetchAll();
        $query_time = (microtime(true) - $query_start) * 1000;
        
        echo "📊 {$name}: " . count($result) . " rows - {$query_time}ms<br>";
        
        if($query_time > 100) {
            echo "⚠️ SLOW QUERY: {$name}<br>";
        }
    }
    
} catch(Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test file includes
$include_start = microtime(true);
try {
    include './data/veri.php';
    include './data/tablo-olustur.php';
    $include_time = (microtime(true) - $include_start) * 1000;
    echo "📁 File includes: {$include_time}ms<br>";
} catch(Exception $e) {
    echo "❌ Include error: " . $e->getMessage() . "<br>";
}

$total_time = (microtime(true) - $start_time) * 1000;
echo "<br><strong>🕐 Total execution time: {$total_time}ms</strong><br>";

if($total_time > 1000) {
    echo "⚠️ PERFORMANCE WARNING: Page load > 1 second<br>";
}

// Memory usage
$memory = memory_get_peak_usage(true) / 1024 / 1024;
echo "💾 Memory usage: " . round($memory, 2) . " MB<br>";
?>