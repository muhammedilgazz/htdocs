<?php

namespace App\Controllers;

class AffiliateController {
    public function index() {
        $csrf_token = generate_csrf_token();
        $user_id = $_SESSION['user_id'] ?? 'user123'; // Placeholder if not set

        require_once ROOT_PATH . '/views/affiliates/index.php';
    }
}
