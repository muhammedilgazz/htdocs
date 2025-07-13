<?php
require_once __DIR__ . '/../classes/Income.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $income_model = new Income();

    $source = $data['source'] ?? '';
    $amount = filter_var($data['amount'] ?? '', FILTER_VALIDATE_FLOAT);
    $date = $data['date'] ?? date('Y-m-d');
    $description = $data['description'] ?? '';

    if (empty($source) || $amount <= 0) {
        json_response(['success' => false, 'message' => 'Kaynak ve tutar zorunludur.'], 400);
    }

    $result = $income_model->add([
        'source' => $source,
        'amount' => $amount,
        'date' => $date,
        'description' => $description
    ]);

    if ($result) {
        json_response(['success' => true, 'message' => 'Gelir başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'Gelir eklenirken hata oluştu'], 500);
    }
});
