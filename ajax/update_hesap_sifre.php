<?php
require_once __DIR__ . '/../classes/Account.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $account = new Account();

    $id = intval($data['id'] ?? 0);
    $platform = $data['platform'] ?? '';
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';
    $login_link = $data['login_link'] ?? '';
    $account_type = $data['account_type'] ?? '';

    if ($id <= 0) {
        json_response(['success' => false, 'message' => 'Geçersiz hesap ID'], 400);
    }

    if (empty($platform) || empty($username) || empty($password) || empty($account_type)) {
        json_response(['success' => false, 'message' => 'Platform, kullanıcı adı, şifre ve hesap türü zorunludur.'], 400);
    }

    // Hesabın var olup olmadığını kontrol et
    $existing_account = $account->getById($id);
    
    if (!$existing_account) {
        json_response(['success' => false, 'message' => 'Hesap bulunamadı'], 404);
    }

    $result = $account->update($id, [
        'platform' => $platform,
        'username' => $username,
        'password' => $password,
        'login_link' => $login_link,
        'account_type' => $account_type
    ]);
    
    if ($result) {
        json_response([
            'success' => true, 
            'message' => 'Hesap başarıyla güncellendi'
        ]);
    } else {
        json_response(['success' => false, 'message' => 'Hesap güncellenirken hata oluştu'], 500);
    }
});
