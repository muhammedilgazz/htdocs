<?php

namespace App\Controllers;

use App\Models\Wishlist;

class FavoriteProductController {
    public function index() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getFavorites();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/favorite_products/index.php';
    }
}