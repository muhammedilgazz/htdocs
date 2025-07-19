<?php
require_once ROOT_PATH . '/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $month = sanitize_input($_POST['month'] ?? '');
    
    if (empty($month)) {
        json_response(['success' => false, 'message' => 'Ay seçimi gerekli'], 400);
    }
    
    // Ay formatını kontrol et (YYYY-MM formatında olmalı)
    if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
        json_response(['success' => false, 'message' => 'Geçersiz ay formatı. YYYY-MM formatında olmalı.'], 400);
    }
    
    // Session'a ay bilgisini kaydet
    $_SESSION['selected_month'] = $month;
    
    json_response([
        'success' => true, 
        'message' => 'Ay başarıyla güncellendi',
        'month' => $month
    ]);
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
