<?php
// Test Başlangıcı
echo "<h1>Backend Model Testleri Başlatıldı</h1>";
echo "<pre>";

// Test ortamı olduğunu belirtmek için bir sabit tanımla
define('RUNNING_TESTS', true);

// Proje ortamını yükle
require_once __DIR__ . '/../bootstrap.php';

// Veritabanı bağlantısını al
$db = \App\Models\Database::getInstance();
$pdo = $db->getPdo();

if (!$pdo) {
    die("Veritabanı bağlantısı kurulamadı. Testler durduruldu.");
}

// --- Test Yardımcı Fonksiyonları ---
function run_test($test_name, callable $test_function) {
    echo "----------------------------------------\n";
    echo "Test Ediliyor: $test_name\n";
    try {
        $result = $test_function();
        if ($result) {
            echo "<strong style='color:green;'>BAŞARILI</strong>\n";
        } else {
            echo "<strong style='color:red;'>BAŞARISIZ</strong>\n";
        }
    } catch (Throwable $e) { // Catching Throwable is better than Exception
        echo "<strong style='color:red;'>HATA: " . $e->getMessage() . "</strong>\n";
        echo "Dosya: " . $e->getFile() . " Satır: " . $e->getLine() . "\n";
        echo "Trace: " . $e->getTraceAsString() . "\n";
    }
    echo "----------------------------------------\n\n";
}

function assert_true($condition, $message = "Koşul sağlanamadı") {
    if ($condition !== true) {
        throw new Exception($message);
    }
}

// --- Test Senaryoları ---

/**
 * Expense (Gider) Modeli Testleri
 */
run_test("Expense Modeli - Yeni Gider Ekleme", function() {
    $expense_model = new \App\Models\Expense();
    $data = [
        'amount' => 150.75,
        'category_type' => 'degisken_gider',
        'description' => 'Test Gideri - Değişken',
        'date' => date('Y-m-d')
    ];
    $result = $expense_model->add($data);
    assert_true($result !== false, "Gider eklenemedi.");
    
    // Eklenen veriyi kontrol et
    $last_id = $result;
    $added_expense = $expense_model->getById($last_id);
    assert_true($added_expense && $added_expense['description'] === 'Test Gideri - Değişken', "Eklenen gider veritabanında bulunamadı veya yanlış.");

    return true;
});

run_test("Expense Modeli - Gider Güncelleme", function() {
    $expense_model = new \App\Models\Expense();
    
    // Önce bir gider ekleyelim
    $data = ['amount' => 200, 'category_type' => 'sabit_gider', 'description' => 'Güncellenecek Gider', 'date' => date('Y-m-d')];
    $last_id = $expense_model->add($data);
    assert_true($last_id !== false, "Güncelleme için test gideri eklenemedi.");

    // Şimdi güncelleyelim
    $update_data = [
        'description' => 'Gider Güncellendi Testi',
        'amount' => 250.50,
        'category_type' => 'degisken_gider'
    ];
    $success = $expense_model->update($last_id, $update_data);
    assert_true($success, "Gider güncellenemedi.");

    // Güncellenen veriyi kontrol et
    $updated_expense = $expense_model->getById($last_id);
    assert_true($updated_expense['description'] === 'Gider Güncellendi Testi', "Gider açıklaması doğru güncellenmemiş.");
    assert_true((float)$updated_expense['amount'] === 250.50, "Gider tutarı doğru güncellenmemiş.");
    assert_true($updated_expense['category_type'] === 'degisken_gider', "Gider kategorisi doğru güncellenmemiş.");

    return true;
});

run_test("Expense Modeli - Gider Silme", function() {
    $expense_model = new \App\Models\Expense();
    
    // Silinecek bir gider ekle
    $data = ['amount' => 50, 'category_type' => 'ani_ekstra', 'description' => 'Silinecek Gider', 'date' => date('Y-m-d')];
    $last_id = $expense_model->add($data);
    assert_true($last_id !== false, "Silme için test gideri eklenemedi.");

    // Silme işlemini yap
    $success = $expense_model->delete($last_id);
    assert_true($success, "Gider silinemedi.");

    // Silinen verinin gerçekten silindiğini kontrol et
    $deleted_expense = $expense_model->getById($last_id);
    assert_true($deleted_expense === false, "Gider veritabanından silinmemiş.");

    return true;
});


/**
 * Wishlist Modeli Testleri
 */
run_test("Wishlist Modeli - Yeni İstek Ekleme", function() {
    $wishlist_model = new \App\Models\Wishlist();
    $data = [
        'item_name' => 'Test Ürünü',
        'wishlist_type' => 'istek',
        'price' => 99.99
    ];
    $result = $wishlist_model->add($data);
    assert_true($result !== false, "İstek eklenemedi.");
    
    $last_id = $result;
    $added_item = $wishlist_model->getById($last_id);
    assert_true($added_item && $added_item['item_name'] === 'Test Ürünü', "Eklenen istek bulunamadı.");

    return true;
});


/**
 * Giderler Modeli Testleri
 */
run_test("Giderler Modeli - Konsolide Giderleri Alma", function() {
    $giderler_model = new \App\Models\Giderler();
    
    // Aylık filtreyi test et
    $result_month = $giderler_model->getConsolidatedMonthlyExpenses('month');
    assert_true(is_array($result_month), "Aylık konsolide giderler alınırken hata oluştu.");

    // Yıllık filtreyi test et
    $result_year = $giderler_model->getConsolidatedMonthlyExpenses('year');
    assert_true(is_array($result_year), "Yıllık konsolide giderler alınırken hata oluştu.");

    // Tüm zamanlar filtresini test et
    $result_all = $giderler_model->getConsolidatedMonthlyExpenses('all');
    assert_true(is_array($result_all), "Tüm zamanlar için konsolide giderler alınırken hata oluştu.");

    return true;
});
/**
 * Note Modeli Testleri
 */
run_test("Note Modeli - Yeni Not Ekleme", function() {
    $note_model = new \App\Models\Note();
    $data = [
        'title' => 'Test Not Başlığı',
        'content' => 'Bu bir test notudur.',
        'category' => 'Test'
    ];
    $result = $note_model->add($data);
    assert_true($result !== false, "Not eklenemedi.");
    
    $last_id = $result;
    $added_note = $note_model->getById($last_id);
    assert_true($added_note && $added_note['title'] === 'Test Not Başlığı', "Eklenen not bulunamadı.");

    return true;
});


echo "</pre>";
echo "<h1>Backend Model Testleri Tamamlandı</h1>";

?>