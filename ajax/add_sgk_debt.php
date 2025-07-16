<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/SgkDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $sgk_debt_model = new SgkDebt();
    
    $data = [
        'owner' => sanitize_input($_POST['owner']),
        'period' => sanitize_input($_POST['period']) ?? null,
        'principal' => (float)$_POST['principal'] ?? 0,
        'interest' => (float)$_POST['interest'] ?? 0,
        'total' => (float)$_POST['total'] ?? 0,
        'payment_due' => sanitize_input($_POST['payment_due']) ?? null,
        'planned_payment' => (float)$_POST['planned_payment'] ?? 0,
        'paid' => (float)$_POST['paid'] ?? 0,
        'remaining' => (float)$_POST['remaining'] ?? 0,
        'this_month_payment' => (float)$_POST['this_month_payment'] ?? 0
    ];

    if ($sgk_debt_model->add($data)) {
        json_response(['success' => true, 'message' => 'SGK borcu başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'SGK borcu eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
