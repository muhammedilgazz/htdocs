<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/BankAccount.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $bank_account_model = new BankAccount();
    $id = (int)$_POST['id'];

    if ($bank_account_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Banka hesabı başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Banka hesabı silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}