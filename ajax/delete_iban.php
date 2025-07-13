<?php
require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/SecurityManager.php';

// Güvenlik kontrolü
$security = new SecurityManager();
$security->checkSession();

// CSRF kontrolü
if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
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
    // IBAN'ı sil
    $stmt = $db->getPdo()->prepare("DELETE FROM ibanlar WHERE id = ? AND user_id = ?");
    $result = $stmt->execute([$id, $_SESSION['user_id']]);
    
    if ($result && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'IBAN başarıyla silindi']);
    } else {
        echo json_encode(['success' => false, 'message' => 'IBAN bulunamadı veya silinemedi']);
    }
} catch (Exception $e) {
    error_log('Delete IBAN error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası']);
}
?>
