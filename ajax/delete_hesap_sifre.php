<?php
require_once __DIR__ . '/../classes/Account.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $account = new Account();
    
    $id = intval($data['id'] ?? 0);
    
    if ($id <= 0) {
        json_response(['success' => false, 'message' => 'Geçersiz hesap ID'], 400);
    }
    
    // Hesabın var olup olmadığını kontrol et
    $existing_account = $account->getById($id);
    
    if (!$existing_account) {
        json_response(['success' => false, 'message' => 'Hesap bulunamadı'], 404);
    }
    
    $result = $account->delete($id);
    
    if ($result) {
        json_response([
            'success' => true, 
            'message' => 'Hesap başarıyla silindi'
        ]);
    } else {
        json_response(['success' => false, 'message' => 'Hesap silinirken hata oluştu'], 500);
    }
});
