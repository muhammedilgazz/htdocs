<?php

namespace App\Controllers;

use App\Models\PersonalDebt;

class IndividualDebtController {
    private $personalDebtModel;

    public function __construct(PersonalDebt $personalDebtModel)
    {
        $this->personalDebtModel = $personalDebtModel;
    }

    public function index() {
        $rows = $this->personalDebtModel->getAll();

        $summary = [
            'personal' => $this->personalDebtModel->getPersonalDebtAmountByOwner('Şahsi'),
            'timdesigners' => $this->personalDebtModel->getPersonalDebtAmountByOwner('Timdesigners'),
            'rentakar' => $this->personalDebtModel->getPersonalDebtAmountByOwner('RentAkar'),
            'total' => $this->personalDebtModel->getTotalPersonalDebtAmount()
        ];

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/individual_debts/index.php';
    }
}
