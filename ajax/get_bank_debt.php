<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/BankDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $bank_debt_model = new BankDebt();
    $id = (int)$_POST['id'];

    $debt = $bank_debt_model->getById($id);

    if ($debt) {
        json_response(['success' => true, 'data' => $debt]);
    } else {
        json_response(['success' => false, 'message' => 'Banka borcu bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
