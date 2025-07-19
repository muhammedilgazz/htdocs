<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/AccountCredential.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $account_credential_model = new AccountCredential();
    $id = (int)$_POST['id'];

    $credential = $account_credential_model->getById($id);

    if ($credential) {
        json_response(['success' => true, 'data' => $credential]);
    } else {
        json_response(['success' => false, 'message' => 'Hesap bilgisi bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
