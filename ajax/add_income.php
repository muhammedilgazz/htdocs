<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Models\Income;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $incomeModel = new Income();
    
    $userId = $_SESSION['user_id'] ?? 1; // Geçici olarak 1 kullanıyoruz
    
    $data = [
        'user_id' => $userId,
        'title' => sanitize_input($_POST['title']),
        'currency' => sanitize_input($_POST['currency']),
        'amount' => (float)$_POST['amount'],
        'period' => sanitize_input($_POST['period']),
        'receive_date' => sanitize_input($_POST['receive_date']),
        'is_debt' => isset($_POST['is_debt']) ? (int)sanitize_input($_POST['is_debt']) : 0, // Varsayılan olarak 0 (hayır)
        'description' => sanitize_input($_POST['description'] ?? ''),
        'status' => 'active'
    ];

    $result = $incomeModel->createIncome($data);

    if ($result) {
        json_response(['success' => true, 'message' => 'Gelir başarıyla eklendi.', 'income_id' => $result]);
    } else {
        json_response(['success' => false, 'message' => 'Gelir eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
