<?php

namespace App\Controllers;

use App\Services\ExpenseService;

class ExtraExpenseController {
    private $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index() {
        $rows = $this->expenseService->getAllExpensesByType('ani_ekstra');

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/extra_expenses/index.php';
    }
}
