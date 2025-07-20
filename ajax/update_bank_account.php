<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/app/Models/BankAccount.php';

use App\Models\BankAccount;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $bank_account_model = new BankAccount();
    
    $id = (int)$_POST['id'];
    $data = [
        'account_holder' => sanitize_input($_POST['account_holder']),
        'iban_number' => sanitize_input($_POST['iban_number']) ?? null,
        'easy_address' => sanitize_input($_POST['easy_address']) ?? null,
        'bank_name' => sanitize_input($_POST['bank_name']),
        'bank_logo' => sanitize_input($_POST['bank_logo']) ?? null,
        'description' => sanitize_input($_POST['description']) ?? null,
        'account_type' => sanitize_input($_POST['account_type'])
    ];

    if ($bank_account_model->update($id, $data)) {
        json_response(['success' => true, 'message' => 'Banka hesabı başarıyla güncellendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Banka hesabı güncellenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
