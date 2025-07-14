<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class SgkController {
    public function index() {
        $expense_model = new Expense();
        $selected_month = $_SESSION['selected_month'] ?? '07.25';
        $rows = $expense_model->getSgkExpenses($selected_month);

        require_once 'C:/xampp/htdocs/views/sgk/index.php';
    }
}