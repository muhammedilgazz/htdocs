<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/PersonalDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $personal_debt_model = new PersonalDebt();
    
    $id = (int)$_POST['id'];
    $data = [
        'to_whom' => sanitize_input($_POST['to_whom']),
        'amount' => (float)$_POST['amount'] ?? 0,
        'due_date' => sanitize_input($_POST['due_date']) ?? null,
        'paid' => (float)$_POST['paid'] ?? 0,
        'remaining' => (float)$_POST['remaining'] ?? 0,
        'planned_payment_date' => sanitize_input($_POST['planned_payment_date']) ?? null
    ];

    if ($personal_debt_model->update($id, $data)) {
        json_response(['success' => true, 'message' => 'Şahıs borcu başarıyla güncellendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Şahıs borcu güncellenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
