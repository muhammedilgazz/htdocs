<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class FixedExpenseController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getFixedExpenses();

        require_once 'C:/xampp/htdocs/views/fixed_expenses/index.php';
    }
}