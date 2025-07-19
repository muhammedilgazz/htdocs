<?php

namespace App\Controllers;

class SettingsController {
    public function index() {
        require_once ROOT_PATH . '/views/settings/index.php';
    }
}