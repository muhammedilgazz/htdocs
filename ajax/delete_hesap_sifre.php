<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/AccountCredential.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $account_credential_model = new AccountCredential();
    $id = (int)$_POST['id'];

    if ($account_credential_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Hesap bilgisi başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Hesap bilgisi silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}