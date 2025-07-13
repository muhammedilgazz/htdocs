<?php
require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/SecurityManager.php';

// Güvenlik kontrolü
$security = new SecurityManager();
$security->checkSession();

// CSRF kontrolü
if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
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
        case 'import_from_favorites':
            $result = importFromFavorites($db, $url, $category);
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
    
    // Alınacaklar listesine ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO alinacak_urunler (user_id, urun_adi, fiyat, link, kategori, oncelik, durum, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, 'Beklemede', NOW())
    ");
    
    $result = $stmt->execute([
        $_SESSION['user_id'],
        $productInfo['title'],
        $productInfo['price'],
        $url,
        $category,
        'Orta'
    ]);
    
    if ($result) {
        return [
            'success' => true, 
            'message' => 'Ürün başarıyla alınacaklar listesine eklendi',
            'data' => $productInfo
        ];
    } else {
        return ['success' => false, 'message' => 'Veritabanına kaydedilemedi'];
    }
}

function importFromFavorites($db, $url, $category) {
    // Favori ürünlerden seçilen ürünü alınacaklar listesine ekle
    $stmt = $db->getPdo()->prepare("
        SELECT * FROM favori_urunler 
        WHERE user_id = ? AND link = ? 
        LIMIT 1
    ");
    $stmt->execute([$_SESSION['user_id'], $url]);
    $favorite = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$favorite) {
        return ['success' => false, 'message' => 'Favori ürün bulunamadı'];
    }
    
    // Alınacaklar listesine ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO alinacak_urunler (user_id, urun_adi, fiyat, link, kategori, oncelik, durum, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, 'Beklemede', NOW())
    ");
    
    $result = $stmt->execute([
        $_SESSION['user_id'],
        $favorite['urun_adi'],
        $favorite['fiyat'],
        $favorite['link'],
        $category,
        'Orta'
    ]);
    
    if ($result) {
        return [
            'success' => true, 
            'message' => 'Favori ürün başarıyla alınacaklar listesine eklendi',
            'data' => $favorite
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
        'title' => 'Trendyol Ürünü',
        'price' => 0,
        'image' => '',
        'description' => 'Trendyol\'dan alınacak ürün'
    ];
}

function extractHepsiburadaInfo($url) {
    // Hepsiburada için özel çıkarma (örnek)
    return [
        'title' => 'Hepsiburada Ürünü',
        'price' => 0,
        'image' => '',
        'description' => 'Hepsiburada\'dan alınacak ürün'
    ];
}

function extractGenericInfo($url) {
    // Genel çıkarma
    return [
        'title' => 'Link Ürünü',
        'price' => 0,
        'image' => '',
        'description' => 'Linkten alınacak ürün'
    ];
}
?> 