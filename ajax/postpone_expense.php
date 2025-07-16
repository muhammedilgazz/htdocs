<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Expense.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $expense_model = new Expense();
    
    $id = (int)$_POST['id'];
    $months = $_POST['months'];

    if ($expense_model->postpone($id, $months)) {
        json_response(['success' => true, 'message' => 'Gider başarıyla ertelendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Gider ertelenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}