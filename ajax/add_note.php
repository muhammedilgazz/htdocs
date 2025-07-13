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
    if (empty($_POST['icerik'])) {
        throw new Exception('Not içeriği gereklidir');
    }

    $kategori = trim($_POST['kategori'] ?? 'Genel');
    $icerik = trim($_POST['icerik']);
    $onem_derecesi = trim($_POST['onem_derecesi'] ?? 'Orta');
    $durum = trim($_POST['durum'] ?? 'Aktif');

    // Notlar tablosunu oluştur (eğer yoksa)
    $db->getPdo()->exec("
    CREATE TABLE IF NOT EXISTS notlar (
        id INT AUTO_INCREMENT PRIMARY KEY,
        kategori VARCHAR(50) NOT NULL DEFAULT 'Genel',
        icerik TEXT NOT NULL,
        onem_derecesi ENUM('Düşük', 'Orta', 'Yüksek') DEFAULT 'Orta',
        durum ENUM('Aktif', 'Tamamlandı', 'Arşivlendi') DEFAULT 'Aktif',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Veritabanına ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO notlar 
        (kategori, icerik, onem_derecesi, durum, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");

    $stmt->execute([
        $kategori,
        $icerik,
        $onem_derecesi,
        $durum
    ]);

    $response['success'] = true;
    $response['message'] = 'Not başarıyla eklendi';
    $response['note_id'] = $db->getPdo()->lastInsertId();

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
