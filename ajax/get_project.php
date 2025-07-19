<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Project.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $project_model = new Project();
    $id = (int)$_POST['id'];

    $project = $project_model->getById($id);

    if ($project) {
        json_response(['success' => true, 'data' => $project]);
    } else {
        json_response(['success' => false, 'message' => 'Proje bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
