<?php

namespace App\Controllers;

use App\Models\Wishlist;

class NeedController {
    public function index() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getNeeds();

        require_once 'C:/xampp/htdocs/views/needs/index.php';
    }
}