<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/TaxDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $tax_debt_model = new TaxDebt();
    $id = (int)$_POST['id'];

    if ($tax_debt_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Vergi borcu başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Vergi borcu silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
