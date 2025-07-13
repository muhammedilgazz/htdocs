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
    if (empty($_POST['kategori'])) {
        throw new Exception('Kategori gereklidir');
    }
    
    if (empty($_POST['kategori_tipi'])) {
        throw new Exception('Kategori tipi gereklidir');
    }
    
    if (empty($_POST['harcama_donemi'])) {
        throw new Exception('Harcama dönemi gereklidir');
    }
    
    if (empty($_POST['urun'])) {
        throw new Exception('Ürün adı gereklidir');
    }
    
    if (empty($_POST['tutar']) || !is_numeric($_POST['tutar']) || $_POST['tutar'] <= 0) {
        throw new Exception('Geçerli bir tutar giriniz');
    }

    $kategori = trim($_POST['kategori']);
    $kategori_tipi = trim($_POST['kategori_tipi']);
    $harcama_donemi = trim($_POST['harcama_donemi']);
    $urun = trim($_POST['urun']);
    $tutar = floatval($_POST['tutar']);
    $link = trim($_POST['link'] ?? '');
    $aciklama = trim($_POST['aciklama'] ?? '');
    $durum = trim($_POST['durum'] ?? 'Beklemede');

    // Link kontrolü
    if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {
        throw new Exception('Geçersiz link formatı');
    }

    // Sıra numarasını al
    $siraStmt = $db->getPdo()->prepare("SELECT MAX(sira) as max_sira FROM harcama_kalemleri WHERE kategori_tipi = ? AND kategori = ? AND harcama_donemi = ?");
    $siraStmt->execute([$kategori_tipi, $kategori, $harcama_donemi]);
    $siraResult = $siraStmt->fetch(PDO::FETCH_ASSOC);
    $sira = ($siraResult['max_sira'] ?? 0) + 1;

    // Veritabanına ekle
    $stmt = $db->getPdo()->prepare("
        INSERT INTO harcama_kalemleri (kategori, kategori_tipi, harcama_donemi, tur, sira, urun, tutar, link, aciklama, durum, created_at, updated_at)
        VALUES (?, ?, ?, 'Alınacaklar', ?, ?, ?, ?, ?, ?, NOW(), NOW())
    ");

    $stmt->execute([
        $kategori,
        $kategori_tipi,
        $harcama_donemi,
        $sira,
        $urun,
        $tutar,
        $link,
        $aciklama,
        $durum
    ]);

    $response['success'] = true;
    $response['message'] = 'Kayıt başarıyla eklendi';

} catch (Exception $e) {
    $response['message'] = 'Hata: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);

// Debug için log
error_log('Add expense response: ' . json_encode($response));
?>
