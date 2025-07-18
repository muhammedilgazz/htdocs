<?php

namespace App\Controllers;

use App\Models\SgkDebt;

class SgkController {
    public function index() {
        $sgk_debt_model = new SgkDebt();
        $rows = $sgk_debt_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/sgk/index.php';
    }
}
