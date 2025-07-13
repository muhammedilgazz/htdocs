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

$db = Database::getInstance();
$response = ['success' => false, 'message' => ''];

try {
    // Gerekli alanları kontrol et
    if (empty($_POST['content'])) {
        throw new Exception('Not içeriği gereklidir');
    }

    $content = trim($_POST['content']);
    $title = trim($_POST['title'] ?? substr($content, 0, 50)); // If title not provided, use first 50 chars of content

    // Veritabanına ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO notes 
        (title, content) 
        VALUES (?, ?)
    ");

    $stmt->execute([
        $title,
        $content
    ]);

    $response['success'] = true;
    $response['message'] = 'Not başarıyla eklendi';
    $response['note_id'] = $db->getPdo()->lastInsertId();

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
