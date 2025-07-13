<?php
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $month = $data['month'] ?? '';
    
    if (empty($month)) {
        json_response(['success' => false, 'message' => 'Ay seçimi gerekli'], 400);
    }
    
    // Ay formatını kontrol et (MM.YY formatında olmalı)
    if (!preg_match('/^\d{2}\.\d{2}$/', $month)) {
        json_response(['success' => false, 'message' => 'Geçersiz ay formatı'], 400);
    }
    
    // Session'a ay bilgisini kaydet
    $_SESSION['selected_month'] = $month;
    
    // Ay adını belirle
    $month_names = [
        '07.25' => 'Temmuz 2025',
        '08.25' => 'Ağustos 2025',
        '09.25' => 'Eylül 2025'
    ];
    
    $month_name = $month_names[$month] ?? 'Bilinmeyen Ay';
    
    json_response([
        'success' => true, 
        'message' => 'Ay güncellendi',
        'month' => $month,
        'month_name' => $month_name
    ]);
});