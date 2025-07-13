<?php
require_once __DIR__ . '/../classes/Iban.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $iban_model = new Iban();

    $banka_adi = $data['banka_adi'] ?? '';
    $iban = $data['iban'] ?? '';
    $hesap_sahibi = $data['hesap_sahibi'] ?? '';
    $aciklama = $data['aciklama'] ?? '';
    $hesap_turu = $data['hesap_turu'] ?? 'diger';

    if (empty($banka_adi) || empty($iban) || empty($hesap_sahibi)) {
        json_response(['success' => false, 'message' => 'Banka adı, IBAN numarası ve hesap sahibi zorunludur.'], 400);
    }

    // IBAN formatı kontrolü (basit)
    if (!preg_match('/^TR\d{2}\s?(\d{4}\s?){4}(\d{2})$/', str_replace(' ', '', $iban))) {
        json_response(['success' => false, 'message' => 'Geçersiz IBAN formatı.'], 400);
    }

    $result = $iban_model->add([
        'banka_adi' => $banka_adi,
        'iban' => $iban,
        'hesap_sahibi' => $hesap_sahibi,
        'aciklama' => $aciklama,
        'hesap_turu' => $hesap_turu
    ]);

    if ($result) {
        json_response(['success' => true, 'message' => 'IBAN başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'IBAN eklenirken hata oluştu'], 500);
    }
});