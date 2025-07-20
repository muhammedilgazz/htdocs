<?php
require_once '../bootstrap.php';

use App\Models\Wishlist;

// Yalnızca POST isteklerine izin ver
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek metodu.']);
    exit;
}

// CSRF token kontrolü
if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Geçersiz CSRF token.']);
    exit;
}

$wishlist_model = new Wishlist();
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    if ($wishlist_model->delete($id)) {
        echo json_encode(['success' => true, 'message' => 'İstek listesi öğesi başarıyla silindi.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'İstek listesi öğesi silinirken bir hata oluştu.']);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Geçersiz ID.']);
}
