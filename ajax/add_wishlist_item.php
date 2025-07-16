<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Wishlist.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $wishlist_model = new Wishlist();
    
    $data = [
        'item_name' => sanitize_input($_POST['item_name']),
        'wishlist_type' => sanitize_input($_POST['wishlist_type']),
        'price' => (float)$_POST['price'] ?? 0,
        'product_link' => sanitize_input($_POST['product_link']) ?? null,
        'image_url' => sanitize_input($_POST['image_url']) ?? null,
        'priority' => (int)$_POST['priority'] ?? null,
        'progress' => (int)$_POST['progress'] ?? 0
    ];

    if ($wishlist_model->add($data)) {
        json_response(['success' => true, 'message' => 'İstek listesi öğesi başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'İstek listesi öğesi eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
