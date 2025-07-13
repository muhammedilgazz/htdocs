<?php
require_once __DIR__ . '/../classes/Iban.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $iban_model = new Iban();

    $bank_name = $data['bank_name'] ?? '';
    $iban = $data['iban'] ?? '';
    $account_holder_name = $data['account_holder_name'] ?? '';
    $easy_address = $data['easy_address'] ?? '';
    $description = $data['description'] ?? '';

    if (empty($bank_name) || empty($iban) || empty($account_holder_name)) {
        json_response(['success' => false, 'message' => 'Banka adı, IBAN numarası ve hesap sahibi zorunludur.'], 400);
    }

    // IBAN formatı kontrolü (basit)
    if (!preg_match('/^TR\d{2}\s?(\d{4}\s?){4}(\d{2})$/', str_replace(' ', '', $iban))) {
        json_response(['success' => false, 'message' => 'Geçersiz IBAN formatı.'], 400);
    }

    $result = $iban_model->add([
        'bank_name' => $bank_name,
        'iban' => $iban,
        'account_holder_name' => $account_holder_name,
        'easy_address' => $easy_address,
        'description' => $description
    ]);

    if ($result) {
        json_response(['success' => true, 'message' => 'IBAN başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'IBAN eklenirken hata oluştu'], 500);
    }
});