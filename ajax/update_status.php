<?php
require_once __DIR__ . '/../classes/Expense.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $expense = new Expense();

    $id = filter_var($data['id'] ?? '', FILTER_VALIDATE_INT);
    $status = $data['status'] ?? '';
    
    if (!$id || !$status) {
        json_response(['success' => false, 'message' => 'Geçersiz parametreler'], 400);
    }
    
    $result = $expense->updateStatus($id, $status);
    
    if ($result) {
        json_response(['success' => true, 'message' => 'Durum güncellendi']);
    } else {
        json_response(['success' => false, 'message' => 'Güncelleme başarısız'], 500);
    }
});
