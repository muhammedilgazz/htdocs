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

// Veri doğrulama ve temizleme
if (empty($_POST['item_name'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Ürün adı boş olamaz.']);
    exit;
}

$data = [
    'item_name' => sanitize_input($_POST['item_name']),
    'wishlist_type' => isset($_POST['wishlist_type']) ? sanitize_input($_POST['wishlist_type']) : 'istek',
    'price' => isset($_POST['price']) && is_numeric($_POST['price']) ? (float)$_POST['price'] : 0,
    'product_link' => isset($_POST['product_link']) ? filter_var($_POST['product_link'], FILTER_SANITIZE_URL) : null,
    'image_url' => isset($_POST['image_url']) ? filter_var($_POST['image_url'], FILTER_SANITIZE_URL) : null,
    'priority' => isset($_POST['priority']) && is_numeric($_POST['priority']) ? (int)$_POST['priority'] : null,
    'progress' => isset($_POST['progress']) && is_numeric($_POST['progress']) ? (int)$_POST['progress'] : 0
];

$wishlist_model = new Wishlist();

if ($wishlist_model->add($data)) {
    echo json_encode(['success' => true, 'message' => 'İstek listesi öğesi başarıyla eklendi.']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'İstek listesi öğesi eklenirken bir hata oluştu.']);
}
