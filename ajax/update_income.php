<?php
require_once '../config/config.php';
require_once '../app/Models/Database.php';
require_once '../app/Models/Income.php';

header('Content-Type: application/json');

// CSRF kontrolü
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== generate_csrf_token()) {
    json_response(['success' => false, 'message' => 'CSRF token geçersiz.']);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'message' => 'Geçersiz istek metodu.']);
}

// Gerekli alanları kontrol et
$required_fields = ['id', 'title', 'currency', 'amount', 'period', 'receive_date', 'is_debt'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || (empty($_POST[$field]) && $_POST[$field] !== '0')) { // '0' değerini boş kabul etmemek için
        json_response(['success' => false, 'message' => "Lütfen tüm gerekli alanları doldurun. Eksik: $field"]);
    }
}

// ID'nin sayısal bir değer olduğunu ve boş olmadığını doğrula
if (!isset($_POST['id']) || !is_numeric($_POST['id']) || $_POST['id'] <= 0) {
    json_response(['success' => false, 'message' => 'Geçersiz gelir ID\'si.']);
}

try {
    $incomeModel = new App\Models\Income();
    $userId = $_SESSION['user_id'] ?? 1;
    
    $data = [
        'title' => trim($_POST['title']),
        'currency' => $_POST['currency'],
        'amount' => (float)$_POST['amount'],
        'period' => sanitize_input($_POST['period']),
        'receive_date' => sanitize_input($_POST['receive_date']),
        'is_debt' => sanitize_input($_POST['is_debt']) === 'yes' ? 1 : 0, // 'yes' veya 'no' stringini 1 veya 0'a çevir
        'description' => sanitize_input($_POST['description'] ?? ''),
        'status' => 'active'
    ];
    
    // Validasyon
    if ($data['amount'] <= 0) {
        json_response(['success' => false, 'message' => 'Tutar 0\'dan büyük olmalıdır.']);
    }
    
    if (!in_array($data['currency'], ['TRY', 'USD', 'EUR', 'GBP'])) {
        json_response(['success' => false, 'message' => 'Geçersiz para birimi.']);
    }
    
    if (!in_array($data['period'], ['daily', 'weekly', 'monthly', 'yearly', 'one_time'])) {
        json_response(['success' => false, 'message' => 'Geçersiz periyot.']);
    }
    
    if (!in_array($data['is_debt'], [0, 1])) { // is_debt'i 0 veya 1 olarak kontrol et
        json_response(['success' => false, 'message' => 'Geçersiz borç durumu.']);
    }
    
    $result = $incomeModel->updateIncome($_POST['id'], $userId, $data);
    
    if ($result) {
        json_response(['success' => true, 'message' => 'Gelir başarıyla güncellendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Gelir güncellenirken bir hata oluştu.']);
    }
    
} catch (Exception $e) {
    error_log("Update income error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
    json_response(['success' => false, 'message' => 'Gelir güncellenirken bir hata oluştu. Lütfen logları kontrol edin.']);
}