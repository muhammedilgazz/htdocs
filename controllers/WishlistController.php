<?php

require_once 'C:/xampp/htdocs/models/Wishlist.php';

class WishlistController {
    public function index() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getAll();

        require_once 'C:/xampp/htdocs/views/wishlist/index.php';
    }
}
