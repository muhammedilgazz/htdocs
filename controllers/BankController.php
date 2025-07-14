<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class BankController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getBankExpenses();

        require_once 'C:/xampp/htdocs/views/bank/index.php';
    }
}