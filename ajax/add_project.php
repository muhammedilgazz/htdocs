<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Project.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $project_model = new Project();
    
    $data = [
        'description' => sanitize_input($_POST['description']),
        'amount' => (float)$_POST['amount'] ?? 0,
        'date' => sanitize_input($_POST['date']) ?? date('Y-m-d')
    ];

    if ($project_model->add($data)) {
        json_response(['success' => true, 'message' => 'Proje başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Proje eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
