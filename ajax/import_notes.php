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
    if (!isset($_POST['notes_text']) || empty($_POST['notes_text'])) {
        throw new Exception('Not metni boş olamaz');
    }

    $notes_text = trim($_POST['notes_text']);
    $notes_category = trim($_POST['notes_category'] ?? 'Genel');
    $lines = explode("\n", $notes_text);
    $imported_count = 0;
    $errors = [];

    foreach ($lines as $line_number => $line) {
        $line = trim($line);
        if (empty($line)) continue;

        // Not içeriğini temizle
        $note_content = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
        
        if (strlen($note_content) < 3) {
            $errors[] = "Satır " . ($line_number + 1) . ": Not çok kısa";
            continue;
        }

        // Veritabanına ekle
        $stmt = $db->getPdo()->prepare("
            INSERT INTO notlar 
            (kategori, icerik, onem_derecesi, durum, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $notes_category,
            $note_content,
            'Orta', // Varsayılan önem derecesi
            'Aktif'
        ]);

        $imported_count++;
    }

    if ($imported_count > 0) {
        $response['success'] = true;
        $response['message'] = $imported_count . ' not başarıyla içe aktarıldı';
        $response['imported_count'] = $imported_count;
        
        if (!empty($errors)) {
            $response['message'] .= '. ' . count($errors) . ' satırda hata oluştu';
            $response['errors'] = $errors;
        }
    } else {
        $response['message'] = 'Hiçbir not içe aktarılamadı';
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