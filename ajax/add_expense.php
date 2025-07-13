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
    if (empty($_POST['category_name'])) {
        throw new Exception('Kategori adı gereklidir');
    }
    
    if (empty($_POST['item_name'])) {
        throw new Exception('Ürün adı gereklidir');
    }
    
    if (empty($_POST['amount']) || !is_numeric($_POST['amount']) || $_POST['amount'] <= 0) {
        throw new Exception('Geçerli bir tutar giriniz');
    }

    $category_name = trim($_POST['category_name']);
    $item_name = trim($_POST['item_name']);
    $amount = floatval($_POST['amount']);
    $link = trim($_POST['link'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status_name = trim($_POST['status_name'] ?? 'Beklemede');

    // Link kontrolü
    if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {
        throw new Exception('Geçersiz link formatı');
    }

    // Sıra numarasını al (basitçe en yüksek sıraya 1 ekle)
    $siraStmt = $db->getPdo()->prepare("SELECT MAX(order_number) as max_sira FROM expense_items");
    $siraStmt->execute();
    $siraResult = $siraStmt->fetch(PDO::FETCH_ASSOC);
    $order_number = ($siraResult['max_sira'] ?? 0) + 1;

    // Veritabanına ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO expense_items (order_number, category_id, item_name, amount, link, description, status_id)
        VALUES (?, (SELECT id FROM categories WHERE name = ? AND type = 'expense'), ?, ?, ?, ?, (SELECT id FROM status_types WHERE name = ?))
    ");

    $stmt->execute([
        $order_number,
        $category_name,
        $item_name,
        $amount,
        $link,
        $description,
        $status_name
    ]);

    $response['success'] = true;
    $response['message'] = 'Kayıt başarıyla eklendi';

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);

// Debug için log
error_log('Add expense response: ' . json_encode($response));
?>
