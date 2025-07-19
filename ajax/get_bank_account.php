<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/BankAccount.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $bank_account_model = new BankAccount();
    $id = (int)$_POST['id'];

    $account = $bank_account_model->getById($id);

    if ($account) {
        json_response(['success' => true, 'data' => $account]);
    } else {
        json_response(['success' => false, 'message' => 'Banka hesabı bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
