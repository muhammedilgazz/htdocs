<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Todo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $todo_model = new Todo();
    $id = (int)$_POST['id'];

    if ($todo_model->delete($id)) {
        json_response(['success' => true, 'message' => 'To-Do başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'To-Do silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
