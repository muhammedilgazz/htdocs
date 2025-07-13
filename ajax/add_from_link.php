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
    if (empty($_POST['product_name'])) {
        throw new Exception('Ürün adı gereklidir');
    }
    
    if (empty($_POST['product_price']) || !is_numeric($_POST['product_price']) || $_POST['product_price'] <= 0) {
        throw new Exception('Geçerli bir fiyat giriniz');
    }

    $product_name = trim($_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_link = trim($_POST['product_link'] ?? '');
    $product_category = trim($_POST['product_category'] ?? 'Diğer');
    $product_image = trim($_POST['product_image'] ?? '');

    // Link kontrolü
    if (!empty($product_link) && !filter_var($product_link, FILTER_VALIDATE_URL)) {
        throw new Exception('Geçersiz link formatı');
    }

    // Resim linki kontrolü
    if (!empty($product_image) && !filter_var($product_image, FILTER_VALIDATE_URL)) {
        throw new Exception('Geçersiz resim linki formatı');
    }

    // Veritabanına ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO wishlist_items 
        (item_name, category_id, price, image_path, link, will_get) 
        VALUES (?, (SELECT id FROM categories WHERE name = ? AND type = 'wishlist'), ?, ?, ?, FALSE)
    ");

    $stmt->execute([
        $product_name,
        $product_category,
        $product_price,
        $product_image,
        $product_link
    ]);

    $response['success'] = true;
    $response['message'] = 'Ürün başarıyla eklendi';
    $response['product_id'] = $db->getPdo()->lastInsertId();

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 