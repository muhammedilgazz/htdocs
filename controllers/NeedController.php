<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class NeedController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getNeeds();

        require_once 'C:/xampp/htdocs/views/needs/index.php';
    }
}