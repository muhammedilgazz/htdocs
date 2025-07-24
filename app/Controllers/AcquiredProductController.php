<?php

namespace App\Controllers;

use App\Models\Wishlist;
use App\Models\UIHelper;

class AcquiredProductController {
    private $wishlistModel;

    public function __construct(Wishlist $wishlistModel)
    {
        $this->wishlistModel = $wishlistModel;
    }

    public function index() {
        $rows = $this->wishlistModel->getAll('alinacak'); // Assuming 'alinacak' is the type for acquired products
        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/acquired_products/index.php';
    }
}
