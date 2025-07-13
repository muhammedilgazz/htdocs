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
    // Gerekli alanları kontrol et
    if (empty($_POST['id'])) {
        throw new Exception('ID gerekli');
    }
    
    if (empty($_POST['urun'])) {
        throw new Exception('Ürün adı gereklidir');
    }
    
    if (empty($_POST['tutar']) || !is_numeric($_POST['tutar']) || $_POST['tutar'] <= 0) {
        throw new Exception('Geçerli bir tutar giriniz');
    }

    $id = intval($_POST['id']);
    $category_name = trim($_POST['category_name'] ?? '');
    $item_name = trim($_POST['item_name']);
    $amount = floatval($_POST['amount']);
    $link = trim($_POST['link'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status_name = trim($_POST['status_name'] ?? 'Beklemede');

    // Link kontrolü
    if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {
        throw new Exception('Geçersiz link formatı');
    }

    // Kaydın var olup olmadığını kontrol et
    $checkStmt = $db->getPdo()->prepare("SELECT id FROM expense_items WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        throw new Exception('Kayıt bulunamadı');
    }

    // Veritabanını güncelle
    $stmt = $db->getPdo()->prepare("
        UPDATE expense_items 
        SET category_id = (SELECT id FROM categories WHERE name = ? AND type = 'expense'), item_name = ?, amount = ?, link = ?, description = ?, status_id = (SELECT id FROM status_types WHERE name = ?), updated_at = NOW()
        WHERE id = ?
    ");

    $stmt->execute([
        $category_name,
        $item_name,
        $amount,
        $link,
        $description,
        $status_name,
        $id
    ]);

    $response['success'] = true;
    $response['message'] = 'Kayıt başarıyla güncellendi';

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
