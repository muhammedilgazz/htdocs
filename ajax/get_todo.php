<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Todo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $todo_model = new Todo();
    $id = (int)$_POST['id'];

    $todo = $todo_model->getById($id);

    if ($todo) {
        json_response(['success' => true, 'data' => $todo]);
    } else {
        json_response(['success' => false, 'message' => 'To-Do bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
