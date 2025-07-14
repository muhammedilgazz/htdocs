<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class TaxController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getTaxExpenses();

        require_once 'C:/xampp/htdocs/views/tax/index.php';
    }
}