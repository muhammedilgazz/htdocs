<?php
require_once __DIR__ . '/../classes/Todo.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $todo_model = new Todo();

    $task = $data['task'] ?? '';
    $status = $data['status'] ?? 'Beklemede';
    $due_date = $data['due_date'] ?? null;

    if (empty($task)) {
        json_response(['success' => false, 'message' => 'Görev alanı zorunludur.'], 400);
    }

    $result = $todo_model->add([
        'task' => $task,
        'status' => $status,
        'due_date' => $due_date
    ]);

    if ($result) {
        json_response(['success' => true, 'message' => 'To-Do başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'To-Do eklenirken hata oluştu'], 500);
    }
});
