<?php

namespace App\Controllers;

use App\Models\BankDebt;

class BankController {
    private $bankDebtModel;

    public function __construct(BankDebt $bankDebtModel)
    {
        $this->bankDebtModel = $bankDebtModel;
    }

    public function index() {
        $rows = $this->bankDebtModel->getAll();

        $summary = [
            'personal' => $this->bankDebtModel->getBankDebtAmountByOwner('Şahsi'),
            'timdesigners' => $this->bankDebtModel->getBankDebtAmountByOwner('Timdesigners'),
            'rentakar' => $this->bankDebtModel->getBankDebtAmountByOwner('RentAkar'),
            'total' => $this->bankDebtModel->getTotalBankDebtAmount()
        ];

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/bank/index.php';
    }
}
