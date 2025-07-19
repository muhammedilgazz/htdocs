<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/SgkDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $sgk_debt_model = new SgkDebt();
    $id = (int)$_POST['id'];

    if ($sgk_debt_model->delete($id)) {
        json_response(['success' => true, 'message' => 'SGK borcu başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'SGK borcu silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
