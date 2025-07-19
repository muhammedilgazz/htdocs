<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Todo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $todo_model = new Todo();
    
    $data = [
        'task' => sanitize_input($_POST['task']),
        'status' => sanitize_input($_POST['status']) ?? 'Beklemede',
        'due_date' => sanitize_input($_POST['due_date']) ?? null
    ];

    if ($todo_model->add($data)) {
        json_response(['success' => true, 'message' => 'To-Do başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'To-Do eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}