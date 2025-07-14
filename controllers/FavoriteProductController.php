<?php

require_once 'C:/xampp/htdocs/models/Wishlist.php';

class FavoriteProductController {
    public function index() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getFavoriteProducts();

        require_once 'C:/xampp/htdocs/views/favorite_products/index.php';
    }
}