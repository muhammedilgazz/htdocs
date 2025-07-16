<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Task.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $task_model = new Task();
    $id = (int)$_POST['id'];

    $task = $task_model->getById($id);

    if ($task) {
        json_response(['success' => true, 'data' => $task]);
    } else {
        json_response(['success' => false, 'message' => 'Görev bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
