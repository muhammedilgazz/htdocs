<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/DreamGoal.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $dream_goal_model = new DreamGoal();
    $id = (int)$_POST['id'];

    $goal = $dream_goal_model->getById($id);

    if ($goal) {
        json_response(['success' => true, 'data' => $goal]);
    } else {
        json_response(['success' => false, 'message' => 'Hayal/Hedef bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
