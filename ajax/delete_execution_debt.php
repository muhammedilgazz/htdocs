<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/ExecutionDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $execution_debt_model = new ExecutionDebt();
    $id = (int)$_POST['id'];

    if ($execution_debt_model->delete($id)) {
        json_response(['success' => true, 'message' => 'İcra borcu başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'İcra borcu silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
