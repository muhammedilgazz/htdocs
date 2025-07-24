<?php

namespace App\Controllers;

use App\Models\Wishlist;

class NeedController {
    private $wishlistModel;

    public function __construct(Wishlist $wishlistModel)
    {
        $this->wishlistModel = $wishlistModel;
    }

    public function index() {
        $rows = $this->wishlistModel->getNeeds();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/needs/index.php';
    }
}