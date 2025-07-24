<?php

namespace App\Controllers;

use App\Models\ExecutionDebt;

class ExecutionController {
    private $executionDebtModel;

    public function __construct(ExecutionDebt $executionDebtModel)
    {
        $this->executionDebtModel = $executionDebtModel;
    }

    public function index() {
        $rows = $this->executionDebtModel->getAll();
        
        $summary = [
            'total_amount' => $this->executionDebtModel->getTotalCurrentDebtAmount(),
            'total_files' => $this->executionDebtModel->getTotalExecutionFilesCount(),
            'this_month' => $this->executionDebtModel->getThisMonthTotalPlannedPayment(),
            'total_paid' => $this->executionDebtModel->getTotalPaidAmount()
        ];

        $total_debt = array_sum(array_column($rows, 'current_debt')); // Bu hala kullanılıyorsa kalsın

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/executions/index.php';
    }
}
