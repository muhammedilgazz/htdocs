<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/DreamGoal.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $dream_goal_model = new DreamGoal();
    
    $data = [
        'goal_name' => sanitize_input($_POST['goal_name']),
        'target_amount' => (float)$_POST['target_amount'] ?? 0,
        'product_link' => sanitize_input($_POST['product_link']) ?? null,
        'priority' => (int)$_POST['priority'] ?? null,
        'progress' => (int)$_POST['progress'] ?? 0
    ];

    if ($dream_goal_model->add($data)) {
        json_response(['success' => true, 'message' => 'Hayal/Hedef başarıyla eklendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Hayal/Hedef eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}