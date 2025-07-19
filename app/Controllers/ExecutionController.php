<?php

namespace App\Controllers;

use App\Models\ExecutionDebt;

class ExecutionController {
    public function index() {
        $execution_debt_model = new ExecutionDebt();
        $rows = $execution_debt_model->getAll();

        $total_debt = array_sum(array_column($rows, 'current_debt'));

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/executions/index.php';
    }
}
