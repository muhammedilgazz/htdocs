<?php

namespace App\Controllers;

use App\Models\Wishlist;
use App\Models\UIHelper;

class AcquiredProductController {
    public function index() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getAll('alinacak'); // Assuming 'alinacak' is the type for acquired products
        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/acquired_products/index.php';
    }
}
