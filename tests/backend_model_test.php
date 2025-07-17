<?php
// Test Başlangıcı
echo "<h1>Backend Model Testleri Başlatıldı</h1>";
echo "<pre>";

// Test ortamı olduğunu belirtmek için bir sabit tanımla
define('RUNNING_TESTS', true);

// Proje ortamını yükle
require_once __DIR__ . '/../bootstrap.php';

// Veritabanı bağlantısını al
$db = new \App\Models\Database();
$pdo = $db->getConnection();

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
    } catch (Exception $e) {
        echo "<strong style='color:red;'>HATA: " . $e->getMessage() . "</strong>\n";
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
run_test("Expense Modeli - Yeni Gider Ekleme", function() use ($pdo) {
    $expense_model = new \App\Models\Expense($pdo);
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

run_test("Expense Modeli - Gider Güncelleme", function() use ($pdo) {
    $expense_model = new \App\Models\Expense($pdo);
    
    // Önce bir gider ekleyelim
    $data = ['amount' => 200, 'category_type' => 'sabit_gider', 'description' => 'Güncellenecek Gider', 'date' => date('Y-m-d')];
    $last_id = $expense_model->add($data);
    assert_true($last_id !== false, "Güncelleme için test gideri eklenemedi.");

    // Şimdi güncelleyelim
    $update_data = ['description' => 'Gider Güncellendi Testi'];
    $success = $expense_model->update($last_id, $update_data);
    assert_true($success, "Gider güncellenemedi.");

    // Güncellenen veriyi kontrol et
    $updated_expense = $expense_model->getById($last_id);
    assert_true($updated_expense['description'] === 'Gider Güncellendi Testi', "Gider açıklaması doğru güncellenmemiş.");

    return true;
});

run_test("Expense Modeli - Gider Silme", function() use ($pdo) {
    $expense_model = new \App\Models\Expense($pdo);
    
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
run_test("Wishlist Modeli - Yeni İstek Ekleme", function() use ($pdo) {
    $wishlist_model = new \App\Models\Wishlist($pdo);
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
 * Note Modeli Testleri
 */
run_test("Note Modeli - Yeni Not Ekleme", function() use ($pdo) {
    $note_model = new \App\Models\Note($pdo);
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