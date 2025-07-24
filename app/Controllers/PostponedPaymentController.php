<?php

namespace App\Controllers;

use App\Services\ExpenseService;

class PostponedPaymentController {
    private $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index() {
        $rows = $this->expenseService->getAllExpensesByType('ertelenmis');

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/postponed_payments/index.php';
    }
}
