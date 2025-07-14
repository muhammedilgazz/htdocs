<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class XtremeAiController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getXtremeAiExpenses();

        require_once 'C:/xampp/htdocs/views/xtreme_ai/index.php';
    }
}