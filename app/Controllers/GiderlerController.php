<?php

namespace App\Controllers;

use App\Models\Giderler;

class GiderlerController {
    private $giderlerModel;

    public function __construct(Giderler $giderlerModel)
    {
        $this->giderlerModel = $giderlerModel;
    }

    public function index() {
        $filter_type = sanitize_input($_GET['filter'] ?? 'month');
        $rows = $this->giderlerModel->getConsolidatedMonthlyExpenses($filter_type);

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/giderler/index.php';
    }
}
