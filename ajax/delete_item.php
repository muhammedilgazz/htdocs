<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $db = Database::getInstance();

    $id = (int)$_POST['id'] ?? null;
    $table = sanitize_input($_POST['table']) ?? null;

    if (!$id || !$table) {
        json_response(['success' => false, 'message' => 'ID ve tablo adı gerekli.'], 400);
    }

    // Güvenli tablo adları (whitelist)
    $allowed_tables = [
        'expenses',
        'wishlist_items',
        'bank_accounts',
        'tax_debts',
        'sgk_debts',
        'execution_debts',
        'personal_debts',
        'account_credentials',
        'notes',
        'todos'
    ];

    if (!in_array($table, $allowed_tables)) {
        json_response(['success' => false, 'message' => 'Geçersiz tablo adı.'], 400);
    }

    try {
        $sql = "DELETE FROM $table WHERE id = ?";
        $stmt = $db->getConnection()->prepare($sql);
        $result = $stmt->execute([$id]);
        
        if ($result && $stmt->rowCount() > 0) {
            json_response(['success' => true, 'message' => 'Kayıt başarıyla silindi.']);
        } else {
            json_response(['success' => false, 'message' => 'Kayıt bulunamadı veya silinemedi.'], 404);
        }
    } catch (Exception $e) {
        error_log("Delete item error: " . $e->getMessage());
        json_response(['success' => false, 'message' => 'Veritabanı hatası: ' . $e->getMessage()], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}