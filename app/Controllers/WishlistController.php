<?php

namespace App\Controllers;

use App\Models\Wishlist;

class WishlistController {
    public function index() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/wishlist/index.php';
    }
}
