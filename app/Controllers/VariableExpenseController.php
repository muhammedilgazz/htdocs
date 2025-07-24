<?php

namespace App\Controllers;

use App\Services\ExpenseService;

class VariableExpenseController {
    private $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index() {
        $rows = $this->expenseService->getAllExpensesByType('degisken_gider');

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/variable_expenses/index.php';
    }
}
