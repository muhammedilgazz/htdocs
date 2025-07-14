<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class VariableExpenseController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getVariableExpenses();

        require_once 'C:/xampp/htdocs/views/variable_expenses/index.php';
    }
}