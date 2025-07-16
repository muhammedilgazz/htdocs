<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Wishlist.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $wishlist_model = new Wishlist();
    $favorites_text = $_POST['favoritesText'] ?? '';
    $lines = explode("\n", $favorites_text);
    $success_count = 0;
    $error_count = 0;

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        // Format: Ürün Adı - Fiyat - Link - Resim Linki (opsiyonel)
        $parts = array_map('trim', explode('-', $line));
        
        $item_name = $parts[0] ?? 'Bilinmeyen Ürün';
        $price = isset($parts[1]) ? (float)filter_var($parts[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0;
        $product_link = $parts[2] ?? null;
        $image_url = $parts[3] ?? null;

        $data = [
            'item_name' => $item_name,
            'wishlist_type' => 'favori',
            'price' => $price,
            'product_link' => $product_link,
            'image_url' => $image_url,
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
        json_response(['success' => true, 'message' => $success_count . ' favori ürün başarıyla içe aktarıldı. ' . $error_count . ' üründe hata oluştu.']);
    } else {
        json_response(['success' => false, 'message' => 'Hiçbir favori ürün içe aktarılamadı.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}