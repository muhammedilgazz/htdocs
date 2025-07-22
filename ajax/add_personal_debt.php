<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/PersonalDebt.php';

// Debugging: Log all POST data received
error_log("add_personal_debt.php received POST data: " . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $personal_debt_model = new PersonalDebt();
    
    $data = [
        'to_whom' => sanitize_input($_POST['to_whom']),
        'amount' => (float)$_POST['amount'] ?? 0,
        'due_date' => sanitize_input($_POST['due_date']) ?? null,
        'paid' => (float)$_POST['paid'] ?? 0,
        'remaining' => (float)$_POST['remaining']) ?? 0,
        'planned_payment_date' => sanitize_input($_POST['planned_payment_date']) ?? null
    ];

    // Debugging: Log data before adding to model
    error_log("add_personal_debt.php data to add: " . print_r($data, true));

    if ($personal_debt_model->add($data)) {
        // Debugging: Log success
        error_log("add_personal_debt.php: Personal debt added successfully.");
        json_response(['success' => true, 'message' => 'Şahıs borcu başarıyla eklendi.']);
    } else {
        // Debugging: Log failure
        error_log("add_personal_debt.php: Failed to add personal debt.");
        json_response(['success' => false, 'message' => 'Şahıs borcu eklenirken bir hata oluştu.'], 500);
    }
} else {
    // Debugging: Log invalid request
    error_log("add_personal_debt.php: Invalid request or CSRF token mismatch.");
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
