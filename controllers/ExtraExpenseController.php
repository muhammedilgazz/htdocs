<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class ExtraExpenseController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getExtraExpenses();

        require_once 'C:/xampp/htdocs/views/extra_expenses/index.php';
    }
}