<?php
require_once '../config/config.php';
require_once '../app/Models/Database.php';
require_once '../app/Models/Income.php';

header('Content-Type: application/json');

// CSRF kontrolü
if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== generate_csrf_token()) {
    json_response(['success' => false, 'message' => 'CSRF token geçersiz.']);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    json_response(['success' => false, 'message' => 'Geçersiz gelir ID.']);
}

try {
    $incomeModel = new App\Models\Income();
    $userId = $_SESSION['user_id'] ?? 1;
    $income = $incomeModel->getIncomeById($_GET['id'], $userId);
    
    if (!$income) {
        json_response(['success' => false, 'message' => 'Gelir bulunamadı.']);
    }
    
    json_response(['success' => true, 'data' => $income]);
    
} catch (Exception $e) {
    error_log("Get income error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
    json_response(['success' => false, 'message' => 'Gelir bilgileri alınırken hata oluştu. Lütfen logları kontrol edin.']);
}