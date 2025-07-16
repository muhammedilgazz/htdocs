<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/TaxDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $tax_debt_model = new TaxDebt();
    
    $id = (int)$_POST['id'];
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

    if ($tax_debt_model->update($id, $data)) {
        json_response(['success' => true, 'message' => 'Vergi borcu başarıyla güncellendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Vergi borcu güncellenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
