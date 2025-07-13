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
    $product_notes = trim($_POST['product_notes'] ?? '');
    $product_image = trim($_POST['product_image'] ?? '');

    // Link kontrolü
    if (!empty($product_link) && !filter_var($product_link, FILTER_VALIDATE_URL)) {
        throw new Exception('Geçersiz link formatı');
    }

    // Resim linki kontrolü
    if (!empty($product_image) && !filter_var($product_image, FILTER_VALIDATE_URL)) {
        throw new Exception('Geçersiz resim linki formatı');
    }

    // Seçili ayı al
    $selected_month = getSelectedMonthKey();

    // Sıra numarası al
    $stmt = $db->getPdo()->prepare("SELECT MAX(sira) as max_sira FROM harcama_kalemleri WHERE kategori_tipi = 'Alınacak Ürünler' AND harcama_donemi = ?");
    $stmt->execute([$selected_month]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $sira = ($result['max_sira'] ?? 0) + 1;

    // Veritabanına ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO harcama_kalemleri 
        (kategori_tipi, kategori, urun, tutar, link, aciklama, durum, harcama_donemi, sira, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

            $description = $product_notes ?: 'Linkten eklenen ürün';
        if (!empty($product_image)) {
            $description .= '; Resim: ' . $product_image;
        }

        $stmt->execute([
            'Alınacak Ürünler',
            $product_category,
            $product_name,
            $product_price,
            $product_link,
            $description,
            'Beklemede',
            $selected_month,
            $sira
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