<?php

namespace App\Controllers;

class NotificationController {
    public function index() {
        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/notifications/index.php';
    }
}
