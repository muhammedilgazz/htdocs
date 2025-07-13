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
$postpone_months = $_POST['postpone_months'] ?? null;

if (!$id || !$postpone_months) {
    echo json_encode(['success' => false, 'message' => 'ID ve erteleme süresi gerekli']);
    exit;
}

try {
    // Mevcut harcama bilgilerini al
    $stmt = $db->getPdo()->prepare("SELECT * FROM expense_items WHERE id = ?");
    $stmt->execute([$id]);
    $expense = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$expense) {
        echo json_encode(['success' => false, 'message' => 'Harcama bulunamadı']);
        exit;
    }
    
    // Harcamayı güncelle
    $updateSql = "UPDATE expense_items SET 
                   status_id = (SELECT id FROM status_types WHERE name = 'Ertelendi')
                   WHERE id = ?";
    
    $updateStmt = $db->getPdo()->prepare($updateSql);
    $result = $updateStmt->execute([
        $id
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true, 
            'message' => "Harcama başarıyla ertelendi",
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erteleme işlemi başarısız']);
    }
    
} catch (Exception $e) {
    error_log("Postpone expense error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası: ' . $e->getMessage()]);
}
?> 