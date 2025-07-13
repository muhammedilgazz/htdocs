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
$response = ['success' => false, 'message' => '', 'data' => null];

try {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('ID gerekli');
    }

    $id = intval($_POST['id']);

    // Veriyi getir
    $stmt = $db->getPdo()->prepare("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE ei.id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        throw new Exception('Kayıt bulunamadı');
    }

    $response['success'] = true;
    $response['data'] = $data;

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
