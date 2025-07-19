<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Wishlist.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $wishlist_model = new Wishlist();
    $id = (int)$_POST['id'];

    if ($wishlist_model->delete($id)) {
        json_response(['success' => true, 'message' => 'İstek listesi öğesi başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'İstek listesi öğesi silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
