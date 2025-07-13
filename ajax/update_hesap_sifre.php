<?php
require_once __DIR__ . '/../classes/Account.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $account = new Account();

    $id = intval($data['id'] ?? 0);
    $platform = $data['platform'] ?? '';
    $kullanici_adi = $data['kullanici_adi'] ?? '';
    $sifre = $data['sifre'] ?? '';
    $giris_linki = $data['giris_linki'] ?? '';
    $hesap_turu = $data['hesap_turu'] ?? '';

    if ($id <= 0) {
        json_response(['success' => false, 'message' => 'Geçersiz hesap ID'], 400);
    }

    if (empty($platform) || empty($kullanici_adi) || empty($sifre) || empty($hesap_turu)) {
        json_response(['success' => false, 'message' => 'Platform, kullanıcı adı, şifre ve hesap türü zorunludur.'], 400);
    }

    $valid_hesap_turleri = [
        'İnternet Bankacılığı', 'Mail', 'Sosyal Medya', 'Bahis Sitesi',
        'E-ticaret', 'Eğitim', 'İş', 'Diğer'
    ];

    if (!in_array($hesap_turu, $valid_hesap_turleri)) {
        json_response(['success' => false, 'message' => 'Geçersiz hesap türü.'], 400);
    }

    // Hesabın var olup olmadığını kontrol et
    $existing_account = $account->getById($id);
    
    if (!$existing_account) {
        json_response(['success' => false, 'message' => 'Hesap bulunamadı'], 404);
    }

    $result = $account->update($id, [
        'platform' => $platform,
        'kullanici_adi' => $kullanici_adi,
        'sifre' => $sifre,
        'giris_linki' => $giris_linki,
        'hesap_turu' => $hesap_turu
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
