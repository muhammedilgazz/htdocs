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
    $durum = trim($_POST['durum']);

    // Geçerli durumlar
    $valid_statuses = ['Beklemede', 'Devam Ediyor', 'Tamamlandı', 'İptal Edildi'];
    if (!in_array($durum, $valid_statuses)) {
        throw new Exception('Geçersiz durum');
    }

    // Kaydın var olup olmadığını kontrol et
    $checkStmt = $db->getPdo()->prepare("SELECT id FROM harcama_kalemleri WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        throw new Exception('Kayıt bulunamadı');
    }

    // Durumu güncelle
    $stmt = $db->getPdo()->prepare("UPDATE harcama_kalemleri SET durum = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$durum, $id]);

    $response['success'] = true;
    $response['message'] = 'Durum başarıyla güncellendi';

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 