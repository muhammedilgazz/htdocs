<?php

require_once 'C:/xampp/htdocs/models/Expense.php';

class ExecutionController {
    public function index() {
        $expense_model = new Expense();
        $selected_month = $_SESSION['selected_month'] ?? '07.25';
        $rows = $expense_model->getExecutionExpenses($selected_month);

        require_once 'C:/xampp/htdocs/views/executions/index.php';
    }
}