<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Models\SgkDebt;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $sgk_debt_model = new SgkDebt();
    $id = (int)$_POST['id'];

    $debt = $sgk_debt_model->getById($id);

    if ($debt) {
        json_response(['success' => true, 'data' => $debt]);
    } else {
        json_response(['success' => false, 'message' => 'SGK borcu bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
