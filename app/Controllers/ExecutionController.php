<?php

namespace App\Controllers;

use App\Models\ExecutionDebt;

class ExecutionController {
    public function index() {
        $execution_debt_model = new ExecutionDebt();
        $rows = $execution_debt_model->getAll();
        
        $summary = [
            'total_amount' => $execution_debt_model->getTotalCurrentDebtAmount(),
            'total_files' => $execution_debt_model->getTotalExecutionFilesCount(),
            'this_month' => $execution_debt_model->getThisMonthTotalPlannedPayment(),
            'total_paid' => $execution_debt_model->getTotalPaidAmount()
        ];

        $total_debt = array_sum(array_column($rows, 'current_debt')); // Bu hala kullanılıyorsa kalsın

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/executions/index.php';
    }
}
