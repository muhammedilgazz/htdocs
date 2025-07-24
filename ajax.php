<?php
/**
 * Merkezi AJAX İstek Yönlendiricisi
 *
 * Tüm asenkron (AJAX) istekleri için tek giriş noktası.
 * Gelen 'action' parametresine göre ilgili Controller'a yönlendirme yapar.
 */

// Uygulamanın çekirdek dosyalarını ve yapılandırmasını yükle
require_once __DIR__ . '/bootstrap.php';

// Yanıtı JSON formatında göndereceğimizi belirt
header('Content-Type: application/json');

// Hangi işlemin gerçekleştirileceğini belirten 'action' parametresini al
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if (empty($action)) {
    echo json_encode(['status' => 'error', 'message' => 'Eylem (action) belirtilmedi.']);
    exit;
}

// Güvenlik için action ismini temizle (sadece alfanumerik ve alt çizgi)
$action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

// Action isminden Controller ve metot isimlerini türet
// Örnek: 'add_todo' -> TodoController::ajax_add_todo()
$parts = explode('_', $action);
$controller_name_segment = array_shift($parts);
$method_name = 'ajax_' . implode('_', $parts);

// Controller adını oluştur (örn: 'todo' -> 'TodoController')
$controller_class_name = ucfirst($controller_name_segment) . 'Controller';
$full_controller_class = '\\App\\Controllers\\' . $controller_class_name;


// Controller ve metot var mı diye kontrol et
if (!class_exists($full_controller_class)) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => "Controller bulunamadı: {$controller_class_name}"]);
    exit;
}

if (!method_exists($full_controller_class, $method_name)) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => "Metot bulunamadı: {$controller_class_name}::{$method_name}"]);
    exit;
}

try {
    // DI Container üzerinden Controller'ı oluştur
    $controller = $container->get($full_controller_class);
    
    // Metodu çağır ve yanıtı al
    $response = $controller->$method_name();
    
    // Yanıtı JSON olarak bas
    echo json_encode($response);

} catch (Exception $e) {
    // Hata durumunda standart bir JSON hatası döndür
    error_log("AJAX Hatası: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Sunucuda bir hata oluştu.',
        'details' => $e->getMessage() // Geliştirme ortamında detayı göster
    ]);
}