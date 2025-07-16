<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Wishlist.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $wishlist_model = new Wishlist();
    $id = (int)$_POST['id'];

    $item = $wishlist_model->getById($id);

    if ($item) {
        json_response(['success' => true, 'data' => $item]);
    } else {
        json_response(['success' => false, 'message' => 'İstek listesi öğesi bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
