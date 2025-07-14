<?php

require_once 'C:/xampp/htdocs/models/Wishlist.php';
require_once 'C:/xampp/htdocs/models/UIHelper.php';
require_once 'C:/xampp/htdocs/config/config.php';

class AcquiredProductController {
    public function index() {
        $wishlist_model = new Wishlist();
        $rows = $wishlist_model->getAll();
        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/acquired_products/index.php';
    }
}