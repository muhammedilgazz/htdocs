<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/PersonalDebt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $personal_debt_model = new PersonalDebt();
    $id = (int)$_POST['id'];

    if ($personal_debt_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Şahıs borcu başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Şahıs borcu silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
