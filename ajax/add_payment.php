<?php
require_once __DIR__ . '/../classes/Payment.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $payment = new Payment();
    
    // Form verilerini al ve temizle
    $kisi_adi = $data['kisi_adi'] ?? '';
    $iban = $data['iban'] ?? '';
    $tutar = floatval($data['tutar'] ?? 0);
    $durum = $data['durum'] ?? 'Beklemede';

    // Validasyon
    if (empty($kisi_adi) || $tutar <= 0) {
        json_response(['success' => false, 'message' => 'Lütfen tüm gerekli alanları doldurun'], 400);
    }
    
    // IBAN formatı kontrolü (opsiyonel)
    if (!empty($iban) && !preg_match('/^TR\d{2}\s?\d{4}\s?\d{4}\s?\d{4}\s?\d{4}\s?\d{2}$/', str_replace(' ', '', $iban))) {
        json_response(['success' => false, 'message' => 'Geçersiz IBAN formatı'], 400);
    }
    
    // Durum kontrolü
    $allowed_statuses = ['Beklemede', 'Planlandı', 'Ödendi', 'Gecikmiş'];
    if (!in_array($durum, $allowed_statuses)) {
        $durum = 'Beklemede';
    }
    
    $result = $payment->add([
        'kisi_adi' => $kisi_adi,
        'iban' => $iban,
        'tutar' => $tutar,
        'durum' => $durum
    ]);
    
    if ($result) {
        // Güvenlik logu
        log_security_event('payment_added', [
            'kisi_adi' => $kisi_adi,
            'tutar' => $tutar,
            'durum' => $durum,
            'user_id' => $_SESSION['user_id'] ?? 'unknown'
        ]);
        
        json_response(['success' => true, 'message' => 'Ödeme başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'Veritabanı hatası'], 500);
    }
});
