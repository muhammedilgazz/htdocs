<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Task.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $task_model = new Task();
    
    $data = [
        'description' => sanitize_input($_POST['description']),
        'amount' => (float)$_POST['amount'] ?? 0,
        'date' => sanitize_input($_POST['date']) ?? date('Y-m-d')
    ];

    if ($task_model->add($data)) {
        json_response(['success' => true, 'message' => 'Görev başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Görev eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
