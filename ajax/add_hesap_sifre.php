<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/AccountCredential.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $account_credential_model = new AccountCredential();
    
    $data = [
        'platform_name' => sanitize_input($_POST['platform_name']),
        'username' => sanitize_input($_POST['username']),
        'password_hash' => password_hash(sanitize_input($_POST['password_hash']), PASSWORD_DEFAULT),
        'login_url' => sanitize_input($_POST['login_url']) ?? null,
        'account_type_id' => (int)$_POST['account_type_id']
    ];

    if ($account_credential_model->add($data)) {
        json_response(['success' => true, 'message' => 'Hesap bilgisi başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Hesap bilgisi eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}