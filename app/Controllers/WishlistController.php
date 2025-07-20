<?php

namespace App\Controllers;

use App\Models\Wishlist;

class WishlistController {
    public function index() {
        // Redirect to a default wishlist type, e.g., 'all'
        header('Location: /wishlist-all.php');
        exit();
    }

    public function ihtiyac() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getByType('ihtiyac');
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/ihtiyac.php';
    }

    public function hayal() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getByType('hayal');
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/hayal.php';
    }

    public function favori() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getByType('favori');
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/favori.php';
    }

    public function istek() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getByType('istek');
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/istek.php';
    }

    public function all() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getAll();
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/all.php';
    }
}
