<?php
require_once ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/config/config.php';

use App\Models\ExecutionDebt;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && validate_csrf_token($_POST['csrf_token'])) {
    $execution_debt_model = new ExecutionDebt();
    $id = (int)$_POST['id'];

    $debt = $execution_debt_model->getById($id);

    if ($debt) {
        json_response(['success' => true, 'data' => $debt]);
    } else {
        json_response(['success' => false, 'message' => 'İcra borcu bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
