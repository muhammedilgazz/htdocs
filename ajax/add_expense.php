<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Expense.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $expense_model = new Expense();
    
    $data = [
        'description' => sanitize_input($_POST['description']),
        'amount' => (float)$_POST['amount'],
        'category_type' => sanitize_input($_POST['category_type']),
        'date' => sanitize_input($_POST['date'])
    ];

    if ($expense_model->add($data)) {
        json_response(['success' => true, 'message' => 'Gider başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Gider eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}