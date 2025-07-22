<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Models\Income;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $incomeModel = new Income();
    
    $userId = $_SESSION['user_id'] ?? 1; // Geçici olarak 1 kullanıyoruz
    $incomeId = (int)$_POST['id'];

    $result = $incomeModel->deleteIncome($incomeId, $userId);

    if ($result) {
        json_response(['success' => true, 'message' => 'Gelir başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Gelir silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
} 