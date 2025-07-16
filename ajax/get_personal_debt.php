<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/PersonalDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $personal_debt_model = new PersonalDebt();
    $id = (int)$_POST['id'];

    $debt = $personal_debt_model->getById($id);

    if ($debt) {
        json_response(['success' => true, 'data' => $debt]);
    } else {
        json_response(['success' => false, 'message' => 'Şahıs borcu bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
