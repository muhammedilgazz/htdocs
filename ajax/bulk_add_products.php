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
$response = ['success' => false, 'message' => '', 'imported_count' => 0];

try {
    if (!isset($_POST['bulk_items_text']) || empty($_POST['bulk_items_text'])) {
        throw new Exception('Ürün listesi boş olamaz');
    }

    $bulk_items_text = trim($_POST['bulk_items_text']);
    $lines = explode("\n", $bulk_items_text);
    $imported_count = 0;
    $errors = [];

    foreach ($lines as $line_number => $line) {
        $line = trim($line);
        if (empty($line)) continue;

        // Format: Ürün Adı - Fiyat - Kategori - Resim Linki (opsiyonel)
        $parts = explode(' - ', $line);
        
        if (count($parts) < 2) {
            $errors[] = "Satır " . ($line_number + 1) . ": Geçersiz format";
            continue;
        }

        $product_name = trim($parts[0]);
        $price_text = trim($parts[1]);
        $category = isset($parts[2]) ? trim($parts[2]) : 'Diğer';
        $image_link = isset($parts[3]) ? trim($parts[3]) : '';

        // Fiyat temizleme
        $price = preg_replace('/[^0-9,.]/', '', $price_text);
        $price = str_replace(',', '.', $price);
        
        if (!is_numeric($price) || $price <= 0) {
            $errors[] = "Satır " . ($line_number + 1) . ": Geçersiz fiyat";
            continue;
        }

        // Resim linki kontrolü
        if (!empty($image_link) && !filter_var($image_link, FILTER_VALIDATE_URL)) {
            $errors[] = "Satır " . ($line_number + 1) . ": Geçersiz resim linki";
            continue;
        }

        

        // Veritabanına ekle
        $stmt = $db->getPdo()->prepare("
            INSERT INTO wishlist_items 
            (item_name, category_id, price, image_path, description, will_get) 
            VALUES (?, (SELECT id FROM categories WHERE name = ? AND type = 'wishlist'), ?, ?, ?, FALSE)
        ");

        $description = 'Toplu ekleme ile eklenen ürün';
        if (!empty($image_link)) {
            $description .= '; Resim: ' . $image_link;
        }

        $stmt->execute([
            $product_name,
            $category,
            $price,
            $image_link,
            $description
        ]);

        $imported_count++;
    }

    if ($imported_count > 0) {
        $response['success'] = true;
        $response['message'] = $imported_count . ' ürün başarıyla eklendi';
        $response['imported_count'] = $imported_count;
        
        if (!empty($errors)) {
            $response['message'] .= '. ' . count($errors) . ' satırda hata oluştu';
            $response['errors'] = $errors;
        }
    } else {
        $response['message'] = 'Hiçbir ürün eklenemedi';
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
    }

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 