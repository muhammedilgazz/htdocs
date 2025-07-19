<?php

namespace App\Controllers;

use App\Models\Expense;

class VariableExpenseController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getAll('degisken_gider');

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/variable_expenses/index.php';
    }
}
