<?php
// Test Başlangıcı
echo "<h1>Backend Refactored Architecture Testleri</h1>";
echo "<pre>";

// Test ortamı olduğunu belirtmek için bir sabit tanımla
define('RUNNING_TESTS', true);

// Proje ortamını ve DI container'ı yükle
require_once __DIR__ . '/../bootstrap.php';
$container = App\Core\Container::getInstance();

use App\Interfaces\ExpenseServiceInterface;

// --- Test Yardımcı Fonksiyonları ---
function run_test($test_name, callable $test_function) {
    echo "----------------------------------------\n";
    echo "Test Ediliyor: $test_name\n";
    ob_flush();
    flush();

    try {
        $test_function();
        echo "<strong style='color:green;'>BAŞARILI</strong>\n";
    } catch (Throwable $e) { // Catching Throwable is better than Exception
        echo "<strong style='color:red;'>HATA: " . $e->getMessage() . "</strong>\n";
        echo "Dosya: " . $e->getFile() . " Satır: " . $e->getLine() . "\n";
        echo "Trace: " . $e->getTraceAsString() . "\n";
    }
    
    echo "----------------------------------------\n\n";
    ob_flush();
    flush();
}

function assert_true($condition, $message = "Koşul sağlanamadı") {
    if ($condition !== true) {
        throw new Exception($message);
    }
}

// --- Test Senaryoları ---

/**
 * ExpenseService Testleri
 */
run_test("ExpenseService - Yeni Gider Ekleme", function() use ($container) {
    /** @var ExpenseServiceInterface $expenseService */
    $expenseService = $container->get(ExpenseServiceInterface::class);
    
    $data = [
        'amount' => 150.75,
        'category_type' => 'degisken_gider',
        'description' => 'Test Gideri - Servis',
        'date' => date('Y-m-d')
    ];
    $last_id = $expenseService->createNewExpense($data);
    assert_true($last_id !== false && is_numeric($last_id), "Gider eklenemedi, ID dönmedi.");
    
    $added_expense = $expenseService->getExpenseById((int)$last_id);
    assert_true($added_expense && $added_expense['description'] === 'Test Gideri - Servis', "Eklenen gider bulunamadı veya yanlış.");
});

run_test("ExpenseService - Gider Güncelleme", function() use ($container) {
    /** @var ExpenseServiceInterface $expenseService */
    $expenseService = $container->get(ExpenseServiceInterface::class);
    
    $data = ['amount' => 200, 'category_type' => 'sabit_gider', 'description' => 'Güncellenecek Gider', 'date' => date('Y-m-d')];
    $last_id = $expenseService->createNewExpense($data);
    assert_true($last_id !== false, "Güncelleme için test gideri eklenemedi.");

    $update_data = ['description' => 'Gider Servis ile Güncellendi'];
    $success = $expenseService->updateExistingExpense((int)$last_id, $update_data);
    assert_true($success, "Gider güncellenemedi.");

    $updated_expense = $expenseService->getExpenseById((int)$last_id);
    assert_true($updated_expense['description'] === 'Gider Servis ile Güncellendi', "Gider açıklaması doğru güncellenmemiş.");
});

run_test("ExpenseService - Gider Silme", function() use ($container) {
    /** @var ExpenseServiceInterface $expenseService */
    $expenseService = $container->get(ExpenseServiceInterface::class);

    $data = ['amount' => 50, 'category_type' => 'ani_ekstra', 'description' => 'Silinecek Gider', 'date' => date('Y-m-d')];
    $last_id = $expenseService->createNewExpense($data);
    assert_true($last_id !== false, "Silme için test gideri eklenemedi.");

    $success = $expenseService->deleteExpenseById((int)$last_id);
    assert_true($success, "Gider silinemedi.");

    $deleted_expense = $expenseService->getExpenseById((int)$last_id);
    assert_true($deleted_expense === false, "Gider veritabanından silinmemiş.");
});

// TODO: Add tests for other services (Wishlist, Note, etc.) after refactoring them.

echo "Tüm test fonksiyonları çalıştırıldı.\n";
echo "</pre>";
echo "<h1>Backend Testleri Tamamlandı</h1>";
echo "SCRIPT END";

?>