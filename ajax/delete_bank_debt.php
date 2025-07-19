<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/BankDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $bank_debt_model = new BankDebt();
    $id = (int)$_POST['id'];

    if ($bank_debt_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Banka borcu başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Banka borcu silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
