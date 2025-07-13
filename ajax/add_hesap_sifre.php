<?php
require_once __DIR__ . '/../classes/Account.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $account = new Account();

    $platform = $data['platform'] ?? '';
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';
    $login_link = $data['login_link'] ?? '';
    $account_type = $data['account_type'] ?? '';

    if (empty($platform) || empty($username) || empty($password) || empty($account_type)) {
        json_response(['success' => false, 'message' => 'Platform, kullanıcı adı, şifre ve hesap türü zorunludur.'], 400);
    }

    $result = $account->add([
        'platform' => $platform,
        'username' => $username,
        'password' => $password,
        'login_link' => $login_link,
        'account_type' => $account_type
    ]);
    
    if ($result) {
        json_response([
            'success' => true, 
            'message' => 'Hesap başarıyla eklendi',
            'id' => $account->lastInsertId()
        ]);
    } else {
        json_response(['success' => false, 'message' => 'Hesap eklenirken hata oluştu'], 500);
    }
});
