<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Expense.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $expense_model = new Expense();
    $id = (int)$_POST['id'];

    $expense = $expense_model->getById($id);

    if ($expense) {
        json_response(['success' => true, 'data' => $expense]);
    } else {
        json_response(['success' => false, 'message' => 'Gider bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}