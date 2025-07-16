<?php
require_once __DIR__ . '/../models/Account.php';
require_once __DIR__ . '/../models/AjaxHelper.php';

handle_get_request(function($data) {
    $account = new Account();
    
    $id = intval($data['id'] ?? 0);
    
    if ($id <= 0) {
        json_response(['success' => false, 'message' => 'Geçersiz hesap ID'], 400);
    }
    
    $account_data = $account->getById($id);
    
    if (!$account_data) {
        json_response(['success' => false, 'message' => 'Hesap bulunamadı'], 404);
    }
    
    json_response([
        'success' => true,
        'data' => $account_data
    ]);
});
