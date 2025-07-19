<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Wishlist.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $wishlist_model = new Wishlist();
    $items_text = $_POST['bulkItemsText'] ?? '';
    $lines = explode("\n", $items_text);
    $success_count = 0;
    $error_count = 0;

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        // Format: Ürün Adı - Fiyat - Kategori - Resim Linki (opsiyonel)
        $parts = array_map('trim', explode('-', $line));
        
        $item_name = $parts[0] ?? 'Bilinmeyen Ürün';
        $price = isset($parts[1]) ? (float)filter_var($parts[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0;
        $wishlist_type = isset($parts[2]) ? sanitize_input($parts[2]) : 'istek'; // Kategori yerine wishlist_type
        $image_url = $parts[3] ?? null;

        $data = [
            'item_name' => $item_name,
            'wishlist_type' => $wishlist_type,
            'price' => $price,
            'image_url' => $image_url,
            'product_link' => null, // Toplu eklemede link yok varsayalım
            'priority' => null,
            'progress' => 0
        ];

        if ($wishlist_model->add($data)) {
            $success_count++;
        } else {
            $error_count++;
        }
    }

    if ($success_count > 0) {
        json_response(['success' => true, 'message' => $success_count . ' ürün başarıyla eklendi. ' . $error_count . ' üründe hata oluştu.']);
    } else {
        json_response(['success' => false, 'message' => 'Hiçbir ürün eklenemedi.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}