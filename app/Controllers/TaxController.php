<?php

namespace App\Controllers;

use App\Models\TaxDebt;

class TaxController {
    private $taxDebtModel;

    public function __construct(TaxDebt $taxDebtModel)
    {
        $this->taxDebtModel = $taxDebtModel;
    }

    public function index() {
        $rows = $this->taxDebtModel->getAll();
        
        $summary = [
            'personal' => $this->taxDebtModel->getTaxDebtAmountByOwner('Şahsi'),
            'timdesigners' => $this->taxDebtModel->getTaxDebtAmountByOwner('Timdesigners'),
            'rentakar' => $this->taxDebtModel->getTaxDebtAmountByOwner('RentAkar'),
            'total' => $this->taxDebtModel->getTotalTaxDebtAmount()
        ];

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/tax/index.php';
    }
}