<?php
require_once '../bootstrap.php';

use App\Models\Wishlist;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
