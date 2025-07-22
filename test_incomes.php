<?php
require_once __DIR__ . '/bootstrap.php';

use App\Models\Income;

echo "<h1>Gelirler Modülü Test Sayfası</h1>";

try {
    $incomeModel = new Income();
    $userId = 1;
    
    echo "<h2>Veritabanı Bağlantısı Test</h2>";
    echo "✅ Veritabanı bağlantısı başarılı<br>";
    
    // İstatistikleri test et
    $stats = $incomeModel->getIncomeStats($userId);
    echo "<h2>İstatistikler</h2>";
    echo "<pre>";
    print_r($stats);
    echo "</pre>";
    
    // Gelirleri listele
    $incomes = $incomeModel->getAllIncomes($userId);
    echo "<h2>Gelirler</h2>";
    echo "<pre>";
    print_r($incomes);
    echo "</pre>";
    
    echo "<h2>Test Tamamlandı!</h2>";
    echo "<a href='/incomes'>Gelirler Sayfasına Git</a>";
    
} catch (Exception $e) {
    echo "<h2>Hata!</h2>";
    echo "❌ " . $e->getMessage();
    echo "<br><br>";
    echo "<a href='/install_incomes_table.php'>Veritabanı Tablosunu Oluştur</a>";
}
?> 