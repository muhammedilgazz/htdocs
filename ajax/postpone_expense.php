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
$id = $_POST['id'] ?? null;
$postpone_months = $_POST['postpone_months'] ?? null;

if (!$id || !$postpone_months) {
    echo json_encode(['success' => false, 'message' => 'ID ve erteleme süresi gerekli']);
    exit;
}

try {
    // Mevcut harcama bilgilerini al
    $stmt = $db->getPdo()->prepare("SELECT * FROM harcama_kalemleri WHERE id = ?");
    $stmt->execute([$id]);
    $expense = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$expense) {
        echo json_encode(['success' => false, 'message' => 'Harcama bulunamadı']);
        exit;
    }
    
    // Erteleme tarihini hesapla
    $current_date = new DateTime();
    $postpone_date = new DateTime();
    
    switch ($postpone_months) {
        case '1':
            $postpone_date->add(new DateInterval('P1M'));
            $new_period = $postpone_date->format('m.y');
            break;
        case '3':
            $postpone_date->add(new DateInterval('P3M'));
            $new_period = $postpone_date->format('m.y');
            break;
        case '6':
            $postpone_date->add(new DateInterval('P6M'));
            $new_period = $postpone_date->format('m.y');
            break;
        case '12':
            $postpone_date->add(new DateInterval('P12M'));
            $new_period = $postpone_date->format('m.y');
            break;
        case 'later':
            $postpone_date = new DateTime('2028-01-01');
            $new_period = '01.28';
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Geçersiz erteleme süresi']);
            exit;
    }
    
    // Harcamayı güncelle
    $updateSql = "UPDATE harcama_kalemleri SET 
                   erteleme_tarihi = ?, 
                   harcama_donemi = ?,
                   durum = 'Ertelendi'
                   WHERE id = ?";
    
    $updateStmt = $db->getPdo()->prepare($updateSql);
    $result = $updateStmt->execute([
        $postpone_date->format('Y-m-d'),
        $new_period,
        $id
    ]);
    
    if ($result) {
        $period_text = '';
        switch ($postpone_months) {
            case '1': $period_text = '1 ay'; break;
            case '3': $period_text = '3 ay'; break;
            case '6': $period_text = '6 ay'; break;
            case '12': $period_text = '1 yıl'; break;
            case 'later': $period_text = 'daha sonra'; break;
        }
        
        // Debug bilgisi
        error_log("Postpone success - ID: $id, New Date: " . $postpone_date->format('Y-m-d') . ", New Period: $new_period");
        
        echo json_encode([
            'success' => true, 
            'message' => "Harcama $period_text ertelendi (Yeni dönem: $new_period)",
            'new_date' => $postpone_date->format('d.m.Y'),
            'new_period' => $new_period
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erteleme işlemi başarısız']);
    }
    
} catch (Exception $e) {
    error_log("Postpone expense error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası: ' . $e->getMessage()]);
}
?> 