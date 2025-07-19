<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/ExecutionDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $execution_debt_model = new ExecutionDebt();
    
    $data = [
        'owner' => sanitize_input($_POST['owner']),
        'creditor' => sanitize_input($_POST['creditor']) ?? null,
        'execution_office' => sanitize_input($_POST['execution_office']) ?? null,
        'start_date' => sanitize_input($_POST['start_date']) ?? null,
        'current_debt' => (float)$_POST['current_debt'] ?? 0,
        'principal_debt' => (float)$_POST['principal_debt'] ?? 0,
        'contact_info' => sanitize_input($_POST['contact_info']) ?? null,
        'status' => sanitize_input($_POST['status']) ?? null,
        'planned_payment' => (float)$_POST['planned_payment'] ?? 0,
        'this_month_payment' => (float)$_POST['this_month_payment'] ?? 0
    ];

    if ($execution_debt_model->add($data)) {
        json_response(['success' => true, 'message' => 'İcra borcu başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'İcra borcu eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
