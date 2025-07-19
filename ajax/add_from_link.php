<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Wishlist.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $wishlist_model = new Wishlist();
    
    $data = [
        'item_name' => sanitize_input($_POST['productName']),
        'wishlist_type' => 'alinacak', // Varsayılan olarak 'alinacak'
        'price' => (float)$_POST['productPrice'] ?? 0,
        'product_link' => sanitize_input($_POST['productLink']) ?? null,
        'image_url' => sanitize_input($_POST['productImage']) ?? null,
        'priority' => null, // Varsayılan olarak null
        'progress' => 0 // Varsayılan olarak 0
    ];

    if ($wishlist_model->add($data)) {
        json_response(['success' => true, 'message' => 'Ürün linkten başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Ürün eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}