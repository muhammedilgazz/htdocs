<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class PostponedPaymentController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getPostponedPayments();

        require_once 'C:/xampp/htdocs/views/postponed_payments/index.php';
    }
}