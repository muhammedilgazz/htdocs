<?php
require_once __DIR__ . '/../classes/DreamGoal.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $dream_goal_model = new DreamGoal();

    $baslik = $data['baslik'] ?? '';
    $aciklama = $data['aciklama'] ?? '';
    $hedef_tutar = filter_var($data['hedef_tutar'] ?? '', FILTER_VALIDATE_FLOAT);
    $mevcut_tutar = filter_var($data['mevcut_tutar'] ?? 0, FILTER_VALIDATE_FLOAT);
    $durum = $data['durum'] ?? 'Beklemede';
    $hedef_tarih = $data['hedef_tarih'] ?? null;

    if (empty($baslik) || $hedef_tutar <= 0) {
        json_response(['success' => false, 'message' => 'Başlık ve hedef tutar zorunludur.'], 400);
    }

    $result = $dream_goal_model->add([
        'baslik' => $baslik,
        'aciklama' => $aciklama,
        'hedef_tutar' => $hedef_tutar,
        'mevcut_tutar' => $mevcut_tutar,
        'durum' => $durum,
        'hedef_tarih' => $hedef_tarih
    ]);

    if ($result) {
        json_response(['success' => true, 'message' => 'Hayal/Hedef başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'Hayal/Hedef eklenirken hata oluştu'], 500);
    }
});
