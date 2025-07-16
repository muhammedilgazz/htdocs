<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/DreamGoal.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $dream_goal_model = new DreamGoal();
    $id = (int)$_POST['id'];

    if ($dream_goal_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Hayal/Hedef başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Hayal/Hedef silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
