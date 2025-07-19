<?php

namespace App\Controllers;

use App\Models\Expense;

class FixedExpenseController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getAll('sabit_gider');

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/fixed_expenses/index.php';
    }
}
