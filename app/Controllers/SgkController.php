<?php

namespace App\Controllers;

use App\Models\SgkDebt;

class SgkController {
    private $sgkDebtModel;

    public function __construct(SgkDebt $sgkDebtModel)
    {
        $this->sgkDebtModel = $sgkDebtModel;
    }

    public function index() {
        $rows = $this->sgkDebtModel->getAll();

        $summary = [
            'personal' => $this->sgkDebtModel->getSgkDebtAmountByOwner('Şahsi'),
            'timdesigners' => $this->sgkDebtModel->getSgkDebtAmountByOwner('Timdesigners'),
            'rentakar' => $this->sgkDebtModel->getSgkDebtAmountByOwner('RentAkar'),
            'total' => $this->sgkDebtModel->getTotalSgkDebtAmount()
        ];

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/sgk/index.php';
    }
}
