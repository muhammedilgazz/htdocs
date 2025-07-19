<?php

namespace App\Controllers;

use App\Models\Giderler;

class GiderlerController {
    public function index() {
        $giderler_model = new Giderler();
        $filter_type = sanitize_input($_GET['filter'] ?? 'month');
        $rows = $giderler_model->getConsolidatedMonthlyExpenses($filter_type);

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/giderler/index.php';
    }
}
