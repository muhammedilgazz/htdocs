<?php
require_once __DIR__ . '/../classes/Payment.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $payment = new Payment();
    
    // Form verilerini al ve temizle
    $person_name = $data['person_name'] ?? '';
    $iban = $data['iban'] ?? '';
    $amount = floatval($data['amount'] ?? 0);
    $status = $data['status'] ?? 'Beklemede';

    // Validasyon
    if (empty($person_name) || $amount <= 0) {
        json_response(['success' => false, 'message' => 'Lütfen tüm gerekli alanları doldurun'], 400);
    }
    
    // IBAN formatı kontrolü (opsiyonel)
    if (!empty($iban) && !preg_match('/^TR\d{2}\s?\d{4}\s?\d{4}\s?\d{4}\s?\d{4}\s?\d{2}$/', str_replace(' ', '', $iban))) {
        json_response(['success' => false, 'message' => 'Geçersiz IBAN formatı'], 400);
    }
    
    $result = $payment->add([
        'person_name' => $person_name,
        'iban' => $iban,
        'amount' => $amount,
        'status' => $status
    ]);
    
    if ($result) {
        // Güvenlik logu
        log_security_event('payment_added', [
            'person_name' => $person_name,
            'amount' => $amount,
            'status' => $status,
            'user_id' => $_SESSION['user_id'] ?? 'unknown'
        ]);
        
        json_response(['success' => true, 'message' => 'Ödeme başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'Veritabanı hatası'], 500);
    }
