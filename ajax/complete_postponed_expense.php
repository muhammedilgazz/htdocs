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

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID gerekli']);
    exit;
}

try {
    // Harcamayı tamamla (durumu güncelle)
    $updateSql = "UPDATE expense_items SET 
                   status_id = (SELECT id FROM status_types WHERE name = 'Ödendi')
                   WHERE id = ?";
    
    $updateStmt = $db->getPdo()->prepare($updateSql);
    $result = $updateStmt->execute([$id]);
    
    if ($result && $updateStmt->rowCount() > 0) {
        echo json_encode([
            'success' => true, 
            'message' => 'Ertelenen ödeme tamamlandı'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Güncelleme işlemi başarısız']);
    }
    
} catch (Exception $e) {
    error_log("Complete postponed expense error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası: ' . $e->getMessage()]);
}
?> 