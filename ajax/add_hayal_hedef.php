<?php
require_once __DIR__ . '/../classes/DreamGoal.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $dream_goal_model = new DreamGoal();

    $goal_name = $data['goal_name'] ?? '';
    $description = $data['description'] ?? '';
    $target_amount = filter_var($data['target_amount'] ?? '', FILTER_VALIDATE_FLOAT);
    $target_date = $data['target_date'] ?? null;

    if (empty($goal_name) || $target_amount <= 0) {
        json_response(['success' => false, 'message' => 'Başlık ve hedef tutar zorunludur.'], 400);
    }

    $result = $dream_goal_model->add([
        'goal_name' => $goal_name,
        'description' => $description,
        'target_amount' => $target_amount,
        'target_date' => $target_date
    ]);

    if ($result) {
        json_response(['success' => true, 'message' => 'Hayal/Hedef başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'Hayal/Hedef eklenirken hata oluştu'], 500);
    }
});
