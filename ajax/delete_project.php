<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Project.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $project_model = new Project();
    $id = (int)$_POST['id'];

    if ($project_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Proje başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Proje silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
