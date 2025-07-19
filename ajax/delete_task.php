<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Task.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $task_model = new Task();
    $id = (int)$_POST['id'];

    if ($task_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Görev başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Görev silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
