<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class DebtPaymentController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getDebtPayments();

        require_once 'C:/xampp/htdocs/views/debt_payments/index.php';
    }
}