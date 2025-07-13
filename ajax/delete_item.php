<?php
require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/SecurityManager.php';

// Güvenlik kontrolü
$security = new SecurityManager();
$security->checkSession();

// CSRF kontrolü
if (!isset($_POST['csrf_token']) || !$security->validateCSRF($_POST['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Güvenlik hatası']);
    exit;
}

// Veritabanı bağlantısı
$db = Database::getInstance();

// POST verilerini al
$id = $_POST['id'] ?? null;
$table = $_POST['table'] ?? null;

if (!$id || !$table) {
    echo json_encode(['success' => false, 'message' => 'ID ve tablo adı gerekli']);
    exit;
}

// Güvenli tablo adları (whitelist) - user_id sütunu yok, sadece ID kontrolü
$allowed_tables = [
    $allowed_tables = [
        'expense_items',
        'iban_details',
        'payments',
        'wishlist_items',
        'account_credentials',
        'notes',
        'todos',
        'dream_goals',
        'incomes',
        'budgets'
    ];

if (!in_array($table, $allowed_tables)) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz tablo']);
    exit;
}

try {
    // Debug bilgileri
    error_log("Delete request - Table: $table, ID: $id");
    
    // Tablo var mı kontrol et
    $tableExists = $db->getPdo()->query("SHOW TABLES LIKE '$table'")->rowCount() > 0;
    if (!$tableExists) {
        echo json_encode(['success' => false, 'message' => "Tablo '$table' mevcut değil"]);
        exit;
    }
    
    // Öğeyi sil (user_id kontrolü yok, sadece ID kontrolü)
    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $db->getPdo()->prepare($sql);
    $result = $stmt->execute([$id]);
    
    if ($result && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Kayıt başarıyla silindi']);
    } else {
        // Neden silinmediğini kontrol et
        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE id = ?";
        $checkStmt = $db->getPdo()->prepare($checkSql);
        $checkStmt->execute([$id]);
        $count = $checkStmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        if ($count == 0) {
            echo json_encode(['success' => false, 'message' => 'Kayıt bulunamadı (ID: ' . $id . ')']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Kayıt bulundu ama silinemedi']);
        }
    }
} catch (Exception $e) {
    error_log("Delete item error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası: ' . $e->getMessage()]);
}
?> 