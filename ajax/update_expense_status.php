<?php
require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/SecurityManager.php';

// Güvenlik kontrolü
$security = new SecurityManager();
$security->checkSession();

// CSRF kontrolü - geçici olarak devre dışı
// if (!isset($_POST['csrf_token']) || !$security->validateCSRF($_POST['csrf_token'])) {
//     http_response_code(403);
//     echo json_encode(['success' => false, 'message' => 'Güvenlik hatası']);
//     exit;
// }

$db = Database::getInstance();
$response = ['success' => false, 'message' => ''];

try {
    if (empty($_POST['id'])) {
        throw new Exception('ID gerekli');
    }
    
    if (empty($_POST['durum'])) {
        throw new Exception('Durum gerekli');
    }

    $id = intval($_POST['id']);
    $status_name = trim($_POST['status_name']);

    // Kaydın var olup olmadığını kontrol et
    $checkStmt = $db->getPdo()->prepare("SELECT id FROM expense_items WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        throw new Exception('Kayıt bulunamadı');
    }

    // Durumu güncelle
    $stmt = $db->getPdo()->prepare("UPDATE expense_items SET status_id = (SELECT id FROM status_types WHERE name = ?), updated_at = NOW() WHERE id = ?");
    $stmt->execute([$status_name, $id]);

    $response['success'] = true;
    $response['message'] = 'Durum başarıyla güncellendi';

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 