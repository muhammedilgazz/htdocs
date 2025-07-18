<?php

namespace App\Controllers;

use App\Models\ExecutionDebt;

class ExecutionController {
    public function index() {
        $execution_debt_model = new ExecutionDebt();
        $rows = $execution_debt_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/executions/index.php';
    }
}
