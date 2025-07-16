<?php

namespace App\Controllers;

use App\Models\Expense;

class PostponedPaymentController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getAll('ertelenmis');

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/postponed_payments/index.php';
    }
}
