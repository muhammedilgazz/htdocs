<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/BankDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $bank_debt_model = new BankDebt();
    
    $data = [
        'bank_name' => sanitize_input($_POST['bank_name']),
        'loan_type' => sanitize_input($_POST['loan_type']) ?? null,
        'principal' => (float)$_POST['principal'] ?? 0,
        'total' => (float)$_POST['total'] ?? 0,
        'is_legal_process' => isset($_POST['is_legal_process']) ? 1 : 0,
        'asset_company' => sanitize_input($_POST['asset_company']) ?? null,
        'is_installment' => isset($_POST['is_installment']) ? 1 : 0,
        'planned_payment_date' => sanitize_input($_POST['planned_payment_date']) ?? null
    ];

    if ($bank_debt_model->add($data)) {
        json_response(['success' => true, 'message' => 'Banka borcu başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Banka borcu eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
