<?php
require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/SecurityManager.php';

// Güvenlik kontrolü
$security = new SecurityManager();
$security->checkSession();

// CSRF kontrolü - geçici olarak devre dışı
// if (!isset($_POST['csrf_token']) || !$security->validateCSRF($_POST['csrf_token'])) {
//     http_response_code(403);
//     echo json_encode(['success' => false, 'message' => 'Güvenlik hatası']);
//     exit;
// }

$db = Database::getInstance();
$response = ['success' => false, 'message' => ''];

try {
    // Gerekli alanları kontrol et
    if (empty($_POST['id'])) {
        throw new Exception('ID gerekli');
    }
    
    if (empty($_POST['urun'])) {
        throw new Exception('Ürün adı gereklidir');
    }
    
    if (empty($_POST['tutar']) || !is_numeric($_POST['tutar']) || $_POST['tutar'] <= 0) {
        throw new Exception('Geçerli bir tutar giriniz');
    }

    $id = intval($_POST['id']);
    $kategori = trim($_POST['kategori'] ?? '');
    $harcama_donemi = trim($_POST['harcama_donemi'] ?? '');
    $urun = trim($_POST['urun']);
    $tutar = floatval($_POST['tutar']);
    $link = trim($_POST['link'] ?? '');
    $aciklama = trim($_POST['aciklama'] ?? '');
    $durum = trim($_POST['durum'] ?? 'Beklemede');

    // Link kontrolü
    if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {
        throw new Exception('Geçersiz link formatı');
    }

    // Kaydın var olup olmadığını kontrol et
    $checkStmt = $db->getPdo()->prepare("SELECT id FROM harcama_kalemleri WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        throw new Exception('Kayıt bulunamadı');
    }

    // Veritabanını güncelle
    $stmt = $db->getPdo()->prepare("
        UPDATE harcama_kalemleri 
        SET kategori = ?, harcama_donemi = ?, urun = ?, tutar = ?, link = ?, aciklama = ?, durum = ?, updated_at = NOW()
        WHERE id = ?
    ");

    $stmt->execute([
        $kategori,
        $harcama_donemi,
        $urun,
        $tutar,
        $link,
        $aciklama,
        $durum,
        $id
    ]);

    $response['success'] = true;
    $response['message'] = 'Kayıt başarıyla güncellendi';

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
