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

// Veritabanı bağlantısı
$db = Database::getInstance();

// POST verilerini al
$action = $_POST['action'] ?? '';
$url = $_POST['url'] ?? '';
$category = $_POST['category'] ?? '';

if (!$action || !$url) {
    echo json_encode(['success' => false, 'message' => 'URL ve işlem türü gerekli']);
    exit;
}

try {
    switch ($action) {
        case 'import_from_link':
            $result = importFromLink($db, $url, $category);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Geçersiz işlem türü']);
            exit;
    }
    
    echo json_encode($result);
} catch (Exception $e) {
    error_log("Auto import error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'İçe aktarma hatası']);
}

function importFromLink($db, $url, $category) {
    // URL'den ürün bilgilerini çek
    $productInfo = extractProductInfo($url);
    
    if (!$productInfo) {
        return ['success' => false, 'message' => 'Ürün bilgileri çekilemedi'];
    }
    
    // İstek listesine ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO wishlist_items (item_name, category_id, price, link, image_path, will_get, description) 
        VALUES (?, (SELECT id FROM categories WHERE name = ? AND type = 'wishlist'), ?, ?, ?, FALSE, ?)
    ");
    
    $result = $stmt->execute([
        $productInfo['title'],
        $category,
        $productInfo['price'],
        $url,
        $productInfo['image'],
        $productInfo['description']
    ]);
    
    if ($result) {
        return [
            'success' => true, 
            'message' => 'Ürün başarıyla istek listesine eklendi',
            'data' => $productInfo
        ];
    } else {
        return ['success' => false, 'message' => 'Veritabanına kaydedilemedi'];
    }
}



function extractProductInfo($url) {
    // Basit ürün bilgisi çıkarma (gerçek uygulamada daha gelişmiş olmalı)
    $domain = parse_url($url, PHP_URL_HOST);
    
    // Domain'e göre farklı çıkarma stratejileri
    switch ($domain) {
        case 'www.trendyol.com':
        case 'trendyol.com':
            return extractTrendyolInfo($url);
        case 'www.hepsiburada.com':
        case 'hepsiburada.com':
            return extractHepsiburadaInfo($url);
        default:
            return extractGenericInfo($url);
    }
}

function extractTrendyolInfo($url) {
    // Trendyol için özel çıkarma (örnek)
    return [
        'item_name' => 'Trendyol Ürünü',
        'price' => 0,
        'image' => '',
        'link' => $url,
        'description' => 'Trendyol\'dan alınacak ürün'
    ];
}

function extractHepsiburadaInfo($url) {
    // Hepsiburada için özel çıkarma (örnek)
    return [
        'item_name' => 'Hepsiburada Ürünü',
        'price' => 0,
        'image' => '',
        'link' => $url,
        'description' => 'Hepsiburada\'dan alınacak ürün'
    ];
}

function extractGenericInfo($url) {
    // Genel çıkarma
    return [
        'item_name' => 'Link Ürünü',
        'price' => 0,
        'image' => '',
        'link' => $url,
        'description' => 'Linkten alınacak ürün'
    ];
}
?> 